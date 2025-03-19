<?php

namespace App\Http\Controllers\Admin\ManageEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class ItineraryEnquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_tripcustomize as a')
                ->join('tbl_tourpackages as b', 'a.package_id', '=', 'b.tourpackageid')
                ->where('a.bit_Deleted_Flag', 0)
                ->select(
                    'a.tripcust_id',
                    'a.email', 
                    'a.phone', 
                    'a.tsdate', 
                    'a.duration', 
                    'a.tnote',
                    'a.package_id',
                    'b.tpackage_name'
                );

            // Apply filters if provided
            if (!empty($request->package_name)) {
                $query->where('b.tpackage_name', 'like', '%' . $request->package_name . '%');
            }
            if (!empty($request->cont_email)) {
                $query->where('a.email', 'like', '%' . $request->cont_email . '%');
            }
            if (!empty($request->cont_phone)) {
                $query->where('a.phone', 'like', '%' . $request->cont_phone . '%');
            }

            // Handle date range filter
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('a.tsdate', [\Carbon\Carbon::parse($request->from_date)->format('Y-m-j'), \Carbon\Carbon::parse($request->to_date)->format('Y-m-j')]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('a.tsdate', '>=', \Carbon\Carbon::parse($request->from_date)->format('Y-m-j'));
            } elseif (!empty($request->to_date)) {
                $query->whereDate('a.tsdate', '<=', \Carbon\Carbon::parse($request->to_date)->format('Y-m-j'));
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('tsdate', function ($row) {
                    return \Carbon\Carbon::parse($row->tsdate)->format('jS M Y');
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.manageitineraryenquiry.viewItineraryEnquiry', ['id' => $row->tripcust_id]);
                    $deleteUrl = route('admin.manageitineraryenquiry.deleteItineraryEnquiry', ['id' => $row->tripcust_id]);

                    $buttons = '<a href="' . $viewUrl . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';
                    if (session('user')->admin_type == 1) {
                        $buttons .= '<form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Itinerary Enquiry?\')" style="display:inline-block;">
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

        return view('admin.manageenquiries.manageItineraryEnquiry');
    }

    public function viewItineraryEnquiry(Request $request, $id)
    {
        try {
            
            // Fetch enquiry data
            $itineraryEnquirys = DB::table('tbl_tripcustomize as a')
                ->join('tbl_package_duration as b', 'a.duration', '=', 'b.durationid')
                ->join('tbl_tourpackages as c', 'a.package_id', '=', 'c.tourpackageid')
                ->where('a.bit_Deleted_Flag', 0)
                ->where('a.tripcust_id', $id)
                ->select(
                    'a.tripcust_id', 
                    'a.email', 
                    'a.phone', 
                    'a.tsdate', 
                    'a.duration', 
                    'a.tnote',
                    'a.package_id',
                    'b.duration_name',
                    'c.tpackage_name'
                )
                ->first();

            if (!$itineraryEnquirys) {
                return redirect()->back()->with('error', 'Itinerary Enquiry not found.');
            }

            // Fetch messages related to the itinerary enquiry ID
            $messages = DB::table('tbl_reply_enquiry')
                ->where('enq_id', $id)
                ->where('type', 2)
                ->select('message', 'created_date', 'adminid')
                ->orderBy('created_date', 'desc')
                ->get();

            // Handle post request for adding reply
            if ($request->isMethod('post')) {
                $request->validate([
                    'reply' => 'required|string',
                    'hdnenquiry_id' => 'required|integer|exists:tbl_tripcustomize,tripcust_id',
                ]);

                DB::table('tbl_reply_enquiry')->insert([
                    'adminid' => session('user')->adminid ?? 0,
                    'type' => 2,
                    'enq_id' => $request->input('hdnenquiry_id'),
                    'message' => $request->input('reply'),
                    'created_date' => now(),
                ]);

                return redirect()->back()->with('success', 'Reply sent successfully.');
            }

            return view('admin.manageenquiries.viewItineraryEnquiry', [
                'itineraryEnquirys' => $itineraryEnquirys,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in view Itinerary Enquiry: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function deleteItineraryEnquiry(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_tripcustomize')->where('tripcust_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Itinerary Enquiry not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_tripcustomize')->where('tripcust_id', $id)->update([
                'bit_Deleted_Flag' => 1
                // 'updated_date' => now(),
                // 'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Itinerary Enquiry deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Itinerary Enquiry: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Itinerary Enquiry.']);
        }
    }
}
