<?php
namespace App\Http\Controllers\Admin\ManageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        // For initial page load, return the view
        $parameters = DB::table('tbl_parameters')
        ->select('parid', 'par_value')
        ->where('status', 1)
        ->where('param_type', 'TD')
        ->where('bit_Deleted_Flag', 0)
        ->get();

        return view('admin.managelocation.destination', ['parameters' => $parameters]);
    }

    public function getData(Request $request){
        if ($request->ajax()) {
            // Fetch destinations for DataTables
            $query = DB::table('tbl_destination as d')
                ->select('d.destiimg', 'd.destiimg_thumb', 'd.destination_id', 'd.destination_name', 'd.status')
                ->where('d.destinationType', 1)
                ->where('d.bit_Deleted_Flag', 0);

            $destination_name   = $request->input('destination_name', '');
            $status             = $request->input('status', '');

            if (!empty($destination_name)) {
                $query->where('d.destination_name', 'like', '%' . $destination_name . '%');
            }
            if (!empty($status)) {
                $query->where('d.status', $status);
            }

            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('d.destination_name', 'like', '%' . $search . '%')
                      ->orWhere('p.par_value', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('destination_name', function ($row) {
                    return $row->destination_name;
                })
                ->addColumn('destiimg', function ($row) {
                    if (!empty($row->destiimg)) {
                        return '<a href="' . asset('storage/destination_images/' . $row->destiimg) . '" target="_blank">
                                    <img id="destinationBannerPreview" 
                                        src="' . asset('storage/destination_images/' . $row->destiimg) . '"
                                        alt="Destination Banner Preview"
                                        class="img-fluid rounded border"
                                        style="width: 150px; height: 80px; object-fit: cover;">
                                </a>';
                    }
                    return '';
                })
                ->addColumn('destiimg_thumb', function ($row) {
                    if (!empty($row->destiimg_thumb)) {
                        return '<a href="' . asset('storage/destination_images/thumbs/' . $row->destiimg_thumb) . '" target="_blank">
                                    <img id="destinationImagePreview" 
                                        src="' . asset('storage/destination_images/thumbs/' . $row->destiimg_thumb) . '"
                                        alt="Destination Image"
                                        class="img-fluid rounded border"
                                        style="width: 150px; height: 80px; object-fit: cover;">
                                </a>';
                    }
                    return '';
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.destination.activeDestination', ['id' => $row->destination_id]);
                    $confirmMessage = "return confirm('Are you sure you want to change the status?')";
    
                    if ($row->status == 1) {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-success" title="Active. Click to deactivate.">
                                        <span class="label-custom label label-success">Active</span>
                                    </button>
                                </form>';
                    } else {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-dark" title="Inactive. Click to activate.">
                                        <span class="label-custom label label-danger">Inactive</span>
                                    </button>
                                </form>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                
                    // Edit button (always visible)
                    $editButton = '
                        <a href="' . route('admin.destination.editdestination', $row->destination_id) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // Define module ID required for delete access (adjust if needed)
                    $requiredModuleId = 6;
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.destination.deletedestination', $row->destination_id) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this destination?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $deleteButton;
                })
                ->rawColumns(['destiimg', 'destiimg_thumb', 'status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function adddestination(Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'destination_name'    => "required|string|max:255",
                'destination_url'     => 'required|string|max:255',
                'pick_drop_price'     => 'required|numeric',
                'accomodation_price'  => 'required|numeric',
                'latitude'            => 'required|string',
                'longitude'           => 'required|string',
                'destiimg'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1900,height=300',
                'destismallimg'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:width=300,height=225',
                'alttag_banner'       => 'required|string|max:60',
                'alttag_thumb'        => 'required|string|max:60'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction

            try {
                $duplicateCountName = DB::table('tbl_destination')->Where('destination_name', $request->input('destination_name'))->where('bit_Deleted_Flag',0)->count();

                if ($duplicateCountName > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this destination, Destination name must be unique.']);
                }

                $duplicateCount = DB::table('tbl_destination')->Where('destination_url', $request->input('destination_url'))->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this destination, URL must be unique.']);
                }
                // Handle Image Upload
                $destination_imageName = null;
                if ($request->hasFile('destiimg')) {
                    $file = $request->file('destiimg');
                    $randomNumber = mt_rand(10000, 99999);
                    $destination_imageName = Str::slug($request->input('alttag_banner')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/destination_images/' . $destination_imageName), 1900, 300);
                }

                // Handle Thumbnail Image Upload
                $destinationThumbImageName = null;
                if ($request->hasFile('destismallimg')) {
                    $file = $request->file('destismallimg');
                    $randomNumber = mt_rand(10000, 99999);
                    $destinationThumbImageName = Str::slug($request->input('alttag_thumb')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/destination_images/thumbs/' . $destinationThumbImageName), 300, 225);
                }

                // Prepare data
                $data = [
                    'destination_name'          => $request->input('destination_name'),
                    'destination_url'           => $request->input('destination_url'),
                    'latitude'                  => $request->input('latitude'),
                    'longitude'                 => $request->input('longitude'),
                    'trip_duration'             => $request->input('trip_duration'),
                    'nearest_city'              => $request->input('nearest_city'),
                    'visit_time'                => $request->input('visit_time'),
                    'peak_season'               => $request->input('peak_season'),
                    'weather_info'              => $request->input('weather_info'),
                    'destiimg'                  => $destination_imageName,
                    'destiimg_thumb'            => $destinationThumbImageName,
                    'alttag_banner'             => Str::slug($request->input('alttag_banner')),
                    'alttag_thumb'              => Str::slug($request->input('alttag_thumb')),
                    'google_map'                => $request->input('google_map'),
                    'about_destination'         => $request->input('short_desc'),
                    'places_visit_desc'         => $request->input('places_to_visit_desc'),
                    'internet_availability'     => $request->input('internet_avl'),
                    'std_code'                  => $request->input('std_code'),
                    'language_spoken'           => $request->input('lng_spk'),
                    'major_festivals'           => $request->input('mjr_fest'),
                    'note_tips'                 => $request->input('note_tips'),
                    // 'show_on_footer'            => $request->input('show_on_footer'),
                    'desttype_for_home'         => $request->input('desttype_for_home'),
                    'destinationType'           => 1,
                    'status'                    => 1,
                    'pick_drop_price'           => $request->input('pick_drop_price'),
                    'accomodation_price'        => $request->input('accomodation_price'),
                    'meta_title'                => $request->input('meta_title'),
                    'meta_keywords'             => $request->input('meta_keywords'),
                    'meta_description'          => $request->input('meta_description'),
                    'created_by'                => session('user')->adminid ?? 0,
                    'created_date'              => now(),
                    'updated_by'                => session('user')->adminid ?? 0,
                    'updated_date'              => now(),
                    'place_meta_title'          => $request->input('place_meta_title'),
                    'place_meta_keywords'       => $request->input('place_meta_keywords'),
                    'place_meta_description'    => $request->input('place_meta_description')
                ];

                // Insert into database
                $inserted = DB::table('tbl_destination')->insertGetId($data);

                if ($inserted) {
                    // Insert categories
                    if (!empty($request->input('edesti'))) {
                        $categories = [];
                        foreach ($request->input('edesti') as $edesti) {
                            $categories[] = [
                                'destination_id' => $inserted,
                                'cat_id'         => $edesti,
                            ];
                        }
                        DB::table('tbl_destination_cats')->insert($categories);
                    }

                    // Insert location types
                    if (!empty($request->input('destination_type'))) {
                        $locationTypes = [];
                        foreach ($request->input('destination_type') as $dtype) {
                            $locationTypes[] = [
                                'loc_id'     => $inserted,
                                'loc_type'   => 1,
                                'loc_type_id' => $dtype,
                            ];
                        }
                        DB::table('tbl_multdest_type')->insert($locationTypes);
                    }

                    // Insert tags
                    if (!empty($request->input('getatagid'))) {
                        $tags = [];
                        foreach ($request->input('getatagid') as $tagid) {
                            $tags[] = [
                                'type'    => 1,
                                'type_id' => $inserted,
                                'tagid'   => $tagid,
                            ];
                        }
                        DB::table('tbl_tags')->insert($tags);
                    }

                    // Insert similar destinations (nearby places)
                    if (!empty($request->input('near_info'))) {
                        $nearPlaces = [];
                        foreach ($request->input('near_info') as $nearinfos) {
                            $nearPlaces[] = [
                                'destination_id' => $inserted,
                                'type'           => 2,
                                'simdest_id'     => $nearinfos,
                            ];
                        }
                        DB::table('tbl_destination_places')->insert($nearPlaces);
                    }

                    // Insert other information
                    if (!empty($request->input('other_info'))) {
                        $otherInfos = [];
                        foreach ($request->input('other_info') as $otherinfos) {
                            $otherInfos[] = [
                                'destination_id' => $inserted,
                                'type'           => 1,
                                'simdest_id'     => $otherinfos,
                            ];
                        }
                        DB::table('tbl_destination_places')->insert($otherInfos);
                    }
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Destination added successfully.');
                } else {
                    throw new \Exception('Destination could not be added.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $similarDestinations = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $nearByPlaces = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $destinationTypes = DB::table('tbl_destination_type')->select('destination_type_id','destination_type_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_type_name', 'ASC')->get();
            $categories  = DB::table('tbl_menucategories')->select('catid','cat_name')->where('status', 1)->where('bit_Deleted_Flag', 0)->where('menuid','!=', 3)->get();
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            $parameters  = DB::table('tbl_parameters')->select('parid','par_value')->where('status', 1)->where('param_type', 'TD')->where('bit_Deleted_Flag', 0)->get();
            return view('admin.managelocation.adddestination', [
                'destinationTypes' => $destinationTypes,
                'categories' => $categories,
                'tags' => $tags,
                'similarDestinations' => $similarDestinations,
                'nearByPlaces' => $nearByPlaces,
                'parameters' => $parameters
            ]);
        }
    }

    public function editDestination(Request $request, $id)
    {
        $destination = DB::table('tbl_destination')->where('destination_id', $id)->first();
        if (!$destination) {
            return redirect()->back()->with('error', 'Destination not found.');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'destination_name'    => "required|string|max:255",
                'pick_drop_price'     => 'required|numeric',
                'accomodation_price'  => 'required|numeric',
                'latitude'            => 'required|string',
                'longitude'           => 'required|string',
                'destiimg'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1900,height=300',
                'destismallimg'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:width=300,height=225',
                'alttag_banner'       => "required|string|max:60",
                'alttag_thumb'        => "required|string|max:60"
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            try {
                $duplicateCountName = DB::table('tbl_destination')->Where('destination_name', $request->input('destination_name'))->where('bit_Deleted_Flag',0)->where('destination_id','!=', $id)->count();

                if ($duplicateCountName > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this destination, Destination name must be unique.']);
                }
                $duplicateCount = DB::table('tbl_destination')->Where('destination_url', $request->input('destination_url'))->where('destination_id','!=', $id)->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this destination, URL must be unique.']);
                }

                if ($request->hasFile('destiimg')) {
                    $file = $request->file('destiimg');
                    $randomNumber = mt_rand(10000, 99999);
                    $destination_imageName = Str::slug($request->input('alttag_banner')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/destination_images/' . $destination_imageName), 1900, 300);
                }else{
                    $destination_imageName = $destination->destiimg;
                }

                if ($request->hasFile('destismallimg')) {
                    $file = $request->file('destismallimg');
                    $randomNumber = mt_rand(10000, 99999);
                    $destinationThumbImageName = Str::slug($request->input('alttag_thumb')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/destination_images/thumbs/' . $destinationThumbImageName), 300, 225);
                }else{
                    $destinationThumbImageName = $destination->destiimg_thumb;
                }

                $data = [
                    'destination_name'          => $request->input('destination_name'),
                    'destination_url'           => $request->input('destination_url'),
                    'latitude'                  => $request->input('latitude'),
                    'longitude'                 => $request->input('longitude'),
                    'trip_duration'             => $request->input('trip_duration'),
                    'nearest_city'              => $request->input('nearest_city'),
                    'visit_time'                => $request->input('visit_time'),
                    'peak_season'               => $request->input('peak_season'),
                    'weather_info'              => $request->input('weather_info'),
                    'destiimg'                  => $destination_imageName,
                    'destiimg_thumb'            => $destinationThumbImageName,
                    'alttag_banner'             => Str::slug($request->input('alttag_banner')),
                    'alttag_thumb'              => Str::slug($request->input('alttag_thumb')),
                    'google_map'                => $request->input('google_map'),
                    'about_destination'         => $request->input('short_desc'),
                    'places_visit_desc'         => $request->input('places_to_visit_desc'),
                    'internet_availability'     => $request->input('internet_avl'),
                    'std_code'                  => $request->input('std_code'),
                    'language_spoken'           => $request->input('lng_spk'),
                    'major_festivals'           => $request->input('mjr_fest'),
                    'note_tips'                 => $request->input('note_tips'),
                    // 'show_on_footer'            => $request->input('show_on_footer'),
                    'desttype_for_home'         => $request->input('desttype_for_home'),
                    'status'                    => 1,
                    'pick_drop_price'           => $request->input('pick_drop_price'),
                    'accomodation_price'        => $request->input('accomodation_price'),
                    'meta_title'                => $request->input('meta_title'),
                    'meta_keywords'             => $request->input('meta_keywords'),
                    'meta_description'          => $request->input('meta_description'),
                    'place_meta_title'          => $request->input('place_meta_title'),
                    'place_meta_keywords'       => $request->input('place_meta_keywords'),
                    'place_meta_description'    => $request->input('place_meta_description'),
                    'created_by'                => session('user')->adminid ?? 0,
                    'created_date'              => now(),
                    'updated_by'                => session('user')->adminid ?? 0,
                    'updated_date'              => now()
                ];

                DB::table('tbl_destination')->where('destination_id', $id)->where('destinationType', 1)->update($data);

                DB::table('tbl_destination_cats')->where('destination_id', $id)->delete();
                if (!empty($request->input('edesti'))) {
                    $categories = array_map(fn($edesti) => ['destination_id' => $id, 'cat_id' => $edesti], $request->input('edesti'));
                    DB::table('tbl_destination_cats')->insert($categories);
                }

                DB::table('tbl_multdest_type')->where('loc_id', $id)->delete();
                if (!empty($request->input('destination_type'))) {
                    $locationTypes = array_map(fn($dtype) => ['loc_id' => $id, 'loc_type' => 1, 'loc_type_id' => $dtype], $request->input('destination_type'));
                    DB::table('tbl_multdest_type')->insert($locationTypes);
                }

                DB::table('tbl_tags')->where('type', 1)->where('type_id', $id)->delete();
                if (!empty($request->input('getatagid'))) {
                    $tags = array_map(fn($tagid) => ['type' => 1, 'type_id' => $id, 'tagid' => $tagid], $request->input('getatagid'));
                    DB::table('tbl_tags')->insert($tags);
                }

                DB::table('tbl_destination_places')->where('destination_id', $id)->delete();
                if (!empty($request->input('near_info'))) {
                    $nearPlaces = array_map(fn($nearinfos) => ['destination_id' => $id, 'type' => 2, 'simdest_id' => $nearinfos], $request->input('near_info'));
                    DB::table('tbl_destination_places')->insert($nearPlaces);
                }

                if (!empty($request->input('other_info'))) {
                    $otherInfos = array_map(fn($otherinfos) => ['destination_id' => $id, 'type' => 1, 'simdest_id' => $otherinfos], $request->input('other_info'));
                    DB::table('tbl_destination_places')->insert($otherInfos);
                }


                DB::commit();
                return redirect()->back()->with('success', 'Destination updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $destinationData = DB::table('tbl_destination as d')
                                ->selectRaw('d.destination_id, d.destination_name, d.destination_url, d.latitude, d.longitude, d.state, d.trip_duration, d.nearest_city, d.visit_time, d.peak_season, d.weather_info, d.destiimg, d.destiimg_thumb, d.alttag_banner, d.alttag_thumb, d.google_map, d.about_destination, d.places_visit_desc, d.internet_availability, d.std_code, d.language_spoken, d.major_festivals, d.note_tips, d.status, d.desttype_for_home, d.show_on_footer, d.pick_drop_price, d.accomodation_price, d.meta_title, d.meta_keywords, d.meta_description, d.place_meta_title, d.place_meta_keywords, d.place_meta_description, d.package_meta_title, d.package_meta_keywords, d.package_meta_description')
                                ->where('d.destination_id', $id)->first();
            $selectedDestinationTypes = DB::table('tbl_multdest_type')
                                ->where('bit_Deleted_Flag', 0)
                                ->where('loc_id', $destination->destination_id ?? 0)
                                ->pluck('loc_type_id') // Fetch only the loc_type_id column
                                ->toArray();
            $selectedCategories = DB::table('tbl_destination_cats')
                                ->where('bit_Deleted_Flag', 0)
                                ->where('destination_id', $destination->destination_id ?? 0)
                                ->pluck('cat_id') // Fetch only the cat_id column
                                ->toArray();
            $selectedGetawayTags = DB::table('tbl_tags')
                                ->where('bit_Deleted_Flag', 0)
                                ->where('type_id', $destination->destination_id ?? 0)
                                ->pluck('tagid') // Fetch only the cat_id column
                                ->toArray();
            $similarDestinationTags = DB::table('tbl_destination_places')
                                ->where('type', 1)
                                ->where('bit_Deleted_Flag', 0)
                                ->where('destination_id', $destination->destination_id ?? 0)
                                ->pluck('simdest_id') // Fetch only the cat_id column
                                ->toArray();
            $nearbyPlacesTags = DB::table('tbl_destination_places')
                                ->where('type', 2)
                                ->where('bit_Deleted_Flag', 0)
                                ->where('destination_id', $destination->destination_id ?? 0)
                                ->pluck('simdest_id') // Fetch only the cat_id column
                                ->toArray();
            $similarDestinations = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $nearByPlaces = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $destinationTypes = DB::table('tbl_destination_type')->select('destination_type_id','destination_type_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_type_name', 'ASC')->get();
            $categories  = DB::table('tbl_menucategories')->select('catid','cat_name')->where('status', 1)->where('bit_Deleted_Flag', 0)->where('menuid','!=', 3)->get();
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            $parameters  = DB::table('tbl_parameters')->select('parid','par_value')->where('status', 1)->where('param_type', 'TD')->where('bit_Deleted_Flag', 0)->get();

            return view('admin.managelocation.adddestination', [
                'destinationData'           => $destinationData,
                'destinationTypes'          => $destinationTypes,
                'categories'                => $categories,
                'tags'                      => $tags,
                'similarDestinations'       => $similarDestinations,
                'nearByPlaces'              => $nearByPlaces,
                'parameters'                => $parameters,
                'selectedDestinationTypes'  => $selectedDestinationTypes,
                'selectedCategories'        => $selectedCategories,
                'selectedGetawayTags'       => $selectedGetawayTags,
                'similarDestinationTags'    => $similarDestinationTags,
                'nearbyPlacesTags'          => $nearbyPlacesTags
            ]);
        }

        
    }

    public function activeDestination(Request $request,$id){
        // Retrieve Destination type by ID
        $data = DB::table('tbl_destination')->select('status')->where('destination_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Destination not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_destination')->where('destination_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Destination inactivated successfully!');
            }else{
                DB::table('tbl_destination')->where('destination_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Destination Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Destination: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Destination.']);
        }
    }

    public function deletedestination(Request $request,$id){
        // Retrieve Destination by ID
        $data = DB::table('tbl_destination')->where('destination_id', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Destination not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_destination')->where('destination_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);
            DB::table('tbl_destination_cats')->where('destination_id', $id)->delete();
            DB::table('tbl_multdest_type')->where('loc_type', 1)->where('loc_id', $id)->delete();
            DB::table('tbl_tags')->where('type', 1)->where('type_id', $id)->delete();
            DB::table('tbl_destination_places')->where('destination_id', $id)->delete();

            return redirect()->back()->with('success', 'Destination deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting destination: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete destination.']);
        }
    }

    public function pickupdestinationdata(Request $request){
        if ($request->ajax()) {
            // Fetch destinations for DataTables
            $query = DB::table('tbl_destination')
                ->select('destination_id', 'destination_name','status','destinationType')
                ->where('destinationType', 2)
                ->where('bit_Deleted_Flag', 0);

            $destination_name   = $request->input('destination_name', '');
            $status             = $request->input('status', '');

            if (!empty($destination_name)) {
                $query->where('destination_name', 'like', '%' . $destination_name . '%');
            }
            if (!empty($status)) {
                $query->where('status', $status);
            }

            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('destination_name', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('destination_name', function ($row) {
                    return $row->destination_name;
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.destination.activeDestination', ['id' => $row->destination_id]);
                    $confirmMessage = "return confirm('Are you sure you want to change the status?')";
    
                    if ($row->status == 1) {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-success" title="Active. Click to deactivate.">
                                        <span class="label-custom label label-success">Active</span>
                                    </button>
                                </form>';
                    } else {
                        return '<form action="' . $route . '" method="POST" onsubmit="' . $confirmMessage . '">
                                    ' . $csrf . '
                                    <button type="submit" class="btn btn-outline-dark" title="Inactive. Click to activate.">
                                        <span class="label-custom label label-danger">Inactive</span>
                                    </button>
                                </form>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.destination.editpickupdestination', ['id' => $row->destination_id]);
                    $deleteUrl = route('admin.destination.deletedestination', ['id' => $row->destination_id]);
                    $moduleAccess = session('moduleAccess', []); // Get module access from session
                    $user = session('user'); // Get user session
                    $requiredModuleId = 20;
                    
                    $buttons = '
                        <div class="d-flex gap-1">
                            <button class="btn btn-success btn-sm edit-btn" data-id="'.$row->destination_id.'" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </button>';
                    
                    if ($user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1)) {
                        $buttons .= '
                            <form action="'.$deleteUrl.'" method="POST" 
                                onsubmit="return confirm(\'Are you sure you want to delete this Pickup destination.?\')">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }
    
    public function addpickupdestination(Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            // $validator = Validator::make($request->all(), [
            //     'destination_name'    => 'required|string|max:255|unique:tbl_destination,destination_name',
            // ]);

            $validator = Validator::make($request->all(), [
                'destination_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('tbl_destination', 'destination_name')->where(function ($query) {
                        return $query->where('bit_Deleted_Flag', 0);
                    }),
                ],
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction

            try {
                // Prepare data
                $data = [
                    'destination_name'          => $request->input('destination_name'),
                    'destinationType'           => 2
                ];
                $inserted = DB::table('tbl_destination')->insert($data);
                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Pickup destination added successfully.');
                } else {
                    throw new \Exception('Pickup destination could not be added.');
                }
            } catch (\Exception $e) {
                dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            return view('admin.managelocation.addpickupdestination');
        }
    }

    public function updatepickupdestination(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|integer',
            'destination_name' => 'required|string|max:255'
        ]);

        try {
            $updated = DB::table('tbl_destination')
                ->where('destination_id', $request->destination_id)
                ->where('destinationType', 2)
                ->update([
                    'destination_name' => $request->input('destination_name'),
                    'updated_date' => now(),
                    'updated_by' => isset(session('user')->adminid) ? session('user')->adminid : 0
                ]);

            if ($updated) {
                return response()->json(['success' => 'Pickup destionation updated successfully!']);
            } else {
                return response()->json(['error' => 'No changes made!'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error updating Pickup destionation: ' . $e->getMessage()], 500);
        }
    }

    public function editpickupdestination($id)
    {
        $destination = DB::table('tbl_destination')->where('destination_id', $id)->first();

        if (!$destination) {
            return response()->json(['error' => 'Destination not found!'], 404);
        }

        // Modal HTML
        $modalHtml = '
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Pickup Destination</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editDestinationForm">
            '.csrf_field().'
                <input type="hidden" name="destination_id" id="destination_id" value="' . $destination->destination_id . '" />
                
                <div class="form-group">
                    <label>Pickup Destination Name</label>
                    <input type="text" class="form-control" name="destination_name" id="destination_name" value="' . $destination->destination_name . '" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>';

        return response()->json(['html' => $modalHtml]);
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