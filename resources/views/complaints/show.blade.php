<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto max-w-3xl py-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">

                {{-- Header --}}
                <div class="flex justify-between items-center border-b pb-4">
                    <a href="{{ url()->previous() }}" class="text-sm px-3 py-1 rounded bg-gray-800 text-white">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="font-bold text-lg">Detail Pengaduan</h1>
                    <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                        {{ $complaint->status }}
                    </span>
                </div>

                {{-- Judul --}}
                <div class="mt-4 text-center">
                    <h2 class="text-xl font-bold">{{ $complaint->title }}</h2>
                    <p class="text-sm text-gray-500">
                        Dibuat pada {{ $complaint->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                {{-- Data Pengadu --}}
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Data Pengadu</h3>
                    <<div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                   <p><strong>Nama:</strong> {{ $complaint->user->name }}</p>
                                   {{-- PERUBAHAN DI SINI: Mengambil dari data pengaduan --}}
                                   <p><strong>No. Telp:</strong> {{ $complaint->phone_number ?? 'Tidak dicantumkan' }}</p>
                                </div>
                </div>

                {{-- Lokasi --}}
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Lokasi Kejadian</h3>
                    <div class="text-sm space-y-1">
                        <p><strong>Desa/Kelurahan:</strong> {{ $complaint->village ?? '-' }}</p>
                        <p><strong>Kecamatan:</strong> {{ $complaint->district ?? '-' }}</p>
                        <p><strong>Kabupaten:</strong> {{ $complaint->city ?? '-' }}</p>
                        <p><strong>Sub District:</strong> {{ $complaint->sub_district ?? '-' }}</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Deskripsi</h3>
                    <p class="text-sm whitespace-pre-wrap">
                        {{ $complaint->description }}
                    </p>
                </div>

                {{-- Lampiran --}}
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Lampiran</h3>
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Foto KTP --}}
                        @if(!empty($complaint->foto_ktp))
                            
                        <img src="{{ asset('storage/'.$complaint->foto_ktp) }}" class="rounded shadow" alt="Foto KTP">
                        <div class="mt-6">
                    <h3 class="font-semibold mb-2">poto ktp </h3>
                    <div class="grid grid-cols-2 gap-4">
                        @endif

                        {{-- Foto Aduan --}}
                        @if(!empty($complaint->photos))
                            @foreach($complaint->photos as $photo)
                                <img src="{{ asset('storage/'.$photo->path) }}" class="rounded shadow" alt="Foto Aduan">
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Tanggapan --}}
                <div class="mt-6 border-t pt-4">
                    <h3 class="font-semibold mb-2">Tanggapan Petugas</h3>
                    @if(!empty($complaint->responses) && $complaint->responses->count())
                        @foreach($complaint->responses as $res)
                            <div class="p-3 rounded bg-gray-50 mb-2">
                                <p class="text-sm">{{ $res->response }}</p>
                                <p class="text-xs text-gray-400">{{ $res->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">Belum ada tanggapan.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
