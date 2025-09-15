<x-app-layout>
    {{-- Bagian Header (tetap sama) --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Selamat datang di sistem Disperkim</p>
        </div>
        <div>
            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Online
            </span>
        </div>
    </div>

    {{-- 
        ============================================================
        PERBAIKAN UTAMA:
        Struktur grid dirombak menjadi lebih sederhana dan mobile-first.
        Semua kartu sekarang berada dalam satu alur yang responsif.
        ============================================================
    --}}
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Laporan</p>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 p-3 rounded-full">
                    <i class="fas fa-file-invoice fa-lg"></i>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dalam Proses</p>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['in_progress'] ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-hourglass-half fa-lg"></i>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aksi Cepat</p>
                    <a href="{{ route('complaints.create') }}" 
                       class="mt-2 inline-block bg-green-600 text-white font-semibold text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition">
                         Buat Laporan Baru
                    </a>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-bolt fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Riwayat Laporan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lihat semua laporan Anda.</p>
                    </div>
                    <div class="bg-green-100 text-green-600 p-4 rounded-full">
                        <i class="fas fa-history fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('complaints.index') }}" class="text-sm text-green-600 font-semibold mt-4 inline-block hover:underline">
                    Lihat Riwayat &rarr;
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Pengaturan Akun</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui data diri & password.</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 p-4 rounded-full">
                        <i class="fas fa-user-cog fa-lg"></i>
                    </div>
                </div>
                {{-- Menggunakan route('settings.edit') yang benar --}}
                <a href="{{ route('settings.edit', 'profile') }}" class="text-sm text-gray-600 dark:text-gray-400 font-semibold mt-4 inline-block hover:underline">
                    Buka Pengaturan &rarr;
                </a>
            </div>
        </div>
    </div>
</x-app-layout>