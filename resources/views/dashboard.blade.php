<x-app-layout>
    {{-- Bagian Header dan Statistik (Tidak Berubah) --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Selamat datang di sistem Disperkim</p>
        </div>
        <div>
            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Online
            </span>
        </div>
    </div>
    <div class="space-y-6">
        {{-- ... (kode statistik dan navigasi lainnya tetap sama) ... --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Laporan</p>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 p-3 rounded-full">
                    <i class="fas fa-file-invoice fa-lg"></i>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dalam Proses</p>
                    <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['in_progress'] ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-hourglass-half fa-lg"></i>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aksi Cepat</p>
                    <a href="{{ route('complaints.create') }}"
                       class="mt-2 inline-block bg-green-600 text-white font-semibold text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition">
                         Buat Laporan Baru
                    </a>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-bolt fa-lg"></i>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Riwayat Laporan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lihat semua laporan Anda.</p>
                    </div>
                    <div class="bg-green-100 text-green-600 p-4 rounded-full">
                        <i class="fas fa-history fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('complaints.index') }}" class="text-sm text-green-600 font-semibold mt-4 inline-block hover:underline">
                    Lihat Riwayat &rarr;
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Pengaturan Akun</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui data diri & password.</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 p-4 rounded-full">
                        <i class="fas fa-user-cog fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('settings.edit', 'profile') }}" class="text-sm text-gray-600 dark:text-gray-400 font-semibold mt-4 inline-block hover:underline">
                    Buka Pengaturan &rarr;
                </a>
            </div>
        </div>
        
        {{-- ============================================================ --}}
        {{--            BAGIAN BERITA DENGAN TAMPILAN GAMBAR               --}}
        {{-- ============================================================ --}}
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
                                {{-- LOGIKA BARU: Tampilkan gambar jika ada, jika tidak tampilkan placeholder --}}
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