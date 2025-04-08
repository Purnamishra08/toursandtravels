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
                        'a.tpackage_image',
                        'a.tour_thumb',
                        'a.alttag_thumb',
                        'a.ratings',
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
                    <img class="card-img-top" src="' . asset('storage/tourpackages/thumbs/' . $values->tour_thumb) . '" alt="' . $values->alttag_thumb . '">
                    <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> '.str_replace('/', '&', $values->duration_name).'</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="' . asset('assets/img/web-img/single-star.png') . '" alt="Rating">
                        <span class="text-secondary">'.$values->ratings.' Star</span>
                    </div>
                    <h5 class="card-title">'.$values->tpackage_name.'</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>₹ '.$values->price.' <span>Per Person</span></h6>
                        </div>
                        <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
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
        return view('website.tourdetails',['tours'=>$tour,'meta_title'=>$tour->meta_title,'meta_description'=>$tour->meta_description,'meta_keywords'=>$tour->meta_keywords,'itinerary'=>$itinerary]);
    }
}
