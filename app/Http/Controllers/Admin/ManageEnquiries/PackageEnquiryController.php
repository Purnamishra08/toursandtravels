<?php

namespace App\Http\Controllers\Admin\ManageEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class PackageEnquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_package_inquiry as a')
                ->join('tbl_tourpackages as b', 'a.packageid', '=', 'b.tourpackageid')
                ->where('a.bit_Deleted_Flag', 0)
                ->select(
                    'a.enq_id',
                    'a.first_name',
                    'a.last_name',
                    DB::raw("CONCAT(a.first_name, ' ', a.last_name) as traveller_name"), // Combine as a single column
                    'a.emailid',
                    'a.phone',
                    'a.message',
                    'a.noof_adult',
                    'a.noof_child',
                    'a.tour_date',
                    'a.accomodation',
                    'a.packageid',
                    'a.inquiry_date',
                    'b.tpackage_name'
                );

            // Apply filters
            if (!empty($request->package_name)) {
                $query->where('b.tpackage_name', 'like', '%' . $request->package_name . '%');
            }

            if (!empty($traveller_name)) {
                $query->where(function ($q) use ($traveller_name) {
                    $q->where('a.first_name', 'like', '%' . $traveller_name . '%')
                    ->orWhere('a.last_name', 'like', '%' . $traveller_name . '%');
                });
            }
            if (!empty($request->cont_email)) {
                $query->where('a.emailid', 'like', '%' . $request->cont_email . '%');
            }
            if (!empty($request->cont_phone)) {
                $query->where('a.phone', 'like', '%' . $request->cont_phone . '%');
            }

            // Handle date range filter
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('a.tour_date', [\Carbon\Carbon::parse($request->from_date)->format('Y-m-j'), \Carbon\Carbon::parse($request->to_date)->format('Y-m-j')]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('a.tour_date', '>=', \Carbon\Carbon::parse($request->from_date)->format('Y-m-j'));
            } elseif (!empty($request->to_date)) {
                $query->whereDate('a.tour_date', '<=', \Carbon\Carbon::parse($request->to_date)->format('Y-m-j'));
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('traveller_name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->filterColumn('traveller_name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(a.first_name, ' ', a.last_name) LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('traveller_name', function ($query, $direction) {
                    $query->orderByRaw("CONCAT(a.first_name, ' ', a.last_name) {$direction}");
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<a href="' . route('admin.managepackageenquiry.viewPackageEnquiry', ['id' => $row->enq_id]) . '" class="btn btn-primary btn-sm" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>';
                    $deleteBtn = '';
                    if (session('user')->admin_type == 1) {
                        $deleteBtn = '<form action="' . route('admin.managepackageenquiry.deletePackageEnquiry', ['id' => $row->enq_id]) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')">
                                        ' . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>';
                    }
                    return '<div class="d-flex gap-1">' . $viewBtn . $deleteBtn . '</div>';
                })
                ->editColumn('tour_date', function ($row) {
                    return \Carbon\Carbon::parse($row->tour_date)->format('jS M Y');
                })
                ->editColumn('inquiry_date', function ($row) {
                    return \Carbon\Carbon::parse($row->inquiry_date)->format('jS M Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.manageenquiries.managePackageEnquiry');
    }


    public function viewPackageEnquiry(Request $request, $id)
    {
        try {
            // Fetch enquiry data
            $enquiry = DB::table('tbl_package_inquiry as a')
                ->join('tbl_hotel_type as b', 'a.accomodation', '=', 'b.hotel_type_id')
                ->join('tbl_tourpackages as c', 'a.packageid', '=', 'c.tourpackageid')
                ->where('a.bit_Deleted_Flag', 0)
                ->where('a.enq_id', $id)
                ->select(
                'a.enq_id',
                'a.first_name',
                'a.last_name',
                'a.emailid',
                'a.phone',
                'a.message',
                'a.noof_adult',
                'a.noof_child',
                'a.tour_date',
                'a.accomodation',
                'a.packageid',
                'a.inquiry_date',
                'b.hotel_type_name',
                'c.tpackage_name'
                )
                ->first();

            if (!$enquiry) {
                return redirect()->back()->with('error', 'Package Enquiry not found.');
            }

            // Fetch messages related to the enquiry ID
            $messages = DB::table('tbl_reply_enquiry')
                ->where('enq_id', $id)
                ->where('type', 3)
                ->select('message', 'created_date', 'adminid')
                ->orderBy('created_date', 'desc')
                ->get();

            // Handle post request for adding reply
            if ($request->isMethod('post')) {
                $request->validate([
                    'reply' => 'required|string',
                    'hdnenquiry_id' => 'required|integer|exists:tbl_package_inquiry,enq_id',
                ]);

                DB::table('tbl_reply_enquiry')->insert([
                    'adminid' => session('user')->adminid ?? 0,
                    'type' => 3,
                    'enq_id' => $request->input('hdnenquiry_id'),
                    'message' => $request->input('reply'),
                    'created_date' => now(),
                ]);

                return redirect()->back()->with('success', 'Reply sent successfully.');
            }

            return view('admin.manageenquiries.viewPackageEnquiry', [
                'enquirys' => $enquiry,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in viewPackageEnquiry: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function deletePackageEnquiry(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_package_inquiry')->where('enq_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Package Enquiry not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_package_inquiry')->where('enq_id', $id)->update([
                'bit_Deleted_Flag' => 1
                // 'updated_date' => now(),
                // 'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Package Enquiry deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Package Enquiry: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Package Enquiry.']);
        }
    }
}
