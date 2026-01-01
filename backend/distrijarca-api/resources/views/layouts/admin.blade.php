<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - DISTRI-JARCA')</title>
    
    @include('partials.admin.head-styles')
    
    @yield('extra-css')
</head>
<body>

    @include('partials.admin.sidebar')

    <div class="main-content">
        @include('partials.admin.navbar')

        <div class="dashboard-content">
            @yield('content')
        </div>
    </div>

    @include('partials.admin.footer')

    @include('partials.admin.footer-scripts')
    
    @yield('extra-js')

</body>
</html>
