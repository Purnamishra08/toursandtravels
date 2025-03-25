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

class ManageBlogsCommentsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.manageblogs.manageblogscomments');
    }
    
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_comments as bc')
                ->leftJoin('tbl_blog as b', 'b.blogid', '=', 'bc.blogid')
                ->select('bc.blogid', 'b.title', 'bc.user_name','bc.status', 'bc.email_id', 'bc.comments', 'bc.created_date', 'bc.commentid')
                ->where('bc.bit_Deleted_Flag', 0)
                ->where('b.bit_Deleted_Flag', 0);
    
            // Global search correction
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('b.title', 'like', '%' . $search . '%')
                      ->orWhere('bc.comments', 'like', '%' . $search . '%')
                      ->orWhere('bc.user_name', 'like', '%' . $search . '%')
                      ->orWhere('bc.email_id', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('comments', function ($row) {
                    $text = strip_tags($row->comments); // Remove HTML tags
                    $words = explode(' ', $text); // Convert to array of words
                    if (count($words) > 20) {
                        return implode(' ', array_slice($words, 0, 20)) . '...'; // Limit to 20 words
                    }
                    return $text;
                })
                ->editColumn('created_date', function ($row) {
                    return date('jS M Y', strtotime($row->created_date));
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.manageblogscomments.activemanageblogscomments', ['id' => $row->commentid]);
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
                        <a href="' . route('admin.manageblogscomments.editmanageblogscomments', $row->commentid) . '" class="btn btn-primary btn-sm" title="Edit">
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
                            <form action="' . route('admin.manageblogscomments.deletemanageblogscomments', $row->commentid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this footer?\')">
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

    public function editmanageblogscomments(Request $request, $id){
        $BlogData = DB::table('tbl_comments')->where('commentid', $id)->first();
        if (!$BlogData) {
            return redirect()->back()->with('error', 'Blog comment not found.');
        }
        if($request->isMethod('post')){
            // Start validation
            $validator = Validator::make($request->all(), [
                'comments'              => 'required|string|max:255'
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                DB::beginTransaction();
                 // Prepare data
                 $data = [
                    'comments'                      => $request->input('comments'),
                    'updated_by'                    => session('user')->adminid ?? 0,
                    'updated_date'                  => now()
                ];

                $inserted = DB::table('tbl_comments')->where('commentid', $id)->update($data);

                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Blog comment updated successfully.');
                }else{
                    throw new \Exception('Blog comment could not be updated.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            return view('admin.manageblogs.editblogscomments', ['BlogData' => $BlogData]);
        }
    }

    public function activemanageblogscomments(Request $request,$id){
        // Retrieve Blog comment type by ID
        $data = DB::table('tbl_comments')->select('status')->where('commentid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Blog comment not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_comments')->where('commentid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Blog comment inactivated successfully!');
            }else{
                DB::table('tbl_comments')->where('commentid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Blog comment Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Blog comment: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Blog comment .']);
        }
    }

    public function deletemanageblogscomments(Request $request, $id){
        // Retrieve Blog comment by ID
        $data = DB::table('tbl_comments')->where('commentid', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Blog comment not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_comments')->where('commentid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Blog comment deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Blog comment: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Blog comment.']);
        }
    }
    
}