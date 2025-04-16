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

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        try {
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
                        <img src="' . asset('storage/blog_images/' . $values->image) . '" alt="' . $values->alttag_image . '" />
                        <p class="tour-badge">Travel</p>
                        <div class="card-body">
                            <ul>
                                <li><i class="bi bi-calendar"></i> ' . date('d-M-Y', strtotime($values->created_date)) . '</li>
                            </ul>
                            <h5 class="card-title mt-2">' . $values->title . '</h5>
                            <p>' . implode(' ', array_slice(explode(' ', $values->content), 0, 30)) . '</p>
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
            return view('website.bloglisting');
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
    
            return view('website.blogdetails', compact('blog', 'blogData', 'parameters', 'blogDataFooter', 'footer', 'blogDataRecent'))
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
        if ($request->ajax()) {
            $blog = DB::table('tbl_blog')
            ->select('blogid')
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

                DB::table('tbl_comments')->insert([
                    'blogid'        => $blog->blogid,
                    'user_name'     => $request->input('user_name'),
                    'email_id'      => $request->input('email_id'),
                    'comments'      => $request->input('comments'),
                    'created_date'  => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Comment submitted successfully!'
                ]);
            }
            
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid request'
        ]);
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
                    <img class="card-img-top" src="' . asset('storage/blog_images/' . $values->image) . '" alt="' . $values->alttag_image . '" />
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