<?php
namespace App\Http\Controllers\Admin\ManageMenus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class MenutagController extends Controller
{
    public function index(Request $request){
        $perPage = $request->get('perPage', 10);
        $menutags = DB::table('tbl_menus as a')
                      ->select('a.menu_name', 'a.menuid', 'a.status', 'a.bit_Deleted_Flag')
                      ->where('a.bit_Deleted_Flag',0)
                      ->paginate($perPage);
        return view('admin.managemenus.menutags', ['menutags' => $menutags]);
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
                        'menu_name'                  => $request->menu_name,
                        'updated_by'                => session('user')->adminid ?? 0,
                        'updated_date'              => now(),
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