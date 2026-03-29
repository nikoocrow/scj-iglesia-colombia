<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Iglesia') }} - @yield('title', 'Bienvenido')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-indigo-50 dark:bg-slate-900 antialiased transition-colors">
<div id="vanta-bg" class="fixed inset-0" style="z-index:0"></div>

    {{-- BOTONES SUPERIORES --}}
    <div class="fixed top-4 right-4 flex items-center gap-2" style="z-index:50">
        {{-- Dark mode --}}
        <button id="darkModeToggle" class="w-10 h-10 shrink-0
           flex items-center justify-center
           rounded-lg bg-gray-200 dark:bg-gray-700
           hover:bg-gray-300 dark:hover:bg-gray-600
           transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 hidden dark:block text-yellow-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 block dark:hidden text-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
        </button>

        {{-- Idioma --}}
        @include('partials.language-switcher')
    </div>

    {{-- CONTENIDO --}}
    <main class="min-h-screen flex items-center justify-center px-4 relative" style="z-index:10">
        @yield('content')
    </main>


<!-- Vanta.js Clouds -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.net.min.js"></script>
<script>
    function initVanta() {
        const isDark = document.documentElement.classList.contains('dark');
        if (window._vantaEffect && typeof window._vantaEffect.destroy === 'function') {
            window._vantaEffect.destroy();
        }
        window._vantaEffect = VANTA.NET({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            backgroundColor: isDark ? 0x0f172a : 0xf0f4ff,
            color: isDark ? 0x3b82f6 : 0x2563eb,
            points: 10.00,
            maxDistance: 20.00,
            spacing: 18.00,
            speed: 1.0,
        });
    }

    document.addEventListener('DOMContentLoaded', initVanta);

    // Re-inicializar cuando cambie el modo oscuro
    const observer = new MutationObserver(() => initVanta());
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
</script>
</body>

</html>