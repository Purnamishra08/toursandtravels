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
        							<a href="{{ route('admin.destinationtype.adddestinationtype') }}"class="tab-menu__item  ">
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
                            <!-- <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Manage State</li>
                            </ol> -->
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    @if(session('m_message'))
                                                        <div class="alert alert-info">{{ session('m_message') }}</div>
                                                    @endif

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th>Sl #</th>
                                                                    <th>Destination Type</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($destination_type as $index => $destination_types)
                                                                <tr>
                                                                    <td>{{ ($destination_type->currentPage() - 1) *
                                                                    $destination_type->perPage() + $loop->iteration }}</td>
                                                                    <td>{{ $destination_types->destination_type_name }}</td>
                                                                    <td>
                                                                        @if($destination_types->status == 1)
                                                                            <span style="color: green; font-weight: bold; position: relative; padding-left: 20px;">
                                                                                <span style="width: 10px; height: 10px; background: green; border-radius: 50%; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
                                                                                box-shadow: 0 0 8px rgba(0, 255, 0, 0.8);"></span>
                                                                                Active
                                                                            </span>
                                                                        @else
                                                                            <span style="color: red; font-weight: bold; position: relative; padding-left: 20px;">
                                                                                <span style="width: 10px; height: 10px; background: red; border-radius: 50%; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
                                                                                box-shadow: 0 0 8px rgba(255, 0, 0, 0.8);"></span>
                                                                                Inactive
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('admin.destinationtype.editdestinationtype', $destination_types->destination_type_id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <form action="{{ route('admin.destinationtype.deletedestinationtype',  $destination_types->destination_type_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this destination type?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                <i class="fa fa-trash-o"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">No data available</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $destination_type->firstItem() }} to {{ $destination_type->lastItem() }} of {{ $destination_type->total() }} entries
                                                            </p>
                                                            {{ $destination_type->links('pagination::bootstrap-4') }}
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