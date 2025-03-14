<?php

namespace App\Http\Controllers\Admin\ManageEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class PackageEnquiryController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve filter inputs (supports GET or POST) with default empty string
        $package_name   = $request->input('package_name', '');
        $traveller_name   = $request->input('traveller_name', '');
        $cont_email = $request->input('cont_email', '');
        $cont_phone   = $request->input('cont_phone', '');
        $from_date       = $request->input('from_date', '');
        $to_date       = $request->input('to_date', '');


        // Build the base query for hotels with required joins
        $query = DB::table('tbl_package_inquiry as a')
            ->where('a.bit_Deleted_Flag', 0)
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
                'a.inquiry_date'
            );

        // Apply filters if provided
        if (!empty($package_name)) {
            $query->where('a.packageid', 'like', '%' . $package_name . '%');
        }
        if (!empty($traveller_name)) {
            $query->where('a.first_name', 'like', '%' . $traveller_name . '%')->orWhere('a.last_name', 'like', '%' . $traveller_name . '%');
        }
        if (!empty($cont_email)) {
            $query->where('a.emailid', 'like', '%' . $cont_email . '%');
        }
        if (!empty($cont_phone)) {
            $query->where('a.phone', 'like', '%' . $cont_phone . '%');
        }
        if (!empty($from_date)) {
            $query->where('a.tour_date', $from_date);
        }

        // Paginate the results
        $enquiry = $query->paginate(10);

        // Return the view with the Package Enquiry data and dropdowns
        return view('admin.manageenquiries.managePackageEnquiry', [
            'packageEnquirys'       => $enquiry
        ]);
    }

    public function viewPackageEnquiry(Request $request, $id)
    {
        try {
            // Fetch enquiry data
            $enquiry = DB::table('tbl_package_inquiry as a')
                ->join('tbl_hotel_type as b', 'a.accomodation', '=', 'b.hotel_type_id')
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
                'b.hotel_type_name'
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
