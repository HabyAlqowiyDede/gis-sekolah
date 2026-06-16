<?php 
$web = $web ?? [] ;
$wilayah = $wilayah ?? [];
$sekolah = $sekolah ?? [];

$jenjangList = [];
$kecamatanList = [];
$markerSekolah = [];

foreach ($sekolah as $item) {
    $coordinat = trim($item['coordinat'] ?? '');

    if (!preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $coordinat)) {
        continue;
    }

    [$lat, $lng] = array_map('trim', explode(',', $coordinat));
    $jenjang = $item['jenjang'] ?? 'Lainnya';
    $kecamatan = $item['nama_kecamatan'] ?? '';

    $jenjangList[$jenjang] = $jenjang;

    if ($kecamatan !== '') {
        $kecamatanList[$kecamatan] = $kecamatan;
    }

    $markerSekolah[] = [
        'nama' => $item['nama_sekolah'] ?? '-',
        'status' => $item['status'] ?? '-',
        'akreditasi' => $item['akreditasi'] ?? '-',
        'jenjang' => $jenjang,
        'alamat' => $item['alamat'] ?? '-',
        'kecamatan' => $kecamatan,
        'nagari' => $item['nama_nagari'] ?? '',
        'lat' => (float) $lat,
        'lng' => (float) $lng,
        'marker' => !empty($item['marker']) ? base_url('marker/' . $item['marker']) : '',
        'foto' => !empty($item['foto']) ? base_url('foto/' . $item['foto']) : '',
    ];
}

ksort($jenjangList);
ksort($kecamatanList);

?>

<style>
/* Peta halaman: full area map dengan panel kiri */
.peta-wrapper{position:relative;width:100%;height:calc(100dvh - 58px);min-height:620px;display:flex}
#map{flex:1;height:100%}

.peta-panel{
  position:absolute;top:16px;left:16px;z-index:1000;
  display:flex;flex-direction:column;gap:12px;
  width:min(280px,calc(100vw - 32px))
}

.panel-card{
  background:#fff;border-radius:10px;padding:16px;
  box-shadow:0 4px 16px rgba(0,0,0,.12);
}

.panel-card h6{
  font-size:10px;font-weight:700;letter-spacing:.08em;
  text-transform:uppercase;color:var(--text-muted);margin-bottom:10px;
  display:flex;justify-content:space-between;align-items:center
}
.panel-card h6 a{font-size:11px;font-weight:600;color:var(--blue-primary);text-transform:none;letter-spacing:0;text-decoration:none}

.peta-search{
  display:flex;align-items:center;gap:8px;
  border:1px solid var(--border);border-radius:8px;padding:8px 10px;
  background:#fff
}
.peta-search input{border:none;outline:none;font-size:13px;width:100%}
.peta-search i{color:var(--text-muted);font-size:12px}

