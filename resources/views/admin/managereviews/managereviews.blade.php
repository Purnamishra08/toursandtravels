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
        							<a href="{{ route('admin.managereviews.addreviews') }}"class="tab-menu__item  ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
        								Add
        							</a>
        							<a href="#" class="tab-menu__item active ">
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
                                <!--Filter Box Start-->
                                <div class="filterBox collapse bg-light p-3" id="filterBox">
                                    <form id="filterForm">
                                        @csrf
                                        <div class="row">
                                            <!-- Hotel Name -->
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" id="reviewer_name" name="reviewer_name"
                                                    value="{{ request('reviewer_name') }}">
                                            </div>
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Location</label>
                                                <input type="text" class="form-control" id="reviewer_loc" name="reviewer_loc"
                                                    value="{{ request('reviewer_loc') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ratings</label>
                                                    <select class="form-control" name="no_of_star" id="no_of_star">
                                                        <option value="0">Select Rating</option>
                                                        <option value="1" {{ request('no_of_star') == '1' ? 'selected' : '' }}>1</option>
                                                        <option value="1.5" {{ request('no_of_star') == '1.5' ? 'selected' : '' }}>1.5</option>
                                                        <option value="2" {{ request('no_of_star') == '2' ? 'selected' : '' }}>2</option>
                                                        <option value="2.5" {{ request('no_of_star') == '2.5' ? 'selected' : '' }}>2.5</option>
                                                        <option value="3" {{ request('no_of_star') == '3' ? 'selected' : '' }}>3</option>
                                                        <option value="3.5" {{ request('no_of_star') == '3.5' ? 'selected' : '' }}>3.5</option>
                                                        <option value="4" {{ request('no_of_star') == '4' ? 'selected' : '' }}>4</option>
                                                        <option value="4.5" {{ request('no_of_star') == '4.5' ? 'selected' : '' }}>4.5</option>
                                                        <option value="5" {{ request('no_of_star') == '5' ? 'selected' : '' }}>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Status -->
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Status</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="">--Select--</option>
                                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <!-- Submit and Reset Buttons -->
                                            <div class="col-sm-4 form-group mb-sm-0 align-self-end">
                                                <button class="btn btn-success mr-2" type="submit">Submit</button>
                                                <button class="btn btn-warning" type="reset" id="resetBtn">Reset</button>
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
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="reviewsTable" class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th width="2%">Sl #</th>
                                                                    <th width="10%">Name</th>
                                                                    <th width="10%">Location</th>
                                                                    <th width="10%">Tour Tags</th>
                                                                    <th width="5%">No of Star</th>
                                                                    <th width="25%">Review</th>
                                                                    <th width="10%">Review Date</th>
                                                                    <th width="8%">Status</th>
                                                                    <th width="10%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                            </section>
                        </div>
                    </div>
                </main>
                <div id="userModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userModalLabel">Review Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="dynamicModalContainer" class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">

    <!-- jQuery (Required for DataTables) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#reviewsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                        url: "{{ route('admin.managereviews.data') }}",
                        type: "GET",
                        data: function (d) {
                            d.search = $('input[type="search"]').val();
                            d.reviewer_name = $('#reviewer_name').val();
                            d.reviewer_loc = $('#reviewer_loc').val();
                            d.no_of_star = $('#no_of_star').val();
                            d.status = $('#status').val();
                        }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'reviewer_name', name: 'reviewer_name' },
                    { data: 'reviewer_loc', name: 'reviewer_loc' },
                    { data: 'tag_name', name: 'tag_name' },
                    { data: 'no_of_star', name: 'no_of_star' },
                    { data: 'feedback_msg', name: 'feedback_msg' },
                    { data: 'updated_date', name: 'updated_date' },
                    { data: 'status', name: 'status', render: function(data, type, row) {
                        return data; // Allow HTML rendering
                    }},
                    { data: 'action', name: 'action', orderable: false, searchable: false, render: function(data, type, row) {
                        return data; // Render buttons properly
                    }}
                ],
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                language: {
                search: "Filter records:",
                },
            });
            // Handle form submission
            $('#filterForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                table.ajax.reload(); // Reload the DataTable with the new filters
            });

            // Handle reset button click
            $('#resetBtn').on('click', function () {
                $('#filterForm')[0].reset(); // Reset the form
                table.ajax.reload(); // Reload the DataTable without filters
            });
        });
        
        function loadReviewDetails(reviewId) {
            $('#userModal .modal-body').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');

            $.ajax({
                url: "{{ url('/managereviews/viewpop') }}",
                type: "POST",
                data: { reqId: reviewId },
                dataType: "json",
                cache: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    if (response.error) {
                        alert("Error: " + response.error);
                    } else {
                        $("#dynamicModalContainer").html(response.html); // Inject only the dynamic content
                        $("#userModal").modal("show"); // Show the modal
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("Status: " + status + "\nError: " + xhr.responseText);
                }
            });
        }
        $(document).on('click', '[data-dismiss="modal"]', function () {
            $('#userModal').modal('hide');
        });
    </script>
</body>

</html>