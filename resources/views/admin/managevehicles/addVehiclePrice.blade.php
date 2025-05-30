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
                                <a href="{{ route('admin.manageVehicleprice.addVehiclePrice') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a>
                                <a href="{{ route('admin.manageVehicleprice') }}" class="tab-menu__item ">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <form action="{{ route('admin.manageVehicleprice.addVehiclePrice') }}"
                                                    method="POST" id="userform" name="userform" class="add-user"
                                                    onsubmit="return validator()">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Vehicle <span class="manadatory">*</span></label>
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
                                                                <label class="control-label">Destination <span class="manadatory">*</span></label>
                                                                <select class="form-select" id="destinationid" name="destinationid" >
                                                                    <option value="">--Select Destination--</option>
                                                                    @forelse($destinations as $destination)
                                                                    <option value="{{ $destination->destination_id }}" 
                                                                    {{ old('destinationid')==$destination->destination_id ? 'selected' : '' }}>
                                                                        {{ $destination->destination_name }}
                                                                    </option>
                                                                    @empty
                                                                    <option value="" disabled>No destination available
                                                                    </option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Price / Day (₹) <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Price / Day (₹)"
                                                                    name="priceperday" id="priceperday">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="reset-button">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="reset" class="btn btn-danger">Reset</button>
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
                @include('admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('admin.include.footerJs')
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

        

</body>

</html>