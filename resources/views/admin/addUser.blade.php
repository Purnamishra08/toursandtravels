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
                                    <li class="breadcrumb-item active">Add User</li>
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
                                                    <form action="{{ route('admin.manageUser.addUser') }}" method="POST" id="userform" name="userform" class="add-user"  onsubmit="return validateFormAddUser()">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter name" name="uname" id="uname">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>User Type</label>
                                                                <div class="radio-group">
                                                                    <div class="radio radio-info radio-inner">
                                                                        <input type="radio" name="utype" id="utype1" value="2"> 
                                                                        <label for="utype1">Admin</label>
                                                                    </div>
                                                                    <div class="radio radio-info radio-inner">
                                                                        <input type="radio" name="utype" id="utype2" value="3"> 
                                                                        <label for="utype2">User</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Contact No.</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Contact no" name="contact" id="contact">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" class="form-control" placeholder="Enter Email Id" name="email" id="email">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Password</label>
                                                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Confirm Password</label>
                                                                    <input type="password" class="form-control" placeholder="Enter Confirm Password" name="cpassword" id="cpassword">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="reset-button">
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                                <button type="reset" class="btn blackbtn">Reset</button>
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