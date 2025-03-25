<?php

namespace App\Http\Controllers\Admin\ManageGeneralSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class GeneralSettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.managegeneralsettings.managegeneralsettings');
    }

    public function getData(Request $request){
        if ($request->ajax()) {
            // Fetch parameters for DataTables
            $query = DB::table('tbl_parameters')
                ->select('parid', 'parameter', 'par_value', 'input_type')
                ->where('status', 1)
                ->where('param_type', 'CS')
                ->where('bit_Deleted_Flag', 0);
    
            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('parameter', 'like', '%' . $search . '%')
                      ->orWhere('par_value', 'like', '%' . $search . '%');
                });
            }
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('parameter', function ($row) {
                    return $row->parameter;
                })
                ->addColumn('par_value', function ($row) {
                    if ($row->input_type != 3) {
                        if ($row->parid == 4) {
                            return 'Edit to view this code';
                        } else {
                            return $row->par_value;
                        }
                    } else {
                        if (!empty($row->par_value)) {
                            return '<a href="' . asset('storage/parameters/' . $row->par_value) . '" target="_blank">
                                        <img id="destinationImagePreview" 
                                            src="' . asset('storage/parameters/' . $row->par_value) . '"
                                            alt="Destination Image"
                                            class="img-fluid rounded border"
                                            style="width: 150px; height: 80px; object-fit: cover;">
                                    </a>';
                        }
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.managetourpackages.editgeneralsettings', $row->parid) . '" class="btn btn-primary btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>';
                })
                ->rawColumns(['par_value', 'action']) // Allow HTML rendering
                ->make(true);
        }
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