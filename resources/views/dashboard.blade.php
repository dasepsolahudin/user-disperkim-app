<x-app-layout>
    <div class="space-y-6">

        <!-- Greeting -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="mt-2 text-gray-600">Kelola laporan pengaduan dan informasi Anda di sini.</p>
        </div>

        <!-- Ringkasan -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">📊 Ringkasan Laporan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-4xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</h4>
                    <p class="mt-2 text-gray-600">Total Laporan</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-4xl font-bold text-yellow-500">{{ $stats['in_progress'] ?? 0 }}</h4>
                    <p class="mt-2 text-gray-600">Dalam Proses</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="text-4xl font-bold text-green-600">{{ $stats['completed'] ?? 0 }}</h4>
                    <p class="mt-2 text-gray-600">Selesai</p>
                </div>

            </div>
        </div>

        <!-- Aksi Cepat -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">⚡ Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('complaints.create') }}" 
                   class="bg-blue-600 text-white p-6 rounded-xl shadow hover:bg-blue-700 hover:shadow-lg transition">
                    <h4 class="font-bold text-xl">Buat Pengaduan</h4>
                    <p class="mt-2 text-blue-100">Laporkan masalah Anda sekarang.</p>
                </a>

                <a href="{{ route('complaints.index') }}" 
                   class="bg-white border p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="font-bold text-xl text-gray-800">Riwayat Laporan</h4>
                    <p class="mt-2 text-gray-600">Lihat laporan yang pernah Anda buat.</p>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="bg-white border p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h4 class="font-bold text-xl text-gray-800">Profil Saya</h4>
                    <p class="mt-2 text-gray-600">Kelola informasi pribadi Anda.</p>
                </a>

            </div>
        </div>

    </div>
</x-app-layout>
