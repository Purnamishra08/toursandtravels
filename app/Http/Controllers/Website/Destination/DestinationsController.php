<?php
namespace App\Http\Controllers\Website\Destination;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class DestinationsController extends Controller{
    public function index($slug){
        $destinationData = DB::table('tbl_destination as a')
                    ->selectRaw('a.destination_id, a.destination_name, a.destination_url, a.latitude, a.longitude, a.state, a.trip_duration, a.nearest_city, a.visit_time, a.peak_season, a.weather_info, a.destiimg, a.destiimg_thumb, a.alttag_banner, a.alttag_thumb, a.google_map, a.about_destination, a.places_visit_desc, a.internet_availability, a.std_code, a.language_spoken, a.major_festivals, a.note_tips, a.destinationType, a.status, a.desttype_for_home, a.show_on_footer, a.pick_drop_price, a.accomodation_price, a.meta_title, a.meta_keywords, a.meta_description, a.created_date, a.created_by, a.updated_date, a.updated_by, a.place_meta_title, a.place_meta_keywords, a.place_meta_description, a.package_meta_title, a.package_meta_keywords, a.package_meta_description, a.bit_Deleted_Flag')
                    ->where('a.destination_url', '=', $slug)
                    ->where('a.bit_Deleted_Flag', '=', 0)
                    ->where('a.status', 1)
                    ->first();
        $placesData = DB::table('tbl_places as p')
                    ->selectRaw('p.placeid, p.destination_id, p.place_name, p.place_url, p.latitude, p.longitude, p.trip_duration, p.distance_from_nearest_city, p.placeimg, p.placethumbimg, p.alttag_banner, p.alttag_thumb, p.google_map, p.travel_tips , p.about_place, p.entry_fee, p.timing, p.rating, p.status, p.meta_title, p.meta_keywords, p.meta_description, p.pckg_meta_title, p.pckg_meta_keywords, p.pckg_meta_description, p.show_in_home')
                    ->where('p.destination_id','=', $destinationData->destination_id)
                    ->where('p.bit_Deleted_Flag', '=', 0)
                    ->where('p.status', 1)
                    ->get();
        $parameters =  DB::table('tbl_parameters')
                    ->select('parameter', 'par_value', 'parid')
                    ->where('param_type', 'CS')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();
        $countAndPrice = DB::table('tbl_tourpackages as a')
                    ->selectRaw('COUNT(a.tourpackageid) as total_packages, MIN(a.price) as min_price')
                    ->where('a.bit_Deleted_Flag', 0)
                    ->where('a.status', 1)
                    ->first();
        
        $faqData = DB::table('tbl_faqs')
                    ->selectRaw('faq_id, faq_question, faq_answer')
                    ->where('bit_Deleted_Flag', 0)
                    ->where('faq_type', 2)
                    ->where('status', 1)
                    ->orderBy('faq_order', 'ASC')
                    ->limit(5)
                    ->get();
        $reviewsData = DB::table('tbl_reviews')
                ->selectRaw('review_id, reviewer_name, reviewer_loc, no_of_star, feedback_msg , updated_date')
                ->where('bit_Deleted_Flag', 0)
                ->where('status', 1)
                ->get();

        $placesSchemaData = DB::table('tbl_places as p')
            ->selectRaw('p.placeid, p.destination_id, p.place_name, p.place_url, p.latitude, p.longitude, p.trip_duration, p.distance_from_nearest_city, p.placeimg, p.placethumbimg, p.alttag_banner, p.alttag_thumb, p.google_map, p.travel_tips , p.about_place, p.entry_fee, p.timing, p.rating, p.status, p.meta_title, p.meta_keywords, p.meta_description, p.pckg_meta_title, p.pckg_meta_keywords, p.pckg_meta_description, p.show_in_home')
            ->where('p.destination_id', '=', $destinationData->destination_id)
            ->where('p.bit_Deleted_Flag', 0)
            ->get();
        
        $popularToursQuery = DB::table('tbl_tourpackages as a')
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
                        'b.destination_name',
                        'c.duration_name'
                    )
                    ->where('a.bit_Deleted_Flag', 0)
                    ->where('a.status', 1);
                    
        $popularTours = $popularToursQuery->get();
        
