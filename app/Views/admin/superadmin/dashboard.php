<?php
$data_terbaru = $data_terbaru ?? [];
// Pastikan jumlah TK tampil: jika variabel tidak tersedia, hitung dari data sekolah
$computed_jumlah_tk = $jumlah_tk ?? null;
if ((empty($computed_jumlah_tk) || $computed_jumlah_tk === 0) && !empty($sekolah)) {
    $cnt = 0;
    foreach ($sekolah as $s) {
        $j = strtoupper(trim($s['jenjang'] ?? ''));
        if ($j === 'TK' || strpos($j, 'TK') !== false || $j === 'PAUD' || strpos($j, 'PAUD') !== false) {
            $cnt++;
        }
    }
    $computed_jumlah_tk = $cnt;
}
?>
<style>
    .dashboard-hero {
        background: linear-gradient(135deg, #1d4ed8 0%, #0f766e 100%);
        border-radius: 12px;
        color: #fff;
        padding: 24px 26px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
    }

    .dashboard-hero h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .dashboard-hero p {
        color: rgba(255, 255, 255, .78);
        margin: 0;
    }

    .dashboard-hero-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255, 255, 255, .16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex: 0 0 auto;
    }

    .dashboard-stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 18px;
        align-items: stretch;
    }

    .dashboard-stat-card {
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        border: 1px solid #eef2ff;
        border-radius: 12px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 6px 20px rgba(16, 24, 40, .06);
        transition: transform .12s ease, box-shadow .12s ease;
    }

    /* Sekolah list cards (kanan) */
    .school-list { display: flex; flex-direction: column; gap: 10px; padding: 12px; }
    .school-card { display:flex; gap:10px; align-items:flex-start; background:#fff; border-radius:10px; padding:10px; border:1px solid #eef2ff; box-shadow:0 4px 12px rgba(15,23,42,.04); }
    .school-card .thumb { width:44px; height:44px; border-radius:8px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-weight:700; color:#0f172a; flex:0 0 44px; }
    .school-card .meta { flex:1; }
    .school-card .meta .name { font-weight:700; color:#0f172a; margin:0 0 4px 0; }
    .school-card .meta .meta-line { font-size:12px; color:#64748b; margin:0; }

    .dashboard-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(16,24,40,.12);
    }

    .dashboard-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .dashboard-stat-icon.blue { background: linear-gradient(135deg,#e0f2fe,#eef2ff); color: #0f172a; }
    .dashboard-stat-icon.green { background: linear-gradient(135deg,#ecfdf5,#dcfce7); color: #0f172a; }
    .dashboard-stat-icon.orange { background: linear-gradient(135deg,#fff7ed,#ffedd5); color: #0f172a; }
    .dashboard-stat-icon.red { background: linear-gradient(135deg,#fff1f2,#fee2e2); color: #0f172a; }

    .dashboard-stat-label {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .dashboard-stat-value {
        color: #0f172a;
        font-size: 24px;
        font-weight: 800;
        line-height: 1;
    }

    .dashboard-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .dashboard-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .dashboard-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .dashboard-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .dashboard-hero { align-items: flex-start; flex-direction: column; }
        .dashboard-stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="col-md-12">

    <div class="dashboard-stat-grid">
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon orange"><i class="fas fa-map"></i></div>
            <div>
                <div class="dashboard-stat-label">Total TK</div>
                <div class="dashboard-stat-value"><?= esc($computed_jumlah_tk ?? 0) ?></div>
            </div>
        </div>
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon blue"><i class="fas fa-school"></i></div>
            <div>
                <div class="dashboard-stat-label">Total SD</div>
                <div class="dashboard-stat-value"><?= $jumlah_sd ?? 0 ?></div>
            </div>
        </div>
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon green"><i class="fas fa-book"></i></div>
            <div>
                <div class="dashboard-stat-label">Total SMP</div>
                <div class="dashboard-stat-value"><?= $jumlah_smp ?? 0 ?></div>
            </div>
        </div>
        
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon red"><i class="fas fa-database"></i></div>
            <div>
                <div class="dashboard-stat-label">Total Sekolah</div>
                <div class="dashboard-stat-value"><?= $jumlah_sekolah ?? 0 ?></div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-8 col-md-8 col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marked-alt mr-1"></i>
                    Peta Sebaran Sekolah
                </h3>
            </div>

            <div class="card-body p-0">
                <div id="map" style="height:700px;"></div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN -->
    <div class="col-lg-4 col-md-4s col-12">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-school mr-1"></i>
                    Data Sekolah
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="school-list">
                    <?php foreach (array_slice($sekolah ?? [], 0, 5) as $item) : ?>
                    <div class="school-card">
                        <div class="thumb"><?= strtoupper(substr($item['jenjang'] ?? '-', 0, 2)) ?></div>
                        <div class="meta">
                            <p class="name"><?= esc($item['nama_sekolah'] ?? '-') ?></p>
                            <p class="meta-line"><?= esc($item['jenjang'] ?? '-') ?> &middot; <?= esc($item['kecamatan'] ?? ($item['alamat'] ?? '-')) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="<?= base_url('sekolah') ?>" class="btn btn-primary btn-sm">
                    Lihat Semua Sekolah
                </a>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    Data Wilayah
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="p-3">
                    <p class="mb-2"><strong>Total Wilayah:</strong> <?= esc($jumlah_wilayah ?? 0) ?></p>
                </div>
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Wilayah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($wilayah ?? [], 0, 5) as $item) : ?>
                        <tr>
                            <td><?= esc($item['nama_wilayah'] ?? ($item['wilayah'] ?? '-')) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="<?= base_url('Wilayah') ?>" class="btn btn-success btn-sm">
                    Lihat Semua Wilayah
                </a>
            </div>
        </div>


<script>
    // OpenStreetMap
    var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        });

    // Satelit
    var peta2 = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        });

    // Inisialisasi Peta
    var map = L.map('map', {
        center: [-0.4719, 100.5730],
        zoom: 10,
        layers: [peta1]
    });

    // Basemap Control
    var baseMaps = {
        "OpenStreetMap": peta1,
        "Satelit": peta2
    };

    L.control.layers(baseMaps).addTo(map);

    var sekolahData = <?= json_encode($sekolah ?? [], JSON_HEX_TAG) ?>;
    var markerGroup = L.layerGroup().addTo(map);

    function colorForJenjang(j) {
        if (!j) return '#94a3b8';
        j = j.toString().toUpperCase();
        if (j.indexOf('TK') !== -1 || j.indexOf('PAUD') !== -1) return '#48ff00';
        if (j.indexOf('SD') !== -1) return '#ff0000';
        if (j.indexOf('SMP') !== -1 || j.indexOf('MTS') !== -1) return '#0022ff';
        return '#94a3b8';
    }

    sekolahData.forEach(function(item) {
        if (!item.coordinat) return;
        var parts = item.coordinat.split(',');
        if (parts.length !== 2) return;
        var lat = parseFloat(parts[0].trim());
        var lng = parseFloat(parts[1].trim());
        if (isNaN(lat) || isNaN(lng)) return;

        var color = colorForJenjang(item.jenjang);
        var marker = L.circleMarker([lat, lng], {
            radius: 8,
            color: color,
            fillColor: color,
            fillOpacity: 0.9,
            weight: 1
        }).addTo(markerGroup);

        var popupText = '<strong>' + (item.nama_sekolah || 'Sekolah') + '</strong>';
        if (item.jenjang) popupText += '<br>' + item.jenjang;
        if (item.id_sekolah) popupText += '<br><a href="' + ("<?= base_url('sekolah') ?>") + '/' + item.id_sekolah + '">Lihat detail</a>';
        marker.bindPopup(popupText);
        marker.on('mouseover', function() { this.openPopup(); });
    });

    if (markerGroup.getLayers().length === 1) {
        map.setView(markerGroup.getBounds().getCenter(), 12);
    } else if (markerGroup.getLayers().length > 1) {
        map.fitBounds(markerGroup.getBounds().pad(0.15));
    }
</script>
