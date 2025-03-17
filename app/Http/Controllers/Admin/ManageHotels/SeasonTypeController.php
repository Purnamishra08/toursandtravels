<?php

namespace App\Http\Controllers\Admin\ManageHotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class SeasonTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_season_type')
                ->select('season_type_id', 'season_type_name', 'status')
                ->where('bit_Deleted_Flag', 0);

            return DataTables::of($data)
                ->filterColumn('season_type_name', function($query, $keyword) {
                    $query->where('season_type_name', 'like', "%{$keyword}%");
                })
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.manageSeasontype.activeSeasonType', ['id' => $row->season_type_id]).'"
                            method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                <span class="label-custom label">'.$label.'</span>
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.manageSeasontype.editSeasonType', ['id' => $row->season_type_id]);
                    $deleteUrl = route('admin.manageSeasontype.deleteSeasonType', ['id' => $row->season_type_id]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 12;

                    $buttons = '
                        <div class="d-flex gap-1">
                            <a href="'.$editUrl.'" class="btn btn-success btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>';
                    
                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this season?\')">
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

        return view('admin.managehotels.manageSeasontype');
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
