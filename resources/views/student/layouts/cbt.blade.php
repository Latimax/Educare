<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=9">
    <meta name="description" content="Student Dashboard">
    <meta name="author" content="Your Institution">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', env('APP_NAME'))</title>

    @php
        $imgpath = 'storage/front/images/';
    @endphp
        <!-- Favicon Icon -->
        <link rel="icon" href="{{ asset($imgpath . 'favicon.png') }}">

        <!-- Stylesheets -->
        <link href='{{ asset('studentpage/css/css.css') }}' rel='stylesheet'>

    <!-- Vendor Stylesheets -->
    <link href="{{ asset('studentpage/vendor/unicons-2.0.1/css/unicons.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/OwlCarousel/assets/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/OwlCarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/bootstrap-select/docs/docs/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/vendor/semantic/semantic.min.css') }}" rel="stylesheet">

    <!-- Application Stylesheets -->
    <link href="{{ asset('studentpage/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('studentpage/css/night-mode.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    @include('student.partials.cbtnavbar')


    <div class="main">

        @yield('content')

        @include('student.partials.cbtfooter')

    </div>

    <!-- jQuery CDN -->
    @stack('scripts')
</body>
</html>
