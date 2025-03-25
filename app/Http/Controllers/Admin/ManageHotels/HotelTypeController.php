<?php

namespace App\Http\Controllers\Admin\ManageHotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class HotelTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_hotel_type')
                ->select('hotel_type_id', 'hotel_type_name', 'status')
                ->where('bit_Deleted_Flag', 0);

            return DataTables::of($data)
                // Filter for searching by hotel_type_name
                ->filterColumn('hotel_type_name', function($query, $keyword) {
                    $query->where('hotel_type_name', 'like', "%{$keyword}%");
                })
                ->addColumn('status', function ($row) {
                    $btnClass = $row->status == 1 ? 'btn-outline-success' : 'btn-outline-dark';
                    $label = $row->status == 1 ? 'Active' : 'Inactive';

                    return '
                        <form action="'.route('admin.manageHoteltype.activeHotelType', ['id' => $row->hotel_type_id]).'"
                            method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                            '.csrf_field().'
                            <button type="submit" class="btn '.$btnClass.' btn-sm">
                                <span class="label-custom label">'.$label.'</span>
                            </button>
                        </form>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.manageHoteltype.editHotelType', ['id' => $row->hotel_type_id]);
                    $deleteUrl = route('admin.manageHoteltype.deleteHotelType', ['id' => $row->hotel_type_id]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 12;

                    $buttons = '
                        <div class="d-flex gap-1">
                            <a href="'.$editUrl.'" class="btn btn-success btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>';
                    
                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this hotel type?\')">
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

        return view('admin.managehotels.manageHotelType');
    }

    public function addHotelType(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'hotelType' => 'required|string|max:255',
            ]);

            try {
                // Insert data into the database
                DB::table('tbl_hotel_type')->insert([
                    'hotel_type_name' => $request->input('hotelType'),
                    'status'=>1,
                    'created_date' => now(),
                    'created_by' => isset(session('user')->adminid) ? session('user')->adminid : 0 ,
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                ]);

                return back()->with('success', 'Hotel Type Added successfully!');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding hotel type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to add hotel type.'])->withInput();
            }
        }

        return view('admin.managehotels.addHotelType');
    }

    public function editHotelType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Hotel Type not found!']);
        }

        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'hotelType' => 'required|string|max:255',
            ]);

            try {
                // Update the record in the database
                DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                    'hotel_type_name' => $request->input('hotelType'),
                    'status'=>1,
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
                ]);

                return back()->with('success', 'Hotel Type updated successfully!');
            } catch (Exception $e) {
                // Log the error
                Log::error('Error updating Hotel type: ' . $e->getMessage());

                return back()->withErrors(['error' => 'Something went wrong! Unable to update hotel type.'])->withInput();
            }
        }

        // Show edit form with existing data
        return view('admin.managehotels.editHotelType', ['hoteltype' => $data]);
    }

    public function deleteHotelType(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Hotel Type not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                'bit_Deleted_Flag' => 1,
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Hotel Type deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Hotel Type: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Hotel Type.']);
        }
    }
    
    public function activeHotelType(Request $request, $id)
    {
        $data = DB::table('tbl_hotel_type')->select('status')->where('hotel_type_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Hotel type not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Hotel type Inactive successfully!');
            }else{
                DB::table('tbl_hotel_type')->where('hotel_type_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Hotel type Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive hotel type: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Hotel type.']);
        }
    }
}
