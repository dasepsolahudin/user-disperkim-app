<x-app-layout>
    {{-- Mengosongkan header default --}}
    <x-slot name="header"></x-slot>

    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto max-w-3xl">

            {{-- Menghapus header yang terpisah --}}

            <div class="p-4">
                {{-- 
                ================================================
                PERUBAHAN DI SINI: SEMUA ELEMEN DISATUKAN
                ================================================
                --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm space-y-6">

                    {{-- BAGIAN 1: HEADER YANG SUDAH DISATUKAN --}}
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                        {{-- Tombol Kembali --}}
                        <a href="{{ url()->previous() }}" class="flex items-center gap-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-700 dark:hover:bg-white transition">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                        
                        {{-- Judul Halaman --}}
                        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            Detail Pengaduan
                        </h1>

                        {{-- Status Badge --}}
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

                    {{-- BAGIAN 2: INFORMASI UTAMA --}}
                    <div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1">
                                <i class="fas fa-exclamation-triangle text-red-500 fa-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $complaint->location_text }}</p>
                                
                                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-2"><i class="fas fa-user"></i> {{ $complaint->user->name }}</span>
                                    <span class="flex items-center gap-2"><i class="fas fa-calendar-alt"></i> {{ $complaint->created_at->format('d M Y') }}</span>
                                    @if($complaint->category)
                                    <span class="flex items-center gap-2 capitalize"><i class="fas fa-tags"></i> {{ str_replace('_', ' ', $complaint->category) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <p class="mt-5 text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $complaint->description }}
                        </p>
                    </div>

                    {{-- BAGIAN 3: LAMPIRAN FOTO --}}
                    <div>
                        {{-- FOTO ADUAN --}}
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Foto Aduan</h3>
                            @if($complaint->photos->isNotEmpty())
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach ($complaint->photos as $photo)
                                        <a href="{{ asset('storage/' . $photo->path) }}" target="_blank" class="block relative group aspect-w-1 aspect-h-1">
                                            <img src="{{ asset('storage/'. $photo->path) }}" alt="Foto Aduan" class="rounded-lg w-full h-full object-cover transition transform group-hover:scale-105">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Tidak ada foto aduan yang dilampirkan.</p>
                            @endif
                        </div>
                        
                        {{-- FOTO KTP --}}
                        <div class="mt-6">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Foto KTP</h3>
                            @if ($complaint->user->ktp_photo)
                                <div class="max-w-[200px]">
                                    <a href="{{ asset('storage/' . $complaint->user->ktp_photo) }}" target="_blank" class="block group">
                                        <img src="{{ asset('storage/' . $complaint->user->ktp_photo) }}" alt="Foto KTP" class="rounded-lg w-full object-contain transition transform group-hover:scale-105">
                                    </a>
                                </div>
                            @else
                                 <p class="text-sm text-gray-500">Tidak ada foto KTP yang dilampirkan.</p>
                            @endif
                        </div>
                    </div>

                    {{-- BAGIAN 4: TANGGAPAN PETUGAS --}}
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Tanggapan Petugas</h3>
                        
                        @if ($complaint->responses->isEmpty())
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <i class="far fa-clock fa-2x text-gray-400 dark:text-gray-500"></i>
                                <p class="mt-3 text-sm text-gray-500">Belum ada tanggapan dari petugas.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                {{-- Loop untuk menampilkan tanggapan --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>