<div class="relative shrink-0 w-10 h-10">
    <!-- Botón -->
    <button class="w-10 h-10 flex items-center justify-center
               rounded-lg bg-gray-200 dark:bg-gray-700
               hover:bg-gray-300 dark:hover:bg-gray-600
               transition" onclick="document.getElementById('lang-menu').classList.toggle('hidden')">

        <span class="text-lg leading-none">🌐</span>
    </button>

    <!-- Menú -->
    <div id="lang-menu" class="hidden absolute right-0 top-12 w-32
               bg-white dark:bg-gray-800
               rounded-lg shadow-lg border
               border-gray-200 dark:border-gray-700
               overflow-hidden">

        <a href="{{ route('lang.switch', 'es') }}" class="flex items-center gap-2 px-4 py-2 text-sm
                  hover:bg-gray-100 dark:hover:bg-gray-700">
            🇪🇸 <span>Español</span>
        </a>

        <a href="{{ route('lang.switch', 'ko') }}" class="flex items-center gap-2 px-4 py-2 text-sm
                  hover:bg-gray-100 dark:hover:bg-gray-700">
            🇰🇷 <span>한국어</span>
        </a>
    </div>
</div>