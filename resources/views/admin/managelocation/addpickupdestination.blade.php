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
                                <a href="{{ route('admin.destination.adddestination') }}"class="tab-menu__item  ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a>
                                <a href="{{ route('admin.destination') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View Destinations
                                </a>
                                <a href="#"class="tab-menu__item active">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
                                        Pickup Destination
        						</a>
                            </nav>
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div  style="margin-bottom: 25px;box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16); background-color:#fff; padding:25px;border-radius: 4px;">
                                            <div class="panel-body">
                                                <form action="{{ route('admin.destination.addpickupdestination') }}"
                                                    method="POST" id="form_destination" name="form_destination" class="add-destination"
                                                    onsubmit="return validator()">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Pickup Destination Name <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter destination name" name="destination_name" id="destination_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Pick / Drop Price () <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter Pick or Drop Price" name="pick_drop_price" id="pick_drop_price">
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

                                    <div class="col-sm-8">
                                        <div  style="margin-bottom: 25px;box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16); background-color:#fff; padding:25px;border-radius: 4px;">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="destination" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="info">
                                                                <th>Sl #</th>
                                                                <th>Sources</th>
                                                                <th>Pick / Drop Price ()</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody> </tbody>
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
                <div class="modal-dialog">
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
        function validator(){
        if(!blankCheck('destination_name','Destination Name cannot be Blank'))
        return false;
        }
        $(document).ready(function () {
        $('#destination').DataTable({
            processing: true, // Show loading indicator
            serverSide: true, // Use server-side processing
            ajax: {
                url: "{{ route('admin.destination.pickupdestinationdata') }}",
                type: "GET",
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => meta.row + 1
                },
                { data: 'destination_name', name: 'destination_name' },
                { data: 'pick_drop_price', name: 'pick_drop_price' },
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

     // Open Edit Modal
        $(document).on('click', '.edit-btn', function () {
            var sourceId = $(this).data('id'); // Get source ID

            $.ajax({
                url: '/editpickupdestination/edit/' + sourceId,  // Fetch modal HTML via AJAX
                type: 'GET',
                dataType: 'json',  // Ensure JSON response
                success: function (response) {
                    if (response.html) {
                        $('#modalContainer .modal-content').html(response.html); // Inject modal content
                        $('#modalContainer').modal('show'); // Open modal
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Error: Invalid response!',
                            confirmButtonColor: '#3085d6',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: 'Error loading edit form.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            });
        });
        // Update Source AJAX
        $(document).on('submit', '#editDestinationForm', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/updatepickupdestination/update',  // Ensure correct URL
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            confirmButtonColor: '#3085d6',
                        });
                        $('#modalContainer').modal('hide'); // Close modal
                        $('#destination').DataTable().ajax.reload(); // Reload DataTable
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.error,
                            confirmButtonColor: '#3085d6',
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Error updating source.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            });
        });

    </script>
</body>
</html>