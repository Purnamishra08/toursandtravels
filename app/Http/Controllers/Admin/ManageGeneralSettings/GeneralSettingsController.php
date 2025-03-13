<?php

namespace App\Http\Controllers\Admin\ManageGeneralSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class GeneralSettingsController extends Controller
{
    public function index(Request $request)
    {
        $parameters  = DB::table('tbl_parameters')->select('parid','parameter','par_value','input_type')->where('status', 1)->where('param_type', 'CS')->where('bit_Deleted_Flag', 0)->paginate(10);
        return view('admin.managegeneralsettings.managegeneralsettings', ['parameters' => $parameters]);
    }

    public function editgeneralsettings(Request $request, $id){
        $parameters = DB::table('tbl_parameters')->select('parid','parameter','par_value','input_type')->where('parid', $id)->where('bit_Deleted_Flag', 0)->first();
        if (!$parameters) {
            return redirect()->back()->with('error', 'General settings not found.');
        }

        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                $inputType = $request->input('input_type');
                $updateData = [];
                
                // Handle different input types
                if ($inputType == 1) {
                    $updateData['par_value'] = $request->input('par_value');
                } elseif ($inputType == 2) {
                    $updateData['par_value'] = $request->input('text_area');
                } elseif ($inputType == 3) {
                    if ($request->hasFile('bnrimg')) {
                        $file = $request->file('bnrimg');
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs('parameters', $fileName, 'public');
                        
                        // Delete existing image if exists
                        if (!empty($parameter->par_value)) {
                            Storage::disk('public')->delete('parameters/' . $parameter->par_value);
                        }

                        $updateData['par_value'] = $fileName;
                    } else {
                        $updateData['par_value'] = $parameter->par_value;
                    }
                } else {
                    $updateData['par_value'] = $request->input('short_desc');
                }

                // Update record in database
                DB::table('tbl_parameters')->where('parid', $id)->update($updateData);
                
                DB::commit();
                return redirect()->back()->with('success', $parameters->parameter . ' updated successfully.');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }else{
            return view('admin.managegeneralsettings.editgeneralsettings', ['parameters' => $parameters]);
        }
    }
}