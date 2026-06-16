<?php
$judul = $judul ?? 'Edit Sekolah';
$page = $page ?? '';
$kabupaten = $kabupaten ?? [];
$kecamatan = $kecamatan ?? [];
$wilayah = $wilayah ?? [];
$web = $web ?? [];
$jenjang = $jenjang ?? [];
$sekolah = $sekolah ?? [];
$nagari = $nagari ?? [];

$mapCoordinate = $sekolah['coordinat'] ?? '-0.460000,100.594000';
$mapZoom = $web['zoom_view'] ?? 10;

if (! preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $mapCoordinate)) {
    $mapCoordinate = '-0.460000,100.594000';
}
?>

<style>
    .school-form-hero {
        background: linear-gradient(135deg, #1d4ed8 0%, #0f766e 100%);
        color: #fff;
        border-radius: 12px;
        padding: 24px 26px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
    }

    .school-form-hero h3 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
    .school-form-hero p { color: rgba(255,255,255,.78); margin: 0; }

    .school-form-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .school-form-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 8px 0 16px;
    }

    .section-title span {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .map-panel {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        background: #f8fafc;
    }

    #map {
        width: 100%;
        height: 420px;
    }

    .map-help {
        padding: 12px 14px;
        color: #64748b;
        font-size: 13px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
        margin-top: 18px;
    }

    @media (max-width: 768px) {
        .school-form-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">
    <div class="school-form-hero">
        <div>
            <h3><?= $judul ?></h3>
            <p>Perbarui identitas, lokasi administratif, foto, dan titik koordinat sekolah.</p>
        </div>
        <div class="school-form-icon">
            <i class="fas fa-edit"></i>
        </div>
    </div>

    <div class="card school-form-card">
        <div class="card-body">

            <?php
            $errors = session()->getFlashdata('errors') ?? [];
            ?>

            <?php if (! empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Data belum valid</h5>
                    <?php foreach ($errors as $error): ?>
                        <div><?= esc($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?= form_open_multipart('Sekolah/UpdateData/' . $sekolah['id_sekolah']) ?>

            <div class="section-title"><span><i class="fas fa-id-card"></i></span>Identitas Sekolah</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" value="<?= esc($sekolah['nama_sekolah']) ?>" placeholder="Contoh: SD Negeri 01" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2">
                            <option value="">Pilih</option>
                            <option value="Negeri" <?= ($sekolah['status'] ?? '') === 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                            <option value="Swasta" <?= ($sekolah['status'] ?? '') === 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Akreditasi</label>
                        <select name="akreditasi" class="form-control select2">
                            <option value="">Pilih</option>
                            <?php foreach (['A', 'B', 'C', 'D'] as $akreditasi): ?>
                                <option value="<?= $akreditasi ?>" <?= ($sekolah['akreditasi'] ?? '') === $akreditasi ? 'selected' : '' ?>><?= $akreditasi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Jenjang</label>
                        <select name="id_jenjang" class="form-control select2">
                            <option value="">Pilih</option>
                            <?php foreach ($jenjang as $value): ?>
                                <option value="<?= esc($value['id_jenjang']) ?>" <?= ($value['id_jenjang'] == $sekolah['id_jenjang']) ? 'selected' : '' ?>>
                                    <?= esc($value['jenjang']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="section-title"><span><i class="fas fa-map-signs"></i></span>Lokasi Administratif</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kabupaten</label>
                        <select name="id_kabupaten" id="id_kabupaten" class="form-control select2">
                            <option value="">Pilih Kabupaten</option>
                            <?php foreach ($kabupaten as $value): ?>
                                <option value="<?= esc($value['id_kabupaten']) ?>" <?= ($value['id_kabupaten'] == $sekolah['id_kabupaten']) ? 'selected' : '' ?>>
                                    <?= esc($value['nama_kabupaten']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control select2">
                            <option value="">Pilih Kecamatan</option>
                            <?php foreach ($kecamatan as $value): ?>
                                <option value="<?= esc($value['id_kecamatan']) ?>" <?= ($value['id_kecamatan'] == $sekolah['id_kecamatan']) ? 'selected' : '' ?>>
                                    <?= esc($value['nama_kecamatan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nagari</label>
                        <select name="id_nagari" id="id_nagari" class="form-control select2">
                            <option value="">Pilih Nagari</option>
                            <?php foreach ($nagari as $value): ?>
                                <option value="<?= esc($value['id_nagari']) ?>" <?= ($value['id_nagari'] == $sekolah['id_nagari']) ? 'selected' : '' ?>>
                                    <?= esc($value['nama_nagari']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, atau deskripsi lokasi sekolah"><?= esc($sekolah['alamat'] ?? '') ?></textarea>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Format: Jalan/Dusun, No. | Akan otomatis ditambah: Nagari, Kecamatan, Kabupaten
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Foto Sekolah</label>
                        <input type="file" accept="image/png,image/jpeg,image/webp" name="foto" class="form-control">
                    </div>
                </div>
            </div>

            <div class="section-title"><span><i class="fas fa-map-marker-alt"></i></span>Titik Koordinat</div>
            <div class="map-panel">
                <div id="map"></div>
                <div class="map-help">
                    Klik peta atau geser marker untuk menentukan koordinat sekolah.
                </div>
            </div>
            <input name="coordinat" id="Coordinat" value="<?= esc($sekolah['coordinat']) ?>" placeholder="Koordinat Sekolah" class="form-control mt-2" readonly>

            <div class="form-actions">
                <a href="<?= site_url('Sekolah') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Simpan</button>
            </div>

            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({ width: '100%' });

        $('#id_kabupaten').change(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Sekolah/Kecamatan') ?>",
                data: { id_kabupaten: $('#id_kabupaten').val() },
                success: function(response) {
                    $('#id_kecamatan').html(response);
                }
            });
        });

        $('#id_kecamatan').change(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Sekolah/Nagari') ?>",
                data: { id_kecamatan: $('#id_kecamatan').val() },
                success: function(response) {
                    $('#id_nagari').html(response);
                    updateAlamatFormat();
                }
            });
        });

        $('#id_kabupaten, #id_kecamatan, #id_nagari').change(function() {
            updateAlamatFormat();
        });

        function updateAlamatFormat() {
            var kabupaten = $('#id_kabupaten option:selected').text();
            var kecamatan = $('#id_kecamatan option:selected').text();
            var nagari = $('#id_nagari option:selected').text();
            var alamatInput = $('textarea[name="alamat"]');
            var currentAlamat = alamatInput.val();

            // Hapus format otomatis sebelumnya
            var cleanAlamat = currentAlamat.split('|')[0].trim();

            // Format baru dengan separator
            if (kabupaten && kecamatan && nagari) {
                var formattedAlamat = cleanAlamat + ' | ' + nagari + ', ' + kecamatan + ', ' + kabupaten;
                alamatInput.val(formattedAlamat);
            }
        }
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
        center: [<?= $mapCoordinate ?>],
        zoom: <?= (int) $mapZoom ?>,
        layers: [peta1]
    });

    L.control.layers({
        "OpenStreetMap": peta1,
        "Satelit": peta2,
        "Light": peta3
    }).addTo(map);

    var coordinat = document.querySelector("[name=coordinat]");
    var marker = L.marker([<?= $mapCoordinate ?>], { draggable: true }).addTo(map);
    map.attributionControl.setPrefix(false);

    marker.on('dragend', function() {
        var position = marker.getLatLng();
        coordinat.value = position.lat + "," + position.lng;
    });

    map.on("click", function(e) {
        marker.setLatLng(e.latlng);
        coordinat.value = e.latlng.lat + "," + e.latlng.lng;
    });
</script>