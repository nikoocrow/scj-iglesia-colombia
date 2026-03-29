<div class="relative shrink-0" id="lang-wrapper">
    <!-- Botón con ícono de traducción -->
    <button onclick="document.getElementById('lang-menu').classList.toggle('hidden'); event.stopPropagation();"
        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors"
        title="{{ app()->getLocale() === 'ko' ? '언어 변경' : 'Cambiar idioma' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
        </svg>
    </button>

    <!-- Dropdown -->
    <div id="lang-menu"
        class="hidden absolute right-0 top-11 w-36 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden z-50">

        <a href="{{ route('lang.switch', 'es') }}"
            class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ app()->getLocale() === 'es' ? 'font-semibold text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }}">
            🇪🇸 <span>Español</span>
            @if(app()->getLocale() === 'es')
                <svg class="w-3.5 h-3.5 ml-auto text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </a>

        <a href="{{ route('lang.switch', 'ko') }}"
            class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ app()->getLocale() === 'ko' ? 'font-semibold text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }}">
            🇰🇷 <span>한국어</span>
            @if(app()->getLocale() === 'ko')
                <svg class="w-3.5 h-3.5 ml-auto text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </a>
    </div>
</div>

<script>
    document.addEventListener('click', function() {
        const menu = document.getElementById('lang-menu');
        if (menu) menu.classList.add('hidden');
    });
</script>
