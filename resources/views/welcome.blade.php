<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi DISPERKIM Kabupaten Garut</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-section {
            background-image: url('https://dpkp.bandung.go.id/storage/app/media/upt-rusunawa.png');
            background-size: cover;
            background-position: center;
        }
        .text-shadow {
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="antialiased bg-green-50/50 text-gray-800">

    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-gray-800">Sistem Informasi Dinas Perumahan Dan Permukiman Kabupaten Garut</a>
            <div class="flex items-center space-x-4">
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="container mx-auto px-6 py-32 md:py-48 flex flex-col items-center justify-center text-center">
                <div class="max-w-xl">
                    <h1 class="text-shadow text-4xl md:text-5xl font-bold text-white leading-tight">
                        Layanan Pengaduan <span class="text-green-400">Disperkim</span> Kabupaten Garut
                    </h1>
                    <p class="text-shadow mt-4 text-lg text-white">
                        Sampaikan keluhan dan laporan Anda mengenai perumahan dan kawasan permukiman. Kami siap melayani untuk mewujudkan lingkungan yang lebih baik.
                    </p>
                    
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}"
                           class="inline-block bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            Masuk ke Sistem
                        </a>
                        <a href="#"
                           class="inline-block bg-white border-2 border-white text-green-700 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-green-100 hover:border-green-100 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            Lihat Peta Laporan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Sisa kode di bawah ini tidak diubah --}}
        
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Layanan Cepat</h2>
                    <p class="mt-2 text-gray-600">Akses cepat ke berbagai layanan pengaduan dan informasi yang Anda butuhkan.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <a href="#" class="block p-6 bg-green-600 text-white rounded-lg shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl mb-2">Buat Pengaduan</h3>
                        <p class="text-green-100 mb-4">Laporkan masalah penanganan dan kawasan permukiman.</p>
                        <span class="font-semibold">Akses Layanan &rarr;</span>
                    </a>
                    <a href="#" class="block p-6 bg-yellow-500 text-white rounded-lg shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl mb-2">Lapor Infrastruktur</h3>
                        <p class="text-yellow-100 mb-4">Laporkan kerusakan infrastruktur di lingkungan Anda.</p>
                        <span class="font-semibold">Akses Layanan &rarr;</span>
                    </a>
                    <a href="#" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border">
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Peta Interaktif</h3>
                        <p class="text-gray-600 mb-4">Lihat sebaran laporan di peta Kabupaten Garut.</p>
                        <span class="font-semibold text-green-600">Akses Layanan &rarr;</span>
                    </a>
                    <a href="#" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border">
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Riwayat Laporan</h3>
                        <p class="text-gray-600 mb-4">Cek status dan riwayat laporan Anda.</p>
                        <span class="font-semibold text-green-600">Akses Layanan &rarr;</span>
                    </a>
                    <a href="#" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border">
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Kontak Darurat</h3>
                        <p class="text-gray-600 mb-4">Hubungi layanan darurat untuk masalah mendesak.</p>
                        <span class="font-semibold text-green-600">Akses Layanan &rarr;</span>
                    </a>
                    <a href="#" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border">
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Informasi Layanan</h3>
                        <p class="text-gray-600 mb-4">Pelajari lebih lanjut tentang layanan kami.</p>
                        <span class="font-semibold">Akses Layanan &rarr;</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Statistik Layanan</h2>
                    <p class="mt-2 text-gray-600">Data real-time mengenai pengaduan dan laporan yang telah diterima dan ditangani.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-green-100">
                        <h3 class="text-4xl font-bold text-green-600">{{ $complaintStats['total'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800">Total Laporan</p>
                        <p class="text-sm text-gray-500">Laporan masuk bulan ini</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-green-100">
                        <h3 class="text-4xl font-bold text-yellow-500">{{ $complaintStats['in_progress'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800">Dalam Proses</p>
                        <p class="text-sm text-gray-500">Sedang ditangani</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-green-100">
                        <h3 class="text-4xl font-bold text-blue-600">{{ $complaintStats['completed'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800">Selesai</p>
                        <p class="text-sm text-gray-500">Berhasil diselesaikan</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-green-100">
                        <h3 class="text-4xl font-bold text-gray-800">{{ $complaintStats['active_users'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800">Pengguna Aktif</p>
                        <p class="text-sm text-gray-500">Masyarakat terdaftar</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Berita & Informasi Terbaru</h2>
                        <p class="mt-2 text-gray-600">Update terkini mengenai program dan kegiatan Disperkim Kabupaten Garut.</p>
                    </div>
                    <a href="#" class="hidden md:inline-block px-5 py-2 font-semibold text-green-600 border border-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($latestNews as $newsItem)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition duration-300 border">
                            <img class="h-48 w-full object-cover" src="https://storage.googleapis.com/gemini-prod-us-west1-423928499222/images/8ed7d018-0248-436f-8705-4c01d4a0a5f7.jpg" alt="Gambar Berita">
                            <div class="p-6">
                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Program</span>
                                <p class="text-gray-500 text-sm mb-2">{{ $newsItem->published_at->format('d F Y') }}</p>
                                <h3 class="font-bold text-lg mb-2 h-16 text-gray-900">{{ Str::limit($newsItem->title, 55) }}</h3>
                                <a href="#" class="text-green-600 hover:underline font-semibold">Baca Selengkapnya &rarr;</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 col-span-full">Belum ada berita yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">DISPERKIM</h3>
                    <p class="text-gray-400">Jalan Contoh No. 123<br>Garut, Jawa Barat, 44112<br>Indonesia</p>
                    <p class="mt-4 text-gray-400">
                        Email: <a href="mailto:info@disperkim.go.id" class="hover:text-green-400">info@disperkim.go.id</a><br>
                        Telepon: (0262) 123-4567
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tautan Penting</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049 1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.345 2.525c.636-.247 1.363-.416 2.427-.465C9.795 2.013 10.148 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0-2a7 7 0 110 14 7 7 0 010-14zm6.406-2.34a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Dinas Perumahan dan Permukiman Kabupaten Garut. All Rights Reserved.
            </div>
        </div>
    </footer>

</body>
</html>