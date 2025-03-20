<?php
namespace App\Http\Controllers\Admin\ManageCms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ManageCmsController extends Controller
{
    public function index(Request $request, $id)
    {
        // For initial page load, return the view
        $contentData = DB::table('tbl_contents')
        ->select('content_id', 'page_name')
        ->where('bit_Deleted_Flag', 0)
        ->get();

        if ($request->isMethod('post')) {
            $content = DB::table('tbl_contents')->where('content_id', $id)->first();
            if (!$content) {
                return redirect()->back()->with('error', 'CMS not found.');
            }
            DB::beginTransaction();
            try {
                $data = [
                    'page_content'              => $request->input('page_content'),
                    'seo_title'                 => $request->input('seo_title'),
                    'seo_description'           => $request->input('seo_description'),
                    'seo_keywords'              => $request->input('seo_keywords'),
                    'updated_by'                => session('user')->adminid ?? 0,
                    'updated_date'              => now(),
                ];
                DB::table('tbl_contents')->where('content_id', $id)->update($data);

                DB::commit();
                return redirect()->back()->with('success', 'CMS updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            if($id > 0){
                $query = DB::table('tbl_contents')
                ->select('content_id', 'page_name', 'page_content', 'seo_title', 'seo_description', 'seo_keywords')
                ->where('content_id', $id)
                ->where('bit_Deleted_Flag', 0);
            }else{
                $query = DB::table('tbl_contents')
                ->select('content_id', 'page_name', 'page_content', 'seo_title', 'seo_description', 'seo_keywords')
                ->where('content_id', 1)
                ->where('bit_Deleted_Flag', 0);
            }

            $contentDataById = $query->first();
        }
        

        return view('admin.managecms.managecms', ['contentData' => $contentData, 'contentDataById' =>  $contentDataById]);
    }
}