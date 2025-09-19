<x-app-layout>
    {{-- Mengosongkan header default --}}
    <x-slot name="header"></x-slot>

    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto max-w-4xl">

            <div class="p-4">
                {{-- KOTAK KONTEN UTAMA --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">

                    {{-- BAGIAN 1: HEADER --}}
                    <div class="flex items-center justify-between pb-5 border-b border-gray-200 dark:border-gray-700">
                        <a href="{{ url()->previous() }}" class="flex items-center gap-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-700 dark:hover:bg-white transition shadow-md">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                        
                        <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 text-center">
                            Detail Pengaduan
                        </h1>

                        @php
                            $statusInfo = match ($complaint->status) {
                                'Selesai' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300', 'icon' => 'fas fa-check-circle'],
                                'Pengerjaan' => ['class' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300', 'icon' => 'fas fa-sync-alt fa-spin'],
                                'Verifikasi' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300', 'icon' => 'fas fa-user-check'],
                                default => ['class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300', 'icon' => 'fas fa-paper-plane'],
                            };
                        @endphp
                        <span class="flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full {{ $statusInfo['class'] }}">
                            <i class="{{ $statusInfo['icon'] }}"></i>
                            {{ $complaint->status }}
                        </span>
                    </div>

                    {{-- BAGIAN 2: DETAIL PENGADUAN --}}
                    <div class="pt-6 space-y-8">
                        
                        {{-- Judul dan Info Ringkas --}}
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h2>
                            <div class="mt-3 flex flex-wrap justify-center items-center gap-x-6 gap-y-2 text-sm text-gray-500 dark:text-gray-400">
                                @if($complaint->category)
                                <span class="flex items-center gap-2 capitalize"><i class="fas fa-tags"></i> {{ str_replace('_', ' ', $complaint->category) }}</span>
                                @endif
                                <span class="flex items-center gap-2"><i class="fas fa-calendar-alt"></i> Dibuat pada {{ $complaint->created_at->format('d M Y, H:i') }}</span>
                                @if($complaint->priority)
                                <span class="flex items-center gap-2 capitalize"><i class="fas fa-exclamation-triangle"></i> Prioritas: {{ $complaint->priority }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Info Pengadu dan Lokasi --}}
                        <div class="grid md:grid-cols-2 gap-8">
                            {{-- KOLOM KIRI: INFO PENGADU --}}
                            
                                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                   <p><strong>Nama:</strong> {{ $complaint->user->name }}</p>
                                   <p><strong>No. Telp:</strong> {{ $complaint->user->phone_number ?? 'Tidak ada' }}</p>
                                   <p><strong>Alamat KTP:</strong> {{ $complaint->user->address ?? 'Tidak ada' }}</p>
                                </div>
                            </div>
                            {{-- KOLOM KANAN: LOKASI KEJADIAN --}}
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2 text-lg">
                                    <i class="fas fa-map-marked-alt text-gray-400"></i>
                                    Lokasi Kejadian
                                </h3>
                                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                    <p><strong>Alamat Lengkap:</strong> {{ $complaint->address }}</p>
                                    <p><strong>RT/RW:</strong> {{ $complaint->rt }}/{{ $complaint->rw }}</p>
                                    <p><strong>Kampung:</strong> {{ $complaint->kampung }}</p>
                                    <p><strong>Desa/Kelurahan:</strong> {{ $complaint->village }}</p>
                                    <p><strong>Kecamatan:</strong> {{ $complaint->sub_district }}</p>
                                    <p><strong>Kabupaten:</strong> {{ $complaint->district }}</p>
                                    @if($complaint->location_text)<p class="pt-2"><strong>Patokan:</strong> {{ $complaint->location_text }}</p>@endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Deskripsi Pengaduan --}}
                        <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                             <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2 text-lg">
                                <i class="fas fa-file-alt text-gray-400"></i>
                                Deskripsi Laporan
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">
                                {{ $complaint->description }}
                            </p>
                        </div>
                    </div>

                    {{-- BAGIAN 3: LAMPIRAN FOTO --}}
                    @if($complaint->photos->isNotEmpty() || $complaint->user->ktp_photo)
                    <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Lampiran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @if($complaint->photos->isNotEmpty())
                            <div>
                                <h4 class="text-md font-medium text-gray-600 dark:text-gray-400 mb-3">Foto Aduan</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    @foreach ($complaint->photos as $photo)
                                        <a href="{{ asset('storage/' . $photo->path) }}" data-fancybox="gallery" class="block group rounded-lg overflow-hidden shadow-md">
                                            <img src="{{ asset('storage/'. $photo->path) }}" alt="Foto Aduan" class="w-full h-32 object-cover transition transform group-hover:scale-110 duration-300">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            @if ($complaint->user->ktp_photo)
                            <div>
                                <h4 class="text-md font-medium text-gray-600 dark:text-gray-400 mb-3">Foto KTP Pengadu</h4>
                                <div class="max-w-xs">
                                    <a href="{{ asset('storage/' . $complaint->user->ktp_photo) }}" data-fancybox="gallery" class="block group rounded-lg overflow-hidden shadow-md">
                                        <img src="{{ asset('storage/' . $complaint->user->ktp_photo) }}" alt="Foto KTP" class="w-full object-contain transition transform group-hover:scale-110 duration-300">
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- BAGIAN 4: TANGGAPAN PETUGAS --}}
                    <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Tanggapan Petugas</h3>
                        
                        @if ($complaint->responses->isEmpty())
                            <div class="text-center py-10 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <i class="far fa-clock fa-3x text-gray-400 dark:text-gray-500"></i>
                                <p class="mt-4 text-gray-500">Belum ada tanggapan dari petugas.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                {{-- Loop untuk menampilkan tanggapan akan muncul di sini --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>