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

            <?php if (isSuperAdmin()): ?>
                <div class="section-title"><span><i class="fas fa-id-card"></i></span>Data Utama Sekolah</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sekolah" value="<?= esc($sekolah['nama_sekolah']) ?>" placeholder="Contoh: SD Negeri 01" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NPSN <span class="text-danger">*</span></label>
                            <input type="text" name="npsn" value="<?= esc($sekolah['npsn'] ?? '') ?>" placeholder="Contoh: 10100001" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenjang <span class="text-danger">*</span></label>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kecamatan <span class="text-danger">*</span></label>
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
                </div>
            <?php else: ?>
                <div class="section-title"><span><i class="fas fa-id-card"></i></span>Identitas Sekolah</div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sekolah" value="<?= esc($sekolah['nama_sekolah']) ?>" placeholder="Contoh: SD Negeri 01" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>NPSN <span class="text-danger">*</span></label>
                            <input type="text" name="npsn" value="<?= esc($sekolah['npsn'] ?? '') ?>" placeholder="Contoh: 10100001" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jenjang <span class="text-danger">*</span></label>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kabupaten <span class="text-danger">*</span></label>
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control select2">
                                <option value="">Pilih</option>
                                <option value="Negeri" <?= ($sekolah['status'] ?? '') === 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                                <option value="Swasta" <?= ($sekolah['status'] ?? '') === 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Akreditasi <span class="text-danger">*</span></label>
                            <select name="akreditasi" class="form-control select2">
                                <option value="">Pilih</option>
                                <?php foreach (['A', 'B', 'C', 'D'] as $akreditasi): ?>
                                    <option value="<?= $akreditasi ?>" <?= ($sekolah['akreditasi'] ?? '') === $akreditasi ? 'selected' : '' ?>><?= $akreditasi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="section-title"><span><i class="fas fa-map-signs"></i></span>Lokasi Administratif</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kecamatan <span class="text-danger">*</span></label>
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
                            <label>Nagari <span class="text-danger">*</span></label>
                            <select name="id_nagari" id="id_nagari" class="form-control select2">
                                <option value="">Pilih Nagari</option>
                                <?php foreach ($nagari as $value): ?>
                                    <option value=" <?= esc($value['id_nagari']) ?>" <?= ($value['id_nagari'] == $sekolah['id_nagari']) ? 'selected' : '' ?>>
                                        <?= esc($value['nama_nagari']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, atau deskripsi lokasi sekolah"><?= esc($sekolah['alamat'] ?? '') ?></textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle mr-1"></i>Format: Jalan/Dusun, No. | Akan otomatis ditambah: Nagari, Kecamatan, Kabupaten
                            </small>
                        </div>
                    </div>
                </div>

                <div class="section-title"><span><i class="fas fa-info-circle"></i></span>Informasi Tambahan</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Visi</label>
                            <textarea name="visi" class="form-control" rows="3" placeholder="Visi sekolah"><?= esc($sekolah['visi'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Misi</label>
                            <textarea name="misi" class="form-control" rows="4" placeholder="Misi sekolah (pisahkan dengan baris baru)"><?= esc($sekolah['misi'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Detail Kegiatan</label>
                            <textarea name="detail_kegiatan" class="form-control" rows="4" placeholder="Deskripsi kegiatan-kegiatan yang dilakukan sekolah"><?= esc($sekolah['detail_kegiatan'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kontak Admin</label>
                            <input type="text" name="kontak_admin" value="<?= esc($sekolah['kontak_admin'] ?? '') ?>" placeholder="Nomor telepon atau email" class="form-control" maxlength="50">
                            <small class="text-muted">Maksimal 50 karakter</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Banyak Guru</label>
                            <input type="number" name="banyak_guru" value="<?= esc($sekolah['banyak_guru'] ?? '') ?>" placeholder="Jumlah guru" class="form-control" min="0">
                        </div>
                    </div>
                </div>

                <div class="section-title"><span><i class="fas fa-image"></i></span>Foto Sekolah</div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Unggah Foto Sekolah</label>
                            <div class="custom-file">
                                <input type="file" accept="image/png,image/jpeg,image/webp" name="foto" class="custom-file-input" id="fotoInput">
                                <label class="custom-file-label" for="fotoInput">Pilih file...</label>
                            </div>
                            <small class="text-muted d-block mt-2">Format: JPG, JPEG, PNG, WEBP | Maksimal: 2 MB</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Preview Foto</label>
                            <div id="fotoPreview" style="width: 100%; height: 200px; border: 2px dashed #ccc; border-radius: 8px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; overflow: hidden;">
                                <?php if (!empty($sekolah['foto'])): ?>
                                    <img id="previewImage" src="<?= base_url('foto/' . esc($sekolah['foto'])) ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div id="noImage" style="text-align: center; color: #999;">
                                        <i class="fas fa-image" style="font-size: 48px; display: block; margin-bottom: 8px;"></i>
                                        <small>Belum ada foto</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title"><span><i class="fas fa-map-marker-alt"></i></span>Titik Koordinat</div>
                <div class="map-panel">
                    <div id="map"></div>
                    <div class="map-help">
                        Klik peta, geser marker, atau isi langsung titik koordinat secara manual.
                    </div>
                </div>
                <input name="coordinat" id="Coordinat" value="<?= esc($sekolah['coordinat']) ?>" placeholder="Koordinat Sekolah (lat,lng)" class="form-control mt-2">
            <?php endif; ?>

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
        // Inisialisasi Select2 untuk semua select
        $('.select2').select2({ width: '100%' });

        // Preview foto ketika user memilih file
        $('#fotoInput').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#fotoPreview').html('<img id="previewImage" src="' + event.target.result + '" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">');
                    // Update label file
                    const fileName = file.name;
                    $('#fotoInput').next('.custom-file-label').html(fileName);
                };
                reader.readAsDataURL(file);
            }
        });

        // Update custom file label
        $('#fotoInput').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Ketika Kabupaten berubah, update Kecamatan
        $('#id_kabupaten').on('change', function() {
            var id_kabupaten = $(this).val();
            
            if (id_kabupaten) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Sekolah/Kecamatan') ?>",
                    data: { id_kabupaten: id_kabupaten },
                    success: function(response) {
                        $('#id_kecamatan').html(response);
                        // Reinitialize Select2 untuk dropdown kecamatan
                        $('#id_kecamatan').select2({ width: '100%' });
                        // Reset Nagari
                        $('#id_nagari').html('<option value="">Pilih Nagari</option>');
                        $('#id_nagari').select2({ width: '100%' });
                        updateAlamatFormat();
                    },
                    error: function() {
                        console.log('Error loading kecamatan');
                    }
                });
            }
        });

        function loadNagariByKecamatan(idKecamatan) {
            if (idKecamatan) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Sekolah/Nagari') ?>",
                    data: { id_kecamatan: idKecamatan },
                    success: function(response) {
                        $('#id_nagari').html(response);
                        $('#id_nagari').select2({ width: '100%' });
                        updateAlamatFormat();
                    },
                    error: function() {
                        console.log('Error loading nagari');
                    }
                });
            } else {
                $('#id_nagari').html('<option value="">Pilih Nagari</option>');
                $('#id_nagari').select2({ width: '100%' });
            }
        }

        // Ketika Kecamatan berubah, update Nagari
        $('#id_kecamatan').on('change', function() {
            loadNagariByKecamatan($(this).val());
        });

        // Untuk mode admin, isi nagari sesuai kecamatan yang sudah dipilih saat halaman terbuka
        var initialKecamatan = $('#id_kecamatan').val();
        if (initialKecamatan) {
            loadNagariByKecamatan(initialKecamatan);
        }

        // Update format alamat ketika ada perubahan
        $('#id_kabupaten, #id_kecamatan, #id_nagari').on('change', function() {
            updateAlamatFormat();
        });

        // Fungsi untuk update format alamat
        function updateAlamatFormat() {
            var kabupaten = $('#id_kabupaten option:selected').text();
            var kecamatan = $('#id_kecamatan option:selected').text();
            var nagari = $('#id_nagari option:selected').text();
            var alamatInput = $('textarea[name="alamat"]');
            var currentAlamat = alamatInput.val();

            // Hapus format otomatis sebelumnya
            var cleanAlamat = currentAlamat.split('|')[0].trim();

            // Format baru dengan separator
            if (kabupaten && kecamatan && nagari && kabupaten !== '-- Pilih Kabupaten --' && kecamatan !== '-- Pilih kecamatan --' && nagari !== '-- Pilih Nagari --') {
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

    function updateMarkerFromInput() {
        var value = coordinat.value.trim();
        var coords = value.split(',').map(function(item) { return item.trim(); });
        if (coords.length >= 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
            var lat = parseFloat(coords[0]);
            var lng = parseFloat(coords[1]);
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng]);
        }
    }

    marker.on('dragend', function() {
        var position = marker.getLatLng();
        coordinat.value = position.lat + "," + position.lng;
    });

    map.on("click", function(e) {
        marker.setLatLng(e.latlng);
        coordinat.value = e.latlng.lat + "," + e.latlng.lng;
    });

    coordinat.addEventListener('change', function() {
        updateMarkerFromInput();
    });
    coordinat.addEventListener('blur', function() {
        updateMarkerFromInput();
    });
</script>