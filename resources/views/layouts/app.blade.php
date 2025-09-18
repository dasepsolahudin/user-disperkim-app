<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
<body class="font-sans antialiased bg-slate-100 dark:bg-gray-900">
        {{-- KODE DIPERBARUI: Menambahkan state 'searchOpen' --}}
        <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false, searchOpen: false }">
        
        {{-- START: Mobile Sidebar Overlay --}}
       <div x-show="mobileSidebarOpen" class="fixed inset-0 flex z-40 lg:hidden" x-cloak>
    <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50" aria-hidden="true"></div>
    
    {{-- UBAH WARNA LATAR BELAKANG DI SINI --}}
    <aside class="relative w-64 flex-shrink-0 bg-blue-700 flex flex-col">
        {{-- Menggunakan @include untuk menghindari duplikasi kode sidebar --}}
        @include('layouts.sidebar-content')
    </aside>
</div>
        {{-- END: Mobile Sidebar Overlay --}}

        {{-- START: Desktop Sidebar --}}
        <aside
    class="hidden lg:flex fixed top-0 left-0 h-full z-30 w-64 flex-shrink-0 flex-col transition-all duration-300 bg-blue-700"
    :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
>
    @include('layouts.sidebar-content')
</aside>
        {{-- END: Desktop Sidebar --}}

        {{-- Main Content Area --}}
        <div class="lg:pl-64 flex flex-col flex-1 transition-all duration-300" 
             :class="{ 'lg:pl-64': sidebarOpen, 'lg:pl-20': !sidebarOpen }">
            
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white dark:bg-black border-b border-slate-200 dark:border-gray-800 sticky top-0 z-20">
                {{-- Tombol untuk membuka sidebar di mobile --}}
                <div class="flex items-center">
                    <button @click.stop="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    {{-- Tombol sidebar desktop di header telah dihapus sesuai permintaan --}}
                </div>
                
                {{-- Slot Header untuk Judul Halaman --}}
                <div class="flex-1 text-center lg:text-left lg:ml-4">
                    @if (isset($header))
                        {{ $header }}
                    @endif
                </div>
                
                {{-- START: Grup Item Sebelah Kanan (Pencarian, Notifikasi, Profil) --}}
                <div class="flex items-center space-x-4">

                    {{-- KODE DIPERBARUI: Form pencarian diganti dengan tombol ikon --}}
                    <button @click="searchOpen = true" class="p-2 rounded-full text-slate-500 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-gray-900 focus:outline-none">
                        <i class="fas fa-search"></i>
                    </button>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 rounded-full text-slate-500 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-gray-900 relative">
                            <i class="fas fa-bell"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications->isNotEmpty())
                                <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-black"></span>
                            @endif
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-black border dark:border-gray-800 rounded-md shadow-xl z-30" x-cloak>
                            <div class="p-4 font-semibold text-sm border-b dark:border-gray-700">Notifikasi</div>
                            <div class="divide-y dark:divide-gray-700 max-h-96 overflow-y-auto">
                                @if(isset($unreadNotifications))
                                    @forelse ($unreadNotifications as $notification)
                                        <a href="{{ route('pengaduan.show', $notification->data['complaint_id']) }}" class="block px-4 py-3 hover:bg-slate-100 dark:hover:bg-gray-900">
                                            <p class="text-sm font-medium text-slate-800 dark:text-gray-200">{{ $notification->data['message'] }}</p>
                                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </a>
                                    @empty
                                        <div class="px-4 py-3 text-center">
                                            <p class="text-sm text-slate-500 dark:text-gray-400">Tidak ada notifikasi baru.</p>
                                        </div>
                                    @endforelse
                                @endif
                            </div>
                            <div class="p-2 text-center border-t dark:border-gray-700">
                                <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Lihat semua notifikasi</a>
                            </div>
                        </div>
                    </div>
                    {{-- Menu Dropdown User (Kode Asli Anda) --}}
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
                </div>
                {{-- END: Grup Item Sebelah Kanan --}}
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-4 sm:px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- KODE BARU: Modal/Panel Pencarian --}}
        <div x-show="searchOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
            <!-- Background overlay -->
            <div @click="searchOpen = false" class="absolute inset-0 bg-black bg-opacity-50"></div>
            <!-- Search panel -->
            <div class="absolute inset-x-0 top-0 p-4">
                <div class="relative w-full max-w-xl mx-auto">
                    <form action="{{ route('search') }}" method="GET">
                        <x-text-input id="search_modal" name="q" class="block w-full pl-10 pr-4 py-2" placeholder="Cari laporan..." autofocus />
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @stack('scripts')
</body>
</html>
