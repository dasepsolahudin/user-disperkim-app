<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- KOLOM KIRI: PROFIL PENGGUNA --}}
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-lg border dark:border-gray-700">
        <section x-data="{ editing: false }">
            {{-- Header Profil Kustom --}}
            <header class="mb-8">
                <div class="flex items-center space-x-4">
                    {{-- Foto Profil --}}
                    <div class="relative">
                        @if($user->photo)
                            <img class="h-24 w-24 rounded-full object-cover shadow-md border-2 border-white dark:border-gray-800" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                        @else
                            <img class="h-24 w-24 rounded-full object-cover shadow-md border-2 border-white dark:border-gray-800" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=ffffff&size=100" alt="{{ $user->name }}">
                        @endif
                        
                        {{-- Tombol Edit Foto --}}
                        {{-- Tombol ini sekarang hanya muncul saat mode edit aktif --}}
                        <form id="photo-upload-form" method="post" action="{{ route('settings.photo.update') }}" enctype="multipart/form-data" class="hidden">
                            @csrf
                            <input id="photo" name="photo" type="file" onchange="document.getElementById('photo-upload-form').submit();">
                        </form>
                        
                        {{-- Tombol ganti foto (label) yang muncul/hilang --}}
                        <label for="photo" x-show="editing" style="display: none;"
                               class="absolute bottom-0 right-0 p-2 rounded-full bg-blue-600 text-white cursor-pointer hover:bg-blue-700 transition">
                            <i class="fas fa-camera text-sm"></i>
                        </label>
                    </div>
                    
                    {{-- Info Nama & Status --}}
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900/50 dark:text-green-300">
                                <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Aktif
                            </span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900/50 dark:text-yellow-300">
                                Member Premium
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Tampilan View Mode --}}
            <div x-show="!editing" class="space-y-6">
                <div>
                    {{-- Label Nama dengan Ikon --}}
                    <label class="flex items-center gap-2 block font-medium text-sm text-gray-700 dark:text-gray-300">
                        <i class="fas fa-user w-4 text-center text-blue-500"></i>
                        <span>Nama Lengkap</span>
                    </label>
                    <div class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-3 text-sm">
                        {{ $user->name }}
                    </div>
                </div>
                <div>
                    {{-- Label Email dengan Ikon --}}
                    <label class="flex items-center gap-2 block font-medium text-sm text-gray-700 dark:text-gray-300">
                        <i class="fas fa-envelope w-4 text-center text-green-500"></i>
                        <span>Email</span>
                    </label>
                    <div class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-3 text-sm">
                        {{ $user->email }}
                    </div>
                </div>
                <div>
                    {{-- Label Telepon dengan Ikon --}}
                    <label class="flex items-center gap-2 block font-medium text-sm text-gray-700 dark:text-gray-300">
                         <i class="fas fa-phone w-4 text-center text-purple-500"></i>
                         <span>Nomor Telepon</span>
                    </label>
                    <div class="mt-1 block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 rounded-md shadow-sm p-3 text-sm">
                        {{ $user->phone_number ?? '-' }}
                    </div>
                </div>
                
                <div class="flex items-center gap-4 pt-2">
                     <button @click.prevent="editing = true"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                        <span>{{ __('Edit Profil') }}</span>
                    </button>
                </div>
            </div>

            {{-- Tampilan Edit Mode --}}
            <div x-show="editing" style="display: none;">
                <form id="profile-update-form" method="post" action="{{ route('settings.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        {{-- Label Nama dengan Ikon --}}
                        <label for="name" class="flex items-center gap-2 block font-medium text-sm text-gray-700 dark:text-gray-300">
                            <i class="fas fa-user w-4 text-center text-blue-500"></i>
                            <span>Nama Lengkap</span>
                        </label>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        {{-- Label Email dengan Ikon --}}
                        <label for="email" class="flex items-center gap-2 block font-medium text-sm text-gray-700 dark:text-gray-300">
                            <i class="fas fa-envelope w-4 text-center text-green-500"></i>
                            <span>Email</span>
                        </label>
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div>
                        {{-- Label Telepon dengan Ikon --}}
                        <label for="phone_number" class="flex items-center gap-2 block font-medium text-sm text-gray-700 dark:text-gray-300">
                            <i class="fas fa-phone w-4 text-center text-purple-500"></i>
                            <span>Nomor Telepon</span>
                        </label>
                        <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                       <button type="button" @click.prevent="editing = false"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-transparent hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                            {{ __('Batal') }}
                        </button>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>

    {{-- KOLOM KANAN: STATISTIK (Tidak ada perubahan) --}}
    <div class="space-y-6">
        {{-- Kartu Statistik --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border dark:border-gray-700">
            {{-- JUDUL: Dibuat rata tengah --}}
            <h3 class="font-semibold text-base text-center flex items-center justify-center gap-2 text-gray-700 dark:text-gray-300">
                <i class="fas fa-chart-line text-gray-400"></i>
                Statistik Saya
            </h3>
            <div class="mt-4 space-y-4">
                {{-- ITEM STATISTIK: Dibuat rata tengah dan font diperkecil --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Pengaduan</p>
                    <p class="font-bold text-2xl text-gray-800 dark:text-gray-200">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Selesai</p>
                    <p class="font-bold text-2xl text-green-600 dark:text-green-500">{{ $stats['completed'] }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Dalam Proses</p>
                    <p class="font-bold text-2xl text-yellow-500 dark:text-yellow-400">{{ $stats['in_progress'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg text-center border dark:border-gray-700">
            <i class="far fa-clock text-2xl text-gray-400 dark:text-gray-500"></i>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Bergabung Sejak</p>
            <p class="font-bold text-lg mt-1 text-gray-800 dark:text-gray-200">{{ $user->created_at->translatedFormat('d F Y') }}</p>
        </div>
    </div>
</div>