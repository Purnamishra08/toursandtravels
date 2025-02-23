<?php

namespace App\Http\Controllers\Admin\ManageVehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class VehiclePriceController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_vehicleprices')->where('bit_Deleted_Flag', 0)->paginate(10);
        return view('admin.managevehicles.manageVehiclePrice', ['vehiclePrices' => $data]);
    }

    public function addVehiclePrice(Request $request)
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

                return back()->with('success', 'Vehicle Price Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding vehicle Price: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add vehicle Price.'])->withInput();
            }
        }

        return view('admin.managevehicles.addVehiclePrice');
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
