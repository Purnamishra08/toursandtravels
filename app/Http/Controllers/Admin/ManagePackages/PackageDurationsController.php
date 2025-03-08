<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class PackageDurationsController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_package_duration')->where('bit_Deleted_Flag', 0)->orderByDesc('durationid')->paginate(10);
        return view('admin.managepackages.managePackageDurations', ['packageDurations' => $data]);
    }

    public function addPackageDurations(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'duration_name'=>'required|string|max:200',
                'no_ofdays'=>'required|numeric|max:11',
                'no_ofnights'=>'required|numeric|max:11',
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_package_duration')->insert([
                    'duration_name'=>$request->input('duration_name'),
                    'no_ofdays'=>$request->input('no_ofdays'),
                    'no_ofnights'=>$request->input('no_ofnights'),
                    'status'=>1
                ]);

                return back()->with('success', 'Package Duration Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding Package Duration: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add Package Duration.'])->withInput();
            }
        }

        return view('admin.managepackages.addPackageDurations');
    }

    public function editPackageDurations(Request $request, $id)
    {
        // Retrieve the package duration record by its id
        $package = DB::table('tbl_package_duration')->where('durationid', $id)->first();

        if (!$package) {
            return redirect()->route('admin.managepackagedurations')
                ->withErrors(['error' => 'Package Duration not found.']);
        }

        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'duration_name' => 'required|string|max:200',
                'no_ofdays'     => 'required|numeric',
                'no_ofnights'   => 'required|numeric',
            ]);

            try {
                // Update the package duration record
                DB::table('tbl_package_duration')->where('durationid', $id)->update([
                    'duration_name' => $request->input('duration_name'),
                    'no_ofdays'     => $request->input('no_ofdays'),
                    'no_ofnights'   => $request->input('no_ofnights'),
                ]);

                return redirect()->route('admin.managepackagedurations')
                    ->with('success', 'Package Duration updated successfully!');
            } catch (\Exception $e) {
                \Log::error('Error updating Package Duration: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to update Package Duration.'])
                            ->withInput();
            }
        }

        // Show the edit form with the existing data prefilled
        return view('admin.managepackages.editPackageDurations', [
            'package' => $package
        ]);
    }

    public function deletePackageDurations(Request $request, $id)
    {
        // Retrieve package duration record by its ID
        $data = DB::table('tbl_package_duration')->where('durationid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Package Duration not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag along with updated_date and updated_by fields
            DB::table('tbl_package_duration')->where('durationid', $id)->update([
                'bit_Deleted_Flag' => 1,
            ]);

            return redirect()->back()->with('success', 'Package Duration deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting Package Duration: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Package Duration.']);
        }
    }


    public function activePackageDurations(Request $request, $id)
    {
        $data = DB::table('tbl_package_duration')->select('status')->where('durationid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Package Durations not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_package_duration')->where('durationid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Package Durations Inactive successfully!');
            }else{
                DB::table('tbl_package_duration')->where('durationid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Package Durations Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Package Durations: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Package Durations.']);
        }
    }


}
