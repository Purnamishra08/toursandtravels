<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class PackageDurationsController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_package_duration')->where('bit_Deleted_Flag', 0)->paginate(10);
        return view('admin.managepackages.managePackageDurations', ['packageDurations' => $data]);
    }
}
