<x-app-layout>
    <div class="space-y-6">

        {{-- HEADER HALAMAN BARU --}}
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt fa-lg text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Detail Pengaduan Masyarakat
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Rincian lengkap dari laporan yang telah dibuat.
                </p>
            </div>
        </div>
        
        {{-- KARTU JUDUL PENGADUAN BARU --}}
<div class="bg-blue-50 dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-blue-200 dark:border-gray-700">
             <div class="bg-blue-50 dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-blue-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    {{-- PERBAIKAN: Mengubah link menjadi tombol berkolom --}}
                     <a href="{{ route('pengaduan.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 dark:bg-blue-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 dark:hover:bg-blue-800 transition shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">ke Daftar</span>
                    </a>

                    <div class="w-px h-6 bg-blue-200 dark:bg-gray-600 hidden sm:block"></div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $complaint->title }}</h2>
                    </div>
                </div>
                @if($complaint->priority)
                    @php
                        // Logika baru untuk menentukan warna dan ikon berdasarkan prioritas
                        $priorityInfo = match ($complaint->priority) {
                            'Tinggi' => [
                                'class' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-500/50',
                                'icon' => 'fas fa-exclamation-circle'
                            ],
                            'Sedang' => [
                                'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-500/50',
                                'icon' => 'fas fa-clock'
                            ],
                            'Rendah' => [
                                'class' => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-500/50',
                                'icon' => 'fas fa-check-circle'
                            ],
                            default => [
                                'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600',
                                'icon' => 'fas fa-info-circle'
                            ],
                        };
                    @endphp
                    <div class="mt-3 sm:mt-0 px-3 py-1 text-xs font-semibold rounded-full flex items-center gap-2 {{ $priorityInfo['class'] }}">
                        <i class="{{ $priorityInfo['icon'] }}"></i>
                        <span>Prioritas {{ $complaint->priority }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- KONTEN UTAMA DENGAN DESAIN BARU --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- KOLOM KIRI (2/3) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Card: Deskripsi --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                     <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-3">
                        <i class="fas fa-file-alt text-gray-400"></i>
                        <span>Deskripsi Pengaduan</span>
                    </h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $complaint->description }}</p>
                </div>
                
                {{-- Card: Foto Lampiran --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-3">
                        <i class="fas fa-images text-gray-400"></i>
                        <span>Foto Lampiran</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Foto Bukti</p>
                            @if($complaint->photos->isNotEmpty())
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($complaint->photos as $photo)
                                    <a href="{{ asset('storage/' . $photo->path) }}" target="_blank" class="block group">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto Bukti" class="rounded-lg object-cover w-full h-40 hover:opacity-80 transition shadow-md">
                                    </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center justify-center h-40 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-sm text-gray-500">
                                    Tidak ada foto bukti.
                                </div>
                            @endif
                        </div>
                        <div>
                             <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Foto KTP</p>
                             @if($complaint->foto_ktp)
                                <a href="{{ asset('storage/' . $complaint->foto_ktp) }}" target="_blank" class="block group">
                                    <img src="{{ asset('storage/' . $complaint->foto_ktp) }}" alt="Foto KTP" class="rounded-lg object-contain w-full h-40 hover:opacity-80 transition shadow-md bg-gray-50 dark:bg-gray-700/50 p-1">
                                </a>
                            @else
                                 <div class="flex items-center justify-center h-40 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-sm text-gray-500">
                                    Tidak ada foto KTP.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Card: Riwayat Tanggapan --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-3">
                        <i class="far fa-comments text-gray-400"></i>
                        <span>Riwayat Tanggapan</span>
                    </h3>
                    <div class="space-y-4">
                        @forelse ($complaint->responses as $response)
                            <div class="bg-blue-50 dark:bg-gray-700/50 p-4 rounded-lg shadow-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-semibold text-sm text-blue-800 dark:text-blue-300">{{ $response->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $response->created_at->format('Y-m-d') }}</p>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $response->content }}
                                </p>
                            </div>
                        @empty
                             <div class="text-center py-6">
                                <i class="far fa-clock fa-2x text-gray-300 dark:text-gray-600"></i>
                                <p class="mt-2 text-sm text-gray-500">Belum ada tanggapan dari petugas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (1/3) --}}
            <div class="space-y-6">
                {{-- Card: Informasi Pengaduan --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                     <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-3">
                        <i class="fas fa-info-circle text-gray-400"></i>
                        <span>Informasi Pengaduan</span>
                    </h3>
                    @php
                        $statusInfo = match ($complaint->status) {
                            'Selesai' => ['class' => 'text-green-600 dark:text-green-400', 'icon' => 'fas fa-check-circle'],
                            'Pengerjaan' => ['class' => 'text-orange-600 dark:text-orange-400', 'icon' => 'fas fa-sync-alt'],
                            'Verifikasi' => ['class' => 'text-yellow-600 dark:text-yellow-400', 'icon' => 'fas fa-user-check'],
                            'Ditolak' => ['class' => 'text-red-600 dark:text-red-400', 'icon' => 'fas fa-times-circle'],
                            default => ['class' => 'text-blue-600 dark:text-blue-400', 'icon' => 'fas fa-paper-plane'],
                        };
                    @endphp
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tanggal Lapor</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $complaint->created_at->format('d F Y') }}</p>
                        </div>
                         <div>
                            <p class="text-gray-500 dark:text-gray-400">Kategori</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100 capitalize">{{ str_replace('_', ' ', $complaint->category) }}</p>
                        </div>
                         <div>
                            <p class="text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-medium flex items-center gap-2 {{ $statusInfo['class'] }}">
                                <i class="{{ $statusInfo['icon'] }}"></i>
                                <span>{{ $complaint->status }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                {{-- Card: Informasi Pelapor --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-3">
                        <i class="fas fa-user-circle text-gray-400"></i>
                        <span>Informasi Pelapor</span>
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Nama</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $complaint->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Telepon</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $complaint->phone_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card: Alamat Lokasi --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        <span>Alamat Lokasi</span>
                    </h3>
                    @php
                        $addressParts = [
                            $complaint->kampung,
                            $complaint->rt_rw ? 'RT/RW ' . $complaint->rt_rw : '',
                            $complaint->desa ? 'Desa ' . $complaint->desa : '',
                            $complaint->kecamatan ? 'Kec. ' . $complaint->kecamatan : '',
                            $complaint->kabupaten ? 'Kab. ' . $complaint->kabupaten : '',
                        ];
                        $fullAddress = implode(', ', array_filter($addressParts));
                    @endphp
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $fullAddress ?: ($complaint->location_text ?? '-') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>