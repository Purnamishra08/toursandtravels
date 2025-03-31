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
                                <!-- <a href="{{ route('admin.manageenquiriesreport.addEnquiriesReport') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                        </path>
                                    </svg>
                                    Add
                                </a> -->
                                <a href="{{ route('admin.manageenquiriesreport') }}" class="tab-menu__item active">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
                                    </svg> -->
                                    Manage Enquiry Report
                                </a>
                                <!-- table-utilities -->
                                    <div class="table-utilities">
                                        <a href="#" id="exportExcelBtn" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Export Excel"><i class="fa-solid fa-file-excel"></i></a>
                                        <a href="#" id="exportCsvBtn" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Export CSV"><i class="fa-solid fa-file-csv"></i></a>
                                    </div>
                                    <!-- table-utilities end-->
                            </nav>
                            <!--Filter Box Start-->
                            <div class="filterBox collapse bg-light p-3" id="filterBox">
                                <form id="filterForm" method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label"> Follow up From Date</label>
                                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker-no-validation" id="from_date" name="from_date" 
                                                value="{{ request('from_date') }}" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label"> Follow up To Date</label>
                                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker-no-validation" id="to_date" name="to_date" 
                                                value="{{ request('to_date') }}" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Customer Name</label>
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                                value="{{ request('customer_name') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Enquiry Number</label>
                                            <input type="text" class="form-control" id="enquiry_number" name="enquiry_number" 
                                                value="{{ request('enquiry_number') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Email Address</label>
                                            <input type="text" class="form-control" id="email_address" name="email_address" 
                                                value="{{ request('email_address') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" 
                                                value="{{ request('phone_number') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">-- Select Status --</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Assign To</label>
                                            <select class="form-select" id="assign_to" name="assign_to">
                                                <option value="">-- Select Assign To --</option>
                                                @foreach($assignData as $data)
                                                    <option value="{{ $data->adminid }}" {{ request('assign_to') == $data->adminid ? 'selected' : '' }}>
                                                        {{ $data->admin_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Submit and Reset Buttons -->
                                        <div class="col-sm-3 form-group mb-sm-0 align-self-end">
                                            <button class="btn btn-success mr-2" type="submit" id="filterBoxBtn">Submit</button>
                                            <button class="btn btn-warning" type="reset" id="resetFilterBtn">Reset</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="text-center filterBtn">
                                <button type="button" class="showListBtn" data-bs-toggle="collapse"
                                    data-bs-target="#filterBox"><i class="fa fa-search"></i> Search</button>
                            </div>
                            <!--Filter Box End-->
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="enquiryEntryTable" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="info">
                                                                <th width="5%">Sl #</th>
                                                                <th width="10%">Enquiry Number</th>
                                                                <th width="15%">Customer Name</th>
                                                                <th width="15%">Email Address</th>
                                                                <th width="15%">Phone Number</th>
                                                                <th width="15%">Follow Up Date</th>
                                                                <th width="15%">Follow Up By</th>
                                                                <th width="10%">Status</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
                <!-- Modal Structure -->
                <div id="modalContainer" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        </div>
                    </div>
                </div>

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
$(document).ready(function () {
    if ($('#enquiryEntryTable').length) {
        loadTable();
    }

    function loadTable() {
        $('#enquiryEntryTable').DataTable().destroy(); // Destroy existing instance if any
        $('#enquiryEntryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.manageenquiriesreport') }}",
                type: 'GET',
                data: function (d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                    d.customer_name = $('#customer_name').val();
                    d.enquiry_number = $('#enquiry_number').val();
                    d.email_address = $('#email_address').val();
                    d.phone_number = $('#phone_number').val();
                    d.status = $('#status').val();
                    d.assign_to = $('#assign_to').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'inquiry_number', name: 'a.inquiry_number' },
                { data: 'customer_name', name: 'a.customer_name' },
                { data: 'email_address', name: 'a.email_address' },
                { data: 'phone_number', name: 'a.phone_number' },
                { data: 'followup_date', name: 'a.followup_date' },
                { data: 'admin_name', name: 'd.admin_name' },
                { data: 'name', name: 'c.name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    }

    // Handle filter submission
    $('#filterBoxBtn').on('click', function (e) {
        e.preventDefault();
        loadTable();
    });

    // Reset filter
    $('#resetFilterBtn').on('click', function () {
        $('form')[0].reset();
        loadTable();
    });

        $('#exportCsvBtn').on('click', function (e) {
        e.preventDefault(); // Prevent default click behavior

        let baseUrl = "{{ route('admin.exportEnquiriesCsv') }}";
        let params = new URLSearchParams();

        // Get form values and append to URL params
        params.append('from_date', $('#from_date').val());
        params.append('to_date', $('#to_date').val());
        params.append('customer_name', $('#customer_name').val());
        params.append('enquiry_number', $('#enquiry_number').val());
        params.append('email_address', $('#email_address').val());
        params.append('phone_number', $('#phone_number').val());
        params.append('status', $('#status').val());
        params.append('assign_to', $('#assign_to').val());

        // Construct final URL with filters
        let finalUrl = baseUrl + '?' + params.toString();

        // Redirect to the new URL (downloads CSV)
        window.location.href = finalUrl;
    });

        $('#exportExcelBtn').on('click', function (e) {
        e.preventDefault(); // Prevent default click behavior

        let baseUrl = "{{ route('admin.exportEnquiriesExcel') }}";
        let params = new URLSearchParams();

        // Get form values and append to URL params
        params.append('from_date', $('#from_date').val());
        params.append('to_date', $('#to_date').val());
        params.append('customer_name', $('#customer_name').val());
        params.append('enquiry_number', $('#enquiry_number').val());
        params.append('email_address', $('#email_address').val());
        params.append('phone_number', $('#phone_number').val());
        params.append('status', $('#status').val());
        params.append('assign_to', $('#assign_to').val());

        // Construct final URL with filters
        let finalUrl = baseUrl + '?' + params.toString();

        // Redirect to the new URL (downloads CSV)
        window.location.href = finalUrl;
    });
});

        // Open View Modal
        $(document).on('click', '.view-btn', function () {
            var sourceId = $(this).data('id'); // Get source ID

            $.ajax({
                url: '/viewEnquiriesReport/' + sourceId,  // Fetch modal HTML via AJAX
                type: 'GET',
                dataType: 'json',  // Ensure JSON response
                success: function (response) {
                    if (response.html) {
                        $('#modalContainer .modal-content').html(response.html); // Inject modal content
                        $('#modalContainer').modal('show'); // Open modal
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss..',
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
        });

        $(document).on('click', '.assign-btn', function () {
            var sourceId = $(this).data('id'); // Get source ID

            $.ajax({
                url: '/assignEnquiriesReport/' + sourceId,  // Fetch modal HTML via AJAX
                type: 'GET',
                dataType: 'json',  // Ensure JSON response
                success: function (response) {
                    if (response.html) {
                        $('#modalContainer .modal-content').html(response.html); // Inject modal content
                        $('#modalContainer').modal('show'); // Open modal
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopps..',
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
        });

        $(document).on('click', '.btnSubmitAssignTo', function () {
        var inquiryId = $(this).data('id');
        var assignTo = $('#assign_to_edit').val();

        $.ajax({
            url: '/update-assign-to',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                inquiry_id: inquiryId,
                assign_to: assignTo
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'success',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                });
                location.reload();
            }
        });
    });



</script>
</body>

</html>