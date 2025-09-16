{{-- Logo dan Tombol Toggle --}}
{{-- Ganti warna border, teks, dan background hover --}}
<div class="flex items-center justify-between h-16 px-4 border-b border-indigo-800">
    <div class="flex items-center transition-opacity duration-200" :class="{ 'opacity-100': sidebarOpen, 'opacity-0 w-0 lg:opacity-100 lg:w-auto': !sidebarOpen }">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <div class="bg-white text-indigo-700 font-bold text-xl rounded-md w-8 h-8 flex items-center justify-center flex-shrink-0">D</div>
            <div class="ml-3" x-show="sidebarOpen">
                <p class="text-sm font-bold text-white whitespace-nowrap">Disperkim</p>
            </div>
        </a>
    </div>
    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-indigo-200 hover:bg-indigo-600 focus:outline-none">
        <i class="fas" :class="{ 'fa-chevron-left': sidebarOpen, 'fa-chevron-right': !sidebarOpen }"></i>
    </button>
</div>

{{-- Navigasi Menu --}}
{{-- Ganti warna teks dan background aktif/hover --}}
<nav class="flex-1 mt-4 px-3 space-y-2">
    <a href="{{ route('dashboard') }}"
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-600 hover:text-white' }}">
        <i class="fas fa-home fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Dashboard') }}</span>
    </a>
    <a href="{{ route('complaints.create') }}"
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('complaints.create') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-600 hover:text-white' }}">
        <i class="fas fa-plus-circle fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Buat Laporan Baru') }}</span>
    </a>
    <a href="{{ route('complaints.index') }}"
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('complaints.index') || request()->routeIs('complaints.show') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-600 hover:text-white' }}">
        <i class="fas fa-folder-open fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Pengaduan Saya') }}</span>
    </a>

    <a href="{{ route('map') }}"
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('map') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-600 hover:text-white' }}">
        <i class="fas fa-map-marked-alt fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Peta') }}</span>
    </a>

    <div class="pt-2"><hr class="border-t border-indigo-800"></div>

    <a href="{{ route('settings.edit', 'profile') }}"
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('settings.edit') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-600 hover:text-white' }}">
        <i class="fas fa-cog fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Pengaturan') }}</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); this.closest('form').submit();"
           class="flex items-center p-3 rounded-lg text-sm font-medium text-indigo-200 hover:bg-indigo-600 hover:text-white transition-colors">
            <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
            <span class="ml-3" x-show="sidebarOpen">{{ __('Logout') }}</span>
        </a>
    </form>
</nav>

{{-- Footer Sidebar --}}
{{-- Ganti warna background dan teks footer --}}
<div class="p-4 mt-auto" x-show="sidebarOpen">
    <div class="bg-indigo-800 text-indigo-300 text-center p-4 rounded-lg">
        <p class="text-xs font-semibold">© 2025 Disperkim Kab Garut</p>
        <p class="text-xs">v1.0.0</p>
    </div>
</div>