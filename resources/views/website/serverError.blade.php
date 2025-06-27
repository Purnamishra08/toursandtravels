<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Error | Coorg Packages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            width: 100%;
            font-family: 'Lato', sans-serif;
        }

        .error-container {
            height: 100vh;
            width: 100vw;
            background: url('{{ asset('assets/img/web-img/500Error-1.jpg') }}') center center / cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: white;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0,0,0,0.6); /* slightly darker overlay for readability */
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 20px;
        }

        .brand-logo {
            width: 140px;
            margin-bottom: 20px;
            animation: zoomIn 1s ease;
        }

        h1 {
            font-size: 48px;
            font-weight: 900;
            animation: fadeInDown 1s ease;
        }

        p {
            font-size: 20px;
            margin-top: 10px;
            animation: fadeInUp 1.2s ease;
        }

        .btn-home {
            margin-top: 30px;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 50px;
            animation: fadeInUp 1.4s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        @media (max-width: 768px) {
            h1 { font-size: 36px; }
            p { font-size: 18px; }
            .brand-logo { width: 100px; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="overlay"></div>
        <div class="content">
            <!-- Branding -->
            <img src="{{ asset('assets/img/mhh-logo.webp') }}" alt="My Holiday Happiness" class="brand-logo" />

            <h1>Oops! Something went wrong</h1>
            <p>We are experiencing technical difficulties. Please try again later.</p>

            <a href="{{ route('website.home') }}" class="btn btn-primary btn-home">
                <i class="bi bi-house me-1"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>