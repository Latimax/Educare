<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js" data-theme="light">

@include('parent.auth.header')

<body>

    @yield('content')

    @include('parent.auth.footer')

    @stack('scripts')

</body>

</html>
