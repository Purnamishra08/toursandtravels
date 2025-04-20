<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
//word file
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
class PackagePdfController extends Controller
{
    public function index(Request $request){
        $packages = DB::table('tbl_tourpackages')
            ->where('status',1)
            ->where('bit_Deleted_Flag',0)
            ->get();
        return view('admin.managepackages.generatePackage',['packages'=>$packages]);
    }


    public function getPackageMaxCapacity($id)
    {
        $packageId =$id;

        // Get starting city for the package
        $package = DB::table('tbl_tourpackages')
            ->select('starting_city')
            ->where('tourpackageid', $packageId)
            ->first();
        if (!$package) {
            return response()->json(['max_capacity' => 0]);
        }

        $startingCity = $package->starting_city;

        // Count vehicles available for the starting city
        $vehicleCount = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->where('a.destination', $startingCity)
            ->where('a.status', 1)
            ->where('a.bit_Deleted_Flag', 0)
            ->where('b.bit_Deleted_Flag', 0)
            ->count('a.priceid');

        $maxCapacity = 0;

        if ($vehicleCount > 0) {
            $maxCapacityResult = DB::table('tbl_vehicleprices as a')
                ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
                ->where('a.destination', $startingCity)
                ->where('a.status', 1)
                ->where('a.bit_Deleted_Flag', 0)
                ->where('b.bit_Deleted_Flag', 0)
                ->max('b.capacity');

            $maxCapacity = (int) $maxCapacityResult;
        }

        return response()->json(['max_capacity' => $maxCapacity]);
    }
    
    public function getPackageItineraries($id)
    {
        $packageId = $id;
        // Count number of daywise itineraries
        $noOfItineraries = DB::table('tbl_itinerary_daywise')
                            ->where('bit_Deleted_Flag', 0)
                            ->where('package_id', $packageId)
                            ->count();

        $html = '';

        if ($noOfItineraries > 0) {
            $daywiseItineraries = DB::table('tbl_itinerary_daywise')
                                    ->where('package_id', $packageId)
                                    ->where('bit_Deleted_Flag', 0)
                                    ->orderBy('itinerary_daywiseid')
                                    ->get();

            $day = 1;
            $html .= '<ul class="timeline">';

            foreach ($daywiseItineraries as $itinerary) {
                $html .= '<li><div class="item">';
                $html .= '<div class="timelineheading"><span style="padding-top: 15px;">Day ' . $day . '</span> - ' . $itinerary->title . '</div>';

                // Places linked to this itinerary day
                $placeIds = $itinerary->place_id;
                if (!empty($placeIds)) {
                    $places = DB::table('tbl_places')
                                ->select('placeid', 'destination_id', 'place_name', 'place_url')
                                ->whereIn('placeid', explode(',', $placeIds))
                                ->get();

                    foreach ($places as $place) {
                        $dest = DB::table('tbl_destination as a')
                                ->join('tbl_state as b', 'a.state', '=', 'b.state_id')
                                ->select('a.destination_url', 'b.state_url')
                                ->where('a.destination_id', $place->destination_id)
                                ->first();

                        if ($dest) {
                            $placeUrl = url("place/{$dest->state_url}/{$dest->destination_url}/{$place->place_url}");
                            $html .= '<div style="text-indent: 10px;color: #000;"><a href="' . $placeUrl . '" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $place->place_name . '</a></div>';
                        }
                    }
                }

                // Other Itinerary Places
                $otherPlaces = explode(',', $itinerary->other_iternary_places);
                foreach ($otherPlaces as $otherPlace) {
                    if (trim($otherPlace)) {
                        $html .= '<div style="text-indent: 10px;color: #000;"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . trim($otherPlace) . '</div>';
                    }
                }

                $html .= '</div></li>';
                $day++;
            }

            $html .= '</ul>';
        }

        return response()->json(['html' => $html]);
    }


    public function getPackageAccommodations($id)
    {
        $packageId = $id;

        // Get starting city of the package (not used in final query, so can be omitted)
        $startingCity = DB::table('tbl_tourpackages')
                        ->where('tourpackageid', $packageId)
                        ->value('starting_city');

        // Get hotel_type_ids used in this package
        $accommodationTypes = DB::table('tbl_hotel as a')
            ->join('tbl_hotel_type as b', 'a.hotel_type', '=', 'b.hotel_type_id')
            ->distinct()
            ->select('a.hotel_type as hotel_type_id')
            ->where('a.status', 1)
            ->whereIn('a.destination_name', function($query) use ($packageId) {
                $query->select('destination_id')
                    ->from('tbl_package_accomodation')
                    ->where('package_id', $packageId);
            })
            ->orderByDesc('b.hotel_type_name')
            ->get();

        $hotelTypeIds = $accommodationTypes->pluck('hotel_type_id')->toArray();

        $html = '<option value=""> - - Select Accommodation - - </option>';

        if (!empty($hotelTypeIds)) {
            $hotelTypes = DB::table('tbl_hotel_type')
                            ->whereIn('hotel_type_id', $hotelTypeIds)
                            ->orderByDesc('hotel_type_name')
                            ->get();

            foreach ($hotelTypes as $type) {
                $html .= '<option value="' . $type->hotel_type_id . '">' . $type->hotel_type_name . '</option>';
            }
        }

        return response()->json(['options' => $html]);
    }

