<?php

$web = $web ?? [];
$wilayah = $wilayah ?? [];
$sekolah = $sekolah ?? [];
$jenjang = $jenjang ?? [];

$jenjangList = [];
$kecamatanList = [];
$markerSekolah = [];

/*
|--------------------------------------------------------------------------
| Urutan tombol jenjang yang diinginkan
|--------------------------------------------------------------------------
*/
$urutanJenjang = ['TK', 'SD', 'SMP', 'SMA', 'SMK'];

/*
|--------------------------------------------------------------------------
| Ambil seluruh jenjang dari database sesuai urutan di atas
|--------------------------------------------------------------------------
*/
foreach ($urutanJenjang as $namaJenjang) {
    foreach ($jenjang as $item) {
        if ($item['jenjang'] == $namaJenjang) {
            $jenjangList[] = $namaJenjang;
        }
    }
}

/*
|--------------------------------------------------------------------------
| Ambil data sekolah untuk marker
|--------------------------------------------------------------------------
*/
foreach ($sekolah as $item) {

  // Ambil koordinat dan normalisasi beberapa format umum yang mungkin masuk
  $coordinat = trim($item['coordinat'] ?? '');
  // Ganti pemisah lain seperti ; atau / dan hapus tanda kurung
  $coordinat = str_replace([';', '/', '(', ')'], ',', $coordinat);
  // Ganti multi-spasi menjadi satu spasi
  $coordinat = preg_replace('/[\s\t\r\n]+/', ' ', $coordinat);
  // Normalisasi koma-spasi
  $coordinat = preg_replace('/\s*,\s*/', ',', $coordinat);

  // Cari dua angka (lat dan lng) terlepas dari pemisah non-angka
  $lat = $lng = null;
  if (preg_match('/(-?\d+(?:\.\d+)?)[^0-9-]+(-?\d+(?:\.\d+)?)/', $coordinat, $m)) {
    $lat = $m[1];
    $lng = $m[2];
  } else {
    // Fallback: coba split dengan koma
    $parts = array_map('trim', explode(',', $coordinat));
    if (count($parts) >= 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
      $lat = $parts[0];
      $lng = $parts[1];
    }
  }

  if ($lat === null || $lng === null) {
    continue;
  }

    $jenjangSekolah = $item['jenjang'] ?? 'Lainnya';
    $kecamatan = $item['nama_kecamatan'] ?? '';

    if ($kecamatan !== '') {
        $kecamatanList[$kecamatan] = $kecamatan;
    }

    $markerSekolah[] = [
        'nama'       => $item['nama_sekolah'] ?? '-',
        'status'     => $item['status'] ?? '-',
        'akreditasi' => $item['akreditasi'] ?? '-',
        'jenjang'    => $jenjangSekolah,
        'alamat'     => $item['alamat'] ?? '-',
        'kecamatan'  => $kecamatan,
        'nagari'     => $item['nama_nagari'] ?? '',
        'lat'        => (float)$lat,
        'lng'        => (float)$lng,
        'marker'     => !empty($item['marker'])
                            ? base_url('marker/' . $item['marker'])
                            : '',
        'foto'       => !empty($item['foto'])
                            ? base_url('foto/' . $item['foto'])
                            : '',
    ];
}

ksort($kecamatanList);

$allowedKecamatan = [
    'Padang Ganting' => ['padang ganting', 'padang gantiang', 'kecamatan padang ganting', 'kecamatan padang gantiang'],
    'Tanjung Ameh' => ['tanjung ameh', 'tanjuang ameh', 'kecamatan tanjung ameh', 'kecamatan tanjuang ameh'],
    'Lintau Buo Utara' => ['lintau buo utara', 'lintau buo', 'kecamatan lintau buo utara', 'kecamatan lintau buo'],
];
$availableKecamatan = [];
foreach ($wilayah as $item) {
    $namaWilayah = strtolower(trim($item['nama_wilayah'] ?? ''));
    foreach ($allowedKecamatan as $label => $aliases) {
        foreach ($aliases as $alias) {
            if ($alias !== '' && str_contains($namaWilayah, $alias)) {
                $availableKecamatan[] = $label;
                break 2;
            }
        }
    }
}
$availableKecamatan = array_values(array_unique($availableKecamatan));

if (empty($availableKecamatan)) {
    $availableKecamatan = array_keys($allowedKecamatan);
}

?>

<style>
/* Peta halaman: full area map dengan panel kiri */
.peta-wrapper{position:relative;width:100%;height: calc(100vh - 70px); min-height:620px;display:flex}
#map {
  height: 100%;
  width: 100%;
}

