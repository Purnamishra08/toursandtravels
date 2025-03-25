<?php

namespace App\Http\Controllers\Admin\ManageFollowUpEnquiries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class StatusListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_statuses')
                ->where('bit_Deleted_Flag', 0);

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.statuslist.activeStatusList', ['id' => $row->id]).'" 
                            method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                <span class="label-custom label">'.$label.'</span>
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.statuslist.editStatusList', ['id' => $row->id]);
                    $deleteUrl = route('admin.statuslist.deleteStatusList', ['id' => $row->id]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 20;
                    
                    $buttons = '
                        <div class="d-flex gap-1">
                            <button class="btn btn-success btn-sm edit-btn" data-id="'.$row->id.'" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </button>';
                    
                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this Status List?\')">
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

        return view('admin.managefollowupenquiries.managestatuslist');
    }

    public function addStatusList(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'statusname' => 'required|string|max:255'
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_statuses')->insert([
                    'name' => $request->input('statusname'),
                    'status'=>1,
                    'created_date' => now(),
                    'created_by' => isset(session('user')->adminid) ? session('user')->adminid : 0
                ]);

                return back()->with('success', 'Status List Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding Status List: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add Status List.'])->withInput();
            }
        }

        return view('admin.managefollowupenquiries.managesources');
    }

    public function deleteStatusList(Request $request, $id)
    {
        // Retrieve statuslist by ID
        $data = DB::table('tbl_statuses')->where('id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Status List not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_statuses')->where('id', $id)->update([
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Status List deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Status List: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Status List.']);
        }
    }

    public function activeStatusList(Request $request, $id)
    {
        // Retrieve statuslist by ID
        $data = DB::table('tbl_statuses')->select('status')->where('id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Status List not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_statuses')->where('id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Status List Inactive successfully!');
            }else{
                DB::table('tbl_statuses')->where('id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Status List Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Status List: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Status List.']);
        }
    }

    public function editStatusList($id)
    {
        $source = DB::table('tbl_statuses')->where('id', $id)->first();

        if (!$source) {
            return response()->json(['error' => 'Source not found!'], 404);
        }

        // Modal HTML
        $modalHtml = '
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editSourceForm">
            '.csrf_field().'
                <input type="hidden" name="editid" id="editid" value="' . $source->id . '" />
                
                <div class="form-group">
                    <label>Status Name</label>
                    <input type="text" class="form-control" name="source_name" id="source_name" value="' . $source->name . '" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>';

        return response()->json(['html' => $modalHtml]);
    }

    // Handle Edit Submission
    public function updateStatusList(Request $request)
    {
        $request->validate([
            'editid' => 'required|integer',
            'source_name' => 'required|string|max:255'
        ]);

        try {
            $updated = DB::table('tbl_statuses')
                ->where('id', $request->editid)
                ->update([
                    'name' => $request->input('source_name'),
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0
                ]);

            if ($updated) {
                return response()->json(['success' => 'Status List updated successfully!']);
            } else {
                return response()->json(['error' => 'No changes made!'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error updating Status List: ' . $e->getMessage()], 500);
        }
    }
}
