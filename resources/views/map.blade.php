<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peta Dinas Perumahan dan Permukiman') }}
        </h2>
    </x-slot>

    {{-- Menambahkan CSS untuk Leaflet.js --}}
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
              crossorigin=""/>
        <style>
            /* Pastikan peta memiliki tinggi agar terlihat */
            #map { 
                height: 500px; 
            }
        </style>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Elemen div ini adalah tempat peta akan ditampilkan --}}
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Menambahkan JavaScript untuk Leaflet.js --}}
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>
        <script>
            // Koordinat untuk Dinas Perumahan dan Permukiman Kabupaten Garut
            const lat = -7.2244;
            const lng = 107.9044;

            // 1. Inisialisasi Peta
            // Peta akan ditampilkan di dalam elemen 'div' dengan id 'map'
            // setView([koordinat], level_zoom)
            const map = L.map('map').setView([lat, lng], 15);

            // 2. Tambahkan Tile Layer (Tampilan Peta)
            // Kita menggunakan data peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            
            // 3. Tambahkan Marker (Penanda Lokasi)
            const marker = L.marker([lat, lng]).addTo(map);

            // 4. (Opsional) Tambahkan Popup pada Marker
            marker.bindPopup("<b>Disperkim Garut</b><br>Kantor Dinas Perumahan dan Permukiman.").openPopup();
        </script>
    @endpush

</x-app-layout>