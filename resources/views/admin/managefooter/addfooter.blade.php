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
                                <a href="{{ isset($footerData) ? route('admin.footerlinks.editfooterlinks', ['id' => $footerData->int_footer_id]) : route('admin.footerlinks.addfooterlinks') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($footerData) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.footerlinks') }}" class="tab-menu__item">
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
                                        <form action="{{ isset($footerData) ? route('admin.footerlinks.editfooterlinks', ['id' => $footerData->int_footer_id]) : route('admin.footerlinks.addfooterlinks') }}" method="POST" enctype="multipart/form-data" onsubmit="return validator()">
                                            @csrf
                                            <div class="box-main">
                                                
                                                <fieldset>
                                                    <legend> Footer Link Details</legend>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Footer Name  <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter footer name" name="vch_Footer_Name" id="vch_Footer_Name" value="{{ old('vch_Footer_Name', $footerData->vch_Footer_Name ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Footer Url <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" readonly placeholder="Enter footer url" name="vch_Footer_URL" id="vch_Footer_URL" value="{{ old('vch_Footer_URL', $footerData->vch_Footer_URL ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Package Tour Tags <span class="manadatory">*</span></label>
                                                                <select data-placeholder="Choose associated tour tags" class="chosen-select" multiple tabindex="4" id="tourpackageid" name="tourpackageid[]" style="width: 100%;">
                                                                    @foreach($tourpackageid as $tag)
                                                                        <option value="{{ $tag->tourpackageid }}"
                                                                            @if(isset($footerData->tourpackageid) && in_array($tag->tourpackageid, explode(',', $footerData->tourpackageid))) selected @endif>
                                                                            {{ $tag->tpackage_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Footer Destination <span class="manadatory">*</span></label>
                                                                <textarea name="vch_Footer_Desc" id="vch_Footer_Desc" class="form-control">{{ old('vch_Footer_Desc', $footerData->vch_Footer_Desc ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="clearfix"></div>
                                            <!-- Meta Tags Section -->
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend>Footer Meta Tags</legend>
                                                        <div class="row">
                                                            <!-- Footer Meta Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Footer Meta Title</label>
                                                                    <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="footer_meta_title" id="footer_meta_title">{{ old('footer_meta_title', $footerData->footer_meta_title ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Footer Meta Keyword</label>
                                                                    <textarea name="footer_meta_keywords" id="footer_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('footer_meta_keywords', $footerData->footer_meta_keywords ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Footer Meta Description</label>
                                                                    <textarea name="footer_meta_description" id="footer_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('footer_meta_description', $footerData->footer_meta_description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </fieldset>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-6 mb-3">
                                                <div class="reset-button">
                                                    <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">{{ isset($footerData) ? 'Update' : 'Save' }}</button>
                                                    @if(!isset($footerData))
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
         $(document).ready(function () {
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
         document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('vch_Footer_Desc');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        @if(!isset($footerData->vch_Footer_URL))
            $(document.body).on('keyup change', '#vch_Footer_Name', function() {
                $("#vch_Footer_URL").val(name_to_url($(this).val()));
            });
        @endif
		function name_to_url(name) {
			name = name.toLowerCase(); // lowercase
			name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
			name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
			name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
			return name;
		}
        function validator() {
            if (!blankCheck('vch_Footer_Name', 'Footer name cannot be blank')) return false;
            if (!blankCheck('vch_Footer_URL', 'Footer URL cannot be blank')) return false;
            if (!selectDropdown('tourpackageid', 'Please select a package tour tag')) return false;
            if (!blankCheck('vch_Footer_Desc', 'Footer desc cannot be blank')) return false;
            return true;
        }
    </script>
</body>
</html>
