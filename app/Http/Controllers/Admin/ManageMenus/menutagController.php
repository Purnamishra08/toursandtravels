<?php
namespace App\Http\Controllers\Admin\ManageMenus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use DB;

class MenutagController extends Controller
{
    public function index(Request $request){
        return view('admin.managemenus.menutags');
    }

    public function getData(Request $request){
        if ($request->ajax()) {
            // Fetch menu tags for DataTables
            $query = DB::table('tbl_menus as a')
                ->select('a.menu_name', 'a.menuid', 'a.status', 'a.bit_Deleted_Flag','a.menu_meta_title','a.menu_meta_keywords','a.menu_meta_description')
                ->where('a.bit_Deleted_Flag', 0);
    
            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('a.menu_name', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('menu_name', function ($row) {
                    return $row->menu_name;
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.category.activemenutag', ['id' => $row->menuid]);
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
                        <a href="' . route('admin.category.editmenutag', $row->menuid) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // Define module ID required for delete access (adjust if needed)
                    $requiredModuleId = 8; // Change this to the correct module ID for menu tag
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.category.deletemenutag', $row->menuid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this menu tag?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $deleteButton;
                })
                ->rawColumns(['status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function addmenutag(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'menu_name'          => 'required|string|max:255|unique:tbl_menus,menu_name',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            try {
                DB::beginTransaction();
                DB::table('tbl_menus')->insert([
                    'menu_name'                 => $request->menu_name,
                    'menu_meta_title'           => $request->input('menu_meta_title'),
                    'menu_meta_keywords'        => $request->input('menu_meta_keywords'),
                    'menu_meta_description'     => $request->input('menu_meta_description'),
                    'status'                    => 1,
                    'created_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'created_date'              => now(),
                    'updated_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'updated_date'              => now(),
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Menu added successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error adding Menu: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while adding the Menu. Please try again.');
            }
        } else {
            return view('admin.managemenus.addmenutags');
        }
    }

    public function editmenutag(Request $request, $id)
    {
        // Fetch the destination type
        $menutags = DB::table('tbl_menus')
            ->where('bit_Deleted_Flag', 0)
            ->where('menuid', $id)
            ->first();

        // If not found, return with an error
        if (!$menutags) {
            return redirect()->back()->withErrors(['error' => 'Menu not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate input
            $validator = Validator::make($request->all(), [
                'menu_name' => 'required|string|max:255|unique:tbl_menus,menu_name,' . $id . ',menuid',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();

                // Update Data
                DB::table('tbl_menus')
                    ->where('menuid', $id)
                    ->update([
                        'menu_name'                     => $request->menu_name,
                        'menu_meta_title'               => $request->input('menu_meta_title'),
                        'menu_meta_keywords'            => $request->input('menu_meta_keywords'),
                        'menu_meta_description'         => $request->input('menu_meta_description'),
                        'updated_by'                    => session('user')->adminid ?? 0,
                        'updated_date'                  => now(),
                    ]);

                DB::commit();
                return redirect()->back()->with('success', 'Menu updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to update Menu. ' . $e->getMessage());
            }
        }

        return view('admin.managemenus.addmenutags', compact('menutags'));
        
    }

    public function deletemenutag(Request $request,$id){
        // Retrieve menu type by ID
        $data = DB::table('tbl_menus')->where('menuid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Menu not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_menus')->where('menuid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Menu deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Menu: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Menu.']);
        }
    }

    public function activemenutag(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_menus')->select('status')->where('menuid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Menu not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_menus')->where('menuid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Menu inactivated successfully!');
            }else{
                DB::table('tbl_menus')->where('menuid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Menu Activated successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Menu: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Menu.']);
        }
    }
}