<?php

namespace App\Http\Controllers\Admin\ManageVehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class VehiclePriceController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_vehicleprices as a')
                ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid') // Join to get vehicle name
                ->select('b.vehicle_name','a.priceid','a.destination','a.price','a.status') // Select required columns
                ->where('a.bit_Deleted_Flag', 0)
                ->paginate(10);
        return view('admin.managevehicles.manageVehiclePrice', ['vehiclePrices' => $data]);
    }

    public function addVehiclePrice(Request $request)
    {
        $vehicleTypes=DB::table('tbl_vehicletypes')->select('vehicleid','vehicle_name')->where('bit_Deleted_Flag', 0)->get();
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'vehicleid' => 'required|integer|min:1',
                'destinationid' => 'required|integer|min:1',
                'priceperday' => 'required|numeric|min:1'
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_vehicleprices')->insert([
                    'vehicle_name' => $request->input('vehicleid'),
                    'destination' => $request->input('destinationid'),
                    'price' => $request->input('priceperday'),
                    'status'=>1
                ]);

                return back()->with('success', 'Vehicle Price Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding vehicle Price: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add vehicle Price.'])->withInput();
            }
        }

        return view('admin.managevehicles.addVehiclePrice',['vehicleTypes'=>$vehicleTypes]);
    }

    public function editVehiclePrice(Request $request, $id)
    {
        // Retrieve vehicle price by ID
        $data = DB::table('tbl_vehicleprices')->where('priceid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Vehicle Price not found!']);
        }

        // Fetch all vehicle types for dropdown
        $vehicleTypes = DB::table('tbl_vehicletypes')->where('bit_Deleted_Flag', 0)->get();

        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'vehicleid' => 'required|integer|min:1',
                'destinationid' => 'required|integer|min:1',
                'priceperday' => 'required|numeric|min:1',
            ]);

            try {
                // Update the record in the database
                DB::table('tbl_vehicleprices')->where('priceid', $id)->update([
                    'vehicle_name' => $request->input('vehicleid'),  // Assuming vehicle_name stores vehicleid
                    'destination' => $request->input('destinationid'),
                    'price' => $request->input('priceperday'),
                ]);

                return back()->with('success', 'Vehicle Price updated successfully!');
            } catch (Exception $e) {
                // Log the error
                Log::error('Error updating Vehicle Price: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to update Vehicle Price.'])->withInput();
            }
        }

        // Show edit form with existing data
        return view('admin.managevehicles.editVehiclePrice', [
            'vehiclePrice' => $data, 
            'vehicleTypes' => $vehicleTypes
        ]);
    }


    public function deleteVehiclePrice(Request $request, $id)
    {
        // Retrieve vehicle price by ID
        $data = DB::table('tbl_vehicleprices')->where('priceid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Vehicle Price Type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_vehicleprices')->where('priceid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Vehicle Price deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting vehicle price: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete vehicle price.']);
        }
    }
}
