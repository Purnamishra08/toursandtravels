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
                            <!-- <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Manage Vehicles</li>
                            </ol> -->
                            <nav class="tab-menu">
        							<a href="{{ route('admin.manageVehicletype.addVehicleType') }}" class="tab-menu__item  ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
        								Add
        							</a>
        							<a href="{{ route('admin.manageVehicletype') }}" class="tab-menu__item active ">
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
                                    <!-- @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif -->
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <!-- <div class="panel-heading">
                                                <div class="btn-group" id="buttonexport">
                                                    <a href="{{ route('admin.manageVehicletype.addVehicleType') }}">
                                                        <h4><i class="fa fa-plus-circle"></i> Add Vehicle Type</h4>
                                                    </a>
                                                </div>
                                            </div> -->
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                <table id="vehicleTypeTable" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl #</th>
                                                            <th>Vehicle Name</th>
                                                            <th>Capacity</th>
                                                            <th>Status</th>
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
                @include('Admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('Admin.include.footerJs')
    <!-- FooterJs End-->
    

    <script>
    $(document).ready(function () {
        $('#vehicleTypeTable').DataTable({
            processing: true, // Show loading indicator
            serverSide: true, // Use server-side processing
            ajax: '{{ route('admin.manageVehicletype') }}', // Fetch data from controller
            
            columns: [
                { 
                    data: null, 
                    orderable: false, 
                    searchable: false, 
                    render: (data, type, row, meta) => meta.row + 1 
                },
                { data: 'vehicle_name', name: 'vehicle_name' },
                { 
                    data: 'capacity', 
                    name: 'capacity',
                    render: (data) => `${data} Members` 
                },
                { data: 'status', name: 'status', orderable: false, searchable: true },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],

            order: [[1, 'asc']], // Default order by Vehicle Name (2nd column)

            // Length menu options
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],

            // Enable search on all columns
            searching: true,

            // Language settings
            language: {
                emptyTable: "No data available",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                search: "Search:",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    });
</script>

</body>

</html>