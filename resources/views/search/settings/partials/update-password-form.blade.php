<section class="max-w-xl" x-data="{ showCurrent: false, showNew: false, showConfirmation: false }">
    {{-- BAGIAN HEADER YANG MENYEBABKAN DUPLIKASI TELAH DIHAPUS DARI SINI --}}

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- Password Saat Ini --}}
        <div class="relative">
            <x-input-label for="current_password" :value="__('Password Saat Ini')" />
            <x-text-input id="current_password" name="current_password" x-bind:type="showCurrent ? 'text' : 'password'" class="mt-1 block w-full pr-10" autocomplete="current-password" placeholder="Masukkan password saat ini" />
            <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5 text-gray-500 dark:text-gray-400">
                <i class="fas" x-bind:class="{ 'fa-eye-slash': showCurrent, 'fa-eye': !showCurrent }"></i>
            </button>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Password Baru --}}
        <div class="relative">
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" name="password" x-bind:type="showNew ? 'text' : 'password'" class="mt-1 block w-full pr-10" autocomplete="new-password" placeholder="Masukkan password baru"/>
            <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5 text-gray-500 dark:text-gray-400">
                <i class="fas" x-bind:class="{ 'fa-eye-slash': showNew, 'fa-eye': !showNew }"></i>
            </button>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div class="relative">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <x-text-input id="password_confirmation" name="password_confirmation" x-bind:type="showConfirmation ? 'text' : 'password'" class="mt-1 block w-full pr-10" autocomplete="new-password" placeholder="Konfirmasi password baru"/>
            <button type="button" @click="showConfirmation = !showConfirmation" class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5 text-gray-500 dark:text-gray-400">
                <i class="fas" x-bind:class="{ 'fa-eye-slash': showConfirmation, 'fa-eye': !showConfirmation }"></i>
            </button>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Tips Password Aman --}}
        <div class="p-4 border-l-4 border-blue-400 bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 rounded-r-lg">
            <h4 class="font-bold">Tips Password Aman:</h4>
            <ul class="mt-2 text-sm list-disc list-inside space-y-1">
                <li>Minimal 8 karakter dengan kombinasi huruf, angka, dan simbol.</li>
                <li>Hindari menggunakan informasi pribadi.</li>
                <li>Gunakan password yang unik untuk setiap akun.</li>
            </ul>
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>
                <i class="fas fa-save mr-2"></i>
                {{ __('Ubah Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>