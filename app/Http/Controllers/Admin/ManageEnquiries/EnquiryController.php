<?php

namespace App\Http\Controllers\Admin\ManageEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve filter inputs (supports GET or POST) with default empty string
        $cont_name   = $request->input('cont_name', '');
        $cont_email = $request->input('cont_email', '');
        $cont_phone   = $request->input('cont_phone', '');
        $from_date       = $request->input('from_date', '');
        $to_date       = $request->input('to_date', '');


        // Build the base query for hotels with required joins
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

        // Apply filters if provided
        if (!empty($cont_name)) {
            $query->where('a.cont_name', 'like', '%' . $cont_name . '%');
        }
        if (!empty($cont_email)) {
            $query->where('a.cont_email', 'like', '%' . $cont_email . '%');
        }
        if (!empty($cont_phone)) {
            $query->where('a.cont_phone', 'like', '%' . $cont_phone . '%');
        }
        if (!empty($from_date)) {
            $query->where('a.cont_date', $from_date);
        }

        // Paginate the results
        $enquiry = $query->paginate(10);

        // Return the view with the Enquiry data and dropdowns
        return view('admin.manageenquiries.manageEnquiry', [
            'enquirys'       => $enquiry
        ]);
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