    public function getVehicles(Request $request)
    {
        $totalCount = $request->input('totalcount');
        $packageId = $request->input('package_id');
        $startingCity = null;

        if ($packageId) {
            $startingCity = DB::table('tbl_tourpackages')
                ->where('tourpackageid', $packageId)
                ->value('starting_city');
        } else {
            $startingCity = $request->input('destination');
        }

        // Get available vehicles
        $vehicles = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->select('b.vehicle_name', 'b.vehicleid')
            ->where('a.destination', $startingCity)
            ->where('a.status', 1)
            ->where(function ($query) use ($totalCount) {
                $query->where('b.capacity', '>', $totalCount)
                    ->orWhere('b.capacity', '=', $totalCount);
            })
            ->orderBy('b.capacity', 'asc')
            ->get();

        // Generate options
        $options = "<option value=''>-Select Vehicle-</option>";
        foreach ($vehicles as $vehicle) {
            $options .= "<option value='{$vehicle->vehicleid}'>{$vehicle->vehicle_name}</option>";
        }

        return response()->json(['options' => $options]);
    }

    public function getAccommodation(Request $request)
    {   
        $firstHotelType = $request->input('accommodation_type');
        $tourPackageId = $request->input('packageid');

        $hotelTypeName = DB::table('tbl_hotel_type')
            ->where('hotel_type_id', $firstHotelType)
            ->where('status',1)
            ->where('bit_Deleted_Flag',0)
            ->value('hotel_type_name');
        $accommodations = DB::table('tbl_package_accomodation')
            ->where('bit_Deleted_Flag',0)
            ->where('package_id', $tourPackageId)
            ->get();

        $html = '';
        if (!$accommodations->isEmpty()) {
            $html .= '<div class="col-xl-12 col-lg-12">';
            $html .= '<h4 style="color:#6583bb; padding-bottom:20px;">' . $hotelTypeName . '</h4>';
            $html .= '</div>';

            $hotelCount = 1;

            foreach ($accommodations as $accommodation) {
                $destinationId = $accommodation->destination_id;
                $stayNights = $accommodation->noof_days;

                $destinationName = DB::table('tbl_destination')
                    ->where('destination_id', $destinationId)
                    ->value('destination_name');

                $hotelList = DB::table('tbl_hotel')
                    ->where('destination_name', $destinationId)
                    ->where('hotel_type', $firstHotelType)
                    ->where('status', 1)
                    ->orderBy('default_price', 'asc')
                    ->get();

                $html .= '<div class="col-xl-3 col-lg-3">';
                $html .= '<h5>' . $destinationName . '</h5>';
                $html .= ($stayNights > 0) ? '<h6>(' . $stayNights . ' Nights)</h6>' : '';
                $html .= '</div>';

                $html .= '<div class="col-xl-9 col-lg-9">';
                $html .= '<div class="row">';

                if ($hotelList->isEmpty()) {
                    $html .= 'No hotel Available';
                } else {
                    $selCount = 1;
                    foreach ($hotelList as $hotel) {
                        $starRating = $hotel->star_rating;
                        $floorRating = floor($starRating);
                        $hasHalf = $starRating - $floorRating > 0;
                        $emptyStars = 5 - ceil($starRating);

                        $html .= '<div class="col-xl-4 col-lg-4">';
                        $html .= '<div class="hoteldetails">';
                        $html .= '<div class="form-check hotelplace">';
                        $html .= '<label class="form-check-label" for="hotelradio_' . $selCount . '">';
                        $html .= '<input type="radio" class="form-check-input" id="hotelradio_' . $selCount . '" name="hotelradio_' . $hotelCount . '" value="' . $hotel->hotel_id . '"' . ($selCount == 1 ? ' checked' : '') . '>' . $hotel->hotel_name;
                        $html .= '</label>';
                        $html .= '</div>';

                        if (!empty($hotel->room_type)) {
                            $html .= '<div class="hotelrating">(' . $hotel->room_type . ')</div>';
                        }

                        $html .= '<div class="hotelrating">';
                        $html .= str_repeat('<i class="fas fa-star"></i>', $floorRating);
                        if ($hasHalf) {
                            $html .= '<i class="fas fa-star-half-alt"></i>';
                        }
                        $html .= str_repeat('<i class="far fa-star"></i>', $emptyStars);
                        $html .= '</div>'; // hotelrating
                        $html .= '</div>'; // hoteldetails
                        $html .= '</div>'; // col
                        $selCount++;
                    }
                }

                $html .= '</div>'; // row
                $html .= '</div>'; // col-9

                if ($hotelCount < count($accommodations)) {
                    $html .= '<div class="col-md-12"><hr></div>';
                }

                $hotelCount++;
            }
        }

        return response()->json(['html' => $html]);
    }

