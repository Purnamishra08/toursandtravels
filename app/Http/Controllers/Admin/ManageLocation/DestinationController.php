<?php
namespace App\Http\Controllers\Admin\ManageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class DestinationController extends Controller
{
    public function index()
    {
        $destination = DB::table('tbl_destination')->where('bit_Deleted_Flag',0)->paginate(10);
        return view('admin.managelocation.destination', ['destination' => $destination]);
    }

    public function adddestination(Request $request){
        if ($request->isMethod('post')) {

        }else{
            $similarDestinations = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $nearByPlaces = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $destinationTypes = DB::table('tbl_destination_type')->select('destination_type_id','destination_type_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_type_name', 'ASC')->get();
            $categories  = DB::table('tbl_menucategories')->select('catid','cat_name')->where('status', 1)->where('bit_Deleted_Flag', 0)->get();
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            return view('admin.managelocation.adddestination', ['destinationTypes' => $destinationTypes, 'categories' => $categories, 'tags' => $tags, 'similarDestinations' => $similarDestinations, 'nearByPlaces' => $nearByPlaces]);
        }
    }
}