        // 1. Organization Schema
        $organisationSchema = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Coorg Packages",
            "url" => url('/'),
            "logo" => "https://coorgpackages.com/assets/img/mhh-logo.png",
            "email" => $parameters[3]->par_value ?? "support@coorgpackages.com",
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => $parameters[2]->par_value ?? "+91 9886 52 52 53",
                "contactType" => "Customer Service",
                "areaServed" => "IN",
                "availableLanguage" => ["English", "Hindi", "Kannada"]
            ],
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "#69 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar",
                "addressLocality" => "Bengaluru",
                "addressRegion" => "Karnataka",
                "postalCode" => "560010",
                "addressCountry" => "IN"
            ],
            "sameAs" => array_filter([
                $parameters[14]->par_value ?? null,
                $parameters[15]->par_value ?? null,
                $parameters[16]->par_value ?? null
            ])
        ];
        // 2.Webpage schema
        $webPageSchema=[
            "@context"      => "https://schema.org",
            "@type"         => "WebPage",
            "name"          => $destinationData->meta_title ?? 'Coorg Packages',
            "url"           => url('/'),
            "description"   => $destinationData->meta_description ?? 'Plan your trip to Coorg with affordable tour packages.',
            "keywords"      => $destinationData->meta_keywords ?? "",
            "inLanguage"    => "en"
        ];
        // 3.Destination Schema
        $destinationSchema = [
            "@context" => "https://schema.org",
            "@type" => "TouristDestination", // You can change this to "TouristDestination" if desired
            "name" => $destinationData->destination_name,
            "url" => url("destinations/".$destinationData->destination_url),
            "description" => strip_tags($destinationData->about_destination),
            "address" => [
                "@type" => "PostalAddress",
                "addressLocality" => $destinationData->state,
                "addressCountry" => "India"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => $destinationData->latitude,
                "longitude" => $destinationData->longitude
            ],
            "image" => !empty($destinationData->destiimg_thumb) ? url('storage/destination_images/' . $destinationData->destiimg_thumb) : null,
            "amenityFeature" => [
                [
                    "@type" => "LocationFeatureSpecification",
                    "name" => "Internet Availability",
                    "value" => $destinationData->internet_availability ? "Yes" : "No"
                ],
                [
                    "@type" => "LocationFeatureSpecification",
                    "name" => "STD Code",
                    "value" => $destinationData->std_code
                ],
                [
                    "@type" => "LocationFeatureSpecification",
                    "name" => "Language Spoken",
                    "value" => $destinationData->language_spoken
                ]
            ],
            "additionalProperty" => [
                [
                    "@type" => "PropertyValue",
                    "name" => "Nearest City",
                    "value" => $destinationData->nearest_city
                ],
                [
                    "@type" => "PropertyValue",
                    "name" => "Trip Duration",
                    "value" => $destinationData->trip_duration
                ],
                [
                    "@type" => "PropertyValue",
                    "name" => "Best Time to Visit",
                    "value" => $destinationData->visit_time
                ],
                [
                    "@type" => "PropertyValue",
                    "name" => "Peak Season",
                    "value" => $destinationData->peak_season
                ],
                [
                    "@type" => "PropertyValue",
                    "name" => "Weather Info",
                    "value" => $destinationData->weather_info
                ],
                [
                    "@type" => "PropertyValue",
                    "name" => "Major Festivals",
                    "value" => $destinationData->major_festivals
                ]
            ],
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => number_format($reviewsData->avg('no_of_star'), 1),
                "reviewCount" => $reviewsData->count()
            ],
            "review" => $reviewsData->map(function ($review) {
                return [
                    "@type" => "Review",
                    "author" => [
                        "@type" => "Person",
                        "name" => $review->reviewer_name
                    ],
                    "datePublished" => date('Y-m-d', strtotime($review->updated_date)),
                    "reviewBody" => $review->feedback_msg,
                    "name" => $review->reviewer_loc ? $review->reviewer_loc . ' Review' : 'Review',
                    "reviewRating" => [
                        "@type" => "Rating",
                        "ratingValue" => $review->no_of_star,
                        "bestRating" => "5"
                    ]
                ];
            })->toArray()
        ];
        // 4. Place schema
        $placeSchemas = [
            "@context" => "https://schema.org",
            "@graph" => $placesSchemaData->map(function ($place) use ($destinationData) {
                $placeSchema = [
                    "@type" => "Place",
                    "name" => $place->place_name,
                    "url" => url("coorg/" . $place->place_url),
                    "description" => strip_tags($place->about_place),
                    "address" => [
                        "@type" => "PostalAddress",
                        "addressLocality" => $destinationData->destination_name ?? '',
                        "addressCountry" => 'India'
                    ],
                    "geo" => [
                        "@type" => "GeoCoordinates",
                        "latitude" => $place->latitude,
                        "longitude" => $place->longitude
                    ],
                    "image" => !empty($place->placethumbimg)
                        ? url('storage/place_images/thumbs/' . $place->placethumbimg)
                        : null,
                    "containedInPlace" => [
                        "@type" => "Place",
                        "name" => $destinationData->destination_name ?? '',
                        "address" => [
                            "@type" => "PostalAddress",
                            "addressCountry" => 'India'
                        ]
                    ],
                ];
        
                // Add aggregateRating only if it exists
                if (!empty($place->rating)) {
                    $placeSchema["aggregateRating"] = [
                        "@type" => "AggregateRating",
                        "ratingValue" => $place->rating,
                        "bestRating" => "5",
                        "reviewCount" => 1
                    ];
                }
        
                // Remove null values from the schema
                return array_filter($placeSchema, function ($value) {
                    return !is_null($value);
                });
            })->values()->toArray()
        ];
        // 5. Faq Schema
        $faqSchema = [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $faqData->map(function ($faq) {
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
    
        // 6. Product schemas
        $productSchemas = [];
        foreach ($popularTours as $tour) {
            $productSchemas[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $tour->tpackage_name,
                "image" => [asset('storage/tourpackages/details/' . $tour->tour_details_img)],
                "description" => Str::limit(strip_tags(html_entity_decode($tour->about_package)), 160),
                "brand" => [
                    "@type" => "Organization",
                    "name" => "coorgpackages.com"
                ],
                "aggregateRating" => [
                    "@type" => "AggregateRating",
                    "ratingValue" => number_format($tour->ratings ?? 4.5, 1),
                    "reviewCount" => (int)($tour->review_count ?? 10)
                ],
                "offers" => [
                    "@type" => "Offer",
                    "url" => url('tours/' . $tour->tpackage_url),
                    "priceCurrency" => "INR",
                    "price" => (string)(int)$tour->price,
                    "availability" => "https://schema.org/InStock",
                    "validFrom" => date('Y-m-d')
                ]
            ];
        }
        return view('website.destination',
         ['destinationData'     => $destinationData,
          'placesData'          => $placesData,
          'parameters'          => $parameters,
          'countAndPrice'       => $countAndPrice,
          'faqData'             => $faqData,
          'reviewsData'         => $reviewsData,
          'placeSchemas'        => $placeSchemas,
          'faqSchemas'          => $faqSchema,
          'webPageSchema'       => $webPageSchema,
          'organisationSchema'  => $organisationSchema,
          'destinationSchema'   => $destinationSchema,
          'productSchemas'      => $productSchemas
          ])
          ->with([
            'meta_title'        => $destinationData->meta_title,
            'meta_description'  => $destinationData->meta_description,
            'meta_keywords'     => $destinationData->meta_keywords
        ]);
    }
    public function getPlaces(Request $request)
    {
        $query = DB::table('tbl_places as p')
            ->selectRaw('p.placeid, p.destination_id, p.place_name, p.place_url, p.latitude, p.longitude, p.trip_duration, p.distance_from_nearest_city, p.placeimg, p.placethumbimg, p.alttag_banner, p.alttag_thumb, p.google_map, p.travel_tips , p.about_place, p.entry_fee, p.timing, p.rating, p.status, p.meta_title, p.meta_keywords, p.meta_description, p.pckg_meta_title, p.pckg_meta_keywords, p.pckg_meta_description, p.show_in_home')
            ->where('p.destination_id', '=', $request->destination_id)
            ->where('p.bit_Deleted_Flag', '=', 0)
            ->where('p.status', 1);
    
        if ($request->load_all == 'true') {
            $placesData = $query->get();
        } else {
            $placesData = $query->skip(($request->page - 1) * 3)->take(3)->get();
        }
    
        $html = '';
        foreach ($placesData as $place) {
            $html .= '
                <div class="card top-place-card mb-3">
                    <img src="' . asset('storage/place_images/thumbs/' . $place->placethumbimg) . '" alt="' . e($place->alttag_thumb) . '" class="card-img-top" />
                    <div class="card-body">
                        <h5 class="card-title">' . e($place->place_name) . '</h5>
                        <p class="card-text mb-2">' . implode(' ', array_slice(explode(' ', strip_tags($place->about_place)), 0, 30)) . '...</p>
                        
                    </div>
                    <div class="card-footer pt-0 pb-3 bg-white border-0"><a href="' . route('website.neardestination', ['slug' => $place->place_url]) . '" target="_blank" class="stretched-link fw-bold">View Details <i class="ms-2 bi bi-arrow-right"></i></a></div>
                </div>
            ';
        }
    
        return $html;
    }

    public function popularTourData(Request $request){

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
                        'c.duration_name'
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
                    
                </div>
                <div class="card-footer bg-white pt-0 pb-3 border-0">
                <div class="d-flex justify-content-between align-items-center ">

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
}