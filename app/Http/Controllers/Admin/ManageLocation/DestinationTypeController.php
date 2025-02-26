<?php
namespace App\Http\Controllers\Admin\ManageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class DestinationTypeController extends Controller
{
    public function index()
    {
        $destination_type = DB::table('tbl_destination_type')->where('bit_Deleted_Flag',0)->paginate(10);
        return view('admin.managelocation.destination_type', ['destination_type' => $destination_type]);
    }

    public function adddestination_type(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'destinationtype'          => 'required|string|max:255|unique:tbl_destination_type,destination_type_name',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            try {
                DB::beginTransaction();
                DB::table('tbl_destination_type')->insert([
                    'destination_type_name'     => $request->destinationtype,
                    'status'                    => 1,
                    'created_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'created_date'              => now(),
                    'updated_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'updated_date'              => now(),
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Destination type added successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error adding Destination type: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while adding the Destination type. Please try again.');
            }
        } else {
            return view('admin.managelocation.adddestination_type');
        }
    }

    public function editdestination_type(Request $request, $id)
    {
        // Fetch the destination type
        $destinationtype = DB::table('tbl_destination_type')
            ->where('bit_Deleted_Flag', 0)
            ->where('destination_type_id', $id)
            ->first();

        // If not found, return with an error
        if (!$destinationtype) {
            return redirect()->back()->withErrors(['error' => 'Destination type not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate input
            $validator = Validator::make($request->all(), [
                'destinationtype' => 'required|string|max:255|unique:tbl_destination_type,destination_type_name,' . $id . ',destination_type_id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();

                // Update Data
                DB::table('tbl_destination_type')
                    ->where('destination_type_id', $id)
                    ->update([
                        'destination_type_name' => $request->destinationtype,
                        'updated_by'            => session('user')->adminid ?? 0,
                        'updated_date'          => now(),
                    ]);

                DB::commit();
                return redirect()->back()->with('success', 'Destination type updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to update destination type. ' . $e->getMessage());
            }
        }

        // Load the edit view with existing data
        return view('admin.managelocation.adddestination_type', compact('destinationtype'));
    }

    public function deletedestination_type(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_destination_type')->where('destination_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Destination type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_destination_type')->where('destination_type_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Destination type deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Destination type: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Destination type.']);
        }
    }
}