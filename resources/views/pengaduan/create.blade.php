@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">Buat Laporan Baru</h1>
    <form action="{{ route('pengaduan.store') }}" method="POST" class="mt-4 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium">Judul Laporan</label>
            <input type="text" name="judul" class="w-full border rounded-lg p-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Isi Laporan</label>
            <textarea name="isi" rows="4" class="w-full border rounded-lg p-2" required></textarea>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
            Simpan
        </button>
    </form>
</div>
@endsection
