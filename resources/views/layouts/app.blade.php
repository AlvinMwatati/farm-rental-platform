<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Auth User Data for JavaScript -->
    <meta name="user-id" content="{{ Auth::id() }}">
    <script>
        window.Laravel = {!! json_encode([
            'user' => Auth::user(),
        ]) !!};
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css'])
    @livewireStyles  <!-- ✅ Include Livewire styles if using Livewire -->
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col"> <!-- Use flex to allow content to grow -->
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="flex-1"> <!-- Allow main to take up remaining space -->
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @livewireScripts  <!-- ✅ Include Livewire scripts if using Livewire -->
</body>
</html>