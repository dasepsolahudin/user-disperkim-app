<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi DISPERKIM Kabupaten Garut</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <nav class="container mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 text-gray-800">
                <span class="bg-green-600 text-white font-bold text-lg rounded-md w-8 h-8 flex items-center justify-center flex-shrink-0">D</span>
                <div>
                    <span class="block sm:hidden font-bold text-base">Disperkim Garut</span>
                    <span class="hidden sm:block font-bold text-base md:text-lg">Dinas Perumahan & Permukiman</span>
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-4">
                 @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk / Daftar</span>
                    </a>
                @endauth
            </div>

            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-green-700 focus:outline-none">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>
        </nav>

        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden bg-white shadow-lg border-t" x-cloak>
            <div class="px-6 py-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-left inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-left inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition">
                         <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk / Daftar</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="hero-section">
            <div class="container mx-auto px-6 py-12 md:py-24 flex flex-col items-center justify-center text-center">
                <div class="max-w-xl">
                    <h1 class="text-shadow text-3xl md:text-5xl font-bold text-white leading-tight">
                        Layanan Pengaduan <span class="text-green-400">Disperkim</span>
                    </h1>
                    <p class="text-shadow mt-4 text-md md:text-lg text-white">
                        Sampaikan keluhan dan laporan Anda mengenai perumahan dan kawasan permukiman.
                    </p>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Statistik Layanan</h2>
                    <p class="mt-2 text-sm md:text-base text-gray-600">Data real-time mengenai pengaduan dan laporan yang diterima.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6 text-center">
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-200">
                        <h3 class="text-3xl md:text-4xl font-bold text-green-600">{{ $stats['total'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800 text-xs md:text-sm">Total Laporan</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-200">
                        <h3 class="text-3xl md:text-4xl font-bold text-yellow-500">{{ $stats['in_progress'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800 text-xs md:text-sm">Dalam Proses</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-200">
                        <h3 class="text-3xl md:text-4xl font-bold text-blue-600">{{ $stats['completed'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800 text-xs md:text-sm">Selesai</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-200">
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $stats['users'] }}</h3>
                        <p class="mt-2 font-semibold text-gray-800 text-xs md:text-sm">Pengguna</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION BERITA & INFORMASI TERBARU DIHAPUS DARI SINI --}}

    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Dinas Perumahan dan Permukiman Kabupaten Garut. All Rights Reserved.
            </div>
        </div>
    </footer>

</body>