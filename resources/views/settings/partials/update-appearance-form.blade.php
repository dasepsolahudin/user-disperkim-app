<section x-data="{
    isDark: localStorage.getItem('theme') === 'dark',
    languageOpen: false,
    selectedLanguage: 'Bahasa Indonesia',

    toggleTheme() {
        this.isDark = !this.isDark;
        if (this.isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    },

    init() {
        // Terapkan tema saat komponen dimuat
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="init()">
    <header class="mb-6 pb-6 border-b border-slate-200">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-purple-100 text-purple-600 flex items-center justify-center rounded-lg">
                    <i class="fas fa-paint-brush"></i>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-medium text-slate-900">
                    Pengaturan Tampilan
                </h2>
                <p class="mt-1 text-sm text-slate-600">
                    Sesuaikan tampilan aplikasi sesuai preferensi Anda.
                </p>
            </div>
        </div>
    </header>

    <div class="space-y-4">
        {{-- Pengaturan Mode Gelap --}}
        <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-2 rounded-lg">
                    <i class="fas fa-palette text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-slate-800">Mode Gelap</h3>
                    <p class="text-sm text-slate-500">Aktifkan tema gelap untuk kenyamanan mata.</p>
                </div>
            </div>
            <button @click="toggleTheme()" 
                    role="switch" 
                    :aria-checked="isDark.toString()" 
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    :class="isDark ? 'bg-indigo-600' : 'bg-slate-200'">
                <span aria-hidden="true" 
                      :class="isDark ? 'translate-x-5' : 'translate-x-0'" 
                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>

        {{-- Pengaturan Bahasa Aplikasi --}}
<div x-data="{ languageOpen: false }" class="bg-white p-4 rounded-xl border border-slate-200">
    <div @click="languageOpen = !languageOpen" class="flex items-center justify-between cursor-pointer">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-100 p-2 rounded-lg">
                <i class="fas fa-globe text-blue-600"></i>
            </div>
            <div>
                <h3 class="font-medium text-slate-800">Bahasa Aplikasi</h3>
                {{-- Menampilkan bahasa yang sedang aktif --}}
                <p class="text-sm text-slate-500">{{ app()->getLocale() == 'id' ? 'ID Bahasa Indonesia' : '' }}</p>
            </div>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': languageOpen }"></i>
    </div>

    {{-- Pilihan Link Bahasa --}}
    <div x-show="languageOpen" x-transition class="mt-4 pt-4 border-t">
        <div class="space-y-2">
            {{-- Link untuk mengubah ke Bahasa Indonesia --}}
            <a href="?lang=id" class="block px-3 py-2 text-sm rounded-md hover:bg-slate-100">
                Bahasa Indonesia
            </a>
            
        </div>
    </div>
</div>
        </div>
    </div>
</section>

