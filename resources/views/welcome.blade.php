<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi DISPERKIM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        <div class="absolute top-0 right-0 p-6 text-right">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900">Register</a>
                @endif
            @endauth
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <header class="text-center my-16">
                <h1 class="text-4xl font-bold text-gray-900">Sistem Pengaduan DISPERKIM</h1>
                <p class="mt-4 text-lg text-gray-600">Punya keluhan atau laporan terkait perumahan dan infrastruktur? Sampaikan di sini.</p>
                <div class="mt-6">
                    <a href="{{ route('complaints.create') }}" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700">Buat Laporan Baru</a>
                </div>
            </header>

            @if($activeAnnouncement)
                <div class="my-8 p-4 bg-yellow-200 text-yellow-800 rounded-lg text-center">
                    <h3 class="font-bold">{{ $activeAnnouncement->title }}</h3>
                    <p>{{ $activeAnnouncement->content }}</p>
                </div>
            @endif

            <section class="my-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-3xl font-bold text-gray-900">{{ $complaintStats['total'] }}</h3>
                        <p class="mt-2 text-gray-600">Total Laporan Masuk</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-3xl font-bold text-blue-600">{{ $complaintStats['in_progress'] }}</h3>
                        <p class="mt-2 text-gray-600">Dalam Pengerjaan</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-3xl font-bold text-green-600">{{ $complaintStats['completed'] }}</h3>
                        <p class="mt-2 text-gray-600">Telah Selesai</p>
                    </div>
                </div>
            </section>

            <section class="my-16">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Berita & Informasi Terbaru</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($latestNews as $newsItem)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- Ganti dengan gambar jika ada --}}
                            <div class="h-40 bg-gray-200"></div> 
                            <div class="p-6">
                                <h3 class="font-bold text-lg">{{ $newsItem->title }}</h3>
                                <a href="#" class="text-blue-600 hover:underline mt-4 inline-block">Baca Selengkapnya</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 col-span-full">Belum ada berita yang dipublikasikan.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</body>
</html>