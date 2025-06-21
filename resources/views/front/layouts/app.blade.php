<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">

<head>
    <title>@yield('title', env('APP_NAME'))</title>

    @php
        $imgpath = 'storage/front/images/';
    @endphp
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset($imgpath . 'favicon.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.min.css') }}">
    <!-- MeanMenu CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/meanmenu.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/fontawesome.min.css') }}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/flaticon.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/magnific-popup.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/animate.css') }}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.carousel.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <!-- Dark CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/dark.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/responsive.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Preloader -->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object" id="object_one"></div>
                <div class="object" id="object_two"></div>
                <div class="object" id="object_three"></div>
                <div class="object" id="object_four"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    @include('front.partials.navbar')

    <main class="dashboard-main">
        @yield('content')

        @include('front.partials.footer')
    </main>

    <!-- Scroll top -->
    <a href="#" class="scroll-top wow animate__animated animate__bounceInDown">
        <i class="fas fa-angle-double-up"></i>
    </a>

    <!-- Js -->
    <script src="{{ asset('front/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap Js -->
    <script src="{{ asset('front/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- MeanMenu JS -->
    <script src="{{ asset('front/assets/js/jquery.meanmenu.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('front/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('front/assets/js/owl.carousel.min.js') }}"></script>
    <!-- Wow JS -->
    <script src="{{ asset('front/assets/js/wow.min.js') }}"></script>
    <!-- Isotope JS -->
    <script src="{{ asset('front/assets/js/isotope.pkgd.min.js') }}"></script>
    <!-- Form Validator JS -->
    <script src="{{ asset('front/assets/js/form-validator.min.js') }}"></script>
    <!-- Contact Form JS -->
    <script src="{{ asset('front/assets/js/contact-form-script.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
