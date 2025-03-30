<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackagePdfController extends Controller
{
    public function index(Request $request){
        return view('admin.managepackages.generatePackage');
    }
}
