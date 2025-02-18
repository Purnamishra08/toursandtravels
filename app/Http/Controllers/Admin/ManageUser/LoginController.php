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
       
        $credentials = $request->only('email_id', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard'); // Redirect to dashboard after login
        }else{
            return back()->withErrors(['email_id' => 'Invalid credentials.']);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
