<?php
namespace App\Http\Controllers\Website\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AboutusController extends Controller{
    public function index(Request $request){
        $aboutus = DB::table('tbl_contents')
        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
        ->where('content_id', 4)
        ->where('bit_Deleted_Flag', 0)
        ->first();
        
        $placesData = DB::table('tbl_destination as a')
        ->selectRaw('a.destination_id, a.destination_name, a.destination_url')
        ->where('a.bit_Deleted_Flag', '=', 0)
        ->where('a.status', 1)
        ->first();

        $meta_title         =  isset($aboutus) ? $aboutus->seo_title : '';
        $meta_keywords      =  isset($aboutus) ? $aboutus->seo_keywords : '';
        $meta_description   =  isset($aboutus) ? $aboutus->seo_description : '';

        return view('website.aboutus', ['aboutus' => $aboutus, 'placesData' => $placesData])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }
}