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
        $similarDestinationTags = DB::table('tbl_destination_places')
                                ->where('type', 1)
                                ->where('bit_Deleted_Flag', 0)
                                ->where('destination_id', $destinationData->destination_id ?? 0)
                                ->pluck('simdest_id') // Fetch only the cat_id column
                                ->toArray();
        $nearbyPlacesTags = DB::table('tbl_destination_places')
                            ->where('type', 2)
                            ->where('bit_Deleted_Flag', 0)
                            ->where('destination_id', $destinationData->destination_id ?? 0)
                            ->pluck('simdest_id') // Fetch only the cat_id column
                            ->toArray();
        $parameters =  DB::table('tbl_parameters')
                    ->select('parameter', 'par_value', 'parid')
                    ->where('param_type', 'CS')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->get();
        return view('website.destination', ['destinationData' => $destinationData, 'placesData' => $placesData, 'parameters' => $parameters])->with([
            'meta_title' => $destinationData->meta_title,
            'meta_description' => $destinationData->meta_description,
            'meta_keywords' => $destinationData->meta_keywords
        ]);;
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
                        <a href="' . url('place/' . $place->place_url) . '" class="stretched-link fw-bold">View Details <i class="ms-2 bi bi-arrow-right"></i></a>
                    </div>
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
    }
}