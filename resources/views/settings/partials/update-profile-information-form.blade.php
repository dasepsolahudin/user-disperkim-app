<section x-data="{ editing: false }">
    {{-- HEADER --}}
    <header>
        <div class="bg-indigo-50 dark:bg-gray-800/50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center rounded-lg">
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

    {{-- =================================== --}}
    {{-- TAMPILAN MODE LIHAT (VIEW MODE)     --}}
    {{-- =================================== --}}
    <div x-show="!editing" class="mt-6 space-y-6">
        <div class="flex items-center gap-4">
            <div>
                @if($user->photo)
                    <img class="h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                @else
                    <img class="h-20 w-20 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=ffffff" alt="{{ $user->name }}">
                @endif
            </div>
        </div>
        <hr class="dark:border-gray-700">
        <div>
            <x-input-label for="view_name" :value="__('Nama Lengkap')" />
            <div id="view_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-2.5 text-sm">
                {{ $user->name }}
            </div>
        </div>
        <div>
            <x-input-label for="view_email" :value="__('Email')" />
            <div id="view_email" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-2.5 text-sm">
                {{ $user->email }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="view_kabupaten" :value="__('Kabupaten/Kota')" />
                {{-- PERBAIKAN: Menggunakan $user->city --}}
                <div id="view_kabupaten" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-2.5 text-sm">
                    {{ $user->city ?? '-' }}
                </div>
            </div>
            <div>
                <x-input-label for="view_kecamatan" :value="__('Kecamatan')" />
                {{-- PERBAIKAN: Menggunakan $user->district --}}
                <div id="view_kecamatan" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-2.5 text-sm">
                    {{ $user->district ?? '-' }}
                </div>
            </div>
        </div>
        <div>
            <x-input-label for="view_desa" :value="__('Desa/Kelurahan')" />
            {{-- PERBAIKAN: Menggunakan $user->village --}}
            <div id="view_desa" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-2.5 text-sm">
                {{ $user->village ?? '-' }}
            </div>
        </div>
    </div>

    {{-- ================================== --}}
    {{-- TAMPILAN MODE EDIT (EDIT MODE)     --}}
    {{-- ================================== --}}
    <div x-show="editing" x-cloak>
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
                 <label for="photo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                    Pilih Foto Baru
                </label>
                <input id="photo" name="photo" type="file" class="hidden" onchange="this.form.submit();">
            </div>
        </form>
        <hr class="my-6 dark:border-gray-700">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
        <form method="post" action="{{ route('settings.profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="kabupaten" :value="__('Kabupaten/Kota')" />
                    {{-- PERBAIKAN: Menggunakan $user->city untuk nilai awal --}}
                    <x-text-input id="kabupaten" name="kabupaten" type="text" class="mt-1 block w-full" :value="old('kabupaten', $user->city)" />
                    <x-input-error class="mt-2" :messages="$errors->get('kabupaten')" />
                </div>
                <div>
                    <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                    {{-- PERBAIKAN: Menggunakan $user->district untuk nilai awal --}}
                    <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" :value="old('kecamatan', $user->district)" />
                    <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                </div>
            </div>
            <div>
                <x-input-label for="desa" :value="__('Desa/Kelurahan')" />
                {{-- PERBAIKAN: Menggunakan $user->village untuk nilai awal --}}
                <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full" :value="old('desa', $user->village)" />
                <x-input-error class="mt-2" :messages="$errors->get('desa')" />
            </div>
            <div class="flex items-center gap-4 pt-2">
                <x-primary-button>
                    Simpan Perubahan
                </x-primary-button>
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>