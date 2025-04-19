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

        //Calculation Part
        $starting_city = $tour->starting_city ? $tour->starting_city:0;

        $noof_vehicle = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->where('a.destination', $starting_city)
            ->where('a.status', 1)
            ->count('a.priceid');

        $max_vehicle_capacity = 0;
        if ($noof_vehicle > 0) {
            $max_vehicle_capacity = DB::table('tbl_vehicleprices as a')
                ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
                ->where('a.destination', $starting_city)
                ->where('a.status', 1)
                ->max('b.capacity');
        }

        $getVehicleDropDown = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->select('b.vehicle_name', 'b.vehicleid')
            ->where('a.destination', $starting_city)
            ->where('a.status', 1)
            ->orderBy('b.capacity', 'asc')
            ->get();

        
        $accommodation_types = DB::table('tbl_hotel as a')
            ->select(DB::raw('DISTINCT(a.hotel_type) as hotel_type_id'))
            ->join('tbl_hotel_type as b', 'a.hotel_type', '=', 'b.hotel_type_id')
            ->where('a.status', 1)
            ->whereIn('a.destination_name', function ($query) use ($tourpackageid) {
                $query->select('destination_id')
                    ->from('tbl_package_accomodation')
                    ->where('package_id', $tourpackageid);
            })
            ->orderByDesc('b.hotel_type_name')
            ->get();

        $hotel_typeids = [];
        if (!$accommodation_types->isEmpty()) {
            foreach ($accommodation_types as $accommodation_type) {
                $hotel_typeids[] = $accommodation_type->hotel_type_id;
            }
            $hotel_typeid = implode(",", $hotel_typeids);
            $first_hoteltype = $hotel_typeids[0];
        }

        $hotelsTypeDropDown = DB::table('tbl_hotel_type')
            ->select('hotel_type_id', 'hotel_type_name')
            ->whereIn('hotel_type_id', $hotel_typeids) // ✅ Use the array, not the string
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get();


        $parameters =  DB::table('tbl_parameters')
            ->select('parameter', 'par_value', 'parid')
            ->where('param_type', 'CS')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get();

        $tourFaqs = DB::table('tbl_package_faqs')
            ->select('faq_id','faq_question','faq_answer')
            ->where('tag_id', $tagid)
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->orderby('faq_order','ASC')
            ->get();
// dd($tourFaqs);
        
        // dd($hotel_typeids,$hotel_typeid,
        //     $hotelsTypeDropDown);
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
            //Calculation
            'noof_vehicle' => $noof_vehicle,
            'max_vehicle_capacity' => $max_vehicle_capacity,
            'hotelsTypeDropDown' => $hotelsTypeDropDown,
            'getVehicleDropDown' => $getVehicleDropDown,
            'tourpackageid' => $tourpackageid,
            //contactus
            'parameters'=>$parameters,
            //tourFaqs
            'tourFaqs'=>$tourFaqs
        ]);
    }

}
