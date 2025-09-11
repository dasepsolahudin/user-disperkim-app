<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen bg-gray-100">
        <aside
            class="w-64 flex-shrink-0 bg-green-50 border-r border-green-200 flex flex-col transition-all duration-300"
            :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
        >
            <div class="flex items-center justify-between h-16 px-4 border-b border-green-200">
                <div class="flex items-center" :class="{ 'opacity-100': sidebarOpen, 'opacity-0 w-0': !sidebarOpen }" class="transition-opacity duration-200">
                    <div class="bg-green-600 text-white font-bold text-xl rounded-md w-8 h-8 flex items-center justify-center">D</div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-gray-800">Disperkim</p>
                    </div>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-gray-500 hover:bg-green-100 focus:outline-none">
                    <i class="fas" :class="{ 'fa-chevron-left': sidebarOpen, 'fa-chevron-right': !sidebarOpen }"></i>
                </button>
            </div>

            <nav class="flex-1 mt-4 px-3 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors 
                          {{ request()->routeIs('dashboard') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-100 hover:text-gray-900' }}">
                    <i class="fas fa-home fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">Dashboard</span>
                </a>
                <a href="#" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('complaints.*') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-100 hover:text-gray-900' }}">
                    <i class="fas fa-file-alt fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">Pengaduan</span>
                </a>
                 <a href="{{ route('profile.edit') }}" 
                   class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('profile.edit') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-100 hover:text-gray-900' }}">
                    <i class="fas fa-user-circle fa-fw w-6 text-center"></i>
                    <span class="ml-3" x-show="sidebarOpen">Profil</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="pt-2">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center p-3 rounded-lg text-sm font-medium text-gray-600 hover:bg-green-100 hover:text-gray-900 transition-colors">
                        <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                        <span class="ml-3" x-show="sidebarOpen">Logout</span>
                    </a>
                </form>
            </nav>

            <div class="p-4 mt-auto" x-show="sidebarOpen">
                <div class="bg-gray-100 text-gray-600 text-center p-4 rounded-lg border">
                    <p class="text-xs font-semibold">© 2025 Diperkim Kab Garut</p>
                    <p class="text-xs">v1.0.0</p>
                </div>
            </div>
            </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between h-16 px-6 bg-green-50 border-b border-green-200">
                <div class="flex items-center">
                    <h1 class="text-lg font-semibold text-gray-800">Sistem Informasi Pengaduan</h1>
                </div>
                 <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-green-100">
                         <span class="font-semibold text-sm text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                        <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=ffffff" alt="Avatar">
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20" x-cloak>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>