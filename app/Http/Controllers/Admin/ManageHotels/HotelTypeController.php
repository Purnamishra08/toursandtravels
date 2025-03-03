<?php

namespace App\Http\Controllers\Admin\ManageHotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class HotelTypeController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_hotel_type')->where('bit_Deleted_Flag', 0)->paginate(10);
        return view('admin.managehotels.manageHotelType', ['hoteltypes' => $data]);
    }

    public function addHotelType(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'hotelType' => 'required|string|max:255',
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_hotel_type')->insert([
                    'hotel_type_name' => $request->input('hotelType'),
                    'status'=>1,
                    'created_date' => now(),
                    'created_by' => isset(session('user')->adminid) ? session('user')->adminid : 0 ,
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                ]);

                return back()->with('success', 'Hotel Type Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding hotel type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add hotel type.'])->withInput();
            }
        }

        return view('admin.managehotels.addHotelType');
    }

    public function editHotelType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Hotel Type not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'hotelType' => 'required|string|max:255',
            ]);

            try {
                // Update the record in the database
                DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                    'hotel_type_name' => $request->input('hotelType'),
                    'status'=>1,
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                ]);

                return back()->with('success', 'Hotel Type updated successfully!');
            } catch (Exception $e) {
                // Log the error
                Log::error('Error updating Hotel type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to update hotel type.'])->withInput();
            }
        }

        // Show edit form with existing data
        return view('admin.managehotels.editHotelType', ['hoteltype' => $data]);
    }

    public function deleteHotelType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Hotel Type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                'bit_Deleted_Flag' => 1,
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Hotel Type deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Hotel Type: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Hotel Type.']);
        }
    }
    
    public function activeHotelType(Request $request, $id)
    {
        $data = DB::table('tbl_hotel_type')->select('status')->where('hotel_type_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Hotel type not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Hotel type Inactive successfully!');
            }else{
                DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Hotel type Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive vehicle: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Hotel type.']);
        }
    }
}
