<?php

namespace App\Http\Controllers\Admin\ManageFollowUpEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;


class EnquiriesEntryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_inquiries as a')
                ->select('a.id', 'a.inquiry_number', 'a.customer_name', 'a.email_address', 'a.phone_number', 'd.admin_name', 'a.created_at', 'c.name', 'a.status')
                ->join('tbl_sources as b', 'a.source_id', '=', 'b.id')
                ->join('tbl_statuses as c', 'a.status_id', '=', 'c.id')
                ->join('tbl_admin as d', 'a.created_by', '=', 'd.adminid')
                ->where('a.bit_Deleted_Flag', 0);

            // Apply filters if present
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('a.created_at', [\Carbon\Carbon::parse($request->from_date)->startOfDay(),\Carbon\Carbon::parse($request->to_date)->endOfDay()]);
            } elseif (!empty($request->from_date)) {
                $query->where('a.created_at', '>=', \Carbon\Carbon::parse($request->from_date)->startOfDay());
            } elseif (!empty($request->to_date)) {
                $query->where('a.created_at', '<=', \Carbon\Carbon::parse($request->to_date)->endOfDay());
            }
            if (!empty($request->customer_name)) {
                $query->where('a.customer_name', 'LIKE', "%{$request->customer_name}%");
            }
            if (!empty($request->enquiry_number)) {
                $query->where('a.inquiry_number', 'LIKE', "%{$request->enquiry_number}%");
            }
            if (!empty($request->email_address)) {
                $query->where('a.email_address', 'LIKE', "%{$request->email_address}%");
            }
            if (!empty($request->phone_number)) {
                $query->where('a.phone_number', 'LIKE', "%{$request->phone_number}%");
            }
            if (!empty($request->status)) {
                $query->where('a.status_id', $request->status);
            }
            if (!empty($request->assign_to)) {
                $query->where('a.assign_to', $request->assign_to);
            }

            // dd($query->toSql());
            return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::parse($row->created_at)->format('jS M Y');
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.manageenquiriesentry.editEnquiriesEntry', ['id' => $row->id]);
                $viewUrl = route('admin.manageenquiriesentry.viewEnquiriesEntry', ['id' => $row->id]);
                $deleteUrl = route('admin.manageenquiriesentry.deleteEnquiriesEntry', ['id' => $row->id]);
                $moduleAccess = session('moduleAccess', []); // Get module access from session
                $user = session('user'); // Get user session
                $requiredModuleId = 20;

                $buttons = '<div class="d-flex gap-1">
                    <button class="btn btn-primary btn-sm view-btn" data-id="'.$row->id.'" title="View">
                        <i class="fa fa-eye"></i>
                    </button>
                    <a href="'.$editUrl.'" class="btn btn-success btn-sm" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>';

                if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                    $buttons .= '
                        <form action="'.$deleteUrl.'" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this enquiry?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>';
                }

                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        $assignData = DB::table('tbl_admin')
            ->select('adminid', 'admin_name')
            ->where('bit_Deleted_Flag', 0)
            ->whereIn('adminid', function ($query) {
                $query->select('adminid')
                    ->from('tbl_admin_modules')
                    ->where('moduleid', 20);
            })
            ->where('status', 1)
            ->orderBy('admin_name', 'asc')
            ->get();

        $statuses = DB::table('tbl_statuses')
            ->select('id', 'name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        return view('admin.managefollowupenquiries.manageEnquiriesEntry', [
            'statuses' => $statuses,
            'assignData' => $assignData
        ]);
    }

    public function addEnquiriesEntry(Request $request)
    {
        // Fetch dropdown data
        $sources = DB::table('tbl_sources')
            ->select('id', 'name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $statuses = DB::table('tbl_statuses')
            ->select('id', 'name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        if ($request->isMethod('post')) {
            // Validate input fields
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'email_address' => 'required|email|max:255',
                'phone_number' => 'required|digits_between:10,15',
                'source_id' => 'required|integer|exists:tbl_sources,id',
                'status_id' => 'required|integer|exists:tbl_statuses,id',
                'trip_name' => 'required|string|max:255',
                'trip_start_date' => 'required|date',
                'follow_up_date' => 'required|date',
                'no_of_travellers' => 'required|integer|min:1',
                'comment' => 'required|string',
            ]);

            try {
                $userid     = isset(session('user')->adminid) ? session('user')->adminid : 0;
                // Insert new hotel
                $enquiryId = DB::table('tbl_inquiries')->insertGetId([
                    'customer_name' => $request->customer_name,
                    'email_address' => $request->email_address,
                    'phone_number' => $request->phone_number,
                    'source_id' => $request->source_id,
                    'status_id' => $request->status_id,
                    'trip_name' => $request->trip_name,
                    'trip_start_date' => $request->trip_start_date ? date('Y-m-d H:i:s', strtotime($request->trip_start_date)) : null,
                    'followup_date' => $request->follow_up_date ? date('Y-m-d H:i:s', strtotime($request->follow_up_date)) : null,
                    'travellers_count' => $request->no_of_travellers,
                    'comments' => $request->comment,
                    'assign_to' => $userid, // Default
                    'created_at' => now(),
                    'created_by' => $userid, // Store User ID
                    'updated_at' => now(),
                    'updated_by' => $userid
                ]);

                $enquiry_no = 'ENQ' . str_pad($enquiryId, '5', "0", STR_PAD_LEFT);
                DB::table('tbl_inquiries')->where('id',$enquiryId)->update(['inquiry_number' => $enquiry_no]);

                $insert_data = array(
						'inquiries_id' => $enquiryId,
						'customer_name' => $request->customer_name,
						'email_address' => $request->email_address,
						'phone_number' => $request->phone_number,
						'source_id' => $request->source_id,
						'status_id' => $request->status_id,
						'trip_name' => $request->trip_name,
						'trip_start_date' => $request->trip_start_date ? date('Y-m-d H:i:s', strtotime($request->trip_start_date)) : null,
						'followup_date' => $request->follow_up_date ? date('Y-m-d H:i:s', strtotime($request->follow_up_date)) : null,
						'travellers_count' => $request->no_of_travellers,
						'comments' => $request->comment,
						'inquiry_number' => $enquiry_no,
						'assign_to' => $userid,
						'created_by' => $userid,
						'updated_by' => $userid,
						'created_at' => now(),
						'updated_at' => now()
					);
                    
                DB::table('tbl_inquiries_log')->insert($insert_data);
                return back()->with('success', 'Enquiry added successfully!');
            } catch (\Exception $e) {
                // Log the error
                Log::error('Error adding Enquiry: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add Enquiry.'])->withInput();
            }
        }

        return view('admin.managefollowupenquiries.addEnquiriesEntry', [
            'sources' => $sources,
            'statuses'   => $statuses
        ]);
    }

    public function viewEnquiriesEntry(Request $request, $id)
    {
        $row = DB::table('tbl_inquiries')->where('id', $id)->first();
        $rows_log = DB::table('tbl_inquiries_log')->where('inquiries_id', $id)->get();

        if ($row) {
            $customer_name = $row->customer_name;
            $email_address = $row->email_address;
            $phone_number = $row->phone_number;
            $source_id = $row->source_id;
            $trip_name = $row->trip_name;
            $inquiry_number = $row->inquiry_number;
            $created_by = $row->created_by;
            $created_at = date('d-M-Y', strtotime($row->created_at));
            $source_name = DB::table('tbl_sources')->where('id', $source_id)->value('name');
            $created_name = DB::table('tbl_admin')->where('adminid', $created_by)->value('admin_name');
            $status_id = $row->status_id;
            $status_name = DB::table('tbl_statuses')->where('id', $status_id)->value('name');
            $trip_start_date = date('d-M-Y', strtotime($row->trip_start_date));
            $followup_date = date('d-M-Y', strtotime($row->followup_date));
            $travellers_count = $row->travellers_count;
            $comments = $row->comments;

            // Start building the modal HTML
            $modalHtml = '<div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enquiry Details (' . $inquiry_number . ')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                </div>
                <div class="modal-body">
                    <div class="modal-sub-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Customer Name:</label></div>
                                    <div class="col-md-8">' . $customer_name . '</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Source:</label></div>
                                    <div class="col-md-8">' . $source_name . '</div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Email Address:</label></div>
                                    <div class="col-md-8">' . $email_address . '</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Phone Number:</label></div>
                                    <div class="col-md-8">' . $phone_number . '</div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Trip Start Date:</label></div>
                                    <div class="col-md-8">' . $trip_start_date . '</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>No. of Travellers:</label></div>
                                    <div class="col-md-8">' . $travellers_count . '</div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Status:</label></div>
                                    <div class="col-md-8">' . $status_name . '</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Follow Up Date:</label></div>
                                    <div class="col-md-8">' . $followup_date . '</div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Trip Name:</label></div>
                                    <div class="col-md-8">' . $trip_name . '</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Comment:</label></div>
                                    <div class="col-md-8">' . $comments . '</div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Created By:</label></div>
                                    <div class="col-md-8">' . $created_name . '</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="gap row">
                                    <div class="col-md-4"><label>Created On:</label></div>
                                    <div class="col-md-8">' . $created_at . '</div>
                                </div>
                            </div>

                            <div class="clearfix"></div>';

            if (!$rows_log->isEmpty()) {
                $modalHtml .= '<div class="col-md-12">
                                <h3>Previous Followup(s)</h3>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Updated Date</th>
                                        <th>Status</th>
                                        <th>Trip Details</th>
                                        <th>Comments</th>
                                        <th>Followup Date</th>
                                        <th>Updated By</th>
                                    </tr>';
                foreach ($rows_log as $row_log) {
                    $status_name = DB::table('tbl_statuses')->where('id', $row_log->status_id)->value('name');
                    $updated_name = DB::table('tbl_admin')->where('adminid', $row_log->updated_by)->value('admin_name');
                    $trip_start_date = date('d-M-Y', strtotime($row_log->trip_start_date));
                    $followup_date = date('d-M-Y', strtotime($row_log->followup_date));
                    $travellers_count = $row_log->travellers_count;
                    $comments = $row_log->comments;
                    $updated_at = date('d-M-Y', strtotime($row_log->updated_at));

                    $modalHtml .= '<tr>
                                    <td>' . $updated_at . '</td>
                                    <td>' . $status_name . '</td>
                                    <td>Trip Start Date: ' . $trip_start_date . '<br>No. of Travellers: ' . $travellers_count . '</td>
                                    <td>' . $comments . '</td>
                                    <td>' . $followup_date . '</td>
                                    <td>' . $updated_name . '</td>
                                </tr>';
                }
                $modalHtml .= '</table></div>';
            }

            $modalHtml .= '</div></div></div>';

            return response()->json(['html' => $modalHtml]);
        }

        return response()->json(['html' => 'No data found']);
    }

    public function editEnquiriesEntry(Request $request, $id)
    {
        // Fetch dropdown data
        $sources = DB::table('tbl_sources')
            ->select('id', 'name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $statuses = DB::table('tbl_statuses')
            ->select('id', 'name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        // Fetch enquiry data
        $enquiry = DB::table('tbl_inquiries')->where('id', $id)->first();
        
        if (!$enquiry) {
            return redirect()->route('admin.manageenquiriesentry')->withErrors(['error' => 'Enquiry not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate input fields
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'email_address' => 'required|email|max:255',
                'phone_number' => 'required|digits_between:10,15',
                'source_id' => 'required|integer|exists:tbl_sources,id',
                'status_id' => 'required|integer|exists:tbl_statuses,id',
                'trip_name' => 'required|string|max:255',
                'trip_start_date' => 'required|date',
                'follow_up_date' => 'required|date',
                'no_of_travellers' => 'required|integer|min:1',
                'comment' => 'required|string',
            ]);

            try {
                $userid = session('user')->adminid ?? 0;

                // Update enquiry
                DB::table('tbl_inquiries')->where('id', $id)->update([
                    'customer_name' => $request->customer_name,
                    'email_address' => $request->email_address,
                    'phone_number' => $request->phone_number,
                    'source_id' => $request->source_id,
                    'status_id' => $request->status_id,
                    'trip_name' => $request->trip_name,
                    'trip_start_date' => $request->trip_start_date ? date('Y-m-d H:i:s', strtotime($request->trip_start_date)) : null,
                    'followup_date' => $request->follow_up_date ? date('Y-m-d H:i:s', strtotime($request->follow_up_date)) : null,
                    'travellers_count' => $request->no_of_travellers,
                    'comments' => $request->comment,
                    'updated_at' => now(),
                    'updated_by' => $userid,
                    'assign_to' => $userid,
                ]);

                // Log update
                DB::table('tbl_inquiries_log')->insert([
                    'inquiries_id' => $id,
                    'customer_name' => $request->customer_name,
                    'email_address' => $request->email_address,
                    'phone_number' => $request->phone_number,
                    'source_id' => $request->source_id,
                    'status_id' => $request->status_id,
                    'trip_name' => $request->trip_name,
                    'trip_start_date' => $request->trip_start_date ? date('Y-m-d H:i:s', strtotime($request->trip_start_date)) : null,
                    'followup_date' => $request->follow_up_date ? date('Y-m-d H:i:s', strtotime($request->follow_up_date)) : null,
                    'travellers_count' => $request->no_of_travellers,
                    'comments' => $request->comment,
                    'inquiry_number' => $enquiry->inquiry_number,
                    'assign_to' => $userid,
                    'created_by' => $userid,
                    'updated_by' => $userid,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return redirect()->route('admin.manageenquiriesentry')->with('success', 'Enquiry updated successfully!');
            } catch (\Exception $e) {
                Log::error('Error updating Enquiry: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Something went wrong! Unable to update Enquiry.'])->withInput();
            }
        }

        return view('admin.managefollowupenquiries.editEnquiriesEntry', [
            'sources' => $sources,
            'statuses' => $statuses,
            'enquiry' => $enquiry
        ]);
    }


    public function deleteEnquiriesEntry(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_inquiries')->where('id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Enquiry not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_inquiries')->where('id', $id)->update([
                'bit_Deleted_Flag' => 1,
                'updated_at' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Enquiry deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Enquiry: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Enquiry.']);
        }
    }

}
