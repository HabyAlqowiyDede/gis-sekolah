<?php
$web = $web ?? [];
$wilayah = $wilayah ?? [];
?>

<div id="map" style="width: 100%; height: 725px;"></div>

<script>
        var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
            attribution: '&copy; OpenStreetMap contributors'
        });

        var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
            attribution: 'Tiles &copy; Esri'
        });

        var peta3 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        });

        var peta4 = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        });

        var peta5 = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',{
            attribution: '&copy; OpenTopoMap contributors'
        });

    // Inisialisasi Peta
    const map = L.map('map', {
        center: [<?= $web['coordinat_wilayah'] ?>], // Tanah Datar
        zoom: <?= $web['zoom_view'] ?>,
        layers: [peta1]
    });

    // Basemap Control
    const baseMaps = {
        "OpenStreetMap": peta1,
        "Satelit": peta2,
        "Light": peta3,
        "Dark": peta4,
        "OpenTopoMap": peta5
    };

    var baseMapControl = L.control.layers(baseMaps).addTo(map);
    <?php foreach ($wilayah as $key => $value) { 
        // 1. Ambil string mentah dari database
        $raw_geojson = $value['geojson'];

        // 2. Teks spesifik "crs" yang rusak berdasarkan gambar database Anda
        $teks_rusak = '"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}},';

        // 3. Hapus teks rusak tersebut langsung di PHP
        $clean_geojson = str_replace($teks_rusak, '', $raw_geojson);

        // 4. Bersihkan juga karakter enter / baris baru agar tidak merusak JavaScript
        $clean_geojson = preg_replace('/[\r\n\t]+/', ' ', $clean_geojson);
    ?>
        try {
            // 5. Masukkan ke dalam variabel JavaScript menggunakan backtick ( ` ) agar aman dari tanda petik
            let geojsonString_<?= $key ?> = `<?= $clean_geojson ?>`;

            // 6. Ubah string yang sudah bersih menjadi Objek JavaScript
            let geojsonObject_<?= $key ?> = JSON.parse(geojsonString_<?= $key ?>);

            L.geoJSON(geojsonObject_<?= $key ?>, {
                fillColor: '<?= $value['warna'] ?>',
                fillOpacity: 0.5,
                
                onEachFeature: function (feature, layer) {
                    // Ambil nama dari database PHP sebagai cadangan utama
                    let namaPopup = "<b><?= addslashes($value['nama_wilayah']) ?></b>";
                    
                    // Jika di dalam properti GeoJSON ada nama desa, tampilkan juga
                    if (feature.properties) {
                        if (feature.properties.village) {
                            namaPopup += "<br>Desa/Nagari: " + feature.properties.village;
                        } else if (feature.properties.VILLAGE) {
                            namaPopup += "<br>Desa/Nagari: " + feature.properties.VILLAGE;
                        }
                    }
                    layer.bindPopup(namaPopup);
                }
            }).addTo(map);

        } catch (e) {
            console.error("Gagal memuat wilayah [<?= addslashes($value['nama_wilayah']) ?>]:", e.message);
        }
    <?php } ?>
</script>