.filter-section{margin-bottom:10px}
.filter-label{font-size:11px;font-weight:600;color:var(--text-muted);margin-bottom:6px}
.jenjang-btns{display:flex;gap:6px}
.jenjang-btn{
  padding:5px 14px;border-radius:6px;font-size:12px;font-weight:600;
  border:1px solid var(--border);cursor:pointer;background:#fff;color:var(--text-muted);
  transition:all .15s
}
.jenjang-btn.active{background:var(--blue-primary);color:#fff;border-color:var(--blue-primary)}

.leaflet-popup-content{font-family:Inter,sans-serif;font-size:12px;line-height:1.45}
.popup-sekolah{min-width:190px}
.popup-sekolah img{width:100%;height:90px;object-fit:cover;border-radius:6px;margin-bottom:8px}
.popup-sekolah strong{display:block;font-size:13px;margin-bottom:4px;color:#111827}
.popup-sekolah span{display:block;color:#4b5563}
.default-school-marker{
  width:28px;height:28px;border-radius:50% 50% 50% 0;
  background:var(--blue-primary);border:2px solid #fff;
  transform:rotate(-45deg);box-shadow:0 2px 8px rgba(0,0,0,.25)
}
.default-school-marker::after{
  content:'';position:absolute;width:10px;height:10px;border-radius:50%;
  background:#fff;left:7px;top:7px
}

.kecamatan-select{
  width:100%;border:1px solid var(--border);border-radius:8px;
  padding:7px 10px;font-size:13px;outline:none;background:#fff;cursor:pointer
}

.toggle-row{
  display:flex;align-items:center;justify-content:space-between;
  font-size:12px;color:var(--text-primary);margin-top:8px
}
.toggle{position:relative;width:36px;height:20px}
.toggle input{opacity:0;width:0;height:0}
.toggle-slider{
  position:absolute;inset:0;background:#d1d5db;border-radius:20px;cursor:pointer;transition:.2s
}
.toggle input:checked + .toggle-slider{background:var(--blue-primary)}
.toggle-slider::before{
  content:'';position:absolute;height:14px;width:14px;left:3px;bottom:3px;
  background:#fff;border-radius:50%;transition:.2s
}
.toggle input:checked + .toggle-slider::before{transform:translateX(16px)}

@media(max-width:768px){
  .peta-wrapper{height:calc(100dvh - 58px);min-height:560px}
  .peta-panel{top:12px;left:12px;right:12px;width:auto}
  .panel-card{padding:12px}
  .jenjang-btns{overflow-x:auto;padding-bottom:2px}
  .jenjang-btn{white-space:nowrap}
}
</style>

<!-- Peta fullscreen -->
<div class="peta-wrapper">

  <!-- Panel kiri -->
  <div class="peta-panel">

    <!-- Search -->
    <div class="panel-card">
      <h6>Cari Sekolah</h6>
      <div class="peta-search">
        <i class="fas fa-search"></i>
        <input type="text" id="searchSekolah" placeholder="Masukkan nama sekolah...">
      </div>
    </div>

    <!-- Filter -->
    <div class="panel-card">
      <h6>Filter Data <a href="#">Reset</a></h6>

      <div class="filter-section">
        <div class="filter-label">Jenjang Pendidikan</div>
        <div class="jenjang-btns">
          <button type="button" class="jenjang-btn active" data-jenjang="">Semua</button>
          <?php foreach ($jenjangList as $jenjang) { ?>
            <button type="button" class="jenjang-btn" data-jenjang="<?= esc($jenjang) ?>"><?= esc($jenjang) ?></button>
          <?php } ?>
        </div>
      </div>

      <div class="filter-section">
        <div class="filter-label">Wilayah Kecamatan</div>
        <select class="kecamatan-select" id="filterKecamatan">
          <option value="">Semua Kecamatan</option>
          <?php foreach ($kecamatanList as $kecamatan) { ?>
            <option value="<?= esc($kecamatan) ?>"><?= esc($kecamatan) ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="toggle-row">
        <span>Tampilkan Kepadatan Penduduk</span>
        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
      </div>
      <div class="toggle-row">
        <span>Batas Administrasi</span>
        <label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label>
      </div>
    </div>

  </div>

  <!-- Map -->
  <div id="map"></div>
</div>

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
    var sekolahData = <?= json_encode($markerSekolah, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    var sekolahLayer = L.layerGroup().addTo(map);
    var selectedJenjang = '';

    function sekolahIcon(markerUrl) {
        if (markerUrl) {
            return L.icon({
                iconUrl: markerUrl,
                iconSize: [34, 42],
                iconAnchor: [17, 42],
                popupAnchor: [0, -38]
            });
        }

        return L.divIcon({
            className: '',
            html: '<div class="default-school-marker"></div>',
            iconSize: [28, 28],
            iconAnchor: [14, 28],
            popupAnchor: [0, -28]
        });
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function(char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function popupSekolah(item) {
        var foto = item.foto ? '<img src="' + escapeHtml(item.foto) + '" alt="Foto sekolah">' : '';

        return '<div class="popup-sekolah">' +
            foto +
            '<strong>' + escapeHtml(item.nama) + '</strong>' +
            '<span>Jenjang: ' + escapeHtml(item.jenjang) + '</span>' +
            '<span>Akreditasi: ' + escapeHtml(item.akreditasi) + '</span>' +
            '<span>Status: ' + escapeHtml(item.status) + '</span>' +
            '<span>Alamat: ' + escapeHtml(item.alamat) + '</span>' +
            '</div>';
    }

    function renderSekolahMarkers() {
        var keyword = document.getElementById('searchSekolah').value.toLowerCase();
        var selectedKecamatan = document.getElementById('filterKecamatan').value;

        sekolahLayer.clearLayers();

        sekolahData.forEach(function(item) {
            var cocokJenjang = !selectedJenjang || item.jenjang === selectedJenjang;
            var cocokKecamatan = !selectedKecamatan || item.kecamatan === selectedKecamatan;
            var cocokKeyword = !keyword || item.nama.toLowerCase().includes(keyword) || item.alamat.toLowerCase().includes(keyword);

            if (!cocokJenjang || !cocokKecamatan || !cocokKeyword) {
                return;
            }

            L.marker([item.lat, item.lng], {
                icon: sekolahIcon(item.marker)
            }).bindPopup(popupSekolah(item)).addTo(sekolahLayer);
        });
    }

    document.querySelectorAll('.jenjang-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.querySelectorAll('.jenjang-btn').forEach(function(item) {
                item.classList.remove('active');
            });

            button.classList.add('active');
            selectedJenjang = button.dataset.jenjang;
            renderSekolahMarkers();
        });
    });

    document.getElementById('searchSekolah').addEventListener('input', renderSekolahMarkers);
    document.getElementById('filterKecamatan').addEventListener('change', renderSekolahMarkers);
    renderSekolahMarkers();

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
