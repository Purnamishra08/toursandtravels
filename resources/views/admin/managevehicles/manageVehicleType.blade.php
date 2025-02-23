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
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item active">Manage Vehicles</li>
                                </ol>
                                @include('Admin.include.sweetaleart')
                                <section class="content">
                                    <div class="row">
                                        <!-- @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif -->
                                        <div class="col-sm-12">
                                            <div class="panel panel-bd lobidrag">
                                                <div class="panel-heading">
                                                    <div class="btn-group" id="buttonexport">
                                                        <a href="{{ route('admin.managevehicles.addVehicleType') }}">
                                                            <h4><i class="fa fa-plus-circle"></i> Add Vehicle Type</h4>
                                                        </a> 
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr class="info">
                                                                    <th width="6%">Sl #</th>
                                                                    <th width="13%">Vehicle Name</th>
                                                                    <th width="9%">Capacity</th>
                                                                    <th width="7%">Status</th>
                                                                    <th width="12%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($vehicletypes as $key => $vehicletype)
                                                                    <tr>
                                                                    <td>{{ ($vehicletypes->currentPage() - 1) * $vehicletypes->perPage() + $loop->iteration }}</td>
                                                                        <td>{{ $vehicletype->vehicle_name }}</td>
                                                                        <td>{{ $vehicletype->capacity }}</td>
                                                                        <td>
                                                                                @if ($vehicletype->status == 1)
                                                                                    <span class="status" data-id="status-{{ $vehicletype->vehicleid }}">
                                                                                        <a href="javascript:void(0)" title="Active. Click to deactivate.">
                                                                                            <span class="label-custom label label-success">Active</span>
                                                                                        </a>
                                                                                    </span>
                                                                                @else
                                                                                    <span class="status" data-id="status-{{ $user->adminid }}">
                                                                                        <a href="javascript:void(0)" title="Inactive. Click to activate.">
                                                                                            <span class="label-custom label label-danger">Inactive</span>
                                                                                        </a>
                                                                                    </span>
                                                                                @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('admin.managevehicles.editVehicleType', ['id' => $vehicletype->vehicleid]) }}" class="btn btn-success btn-sm" title="Edit">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                            @if(session('user')->admin_type == 1)
                                                                                <form action="{{ route('admin.managevehicles.deleteVehicleType', ['id' => $vehicletype->vehicleid]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                        <i class="fa fa-trash-o"></i>
                                                                                    </button>
                                                                                </form>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td class="text-center" colspan="8">No data available</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $vehicletypes->firstItem() }} to {{ $vehicletypes->lastItem() }} of {{ $vehicletypes->total() }} entries
                                                            </p>
                                                            {{ $vehicletypes->links('pagination::bootstrap-4') }}
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
        <script>
           function loadUserDetails(userId) {
                $('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');

                $.ajax({
                    url: "",
                    type: "GET",
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Adding CSRF Token
                    },
                    success: function (modal_content) {
                        $('#myModal .modal-content').html(modal_content);
                        $('#myModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        alert("Status: " + status + "\nError: " + error);
                        $('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> Your query could not be executed. Please try again.</div>');
                    }
                });

            }
        </script>
        

    </body>
</html>