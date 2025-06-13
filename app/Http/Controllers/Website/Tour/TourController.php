<?php

namespace App\Http\Controllers\Website\Tour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class TourController extends Controller
{
    public function allTourPackages(Request $request){

        $tourPageData = DB::table('tbl_menutags')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->first();
            $tours = DB::table('tbl_tourpackages as a')
                    ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
                    ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
                    ->select(
                        'a.tourpackageid',
                        'a.tpackage_name',
                        'a.tpackage_url',
                        'a.price',
                        'a.fakeprice',
                        'a.about_package',
                        'a.tpackage_image',
                        'a.tour_thumb',
                        'a.tour_details_img',
                        'a.alttag_thumb',
                        'a.ratings',
                        'a.pack_type',
                        'b.destination_id',
                        'b.destination_name',
                        'c.duration_name'
                    )
                    ->where('a.bit_Deleted_Flag', 0)
                    // ->where('a.pack_type', 15)
                    ->where('a.status', 1);

        // Apply filters
        if ($request->has('durations') && is_array($request->durations)) {
            $tours->whereIn('a.package_duration', $request->durations);
        }

        if ($request->has('startingCities') && is_array($request->startingCities)) {
            $tours->whereIn('a.starting_city', $request->startingCities);
        }

        $tours = $tours->get();
        $tourCount = DB::table('tbl_tourpackages')->where('bit_Deleted_Flag', 0)->where('status', 1)->count();
        $tourPackageIds = $tours->pluck('tourpackageid');
        $durations = DB::table('tbl_package_duration as d')
            ->select('d.durationid', 'd.duration_name')
            ->join('tbl_tourpackages as t', 't.package_duration', '=', 'd.durationid')
            ->whereIn('t.tourpackageid', $tourPackageIds)
            ->where('d.bit_Deleted_Flag', 0)
            ->where('d.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->groupBy('d.durationid', 'd.duration_name')
            ->get();

        $destinations = DB::table('tbl_destination as dest')
            ->select('dest.destination_id', 'dest.destination_name')
            ->join('tbl_tourpackages as t', 't.starting_city', '=', 'dest.destination_id')
            ->whereIn('t.tourpackageid', $tourPackageIds)
            ->where('dest.bit_Deleted_Flag', 0)
            ->where('dest.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->groupBy('dest.destination_id', 'dest.destination_name')
            ->get();

        if ($request->ajax()) {
            $html = '';
            foreach ($tours as $values) {

                $accommodationDestIds = DB::table('tbl_package_accomodation')
                            ->where('package_id', $values->tourpackageid)
                            ->where('bit_Deleted_Flag', 0)
                            ->pluck('destination_id');

                $hotelType = DB::table('tbl_hotel as a')
                    ->join('tbl_hotel_type as b', 'a.hotel_type', '=', 'b.hotel_type_id')
                    ->select('b.hotel_type_name')
                    ->whereIn('a.destination_name', $accommodationDestIds)
                    ->where('a.status', 1)
                    ->where('a.bit_Deleted_Flag', 0)
                    ->orderByDesc('a.hotel_type')
                    ->first();
                $hotelType = !empty($hotelType->hotel_type_name) ? $hotelType->hotel_type_name : "No Hotel";

                $itinerary = DB::table('tbl_itinerary_daywise')
                    ->where('package_id', $values->tourpackageid)
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
                    ->limit(3)
                    ->get()
                    ->keyBy('placeid');

                $html .= '
                <div class="card tour-listing-card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4 col-lg-4">
                            <img loading="lazy" class="place-img" src="' . asset('storage/tourpackages/thumbs/' . $values->tour_thumb) . '" alt="' . $values->alttag_thumb . '">
                        </div>
                    <div class="col-md-8 col-lg-8">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-item-center flex-wrap">
                                <h3 class="card-title">'.$values->tpackage_name.'</h3>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="text-warning fs-4">★</span>
                                    <span class="text-secondary">'.$values->ratings.' Star</span>
                                </div>';
                    if($values->pack_type==15){
                        $html.='<span class="badge">Most popular</span>';
                    }
                    
                    $html.='</div>';
                    if(!empty($values->about_package)){
                        $html.='<p class="card-text mb-2">'.$values->about_package.'</p>';
                    }
                    $html.='
                        <ul class="m-0 d-flex gx-3 gy-2 flex-wrap text-secondary mb-3">
                            <li><i class="bi bi-clock me-1"></i> '.str_replace('/', '&', $values->duration_name).' </li>
                            <li> <i class="bi bi-geo-alt me-1"></i>Ex- '.$values->destination_name.'</li>
                            <li><i class="bi bi-house me-1"></i>'.$hotelType.'</li>
                            <!--<li><i class="bi bi-signpost-split me-1"></i> Adventure</li> -->
                        </ul>
                        <div class="d-flex gap-3 mb-3 align-items-center">
                            <span class="title"> <i class="bi bi-geo-alt me-1"></i>Places:</span>
                            <ul class="m-0 d-flex gx-3 gy-2 flex-wrap text-secondary">';
                            if(count($places)>0){
                            foreach ($places as $value) {
                                $html.=' <li class="light-badge"> '.$value->place_name.' </li>';

                            }
                        }
                            $html.=' </ul>
                        </div>
                        <!--<div class="d-flex gap-3 mb-3 align-items-center">
                            <span class="title"><i class="bi bi-activity me-1"></i> Activity</span>
                            <ul class="m-0 d-flex gx-3 gy-2 flex-wrap text-secondary">
                                <li class="primary-badge">
                                    Trekking or Hiking
                                </li>
                                <li class="primary-badge">River Rafting</li>
                                <li class="primary-badge"><i class="bi bi-home"></i> Ziplining</li>
                                <li class="primary-badge"><i class="bi bi-signpost-split"></i> Scuba Diving / Snorkeling</li>
                            </ul>
                        </div>-->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="p-card-info">
                                <h4 class="mb-0">&#x20b9;'.(int)$values->price.' </h4>
                                <strike>&#x20b9; '.(int)$values->fakeprice.'</strike>
                            </div>
                            <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary stretched-link">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        }
            return $html;
        }

        $tourFaqs = DB::table('tbl_package_faqs')
            ->select('faq_id','faq_question','faq_answer')
            ->where('tag_id', $tourPageData->tagid)
            ->where('faq_type', 1)
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->orderby('faq_order','ASC')
            ->get();

        $reviews = DB::table('tbl_reviews as r')
            ->leftJoin('tbl_menutags as t', DB::raw('FIND_IN_SET(t.tagid, r.tourtagid)'), '>', DB::raw('0'))
            ->select(
                'r.review_id',
                'r.tourtagid',
                'r.reviewer_name',
                'r.reviewer_loc',
                'r.no_of_star',
                'r.feedback_msg',
                'r.status',
                'r.updated_date',
                DB::raw("GROUP_CONCAT(DISTINCT t.tag_name ORDER BY t.tag_name SEPARATOR ', ') AS tag_name")
            )
            ->where('r.bit_Deleted_Flag', 0)
            ->where('r.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->inRandomOrder()
            ->groupBy('r.review_id', 'r.tourtagid', 'r.reviewer_name', 'r.reviewer_loc', 'r.no_of_star', 'r.feedback_msg', 'r.status', 'r.updated_date')
            ->get();

        //  Product schemas
        $productSchemas = [];
        foreach ($tours as $tour) {
            $productSchemas[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $tour->tpackage_name,
                "image" => [asset('storage/tourpackages/details/' . $tour->tour_details_img)],
                "description" => Str::limit(strip_tags(html_entity_decode($tour->about_package)), 160),
                // "brand" => [
                //     "@type" => "Organization",
                //     "name" => "coorgpackages.com"
                // ],
                "aggregateRating" => [
                    "@type" => "AggregateRating",
                    "ratingValue" => number_format($tour->ratings ?? 4.5, 1),
                    "reviewCount" => (int)($tour->review_count ??  mt_rand(100, 200))
                ],
                "offers" => [
                    "@type" => "Offer",
                    "url" => url('/' . $tour->tpackage_url),
                    "priceCurrency" => "INR",
                    "price" => (string)(int)$tour->price,
                    "availability" => "https://schema.org/InStock",
                    "validFrom" => date('Y-m-d'),
                    "priceValidUntil" => now()->addDays(3)->toDateString()
                ]
            ];
        }


        $faqSchema = [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $tourFaqs->map(function ($faq) {
                return [
                    "@type" => "Question",
                    "name" => strip_tags($faq->faq_question),
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => strip_tags($faq->faq_answer)
                    ]
                ];
            })->toArray()
        ];

        return view('website.tourlisting',['tourPageData'=>$tourPageData,'meta_title'=>$tourPageData->meta_title,'meta_keywords'=>$tourPageData->meta_keywords,'meta_description'=>$tourPageData->meta_description,'durations'=>$durations,'destinations'=>$destinations,'tourFaqs'=>$tourFaqs,'reviews'=>$reviews,'tourCount'=>$tourCount,'productSchemas' => $productSchemas,'faqSchemas'=>$faqSchema]);
    }

    public function allTourPlacePackages(Request $request,$slug){
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
                        'a.about_package',
                        'a.tpackage_image',
                        'a.tour_details_img',
                        'a.about_package',
                        'a.tour_thumb',
                        'a.alttag_thumb',
                        'a.ratings',
                        'a.pack_type',
                        'b.destination_id',
                        'b.destination_name',
                        'c.duration_name'
                    )
            ->whereRaw('FIND_IN_SET(?, d.place_id)', [$placesData->placeid ?? 0])
            ->where('a.bit_Deleted_Flag', 0)
            ->where('d.bit_Deleted_Flag', 0)
            ->where('a.status', 1);

            // Apply filters
            if ($request->has('durations') && is_array($request->durations)) {
                $tours->whereIn('a.package_duration', $request->durations);
            }

            if ($request->has('startingCities') && is_array($request->startingCities)) {
                $tours->whereIn('a.starting_city', $request->startingCities);
            }

            $tours = $tours->get();
            $tourPackageIds = $tours->pluck('tourpackageid');
            $countAndPrice = DB::table('tbl_itinerary_daywise as a')
            ->join('tbl_tourpackages as b', 'a.package_id', '=', 'b.tourpackageid')
            ->selectRaw('COUNT(b.tourpackageid) as total_packages, MIN(b.price) as min_price')
            ->whereRaw('FIND_IN_SET(?, a.place_id)', [$placesData->placeid ?? 0])
            ->where('b.status', 1)
            ->where('a.bit_Deleted_Flag',0)
            ->where('b.bit_Deleted_Flag', 0)
            ->first();
        }

        $durations = DB::table('tbl_package_duration as d')
            ->select('d.durationid', 'd.duration_name')
            ->join('tbl_tourpackages as t', 't.package_duration', '=', 'd.durationid')
            ->whereIn('t.tourpackageid', $tourPackageIds)
            ->where('d.bit_Deleted_Flag', 0)
            ->where('d.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->groupBy('d.durationid', 'd.duration_name')
            ->get();

        $destinations = DB::table('tbl_destination as dest')
            ->select('dest.destination_id', 'dest.destination_name')
            ->join('tbl_tourpackages as t', 't.starting_city', '=', 'dest.destination_id')
            ->whereIn('t.tourpackageid', $tourPackageIds)
            ->where('dest.bit_Deleted_Flag', 0)
            ->where('dest.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->groupBy('dest.destination_id', 'dest.destination_name')
            ->get();
        if ($request->ajax()) {
            $html = '';
            foreach ($tours as $values) {

                $accommodationDestIds = DB::table('tbl_package_accomodation')
                            ->where('package_id', $values->tourpackageid)
                            ->where('bit_Deleted_Flag', 0)
                            ->pluck('destination_id');

                $hotelType = DB::table('tbl_hotel as a')
                    ->join('tbl_hotel_type as b', 'a.hotel_type', '=', 'b.hotel_type_id')
                    ->select('b.hotel_type_name')
                    ->whereIn('a.destination_name', $accommodationDestIds)
                    ->where('a.status', 1)
                    ->where('a.bit_Deleted_Flag', 0)
                    ->orderByDesc('a.hotel_type')
                    ->first();
                $hotelType = !empty($hotelType->hotel_type_name) ? $hotelType->hotel_type_name : "No Hotel";

                $itinerary = DB::table('tbl_itinerary_daywise')
                    ->where('package_id', $values->tourpackageid)
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
                    ->limit(3)
                    ->get()
                    ->keyBy('placeid');

                $html .= '
                <div class="card tour-listing-card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4 col-lg-4">
                            <img loading="lazy" class="place-img" src="' . asset('storage/tourpackages/thumbs/' . $values->tour_thumb) . '" alt="' . $values->alttag_thumb . '">
                        </div>
                    <div class="col-md-8 col-lg-8">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-item-center flex-wrap">
                                <h3 class="card-title">'.$values->tpackage_name.'</h3>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fa fa-star text-warning"></i>
                                    <span class="text-secondary">'.$values->ratings.' Star</span>
                                </div>';
                    if($values->pack_type==15){
                        $html.='<span class="badge">Most popular</span>';
                    }
                    
                    $html.='</div>';
                    if(!empty($values->about_package)){
                        $html.='<p class="card-text mb-2">'.$values->about_package.'</p>';
                    }
                    $html.='
                        <ul class="m-0 d-flex gx-3 gy-2 flex-wrap text-secondary mb-3">
                            <li><i class="bi bi-clock me-1"></i> '.str_replace('/', '&', $values->duration_name).' </li>
                            <li> <i class="bi bi-geo-alt me-1"></i>Ex- '.$values->destination_name.'</li>
                            <li><i class="bi bi-house me-1"></i>'.$hotelType.'</li>
                            <!--<li><i class="bi bi-signpost-split me-1"></i> Adventure</li> -->
                        </ul>
                        <div class="d-flex gap-3 mb-3 align-items-center">
                            <span class="title"> <i class="bi bi-geo-alt me-1"></i>Places:</span>
                            <ul class="m-0 d-flex gx-3 gy-2 flex-wrap text-secondary">';
                            if(count($places)>0){
                            foreach ($places as $value) {
                                $html.=' <li class="light-badge"> '.$value->place_name.' </li>';

                            }
                        }
                            $html.=' </ul>
                        </div>
                        <!--<div class="d-flex gap-3 mb-3 align-items-center">
                            <span class="title"><i class="bi bi-activity me-1"></i> Activity</span>
                            <ul class="m-0 d-flex gx-3 gy-2 flex-wrap text-secondary">
                                <li class="primary-badge">
                                    Trekking or Hiking
                                </li>
                                <li class="primary-badge">River Rafting</li>
                                <li class="primary-badge"><i class="bi bi-home"></i> Ziplining</li>
                                <li class="primary-badge"><i class="bi bi-signpost-split"></i> Scuba Diving / Snorkeling</li>
                            </ul>
                        </div>-->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="p-card-info">
                                <h4 class="mb-0"><span>₹ </span>'.(int)$values->price.' </h4>
                                <strike>₹ '.(int)$values->fakeprice.'</strike>
                            </div>
                            <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary stretched-link">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        }
            if($html==''){
                $html .= '<div class="text-center fw-bold py-4"><h1>No Package Found.</h1></div>';
            }
            return $html;
        }

        //  Product schemas
        $productSchemas = [];
        foreach ($tours as $tour) {
            $productSchemas[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $tour->tpackage_name,
                "image" => [asset('storage/tourpackages/details/' . $tour->tour_details_img)],
                "description" => Str::limit(strip_tags(html_entity_decode($tour->about_package)), 160),
                // "brand" => [
                //     "@type" => "Organization",
                //     "name" => "coorgpackages.com"
                // ],
                "aggregateRating" => [
                    "@type" => "AggregateRating",
                    "ratingValue" => number_format($tour->ratings ?? 4.5, 1),
                    "reviewCount" => (int)($tour->review_count ??  mt_rand(100, 200))
                ],
                "offers" => [
                    "@type" => "Offer",
                    "url" => url('/' . $tour->tpackage_url),
                    "priceCurrency" => "INR",
                    "price" => (string)(int)$tour->price,
                    "availability" => "https://schema.org/InStock",
                    "validFrom" => date('Y-m-d'),
                    "priceValidUntil" => now()->addDays(3)->toDateString()
                ]
            ];
        }

        return view('website.tourplacelisting', ['productSchemas'=>$productSchemas,'slug'=>$slug,'tours' => $tours, 'placesData' => $placesData, 'countAndPrice' => $countAndPrice,'durations'=>$durations,'destinations'=>$destinations])->with([
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

            $durationId = request('duration');
            $destinationId = request('destination');
            if ($relatedIds->isNotEmpty()) {
                $tour_packages = DB::table('tbl_tourpackages as a')
                    ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
                    ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
                    ->whereIn('a.tourpackageid', $relatedIds)
                    ->where('a.status', 1)
                    ->where('b.status', 1)
                    ->where('c.status', 1)
                    ->where('a.bit_Deleted_Flag',0)
                    ->where('b.bit_Deleted_Flag',0)
                    ->where('c.bit_Deleted_Flag',0)
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
                    );

                if ($durationId && $durationId != 0) {
                    $tour_packages->where('a.package_duration', $durationId);
                }
                if ($destinationId && $destinationId != 0) {
                    $tour_packages->where('a.starting_city', $destinationId);
                }
                $tour_packages=$tour_packages->get();
                $tourPackageIds = $tour_packages->pluck('tourpackageid');
                $tag_name = DB::table('tbl_menutags')
                    ->where('tagid', $tagid)
                    ->where('status',1)
                    ->where('bit_Deleted_Flag',0)
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
                ->select(DB::raw('DISTINCT a.hotel_type as hotel_type_id'), 'b.hotel_type_name')
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


            $durations = DB::table('tbl_package_duration as d')
            ->select('d.durationid', 'd.duration_name')
            ->join('tbl_tourpackages as t', 't.package_duration', '=', 'd.durationid')
            ->whereIn('t.tourpackageid', $tourPackageIds)
            ->where('d.bit_Deleted_Flag', 0)
            ->where('d.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->groupBy('d.durationid', 'd.duration_name')
            ->get();

        $destinations = DB::table('tbl_destination as dest')
            ->select('dest.destination_id', 'dest.destination_name')
            ->join('tbl_tourpackages as t', 't.starting_city', '=', 'dest.destination_id')
            ->whereIn('t.tourpackageid', $tourPackageIds)
            ->where('dest.bit_Deleted_Flag', 0)
            ->where('dest.status', 1)
            ->where('t.bit_Deleted_Flag', 0)
            ->where('t.status', 1)
            ->groupBy('dest.destination_id', 'dest.destination_name')
            ->get();

        if (request()->ajax()) {
            $html = view('website.tourdetails', [
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
                'noof_vehicle' => $noof_vehicle,
                'max_vehicle_capacity' => $max_vehicle_capacity,
                'hotelsTypeDropDown' => $hotelsTypeDropDown,
                'getVehicleDropDown' => $getVehicleDropDown,
                'tourpackageid' => $tourpackageid,
                'parameters' => $parameters,
                'tourFaqs' => $tourFaqs,
                'durations' => $durations,
                'destinations' => $destinations
            ])->render();
            return response()->json(['html' => $html]);
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
            //Calculation
            'noof_vehicle' => $noof_vehicle,
            'max_vehicle_capacity' => $max_vehicle_capacity,
            'hotelsTypeDropDown' => $hotelsTypeDropDown,
            'getVehicleDropDown' => $getVehicleDropDown,
            'tourpackageid' => $tourpackageid,
            //contactus
            'parameters'=>$parameters,
            //tourFaqs
            'tourFaqs'=>$tourFaqs,
            //filter
            'durations'=>$durations,
            'destinations'=>$destinations
        ]);
    }
    
    public function submitInquiry(Request $request)
    {
        $type = $request->has('type') ? 1 : 2;

        if($type==2){
            // Recaptcha verification
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                'response' => $recaptchaResponse,
            ]);

            if (!$googleResponse->json('success')) {
                return response()->json([
                    'errors' => ['recaptcha' => ['Captcha validation failed. Please try again.']]
                ], 422);
            }
        }
        

        // Validation
        $request->validate([
            'first_name' => 'required|string|max:200',
            'last_name' => 'nullable|string|max:200',
            'email' => 'nullable|email|max:250',
            'mobile' => 'required|string|max:20',
            'message' => 'nullable|string',
            'adult_count' => 'nullable|integer|min:0',
            'child_count' => 'nullable|integer|min:0',
            'travel_date' => 'required',
            'accommodation' => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {
            // Insert into DB
            DB::table('tbl_package_inquiry')->insert([
                'type'             => $type,
                'first_name'       => $request->first_name,
                'last_name'        => $request->last_name,
                'emailid'          => $request->email,
                'phone'            => $request->mobile,
                'message'          => $request->message,
                'noof_adult'       => $request->adult_count,
                'noof_child'       => $request->child_count,
                'tour_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $request->travel_date))),
                'accomodation'     => $request->accommodation,
                'packageid'        => $request->package_id,
                'inquiry_date'     => now(),
                'bit_Deleted_Flag' => 0,
            ]);

            // Get email parameters
            $parameters = DB::table('tbl_parameters')
                ->select('parameter', 'par_value', 'parid')
                ->where('param_type', 'CS')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();

            $fromEmail = $parameters->firstWhere('parid', 9)->par_value ?? null;
            $toEmail = $parameters->firstWhere('parid', 2)->par_value ?? null;

            // Fetch package and accommodation names
            $package = DB::table('tbl_tourpackages')->select('tpackage_name','tpackage_url')->where('tourpackageid', $request->package_id)->first();
            $accommodation = DB::table('tbl_hotel_type')->select('hotel_type_name')->where('hotel_type_id', $request->accommodation)->first();

            $tourName = $package->tpackage_name ?? 'N/A';
            $tourUrl = route('website.tourDetails', ['slug' => $package->tpackage_url]); // assuming $package is available
            $accommodationName = $accommodation->hotel_type_name ?? 'N/A';
            $userEmail = $request->email;
            $logoUrl = asset('assets/img/logo.png');

            // Prepare user email
            $userMessage = '
            <div style="font-family: Arial, sans-serif; border:1px solid #eee; padding:20px; max-width:600px; margin:auto;">
                <div style="text-align:center; margin-bottom:20px;">
                    <a href="'.url('/').'"><img src="' . $logoUrl . '" alt="My Holiday Happiness Logo" style="max-height:80px;"></a>
                </div>
                <h2 style="color:#0d6efd;">Greetings from My Holiday Happiness (MHH)</h2>
                <p>Dear ' . $request->first_name . ',</p>
                <p>Thank you for reaching out to us. We are pleased to inform you that we have received your ' . ($type == 1 ? 'booking' : 'itinerary') . ' enquiry.</p>
                <p>One of our travel executives will review your request and share the complete details of your travel plan within the next 6-8 hours.</p>
                <p><strong>Tour Name:</strong> ' . $tourName . '</p>
                <p><strong>Accommodation:</strong> ' . $accommodationName . '</p>
                <p>For urgent assistance, feel free to call us at <strong>+91 98865 25253</strong>.</p>
                <br>
                <p>Warm regards,<br><strong>Team My Holiday Happiness</strong></p>
            </div>';

            // Prepare admin email
            $adminMessage = '
            <div style="font-family: Arial, sans-serif; border:1px solid #eee; padding:20px; max-width:600px; margin:auto;">
                <div style="text-align:center; margin-bottom:20px;">
                    <img src="' . $logoUrl . '" alt="MHH Logo" style="max-height:80px;">
                </div>
                <h3 style="color:#dc3545;">New ' . ($type == 1 ? 'Booking' : 'Itinerary') . ' Enquiry Received</h3>
                <p><strong>Name:</strong> ' . $request->first_name . ' ' . $request->last_name . '</p>
                <p><strong>Email:</strong> ' . $userEmail . '</p>
                <p><strong>Mobile:</strong> ' . $request->mobile . '</p>
                <p><strong>Adults:</strong> ' . $request->adult_count . '</p>
                <p><strong>Children:</strong> ' . $request->child_count . '</p>
                <p><strong>Travel Date:</strong> ' . $request->travel_date . '</p>
                <p><strong>Accommodation:</strong> ' . $accommodationName . '</p>
                <p><strong>Tour Package:</strong> <a href="' . $tourUrl . '" target="_blank" style="color:#0d6efd; text-decoration:none;">' . $tourName . '</a></p>
                <p><strong>Message:</strong><br>' . nl2br($request->message) . '</p>
                <br>
            </div>
            ';

            // Send emails
            if ($userEmail) {
                $fromEmail = $parameters->firstWhere('parid', 9)->par_value ?? null;
                $toEmail = $userEmail;

                if (!$fromEmail || !$toEmail) {
                    throw
                        new \Exception("Missing email addresses in parameters table.");
                }
                $mail = new PHPMailer(true);
                //Server settings
                $mail->isSMTP();
                $mail->Host       = env('MAIL_HOST');
                $mail->SMTPAuth   = true;
                $mail->Username   = env('MAIL_USERNAME');
                $mail->Password   = env('MAIL_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587; // or 465 for SMTPS 2525
            
                //Recipients
                $mail->setFrom($fromEmail, 'Coorg Packages');
                $mail->addAddress($toEmail);
            
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Thank you for your enquiry - Coorg Packages';
                $mail->Body    = $userMessage;
            
                $mail->send();
            }
            $mailAdmin = new PHPMailer(true);
            //Server settings
            $mailAdmin->isSMTP();
            $mailAdmin->Host       = env('MAIL_HOST');
            $mailAdmin->SMTPAuth   = true;
            $mailAdmin->Username   = env('MAIL_USERNAME');
            $mailAdmin->Password   = env('MAIL_PASSWORD');
            $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailAdmin->Port       = 587; // or 465 for SMTPS 2525
        
            //Recipients
            $mailAdmin->setFrom($fromEmail, 'Coorg Packages');
            $mailAdmin->addAddress($fromEmail);
        
            // Content
            $mailAdmin->isHTML(true);
            $mailAdmin->Subject = 'New Tour ' . ($type == 1 ? 'Booking' : 'Itinerary') . ' Enquiry Received';
            $mailAdmin->Body    = $adminMessage;
        
            $mailAdmin->send();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Enquiry submitted successfully.']);
        } catch (\Exception $e) {dd($e);
            DB::rollBack();
            Log::error('Enquiry failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while submitting the enquiry. Please try again later.'], 500);
        }
    }

    // public function clientReviews(Request $request)
    // {
    //     $reviews = DB::table('tbl_reviews as r')
    //         ->leftJoin('tbl_menutags as t', DB::raw('FIND_IN_SET(t.tagid, r.tourtagid)'), '>', DB::raw('0'))
    //         ->select(
    //             'r.review_id',
    //             'r.tourtagid',
    //             'r.reviewer_name',
    //             'r.reviewer_loc',
    //             'r.no_of_star',
    //             'r.feedback_msg',
    //             'r.status',
    //             'r.updated_date',
    //             DB::raw("GROUP_CONCAT(DISTINCT t.tag_name ORDER BY t.tag_name SEPARATOR ', ') AS tag_name")
    //         )
    //         ->where('r.bit_Deleted_Flag', 0)
    //         ->where('r.status', 1)
    //         ->orderBy('r.review_id', 'DESC')
    //         ->groupBy('r.review_id', 'r.tourtagid', 'r.reviewer_name', 'r.reviewer_loc', 'r.no_of_star', 'r.feedback_msg', 'r.status', 'r.updated_date')
    //         // ->limit(6)
    //         ->get();

    //     if ($request->ajax()) {
    //         $html = '';
    //         foreach ($reviews as $values) {

    //             // Star rating generation
    //             $fullStars = floor($values->no_of_star);
    //             $halfStar = (fmod($values->no_of_star, 1) != 0.00) ? 1 : 0;
    //             $emptyStars = 5 - ($fullStars + $halfStar);

    //             $starsHtml = '';
    //             for ($i = 0; $i < $fullStars; $i++) {
    //                 $starsHtml .= '<i class="fa fa-star text-warning"></i> ';
    //             }
    //             if ($halfStar) {
    //                 $starsHtml .= '<i class="fa fa-star-half-stroke text-warning"></i> ';
    //             }
    //             for ($i = 0; $i < $emptyStars; $i++) {
    //                 $starsHtml .= '<i class="fa fa-star text-secondary"></i> ';
    //             }

    //             // Review card HTML
    //             $html .= '
    //                 <div class="swiper-slide">
    //                     <div class="card client-review-card h-100">
    //                         <div class="card-body">
    //                             <div class="client-details mb-2">
    //                                 <div class="d-flex gap-2 align-items-center">
    //                                     <i class="bi bi-person-circle"></i>
    //                                         <div>
    //                                             <p class="client-name">  ' . $values->reviewer_name . '</p>
    //                                             <div class="rate">' . $starsHtml . '</div>

    //                                         </div>

    //                                         </div>
    //                                         <p class="client-location text-secondary"><i class="fa-solid fa-location-dot"></i> ' . $values->reviewer_loc . '</p>
                                        
                                        
                                    
    //                             </div>
    //                             <p class="clent-message">' . $values->feedback_msg . '</p>
    //                         </div>
    //                     </div>
    //                 </div>';
    //         }
    //         return $html;
    //     }
    // }

}
