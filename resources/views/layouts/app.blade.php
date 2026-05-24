<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NOCTRA LAB') — Limited Fashion Drop</title>
    <meta name="description" content="@yield('meta_description', 'NOCTRA LAB — Korean Streetwear & Limited Drop Fashion Store')">

    {{-- Vite assets (Bootstrap + Custom CSS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    @include('components.navbar')

    {{-- TOAST NOTIFICATION --}}
    @include('components.toast')

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.footer')

    @stack('scripts')
</body>
</html>