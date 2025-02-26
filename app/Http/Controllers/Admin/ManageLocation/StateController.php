<?php
namespace App\Http\Controllers\Admin\ManageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class StateController extends Controller
{
    public function index()
    {
        $states = DB::table('tbl_state')->where('bit_Deleted_Flag',0)->paginate(10);
        return view('admin.managelocation.state', ['states' => $states]);
    }
    
    public function addState(Request $request){
       // Validation Rules
       if ($request->isMethod('post')) {
        $validator = Validator::make($request->all(), [
            'state_name'          => 'required|string|max:255|unique:tbl_state,state_name',
            // 'state_url'           => 'required|url|max:255',
            'bannerimg'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alttag_banner'       => 'nullable|string|max:60',
            'state_meta_title'    => 'nullable|string|max:255',
            'state_meta_keywords' => 'nullable|string|max:500',
            'state_meta_description' => 'nullable|string|max:1000',
            'showmenu'            => 'nullable|boolean',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Handle Image Upload
            $bannerImageName = null;
            if ($request->hasFile('bannerimg')) {
                $file = $request->file('bannerimg');
                $bannerImageName = time() . '_' . $file->getClientOriginalName(); // Unique Name
                $file->storeAs('banner_images', $bannerImageName, 'public'); // Store in Storage
            }

            // Insert Data using Query Builder
            DB::table('tbl_state')->insert([
                'state_name'                => $request->state_name,
                'state_url'                 => $request->state_url,
                'bannerimg'                 => $bannerImageName,
                'alttag_banner'             => $request->alttag_banner,
                'state_meta_title'          => $request->state_meta_title,
                'state_meta_keywords'       => $request->state_meta_keywords,
                'state_meta_description'    => $request->state_meta_description,
                'showmenu'                  => $request->has('showmenu') ? 1 : 0,
                'status'                    => 1, // Default Active
                'bit_Deleted_Flag'          => 0, // Default Not Deleted
                'created_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                'created_date'              => now(),
                'updated_by'                => isset(session('user')->adminid) ? session('user')->adminid : 0,
                'updated_date'              => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'State added successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error adding state: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding the state. Please try again.');
        }


       }else{
            return view('admin.managelocation.addstate');
        }
       
    }

    public function editState(Request $request,$id){
        $stateData = DB::table('tbl_state')->where('bit_Deleted_Flag', 0)->where('state_id', $id)->first();
        if (!$stateData) {
            return redirect()->back()->withErrors(['error' => 'State not found!']);
        }else{
            if ($request->isMethod('post')) {
                // Validate input
                $validator = Validator::make($request->all(), [
                    'state_name'          => 'required|string|max:255|unique:tbl_state,state_name,' . $id . ',state_id',
                    'bannerimg'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'alttag_banner'       => 'nullable|string|max:60',
                    'state_meta_title'    => 'nullable|string',
                    'state_meta_keywords' => 'nullable|string',
                    'state_meta_description' => 'nullable|string',
                    'showmenu'            => 'nullable|boolean',
                ]);

                // If validation fails
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                try {
                    DB::beginTransaction();
            
                    // Get existing state record
                    $state = DB::table('tbl_state')->where('state_id', $id)->first();
                    if (!$state) {
                        return redirect()->back()->with('error', 'State not found.');
                    }
            
                    // Handle Image Upload
                    $bannerImageName = $state->bannerimg; // Keep old image if not replaced
                    if ($request->hasFile('bannerimg')) {
                        $file = $request->file('bannerimg');
                        $bannerImageName = time() . '_' . $file->getClientOriginalName();
            
                        // Delete old image if exists
                        if ($state->bannerimg && Storage::disk('public')->exists('banner_images/' . $state->bannerimg)) {
                            Storage::disk('public')->delete('banner_images/' . $state->bannerimg);
                        }
            
                        // Store new image
                        $file->storeAs('banner_images', $bannerImageName, 'public');
                    }
            
                    // Update Data
                    DB::table('tbl_state')->where('state_id', $id)->update([
                        'state_name'                => $request->state_name,
                        'state_url'                 => $request->state_url,
                        'bannerimg'                 => $bannerImageName, // Updated Image Name
                        'alttag_banner'             => $request->alttag_banner,
                        'state_meta_title'          => $request->state_meta_title,
                        'state_meta_keywords'       => $request->state_meta_keywords,
                        'state_meta_description'    => $request->state_meta_description,
                        'showmenu'                  => $request->has('showmenu') ? 1 : 0,
                        'updated_by'                => session('user')->adminid ?? 0,
                        'updated_date'              => now(),
                    ]);
            
                    DB::commit();
                    return redirect()->back()->with('success', 'State updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Failed to update state. ' . $e->getMessage());
                }
            }else{
                return view('admin.managelocation.addstate', ['state' => $stateData]);
            }
        }
           
        
        
     }

    public function deleteState(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_state')->where('state_id', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'State not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_state')->where('state_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'State deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting state: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete state.']);
        }
    }

}