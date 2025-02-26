<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour And Travel Admin Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}"> 
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="assets/img/duplicate-logo-dashbord.png">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main> 
        <div>
            <div class="login-container">
                <h1 class="logo">
                    <img src="{{ asset('assets/img/duplicate-logo.png') }}" alt="logo" >
                </h1>
                <h2 class="login-title">Admin Login</h2>
                @include('Admin.include.sweetaleart')
                <form action="{{ route('admin.processLogin') }}" method="POST" onsubmit="return validator()">
                    @csrf
                <div class="icon-input-control">
                    <input class="form-control" type="text" placeholder="User id" name="email_id" id="email_id">
                    <span class="icon-input-right">
                        <i class="bi bi-person" ></i>
                    </span>
                </div>
                <div class="icon-input-control">
                    <input  type="password" id="password" class="form-control" name="password" id="password">                    
                        <i class="toggle-password bi bi-eye-slash icon-input-right"></i>                    
                </div>
                <div class="captcha-inputs">
                        <input class="form-control" type="text" id="captcha-input" placeholder="Enter Captcha">
                        <div class="icon-input-control">
                            <input class="form-control captcha-control" type="text" id="captcha-text" disabled>
                            <span class="icon-input-right" onclick="generateCaptcha()">
                                <i class="fa fa-refresh"></i>
                            </span>
                        </div>
                </div>
                <div class="form-btns">
                    <button class="login-btn" type="submit">Login</button>
                    <!-- <a href="index.php" class="login-btn">Login</a> -->
                    <a href="{{ route('admin.forgot-password') }}" class="forgot-link">Forgot Password?</a>
                </div>
            </form>
            </div>
            <footer>Copyright &copy; 2025 Tours and Travel, All Right Reserved</footer>
        </div>
    </main>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script type="text/javascript"> 
    function validator(){
        if(!blankCheck('email_id','Email Id cannot be blank'))
            return false;
        if(!blankCheck('password','Password cannot be blank'))
            return false;
        let inputCaptcha = document.getElementById("captcha-input").value.trim();
        let generatedCaptcha = document.getElementById("captcha-text").value.trim();
        if (inputCaptcha === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill Captcha and try again.',
                });
            generateCaptcha();
            return false;
        }
        if(inputCaptcha !== generatedCaptcha){
            Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Incorrect Captcha! Please try again.',
                });
            generateCaptcha();
            return false;
        }
    }
    $(document).ready(function() {
        generateCaptcha();
    });
    $(".toggle-password").click(function() {
        $(this).toggleClass("bi-eye bi-eye-slash");
         input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    function generateCaptcha() {
        let chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        let captcha = "";
        for (let i = 0; i < 6; i++) {
            captcha += chars[Math.floor(Math.random() * chars.length)];
        }
        document.getElementById("captcha-text").value = captcha;
    }

    function validateCaptcha() {
        let inputCaptcha = document.getElementById("captcha-input").value.trim();
        let generatedCaptcha = document.getElementById("captcha-text").value.trim();
        if (inputCaptcha === "" || inputCaptcha !== generatedCaptcha) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Incorrect Captcha! Please try again.',
                });
            generateCaptcha();
            return false;
        }
        return true;
    }
</script>

</body>



</html>