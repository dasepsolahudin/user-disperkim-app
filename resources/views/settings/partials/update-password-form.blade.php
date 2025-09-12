<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil dan alamat email Anda. Tambahkan juga foto profil agar lebih personal.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Foto Profil --}}
        <div class="flex items-center space-x-4">
            <div>
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                         alt="Foto Profil" 
                         class="w-20 h-20 rounded-full object-cover border">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                         alt="Foto Profil Default" 
                         class="w-20 h-20 rounded-full object-cover border">
                @endif
            </div>
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <input id="photo" name="photo" type="file" 
                       class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0 file:text-sm file:font-semibold
                              file:bg-green-600 file:text-white hover:file:bg-green-700"/>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600">
                    {{ __('Perubahan tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
