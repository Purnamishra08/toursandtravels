<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour And Travel Admin Login</title>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"> 
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" />
    <!-- <link href="assets/css/login.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
</head>

<body>
    <main> 
        <div>
            <div class="login-container">
                <h1 class="logo">
                    <img src="{{ asset('assets/img/duplicate-logo.png') }}" alt="logo" >
                </h1>
                <h2 class="login-title">Admin Login</h2>
                 <!-- Display errors if there are any -->
                    @if ($errors->any())
                        <div style="color: red;">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                <form action="{{ route('admin.processLogin') }}" method="POST">
                    @csrf
                <div class="icon-input-control">
                    <input class="form-control" type="email_id" placeholder="User id" name="email_id" required>
                    <span class="icon-input-right">
                        <i class="bi bi-person" ></i>
                    </span>
                </div>
                <div class="icon-input-control">
                    <input  type="password" id="password" class="form-control" name="password" required>                    
                        <i class="toggle-password bi bi-eye-slash icon-input-right"></i>                    
                </div>
                <div class="captcha-inputs">
                    <input class="form-control" type="text" placeholder="Enter Captcha">
                    <div class="icon-input-control">
                        <input class="form-control captcha-control" type="text" value="123sd4" disabled>
                        <span class="icon-input-right">
                            <i class="fa fa-refresh"></i>
                        </span>
                    </div>
                </div>
                <div class="form-btns">
                    <button class="login-btn" type="submit">Login</button>
                    <!-- <a href="index.php" class="login-btn">Login</a> -->
                    <a href="forgot.php" class="forgot-link">Forgot Password?</a>
                </div>
            </form>
            </div>
            <!--<footer>Copyright &copy; 2022 Varanasi, All Right Reserved</footer>-->
        </div>
    </main>

<script type="text/javascript"> 
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