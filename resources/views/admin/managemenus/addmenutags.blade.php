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
                <!--TopBar header end -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                        <nav class="tab-menu">
                                    <a href="{{ isset($menutags) ? route('admin.category.editmenutag', ['id' => $menutags->menuid]) : route('admin.category.addmenutag') }}" class="tab-menu__item active">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
                                          {{ isset($destinationtype) ? 'Edit' : 'Add' }}
                                    </a>
        							<a href="{{ route('admin.menutag') }}" class="tab-menu__item  ">
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
                            <!-- <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Manage State</li>
                            </ol> -->
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <form action="{{ isset($menutags) ? route('admin.category.editmenutag', $menutags->menuid) : route('admin.category.addmenutag') }}" method="POST" id="menutagform"  name="menutagform" class="add-menutag" onsubmit="return validator()"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Menu Tag  <span class="manadatory">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter menu tag" name="menu_name" id="menu_name" 
                                                value="{{ old('menu_name', $menutags->menu_name ?? '') }}">
                                        </div>
                                        <!-- Meta Tags Section -->
                                        <div class="box-main">
                                            <fieldset>
                                                <legend>Menu Meta Tags</legend>
                                                    <div class="row">
                                                        <!-- Menu Meta Tags -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Menu Meta Title</label>
                                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="menu_meta_title" id="menu_meta_title">{{ old('menu_meta_title', $menutags->menu_meta_title ?? '') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Menu Meta Keyword</label>
                                                                <textarea name="menu_meta_keywords" id="menu_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('menu_meta_keywords', $menutags->menu_meta_keywords ?? '') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Menu Meta Description</label>
                                                                <textarea name="menu_meta_description" id="menu_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('menu_meta_description', $menutags->menu_meta_description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">{{ isset($menutags) ? 'Update' : 'Save' }}</button>
                                            @if(!isset($menutags))
                                                <button type="reset" class="btn btn-secondary">Reset</button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
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
    
    <script>
        function validator(){
            if(!blankCheck('menu_name','Menu tag cannot be blank'))
                return false;
        }
    </script>
</body>

</html>