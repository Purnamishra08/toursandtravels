<!-- Metaheader Section-->
@include('admin.include.metaheader')
<!-- Metaheader Section End -->
<body>
    <div id="layoutSidenav">
        <!-- Left Navbar Start-->
        @include('admin.include.leftNavbar')
        <!-- Left Navbar End-->

        <div id="layoutSidenav_content">
            <div class="content-body">

                <!-- TopBar header Start-->
                @include('admin.include.topBarHeader')
                <!-- TopBar header End -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <a href="{{ isset($BlogData) ? route('admin.manageblogs.editmanageblogs', ['id' => $BlogData->blogid]) : route('admin.manageblogs.addmanageblogs') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($BlogData) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.manageblogs') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View
                                </a>
                                <!-- table-utilities -->
                                <div class="table-utilities">
                                    <strong class="manadatory me-1">*</strong>Indicates Mandatory
                                </div>
                                <!-- table-utilities end-->
                            </nav>
                            @include('admin.include.sweetaleart')

                            <section class="content">
                                <div class="form-container">
                                    <div class="panel-body">
                                        <form action="{{ isset($BlogData) ? route('admin.manageblogs.editmanageblogs', ['id' => $BlogData->blogid]) : route('admin.manageblogs.addmanageblogs') }}" method="POST" enctype="multipart/form-data" onsubmit="return validator()">
                                            @csrf
                                            <div class="box-main">
                                                
                                                <fieldset>
                                                    <legend> Footer Link Details</legend>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Post Title  <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter post title" name="title" id="title" value="{{ old('title', $BlogData->title ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Blog Url <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" readonly placeholder="Enter blog url" name="blog_url" id="blog_url" value="{{ old('blog_url', $BlogData->blog_url ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Featured Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Featured Image <span class="manadatory">*</span></label>
                                                                <input name="image" id="image" class="form-control" type="file" onchange="previewImage(event, 'banner_preview')">
                                                                <span>Image size should be 1140px X 350px</span>
                                                                <div id="banner_preview" style="margin-top: 10px;">
                                                                    <img id="bannerPreview"
                                                                    src="{{ isset($BlogData->image) ? asset('storage/blog_images/'.$BlogData->image) : '' }}"
                                                                    alt="Banner Preview"
                                                                    class="img-fluid rounded border"
                                                                    style="width: 400px; height: 200px; object-fit: cover; display: {{ isset($BlogData->image) ? 'block' : 'none' }};">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Alt Tag For Featured Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Alt Tag For Featured Image <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter Alt Tag For Featured Image" name="alttag_image" id="alttag_image" value="{{ old('alttag_image', $BlogData->alttag_image ?? '') }}" maxlength="60">
                                                            </div>
                                                        </div>

                                                        <!-- Show Comments -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Show Comments</label>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="checkbox" name="show_comment" id="show_comment" value="1" {{ old('show_comment', $BlogData->show_comment ?? '') ? 'checked' : '' }}>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Show home -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Show home</label>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="checkbox" name="show_in_home" id="show_in_home" value="1" {{ old('show_in_home', $BlogData->show_in_home ?? '') ? 'checked' : '' }}>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Content <span class="manadatory">*</span></label>
                                                                <textarea name="content" id="content" class="form-control">{{ old('content', $BlogData->content ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="clearfix"></div>

                                            <!-- Meta Tags Section -->
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend>Meta Tags</legend>
                                                        <div class="row">
                                                            <!-- Meta Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Title</label>
                                                                    <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="blog_meta_title" id="blog_meta_title">{{ old('blog_meta_title', $BlogData->blog_meta_title ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Keyword</label>
                                                                    <textarea name="blog_meta_keywords" id="blog_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('blog_meta_keywords', $BlogData->blog_meta_keywords ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Description</label>
                                                                    <textarea name="blog_meta_description" id="blog_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('blog_meta_description', $BlogData->blog_meta_description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="reset-button">
                                                    <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">{{ isset($BlogData) ? 'Update' : 'Save' }}</button>
                                                    @if(!isset($BlogData))
                                                        <button name='reset' type="reset" value='Reset' class="btn btn-secondary">Reset</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>

                <!-- Footer Start-->
                @include('admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('admin.include.footerJs')
    <!-- FooterJs End-->
    
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
         document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('content');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        
        $(document.body).on('keyup change', '#title', function() {
			$("#blog_url").val(name_to_url($(this).val()));
		});
		function name_to_url(name) {
			name = name.toLowerCase(); // lowercase
			name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
			name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
			name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
			return name;
		}
        function previewImage(event, previewId) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById(previewId);
                output.innerHTML = '<img src="' + reader.result + '" alt="Preview" style="width: 400px; height: 200px; object-fit: cover; border: 1px solid #ddd; padding: 5px; margin-top: 10px;">';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        function validator() {
            if (!blankCheck('title', 'Post Title cannot be blank')) return false;
            if (!blankCheck('blog_url', 'Blog URL cannot be blank')) return false;
            if (!validateFilePresence('image', 'Featured image is required.')) return false;
            if (!blankCheck('alttag_image', 'Alternative taf for featured image cannot be blank')) return false;
            if (!blankCheck('content', 'Content cannot be blank')) return false;
            return true;
        }
    </script>
</body>
</html>
