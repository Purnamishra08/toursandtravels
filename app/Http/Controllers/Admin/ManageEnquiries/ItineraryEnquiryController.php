<?php

namespace App\Http\Controllers\Admin\ManageEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class ItineraryEnquiryController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve filter inputs (supports GET or POST) with default empty string
        $package_name   = $request->input('package_name', '');
        $email = $request->input('cont_email', '');
        $phone   = $request->input('cont_phone', '');
        $from_date       = $request->input('from_date', '');
        $to_date       = $request->input('to_date', '');

        // Build the base query for hotels with required joins
        $query = DB::table('tbl_tripcustomize as a')
            ->where('a.bit_Deleted_Flag', 0)
            ->select(
                'a.tripcust_id',
                'a.email', 
                'a.phone', 
                'a.tsdate', 
                'a.duration', 
                'a.tnote',
                'a.package_id'
            );

        // Apply filters if provided
        if (!empty($package_name)) {
            $query->where('a.package_id', 'like', '%' . $package_name . '%');
        }
        if (!empty($email)) {
            $query->where('a.email', 'like', '%' . $email . '%');
        }
        if (!empty($phone)) {
            $query->where('a.phone', 'like', '%' . $phone . '%');
        }
        if (!empty($from_date)) {
            $query->where('a.tsdate', $from_date);
        }

        // Paginate the results
        $itineraryEnquirys = $query->paginate(10);

        // Return the view with the Itinerary Enquiry data and dropdowns
        return view('admin.manageenquiries.manageItineraryEnquiry', [
            'itineraryEnquirys'       => $itineraryEnquirys
        ]);
    }

    public function viewItineraryEnquiry(Request $request, $id)
    {
        try {
            
            // Fetch enquiry data
            $itineraryEnquirys = DB::table('tbl_tripcustomize as a')
                ->join('tbl_package_duration as b', 'a.duration', '=', 'b.durationid')
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
                    'b.duration_name'
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
