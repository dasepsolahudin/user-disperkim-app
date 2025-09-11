<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2 text-gray-600">Anda dapat mengelola semua laporan dan pengaduan Anda di sini.</p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Laporan Saya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h4 class="text-4xl font-bold text-gray-800">{{ $stats['total'] }}</h4>
                        <p class="mt-2 font-semibold text-gray-600">Total Laporan</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h4 class="text-4xl font-bold text-yellow-500">{{ $stats['in_progress'] }}</h4>
                        <p class="mt-2 font-semibold text-gray-600">Dalam Proses</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h4 class="text-4xl font-bold text-green-600">{{ $stats['completed'] }}</h4>
                        <p class="mt-2 font-semibold text-gray-600">Selesai</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('complaints.create') }}" class="block p-6 bg-green-600 text-white rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <h4 class="font-bold text-xl mb-2">Buat Pengaduan Baru</h4>
                        <p class="text-green-100 mb-4">Laporkan masalah atau keluhan Anda sekarang.</p>
                        <span class="font-semibold inline-block">Akses Layanan &rarr;</span>
                    </a>
                     <a href="#" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border">
                        <h4 class="font-bold text-xl mb-2 text-gray-800">Riwayat Laporan</h4>
                        <p class="text-gray-600 mb-4">Lihat semua laporan yang pernah Anda buat.</p>
                        <span class="font-semibold text-green-600">Lihat Riwayat &rarr;</span>
                    </a>
                     <a href="{{ route('profile.edit') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border">
                        <h4 class="font-bold text-xl mb-2 text-gray-800">Profil Saya</h4>
                        <p class="text-gray-600 mb-4">Perbarui informasi data diri dan password Anda.</p>
                        <span class="font-semibold text-green-600">Atur Profil &rarr;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>