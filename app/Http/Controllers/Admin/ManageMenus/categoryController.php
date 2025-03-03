<?php
namespace App\Http\Controllers\Admin\ManageMenus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{
    public function index(Request $request){
        $perPage = $request->get('perPage', 10);
        $menus_type = DB::table('tbl_menucategories as a')
                      ->select('a.catid', 'm.menu_name','a.cat_name', 'a.status', 'a.bit_Deleted_Flag')
                      ->leftJoin('tbl_menus as m', 'a.menuid', '=', 'm.menuid')
                      ->where('a.bit_Deleted_Flag',0)
                      ->where('m.bit_Deleted_Flag',0)
                      ->paginate($perPage);
        return view('admin.managemenus.category', ['menus_type' => $menus_type]);
    }

    public function addcategory(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'cat_name'          => 'required|string|max:255|unique:tbl_menucategories,cat_name',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            try {
                DB::beginTransaction();
                DB::table('tbl_menucategories')->insert([
                    'menuid'                    => $request->menuid,
                    'cat_name'                  => $request->cat_name,
                    'status'                    => 1,
                    'created_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'created_date'              => now(),
                    'updated_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                    'updated_date'              => now(),
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Category added successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error adding category: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while adding the category. Please try again.');
            }
        } else {
            $menu = DB::table('tbl_menus')->select('menuid','menu_name')->where('status', 1)->where('bit_Deleted_Flag', 0)->get();
            return view('admin.managemenus.addcategory', ['menuTags' => $menu]);
        }
    }

    public function editcategory(Request $request, $id)
    {
        // Fetch the destination type
        $Category = DB::table('tbl_menucategories')
            ->where('bit_Deleted_Flag', 0)
            ->where('catid', $id)
            ->first();

        // If not found, return with an error
        if (!$Category) {
            return redirect()->back()->withErrors(['error' => 'Category not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate input
            $validator = Validator::make($request->all(), [
                'cat_name' => 'required|string|max:255|unique:tbl_menucategories,cat_name,' . $id . ',catid',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();

                // Update Data
                DB::table('tbl_menucategories')
                    ->where('catid', $id)
                    ->update([
                        'menuid'                    => $request->menuid,
                        'cat_name'                  => $request->cat_name,
                        'updated_by'                => session('user')->adminid ?? 0,
                        'updated_date'              => now(),
                    ]);

                DB::commit();
                return redirect()->back()->with('success', 'category updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to update category. ' . $e->getMessage());
            }
        }

        // Load the edit view with existing data
        $menuTags = DB::table('tbl_menus')->select('menuid','menu_name')->where('status', 1)->where('bit_Deleted_Flag', 0)->get();
        return view('admin.managemenus.addcategory', compact('Category', 'menuTags'));
        
    }

    public function deletecategory(Request $request,$id){
        // Retrieve category type by ID
        $data = DB::table('tbl_menucategories')->where('catid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Category not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_menucategories')->where('catid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Category: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Category.']);
        }
    }

    public function activecategory(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_menucategories')->select('status')->where('catid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Category not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_menucategories')->where('catid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Category inactivated successfully!');
            }else{
                DB::table('tbl_menucategories')->where('catid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Category Activated successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Category: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Category.']);
        }
    }
}