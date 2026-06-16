<?php
$judul = $judul ?? 'Edit Wilayah';
$wilayah = $wilayah ?? [];
$errors = session()->getFlashdata('errors') ?? [];
?>

<style>
    .wilayah-form-hero {
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

    .wilayah-form-hero h3 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
    .wilayah-form-hero p { color: rgba(255,255,255,.78); margin: 0; }

    .wilayah-form-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .wilayah-form-card {
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

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
        margin-top: 18px;
    }

    @media (max-width: 768px) {
        .wilayah-form-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">
    <div class="wilayah-form-hero">
        <div>
            <h3>Edit Wilayah Administrasi</h3>
            <p>Perbarui informasi wilayah, warna, dan data GeoJSON.</p>
        </div>
        <div class="wilayah-form-icon">
            <i class="fas fa-edit"></i>
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

    <div class="card wilayah-form-card">
        <div class="card-body">
            <?= form_open('Wilayah/UpdateData/' . $wilayah['id_wilayah']) ?>

            <div class="section-title"><span><i class="fas fa-map"></i></span>Informasi Wilayah</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Wilayah</label>
                        <input type="text" name="nama_wilayah" value="<?= esc(old('nama_wilayah', $wilayah['nama_wilayah'])) ?>" placeholder="Contoh: Kabupaten Tanah Datar" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Warna Wilayah</label>
                        <input type="text" name="warna" value="<?= esc(old('warna', $wilayah['warna'])) ?>" placeholder="#FF5733" class="form-control my-colorpicker1">
                    </div>
                </div>
            </div>

            <div class="section-title"><span><i class="fas fa-file-code"></i></span>Data GeoJSON</div>
            <div class="form-group">
                <label>GeoJSON Data</label>
                <textarea name="geojson" class="form-control" rows="12" placeholder="Paste GeoJSON data here..."><?= esc(old('geojson', $wilayah['geojson'])) ?></textarea>
            </div>

            <div class="form-actions">
                <a href="<?= site_url('Wilayah') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Simpan</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $('.my-colorpicker1').colorpicker();
</script>