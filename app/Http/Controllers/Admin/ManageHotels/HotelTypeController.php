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
                'vehiclename' => 'required|string|max:255',
                'vehiclecapacity' => 'required|integer|min:1'
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_vehicletypes')->insert([
                    'vehicle_name' => $request->input('vehiclename'),
                    'capacity' => $request->input('vehiclecapacity'),
                    'status'=>1
                ]);

                return back()->with('success', 'Vehicle Type Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding vehicle type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add vehicle type.'])->withInput();
            }
        }

        return view('admin.managevehicles.addVehicleType');
    }

    public function editVehicleType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_vehicletypes')->where('vehicleid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Vehicle Type not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'vehiclename' => 'required|string|max:255',
                'vehiclecapacity' => 'required|integer|min:1'
            ]);

            try {
                // Update the record in the database
                DB::table('tbl_vehicletypes')->where('vehicleid', $id)->update([
                    'vehicle_name' => $request->input('vehiclename'),
                    'capacity' => $request->input('vehiclecapacity'),
                ]);

                return back()->with('success', 'Vehicle Type updated successfully!');
            } catch (Exception $e) {
                // Log the error
                Log::error('Error updating vehicle type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to update vehicle type.'])->withInput();
            }
        }

        // Show edit form with existing data
        return view('admin.managevehicles.editVehicleType', ['vehicletype' => $data]);
    }

    public function deleteVehicleType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_vehicletypes')->where('vehicleid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Vehicle Type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_vehicletypes')->where('vehicleid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Vehicle deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting vehicle: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete vehicle.']);
        }
    }
}
