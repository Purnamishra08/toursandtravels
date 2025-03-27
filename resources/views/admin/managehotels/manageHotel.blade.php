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
                                <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                        </path>
                                    </svg>
                                    Add
                                </a>
                                <a href="{{ route('admin.manageHotels') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
                                    </svg>
                                    View
                                </a>
                            </nav>
                            <!--Filter Box Start-->
                            <div class="filterBox collapse bg-light p-3" id="filterBox">
                                <form method="GET" id="filterForm">
                                    @csrf
                                    <div class="row">
                                        <!-- Hotel Name -->
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Hotel Name</label>
                                            <input type="text" class="form-control" id="hotel_name" name="hotel_name" 
                                                value="{{ request('hotel_name') }}">
                                        </div>
                                        <!-- Destination -->
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Destination</label>
                                            <select class="form-select" id="destinationid" name="destinationid">
                                                <option value="">-- Select destination --</option>
                                                @forelse($destinations as $destination)
                                                    <option value="{{ $destination->destination_id }}" 
                                                        {{ request('destinationid') == $destination->destination_id ? 'selected' : '' }}>
                                                        {{ $destination->destination_name }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>No destination available</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <!-- Hotel Type -->
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Hotel Type</label>
                                            <select class="form-select" id="hotel_type" name="hotel_type">
                                                <option value="">-- Select Hotel Type --</option>
                                                @forelse($hotelTypes as $hotelType)
                                                    <option value="{{ $hotelType->hotel_type_id }}" 
                                                        {{ request('hotel_type') == $hotelType->hotel_type_id ? 'selected' : '' }}>
                                                        {{ $hotelType->hotel_type_name }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>No hotel type available</option>
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
                                            <!-- <button class="btn btn-warning" type="reset" id="resetBtn">Reset</button> -->
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
                                                    <table id="hotelTable" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl #</th>
                                                                <th>Hotel Name</th>
                                                                <th>Destination</th>
                                                                <th>Hotel Type</th>
                                                                <th>Room Type</th>
                                                                <th>Price (₹)</th>
                                                                <th>Star Rating</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
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
    // document.getElementById('resetBtn').addEventListener('click', function (e) {
    //     e.preventDefault(); // Prevent the default reset action
    //     // Clear all fields manually
    //     document.getElementById('hotel_name').value = '';
    //     document.getElementById('destinationid').selectedIndex = 0;
    //     document.getElementById('hotel_type').selectedIndex = 0;
    //     document.getElementById('status').selectedIndex = 0;
    // });
    
    $(document).ready(function () {
    loadTable();

    function loadTable() {
        $('#hotelTable').DataTable().clear().destroy(); // ✅ Clear and destroy before reinitializing
        $('#hotelTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.manageHotels') }}',
                type: 'GET',
                data: function (d) {
                    d.hotel_name = $('input[name=hotel_name]').val();
                    d.destinationid = $('select[name=destinationid]').val();
                    d.hotel_type = $('select[name=hotel_type]').val();
                    d.status = $('select[name=status]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'hotel_name', name: 'a.hotel_name' }, // ✅ Fix table alias
                { data: 'destination_name', name: 'b.destination_name' }, // ✅ Fix table alias
                { data: 'hotel_type_name', name: 'c.hotel_type_name' }, // ✅ Fix table alias
                { data: 'room_type', name: 'a.room_type' }, // ✅ Fix table alias
                { data: 'default_price', name: 'a.default_price' }, // ✅ Fix table alias
                { data: 'star_rating', name: 'a.star_rating' }, // ✅ Fix table alias
                { data: 'status', name: 'a.status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    }

    $('#filterBoxBtn').on('click', function (e) {
        e.preventDefault();
        $('#hotelTable').DataTable().ajax.reload(); // ✅ Reload DataTable after form submit
    });

    $('#resetFilterBtn').on('click', function (e) {
        $('#filterForm')[0].reset();
        $('#hotelTable').DataTable().ajax.reload();
    });
});

</script>
</body>

</html>