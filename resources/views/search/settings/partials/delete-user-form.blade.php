{{-- PERBAIKAN: Menghapus class max-w-2xl mx-auto agar tata letak mengikuti halaman utama --}}
<section class="space-y-6" x-data="{ confirmingDeletion: false, password: '', confirmText: '', agreed: [] }">
    {{-- HEADER --}}
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center">
            <i class="fas fa-trash-alt fa-xl text-red-500 dark:text-red-400"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Hapus Akun Permanen') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.') }}
            </p>
        </div>
    </div>

    {{-- KOTAK PERINGATAN PENTING --}}
    <div class="p-4 border-l-4 border-red-400 bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-300 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
            <h4 class="font-bold">Peringatan Penting</h4>
        </div>
        <ul class="mt-2 text-sm list-disc list-inside space-y-1 pl-8">
            <li>Semua data profil dan riwayat akan dihapus permanen.</li>
            <li>Akses ke layanan Disperkim akan dicabut.</li>
            <li>Proses penghapusan tidak dapat dibatalkan.</li>
            <li>Backup data tidak akan tersedia setelah penghapusan.</li>
        </ul>
    </div>

    {{-- Tombol ini sekarang akan menampilkan form konfirmasi di bawah, bukan modal --}}
    <div class="mt-8 flex justify-center" x-show="!confirmingDeletion">
        <x-danger-button @click="confirmingDeletion = true" class="w-full md:w-auto justify-center text-base px-8 py-3">
            <i class="fas fa-trash-alt mr-2"></i>
            Mulai Proses Penghapusan Akun
        </x-danger-button>
    </div>

    {{-- Bagian ini (sebelumnya modal) sekarang menjadi form yang bisa ditampilkan/disembunyikan --}}
    <div x-show="confirmingDeletion" 
         class="mt-6 p-6 md:p-8 border border-red-300 dark:border-red-700 bg-red-50/50 dark:bg-red-900/20 rounded-lg space-y-6"
         style="display: none;">
        
        <form method="post" action="{{ route('settings.account.destroy') }}" class="space-y-6">
            @csrf
            @method('delete')

            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Konfirmasi Penghapusan Akun') }}
                </h2>
                <button type="button" @click="confirmingDeletion = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Centang semua kotak di bawah ini untuk melanjutkan:') }}
            </p>

            {{-- CHECKBOX KONFIRMASI --}}
            <div class="space-y-3 text-sm text-red-700 dark:text-red-400">
                <label class="flex items-start">
                    <input type="checkbox" name="agree[]" value="understand" x-model="agreed" class="mt-1 mr-3 rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500">
                    <span>Saya memahami bahwa tindakan ini akan menghapus akun saya secara permanen.</span>
                </label>
                <label class="flex items-start">
                    <input type="checkbox" name="agree[]" value="backup" x-model="agreed" class="mt-1 mr-3 rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500">
                    <span>Saya telah membuat backup semua data penting yang diperlukan.</span>
                </label>
                 <label class="flex items-start">
                    <input type="checkbox" name="agree[]" value="irreversible" x-model="agreed" class="mt-1 mr-3 rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500">
                    <span>Saya menyadari bahwa penghapusan ini bersifat permanen dan tidak dapat dibatalkan.</span>
                </label>
            </div>

            {{-- INPUT KONFIRMASI TEKS --}}
            <div>
                <x-input-label for="confirm_text" value="Ketik 'HAPUS AKUN SAYA' untuk mengonfirmasi:" />
                <x-text-input id="confirm_text" name="confirm_text" type="text" class="mt-1 block w-full" x-model="confirmText" />
            </div>

            {{-- INPUT PASSWORD --}}
            <div class="relative" x-data="{ showPassword: false }">
                <x-input-label for="password" value="{{ __('Masukkan password Anda untuk konfirmasi:') }}" />
                <x-text-input id="password" name="password" x-bind:type="showPassword ? 'text' : 'password'" class="mt-1 block w-full" x-model="password" />
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-sm leading-5 text-gray-500 dark:text-gray-400">
                    <i class="fas" x-bind:class="{ 'fa-eye': !showPassword, 'fa-eye-slash': showPassword }"></i>
                </button>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            
            {{-- TOMBOL AKSI MODAL --}}
            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button type="button" @click="confirmingDeletion = false">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button x-bind:disabled="agreed.length < 3 || confirmText !== 'HAPUS AKUN SAYA' || password === ''">
                     <i class="fas fa-trash-alt mr-2"></i>
                    {{ __('Hapus Akun Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</section>

