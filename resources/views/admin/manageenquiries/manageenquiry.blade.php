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
                                <!-- <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                        </path>
                                    </svg>
                                    Add
                                </a> -->
                                <a href="{{ route('admin.manageenquiry') }}" class="tab-menu__item active">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
                                    </svg> -->
                                    Manage Enquiry
                                </a>
                            </nav>
                            <!--Filter Box Start-->
                            <div class="filterBox collapse bg-light p-3" id="filterBox">
                                <form id="filterForm" method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" id="cont_name" name="cont_name" 
                                                value="{{ request('cont_name') }}">
                                        </div>
                                       <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" id="cont_email" name="cont_email" 
                                                value="{{ request('cont_email') }}">
                                        </div><div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Contact No</label>
                                            <input type="text" class="form-control" id="cont_phone" name="cont_phone" 
                                                value="{{ request('cont_phone') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">From Date</label>
                                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker" id="from_date" name="from_date" 
                                                value="{{ request('from_date') }}" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">To Date</label>
                                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker" id="to_date" name="to_date" 
                                                value="{{ request('to_date') }}" autocomplete="off" readonly>
                                        </div>
                                        <!-- Submit and Reset Buttons -->
                                        <div class="col-sm-4 form-group mb-sm-0 align-self-end">
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
                                                    <table id="enquiryTable" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="info">
                                                                <th>Sl #</th>
                                                                <th>Name</th>
                                                                <th>Email Id</th>
                                                                <th>Contact No</th>
                                                                <th>Page Name</th>
                                                                <th>Enquiry Details</th>
                                                                <th>Enquiry Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
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
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content"> </div>
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
        // Initialize Datepicker
        // $('.datepicker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true
        // });

        let table = $('#enquiryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.manageenquiry') }}",
                data: function (d) {
                    d.cont_name = $('#cont_name').val();
                    d.cont_email = $('#cont_email').val();
                    d.cont_phone = $('#cont_phone').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'cont_name', name: 'cont_name' },
                { data: 'cont_email', name: 'cont_email' },
                { data: 'cont_phone', name: 'cont_phone' },
                { data: 'page_name', name: 'page_name' },
                { data: 'cont_enquiry_details', name: 'cont_enquiry_details' },
                { data: 'cont_date', name: 'cont_date' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[6, 'desc']],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

        // Filter Button
        $('#filterBoxBtn').on('click', function (e) {
            e.preventDefault(); // Prevent form submission
            table.ajax.reload();
        });

        // Reset Button
        $('#resetFilterBtn').on('click', function () {
            $('#filterForm')[0].reset();
            table.ajax.reload();
        });
    });
</script>

</body>

</html>