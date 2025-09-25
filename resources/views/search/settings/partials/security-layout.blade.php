{{-- PERBAIKAN: Kesalahan penulisan pada div pembuka di bawah ini telah diperbaiki --}}
<div x-data="{
    // === STATES ===
    smsAuth: {{ auth()->user()->two_factor_sms_enabled ? 'true' : 'false' }},
    emailAuth: {{ auth()->user()->two_factor_email_enabled ? 'true' : 'false' }},
    newDeviceLogin: {{ auth()->user()->notification_push ? 'true' : 'false' }},
    passwordChange: {{ auth()->user()->notification_email ? 'true' : 'false' }},
    suspiciousActivity: {{ auth()->user()->notification_sms ? 'true' : 'false' }},
    status2FA: '',
    statusNotif: '',

    // === FUNCTIONS ===
    update2FA(method, value) {
        this.status2FA = 'Menyimpan...';
        let data = {};
        data[method] = value;

        fetch('{{ route('settings.2fa.update') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                _method: 'PATCH',
                ...data
            })
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                this.status2FA = 'Perubahan disimpan.';
            } else {
                this.status2FA = 'Gagal menyimpan.';
            }
            setTimeout(() => this.status2FA = '', 3000);
        })
        .catch(() => {
            this.status2FA = 'Terjadi kesalahan.';
            if (method === 'sms') this.smsAuth = !value;
            if (method === 'email') this.emailAuth = !value;
            setTimeout(() => this.status2FA = '', 3000);
        });
    },

    updateNotification(preference, value) {
        this.statusNotif = 'Menyimpan...';
        
        let formData = new FormData();
        formData.append(preference, value ? 1 : 0);
        formData.append('_method', 'PATCH');
        
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
                this.statusNotif = 'Perubahan disimpan.';
            } else {
                this.statusNotif = 'Gagal menyimpan.';
            }
            setTimeout(() => this.statusNotif = '', 2000);
        }).catch(() => {
            this.statusNotif = 'Terjadi kesalahan.';
            setTimeout(() => this.statusNotif = '', 2000);
        });
    }
}">

    <div class="space-y-8">

        {{-- KOTAK 1: UBAH PASSWORD --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lock fa-lg text-red-500 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            Ubah Password
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Perbarui password Anda untuk menjaga keamanan akun.
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-6 sm:p-8">
@include('search.settings.partials.update-password-form')       
     </div>
        </div>

      
        
        {{-- KOTAK 4: NOTIFIKASI KEAMANAN --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bell fa-lg text-purple-500 dark:text-purple-400"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            Notifikasi Keamanan
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Atur pemberitahuan untuk aktivitas keamanan.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 sm:p-8">
                <div class="space-y-4">
                    {{-- Opsi Login Perangkat Baru --}}
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-mobile-alt fa-lg text-gray-500 dark:text-gray-400"></i>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Login dari Perangkat Baru</p>
                                <p class="text-xs text-gray-500">Notifikasi saat login dari perangkat yang tidak dikenal.</p>
                            </div>
                        </div>
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" class="sr-only" x-model="newDeviceLogin" @change="updateNotification('notification_push', newDeviceLogin)">
                                <div class="block w-14 h-8 rounded-full" :class="newDeviceLogin ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform" :class="{ 'transform translate-x-6': newDeviceLogin }"></div>
                            </div>
                        </label>
                    </div>
                    {{-- Opsi Perubahan Password --}}
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-key fa-lg text-gray-500 dark:text-gray-400"></i>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Perubahan Password</p>
                                <p class="text-xs text-gray-500">Notifikasi saat password berhasil diubah.</p>
                            </div>
                        </div>
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" class="sr-only" x-model="passwordChange" @change="updateNotification('notification_email', passwordChange)">
                                <div class="block w-14 h-8 rounded-full" :class="passwordChange ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform" :class="{ 'transform translate-x-6': passwordChange }"></div>
                            </div>
                        </label>
                    </div>
                    {{-- Opsi Aktivitas Mencurigakan --}}
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-exclamation-triangle fa-lg text-gray-500 dark:text-gray-400"></i>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Aktivitas Mencurigakan</p>
                                <p class="text-xs text-gray-500">Notifikasi untuk aktivitas yang tidak biasa.</p>
                            </div>
                        </div>
                         <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" class="sr-only" x-model="suspiciousActivity" @change="updateNotification('notification_sms', suspiciousActivity)">
                                <div class="block w-14 h-8 rounded-full" :class="suspiciousActivity ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform" :class="{ 'transform translate-x-6': suspiciousActivity }"></div>
                            </div>
                        </label>
                    </div>
                </div>
                {{-- Status Message untuk Notifikasi --}}
                 <p x-show="statusNotif" x-transition class="text-sm text-gray-600 dark:text-gray-400 mt-4" x-text="statusNotif"></p>
            </div>
        </div>
    </div>
</div>