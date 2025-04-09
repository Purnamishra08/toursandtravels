<?php

namespace App\Http\Controllers\Admin\ManageUser;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class ManageUserController extends Controller
{
    public function index()
    { 
        return view('admin.manageuser.manageUser');
    }
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            // Fetch users for DataTables
            $users = DB::table('tbl_admin')->where('bit_Deleted_Flag', 0);

            // Handle global search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $users->where(function ($q) use ($search) {
                    $q->where('admin_name', 'like', '%' . $search . '%')
                    ->orWhere('contact_no', 'like', '%' . $search . '%')
                    ->orWhere('email_id', 'like', '%' . $search . '%')
                    ->orWhere('admin_type', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('admin_name', function ($row) {
                    return $row->admin_name;
                })
                ->addColumn('admin_type', function ($row) {
                    if ($row->admin_type == 1) {
                        return 'Super Admin';
                    } elseif ($row->admin_type == 2) {
                        return 'Admin';
                    } else {
                        return 'User';
                    }
                })
                ->addColumn('contact_no', function ($row) {
                    return $row->contact_no;
                })
                ->addColumn('email_id', function ($row) {
                    return $row->email_id;
                })
                ->addColumn('modules', function ($row) {
                    if ($row->admin_type == 1) {
                        $modules = DB::table('tbl_modules')
                            ->where('status', 1)
                            ->orderBy('moduleid', 'ASC')
                            ->pluck('module')
                            ->toArray();
                    } else {
                        $modules = DB::table('tbl_admin_modules as a')
                            ->join('tbl_modules as b', 'a.moduleid', '=', 'b.moduleid')
                            ->where('a.adminid', $row->adminid)
                            ->orderBy('b.moduleid', 'ASC')
                            ->pluck('b.module')
                            ->toArray();
                    }
                    return implode(', ', $modules);
                })
                ->addColumn('status', function ($row) {
                    $csrf = csrf_field();
                    $route = route('admin.manageUser.activeUser', ['id' => $row->adminid]);
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
                    return '
                        <a href="' . route('admin.manageUser.editUser', $row->adminid) . '" class="btn btn-success btn-sm" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm view" title="View" onclick="loadUserDetails(' . $row->adminid . ')">
                            <i class="fa fa-eye"></i>
                        </a>
                        <form action="' . route('admin.manageUser.deleteUser', $row->adminid) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure you want to delete this user?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }

    public function viewPop(Request $request)
    {
        $id = $request->input('reqId');
        if (!$id) {
            return response()->json(['error' => 'Invalid Request'], 400);
        }
    
        $user = DB::table('tbl_admin')->where('adminid', $id)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Determine user type
        $userTypeName = match ($user->admin_type) {
            1 => 'Super Admin',
            2 => 'Admin',
            default => 'User',
        };
    
        // Generate only the dynamic content for the modal body
        $html = '
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6"><strong>Name:</strong> ' . htmlspecialchars($user->admin_name) . '</div>
                    <div class="col-md-6"><strong>Type:</strong> ' . htmlspecialchars($userTypeName) . '</div>
                    <div class="col-md-6"><strong>Email:</strong> ' . htmlspecialchars($user->email_id) . '</div>
                    <div class="col-md-6"><strong>Contact No.:</strong> ' . htmlspecialchars($user->contact_no) . '</div>
                    <div class="col-md-6">
                        <strong>Status:</strong> ' . 
                        ($user->status == 1 
                            ? '<span class="badge bg-success text-light">Active</span>' 
                            : '<span class="badge bg-danger text-light">Inactive</span>') . '
                    </div>
                </div>
            </div>';

    
        return response()->json(['html' => $html]);
    }

    public function addUser(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'uname' => ['required', 'regex:/^[A-Za-z\s]+$/'],
                'utype' => ['required', 'in:1,2,3'],
                'contact' => [
                    'required',
                    'regex:/^[6-9]\d{9}$/',
                    Rule::unique('tbl_admin', 'contact_no')->where(function ($query) {
                        return $query->where('bit_Deleted_Flag', 0);
                    }),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('tbl_admin', 'email_id')->where(function ($query) {
                        return $query->where('bit_Deleted_Flag', 0);
                    }),
                ],
                'password' => ['required', 'min:6'],
                'cpassword' => ['required', 'same:password'],
            ]);

            $messages = [
                'uname.regex' => 'Name should not contain numbers.',
                'utype.in' => 'Invalid User Type selected.',
                'contact.digits' => 'Contact number must be exactly 10 digits.',
                'cpassword.same' => 'Passwords do not match.',
            ];

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $user = DB::table('tbl_admin')->insertGetId([
                    'admin_name'  => $request->input('uname'),
                    'admin_type'  => $request->input('utype'),
                    'contact_no'  => $request->input('contact'),
                    'email_id'    => $request->input('email'),
                    'password'    => Hash::make($request->input('password')),
                ]);
                $lastInsertedId = DB::getPdo()->lastInsertId();
                DB::table('tbl_admin_modules')->where('adminid', $lastInsertedId)->delete();
                $utype = $request->input('utype');
                // If not Super Admin (utype != 1 && utype != 2)
                if ($utype != 1) {
                    $modules = $request->input('modules', []); // Default to an empty array if no modules selected
                    $access = $request->input('access', []); // Access values for all modules
                    $sess_userid = session('user')->adminid ?? 0; // Get logged-in user's ID

                    // Filter only selected modules
                    $filteredAccess = array_filter($access, function ($key) use ($modules) {
                        return in_array($key, $modules);
                    }, ARRAY_FILTER_USE_KEY);

                    $date = now(); // Get current timestamp

                    $insertData = [];

                    foreach ($filteredAccess as $moduleid => $accessValue) {
                        $insertData[] = [
                            'adminid'                   => $lastInsertedId,
                            'moduleid'                  => $moduleid,
                            'moduleDeleteAccess'        => (int)$accessValue,
                            'created_by'                => $sess_userid,
                            'created_date'              => $date
                        ];
                    }

                    // Insert multiple records at once
                    if (!empty($insertData)) {
                        DB::table('tbl_admin_modules')->insert($insertData);
                    }
                }

                return redirect()->back()->with('success', 'User created successfully!');
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to create user.'])->withInput();
            }
        }else{
            $modules = DB::table('tbl_modules')->select('moduleid','module')->where('status', 1)->where('bit_Deleted_Flag', 0)->get();
            return view('admin.manageuser.addUser', ['modules' => $modules]);
        }
        
    }

    public function editUser(Request $request, $id){
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found!']);
        }else{
            if($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'uname' => ['required', 'regex:/^[A-Za-z\s]+$/'],
                    'utype' => ['required', 'in:1,2,3'],
                    'contact' => ['required', 'regex:/^[6-9]\d{9}$/'],
                    'email' => ['required', 'email'],
                ]);
    
                $messages = [
                    'uname.regex' => 'Name should not contain numbers.',
                    'utype.in' => 'Invalid User Type selected.',
                    'contact.digits' => 'Contact number must be exactly 10 digits.',
                ];
    
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                $user->admin_name = $request->input('uname');
                $user->admin_type = $request->input('utype');
                $user->contact_no = $request->input('contact');
                $user->email_id = $request->input('email');

                $user->save();
                DB::table('tbl_admin_modules')->where('adminid', $id)->delete();
                $utype = $request->input('utype');
                if ($utype != 1) { // If not Super Admin
                    $modules = $request->input('modules', []); // Get selected modules
                    $access = $request->input('access', []); // Access values for all modules
                    $sess_userid = session('user')->adminid ?? 0;
                    $date = now();
        
                    // Filter only selected modules
                    $filteredAccess = array_filter($access, function ($key) use ($modules) {
                        return in_array($key, $modules);
                    }, ARRAY_FILTER_USE_KEY);

                    $insertData = [];
                     foreach ($filteredAccess as $moduleid => $accessValue) {
                        $insertData[] = [
                            'adminid'                   => $id,
                            'moduleid'                  => $moduleid,
                            'moduleDeleteAccess'        => (int)$accessValue,
                            'created_by'                => $sess_userid,
                            'created_date'              => $date
                        ];
                    }
        
                    if (!empty($insertData)) {
                        DB::table('tbl_admin_modules')->insert($insertData);
                    }
                }
                return redirect()->back()->with('success', 'User updated successfully!');
            }else{
                $modules = DB::table('tbl_modules')->select('moduleid','module')->where('status', 1)->where('bit_Deleted_Flag', 0)->get();
                if ($user->admin_type == 1) {
                    $selectedModules = DB::table('tbl_modules')
                        ->where('status', 1)
                        ->orderBy('moduleid', 'ASC')
                        ->pluck('moduleid')
                        ->toArray();
                    $moduleAccess = [];   
                } else {
                    $selectedModules = DB::table('tbl_admin_modules')
                        ->where('adminid', $user->adminid)
                        ->orderBy('moduleid', 'ASC')
                        ->pluck('moduleid')
                        ->toArray();

                    // Fetch moduleDeleteAccess values for selected modules
                    $moduleAccess = DB::table('tbl_admin_modules')
                    ->where('adminid', $user->adminid)
                    ->pluck('moduleDeleteAccess', 'moduleid') // Fetch moduleDeleteAccess as key-value pairs
                    ->toArray();
                }
                return view('admin.manageuser.addUser', ['user' => $user, 'modules' => $modules, 'selectedModules' => $selectedModules, 'moduleAccess' => $moduleAccess]);
            }
        }
        
       
    }

    public function deleteUser(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_admin')->where('adminid', $id)->first();

        if (!$data) {
            return back()->withErrors(['error' => 'User not found!']);
        }

        try {
            // Soft delete: Update the bit_Deleted_Flag
            DB::table('tbl_admin')->where('adminid', $id)->update([
                'bit_Deleted_Flag' => 1
            ]);

            return redirect()->back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting User: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to delete user.']);
        }
    }
    
    public function activeUser(Request $request,$id){
        // Retrieve vehicle type by ID
        $data = DB::table('tbl_admin')->select('status')->where('adminid', $id)->first();
        $status=$data->status;
        if (!$data) {
            return back()->withErrors(['error' => 'User not found!']);
        }

        try {
            // Soft delete: Update the status
            if($status==1){
                DB::table('tbl_admin')->where('adminid', $id)->update([
                'status' => 2
                ]);
                return redirect()->back()->with('success', 'User Inactive successfully!');
            }else{
                DB::table('tbl_admin')->where('adminid', $id)->update([
                'status' => 1
                ]);
                return redirect()->back()->with('success', 'User Active successfully!');
            }            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error Active/Inactive user: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to Active/Inactive user.']);
        }
    }


}