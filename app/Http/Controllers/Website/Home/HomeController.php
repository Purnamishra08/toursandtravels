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
    public function index(Request $request)
    {
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
                    <img src="' . asset('storage/blog_images/' . $values->image) . '" alt="' . $values->alttag_image . '" />
                    <p class="tour-badge">Travel</p>
                    <div class="card-body">
                        <ul>
                            <li><i class="bi bi-calendar"></i> ' . date('d-M-Y', strtotime($values->created_date)) . '</li>
                        </ul>
                        <h5 class="card-title mt-3">' . $values->title . '</h5>
                        <p>' . implode(' ', array_slice(explode(' ', $values->content), 0, 30)) . '</p>
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
        return view('website.index');
    }

    public function popularTour(Request $request){

        $popularTours = DB::table('tbl_tourpackages as a')
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
                    ->where('a.pack_type', 15)
                    ->where('a.status', 1)
                    ->where('a.show_in_home', 1)
                    ->limit(6)
                    ->get();

        if ($request->ajax()) {
            $html = '';
            foreach ($popularTours as $values) {
                $html .= '
                <div class="card tour-card  wow animate__fadeInUp  " data-wow-delay="200ms">
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
        return view('website.index');
    }


    public function destinationPlaces(Request $request) {

        $destinationPlaces=DB::table('tbl_places as p')
                ->select('p.placeimg', 'p.placethumbimg', 'p.placeid', 'p.place_name', 'd.destination_id', 'd.destination_name', 'p.alttag_thumb')
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
                    <img src="' . asset('storage/place_images/thumbs/' . $values->placethumbimg) . '" alt="' . $values->alttag_thumb . '">
                    <div class="gallery-text">'. $values->place_name.'</div>
                </div>';
            }
            return $html;
        }
        return view('website.index');
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
                    $starsHtml .= '<i class="fa fa-star text-warning"></i> ';
                }
                if ($halfStar) {
                    $starsHtml .= '<i class="fa fa-star-half text-warning"></i> ';
                }
                for ($i = 0; $i < $emptyStars; $i++) {
                    $starsHtml .= '<i class="fa fa-star text-secondary"></i> ';
                }

                // Review card HTML
                $html .= '
                    <div class="swiper-slide">
                        <div class="card client-review-card">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div>
                                        <p class="client-name"><i class="fa-solid fa-person"></i>  ' . $values->reviewer_name . '</p>
                                        <p class="client-name text-black"><i class="fa-solid fa-location-dot"></i> ' . $values->reviewer_loc . '</p>
                                        <div class="rate">' . $starsHtml . '</div>
                                    </div>
                                </div>
                                <p class="clent-message">' . $values->feedback_msg . '</p>
                            </div>
                        </div>
                    </div>';
            }
            return $html;
        }

        return view('website.index');
    }
}