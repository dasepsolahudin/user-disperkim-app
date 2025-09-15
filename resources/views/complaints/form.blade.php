<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Pengaduan: ') }} <span class="capitalize">{{ str_replace('_', ' ', $category) }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="category" value="{{ $category }}">

                        <div>
                            <x-input-label for="title" :value="__('Judul Pengaduan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsikan Pengaduan Anda')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <hr class="my-6 dark:border-gray-700">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-lg mb-2 dark:text-gray-100">Alamat Sesuai Profil</h3>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    {{-- PERBAIKAN: Menyesuaikan nama kolom alamat dengan database yang benar --}}
                                    <p><strong>Desa/Kel:</strong> {{ Auth::user()->village ?: '-' }}</p>
                                    <p><strong>Kecamatan:</strong> {{ Auth::user()->district ?: '-' }}</p>
                                    <p><strong>Kabupaten/Kota:</strong> {{ Auth::user()->city ?: '-' }}</p>
                                    {{-- PERBAIKAN: Memperbaiki tag <a> yang rusak dan rute yang salah --}}
                                    <a href="{{ route('settings.edit', 'profile') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-xs pt-2 inline-block">Ubah Alamat di Profil</a>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="location_text" :value="__('Lokasi Spesifik Aduan')" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Jelaskan detail lokasi kejadian, contoh: "Depan Masjid Al-Ikhlas, Kp. Ciburial RT 01/RW 05".</p>
                                <textarea id="location_text" name="location_text" rows="3" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('location_text') }}</textarea>
                                <x-input-error :messages="$errors->get('location_text')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-6 dark:border-gray-700">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div x-data="{ files: [] }">
                                <x-input-label for="photos" :value="__('Foto Aduan (Wajib, minimal 3 foto)')" />
                                <input 
                                    type="file" 
                                    id="photos" 
                                    name="photos[]" 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-100 dark:file:bg-green-900 file:text-green-700 dark:file:text-green-300 hover:file:bg-green-200 dark:hover:file:bg-green-800 mt-1" 
                                    required 
                                    multiple
                                    accept="image/*"
                                    @change="files = Array.from($event.target.files).map(f => f.name)"
                                />
                                <div x-show="files.length > 0" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <p class="font-semibold">File yang dipilih (<span x-text="files.length"></span>):</p>
                                    <ul class="list-disc list-inside">
                                        <template x-for="file in files" :key="file">
                                            <li x-text="file" class="truncate"></li>
                                        </template>
                                    </ul>
                                </div>
                                <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                                <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="ktp_photo" :value="__('Foto KTP (Untuk Verifikasi)')" />
                                <input type="file" id="ktp_photo" name="ktp_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-200 dark:hover:file:bg-blue-800 mt-1"/>
                                <x-input-error :messages="$errors->get('ktp_photo')" class="mt-2" />
                                @if(Auth::user()->ktp_photo)
                                <p class="text-xs text-green-600 dark:text-green-500 mt-2">Anda sudah pernah mengunggah KTP. Kosongkan jika tidak ingin mengubahnya.</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 border-t dark:border-gray-700 pt-6">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Kembali
                            </a>

                            <x-primary-button>
                                {{ __('Kirim Pengaduan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

