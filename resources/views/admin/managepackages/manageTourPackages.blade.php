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
                                <a href="{{ route('admin.managetourpackages.addTourPackages') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a>
                                <a href="{{ route('admin.managetourpackages') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View
                                </a>
                            </nav>
                            <!--Filter Box Start-->
                            <div class="filterBox collapse bg-light p-3" id="filterBox">
                                <form id="filterForm" method="GET">
                                    <div class="row">
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Packages</label>
                                            <input type="text" class="form-control" id="package_name" name="package_name" 
                                                value="{{ request('package_name') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Starting City</label>
                                            <select class="form-select" id="starting_city" name="starting_city">
                                                <option value="">-- Select Starting City --</option>
                                                @foreach($destinations as $destination)
                                                    <option value="{{ $destination->destination_id }}" {{ request('starting_city') == $destination->destination_id ? 'selected' : '' }}>
                                                        {{ $destination->destination_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Duration</label>
                                            <select class="form-select" id="duration" name="duration">
                                                <option value="">-- Select Duration--</option>
                                                @forelse($durations as $duration)
                                                    <option value="{{ $duration->durationid }}" 
                                                        {{ request('duration') == $duration->durationid ? 'selected' : '' }}>
                                                        {{ $duration->duration_name }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>No destination available</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <!-- Status -->
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="">Select</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Inactive</option>
                                            </select>
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
                                    <!-- @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif -->
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="example"
                                                        class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="info">
                                                                <th width="1%">Sl #</th>
                                                                <th width="20%">Packages</th>
                                                                <th width="10%">Starting City</th>
                                                                <th width="10%">Package Durations</th>
                                                                <th width="9%">Price (₹)</th>
                                                                <th width="12%">Banner Images</th>
                                                                <th width="12%">Tour Images</th>
                                                                <th width="6%">Show In Home</th>
                                                                <th width="6%">Status</th>
                                                                <th width="9%">Action</th>
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
    // Setup DataTable
    let table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.managetourpackages') }}",
            data: function (d) {
                d.package_name = $('#package_name').val();
                d.starting_city = $('#starting_city').val();
                d.duration = $('#duration').val();
                d.status = $('#status').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'tpackage_name', name: 'a.tpackage_name' },
            { data: 'destination_name', name: 'b.destination_name' },
            { data: 'duration_name', name: 'c.duration_name' },
            { data: 'price', name: 'a.price' },
            { data: 'banner', name: 'a.tpackage_image', orderable: false, searchable: false },
            { data: 'thumb', name: 'a.tour_thumb', orderable: false, searchable: false },
            { data: 'show_in_home', name: 'a.show_in_home'},
            { data: 'status', name: 'a.status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

    // Filter Form Submission
    $('#filterBoxBtn').on('click', function (e) {
        e.preventDefault(); // Prevent form submission
        table.draw(); // Reload table with filter values
    });

    // Reset Button
    $('#resetFilterBtn').on('click', function () {
        $('#filterForm')[0].reset(); // Reset form fields
        table.draw(); // Reload table with reset values
    });
});


    </script>
    
</body>

</html>