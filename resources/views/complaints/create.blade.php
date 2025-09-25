{{-- resources/views/complaints/create.blade.php --}}
<x-app-layout>
    {{-- PERUBAHAN DI SINI: Judul dipindahkan ke header --}}
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
            <i class="fas fa-plus-circle text-indigo-500"></i>
            <span>Buat Pengaduan Baru</span>
        </h1>
    </x-slot>

    <div class="space-y-6">
        {{-- Header kustom lama dihapus dari sini --}}

        {{-- START: NAVIGASI TAB --}}
        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-sm flex items-center space-x-2">
            {{-- Tombol Inaktif --}}
            <a href="{{ route('complaints.index') }}" class="w-1/2 text-center py-2 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="fas fa-list-ul mr-2"></i>
                Daftar Pengaduan
            </a>
            {{-- Tombol Aktif --}}
            <span class="w-1/2 text-center py-2 px-4 bg-indigo-600 text-white rounded-md font-semibold text-sm cursor-default">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengaduan
            </span>
        </div>
        {{-- END: NAVIGASI TAB --}}

        {{-- KONTEN ASLI HALAMAN CREATE --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Silakan pilih jenis layanan pengaduan yang Anda butuhkan:</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Daftar Kategori dengan ikon baru --}}
                    <a href="{{ route('complaints.form', ['category' => 'rutilahu']) }}" class="block p-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-house-damage text-lg text-red-500"></i>
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Pengaduan Rutilahu</h4>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Laporan terkait Rumah Tidak Layak Huni.</p>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Pilih Kategori &rarr;</span>
                    </a>
                    <a href="{{ route('complaints.form', ['category' => 'infrastruktur']) }}" class="block p-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-road text-lg text-yellow-500"></i>
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Pengaduan Infrastruktur</h4>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Laporan terkait jalan, drainase, dan fasilitas umum.</p>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Pilih Kategori &rarr;</span>
                    </a>
                    <a href="{{ route('complaints.form', ['category' => 'tata_kota']) }}" class="block p-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-city text-lg text-blue-500"></i>
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Pengaduan Tata Kota</h4>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Laporan terkait pelanggaran tata ruang dan perizinan.</p>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Pilih Kategori &rarr;</span>
                    </a>
                    <a href="{{ route('complaints.form', ['category' => 'air_bersih_sanitasi']) }}" class="block p-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-tint text-lg text-cyan-500"></i>
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Air Bersih & Sanitasi</h4>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Laporan terkait masalah air bersih dan sanitasi.</p>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Pilih Kategori &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>