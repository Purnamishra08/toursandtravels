<?php
namespace App\Http\Controllers\Website\Places;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class PlaceController extends Controller{
    public function index($slug){
        $placesData = DB::table('tbl_places as p')
        ->selectRaw('p.placeid, p.destination_id, p.place_name, p.place_url, p.latitude, p.longitude, p.show_in_home, p.trip_duration, p.distance_from_nearest_city, p.placeimg, p.placethumbimg, p.alttag_banner, p.alttag_thumb, p.google_map, p.travel_tips, p.about_place, p.status, p.entry_fee, p.timing, p.rating, p.meta_title, p.meta_keywords, p.meta_description, p.pckg_meta_title, p.pckg_meta_keywords, p.pckg_meta_description, p.created_date, p.created_by, p.updated_date, p.updated_by, p.bit_Deleted_Flag, b.destination_name')
        ->join('tbl_destination as b', 'p.destination_id', '=', 'b.destination_id')
        ->where('place_url', $slug)
        ->where('p.status', 1)
        ->where('p.bit_Deleted_Flag', 0)
        ->first();

        $selectedDestinationTypes = DB::table('tbl_multdest_type')
        ->where('bit_Deleted_Flag', 0)
        ->where('loc_id', $placesData->placeid ?? 0)
        ->pluck('loc_type_id')
        ->toArray();
        $destinationTypes = '';
        if(!empty($selectedDestinationTypes)){
            $destinationTypes = DB::table('tbl_destination_type')
                    ->selectRaw('GROUP_CONCAT(destination_type_name ORDER BY destination_type_name ASC) as destination_type_names')
                    ->where('status', 1)
                    ->whereIn('destination_type_id', $selectedDestinationTypes)
                    ->where('bit_Deleted_Flag', 0)
                    ->first();
        }
        $parameters =  DB::table('tbl_parameters')
                ->select('parameter', 'par_value', 'parid')
                ->where('param_type', 'CS')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();
        $faqData = DB::table('tbl_faqs')
                ->selectRaw('faq_id, faq_question, faq_answer')
                ->where('bit_Deleted_Flag', 0)
                ->where('faq_type', 1)
                ->where('status', 1)
                ->orderBy('faq_order', 'ASC')
                ->limit(5)
                ->get();
        $reviewsData = DB::table('tbl_reviews')
                ->selectRaw('review_id, reviewer_name, reviewer_loc, no_of_star, feedback_msg')
                ->where('bit_Deleted_Flag', 0)
                ->where('status', 1)
                ->get();
        $countAndPrice = DB::table('tbl_itinerary_daywise as a')
                ->join('tbl_tourpackages as b', 'a.package_id', '=', 'b.tourpackageid')
                ->selectRaw('COUNT(b.tourpackageid) as total_packages, MIN(b.price) as min_price')
                ->whereRaw('FIND_IN_SET(?, a.place_id)', [$placesData->placeid ?? 0])
                ->where('b.status', 1)
                ->where('a.bit_Deleted_Flag', 0)
                ->where('b.bit_Deleted_Flag', 0)
                ->first();

        return view('website.neardestination', ['placesData' => $placesData, 'parameters' => $parameters, 'destinationTypes' => $destinationTypes, 'countAndPrice' => $countAndPrice, 'faqData' => $faqData, 'reviewsData' => $reviewsData])->with([
            'meta_title' => $placesData->meta_title,
            'meta_description' => $placesData->meta_description,
            'meta_keywords' => $placesData->meta_keywords
        ]);
    }

    public function popularTourDataPlaces(Request $request){

        $query = DB::table('tbl_tourpackages as a')
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
                    ->where('a.pack_type', 15)
                    ->where('a.status', 1);
        $popularTours = $query->inRandomOrder()->limit(6)->get();
        if ($request->ajax()) {
            $html = '';
            foreach ($popularTours as $values) {
                $html .= '
                <div class="card tour-card  wow animate__fadeInUp  " data-wow-delay="200ms">
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
                        
                            
                            <h6 class="mb-0"><span>₹ </span>'.(int)$values->price.' </h6>
                            <strike >₹ '.(int)$values->fakeprice.'</strike>
                        </div>
                        <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary stretched-link">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>';
            }
            return $html;
        }
    }

    public function allPlacesDataAsPerDestination(Request $request){
        $destinationId = $request->destination_id;
        $place_Id = $request->place_Id;
        $placesData = DB::table('tbl_places as p')
                    ->selectRaw('p.placeid, p.destination_id, p.place_name, p.place_url, p.latitude, p.longitude, p.trip_duration, p.distance_from_nearest_city, p.placeimg, p.placethumbimg, p.alttag_banner, p.alttag_thumb, p.google_map, p.travel_tips , p.about_place, p.entry_fee, p.timing, p.rating, p.status, p.meta_title, p.meta_keywords, p.meta_description, p.pckg_meta_title, p.pckg_meta_keywords, p.pckg_meta_description, p.show_in_home, b.destination_name')
                    ->join('tbl_destination as b', 'p.destination_id', '=', 'b.destination_id')
                    ->where('p.destination_id','=', $destinationId)
                    ->where('p.placeid', '!=', $place_Id)
                    ->where('p.bit_Deleted_Flag', '=', 0)
                    ->where('p.status', 1)
                    ->get();
        
        $html = '';
        $html .= '
            <h1 class="page-section-heading">' . count($placesData) . ' places to visit & things to do in '.$placesData[0]->destination_name.'</h1>
            <div class="near-destination-wrapper" id="placesDataAll">
        ';
        foreach ($placesData as $place) {
            $image = asset('storage/place_images/thumbs/' . $place->placethumbimg); // Adjust path as needed
            $html .= '
            <a href="' . route('website.neardestination', ['slug' => $place->place_url]) . '" class="card near-Dcard" target="_blank">
                <img src="' . $image . '" alt="' . e($place->alttag_thumb) . '">
                <div class="overlay">
                    <h2>' . e($place->place_name) . '</h2>
                </div>
            </a>';
        }

        return $html;
    }

    public function popularTourPlaces(Request $request){
        $place_Id = $request->place_Id;
        $popularTours = DB::table('tbl_itinerary_daywise as a')
                ->join('tbl_tourpackages as b', 'a.package_id', '=', 'b.tourpackageid')
                ->join('tbl_destination as c', 'b.starting_city', '=', 'c.destination_id')
                ->join('tbl_package_duration as d', 'b.package_duration', '=', 'd.durationid')
                ->select(
                    'b.tourpackageid',
                    'b.tpackage_name',
                    'b.tpackage_url',
                    'b.price',
                    'b.fakeprice',
                    'b.tpackage_image',
                    'b.tour_thumb',
                    'b.alttag_thumb',
                    'b.ratings',
                    'b.pack_type',
                    'c.destination_name',
                    'd.duration_name'
                )
                ->whereRaw('FIND_IN_SET(?, a.place_id)', [$place_Id])
                ->where('b.status', 1)
                ->where('b.bit_Deleted_Flag', 0)
                ->where('a.bit_Deleted_Flag', 0)
                ->get();
        if ($request->ajax()) {
            $html = '';
            foreach ($popularTours as $values) {
                $html .= '
                <div class="card tour-card  wow animate__fadeInUp  " data-wow-delay="200ms">
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
                        
                            
                            <h6 class="mb-0"><span>₹ </span>'.(int)$values->price.' </h6>
                            <strike >₹ '.(int)$values->fakeprice.'</strike>
                        </div>
                        <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary stretched-link" target="_blank" >Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>';
            }
            return $html;
        }
    }
}