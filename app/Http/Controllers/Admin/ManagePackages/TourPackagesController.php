<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Exception;

class TourPackagesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $packages = DB::table('tbl_tourpackages as a')
                ->join('tbl_destination as b', 'a.starting_city', '=', 'b.destination_id')
                ->join('tbl_package_duration as c', 'a.package_duration', '=', 'c.durationid')
                ->select(
                    'a.tourpackageid',
                    'a.tpackage_name',
                    'a.price',
                    'a.tpackage_image',
                    'a.tour_thumb',
                    'a.show_in_home',
                    'a.status',
                    'b.destination_name',
                    'c.duration_name',
                )
                ->where('a.bit_Deleted_Flag', 0);

            // Apply search filters
            if ($request->filled('package_name')) {
                $packages->where('a.tpackage_name', 'like', '%' . $request->package_name . '%');
            }
            if ($request->filled('starting_city')) {
                $packages->where('a.starting_city', $request->starting_city);
            }
            if ($request->filled('duration')) {
                $packages->where('a.package_duration', $request->duration);
            }
            if ($request->filled('status')) {
                $packages->where('a.status', $request->status);
            }

            // Handle sorting
            if ($request->has('order')) {
                $columnIndex = $request->input('order')[0]['column']; // Column index
                $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
                $sortDirection = $request->input('order')[0]['dir']; // Sort direction
                $packages->orderBy($columnName, $sortDirection);
            } else {
                $packages->orderByDesc('a.tourpackageid');
            }

            return DataTables::of($packages)
                ->addIndexColumn()
                ->addColumn('banner', function ($row) {
                    return '<a href="' . asset('storage/tourpackages/' . $row->tpackage_image) . '" target="_blank">
                                <img src="' . asset('storage/tourpackages/' . $row->tpackage_image) . '" 
                                    alt="Banner Image" style="width: 100px; height: 60px; object-fit: cover;" class="rounded border">
                            </a>';
                })
                ->addColumn('thumb', function ($row) {
                    return '<a href="' . asset('storage/tourpackages/thumbs/' . $row->tour_thumb) . '" target="_blank">
                                <img src="' . asset('storage/tourpackages/thumbs/' . $row->tour_thumb) . '" 
                                    alt="Thumb Image" style="width: 100px; height: 60px; object-fit: cover;" class="rounded border">
                            </a>';
                })
                ->addColumn('show_in_home', function ($row) {
                    if ($row->show_in_home == 1) {
                        return '<form action="' . route('admin.managetourpackages.showTourPackages', ['id' => $row->tourpackageid]) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to hide in home page?\')">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <span class="label-custom label label-success">Shown</span>
                                    </button>
                                </form>';
                    } else {
                        return '<form action="' . route('admin.managetourpackages.showTourPackages', ['id' => $row->tourpackageid]) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to show in home page?\')">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-outline-dark btn-sm">
                                        <span class="label-custom label label-danger">Hidden</span>
                                    </button>
                                </form>';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<form action="' . route('admin.managetourpackages.activeTourPackages', ['id' => $row->tourpackageid]) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <span class="label-custom label label-success">Active</span>
                                    </button>
                                </form>';
                    } else {
                        return '<form action="' . route('admin.managetourpackages.activeTourPackages', ['id' => $row->tourpackageid]) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to change the status?\')">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-outline-dark btn-sm">
                                        <span class="label-custom label label-danger">Inactive</span>
                                    </button>
                                </form>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.managetourpackages.editTourPackages', ['id' => $row->tourpackageid]);
                    $viewUrl = route('admin.managetourpackages.viewTourPackages', ['id' => $row->tourpackageid]);
                    $deleteUrl = route('admin.managetourpackages.deleteTourPackages', ['id' => $row->tourpackageid]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 10;

                    $buttons = '<div class="d-flex gap-1">
                                    <a href="' . $editUrl . '" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                    <a href="' . $viewUrl . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>';

                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '<form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this package?\')">
                                        ' . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>';
                    }

                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['banner', 'thumb', 'show_in_home' ,'status', 'action'])
                ->make(true);
        }

        $durations = DB::table('tbl_package_duration')
            ->select('durationid', 'duration_name')
            ->where('bit_Deleted_Flag', 0)
            ->get();

        $destinations = DB::table('tbl_destination')
            ->select('destination_id', 'destination_name')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->get();

        return view('admin.managepackages.manageTourPackages', [
            'durations' => $durations,
            'destinations' => $destinations,
        ]);
    }

    public function getItineraryAddmore(Request $request)
    {
        $durationId = $request->input('duration_id');

        // Fetch number of days for the selected duration
        $package = DB::table('tbl_package_duration')
            ->where('durationid', $durationId)
            ->first();

        if ($package) {
            $noOfDays = $package->no_ofdays;

            // Fetch active places
            $places = DB::table('tbl_places')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('place_name', 'asc')
                ->get();

            $html = '<div class="box-main"><fieldset>';
            $html .= '<legend>Itinerary Details</legend>';
            $html .= '<div class="col-md-12">';

            for ($i = 1; $i <= $noOfDays; $i++) {
                $html .= '<div class="row mb10">';
                
                // Day Number
                $html .= '<div class="col-md-1">';
                if ($i == 1) {
                    $html .= '<label>Day</label><br>';
                }
                $html .= '<label>' . $i . ':</label>';
                $html .= '</div>';

                // Itinerary Title
                $html .= '<div class="col-md-6">';
                if ($i == 1) {
                    $html .= '<label>Itinerary Title</label>';
                }
                $html .= '<input type="text" class="form-control mb-2" placeholder="Itinerary Title" name="title[]">';
                $html .= '<textarea name="itineraryDesc['.$i.']" id="itineraryDesc_'.$i.'" class="form-control mb-2" placeholder="Itinerary Description..."></textarea>';
                $html .= '</div>';

                // Itinerary Places (Dropdown)
                $html .= '<div class="col-md-5">';
                if ($i == 1) {
                    $html .= '<label>Itinerary Places</label>';
                }
                $html .= '<select class="form-control chosen-select" name="getplaceid[' . $i . '][]" multiple>';
                
                foreach ($places as $place) {
                    $html .= '<option value="' . $place->placeid . '">' . $place->place_name . '</option>';
                }

                $html .= '</select>';
                $html .= '<input type="text" class="form-control mt-2" placeholder="Other Itinerary Places" name="otherItineraryPlaces[]">';
                $html .= '</div>';

                $html .= '</div>'; // Close row
            }

            $html .= '</div>'; // Close col-md-12
            $html .= '</fieldset></div>'; // Close box-main

           $html .= <<<SCRIPT
            <script>
                $(document).ready(function() {
                    $('.chosen-select').chosen();
                    
                    // Initialize CKEditor for each textarea dynamically
                    $('textarea[name^="itineraryDesc"]').each(function() {
                        CKEDITOR.replace($(this).attr('id'));
                    });
                });
            </script>
            SCRIPT;

            return response()->json($html);
        }

        return response()->json('');
    
    }

    public function addTourPackages(Request $request)
    {
        if ($request->isMethod('get')) {
            $durations = DB::table('tbl_package_duration')
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('duration_name', 'asc')
                ->get();

            $packageTypes = DB::table('tbl_parameters')
                ->where('param_type', 'PT')
                ->where('bit_Deleted_Flag', 0)
                ->where('status', 1)
                ->orderBy('par_value', 'asc')
                ->get();

            $itineraries = DB::table('tbl_itinerary')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('itinerary_name', 'asc')
                ->get();

            $destinations = DB::table('tbl_destination')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('destination_name', 'asc')
                ->get();

            $availableDestinations = $destinations;

            
            $inclusionExclusion = DB::table('tbl_parameters')
            ->select('parameter', 'par_value', 'parid')
            ->where('param_type', 'CS')
            ->where('parid', '22')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->first();

            $tags = DB::table('tbl_menutags')
                ->where('status', 1)
                ->where('menuid', 3)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('tag_name', 'asc')
                ->get();

            $max_noof_days = DB::table('tbl_package_duration')->max('no_ofdays');


            return view('admin.managepackages.addTourPackages', [
                'durations' => $durations,
                'packageTypes' => $packageTypes,
                'itineraries' => $itineraries,
                'destinations' => $destinations,
                'availableDestinations' => $availableDestinations,
                'tags' => $tags,
                'max_noof_days' => $max_noof_days,
                'inclusionExclusion'=>$inclusionExclusion
            ]);
        }

        $validated = $request->validate([
            'tpackage_name'    => 'required|string|max:255',
            'tpackage_url'     => 'required|string|max:255|unique:tbl_tourpackages,tpackage_url',
            'tpackage_code'    => 'required|string|max:255|unique:tbl_tourpackages,tpackage_code',
            'pduration'        => 'required',
            'price'            => 'required|numeric',
            'fakeprice'        => 'required|numeric',
            'getatagid'        => 'required|array',
            'pmargin_perctage' => 'required|numeric',
            'alttag_banner'    => 'required|string|max:60',
            'alttag_thumb'     => 'required|string|max:60',
            'alttag_details'   => 'required|string|max:60',
            'starting_city'    => 'required',
            'inclusion'        => 'required',
            'tourimg'          => 'nullable|image|dimensions:width=1900,height=300',
            'tourthumb'        => 'nullable|image|dimensions:width=300,height=225',
            'tour_details_img'      => 'nullable|image|dimensions:width=900,height=300',
        ]);

        try {
            DB::beginTransaction();

            $show_video_itinerary = $request->has('show_video_itinerary') ? 1 : 0;
            $randomNumber = mt_rand(10000, 99999);
            // ✅ Handle Tour Image Upload
            if ($request->hasFile('tourimg')) {
                $tourimgFile = $request->file('tourimg');
                $tourimgfilename = Str::slug($validated['alttag_banner']).'-'.$randomNumber.'.webp';

                // Convert and Store as WebP
                $this->convertToWebp($tourimgFile, storage_path('app/public/tourpackages/' . $tourimgfilename), 1900, 300);
            }

            // ✅ Handle Tour Thumbnail Upload
            if ($request->hasFile('tourthumb')) {
                $tourthumbFile = $request->file('tourthumb');
                $tourthumbfilename = Str::slug($validated['alttag_thumb']).'-'. $randomNumber . '.webp';

                // Convert and Store as WebP
                $this->convertToWebp($tourthumbFile, storage_path('app/public/tourpackages/thumbs/' . $tourthumbfilename), 300, 225);
            }
            // ✅ Handle Tour Details Upload
            if ($request->hasFile('tour_details_img')) {
                $tourDetails = $request->file('tour_details_img');
                $tourDetailsFilename = Str::slug($validated['alttag_details']).'-'. $randomNumber . '.webp';

                // Convert and Store as WebP
                $this->convertToWebp($tourDetails, storage_path('app/public/tourpackages/details/' . $tourDetailsFilename), 900, 300);
            }

            // if ($request->hasFile('tourimg')) {
            //     $tourimgFile = $request->file('tourimg');
            //     $tourimgfilename = Str::slug($validated['alttag_banner']) . '.' . $tourimgFile->getClientOriginalExtension();
            //     $tourimgFile->storeAs('public/tourpackages', $tourimgfilename);
            // } else {
            //     $tourimgfilename = null;
            // }

            // if ($request->hasFile('tourthumb')) {
            //     $tourthumbFile = $request->file('tourthumb');
            //     $tourthumbfilename = Str::slug($validated['alttag_thumb']) . '.' . $tourthumbFile->getClientOriginalExtension();
            //     $tourthumbFile->storeAs('public/tourpackages/thumbs', $tourthumbfilename);
            // } else {
            //     $tourthumbfilename = null;
            // }

            $duplicateCount = DB::table('tbl_tourpackages')
                ->where(function ($query) use ($validated) {
                    $query->where('tpackage_code', $validated['tpackage_code'])
                        ->orWhere('tpackage_url', $validated['tpackage_url']);
                })->count();

            if ($duplicateCount > 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'You have already added this tour package, package name or URL must be unique.']);
            }

            $data = [
                'tpackage_name'        => $validated['tpackage_name'],
                'tpackage_url'         => $validated['tpackage_url'],
                'tpackage_code'        => $validated['tpackage_code'],
                'package_duration'     => $validated['pduration'],
                'pmargin_perctage'     => $validated['pmargin_perctage'],
                'tpackage_image'       => $tourimgfilename,
                'tour_thumb'           => $tourthumbfilename,
                'tour_details_img'         => $tourDetailsFilename,
                'price'                => $validated['price'],
                'fakeprice'            => $validated['fakeprice'],
                'about_package'        => $request->input('about_package',""),
                'ratings'              => $request->input('rating',0),
                'inclusion_exclusion'  => $validated['inclusion'],
                'alttag_banner'        => $validated['alttag_banner'],
                'alttag_thumb'         => $validated['alttag_thumb'],
                'alttag_details'       => $validated['alttag_details'],
                'itinerary_note'       => $request->input('itinerary_note',""),
                'accomodation'         => $request->input('accomodation', 0),
                'tourtransport'        => $request->input('tourtransport', 0),
                'sightseeing'          => $request->input('sightseeing', 0),
                'breakfast'            => $request->input('breakfast', 0),
                'waterbottle'          => $request->input('waterbottle', 0),
                'status'               => 1,
                'pack_type'            => $request->input('packtype',0),
                'starting_city'        => $validated['starting_city'],
                'meta_title'           => $request->input('meta_title',""),
                'meta_keywords'        => $request->input('meta_keywords',""),
                'meta_description'     => $request->input('meta_description',""),
                'show_video_itinerary' => $show_video_itinerary,
                'video_itinerary_link' => $request->input('video_itinerary_link',""),
                'created_date'         => now(),
                'created_by'           => session('user')->adminid ?? 0,
            ];

            $lastId = DB::table('tbl_tourpackages')->insertGetId($data);

            foreach ($validated['getatagid'] as $tagid) {
                DB::table('tbl_tags')->insert([
                    'type_id' => $lastId,
                    'type'    => 3,
                    'tagid'   => $tagid,
                ]);
            }

            $destination_ids = $request->input('destination_id',"");
            $no_ofdays       = $request->input('no_ofdays',"");

            if (is_array($destination_ids)) {
                foreach ($destination_ids as $i => $dest_id) {
                    if (!empty($dest_id) && !empty($no_ofdays[$i])) {
                        DB::table('tbl_package_accomodation')->insert([
                            'package_id'     => $lastId,
                            'destination_id' => $dest_id,
                            'noof_days'      => $no_ofdays[$i],
                        ]);
                    }
                }
            }

            $title = $request->input('title') ?? [];
            $itineraryDesc = $request->input('itineraryDesc') ?? [];
            $place_id = $request->input('getplaceid') ?? [];
            $otherItineraryPlaces = $request->input('otherItineraryPlaces') ?? [];
            if (count($title) > 0) {
                for ($k = 0; $k < count($title); $k++) {
                    DB::table('tbl_itinerary_daywise')->insert([
                        'package_id' => $lastId,
                        'title' => $title[$k],
                        'itinerary_desc' => $itineraryDesc[$k+1],
                        'place_id' => implode(",", $place_id[$k+1] ?? []),
                        'other_iternary_places' => $otherItineraryPlaces[$k],
                        'created_date' => now(),
                        'created_by' => session('user')->adminid ?? 0
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.managetourpackages')->with('success', 'Package added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add package: ' . $e->getMessage()]);
        }
    }

    public function editTourPackages(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            $tourPackage = DB::table('tbl_tourpackages')->where('tourpackageid', $id)->first();

            if (!$tourPackage) {
                return redirect()->back()->with('error', 'Tour package not found.');
            }

            $durations = DB::table('tbl_package_duration')
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('duration_name', 'asc')
                ->get();

            $packageTypes = DB::table('tbl_parameters')
                ->where('param_type', 'PT')
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('par_value', 'asc')
                ->get();

            $itineraries = DB::table('tbl_itinerary')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('itinerary_name', 'asc')
                ->get();

            $destinations = DB::table('tbl_destination')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('destination_name', 'asc')
                ->get();

            $availableDestinations = $destinations;
            $insertedAccomodation = DB::table('tbl_package_accomodation')
                ->where('package_id', $id)
                ->where('bit_Deleted_Flag', 0)
                ->get();

            $tags = DB::table('tbl_menutags')
                ->where('status', 1)
                ->where('menuid', 3)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('tag_name', 'asc')
                ->get();

            $selectedTags = DB::table('tbl_tags')
                ->where('type_id', $id)
                ->where('type', 3)
                ->where('bit_Deleted_Flag', 0)
                ->get();

            $max_noof_days = DB::table('tbl_package_duration')->max('no_ofdays');

            return view('admin.managepackages.editTourPackages', [
                'tourPackage' => $tourPackage,
                'durations' => $durations,
                'packageTypes' => $packageTypes,
                'itineraries' => $itineraries,
                'destinations' => $destinations,
                'availableDestinations' => $availableDestinations,
                'insertedAccomodation' => $insertedAccomodation,
                'tags' => $tags,
                'selectedTags' => $selectedTags,
                'max_noof_days' => $max_noof_days
            ]);
        }

        $validated = $request->validate([
            'tpackage_name' => 'required|string|max:255',
            'tpackage_url' => 'required|string|max:255|unique:tbl_tourpackages,tpackage_url,' . $id . ',tourpackageid',
            'tpackage_code' => 'required|string|max:255|unique:tbl_tourpackages,tpackage_code,' . $id . ',tourpackageid',
            'pduration' => 'required',
            'price' => 'required|numeric',
            'fakeprice' => 'required|numeric',
            'getatagid' => 'required|array',
            'pmargin_perctage' => 'required|numeric',
            'alttag_banner' => 'required|string|max:60',
            'alttag_thumb' => 'required|string|max:60',
            'alttag_details'   => 'required|string|max:60',
            'starting_city' => 'required',
            'inclusion' => 'required',
            'tourimg' => 'nullable|image|dimensions:width=1900,height=300',
            'tourthumb' => 'nullable|image|dimensions:width=300,height=225',
        ]);
        
        try {
            DB::beginTransaction();
            
            $show_video_itinerary = $request->has('show_video_itinerary') ? 1 : 0;
            
            $tourPackage = DB::table('tbl_tourpackages')->where('tourpackageid', $id)->first();
            
            $tourimgfilename = $tourPackage->tpackage_image;
            $tourthumbfilename = $tourPackage->tour_thumb;
            $randomNumber = mt_rand(10000, 99999);
            // ✅ Handle tour image
        //     if ($request->hasFile('tourimg')) {
        //         $tourimgFile = $request->file('tourimg');
        //         $tempTourimgfilename = Str::slug($validated['alttag_banner']) . '.' . $tourimgFile->getClientOriginalExtension();
        //         $tourimgFile->storeAs('public/tourpackages', $tempTourimgfilename);
                
        //         // Store temporary name, will finalize if DB transaction succeeds
        //         $tourimgfilename = $tempTourimgfilename;
        //     }
            
        // // ✅ Handle tour thumb
        // if ($request->hasFile('tourthumb')) {
        //     $tourthumbFile = $request->file('tourthumb');
        //     $tempTourthumbfilename = Str::slug($validated['alttag_thumb']) . '.' . $tourthumbFile->getClientOriginalExtension();
        //     $tourthumbFile->storeAs('public/tourpackages/thumbs', $tempTourthumbfilename);
            
        //     // Store temporary name, will finalize if DB transaction succeeds
        //     $tourthumbfilename = $tempTourthumbfilename;
        // }

        // ✅ Handle Tour Image Upload
        if ($request->hasFile('tourimg')) {
            $tourimgFile = $request->file('tourimg');
            $tourimgfilename = Str::slug($validated['alttag_banner']).'-'.$randomNumber.'.webp';

            // Convert and Store as WebP
            $this->convertToWebp($tourimgFile, storage_path('app/public/tourpackages/' . $tourimgfilename), 1900, 300);
        }

        // ✅ Handle Tour Thumbnail Upload
        if ($request->hasFile('tourthumb')) {
            $tourthumbFile = $request->file('tourthumb');
            $tourthumbfilename = Str::slug($validated['alttag_thumb']).'-'.$randomNumber.'.webp';

            // Convert and Store as WebP
            $this->convertToWebp($tourthumbFile, storage_path('app/public/tourpackages/thumbs/' . $tourthumbfilename), 300, 225);
        }

        // ✅ Handle Tour Details Upload
            if ($request->hasFile('tour_details_img')) {
                $tourDetails = $request->file('tour_details_img');
                $tourDetailsFilename = Str::slug($validated['alttag_details']).'-'. $randomNumber . '.webp';

                // Convert and Store as WebP
                $this->convertToWebp($tourDetails, storage_path('app/public/tourpackages/details/' . $tourDetailsFilename), 900, 300);
            }
        
        // ✅ Update tour package
        DB::table('tbl_tourpackages')->where('tourpackageid', $id)->update([
            'tpackage_name' => $validated['tpackage_name'],
            'tpackage_url' => $validated['tpackage_url'],
            'tpackage_code' => $validated['tpackage_code'],
            'package_duration' => $validated['pduration'],
            'pmargin_perctage' => $validated['pmargin_perctage'],
            'tpackage_image' => $tourimgfilename,
            'tour_thumb' => $tourthumbfilename,
            'tour_details_img'         => $tourDetailsFilename,
            'price' => $validated['price'],
            'fakeprice' => $validated['fakeprice'],
            'about_package'        => $request->input('about_package',""),
            'ratings' => $request->input('rating',0),
            'inclusion_exclusion' => $validated['inclusion'],
            'alttag_banner' => $validated['alttag_banner'],
            'alttag_thumb' => $validated['alttag_thumb'],
            'alttag_details'       => $validated['alttag_details'],
            'itinerary_note'       => $request->input('itinerary_note',""),
            'accomodation'         => $request->input('accomodation', 0),
            'tourtransport'        => $request->input('tourtransport', 0),
            'sightseeing'          => $request->input('sightseeing', 0),
            'breakfast'            => $request->input('breakfast', 0),
            'waterbottle'          => $request->input('waterbottle', 0),
            'status'               => 1,
            'pack_type'            => $request->input('packtype',""),
            'starting_city'        => $validated['starting_city'],
            'meta_title'           => $request->input('meta_title',""),
            'meta_keywords'        => $request->input('meta_keywords',""),
            'meta_description'     => $request->input('meta_description',""),
            'show_video_itinerary' => $show_video_itinerary,
            'video_itinerary_link' => $request->input('video_itinerary_link',""),
            'updated_date' => now(),
            'updated_by' => session('user')->adminid ?? 0
        ]);
        
        // ✅ Handle tour image cleanup only after successful DB update
        // if ($request->hasFile('tourimg')) {
        //     if ($tourPackage->tpackage_image) {
        //         $previousImagePath = storage_path('app/public/tourpackages/' . $tourPackage->tpackage_image);
        //         if (file_exists($previousImagePath)) {
        //             unlink($previousImagePath);
        //         }
        //     }
        // }
        
        // if ($request->hasFile('tourthumb')) {
        //     if ($tourPackage->tour_thumb) {
        //         $previousThumbPath = storage_path('app/public/tourpackages/thumbs/' . $tourPackage->tour_thumb);
        //         if (file_exists($previousThumbPath)) {
        //             unlink($previousThumbPath);
        //         }
        //     }
        // }
        
        // ✅ Update tags
        DB::table('tbl_tags')->where('type_id', $id)->where('type', 3)->update(['bit_Deleted_Flag' => 1]);
        foreach ($validated['getatagid'] as $tagid) {
            DB::table('tbl_tags')->updateOrInsert(
                ['type_id' => $id, 'type' => 3, 'tagid' => $tagid],
                ['bit_Deleted_Flag' => 0]
            );
        }

        $destination_ids = $request->input('destination_id',"");
        $no_ofdays       = $request->input('no_ofdays',"");

        DB::table('tbl_package_accomodation')->where('package_id', $id)->update(['bit_Deleted_Flag' => 1]);
        if (is_array($destination_ids)) {
            foreach ($destination_ids as $i => $dest_id) {
                if (!empty($dest_id) && !empty($no_ofdays[$i])) {
                    DB::table('tbl_package_accomodation')->insert([
                        'package_id'     => $id,
                        'destination_id' => $dest_id,
                        'noof_days'      => $no_ofdays[$i],
                    ]);
                }
            }
        }
        
        // ✅ Update itinerary
        $titles = $request->input('title') ?? [];
        $itineraryDesc = $request->input('itineraryDesc') ?? [];
        $place_ids = $request->input('getplaceid') ?? [];
        $otherPlaces = $request->input('otherIternaryPlaces') ?? [];
        if (!empty($titles)) {
        // Soft delete existing records
        DB::table('tbl_itinerary_daywise')
            ->where('package_id', $id)
            ->update(['bit_Deleted_Flag' => 1]);

        // Insert new records
            for ($k = 0; $k < count($titles); $k++) {
                DB::table('tbl_itinerary_daywise')->insert([
                    'package_id' => $id,
                    'title' => $titles[$k],
                    'itinerary_desc' => $itineraryDesc[$k+1],
                    'place_id' => implode(",", $place_ids[$k] ?? []),
                    'other_iternary_places' => $otherPlaces[$k],
                    'created_date' => now(),
                    'created_by' => session('user')->adminid ?? 0
                ]);
            }
        }



        DB::commit();

        return redirect()->route('admin.managetourpackages.editTourPackages',['id' => $id])->with('success', 'Package updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // ❌ If an error occurs, delete the temporary files to avoid leftover files
            if (isset($tempTourimgfilename)) {
                $tempImagePath = storage_path('app/public/tourpackages/' . $tempTourimgfilename);
                if (file_exists($tempImagePath)) {
                    unlink($tempImagePath);
                }
            }

            if (isset($tempTourthumbfilename)) {
                $tempThumbPath = storage_path('app/public/tourpackages/thumbs/' . $tempTourthumbfilename);
                if (file_exists($tempThumbPath)) {
                    unlink($tempThumbPath);
                }
            }

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function editItineraryAddmore(Request $request)
    {
        $durationId = $request->input('duration_id');
        $itineraryId = $request->input('package_id');
        
        // Get number of days from tbl_package_duration
        $duration = DB::table('tbl_package_duration')
                    ->where('durationid', $durationId)
                    ->first();
        if (!$duration) {
            return response()->json(['html' => '']);
        }

        $noOfDays = $duration->no_ofdays;

        // Get active places
        $places = DB::table('tbl_places')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->orderBy('place_name', 'asc')
                    ->get();

        // Get existing itinerary data
        $editItinerary = DB::table('tbl_itinerary_daywise')
                        ->where('package_id', $itineraryId)
                        ->where('bit_Deleted_Flag', 0)
                        ->orderBy('itinerary_daywiseid', 'asc')
                        ->get();

        $html = '<div class="box-main"><fieldset>
                    <legend>Itinerary Details</legend>
                    <div class="col-md-12">';

        $arr = 0;
        for ($i = 1; $i <= $noOfDays; $i++) {
            $itineraryTitle = $editItinerary[$arr]->title ?? '';
            $itineraryDesc = $editItinerary[$arr]->itinerary_desc ?? '';
            $otherPlaces = $editItinerary[$arr]->other_iternary_places ?? '';
            $itineraryPlace = $editItinerary[$arr]->place_id ?? '';

            $html .= '<div class="row mb-3">
                        <div class="col-md-1">';
                $html .= '<label>Day</label>&nbsp';
            $html .= '<label>' . $i . ':</label>
                        </div>

                        <div class="col-md-6">';
            if ($i == 1) {
                $html .= '<label>Itinerary Title</label>';
            }
            $html .= '<input type="text" class="form-control mb-2" placeholder="Itinerary Title" name="title[]" value="' . htmlspecialchars($itineraryTitle) . '">
                        <textarea name="itineraryDesc['.$i.']" id="itineraryDesc_'.$i.'" class="form-control mb-2" placeholder="Itinerary Description...">' . htmlspecialchars($itineraryDesc) . '</textarea>
                        </div>

                        <div class="col-md-5">';
            if ($i == 1) {
                $html .= '<label>Itinerary Places</label>';
            }
            $html .= '<select data-placeholder="Choose itinerary places" class="chosen-select" multiple tabindex="4" id="getplaceid_' . $i . '" name="getplaceid[' . $arr . '][]" style="width: 100%;height: auto;border: 1px solid #aaa; cursor: text; font-size: 13px; padding: 5px 7px;">';

            // Add place options
            foreach ($places as $place) {
                $selected = (in_array($place->placeid, explode(',', $itineraryPlace))) ? 'selected' : '';
                $html .= '<option value="' . $place->placeid . '" ' . $selected . '>' . htmlspecialchars($place->place_name) . '</option>';
            }

            $html .= '</select>
                    <input type="text" class="form-control mt-2" placeholder="Other Itinerary Places" name="otherIternaryPlaces[]" value="' . htmlspecialchars($otherPlaces) . '">
                    </div>
                </div>';

            $arr++;
        }

        $html .= '</div>
                </fieldset></div>';

        // JavaScript to update chosen select
        $html .= '<script type="text/javascript">
                    $(document).ready(function () {';

        $arr1 = 0;
        for ($i = 1; $i <= $noOfDays; $i++) {
            $html .= '$("#getplaceid_' . $i . '").chosen();';

            $itineraryPlace = $editItinerary[$arr1]->place_id ?? '';
            if ($itineraryPlace != '') {
                $tagArray = explode(',', $itineraryPlace);
                $html .= 'CKEDITOR.replace("itineraryDesc_'.$i.'");';
                $html .= 'var tagArray = ' . json_encode($tagArray) . ';
                        $.each(tagArray, function (index, value) {
                            $("#getplaceid_' . $i . ' option[value=\'" + value + "\']").attr("selected", "selected");
                        });
                        $("#getplaceid_' . $i . '").trigger("chosen:updated");';
            }

            $arr1++;
        }

        $html .= '});
                </script>';

        // return response()->json(['html' => $html]);
        return response()->json($html);
    }

    public function viewTourPackages(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            // Fetch tour package details with related data in one query where possible
            $tourPackage = DB::table('tbl_tourpackages as a')
                ->leftJoin('tbl_package_duration as b', 'a.package_duration', '=', 'b.durationid')
                ->leftJoin('tbl_parameters as c', 'a.pack_type', '=', 'c.parid')
                ->leftJoin('tbl_destination as d', 'a.starting_city', '=', 'd.destination_id')
                ->select(
                    'a.tourpackageid',
                    'a.tpackage_name',
                    'a.tpackage_url',
                    'a.tpackage_code',
                    'a.package_duration',
                    'a.price',
                    'a.fakeprice',
                    'a.about_package',
                    'a.pmargin_perctage',
                    'a.inclusion_exclusion',
                    'a.tpackage_image',
                    'a.tour_thumb',
                    'a.alttag_banner',
                    'a.alttag_thumb',
                    'a.ratings',
                    'a.itinerary_note',
                    'a.accomodation',
                    'a.tourtransport',
                    'a.sightseeing',
                    'a.breakfast',
                    'a.waterbottle',
                    'a.status',
                    'a.pack_type',
                    'a.starting_city',
                    'a.meta_title',
                    'a.meta_keywords',
                    'a.meta_description',
                    'a.show_video_itinerary',
                    'a.video_itinerary_link',
                    'b.duration_name',
                    'c.par_value',
                    'd.destination_name as starting_city_name' // Directly get destination name
                )
                ->where('a.tourpackageid', $id)
                ->where('a.bit_Deleted_Flag', 0)
                ->first();

            if (!$tourPackage) {
                return redirect()->back()->with('error', 'Tour package not found.');
            }

            // Get tour tags using GROUP_CONCAT
            $tourTags = DB::table('tbl_tags as a')
                ->join('tbl_menutags as b', 'a.tagid', '=', 'b.tagid')
                ->where('a.type_id', $id)
                ->pluck('b.tag_name')
                ->implode(', ');

            // Get itinerary details efficiently
            $itineraryDetails = DB::table('tbl_itinerary_daywise as a')
                ->select(
                    'a.title',
                    'a.itinerary_desc',
                    'a.other_iternary_places',
                    DB::raw('(
                        SELECT GROUP_CONCAT(b.place_name) 
                        FROM tbl_places as b 
                        WHERE FIND_IN_SET(b.placeid, a.place_id)
                    ) as place_names')
                )
                ->where('a.package_id', $id)
                ->where('a.bit_Deleted_Flag', 0)
                ->get();

            // Get accommodation details with destination names
            $accomodations = DB::table('tbl_package_accomodation as a')
                ->leftJoin('tbl_destination as b', 'a.destination_id', '=', 'b.destination_id')
                ->select('b.destination_name', 'a.noof_days')
                ->where('a.package_id', $id)
                ->where('a.bit_Deleted_Flag', 0)
                ->get();

            // Return view with compacted data
            return view('admin.managepackages.viewTourPackages', compact(
                'tourPackage', 'tourTags', 'itineraryDetails', 'accomodations'
            ));
        }
    }

    public function activeTourPackages(Request $request, $id)
    {
        $data = DB::table('tbl_tourpackages')->select('status')->where('tourpackageid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Tour Package not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_tourpackages')->where('tourpackageid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Tour Package Inactive successfully!');
            }else{
                DB::table('tbl_tourpackages')->where('tourpackageid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Tour Package Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Tour Package: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Tour Package.']);
        }
    }
    public function showTourPackages(Request $request, $id)
    {
        $data = DB::table('tbl_tourpackages')->select('show_in_home')->where('tourpackageid', $id)->first();
        $status=$data->show_in_home;
        if (!$data) {
            return back()->withErrors(['error' => 'Tour Package not found!']);
        }

        try {
            //  Update the status
            if($status==1){
                DB::table('tbl_tourpackages')->where('tourpackageid', $id)->update([
                'show_in_home' => 2
                ]);
                return redirect()->back()->with('success', 'Tour Package Hide successfully!');
            }else{
                DB::table('tbl_tourpackages')->where('tourpackageid', $id)->update([
                'show_in_home' => 1
                ]);
                return redirect()->back()->with('success', 'Tour Package Show successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error show_in_home/show_in_home Tour Package: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to show_in_home/show_in_home Tour Package.']);
        }
    }

    public function deleteTourPackages(Request $request, $id)
    {
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_tourpackages')->where('tourpackageid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'Tour Package not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_tourpackages')->where('tourpackageid', $id)->update([
                'bit_Deleted_Flag' => 1,
                'updated_date' => now(),
                'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0,
            ]);

            return redirect()->back()->with('success', 'Tour Package deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting Tour Package: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete Tour Package.']);
        }
    }

    private function convertToWebp($file, $destination, $width, $height)
    {
        $imageType = exif_imagetype($file->getPathname());
        $sourceImage = null;

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($file->getPathname());
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($file->getPathname());
                imagepalettetotruecolor($sourceImage); // Convert PNG to TrueColor
                imagealphablending($sourceImage, true);
                imagesavealpha($sourceImage, true);
                break;
            default:
                throw new \Exception("Unsupported image type.");
        }

        if (!$sourceImage) {
            throw new \Exception("Failed to create image resource.");
        }

        // Resize Image
        $resizedImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $width, $height, imagesx($sourceImage), imagesy($sourceImage));

        // Save as WebP
        imagewebp($resizedImage, $destination, 100); // Quality: 100

        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    }


}
