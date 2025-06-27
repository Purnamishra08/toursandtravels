<?php
namespace App\Http\Controllers\Website\Reviews;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class ReviewController extends Controller{
    public function index(Request $request){
        $reviewMeta = DB::table('tbl_contents')
        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
        ->where('content_id', 7)
        ->where('bit_Deleted_Flag', 0)
        ->first();

        $reviewData = DB::table('tbl_reviews as r')
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
                ->orderBy('r.review_id', 'DESC')
                ->groupBy('r.review_id', 'r.tourtagid', 'r.reviewer_name', 'r.reviewer_loc', 'r.no_of_star', 'r.feedback_msg', 'r.status', 'r.updated_date')
                ->get();

        $meta_title         =  isset($reviewMeta) ? $reviewMeta->seo_title : '';
        $meta_keywords      =  isset($reviewMeta) ? $reviewMeta->seo_keywords : '';
        $meta_description   =  isset($reviewMeta) ? $reviewMeta->seo_description : '';
        
        $parameters =  DB::table('tbl_parameters')
        ->select('parameter', 'par_value', 'parid')
        ->where('param_type', 'CS')
        ->where('status', 1)
        ->where('bit_Deleted_Flag', 0)
        ->get();

        // 1. Organization Schema
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
        // 2.Webpage schema
        $webPageSchema=[
            "@context"      => "https://schema.org",
            "@type"         => "WebPage",
            "name"          => $meta_title ?? 'Coorg Packages',
            "url"           => url()->current(),
            "description"   => $meta_description ?? 'Plan your trip to Coorg with affordable tour packages.',
            "keywords"      => $meta_keywords ?? "",
            "inLanguage"    => "en",
            "isPartOf"      => [
                "@type" => "Website",
                "name"  => "Coorg Packages",
                "url"   => url('/')
            ]
        ];
        // 3.Review schema
        $reviewSchema = [];
        foreach ($reviewData as $review) {
            $reviewSchema[] = [
                "@context" => "https://schema.org",
                "@type" => "Review",
                "author" => [
                    "@type" => "Person",
                    "name" => $review->reviewer_name
                ],
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $review->no_of_star,
                    "bestRating" => "5"
                ],
                "reviewBody" => strip_tags($review->feedback_msg),
                "datePublished" => date('Y-m-d', strtotime($review->updated_date)),
                "itemReviewed" => [
                    "@type" => "Product",
                    "name" => $review->tag_name
                ]
            ];
        }

        return view('website.allreview', [
            'reviewData'            => $reviewData,
            'webPageSchema'         => $webPageSchema,
            'organisationSchema'    => $organisationSchema,
            'reviewSchema'          => $reviewSchema
            ])->with([
            'meta_title'        => $meta_title,
            'meta_description'  => $meta_description,
            'meta_keywords'     => $meta_keywords
        ]);
    }
}