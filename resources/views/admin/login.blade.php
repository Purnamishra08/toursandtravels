<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Holiday Happiness</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/fav-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}"> 
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main> 
        <div>
            <div class="login-container">
                <h1 class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" >
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
                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                <div class="form-btns">
                    <button class="login-btn" type="submit">Login</button>
                    <!-- <a href="index.php" class="login-btn">Login</a> -->
                    <a href="{{ route('admin.forgot-password') }}" class="forgot-link">Forgot Password?</a>
                </div>
            </form>
            </div>
            <footer>Copyright &copy; 2025 My Holiday Happiness, All Right Reserved</footer>
        </div>
    </main>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script type="text/javascript"> 
    function validator(){
        if(!blankCheck('email_id','Email Id cannot be blank'))
            return false;
        if(!blankCheck('password','Password cannot be blank'))
            return false;
    }
    $(".toggle-password").click(function() {
        $(this).toggleClass("bi-eye bi-eye-slash");
         input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>

</body>



</html>