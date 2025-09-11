<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Kategori Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Silakan pilih jenis layanan pengaduan yang Anda butuhkan:</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kartu Pengaduan Rutilahu --}}
                        <a href="{{ route('complaints.form', ['category' => 'rutilahu']) }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-200">
                            <h4 class="font-bold text-xl mb-2 text-gray-800">Pengaduan Rutilahu</h4>
                            <p class="text-gray-600 mb-4">Laporan terkait Rumah Tidak Layak Huni.</p>
                            <span class="font-semibold text-green-600">Buat Laporan &rarr;</span>
                        </a>

                        {{-- Kartu Pengaduan Infrastruktur --}}
                        <a href="{{ route('complaints.form', ['category' => 'infrastruktur']) }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-200">
                            <h4 class="font-bold text-xl mb-2 text-gray-800">Pengaduan Infrastruktur</h4>
                            <p class="text-gray-600 mb-4">Laporan terkait jalan, drainase, dan fasilitas umum lainnya.</p>
                            <span class="font-semibold text-green-600">Buat Laporan &rarr;</span>
                        </a>

                        {{-- Kartu Pengaduan Tata Kota --}}
                        <a href="{{ route('complaints.form', ['category' => 'tata_kota']) }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-200">
                            <h4 class="font-bold text-xl mb-2 text-gray-800">Pengaduan Tata Kota</h4>
                            <p class="text-gray-600 mb-4">Laporan terkait pelanggaran tata ruang dan perizinan.</p>
                            <span class="font-semibold text-green-600">Buat Laporan &rarr;</span>
                        </a>

                        {{-- Kartu Pengaduan Air Bersih & Sanitasi --}}
                        <a href="{{ route('complaints.form', ['category' => 'air_bersih_sanitasi']) }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-200">
                            <h4 class="font-bold text-xl mb-2 text-gray-800">Air Bersih & Sanitasi</h4>
                            <p class="text-gray-600 mb-4">Laporan terkait masalah air bersih dan sanitasi lingkungan.</p>
                            <span class="font-semibold text-green-600">Buat Laporan &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>