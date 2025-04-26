<?php
namespace App\Http\Controllers\Website\Faqs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class FaqsController extends Controller{
    public function index($slug){
        if(!empty($slug)){
            $faq_type = 0;
            if($slug == "common-faqs"){
                $faq_type = 1;
            }elseif($slug == "destination-faqs"){
                $faq_type = 2;
            }elseif($slug == "package-faqs"){
                $faq_type = 3;
            }else{
                $faq_type = 0;
            }
        }
        if($faq_type != 3){
            $Faq_Table_Name = 'tbl_faqs';
        }else{
            $Faq_Table_Name = 'tbl_package_faqs';
        }
        
        $data = DB::table($Faq_Table_Name)
        ->selectRaw('faq_id, faq_question, faq_answer')
        ->where('bit_Deleted_Flag', 0)
        ->where('status', 1)
        ->orderBy('faq_order', 'ASC');
        

        if($faq_type != 3){
            $data->where('faq_type', $faq_type);
        }

        $faqData = $data->get();

        $placesData = DB::table('tbl_destination as a')
        ->selectRaw('a.destination_id, a.destination_name, a.destination_url, a.latitude, a.longitude, a.state, a.trip_duration, a.nearest_city, a.visit_time, a.peak_season, a.weather_info, a.destiimg, a.destiimg_thumb, a.alttag_banner, a.alttag_thumb, a.google_map, a.about_destination, a.places_visit_desc, a.internet_availability, a.std_code, a.language_spoken, a.major_festivals, a.note_tips, a.destinationType, a.status, a.desttype_for_home, a.show_on_footer, a.pick_drop_price, a.accomodation_price, a.meta_title, a.meta_keywords, a.meta_description, a.created_date, a.created_by, a.updated_date, a.updated_by, a.place_meta_title, a.place_meta_keywords, a.place_meta_description, a.package_meta_title, a.package_meta_keywords, a.package_meta_description, a.bit_Deleted_Flag')
        ->where('a.bit_Deleted_Flag', '=', 0)
        ->where('a.status', 1)
        ->first();

        $parameters =  DB::table('tbl_parameters')
        ->select('parameter', 'par_value', 'parid')
        ->where('param_type', 'CS')
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->get();

        $faqmeta = DB::table('tbl_contents')
                        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
                        ->where('content_id', 6)
                        ->where('bit_Deleted_Flag', 0)
                        ->first();

        $meta_title         =  isset($faqmeta) ? $faqmeta->seo_title : '';
        $meta_keywords      =  isset($faqmeta) ? $faqmeta->seo_keywords : '';
        $meta_description   =  isset($faqmeta) ? $faqmeta->seo_description : '';

        return view('website.faq', ['faqData' => $faqData, 'parameters' => $parameters, 'placesData' => $placesData])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }
}