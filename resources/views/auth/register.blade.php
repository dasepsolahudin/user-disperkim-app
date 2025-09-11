<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Disperkim</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F3F9F7] flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md px-4">
        {{-- Logo + Judul --}}
        <div class="text-center mb-6">
            <div class="flex justify-center mb-2">
                <img src="{{ asset('images/logo-disperkim.png') }}" alt="Logo" class="h-12">
            </div>
            <h1 class="text-2xl font-bold text-[#004D40]">DISPERKIM</h1>
            <p class="text-sm text-gray-600">Dinas Perumahan, Kawasan Permukiman dan Pertanahan</p>
        </div>

        {{-- Tab Masuk / Daftar --}}
        <div class="flex justify-center mb-6">
            <a href="{{ route('login') }}"
               class="w-1/2 text-center py-2 border rounded-l-lg {{ request()->routeIs('login') ? 'bg-white shadow font-semibold' : 'bg-gray-100 text-gray-600' }}">
               Masuk
            </a>
            <a href="{{ route('register') }}"
               class="w-1/2 text-center py-2 border rounded-r-lg {{ request()->routeIs('register') ? 'bg-white shadow font-semibold' : 'bg-gray-100 text-gray-600' }}">
               Daftar
            </a>
        </div>

        {{-- Card Form Register --}}
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 text-center mb-4">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Lengkapi data diri untuk mendaftar ke sistem DISPERKIM</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Nama --}}
                <div class="relative">
                    <input type="text" name="name" placeholder="Masukkan nama lengkap"
                        class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                {{-- Email --}}
                <div class="relative">
                    <input type="email" name="email" placeholder="nama@email.com"
                        class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>

                {{-- Alamat --}}
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="kabupaten" placeholder="Nama kabupaten"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                    <input type="text" name="kecamatan" placeholder="Nama kecamatan"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="desa" placeholder="Nama desa"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                    <input type="text" name="kampung" placeholder="Nama kampung"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                </div>

                {{-- Password --}}
                <div class="relative">
                    <input type="password" name="password" placeholder="Minimal 8 karakter"
                        class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="relative">
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi"
                        class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-[#00695C] focus:outline-none">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>

                {{-- Button --}}
                <button type="submit"
                    class="w-full bg-[#004D40] text-white py-2 rounded-lg font-semibold hover:bg-[#003d33] transition">
                    Daftar Sekarang
                </button>
            </form>

            {{-- Disclaimer --}}
            <p class="text-xs text-gray-500 text-center mt-4">
                Dengan mendaftar, Anda menyetujui <a href="#" class="text-[#00695C] hover:underline">Syarat & Ketentuan</a> 
                dan <a href="#" class="text-[#00695C] hover:underline">Kebijakan Privasi</a> DISPERKIM.
            </p>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-500 mt-6">
            © 2025 DISPERKIM KAB GARUT. Semua hak dilindungi.
        </p>
    </div>

</body>
</html>
