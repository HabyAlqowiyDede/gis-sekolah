<?php
$jumlah_tk = $jumlah_tk ?? 0;
$jumlah_sd = $jumlah_sd ?? 0;
$jumlah_smp = $jumlah_smp ?? 0;
$jumlah_sekolah = $jumlah_sekolah ?? 0;
$sekolah = $sekolah ?? [];
$wilayah = $wilayah ?? [];
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
        grid-template-columns: repeat(1, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .dashboard-stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
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

    .dashboard-stat-icon.blue { background: #eff6ff; color: #1d4ed8; }

    .dashboard-stat-label {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .dashboard-stat-value {
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
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

    .info-box {
        background: #eff6ff;
        border-left: 4px solid #1d4ed8;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .info-box h5 {
        color: #1d4ed8;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .info-box p {
        color: #475569;
        margin: 0;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .dashboard-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">
    <div class="dashboard-hero">
        <div>
            <h3>Dashboard Operator Sekolah</h3>
            <p>Kelola data sekolah Anda dengan mudah</p>
        </div>
        <div class="dashboard-hero-icon">
            <i class="fas fa-tachometer-alt"></i>
        </div>
    </div>

    <div class="info-box">
        <h5><i class="fas fa-info-circle mr-2"></i>Selamat Datang</h5>
        <p>Di halaman ini Anda dapat melihat dan mengelola informasi sekolah Anda. Silakan gunakan menu di samping untuk mengakses berbagai fitur.</p>
    </div>

    <?php if (! empty($sekolah)): ?>
        <div class="card dashboard-card">
            <div class="card-header">
                <h3 class="dashboard-title">
                    <span class="title-icon"><i class="fas fa-school"></i></span>
                    Sekolah Saya
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="info-group" style="background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px; margin-bottom: 12px;">
                            <div>
                                <strong><?= esc($sekolah[0]['nama_sekolah'] ?? '-') ?></strong>
                                <br>
                                <small class="text-muted">NPSN: <?= esc($sekolah[0]['npsn'] ?? '-') ?></small>
                            </div>
                        </div>

                        <div class="row" style="font-size: 13px;">
                            <div class="col-md-6">
                                <p><strong>Jenjang:</strong> <?= esc($sekolah[0]['jenjang'] ?? '-') ?></p>
                                <p><strong>Status:</strong> <?= esc($sekolah[0]['status'] ?? '-') ?></p>
                                <p><strong>Akreditasi:</strong> <?= esc($sekolah[0]['akreditasi'] ?? '-') ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Alamat:</strong> <?= esc($sekolah[0]['alamat'] ?? '-') ?></p>
                                <p><strong>Kecamatan:</strong> <?= esc($sekolah[0]['nama_kecamatan'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div style="background: linear-gradient(135deg, #1d4ed8, #0f766e); color: #fff; padding: 14px; border-radius: 8px; text-align: center;">
                            <p style="margin-bottom: 10px; color: rgba(255,255,255,.7); font-size: 12px;">Total Guru</p>
                            <h3 style="margin: 0; font-size: 32px; font-weight: 700;"><?= esc($sekolah[0]['banyak_guru'] ?? 0) ?></h3>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 16px;">
                    <a href="<?= site_url('Sekolah') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i> Edit Data Sekolah
                    </a>
                    <a href="<?= site_url('Sekolah/galeri') ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-images mr-1"></i> Galeri Sekolah
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
