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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .login-title {
        margin: 1rem 0 2rem 0;
  
}
.form-control {
    margin-bottom: .75rem;
}
        
        

    </style>
</head>

<body>
<main>
    <div class="scroll-container">
        <div class="login-container">
            <h1 class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
            </h1>
            <h2 class="login-title">Forgot Password</h2>
            @include('admin.include.sweetaleart')
            <form id="forgot-password-form">
                @csrf
                <div class="icon-input-control">
                    <input class="form-control" type="email" placeholder="User ID (Email)" name="email" id="email">
                    <span class="icon-input-right">
                        <i class="bi bi-person"></i>
                    </span>
                </div>

                <div id="otp-section" style="display:none;">
                    <input class="form-control mt-2" type="text" placeholder="Enter OTP" name="otp" id="otp">
                </div>

                <div id="password-section" style="display:none;">
                    <input class="form-control mt-2" type="password" placeholder="New Password" name="new_password" id="new_password">
                    <input class="form-control mt-2" type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                </div>
                <div class="form-btns mt-3">
                    <span class="spinner-border spinner-border-sm d-none" id="btn-loader" role="status" aria-hidden="true"></span>
                    <button type="button" class="login-btn" id="submit-btn">
                        <span id="btn-text">Submit</span>
                    </button>
                    <a href="{{ route('admin.login') }}" class="forgot-link">Back to Login</a>
                </div>
            </form>

            <div id="response-message" class="mt-2" style="color:red;"></div>
        </div>

        <footer>Copyright &copy; 2025 My Holiday Happiness, All Right Reserved</footer>
    </div>
</main>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script>
let currentStep = 1;

function showButtonLoader() {
    $('#btn-loader').removeClass('d-none');
    $('#btn-text').text('Processing...');
    $('#submit-btn').attr('disabled', true);
}

function hideButtonLoader() {
    $('#btn-loader').addClass('d-none');
    $('#btn-text').text('Submit');
    $('#submit-btn').attr('disabled', false);
}

$('#submit-btn').on('click', function (e) {
    e.preventDefault();

    const email = $('#email').val();
    const otp = $('#otp').val();
    const newPassword = $('#new_password').val();
    const confirmPassword = $('#confirm_password').val();
    const recaptchaResponse = grecaptcha.getResponse();

    showButtonLoader();

    if (currentStep === 1) {
        $.post("{{ route('admin.checkEmailAndSendOTP') }}", {
            _token: "{{ csrf_token() }}",
            email: email
        }, function (response) {
            hideButtonLoader();
            if (response.status === 'success') {
                $('#otp-section').show();
                Swal.fire('OTP Sent!', 'OTP sent to your email. It is valid for 10 minutes.', 'success');
                currentStep = 2;
            } else {
                Swal.fire('Error!', response.message, 'error');
            }
        });
    } else if (currentStep === 2) {
        $.post("{{ route('admin.verifyOtp') }}", {
            _token: "{{ csrf_token() }}",
            otp: otp
        }, function (response) {
            hideButtonLoader();
            if (response.status === 'success') {
                $('#password-section').show();
                Swal.fire('OTP Verified!', 'OTP verified. Please set a new password.', 'success');
                currentStep = 3;
            } else {
                Swal.fire('Invalid OTP', response.message, 'error');
            }
        });
    } else if (currentStep === 3) {
        if (newPassword !== confirmPassword) {
            hideButtonLoader();
            Swal.fire('Mismatch', 'Passwords do not match.', 'error');
            return;
        }

        $.post("{{ route('admin.resetPassword') }}", {
            _token: "{{ csrf_token() }}",
            new_password: newPassword,
            confirm_password: confirmPassword,
            email: email,
            recaptchaResponse: recaptchaResponse
        }, function (response) {
            hideButtonLoader();
            if (response.status === 'success') {
                Swal.fire('Password Reset', 'Password reset successfully.', 'success');
                $('#forgot-password-form')[0].reset();
                currentStep = 1;
                $('#otp-section').hide();
                $('#password-section').hide();
            } else {
                Swal.fire('Failed', response.message, 'error');
            }
        });
    }
});
</script>

