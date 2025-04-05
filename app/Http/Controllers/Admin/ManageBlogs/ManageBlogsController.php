<?php
namespace App\Http\Controllers\Admin\ManageBlogs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class ManageBlogsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.manageblogs.manageblogs');
    }
    
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_blog')
                ->select('blogid', 'title', 'status', 'image', 'content', 'created_date', 'show_comment')
                ->where('bit_Deleted_Flag', 0);
    
            // Global search correction
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('content', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return !empty($row->image) ? '<a href="' . asset('storage/blog_images/' . $row->image) . '" target="_blank">
                        <img src="' . asset('storage/blog_images/' . $row->image) . '" class="img-fluid rounded border" width="150">
                    </a>' : '';
                })
                ->editColumn('content', function ($row) {
                    $text = strip_tags($row->content); // Remove HTML tags
                    $words = explode(' ', $text); // Convert to array of words
                    if (count($words) > 20) {
                        return implode(' ', array_slice($words, 0, 20)) . '...'; // Limit to 20 words
                    }
                    return $text;
                })
                ->editColumn('created_date', function ($row) {
                    return date('jS M Y', strtotime($row->created_date));
                })
                ->editColumn('show_comment', function ($row) {
                    return $row->show_comment ? 'YES' : 'NO';
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.manageblogs.activemanageblogs', ['id' => $row->blogid]);
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
                        <a href="' . route('admin.manageblogs.editmanageblogs', $row->blogid) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // Define module ID required for delete access (adjust if needed)
                    $requiredModuleId = 14;
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.manageblogs.deletemanageblogs', $row->blogid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this footer?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $deleteButton;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
    }

    public function addmanageblogs(Request $request){
        if($request->isMethod('post')){
            // Start validation
            $validator = Validator::make($request->all(), [
                'title'                 => 'required|string|max:255|unique:tbl_blog,title',
                'blog_url'              => 'required|string|max:255',
                'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1140,height=350',
                'alttag_image'          => 'required|string|max:60|unique:tbl_blog,alttag_image',
                'content'               => 'required|string'
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $duplicateCount = DB::table('tbl_blog')->Where('blog_url', $request->input('blog_url'))->where('bit_Deleted_Flag', 0)->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this blog, URL must be unique.']);
                }
                DB::beginTransaction();
                // Handle Image Upload
                $featured_imageName = null;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $featured_imageName = Str::slug($request->input('alttag_image')) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('blog_images', $featured_imageName, 'public');
                }

                 // Prepare data
                 $data = [
                    'title'                         => $request->input('title'),
                    'blog_url'                      => $request->input('blog_url'),
                    'image'                         => $featured_imageName,
                    'content'                       => $request->input('content'),
                    'alttag_image'                  => Str::slug($request->input('alttag_image')),
                    'show_comment'                  => $request->input('show_comment'),
                    'show_in_home'                  => $request->input('show_in_home'),
                    'blog_meta_title'               => $request->input('blog_meta_title'),
                    'blog_meta_keywords'            => $request->input('blog_meta_keywords'),
                    'blog_meta_description'         => $request->input('blog_meta_description'),
                    'status'                        => 1,
                    'created_by'                    => session('user')->adminid ?? 0,
                    'created_date'                  => now(),
                    'updated_by'                    => session('user')->adminid ?? 0,
                    'updated_date'                  => now()
                ];

                $inserted = DB::table('tbl_blog')->insert($data);

                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Blog added successfully.');
                }else{
                    throw new \Exception('Blog could not be added.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            return view('admin.manageblogs.addblogs');
        }
    }

    public function editmanageblogs(Request $request, $id){
        $BlogData = DB::table('tbl_blog')->where('blogid', $id)->first();
        if (!$BlogData) {
            return redirect()->back()->with('error', 'Blog not found.');
        }
        if($request->isMethod('post')){
            // Start validation
            $validator = Validator::make($request->all(), [
                'title'                 => ['required','string','max:255',Rule::unique('tbl_blog', 'title')->ignore($id, 'blogid')],
                'blog_url'              => 'required|string|max:255',
                'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1140,height=350',
                'alttag_image'          => "required|string|max:255|unique:tbl_blog,alttag_image,$id,blogid",
                'content'               => 'required|string'
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $duplicateCount = DB::table('tbl_blog')->Where('blog_url', $request->input('blog_url'))->where('blogid','!=', $id)->where('bit_Deleted_Flag', 0)->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this blog, URL must be unique.']);
                }
                DB::beginTransaction();
                
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $featured_imageName = Str::slug($request->input('alttag_image')) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('blog_images', $featured_imageName, 'public');
                } else {
                    $featured_imageName = $BlogData->image;
                }

                 // Prepare data
                 $data = [
                    'title'                         => $request->input('title'),
                    'blog_url'                      => $request->input('blog_url'),
                    'image'                         => $featured_imageName,
                    'content'                       => $request->input('content'),
                    'alttag_image'                  => Str::slug($request->input('alttag_image')),
                    'show_comment'                  => $request->input('show_comment'),
                    'show_in_home'                  => $request->input('show_in_home'),
                    'blog_meta_title'               => $request->input('blog_meta_title'),
                    'blog_meta_keywords'            => $request->input('blog_meta_keywords'),
                    'blog_meta_description'         => $request->input('blog_meta_description'),
                    'updated_by'                    => session('user')->adminid ?? 0,
                    'updated_date'                  => now()
                ];

                $inserted = DB::table('tbl_blog')->where('blogid', $id)->update($data);

                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Blog updated successfully.');
                }else{
                    throw new \Exception('Blog could not be updated.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            return view('admin.manageblogs.addblogs', ['BlogData' => $BlogData]);
        }
    }

    public function activemanageblogs(Request $request,$id){
        // Retrieve Blog type by ID
        $data = DB::table('tbl_blog')->select('status')->where('blogid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Blog not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_blog')->where('blogid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Blog inactivated successfully!');
            }else{
                DB::table('tbl_blog')->where('blogid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Blog Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Blog: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Blog.']);
        }
    }

    public function deletemanageblogs(Request $request, $id){
        // Retrieve Blog by ID
        $data = DB::table('tbl_blog')->where('blogid', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Blog not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_blog')->where('blogid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Blog deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Blog: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Blog.']);
        }
    }
    
}