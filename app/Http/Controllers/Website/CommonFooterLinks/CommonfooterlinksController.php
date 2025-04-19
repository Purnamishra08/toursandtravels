<?php
namespace App\Http\Controllers\Website\CommonFooterLinks;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class CommonfooterlinksController extends Controller{
    public function index(Request $request){
        $parameters =  DB::table('tbl_parameters')
        ->select('parameter', 'par_value', 'parid')
        ->where('param_type', 'CS')
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->get();

        $meta_title         =  isset($parameters) ? $parameters[10]->par_value : '';
        $meta_keywords      =  isset($parameters) ? $parameters[11]->par_value : '';
        $meta_description   =  isset($parameters) ? $parameters[12]->par_value : '';

        $privacyPolicy = DB::table('tbl_contents')
                        ->select('page_name','page_content')
                        ->where('content_id', 15)
                        ->where('bit_Deleted_Flag', 0)
                        ->first();
        return view('website.privacy-policy', ['privacyPolicy' => $privacyPolicy])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }

    public function bookingpolicy(Request $request){
        $parameters =  DB::table('tbl_parameters')
        ->select('parameter', 'par_value', 'parid')
        ->where('param_type', 'CS')
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->get();

        $meta_title         =  isset($parameters) ? $parameters[10]->par_value : '';
        $meta_keywords      =  isset($parameters) ? $parameters[11]->par_value : '';
        $meta_description   =  isset($parameters) ? $parameters[12]->par_value : '';

        $bookingPolicy = DB::table('tbl_contents')
        ->select('page_name','page_content')
        ->where('content_id', 17)
        ->where('bit_Deleted_Flag', 0)
        ->first();
        return view('website.booking-policy', ['bookingPolicy' => $bookingPolicy])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }

    public function termsConditions(Request $request){
        $parameters =  DB::table('tbl_parameters')
        ->select('parameter', 'par_value', 'parid')
        ->where('param_type', 'CS')
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->get();

        $meta_title         =  isset($parameters) ? $parameters[10]->par_value : '';
        $meta_keywords      =  isset($parameters) ? $parameters[11]->par_value : '';
        $meta_description   =  isset($parameters) ? $parameters[12]->par_value : '';

        $termsConditions = DB::table('tbl_contents')
        ->select('page_name','page_content')
        ->where('content_id', 16)
        ->where('bit_Deleted_Flag', 0)
        ->first();
        return view('website.term-condition', ['termsConditions' => $termsConditions])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }
}