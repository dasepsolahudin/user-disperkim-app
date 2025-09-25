<x-app-layout>
    {{-- Slot header dikosongkan lagi --}}
    <x-slot name="header">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
            <i class="fas fa-tachometer-alt text-indigo-500"></i>
            <span>Dashboard </span>
        </h1>
    </x-slot>

    {{-- Tanggal dikembalikan ke sini --}}
   <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-building text-gray-700 dark:text-gray-300"></i>
                <span>Selamat Datang di Disperkim</span>
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sistem Informasi Perumahan dan Kawasan Permukiman</p>
        </div>
        <div class="text-right">
             <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300">
                <i class="fas fa-calendar-alt"></i>
                <span>Hari ini</span>
            </div>
            <p class="text-blue-600 font-medium text-sm mt-1">{{ now()->format('d/m/Y') }}</p>
        </div>
    </div>

    {{-- Kartu Statistik (Tidak ada perubahan) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-5 shadow-sm flex justify-between items-center">
            <div>
                <p class="text-gray-600 dark:text-gray-400">Total Pengaduan</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['total'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">Bulan ini</p>
            </div>
            <div class="text-blue-400">
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
        </div>

        <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 rounded-lg p-5 shadow-sm flex justify-between items-center">
            <div>
                <p class="text-gray-600 dark:text-gray-400">Dalam Proses</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['in_progress'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">Sedang ditangani</p>
            </div>
            <div class="text-orange-400">
                <i class="fas fa-clock fa-2x"></i>
            </div>
        </div>

        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg p-5 shadow-sm flex justify-between items-center">
            <div>
                <p class="text-gray-600 dark:text-gray-400">Selesai</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['completed'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">Bulan ini</p>
            </div>
            <div class="text-green-400">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
        </div>

        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-5 shadow-sm flex justify-between items-center">
            <div>
                <p class="text-gray-600 dark:text-gray-400">Mendesak</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['urgent'] ?? 0 }}</p>
                <p class="text-xs text-gray-500">Perlu perhatian</p>
            </div>
            <div class="text-red-400">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
            </div>
        </div>
    </div>
    
    {{-- Bagian Berita (Tidak ada perubahan) --}}
    <div class="mt-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                <i class="fas fa-newspaper mr-2 text-indigo-500"></i>
                Berita Disperkim Terbaru
            </h3>
            <div class="space-y-4">
                @if (!empty($newsItems))
                    @foreach ($newsItems as $item)
                        <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer" class="block bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 p-4 rounded-lg border dark:border-gray-700 transition duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-24 h-16 rounded-md overflow-hidden">
                                    @if ($item['image'])
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-500"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="font-semibold px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 rounded">
                                            {{ $item['source'] }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($item['pubDate'])->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 leading-snug">
                                        {{ Str::limit($item['title'], 80) }}
                                    </h4>
                                    <span class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline mt-2 inline-block">
                                        Baca Selengkapnya <i class="fas fa-external-link-alt fa-xs ml-1"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada berita yang dapat ditampilkan saat ini.</p>
                @endif
            </div>
             @if (!empty($newsItems) && $newsItems[0]['link'] !== '#')
                <div class="mt-6 text-center">
                    <a href="https://news.google.com/search?q=Disperkim%20Garut" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <i class="fas fa-list-alt mr-2"></i>
                        Lihat Semua Berita
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>