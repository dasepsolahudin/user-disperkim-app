<x-app-layout>
    {{-- Hapus header default untuk header kustom --}}
    <x-slot name="header"></x-slot>

    <div class="space-y-6">
        {{-- START: HEADER KUSTOM DENGAN TOMBOL KEMBALI --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('complaints.index') }}" class="flex items-center gap-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Pengaduan
            </a>
        </div>
        {{-- END: HEADER KUSTOM --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- START: KOLOM UTAMA (KIRI) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- KARTU DETAIL PENGADUAN --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-semibold rounded-full capitalize">
                                {{ str_replace('_', ' ', $complaint->category) }}
                            </span>
                            <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                {{ $complaint->title }}
                            </h1>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:text-right flex-shrink-0">
                             @php
                                $statusClass = '';
                                switch ($complaint->status) {
                                    case 'Baru': $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-500/30'; break;
                                    case 'Verifikasi': $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-500/30'; break;
                                    case 'Pengerjaan': $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300 border border-orange-200 dark:border-orange-500/30'; break;
                                    case 'Selesai': $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-500/30'; break;
                                    case 'Ditolak': $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-500/30'; break;
                                    default: $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'; break;
                                }
                            @endphp
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status Laporan</p>
                            <span class="px-2.5 py-1 text-sm font-semibold rounded-md {{ $statusClass }}">
                                {{ $complaint->status }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-6 space-y-6">
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <i class="fas fa-file-alt text-gray-400"></i> Rincian Laporan
                            </h3>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $complaint->description }}
                            </p>
                        </div>
                         <div>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-gray-400"></i> Lokasi Spesifik
                            </h3>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ $complaint->location_text }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $complaint->sub_district }}, {{ $complaint->village }}, {{ $complaint->district }}, {{ $complaint->city }}</p>
                        </div>
                    </div>
                </div>

                {{-- KARTU TANGGAPAN DARI PETUGAS --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-4">Tanggapan dari Petugas</h3>
                    <div class="space-y-4">
                        @forelse ($complaint->responses as $response)
                            <div class="flex items-start gap-4">
                                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($response->user->name) }}&background=0D8ABC&color=fff" alt="{{ $response->user->name }}">
                                <div class="flex-1 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $response->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $response->created_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $response->message }}
                                    </p>
                                </div>
                            </div>
                        @empty
                             <div class="text-center py-8">
                                <i class="fas fa-comment-slash fa-2x text-gray-300 dark:text-gray-600"></i>
                                <p class="mt-3 text-sm text-gray-500">Belum ada tanggapan dari petugas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- END: KOLOM UTAMA (KIRI) --}}

            {{-- START: KOLOM SISI (KANAN) --}}
            <div class="space-y-6">
                {{-- KARTU INFORMASI PELAPOR --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm">
                    <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-4 border-b dark:border-gray-700 pb-3">Informasi Pelapor</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $complaint->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $complaint->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Asal Desa:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $complaint->user->village ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kecamatan:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $complaint->user->district ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- KARTU LAMPIRAN --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm">
                    <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-4 border-b dark:border-gray-700 pb-3">Lampiran</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">Foto Bukti</h4>
                            @if($complaint->photos->isNotEmpty())
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($complaint->photos as $photo)
                                        <a href="{{ asset('storage/' . $photo->path) }}" target="_blank" class="block relative group">
                                            <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto Aduan" class="rounded-md w-full h-20 object-cover transition transform group-hover:scale-105">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-gray-500">Tidak ada foto bukti.</p>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">Foto KTP</h4>
                            @if ($complaint->user->ktp_photo)
                                <a href="{{ asset('storage/' . $complaint->user->ktp_photo) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $complaint->user->ktp_photo) }}" alt="Foto KTP" class="rounded-md w-full object-contain transition transform hover:scale-105">
                                </a>
                            @else
                                <p class="text-xs text-gray-500">Tidak ada KTP dilampirkan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- END: KOLOM SISI (KANAN) --}}
        </div>
    </div>
</x-app-layout>