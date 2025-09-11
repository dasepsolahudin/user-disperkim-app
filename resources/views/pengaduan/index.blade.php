@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Halaman Pengaduan</h1>
        <p class="mt-1 text-gray-600">Silakan kelola dan buat pengaduan di sini.</p>
    </div>

    {{-- Aksi Cepat --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
            <div>
                <h2 class="text-sm text-gray-500">Aksi Cepat</h2>
                <a href="{{ route('pengaduan.create') }}" 
                   class="mt-2 inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Buat Laporan Baru
                </a>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-lightning-charge text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Daftar Pengaduan (opsional kalau sudah ada data) --}}
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Daftar Pengaduan</h2>
        <p class="text-gray-500 text-sm">Belum ada data pengaduan.</p>
    </div>
</div>
@endsection
