<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class PackageDurationsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_package_duration')
                ->where('bit_Deleted_Flag', 0);

            // 👉 Handle ordering explicitly
            if ($request->has('order')) {
                $columnIndex = $request->input('order')[0]['column']; // Get the column index
                $columnName = $request->input('columns')[$columnIndex]['data']; // Get column name
                $sortDirection = $request->input('order')[0]['dir']; // Get sorting direction
                $data->orderBy($columnName, $sortDirection);
            } else {
                $data->orderByDesc('durationid'); // Default sorting
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.managepackagedurations.activePackageDurations', ['id' => $row->durationid]).'" method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                <span class="label-custom label">'.$label.'</span>
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.managepackagedurations.editPackageDurations', ['id' => $row->durationid]);
                    $deleteUrl = route('admin.managepackagedurations.deletePackageDurations', ['id' => $row->durationid]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 10;
                    
                    $buttons = '
                        <div class="d-flex gap-1">
                            <a href="'.$editUrl.'" class="btn btn-success btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>';
                            
                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this package duration?\')">
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

        return view('admin.managepackages.managePackageDurations');
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
