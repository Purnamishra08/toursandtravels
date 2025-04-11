<?php
namespace App\Http\Controllers\Admin\ManageReviews;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.managereviews.managereviews');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            // Fetch reviews for DataTables
            $query = DB::table('tbl_reviews as r')
                ->leftJoin('tbl_menutags as t', DB::raw('FIND_IN_SET(t.tagid, r.tourtagid)'), '>', DB::raw('0'))
                ->select(
                    'r.review_id',
                    'r.tourtagid',
                    'r.reviewer_name',
                    'r.reviewer_loc',
                    'r.no_of_star',
                    'r.feedback_msg',
                    'r.status',
                    'r.updated_date',
                    DB::raw("GROUP_CONCAT(DISTINCT t.tag_name ORDER BY t.tag_name SEPARATOR ', ') AS tag_name")
                )
                ->where('r.bit_Deleted_Flag', 0)
                ->orderBy('r.review_id', 'DESC')
                ->groupBy('r.review_id', 'r.tourtagid', 'r.reviewer_name', 'r.reviewer_loc', 'r.no_of_star', 'r.feedback_msg', 'r.status', 'r.updated_date');

            $reviewer_name      = $request->input('reviewer_name', '');
            $reviewer_loc       = $request->input('reviewer_loc', '');
            $no_of_star         = $request->input('no_of_star', '');
            $status             = $request->input('status', '');

            if (!empty($reviewer_name)) {
                $query->where('r.reviewer_name', 'like', '%' . $reviewer_name . '%');
            }
            if (!empty($reviewer_loc)) {
                $query->where('r.reviewer_loc', $reviewer_loc);
            }
            if (!empty($no_of_star)) {
                $query->where('r.no_of_star', $no_of_star);
            }
            if (!empty($status)) {
                $query->where('r.status', $status);
            }

            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('r.reviewer_name', 'like', '%' . $search . '%')
                    ->orWhere('r.reviewer_loc', 'like', '%' . $search . '%')
                    ->orWhere('r.no_of_star', 'like', '%' . $search . '%')
                    ->orWhere('r.feedback_msg', 'like', '%' . $search . '%')
                    ->orWhere('t.tag_name', 'like', '%' . $search . '%');
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('reviewer_name', function ($row) {
                    return $row->reviewer_name;
                })
                ->addColumn('reviewer_loc', function ($row) {
                    return $row->reviewer_loc;
                })
                ->addColumn('tag_name', function ($row) {
                    return $row->tag_name;
                })
                ->addColumn('no_of_star', function ($row) {
                    return $row->no_of_star;
                })
                ->addColumn('feedback_msg', function ($row) {
                    return $row->feedback_msg;
                })
                ->addColumn('updated_date', function ($row) {
                    return date('jS M Y', strtotime($row->updated_date));
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.managereviews.activereviews', ['id' => $row->review_id]);
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
                    $moduleAccess = session('moduleAccess', []);
                    $user = session('user');
                
                    // Edit button (always visible)
                    $editButton = '
                        <a href="' . route('admin.managereviews.editreviews', $row->review_id) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // View button (always visible)
                    $viewButton = '
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm view" title="View" onclick="loadReviewDetails(' . $row->review_id . ')">
                            <i class="fa fa-eye"></i>
                        </a>';
                
                    // Define the module ID required for delete access (adjust as needed)
                    $requiredModuleId = 13;
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.managereviews.deletereviews', $row->review_id) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this review?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $viewButton . $deleteButton;
                })
                ->rawColumns(['status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function addreviews(Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'reviewer_name'    => 'required|string|max:255',
                'reviewer_loc'     => 'required|string|max:255',
                'no_of_star'       => 'required|numeric',
                'feedback_msg'     => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction
            try {
                $data = [
                    'reviewer_name'          => $request->input('reviewer_name'),
                    'reviewer_loc'           => $request->input('reviewer_loc'),
                    'no_of_star'             => $request->input('no_of_star'),
                    'feedback_msg'           => $request->input('feedback_msg'),
                    'status'                 => 1,
                    'tourtagid' 		     => implode(',', $request->input('getatagid')),
                    'created_by'             => session('user')->adminid ?? 0,
                    'updated_by'             => session('user')->adminid ?? 0,
                    'created_date'           => now(),
                    'updated_date'           => now(),
                ];
                // Insert into database
                $inserted = DB::table('tbl_reviews')->insert($data);
                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Review added successfully.');
                } else {
                    throw new \Exception('Review could not be added.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            return view('admin.managereviews.addmanagereviews', ['tags' => $tags]);
        }
    }

    public function editreviews(Request $request, $id){
        $reviews = DB::table('tbl_reviews')->where('review_id', $id)->first();
        if (!$reviews) {
            return redirect()->back()->with('error', 'Review not found.');
        }
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'reviewer_name'    => 'required|string|max:255',
                'reviewer_loc'     => 'required|string|max:255',
                'no_of_star'       => 'required|numeric',
                'feedback_msg'     => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction
            try {
                $data = [
                    'reviewer_name'          => $request->input('reviewer_name'),
                    'reviewer_loc'           => $request->input('reviewer_loc'),
                    'no_of_star'             => $request->input('no_of_star'),
                    'feedback_msg'           => $request->input('feedback_msg'),
                    'status'                 => 1,
                    'tourtagid' 		     => implode(',', $request->input('getatagid')),
                    'updated_by'             => session('user')->adminid ?? 0,
                    'updated_date'           => now(),
                ];
                // Insert into database
                $updated = DB::table('tbl_reviews')->where('review_id', $id)->update($data);
                if ($updated) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Review updated successfully.');
                } else {
                    throw new \Exception('Review could not be updated.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            return view('admin.managereviews.addmanagereviews', ['tags' => $tags, 'reviews' => $reviews]);
        }
    }

    public function activereviews(Request $request,$id){
        // Retrieve Review type by ID
        $data = DB::table('tbl_reviews')->select('status')->where('review_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Review not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_reviews')->where('review_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Review inactivated successfully!');
            }else{
                DB::table('tbl_reviews')->where('review_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Review Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Review: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Review.']);
        }
    }

    public function deletereviews(Request $request,$id){
        // Retrieve Review by ID
        $data = DB::table('tbl_reviews')->where('review_id', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Review not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_reviews')->where('review_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Review deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Review: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Review.']);
        }
    }

    public function viewPop(Request $request)
    {
        $id = $request->input('reqId');
        if (!$id) {
            return response()->json(['error' => 'Invalid Request'], 400);
        }
    
        $review = DB::table('tbl_reviews')->where('review_id', $id)->first();
    
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }
    
        // Generate only the dynamic content for the modal body
        $html = '
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <strong>Name:</strong> ' . htmlspecialchars($review->reviewer_name) . '
            </div>
            <div class="col-md-6">
                <strong>Location:</strong> ' . htmlspecialchars($review->reviewer_loc) . '
            </div>
            <div class="col-md-6">
                <strong>Feedback:</strong> ' . htmlspecialchars($review->feedback_msg) . '
            </div>
            <div class="col-md-6">
                <strong>Date:</strong> ' . htmlspecialchars(date("jS M Y", strtotime($review->created_date))) . '
            </div>
            <div class="col-md-6">
                <strong>Status:</strong> ' . 
                ($review->status == 1 
                    ? '<span class="badge bg-success text-light">Active</span>' 
                    : '<span class="badge bg-danger text-light">Inactive</span>') . '
            </div>
            <div class="col-md-4">
                <strong>No of Stars:</strong>';

            $stars = '';
            for ($x = 1; $x <= floor($review->no_of_star); $x++) {
                $stars .= '<i class="fa fa-star text-warning"></i> ';
            }

            // Half Star Logic
            if (fmod($review->no_of_star, 1) !== 0.00) {
                $stars .= '<i class="fa fa-star-half-stroke text-warning"></i> ';
                $x++;
            }

            // Remaining Empty Stars
            while ($x <= 5) {
                $stars .= '<i class="fa fa-star text-muted"></i> ';
                $x++;
            }

            $html .= $stars . '<br> (' . htmlspecialchars($review->no_of_star) . ' Star)</div>
                    </div>
                </div>';

    
        return response()->json(['html' => $html]);
    }
}