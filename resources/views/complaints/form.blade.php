<x-app-layout>
    <div class="space-y-6" x-data="{
        ktpPreview: null,
        ktpName: null,
        buktiFiles: [],
    }">
        {{-- START: HEADER KUSTOM --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pengaduan Masyarakat</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Isi dan submit pengaduan untuk perbaikan layanan.
            </p>
        </div>
        {{-- END: HEADER KUSTOM --}}

        {{-- START: NAVIGASI TAB --}}
        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-sm flex items-center space-x-2">
            <a href="{{ route('complaints.index') }}" class="w-1/2 text-center py-2 px-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-8">
                    
                    {{-- START: KOLOM KIRI (Data Pengaduan) --}}
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="title" value="Judul Pengaduan *" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required placeholder="Cth: Jalan rusak di Kampung Sindangheula" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="category" value="Kategori *" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="rutilahu" {{ old('category', $category ?? '') == 'rutilahu' ? 'selected' : '' }}>Rutilahu</option>
                                <option value="infrastruktur" {{ old('category', $category ?? '') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="tata_kota" {{ old('category', $category ?? '') == 'tata_kota' ? 'selected' : '' }}>Tata Kota</option>
                                <option value="air_bersih_sanitasi" {{ old('category', $category ?? '') == 'air_bersih_sanitasi' ? 'selected' : '' }}>Air Bersih & Sanitasi</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

 <div>
                            <x-input-label for="priority" value="Prioritas *" />
                            <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="Rendah" {{ old('priority') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ old('priority', 'Sedang') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ old('priority') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Deskripsi Pengaduan *" />
                            <textarea id="description" name="description" rows="23" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Jelaskan detail pengaduan Anda selengkap mungkin...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                    {{-- END: KOLOM KIRI --}}

                    {{-- START: KOLOM KANAN (Alamat & Berkas) --}}
                    <div class="space-y-8">
                        {{-- Seksi Alamat --}}
                        <div class="space-y-6">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Alamat Lengkap Sesuai KTP</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="kabupaten" value="Kabupaten *" />
                                    <x-text-input id="kabupaten" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700/50 cursor-not-allowed" type="text" name="kabupaten" value="Garut" readonly />
                                </div>
                                <div>
                                    <x-input-label for="kecamatan" value="Kecamatan *" />
                                    <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" :value="old('kecamatan')" required placeholder="Cth: Tarogong Kidul" />
                                    <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="desa" value="Desa / Kelurahan *" />
                                    <x-text-input id="desa" class="block mt-1 w-full" type="text" name="desa" :value="old('desa')" required placeholder="Cth: Sukagalih" />
                                    <x-input-error :messages="$errors->get('desa')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="kampung" value="Kampung *" />
                                    <x-text-input id="kampung" class="block mt-1 w-full" type="text" name="kampung" :value="old('kampung')" required placeholder="Cth: Kp. Sindangheula" />
                                    <x-input-error :messages="$errors->get('kampung')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="rt_rw" value="RT/RW *" />
                                    <x-text-input id="rt_rw" class="block mt-1 w-full" type="text" name="rt_rw" :value="old('rt_rw')" placeholder="Contoh: 001/005" required />
                                    <x-input-error :messages="$errors->get('rt_rw')" class="mt-2" />
                                </div>
                                {{-- NOMOR TELEPON --}}
                                <div>
                                    <x-input-label for="phone_number" value="Nomor Telepon (WhatsApp) *" />
                                    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required placeholder="Cth: 081234567890" />
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Seksi Upload Berkas --}}
                        <div class="space-y-6">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200">Upload Berkas</h3>
                            
                            {{-- UPLOAD FOTO KTP --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto KTP (Wajib)</label>
                                <input type="file" id="foto_ktp" name="foto_ktp" class="hidden" required @change="
                                    if ($event.target.files.length > 0) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => { ktpPreview = e.target.result; };
                                        reader.readAsDataURL($event.target.files[0]);
                                        ktpName = $event.target.files[0].name;
                                    } else {
                                        ktpPreview = null; ktpName = null;
                                    }">
                                <label for="foto_ktp" class="mt-1 flex justify-center w-full h-32 px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 transition bg-gray-50 dark:bg-gray-900/50">
                                    <div class="space-y-1 text-center flex flex-col justify-center items-center" x-show="!ktpPreview">
                                        <i class="fas fa-id-card fa-2x text-gray-400"></i>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload</p>
                                        <p class="text-xs text-gray-500">JPG, PNG, maks 2MB</p>
                                    </div>
                                    <div x-show="ktpPreview" class="relative" x-cloak>
                                        <img :src="ktpPreview" class="h-24 object-contain rounded-md">
                                    </div>
                                </label>
                                <div x-show="ktpName" class="mt-2 text-xs text-gray-500" x-cloak>
                                    <p>File dipilih: <span class="font-semibold" x-text="ktpName"></span></p>
                                </div>
                                <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
                            </div>
                            
                            {{-- UPLOAD FOTO BUKTI --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Bukti (Wajib, bisa lebih dari 1)</label>
                                <label for="photos" class="mt-1 flex justify-center w-full h-32 px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 transition bg-gray-50 dark:bg-gray-900/50">
                                     <div class="space-y-1 text-center flex flex-col justify-center items-center">
                                        <i class="fas fa-camera fa-2x text-gray-400"></i>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload</p>
                                        <p class="text-xs text-gray-500">JPG, PNG, maks 2MB per file</p>
                                    </div>
                                </label>
                                <input type="file" id="photos" name="photos[]" class="hidden" multiple required @change="buktiFiles = Array.from($event.target.files)">
                                <div x-show="buktiFiles.length > 0" class="mt-2 text-xs text-gray-500" x-cloak>
                                    <p><span x-text="buktiFiles.length" class="font-semibold"></span> file dipilih.</p>
                                    <ul class="list-disc pl-4 mt-1">
                                       <template x-for="file in buktiFiles" :key="file.name">
                                            <li x-text="file.name"></li>
                                       </template>
                                    </ul>
                                </div>
                                <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                                <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                            </div>
                        </div>
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

