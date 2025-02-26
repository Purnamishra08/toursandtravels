<!-- Metaheader Section-->
@include('Admin.include.metaheader')
<!-- Metaheader Section End -->
<style>
    .form-container, .table-container {
    margin-bottom: 25px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
    background-color: #fff;
    padding: 25px;
    border-radius: 4px;
    }
    .table thead {
        background-color: #17a2b8;
        color: white;
    }
    .btn-sm i {
        margin-right: 5px;
    }
    thead th {
        background: linear-gradient(to right, #222, #444); /* Dark Gradient */
        color: black;
        text-align: center;
        padding: 10px;
        border-bottom: 2px solid #666;
    }
</style>
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
                                    <a href="{{ isset($state) ? route('admin.state.editState', ['id' => $state->state_id]) : route('admin.state.addState') }}" class="tab-menu__item active">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
                                          {{ isset($state) ? 'Edit' : 'Add' }}
                                    </a>
        							<a href="{{ route('admin.state') }}" class="tab-menu__item  ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
        									<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
        									<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
        								</svg>
        								View
        							</a>
        							<!-- table-utilities -->
        							<div class="table-utilities">
        								<!-- <strong class="manadatory me-1">*</strong>Indicates Mandatory -->
        							</div>
        							<!-- table-utilities end-->
        						</nav>
                            <!-- <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Manage State</li>
                            </ol> -->
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <form action="{{ isset($state) ? route('admin.state.editState', $state->state_id) : route('admin.state.addState') }}" method="POST" id="stateform"  name="stateform" class="add-state" onsubmit="return validator()"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>State Name</label>
                                            <input type="text" class="form-control" placeholder="Enter state name" name="state_name" id="state_name" 
                                                value="{{ old('state_name', $state->state_name ?? '') }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>State URL</label>
                                            <input type="text" class="form-control" placeholder="Enter state URL" name="state_url" id="state_url" 
                                                value="{{ old('state_url', $state->state_url ?? '') }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Banner Image</label>
                                            <input type="file" name="bannerimg" id="bannerimg" class="form-control-file" onchange="previewImage(event)">
                                            <small class="text-muted">Image size should be 1920px X 488px</small>
                                            
                                            <!-- Image Preview -->
                                            <div class="mt-2">
                                                <img id="bannerPreview" 
                                                    src="{{ isset($state->bannerimg) ? asset('storage/banner_images/'.$state->bannerimg) : '' }}" 
                                                    alt="Banner Preview" 
                                                    class="img-fluid rounded border" 
                                                    style="max-width: 300px; display: {{ isset($state->bannerimg) ? 'block' : 'none' }};">
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Alt Tag for Banner Image</label>
                                            <input type="text" class="form-control" placeholder="Enter Alt tag" name="alttag_banner" maxlength="60" id="alttag_banner"
                                                value="{{ old('alttag_banner', $state->alttag_banner ?? '') }}">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Meta Title</label>
                                            <textarea class="form-control" placeholder="Meta Title..." name="state_meta_title" id="state_meta_title">{{ old('state_meta_title', $state->state_meta_title ?? '') }}</textarea>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Meta Keywords</label>
                                            <textarea class="form-control" placeholder="Meta Keywords..." name="state_meta_keywords" id="state_meta_keywords">{{ old('state_meta_keywords', $state->state_meta_keywords ?? '') }}</textarea>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" placeholder="Meta Description..." name="state_meta_description" id="state_meta_description">{{ old('state_meta_description', $state->state_meta_description ?? '') }}</textarea>
                                        </div>

                                        <div class="col-md-6 form-group form-check" style="margin-left: 10px;">
                                            <input type="checkbox" class="form-check-input" name="showmenu" id="showmenu" value="1"
                                                {{ old('showmenu', $state->showmenu ?? '') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="showmenu"><strong>Show this state on menu</strong></label>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">{{ isset($state) ? 'Update' : 'Save' }}</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </div>
                                </form>
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
     
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('bannerPreview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        function validator(){
            if(!blankCheck('state_name','State name cannot be blank'))
                return false;
            if(!blankCheck('state_url','State URL cannot be blank'))
                return false;
            if(!blankCheck('alttag_banner','Alt Tag for Banner Image cannot be blank'))
                return false;
            if(!blankCheck('state_meta_title','State meta title cannot be blank'))
                return false;
            if(!blankCheck('state_meta_keywords','State meta keywords cannot be blank'))
                return false;
            if(!blankCheck('state_meta_description','State meta description cannot be blank'))
                return false;
        }
    </script>

    <script src="{{ asset('assets/js/validation.js') }}"></script>
</body>

</html>