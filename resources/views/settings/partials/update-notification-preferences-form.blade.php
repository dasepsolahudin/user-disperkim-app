<section x-data="{
    push: {{ auth()->user()->notification_push ? 'true' : 'false' }},
    email: {{ auth()->user()->notification_email ? 'true' : 'false' }},
    sms: {{ auth()->user()->notification_sms ? 'true' : 'false' }},
    autoSave: {{ auth()->user()->auto_save ? 'true' : 'false' }},
    status: '',
    submitForm() {
        let formData = new FormData(this.$refs.notificationForm);
        
        // Append correct boolean values
        formData.set('notification_push', this.push ? 1 : 0);
        formData.set('notification_email', this.email ? 1 : 0);
        formData.set('notification_sms', this.sms ? 1 : 0);
        formData.set('auto_save', this.autoSave ? 1 : 0);

        fetch('{{ route('settings.notifications.update') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                this.status = 'Perubahan disimpan.';
                setTimeout(() => this.status = '', 2000);
            }
        }).catch(() => {
            this.status = 'Gagal menyimpan perubahan.';
            setTimeout(() => this.status = '', 2000);
        });
    }
}" x-on:change="if (autoSave) { submitForm() }">
    <header class="mb-6">
        {{-- Header Box with Green Background --}}
        <div class="bg-blue-100 dark:bg-gray-700/50 rounded-lg p-4">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-300 dark:bg-green-900/50 text-blue-700 dark:text-blue-400 flex items-center justify-center rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
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
        @csrf
        @method('PATCH')

        {{-- Notification Cards --}}
        <div class="space-y-3">
            {{-- Push Notification --}}
            <div class="bg-white dark:bg-gray-800/50 p-4 rounded-lg border dark:border-gray-200 dark:border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-mobile-alt text-gray-400 fa-lg w-6 text-center"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Notifikasi Push</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terima notifikasi langsung di aplikasi</p>
                    </div>
                </div>
                <div @click="push = !push; $dispatch('change')" role="switch" :aria-checked="push.toString()" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out" :class="push ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-600'">
                    <span aria-hidden="true" :class="push ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </div>
            </div>

            {{-- Email Notification --}}
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

            {{-- SMS Notification --}}
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
            
             {{-- Auto Save --}}
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
