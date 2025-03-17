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
                                <!-- <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                        </path>
                                    </svg>
                                    Add
                                </a> -->
                                <a href="{{ route('admin.manageenquiry') }}" class="tab-menu__item active">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
                                    </svg> -->
                                    Manage Enquiry
                                </a>
                            </nav>
                            <!--Filter Box Start-->
                            <div class="filterBox collapse bg-light p-3" id="filterBox">
                                <form action="{{ route('admin.manageenquiry') }}" method="POST" onsubmit="return validator()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" id="cont_name" name="cont_name" 
                                                value="{{ request('cont_name') }}">
                                        </div>
                                       <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" id="cont_email" name="cont_email" 
                                                value="{{ request('cont_email') }}">
                                        </div><div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">Contact No</label>
                                            <input type="text" class="form-control" id="cont_phone" name="cont_phone" 
                                                value="{{ request('cont_phone') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">From Date</label>
                                            <input type="text" class="form-control" id="from_date" name="from_date" 
                                                value="{{ request('from_date') }}">
                                        </div>
                                        <div class="col-sm-4 form-group mb-sm-0">
                                            <label class="control-label">To Date</label>
                                            <input type="text" class="form-control" id="to_date" name="to_date" 
                                                value="{{ request('to_date') }}">
                                        </div>
                                        <!-- Submit and Reset Buttons -->
                                        <div class="col-sm-4 form-group mb-sm-0 align-self-end">
                                            <button class="btn btn-success mr-2" type="submit">Submit</button>
                                            <!-- <button class="btn btn-warning" type="reset" id="resetBtn">Reset</button> -->
                                            <a href="{{ route('admin.manageenquiry') }}" class="btn btn-warning">Reset</a>
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
                                                                <th width="13%">Name</th>
                                                                <th width="13%">Email Id</th>
                                                                <th width="13%">Contact No</th>
                                                                <th width="13%">Page Name</th>
                                                                <th width="13%">Enquiry Details</th>
                                                                <th width="13%">Enquiry Date</th>
                                                                <th width="12%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($enquirys as $key => $enquiry)
                                                            <tr>
                                                                <td>{{ ($enquirys->currentPage() - 1) *
                                                                    $enquirys->perPage() + $loop->iteration }}</td>
                                                                <td>{{ $enquiry->cont_name }}</td>
                                                                <td>{{ $enquiry->cont_email }}</td>
                                                                <td>{{ $enquiry->cont_phone }}</td>
                                                                <td>{{ $enquiry->page_name }}</td>
                                                                <td>{{ $enquiry->cont_enquiry_details }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($enquiry->cont_date)->format('jS M Y') }}</td>
                                                                <td>
                                                                    <div class="d-flex gap-1">
                                                                    <a href="{{ route('admin.manageenquiry.viewEnquiry', ['id' => $enquiry->enq_id]) }}"
                                                                        class="btn btn-primary btn-sm" title="View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    @if(session('user')->admin_type == 1)
                                                                    <form
                                                                        action="{{ route('admin.manageenquiry.deleteEnquiry', ['id' => $enquiry->enq_id]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to delete this enquiry?')">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"
                                                                            title="Delete">
                                                                            <i class="fa-regular fa-trash-can"></i>
                                                                        </button>
                                                                    </form>
                                                                    @endif
                                                                    </div>
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
                                                            Showing {{ $enquirys->firstItem() }} to {{
                                                            $enquirys->lastItem() }} of {{ $enquirys->total() }}
                                                            entries
                                                        </p>
                                                        {{ $enquirys->links('pagination::bootstrap-4') }}
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
</body>

</html>