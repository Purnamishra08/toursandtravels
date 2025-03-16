<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;


class TourPackagesController extends Controller
{
    public function index()
    {
        // $data = DB::table('tbl_package_duration')->where('bit_Deleted_Flag', 0)->orderByDesc('durationid')->paginate(10);
        return view('admin.managepackages.manageTourPackages');
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
                ->orderBy('place_name', 'asc')
                ->get();

            $html = '<div class="box-main">';
            $html .= '<h3>Itinerary Details</h3>';
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
                $html .= '<input type="text" class="form-control" placeholder="Itinerary Title" name="title[]">';
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
            $html .= '</div>'; // Close box-main

            $html .= <<<SCRIPT
            <script>
                $(document).ready(function() {
                    $('.chosen-select').chosen();
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
            'starting_city'    => 'required',
            'inclusion'        => 'required',
            'tourimg'          => 'nullable|image|dimensions:width=745,height=450',
            'tourthumb'        => 'nullable|image|dimensions:width=300,height=225',
        ]);

        try {
            DB::beginTransaction();

            $show_video_itinerary = $request->has('show_video_itinerary') ? 1 : 0;

            if ($request->hasFile('tourimg')) {
                $tourimgFile = $request->file('tourimg');
                $tourimgfilename = Str::slug($validated['alttag_banner']) . '.' . $tourimgFile->getClientOriginalExtension();
                $tourimgFile->storeAs('public/tourpackages', $tourimgfilename);
            } else {
                $tourimgfilename = null;
            }

            if ($request->hasFile('tourthumb')) {
                $tourthumbFile = $request->file('tourthumb');
                $tourthumbfilename = Str::slug($validated['alttag_thumb']) . '.' . $tourthumbFile->getClientOriginalExtension();
                $tourthumbFile->storeAs('public/tourpackages/thumbs', $tourthumbfilename);
            } else {
                $tourthumbfilename = null;
            }

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
                'price'                => $validated['price'],
                'fakeprice'            => $validated['fakeprice'],
                'ratings'              => $request->input('rating'),
                'inclusion_exclusion'  => $validated['inclusion'],
                'alttag_banner'        => $validated['alttag_banner'],
                'alttag_thumb'         => $validated['alttag_thumb'],
                'itinerary_note'       => $request->input('itinerary_note'),
                'accomodation'         => $request->input('accomodation', 0),
                'tourtransport'        => $request->input('tourtransport', 0),
                'sightseeing'          => $request->input('sightseeing', 0),
                'breakfast'            => $request->input('breakfast', 0),
                'waterbottle'          => $request->input('waterbottle', 0),
                'status'               => 1,
                'pack_type'            => $request->input('packtype'),
                'starting_city'        => $validated['starting_city'],
                'meta_title'           => $request->input('meta_title'),
                'meta_keywords'        => $request->input('meta_keywords'),
                'meta_description'     => $request->input('meta_description'),
                'show_video_itinerary' => $show_video_itinerary,
                'video_itinerary_link' => $request->input('video_itinerary_link'),
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

            $destination_ids = $request->input('destination_id');
            $no_ofdays       = $request->input('no_ofdays');

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

            $title = $request->input('title');
            $place_id = $request->input('getplaceid');
            $otherItineraryPlaces = $request->input('otherItineraryPlaces');

            if (count($title) > 0) {
                for ($k = 0; $k < count($title); $k++) {
                    DB::table('tbl_itinerary_daywise')->insert([
                        'package_id' => $lastId,
                        'title' => $title[$k],
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
        'starting_city' => 'required',
        'inclusion' => 'required',
        'tourimg' => 'nullable|image|dimensions:width=745,height=450',
        'tourthumb' => 'nullable|image|dimensions:width=300,height=225',
    ]);
    
    try {
        DB::beginTransaction();
        
        $show_video_itinerary = $request->has('show_video_itinerary') ? 1 : 0;
        
        $tourPackage = DB::table('tbl_tourpackages')->where('tourpackageid', $id)->first();
        
        $tourimgfilename = $tourPackage->tpackage_image;
        $tourthumbfilename = $tourPackage->tour_thumb;
        
        // ✅ Handle tour image
        if ($request->hasFile('tourimg')) {
            $tourimgFile = $request->file('tourimg');
            $tempTourimgfilename = Str::slug($validated['alttag_banner']) . '.' . $tourimgFile->getClientOriginalExtension();
            $tourimgFile->storeAs('public/tourpackages', $tempTourimgfilename);
            
            // Store temporary name, will finalize if DB transaction succeeds
            $tourimgfilename = $tempTourimgfilename;
        }
        
    // ✅ Handle tour thumb
    if ($request->hasFile('tourthumb')) {
        $tourthumbFile = $request->file('tourthumb');
        $tempTourthumbfilename = Str::slug($validated['alttag_thumb']) . '.' . $tourthumbFile->getClientOriginalExtension();
        $tourthumbFile->storeAs('public/tourpackages/thumbs', $tempTourthumbfilename);
        
        // Store temporary name, will finalize if DB transaction succeeds
        $tourthumbfilename = $tempTourthumbfilename;
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
        'price' => $validated['price'],
        'fakeprice' => $validated['fakeprice'],
        'ratings' => $request->input('rating'),
        'inclusion_exclusion' => $validated['inclusion'],
        'alttag_banner' => $validated['alttag_banner'],
        'alttag_thumb' => $validated['alttag_thumb'],
        'itinerary_note'       => $request->input('itinerary_note'),
        'accomodation'         => $request->input('accomodation', 0),
        'tourtransport'        => $request->input('tourtransport', 0),
        'sightseeing'          => $request->input('sightseeing', 0),
        'breakfast'            => $request->input('breakfast', 0),
        'waterbottle'          => $request->input('waterbottle', 0),
        'status'               => 1,
        'pack_type'            => $request->input('packtype'),
        'starting_city'        => $validated['starting_city'],
        'meta_title'           => $request->input('meta_title'),
        'meta_keywords'        => $request->input('meta_keywords'),
        'meta_description'     => $request->input('meta_description'),
        'show_video_itinerary' => $show_video_itinerary,
        'video_itinerary_link' => $request->input('video_itinerary_link'),
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

    $destination_ids = $request->input('destination_id');
    $no_ofdays       = $request->input('no_ofdays');

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
                    ->orderBy('place_name', 'asc')
                    ->get();

        // Get existing itinerary data
        $editItinerary = DB::table('tbl_itinerary_daywise')
                        ->where('package_id', $itineraryId)
                        ->where('bit_Deleted_Flag', 0)
                        ->orderBy('itinerary_daywiseid', 'asc')
                        ->get();

        $html = '<div class="box-main">
                    <h3>Itinerary Details</h3>
                    <div class="col-md-12">';

        $arr = 0;
        for ($i = 1; $i <= $noOfDays; $i++) {
            $itineraryTitle = $editItinerary[$arr]->title ?? '';
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
            $html .= '<input type="text" class="form-control" placeholder="Itinerary Title" name="title[]" value="' . htmlspecialchars($itineraryTitle) . '">
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
                </div>';

        // JavaScript to update chosen select
        $html .= '<script type="text/javascript">
                    $(document).ready(function () {';

        $arr1 = 0;
        for ($i = 1; $i <= $noOfDays; $i++) {
            $html .= '$("#getplaceid_' . $i . '").chosen();';

            $itineraryPlace = $editItinerary[$arr1]->place_id ?? '';
            if ($itineraryPlace != '') {
                $tagArray = explode(',', $itineraryPlace);
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

}
