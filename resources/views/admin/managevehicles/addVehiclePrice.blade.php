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
                                <li class="breadcrumb-item active">Add Vehicle Price</li>
                            </ol>
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-heading">
                                                <div class="btn-group" id="buttonexport">
                                                    <a href="{{ route('admin.manageVehicleprice') }}">
                                                        <h4><i class="fa fa-plus-circle"></i> Manage Vehicle Price</h4>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <form action="{{ route('admin.manageVehicleprice.addVehiclePrice') }}"
                                                    method="POST" id="userform" name="userform" class="add-user"
                                                    onsubmit="return validator()">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Vehicle <span
                                                                        class="manadatory">*</span></label>
                                                                <select class="form-select" id="vehicleid" name="vehicleid">
                                                                    <option value="">--Select Vehicle--</option>
                                                                    @forelse($vehicleTypes as $vehicleType)
                                                                    <option value="{{ $vehicleType->vehicleid }}" 
                                                                    {{ old('vehicleid')==$vehicleType->vehicleid ? 'selected' : '' }}>
                                                                        {{ $vehicleType->vehicle_name }}
                                                                    </option>
                                                                    @empty
                                                                    <option value="" disabled>No vehicles available
                                                                    </option>
                                                                    @endforelse
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Destination <span
                                                                        class="manadatory">*</span></label>
                                                                <select class="form-select" id="destinationid" name="destinationid" >
                                                                    <option value="">--Select Destination--</option>
                                                                    <option value="1">Delhi </option>
                                                                    <option value="2">Jaipur</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Price / Day (₹) <span
                                                                        class="manadatory">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Price / Day (₹)"
                                                                    name="priceperday" id="priceperday">
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
        if(!selectDropdown('vehicleid','Please Select Vehicle'))
        return false;
        if(!selectDropdown('destinationid','Please Select Destination'))
        return false;
        if(!blankCheck('priceperday','Please Enter Price / Day (₹)'))
        return false;
        if(!checkDecimal('priceperday'))
        return false;
        }
        </script>

        <script src="{{ asset('assets/js/validation.js') }}"></script>

</body>

</html>