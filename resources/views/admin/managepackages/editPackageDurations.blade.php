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
                                <a href="{{ route('admin.managepackagedurations.editPackageDurations', ['id' => $package->durationid]) }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l2.0 2.0a.5.5 0 0 1 0 .708L5.207 13.5H3v-2.207L12.146.146zM11.207 2L4 9.207V10h.793L13 3.793 11.207 2z"/>
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('admin.managepackagedurations') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <form action="{{ route('admin.managepackagedurations.editPackageDurations', ['id' => $package->durationid]) }}" method="POST" id="userform" name="userform" class="add-user" onsubmit="return validator()">
                                                    @csrf
                                                    <!-- If you prefer using POST for update, no need for @method('PUT'). Otherwise, add @method('PUT') -->
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Duration Name <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter Duration Name" name="duration_name" id="duration_name" value="{{ old('duration_name', $package->duration_name) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">No. of Days <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter No. of Days" name="no_ofdays" id="no_ofdays" value="{{ old('no_ofdays', $package->no_ofdays) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">No. of Nights <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter No. of Nights" name="no_ofnights" id="no_ofnights" value="{{ old('no_ofnights', $package->no_ofnights) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="reset-button">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Delete Form -->
                                                <!--  -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
                <!-- Main Content End -->

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
        function validator(){
            if(!blankCheck('duration_name','Please Enter Duration Name'))
                return false;
            if(!blankCheck('no_ofdays','Please Enter No. of Days'))
                return false;
            if(!onlyNumeric('no_ofdays','Please Enter only numbers for No. of Days'))
                return false;
            if(!blankCheck('no_ofnights','Please Enter No. of Nights'))
                return false;
            if(!onlyNumeric('no_ofnights','Please Enter only numbers for No. of Nights'))
                return false;
        }
    </script>
    <script src="{{ asset('assets/js/validation.js') }}"></script>
</body>
</html>