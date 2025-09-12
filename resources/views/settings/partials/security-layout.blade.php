<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <section>
        <header>
            {{-- Latar belakang header --}}
            <div class="bg-red-50 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-red-500 text-red-100 flex items-center justify-center rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Pengaturan Keamanan
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Kelola keamanan akun dan ubah password Anda.
                        </p>
                    </div>
                </div>
            </div>

            {{-- KODE BARU: Panel Tips Keamanan --}}
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm-1-5h2V7h-2v6zm0 4h2v-2h-2v2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-yellow-800">Tips Keamanan</p>
                        <p class="text-sm text-yellow-700">
                            Gunakan password yang kuat dengan kombinasi huruf besar, angka, dan simbol untuk menjaga keamanan akun Anda.
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            @csrf
            @method('put')

            {{-- Formulir Ganti Password (tidak berubah) --}}
            <div>
                <x-input-label for="current_password" value="Password Saat Ini" />
                <div class="relative mt-1">
                    <x-text-input id="current_password" name="current_password" ::type="showCurrent ? 'text' : 'password'" class="block w-full" autocomplete="current-password" placeholder="Masukkan password saat ini" />
                    <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                        <i class="fas" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password Baru" />
                <div class="relative mt-1">
                    <x-text-input id="password" name="password" ::type="showNew ? 'text' : 'password'" class="block w-full" autocomplete="new-password" placeholder="Masukkan password baru" />
                    <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                        <i class="fas" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
                 <div class="relative mt-1">
                    <x-text-input id="password_confirmation" name="password_confirmation" ::type="showConfirm ? 'text' : 'password'" class="block w-full" autocomplete="new-password" placeholder="Konfirmasi password baru" />
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                        <i class="fas" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <x-primary-button class="bg-gray-800 hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Ubah Password
                </x-primary-button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                @endif
            </div>
        </form>
    </section>
</div>

