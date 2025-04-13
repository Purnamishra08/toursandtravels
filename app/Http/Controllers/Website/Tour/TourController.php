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
    public function allTourPlacePackages($slug){
        $placesData = DB::table('tbl_places')
        ->select('placeid','place_name','pckg_meta_title','pckg_meta_keywords','pckg_meta_description')
        ->where('place_url', $slug)
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->first();
        if(count((array)$placesData) > 0){
            $tours = DB::table('tbl_tourpackages as a')
            ->join('tbl_itinerary_daywise as d', 'd.package_id', '=', 'a.tourpackageid')
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
            ->whereRaw('FIND_IN_SET(?, d.place_id)', [$placesData->placeid ?? 0])
            ->where('a.bit_Deleted_Flag', 0)
            ->where('d.bit_Deleted_Flag', 0)
            ->where('a.status', 1)
            ->get();
            $countAndPrice = DB::table('tbl_itinerary_daywise as a')
            ->join('tbl_tourpackages as b', 'a.package_id', '=', 'b.tourpackageid')
            ->selectRaw('COUNT(b.tourpackageid) as total_packages, MIN(b.price) as min_price')
            ->whereRaw('FIND_IN_SET(?, a.place_id)', [$placesData->placeid ?? 0])
            ->where('b.status', 1)
            ->where('a.bit_Deleted_Flag',0)
            ->where('b.bit_Deleted_Flag', 0)
            ->first();
        }
        return view('website.tourplacelisting', ['tours' => $tours, 'placesData' => $placesData, 'countAndPrice' => $countAndPrice])->with([
            'meta_title' => $placesData->pckg_meta_title,
            'meta_description' => $placesData->pckg_meta_description,
            'meta_keywords' => $placesData->pckg_meta_keywords
        ]);
    }
    public function tourDetails1($slug){

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
                    
        $itinerary = DB::table('tbl_itinerary_daywise')
                ->where('package_id',$tour->tourpackageid)
                ->where('bit_Deleted_Flag',0)
                ->get();

        $places = DB::table('tbl_places')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('place_name', 'asc')
                ->get();

        $packageAccomodations = DB::table('tbl_package_accomodation')
                ->where('package_id',$tour->tourpackageid)
                ->where('bit_Deleted_Flag',0)
                ->get();
        // dd($packageAccomodations);
        $hotelsType = DB::table('tbl_hotel_type')
                ->where('status',1)
                ->where('bit_Deleted_Flag',0)
                ->get();

        $destinations = DB::table('tbl_destination')
                ->where('status',1)
                ->where('bit_Deleted_Flag',0)
                ->get();

        $bookingPolicys = DB::table('tbl_parameters')
                ->select('par_value')
                ->where('parid', 21)
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->first();

        //Other Tours
        $get_pkg_tag = DB::table('tbl_tags')
            ->select('tagid')
            ->where('type_id', $tour->tourpackageid)
            ->where('type', 3)
            ->where('bit_Deleted_Flag', 0)
            ->orderByRaw('RAND()')
            ->get();

        if ($get_pkg_tag->count() > 0) {
            foreach ($get_pkg_tag as $row) {
                $tagid = $row->tagid;

                $noof_package = DB::table('tbl_tags')
                    ->select(DB::raw('DISTINCT(type_id) as packageid'))
                    ->where('type', 3)
                    ->where('tagid', $tagid)
                    ->where('type_id', '!=', $tour->tourpackageid)
                    ->where('bit_Deleted_Flag', 0)
                    ->count();

                if ($noof_package > 0) {
                    $tagid;
                }
            }
        }

        $tourpackageid = $tour->tourpackageid;
        $tour_packages = DB::table('tbl_tourpackages as a')
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
                ->whereIn('a.tourpackageid', function ($query) use ($tagid, $tourpackageid) {
                    $query->select(DB::raw('DISTINCT(type_id)'))
                        ->from('tbl_tags')
                        ->where('type', 3)
                        ->where('tagid', $tagid)
                        ->whereNotIn('type_id', [$tourpackageid]);
                })
                ->where('a.status', 1)
                ->where('c.status', 1)
                ->get();

        $tag_name = DB::table('tbl_menutags')
            ->where('tagid', $tagid)
            ->value('tag_name');
        return view('website.tourdetails',['tours'=>$tour,'meta_title'=>$tour->meta_title,'meta_description'=>$tour->meta_description,'meta_keywords'=>$tour->meta_keywords,'itinerary'=>$itinerary,'places'=>$places,'packageAccomodations'=>$packageAccomodations,'hotelsType'=>$hotelsType,'destinations'=> $destinations,'bookingPolicys'=>$bookingPolicys,'tour_packages'=>$tour_packages,'tag_name'=>$tag_name]);
    }
    public function tourDetails($slug)
    {
        $tour = DB::table('tbl_tourpackages as a')
            ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
            ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
            ->where('a.bit_Deleted_Flag', 0)
            ->where('a.status', 1)
            ->where('a.tpackage_url', $slug)
            ->select('a.*', 'b.destination_name', 'c.duration_name')
            ->first();

        if (!$tour) {
            abort(404);
        }

        $tourpackageid = $tour->tourpackageid;

        // Fetch all related data in batch
        $itinerary = DB::table('tbl_itinerary_daywise')
            ->where('package_id', $tourpackageid)
            ->where('bit_Deleted_Flag', 0)
            ->get();

        $placeIds = $itinerary->pluck('place_id')
            ->flatMap(fn ($ids) => explode(',', $ids))
            ->unique()
            ->filter();

        $places = DB::table('tbl_places')
            ->whereIn('placeid', $placeIds)
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get()
            ->keyBy('placeid');

        $packageAccomodations = DB::table('tbl_package_accomodation')
            ->where('package_id', $tourpackageid)
            ->where('bit_Deleted_Flag', 0)
            ->get();

        $destinationIds = $packageAccomodations->pluck('destination_id')->unique();

        $destinations = DB::table('tbl_destination')
            ->whereIn('destination_id', $destinationIds)
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get()
            ->keyBy('destination_id');

        $hotelsType = DB::table('tbl_hotel_type')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get()
            ->keyBy('hotel_type_id');

        $hotels = DB::table('tbl_hotel')
            ->whereIn('destination_name', $destinationIds)
            ->where('bit_Deleted_Flag', 0)
            ->get()
            ->groupBy('destination_name');

        $bookingPolicys = DB::table('tbl_parameters')
            ->select('par_value')
            ->where('parid', 21)
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->first();

        $reviewsTag = DB::table('tbl_tags')
            ->where('type', 3)
            ->where('type_id', $tourpackageid)
            ->where('bit_Deleted_Flag', 0)
            ->distinct()
            ->pluck('tagid');

        $reviews = DB::table('tbl_reviews')
            ->select('review_id','tourtagid','reviewer_name','reviewer_loc','no_of_star','feedback_msg')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->where(function ($query) use ($reviewsTag) {
                foreach ($reviewsTag as $tagid) {
                    $query->orWhere('tourtagid', 'LIKE', "%$tagid%");
                }
            })
            ->orderByDesc('review_id')
            ->get();
        // Get a random related tag
        $tagRow = DB::table('tbl_tags')
            ->select('tagid')
            ->where('type_id', $tourpackageid)
            ->where('type', 3)
            ->where('bit_Deleted_Flag', 0)
            ->inRandomOrder()
            ->first();

        $tagid = $tagRow->tagid ?? null;

        // Fetch similar packages
        $tour_packages = [];
        $tag_name = '';

        if ($tagid) {
            $relatedIds = DB::table('tbl_tags')
                ->where('type', 3)
                ->where('tagid', $tagid)
                ->where('type_id', '!=', $tourpackageid)
                ->where('bit_Deleted_Flag', 0)
                ->distinct()
                ->pluck('type_id');

            if ($relatedIds->isNotEmpty()) {
                $tour_packages = DB::table('tbl_tourpackages as a')
                    ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
                    ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
                    ->whereIn('a.tourpackageid', $relatedIds)
                    ->where('a.status', 1)
                    ->where('c.status', 1)
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
                        'c.duration_name'
                    )
                    ->get();

                $tag_name = DB::table('tbl_menutags')
                    ->where('tagid', $tagid)
                    ->value('tag_name');
            }
        }

        return view('website.tourdetails', [
            'tours' => $tour,
            'meta_title' => $tour->meta_title,
            'meta_description' => $tour->meta_description,
            'meta_keywords' => $tour->meta_keywords,
            'itinerary' => $itinerary,
            'places' => $places,
            'packageAccomodations' => $packageAccomodations,
            'hotelsType' => $hotelsType,
            'destinations' => $destinations,
            'hotels' => $hotels,
            'bookingPolicys' => $bookingPolicys,
            'tour_packages' => $tour_packages,
            'tag_name' => $tag_name,
            'reviews' => $reviews,
        ]);
    }

}
