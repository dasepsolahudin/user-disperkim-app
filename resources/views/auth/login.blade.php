<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F1F9F6]">
        <div class="w-full max-w-md space-y-6">

            <!-- Logo & Header -->
            <div class="text-center">
                <div class="flex justify-center mb-3">
                    <img src="{{ asset('images/logo-disperkim.png') }}" alt="Logo" class="h-16 w-16">
                </div>
                <h1 class="text-xl font-bold text-[#0B2C2C]">DISPERKIM KAB GARUT</h1>
                <p class="text-sm text-[#0B2C2C]/70">Dinas Perumahan, Kawasan Permukiman dan Pertanahan</p>
            </div>

            <!-- Tab Masuk / Daftar -->
            <div class="flex justify-center bg-gray-100 rounded-lg p-1">
                <a href="{{ route('login') }}"
                   class="w-1/2 text-center py-2 rounded-md font-medium transition
                          {{ request()->routeIs('login') ? 'bg-white shadow text-[#0B2C2C]' : 'text-gray-500' }}">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="w-1/2 text-center py-2 rounded-md font-medium transition
                          {{ request()->routeIs('register') ? 'bg-white shadow text-[#0B2C2C]' : 'text-gray-500' }}">
                    Daftar
                </a>
            </div>

            <!-- Card -->
            <div class="bg-white shadow-md rounded-xl p-6">
                <h2 class="text-lg font-semibold text-center mb-2 text-[#0B2C2C]">Masuk ke Akun Anda</h2>
                <p class="text-sm text-gray-500 text-center mb-6">Masukkan email dan kata sandi untuk mengakses sistem</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <input id="email" type="email" name="email" placeholder="nama@email.com"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0B2C2C] focus:ring-[#0B2C2C]"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <input id="password" type="password" name="password" placeholder="Masukkan kata sandi"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#0B2C2C] focus:ring-[#0B2C2C]"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember & Lupa Password -->
                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#0B2C2C]">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-[#0B2C2C] hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Tombol Masuk -->
<button type="submit"
        style="background-color: black; color: white;"
        class="w-full py-2 font-semibold rounded-lg shadow hover:opacity-90 transition">
    Masuk →
</button>


                </form>
            </div>

            <!-- Footer -->
            <p class="text-center text-sm text-gray-500 mt-4">
                © 2025 DISPERKIM KAB GARUT. Semua hak dilindungi.
            </p>
        </div>
    </div>
</x-guest-layout>
