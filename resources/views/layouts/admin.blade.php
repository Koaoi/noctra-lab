<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | NOCTRA LAB</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

<div class="admin-wrapper">
    {{-- SIDEBAR --}}
    @include('admin.components.sidebar')

    {{-- CONTENT --}}
    <main class="admin-content">
        {{-- ADMIN TOAST --}}
        @include('components.toast')

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>