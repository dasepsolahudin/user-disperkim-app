{{-- Logo dan Tombol Toggle --}}
<div class="flex items-center justify-between h-16 px-4 border-b border-slate-200 dark:border-gray-800">
    <div class="flex items-center transition-opacity duration-200" :class="{ 'opacity-100': sidebarOpen, 'opacity-0 w-0 lg:opacity-100 lg:w-auto': !sidebarOpen }">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <div class="bg-indigo-600 text-white font-bold text-xl rounded-md w-8 h-8 flex items-center justify-center flex-shrink-0">D</div>
            <div class="ml-3" x-show="sidebarOpen">
                <p class="text-sm font-bold text-slate-800 dark:text-gray-200 whitespace-nowrap">Disperkim</p>
            </div>
        </a>
    </div>
    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
        <i class="fas" :class="{ 'fa-chevron-left': sidebarOpen, 'fa-chevron-right': !sidebarOpen }"></i>
    </button>
</div>

{{-- Navigasi Menu --}}
<nav class="flex-1 mt-4 px-3 space-y-2">
    <a href="{{ route('dashboard') }}" 
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
        <i class="fas fa-home fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Dashboard') }}</span>
    </a>
    <a href="{{ route('complaints.create') }}" 
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('complaints.create') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
        <i class="fas fa-plus-circle fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Buat Laporan Baru') }}</span>
    </a>
    <a href="{{ route('complaints.index') }}" 
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('complaints.index') || request()->routeIs('complaints.show') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
        <i class="fas fa-folder-open fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Pengaduan Saya') }}</span>
    </a>

    <div class="pt-2"><hr class="border-t border-slate-200 dark:border-gray-800"></div>

    <a href="{{ route('settings.edit', 'profile') }}" 
       class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors
              {{ request()->routeIs('settings.edit') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
        <i class="fas fa-cog fa-fw w-6 text-center"></i>
        <span class="ml-3" x-show="sidebarOpen">{{ __('Pengaturan') }}</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); this.closest('form').submit();"
           class="flex items-center p-3 rounded-lg text-sm font-medium text-gray-400 hover:bg-gray-900 hover:text-white transition-colors">
            <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
            <span class="ml-3" x-show="sidebarOpen">{{ __('Logout') }}</span>
        </a>
    </form>
</nav>

{{-- Footer Sidebar --}}
<div class="p-4 mt-auto" x-show="sidebarOpen">
    <div class="bg-slate-100 dark:bg-gray-900/50 text-slate-600 dark:text-gray-400 text-center p-4 rounded-lg border border-slate-200 dark:border-gray-800">
        <p class="text-xs font-semibold">© 2025 Disperkim Kab Garut</p>
        <p class="text-xs">v1.0.0</p>
    </div>
</div>