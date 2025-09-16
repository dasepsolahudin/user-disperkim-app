{{-- resources/views/complaints/index.blade.php --}}
<x-app-layout>
    <div class="space-y-6">
        {{-- START: HEADER KUSTOM --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pengaduan Masyarakat</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kelola dan submit pengaduan untuk perbaikan layanan
            </p>
        </div>
        {{-- END: HEADER KUSTOM --}}

        {{-- START: NAVIGASI TAB --}}
        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-sm flex items-center space-x-2">
            {{-- Tombol Aktif --}}
            <span class="w-1/2 text-center py-2 px-4 bg-indigo-600 text-white rounded-md font-semibold text-sm cursor-default">
                <i class="fas fa-list-ul mr-2"></i>
                Daftar Pengaduan
            </span>
            {{-- Tombol Inaktif (Gaya diperbaiki agar sama persis) --}}
            <a href="{{ route('complaints.create') }}" class="w-1/2 text-center py-2 px-4 text-indigo-600 bg-white dark:bg-gray-800 border border-indigo-600 rounded-md font-semibold text-sm hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengaduan
            </a>
        </div>
        {{-- END: NAVIGASI TAB --}}

        {{-- START: FILTER DAN PENCARIAN --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="text" placeholder="Cari pengaduan..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <select class="block w-full pl-3 pr-10 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                        <option>Semua Status</option>
                        <option>Baru</option>
                        <option>Verifikasi</option>
                        <option>Pengerjaan</option>
                        <option>Selesai</option>
                        <option>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
        {{-- END: FILTER DAN PENCARIAN --}}

        {{-- START: DAFTAR PENGADUAN --}}
        <div class="space-y-4">
            @forelse ($complaints as $complaint)
                @php
                    // Logika untuk menentukan warna badge status
                    $statusClass = '';
                    switch ($complaint->status) {
                        case 'Baru':
                            $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                            break;
                        case 'Verifikasi':
                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                            break;
                        case 'Pengerjaan':
                            $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
                            break;
                        case 'Selesai':
                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                            break;
                        case 'Ditolak':
                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                            break;
                        default:
                            $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            break;
                    }
                @endphp
                <a href="{{ route('complaints.show', $complaint->id) }}" class="block">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm transition hover:shadow-md hover:border-indigo-500 border border-transparent">
                        <div class="flex items-start space-x-4">
                            <div class="text-gray-400 dark:text-gray-500 mt-1">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-bold text-gray-800 dark:text-gray-100">
                                        {{ $complaint->title }}
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-md">Tinggi</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ Str::limit($complaint->description, 150) }}
                                </p>
                                <div class="mt-4 flex items-center flex-wrap gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Kategori: <strong>{{ str_replace('_', ' ', $complaint->category) }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $complaint->created_at->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-md {{ $statusClass }}">
                                        {{ $complaint->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-sm text-center">
                    <i class="fas fa-folder-open fa-3x text-gray-300 dark:text-gray-600"></i>
                    <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Anda belum memiliki pengaduan.
                    </p>
                </div>
            @endforelse
        </div>
        {{-- END: DAFTAR PENGADUAN --}}
        
        <div class="mt-6">
            {{ $complaints->links() }}
        </div>
    </div>
</x-app-layout>