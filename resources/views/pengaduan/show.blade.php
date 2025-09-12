<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengaduan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Tombol Kembali --}}
                <div class="mb-6">
                    <a href="{{ route('complaints.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Pengaduan
                    </a>
                </div>

                {{-- Judul Pengaduan --}}
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $complaint->title }}</h1>
                <p class="text-sm text-gray-600 mb-6">
                    Kategori: <span class="font-semibold text-indigo-700">{{ $complaint->category }}</span> |
                    Tanggal Lapor: {{ \Carbon\Carbon::parse($complaint->created_at)->format('d F Y H:i') }}
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Kolom Kiri: Status Pengaduan dan Deskripsi --}}
                    <div class="lg:col-span-2">
                        <div class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Status Pengaduan</h3>
                            <ol class="relative border-s border-indigo-200">
                                {{-- Step 1: Laporan Dibuat --}}
                                <li class="mb-10 ms-6">
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-indigo-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-indigo-900">
                                        <svg class="w-2.5 h-2.5 text-indigo-800 dark:text-indigo-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                    </span>
                                    <h4 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                        Laporan Dibuat
                                        @if($complaint->status == 'Baru')
                                            <span class="bg-indigo-100 text-indigo-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300 ms-3">Saat Ini</span>
                                        @endif
                                    </h4>
                                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Pengaduan Anda telah kami terima pada tanggal {{ \Carbon\Carbon::parse($complaint->created_at)->format('d F Y H:i') }}.</time>
                                </li>

                                {{-- Step 2: Verifikasi Petugas --}}
                                <li class="mb-10 ms-6">
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        @if(in_array($complaint->status, ['Verifikasi', 'Pengerjaan', 'Selesai']))
                                            <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                        @else
                                            <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <h4 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Verifikasi Petugas
                                        @if($complaint->status == 'Verifikasi')
                                            <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">Saat Ini</span>
                                        @endif
                                    </h4>
                                    <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">Laporan sedang diperiksa dan diverifikasi oleh petugas terkait.</p>
                                </li>

                                {{-- Step 3: Dalam Pengerjaan --}}
                                <li class="mb-10 ms-6">
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        @if(in_array($complaint->status, ['Pengerjaan', 'Selesai']))
                                            <svg class="w-2.5 h-2.5 text-green-800 dark:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                        @else
                                            <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <h4 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Dalam Pengerjaan
                                        @if($complaint->status == 'Pengerjaan')
                                            <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 ms-3">Saat Ini</span>
                                        @endif
                                    </h4>
                                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Masalah yang dilaporkan sedang dalam proses penanganan oleh tim kami.</p>
                                </li>

                                {{-- Step 4: Selesai --}}
                                <li class="ms-6">
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        @if($complaint->status == 'Selesai')
                                            <svg class="w-2.5 h-2.5 text-purple-800 dark:text-purple-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                        @else
                                            <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <h4 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Selesai
                                        @if($complaint->status == 'Selesai')
                                            <span class="bg-purple-100 text-purple-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300 ms-3">Saat Ini</span>
                                        @endif
                                    </h4>
                                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Pengaduan telah selesai ditangani. Terima kasih atas laporan Anda.</p>
                                </li>
                            </ol>
                        </div>

                        {{-- Deskripsi Lengkap --}}
                        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Lengkap</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $complaint->description }}</p>
                            @if($complaint->location)
                                <p class="mt-4 text-gray-600 text-sm">
                                    Lokasi: <span class="font-medium">{{ $complaint->location }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom Kanan: Galeri Foto dan Tanggapan --}}
                    <div class="lg:col-span-1">
                        {{-- Galeri Foto --}}
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Galeri Foto Aduan</h3>
@if($complaint->photos->isNotEmpty())
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($complaint->photos as $photo)
            <div>
                <a href="{{ asset('storage/' . $photo->path) }}" target="_blank" class="block">
                    <img src="{{ asset('storage/' . $photo->path) }}" 
                         alt="Foto Pengaduan {{ $loop->iteration }}" 
                         class="rounded-lg shadow-sm w-full h-40 object-cover border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                </a>
            </div>
        @endforeach
    </div>
@else
    <p class="text-gray-500 mt-2">Tidak ada foto aduan yang dilampirkan.</p>
@endif

{{-- Tampilkan juga foto KTP jika ada, di bagian terpisah --}}
@if($complaint->user && $complaint->user->ktp_photo)
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Foto KTP Pelapor (Verifikasi)</h3>
        <a href="{{ asset('storage/' . $complaint->user->ktp_photo) }}" target="_blank" class="block">
            <img src="{{ asset('storage/' . $complaint->user->ktp_photo) }}" 
                 alt="Foto KTP Pelapor" 
                 class="rounded-lg shadow-sm w-full h-auto object-cover max-h-64 border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        </a>
    </div>
@endif
                            </div>

                            {{-- Pesan jika tidak ada foto sama sekali --}}
                            @if(!$complaint->photo && (!$complaint->user || !$complaint->user->ktp_photo))
                                <p class="text-gray-500 mt-2">Tidak ada foto yang dilampirkan.</p>
                            @endif
                        </div>

                        {{-- Tanggapan dari Petugas --}}
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Tanggapan dari Petugas</h3>
                            @if($complaint->responses->isNotEmpty()) {{-- Asumsi ada relasi 'responses' --}}
                                @foreach($complaint->responses as $response)
                                    <div class="border-b last:border-b-0 pb-4 mb-4 last:mb-0 last:pb-0">
                                        <p class="text-gray-700 leading-relaxed mb-2">{{ $response->content }}</p>
                                        <p class="text-sm text-gray-500">
                                            Oleh: <span class="font-medium">{{ $response->user->name }}</span> |
                                            {{ \Carbon\Carbon::parse($response->created_at)->format('d F Y') }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Belum ada tanggapan dari petugas.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>