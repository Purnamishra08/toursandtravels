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
                <!--TopBar header end -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <a href="{{ route('admin.generalsettings') }}" class="tab-menu__item active ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View
                                </a>
                            </nav>
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="panel">
                                    <div class="panel-body">
                                        <form action="{{route('admin.managetourpackages.editgeneralsettings', ['id' => $parameters->parid])}}" id="form_cmnstng" name="form_cmnstng" class="add-user" enctype="multipart/form-data" method="POST" >
                                            @csrf
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12">
                                                    <label>{{ $parameters->parameter }}</label>
                                                </div>
                                                <div class="clearfix"></div><br>

                                                @if($parameters->input_type == 1)
                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Enter {{ $parameters->parameter }}" name="par_value" id="par_value" value="{{ old('par_value', $parameters->par_value) }}" />
                                                    </div> 
                                                </div>  

                                                @elseif($parameters->input_type == 2)
                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="5" name="text_area" id="text_area">{{ old('text_area', $parameters->par_value) }}</textarea>
                                                    </div> 
                                                </div>
                                                
                                                @elseif($parameters->input_type == 3)
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <input name="bnrimg" id="bnrimg" type="file" class="form-control" onchange="previewImage(event, 'banner_preview')"> 
                                                        </div>
                                                        <div id="banner_preview" style="margin-top: 10px;">
                                                            <img id="bannerPreview"
                                                                src="{{ isset($parameters->par_value) ? asset('storage/parameters/'.$parameters->par_value) : '' }}"
                                                                alt="Banner Preview"
                                                                class="img-fluid rounded border"
                                                                style="max-width: 300px; display: {{ isset($parameters->par_value) ? 'block' : 'none' }};">
                                                        </div>
                                                        <span>Note: Image size should be 1920px X 400px</span>
                                                        <div class="clearfix"></div>
                                                    </div> 
                                                </div>

                                                @else
                                                <div class="col-md-12"> 
                                                    <div class="form-group">
                                                        <textarea name="short_desc" id="short_desc" class="form-control">{{ old('short_desc', $parameters->par_value) }}</textarea>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="clearfix"></div> 

                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="reset-button"> 
                                                        <input type="hidden" name="input_type" id="input_type" value="{{ $parameters->input_type }}" />
                                                        <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">Update</button>
                                                        <button type="button" class="btn btn-danger" onClick="window.location='{{ route('admin.generalsettings') }}'">Back</button> 
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('short_desc');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        function previewImage(event, previewId) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById(previewId);
                output.innerHTML = '<img src="' + reader.result + '" alt="Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px; margin-top: 10px;">';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>