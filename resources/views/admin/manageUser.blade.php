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
                                    <li class="breadcrumb-item active">Manage user</li>
                                </ol>
                                @include('Admin.include.sweetaleart')
                                <section class="content">
                                    <div class="row">
                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        <div class="col-sm-12">
                                            <div class="panel panel-bd lobidrag">
                                                <div class="panel-heading">
                                                    <div class="btn-group" id="buttonexport">
                                                        <a href="{{ route('admin.manageUser.addUser') }}">
                                                            <h4><i class="fa fa-plus-circle"></i> Add User</h4>
                                                        </a> 
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr class="info">
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
                                                                            <a href="{{ route('admin.manageUser.editUser', ['id' => $user->adminid]) }}" class="btn btn-success btn-sm" title="Edit">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm view" title="View" onclick = "loadUserDetails({{ $user->adminid }})">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>

                                                                            @if ($user->adminid != 1)
                                                                                <a onclick="return confirm('Are you sure you want to delete this user?')" href="{{ url('admin/users/delete', $user->adminid) }}" class="btn btn-danger btn-sm" title="Delete">
                                                                                    <i class="fa fa-trash-o"></i>
                                                                                </a>
                                                                            @endif
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