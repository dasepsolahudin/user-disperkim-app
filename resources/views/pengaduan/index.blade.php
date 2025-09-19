<x-app-layout>
    <div class="space-y-6">
        {{-- START: HEADER KUSTOM --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pengaduan Saya</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Lihat dan kelola semua laporan yang Anda buat.
            </p>
        </div>
        {{-- END: HEADER KUSTOM --}}

        {{-- START: NAVIGASI TAB --}}
        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-sm flex items-center space-x-2">
            <span class="w-1/2 text-center py-2 px-4 bg-indigo-600 text-white rounded-md font-semibold text-sm cursor-default">
                <i class="fas fa-list-ul mr-2"></i>
                Daftar Pengaduan
            </span>
            <a href="{{ route('complaints.create') }}" class="w-1/2 text-center py-2 px-4 text-indigo-600 bg-white dark:bg-gray-800 border border-indigo-600 rounded-md font-semibold text-sm hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengaduan
            </a>
        </div>
        {{-- END: NAVIGASI TAB --}}

        {{-- START: DAFTAR PENGADUAN --}}
        <div class="space-y-4">
            @forelse ($complaints as $complaint)
                @php
                    $statusClass = '';
                    switch ($complaint->status) {
                        case 'Baru': $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'; break;
                        case 'Verifikasi': $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'; break;
                        case 'Pengerjaan': $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300'; break;
                        case 'Selesai': $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'; break;
                        case 'Ditolak': $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'; break;
                        default: $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'; break;
                    }
                @endphp
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-transparent hover:shadow-md hover:border-indigo-500 transition">
                    <div class="flex items-start space-x-4">
                        <div class="text-gray-400 dark:text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-gray-800 dark:text-gray-100">
                                    {{ Str::limit($complaint->title, 50) }}
                                </h3>
                                <span class="px-2 py-0.5 text-xs font-semibold text-red-800 bg-red-100 rounded-md">
                                    {{ $complaint->priority ?? 'Sedang' }}
                                </span>
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
                            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex items-center space-x-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <a href="{{ route('pengaduan.show', $complaint->id) }}" 
                                       class="px-3 py-1 rounded-full text-blue-800 bg-blue-100 text-xs font-semibold hover:bg-blue-200 transition">
                                        Lihat Detail
                                    </a>
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('complaints.edit', $complaint->id) }}" 
                                       class="px-3 py-1 rounded-full text-green-800 bg-green-100 text-xs font-semibold hover:bg-green-200 transition">
                                        Edit
                                    </a>
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus pengaduan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="px-3 py-1 rounded-full text-red-800 bg-red-100 text-xs font-semibold hover:bg-red-200 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        
        @if ($complaints->hasPages())
            <div class="mt-6">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</x-app-layout>