<?php

namespace App\Http\Controllers\Website\Tour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TourController extends Controller
{
    public function allTourPackages(Request $request){

        $tours = DB::table('tbl_tourpackages as a')
                    ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
                    ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
                    ->select(
                        'a.tourpackageid',
                        'a.tpackage_name',
                        'a.tpackage_url',
                        'a.price',
                        'a.fakeprice',
                        'a.tpackage_image',
                        'a.tour_thumb',
                        'a.alttag_thumb',
                        'a.ratings',
                        'a.pack_type',
                        'b.destination_name',
                        'c.duration_name',
                    )
                    ->where('a.bit_Deleted_Flag', 0)
                    // ->where('a.pack_type', 15)
                    ->where('a.status', 1)
                    ->get();

        if ($request->ajax()) {
            $html = '';
            foreach ($tours as $values) {

                
                $html .= '
                <div class="card tour-card">
                    <img class="card-img-top" src="' . asset('storage/tourpackages/thumbs/' . $values->tour_thumb) . '" alt="' . $values->alttag_thumb . '">';
                    if($values->pack_type==15){
                        $html.='<span class="badge">Most popular</span>';
                    }
                    $html.='<div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> '.str_replace('/', '&', $values->duration_name).'</span>
                        <small class="d-block">Ex- '.$values->destination_name.'</small>
                    </p>
                    
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="' . asset('assets/img/web-img/single-star.png') . '" alt="Rating">
                        <span class="text-secondary">'.$values->ratings.' Star</span>
                    </div>
                    <h5 class="card-title">'.$values->tpackage_name.'</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                        
                            
                            <h6 class="mb-0"><span>₹ </span>'.$values->price.' </h6>
                            <strike >₹ '.$values->fakeprice.'</strike>
                        </div>
                        <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary stretched-link">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>';
            }
            return $html;
        }
        return view('website.tourlisting');
    }
    public function tourDetails($slug){

        $tour = DB::table('tbl_tourpackages as a')
                    ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
                    ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
                    // ->select(
                    //     'a.tourpackageid',
                    //     'a.tpackage_name',
                    //     'a.tpackage_url',
                    //     'a.tpackage_code',
                    //     'a.fakeprice',
                    //     'a.price',
                    //     'a.tpackage_image',
                    //     'a.tour_thumb',
                    //     'a.alttag_thumb',
                    //     'a.ratings',
                    //     'b.destination_name',
                    //     'c.duration_name',
                    // )
                    ->where('a.bit_Deleted_Flag', 0)
                    ->where('a.tpackage_url', $slug)
                    // ->where('a.pack_type', 15)
                    ->where('a.status', 1)
                    ->first();
                    
        $itinerary = DB::table('tbl_itinerary_daywise')->where('package_id',$tour->tourpackageid)->where('bit_Deleted_Flag',0)->get();
        $places = DB::table('tbl_places')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('place_name', 'asc')
                ->get();
        $bookingPolicys=DB::table('tbl_parameters')
                ->select('par_value')
                ->where('parid', 21)
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->first();
        // $places = DB::table('tbl_places as p')
        //         ->join(DB::raw('
        //             (
        //                 SELECT DISTINCT 
        //                     TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(tid.place_id, \',\', numbers.n), \',\', -1)) AS place_id,
        //                     tid.package_id,
        //                     tid.itinerary_daywiseid
        //                 FROM (
        //                     SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
        //                     UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
        //                     UNION ALL SELECT 9 UNION ALL SELECT 10
        //                 ) numbers
        //                 JOIN tbl_itinerary_daywise tid 
        //                 ON CHAR_LENGTH(tid.place_id) - CHAR_LENGTH(REPLACE(tid.place_id, \',\', \'\')) >= numbers.n - 1
        //                 WHERE tid.package_id = '.$tour->tourpackageid.' AND tid.bit_Deleted_Flag = 0
        //             ) as used_places
        //         '), 'used_places.place_id', '=', 'p.placeid')
        //         ->select('p.placeid', 'p.place_name', 'used_places.package_id', 'used_places.itinerary_daywiseid')
        //         ->get();
        // dd($itinerary);
        return view('website.tourdetails',['tours'=>$tour,'meta_title'=>$tour->meta_title,'meta_description'=>$tour->meta_description,'meta_keywords'=>$tour->meta_keywords,'itinerary'=>$itinerary,'places'=>$places,'bookingPolicys'=>$bookingPolicys]);
    }
}
