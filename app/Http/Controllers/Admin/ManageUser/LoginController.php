<?php

namespace App\Http\Controllers\Admin\ManageUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'email_id' => $request->email_id, // Use 'email_id' as the key
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }else{
            return back()->withErrors(['email_id' => 'Invalid credentials.']);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin');
    }

     public function forgotPassword()
    {
        return view('admin.forgotpassword');
    }
}