    // public function getAccommodationWeb(Request $request)
    // {   
    //     $firstHotelType = $request->input('accommodation_type');
    //     $tourPackageId = $request->input('packageid');

    //     $hotelTypeName = DB::table('tbl_hotel_type')
    //         ->where('hotel_type_id', $firstHotelType)
    //         ->where('status',1)
    //         ->where('bit_Deleted_Flag',0)
    //         ->value('hotel_type_name');
    //     $accommodations = DB::table('tbl_package_accomodation')
    //         ->where('bit_Deleted_Flag',0)
    //         ->where('package_id', $tourPackageId)
    //         ->get();

    //     $html = '';
    //     if (!$accommodations->isEmpty()) {
    //         $html .= '<div class="col-xl-12 col-lg-12">';
    //         $html .= '<h4 style="color:#6583bb; padding-bottom:20px;">' . $hotelTypeName . '</h4>';
    //         $html .= '</div>';

    //         $hotelCount = 1;

    //         foreach ($accommodations as $accommodation) {
    //             $destinationId = $accommodation->destination_id;
    //             $stayNights = $accommodation->noof_days;

    //             $destinationName = DB::table('tbl_destination')
    //                 ->where('destination_id', $destinationId)
    //                 ->value('destination_name');

    //             $hotelList = DB::table('tbl_hotel')
    //                 ->where('destination_name', $destinationId)
    //                 ->where('hotel_type', $firstHotelType)
    //                 ->where('status', 1)
    //                 ->orderBy('default_price', 'asc')
    //                 ->get();

    //             $html .= '<div class="col-xl-3 col-lg-3">';
    //             $html .= '<h5>' . $destinationName . '</h5>';
    //             $html .= ($stayNights > 0) ? '<h6>(' . $stayNights . ' Nights)</h6>' : '';
    //             $html .= '</div>';

    //             $html .= '<div class="col-xl-9 col-lg-9">';
    //             $html .= '<div class="row">';

    //             if ($hotelList->isEmpty()) {
    //                 $html .= 'No hotel Available';
    //             } else {
    //                 $selCount = 1;
    //                 foreach ($hotelList as $hotel) {
    //                     $starRating = $hotel->star_rating;
    //                     $floorRating = floor($starRating);
    //                     $hasHalf = $starRating - $floorRating > 0;
    //                     $emptyStars = 5 - ceil($starRating);

    //                     $html .= '<div class="col-xl-4 col-lg-4">';
    //                     $html .= '<div class="hoteldetails">';
    //                     $html .= '<div class="form-check hotelplace">';
    //                     $html .= '<label class="form-check-label" for="hotelradio_' . $selCount . '">';
    //                     $html .= '<input type="radio" class="form-check-input" id="hotelradio_' . $selCount . '" name="hotelradio_' . $hotelCount . '" value="' . $hotel->hotel_id . '"' . ($selCount == 1 ? ' checked' : '') . '>' . $hotel->hotel_name;
    //                     $html .= '</label>';
    //                     $html .= '</div>';

    //                     if (!empty($hotel->room_type)) {
    //                         $html .= '<div class="hotelrating">(' . $hotel->room_type . ')</div>';
    //                     }

    //                     $html .= '<div class="hotelrating">';
    //                     $html .= str_repeat('<i class="fas fa-star"></i>', $floorRating);
    //                     if ($hasHalf) {
    //                         $html .= '<i class="fas fa-star-half-alt"></i>';
    //                     }
    //                     $html .= str_repeat('<i class="far fa-star"></i>', $emptyStars);
    //                     $html .= '</div>'; // hotelrating
    //                     $html .= '</div>'; // hoteldetails
    //                     $html .= '</div>'; // col
    //                     $selCount++;
    //                 }
    //             }

    //             $html .= '</div>'; // row
    //             $html .= '</div>'; // col-9

    //             if ($hotelCount < count($accommodations)) {
    //                 $html .= '<div class="col-md-12"><hr></div>';
    //             }

    //             $hotelCount++;
    //         }
    //     }

