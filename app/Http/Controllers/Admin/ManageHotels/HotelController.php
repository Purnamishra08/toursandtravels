<?php

namespace App\Http\Controllers\Admin\ManageHotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('tbl_hotel as a')
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
                );

            // ✅ Handle Filters
            if ($request->filled('hotel_name')) {
                $query->where('a.hotel_name', 'like', '%' . $request->hotel_name . '%');
            }
            if ($request->filled('destinationid')) {
                $query->where('a.destination_name', $request->destinationid);
            }
            if ($request->filled('hotel_type')) {
                $query->where('a.hotel_type', $request->hotel_type);
            }
            if ($request->filled('status')) {
                $query->where('a.status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.manageHotels.activeHotel', ['id' => $row->hotel_id]).'" 
                            method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                '.$label.'
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.manageHotels.editHotel', ['id' => $row->hotel_id]);
                    $viewUrl = route('admin.manageHotels.viewHotel', ['id' => $row->hotel_id]);
                    $deleteUrl = route('admin.manageHotels.deleteHotel', ['id' => $row->hotel_id]);

                    $buttons = '
                        <div class="d-flex gap-1">
                            <a href="'.$editUrl.'" class="btn btn-success btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="'.$viewUrl.'" class="btn btn-primary btn-sm" title="View">
                                <i class="fa fa-eye"></i>
                            </a>';
                    
                    if (session('user')->admin_type == 1) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this hotel?\')">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }

                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $destinations = DB::table('tbl_destination')
            ->select('destination_id', 'destination_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $hotelTypes = DB::table('tbl_hotel_type')
            ->select('hotel_type_id', 'hotel_type_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        return view('admin.managehotels.manageHotel', [
            'destinations' => $destinations,
            'hotelTypes'   => $hotelTypes,
        ]);
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

    public function viewHotel(Request $request, $id)
    {
        // Fetch hotel details (excluding seasons for now)
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
            ->where('a.hotel_id',$id)
            ->first(); // Since you're fetching one hotel

        if ($data) {
            // Fetch related seasons for this hotel
            $seasons = DB::table('tbl_season as a')
                ->join('tbl_season_type as b', 'a.season_type', '=', 'b.season_type_id')
                ->where('hotel_id', $id)
                ->where('a.bit_Deleted_Flag', 0)
                ->where('b.bit_Deleted_Flag', 0)
                ->select('a.season_id','a.season_type','b.season_type_name','a.sesonstart_month','a.sesonend_month','a.sesonstart_day','a.sesonend_day','a.adult_price','a.couple_price','a.kid_price','a.adult_extra',)
                ->get();

            // Add seasons as an array to the hotel object
            $data->seasons = $seasons;
        }

        // dd($data);


        return view('admin.managehotels.viewHotel', ['hotels' => $data]);
    }

    public function editHotel(Request $request, $id)
    {
        // Fetch dropdown data
        $destinations = DB::table('tbl_destination')
            ->select('destination_id', 'destination_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $hotelTypes = DB::table('tbl_hotel_type')
            ->select('hotel_type_id', 'hotel_type_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        $seasonTypes = DB::table('tbl_season_type')
            ->select('season_type_id', 'season_type_name')
            ->where('bit_Deleted_Flag', 0)
            ->where('status', 1)
            ->get();

        // Retrieve the hotel record and its seasons
        $hotel = DB::table('tbl_hotel')
            ->where('hotel_id', $id)
            ->first();

        if (!$hotel) {
            return redirect()->route('admin.manageHotels.editHotel')
                ->withErrors(['error' => 'Hotel not found.']);
        }

        $seasons = DB::table('tbl_season')
            ->where('hotel_id', $id)
            ->get();

        if ($request->isMethod('post')) {
            // Validate the hotel details
            $request->validate([
                'hotel_name'    => 'required|string|max:255',
                'destinationid' => 'required|string|max:255',
                'hotel_type'    => 'required|string|max:255',
                'default_price' => 'required|numeric|min:0',
                'room_type'     => 'required|string|max:255',
                'trip_url'      => 'nullable|url',
                'star_ratings'  => 'required|numeric|between:1,5',
            ]);

            try {
                $hname         = $request->hotel_name;
                $destid        = $request->destinationid;
                $htype         = $request->hotel_type;
                $hdprice       = $request->default_price;
                $room_type     = $request->room_type;
                $trip_url      = $request->trip_url;
                $star_ratings  = $request->star_ratings;
                $userid        = session('user')->adminid ?? 0;
                $date          = now();

                // Check for duplicate hotel (excluding the current hotel)
                $duplicate = DB::table('tbl_hotel')
                    ->where('hotel_name', $hname)
                    ->where('destination_name', $destid)
                    ->where('hotel_id', '<>', $id)
                    ->count();
                if ($duplicate > 0) {
                    return back()->withErrors(['error' => 'This hotel already exists in this destination.'])
                        ->withInput();
                }

                // Update the hotel record
                DB::table('tbl_hotel')->where('hotel_id', $id)->update([
                    'hotel_name'       => $hname,
                    'destination_name' => $destid,
                    'hotel_type'       => $htype,
                    'default_price'    => $hdprice,
                    'room_type'        => $room_type,
                    'trip_advisor_url' => $trip_url,
                    'star_rating'      => $star_ratings,
                    'updated_by'       => $userid,
                    'updated_date'     => $date,
                ]);

                // Remove current season records
                DB::table('tbl_season')->where('hotel_id', $id)->delete();

                // Insert season-wise pricing if available
                if ($request->has('season_type')) {
                    $seasonData = [];
                    foreach ($request->season_type as $index => $seasonType) {
                        $seasonData[] = [
                            'hotel_id'         => $id,
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

                return redirect()->route('admin.manageHotels.editHotel', ['id' => $id])
                    ->with('success', 'Hotel updated successfully!');
            } catch (\Exception $e) {
                Log::error('Error updating hotel: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Something went wrong! Unable to update hotel.'])
                    ->withInput();
            }
        }

        return view('admin.managehotels.editHotel', [
            'hotel'        => $hotel,
            'seasons'      => $seasons,
            'destinations' => $destinations,
            'hotelTypes'   => $hotelTypes,
            'seasonTypes'  => $seasonTypes,
        ]);
    }

    public function deleteHotel(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_hotel')->where('hotel_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Hotel not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_hotel')->where('hotel_id', $id)->update([
                'bit_Deleted_Flag' => 1,
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Hotel deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Hotel: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Hotel.']);
        }
    }
}
