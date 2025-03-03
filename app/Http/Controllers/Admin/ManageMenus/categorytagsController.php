<?php
namespace App\Http\Controllers\Admin\ManageMenus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class CategoryTagsController extends Controller
{
    public function index(Request $request){
        $perPage = $request->get('perPage', 10);
        $category_tags = DB::table('tbl_menutags as a')
                      ->select('a.tagid', 'a.cat_id', 'a.menuid', 'm.menu_name','c.cat_name', 'a.tag_name', 'a.status', 'a.bit_Deleted_Flag')
                      ->leftJoin('tbl_menus as m', 'a.menuid', '=', 'm.menuid')
                      ->leftJoin('tbl_menucateories as c', 'a.cat_id', '=', 'c.catid')
                      ->where('a.bit_Deleted_Flag',0)
                      ->where('m.bit_Deleted_Flag',0)
                      ->where('c.bit_Deleted_Flag',0)
                      ->paginate($perPage);
        return view('admin.managemenus.categorytags', ['category_tags' => $category_tags]);
    }

    public function deletecategorytags(Request $request,$id){
        // Retrieve category type by ID
        $data = DB::table('tbl_menutags')->where('tagid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Category tag not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_menutags')->where('tagid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Category tag deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Category tag: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Category tag.']);
        }
    }

    public function activecategorytags(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_menutags')->select('status')->where('tagid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Category tag not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_menutags')->where('tagid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Category tag inactivated successfully!');
            }else{
                DB::table('tbl_menutags')->where('tagid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Category tag Activated successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Category tag: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Category tag.']);
        }
    }
}