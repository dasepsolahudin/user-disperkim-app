<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                <i class="fas fa-cogs fa-lg text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Pengaturan Aplikasi
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola preferensi dan konfigurasi aplikasi Disperkim Anda.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Navigasi Tab Horizontal untuk Mobile --}}
            <div class="md:hidden px-4 sm:px-0 mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                        <a href="{{ route('settings.edit', 'profile') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $section == 'profile' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Profil
                        </a>
                        <a href="{{ route('settings.edit', 'security') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $section == 'security' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Keamanan
                        </a>
                        <a href="{{ route('settings.edit', 'notifications') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $section == 'notifications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Notifikasi
                        </a>
                        <a href="{{ route('settings.edit', 'appearance') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $section == 'appearance' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Tampilan
                        </a>
                        {{-- MENU SAMPAH DITAMBAHKAN KEMBALI DI SINI --}}
                        <a href="{{ route('settings.edit', 'trash') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $section == 'trash' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Sampah
                        </a>
                        <a href="{{ route('settings.edit', 'delete') }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $section == 'delete' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Hapus Akun
                        </a>
                    </nav>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                {{-- NAVIGASI SAMPING (SIDEBAR) untuk Desktop --}}
                <aside class="hidden md:block md:w-1/3 lg:w-1/4">
                    <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-2xl">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Menu Pengaturan</h3>
                            <p class="text-sm text-gray-500 mt-1">Pilih kategori pengaturan</p>
                        </div>
                        
                        <nav class="space-y-1 mt-4">
                            <a href="{{ route('settings.edit', 'profile') }}" 
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'profile' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-user-circle fa-fw mt-1 text-blue-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'profile' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Profil</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Informasi pribadi dan data akun</p>
                                </div>
                            </a>
                            <a href="{{ route('settings.edit', 'notifications') }}"
                                class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'notifications' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-bell fa-fw mt-1 text-yellow-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'notifications' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Notifikasi</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Pengaturan pemberitahuan</p>
                                </div>
                            </a>
                            <a href="{{ route('settings.edit', 'appearance') }}"
                                class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'appearance' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-paint-brush fa-fw mt-1 text-purple-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'appearance' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Tampilan</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Tema dan bahasa aplikasi</p>
                                </div>
                            </a>
                            <a href="{{ route('settings.edit', 'security') }}"
                                class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'security' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-shield-alt fa-fw mt-1 text-green-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'security' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Keamanan</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Password dan keamanan akun</p>
                                </div>
                            </a>
                            
                            {{-- MENU SAMPAH DITAMBAHKAN KEMBALI DI SINI --}}
                            <a href="{{ route('settings.edit', 'trash') }}"
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'trash' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-trash-alt fa-fw mt-1 text-orange-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'trash' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Sampah</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Berkas yang dihapus sementara</p>
                                </div>
                            </a>
                             
                            <a href="{{ route('settings.edit', 'delete') }}"
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'delete' ? 'bg-red-50 dark:bg-red-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-user-times fa-fw mt-1 text-red-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'delete' ? 'text-red-700 dark:text-red-300' : 'text-gray-800 dark:text-gray-200' }}">Hapus Akun</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Penghapusan akun permanen</p>
                                </div>
                            </a>
                        </nav>
                    </div>
                </aside>

                {{-- KONTEN UTAMA --}}
                <main class="flex-1">
                    <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-2xl">
                        @switch($section)
                            @case('profile')
    @include('search.settings.partials.update-profile-information-form')
    @break
                            @case('security')
                                @include('search.settings.partials.security-layout')
                                @break
                            @case('notifications')
    @include('search.settings.partials.update-notification-preferences-form')
    @break
                            @case('appearance')
                                @include('search.settings.partials.update-appearance-form')
                                @break
                            @case('trash')
                                {{-- Pastikan Anda memiliki view partial ini --}}
                                @include('search.settings.partials.trash-section')
                                @break
                            @case('delete')
                                @include('search.settings.partials.delete-user-form')
                                @break
                        @endswitch
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>