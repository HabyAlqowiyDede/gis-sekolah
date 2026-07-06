<?php
$judul = $judul ?? 'Wilayah';
$wilayah = $wilayah ?? [];
$web = $web ?? [];
$totalWilayah = count($wilayah);
?>

<style>
    .wilayah-hero {
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

    .wilayah-hero h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .wilayah-hero p {
        color: rgba(255, 255, 255, .78);
        margin: 0;
    }

    .wilayah-hero-icon {
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

    .wilayah-stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .wilayah-stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
    }

    .wilayah-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .wilayah-stat-icon.blue { background: #eff6ff; color: #1d4ed8; }
    .wilayah-stat-icon.green { background: #ecfdf5; color: #047857; }

    .wilayah-stat-label {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .wilayah-stat-value {
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
    }

    .wilayah-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .wilayah-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .wilayah-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .wilayah-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .color-preview {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        display: inline-block;
    }

    .btn-action {
        border-radius: 8px;
        padding: 7px 10px;
    }

    .dataTables_wrapper {
        padding: 0 !important;
    }

    .dataTables_length, .dataTables_filter {
        padding: 16px 0 !important;
        color: #0f172a !important;
        font-size: 14px;
    }

    .dataTables_length label, .dataTables_filter label {
        margin-bottom: 0 !important;
    }

    .dataTables_length select, .dataTables_filter input {
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        font-size: 13px;
    }

    .dataTables_info {
        padding: 12px 0 !important;
        color: #64748b !important;
        font-size: 13px;
    }

    .dataTables_paginate {
        padding: 12px 0 !important;
    }

    .paginate_button {
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        margin: 0 2px !important;
        background: #fff !important;
        color: #0f172a !important;
        font-size: 13px;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }

    .paginate_button:hover {
        background: #f1f5f9 !important;
        border-color: #1d4ed8 !important;
    }

    .paginate_button.current {
        background: #1d4ed8 !important;
        color: #fff !important;
        border-color: #1d4ed8 !important;
    }

    .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
    }

    .map-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
        margin-top: 18px;
    }

    @media (max-width: 768px) {
        .wilayah-hero { align-items: flex-start; flex-direction: column; }
        .wilayah-stat-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="col-md-12">

    <div class="wilayah-stat-grid">
        <div class="wilayah-stat-card">
            <div class="wilayah-stat-icon blue"><i class="fas fa-map"></i></div>
            <div>
                <div class="wilayah-stat-label">Total Wilayah</div>
                <div class="wilayah-stat-value"><?= esc($totalWilayah) ?></div>
            </div>
        </div>
        <div class="wilayah-stat-card">
            <div class="wilayah-stat-icon green"><i class="fas fa-database"></i></div>
            <div>
                <div class="wilayah-stat-label">Sumber Data</div>
                <div class="wilayah-stat-value">GIS</div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('Insert')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('Insert')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('Update')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('Update')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('delete')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-info-circle"></i> Informasi</h5>
            <?= esc(session()->getFlashdata('delete')) ?>
        </div>
    <?php endif; ?>

    <div class="card wilayah-card">
        <div class="card-header d-flex align-items-center">
            <h3 class="wilayah-title">
                <span class="title-icon"><i class="fas fa-list"></i></span>
                Data Wilayah
            </h3>
            <a href="<?= site_url('Wilayah/input') ?>" class="btn btn-primary btn-sm" style="margin-left: auto;">
                <i class="fas fa-plus mr-1"></i> Tambah Wilayah
            </a>
        </div>
        <div class="card-body">
            <table id="tableWilayah" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50px" class="text-center">No</th>
                        <th>Nama Wilayah</th>
                        <th width="100px" class="text-center">Warna</th>
                        <th width="150px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($wilayah as $value): ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++ ?></td>
                            <td class="align-middle"><?= esc($value['nama_wilayah']) ?></td>
                            <td class="text-center align-middle">
                                <span class="color-preview" style="background-color: <?= esc($value['warna']) ?>;" title="<?= esc($value['warna']) ?>"></span>
                            </td>
                            <td class="text-center align-middle">
                                <a href="<?= site_url('Wilayah/Edit/' . $value['id_wilayah']) ?>" class="btn btn-warning btn-sm btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" data-toggle="modal" data-target="#modalDelete<?= esc($value['id_wilayah']) ?>" class="btn btn-danger btn-sm btn-action" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="map-container">
        <div id="map" style="width: 100%; height: 600px;"></div>
    </div>
</div>

<?php foreach ($wilayah as $value): ?>
    <div class="modal fade" id="modalDelete<?= esc($value['id_wilayah']) ?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?= site_url('Wilayah/Delete/' . $value['id_wilayah']) ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-trash text-danger mr-2"></i>Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Hapus wilayah <strong><?= esc($value['nama_wilayah']) ?></strong>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(function () {
        $('#tableWilayah').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                paginate: {
                    first: '<i class="fas fa-step-backward"></i>',
                    last: '<i class="fas fa-step-forward"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>

<script>
    var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    });

    var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri'
    });

    var peta3 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
    });

    const map = L.map('map', {
        center: [<?= $web['coordinat_wilayah'] ?? '-0.460000,100.594000' ?>],
        zoom: <?= (int) ($web['zoom_view'] ?? 10) ?>,
        layers: [peta2]
    });

    const baseMaps = {
        "Satelit": peta2,
        "OpenStreetMap": peta1,
        "Light": peta3
    };
    L.control.layers(baseMaps).addTo(map);

    <?php foreach ($wilayah as $key => $value) {
        $raw_geojson = $value['geojson'];
        $teks_rusak = '"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}},';
        $clean_geojson = str_replace($teks_rusak, '', $raw_geojson);
        $clean_geojson = preg_replace('/[\r\n\t]+/', ' ', $clean_geojson);
    ?>
        try {
            let geojsonString_<?= $key ?> = `<?= $clean_geojson ?>`;
            let geojsonObject_<?= $key ?> = JSON.parse(geojsonString_<?= $key ?>);

            L.geoJSON(geojsonObject_<?= $key ?>, {
                fillColor: '<?= $value['warna'] ?>',
                fillOpacity: 0.5,
                onEachFeature: function (feature, layer) {
                    let namaPopup = "<b><?= addslashes($value['nama_wilayah']) ?></b>";
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