<?php
namespace App\Http\Controllers\Website\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $parameters =  DB::table('tbl_parameters')
                    ->select('parameter', 'par_value', 'parid')
                    ->where('param_type', 'CS')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();
        $blogDataFooter = DB::table('tbl_blog')
                    ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->limit(6)
                    ->get();
        $footer =  DB::table('tbl_footer')
                    ->select('vch_Footer_Name', 'vch_Footer_URL', 'int_footer_id')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();
        return view('website.index', ['parameters' => $parameters, 'blogDataFooter' => $blogDataFooter, 'footer' => $footer]);
    }
}