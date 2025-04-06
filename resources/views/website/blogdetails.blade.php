@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Blogs</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
          
            <li class="breadcrumb-item">
                <a href="{{ route('website.blogdetails', ['slug' => $blog->blog_url]) }}" class="breadcrumb-link active">Blogs</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 blog-details-box">
                    <img src="{{ asset('storage/blog_images/' . $blog->image) }}" alt="{{ $blog->alttag_image }}" />
                    <h3 class="mt-2">{{ $blog->title }}</h3>
                    <ul class="mb-3">
                        <li><i class="bi bi-calendar me-2"></i> {{ date('d-M-Y', strtotime($blog->created_date)) }}</li>

                    </ul>
                    <p>{!! $blog->content !!}</p>
                    <div class="d-flex gap-2 align-items-center mt-3 blog-share">
                        <strong>Share :</strong>
                        <ul class="d-flex align-items-center gap-1">
                            <li><a href="#" title="facebook"> <i class="bi bi-facebook"></i></a></li>
                            <li><a href="#" title="Twitter"> <i class="bi bi-twitter-x"></i></a></li>
                            <li><a href="#" title="Google+"> <i class="bi bi-google"></i></a></li>
                            <li><a href="#" title="Linkdin"> <i class="bi bi-linkedin"></i></a></li>
                        </ul>

                    </div>
                    <div class="mt-3 mt-md-4 bg-light p-3 rounded">
                      <h5>Leave a comment</h5>
                      <span>  Your email address will not be published. Required fields are marked *</span>
                        <form method="POST" id="blog_comments" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-3 g-3">
                                <div class="col-md-6">
                                <label  class="d-block"> Name</label>
                                <input type="text" class="form-control" name="user_name" id="user_name">
                                </div>
                                <div class="col-md-6">
                                <label  class="d-block"> Email</label>
                                <input type="email" class="form-control" name="email_id" id="email_id">
                                </div>
                                <div class="col-md-12">
                                <label  class="d-block">Comment </label>
                                <textarea class="form-control" name="comments" id="comments"></textarea>
                                </div>
                                <input type="hidden" value="{{$blog->blog_url}}" name="blog_url" id="blog_url">
                                <div class="col-md-12">
                                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 ">
                    <div class="stickey-section">

                        <div class="card mb-2">
                            <div class="card-header bg-white">
                                <h5 class="mt-3">Search Here</h5>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="blogSearchInput" placeholder="Search by Title" aria-label="Search" />
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mt-3">Recent Blog</h5>
                            </div>
                            <div class="card-body">
                                <ul class="m-0 p-0" id="recentBlogList">
                                    @foreach($blogDataRecent as $values)
                                        <li class="d-flex gap-3 recent-blog-card">
                                            <img class="card-img-top" src="{{ asset('storage/blog_images/' . $values->image) }}" alt="{{ $values->alttag_image }}" />
                                            <div>
                                                <a href="{{ route('website.blogdetails', ['slug' => $values->blog_url]) }}">{{ $values->title }}</a>
                                                <ul>
                                                    <li><i class="bi bi-calendar"></i> {{ date('d-M-Y', strtotime($values->created_date)) }}</li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@include('website.include.webfooter')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $('#blog_comments').on('submit', function(e) {
        e.preventDefault(); // 🔒 prevent normal form submit

        let name = $('#user_name').val().trim();
        let email = $('#email_id').val().trim();
        let comment = $('#comments').val().trim();
        let recaptcha = grecaptcha.getResponse();

        if (name === '') {
            Swal.fire('Error', 'Please enter your name', 'error');
            return false;
        }
        if (email === '') {
            Swal.fire('Error', 'Please enter your email', 'error');
            return false;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            Swal.fire('Error', 'Please enter a valid email address', 'error');
            return false;
        }
        if (comment === '') {
            Swal.fire('Error', 'Please enter a comment', 'error');
            return false;
        }
        if (recaptcha === '') {
            Swal.fire('Error', 'Please verify reCAPTCHA', 'error');
            return false;
        }

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('website.blogComments') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success');
                    $('#blog_comments')[0].reset();
                    grecaptcha.reset();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Something went wrong. Try again.', 'error');
            }
        });
    });
    $('#blogSearchInput').on('keyup', function () {
        let query = $(this).val().trim();

        $.ajax({
            url: '{{ route("website.blogsearch") }}',
            method: 'GET',
            data: { search: query },
            success: function (response) {
                $('#recentBlogList').html(response.html);
            },
            error: function () {
                console.error("Error fetching search results.");
            }
        });
    });
</script>