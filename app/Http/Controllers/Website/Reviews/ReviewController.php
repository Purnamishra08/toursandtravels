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

        return view('website.allreview', ['reviewData' => $reviewData])->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
    }
}