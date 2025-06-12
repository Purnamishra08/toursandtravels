<?php
namespace App\Http\Controllers\Website\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index(Request $request){
        // 1. Load parameters
        $parameters =  DB::table('tbl_parameters')
        ->select('parameter', 'par_value', 'parid')
        ->where('param_type', 'CS')
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->get();

        // 2. Meta tags
        $meta_title         =  isset($parameters) ? $parameters[10]->par_value : '';
        $meta_keywords      =  isset($parameters) ? $parameters[11]->par_value : '';
        $meta_description   =  isset($parameters) ? $parameters[12]->par_value : '';

        // 3. Destination name
        $destinationName = DB::table('tbl_destination')->select('destination_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->first();
        
        // 4. Organization Schema
        $organisationSchema = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Coorg Packages",
            "url" => url('/'),
            "logo" => "https://coorgpackages.com/assets/img/mhh-logo.webp",
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

        // 5. WebPage Schema
        $webPageSchema=[
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => $meta_title ?? 'Coorg Packages',
            "url" => url('/'),
            "description" => $meta_description ?? 'Plan your trip to Coorg with affordable tour packages.',
            "keywords" => $meta_keywords ?? "coorg packages,coorg tour packages",
            "inLanguage" => "en"
        ]; 
        
        // 6. Popular tours query builder
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
                    // ->where('a.pack_type', 15)
                    ->where('a.status', 1);
                    if ($request->fromDestination != 1) {
                        $popularToursQuery->where('a.show_in_home', 1)
                            ->inRandomOrder()
                            ->limit(9);
                    } else {
                        $popularToursQuery->inRandomOrder()
                            ->limit(6);
                    }
                    $popularTours = $popularToursQuery->get();

        // 7. Product schemas
        $productSchemas = [];
        foreach ($popularTours as $tour) {
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
                    "reviewCount" => (int)($tour->review_count ?? mt_rand(100, 200))
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

        // 8. Reviews query
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
            ->orderBy('r.review_id', 'DESC')
            ->groupBy(
                'r.review_id', 'r.tourtagid', 'r.reviewer_name', 'r.reviewer_loc',
                'r.no_of_star', 'r.feedback_msg', 'r.status', 'r.updated_date'
            )
            ->get();

        // 9. Review schema
        $reviewSchema = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "coorgpackages.com",
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => number_format($reviews->avg('no_of_star'), 1),
                "reviewCount" => $reviews->count() ?? mt_rand(100, 200)
            ],
            "review" => $reviews->map(function ($review) {
                return [
                    "@type" => "Review",
                    "author" => $review->reviewer_name,
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

        // 10. Blogs for home page
        $blogDataShow = DB::table('tbl_blog')
            ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
            ->where('status', 1)
            ->where('show_in_home', 1)
            ->where('bit_Deleted_Flag', 0)
            ->limit(6)
            ->get();
        
        $blogSchemas = [];
        foreach ($blogDataShow as $blog) {
            $blogSchemas[] = [
                "@context" => "https://schema.org",
                "@type" => "BlogPosting",
                "mainEntityOfPage" => [
                    "@type" => "WebPage",
                    "@id" => url('/blog/' . $blog->blog_url)
                ],
                "headline" => $blog->title,
                "image" => [asset('storage/blog_images/' . $blog->image)],
                "datePublished" => date('c', strtotime($blog->created_date)),
                "dateModified" => date('c', strtotime($blog->created_date)),
                "author" => [
                    "@type" => "Organization",
                    "name" => "coorgpackages.com",
                    "url" => url('/')
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "coorgpackages.com",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => "https://coorgpackages.com/assets/img/mhh-logo.webp"
                    ]
                ],
                "description" => Str::limit(strip_tags(html_entity_decode($blog->content)), 160),
            ];
        }

            // 11. Return view with all data
        return view('website.index', [
            'destinationName' => $destinationName,
            'organisationSchema' => $organisationSchema,
            'webPageSchema' => $webPageSchema,
            'productSchemas' => $productSchemas,
            'reviewSchema' => $reviewSchema,
            'blogSchemas' => $blogSchemas,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
        ]);
    }

    public function blogsHome(Request $request){
        $blogDataShow = DB::table('tbl_blog')
                    ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
                    ->where('status', 1)
                    ->where('show_in_home', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->limit(6)
                    ->get();
        if ($request->ajax()) {
            $html = '';
            foreach ($blogDataShow as $values) {
                $html .= '
                <div class="card recent-post-card wow animate__fadeInUp" data-wow-delay="200ms">
                    <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" target="_blank">
                        <img loading="lazy" src="' . asset('storage/blog_images/' . $values->image) . '" alt="' . $values->alttag_image . '" />
                    </a>
                    <p class="tour-badge">Travel</p>
                    <div class="card-body">
                        <ul>
                            <li><i class="bi bi-calendar"></i> ' . date('d-M-Y', strtotime($values->created_date)) . '</li>
                        </ul>
                        <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" target="_blank" style="color:black">
                            <h3 class="card-title mt-3">' . $values->title . '</h3>
                            <p>' . implode(' ', array_slice(explode(' ', $values->content), 0, 30)) . '</p>
                        </a>
                        <div class="text-end mt-2">
                            <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" class="btn btn-outline-primary">
                                Read More <i class="ms-2 bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>';
            }
            return $html;
        }
    }

    public function popularTour(Request $request){

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
                    // ->where('a.pack_type', 15)
                    ->where('a.status', 1);
        if($request->fromDestination != 1){
            $query->where('a.show_in_home', 1);
            $query->inRandomOrder()->limit(9);
        }else{
            $query->inRandomOrder()->limit(6);
        }
        $popularTours = $query->inRandomOrder()->limit(9)->get();
        if ($request->ajax()) {
            $html = '';
            foreach ($popularTours as $values) {
                $html .= '
                <div class="card tour-card  wow animate__fadeInUp  " data-wow-delay="200ms">
                    <img loading="lazy" class="card-img-top" src="' . asset('storage/tourpackages/thumbs/' . $values->tour_thumb) . '" alt="' . $values->alttag_thumb . '">';
                    if($values->pack_type==15){
                        $html.='<span class="badge">Most popular</span>';
                    }
                    $html.='<div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> '.str_replace('/', '&', $values->duration_name).'</span>
                        <small class="d-block">Ex- '.$values->destination_name.'</small>
                    </p>
                    
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <span class="text-secondary">'.$values->ratings.' Star</span>
                    </div>
                    <h3 class="card-title">'.$values->tpackage_name.'</h3>
                   
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0"> 
                <div class="d-flex justify-content-between align-items-center ">

                        <div class="p-card-info">
                        
                            
                            <h4 class="mb-0"><span>₹ </span>'.(int)$values->price.' </h4>
                            <strike >₹ '.(int)$values->fakeprice.'</strike>
                        </div>
                        <a href="' . route('website.tourDetails', ['slug' => $values->tpackage_url]) . '" class="btn btn-outline-primary stretched-link">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div></div>
            </div>';
            }
            return $html;
        }
    }

    public function destinationPlaces(Request $request) {

        $destinationPlaces=DB::table('tbl_places as p')
                ->select('p.placeimg', 'p.placethumbimg', 'p.placeid', 'p.place_name', 'd.destination_id', 'd.destination_name', 'p.alttag_thumb', 'p.place_url')
                ->leftJoin('tbl_destination as d', 'p.destination_id', '=', 'd.destination_id')
                ->where('p.bit_Deleted_Flag', 0)
                ->where('p.show_in_home', 1)
                ->where('p.status', 1)
                ->where('d.bit_Deleted_Flag', 0)
                ->limit(5)
                ->get();
        if ($request->ajax()) {
            $html = '';
            foreach ($destinationPlaces as $values) {
                $html .= '
                <div class="gallery-item">
                    <a href="' . route('website.neardestination', ['slug' => $values->place_url]) . '" target="_blank">
                        <img loading="lazy" src="' . asset('storage/place_images/thumbs/' . $values->placethumbimg) . '" alt="' . $values->alttag_thumb . '">
                    </a>
                    <div class="gallery-text">' . $values->place_name . '</div>
                </div>';
            }
            return $html;
        }
    }
    
    public function clientReviews(Request $request)
    {
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
            ->orderBy('r.review_id', 'DESC')
            ->groupBy('r.review_id', 'r.tourtagid', 'r.reviewer_name', 'r.reviewer_loc', 'r.no_of_star', 'r.feedback_msg', 'r.status', 'r.updated_date')
            ->limit(6)
            ->get();

        if ($request->ajax()) {
            $html = '';
            foreach ($reviews as $values) {

                // Star rating generation
                $fullStars = floor($values->no_of_star);
                $halfStar = (fmod($values->no_of_star, 1) != 0.00) ? 1 : 0;
                $emptyStars = 5 - ($fullStars + $halfStar);

                $starsHtml = '';
                for ($i = 0; $i < $fullStars; $i++) {
                    $starsHtml .= '<i class="bi bi-star-fill text-warning"></i> ';
                }
                if ($halfStar) {
                    $starsHtml .= '<i class="bi bi-star-half text-warning"></i> ';
                }
                for ($i = 0; $i < $emptyStars; $i++) {
                    $starsHtml .= '<i class="bi bi-star-fill text-secondary"></i> ';
                }

                // Review card HTML
                $html .= '
                    <div class="swiper-slide">
                        <div class="card client-review-card h-100">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">  ' . $values->reviewer_name . '</p>
                                                <div class="rate">' . $starsHtml . '</div>

                                            </div>

                                            </div>
                                            <p class="client-location text-secondary"><i class="bi bi-geo-alt-fill"></i> ' . $values->reviewer_loc . '</p>
                                        
                                        
                                    
                                </div>
                                <p class="clent-message">' . $values->feedback_msg . '</p>
                            </div>
                        </div>
                    </div>';
            }
            return $html;
        }
    }
}