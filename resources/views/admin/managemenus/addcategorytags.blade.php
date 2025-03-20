<!-- Metaheader Section-->
@include('Admin.include.metaheader')
<!-- Metaheader Section End -->
<body>
    <div id="layoutSidenav">
        <!-- Left Navbar Start-->
        @include('Admin.include.leftNavbar')
        <!-- Left Navbar End-->

        <div id="layoutSidenav_content">
            <div class="content-body">

                <!-- TopBar header Start-->
                @include('Admin.include.topBarHeader')
                <!-- TopBar header End -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <a href="{{ isset($Categorytags) ? route('admin.categorytags.editcategorytags', ['id' => $Categorytags->tagid]) : route('admin.categorytags.addcategorytags') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($Categorytags) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.categorytags') }}" class="tab-menu__item">
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
                            @include('Admin.include.sweetaleart')

                            <section class="content">
                                <div class="form-container" style="margin-bottom: 25px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16); background-color:#fff; padding:25px; border-radius: 4px;">
                                    <div class="panel-body">
                                        <form action="{{ isset($Categorytags) ? route('admin.categorytags.editcategorytags', $Categorytags->tagid) : route('admin.categorytags.addcategorytags') }}" id="form_menutags" name="form_menutags" class="add-user" enctype="multipart/form-data" method="post" onsubmit="return validator()">
                                            @csrf
                                            <div class="box-main">
                                                <h3>Tag Details</h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Tag Name  <span class="manadatory">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Enter Tag Name" name="tag_name" id="tag_name" value="{{ old('tag_name', $Categorytags->tag_name ?? '') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Tag URL  <span class="manadatory">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Enter Tag URL" name="tag_url" id="tag_url" readonly value="{{ old('tag_url', $Categorytags->tag_url ?? '') }}">
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Menu  <span class="manadatory">*</span></label>
                                                            <select class="form-control" name="menuid" id="menuid" onchange="getCategory(this)">
                                                                <option value=""> --Select menu tab--</option>
                                                                @foreach($menuTags as $menu)
                                                                    <option value="{{ $menu->menuid }}" 
                                                                        {{ old('menuid', $Categorytags->menuid ?? '') == $menu->menuid ? 'selected' : '' }}>
                                                                        {{ $menu->menu_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Category  <span class="manadatory">*</span></label>
                                                            <select class="form-control" name="catId" id="catId">
                                                                <option value=""> -- Select category --</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Banner Image  <span class="manadatory">*</span></label>
                                                            <input name="menutag_img" id="menutag_img" type="file" onchange="previewImage(event, 'banner_preview')">
                                                            <span>Image size should be 1920px X 488px</span>
                                                            <div id="banner_preview" style="margin-top: 10px;">
                                                                <img id="bannerPreview" 
                                                                    src="{{ isset($Categorytags->menutag_img) ? asset('storage/category_tags_images/BannerImages/'.$Categorytags->menutag_img) : '' }}" 
                                                                    alt="Banner Preview" 
                                                                    class="img-fluid rounded border" 
                                                                    style="width: 400px; height: 200px; object-fit: cover; display: {{ isset($Categorytags->menutag_img) ? 'block' : 'none' }};">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Getaways/Tour Image</label>
                                                            <input name="menutagthumb_img" id="menutagthumb_img" type="file" onchange="previewImage(event, 'getaway_preview')">
                                                            <span>Image size should be 500px X 350px</span>
                                                            <div id="getaway_preview" style="margin-top: 10px;">
                                                                <img id="getaway_preview" 
                                                                    src="{{ isset($Categorytags->menutagthumb_img) ? asset('storage/category_tags_images/GetawaysImages/'.$Categorytags->menutagthumb_img) : '' }}" 
                                                                    alt="Banner Preview" 
                                                                    class="img-fluid rounded border" 
                                                                    style="width: 400px; height: 200px; object-fit: cover; display: {{ isset($Categorytags->menutagthumb_img) ? 'block' : 'none' }};">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Alt Tag For Banner Image</label>
                                                            <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="{{ old('alttag_banner', $Categorytags->alttag_banner ?? '') }}" maxlength="60">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Alt Tag For Getaways Image</label>
                                                            <input type="text" class="form-control" placeholder="Enter Alt tag for getaways image" name="alttag_thumb" id="alttag_thumb" value="{{ old('alttag_thumb', $Categorytags->alttag_thumb ?? '') }}" maxlength="60">
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Show on home page</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="checkbox" name="show_on_home" id="show_on_home" value="1" {{ old('show_on_home', $Categorytags->show_on_home ?? 0) == 1 ? 'checked' : '' }}>
                                                                    Top weekend getaways / Most popular tours
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>Show on footer menu</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1" {{ old('show_on_footer', $Categorytags->show_on_footer ?? 0) == 1 ? 'checked' : '' }}>
                                                                    For footer menu
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <div class="col-md-12">
                                                        <div class="form-group" style="margin-bottom: 20px;">
                                                            <label>About Tag</label>
                                                            <textarea name="about_tag" id="about_tag" class="form-control">{{ old('about_tag', $Categorytags->about_tag ?? '') }}</textarea>
                                                            <div id="aboutplace_err"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="box-main">
                                                    <h3>Meta Tags</h3>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="margin-bottom: 20px;">
                                                                <label>Meta Title</label>
                                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title">{{ old('meta_title', $Categorytags->meta_title ?? '') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" style="margin-bottom: 20px;">
                                                                <label>Meta Keywords</label>
                                                                <textarea name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('meta_keywords', $Categorytags->meta_keywords ?? '') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" style="margin-bottom: 20px;">
                                                                <label>Meta Description</label>
                                                                <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('meta_description', $Categorytags->meta_description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">{{ isset($Categorytags) ? 'Update' : 'Save' }}</button>
                                                        @if(!isset($Categorytags))
                                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                                        @endif
                                                    </div>
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
                @include('Admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    
    <!-- FooterJs Start-->
    @include('Admin.include.footerJs')
    <!-- FooterJs End-->
    
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <!-- JavaScript for Image Preview -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('about_tag');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        $(document).ready(function() {
            var menuId = '{{isset($Categorytags->menuid) ? $Categorytags->menuid : 0 }}'; // Assuming this is a valid variable with a menuid
            getCategory({ value: menuId });
        });
        $(document.body).on('keyup change', '#tag_name', function() {
			$("#tag_url").val(name_to_url($(this).val()));
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
            if(!blankCheck('tag_name', 'Tag name cannot be blank'))
                return false;
            if(!blankCheck('tag_url', 'Tag name cannot be blank'))
                return false;
            if(!selectDropdown('menuid', 'Menu is required'))
                return false;
            if(!selectDropdown('catId', 'Category is required'))
                return false;
            if(!validateFilePresence('menutag_img', 'Banner image is required.'))
                return false;
            if(!validateFilePresence('menutagthumb_img', 'Getaways/Tour Image is required.'))
                return false;
            if (!blankCheck('alttag_banner', 'Banner Alt Tag cannot be blank'))
                 return false;
            if (!blankCheck('alttag_thumb', 'Alt Tag For Getaways Image cannot be blank'))
                 return false;
            if (!blankCheck('about_tag', 'About Tag cannot be blank'))
                 return false;
            if (!blankCheck('meta_title', 'Meta Title cannot be blank'))
                 return false;
            if (!blankCheck('meta_keywords', 'Meta Keywords cannot be blank'))
                 return false;
            if (!blankCheck('meta_description', 'Meta Description cannot be blank'))
                 return false;
        }
        function getCategory(selectElement) {
            var menuId = selectElement.value;
        
            if (menuId) {
                $.ajax({
                    url: "{{ url('/categorytags/getCategoryMenuWise') }}", // Route for AJAX request
                    type: "POST",
                    data: { menu_id: menuId },
                    dataType: "json",
                    cache: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        var categorySelect = $('#catId');
                        categorySelect.empty(); // Clear previous categories
                        categorySelect.append('<option value=""> -- Select category --</option>'); // Default option
                        
                        // Loop through the categories returned from the controller
                        $.each(response.categories, function(index, category) {
                            var selected = '';
                            if (category.catid == '{{ old('catId', $Categorytags->cat_id ?? '') }}') {
                                selected = 'selected';
                            }
                            categorySelect.append('<option value="' + category.catid + '" ' + selected + '>' + category.cat_name + '</option>');
                        });
                    }
                });
            } else {
                $('#catId').empty().append('<option value=""> -- Select category --</option>'); // Reset if no menu selected
            }
        }
    </script>
</body>
</html>
