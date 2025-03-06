<?php

namespace App\Http\Controllers\Admin\ManageHotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class HotelController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_hotel as a')
            ->join('tbl_destination as b', 'a.destination_name', '=', 'b.destination_id')
            ->join('tbl_hotel_type as c', 'a.hotel_type', '=', 'c.hotel_type_id')
            ->where('a.bit_Deleted_Flag', 0)
            ->select(
                'a.hotel_id', 
                'a.hotel_name', 
                'a.destination_name as destId', 
                'a.hotel_type as hotelId', 
                'a.default_price', 
                'a.room_type', 
                'a.trip_advisor_url', 
                'a.star_rating', 
                'a.status', 
                'b.destination_name', 
                'c.hotel_type_name'
            )
            ->paginate(10);

        return view('admin.managehotels.manageHotel', ['hotels' => $data]);
    }

    public function addHotel(Request $request)
    {
        // Fetch dropdown data
        $destination = DB::table('tbl_destination')
            ->select('destination_id', 'destination_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $hotelType = DB::table('tbl_hotel_type')
            ->select('hotel_type_id', 'hotel_type_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $seasonType = DB::table('tbl_season_type')
            ->select('season_type_id', 'season_type_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        if ($request->isMethod('post')) {
            // Validate input fields
            $request->validate([
                'hotel_name'       => 'required|string|max:255',
                'destinationid' => 'required|string|max:255',
                'hotel_type'       => 'required|string|max:255',
                'default_price'    => 'required|numeric|min:0',
                'room_type'        => 'required|string|max:255',
                'trip_url'         => 'nullable|url',
                'star_ratings'     => 'required|numeric|between:1,5',
            ]);

            try {
                $hname      = $request->hotel_name;
                $destname   = $request->destinationid;
                $htype      = $request->hotel_type;
                $hdprice    = $request->default_price;
                $room_type  = $request->room_type;
                $trip_url   = $request->trip_url;
                $star_ratings = $request->star_ratings;
                $userid     = isset(session('user')->adminid) ? session('user')->adminid : 0;
                $date       = now();

                // Check if hotel already exists
                $duplicate = DB::table('tbl_hotel')
                    ->where('hotel_name', $hname)
                    ->where('destination_name', $destname)
                    ->count();

                if ($duplicate > 0) {
                    return back()->withErrors(['error' => 'This hotel already exists in this destination.'])->withInput();
                }

                // Insert new hotel
                $hotel_id = DB::table('tbl_hotel')->insertGetId([
                    'hotel_name'       => $hname,
                    'destination_name' => $destname,
                    'hotel_type'       => $htype,
                    'default_price'    => $hdprice,
                    'room_type'        => $room_type,
                    'trip_advisor_url' => $trip_url,
                    'star_rating'      => $star_ratings,
                    'status'           => 1,
                    'created_by'       => $userid,
                    'created_date'     => $date,
                    'updated_by'       => $userid,
                    'updated_date'     => $date,
                ]);

                // Insert season-wise pricing if available
                if ($request->has('season_type')) {
                    $seasonData = [];
                    foreach ($request->season_type as $index => $seasonType) {
                        $seasonData[] = [
                            'hotel_id'         => $hotel_id,
                            'season_type'      => $seasonType,
                            'sesonstart_month' => $request->from_startmonth[$index],
                            'sesonend_month'   => $request->from_endmonth[$index],
                            'sesonstart_day'   => $request->from_startdate[$index],
                            'sesonend_day'     => $request->from_enddate[$index],
                            'adult_price'      => $request->adult_price[$index],
                            'couple_price'     => $request->couple_price[$index],
                            'kid_price'        => $request->kid_price[$index],
                            'adult_extra'      => $request->adult_extra[$index],
                            'status'           => 1,
                            'created_date'     => $date,
                            'created_by'       => $userid,
                            'updated_by'       => $userid,
                            'updated_date'     => $date,
                        ];
                    }
                    DB::table('tbl_season')->insert($seasonData);
                }

                return back()->with('success', 'Hotel added successfully!');
            } catch (\Exception $e) {
                // Log the error
                Log::error('Error adding hotel: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add hotel.'])->withInput();
            }
        }

        return view('admin.managehotels.addHotel', [
            'destinations' => $destination,
            'hotelTypes'   => $hotelType,
            'seasonTypes'  => $seasonType,
        ]);
    }

     public function activeHotel(Request $request, $id)
    {
        $data = DB::table('tbl_hotel')->select('status')->where('hotel_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Hotel not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_hotel')->where('hotel_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Hotel Inactive successfully!');
            }else{
                DB::table('tbl_hotel')->where('hotel_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Hotel Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive hotel: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Hotel.']);
        }
    }


}
