<?php

namespace App\Http\Controllers\Admin\ManageUser;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_id' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = [
            'email_id' => $request->email_id,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->bit_Deleted_Flag == 0 && $user->status == 1) {
                session(['user' => Auth::user()]);
                return redirect()->intended('/dashboard');
            }
            Auth::logout();
            return back()->withErrors(['error' => 'Your account is inactive or deleted.']);
            
        }else{
            return back()->withErrors(['email_id' => 'Invalid credentials.']);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }

    public function forgotPassword()
    {
        return view('admin.forgotpassword');
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);
    
            $user = Auth::user();
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Old password is incorrect!']);
            }
            if ($request->old_password === $request->new_password) {
                return back()->withErrors(['old_password' => 'Old password and new password cannot be the same!']);
            }
            
    
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return back()->with('success', 'Password updated successfully!');
        }else{
            return view('admin.changePassword');
        }
    }
}
