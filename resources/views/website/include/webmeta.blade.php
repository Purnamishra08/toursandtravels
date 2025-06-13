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

    <!-- Preload and async load Animate.css -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    </noscript>

    <!-- Preload and async load Bootstrap -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    </noscript>

    <!-- Icons & Plugins (non-blocking, async load recommended) -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    </noscript>

    <!-- Local CSS (critical styles should go higher in priority) -->
    <link rel="stylesheet" href="{{ asset('assets/css/web-animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/web-common.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/web-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/web-content.css') }}">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <!-- Preload banner images -->
    <link rel="preload" as="image" fetchpriority="high" href="{{ asset('assets/img/web-img/banner-coorg_300kb_imresizer.webp') }}">
    <link rel="preload" as="image" fetchpriority="high" href="{{ asset('assets/img/web-img/banner-coorg_300kb_imresizermob.webp') }}">
    <link rel="preload" as="image" fetchpriority="high" href="{{ asset('assets/img/web-img/footer-bg.webp') }}">
</head>
