<?php
namespace App\Http\Controllers\Admin\ManageFooter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FooterLinksController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.managefooter.footer');
    }
    
    public function getData(Request $request){
        if ($request->ajax()) {
            // Fetch destinations for DataTables
            $query = DB::table('tbl_footer as f')
                ->select('f.vch_Footer_Name', 'f.int_footer_id', 'f.status', DB::raw("GROUP_CONCAT(DISTINCT t.tpackage_name ORDER BY t.tpackage_name SEPARATOR ', ') AS tpackage_name"))
                ->leftJoin('tbl_tourpackages as t', DB::raw('FIND_IN_SET(t.tourpackageid, f.tourpackageid)'), '>', DB::raw('0'))
                ->where('t.bit_Deleted_Flag', 0)
                ->where('f.bit_Deleted_Flag', 0)
                ->groupBy('f.vch_Footer_Name', 'f.int_footer_id', 'f.status');

            $vch_Footer_Name   = $request->input('vch_Footer_Name', '');
            $status             = $request->input('status', '');

            if (!empty($vch_Footer_Name)) {
                $query->where('f.vch_Footer_Name', 'like', '%' . $vch_Footer_Name . '%');
            }
            if (!empty($status)) {
                $query->where('f.status', $status);
            }

            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('f.vch_Footer_Name', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('vch_Footer_Name', function ($row) {
                    return $row->vch_Footer_Name;
                })
                ->addColumn('tpackage_name', function ($row) {
                    return $row->tpackage_name;
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.footerlinks.activefooterlinks', ['id' => $row->int_footer_id]);
                    $confirmMessage = "return confirm('Are you sure you want to change the status?')";
    
                    if ($row->status == 1) {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-success" title="Active. Click to deactivate.">
                                        <span class="label-custom label label-success">Active</span>
                                    </button>
                                </form>';
                    } else {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-dark" title="Inactive. Click to activate.">
                                        <span class="label-custom label label-danger">Inactive</span>
                                    </button>
                                </form>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                
                    // Edit button (always visible)
                    $editButton = '
                        <a href="' . route('admin.footerlinks.editfooterlinks', $row->int_footer_id) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // Define module ID required for delete access (adjust if needed)
                    $requiredModuleId = 6;
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.footerlinks.deletefooterlinks', $row->int_footer_id) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this footer?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $deleteButton;
                })
                ->rawColumns(['destiimg', 'destiimg_thumb', 'status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function addfooterlinks (Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'vch_Footer_Name'    => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction
            try {
                $duplicateCount = DB::table('tbl_footer')->Where('vch_Footer_URL', $request->input('vch_Footer_URL'))->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this footer, URL must be unique.']);
                }
                $data = [
                    'vch_Footer_Name'           => $request->input('vch_Footer_Name'),
                    'vch_Footer_URL'            => $request->input('vch_Footer_URL'),
                    'vch_Footer_Desc'           => $request->input('vch_Footer_Desc'),
                    'footer_meta_title'         => $request->input('footer_meta_title'),
                    'footer_meta_keywords'      => $request->input('footer_meta_keywords'),
                    'footer_meta_description'   => $request->input('footer_meta_description'),
                    'tourpackageid' 		    => implode(',', $request->input('tourpackageid')),
                    'status'                    => 1,
                    'created_by'                => session('user')->adminid ?? 0,
                    'updated_by'                => session('user')->adminid ?? 0,
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ];
                // Insert into database
                $inserted = DB::table('tbl_footer')->insert($data);
                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Footer added successfully.');
                } else {
                    throw new \Exception('Footer could not be added.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $tourpackageid = DB::table('tbl_tourpackages')->select('tourpackageid','tpackage_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tpackage_name', 'ASC')->get();
            return view('admin.managefooter.addfooter', ['tourpackageid' => $tourpackageid]);
        }
    }

    public function editfooterlinks (Request $request, $id){
        $footerData = DB::table('tbl_footer')->where('int_footer_id', $id)->first();
        if (!$footerData) {
            return redirect()->back()->with('error', 'Footer not found.');
        }
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'vch_Footer_Name'    => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction
            try {
                $duplicateCount = DB::table('tbl_footer')->Where('vch_Footer_URL', $request->input('vch_Footer_URL'))->where('int_footer_id', '!=', $id)->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this footer, URL must be unique.']);
                }
                $data = [
                    'vch_Footer_Name'           => $request->input('vch_Footer_Name'),
                    'vch_Footer_URL'            => $request->input('vch_Footer_URL'),
                    'vch_Footer_Desc'           => $request->input('vch_Footer_Desc'),
                    'footer_meta_title'         => $request->input('footer_meta_title'),
                    'footer_meta_description'   => $request->input('footer_meta_description'),
                    'tourpackageid' 		    => implode(',', $request->input('tourpackageid')),
                    'status'                    => 1,
                    'updated_by'                => session('user')->adminid ?? 0,
                    'updated_at'                => now(),
                ];
                // Insert into database
                $updated = DB::table('tbl_footer')->where('int_footer_id', $id)->update($data);
                if ($updated) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Footer updated successfully.');
                } else {
                    throw new \Exception('Footer could not be updated.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $tourpackageid = DB::table('tbl_tourpackages')->select('tourpackageid','tpackage_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tpackage_name', 'ASC')->get();
            return view('admin.managefooter.addfooter', ['tourpackageid' => $tourpackageid, 'footerData' => $footerData]);
        }
    }

    public function activefooterlinks(Request $request,$id){
        // Retrieve Footer type by ID
        $data = DB::table('tbl_footer')->select('status')->where('int_footer_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Footer not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_footer')->where('int_footer_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Footer inactivated successfully!');
            }else{
                DB::table('tbl_footer')->where('int_footer_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Footer Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Footer: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Footer.']);
        }
    }

    public function deletefooterlinks(Request $request,$id){
        // Retrieve Footer by ID
        $data = DB::table('tbl_footer')->where('int_footer_id', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Footer not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_footer')->where('int_footer_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Footer deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Footer: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Footer.']);
        }
    }
}