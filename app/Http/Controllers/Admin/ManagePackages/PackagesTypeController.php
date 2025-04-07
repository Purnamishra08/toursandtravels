<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class PackagesTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_parameters')
                ->select('parid','par_value','status')
                ->where('param_type', 'PT')
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('par_value', 'asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.packageType.activePackageType', ['id' => $row->parid]).'" 
                            method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                <span class="label-custom label">'.$label.'</span>
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.packageType.editPackageType', ['id' => $row->parid]);
                    $deleteUrl = route('admin.packageType.deletePackageType', ['id' => $row->parid]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 20;
                    
                    $buttons = '
                        <div class="d-flex gap-1">
                            <button class="btn btn-success btn-sm edit-btn" data-id="'.$row->parid.'" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </button>';
                    
                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this Package Type?\')">
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
        return view('admin.managepackages.managePackageType');
    }

    public function addPackageType(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'packageType' => 'required|string|max:255'
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_parameters')->insert([
                    'parameter'=>'Package Type',
                    'par_value' => $request->input('packageType'),
                    'status'=>1,
                    'input_type'=>1,
                    'param_type'=>'PT',
                    'created_date' => now(),
                    'created_by' => isset(session('user')->adminid) ? session('user')->adminid : 0
                ]);

                return back()->with('success', 'Package Type Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding Package Type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add Package Type.'])->withInput();
            }
        }

        return view('admin.managepackages.managePackageType');
    }

    public function deletePackageType(Request $request, $id)
    {
        // Retrieve Package Type by ID
        $data = DB::table('tbl_parameters')->where('parid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Package Type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_parameters')->where('parid', $id)->update([
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Package Type deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Package Type: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Package Type.']);
        }
    }

    public function activePackageType(Request $request, $id)
    {
        // Retrieve Package Type by ID
        $data = DB::table('tbl_parameters')->select('status')->where('parid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Package Type not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_parameters')->where('parid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Package Type Inactive successfully!');
            }else{
                DB::table('tbl_parameters')->where('parid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Package Type Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive PackageType: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive PackageType.']);
        }
    }

    public function editPackageType($id)
    {
        $source = DB::table('tbl_parameters')->where('parid', $id)->first();

        if (!$source) {
            return response()->json(['error' => 'Package Type not found!'], 404);
        }

        // Modal HTML
        $modalHtml = '
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Source</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editSourceForm">
            '.csrf_field().'
                <input type="hidden" name="editid" id="editid" value="' . $source->parid . '" />
                
                <div class="form-group">
                    <label>Source Name</label>
                    <input type="text" class="form-control" name="packageType" id="packageType" value="' . $source->par_value . '" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>';

        return response()->json(['html' => $modalHtml]);
    }

    // Handle Edit Submission
    public function updatePackageType(Request $request)
    {
        $request->validate([
            'editid' => 'required|integer',
            'packageType' => 'required|string|max:255'
        ]);

        try {
            $updated = DB::table('tbl_parameters')
                ->where('parid', $request->editid)
                ->update([
                    'par_value' => $request->input('packageType'),
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0
                ]);

            if ($updated) {
                return response()->json(['success' => 'Source updated successfully!']);
            } else {
                return response()->json(['error' => 'No changes made!'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error updating source: ' . $e->getMessage()], 500);
        }
    }
}