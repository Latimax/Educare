<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">

@include('student.auth.header')

<body>

    @yield('content')

    @include('student.auth.footer')

    @stack('scripts')

</body>

</html>
