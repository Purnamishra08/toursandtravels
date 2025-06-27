<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $meta_title ?? 'My Holiday Happiness' }}</title>
    <meta name="description" content="{{ $meta_description ?? 'Default description for the website' }}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'default, keywords' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/fav-icon.webp') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" media="print" onload="this.onload=null;this.media='all';">
    
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap">
    </noscript>

    <!-- Preconnect to critical domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Preload styles (deferred loading using media=print) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" media="print" onload="this.onload=null;this.media='all';">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" media="print" onload="this.onload=null;this.media='all';">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" media="print" onload="this.onload=null;this.media='all';">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" media="print" onload="this.onload=null;this.media='all';">
    <link rel="preload" as="image" fetchpriority="high" href="{{ asset('assets/img/web-img/banner-coorg_300kb_imresizer.webp') }}">
    <link rel="preload" as="image" fetchpriority="high" href="{{ asset('assets/img/web-img/banner-coorg_300kb_imresizermob.webp') }}">

    <!-- No-JS fallback -->
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    </noscript>

    <!-- Local critical stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/web-animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/web-common.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/web-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/web-content.css') }}">

    <!-- Optional: defer SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>