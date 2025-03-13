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
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th>Sl #</th>
                                                                    <th>Parameter</th>
                                                                    <th width="60%">Parameter Value</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($parameters as $index => $parameter)
                                                                <tr>
                                                                    <td>{{ ($parameters->currentPage() - 1) *
                                                                    $parameters->perPage() + $loop->iteration }}</td>
                                                                    <td>{{ $parameter->parameter }}</td>
                                                                    <td>
                                                                        @if($parameter->input_type != 3)
                                                                            @if($parameter->parid == 4)
                                                                                Edit to view this code
                                                                            @else
                                                                                {!! $parameter->par_value !!}
                                                                            @endif
                                                                        @else
                                                                            @if(isset($parameter->par_value) && !empty($parameter->par_value))
                                                                                <a href="{{ asset('storage/parameters/'.$parameter->par_value) }}" target="_blank">
                                                                                    <img id="destinationImagePreview" 
                                                                                        src="{{ asset('storage/parameters/'.$parameter->par_value) }}"
                                                                                        alt="Destination Image"
                                                                                        class="img-fluid rounded border"
                                                                                        style="width: 150px; height: 80px; object-fit: cover;">
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('admin.managetourpackages.editgeneralsettings', $parameter->parid) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center">No data available</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $parameters->firstItem() }} to {{ $parameters->lastItem() }} of {{ $parameters->total() }} entries
                                                            </p>
                                                            {{ $parameters->links('pagination::bootstrap-4') }}
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