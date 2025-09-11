<x-guest-layout>
    {{-- Menambahkan x-data untuk menyimpan state (status) terlihat atau tidaknya password --}}
    <div class="w-full max-w-md space-y-6" x-data="{ passwordVisible: false }">

        <div class="text-center">
            <div class="flex justify-center items-center space-x-3 mb-3">
                {{-- Icon 1 --}}
                <div class="bg-gray-200 p-3 rounded-lg">
                     <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                {{-- Icon 2 --}}
                <div class="bg-red-500 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-[#0B2C2C]">DISPERKIM</h1>
            <p class="text-sm text-gray-500">Dinas Perumahan, Kawasan Permukiman dan Pertanahan</p>
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
            <h2 class="text-xl font-bold text-center mb-1 text-[#0B2C2C]">Masuk ke Akun Anda</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Masukkan email dan kata sandi untuk mengakses sistem</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                               placeholder="nama@email.com"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input id="password" :type="passwordVisible ? 'text' : 'password'" name="password" required autocomplete="current-password"
                               placeholder="Masukkan kata sandi"
                               class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-[#004D40] focus:ring-[#004D40]"/>
                         <span @click="passwordVisible = !passwordVisible" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            <i class="fas text-gray-400" :class="passwordVisible ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </span>
                    </div>
                     <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-[#004D40] shadow-sm focus:ring-[#004D40]">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#004D40] hover:underline">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full flex justify-center items-center py-3 font-semibold rounded-lg shadow-md text-white bg-[#0B2C2C] hover:bg-opacity-90 transition">
                    Masuk <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>