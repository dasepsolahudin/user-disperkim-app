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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">

                {{-- NAVIGASI SAMPING (SIDEBAR) --}}
                <aside class="md:w-1/3 lg:w-1/4" x-data="{ open: true }">
                    <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-2xl">
                        <button @click="open = !open" class="w-full flex items-center justify-between text-left">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Menu Pengaturan</h3>
                                <p class="text-sm text-gray-500 mt-1">Pilih kategori pengaturan</p>
                            </div>
                            <i class="fas text-gray-500 transition-transform" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
                        </button>
                        
                        <nav class="space-y-1 mt-4 transition-all duration-300" x-show="open" x-collapse>
                            {{-- Menu Profil --}}
                            <a href="{{ route('settings.edit', 'profile') }}" 
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'profile' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-user-circle fa-fw mt-1 text-blue-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'profile' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Profil</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Informasi pribadi dan data akun</p>
                                </div>
                            </a>

                            {{-- Menu Notifikasi --}}
                             <a href="{{ route('settings.edit', 'notifications') }}"
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'notifications' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-bell fa-fw mt-1 text-yellow-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'notifications' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Notifikasi</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Pengaturan pemberitahuan</p>
                                </div>
                            </a>
                            
                            {{-- Menu Tampilan --}}
                             <a href="{{ route('settings.edit', 'appearance') }}"
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'appearance' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-paint-brush fa-fw mt-1 text-purple-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'appearance' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Tampilan</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Tema dan bahasa aplikasi</p>
                                </div>
                            </a>

                            {{-- Menu Keamanan --}}
                             <a href="{{ route('settings.edit', 'security') }}"
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'security' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-shield-alt fa-fw mt-1 text-green-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'security' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Keamanan</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Password dan keamanan akun</p>
                                </div>
                            </a>
                            
                            {{-- Menu Sampah --}}
                            <a href="{{ route('settings.edit', 'trash') }}"
                               class="group flex items-start gap-3 px-3 py-2 rounded-lg transition {{ $section == 'trash' ? 'bg-indigo-50 dark:bg-indigo-900/50' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                                <i class="fas fa-trash-alt fa-fw mt-1 text-orange-500"></i>
                                <div>
                                    <span class="font-semibold {{ $section == 'trash' ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-800 dark:text-gray-200' }}">Sampah</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Berkas yang dihapus sementara</p>
                                </div>
                            </a>
                             
                             {{-- Menu Hapus Akun --}}
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
                    <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl">
                        @switch($section)
                            @case('profile')
                                <div class="max-w-xl">
                                    @include('settings.partials.update-profile-information-form')
                                </div>
                                @break

                            @case('security')
                                {{-- PERBAIKAN: Memanggil file layout keamanan yang baru --}}
                                @include('settings.partials.security-layout')
                                @break

                            @case('notifications')
                                <div class="max-w-xl">
                                    @include('settings.partials.update-notification-preferences-form')
                                </div>
                                @break

                            @case('appearance')
                                <div class="max-w-xl">
                                    @include('settings.partials.update-appearance-form')
                                </div>
                                @break

                            @case('trash')
                                @include('settings.partials.trash-section')
                                @break

                            @case('delete')
                                @include('settings.partials.delete-user-form')
                                @break
                        @endswitch
                    </div>
                </main>

            </div>
        </div>
    </div>
</x-app-layout>

