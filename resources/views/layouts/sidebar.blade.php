<aside class="w-64 bg-green-50 min-h-screen p-4">
    <div class="flex items-center gap-2 mb-6">
        <div class="w-10 h-10 bg-green-600 text-white flex items-center justify-center rounded-lg font-bold">
            D
        </div>
        <span class="font-semibold text-gray-800">Disperkim</span>
    </div>

    <ul class="space-y-2">
        <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 p-2 rounded-lg transition 
                      {{ request()->routeIs('dashboard') ? 'bg-green-600 text-white' : 'hover:bg-gray-200 text-gray-700' }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            {{-- KODE YANG DIPERBAIKI --}}
            <a href="{{ route('settings.edit') }}"
               class="flex items-center gap-2 p-2 rounded-lg transition 
                      {{ request()->routeIs('settings.*') ? 'bg-green-600 text-white' : 'hover:bg-gray-200 text-gray-700' }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
            
        </li>

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 w-full text-left p-2 rounded-lg transition hover:bg-gray-200 text-gray-700">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>
    </ul>

    <div class="absolute bottom-4 left-4 text-xs text-gray-500">
        © 2025 Disperkim Kab Garut <br> v1.0.0
    </div>
</aside>
