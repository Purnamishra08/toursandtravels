<?php

namespace App\Http\Controllers\Admin\ManageHotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SeasonTypeController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_season_type')->where('bit_Deleted_Flag', 0)->paginate(10);
        return view('admin.managehotels.manageSeasontype', ['seasontypes' => $data]);
    }

     public function addSeasonType(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'seasonType' => 'required|string|max:255',
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_season_type')->insert([
                    'season_type_name' => $request->input('seasonType'),
                    'status'=>1,
                    'created_date' => now(),
                    'created_by' => isset(session('user')->adminid) ? session('user')->adminid : 0 ,
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                ]);

                return back()->with('success', 'Season Type Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding Season type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add Season type.'])->withInput();
            }
        }

        return view('admin.managehotels.addSeasonType');
    }

    public function editSeasonType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_season_type')->where('season_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'season Type not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'seasonType' => 'required|string|max:255',
            ]);

            try {
                // Update the record in the database
                DB::table('tbl_season_type')->where('season_type_id', $id)->update([
                    'season_type_name' => $request->input('seasonType'),
                    'status'=>1,
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                ]);

                return back()->with('success', 'Season Type updated successfully!');
            } catch (Exception $e) {
                // Log the error
                Log::error('Error updating Season type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to update Season type.'])->withInput();
            }
        }

        // Show edit form with existing data
        return view('admin.managehotels.editSeasonType', ['seasontype' => $data]);
    }

    public function deleteSeasonType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_season_type')->where('season_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Season Type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_season_type')->where('season_type_id', $id)->update([
                'bit_Deleted_Flag' => 1,
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Season Type deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Season Type: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Season Type.']);
        }
    }

    public function activeSeasonType(Request $request, $id)
    {
        $data = DB::table('tbl_season_type')->select('status')->where('season_type_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Season type not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_season_type')->where('season_type_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Season type Inactive successfully!');
            }else{
                DB::table('tbl_season_type')->where('season_type_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Season type Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive vehicle: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Season type.']);
        }
    }
}
