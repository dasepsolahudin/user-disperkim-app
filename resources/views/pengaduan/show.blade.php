<x-app-layout>
    {{-- Mengosongkan header default --}}
    <x-slot name="header"></x-slot>

    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto max-w-3xl">

            <div class="p-4">
                {{-- KOTAK KONTEN UTAMA --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm">

                    {{-- BAGIAN 1: HEADER --}}
                    <div class="flex items-center justify-between pb-4">
                        <a href="{{ url()->previous() }}" class="flex items-center gap-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-700 dark:hover:bg-white transition">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                        
                        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            Detail Pengaduan
                        </h1>

                        @php
                            $statusClass = match ($complaint->status) {
                                'Selesai' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                'Pengerjaan' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
                                'Verifikasi' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                                default => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                            };
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                            {{ $complaint->status }}
                        </span>
                    </div>

                    {{-- BAGIAN 2: DETAIL PENGADUAN --}}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 space-y-6">
                        
                        {{-- Judul dan Info Ringkas --}}
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h2>
                            <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 dark:text-gray-400">
                                @if($complaint->category)
                                <span class="flex items-center gap-2 capitalize"><i class="fas fa-tags"></i> {{ str_replace('_', ' ', $complaint->category) }}</span>
                                @endif
                                <span class="flex items-center gap-2"><i class="fas fa-calendar-alt"></i> {{ $complaint->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        {{-- Info Pengadu dan Lokasi --}}
                        <div class="space-y-4">
                            <div>
                                 <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-2">
                                    <i class="fas fa-user-circle text-gray-400"></i>
                                    Pengadu
                                </h3>
                                <div class="text-sm text-gray-700 dark:text-gray-300 border-l-2 border-gray-200 dark:border-gray-700 ml-2 pl-4">
                                   <p>{{ $complaint->user->name }}</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-2">
                                    <i class="fas fa-map-marked-alt text-gray-400"></i>
                                    Lokasi
                                </h3>
                                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1 border-l-2 border-gray-200 dark:border-gray-700 ml-2 pl-4">
                                    @if($complaint->location_text)<p><strong>Patokan:</strong> {{ $complaint->location_text }}</p>@endif
                                    @if($complaint->address)<p><strong>RT/RW:</strong> {{ $complaint->address }}</p>@endif
                                    @if($complaint->village)<p><strong>Desa/Kel:</strong> {{ $complaint->village }}</p>@endif
                                    @if($complaint->sub_district)<p><strong>Kecamatan:</strong> {{ $complaint->sub_district }}</p>@endif
                                    @if($complaint->district)<p><strong>Kabupaten:</strong> {{ $complaint->district }}</p>@endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Deskripsi Pengaduan dengan Kotak Pemisah --}}
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                             <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-2">
                                <i class="fas fa-file-alt text-gray-400"></i>
                                Deskripsi Laporan
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $complaint->description }}
                            </p>
                        </div>
                    </div>

                    {{-- BAGIAN 3: LAMPIRAN FOTO --}}
                    @if($complaint->photos->isNotEmpty() || $complaint->user->ktp_photo)
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Lampiran</h3>
                        <div class="space-y-6">
                            @if($complaint->photos->isNotEmpty())
                            <div>
                                <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Foto Aduan</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    @foreach ($complaint->photos as $photo)
                                        <a href="{{ asset('storage/' . $photo->path) }}" target="_blank" class="block group">
                                            <img src="{{ asset('storage/'. $photo->path) }}" alt="Foto Aduan" class="rounded-lg w-full h-24 object-cover transition transform group-hover:scale-105">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            @if ($complaint->user->ktp_photo)
                            <div>
                                <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Foto KTP</h4>
                                <div class="max-w-[150px]">
                                    <a href="{{ asset('storage/' . $complaint->user->ktp_photo) }}" target="_blank" class="block group">
                                        <img src="{{ asset('storage/' . $complaint->user->ktp_photo) }}" alt="Foto KTP" class="rounded-lg w-full object-contain transition transform group-hover:scale-105">
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- BAGIAN 4: TANGGAPAN PETUGAS --}}
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Tanggapan Petugas</h3>
                        
                        @if ($complaint->responses->isEmpty())
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <i class="far fa-clock fa-2x text-gray-400 dark:text-gray-500"></i>
                                <p class="mt-3 text-sm text-gray-500">Belum ada tanggapan dari petugas.</p>
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