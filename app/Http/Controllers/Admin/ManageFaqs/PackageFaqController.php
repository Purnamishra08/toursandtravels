<?php
namespace App\Http\Controllers\Admin\ManageFaqs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PackageFaqController extends Controller
{
    public function index(Request $request)
    {
        $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
        return view('admin.managefaqs.managepackagefaqs', ['tags' => $tags]);
    }

    public function getData(Request $request)
    {
        $tagid = $request->input('tagid', 0);
        $faq_question = $request->input('faq_question', '');
        $faq_answer = $request->input('faq_answer', '');
        $status = $request->input('status', '');

        $query = DB::table('tbl_package_faqs as p')
            ->leftJoin('tbl_tourpackages as m', 'p.tag_id', '=', 'm.tourpackageid')
            ->select('p.faq_id', 'p.faq_question', 'p.faq_answer', 'p.faq_order', 'p.status', 'p.created_date', 'm.tpackage_name')
            ->where('p.bit_Deleted_Flag', 0)
            ->where('m.bit_Deleted_Flag', 0)
            ->orderBy('p.faq_order', 'ASC');

        if (!empty($tagid)) {
            $query->where('p.tag_id', $tagid);
        }
        if (!empty($faq_question)) {
            $query->where('p.faq_question', 'like', '%' . $faq_question . '%');
        }
        if (!empty($faq_answer)) {
            $query->where('p.faq_answer', 'like', '%' . $faq_answer . '%');
        }
        if (!empty($status)) {
            $query->where('p.status', $status);
        }

        // Handle global search
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('p.faq_question', 'like', '%' . $search . '%')
                  ->orWhere('p.faq_answer', 'like', '%' . $search . '%');
            });
        }
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_date', function ($row) {
                return date('jS M Y', strtotime($row->created_date));
            })
            ->editColumn('faq_answer', function ($row) {
                return htmlspecialchars_decode($row->faq_answer);
            })
            ->addColumn('tpackage_name', function ($row) {
                return $row->tpackage_name;
            })
            ->addColumn('status', function ($row) {
                $csrf = csrf_field();
                $route = route('admin.packagefaqs.activepackagefaqs', ['id' => $row->faq_id]);
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
                return '
                    <a href="' . route('admin.packagefaqs.editpackagefaqs', $row->faq_id) . '" class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <form action="' . route('admin.packagefaqs.deletepackagefaqs', $row->faq_id) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure to delete this faq?\')">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form>';
            })
            ->rawColumns(['status', 'action']) // Allow HTML rendering
            ->make(true);
    }

    public function addpackagefaqs(Request $request){
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'tag_id'            => 'required|numeric',
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
                    'tag_id'                    => $request->input('tag_id'),
                    'faq_question'              => $request->input('faq_question'),
                    'faq_answer'                => $request->input('faq_answer'),
                    'faq_order'                 => $request->input('faq_order'),
                    'status'                    => 1,
                    'created_by'                => session('user')->adminid ?? 0,
                    'updated_by'                => session('user')->adminid ?? 0,
                    'created_date'              => now(),
                    'updated_date'              => now(),
                ];
                // Insert into database
                $inserted = DB::table('tbl_package_faqs')->insert($data);
                if ($inserted) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'package faqs added successfully.');
                } else {
                    throw new \Exception('package faqs could not be added.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            return view('admin.managefaqs.addpackagefaqs', ['tags' => $tags]);
        }
    }

    public function editpackagefaqs(Request $request, $id){
        $packagefaqs = DB::table('tbl_package_faqs')->where('faq_id', $id)->first();
        if (!$packagefaqs) {
            return redirect()->back()->with('error', 'package faq not found.');
        }
        if ($request->isMethod('post')) {
            // Start validation
            $validator = Validator::make($request->all(), [
                'tag_id'            => 'required|numeric',
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
                    'tag_id'                    => $request->input('tag_id'),
                    'faq_question'              => $request->input('faq_question'),
                    'faq_answer'                => $request->input('faq_answer'),
                    'faq_order'                 => $request->input('faq_order'),
                    'status'                    => 1,
                    'updated_by'                => session('user')->adminid ?? 0,
                    'updated_date'              => now(),
                ];
                // Insert into database
                $update = DB::table('tbl_package_faqs')->where('faq_id', $id)->update($data);
                if ($update) {
                    DB::commit(); // Commit transaction
                    return redirect()->back()->with('success', 'package faqs updated successfully.');
                } else {
                    throw new \Exception('package faqs could not be updated.');
                }
            } catch (\Exception $e) {dd($e);
                DB::rollBack(); // Rollback transaction on error
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }else{
            $tags = DB::table('tbl_menutags')->select('tagid','tag_name')->where('bit_Deleted_Flag', 0)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
            return view('admin.managefaqs.addpackagefaqs', ['packagefaq' => $packagefaqs, 'tags' => $tags]);
        }
    }

    public function activepackagefaqs(Request $request,$id){
        // Retrieve package faq type by ID
        $data = DB::table('tbl_package_faqs')->select('status')->where('faq_id', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'package faq not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_package_faqs')->where('faq_id', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'package faq inactivated successfully!');
            }else{
                DB::table('tbl_package_faqs')->where('faq_id', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'package faq Activated successfully!');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive package faq: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive package faq.']);
        }
    }

    public function deletepackagefaqs(Request $request,$id){
        // Retrieve package faq by ID
        $data = DB::table('tbl_package_faqs')->where('faq_id', $id)->first();
        if (!$data) {
            return back()->withErrors(['error' => 'package faq not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_package_faqs')->where('faq_id', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'package faq deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting package faq: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete package faq.']);
        }
    }
}