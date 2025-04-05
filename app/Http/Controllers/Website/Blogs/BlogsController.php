<?php
namespace App\Http\Controllers\Website\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

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
                            <h5 class="card-title mt-3">' . $values->title . '</h5>
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
            $parameters =  DB::table('tbl_parameters')
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
            $footer =  DB::table('tbl_footer')
                        ->select('vch_Footer_Name', 'vch_Footer_URL', 'int_footer_id')
                        ->where('status', 1)
                        ->where('bit_Deleted_Flag', 0)
                        ->get();
            return view('website.bloglisting', ['parameters' => $parameters, 'blogDataFooter' => $blogDataFooter, 'footer' => $footer]);
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
}