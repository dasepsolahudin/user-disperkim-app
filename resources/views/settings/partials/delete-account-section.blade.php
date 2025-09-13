<section class="space-y-6">
    <div class="text-left mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Hapus Akun Aplikasi</h2>
        <p class="text-gray-500 mt-1">Kelola preferensi dan konfigurasi aplikasi Disperkim Anda</p>
    </div>

    {{-- Kotak Peringatan Utama --}}
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-red-100 text-red-600 flex items-center justify-center rounded-full">
                    <i class="fas fa-trash-alt fa-lg"></i>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-800">
                    Hapus Akun Permanen
                </h3>
                <p class="mt-1 text-sm text-red-700">
                    Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
                </p>
            </div>
        </div>
    </div>

    {{-- Kotak Peringatan Penting --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="text-yellow-500 mt-1">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-yellow-900">
                    Peringatan Penting
                </h3>
                <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-yellow-800">
                    <li>Semua data profil dan riwayat akan dihapus permanen</li>
                    <li>Akses ke layanan Disperkim akan dicabut</li>
                    <li>Proses penghapusan tidak dapat dibatalkan</li>
                    <li>Backup data tidak akan tersedia setelah penghapusan</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi Hapus --}}
    <div class="mt-6 flex justify-end">
        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <i class="fas fa-exclamation-circle mr-2"></i>
            Mulai Proses Penghapusan Akun
        </x-danger-button>
    </div>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div x-data="{
            confirmUnderstood: false,
            confirmBackup: false,
            confirmIrreversible: false,
            confirmText: '',
            passwordVisible: false,
            get canDelete() {
                return this.confirmUnderstood && this.confirmBackup && this.confirmIrreversible && this.confirmText === 'HAPUS AKUN SAYA';
            }
        }" class="p-6 bg-red-50">

            <form method="post" action="{{ route('settings.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                {{-- Header Modal --}}
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-100 text-red-600 flex items-center justify-center rounded-full">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-red-800">
                                Hapus Akun Permanen
                            </h2>
                            <p class="mt-1 text-sm text-red-700">
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>
                    <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Peringatan Penting --}}
                <div class="bg-red-100 border border-red-200 rounded-lg p-4">
                    <h3 class="font-bold text-red-900 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Peringatan Penting
                    </h3>
                    <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-red-800">
                        <li>Semua data profil dan riwayat akan dihapus permanen</li>
                        <li>Akses ke layanan Disperkim akan dicabut</li>
                        <li>Proses penghapusan tidak dapat dibatalkan</li>
                        <li>Backup data tidak akan tersedia setelah penghapusan</li>
                    </ul>
                </div>

                {{-- Konfirmasi Penghapusan Akun --}}
                <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-4">
                    <h3 class="font-semibold text-gray-800">Konfirmasi Penghapusan Akun</h3>
                    <p class="text-sm text-gray-600">Centang semua kotak di bawah ini untuk melanjutkan:</p>

                    <label class="flex items-start space-x-3">
                        <input type="checkbox" x-model="confirmUnderstood" class="mt-1 rounded text-red-600 focus:ring-red-500">
                        <span class="text-sm text-gray-700">Saya memahami bahwa tindakan ini akan menghapus akun saya secara permanen</span>
                    </label>
                    <label class="flex items-start space-x-3">
                        <input type="checkbox" x-model="confirmBackup" class="mt-1 rounded text-red-600 focus:ring-red-500">
                        <span class="text-sm text-gray-700">Saya telah membuat backup semua data penting yang diperlukan</span>
                    </label>
                    <label class="flex items-start space-x-3">
                        <input type="checkbox" x-model="confirmIrreversible" class="mt-1 rounded text-red-600 focus:ring-red-500">
                        <span class="text-sm text-gray-700">Saya menyadari bahwa penghapusan ini bersifat permanen dan tidak dapat dibatalkan</span>
                    </label>
                </div>

                {{-- Input Teks Konfirmasi & Password --}}
                <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-4">
                    <div>
                        <x-input-label for="confirm_text" value="Ketik 'HAPUS AKUN SAYA' untuk mengonfirmasi:" />
                        {{-- PERBAIKAN DI SINI: Menambahkan autocomplete="off" --}}
                        <x-text-input 
                            id="confirm_text" 
                            name="confirm_text" 
                            type="text" 
                            x-model.debounce.500ms="confirmText" 
                            class="mt-1 block w-full" 
                            placeholder="HAPUS AKUN SAYA"
                            autocomplete="off" />
                    </div>
                    <div>
                        <x-input-label for="password_modal" value="Masukkan password Anda untuk konfirmasi" />
                        <div class="relative">
                            <x-text-input 
                                id="password_modal" 
                                name="password" 
                                ::type="passwordVisible ? 'text' : 'password'"
                                class="mt-1 block w-full pr-10"
                                placeholder="Password Anda" 
                                required 
                            />
                            <button type="button" @click="passwordVisible = !passwordVisible" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                                <i class="fas" :class="passwordVisible ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                </div>

                {{-- Tombol Aksi Batal dan Hapus --}}
                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>

                    <x-danger-button x-bind:disabled="!canDelete" x-bind:class="{ 'opacity-50 cursor-not-allowed': !canDelete }">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Hapus Akun Permanen
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</section>

