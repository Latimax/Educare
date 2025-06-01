{{-- layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">

<head>
    <title>@yield('title', env('APP_NAME'))</title>

    @php
        $imgpath = 'storage/front/images/';
    @endphp
    <!-- Favicon -->
    <link rel="icon" href="{{ asset($imgpath . 'favicon.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/remixicon.css') }}">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/bootstrap.min.css') }}">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/apexcharts.css') }}">
    <!-- Data Table css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/dataTables.min.css') }}">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/editor-katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/editor.atom-one-dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/editor.quill.snow.css') }}">
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/flatpickr.min.css') }}">
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/full-calendar.css') }}">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
    <!-- Popup css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/magnific-popup.css') }}">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/slick.css') }}">
    <!-- prism css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/prism.css') }}">
    <!-- file upload css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/file-upload.css') }}">

    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/audioplayer.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/style.css') }}">


    @stack('styles')
</head>

<body>

    @include('admin.partials.sidebar')

    <main class="dashboard-main">

        @include('admin.partials.navbar')

        @yield('content')

        @include('admin.partials.footer')

        @stack('scripts')

</body>

</html>
