<!-- Navbar -->
<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16">
    <div class="h-full px-6 flex items-center justify-between">
        <!-- Mobile menu button -->
        <button id="sidebarToggle"
            class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <!-- Page Title / Breadcrumb -->
        <div class="hidden lg:block">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-3 pr-2">
            <!-- Dark Mode Toggle -->
            <button id="darkModeToggle"
                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                <!-- Sun Icon (visible in dark mode) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 hidden dark:block">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <!-- Moon Icon (visible in light mode) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 block dark:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>

            </button>

            <!-- Language Switcher -->
            @include('partials.language-switcher')

            <!-- User Profile -->
            <a href="{{ route('profile.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                <div
                    style="width:36px;height:36px;border-radius:50%;overflow:hidden;background:#2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:white;font-weight:600;font-size:14px; p-4">
                    @if(Auth::user()->avatar)
                    <img src="{{ asset('avatars/' . Auth::user()->avatar) }}"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                    @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="hidden md:block text-left" style="min-width:0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white" style="line-height:1.3;">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" style="line-height:1.3;">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </a>
        </div>
    </div>
</header>