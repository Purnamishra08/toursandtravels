<?php

namespace App\Http\Controllers\Admin\ManageUser;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.manageuser.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_id' => 'required|email',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required'
        ],[
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.'
        ]);

        // Verify Google reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
        ]);
        $result = json_decode($response->body());

        if (!$result->success) {
            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
        }

        $credentials = [
            'email_id' => $request->email_id,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->bit_Deleted_Flag == 0 && $user->status == 1) {
                $moduleAccess = DB::table('tbl_admin_modules')->where('adminid', $user->adminid)->where('bit_Deleted_Flag', 0)->pluck( 'moduleDeleteAccess', 'moduleid')->toArray();
                session(['user' => Auth::user(), 'moduleAccess' => $moduleAccess]);
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
        return view('admin.manageuser.forgotpassword');
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
            return view('admin.manageuser.changePassword');
        }
    }

    public function checkEmailAndSendOTP(Request $request) {
        $email = $request->email;
        $user = DB::table('tbl_admin')
                ->where('email_id', $email)
                ->where('bit_Deleted_Flag', '=', 0)
                ->where('status', '=', 1)
                ->first();
        if (!empty($user)) {
            $otp = rand(100000, 999999);
            session(['otp' => $otp, 'otp_created_at' => now()]);
            $htmlContent = "
            <!doctype html>
            <html>
            <head>
                <meta charset='utf-8'>
            </head>
            <body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
                <div style='width: 100%;background: #F5F5F5;color: #000;'>
                    <div style='text-align:center'>
                        <a href='".url('/')."'><img src='".asset('assets/img/logo.png')."' alt='Logo'></a>
                    </div>
                    <div style='clear:both'></div>
                </div>

                <div style='padding:20px 30px;'>
                    <h2 style='margin-bottom: 20px; color: #333;'>Forgot Password - OTP Verification</h2>
                    <p>Hello <strong>$user->admin_name</strong>,</p>

                    <p>We have received a request to reset your password. Please use the One Time Password (OTP) below to proceed with resetting your password.</p>

                    <div style='background:#f0f0f0; padding:15px; margin:20px 0; text-align:center; font-size:18px; font-weight:bold; letter-spacing:3px;'>
                        $otp
                    </div>

                    <p>This OTP is valid for <strong>10 minutes</strong> and can only be used once.</p>
                    <p>If you did not request a password reset, please ignore this email.</p>

                    <p style='margin-top:30px;'>Thank you,<br>Team My Holiday Happiness</p>
                </div>

                <div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
                    <div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
                        &copy; ".date('Y')." All rights reserved. myholidayhappiness.com
                    </div>
                </div>
            </body>
            </html>
            ";
            try {
                Mail::send([], [], function ($message) use ($htmlContent, $user) {
                    $parameters = DB::table('tbl_parameters')->select('par_value')->Where('parid', 9)->where('status',1)->where('bit_Deleted_Flag', 0)->first();
                    $fromEmail = $parameters->par_value ?? null;
                    $toEmail = $user->email_id ?? null;

                    if (!$fromEmail || !$toEmail) {
                        return response()->json(['status' => 'error', 'message' => 'Failed to send email. email details missing.']);
                    }
                    $message->from(''.$fromEmail.'', 'Coorg Packages');
                    $message->to(''.$toEmail.'');
                    $message->subject('Forgot Password OTP.');
                    $message->html($htmlContent, 'text/html');
                });
                return response()->json(['status' => 'success']);
            } catch (\Exception $e) {dd($e);
                Log::error('Mail Send Failed: '.$e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Failed to send email. Please try again later.']);
            }

            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'User not found.']);
        }
    }
    
    public function verifyOtp(Request $request) {
        $otp = $request->otp;
        $storedOtp = session('otp');
        $created = session('otp_created_at');
    
        if (!$storedOtp || !$created || now()->diffInMinutes($created) > 10) {
            session()->forget(['otp', 'otp_created_at']);
            return response()->json(['status' => 'error', 'message' => 'OTP expired or not found.']);
        }
    
        if ($otp != $storedOtp) {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP.']);
        }
    
        return response()->json(['status' => 'success']);
    }
    
    public function resetPassword(Request $request) {
        if ($request->isMethod('post')) {
            $user = DB::table('tbl_admin')
                ->where('email_id', $request->email)
                ->where('bit_Deleted_Flag', '=', 0)
                ->where('status', '=', 1)
                ->first();

            if(empty($user)){
                return response()->json(['status' => 'error', 'message' => 'User not found.']);
            }else{
                $validator = Validator::make($request->all(), [
                    'new_password'          => 'required|min:6',
                    'confirm_password'      => 'required|same:new_password',
                    'recaptchaResponse'     => 'required'
                ],[
                    'recaptchaResponse.required' => 'Please verify that you are not a robot.'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => 'error',
                        'message' => $validator->errors()->first()
                    ]);
                }

                // Verify Google reCAPTCHA
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                    'response' => $request->input('recaptchaResponse'),
                ]);
                $result = json_decode($response->body());

                if (!$result->success) {
                    return response()->json(['status' => 'error', 'message' => 'reCAPTCHA verification failed. Please try again.']);
                }
            
                $user = DB::table('tbl_admin')
                ->where('email_id', $request->email)
                ->update([
                    'password' => Hash::make($request->new_password),
                    'updated_at' => now()
                ]);

                if($user){
                    return response()->json(['status' => 'success']);
                    session()->forget(['otp', 'otp_created_at', 'email']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again later!']);
                }
            }
        }
    }
    
}
