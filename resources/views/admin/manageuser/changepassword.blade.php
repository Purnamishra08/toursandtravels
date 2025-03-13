    <!-- Metaheader Section-->
    @include('Admin.include.metaheader')
    <!-- Metaheader Section End -->
    <link href="{{asset('assets/css/change-password.css')}}" rel="stylesheet" />
    <style>
       
            .form-control{
            height: auto !important;
        }
        .login-title{
            margin: 0 0 1rem ;
        }
        .change-password-img{
           width: 85%;
        }
        .login-btn{
            padding: .5rem;
        }
        
    </style>

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
                        <div class="inner-layout h-100">
                            <div class="container-fluid px-4 pt-3 h-100">
                                <!-- <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item active">Change Password</li>
                                </ol> -->
                                @include('Admin.include.sweetaleart')
                                <div class="row align-items-center h-100 ">
                                    <div class="col-md-6">
                                        <img class="change-password-img" src="{{ asset('assets/img/change-password.png') }}" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="login-container">
                                            <h4 class="login-title">Change Password</h4>
                                            <form id="changePasswordForm" method="POST" action="{{ route('admin.change-password') }}" onsubmit="return validateForm()">
                                                @csrf

                                                <!-- Old Password -->
                                                <div class="mb-3 ">
                                                    <label for="old_password" class="form-label">Old Password</label>
                                                    <div class="icon-input-control">

                                                        <input type="password" class="form-control " id="old_password" name="old_password">
                                                        <i class="toggle-password bi bi-eye-slash icon-input-right"></i>
                                                    </div>
                                                    <div id="old_password_error" class="text-danger mt-1" style="display: none;"></div>
                                                </div>

                                                <!-- New Password -->
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label">New Password</label>
                                                    <div class="icon-input-control">
                                                        <input type="password" class="form-control " id="new_password" name="new_password">
                                                        <i class="toggle-password bi bi-eye-slash icon-input-right"></i>
                                                    </div>
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

        <script>
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', function() {
                    const inputField = this.closest('.icon-input-control').querySelector('.password-input'); // Get the correct input field

                    if (inputField.type === 'password') {
                        inputField.type = 'text';
                        this.classList.replace('bi-eye-slash', 'bi-eye'); // Change icon to "eye"
                    } else {
                        inputField.type = 'password';
                        this.classList.replace('bi-eye', 'bi-eye-slash'); // Change icon to "eye-slash"
                    }
                });
            });
        </script>

        </script>

    </body>

    </html>