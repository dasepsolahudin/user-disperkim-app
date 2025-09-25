<nav x-data="{ open: false, searchOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <div class="hidden sm:flex sm:items-center sm:ms-10">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('complaints.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                    <div>{{ __('Pengaduan') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('complaints.form', ['category' => 'rutilahu'])">
                                    {{ __('Pengaduan Rutilahu') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('complaints.form', ['category' => 'infrastruktur'])">
                                    {{ __('Pengaduan Infrastruktur') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('complaints.form', ['category' => 'tata_kota'])">
                                    {{ __('Pengaduan Tata Kota') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('complaints.form', ['category' => 'air_bersih_sanitasi'])">
                                    {{ __('Air Bersih & Sanitasi') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown and Search Icon (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button @click="searchOpen = true" class="me-3 p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('settings.edit')">
                            {{ __('Pengaturan') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button @click.prevent="$dispatch('open-modal', 'confirm-logout')" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                <i class="fas fa-sign-out-alt w-4 mr-2"></i>
                {{ __('Log Out') }}
            </button>
            
            <form method="POST" action="{{ route('logout') }}" class="hidden" id="logout-form">
                @csrf
            </form>
        </x-slot>
    </x-dropdown>
</div>


            <!-- Mobile Menu Icons: Search and Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="searchOpen = true" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Hamburger -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Hamburger) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">Pengaduan</div>
                </div>
                <div class="mt-2 space-y-1">
                     <x-responsive-nav-link :href="route('complaints.form', ['category' => 'rutilahu'])" :active="request()->fullUrlIs(route('complaints.form', ['category' => 'rutilahu']))">
                         {{ __('Rutilahu') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('complaints.form', ['category' => 'infrastruktur'])" :active="request()->fullUrlIs(route('complaints.form', ['category' => 'infrastruktur']))">
                         {{ __('Infrastruktur') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('complaints.form', ['category' => 'tata_kota'])" :active="request()->fullUrlIs(route('complaints.form', ['category' => 'tata_kota']))">
                         {{ __('Tata Kota') }}
                    </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('complaints.form', ['category' => 'air_bersih_sanitasi'])" :active="request()->fullUrlIs(route('complaints.form', ['category' => 'air_bersih_sanitasi']))">
                         {{ __('Air Bersih & Sanitasi') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('settings.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button @click.prevent="$dispatch('open-modal', 'confirm-logout')" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out">
                {{ __('Log Out') }}
            </button>
        </div>
    </div>
</div>
    <!-- Search Modal/Overlay -->
    <div x-show="searchOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
        <!-- Background overlay -->
        <div @click="searchOpen = false" class="absolute inset-0 bg-black bg-opacity-50"></div>
        <!-- Search panel -->
        <div class="absolute inset-x-0 top-0 p-4">
            <div class="relative w-full max-w-xl mx-auto">
                {{-- KODE DIPERBAIKI: Menggunakan route('search') dan name="q" agar fungsional --}}
                <form action="{{ route('search') }}" method="GET">
                    <x-text-input id="search_mobile" name="q" class="block w-full pl-10 pr-4 py-2" placeholder="Cari laporan..." autofocus />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </form>
            </div>
        </div>
    </div>
</nav>

