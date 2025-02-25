<?php

namespace App\Http\Controllers\Admin\ManageUser;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

use DB;

class ManageUserController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_admin')->where('bit_Deleted_Flag', 0)->paginate(10);
        return view('admin.manageUser', ['users' => $data]);
    }

    public function viewPop($id)
    {
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

        // Fetch modules
        // if ($user->admin_type == 1 || $user->admin_type == 2) {
        //     $modules = DB::table('tbl_modules')->where('status', 1)->pluck('module')->toArray();
        // } else {
        //     $modules = DB::table('tbl_admin_modules as a')
        //         ->join('tbl_modules as b', 'a.moduleid', '=', 'b.moduleid')
        //         ->where('a.adminid', $user->adminid)
        //         ->pluck('b.module')
        //         ->toArray();
        // }

        // $modulesList = implode(", ", $modules);

        // Generate HTML content
        $html = '
            <div class="modal-header">
                <button type="button" class="close-btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title pupop-title">User Details</h4>
            </div>
            <div class="modal-body">
                <div class="modal-sub-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="gap row">
                                <div class="col-md-4"><label>Name</label></div>
                                <div class="col-md-8">'.htmlspecialchars($user->admin_name).'</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="gap row">
                                <div class="col-md-4"><label>Type</label></div>
                                <div class="col-md-8">'.htmlspecialchars($userTypeName).'</div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <div class="gap row">
                                <div class="col-md-4"><label>Email</label></div>
                                <div class="col-md-8">'.htmlspecialchars($user->email_id).'</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="gap row">
                                <div class="col-md-4"><label>Contact No.</label></div>
                                <div class="col-md-8">'.htmlspecialchars($user->contact_no).'</div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        // <div class="col-md-6">
                        //     <div class="gap row">
                        //         <div class="col-md-4"><label>Module</label></div>
                        //         <div class="col-md-8">'.htmlspecialchars($modulesList).'</div>
                        //     </div>
                        // </div>
                        <div class="col-md-6">
                            <div class="gap row">
                                <div class="col-md-4"><label>Status</label></div>
                                <div class="col-md-8">
                                    '.($user->status == 1 
                                        ? '<span class="label label-success">Active</span>' 
                                        : '<span class="label label-danger">Inactive</span>').'
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>';

        return response()->json(['html' => $html]);
    }

    public function addUser(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'uname' => ['required', 'regex:/^[A-Za-z\s]+$/'],
                'utype' => ['required', 'in:1,2,3'],
                'contact' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:tbl_admin,contact_no'],
                'email' => ['required', 'email', 'unique:tbl_admin,email_id'],
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
                $user = User::create([
                    'admin_name'    => $request->input('uname'),
                    'admin_type'    => $request->input('utype'),
                    'contact_no'    => $request->input('contact'),
                    'email_id'      => $request->input('email'),
                    'password'      => Hash::make($request->input('password')),
                ]);
    
                return redirect()->back()->with('success', 'User created successfully!');
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Something went wrong! Unable to create user.'])->withInput();
            }
        }else{
            return view('admin.addUser');
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
                return redirect()->back()->with('success', 'User updated successfully!');
            }else{
                return view('admin.editUser', ['user' => $user]);
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
    


}