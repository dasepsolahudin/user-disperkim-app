<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-black">
    {{-- 
        PENYESUAIAN UTAMA ADA DI SINI. 
        x-data diubah untuk mengelola sidebar di desktop (sidebarOpen) 
        dan di mobile (mobileSidebarOpen) secara terpisah.
    --}}
    <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">
        
        {{-- START: Mobile Sidebar Overlay --}}
        <div x-show="mobileSidebarOpen" class="fixed inset-0 flex z-40 lg:hidden" x-cloak>
            {{-- Backdrop --}}
            <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black opacity-30" aria-hidden="true"></div>
            
            {{-- Mobile Sidebar Panel --}}
            <aside class="relative w-64 flex-shrink-0 bg-white dark:bg-black border-r border-slate-200 dark:border-gray-800 flex flex-col">
                @include('layouts.sidebar-content')
            </aside>
        </div>
        {{-- END: Mobile Sidebar Overlay --}}

        {{-- START: Desktop Sidebar --}}
        <aside
            class="hidden lg:flex fixed top-0 left-0 h-full z-10 w-64 flex-shrink-0 flex-col transition-all duration-300"
            :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
        >
            @include('layouts.sidebar-content')
        </aside>
        {{-- END: Desktop Sidebar --}}

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col transition-all duration-300" 
             :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-20': !sidebarOpen }">
            
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white dark:bg-black border-b border-slate-200 dark:border-gray-800 sticky top-0 z-20">
                {{-- Tombol Hamburger untuk Mobile --}}
                <button @click.stop="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>

                {{-- Header Slot atau Judul Default (diberi div agar tidak terpengaruh tombol hamburger) --}}
                <div>
                    @if (isset($header))
                        {{ $header }}
                    @else
                        <h1 class="text-lg font-semibold text-slate-800 dark:text-gray-200">{{ __('Sistem Informasi Pengaduan') }}</h1>
                    @endif
                </div>
                
                {{-- Menu Dropdown User --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-gray-900">
                        <span class="font-semibold text-sm text-slate-700 dark:text-gray-300 hidden sm:block">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->photo)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}">
                        @else
                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=ffffff" alt="{{ Auth::user()->name }}">
                        @endif
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-black border dark:border-gray-800 rounded-md shadow-xl z-30" x-cloak>
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
                <div class="container mx-auto px-4 sm:px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>