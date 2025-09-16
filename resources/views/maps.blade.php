<!DOCTYPE html>
<html>
<head>
    <title>Peta Kabupaten Garut</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
    <h2>Peta Kabupaten Garut</h2>
    <div id="map" style="height: 600px; width: 100%;"></div>

    <script>
        // Inisialisasi peta di koordinat Garut
        var map = L.map("map").setView([-7.2279, 107.9087], 10);

        // Tambah tile dari OpenStreetMap
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap contributors"
        }).addTo(map);

        // Tambah marker di pusat Garut
        L.marker([-7.2279, 107.9087]).addTo(map)
            .bindPopup("Kabupaten Garut")
            .openPopup();
    </script>
</body>
</html>
