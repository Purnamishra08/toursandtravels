<?php
namespace App\Http\Controllers\Website\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $blogData = DB::table('tbl_contents')
                        ->select('page_name','page_content','seo_title','seo_description','seo_keywords')
                        ->where('content_id', 5)
                        ->where('bit_Deleted_Flag', 0)
                        ->first();

            $meta_title         =  isset($blogData) ? $blogData->seo_title : '';
            $meta_keywords      =  isset($blogData) ? $blogData->seo_keywords : '';
            $meta_description   =  isset($blogData) ? $blogData->seo_description : '';

            $blogData = DB::table('tbl_blog')
                    ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
                    ->where('status', 1)
                    ->where('bit_Deleted_Flag', 0)
                    ->orderByDesc('created_date')
                    ->paginate(6);
            if ($request->ajax()) {
                $html = '';
                foreach ($blogData as $values) {
                    $html .= '
                    <div class="card recent-post-card wow animate__fadeInUp" data-wow-delay="200ms">
                        <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" target="_blank">
                            <img src="' . asset('storage/blog_images/' . $values->image) . '" alt="' . $values->alttag_image . '" />
                        </a>
                        <p class="tour-badge">Travel</p>
                        <div class="card-body">
                            <ul>
                                <li><i class="bi bi-calendar"></i> ' . date('d-M-Y', strtotime($values->created_date)) . '</li>
                            </ul>
                            <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" target="_blank" style="color:black">
                                <h5 class="card-title mt-2">' . $values->title . '</h5>
                                <p>' . implode(' ', array_slice(explode(' ', $values->content), 0, 30)) . '</p>
                            </a>
                            
                            <div class="text-end mt-2">
                                <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" class="btn btn-outline-primary">
                                    Read More <i class="ms-2 bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>
                    </div>';
                }
                return $html;
            }

            $blogSchemas = [];
            foreach ($blogData as $blog) {
                $blogSchemas[] = [
                    "@context" => "https://schema.org",
                    "@type" => "BlogPosting",
                    "mainEntityOfPage" => [
                        "@type" => "WebPage",
                        "@id" => url('/blog/' . $blog->blog_url)
                    ],
                    "headline" => $blog->title,
                    "image" => [asset('storage/blog_images/' . $blog->image)],
                    "datePublished" => date('c', strtotime($blog->created_date)),
                    "dateModified" => date('c', strtotime($blog->created_date)),
                    "author" => [
                        "@type" => "Organization",
                        "name" => "coorgpackages.com",
                        "url" => url('/')
                    ],
                    "publisher" => [
                        "@type" => "Organization",
                        "name" => "coorgpackages.com",
                        "logo" => [
                            "@type" => "ImageObject",
                            "url" => "https://coorgpackages.com/assets/img/mhh-logo.webp"
                        ]
                    ],
                    "description" => Str::limit(strip_tags(html_entity_decode($blog->content)), 160),
                ];
            }
            return view('website.bloglisting',['blogSchemas'=>$blogSchemas])->with([
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords
            ]);
        } catch (\Exception $e) {
            Log::error("Error in BlogDetails: " . $e->getMessage());
            abort(500, 'Something went wrong. Please try again later.');
        }
    }

    public function blogdetails($slug)
    {
        try {
            $blog = DB::table('tbl_blog')
                ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment', 'blog_meta_title', 'blog_meta_keywords', 'blog_meta_description')
                ->where('blog_url', $slug)
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->first();
    

            if (!$blog) {
                abort(404, 'Blog post not found');
            }

            $blogComments = DB::table('tbl_comments')
                ->selectRaw('commentid, blogid, parentid, user_name, email_id, comments, status, created_date, created_by, updated_date, updated_by, bit_Deleted_Flag')
                ->where('blogid', $blog->blogid)
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();

            $blogData = DB::table('tbl_blog')
                ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();
    
            $parameters = DB::table('tbl_parameters')
                ->select('parameter', 'par_value', 'parid')
                ->where('param_type', 'CS')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();
    
            $blogDataFooter = DB::table('tbl_blog')
                ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->limit(6)
                ->get();
    
            $footer = DB::table('tbl_footer')
                ->select('vch_Footer_Name', 'vch_Footer_URL', 'int_footer_id')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->get();
    
            $blogDataRecent = DB::table('tbl_blog')
                ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->orderBy('created_date', 'DESC')
                ->limit(6)
                ->get();
    
            return view('website.blogdetails', compact('blog', 'blogData', 'parameters', 'blogDataFooter', 'footer', 'blogDataRecent', 'blogComments'))
                ->with([
                    'meta_title' => $blog->blog_meta_title,
                    'meta_description' => $blog->blog_meta_description,
                    'meta_keywords' => $blog->blog_meta_keywords
                ]);
        } catch (\Exception $e) {
            Log::error("Error in BlogDetails: " . $e->getMessage());
            abort(500, 'Something went wrong. Please try again later.');
        }
    }

    public function blogComments(Request $request)
    {
        try{
            if ($request->ajax()) {
                $blog = DB::table('tbl_blog')
                ->select('blogid', 'title')
                ->where('blog_url', $request->input('blog_url'))
                ->where('status', 1)
                ->where('bit_Deleted_Flag', 0)
                ->first();
                if (!$blog) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong ! Parameters missing.'
                    ]);
                }else{
                    // Validate input
                    $validator = Validator::make($request->all(), [
                        'user_name' => 'required|string|max:255',
                        'email_id' => 'required|email|max:255',
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
    
                    $BlogData = DB::table('tbl_comments')->insert([
                        'blogid'        => $blog->blogid,
                        'user_name'     => $request->input('user_name'),
                        'email_id'      => $request->input('email_id'),
                        'comments'      => $request->input('comments'),
                        'created_date'  => now(),
                    ]);
                    if($BlogData){
                        $userName = $request->input('user_name');
                        $emailId = $request->input('email_id');
                        $comments = $request->input('comments');

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
                                    <a href='".url('/')."'><img src='".asset('assets/img/logo.png')."'></a>
                                </div>
                                <div style='clear:both'></div>
                            </div>
    
                            <div style='padding:10px 30px;'>
                                <p style='margin-top:30px;'>There is a comment from website (Blogs). Please have a look below details:</p>
                                <div style='line-height:25px;font-size:14px'>
                                    <div><strong>NAME:</strong> $userName </div>
                                    <div><strong>EMAIL:</strong> $emailId </div>
                                    <div><strong>BLOG DETAILS:</strong> $blog->title </div>
                                    <div><strong>BLOG COMMENTS:</strong> $comments </div>
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
                        
                            if (!$fromEmail || !$toEmail) {
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
                            $mail->Subject = 'New comments from coorg packages blog';
                            $mail->Body    = $htmlContent;
                        
                            $mail->send();
                            return response()->json([
                                'success' => true,
                                'message' => 'Comment submitted successfully!'
                            ]);
                        } catch (Exception $e) {
                            \Log::error('Mail Send Failed: ' . $e->getMessage());
                            return response()->json(['status' => 'error', 'message' => 'Failed to send email. Please try again later.']);
                        }
                    }
                }
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }catch (\Exception $e) {dd($e);
            Log::error("Error in BlogDetails: " . $e->getMessage());
            abort(500, 'Something went wrong. Please try again later.');
        }
        
    }
    
    public function searchRecentBlog(Request $request)
    {
        $query = $request->input('search');

        $blogs = DB::table('tbl_blog')
            ->select('blogid', 'title', 'blog_url', 'status', 'image', 'alttag_image', 'content', 'created_date', 'show_comment')
            ->where('status', 1)
            ->where('bit_Deleted_Flag', 0)
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%');
            })
            ->orderBy('created_date', 'DESC')
            ->limit(6)
            ->get();

        $html = '';
        foreach ($blogs as $values) {
            $html .= '
                <li class="d-flex gap-3 recent-blog-card">
                    <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '" target="_blank">
                        <img class="card-img-top" src="' . asset('storage/blog_images/' . $values->image) . '" alt="' . $values->alttag_image . '" />
                    </a>
                    <div>
                        <a href="' . route('website.blogdetails', ['slug' => $values->blog_url]) . '">' . $values->title . '</a>
                        <ul>
                            <li><i class="bi bi-calendar"></i> ' . date('d-M-Y', strtotime($values->created_date)) . '</li>
                        </ul>
                    </div>
                </li>';
        }

        return response()->json(['html' => $html]);
    }
}