<?php
$judul = $judul ?? 'Profil Dinas Pendidikan';
$profil = $profil ?? [];
$errors = session()->getFlashdata('errors') ?? [];
?>

<style>
    .profil-hero {
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

    .profil-hero h3 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
    .profil-hero p { color: rgba(255,255,255,.78); margin: 0; }

    .profil-hero-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .profil-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .profil-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .profil-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .profil-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profil-logo {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        object-fit: cover;
        margin-bottom: 16px;
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

    .info-group {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
    }

    .info-value {
        font-size: 14px;
        color: #0f172a;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profil-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">
    <div class="profil-hero">
        <div>
            <h3>Profil Dinas Pendidikan</h3>
            <p>Kelola informasi resmi Dinas Pendidikan Anda.</p>
        </div>
        <div class="profil-hero-icon">
            <i class="fas fa-building"></i>
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

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <div class="card profil-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="profil-title">
                <span class="title-icon"><i class="fas fa-info-circle"></i></span>
                Informasi Dinas
            </h3>
            <a href="<?= site_url('User/edit') ?>" class="btn btn-primary btn-sm" style="margin-left: auto;">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <?php if (empty($profil)): ?>
                <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                    <i class="fas fa-info-circle" style="font-size: 42px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                    <h5>Belum ada profil</h5>
                    <p class="mb-0">Klik tombol Edit untuk menambahkan informasi profil Dinas Pendidikan.</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-4">
                        <div style="text-align: center;">
                            <img src="<?= base_url('profil/' . ($profil['logo'] ?? 'default.png')) ?>" alt="Logo Dinas" class="profil-logo">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="section-title"><span><i class="fas fa-building"></i></span>Identitas Dinas</div>

                        <div class="info-group">
                            <div class="info-label">Nama Dinas</div>
                            <div class="info-value"><?= esc($profil['nama_dinas'] ?? '-') ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Kepala Dinas</div>
                            <div class="info-value"><?= esc($profil['kepala_dinas'] ?? '-') ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">NIP Kepala Dinas</div>
                            <div class="info-value"><?= esc($profil['nip_kepala'] ?? '-') ?></div>
                        </div>

                        <div class="section-title" style="margin-top: 24px;"><span><i class="fas fa-map-marker-alt"></i></span>Kontak</div>

                        <div class="info-group">
                            <div class="info-label">Alamat</div>
                            <div class="info-value"><?= esc($profil['alamat'] ?? '-') ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Telepon</div>
                            <div class="info-value"><?= esc($profil['telepon'] ?? '-') ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= esc($profil['email'] ?? '-') ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Website</div>
                            <div class="info-value"><?= esc($profil['website'] ?? '-') ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
