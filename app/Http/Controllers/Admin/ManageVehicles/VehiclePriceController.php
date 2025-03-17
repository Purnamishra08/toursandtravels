<?php

namespace App\Http\Controllers\Admin\ManageVehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;
class VehiclePriceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_vehicleprices as a')
                ->leftJoin('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
                ->leftJoin('tbl_destination as c', 'c.destination_id', '=', 'a.destination')
                ->select(
                    'a.priceid',
                    'b.vehicle_name',
                    'c.destination_name',
                    'a.price',
                    'a.status'
                )
                ->where('a.bit_Deleted_Flag', 0);

            return DataTables::of($data)
                // Fix for searching the alias column `destination_name`
                ->filterColumn('destination_name', function($query, $keyword) {
                    $query->where('c.destination_name', 'like', "%{$keyword}%");
                })
                ->filterColumn('vehicle_name', function($query, $keyword) {
                    $query->where('b.vehicle_name', 'like', "%{$keyword}%");
                })
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.manageVehicleprice.activeVehiclePrice', ['id' => $row->priceid]).'"
                            method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                <span class="label-custom label">'.$label.'</span>
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.manageVehicleprice.editVehiclePrice', ['id' => $row->priceid]);
                    $deleteUrl = route('admin.manageVehicleprice.deleteVehiclePrice', ['id' => $row->priceid]);

                    $buttons = '
                        <div class="d-flex gap-1">
                            <a href="'.$editUrl.'" class="btn btn-success btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>';
                    
                    if (session('user')->admin_type == 1) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this vehicle?\')">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.managevehicles.manageVehiclePrice');
    }


    public function addVehiclePrice(Request $request)
    {
        $vehicleTypes=DB::table('tbl_vehicletypes')->select('vehicleid','vehicle_name')->where('bit_Deleted_Flag', 0)->get();
        $destination=DB::table('tbl_destination')->select('destination_id','destination_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->get();
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

        return view('admin.managevehicles.addVehiclePrice',['vehicleTypes'=>$vehicleTypes,'destinations'=>$destination]);
    }

    public function editVehiclePrice(Request $request, $id)
    {
        // Retrieve vehicle price by ID
        $data = DB::table('tbl_vehicleprices')->where('priceid', $id)->first();
        $destination=DB::table('tbl_destination')->select('destination_id','destination_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->get();
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
            'vehicleTypes' => $vehicleTypes,
            'destinations' => $destination
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

    public function activeVehiclePrice(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_vehicleprices')->select('status')->where('priceid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Vehicle Price not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_vehicleprices')->where('priceid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Vehicle Price Inactive successfully!');
            }else{
                DB::table('tbl_vehicleprices')->where('priceid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Vehicle Price Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive vehicle: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Vehicle Price.']);
        }
    }
}
