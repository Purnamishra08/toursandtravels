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
                return view('admin.addUser', ['user' => $user]);
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