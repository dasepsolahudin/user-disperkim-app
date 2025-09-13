<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons (Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Skrip ini memastikan tema yang dipilih pengguna diterapkan secara konsisten
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen bg-slate-50 dark:bg-black">
        
        {{-- Sidebar --}}
        <aside
            class="relative z-10 w-64 flex-shrink-0 bg-white dark:bg-black border-r border-slate-200 dark:border-gray-800 flex flex-col transition-all duration-300"
            :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
        >
            <div class="flex items-center justify-between h-16 px-4 border-b border-slate-200 dark:border-gray-800">
                <div class="flex items-center transition-opacity duration-200" :class="{ 'opacity-100': sidebarOpen, 'opacity-0 w-0': !sidebarOpen }">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <div class="bg-indigo-600 text-white font-bold text-xl rounded-md w-8 h-8 flex items-center justify-center">D</div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-slate-800 dark:text-gray-200">Disperkim</p>
                        </div>
                    </a>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
                    <i class="fas" :class="{ 'fa-chevron-left': sidebarOpen, 'fa-chevron-right': !sidebarOpen }"></i>
                </button>
            </div>
            
            {{-- Navigasi Menu --}}
            <nav class="flex-1 mt-4 px-3 space-y-2">
                {{-- PERBAIKAN: Semua teks diubah menggunakan fungsi terjemahan __() --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fas fa-home fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">{{ __('Dashboard') }}</span>
                </a>

                <a href="{{ route('complaints.create') }}" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('complaints.create') || request()->routeIs('complaints.form') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fas fa-plus-circle fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">{{ __('Buat Laporan Baru') }}</span>
                </a>

                <a href="{{ route('complaints.index') }}" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('complaints.index') || request()->routeIs('complaints.show') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fas fa-folder-open fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">{{ __('Pengaduan Saya') }}</span>
                </a>

                <div class="pt-2"><hr class="border-t border-slate-200 dark:border-gray-800"></div>

                <a href="{{ route('settings.edit', 'profile') }}" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('settings.edit') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <i class="fas fa-cog fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">{{ __('Pengaturan') }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center p-3 rounded-lg text-sm font-medium text-gray-400 hover:bg-gray-900 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                        <span class="ml-3" x-show="sidebarOpen">{{ __('Logout') }}</span>
                    </a>
                </form>
            </nav>

            <div class="p-4 mt-auto" x-show="sidebarOpen">
                <div class="bg-slate-100 dark:bg-gray-900/50 text-slate-600 dark:text-gray-400 text-center p-4 rounded-lg border border-slate-200 dark:border-gray-800">
                    <p class="text-xs font-semibold">© 2025 Disperkim Kab Garut</p>
                    <p class="text-xs">v1.0.0</p>
                </div>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-black border-b border-slate-200 dark:border-gray-800">
                @if (isset($header))
                    {{ $header }}
                @else
                    <div class="flex items-center">
                        <h1 class="text-lg font-semibold text-slate-800 dark:text-gray-200">{{ __('Sistem Informasi Pengaduan') }}</h1>
                    </div>
                @endif
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-gray-900">
                        <span class="font-semibold text-sm text-slate-700 dark:text-gray-300 hidden sm:block">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->photo)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}">
                        @else
                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=ffffff" alt="{{ Auth::user()->name }}">
                        @endif
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-black border dark:border-gray-800 rounded-md shadow-xl z-20" x-cloak>
                        <a href="{{ route('settings.edit', 'profile') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-gray-900">{{ __('Pengaturan Akun') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-gray-900">{{ __('Logout') }}</a>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>

