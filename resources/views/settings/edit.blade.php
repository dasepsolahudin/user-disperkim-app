<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('⚙️ Pengaturan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">

                {{-- Navigasi Samping --}}
                <aside class="md:w-1/4">
                    <nav class="space-y-2">
                        {{-- Menu Edit Profil --}}
                        <a href="{{ route('settings.edit', 'profile') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-lg transition
                                  {{ $section == 'profile' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                            <i class="fas fa-user-edit fa-fw"></i>
                            <span>Edit Profil</span>
                        </a>

                        {{-- Menu Keamanan (Sekarang Aktif) --}}
                        <a href="{{ route('settings.edit', 'security') }}"
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-lg transition
                                  {{ $section == 'security' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                            <i class="fas fa-shield-alt fa-fw"></i>
                            <span>Keamanan</span>
                        </a>

                        {{-- Menu Notifikasi (Belum Aktif) --}}
                        <a href="#"
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-lg transition text-gray-400 cursor-not-allowed">
                            <i class="fas fa-bell fa-fw"></i>
                            <span>Notifikasi</span>
                        </a>
                    </nav>
                </aside>

                {{-- Konten Utama --}}
                <main class="flex-1">
                    {{-- Konten untuk Section PROFIL --}}
                    @if ($section == 'profile')
                        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            @include('settings.partials.update-profile-information-form')
                        </div>
                    
                    {{-- Konten untuk Section KEAMANAN (DIPERBAIKI) --}}
                    @elseif ($section == 'security')
                        {{-- Cukup panggil layout keamanan. File ini sudah menangani semuanya. --}}
                        @include('settings.partials.security-layout')
                    @endif
                </main>

            </div>
        </div>
    </div>
</x-app-layout>