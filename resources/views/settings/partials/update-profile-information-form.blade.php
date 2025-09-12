<section x-data="{ editing: false }">
    {{-- HEADER --}}
    <header>
        {{-- Header Box dengan Latar Belakang Biru Minimalis --}}
        <div class="bg-indigo-50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                {{-- Sisi Kiri: Ikon dan Teks --}}
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 flex items-center justify-center rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Informasi Profil
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Lihat dan perbarui data diri serta alamat Anda.
                        </p>
                    </div>
                </div>
                {{-- Sisi Kanan: Tombol Edit/Batal --}}
                <div>
                    <template x-if="!editing">
                        <x-primary-button @click="editing = true">{{ __('Edit Profil') }}</x-primary-button>
                    </template>
                    <template x-if="editing">
                        <x-secondary-button @click="editing = false">{{ __('Batal') }}</x-secondary-button>
                    </template>
                </div>
            </div>
        </div>
    </header>

    {{-- ================================================================= --}}
    {{-- TAMPILAN SAAT MELIHAT DATA (VIEW MODE) - BAGIAN YANG DIPERBAIKI --}}
    {{-- ================================================================= --}}
    <div x-show="!editing" class="mt-6 space-y-4">
        
        {{-- Kotak Foto Profil --}}
        <div class="bg-gray-50 p-4 rounded-lg border flex justify-between items-center">
            <p class="font-semibold text-gray-600">Foto Profil</p>
            <div>
                @if($user->photo)
                    <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                @else
                    <img class="h-16 w-16 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=ffffff" alt="{{ $user->name }}">
                @endif
            </div>
        </div>

        {{-- Kotak Nama Lengkap --}}
        <div class="bg-gray-50 p-4 rounded-lg border">
            <p class="text-xs text-gray-500">Nama Lengkap</p>
            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
        </div>

        {{-- Kotak Email --}}
        <div class="bg-gray-50 p-4 rounded-lg border">
            <p class="text-xs text-gray-500">Email</p>
            <p class="font-semibold text-gray-800">{{ $user->email }}</p>
        </div>
        
        {{-- Kotak Alamat --}}
        <div class="bg-gray-50 p-4 rounded-lg border grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-gray-500">Kabupaten/Kota</p>
                <p class="font-semibold text-gray-800">{{ $user->kabupaten ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Kecamatan</p>
                <p class="font-semibold text-gray-800">{{ $user->kecamatan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Desa/Kelurahan</p>
                <p class="font-semibold text-gray-800">{{ $user->desa ?? '-' }}</p>
            </div>
        </div>
    </div>


    {{-- TAMPILAN SAAT MENGEDIT DATA (EDIT MODE) - TIDAK DIUBAH --}}
    <div x-show="editing" x-cloak>
        {{-- FORM UPLOAD FOTO PROFIL --}}
        <form method="post" action="{{ route('settings.photo.update') }}" enctype="multipart/form-data" class="mt-6 flex items-center gap-4">
            @csrf
            <div>
                @if($user->photo)
                    <img id="preview-photo" class="h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                @else
                    <img id="preview-photo" class="h-20 w-20 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=ffffff" alt="{{ $user->name }}">
                @endif
            </div>
            <div class="flex items-center gap-2">
                 <label for="photo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    Pilih Foto Baru
                </label>
                <input id="photo" name="photo" type="file" class="hidden" 
                       onchange="document.getElementById('file-name').textContent = this.files[0].name; this.form.submit();">
                <p class="text-sm text-gray-500" id="file-name"></p>
            </div>
        </form>

        <hr class="my-6 dark:border-gray-700">

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
        
        <form method="post" action="{{ route('settings.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            {{-- Nama --}}
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Alamat email Anda belum terverifikasi.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Baris untuk Kabupaten & Kecamatan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="kabupaten" :value="__('Kabupaten/Kota')" />
                    <x-text-input id="kabupaten" name="kabupaten" type="text" class="mt-1 block w-full" :value="old('kabupaten', $user->kabupaten)" />
                    <x-input-error class="mt-2" :messages="$errors->get('kabupaten')" />
                </div>
                <div>
                    <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                    <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" :value="old('kecamatan', $user->kecamatan)" />
                    <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                </div>
            </div>

            {{-- Desa --}}
            <div>
                <x-input-label for="desa" :value="__('Desa/Kelurahan')" />
                <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full" :value="old('desa', $user->desa)" />
                <x-input-error class="mt-2" :messages="$errors->get('desa')" />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <x-primary-button>
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>

