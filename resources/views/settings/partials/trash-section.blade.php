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
            <form action="{{ route('settings.trash.empty') }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengosongkan sampah? Semua berkas di dalamnya akan dihapus permanen.');">
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
                $daysRemaining = round(now()->diffInDays($complaint->deleted_at->addDays(30), false));
                // Ambil foto pertama sebagai thumbnail, atau gunakan placeholder jika tidak ada foto
                $thumbnail = $complaint->photos->first()->path ?? null;
            @endphp
            <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 p-4 rounded-lg flex items-center gap-4 transition hover:shadow-sm hover:border-gray-300 dark:hover:border-gray-600">
                
                @if($thumbnail)
                    <img src="{{ asset('storage/' . $thumbnail) }}" alt="Thumbnail" class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                @else
                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-md flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-alt fa-lg text-gray-500"></i>
                    </div>
                @endif

                <div class="flex-grow">
                    <p class="font-semibold text-gray-800 dark:text-gray-100">{{ Str::limit($complaint->title, 60) }}</p>
                    <div class="flex items-center flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span>Dihapus: {{ $complaint->deleted_at->format('Y-m-d') }}</span>
                        @if($daysRemaining >= 0)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ $daysRemaining }} hari tersisa
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    {{-- PERBAIKAN: MENAMBAHKAN TOMBOL DETAIL --}}
                    <a href="{{ route('settings.trash.show', $complaint->id) }}" title="Lihat Detail" class="w-9 h-9 flex items-center justify-center rounded-md text-gray-500 hover:bg-blue-100 hover:text-blue-600 dark:hover:bg-blue-900 dark:hover:text-blue-400 transition">
                        <i class="fas fa-eye"></i>
                    </a>

                    <form action="{{ route('settings.trash.restore', $complaint->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('PUT')
                        <button type="submit" title="Pulihkan" class="w-9 h-9 flex items-center justify-center rounded-md text-gray-500 hover:bg-green-100 hover:text-green-600 dark:hover:bg-green-900 dark:hover:text-green-400 transition">
                            <i class="fas fa-undo"></i>
                        </button>
                    </form>
                    <form action="{{ route('settings.trash.forceDelete', $complaint->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pengaduan ini secara permanen?');" class="m-0">
                        @csrf
                        @method('DELETE')
                         <button type="submit" title="Hapus Permanen" class="w-9 h-9 flex items-center justify-center rounded-md text-gray-500 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900 dark:hover:text-red-400 transition">
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

