<?php
$judul = $judul ?? 'Setting';
$page = $page ?? '';
?>

<style>
    .setting-hero {
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

    .setting-hero h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .setting-hero p {
        color: rgba(255, 255, 255, .78);
        margin: 0;
    }

    .setting-hero-icon {
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

    .setting-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
        margin-bottom: 18px;
    }

    .setting-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .setting-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .setting-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
        margin-top: 18px;
    }

    .info-badge {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .setting-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">
    <div class="setting-hero">
        <div>
            <h3>Pengaturan Sistem</h3>
            <p>Kelola konfigurasi website dan sistem Dinas Pendidikan.</p>
        </div>
        <div class="setting-hero-icon">
            <i class="fas fa-cogs"></i>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('pesan')) ?>
        </div>
    <?php endif; ?>


    <!-- Konfigurasi Website -->
    <div class="card setting-card">
        <div class="card-header">
            <h3 class="setting-title">
                <span class="title-icon"><i class="fas fa-globe"></i></span>
                Konfigurasi Website
            </h3>
        </div>
        <div class="card-body">
            <?php echo form_open('Admin/UpdateSetting') ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Website</label>
                        <input name="nama_web" value="<?= esc($web['nama_web'] ?? '') ?>" class="form-control" placeholder="GIS Sekolah" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tahun Ajaran Aktif</label>
                        <input name="tahun_ajaran" value="<?= esc($web['tahun_ajaran'] ?? '') ?>" class="form-control" placeholder="2024/2025" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Koordinat Wilayah</label>
                        <input name="coordinat_wilayah" value="<?= esc($web['coordinat_wilayah'] ?? '') ?>" class="form-control" placeholder="-0.460000,100.594000" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Zoom View Peta</label>
                        <input type="number" name="zoom_view" value="<?= esc($web['zoom_view'] ?? '') ?>" min="0" max="20" class="form-control" required>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="mt-4 mb-3"><i class="fas fa-phone mr-2"></i>Kontak & Media Sosial</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telepon Support</label>
                        <input name="telepon_support" value="<?= esc($web['telepon_support'] ?? '') ?>" class="form-control" placeholder="(0753) 7123456">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Support</label>
                        <input type="email" name="email_support" value="<?= esc($web['email_support'] ?? '') ?>" class="form-control" placeholder="support@dinpendidikan.go.id">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Facebook</label>
                        <input name="fb_link" value="<?= esc($web['fb_link'] ?? '') ?>" class="form-control" placeholder="https://facebook.com/...">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Instagram</label>
                        <input name="ig_link" value="<?= esc($web['ig_link'] ?? '') ?>" class="form-control" placeholder="https://instagram.com/...">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Twitter</label>
                        <input name="tw_link" value="<?= esc($web['tw_link'] ?? '') ?>" class="form-control" placeholder="https://twitter.com/...">
                    </div>
                </div>
            </div>  

            <h5 class="mt-4 mb-3"><i class="fas fa-palette mr-2"></i>Tampilan & Tema</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tema Aplikasi</label>
                        <select name="tema" class="form-control">
                            <option value="light" <?= ($web['tema'] ?? '') === 'light' ? 'selected' : '' ?>>Light (Terang)</option>
                            <option value="dark" <?= ($web['tema'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark (Gelap)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Warna Utama</label>
                        <input type="color" name="warna_utama" value="<?= esc($web['warna_utama'] ?? '#1d4ed8') ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Pengaturan</button>
            </div>

            <?php echo form_close() ?>
        </div>
    </div>

    <!-- Peta untuk Setting Koordinat -->
    <div class="card setting-card">
        <div class="card-header">
            <h3 class="setting-title">
                <span class="title-icon"><i class="fas fa-map"></i></span>
                Atur Koordinat Wilayah
            </h3>
        </div>
        <div class="card-body">
            <div id="map" style="width: 100%; height: 500px; border-radius: 8px;"></div>
            <small class="text-muted mt-2 d-block">Klik pada peta untuk mengubah koordinat wilayah</small>
        </div>
    </div>
</div>

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
        zoom: <?= (int)($web['zoom_view'] ?? 10) ?>,
        layers: [peta1]
    });

    const baseMaps = {
        "OpenStreetMap": peta1,
        "Satelit": peta2,
        "Light": peta3
    };

    L.control.layers(baseMaps).addTo(map);

    var coordinatInput = document.querySelector("[name=coordinat_wilayah]");

    map.on("click", function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        coordinatInput.value = lat + "," + lng;

        // Update marker jika ada
        if (window.settingMarker) {
            map.removeLayer(window.settingMarker);
        }
        window.settingMarker = L.marker(e.latlng).addTo(map);
    });

    // Tambah marker di posisi awal
    var initialCoord = "<?= $web['coordinat_wilayah'] ?? '-0.460000,100.594000' ?>".split(',');
    if (initialCoord[0] && initialCoord[1]) {
        L.marker([parseFloat(initialCoord[0]), parseFloat(initialCoord[1])]).addTo(map);
    }
</script>
