<?php
namespace App\Http\Controllers\Admin\ManageFaqs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CommonFaqController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.managefaqs.managecommonfaqs');
    }

    public function getData(Request $request)
    {
        $faq_question = $request->input('faq_question', '');
        $faq_answer = $request->input('faq_answer', '');
        $status = $request->input('status', '');
        $faq_type = $request->input('faq_type', '');

        $query = DB::table('tbl_faqs')
            ->select('faq_id', 'faq_question', 'faq_answer', 'faq_order', 'status', 'created_date', 'faq_type')
            ->where('bit_Deleted_Flag', 0)
            ->orderBy('faq_order', 'ASC');

        if (!empty($faq_question)) {
            $query->where('faq_question', 'like', '%' . $faq_question . '%');
        }
        if (!empty($faq_answer)) {
            $query->where('faq_answer', 'like', '%' . $faq_answer . '%');
        }
        if (!empty($status)) {
            $query->where('status', $status);
        }
        if(!empty($faq_type)){
            $query->where('faq_type', $faq_type);
        }

        // Handle global search
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('faq_question', 'like', '%' . $search . '%')
                ->orWhere('faq_answer', 'like', '%' . $search . '%');
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('faq_type', function ($row) {
                return $row->faq_type == 1 ? 'Common Faqs' : ($row->faq_type == 2 ? 'Destination Faqs' : 'N/A');
            })
            ->editColumn('created_date', function ($row) {
                return date('jS M Y', strtotime($row->created_date));
            })
            ->editColumn('faq_answer', function ($row) {
                return htmlspecialchars_decode($row->faq_answer);
            })
            ->addColumn('status', function ($row) {
                $csrf = csrf_field();
                $route = route('admin.commonfaqs.activecommonfaqs', ['id' => $row->faq_id]);
                $confirmMessage = "return confirm('Are you sure you want to change the status?')";
            
                if ($row->status == 1) {
                    return '<form action="'.$route.'" method="POST" onsubmit="'.$confirmMessage.'">
                                '.$csrf.'
                                <button type="submit" class="btn btn-outline-success" title="Active. Click to deactivate.">
                                    <span class="label-custom label label-success">Active</span>
                                </button>
                            </form>';
                } else {
                    return '<form action="'.$route.'" method="POST" onsubmit="'.$confirmMessage.'">
                                '.$csrf.'
                                <button type="submit" class="btn btn-outline-dark" title="Inactive. Click to activate.">
                                    <span class="label-custom label label-danger">Inactive</span>
                                </button>
                            </form>';
                }
            })
            ->addColumn('action', function ($row) {
                $moduleAccess = session('moduleAccess', []);
                $user = session('user');
            
                // Edit button (always visible)
                $editButton = '
                    <a href="' . route('admin.commonfaqs.editcommonfaqs', $row->faq_id) . '" class="btn btn-primary btn-sm" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>';
            
                // Define the module ID required for delete access (adjust as needed)
                $requiredModuleId = 16;
            
                // Check if the user has delete permission
                $canDelete = $user->admin_type == 1 || (isset($moduleAccess[$requiredModuleId]) && $moduleAccess[$requiredModuleId] == 1);
            
                // Delete button (visible only if allowed)
                $deleteButton = '';
                if ($canDelete) {
                    $deleteButton = '
                        <form action="' . route('admin.commonfaqs.deletecommonfaqs', $row->faq_id) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this FAQ?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>';
                }
            
                return $editButton . $deleteButton;
            })
            ->rawColumns(['status', 'action']) // Allow HTML rendering
            ->make(true);
    }

    public function addcommonfaqs(Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'faq_type'          => 'required|numeric',
                'faq_question'      => 'required|string',
                'faq_answer'        => 'required|string|',
                'faq_order'         => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction
            try {
                $data = [
                    'faq_type'                  => $request->input('faq_type'),
                    'faq_question'              => stripslashes($request->input('faq_question')),
                    'faq_answer'                => stripslashes($request->input('faq_answer')),
                    'faq_order'                 => $request->input('faq_order'),
                    'status'                    => 1,
                    'created_by'                => session('user')->adminid ?? 0,
                    'updated_by'                => session('user')->adminid ?? 0,
                    'created_date'              => now(),
                    'updated_date'              => now(),
                ];
                // Insert into database
                $inserted = DB::table('tbl_faqs')->insert($data);
                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Common faqs added successfully.');
                } else {
                    throw new \Exception('Common faqs could not be added.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            return view('admin.managefaqs.addcommonfaqs');
        }
    }

    public function editcommonfaqs(Request $request, $id){
        $commonfaqs = DB::table('tbl_faqs')->where('faq_id', $id)->first();
        if (!$commonfaqs) {
            return redirect()->back()->with('error', 'Common faq not found.');
        }
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'faq_type'          => 'required|numeric',
                'faq_question'      => 'required|string',
                'faq_answer'        => 'required|string|',
                'faq_order'         => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction(); // Start transaction
            try {
                $data = [
                    'faq_type'                  => $request->input('faq_type'),
                    'faq_question'              => stripslashes($request->input('faq_question')),
                    'faq_answer'                => stripslashes($request->input('faq_answer')),
                    'faq_order'                 => $request->input('faq_order'),
                    'status'                    => 1,
                    'updated_by'                => session('user')->adminid ?? 0,
                    'updated_date'              => now(),
                ];
                // Insert into database
                $update = DB::table('tbl_faqs')->where('faq_id', $id)->update($data);
                if ($update) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'Common faqs updated successfully.');
                } else {
                    throw new \Exception('Common faqs could not be updated.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            return view('admin.managefaqs.addcommonfaqs', ['commonfaq' => $commonfaqs]);
        }
    }

    public function activecommonfaqs(Request $request,$id){
        // Retrieve common faq type by ID
        $data = DB::table('tbl_faqs')->select('status')->where('faq_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'Common faq not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_faqs')->where('faq_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'Common faq inactivated successfully!');
            }else{
                DB::table('tbl_faqs')->where('faq_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'Common faq Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive common faq: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive common faq.']);
        }
    }

    public function deletecommonfaqs(Request $request,$id){
        // Retrieve Common faq by ID
        $data = DB::table('tbl_faqs')->where('faq_id', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'Common faq not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_faqs')->where('faq_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'Common faq deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting common faq: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete common faq.']);
        }
    }
}