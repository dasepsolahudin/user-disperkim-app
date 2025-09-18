<section x-data="{
    // Inisialisasi state dari preferensi pengguna di database
    push: {{ json_encode(auth()->user()->notification_preferences['push_notification'] ?? false) }},
    email: {{ json_encode(auth()->user()->notification_preferences['email_notification'] ?? false) }},
    sms: {{ json_encode(auth()->user()->notification_preferences['sms_notification'] ?? false) }},
    autoSave: {{ json_encode(auth()->user()->notification_preferences['auto_save'] ?? false) }},
    status: '', // Untuk feedback setelah menyimpan

    // Fungsi untuk mengirim form secara otomatis jika autoSave aktif
    submitForm() {
        this.status = 'Menyimpan...';

        let formData = new FormData();
        formData.append('push_notification', this.push ? 1 : 0);
        formData.append('email_notification', this.email ? 1 : 0);
        formData.append('sms_notification', this.sms ? 1 : 0);
        formData.append('auto_save', this.autoSave ? 1 : 0);
        formData.append('_method', 'PATCH');
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('settings.notifications.update') }}', {
            method: 'POST', // Ganti ke POST untuk kompatibilitas form-data
            body: formData,
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                this.status = 'Perubahan disimpan.';
            } else {
                this.status = 'Gagal menyimpan perubahan.';
            }
            setTimeout(() => this.status = '', 2000);
        })
        .catch(() => {
            this.status = 'Terjadi kesalahan.';
            setTimeout(() => this.status = '', 2000);
        });
    }
}" x-on:change="if (autoSave) { submitForm() }">
    <header class="mb-6">
        <div class="bg-blue-100 dark:bg-gray-800/50 rounded-lg p-4">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-300 dark:bg-green-900/50 text-blue-700 dark:text-blue-400 flex items-center justify-center rounded-lg">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Preferensi Notifikasi
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Atur cara Anda menerima pemberitahuan dari aplikasi.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <form x-ref="notificationForm" @submit.prevent="submitForm" class="space-y-4">
        {{-- Notification Cards --}}
        <div class="space-y-3">
            {{-- Notifikasi Push --}}
            <div class="bg-white dark:bg-gray-800/50 p-4 rounded-lg border dark:border-gray-200 dark:border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-mobile-alt text-gray-400 fa-lg w-6 text-center"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Notifikasi Push</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terima notifikasi langsung di aplikasi</p>
                    </div>
                </div>
                {{-- Toggle Switch Push --}}
                <div @click="push = !push; $dispatch('change')" role="switch" :aria-checked="push.toString()" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="push ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-600'">
                    <span aria-hidden="true" :class="push ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </div>
            </div>

            {{-- Notifikasi Email --}}
            <div class="bg-white dark:bg-gray-800/50 p-4 rounded-lg border dark:border-gray-200 dark:border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-envelope text-gray-400 fa-lg w-6 text-center"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Notifikasi Email</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terima notifikasi melalui email</p>
                    </div>
                </div>
                 <div @click="email = !email; $dispatch('change')" role="switch" :aria-checked="email.toString()" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="email ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-600'">
                    <span aria-hidden="true" :class="email ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </div>
            </div>

            {{-- Notifikasi SMS --}}
            <div class="bg-white dark:bg-gray-800/50 p-4 rounded-lg border dark:border-gray-200 dark:border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-comment-alt text-gray-400 fa-lg w-6 text-center"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Notifikasi SMS</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terima notifikasi melalui SMS</p>
                    </div>
                </div>
                 <div @click="sms = !sms; $dispatch('change')" role="switch" :aria-checked="sms.toString()" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="sms ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-600'">
                    <span aria-hidden="true" :class="sms ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </div>
            </div>
            
             {{-- Penyimpanan Otomatis --}}
            <div class="bg-white dark:bg-gray-800/50 p-4 rounded-lg border dark:border-gray-200 dark:border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-save text-gray-400 fa-lg w-6 text-center"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Penyimpanan Otomatis</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Simpan perubahan secara otomatis</p>
                    </div>
                </div>
                 <div @click="autoSave = !autoSave; $dispatch('change')" role="switch" :aria-checked="autoSave.toString()" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="autoSave ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-600'">
                    <span aria-hidden="true" :class="autoSave ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-4 pt-4" x-show="!autoSave">
            <x-primary-button>
                 Simpan Perubahan
            </x-primary-button>
        </div>
        
        <p x-show="status" x-transition class="text-sm text-gray-600 dark:text-gray-400" x-text="status"></p>

    </form>
</section>