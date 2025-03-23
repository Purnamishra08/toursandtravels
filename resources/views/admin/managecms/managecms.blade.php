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
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <div class="form-container">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.managecms', ['id' => $contentDataById->content_id]) }}" method="POST" id="form_destination" name="form_destination" class="add-user" enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend> Place Details</legend>
                                                    <div class="row">
                                                        <!-- Destination -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination <span class="manadatory">*</span></label>
                                                                <select data-placeholder="Choose cms type" tabindex="4" id="content_id" name="content_id" style="width: 100%;" class="form-control" onchange="redirectToCMS(this.value)">
                                                                    <option value="">--Select cms type--</option>
                                                                    @foreach($contentData as $type)
                                                                        <option value="{{ $type->content_id }}"  {{ (isset($contentDataById) && $contentDataById->content_id == $type->content_id) ? 'selected' : '' }}>
                                                                            {{ $type->page_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend> Description </legend>
                                                    <div class="row">
                                                         <!-- About page_content -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Place <span class="manadatory">*</span></label>
                                                                <textarea name="page_content" id="page_content" class="form-control">{{ old('page_content', $contentDataById->page_content ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend> Seo Title </legend>
                                                    <div class="row">
                                                        <!-- About seo_title -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Place <span class="manadatory">*</span></label>
                                                                <textarea name="seo_title" id="seo_title" class="form-control">{{ old('seo_title', $contentDataById->seo_title ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend> Seo Description </legend>
                                                    <div class="row">
                                                        <!-- About seo_description -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Place <span class="manadatory">*</span></label>
                                                                <textarea name="seo_description" id="seo_description" class="form-control">{{ old('seo_description', $contentDataById->seo_description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend> Seo Keywords </legend>
                                                    <div class="row">
                                                        <!-- About seo_keywords -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Place <span class="manadatory">*</span></label>
                                                                <textarea name="seo_keywords" id="seo_keywords" class="form-control">{{ old('seo_keywords', $contentDataById->seo_keywords ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-md-6 mb-3">
                                                <div class="reset-button">
                                                    <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">Update</button>
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
            CKEDITOR.replace('page_content');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        function redirectToCMS(contentId) {
            if (contentId === "") {
                Swal.fire({
                    icon: "error",
                    text: "Please select a CMS type.",
                    confirmButtonColor: "#d33",
                });
                return;
            }else{
                if (contentId) {
                    window.location.href = "/managecms/" + contentId;
                } else {
                    window.location.href = "/managecms/1";
                }
            }
        }
    </script>
</body>
</html>
