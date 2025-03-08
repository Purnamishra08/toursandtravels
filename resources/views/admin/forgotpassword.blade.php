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
    </head>

<body>
    <main> 
        <div>
            <div class="login-container">
                <h1 class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" >
                </h1>
                <h2 class="login-title">Admin Login</h2>
                <div class="icon-input-control">
                    <input class="form-control" type="text" placeholder="User id">
                    <span class="icon-input-right">
                        <i class="bi bi-person"></i>
                    </span>
                </div>
                <div class="icon-input-control">
                    <input class="form-control" type="text" placeholder="Email id">
                    <span class="icon-input-right">
                        <i class="bi bi-envelope"></i>
                    </span>
                </div>
                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                <div class="form-btns">
                    <a href="login.html" class="login-btn">Submit</a>
                    <a href="{{ route('admin.login') }}" class="forgot-link">Back to Login</a>
                </div>
            </div>
            <footer>Copyright &copy; 2025 Tours and Travel, All Right Reserved</footer>
        </div>
    </main>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>