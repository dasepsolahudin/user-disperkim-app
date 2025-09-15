<x-app-layout>
    {{-- Mengosongkan header bawaan agar kita bisa membuat header kustom di bawah --}}
    <x-slot name="header">
    </x-slot>

    <div class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER KUSTOM: Hanya menampilkan kategori --}}
            <div class="flex justify-end items-center px-4 sm:px-0">
                <span class="px-4 py-2 bg-gray-900 dark:bg-gray-700 text-white text-xs font-semibold rounded-full capitalize">
                    {{ str_replace('_', ' ', $complaint->category) }}
                </span>
            </div>

            {{-- KARTU KONTEN UTAMA --}}
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-lg space-y-8">
                
                {{-- Judul dan Status --}}
                <div>
                     <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                        {{ $complaint->title }}
                    </h1>
                     <div class="flex items-center mt-4 text-sm text-gray-500 border-t dark:border-gray-700 pt-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full capitalize
                            @switch($complaint->status)
                                @case('Baru')
                                @case('pending') 
                                    bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 @break
                                @case('Diproses') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @break
                                @case('Selesai') 
                                @case('approved')
                                    bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @break
                                @case('Ditolak')
                                @case('rejected')
                                    bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @break
                                @default bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @endswitch">
                            Status: {{ $complaint->status }}
                        </span>
                    </div>
                </div>

                {{-- Bagian Rincian Laporan --}}
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 pt-1">
                        <span class="w-2 h-2 inline-block bg-blue-500 rounded-full"></span>
                    </div>
                    <div class="w-full">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Rincian Laporan</h3>
                        <div class="mt-2 p-4 bg-gray-50/70 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $complaint->description }}</p>
                        </div>
                    </div>
                </div>

                {{-- Bagian Lokasi Spesifik --}}
                <div class="flex items-start space-x-4">
                     <div class="flex-shrink-0 pt-1">
                        <span class="w-2 h-2 inline-block bg-green-500 rounded-full"></span>
                    </div>
                    <div class="w-full">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Lokasi Spesifik</h3>
                        <div class="mt-2 p-4 bg-gray-50/70 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $complaint->location_text ?: 'Tidak ada detail lokasi.' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Bagian Foto Lampiran --}}
                <div class="flex items-start space-x-4">
                     <div class="flex-shrink-0 pt-1">
                        <span class="w-2 h-2 inline-block bg-purple-500 rounded-full"></span>
                    </div>
                    <div class="w-full">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Foto Lampiran</h3>
                        <div class="mt-2 p-4 bg-gray-50/70 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @forelse ($complaint->photos as $photo)
                                    <a href="{{ asset('storage/' . $photo->path) }}" target="_blank" class="block relative group">
                                        <img src="{{ asset('storage/' . $photo->path) }}" 
                                             alt="Foto Aduan {{ $loop->iteration }}" 
                                             class="rounded-lg w-full h-40 object-cover transition-transform duration-300 group-hover:scale-105">
                                    </a>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 col-span-full">Tidak ada foto yang dilampirkan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Waktu Pembuatan & Update --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Dibuat: {{ $complaint->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center">
                         <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5"></path></svg>
                        <span>Diperbarui: {{ $complaint->updated_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>

                {{-- PERBAIKAN: Tombol Aksi dipindahkan ke bagian bawah kartu --}}
                <div class="flex items-center justify-between mt-8 border-t dark:border-gray-700 pt-6">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                    
                    @if(!$complaint->trashed())
                        <a href="{{ route('pengaduan.edit', $complaint) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition">
                            Edit Pengaduan
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

