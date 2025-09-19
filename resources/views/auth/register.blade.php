<x-guest-layout>
    {{-- Menambahkan x-data untuk menyimpan state (status) terlihat atau tidaknya password --}}
    <div class="w-full max-w-md space-y-6 py-8" x-data="{ passwordVisible: false, confirmationVisible: false }">

        <div class="text-center">
            <div class="flex justify-center items-center space-x-3 mb-3">
                <div class="bg-gray-200 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="bg-red-500 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-[#0B2C2C]">DISPERKIM KAB GARUT</h1>
            <p class="text-sm text-gray-500">Dinas Perumahan dan Permukiman Kabupaten Garut</p>
        </div>

        <div class="flex justify-center bg-gray-100/80 rounded-lg p-1 border">
            <a href="{{ route('login') }}"
               class="w-1/2 text-center py-2 rounded-md font-semibold transition
                      {{ request()->routeIs('login') ? 'bg-white shadow-md text-[#0B2C2C]' : 'text-gray-500' }}">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="w-1/2 text-center py-2 rounded-md font-semibold transition
                      {{ request()->routeIs('register') ? 'bg-white shadow-md text-[#0B2C2C]' : 'text-gray-500' }}">
                Daftar
            </a>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-xl font-bold text-center mb-1 text-[#0B2C2C]">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Lengkapi data diri untuk mendaftar ke sistem DISPERKIM KAB GARUT</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-user text-gray-400"></i>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="Masukkan nama lengkap"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@email.com"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Nomor HP --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-phone text-gray-400"></i>
                        </span>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                               placeholder="Contoh: 081234567890"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                {{-- Detail Alamat --}}
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-medium text-gray-700 -mb-2">Alamat Asal</label>
                    
                    {{-- Baris 1: Kabupaten & Kecamatan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="district" class="block text-xs font-medium text-gray-600 mb-1">Kabupaten</label>
                            <input id="district" type="text" name="district" value="{{ old('district') }}" placeholder="Kabupaten" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#004D40] focus:ring-[#004D40]"/>
                        </div>
                        <div>
                            <label for="sub_district" class="block text-xs font-medium text-gray-600 mb-1">Kecamatan</label>
                            <input id="sub_district" type="text" name="sub_district" value="{{ old('sub_district') }}" placeholder="Kecamatan" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#004D40] focus:ring-[#004D40]"/>
                        </div>
                    </div>
                    
                    {{-- Baris 2: Desa & Kampung --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="village" class="block text-xs font-medium text-gray-600 mb-1">Desa</label>
                            <input id="village" type="text" name="village" value="{{ old('village') }}" placeholder="Desa" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#004D40] focus:ring-[#004D40]"/>
                        </div>
                         <div>
                            <label for="address" class="block text-xs font-medium text-gray-600 mb-1">Kampung</label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="Kampung" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#004D40] focus:ring-[#004D40]"/>
                        </div>
                    </div>

                    {{-- Baris 3: RT & RW --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="rt" class="block text-xs font-medium text-gray-600 mb-1">RT</label>
                            <input id="rt" type="text" name="rt" value="{{ old('rt') }}" placeholder="RT" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#004D40] focus:ring-[#004D40]"/>
                        </div>
                        <div>
                            <label for="rw" class="block text-xs font-medium text-gray-600 mb-1">RW</label>
                            <input id="rw" type="text" name="rw" value="{{ old('rw') }}" placeholder="RW" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-[#004D40] focus:ring-[#004D40]"/>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input id="password" :type="passwordVisible ? 'text' : 'password'" name="password" required
                               placeholder="Minimal 8 karakter"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                         <span @click="passwordVisible = !passwordVisible" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            <i class="fas text-gray-400" :class="passwordVisible ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </span>
                    </div>
                     <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input id="password_confirmation" :type="confirmationVisible ? 'text' : 'password'" name="password_confirmation" required
                               placeholder="Ulangi kata sandi"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                        <span @click="confirmationVisible = !confirmationVisible" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            <i class="fas text-gray-400" :class="confirmationVisible ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </span>
                    </div>
                     <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit"
                        class="w-full flex justify-center items-center py-3 font-semibold rounded-lg shadow-md text-white bg-[#0B2C2C] hover:bg-opacity-90 transition">
                    <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                </button>
            </form>

             <p class="text-center text-xs text-gray-500 mt-6">
                Dengan mendaftar, Anda menyetujui <a href="#" class="font-semibold text-[#004D40] hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="font-semibold text-[#004D40] hover:underline">Kebijakan Privasi</a> Disperkim.
            </p>
        </div>

        <p class="text-center text-xs text-gray-500 mt-4">
            © 2025 DISPERKIM KAB GARUT. Semua hak dilindungi.
        </p>
    </div>
</x-guest-layout>