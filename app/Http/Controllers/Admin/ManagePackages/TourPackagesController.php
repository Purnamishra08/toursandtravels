<?php

namespace App\Http\Controllers\Admin\ManagePackages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;


class TourPackagesController extends Controller
{
    public function index()
    {
        // $data = DB::table('tbl_package_duration')->where('bit_Deleted_Flag', 0)->orderByDesc('durationid')->paginate(10);
        return view('admin.managepackages.manageTourPackages');
    }

    public function addTourPackages(Request $request)
    {
        // If the request is GET, show the add form view with needed data.
        if ($request->isMethod('get')) {
            // Retrieve any data needed by the view (for dropdowns, tags, durations, itineraries, etc.)
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
            $availableDestinations = $destinations; // For the accommodation section.
            $tags = DB::table('tbl_menutags')
                ->where('status', 1)
                ->where('menuid', 3)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('tag_name', 'asc')
                ->get();
            // Also retrieve the maximum number of days from package durations if needed.
            $max_noof_days = DB::table('tbl_package_duration')->max('no_ofdays');

            return view('admin.managepackages.addTourPackages', [
                'durations'=>$durations,
                'packageTypes'=>$packageTypes,
                'itineraries'=>$itineraries,
                'destinations'=>$destinations,
                'availableDestinations'=>$availableDestinations,
                'tags'=>$tags,
                'max_noof_days'=>$max_noof_days
            ]);
        }

        // Process the POST request (form submission)
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
            'itinerary'        => 'required',
            'starting_city'    => 'required',
            'inclusion'        => 'required',
            // For files, you might require image rules and dimensions if desired.
            'tourimg'          => 'nullable|image|dimensions:width=745,height=450',
            'tourthumb'        => 'nullable|image|dimensions:width=300,height=225',
        ]);

        // Prepare additional fields and process checkboxes
        $show_video_itinerary = $request->has('show_video_itinerary') ? 1 : 0;

        // Process file uploads (using Laravel's Storage facade)
        // You can create helper methods for resizing images if needed.
        if ($request->hasFile('tourimg')) {
            $tourimgFile = $request->file('tourimg');
            // Create a SEO-friendly filename based on alt tag (using Str::slug)
            $tourimgfilename = Str::slug($validated['alttag_banner']) . '.' . $tourimgFile->getClientOriginalExtension();
            // Store file in 'public/tourpackages'. (Make sure you have a symbolic link: php artisan storage:link)
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

        // Prepare numeric values for checkboxes (defaulting to 0 if not checked)
        $accomodation   = $request->input('accomodation', 0);
        $tourtransport  = $request->input('tourtransport', 0);
        $sightseeing    = $request->input('sightseeing', 0);
        $breakfast      = $request->input('breakfast', 0);
        $waterbottle    = $request->input('waterbottle', 0);

        // Check for duplicates: if a package exists with same code or URL.
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

        // Prepare data array for insertion into tbl_tourpackages.
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
            'ratings'              => $request->input('rating'), // Not validated above; adjust if needed.
            'inclusion_exclusion'  => $validated['inclusion'],
            'alttag_banner'        => $validated['alttag_banner'],
            'alttag_thumb'         => $validated['alttag_thumb'],
            'itinerary_note'       => $request->input('itinerary_note'),
            'accomodation'         => $accomodation,
            'tourtransport'        => $tourtransport,
            'sightseeing'          => $sightseeing,
            'breakfast'            => $breakfast,
            'waterbottle'          => $waterbottle,
            'status'               => 1,
            'pack_type'            => $request->input('packtype'),
            'itinerary'            => $validated['itinerary'],
            'starting_city'        => $validated['starting_city'],
            'meta_title'           => $request->input('meta_title'),
            'meta_keywords'        => $request->input('meta_keywords'),
            'meta_description'     => $request->input('meta_description'),
            'show_video_itinerary' => $show_video_itinerary,
            'video_itinerary_link' => $request->input('video_itinerary_link'),
            'created_date'         => now(),
        ];

        // Insert into tbl_tourpackages and get the inserted ID.
        $lastId = DB::table('tbl_tourpackages')->insertGetId($data);

        // Insert tags into tbl_tags
        foreach ($validated['getatagid'] as $tagid) {
            DB::table('tbl_tags')->insert([
                'type_id' => $lastId,
                'type'    => 3, // 3 indicates tour package type (as per your logic)
                'tagid'   => $tagid,
            ]);
        }

        // Process Accommodation rows (multiple rows may be sent as arrays)
        $destination_ids = $request->input('destination_id'); // array
        $no_ofdays       = $request->input('no_ofdays'); // array

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

        return redirect()->route('admin.managetourpackages')
            ->with('success', 'Package added successfully!');
    }

}
