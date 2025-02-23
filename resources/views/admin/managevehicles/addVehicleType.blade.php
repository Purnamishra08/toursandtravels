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
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Add Vehicle Type</li>
                            </ol>
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-heading">
                                                <div class="btn-group" id="buttonexport">
                                                    <a href="{{ route('admin.manageVehicletype') }}">
                                                        <h4><i class="fa fa-plus-circle"></i> Manage Vehicle Type</h4>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <form action="{{ route('admin.managevehicles.addVehicleType') }}"
                                                    method="POST" id="userform" name="userform" class="add-user"
                                                    onsubmit="return validator()">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Vehicle Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Vehicle Name" name="vehiclename"
                                                                    id="vehiclename">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Vehicle Capacity</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Vehicle Capacity"
                                                                    name="vehiclecapacity" id="vehiclecapacity">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="reset-button">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="reset" class="btn blackbtn">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
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

    <<script>
        function validator(){
        if(!blankCheck('vehiclename','Vehicle Name cannot be Blank'))
        return false;
        if(!blankCheck('vehiclecapacity','Vehicle Capacity cannot be Blank'))
        return false;
        if(!onlyNumeric('vehiclecapacity'))
        return false;
        }
        </script>

        <script src="{{ asset('assets/js/validation.js') }}"></script>

</body>

</html>