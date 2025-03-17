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
                                <nav class="tab-menu">
        							<a href="{{ route('admin.manageUser.addUser') }}" class="tab-menu__item ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
        								Add
        							</a>
        							<a href="view-service-master.php" class="tab-menu__item active">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
        									<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
        									<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
        								</svg>
        								View
        							</a>
        						</nav>
                                @include('Admin.include.sweetaleart')
                                <section class="content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-bd lobidrag">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="userTable" class="table table-bordered ">
                                                            <thead>
                                                                <tr >
                                                                    <th width="6%">Sl #</th>
                                                                    <th width="13%">Name</th>
                                                                    <th width="9%">Type</th>
                                                                    <th width="9%">Contact No.</th>
                                                                    <th width="18%">Email</th>
                                                                    <th width="18%">Module</th>
                                                                    <th width="7%">Status</th>
                                                                    <th width="12%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
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
                    <div id="userModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel">User Details</h5>
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
                    @include('Admin.include.footer')
                    <!-- Footer End-->
                </div>
            </div>
        </div>
        <!-- FooterJs Start-->
        @include('Admin.include.footerJs')
        <!-- FooterJs End-->

        <!-- validation js -->
        
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">

        <!-- jQuery (Required for DataTables) -->
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

        <!-- DataTables JS -->
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#userTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.manageUser.data') }}",
                        type: "GET",
                        data: function (d) {
                            d.search = $('input[type="search"]').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'admin_name', name: 'admin_name' },
                        { data: 'admin_type', name: 'admin_type' },
                        { data: 'contact_no', name: 'contact_no' },
                        { data: 'email_id', name: 'email_id' },
                        { data: 'modules', name: 'modules' },
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
            });
            function loadUserDetails(userId) {
                $('#userModal .modal-body').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');

                $.ajax({
                    url: "{{ url('/manageUser/viewpop') }}",
                    type: "POST",
                    data: { reqId: userId },
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