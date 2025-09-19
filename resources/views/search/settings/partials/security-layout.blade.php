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

        {{-- KOTAK 2: AUTENTIKASI DUA FAKTOR (2FA) --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt fa-lg text-green-500 dark:text-green-400"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            Autentikasi Dua Faktor (2FA)
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Tambahkan lapisan keamanan ekstra untuk akun Anda.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 sm:p-8">
                <div class="space-y-4">
                    {{-- Opsi SMS --}}
                    <div class="flex items-center justify-between p-4 border rounded-lg" :class="smsAuth ? 'border-green-300 dark:border-green-700 bg-green-50/50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700'">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-sms fa-lg" :class="smsAuth ? 'text-green-500' : 'text-gray-400'"></i>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">SMS Authentication</p>
                                <p class="text-xs text-gray-500">Terima kode verifikasi melalui SMS.</p>
                            </div>
                        </div>
                        <button @click="smsAuth = !smsAuth; update2FA('sms', smsAuth)" class="px-4 py-2 text-xs font-semibold rounded-lg transition" :class="smsAuth ? 'text-red-700 bg-red-100 hover:bg-red-200' : 'text-green-700 bg-green-100 hover:bg-green-200'">
                            <span x-text="smsAuth ? 'Nonaktifkan' : 'Aktifkan'"></span>
                        </button>
                    </div>

                    {{-- Opsi Email --}}
                    <div class="flex items-center justify-between p-4 border rounded-lg" :class="emailAuth ? 'border-green-300 dark:border-green-700 bg-green-50/50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700'">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-envelope fa-lg" :class="emailAuth ? 'text-green-500' : 'text-gray-400'"></i>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Email Authentication</p>
                                <p class="text-xs text-gray-500">Terima kode verifikasi melalui email.</p>
                            </div>
                        </div>
                        <button @click="emailAuth = !emailAuth; update2FA('email', emailAuth)" class="px-4 py-2 text-xs font-semibold rounded-lg transition" :class="emailAuth ? 'text-red-700 bg-red-100 hover:bg-red-200' : 'text-green-700 bg-green-100 hover:bg-green-200'">
                             <span x-text="emailAuth ? 'Nonaktifkan' : 'Aktifkan'"></span>
                        </button>
                    </div>
                </div>
                {{-- Status Message untuk 2FA --}}
                <p x-show="status2FA" x-transition class="text-sm text-gray-600 dark:text-gray-400 mt-4" x-text="status2FA"></p>
            </div>
        </div>

        {{-- KOTAK 3: AKTIVITAS LOGIN --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-globe-asia fa-lg text-blue-500 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            Aktivitas Login
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Pantau aktivitas login dan sesi aktif Anda.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 sm:p-8">
                <div class="space-y-3">
                    {{-- Sesi Saat Ini --}}
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Chrome di Windows <span class="text-xs text-gray-500 font-normal">&bull; Jakarta, Indonesia</span></p>
                                <p class="text-xs text-green-600 dark:text-green-400 font-semibold">Aktif sekarang</p>
                            </div>
                        </div>
                    </div>
                    {{-- Sesi Lain --}}
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Mobile App <span class="text-xs text-gray-500 font-normal">&bull; Android &bull; Jakarta, Indonesia</span></p>
                                <p class="text-xs text-gray-500">2 jam yang lalu</p>
                            </div>
                        </div>
                        <button class="px-4 py-2 text-xs font-semibold text-red-700 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 rounded-lg transition">
                            Akhiri Sesi
                        </button>
                    </div>
                    {{-- Sesi Lain 2 --}}
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200">Firefox <span class="text-xs text-gray-500 font-normal">&bull; Windows &bull; Bandung, Indonesia</span></p>
                                <p class="text-xs text-gray-500">1 hari yang lalu</p>
                            </div>
                        </div>
                        <button class="px-4 py-2 text-xs font-semibold text-red-700 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 rounded-lg transition">
                            Akhiri Sesi
                        </button>
                    </div>
                </div>

                <div class="mt-6 border-t dark:border-gray-700 pt-4 flex justify-end">
                    <button class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-700 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                        <i class="fas fa-times-circle"></i>
                        Akhiri Semua Sesi Lain
                    </button>
                </div>
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