<?php

namespace App\Http\Controllers\Website\FooterQuickLinks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class FooterquicklinksController extends Controller
{
    public function allTourPackages(Request $request, $slug){
        $footers = DB::table('tbl_footer')
        ->selectRaw('int_footer_id, vch_Footer_Name, vch_Footer_URL, vch_Footer_Desc, tourpackageid, status, footer_meta_title, footer_meta_keywords, footer_meta_description, created_at, created_by, updated_at, updated_by, bit_Deleted_Flag')
        ->where('vch_Footer_URL', $slug)
        ->where('bit_Deleted_Flag', 0)
        ->where('status', 1)
        ->first();
        $tourpackageIds = explode(',', $footers->tourpackageid);
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
                        'a.tpackage_image',
                        'a.tour_details_img',
                        'a.about_package',
                        'a.tour_thumb',
                        'a.alttag_thumb',
                        'a.ratings',
                        'a.pack_type',
                        'b.destination_id',
                        'b.destination_name',
                        'c.duration_name',
                    )
                    ->where('a.bit_Deleted_Flag', 0)
                    // ->where('a.pack_type', 15)
                    ->where('a.status', 1)
                    ->whereIn('tourpackageid', $tourpackageIds);

        // Apply filters
        if ($request->has('durations') && is_array($request->durations)) {
            $tours->whereIn('a.package_duration', $request->durations);
        }

        if ($request->has('startingCities') && is_array($request->startingCities)) {
            $tours->whereIn('a.starting_city', $request->startingCities);
        }

        $tours = $tours->get();

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
                            <img class="place-img" src="' . asset('storage/tourpackages/thumbs/' . $values->tour_thumb) . '" alt="' . $values->alttag_thumb . '">
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
                    
                    $html.='</div>
                        <p class="card-text mb-2">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
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
            return $html;
        }

        $tourFaqs = DB::table('tbl_package_faqs')
            ->select('faq_id','faq_question','faq_answer')
            ->where('tag_id', $footers->int_footer_id)
            ->where('faq_type', 2)
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

        return view('website.tourlistingfooter',['productSchemas'=>$productSchemas,'faqSchemas'=>$faqSchema,'slug'=>$slug,'tourPageData'=>$tourPageData,'meta_title'=>$footers->footer_meta_title,'meta_keywords'=>$footers->footer_meta_keywords,'meta_description'=>$footers->footer_meta_description,'durations'=>$durations,'destinations'=>$destinations,'tourFaqs'=>$tourFaqs,'reviews'=>$reviews, 'footers' => $footers]);
    }

}
