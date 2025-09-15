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

    {{-- Penambahan Pustaka Peta (LeafletJS) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
    <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">
        
        {{-- START: Mobile Sidebar Overlay --}}
        <div x-show="mobileSidebarOpen" class="fixed inset-0 flex z-40 lg:hidden" x-cloak>
            <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50" aria-hidden="true"></div>
            
            <aside class="relative w-64 flex-shrink-0 bg-white dark:bg-black border-r border-slate-200 dark:border-gray-800 flex flex-col">
                {{-- Menggunakan @include untuk menghindari duplikasi kode sidebar --}}
                @include('layouts.sidebar-content')
            </aside>
        </div>
        {{-- END: Mobile Sidebar Overlay --}}

        {{-- START: Desktop Sidebar --}}
        <aside
            class="hidden lg:flex fixed top-0 left-0 h-full z-30 w-64 flex-shrink-0 flex-col transition-all duration-300"
            :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
        >
            @include('layouts.sidebar-content')
        </aside>
        {{-- END: Desktop Sidebar --}}

        {{-- Main Content Area --}}
        <div class="lg:pl-64 flex flex-col flex-1 transition-all duration-300" 
             :class="{ 'lg:pl-64': sidebarOpen, 'lg:pl-20': !sidebarOpen }">
            
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white dark:bg-black border-b border-slate-200 dark:border-gray-800 sticky top-0 z-20">
                {{-- Tombol untuk membuka sidebar di mobile dan menutup di desktop --}}
                <div class="flex items-center">
                    <button @click.stop="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
                        <i class="fas" :class="{ 'fa-chevron-left': sidebarOpen, 'fa-chevron-right': !sidebarOpen }"></i>
                    </button>
                </div>
                
                {{-- Slot Header untuk Judul Halaman --}}
                <div class="flex-1 text-center lg:text-left lg:ml-4">
                    @if (isset($header))
                        {{ $header }}
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
    @stack('scripts')
</body>
</html>