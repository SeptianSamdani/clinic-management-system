<!-- ========================================== -->
<!-- resources/views/layouts/guest.blade.php -->
<!-- For pages without authentication -->
<!-- ========================================== -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Sehat Sejahtera')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    @yield('content')
    
    @stack('scripts')
</body>
</html>