    //     return response()->json(['html' => $html]);
    // }
    public function getAccommodationWeb(Request $request)
    {
        $firstHotelType = $request->input('accommodation_type');
        $tourPackageId = $request->input('packageid');

        $hotelTypeName = DB::table('tbl_hotel_type')
            ->where('hotel_type_id', $firstHotelType)
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->value('hotel_type_name');

        $accommodations = DB::table('tbl_package_accomodation')
            ->where('bit_Deleted_Flag', 0)
            ->where('package_id', $tourPackageId)
            ->get();

        $html = '';

        if (!$accommodations->isEmpty()) {
            $hotelcount = 1;
            foreach ($accommodations as $index => $accommodation) {
                $destinationId = $accommodation->destination_id;
                $stayNights = $accommodation->noof_days;

                $destinationName = DB::table('tbl_destination')
                    ->where('destination_id', $destinationId)
                    ->value('destination_name');

                $hotelList = DB::table('tbl_hotel')
                    ->where('destination_name', $destinationId)
                    ->where('hotel_type', $firstHotelType)
                    ->where('status', 1)
                    ->orderBy('default_price', 'asc')
                    ->get();

                $html .= '<h6 class="text-info text-decoration-underline">' . $hotelTypeName . ' in ' . $destinationName . ' (' . $stayNights . ' Night' . ($stayNights > 1 ? 's' : '') . ')</h6>';

                if ($hotelList->isEmpty()) {
                    $html .= '<div class="hotel-wrapper mb-2">No hotels available in this destination.</div>';
                } else {
                    $selCount = 1;
                    foreach ($hotelList as $hotelIndex => $hotel) {
                        $checked = $selCount == 1 ? 'checked' : '';
                        $radioName = 'hotelradio_' . $selCount;
                        $hotelNameCount = 'hotelradio_' . $hotelcount;

                        $html .= '<div class="hotel-wrapper mb-1" id="accomodation_result">';
                        $html .= '<label class="hotel-details-card">';
                        $html .= '<input name="' . $hotelNameCount . '" id="' . $radioName . '"  class="hotel-radio form-check-input" type="radio" value="' . $hotel->hotel_id . '" ' . $checked . '>';
                        $html .= '<div class="card-body plan-details">';

                        // Hotel name
                        $html .= '<span class="d-block h-name"><i class="bi bi-buildings"></i> ' . $hotel->hotel_name . '</span>';

                        // Star rating
                        $html .= '<span class="d-block">';
                        $fullStars = floor($hotel->star_rating);
                        $halfStar = ($hotel->star_rating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;

                        $html .= str_repeat('<i class="fas fa-star text-warning"></i>', $fullStars);
                        if ($halfStar) {
                            $html .= '<i class="fas fa-star-half-stroke text-warning"></i>';
                        }
                        $html .= str_repeat('<i class="far fa-star text-warning"></i>', $emptyStars);
                        $html .= '</span>';

                        // Hotel type & room
                        $html .= '<span class="d-block">' . $hotelTypeName . ' Hotel</span>';
                        $html .= '<small class="d-block">(' . $hotel->room_type . ')</small>';

                        $html .= '</div>'; // card-body
                        $html .= '</label>';
                        $html .= '</div>'; // hotel-wrapper
                        $selCount++;
                    }
                }

                if ($index < count($accommodations) - 1) {
                    $html .= '<hr>';
                }
                
                $hotelcount++;
            }

            $html .= '<div class="text-center mt-3">';
            $html .= '<input type="button" class="btn btn-info" value="OK" data-bs-dismiss="modal">';
            $html .= '</div>';
        } else {
            $html .= '<div class="text-danger">No accommodation data found for this package.</div>';
        }

        return response()->json(['html' => $html]);
    }

    public function getPackagePrice(Request $request)
    {

        $hid_packageid = $request->input('hid_packageid');
        $quantity_adult = (int) $request->input('quantity_adult');
        $quantity_child = (int) $request->input('quantity_child');
        $travel_date = $request->input('travel_date');
        
        $splitdate = explode("/",$travel_date);		
		$travel_date_format = $splitdate[2]."-".$splitdate[1]."-".$splitdate[0];
		$travel_year = date("Y", strtotime($travel_date_format));
        // Fetch package info
        $package_data = DB::table('tbl_tourpackages')
            ->select('tpackage_name', 'package_duration', 'pmargin_perctage', 'starting_city')
            ->where('tourpackageid', $hid_packageid)
            ->first();

        $package_duration = $package_data->package_duration;
        $pmargin_perctage = $package_data->pmargin_perctage;
        $starting_city = $package_data->starting_city;
        $tpackage_name = $package_data->tpackage_name;


        $no_ofdays = DB::table('tbl_package_duration')->where('durationid', $package_data->package_duration)->value('no_ofdays');
        $pick_drop_price = DB::table('tbl_destination')->where('destination_id', $package_data->starting_city)->value('pick_drop_price');


        
        $vehicle = $request->input('vehicle');

        // Get vehicle price
        $get_vehicles = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->where('a.destination', $package_data->starting_city)
            ->where('a.vehicle_name', $vehicle)
            ->select('a.price', 'b.vehicle_name', 'b.vehicleid')
            ->first();

        $vehicle_name = $get_vehicles ? $get_vehicles->vehicle_name : "";
        $vehicle_price = $get_vehicles ? $get_vehicles->price : 0;


        $noof_coupleroom = 0;
		$noof_extrabed = 0;
		$noof_kidsroom = 0;
		$noof_coupleroom_price = 0;
		$noof_extrabed_price = 0;
		$noof_kidsroom_price = 0;
		$total_coupleroom_price = 0;
		$total_extrabed_price = 0;
		$total_kidsroom_price = 0;
		$total_traveller = $quantity_adult+$quantity_child;

        if($total_traveller <=2)
		{
			$noof_coupleroom = 1;
		}
		else 
		{			
			if($total_traveller % 2 == 0)
			{
				$noof_coupleroom = $total_traveller/2;
			}
			else
			{
				$noof_coupleroom = floor($total_traveller/2);
				if($quantity_child > 0)
					$noof_kidsroom = 1;
				else
					$noof_extrabed = 1;
			}
		}

        $accommodation_type = $request->input('accommodation_type');

        $accommodation_name = DB::table('tbl_hotel_type')->where('hotel_type_id', $accommodation_type)->where('bit_Deleted_Flag', 0)->value('hotel_type_name');
        $noof_hotels = DB::table('tbl_package_accomodation')->where('package_id', $hid_packageid)->where('bit_Deleted_Flag', 0)->count();

        // Handle selected hotels
        $field_value = [];
        for ($i = 1; $i <= $noof_hotels; $i++) {
            $fieldname = "hotelradio_" . $i;
            if ($request->has($fieldname)) {
                $field_value[] = $request->input($fieldname);
            }
        }
        $all_hotel_ids = implode(",",$field_value);
	    $rowspan = 1;
        foreach ($field_value as $hotel_id) {
            $hotel_coupleroom_price = 0;
            $hotel_extrabed_price = 0;
            $hotel_kidsroom_price = 0;

            $acc_destination_id = DB::table('tbl_hotel')->where('hotel_id', $hotel_id)->value('destination_name');
            $noof_nights = DB::table('tbl_package_accomodation')
                ->where('package_id', $hid_packageid)
                ->where('destination_id', $acc_destination_id)
                ->value('noof_days');

            for ($n = 0; $n < $noof_nights; $n++) {
                $hoteldate = date("Y-m-d", strtotime("+$n days", strtotime($travel_date_format)));

                $season_data = DB::select("SELECT * FROM `tbl_season` WHERE hotel_id = ? AND ? BETWEEN 
                    STR_TO_DATE(CONCAT(?, '-', sesonstart_month, '-', sesonstart_day), '%Y-%m-%d') AND 
                    STR_TO_DATE(CONCAT(?, '-', sesonend_month, '-', sesonend_day), '%Y-%m-%d')",
                    [$hotel_id, $hoteldate, $travel_year, $travel_year]);

                if (count($season_data) > 0) {
                    $noof_coupleroom_price = $season_data[0]->couple_price;
                    $noof_extrabed_price = $season_data[0]->adult_extra;
                    $noof_kidsroom_price = $season_data[0]->kid_price;
                } else {
                    $default_price = DB::table('tbl_hotel')->where('hotel_id', $hotel_id)->value('default_price');
                    $noof_coupleroom_price = $default_price;
                    $noof_extrabed_price = $default_price;
                    $noof_kidsroom_price = $default_price;
                }

                $hotel_coupleroom_price += $noof_coupleroom_price * $noof_coupleroom;
                $hotel_extrabed_price += $noof_extrabed_price * $noof_extrabed;
                $hotel_kidsroom_price += $noof_kidsroom_price * $noof_kidsroom;

                $rowspan++;
            }

            $total_coupleroom_price += $hotel_coupleroom_price;
            $total_extrabed_price += $hotel_extrabed_price;
            $total_kidsroom_price += $hotel_kidsroom_price;
        }

        $total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;	
		$total_vehicle_price = $vehicle_price*$no_ofdays;


        $airport_pickup = 0;
		$airport_pickup_price = 0;

        if($request->has('airport_pickup')) {
			$airport_pickup_price = $pick_drop_price;
			$airport_pickup = 1;
		}

        $airport_drop = 0;
		$airport_drop_price = 0;
		if($request->has('airport_drop')) {
			$airport_drop_price = $pick_drop_price;
			$airport_drop = 1;
		}

        $sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;

        return response()->json([
            'status'=>200,
            'adult' => $quantity_adult,
            'child' => $quantity_child,
            'vehicle' => $vehicle_name,
            'travel_date' => $travel_date,
            'accommodation' => $accommodation_name,
            'airport_pickup' => $airport_pickup,
            'airport_drop' => $airport_drop,
            'total_price' => number_format($total_price, 2)
        ]);
    }

    public function generatePDF(Request $request)
    {
        $hid_packageid = $request->input('hid_packageid');
        $quantity_adult = (int) $request->input('quantity_adult');
        $quantity_child = (int) $request->input('quantity_child');
        $travel_date = $request->input('travel_date');

        $splitdate = explode("/",$travel_date);		
		$travel_date_format = $splitdate[2]."-".$splitdate[1]."-".$splitdate[0];
		$travel_year = date("Y", strtotime($travel_date_format));

        // Fetch package info
        $package_data = DB::table('tbl_tourpackages')
            ->select('tpackage_name', 'package_duration', 'pmargin_perctage', 'starting_city')
            ->where('tourpackageid', $hid_packageid)
            ->first();
        $package_duration = $package_data->package_duration;
        $pmargin_perctage = $package_data->pmargin_perctage;
        $starting_city = $package_data->starting_city;
        $tpackage_name = $package_data->tpackage_name;


        $no_ofdays = DB::table('tbl_package_duration')->where('durationid', $package_data->package_duration)->value('no_ofdays');
        $pick_drop_price = DB::table('tbl_destination')->where('destination_id', $package_data->starting_city)->value('pick_drop_price');


        
        $vehicle = $request->input('vehicle');

        // Get vehicle price
        $get_vehicles = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->where('a.destination', $package_data->starting_city)
            ->where('a.vehicle_name', $vehicle)
            ->select('a.price', 'b.vehicle_name', 'b.vehicleid')
            ->first();

        $vehicle_name = $get_vehicles ? $get_vehicles->vehicle_name : "";
        $vehicle_price = $get_vehicles ? $get_vehicles->price : 0;


        $noof_coupleroom = 0;
		$noof_extrabed = 0;
		$noof_kidsroom = 0;
		$noof_coupleroom_price = 0;
		$noof_extrabed_price = 0;
		$noof_kidsroom_price = 0;
		$total_coupleroom_price = 0;
		$total_extrabed_price = 0;
		$total_kidsroom_price = 0;
		$total_traveller = $quantity_adult+$quantity_child;

        if($total_traveller <=2)
		{
			$noof_coupleroom = 1;
		}
		else 
		{			
			if($total_traveller % 2 == 0)
			{
				$noof_coupleroom = $total_traveller/2;
			}
			else
			{
				$noof_coupleroom = floor($total_traveller/2);
				if($quantity_child > 0)
					$noof_kidsroom = 1;
				else
					$noof_extrabed = 1;
			}
		}

        $accommodation_type = $request->input('accommodation_type');

        $accommodation_name = DB::table('tbl_hotel_type')->where('hotel_type_id', $accommodation_type)->value('hotel_type_name');
        $noof_hotels = DB::table('tbl_package_accomodation')->where('package_id', $hid_packageid)->count();

        // Handle selected hotels
        $field_value = [];
        for ($i = 1; $i <= $noof_hotels; $i++) {
            $fieldname = "hotelradio_" . $i;
            if ($request->has($fieldname)) {
                $field_value[] = $request->input($fieldname);
            }
        }
        
        $all_hotel_ids = implode(",",$field_value);
	    $rowspan = 1;

        foreach ($field_value as $hotel_id) {
            $hotel_coupleroom_price = 0;
            $hotel_extrabed_price = 0;
            $hotel_kidsroom_price = 0;

            $acc_destination_id = DB::table('tbl_hotel')->where('hotel_id', $hotel_id)->value('destination_name');
            $noof_nights = DB::table('tbl_package_accomodation')
                ->where('package_id', $hid_packageid)
                ->where('destination_id', $acc_destination_id)
                ->where('bit_Deleted_Flag', 0)
                ->value('noof_days');

            for ($n = 0; $n < $noof_nights; $n++) {
                $hoteldate = date("Y-m-d", strtotime("+$n days", strtotime($travel_date_format)));

                $season_data = DB::select("SELECT * FROM `tbl_season` WHERE hotel_id = ? AND ? BETWEEN 
                    STR_TO_DATE(CONCAT(?, '-', sesonstart_month, '-', sesonstart_day), '%Y-%m-%d') AND 
                    STR_TO_DATE(CONCAT(?, '-', sesonend_month, '-', sesonend_day), '%Y-%m-%d')",
                    [$hotel_id, $hoteldate, $travel_year, $travel_year]);

                if (count($season_data) > 0) {
                    $noof_coupleroom_price = $season_data[0]->couple_price;
                    $noof_extrabed_price = $season_data[0]->adult_extra;
                    $noof_kidsroom_price = $season_data[0]->kid_price;
                } else {
                    $default_price = DB::table('tbl_hotel')->where('hotel_id', $hotel_id)->value('default_price');
                    $noof_coupleroom_price = $default_price;
                    $noof_extrabed_price = $default_price;
                    $noof_kidsroom_price = $default_price;
                }

                $hotel_coupleroom_price += $noof_coupleroom_price * $noof_coupleroom;
                $hotel_extrabed_price += $noof_extrabed_price * $noof_extrabed;
                $hotel_kidsroom_price += $noof_kidsroom_price * $noof_kidsroom;

                $rowspan++;
            }

            $total_coupleroom_price += $hotel_coupleroom_price;
            $total_extrabed_price += $hotel_extrabed_price;
            $total_kidsroom_price += $hotel_kidsroom_price;
        }

        $total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;		
		$total_vehicle_price = $vehicle_price*$no_ofdays;


        $airport_pickup = 0;
		$airport_pickup_price = 0;

        if($request->has('airport_pickup')) {
			$airport_pickup_price = $pick_drop_price;
			$airport_pickup = 1;
		}

        $airport_drop = 0;
		$airport_drop_price = 0;
		if($request->has('airport_drop')) {
			$airport_drop_price = $pick_drop_price;
			$airport_drop = 1;
		}

        $sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;

        $parameters =  DB::table('tbl_parameters')
            ->select('parameter', 'par_value', 'parid')
            ->where('param_type', 'CS')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get();

        // return view('website.bookingDownload',[
        //     'status'=>200,
        //     'tpackage_name'=>$tpackage_name,//
        //     'adult' => $quantity_adult,//
        //     'child' => $quantity_child,//
        //     'field_value' => $field_value,//
        //     'hid_packageid' =>$hid_packageid,
        //     'parameters'=>$parameters,
        //     'vehicle' => $vehicle_name,
        //     'travel_date' => $travel_date,
        //     'accommodation' => $accommodation_name,
        //     'airport_pickup' => $airport_pickup,
        //     'airport_drop' => $airport_drop,
        //     'total_price' => number_format($total_price, 2)
        // ]);

       $viewData = [
            'status'=>200,
            'tpackage_name'=>$tpackage_name,//
            'adult' => $quantity_adult,//
            'child' => $quantity_child,//
            'field_value' => $field_value,//
            'hid_packageid' =>$hid_packageid,
            'parameters'=>$parameters,
            'vehicle' => $vehicle_name,
            'travel_date' => $travel_date,
            'accommodation' => $accommodation_name,
            'airport_pickup' => $airport_pickup,
            'airport_drop' => $airport_drop,
            'total_price' => number_format($total_price, 2)
        ];


        
        return view('website.bookingDownload', $viewData);
        // $pdf = Pdf::loadView('website.bookingDownload', $viewData);
        // return $pdf->download('TourQuote.pdf');
       
    }

    public function generateDoc(Request $request)
    {
        $hid_packageid = $request->input('hid_packageid');
        $quantity_adult = (int) $request->input('quantity_adult');
        $quantity_child = (int) $request->input('quantity_child');
        $travel_date = $request->input('travel_date');

        $splitdate = explode("/",$travel_date);		
		$travel_date_format = $splitdate[2]."-".$splitdate[1]."-".$splitdate[0];
		$travel_year = date("Y", strtotime($travel_date_format));

        // Fetch package info
        $package_data = DB::table('tbl_tourpackages')
            ->select('tpackage_name', 'package_duration', 'pmargin_perctage', 'starting_city')
            ->where('tourpackageid', $hid_packageid)
            ->first();
        $package_duration = $package_data->package_duration;
        $pmargin_perctage = $package_data->pmargin_perctage;
        $starting_city = $package_data->starting_city;
        $tpackage_name = $package_data->tpackage_name;


        $no_ofdays = DB::table('tbl_package_duration')->where('durationid', $package_data->package_duration)->value('no_ofdays');
        $pick_drop_price = DB::table('tbl_destination')->where('destination_id', $package_data->starting_city)->value('pick_drop_price');


        
        $vehicle = $request->input('vehicle');

        // Get vehicle price
        $get_vehicles = DB::table('tbl_vehicleprices as a')
            ->join('tbl_vehicletypes as b', 'a.vehicle_name', '=', 'b.vehicleid')
            ->where('a.destination', $package_data->starting_city)
            ->where('a.vehicle_name', $vehicle)
            ->select('a.price', 'b.vehicle_name', 'b.vehicleid')
            ->first();

        $vehicle_name = $get_vehicles ? $get_vehicles->vehicle_name : "";
        $vehicle_price = $get_vehicles ? $get_vehicles->price : 0;


        $noof_coupleroom = 0;
		$noof_extrabed = 0;
		$noof_kidsroom = 0;
		$noof_coupleroom_price = 0;
		$noof_extrabed_price = 0;
		$noof_kidsroom_price = 0;
		$total_coupleroom_price = 0;
		$total_extrabed_price = 0;
		$total_kidsroom_price = 0;
		$total_traveller = $quantity_adult+$quantity_child;

        if($total_traveller <=2)
		{
			$noof_coupleroom = 1;
		}
		else 
		{			
			if($total_traveller % 2 == 0)
			{
				$noof_coupleroom = $total_traveller/2;
			}
			else
			{
				$noof_coupleroom = floor($total_traveller/2);
				if($quantity_child > 0)
					$noof_kidsroom = 1;
				else
					$noof_extrabed = 1;
			}
		}

        $accommodation_type = $request->input('accommodation_type');

        $accommodation_name = DB::table('tbl_hotel_type')->where('hotel_type_id', $accommodation_type)->value('hotel_type_name');
        $noof_hotels = DB::table('tbl_package_accomodation')->where('package_id', $hid_packageid)->count();

        // Handle selected hotels
        $field_value = [];
        for ($i = 1; $i <= $noof_hotels; $i++) {
            $fieldname = "hotelradio_" . $i;
            if ($request->has($fieldname)) {
                $field_value[] = $request->input($fieldname);
            }
        }
        
        $all_hotel_ids = implode(",",$field_value);
	    $rowspan = 1;

        foreach ($field_value as $hotel_id) {
            $hotel_coupleroom_price = 0;
            $hotel_extrabed_price = 0;
            $hotel_kidsroom_price = 0;

            $acc_destination_id = DB::table('tbl_hotel')->where('hotel_id', $hotel_id)->value('destination_name');
            $noof_nights = DB::table('tbl_package_accomodation')
                ->where('package_id', $hid_packageid)
                ->where('destination_id', $acc_destination_id)
                ->where('bit_Deleted_Flag', 0)
                ->value('noof_days');

            for ($n = 0; $n < $noof_nights; $n++) {
                $hoteldate = date("Y-m-d", strtotime("+$n days", strtotime($travel_date_format)));

                $season_data = DB::select("SELECT * FROM `tbl_season` WHERE hotel_id = ? AND ? BETWEEN 
                    STR_TO_DATE(CONCAT(?, '-', sesonstart_month, '-', sesonstart_day), '%Y-%m-%d') AND 
                    STR_TO_DATE(CONCAT(?, '-', sesonend_month, '-', sesonend_day), '%Y-%m-%d')",
                    [$hotel_id, $hoteldate, $travel_year, $travel_year]);

                if (count($season_data) > 0) {
                    $noof_coupleroom_price = $season_data[0]->couple_price;
                    $noof_extrabed_price = $season_data[0]->adult_extra;
                    $noof_kidsroom_price = $season_data[0]->kid_price;
                } else {
                    $default_price = DB::table('tbl_hotel')->where('hotel_id', $hotel_id)->value('default_price');
                    $noof_coupleroom_price = $default_price;
                    $noof_extrabed_price = $default_price;
                    $noof_kidsroom_price = $default_price;
                }

                $hotel_coupleroom_price += $noof_coupleroom_price * $noof_coupleroom;
                $hotel_extrabed_price += $noof_extrabed_price * $noof_extrabed;
                $hotel_kidsroom_price += $noof_kidsroom_price * $noof_kidsroom;

                $rowspan++;
            }

            $total_coupleroom_price += $hotel_coupleroom_price;
            $total_extrabed_price += $hotel_extrabed_price;
            $total_kidsroom_price += $hotel_kidsroom_price;
        }

        $total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;		
		$total_vehicle_price = $vehicle_price*$no_ofdays;


        $airport_pickup = 0;
		$airport_pickup_price = 0;

        if($request->has('airport_pickup')) {
			$airport_pickup_price = $pick_drop_price;
			$airport_pickup = 1;
		}

        $airport_drop = 0;
		$airport_drop_price = 0;
		if($request->has('airport_drop')) {
			$airport_drop_price = $pick_drop_price;
			$airport_drop = 1;
		}

        $sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;

        $parameters =  DB::table('tbl_parameters')
            ->select('parameter', 'par_value', 'parid')
            ->where('param_type', 'CS')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get();

        // return view('website.bookingDownload',[
        //     'status'=>200,
        //     'tpackage_name'=>$tpackage_name,//
        //     'adult' => $quantity_adult,//
        //     'child' => $quantity_child,//
        //     'field_value' => $field_value,//
        //     'hid_packageid' =>$hid_packageid,
        //     'parameters'=>$parameters,
        //     'vehicle' => $vehicle_name,
        //     'travel_date' => $travel_date,
        //     'accommodation' => $accommodation_name,
        //     'airport_pickup' => $airport_pickup,
        //     'airport_drop' => $airport_drop,
        //     'total_price' => number_format($total_price, 2)
        // ]);

       $viewData = [
            'status'=>200,
            'tpackage_name'=>$tpackage_name,//
            'adult' => $quantity_adult,//
            'child' => $quantity_child,//
            'field_value' => $field_value,//
            'hid_packageid' =>$hid_packageid,
            'parameters'=>$parameters,
            'vehicle' => $vehicle_name,
            'travel_date' => $travel_date,
            'accommodation' => $accommodation_name,
            'airport_pickup' => $airport_pickup,
            'airport_drop' => $airport_drop,
            'total_price' => number_format($total_price, 2)
        ];


        
        // return view('website.bookingDownload', $viewData);

    $html = view('website.bookingDownload', $viewData)->render();
    // Ensure HTML is properly wrapped to avoid PhpWord DOM issues
    $dom = new \DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $wrappedHtml = '<html><body>' . $html . '</body></html>';
    $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    $cleanHtml = $dom->saveHTML();

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $cleanHtml, false, false);

    $fileName = 'TourQuote_' . time() . '.docx';
    $filePath = storage_path($fileName);

    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($filePath);

    return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
