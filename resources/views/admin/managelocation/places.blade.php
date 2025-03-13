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
        							<a href="{{ route('admin.places.addplaces') }}"class="tab-menu__item  ">
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
                                    <form action="{{ route('admin.places') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <!-- Hotel Name -->
                                            <div class="col-sm-4 form-group mb-sm-0">
                                                <label class="control-label">Place Name</label>
                                                <input type="text" class="form-control" id="place_name" name="place_name"
                                                    value="{{ request('place_name') }}">
                                            </div>
                                            <div class="col-sm-4 form-group mb-sm-0">
                                                <label class="control-label">Destination</label>
                                                <select class="form-select" id="destination_id" name="destination_id">
                                                    <option value="">-- Select Destination Type --</option>
                                                    @forelse($destinations as $type)
                                                        <option value="{{ $type->destination_id }}" 
                                                            {{ request('destination_id') == $type->destination_id ? 'selected' : '' }}>
                                                            {{ $type->destination_name }}
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
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th width="8%">Sl #</th>
                                                                    <th width="20%">Place</th>
                                                                    <th width="12%">Destination</th>
                                                                    <th width="12%">Banner Image</th>
                                                                    <th width="15%">Place Image</th>
                                                                    <th width="8%">Status</th>
                                                                    <th width="10%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($places as $index => $place)
                                                                <tr>
                                                                    <td>{{ ($places->currentPage() - 1) *
                                                                    $places->perPage() + $loop->iteration }}</td>
                                                                    <td>{{ $place->place_name }}</td>
                                                                    <td>{{ $place->destination_name }}</td>
                                                                    <td>
                                                                        <div class="mt-2">
                                                                            <img id="destinationBannerPreview"
                                                                                src="{{ isset($place->placeimg) ? asset('storage/place_images/'.$place->placeimg) : '' }}"
                                                                                alt="Destination Banner Preview"
                                                                                class="img-fluid rounded border"
                                                                                style="width: 150px; height: 80px; object-fit: cover;">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="mt-2">
                                                                            <img id="destinationImagePreview" 
                                                                                src="{{ isset($place->placethumbimg) ? asset('storage/place_images/thumbs/'.$place->placethumbimg) : '' }}"
                                                                                alt="Destination Image"
                                                                                class="img-fluid rounded border"
                                                                                style="width: 150px; height: 80px; object-fit: cover;">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if($place->status == 1)
                                                                            <form action="{{ route('admin.places.activeplaces', ['id' => $place->placeid]) }}" method="POST"
                                                                                onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-outline-success"
                                                                                        title="Active. Click to deactivate.">
                                                                                        <span class="label-custom label label-success">Active</span>
                                                                                    </button>
                                                                            </form>
                                                                        @else
                                                                            <form action="{{ route('admin.places.activeplaces', ['id' => $place->placeid]) }}" method="POST"
                                                                                onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-outline-dark"
                                                                                    title="Active. Click to deactivate.">
                                                                                    <span class="label-custom label label-danger">Inactive</span>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('admin.places.editplaces', $place->placeid) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <form action="{{ route('admin.places.deleteplaces',  $place->placeid) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this place ?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                <i class="fa-regular fa-trash-can"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center">No data available</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $places->firstItem() }} to {{ $places->lastItem() }} of {{ $places->total() }} entries
                                                            </p>
                                                            {{ $places->links('pagination::bootstrap-4') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            </section>
                        </div>
                    </div>
                </main>

                <!-- Footer Start-->
                @include('Admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('Admin.include.footerJs')
    <!-- FooterJs End-->
</body>

</html>