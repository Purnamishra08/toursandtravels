<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PackagePdfController extends Controller
{
    public function index(Request $request){
        $packages = DB::table('tbl_tourpackages')
            ->where('status',1)
            ->where('bit_Deleted_Flag',0)
            ->get();
        return view('admin.managepackages.generatePackage',['packages'=>$packages]);
    }
}
