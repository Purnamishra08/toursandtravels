    <!-- Metaheader Section-->
    @include('Admin.include.metaheader')
    <!-- Metaheader Section End -->
    <link href="{{asset('assets/css/change-password.css')}}" rel="stylesheet" />
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
                                    <li class="breadcrumb-item active">Change Password</li>
                                </ol> -->
                                @include('Admin.include.sweetaleart')
                                <div class="row align-items-center mt-md-4">
                                    <div class="col-md-6">
                                        <img class="change-password-img" src="{{ asset('assets/img/change-password.png') }}" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="login-container">
                                            <h4 class="login-title">Change Password</h4>
                                            <form id="changePasswordForm" method="POST" action="{{ route('admin.change-password') }}" onsubmit="return validateForm()">
                                                @csrf

                                                <!-- Old Password -->
                                                <div class="mb-3">
                                                    <label for="old_password" class="form-label">Old Password</label>
                                                    <input type="password" class="form-control" id="old_password" name="old_password">
                                                    <div id="old_password_error" class="text-danger mt-1" style="display: none;"></div>
                                                </div>

                                                <!-- New Password -->
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                                    <div id="new_password_error" class="text-danger mt-1" style="display: none;"></div>
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="mb-3">
                                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                                    <div id="confirm_password_error" class="text-danger mt-1" style="display: none;"></div>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="d-grid">
                                                    <button type="submit" class=" login-btn">Update Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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