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
                                                                        <select class="form-select" name="package_id" id="package_id" onchange="getPackageDetails()">
                                                                            <option value="0">-- Select Package --</option>
                                                                            @foreach($packages as $pack)
                                                                                <option value="{{ $pack->tourpackageid }}" {{ old('package_id') == $pack->tourpackageid ? 'selected' : '' }}>
                                                                                    {{ $pack->tpackage_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>(Adults: 12+ Yrs)</label>
                                                                        <div class="d-flex align-items-center input-group" style="gap: 6px;">
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
                                                                        <div class="d-flex align-items-center input-group" style="gap: 6px;">
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
                                                                        <!-- <input type="text" data-date-format="dd-mm-yyyy" class="form-control datepicker" id="travel_date" name="travel_date" placeholder="dd-mm-yyyy" autocomplete="off" readonly> -->
                                                                        <input type="text" data-date-format="dd/mm/yyyy" class="form-control datepicker" id="travel_date" name="travel_date" placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="date">Accommodation Type</label>
                                                                        <select class="form-control" id="accommodation_type" name="accommodation_type" onchange="getAccommodation()">		
                                                                            <option value=""> - - Select Accommodation - - </option>
                                                                            
                                                                        </select>
                                                                        <span for="accomodation" class="chk-hotl" data-bs-toggle="modal" data-bs-target="#Hotel-check" style="float:right;cursor:pointer">Check Hotels</span>

                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
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
				<div id="result" style='display:none'></div>
				<div id="iternary" style='display:none'></div>
                <!-- Main Content End -->
                <!-- Hotel Modal -->
                            <div class="modal fade" id="Hotel-check">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hotels</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                        <input type="button" class="btn btn-primary" value="OK" data-bs-dismiss="modal">
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
        dateFormat: "dd/mm/yy", // Correct format for jQuery UI (yy = 4-digit year)
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

    function getPackageDetails(){
        let package_id = $('#package_id').val();
        $.ajax({
            url: '/getPackageMaxCapacity/' + package_id,
            type: 'GET',
            dataType: 'json',  // Ensure JSON response
            success: function (response) {                
                if (response.max_capacity) {
                    $("quantity_adult").attr("max",response.max_capacity);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error: Invalid response!',
                        confirmButtonColor: '#dd3333',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopps...',
                    text: 'Error loading view form.',
                    confirmButtonColor: '#dd3333',
                });
            }
        });
        $.ajax({
            url: '/getPackageItineraries/' + package_id,
            type: 'GET',
            dataType: 'json',  // Ensure JSON response
            success: function (response) {
                if (response.html) {
                    $("#iternary").html(response.html);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error: Invalid response!',
                        confirmButtonColor: '#dd3333',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopps...',
                    text: 'Error loading view form.',
                    confirmButtonColor: '#dd3333',
                });
            }
        });
        $.ajax({
            url: '/getPackageAccommodations/' + package_id,
            type: 'GET',
            dataType: 'json',  // Ensure JSON response
            success: function (response) {
                if (response.options) {
                    $("#accommodation_type").html(response.options);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error: Invalid response!!!!',
                        confirmButtonColor: '#dd3333',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopps...',
                    text: 'Error loading view form.',
                    confirmButtonColor: '#dd3333',
                });
            }
        });
        checkcapacity();
	}

    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
        var otherField = (fieldName === 'quantity_adult') ? 'quantity_child' : 'quantity_adult';
        var otherVal = parseInt($('#' + otherField).val(), 10);
        var total = currentVal + otherVal + 1; // +1 for the increment we're about to do

        var maxCapacity = 20;

        if (total > maxCapacity) {
            Swal.fire({
                icon: 'warning',
                title: 'Maximum Limit Reached',
                text: 'Maximum 20 travellers allowed. Please make an enquiry for more.',
                confirmButtonColor: '#dd3333',
            });
            $("#Enquiry-now").modal('show');
            return; // prevent increment
        }

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }

        checkcapacity();
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    $('.input-group').on('click', '.button-plus', function (e) {
        incrementValue(e);
        checkcapacity();
    });

    $('.input-group').on('click', '.button-minus', function (e) {
        decrementValue(e);
        checkcapacity();
    });
    function checkcapacity()
    {
        let package_id = $('#package_id').val();
        var maxcapacity = 20;
        var adultcount = $("#quantity_adult").val();
        var childcount = $("#quantity_child").val();
        var totalcount = parseInt(adultcount) + parseInt(childcount);
        if (totalcount > maxcapacity)
        {
            $("#calculate_price").prop("disabled", true);
            // alert("Maximum 20 no of travellers can be booked for this package. Please make a inquiry below for more traveller.");
            Swal.fire({
                icon: 'warning',
                title: 'Maximum Limit Reached',
                text: 'Maximum 20 travellers allowed. Please make an enquiry for more.',
                confirmButtonColor: '#dd3333',
            });
            $("#Enquiry-now").modal('show');
            $("#noof_adult").val(adultcount);
            $("#noof_child").val(childcount);
        } else
        {
            $("#calculate_price").prop("disabled", false);
            $("#noof_adult").val(adultcount);
            $("#noof_child").val(childcount);
        }

        $.ajax({
            url: '/getVehicles',
            type: 'GET',
            dataType: 'json',  // Ensure JSON response
            data: {
                totalcount: totalcount,
                package_id: package_id // or destination if no package_id
            },
            success: function (response) {                
                if (response.options) {
                    $('#vehicle').html(response.options);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error: Invalid response!',
                        confirmButtonColor: '#dd3333',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopps...',
                    text: 'Error loading view form.',
                    confirmButtonColor: '#dd3333',
                });
            }
        });
    }

    function getAccommodation(){
        let package_id = $('#package_id').val();
        var accommodation_type = $('#accommodation_type').val();
        if (accommodation_type !="")
        {
            $("#Hotel-check").modal('show');
            $.ajax({
                url: '/getAccommodation',
                type: 'GET',
                dataType: 'json',  // Ensure JSON response
                data: {
                    accommodation_type: accommodation_type,
                    packageid: package_id
                },
                success: function (response) {
                    if (response.html) {
                        $('#accomodation_result').html(response.html);
                        $('#accommodation').val(accommodation_type);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopps...',
                            text: 'Error: Invalid response!',
                            confirmButtonColor: '#dd3333',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error loading view form.',
                        confirmButtonColor: '#dd3333',
                    });
                }
            });
        } else
        {
            $("#accomodation_result").html('<h4 style="color:#6583bb; padding-bottom:20px;">Select rohan accommodation first to check hotels.</h4>');
        }
    }

    function generate() {
        let error = 0;

        // Validate fields
        if ($("#package_id").val() == "") {
            $("#package_id").addClass("errorfield");
            error += 1;
        } else {
            $("#package_id").removeClass("errorfield");
        }

        if (!$("#quantity_adult").val()) {
            $("#quantity_adult").addClass("errorfield");
            error += 1;
        } else {
            $("#quantity_adult").removeClass("errorfield");
        }

        if (!$("#vehicle").val()) {
            $("#vehicle").addClass("errorfield");
            error += 1;
        } else {
            $("#vehicle").removeClass("errorfield");
        }

        if (!$("#travel_date").val()) {
            $("#travel_date").addClass("errorfield");
            error += 1;
        } else {
            $("#travel_date").removeClass("errorfield");
        }

        if (!$("#accommodation_type").val()) {
            $("#accommodation_type").addClass("errorfield");
            error += 1;
        } else {
            $("#accommodation_type").removeClass("errorfield");
        }

        // If no errors, proceed with AJAX
        if (error == 0) {
            $("#error_message").html('');

            var formData = new FormData();

            // Append checked checkboxes
            for (let i = 0; i < document.querySelectorAll('.form-check-input').length; i++) {
                if (document.querySelectorAll('.form-check-input')[i].checked) {
                    formData.append(document.querySelectorAll('.form-check-input')[i].name, document.querySelectorAll('.form-check-input')[i].value);
                }
            }

            // Append form fields
            formData.append('accommodation_type', $("#accommodation_type").val());
            formData.append('travel_date', $("#travel_date").val());
            formData.append('vehicle', $("#vehicle").val());
            formData.append('quantity_adult', $("#quantity_adult").val());
            formData.append('hid_packageid', $("#package_id").val());
            formData.append('quantity_child', $("#quantity_child").val());

            // CSRF token (Laravel Blade)
            formData.append('_token', '{{ csrf_token() }}');

            // Send AJAX request
            $.ajax({
                url: "{{ route('admin.generatePackageDoc.generatePDF') }}",  // Replace with Laravel route
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    // Show loading spinner or something before sending
                },
                success: function (result) {
                        // Check if download URL is provided
                    if (result.status === 'success' && result.download_url) {
                        // Redirect to the download URL to start the download
                        window.location.href = result.download_url;
                    } else {
                        alert('Failed to generate PDF.');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                }
            });
        } else {
            // Show error message if validation fails
            $("#error_message").html('<div class="errormsg" style="font-size:15px;">Please fill up all above mandatory fields.</div>');
            return false;
        }
    }
    function generateDoc() {
        let error = 0;

        // Validate fields
        if ($("#package_id").val() == "") {
            $("#package_id").addClass("errorfield");
            error += 1;
        } else {
            $("#package_id").removeClass("errorfield");
        }

        if (!$("#quantity_adult").val()) {
            $("#quantity_adult").addClass("errorfield");
            error += 1;
        } else {
            $("#quantity_adult").removeClass("errorfield");
        }

        if (!$("#vehicle").val()) {
            $("#vehicle").addClass("errorfield");
            error += 1;
        } else {
            $("#vehicle").removeClass("errorfield");
        }

        if (!$("#travel_date").val()) {
            $("#travel_date").addClass("errorfield");
            error += 1;
        } else {
            $("#travel_date").removeClass("errorfield");
        }

        if (!$("#accommodation_type").val()) {
            $("#accommodation_type").addClass("errorfield");
            error += 1;
        } else {
            $("#accommodation_type").removeClass("errorfield");
        }

        // If no errors, proceed with AJAX
        if (error == 0) {
            $("#error_message").html('');

            var formData = new FormData();

            // Append checked checkboxes
            for (let i = 0; i < document.querySelectorAll('.form-check-input').length; i++) {
                if (document.querySelectorAll('.form-check-input')[i].checked) {
                    formData.append(document.querySelectorAll('.form-check-input')[i].name, document.querySelectorAll('.form-check-input')[i].value);
                }
            }

            // Append form fields
            formData.append('accommodation_type', $("#accommodation_type").val());
            formData.append('travel_date', $("#travel_date").val());
            formData.append('vehicle', $("#vehicle").val());
            formData.append('quantity_adult', $("#quantity_adult").val());
            formData.append('hid_packageid', $("#package_id").val());
            formData.append('quantity_child', $("#quantity_child").val());

            // CSRF token (Laravel Blade)
            formData.append('_token', '{{ csrf_token() }}');

            // Send AJAX request
            $.ajax({
                url: "{{ route('admin.generatePackageDoc.generateDoc') }}",  // Replace with Laravel route
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    // Show loading spinner or something before sending
                },
                success: function (result) {
                     if(result.download_url) {
            window.location.href = result.download_url;  // Redirect to the generated DOCX file URL
        } else {
            alert("Error: Download URL not received.");
        }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                }
            });
        } else {
            // Show error message if validation fails
            $("#error_message").html('<div class="errormsg" style="font-size:15px;">Please fill up all above mandatory fields.</div>');
            return false;
        }
    }
    </script>

</body>

</html>