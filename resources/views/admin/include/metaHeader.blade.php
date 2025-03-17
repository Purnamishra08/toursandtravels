<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>My Holidays Happiness</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/img/fav-icon.png') }}">
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/datepicker.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/frame.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/all.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/bootstrap-icons.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{asset('assets/js/all.min.js')}}"></script>
        <script type="text/javascript">
            var base_url = "<?php echo env('APP_URL'); ?>";
        </script>
    </head>

