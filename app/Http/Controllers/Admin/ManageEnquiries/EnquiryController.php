<?php

namespace App\Http\Controllers\Admin\ManageEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_contact as a')
                ->where('a.bit_Deleted_Flag', 0)
                ->select(
                    'a.enq_id', 
                    'a.cont_name', 
                    'a.cont_email', 
                    'a.cont_phone', 
                    'a.cont_enquiry_details', 
                    'a.page_name', 
                    'a.cont_date'
                );

            if (!empty($request->cont_name)) {
                $query->where('a.cont_name', 'like', '%' . $request->cont_name . '%');
            }
            if (!empty($request->cont_email)) {
                $query->where('a.cont_email', 'like', '%' . $request->cont_email . '%');
            }
            if (!empty($request->cont_phone)) {
                $query->where('a.cont_phone', 'like', '%' . $request->cont_phone . '%');
            }

            // Handle date range filter
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('a.cont_date', [\Carbon\Carbon::parse($request->from_date)->format('Y-m-j'), \Carbon\Carbon::parse($request->to_date)->format('Y-m-j')]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('a.cont_date', '>=', \Carbon\Carbon::parse($request->from_date)->format('Y-m-j'));
            } elseif (!empty($request->to_date)) {
                $query->whereDate('a.cont_date', '<=', \Carbon\Carbon::parse($request->to_date)->format('Y-m-j'));
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('cont_date', function ($row) {
                    // Format date to 'jS M Y'
                    return \Carbon\Carbon::parse($row->cont_date)->format('jS M Y');
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.manageenquiry.viewEnquiry', $row->enq_id);
                    $deleteUrl = route('admin.manageenquiry.deleteEnquiry', $row->enq_id);

                    $buttons = '<a href="' . $viewUrl . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
                    if (session('user')->admin_type == 1) {
                        $buttons .= '<form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\')" style="display:inline-block;">
                                        ' . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>';
                    }
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.manageenquiries.manageEnquiry');
    }



    public function viewEnquiry(Request $request, $id)
    {
        try {
            // Fetch enquiry data
            $enquiry = DB::table('tbl_contact as a')
                ->where('a.bit_Deleted_Flag', 0)
                ->where('a.enq_id', $id)
                ->select(
                    'a.enq_id', 
                    'a.cont_name', 
                    'a.cont_email', 
                    'a.cont_phone', 
                    'a.cont_enquiry_details', 
                    'a.page_name', 
                    'a.cont_date'
                )
                ->first();

            if (!$enquiry) {
                return redirect()->back()->with('error', 'Enquiry not found.');
            }

            // Fetch messages related to the enquiry ID
            $messages = DB::table('tbl_reply_enquiry')
                ->where('enq_id', $id)
                ->where('type', 1)
                ->select('message', 'created_date', 'adminid')
                ->orderBy('created_date', 'desc')
                ->get();

            // Handle post request for adding reply
            if ($request->isMethod('post')) {
                $request->validate([
                    'reply' => 'required|string',
                    'hdnenquiry_id' => 'required|integer|exists:tbl_contact,enq_id',
                ]);

                DB::table('tbl_reply_enquiry')->insert([
                    'adminid' => session('user')->adminid ?? 0,
                    'type' => 1,
                    'enq_id' => $request->input('hdnenquiry_id'),
                    'message' => $request->input('reply'),
                    'created_date' => now(),
                ]);

                return redirect()->back()->with('success', 'Reply sent successfully.');
            }

            return view('admin.manageenquiries.viewEnquiry', [
                'enquirys' => $enquiry,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in viewEnquiry: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function deleteEnquiry(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_contact')->where('enq_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Enquiry not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_contact')->where('enq_id', $id)->update([
                'bit_Deleted_Flag' => 1
                // 'updated_date' => now(),
                // 'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Enquiry deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Enquiry: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Enquiry.']);
        }
    }

}
