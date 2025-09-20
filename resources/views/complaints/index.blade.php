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
            <a href="{{ route('complaints.create') }}" class="w-1/2 text-center py-2 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
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
                    $priorityClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                    switch ($complaint->status) {
                        case 'Baru': $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'; break;
                        case 'Verifikasi': $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300'; break;
                        case 'Pengerjaan': $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300'; break;
                        case 'Selesai': $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'; break;
                        case 'Ditolak': $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'; break;
                    }
                    switch ($complaint->priority) {
                        case 'Tinggi': $priorityClass = 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'; break;
                        case 'Sedang': $priorityClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300'; break;
                        case 'Rendah': $priorityClass = 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'; break;
                    }
                @endphp
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700/50 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mt-1">
                             <i class="fas fa-bullhorn text-gray-500"></i>
                        </div>
                        <div class="flex-1">
                            {{-- Baris Atas: Judul dan Prioritas --}}
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-gray-800 dark:text-gray-100">
                                    {{ Str::limit($complaint->title, 60) }}
                                </h3>
                                @if($complaint->priority)
                                <span class="px-2.5 py-0.5 text-xs font-semibold capitalize rounded-full {{ $priorityClass }}">
                                    {{ $complaint->priority }}
                                </span>
                                @endif
                            </div>
                            
                            {{-- Deskripsi Singkat --}}
                             <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::limit($complaint->description, 120) }}
                            </p>

                            {{-- Baris Bawah: Kategori, Tanggal, Status --}}
                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400">
                               <span class="capitalize">Kategori: <strong>{{ str_replace('_', ' ', $complaint->category) }}</strong></span>
                               <span>•</span>
                               <span>{{ $complaint->created_at->format('d M Y') }}</span>
                               <span>•</span>
                               <span class="px-2 py-0.5 font-semibold rounded-md {{ $statusClass }}">
                                    {{ $complaint->status }}
                               </span>
                            </div>

                            {{-- Aksi --}}
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('pengaduan.show', $complaint->id) }}" 
                                       class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat Detail</span>
                                    </a>
                                    {{-- Tombol Edit Dihilangkan Sesuai Permintaan --}}
                                    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 dark:bg-red-900/50 dark:text-red-300 dark:hover:bg-red-900 transition">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Hapus</span>
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
