<?php
namespace App\Http\Controllers\Admin\ManageMenus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class CategoryTagsController extends Controller
{
    public function index(Request $request){
        return view('admin.managemenus.categorytags');
    }

    public function getData(Request $request){
        if ($request->ajax()) {
            // Fetch category tags for DataTables
            $query = DB::table('tbl_menutags as a')
                ->select('a.tagid', 'a.cat_id', 'a.menuid', 'm.menu_name', 'c.cat_name', 'a.tag_name', 'a.status', 'a.bit_Deleted_Flag')
                ->leftJoin('tbl_menus as m', 'a.menuid', '=', 'm.menuid')
                ->leftJoin('tbl_menucategories as c', 'a.cat_id', '=', 'c.catid')
                ->where('a.bit_Deleted_Flag', 0)
                ->where('m.bit_Deleted_Flag', 0)
                ->where('c.bit_Deleted_Flag', 0);
    
            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('m.menu_name', 'like', '%' . $search . '%')
                      ->orWhere('c.cat_name', 'like', '%' . $search . '%')
                      ->orWhere('a.tag_name', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('menu_name', function ($row) {
                    return $row->menu_name;
                })
                ->addColumn('cat_name', function ($row) {
                    return $row->cat_name;
                })
                ->addColumn('tag_name', function ($row) {
                    return $row->tag_name;
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.categorytags.activecategorytags', ['id' => $row->tagid]);
                    $confirmMessage = "return confirm('Are you sure you want to change the status?')";
    
                    if ($row->status == 1) {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-success" title="Active. Click to deactivate.">
                                        <span class="label-custom label label-success">Active</span>
                                    </button>
                                </form>';
                    } else {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-dark" title="Inactive. Click to activate.">
                                        <span class="label-custom label label-danger">Inactive</span>
                                    </button>
                                </form>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                
                    // Edit button (always visible)
                    $editButton = '
                        <a href="' . route('admin.categorytags.editcategorytags', $row->tagid) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // Define the module ID required for delete access (adjust as needed)
                    $requiredModuleId = 8; // Change this to the correct module ID for category tags
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.categorytags.deletecategorytags', $row->tagid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this category tag?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $deleteButton;
                })
                ->rawColumns(['status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function getCategoryMenuWise(Request $request){
        $menu_id = $request->input('menu_id');
        if (!$menu_id) {
            return response()->json(['error' => 'Invalid Request'], 400);
        }
    
        $menuWiseCat = DB::table('tbl_menucategories')
                ->where('menuid', $menu_id)
                ->where('bit_Deleted_Flag', 0)
                ->where('status', 1)
                ->get();
    
        if (!count($menuWiseCat) > 0) {
            return response()->json(['error' => 'Categories not found'], 404);
        }else{
            return response()->json(['categories' => $menuWiseCat]);
        }
    }

    public function addcategorytags(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validation using Validator::make
            $validator = Validator::make($request->all(), [
                'tag_name'                  => 'required|string|max:255',
                'tag_url'                   => 'required|max:255',
                'menuid'                    => 'required',
                'catId'                     => 'required',
                'menutag_img'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1920,height=488',
                'menutagthumb_img'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:width=500,height=350',
                'alttag_banner'             => 'required|string|max:60|unique:tbl_menutags,alttag_banner',
                'alttag_thumb'              => 'required|string|max:60|unique:tbl_menutags,alttag_thumb',
                'show_on_home'              => 'nullable|boolean',
                'show_on_footer'            => 'nullable|boolean',
                'about_tag'                 => 'required|string',
                'description_tag'           => 'required|string',
                'meta_title'                => 'nullable|string|max:255',
                'meta_keywords'             => 'nullable|string|max:255',
                'meta_description'          => 'nullable|string|max:255',
            ], [
                'tag_name.required'                 => 'The tag name field is required.',
                'tag_url.required'                  => 'The tag URL field is required.',
                'menuid.required'                   => 'Please select a menu ID.',
                'catId.required'                    => 'Please select a category ID.',
                'menutag_img.image'                 => 'The Banner image must be an image file.',
                'menutag_img.mimes'                 => 'The Banner image must be in JPEG, PNG, JPG, GIF, or SVG format.',
                'menutag_img.max'                   => 'The Banner image size must not exceed 2MB.',
                'menutag_img.dimensions'            => 'The Banner image must be exactly 1920x488 pixels.',
                'menutagthumb_img.image'            => 'The Getaways/Tour image must be an image file.',
                'menutagthumb_img.mimes'            => 'The Getaways/Tour image must be in JPEG, PNG, JPG, GIF, or SVG format.',
                'menutagthumb_img.max'              => 'The Getaways/Tour image size must not exceed 1MB.',
                'menutagthumb_img.dimensions'       => 'The Getaways/Tour image must be exactly 500x350 pixels.',
                'alttag_banner.required'            => 'The banner alt tag is required.',
                'alttag_banner.unique'              => 'This banner alt tag is already in use.',
                'alttag_banner.max'                 => 'The banner alt tag must not exceed 60 characters.',
                'alttag_thumb.required'             => 'The gateway/tours alt tag is required.',
                'alttag_thumb.unique'               => 'This gateway/tours alt tag is already in use.',
                'alttag_thumb.max'                  => 'The gateway/tours alt tag must not exceed 60 characters.',
                'about_tag.required'                => 'The about tag field is required.',
                'description_tag.required'          => 'The description tag field is required.',
                'meta_title.max'                    => 'The meta title must not exceed 255 characters.',
                'meta_keywords.max'                 => 'The meta keywords must not exceed 255 characters.',
                'meta_description.max'              => 'The meta description must not exceed 255 characters.',
            ]);

            // If validation fails, redirect back with errors and old input
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction(); // Start transaction

            try {
                $duplicateCount = DB::table('tbl_menutags')->Where('tag_url', $request->input('tag_url'))->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this category tag, URL must be unique.']);
                }
                // Handle image file uploads and store only image names in the database
                $bannerImageName = null;
                if ($request->hasFile('menutag_img')) {
                    $file = $request->file('menutag_img');
                    $randomNumber = mt_rand(10000, 99999);
                    $bannerImageName = Str::slug($request->input('alttag_banner')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/category_tags_images/BannerImages/' . $bannerImageName), 1920, 488);
                }

                $getawayImageName = null;
                if ($request->hasFile('menutagthumb_img')) {
                    $file = $request->file('menutagthumb_img');
                    $randomNumber = mt_rand(10000, 99999);
                    $getawayImageName = Str::slug($request->input('alttag_thumb')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/category_tags_images/GetawaysImages/' . $getawayImageName), 500, 350);
                }

                // Prepare data for insertion
                $data = [
                    'tag_name'              => $request->tag_name,
                    'tag_url'               => $request->tag_url,
                    'menuid'                => $request->menuid,
                    'cat_id'                => $request->catId,
                    'menutag_img'           => $bannerImageName,
                    'menutagthumb_img'      => $getawayImageName,
                    'alttag_banner'         => Str::slug($request->input('alttag_banner')),
                    'alttag_thumb'          => Str::slug($request->input('alttag_thumb')),
                    'show_on_home'          => $request->show_on_home ?? 0,
                    'show_on_footer'        => $request->show_on_footer ?? 0,
                    'about_tag'             => $request->about_tag,
                    'description_tag'       => $request->description_tag,
                    'meta_title'            => $request->meta_title ?? '',
                    'meta_keywords'         => $request->meta_keywords ?? '',
                    'meta_description'      => $request->meta_description ?? '',
                    'status'                => 1,
                    'created_date'          => now(),
                    'created_by'            => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'updated_date'          => now(),
                    'updated_by'            => isset(session('user')->adminid) ? session('user')->adminid : 0
                ];

                // Insert data into the database table
                DB::table('tbl_menutags')->insert($data);

                // Commit transaction
                DB::commit();
                return redirect()->back()->with('success', 'Category Tag added successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error adding category tag: ' . $e->getMessage());
                return redirect()->back()->with('error', 'There was an error adding the Category Tag.');
            }
        } else {
            // Fetch menus for dropdown if the request is not POST
            $menu = DB::table('tbl_menus')
                    ->select('menuid', 'menu_name')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();

            return view('admin.managemenus.addcategorytags', ['menuTags' => $menu]);
        }
    }

    public function editcategorytags(Request $request,$id){
        $categorytags = DB::table('tbl_menutags')->where('bit_Deleted_Flag', 0)->where('tagid', $id)->first();
        if (!$categorytags) {
            return redirect()->back()->withErrors(['error' => 'Category tag not found!']);
        }else{
            if ($request->isMethod('post')) {
                // Validation using Validator::make
                $validator = Validator::make($request->all(), [
                    'tag_name'              => 'required|string|max:255',
                    'tag_url'               => 'required|max:255',
                    'menuid'                => 'required',
                    'catId'                 => 'required',
                    'menutag_img'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1920,height=488',
                    'menutagthumb_img'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:width=500,height=350',
                    'alttag_banner'         => "required|string|max:60|unique:tbl_menutags,alttag_banner,$id,tagid",
                    'alttag_thumb'          => "required|string|max:60|unique:tbl_menutags,alttag_thumb,$id,tagid",
                    'show_on_home'          => 'nullable|boolean',
                    'show_on_footer'        => 'nullable|boolean',
                    'about_tag'             => 'required|string',
                    'description_tag'       => 'required|string',
                    'meta_title'            => 'nullable|string|max:255',
                    'meta_keywords'         => 'nullable|string|max:255',
                    'meta_description'      => 'nullable|string|max:255',
                ], [
                    'tag_name.required'             => 'The tag name field is required.',
                    'tag_url.required'              => 'The tag URL field is required.',
                    'menuid.required'               => 'Please select a menu ID.',
                    'catId.required'                => 'Please select a category ID.',
                    'menutag_img.image'             => 'The Banner image must be an image file.',
                    'menutag_img.mimes'             => 'The Banner image must be in JPEG, PNG, JPG, GIF, or SVG format.',
                    'menutag_img.max'               => 'The Banner image size must not exceed 2MB.',
                    'menutag_img.dimensions'        => 'The Banner image must be exactly 1920x488 pixels.',
                    'menutagthumb_img.image'        => 'The Getaways/Tour image must be an image file.',
                    'menutagthumb_img.mimes'        => 'The Getaways/Tour image must be in JPEG, PNG, JPG, GIF, or SVG format.',
                    'menutagthumb_img.max'          => 'The Getaways/Tour image size must not exceed 1MB.',
                    'menutagthumb_img.dimensions'   => 'The Getaways/Tour image must be exactly 500x350 pixels.',
                    'alttag_banner.required'        => 'The banner alt tag is required.',
                    'alttag_banner.unique'          => 'This banner alt tag is already in use.',
                    'alttag_banner.max'             => 'The banner alt tag must not exceed 60 characters.',
                    'alttag_thumb.required'         => 'The gateway/tours alt tag is required.',
                    'alttag_thumb.unique'           => 'This gateway/tours alt tag is already in use.',
                    'alttag_thumb.max'              => 'The gateway/tours alt tag must not exceed 60 characters.',
                    'about_tag.required'            => 'The about tag field is required.',
                    'description_tag.required'      => 'The description tag field is required.',
                    'meta_title.max'                => 'The meta title must not exceed 255 characters.',
                    'meta_keywords.max'             => 'The meta keywords must not exceed 255 characters.',
                    'meta_description.max'          => 'The meta description must not exceed 255 characters.',
                ]);

                // If validation fails, redirect back with errors and old input
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction(); // Start transaction
                try {
                    $duplicateCount = DB::table('tbl_menutags')->Where('tag_url', $request->input('tag_url'))->where('tagid','!=', $id)->count();

                    if ($duplicateCount > 0) {
                        return redirect()->back()
                            ->withInput()
                            ->withErrors(['error' => 'You have already added this category tag, URL must be unique.']);
                    }

                    if ($request->hasFile('menutag_img')) {
                        $file = $request->file('menutag_img');
                        $randomNumber = mt_rand(10000, 99999);
                        $bannerImageName = Str::slug($request->input('alttag_banner')) . '-' . $randomNumber . '.webp';
            
                        // Convert and Store as WebP
                        $this->convertToWebp($file, storage_path('app/public/category_tags_images/BannerImages/' . $bannerImageName), 1920, 488);
                    }else{
                        $bannerImageName = $categorytags->menutag_img;
                    }
                    
                    if ($request->hasFile('menutagthumb_img')) {
                        $file = $request->file('menutagthumb_img');
                        $randomNumber = mt_rand(10000, 99999);
                        $getawayImageName = Str::slug($request->input('alttag_thumb')) . '-' . $randomNumber . '.webp';
            
                        // Convert and Store as WebP
                        $this->convertToWebp($file, storage_path('app/public/category_tags_images/GetawaysImages/' . $getawayImageName), 500, 350);
                    }else{
                        $getawayImageName = $categorytags->menutagthumb_img;
                    }

                    $data = [
                        'tag_name'              => $request->tag_name,
                        'tag_url'               => $request->tag_url,
                        'menuid'                => $request->menuid,
                        'cat_id'                => $request->catId,
                        'menutag_img'           => $bannerImageName,
                        'menutagthumb_img'      => $getawayImageName,
                        'alttag_banner'         => Str::slug($request->input('alttag_banner')),
                        'alttag_thumb'          => Str::slug($request->input('alttag_thumb')),
                        'show_on_home'          => $request->show_on_home ?? 0,
                        'show_on_footer'        => $request->show_on_footer ?? 0,
                        'about_tag'             => $request->about_tag,
                        'description_tag'       => $request->description_tag,
                        'meta_title'            => $request->meta_title ?? '',
                        'meta_keywords'         => $request->meta_keywords ?? '',
                        'meta_description'      => $request->meta_description ?? '',
                        'status'                => 1,
                        'updated_date'          => now(),
                        'updated_by'            => isset(session('user')->adminid) ? session('user')->adminid : 0
                    ];
                
                    // Update the data in the database (assuming you're updating an existing record)
                    DB::table('tbl_menutags')
                        ->where('tagid', $categorytags->tagid) // Assuming $categorytags holds the current record being edited
                        ->update($data);
                
                    // Commit transaction
                    DB::commit();
                    return redirect()->back()->with('success', 'Category Tag updated successfully');
                } catch (\Exception $e) {dd($e);
                    DB::rollBack();
                    \Log::error('Error updating category tag: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'There was an error updating the Category Tag.');
                }
                
            } else{
                $menu = DB::table('tbl_menus')
                    ->select('menuid', 'menu_name')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();
                return view('admin.managemenus.addcategorytags', ['menuTags' => $menu, 'Categorytags' => $categorytags]);
            }
        }

    }

    public function deletecategorytags(Request $request,$id){
        // Retrieve category type by ID
        $data = DB::table('tbl_menutags')->where('tagid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Category tag not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_menutags')->where('tagid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Category tag deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Category tag: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Category tag.']);
        }
    }

    public function activecategorytags(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_menutags')->select('status')->where('tagid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Category tag not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_menutags')->where('tagid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Category tag inactivated successfully!');
            }else{
                DB::table('tbl_menutags')->where('tagid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Category tag Activated successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Category tag: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Category tag.']);
        }
    }

    private function convertToWebp($file, $destination, $width, $height)
    {
        $imageType = exif_imagetype($file->getPathname());
        $sourceImage = null;

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($file->getPathname());
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($file->getPathname());
                imagepalettetotruecolor($sourceImage); // Convert PNG to TrueColor
                imagealphablending($sourceImage, true);
                imagesavealpha($sourceImage, true);
                break;
            default:
                throw new \Exception("Unsupported image type.");
        }

        if (!$sourceImage) {
            throw new \Exception("Failed to create image resource.");
        }

        // Resize Image
        $resizedImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $width, $height, imagesx($sourceImage), imagesy($sourceImage));

        // Save as WebP
        imagewebp($resizedImage, $destination, 100); // Quality: 100

        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    }
}