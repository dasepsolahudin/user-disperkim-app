<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengaduan: ') }} <span class="capitalize">{{ str_replace('_', ' ', $category) }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    {{-- Tambahkan enctype untuk upload file --}}
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
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <hr class="my-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Alamat Sesuai Profil</h3>
                                <div class="p-4 bg-gray-50 border rounded-md text-sm text-gray-600">
                                    <p><strong>Kampung:</strong> {{ Auth::user()->kampung ?: '-' }}</p>
                                    <p><strong>Desa/Kel:</strong> {{ Auth::user()->desa ?: '-' }}</p>
                                    <p><strong>Kecamatan:</strong> {{ Auth::user()->kecamatan ?: '-' }}</p>
                                    <p><strong>Kabupaten:</strong> {{ Auth::user()->kabupaten ?: '-' }}</p>
                                    <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:underline text-xs mt-2 inline-block">Ubah Alamat di Profil</a>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="location_text" :value="__('Lokasi Spesifik Aduan')" />
                                <p class="text-sm text-gray-500 mb-2">Jelaskan detail lokasi kejadian, contoh: "Depan Masjid Al-Ikhlas, Kp. Ciburial RT 01/RW 05".</p>
                                <textarea id="location_text" name="location_text" rows="3" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('location_text') }}</textarea>
                                <x-input-error :messages="$errors->get('location_text')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <x-input-label for="photo" :value="__('Foto Aduan (Wajib)')" />
                                <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 mt-1" required/>
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="ktp_photo" :value="__('Foto KTP (Untuk Verifikasi)')" />
                                <input type="file" id="ktp_photo" name="ktp_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 mt-1"/>
                                <x-input-error :messages="$errors->get('ktp_photo')" class="mt-2" />
                                @if(Auth::user()->ktp_photo)
                                <p class="text-xs text-green-600 mt-2">Anda sudah pernah mengunggah KTP. Kosongkan jika tidak ingin mengubahnya.</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
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