.peta-panel{
  position:fixed;top:16px;left:16px;z-index:900;
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
.map-layer-control{position:fixed;top:16px;right:16px;z-index:950}
.map-layer-toggle{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid rgba(15,23,42,.12);border-radius:10px;background:#fff;box-shadow:0 8px 24px rgba(15,23,42,.12);font-size:13px;font-weight:600;color:#0f172a;cursor:pointer}
.map-layer-toggle i:first-child{color:var(--blue-primary)}
.map-layer-toggle .fa-chevron-down{font-size:10px;color:var(--text-muted);margin-left:2px}
.map-layer-dropdown{display:none;position:absolute;top:calc(100% + 8px);right:0;min-width:190px;background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:10px;padding:6px;box-shadow:0 12px 24px rgba(15,23,42,.14);overflow:hidden}
.map-layer-dropdown.show{display:block}
.map-layer-option{width:100%;display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border:none;background:transparent;border-radius:8px;text-align:left;font-size:13px;color:#334155;cursor:pointer}
.map-layer-option:hover,.map-layer-option.active{background:#eff6ff;color:#1d4ed8}
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
.panel-card {
  padding: 16px;
}

.panel-card h6 {
  margin-bottom: 12px;
  font-weight: 700;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 8px;
  font-size: 14px;
}

/* bulatan */
.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  display: inline-block;
}

/* warna */
.dot.tk {
  background: #22c55e; /* hijau */
}

.dot.sd {
  background: #ef4444; /* merah */
}

.dot.smp {
  background: #3b82f6; /* biru */
}
@media(max-width:768px){
  .peta-wrapper{height:calc(100dvh - 58px);min-height:560px}
  .peta-panel{top:12px;left:12px;right:12px;width:auto}
  .panel-card{padding:12px}
  .jenjang-btns{overflow-x:auto;padding-bottom:2px}
  .jenjang-btn{white-space:nowrap}
}

/* Search results panel (muncul di samping panel pencarian pada layar lebar) */
.search-results{
  position:fixed;top:16px;left:320px;z-index:900;width:min(360px,calc(100vw - 360px));max-height:70vh;overflow:auto;display:none;border-radius:10px;padding:12px;background:#fff;box-shadow:0 8px 32px rgba(2,6,23,.12)
}
.search-results .results-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.search-results .results-list{display:flex;flex-direction:column;gap:8px}
.search-result-item{background:#fff;border-radius:8px;padding:10px;border:1px solid rgba(15,23,42,.04);cursor:pointer}
.search-result-item h4{margin:0;font-size:14px;font-weight:700}
.search-result-item p{margin:4px 0 0;font-size:13px;color:#475569}
@media(max-width:768px){
  .search-results{position:static;left:auto;top:auto;margin-top:8px;width:auto;display:none}
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
      <h6>Filter Data</h6>

      <div class="filter-section">
        <div class="filter-label">Jenjang Pendidikan</div>
        <?php $fixedJenjang = ['TK','SD','SMP']; ?>
        <div class="jenjang-btns">
          <button type="button" class="jenjang-btn active" data-jenjang="">Semua</button>
          <?php foreach ($fixedJenjang as $fj) { ?>
            <button type="button" class="jenjang-btn" data-jenjang="<?= esc($fj) ?>"><?= esc($fj) ?></button>
          <?php } ?>
          <?php foreach ($jenjangList as $j) { ?>
            <?php if (in_array($j, $fixedJenjang)) continue; ?>
            <button type="button" class="jenjang-btn" data-jenjang="<?= esc($j) ?>"><?= esc($j) ?></button>
          <?php } ?>
        </div>
      </div>

      <div class="filter-section">
        <div class="filter-label">Wilayah Kecamatan</div>
        <select class="kecamatan-select" id="filterKecamatan">
          <option value="">Semua Kecamatan</option>
          <?php foreach ($availableKecamatan as $kecamatan) { ?>
            <option value="<?= esc($kecamatan) ?>"><?= esc($kecamatan) ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="panel-card">
  <h6>Legenda</h6>

  <div class="legend-item">
    <span class="dot tk"></span> TK
  </div>

  <div class="legend-item">
    <span class="dot sd"></span> SD
  </div>

  <div class="legend-item">
    <span class="dot smp"></span> SMP
  </div>
</div>

    
  </div>

  <div class="map-layer-control">
    <button type="button" id="layerToggleBtn" class="map-layer-toggle">
      <i class="fas fa-layer-group"></i>
      <span id="layerButtonLabel">Light</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <div id="layerDropdown" class="map-layer-dropdown" role="menu" aria-label="Pilihan mode peta">
      <button type="button" class="map-layer-option active" data-layer="Light">Light</button>
      <button type="button" class="map-layer-option" data-layer="OpenStreetMap">OpenStreetMap</button>
      <button type="button" class="map-layer-option" data-layer="Satelit">Satelit</button>
    </div>
  </div>

  <!-- Map -->
  <div id="map"></div>
  <!-- Search Results (akan muncul di samping pada layar lebar) -->
  <div id="searchResults" class="search-results" aria-live="polite">
    <div class="results-header">
      <h6>Hasil Pencarian</h6>
      <a href="#" id="closeResults" style="font-size:12px;color:var(--blue-primary)">Tutup</a>
    </div>
    <div class="results-list" id="resultsList"></div>
  </div>
</div>

<script>
        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
            attribution: '&copy; OpenStreetMap contributors'
        });

        var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{
            attribution: 'Tiles &copy; Esri'
        });

        var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        });

    // Inisialisasi Peta
    const map = L.map('map', {
        center: [<?= $web['coordinat_wilayah'] ?>], // Tanah Datar
        zoom: <?= $web['zoom_view'] ?>,
        layers: [peta1]
    });

    const baseMaps = {
        "Light": peta1,
        "Satelit": peta2,
        "OpenStreetMap": peta3
    };

    const layerToggleBtn = document.getElementById('layerToggleBtn');
    const layerButtonLabel = document.getElementById('layerButtonLabel');
    const layerDropdown = document.getElementById('layerDropdown');
    const layerOptions = Array.from(document.querySelectorAll('.map-layer-option'));
    let activeBaseLayer = peta1;

    function setActiveBaseLayer(name) {
        if (!baseMaps[name]) return;
        if (map.hasLayer(activeBaseLayer)) {
            map.removeLayer(activeBaseLayer);
        }
        baseMaps[name].addTo(map);
        activeBaseLayer = baseMaps[name];
        layerButtonLabel.textContent = name;
        layerOptions.forEach((option) => {
            option.classList.toggle('active', option.getAttribute('data-layer') === name);
        });
    }

    layerToggleBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        layerDropdown.classList.toggle('show');
    });

    document.addEventListener('click', function () {
        layerDropdown.classList.remove('show');
    });

    layerOptions.forEach((option) => {
        option.addEventListener('click', function () {
            setActiveBaseLayer(this.getAttribute('data-layer'));
            layerDropdown.classList.remove('show');
        });
    });

    setActiveBaseLayer('Light');
    var sekolahData = <?= json_encode($markerSekolah, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    console.log('DEBUG: sekolahData =', sekolahData);
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

    var kecamatanAliasMap = {
        'Padang Ganting': ['padang ganting', 'padang gantiang', 'kecamatan padang ganting', 'kecamatan padang gantiang'],
        'Tanjung Ameh': ['tanjung ameh', 'tanjuang ameh', 'kecamatan tanjung ameh', 'kecamatan tanjuang ameh'],
        'Lintau Buo Utara': ['lintau buo utara', 'lintau buo', 'kecamatan lintau buo utara', 'kecamatan lintau buo'],
    };

    function kecamatanMatches(value, selectedKecamatan) {
        if (!selectedKecamatan) {
            return true;
        }
        var normalizedValue = (value || '').toLowerCase();
        var aliases = kecamatanAliasMap[selectedKecamatan] || [selectedKecamatan.toLowerCase()];
        return aliases.some(function(alias) {
            return alias && normalizedValue.includes(alias);
        });
    }

    function renderSekolahMarkers() {
        var keyword = document.getElementById('searchSekolah').value.toLowerCase();
        var selectedKecamatan = getSelectedKecamatan();

        sekolahLayer.clearLayers();

      var renderedCount = 0;
      var matches = [];
      sekolahData.forEach(function(item) {
        var cocokJenjang = !selectedJenjang || item.jenjang === selectedJenjang;
        var cocokKecamatan = kecamatanMatches(item.kecamatan, selectedKecamatan);
        var cocokKeyword = !keyword || item.nama.toLowerCase().includes(keyword) || item.alamat.toLowerCase().includes(keyword);

        if (!cocokJenjang || !cocokKecamatan || !cocokKeyword) {
          return;
        }

        L.marker([item.lat, item.lng], {
          icon: sekolahIcon(item.marker)
        }).bindPopup(popupSekolah(item)).addTo(sekolahLayer);
        renderedCount++;
        matches.push(item);
      });

      // Tampilkan daftar hasil di panel samping (maks 20)
      showSearchResults(matches.slice(0, 20));

      console.log('DEBUG: rendered markers =', renderedCount, 'filter jenjang=', selectedJenjang, 'keyword=', keyword, 'kecamatan=', selectedKecamatan);
      renderWilayahLayers(selectedKecamatan);
    }

    // Render daftar hasil pencarian ke DOM
    function showSearchResults(items) {
      var container = document.getElementById('searchResults');
      var list = document.getElementById('resultsList');
      list.innerHTML = '';
      if (!items || items.length === 0) {
        container.style.display = 'none';
        return;
      }

      items.forEach(function(item, idx) {
        var el = document.createElement('div');
        el.className = 'search-result-item';
        el.tabIndex = 0;
        el.innerHTML = '<h4>' + escapeHtml(item.nama) + '</h4>' +
                 '<p>' + escapeHtml(item.alamat) + ' • ' + escapeHtml(item.jenjang) + '</p>';
        el.addEventListener('click', function(e) {
          map.setView([item.lat, item.lng], 16);
          L.popup({maxWidth:300}).setLatLng([item.lat, item.lng]).setContent(popupSekolah(item)).openOn(map);
        });
        el.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); el.click(); }
        });
        list.appendChild(el);
      });

      container.style.display = 'block';
    }

    document.getElementById('closeResults').addEventListener('click', function(e){
      e.preventDefault();
      document.getElementById('searchResults').style.display = 'none';
    });

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

    var wilayahData = [];
    var wilayahLayers = {};

    function getSelectedKecamatan() {
        return document.getElementById('filterKecamatan').value;
    }

    function buildWilayahLayer(item) {
        return L.geoJSON(item.geojson, {
            style: {
                color: item.warna,
                fillColor: item.warna,
                fillOpacity: 0.25,
                weight: 2,
                opacity: 0.8
            },
            onEachFeature: function (feature, layer) {
                var namaPopup = '<b>' + escapeHtml(item.nama) + '</b>';
                if (feature.properties) {
                    if (feature.properties.nama) {
                        namaPopup += '<br>' + escapeHtml(feature.properties.nama);
                    }
                    if (feature.properties.village) {
                        namaPopup += '<br>Desa/Nagari: ' + escapeHtml(feature.properties.village);
                    } else if (feature.properties.VILLAGE) {
                        namaPopup += '<br>Desa/Nagari: ' + escapeHtml(feature.properties.VILLAGE);
                    }
                }
                layer.bindPopup(namaPopup);
            }
        });
    }

    function renderWilayahLayers(selectedKecamatan) {
        Object.values(wilayahLayers).forEach(function (layer) {
            if (map.hasLayer(layer)) {
                map.removeLayer(layer);
            }
        });
        wilayahLayers = {};

        var showAll = !selectedKecamatan;
        wilayahData.forEach(function (item, index) {
            var cocokWilayah = showAll || kecamatanMatches(item.nama, selectedKecamatan);
            if (cocokWilayah) {
                wilayahLayers[index] = buildWilayahLayer(item).addTo(map);
            }
        });
    }

    <?php foreach ($wilayah as $key => $value) { 
        $raw_geojson = $value['geojson'];
        $teks_rusak = '"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}},';
        $clean_geojson = str_replace($teks_rusak, '', $raw_geojson);
        $clean_geojson = preg_replace('/[\r\n\t]+/', ' ', $clean_geojson);
    ?>
        try {
            let geojsonString_<?= $key ?> = `<?= $clean_geojson ?>`;
            wilayahData.push({
                nama: "<?= addslashes($value['nama_wilayah']) ?>",
                geojson: JSON.parse(geojsonString_<?= $key ?>),
                warna: "<?= addslashes($value['warna']) ?>"
            });
        } catch (e) {
            console.error("Gagal memuat wilayah [<?= addslashes($value['nama_wilayah']) ?>]:", e.message);
        }
    <?php } ?>

    // Render initial markers and wilayah layers after wilayahData has been populated
    renderSekolahMarkers();

    // Fix panels so they stay solid below the top navbar (no scroll repositioning)
    function fixPanelsBelowHeader() {
      var header = document.querySelector('.top-nav') || document.querySelector('header') || document.querySelector('.main-header') || document.querySelector('.navbar');
      var headerBottom = 0;
      if (header) {
        var rect = header.getBoundingClientRect();
        headerBottom = rect.bottom > 0 ? rect.bottom : 0;
      }

      var panel = document.querySelector('.peta-panel');
      if (panel) {
        panel.style.position = 'fixed';
        panel.style.top = (Math.ceil(headerBottom) + 12) + 'px';
        panel.style.left = '16px';
        panel.style.zIndex = 900;
      }

      var results = document.getElementById('searchResults');
      if (results) {
        results.style.position = 'fixed';
        // place results to the right of the panel when space allows
        var pr = panel ? panel.getBoundingClientRect() : {right: 300};
        results.style.left = (Math.ceil(pr.right + 12)) + 'px';
        results.style.top = (Math.ceil(headerBottom) + 12) + 'px';
        results.style.zIndex = 880;
      }
    }

    // apply once on load and when resizing; do NOT reposition on scroll so panel stays solid
    window.addEventListener('load', fixPanelsBelowHeader);
    window.addEventListener('resize', fixPanelsBelowHeader);
    // initial call
    setTimeout(fixPanelsBelowHeader, 60);
</script>
