<section>
    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <div class="flex-shrink-0 w-12 h-12 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
            <i class="fas fa-trash-alt fa-xl text-orange-500 dark:text-orange-400"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Sampah') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Kelola berkas yang dihapus sementara. Berkas akan dihapus permanen setelah 30 hari.') }}
            </p>
        </div>
    </div>

    {{-- BADGE JUMLAH & TOMBOL KOSONGKAN SAMPAH --}}
    <div class="flex items-center justify-between mt-6">
        <span class="px-3 py-1 text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full">
            {{ $trashedComplaints->total() }} berkas
        </span>
        
        @if($trashedComplaints->total() > 0)
            {{-- PERBAIKAN: Mengubah nama rute menjadi 'trash.empty' --}}
            <form action="{{ route('trash.empty') }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengosongkan sampah? Semua berkas di dalamnya akan dihapus permanen.');">
                @csrf
                @method('DELETE')
                <x-danger-button>
                    <i class="fas fa-trash-alt mr-2"></i>
                    Kosongkan Sampah
                </x-danger-button>
            </form>
        @endif
    </div>

    {{-- DAFTAR BERKAS YANG DIHAPUS --}}
    <div class="mt-4 space-y-3">
        @forelse ($trashedComplaints as $complaint)
            @php
                $daysRemaining = now()->diffInDays($complaint->deleted_at->addDays(30), false);
            @endphp
            <div class="bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 p-4 rounded-lg flex items-center gap-4 transition hover:shadow-md hover:border-orange-500/50 dark:hover:border-orange-500/50">
                
                {{-- Logika untuk menampilkan ikon berdasarkan judul --}}
                @php
                    $titleLower = strtolower($complaint->title);
                    if (Str::contains($titleLower, ['pdf'])) {
                        $iconClass = 'fas fa-file-pdf text-blue-500';
                    } elseif (Str::contains($titleLower, ['foto', 'gambar', 'infrastruktur', 'jalan'])) {
                        $iconClass = 'fas fa-image text-green-500';
                    } elseif (Str::contains($titleLower, ['data', 'laporan', 'masyarakat'])) {
                        $iconClass = 'fas fa-file-excel text-green-600';
                    } else {
                        $iconClass = 'fas fa-file-alt text-gray-500';
                    }
                @endphp
                <i class="{{ $iconClass }} fa-2x w-8 text-center"></i>

                <div class="flex-grow">
                    <p class="font-semibold text-gray-800 dark:text-gray-100">{{ Str::limit($complaint->title, 60) }}</p>
                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span>Dihapus: {{ $complaint->deleted_at->format('Y-m-d') }}</span>
                        @if($daysRemaining >= 0)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ $daysRemaining }} hari tersisa
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Tombol Pulihkan --}}
                    {{-- PERBAIKAN: Mengubah nama rute menjadi 'trash.restore' --}}
                    <form action="{{ route('trash.restore', $complaint->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('PUT')
                        <button type="submit" title="Pulihkan" class="w-8 h-8 flex items-center justify-center rounded-md text-gray-500 hover:bg-green-100 hover:text-green-600 dark:hover:bg-green-900 dark:hover:text-green-400 transition">
                            <i class="fas fa-undo"></i>
                        </button>
                    </form>
                    {{-- Tombol Hapus Permanen --}}
                    {{-- PERBAIKAN: Mengubah nama rute menjadi 'trash.forceDelete' --}}
                    <form action="{{ route('trash.forceDelete', $complaint->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pengaduan ini secara permanen?');" class="m-0">
                        @csrf
                        @method('DELETE')
                         <button type="submit" title="Hapus Permanen" class="w-8 h-8 flex items-center justify-center rounded-md text-gray-500 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900 dark:hover:text-red-400 transition">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 px-6 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                <i class="fas fa-trash fa-3x text-gray-300 dark:text-gray-600"></i>
                <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">Sampah Anda kosong.</p>
            </div>
        @endforelse
    </div>

    @if ($trashedComplaints->hasPages())
        <div class="mt-6">
            {{ $trashedComplaints->links() }}
        </div>
    @endif

    {{-- KOTAK INFORMASI PENTING --}}
    <div class="mt-8 p-4 border-l-4 border-orange-400 bg-orange-50 dark:bg-orange-900/20 text-orange-800 dark:text-orange-300 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-3 text-orange-500"></i>
            <h4 class="font-bold">Informasi Penting</h4>
        </div>
        <ul class="mt-2 text-sm list-disc list-inside space-y-1 pl-8">
            <li>Berkas akan dihapus permanen setelah 30 hari.</li>
            <li>Anda dapat memulihkan berkas kapan saja sebelum batas waktu.</li>
            <li>Berkas yang dihapus permanen tidak dapat dipulihkan.</li>
            <li>Sampah akan dikosongkan otomatis setiap bulan.</li>
        </ul>
    </div>
</section>

