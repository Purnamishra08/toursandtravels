<?php
namespace App\Http\Controllers\Admin\ManageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PlacesController extends Controller
{
    public function index(Request $request)
    {
        $destinations = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();

        return view('admin.managelocation.places', ['destinations' => $destinations]);
    }

    public function getData(Request $request){
        if ($request->ajax()) {
            // Fetch places for DataTables
            $query = DB::table('tbl_places as p')
                ->select('p.placeimg', 'p.placethumbimg', 'p.placeid', 'p.place_name', 'd.destination_id', 'd.destination_name', 'p.status')
                ->leftJoin('tbl_destination as d', 'p.destination_id', '=', 'd.destination_id')
                ->where('p.bit_Deleted_Flag', 0)
                ->where('d.bit_Deleted_Flag', 0);

            $place_name         = $request->input('place_name', '');
            $destination_id     = $request->input('destination_id', '');
            $status             = $request->input('status', '');
            $show_in_home       = $request->input('show_in_home', '');

            if (!empty($place_name)) {
                $query->where('p.place_name', 'like', '%' . $place_name . '%');
            }
            if (!empty($destination_id)) {
                $query->where('p.destination_id', $destination_id);
            }
            if (!empty($status)) {
                $query->where('p.status', $status);
            }
            if (!empty($show_in_home)) {
                $query->where('p.show_in_home', $show_in_home);
            }

            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('p.place_name', 'like', '%' . $search . '%')
                      ->orWhere('d.destination_name', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('place_name', function ($row) {
                    return $row->place_name;
                })
                ->addColumn('destination_name', function ($row) {
                    return $row->destination_name;
                })
                ->addColumn('placeimg', function ($row) {
                    if (!empty($row->placeimg)) {
                        return '<a href="' . asset('storage/place_images/' . $row->placeimg) . '" target="_blank">
                                    <img id="destinationBannerPreview"
                                        src="' . asset('storage/place_images/' . $row->placeimg) . '"
                                        alt="Place Banner Preview"
                                        class="img-fluid rounded border"
                                        style="width: 150px; height: 80px; object-fit: cover;">
                                </a>';
                    }
                    return '';
                })
                ->addColumn('placethumbimg', function ($row) {
                    if (!empty($row->placethumbimg)) {
                        return '<a href="' . asset('storage/place_images/thumbs/' . $row->placethumbimg) . '" target="_blank">
                                    <img id="destinationImagePreview" 
                                        src="' . asset('storage/place_images/thumbs/' . $row->placethumbimg) . '"
                                        alt="Place Image"
                                        class="img-fluid rounded border"
                                        style="width: 150px; height: 80px; object-fit: cover;">
                                </a>';
                    }
                    return '';
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.places.activeplaces', ['id' => $row->placeid]);
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
                        <a href="' . route('admin.places.editplaces', $row->placeid) . '" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>';
                
                    // Define module ID required for delete access (adjust if needed)
                    $requiredModuleId = 6; // Change this to the correct module ID for places
                
                    // Check if the user has delete permission
                    $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
                
                    // Delete button (visible only if allowed)
                    $deleteButton = '';
                    if ($canDelete) {
                        $deleteButton = '
                            <form action="' . route('admin.places.deleteplaces', $row->placeid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this place?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>';
                    }
                
                    return $editButton . $deleteButton;
                })
                ->rawColumns(['placeimg', 'placethumbimg', 'status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function addplaces(Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'place_name'          => 'required|string|max:255',
                'place_url'           => 'required|string|max:255',
                'destination_id'      => 'required|numeric',
                'short_desc'          => 'required|string',
                'latitude'            => 'required|string',
                'longitude'           => 'required|string',
                'placeimg'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1900,height=300',
                'placethumbimg'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:width=500,height=300',
                'alttag_banner'       => 'required|string|max:60|unique:tbl_places,alttag_banner',
                'alttag_thumb'        => 'required|string|max:60|unique:tbl_places,alttag_thumb'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            

            try {
                $duplicateCountName = DB::table('tbl_places')->Where('place_name', $request->input('place_name'))->where('bit_Deleted_Flag',0)->count();

                if ($duplicateCountName > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this place, Place name must be unique.']);
                }
                $duplicateCount = DB::table('tbl_places')->Where('place_url', $request->input('place_url'))->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this place, URL must be unique.']);
                }

                DB::beginTransaction(); // Start transaction
                // Handle Image Upload
                $place_imageName = null;
                if ($request->hasFile('placeimg')) {
                    $file = $request->file('placeimg');
                    $place_imageName = Str::slug($request->input('alttag_banner')) . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/place_images/' . $place_imageName), 1900, 300);
                }

                // Handle Thumbnail Image Upload
                $placeThumbImageName = null;
                if ($request->hasFile('placethumbimg')) {
                    $file = $request->file('placethumbimg');
                    $placeThumbImageName = Str::slug($request->input('alttag_thumb')) . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/place_images/thumbs/' . $placeThumbImageName), 500, 300);
                }

                // Prepare data
                $data = [
                    'place_name'                    => $request->input('place_name'),
                    'place_url'                     => $request->input('place_url'),
                    'latitude'                      => $request->input('latitude'),
                    'longitude'                     => $request->input('longitude'),
                    'show_in_home'                  => $request->input('show_in_home'),
                    'destination_id'                => $request->input('destination_id'),
                    'distance_from_nearest_city'    => $request->input('distance_from_nearest_city'),
                    'about_place'                   => $request->input('short_desc'),
                    'placeimg'                      => $place_imageName,
                    'placethumbimg'                 => $placeThumbImageName,
                    'alttag_banner'                 => Str::slug($request->input('alttag_banner')),
                    'alttag_thumb'                  => Str::slug($request->input('alttag_thumb')),
                    'travel_tips'                   => $request->input('travel_tips'),
                    'google_map'                    => $request->input('google_map'),
                    'entry_fee'			            => $request->input('entry_fee'),
                    'timing'			            => $request->input('timing'),
                    'rating'			            => $request->input('rating'),
                    'meta_title'                    => $request->input('place_meta_title'),
                    'meta_keywords'                 => $request->input('place_meta_keywords'),
                    'meta_description'              => $request->input('place_meta_description'),
                    'created_by'                    => session('user')->adminid ?? 0,
                    'created_date'                  => now(),
                    'updated_by'                    => session('user')->adminid ?? 0,
                    'updated_date'                  => now(),
                    'pckg_meta_title'            => $request->input('pckg_meta_title'),
                    'pckg_meta_keywords'         => $request->input('pckg_meta_keywords'),
                    'pckg_meta_description'      => $request->input('pckg_meta_description')
                ];

                // Insert into database
                $inserted = DB::table('tbl_places')->insertGetId($data);

                if ($inserted) {
                    // Insert location types
                    if (!empty($request->input('place_type'))) {
                        $locationTypes = [];
                        foreach ($request->input('place_type') as $dtype) {
                            $locationTypes[] = [
                                'loc_id'     => $inserted,
                                'loc_type'   => 2,
                                'loc_type_id' => $dtype,
                            ];
                        }
                        DB::table('tbl_multdest_type')->insert($locationTypes);
                    }

                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Place added successfully.');
                } else {
                    throw new \Exception('Place could not be added.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $destinations = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('destinationType', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $vehicleType = DB::table('tbl_vehicletypes')->select('vehicleid','vehicle_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('vehicle_name', 'ASC')->get();
            $destinationTypes = DB::table('tbl_destination_type')->select('destination_type_id','destination_type_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_type_name', 'ASC')->get();
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            return view('admin.managelocation.addplaces', [
                'destinationTypes'  => $destinationTypes,
                'tags'              => $tags,
                'destinations'      => $destinations,
                'vehicleType'       => $vehicleType
            ]);
        }
    }

    public function editplaces(Request $request, $id)
    {
        $place = DB::table('tbl_places')->where('placeid', $id)->first();
        if (!$place) {
            return redirect()->back()->with('error', 'Place not found.');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'place_name'          => "required|string|max:255",
                'place_url'           => 'required|string|max:255',
                'destination_id'      => 'required|numeric',
                'short_desc'          => 'required|string',
                'latitude'            => 'required|string',
                'longitude'           => 'required|string',
                'placeimg'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1900,height=300',
                'placethumbimg'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:width=500,height=300',
                'alttag_banner'       => "required|string|max:60|unique:tbl_places,alttag_banner,$id,placeid",
                'alttag_thumb'        => "required|string|max:60|unique:tbl_places,alttag_thumb,$id,placeid"
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            try {
                $duplicateCountName = DB::table('tbl_places')->Where('place_name', $request->input('place_name'))->where('bit_Deleted_Flag',0)->where('placeid','!=', $id)->count();

                if ($duplicateCountName > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this place, Place name must be unique.']);
                }
                $duplicateCount = DB::table('tbl_places')->Where('place_url', $request->input('place_url'))->where('placeid','!=', $id)->count();

                if ($duplicateCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'You have already added this place, URL must be unique.']);
                }

                if ($request->hasFile('placeimg')) {
                    $file = $request->file('placeimg');
                    $randomNumber = mt_rand(10000, 99999);
                    $place_imageName = Str::slug($request->input('alttag_banner')) . '-' . $randomNumber . '.webp';
        
                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/place_images/' . $place_imageName), 1900, 300);
                }else{
                    $place_imageName = $place->placeimg;
                }

                if ($request->hasFile('placethumbimg')) {
                    $file = $request->file('placethumbimg');
                    $randomNumber = mt_rand(10000, 99999);
                    $placeThumbImageName = Str::slug($request->input('alttag_thumb')) . '-' . $randomNumber . '.webp';

                    // Convert and Store as WebP
                    $this->convertToWebp($file, storage_path('app/public/place_images/thumbs/' . $placeThumbImageName), 500, 300);
                }else{
                    $placeThumbImageName = $place->placethumbimg;
                }
                

                $data = [
                    'place_name'                    => $request->input('place_name'),
                    'place_url'                     => $request->input('place_url'),
                    'latitude'                      => $request->input('latitude'),
                    'longitude'                     => $request->input('longitude'),
                    'show_in_home'                  => $request->input('show_in_home'),
                    'destination_id'                => $request->input('destination_id'),
                    'distance_from_nearest_city'    => $request->input('distance_from_nearest_city'),
                    'about_place'                   => $request->input('short_desc'),
                    'placeimg'                      => $place_imageName,
                    'placethumbimg'                 => $placeThumbImageName,
                    'alttag_banner'                 => Str::slug($request->input('alttag_banner')),
                    'alttag_thumb'                  => Str::slug($request->input('alttag_thumb')),
                    'trip_duration'                 => $request->input('trip_duration'),
                    'travel_tips'                   => $request->input('travel_tips'),
                    'google_map'                    => $request->input('google_map'),
                    'entry_fee'			            => $request->input('entry_fee'),
                    'timing'			            => $request->input('timing'),
                    'rating'			            => $request->input('rating'),
                    'meta_title'                    => $request->input('place_meta_title'),
                    'meta_keywords'                 => $request->input('place_meta_keywords'),
                    'meta_description'              => $request->input('place_meta_description'),
                    'created_by'                    => session('user')->adminid ?? 0,
                    'created_date'                  => now(),
                    'updated_by'                    => session('user')->adminid ?? 0,
                    'updated_date'                  => now(),
                    'pckg_meta_title'               => $request->input('pckg_meta_title'),
                    'pckg_meta_keywords'            => $request->input('pckg_meta_keywords'),
                    'pckg_meta_description'         => $request->input('pckg_meta_description')
                ];

                DB::table('tbl_places')->where('placeid', $id)->update($data);

                DB::table('tbl_multdest_type')->where('loc_id', $id)->where('loc_type', 2)->delete();
                if (!empty($request->input('place_type'))) {
                    $locationTypes = array_map(function ($dtype) use ($id) {
                        return [
                            'loc_id' => $id,
                            'loc_type' => 2,
                            'loc_type_id' => $dtype
                        ];
                    }, $request->input('place_type'));
                
                    DB::table('tbl_multdest_type')->insert($locationTypes);
                }
                DB::commit();
                return redirect()->back()->with('success', 'Place updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $placesData = DB::table('tbl_places as d')
                                ->selectRaw('d.placeid, d.destination_id, d.place_name, d.place_url, d.latitude, d.longitude, d.trip_duration, d.distance_from_nearest_city, d.placeimg, d.placethumbimg, d.alttag_banner, d.alttag_thumb, d.google_map, d.travel_tips , d.about_place, d.entry_fee, d.timing, d.rating, d.status, d.meta_title, d.meta_keywords, d.meta_description, d.pckg_meta_title, d.pckg_meta_keywords, d.pckg_meta_description, d.show_in_home')
                                ->where('d.placeid', $id)->first();
            $selectedDestinationTypes = DB::table('tbl_multdest_type')
                                ->where('bit_Deleted_Flag', 0)
                                ->where('loc_id', $place->placeid ?? 0)
                                ->pluck('loc_type_id')
                                ->toArray();
            $destinations = DB::table('tbl_destination')->select('destination_id','destination_name')->where('status', 1)->where('destinationType', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_name', 'ASC')->get();
            $vehicleType = DB::table('tbl_vehicletypes')->select('vehicleid','vehicle_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('vehicle_name', 'ASC')->get();
            $destinationTypes = DB::table('tbl_destination_type')->select('destination_type_id','destination_type_name')->where('status', 1)->where('bit_Deleted_Flag',0)->orderBy('destination_type_name', 'ASC')->get();
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();

            return view('admin.managelocation.addplaces', [
                'placesData'                => $placesData,
                'selectedDestinationTypes'  => $selectedDestinationTypes,
                'destinations'              => $destinations,
                'vehicleType'               => $vehicleType,
                'destinationTypes'          => $destinationTypes,
                'tags'                      => $tags
            ]);
        }

        
    }

    public function activeplaces(Request $request,$id){
        // Retrieve Place type by ID
        $data = DB::table('tbl_places')->select('status')->where('placeid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Place not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_places')->where('placeid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Place inactivated successfully!');
            }else{
                DB::table('tbl_places')->where('placeid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Place Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive Place: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive Place.']);
        }
    }

    public function deleteplaces(Request $request,$id){
        // Retrieve Place by ID
        $data = DB::table('tbl_places')->where('placeid', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Place not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_places')->where('placeid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);
            DB::table('tbl_multdest_type')->where('loc_id', $id)->where('loc_type', 2)->delete();
            return redirect()->back()->with('success', 'Place deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting place: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete place.']);
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