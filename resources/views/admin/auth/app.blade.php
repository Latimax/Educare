<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">

@include('admin.auth.header')

<body>

    @yield('content')

    @include('admin.auth.footer')

    @stack('scripts')

</body>

</html>
