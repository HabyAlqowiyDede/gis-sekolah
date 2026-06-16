<?php
$judul = $judul ?? 'Input Sekolah';
$kabupaten = $kabupaten ?? [];
$web = $web ?? [];
$jenjang = $jenjang ?? [];
$wilayah = $wilayah ?? [];
$errors = session()->getFlashdata('errors') ?? [];
$kecamatan = $kecamatan ?? [];
$nagari = $nagari ?? [];    

$oldIdJenjang = old('id_jenjang');
$oldIdKabupaten = old('id_kabupaten');
$oldIdKecamatan = old('id_kecamatan');
$oldIdNagari = old('id_nagari');
$mapCoordinate = old('coordinat') ?: ($web['coordinat_wilayah'] ?? '-0.460000,100.594000');
$mapZoom = $web['zoom_view'] ?? 10;

if (! preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $mapCoordinate)) {
    $mapCoordinate = '-0.460000,100.594000';
}

list($mapLat, $mapLng) = array_map('trim', explode(',', $mapCoordinate) + ['', '']);
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
            <h3>Tambah Data Sekolah</h3>
            <p>Lengkapi identitas, lokasi Sekolah, foto, dan titik koordinat sekolah.</p>
        </div>
        <div class="school-form-icon">
            <i class="fas fa-plus"></i>
        </div>
    </div>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Data belum valid</h5>
            <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card school-form-card">
        <div class="card-body">
            <?= form_open_multipart('Sekolah/InsertData') ?>

            <div class="section-title"><span><i class="fas fa-id-card"></i></span>Identitas Sekolah</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" value="<?= esc(old('nama_sekolah')) ?>" placeholder="Contoh: SD Negeri 01" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2" required>
                            <option value="">Pilih</option>
                            <option value="Negeri" <?= old('status') === 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                            <option value="Swasta" <?= old('status') === 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Akreditasi</label>
                        <select name="akreditasi" class="form-control select2" required>
                            <option value="">Pilih</option>
                            <?php foreach (['A', 'B', 'C', 'D'] as $akreditasi): ?>
                                <option value="<?= $akreditasi ?>" <?= old('akreditasi') === $akreditasi ? 'selected' : '' ?>><?= $akreditasi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Jenjang</label>
                        <select name="id_jenjang" class="form-control select2" required>
                            <option value="">Pilih</option>
                            <?php foreach ($jenjang as $value): ?>
                                <option value="<?= esc($value['id_jenjang']) ?>" <?= ($value['id_jenjang'] == $oldIdJenjang) ? 'selected' : '' ?>>
                                    <?= esc($value['jenjang']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="section-title"><span><i class="fas fa-map-signs"></i></span>Lokasi Sekolah</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kabupaten</label>
                        <select name="id_kabupaten" id="id_kabupaten" class="form-control select2" required>
                            <option value="">Pilih Kabupaten</option>
                            <?php foreach ($kabupaten as $value): ?>
                                <option value="<?= esc($value['id_kabupaten']) ?>" <?= ($value['id_kabupaten'] == $oldIdKabupaten) ? 'selected' : '' ?>>
                                    <?= esc($value['nama_kabupaten']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" required>
                            <option value="">Pilih Kecamatan</option>
                            <?php foreach ($kecamatan as $value): ?>
                                <option value="<?= esc($value['id_kecamatan']) ?>" <?= ($value['id_kecamatan'] == $oldIdKecamatan) ? 'selected' : '' ?>>
                                    <?= esc($value['nama_kecamatan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nagari</label>
                        <select name="id_nagari" id="id_nagari" class="form-control select2" required>
                            <option value="">Pilih Nagari</option>
                            <?php foreach ($nagari as $value): ?>
                                <option value="<?= esc($value['id_nagari']) ?>" <?= ($value['id_nagari'] == $oldIdNagari) ? 'selected' : '' ?>>
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
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="<?= esc(old('alamat')) ?>" placeholder="Alamat lengkap sekolah" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Foto Sekolah</label>
                        <input type="file" accept="image/png,image/jpeg,image/webp" name="foto" class="form-control" required>
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
            <input name="coordinat" id="Coordinat" value="<?= esc($mapCoordinate) ?>" placeholder="Koordinat Sekolah" class="form-control mt-2" readonly required>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" name="latitude" id="Latitude" value="<?= esc(old('latitude') ?: $mapLat) ?>" class="form-control" placeholder="-0.460000" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" name="longitude" id="Longitude" value="<?= esc(old('longitude') ?: $mapLng) ?>" class="form-control" placeholder="100.594000" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <small class="text-muted">Ubah latitude/longitude secara manual atau klik peta untuk mengatur koordinat.</small>
            </div>

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

        var oldIdKecamatan = "<?= esc($oldIdKecamatan, 'js') ?>";
        var oldIdNagari = "<?= esc($oldIdNagari, 'js') ?>";

        $('#id_kabupaten').change(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Sekolah/Kecamatan') ?>",
                data: { id_kabupaten: $('#id_kabupaten').val() },
                success: function(response) {
                    $('#id_kecamatan').html(response);
                    if (oldIdKecamatan) {
                        $('#id_kecamatan').val(oldIdKecamatan).trigger('change');
                        oldIdKecamatan = "";
                    }
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
                    if (oldIdNagari) {
                        $('#id_nagari').val(oldIdNagari).trigger('change');
                        oldIdNagari = "";
                    }
                }
            });
        });

        if ($('#id_kabupaten').val()) {
            $('#id_kabupaten').trigger('change');
        }
    });
</script>

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
        center: [<?= $mapCoordinate ?>],
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

    var coordinat = document.querySelector('[name="coordinat"]');
    var latitudeInput = document.querySelector('[name="latitude"]');
    var longitudeInput = document.querySelector('[name="longitude"]');
    var initialPosition = [<?= $mapCoordinate ?>];
    var marker = L.marker(initialPosition, { draggable: true }).addTo(map);

    map.attributionControl.setPrefix(false);

    function updateCoordinateFields(latlng) {
        var lat = Number(latlng.lat).toFixed(6);
        var lng = Number(latlng.lng).toFixed(6);
        coordinat.value = lat + ',' + lng;
        latitudeInput.value = lat;
        longitudeInput.value = lng;
    }

    function updateMarkerFromInputs() {
        var lat = parseFloat(latitudeInput.value);
        var lng = parseFloat(longitudeInput.value);

        if (!isNaN(lat) && !isNaN(lng)) {
            var latlng = L.latLng(lat, lng);
            marker.setLatLng(latlng);
            map.panTo(latlng);
            coordinat.value = lat.toFixed(6) + ',' + lng.toFixed(6);
        }
    }

    updateCoordinateFields(marker.getLatLng());

    marker.on('dragend', function() {
        updateCoordinateFields(marker.getLatLng());
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinateFields(e.latlng);
    });

    latitudeInput.addEventListener('change', updateMarkerFromInputs);
    longitudeInput.addEventListener('change', updateMarkerFromInputs);

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
