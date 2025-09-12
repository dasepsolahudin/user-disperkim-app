<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="mt-1 text-gray-600">Selamat datang di sistem Disperkim</p>
        </div>
        <div>
            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Online
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ringkasan Laporan</p>
                        <p class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-chart-line text-green-600"></i> Total: {{ $stats['total'] ?? 0 }} laporan
                        </p>
                    </div>
                    <div class="bg-gray-100 text-gray-600 p-3 rounded-full">
                        <i class="fas fa-file-invoice fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['in_progress'] ?? 0 }}</p>
                        <p class="mt-1 text-sm font-medium text-gray-500">Dalam Proses</p>
                    </div>
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <i class="fas fa-hourglass-half fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Aksi Cepat</p>
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

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800">Riwayat Laporan</h3>
                    <p class="text-sm text-gray-500 mt-1">Lihat semua laporan yang pernah Anda buat dan pantau statusnya.</p>
                    <a href="{{ route('complaints.index') }}" class="text-sm text-green-600 font-semibold mt-4 inline-block hover:underline">
                        Lihat Riwayat &rarr;
                    </a>
                </div>
                <div class="flex items-center">
                    <span class="text-lg font-bold text-green-600 mr-4">{{ $stats['total'] ?? 0 }} Total</span>
                    <div class="bg-green-100 text-green-600 p-4 rounded-full">
                        <i class="fas fa-history fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
               <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Pengaturan Akun</h3>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Lengkap</span>
                </div>
                <div class="bg-gray-50 text-gray-600 p-4 rounded-lg border">
                    <i class="fas fa-user-shield text-green-600 mr-2"></i>
                    <p class="text-sm inline">Perbarui informasi data diri dan password Anda untuk keamanan akun.</p>
                </div>
                {{-- KODE YANG DIPERBAIKI --}}
                <a href="{{ route('settings.edit') }}" class="w-full mt-4 inline-block text-center bg-gray-200 text-gray-700 font-semibold text-sm px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Buka Pengaturan &rarr;
                </a>
            </div>
        </div>
    </div>
</x-app-layout>