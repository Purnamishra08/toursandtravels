<?php
namespace App\Http\Controllers\Website\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class FooterController extends Controller
{
    public function index(Request $request)
    {   
        
        return view('website.include.webfooter', compact('blogData', 'parameters', 'footer'));

    }
}