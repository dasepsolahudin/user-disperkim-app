<x-app-layout>
    {{-- CSS Khusus untuk Leaflet --}}
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
              crossorigin=""/>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peta Sebaran Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="map" style="height: 600px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Memuat pustaka Leaflet.js --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Koordinat akurat untuk Jl. Raya Samarang No.115
                const dinasLocation = [-7.21551, 107.90358];

                // --- Base Layers ---
                var streetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                });

                var satelliteMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri'
                });

                // --- Inisialisasi Peta ---
                var map = L.map('map', {
                    center: dinasLocation,
                    zoom: 18, // Zoom lebih dekat untuk presisi
                    layers: [streetMap]
                });

                // --- Kontrol Layer ---
                var baseMaps = {
                    "Peta Jalan": streetMap,
                    "Satelit": satelliteMap
                };
                L.control.layers(baseMaps).addTo(map);

                // --- Marker Kantor Dinas ---
                L.marker(dinasLocation).addTo(map)
                    .bindPopup('<b>Dinas Perumahan dan Permukiman</b><br>Jl. Raya Samarang No.115, Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut.')
                    .openPopup();

                // --- Marker Pengaduan ---
                var complaints = @json($complaints);
                complaints.forEach(function(complaint) {
                    if (complaint.latitude && complaint.longitude) {
                        L.marker([complaint.latitude, complaint.longitude]).addTo(map)
                            .bindPopup('<b>' + complaint.title + '</b><br>' + complaint.location_text);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>