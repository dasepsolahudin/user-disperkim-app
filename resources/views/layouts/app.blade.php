<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disperkim App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex bg-gray-50 text-gray-900">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-blue-600 text-white min-h-screen transition-all duration-300">
        <div class="flex items-center justify-between px-6 h-16 border-b border-blue-500">
            <h2 class="text-lg font-bold">Disperkim</h2>
            <button id="sidebarToggle" class="text-white focus:outline-none">
                ☰
            </button>
        </div>
        <nav class="mt-6 space-y-2 px-4">
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition">
                📊 <span class="ml-3">Dashboard</span>
            </a>
            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition">
                📝 <span class="ml-3">Pengaduan</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition">
                👤 <span class="ml-3">Profil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center p-2 rounded-lg hover:bg-blue-700 transition">
                    🚪 <span class="ml-3">Logout</span>
                </button>
            </form>
        </nav>

        <div class="absolute bottom-4 left-0 right-0 text-center text-xs text-blue-200">
            © 2024 Disperkim App v1.0.0
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="flex items-center justify-center h-16 bg-blue-600 text-white relative shadow">
            <h1 class="text-xl font-bold">Disperkim App</h1>
            <div class="absolute right-6">
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>

    <script>
        const toggleBtn = document.getElementById("sidebarToggle");
        const sidebar = document.getElementById("sidebar");

        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("-ml-64"); // sembunyikan sidebar
        });
    </script>
</body>
</html>
