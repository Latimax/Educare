<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">

@include('staff.auth.header')

<body>

    @yield('content')

    @include('staff.auth.footer')

    @stack('scripts')

</body>

</html>
