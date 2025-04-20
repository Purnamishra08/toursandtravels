<?php
namespace App\Http\Controllers\Website\ContactUs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactusController extends Controller{
    public function index(Request $request){
        $parameters = DB::table('tbl_parameters')
                ->select('parameter', 'par_value', 'parid')
                ->where('param_type', 'CS')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();
        return view('website.contactus', ['parameters' => $parameters]);
    }

    public function addContacUs(Request $request){
        try{
            if ($request->ajax()) {

                $validator = Validator::make($request->all(), [
                    'customer_name' => 'required|string|max:255',
                    'email_address' => 'required|email|max:255',
                    'phone_number' => 'required|digits_between:10,15',
                    'comments' => 'required|string',
                    'g-recaptcha-response' => 'required'
                ],[
                    'g-recaptcha-response.required' => 'Please verify that you are not a robot.'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first()
                    ]);
                }

                // Verify Google reCAPTCHA
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                    'response' => $request->input('g-recaptcha-response'),
                ]);
                $result = json_decode($response->body());

                if (!$result->success) {
                    return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
                }

                // Insert new hotel
                $enquiryId = DB::table('tbl_inquiries')->insertGetId([
                    'customer_name'     => $request->input('customer_name'),
                    'email_address'     => $request->input('email_address'),
                    'phone_number'      => $request->input('phone_number'),
                    'comments'          => $request->input('comments'),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);

                $enquiry_no = 'ENQ' . str_pad($enquiryId, '5', "0", STR_PAD_LEFT);
                DB::table('tbl_inquiries')->where('id',$enquiryId)->update(['inquiry_number' => $enquiry_no]);

                $insert_data = array(
                    'inquiries_id'      => $enquiryId,
                    'customer_name'     => $request->input('customer_name'),
                    'email_address'     => $request->input('email_address'),
                    'phone_number'      => $request->input('phone_number'),
                    'comments'          => $request->input('comments'),
                    'inquiry_number'    => $enquiry_no,
                    'created_at'        => now(),
                    'updated_at'        => now()
                );

                DB::table('tbl_inquiries_log')->insert($insert_data);

                $userName       = $request->input('customer_name');
                $emailId        = $request->input('email_address');
                $phone_number   = $request->input('phone_number');
                $comments       = $request->input('comments');

                $parameters = DB::table('tbl_parameters')
                        ->select('parameter', 'par_value', 'parid')
                        ->where('param_type', 'CS')
                        ->where('status', 1)
                        ->where('bit_Deleted_Flag', 0)
                        ->get();

                $htmlContent = "
                <!doctype html>
                <html>
                <head>
                    <meta charset='utf-8'>
                </head>
                <body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
                    <div style='width: 100%;background: #F5F5F5;color: #000;'>
                        <div style='text-align:center'>
                            <a href='".url('/')."'><img src='".asset('assets/imag/logo.png')."'></a>
                        </div>
                        <div style='clear:both'></div>
                    </div>

                    <div style='padding:10px 30px;'>
                        <p style='margin-top:30px;'>
                            You have received a new enquiry from the <strong>Contact Us</strong> page on your website. Please find the details below:
                        </p>
                        <div style='line-height:25px;font-size:14px'>
                            <div><strong>ENQUIRY NUMBER:</strong> $enquiry_no </div>
                            <div><strong>NAME:</strong> $userName </div>
                            <div><strong>EMAIL:</strong> $emailId </div>
                            <div><strong>CONTACT NUMBER:</strong> $phone_number </div>
                            <div><strong>ENQUIRY COMMENTS:</strong> $comments </div>
                        </div>
                    </div>

                    <div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
                        <div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
                            &copy; ".date('Y')." All rights reserved. coorgpackages.com
                        </div>
                    </div>
                </body>
                </html>
                ";

                try {
                    Mail::send([], [], function ($message) use ($htmlContent, $parameters) {
                        $fromEmail = $parameters->firstWhere('parid', 9)->par_value ?? null;
                        $toEmail = $parameters->firstWhere('parid', 2)->par_value ?? null;

                        if (!$fromEmail || !$toEmail) {
                            throw
                                new \Exception("Missing email addresses in parameters table.");
                        }
                        $message->from(''.$fromEmail.'', 'Coorg Packages');
                        $message->to(''.$toEmail.'');
                        $message->subject('New enquiry from coorg packages contact us.');
                        $message->html($htmlContent, 'text/html');
                    });
                    return response()->json([
                        'success' => true,
                        'message' => 'Enquiry submitted successfully! We will contact you soon.'
                    ]);
                } catch (\Exception $e) {dd($e);
                    Log::error('Mail Send Failed: '.$e->getMessage());

                    return back()->with('error', 'Failed to send email. Please try again later.');
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request'
                ]);
            }
        }catch (\Exception $e) {dd($e);
            Log::error("Error in Contact Us: " . $e->getMessage());
            abort(500, 'Something went wrong. Please try again later.');
        }
    }
}