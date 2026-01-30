<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Iglesia') }} - @yield('title', 'Bienvenido')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 antialiased transition-colors">

    {{-- BOTONES SUPERIORES --}}
    <div class="fixed top-4 right-4 z-50 flex items-center gap-2">
        {{-- Dark mode --}}
        <button id="darkModeToggle" class="w-10 h-10 shrink-0
           flex items-center justify-center
           rounded-lg bg-gray-200 dark:bg-gray-700
           hover:bg-gray-300 dark:hover:bg-gray-600
           transition">
            <svg class="w-6 h-6 hidden dark:block text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg class="w-6 h-6 block dark:hidden text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
            </svg>
        </button>

        {{-- Idioma --}}
        @include('partials.language-switcher')
    </div>

    {{-- CONTENIDO --}}
    <main class="min-h-screen flex items-center justify-center px-4">
        @yield('content')
    </main>

</body>

</html>