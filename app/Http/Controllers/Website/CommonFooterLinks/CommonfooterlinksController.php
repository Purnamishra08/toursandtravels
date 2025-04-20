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
        $privacyPolicy = DB::table('tbl_contents')
                        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
                        ->where('content_id', 15)
                        ->where('bit_Deleted_Flag', 0)
                        ->first();

        $meta_title         =  isset($privacyPolicy) ? $privacyPolicy->seo_title : '';
        $meta_keywords      =  isset($privacyPolicy) ? $privacyPolicy->seo_keywords : '';
        $meta_description   =  isset($privacyPolicy) ? $privacyPolicy->seo_description : '';

        return view('website.privacy-policy', ['privacyPolicy' => $privacyPolicy])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }

    public function bookingpolicy(Request $request){
        $bookingPolicy = DB::table('tbl_contents')
        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
        ->where('content_id', 17)
        ->where('bit_Deleted_Flag', 0)
        ->first();

        $meta_title         =  isset($bookingPolicy) ? $bookingPolicy->seo_title : '';
        $meta_keywords      =  isset($bookingPolicy) ? $bookingPolicy->seo_keywords : '';
        $meta_description   =  isset($bookingPolicy) ? $bookingPolicy->seo_description : '';

        return view('website.booking-policy', ['bookingPolicy' => $bookingPolicy])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }

    public function termsConditions(Request $request){

        $termsConditions = DB::table('tbl_contents')
        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
        ->where('content_id', 16)
        ->where('bit_Deleted_Flag', 0)
        ->first();

        $meta_title         =  isset($termsConditions) ? $termsConditions->seo_title : '';
        $meta_keywords      =  isset($termsConditions) ? $termsConditions->seo_keywords : '';
        $meta_description   =  isset($termsConditions) ? $termsConditions->seo_description : '';

        return view('website.term-condition', ['termsConditions' => $termsConditions])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }
}