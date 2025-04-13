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
                                
                                <a href="{{ route('admin.generatePackageDoc') }}" class="tab-menu__item active">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg> -->
                                    Generate Package
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
                                                <form action="{{ route('admin.managetourpackages.addTourPackages') }}" method="POST" id="form_tpackages" name="form_tpackages" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                                    @csrf
                                                    <div class="box-main">
                                                        <fieldset>
                                                            <legend>Generate Package Details PDF/DOC</legend>
                                                            <div class="row">
                                                                <!-- Package Name -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Package</label>
                                                                        <select class="form-select" name="packtype" id="packtype">
                                                                            <option value="">-- Select Package --</option>
                                                                            @foreach($packages as $pack)
                                                                                <option value="{{ $pack->tourpackageid }}" {{ old('packtype') == $pack->tourpackageid ? 'selected' : '' }}>
                                                                                    {{ $pack->tpackage_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>(Adults: 12+ Yrs)</label>
                                                                        <div class="d-flex align-items-center" style="gap: 6px;">
                                                                            <button type="button" class="btn btn-danger btn-sm button-minus" data-field="quantity_adult">−</button>
                                                                            <input type="text" name="quantity_adult" id="quantity_adult" value="0"
                                                                                class="form-control text-center quantity-field"
                                                                                readonly style="width: 35px; height: 30px; padding: 0; font-size: 14px;">
                                                                            <button type="button" class="btn btn-success btn-sm button-plus" data-field="quantity_adult">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>(Children: 6-12 Yrs)</label>
                                                                        <div class="d-flex align-items-center" style="gap: 6px;">
                                                                            <button type="button" class="btn btn-danger btn-sm button-minus" data-field="quantity_child">−</button>
                                                                            <input type="text" name="quantity_child" id="quantity_child" value="0"
                                                                                class="form-control text-center quantity-field"
                                                                                readonly style="width: 35px; height: 30px; padding: 0; font-size: 14px;">
                                                                            <button type="button" class="btn btn-success btn-sm button-plus" data-field="quantity_child">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="vehicle">Vehicle</label>
                                                                        <select class="form-select" id="vehicle" name="vehicle">
                                                                            <option value="">---Select Vehicle---</option>
                                                                        
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Date of travel <span class="manadatory">*</span></label>
                                                                        <input type="text" data-date-format="dd-mm-yyyy" class="form-control datepicker" id="travel_date" name="travel_date" placeholder="mm-dd-yyyy" autocomplete="off" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="date">Accommodation Type</label>
                                                                        <select class="form-control" id="accommodation_type" name="accommodation_type">		
                                                                            <option value=""> - - Select Accommodation - - </option>
                                                                            
                                                                        </select>
                                                                        <span for="accomodation" class="chk-hotl" data-toggle="modal" data-target="#Hotel-check" style="float:right;cursor:pointer">Check Hotels</span>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <!-- <div class="col-md-6">
                                                                    <div class="reset-button align-items-center">
                                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                                        <button type="reset" class="btn btn-danger">Reset</button>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-md-6">
                                                                    <div class="reset-button"> 
                                                                        <button type="button" class="btn btn-primary" name="btnSubmit" id="btnSubmit" onclick="generate()">Generate PDF</button>
                                                                    </div>
                                                                </div>   
                                                                <div class="col-md-6">
                                                                    <div class="reset-button"> 
                                                                        <button type="button" class="btn btn-primary" name="btnSubmit" id="btnSubmit2" onclick="generateDoc()">Generate DOC</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
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
                <!-- Hotel Modal -->
                            <div class="modal fade" id="Hotel-check">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hotels</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="hotel-chk-sec">
                                                <div class="row" id="accomodation_result">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <h4 style="color:#6583bb; padding-bottom:20px;">Select accommodation first to check hotels.</h4>
                                                    </div>
                                                </div>
												<div class="row">
													<div class="col-xl-12 col-lg-12 text-center">
                                                        <input type="button" class="btn btn-primary" value="OK" data-dismiss="modal">
                                                    </div>
												</div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->

                                    </div>
                                </div>
                            </div>
                <!-- Hotel Modal -->

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
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
        changeYear: true, // Allow year selection
        minDate: +2, //
        showButtonPanel: true, // Show footer buttons
        closeText: "Close", // Customize close button text
        currentText: "Today", // Customize today button text
        clearText: "Clear", // Customize clear button text
        beforeShow: function (input, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find(".ui-datepicker-close").hide(); // Hide default close button
                if (!$(inst.dpDiv).find(".ui-datepicker-clear").length) {
                    $(inst.dpDiv)
                        .find(".ui-datepicker-buttonpane")
                        .append(
                            '<button type="button" class="ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all">Clear</button>'
                        ); // Add Clear button
                }
            }, 1);
        },
    });
     </script>

</body>

</html>