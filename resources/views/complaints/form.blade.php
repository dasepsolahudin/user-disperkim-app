<x-app-layout>
    <div class="space-y-6">
        {{-- START: HEADER KUSTOM --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pengaduan Masyarakat</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kelola dan submit pengaduan untuk perbaikan layanan
            </p>
        </div>
        {{-- END: HEADER KUSTOM --}}

        {{-- START: NAVIGASI TAB --}}
        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-sm flex items-center space-x-2">
            <a href="{{ route('complaints.index') }}" class="w-1/2 text-center py-2 px-4 text-indigo-600 bg-white dark:bg-gray-800 border border-indigo-600 rounded-md font-semibold text-sm hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                <i class="fas fa-list-ul mr-2"></i>
                Daftar Pengaduan
            </a>
            <span class="w-1/2 text-center py-2 px-4 bg-indigo-600 text-white rounded-md font-semibold text-sm cursor-default">
                <i class="fas fa-plus mr-2"></i>
                Buat Pengaduan
            </span>
        </div>
        {{-- END: NAVIGASI TAB --}}

        {{-- START: FORM PENGADUAN BARU --}}
        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-lg shadow-sm">
                {{-- Grid Utama Dua Kolom --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    
                    {{-- START: KOLOM KIRI --}}
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="title" value="Judul Pengaduan *" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required placeholder="Cth: Jalan rusak di depan sekolah" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="category" value="Kategori *" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="rutilahu" {{ old('category', $category ?? '') == 'rutilahu' ? 'selected' : '' }}>Rutilahu</option>
                                <option value="infrastruktur" {{ old('category', $category ?? '') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="tata_kota" {{ old('category', $category ?? '') == 'tata_kota' ? 'selected' : '' }}>Tata Kota</option>
                                <option value="air_bersih_sanitasi" {{ old('category', $category ?? '') == 'air_bersih_sanitasi' ? 'selected' : '' }}>Air Bersih & Sanitasi</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="priority" value="Prioritas" />
                            <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="Rendah" @if(old('priority') == 'Rendah') selected @endif>Rendah</option>
                                <option value="Sedang" @if(old('priority', 'Sedang') == 'Sedang') selected @endif>Sedang</option>
                                <option value="Tinggi" @if(old('priority') == 'Tinggi') selected @endif>Tinggi</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="description" value="Deskripsi Pengaduan *" />
                            <textarea id="description" name="description" rows="12" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Jelaskan detail pengaduan Anda selengkap mungkin...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                    {{-- END: KOLOM KIRI --}}

                    {{-- START: KOLOM KANAN --}}
                    <div class="space-y-6">
                        {{-- Seksi Alamat --}}
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Alamat Lengkap</h3>
                            <div>
                                <x-input-label for="city" value="Kabupaten" class="text-xs"/>
                                <x-text-input id="city" class="block mt-1 w-full bg-gray-100 dark:bg-gray-800" type="text" name="city" value="Garut" readonly />
                            </div>
                             <div>
                                <x-input-label for="district" value="Kecamatan *" class="text-xs"/>
                                <x-text-input id="district" class="block mt-1 w-full" type="text" name="district" :value="old('district')" required placeholder="Cth: Garut Kota"/>
                                <x-input-error :messages="$errors->get('district')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="village" value="Desa/Kelurahan *" class="text-xs"/>
                                <x-text-input id="village" class="block mt-1 w-full" type="text" name="village" :value="old('village')" required placeholder="Cth: Sukamentri"/>
                                <x-input-error :messages="$errors->get('village')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="sub_district" value="Kampung/RW" class="text-xs"/>
                                <x-text-input id="sub_district" class="block mt-1 w-full" type="text" name="sub_district" :value="old('sub_district')" placeholder="Cth: Kp. Sindangheula RW 01"/>
                            </div>
                             <div>
                                <x-input-label for="location_text" value="Alamat Detail" class="text-xs"/>
                                <textarea id="location_text" name="location_text" rows="2" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Cth: Jl. Pahlawan No. 25, RT 02/RW 01 (depan masjid)">{{ old('location_text') }}</textarea>
                                <x-input-error :messages="$errors->get('location_text')" class="mt-2" />
                            </div>
                        </div>

                        {{-- START: PERBAIKAN UPLOAD BERKAS DENGAN PREVIEW --}}
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Upload Berkas</h3>
                            
                            {{-- UPLOAD FOTO BUKTI --}}
                            <div x-data="{ files: null }">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Bukti (Opsional)</label>
                                <label for="photos" class="mt-1 flex justify-center w-full h-32 px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 transition bg-gray-50 dark:bg-gray-900/50">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-camera fa-2x text-gray-400"></i>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload (bisa lebih dari 1 foto)</p>
                                        <p class="text-xs text-gray-500">JPG, PNG. maks 5MB</p>
                                    </div>
                                </label>
                                <input type="file" id="photos" name="photos[]" class="hidden" multiple @change="files = $event.target.files">
                                <div x-show="files && files.length > 0" class="mt-2 text-xs text-gray-500" x-cloak>
                                    <p><span x-text="files.length"></span> file dipilih.</p>
                                </div>
                                <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                            </div>

                            {{-- UPLOAD FOTO KTP --}}
                            <div x-data="{ ktpPreview: null, ktpName: null }">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto KTP (Opsional)</label>
                                <input type="file" id="ktp_photo" name="ktp_photo" class="hidden"
                                       @change="
                                            if ($event.target.files.length > 0) {
                                                const reader = new FileReader();
                                                reader.onload = (e) => { ktpPreview = e.target.result; };
                                                reader.readAsDataURL($event.target.files[0]);
                                                ktpName = $event.target.files[0].name;
                                            } else {
                                                ktpPreview = null;
                                                ktpName = null;
                                            }
                                       ">
                                <label for="ktp_photo" class="mt-1 flex justify-center w-full h-32 px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 transition bg-gray-50 dark:bg-gray-900/50">
                                    <div class="space-y-1 text-center" x-show="!ktpPreview">
                                        <i class="fas fa-id-card fa-2x text-gray-400"></i>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload</p>
                                        <p class="text-xs text-gray-500">JPG, PNG. maks 5MB</p>
                                    </div>
                                    <div x-show="ktpPreview" class="relative" x-cloak>
                                        <img :src="ktpPreview" class="h-24 object-contain rounded-md">
                                    </div>
                                </label>
                                <div x-show="ktpName" class="mt-2 text-xs text-gray-500" x-cloak>
                                    <p>File dipilih: <span x-text="ktpName"></span></p>
                                </div>
                                <x-input-error :messages="$errors->get('ktp_photo')" class="mt-2" />
                            </div>
                        </div>
                        {{-- END: PERBAIKAN UPLOAD BERKAS DENGAN PREVIEW --}}
                    </div>
                    {{-- END: KOLOM KANAN --}}
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Pengaduan
                    </button>
                </div>
            </div>
        </form>
        {{-- END: FORM PENGADUAN BARU --}}
    </div>
</x-app-layout>