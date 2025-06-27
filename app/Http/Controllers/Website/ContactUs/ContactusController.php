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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactusController extends Controller{
    public function index(Request $request){
        $contactUsData = DB::table('tbl_contents')
                        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
                        ->where('content_id', 3)
                        ->where('bit_Deleted_Flag', 0)
                        ->first();

        $meta_title         =  isset($contactUsData) ? $contactUsData->seo_title : '';
        $meta_keywords      =  isset($contactUsData) ? $contactUsData->seo_keywords : '';
        $meta_description   =  isset($contactUsData) ? $contactUsData->seo_description : '';

        $parameters = DB::table('tbl_parameters')
                ->select('parameter', 'par_value', 'parid')
                ->where('param_type', 'CS')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();

        // 1. Organization Schema
        $organisationSchema = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Coorg Packages",
            "url" => url('/'),
            "logo" => "https://coorgpackages.com/assets/img/mhh-logo.webp",
            "email" => $parameters[3]->par_value ?? "support@coorgpackages.com",
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => $parameters[2]->par_value ?? "+91 9886525253",
                "contactType" => "Customer Service",
                "areaServed" => "IN",
                "availableLanguage" => ["English", "Hindi", "Kannada"]
            ],
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "#69 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar",
                "addressLocality" => "Bengaluru",
                "addressRegion" => "Karnataka",
                "postalCode" => "560010",
                "addressCountry" => "IN"
            ],
            "sameAs" => array_filter([
                $parameters[14]->par_value ?? null,
                $parameters[15]->par_value ?? null,
                $parameters[16]->par_value ?? null
            ])
        ];
        // 2.Webpage schema
        $webPageSchema=[
            "@context"      => "https://schema.org",
            "@type"         => "WebPage",
            "name"          => $meta_title ?? 'Coorg Packages',
            "url"           => url()->current(),
            "description"   => $meta_description ?? 'Plan your trip to Coorg with affordable tour packages.',
            "keywords"      => $meta_keywords ?? "",
            "inLanguage"    => "en",
            "isPartOf"      => [
                "@type" => "Website",
                "name"  => "Coorg Packages",
                "url"   => url('/')
            ]
        ];
        // 3.Contact us schema
        $contactUsSchema = [
            "@context" => "https://schema.org",
            "@type" => "ContactPage",
            "name" => "Contact Us",
            "url" => url()->current(),
            "mainEntity" => [
                "@type" => "Organization",
                "name" => "Coorg Packages",
                "url" => url('/'),
                "logo" => "https://www.coorgpackages.com/mhh-logo.webp",
                "email" => $parameters[3]->par_value ?? "support@coorgpackages.com",
                "contactPoint" => [
                    [
                        "@type" => "ContactPoint",
                        "telephone" => $parameters[2]->par_value ?? "+91 9886 52 52 53",
                        "contactType" => "Customer Support",
                        "areaServed" => "IN",
                        "availableLanguage" => ["English", "Hindi"]
                    ]
                ],
                "address" => [
                    "@type" => "PostalAddress",
                    "streetAddress" => "#66 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar, Bengaluru, Karnataka 560010",
                    "addressLocality" => "Bengaluru",
                    "addressRegion" => "Karnataka",
                    "postalCode" => "560010",
                    "addressCountry" => "IN"
                ],
                "sameAs" => [
                    "https://en-gb.facebook.com/myholhap/",
                    "https://twitter.com/MyHolidayHappi1",
                    "https://www.linkedin.com/company/28728838"
                ]
            ]
        ];
        return view('website.contactus',
         [
           'parameters'          => $parameters,
           'organisationSchema'  => $organisationSchema,
           'webPageSchema'       => $webPageSchema,
           'contactUsSchema'     => $contactUsSchema
         ])
        ->with([
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ]);
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
                // Prepare user email
                $userMessage = "
                <div style='font-family: Arial, sans-serif; border:1px solid #eee; padding:20px; max-width:600px; margin:auto;'>
                    <div style='text-align:center; margin-bottom:20px;'>
                        <a href='" . url('/') . "'>
                            <img src='" . asset('assets/img/logo.png') . "' alt='My Holiday Happiness Logo' style='max-height:80px;'>
                        </a>
                    </div>
                    <h2 style='color:#0d6efd;'>Thank You for Your Enquiry</h2>
                    <p>Dear {$userName},</p>
                    <p>We appreciate your interest in My Holiday Happiness. Your enquiry has been successfully received and is currently being reviewed by our travel team.</p>
                    <p>Our representative will get in touch with you within the next <strong>6 to 8 hours</strong> to assist you further.</p>
                    <div style='line-height:25px;font-size:14px; margin-top:20px;'>
                        <div><strong>Enquiry Reference Number:</strong> {$enquiry_no}</div>
                    </div>
                    <p style='margin-top:20px;'>For immediate assistance, please call us at <strong>+91 98865 25253</strong>.</p>
                    <br>
                    <p>Warm regards,<br><strong>Team My Holiday Happiness</strong></p>
                </div>";


                //Admin message
                $htmlContent = "
                <!doctype html>
                <html>
                <head>
                    <meta charset='utf-8'>
                </head>
                <body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
                    <div style='width: 100%;background: #F5F5F5;color: #000;'>
                        <div style='text-align:center'>
                            <a href='".url('/')."'><img src='".asset('assets/img/logo.png')."'></a>
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
                    $fromEmail = $parameters->firstWhere('parid', 9)->par_value ?? null;
                    $toEmail = $parameters->firstWhere('parid', 2)->par_value ?? null;
                    $toEmailClient = isset($emailId) ? $emailId : null;
                
                    if (!$fromEmail || !$toEmail || !$toEmailClient) {
                        return response()->json(['status' => 'error', 'message' => 'Failed to send email. Email details missing.']);
                    }
                
                    $mail = new PHPMailer(true);
                
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host       = env('MAIL_HOST');
                    $mail->SMTPAuth   = true;
                    $mail->Username   = env('MAIL_USERNAME');
                    $mail->Password   = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587; // or 465 for SMTPS 2525
                
                    //Recipients
                    $mail->setFrom($fromEmail, 'Coorg Packages');
                    $mail->addAddress($toEmail);
                
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'New enquiry from coorg packages contact us';
                    $mail->Body    = $htmlContent;
                
                    $mail->send();
                    
                    $mailClient = new PHPMailer(true);
                    //Server settings
                    $mailClient->isSMTP();
                    $mailClient->Host       = env('MAIL_HOST');
                    $mailClient->SMTPAuth   = true;
                    $mailClient->Username   = env('MAIL_USERNAME');
                    $mailClient->Password   = env('MAIL_PASSWORD');
                    $mailClient->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mailClient->Port       = 587; // or 465 for SMTPS 2525
                
                    //Recipients
                    $mailClient->setFrom($fromEmail, 'Coorg Packages');
                    $mailClient->addAddress($toEmailClient);
                
                    // Content
                    $mailClient->isHTML(true);
                    $mailClient->Subject = 'Your Enquiry with Coorg Packages [Ref: '.$enquiry_no.' ]';
                    $mailClient->Body    = $userMessage;
                
                    $mailClient->send();
                    return response()->json([
                        'success' => true,
                        'message' => 'Enquiry submitted successfully!'
                    ]);
                } catch (Exception $e) {
                    \Log::error('Mail Send Failed: ' . $e->getMessage());
                    return response()->json(['status' => 'error', 'message' => 'Failed to send email. Please try again later.']);
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