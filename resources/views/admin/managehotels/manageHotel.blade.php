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
                                <a href="{{ route('admin.manageHotel.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a>
                                <a href="{{ route('admin.manageHotel') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View
                                </a>
                            </nav>
                            <!--Filter Box Start-->
                                <div class="filterBox collapse bg-light p-3" id="filterBox">
                                    <div class="row">
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Service Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Status</label>
                                            <select class="form-select">
                                                <option>Select</option>
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0 align-self-end">
                                            <button class="btn btn-success mr-2" type="button">Submit</button>
                                        <button class="btn btn-warning" type="reset">Reset</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center filterBtn">
                                    <button type="button" class="showListBtn" data-bs-toggle="collapse" data-bs-target="#filterBox"><i class="fa fa-search"></i> Search</button>
                                </div>
                            <!--Filter Box End-->
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="example"
                                                        class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="info">
                                                                <th width="2%">Sl #</th>
                                                                <th width="13%">Hotel Name</th>
                                                                <th width="13%">Destination</th>
                                                                <th width="13%">Hotel Type</th>
                                                                <th width="13%">Room Type</th>
                                                                <th width="13%">Default Price (₹)</th>
                                                                <th width="13%">Star Rating</th>
                                                                <th width="7%">Status</th>
                                                                <th width="12%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($hotels as $key => $hotel)
                                                            <tr>
                                                                <td>{{ ($hotels->currentPage() - 1) *
                                                                    $hotels->perPage() + $loop->iteration }}</td>
                                                                <td>{{ $hotel->hotel_name }}</td>
                                                                <td>{{ $hotel->destination_name }}</td>
                                                                <td>{{ $hotel->hotel_type_name }}</td>
                                                                <td>{{ $hotel->room_type }}</td>
                                                                <td>{{ $hotel->default_price }}</td>
                                                                <td>{{ $hotel->star_rating }}</td>
                                                                <td>
                                                                    @if ($hotel->status == 1)
                                                                        <form action="{{ route('admin.manageHotel.activeHotel', ['id' => $hotel->hotel_id]) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-outline-success"
                                                                                title="Active. Click to deactivate.">
                                                                                <span class="label-custom label label-success">Active</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <form action="{{ route('admin.manageHotel.activeHotel', ['id' => $hotel->hotel_id]) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-outline-dark"
                                                                                title="Inactive. Click to activate.">
                                                                                <span class="label-custom label label-danger">Inactive</span>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('admin.manageHotel.editHotel', ['id' => $hotel->hotel_id]) }}"
                                                                        class="btn btn-success btn-sm" title="Edit">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                    @if(session('user')->admin_type == 1)
                                                                    <form
                                                                        action="{{ route('admin.manageHotel.deleteHotel', ['id' => $hotel->hotel_id]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"
                                                                            title="Delete">
                                                                            <i class="fa fa-trash-o"></i>
                                                                        </button>
                                                                    </form>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td class="text-center" colspan="9">No data available
                                                                </td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    {{-- Pagination Links --}}
                                                    <div
                                                        class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                        <p class="mb-0">
                                                            Showing {{ $hotels->firstItem() }} to {{
                                                            $hotels->lastItem() }} of {{ $hotels->total() }}
                                                            entries
                                                        </p>
                                                        {{ $hotels->links('pagination::bootstrap-4') }}
                                                    </div>

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
    <script src="{{ asset('assets/js/validation.js') }}"></script>
</body>

</html>