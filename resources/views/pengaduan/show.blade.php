<x-app-layout>
    <div class="space-y-6">

        {{-- START: HEADER UTAMA --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pengaduan Masyarakat</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kelola dan submit pengaduan untuk perbaikan layanan
            </p>
        </div>
        {{-- END: HEADER UTAMA --}}

        {{-- START: NAVIGASI TAB --}}
        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-sm flex items-center space-x-2">
            <a href="{{ route('complaints.index') }}" class="w-1/2 text-center py-2 px-4 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                <i class="fas fa-list-ul mr-2"></i>
                Daftar Pengaduan
            </a>
            <a href="{{ route('complaints.create') }}" class="w-1/2 text-center py-2 px-4 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengaduan
            </a>
        </div>
        {{-- END: NAVIGASI TAB --}}
        
        {{-- START: KARTU JUDUL PENGADUAN --}}
        <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('complaints.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">Kembali ke Daftar</span>
                    </a>
                    <div class="w-px h-6 bg-gray-200 dark:bg-gray-600 hidden sm:block"></div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Detail lengkap pengaduan dan riwayat penanganan</p>
                    </div>
                </div>
                @if($complaint->priority)
                    @php
                        $priorityClass = match ($complaint->priority) {
                            'Tinggi' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                            'Sedang' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                            'Rendah' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        };
                    @endphp
                    <div class="mt-3 sm:mt-0 px-3 py-1 text-xs font-semibold rounded-full {{ $priorityClass }}">
                        Prioritas {{ $complaint->priority }}
                    </div>
                @endif
            </div>
        </div>
        {{-- END: KARTU JUDUL PENGADUAN --}}

        {{-- START: KONTEN UTAMA --}}
        <div class="space-y-6">
            {{-- START: BARIS 1 --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Card: Informasi Pelapor --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-gray-400"></i>
                        Informasi Pelapor
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
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        Alamat Lokasi
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
            {{-- END: BARIS 1 --}}

            {{-- START: BARIS 2 --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Card: Informasi Pengaduan --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                     <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-gray-400"></i>
                        Informasi Pengaduan
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
                            <p class="text-gray-500 dark:text-gray-400">Tanggal</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $complaint->created_at->format('Y-m-d') }}</p>
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

                {{-- Card: Deskripsi --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                     <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fas fa-file-alt text-gray-400"></i>
                        Deskripsi Pengaduan
                    </h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $complaint->description }}</p>
                </div>
            </div>
            {{-- END: BARIS 2 --}}
            
            {{-- Card: Foto Lampiran --}}
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                    <i class="fas fa-images text-gray-400"></i>
                    Foto Lampiran
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
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                    <i class="far fa-comments text-gray-400"></i>
                    Riwayat Tanggapan
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
        {{-- END: KONTEN UTAMA --}}
    </div>
</x-app-layout>

