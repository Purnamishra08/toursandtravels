<?php
namespace App\Http\Controllers\Admin\ManageMenus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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
                    return '
                        <a href="' . route('admin.categorytags.editcategorytags', $row->tagid) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <form action="' . route('admin.categorytags.deletecategorytags', $row->tagid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this category tag?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>';
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
                'tag_name' => 'required|string|max:255',
                'tag_url' => 'required|max:255',
                'menuid' => 'required',
                'catId' => 'required',
                'menutag_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image validation
                'menutagthumb_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image validation
                'alttag_banner' => 'nullable|string|max:60',
                'alttag_thumb' => 'nullable|string|max:60',
                'show_on_home' => 'nullable|boolean',
                'show_on_footer' => 'nullable|boolean',
                'about_tag' => 'required|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_keywords' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:255',
            ]);

            // If validation fails, redirect back with errors and old input
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction(); // Start transaction

            try {
                // Prepare data for insertion
                $data = [
                    'tag_name'              => $request->tag_name,
                    'tag_url'               => $request->tag_url,
                    'menuid'                => $request->menuid,
                    'cat_id'                => $request->catId,
                    'alttag_banner'         => $request->alttag_banner ?? '',
                    'alttag_thumb'          => $request->alttag_thumb ?? '',
                    'show_on_home'          => $request->show_on_home ?? 0,
                    'show_on_footer'        => $request->show_on_footer ?? 0,
                    'about_tag'             => $request->about_tag,
                    'meta_title'            => $request->meta_title ?? '',
                    'meta_keywords'         => $request->meta_keywords ?? '',
                    'meta_description'      => $request->meta_description ?? '',
                    'status'                => 1,
                    'created_date'          => now(),
                    'created_by'            => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'updated_date'          => now(),
                    'updated_by'            => isset(session('user')->adminid) ? session('user')->adminid : 0
                ];

                // Handle image file uploads and store only image names in the database
                $bannerImageName = null;
                if ($request->hasFile('menutag_img')) {
                    $file = $request->file('menutag_img');
                    $bannerImageName = time() . '_' . $file->getClientOriginalName(); // Unique Name
                    $file->storeAs('category_tags_images', $bannerImageName, 'public'); // Store in Storage
                    $data['menutag_img'] = $bannerImageName; // Store only the name in DB
                }

                $getawayImageName = null;
                if ($request->hasFile('menutagthumb_img')) {
                    $file = $request->file('menutagthumb_img');
                    $getawayImageName = time() . '_' . $file->getClientOriginalName(); // Unique Name
                    $file->storeAs('category_tags_images', $getawayImageName, 'public'); // Store in Storage
                    $data['menutagthumb_img'] = $getawayImageName; // Store only the name in DB
                }

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
                    'tag_name' => 'required|string|max:255',
                    'tag_url' => 'required|max:255',
                    'menuid' => 'required',
                    'catId' => 'required',
                    'menutag_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image validation
                    'menutagthumb_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image validation
                    'alttag_banner' => 'nullable|string|max:60',
                    'alttag_thumb' => 'nullable|string|max:60',
                    'show_on_home' => 'nullable|boolean',
                    'show_on_footer' => 'nullable|boolean',
                    'about_tag' => 'required|string',
                    'meta_title' => 'nullable|string|max:255',
                    'meta_keywords' => 'nullable|string|max:255',
                    'meta_description' => 'nullable|string|max:255',
                ]);

                // If validation fails, redirect back with errors and old input
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction(); // Start transaction
                try {
                    $data = [
                        'tag_name'              => $request->tag_name,
                        'tag_url'               => $request->tag_url,
                        'menuid'                => $request->menuid,
                        'cat_id'                => $request->catId,
                        'alttag_banner'         => $request->alttag_banner ?? '',
                        'alttag_thumb'          => $request->alttag_thumb ?? '',
                        'show_on_home'          => $request->show_on_home ?? 0,
                        'show_on_footer'        => $request->show_on_footer ?? 0,
                        'about_tag'             => $request->about_tag,
                        'meta_title'            => $request->meta_title ?? '',
                        'meta_keywords'         => $request->meta_keywords ?? '',
                        'meta_description'      => $request->meta_description ?? '',
                        'status'                => 1,
                        'updated_date'          => now(),
                        'updated_by'            => isset(session('user')->adminid) ? session('user')->adminid : 0
                    ];
                
                    // Handle banner image file upload
                    if ($request->hasFile('menutag_img')) {
                        if (!empty($categorytags->menutag_img) && file_exists(public_path('storage/category_tags_images/' . $categorytags->menutag_img))) {
                            unlink(public_path('storage/category_tags_images/' . $categorytags->menutag_img));
                        }
                
                        // Store the new image
                        $file = $request->file('menutag_img');
                        $bannerImageName = time() . '_' . $file->getClientOriginalName(); // Unique Name
                        $file->storeAs('category_tags_images', $bannerImageName, 'public'); // Store in Storage
                        $data['menutag_img'] = $bannerImageName; // Store only the name in DB
                    }
                
                    // Handle getaway image file upload
                    if ($request->hasFile('menutagthumb_img')) {
                        if (!empty($categorytags->menutagthumb_img) && file_exists(public_path('storage/category_tags_images/' . $categorytags->menutagthumb_img))) {
                            unlink(public_path('storage/category_tags_images/' . $categorytags->menutagthumb_img));
                        }
                
                        // Store the new image
                        $file = $request->file('menutagthumb_img');
                        $getawayImageName = time() . '_' . $file->getClientOriginalName(); // Unique Name
                        $file->storeAs('category_tags_images', $getawayImageName, 'public'); // Store in Storage
                        $data['menutagthumb_img'] = $getawayImageName; // Store only the name in DB
                    }
                
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
}