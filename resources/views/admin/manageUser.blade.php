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
                                    <li class="breadcrumb-item active">Manage user</li>
                                </ol> -->
                                <nav class="tab-menu">
        							<a href="{{ route('admin.manageUser.addUser') }}" class="tab-menu__item ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
        								Add
        							</a>
        							<a href="view-service-master.php" class="tab-menu__item active">
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
                                    <div class="row">
                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        <div class="col-sm-12">
                                            <div class="panel panel-bd lobidrag">
                                                <!-- <div class="panel-heading">
                                                    <div class="btn-group" id="buttonexport">
                                                        <a href="{{ route('admin.manageUser.addUser') }}">
                                                            <h4><i class="fa fa-plus-circle"></i> Add User</h4>
                                                        </a> 
                                                    </div>
                                                </div> -->
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered ">
                                                            <thead>
                                                                <tr >
                                                                    <th width="6%">Sl #</th>
                                                                    <th width="13%">Name</th>
                                                                    <th width="9%">Type</th>
                                                                    <th width="9%">Contact No.</th>
                                                                    <th width="18%">Email</th>
                                                                    <th width="18%">Module</th>
                                                                    <th width="7%">Status</th>
                                                                    <th width="12%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($users as $key => $user)
                                                                    <tr>
                                                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                                                        <td>{{ $user->admin_name }}</td>
                                                                        <td>
                                                                            @if ($user->admin_type == 1)
                                                                                Super Admin
                                                                            @elseif ($user->admin_type == 2)
                                                                                Admin
                                                                            @else
                                                                                User
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $user->contact_no }}</td>
                                                                        <td>{{ $user->email_id }}</td>
                                                                        <td>
                                                                            {{-- Fetch modules dynamically if required --}}
                                                                            {{ $user->modules ?? 'N/A' }}
                                                                        </td>
                                                                        <td>
                                                                            @if ($user->adminid != 1)
                                                                                @if ($user->status == 1)
                                                                                    <span class="status" data-id="status-{{ $user->adminid }}">
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
                                                                            @else
                                                                                <span class="label-custom label label-success">Active</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2">
                                                                                <a href="{{ route('admin.manageUser.editUser', ['id' => $user->adminid]) }}" class="btn btn-success btn-sm" title="Edit">
                                                                                    <i class="fa fa-pencil"></i>
                                                                                </a>
                                                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm view" title="View" onclick="loadUserDetails({{ $user->adminid }})">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </a>
                                                                                @if(session('user')->admin_type == 1 && $user->adminid != 1)
                                                                                    <form action="{{ route('admin.manageUser.deleteUser', ['id' => $user->adminid]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" class="d-inline-block">
                                                                                        @csrf
                                                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                            <i class="fa fa-trash-o"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                @endif
                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td class="text-center" colspan="8">No data available in table</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                                                            </p>
                                                            {{ $users->links('pagination::bootstrap-4') }}
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