<?php
$judul = $judul ?? 'Edit Profil Dinas Pendidikan';
$profil = $profil ?? [];
$errors = session()->getFlashdata('errors') ?? [];
?>

<style>
    .profil-form-hero {
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

    .profil-form-hero h3 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
    .profil-form-hero p { color: rgba(255,255,255,.78); margin: 0; }

    .profil-form-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .profil-form-card {
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

    .logo-preview {
        width: 150px;
        height: 150px;
        border: 2px dashed #e5e7eb;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .logo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .profil-form-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">
    <div class="profil-form-hero">
        <div>
            <h3>Edit Profil Dinas Pendidikan</h3>
            <p>Perbarui informasi dan identitas resmi Dinas Pendidikan.</p>
        </div>
        <div class="profil-form-icon">
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

    <div class="card profil-form-card">
        <div class="card-body">
            <?= form_open_multipart('User/UpdateProfil') ?>

            <div class="section-title"><span><i class="fas fa-image"></i></span>Logo Dinas</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="logo-preview">
                        <?php if (!empty($profil['logo'])): ?>
                            <img src="<?= base_url('profil/' . $profil['logo']) ?>" alt="Logo Dinas">
                        <?php else: ?>
                            <i class="fas fa-image" style="font-size: 48px; color: #cbd5e1;"></i>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Upload Logo Baru</label>
                        <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted">Format: PNG, JPG, WebP. Maks 2 MB</small>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="section-title"><span><i class="fas fa-building"></i></span>Identitas Dinas</div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Dinas Pendidikan</label>
                                <input type="text" name="nama_dinas" value="<?= esc($profil['nama_dinas'] ?? '') ?>" placeholder="Contoh: Dinas Pendidikan Kabupaten Tanah Datar" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kepala Dinas</label>
                                <input type="text" name="kepala_dinas" value="<?= esc($profil['kepala_dinas'] ?? '') ?>" placeholder="Nama lengkap" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP Kepala Dinas</label>
                                <input type="text" name="nip_kepala" value="<?= esc($profil['nip_kepala'] ?? '') ?>" placeholder="NIP" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-title" style="margin-top: 24px;"><span><i class="fas fa-map-marker-alt"></i></span>Informasi Kontak</div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Jalan, No., Kelurahan, Kecamatan, Kab/Kota, Provinsi"><?= esc($profil['alamat'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="telepon" value="<?= esc($profil['telepon'] ?? '') ?>" placeholder="Contoh: (0753) 7123456" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= esc($profil['email'] ?? '') ?>" placeholder="Contoh: info@dinpendidikan.go.id" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Website</label>
                <input type="url" name="website" value="<?= esc($profil['website'] ?? '') ?>" placeholder="Contoh: https://dinpendidikan.go.id" class="form-control">
            </div>

            <div class="form-actions">
                <a href="<?= site_url('User') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Simpan Profil</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
