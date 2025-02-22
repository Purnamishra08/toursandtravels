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
                                    <li class="breadcrumb-item active">Edit User</li>
                                </ol>
                                @include('Admin.include.sweetaleart')
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-bd lobidrag">
                                                <div class="panel-heading">
                                                    <div class="btn-group" id="buttonexport">
                                                        <a href="{{ route('admin.manageUser') }}">
                                                            <h4><i class="fa fa-plus-circle"></i> Manage Users</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <form id="userform" name="userform" class="add-user" method="POST"  action="{{ route('admin.manageUser.editUser', ['id' => $user->adminid]) }}" onsubmit="return validateFormEditUser()">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6"> 
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter name" name="uname" id="uname" value="{{$user->admin_name}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label>User Type</label>
                                                                <div>
                                                                    @if($user->admin_type == 1)
                                                                        <div class="radio radio-info radio-inner">
                                                                            <input type="radio" name="utype" id="utype1" value="1" {{ $user->admin_type == 1 ? 'checked' : '' }}> <label for="utype1">Super Admin</label>
                                                                        </div>
                                                                    @else
                                                                        <div class="radio radio-info radio-inner">
                                                                            <input type="radio" name="utype" id="utype2" value="2" {{ $user->admin_type == 2 ? 'checked' : '' }}> <label for="utype2">Admin</label>
                                                                        </div>
                                                                        <div class="radio radio-info radio-inner">
                                                                            <input type="radio" name="utype" id="utype3" value="3" {{ $user->admin_type == 3 ? 'checked' : '' }}> <label for="utype3">User</label>
                                                                        </div>
                                                                    @endif
                                                                    <div id="utype_errorloc"></div>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Contact No.</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Contact no" name="contact" id="contact" value="{{$user->contact_no}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" class="form-control" placeholder="Enter Email Id" name="email" id="email" value="{{$user->email_id}}">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="clearfix"></div>  
                                                        <div class="col-md-6">
                                                            <div class="reset-button"> 
                                                                <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">Update</button>
                                                                <button type="button" class="btn blackbtn" onClick="window.location='{{ url('admin/users') }}'">Back</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </main>
                    <!-- Main Content End -->
                    
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