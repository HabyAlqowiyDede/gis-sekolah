<?php
$sekolah = $sekolah ?? [];
?>

<style>
    .school-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .school-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .school-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .school-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #ecfdf5;
        color: #047857;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="col-md-12">
    <div class="card school-card">
        <div class="card-header">
            <h3 class="school-title">
                <span class="title-icon"><i class="fas fa-school"></i></span>
                Data Sekolah Saya
            </h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Informasi:</strong> Anda hanya dapat mengelola data sekolah Anda sendiri.
            </div>

            <?php if (! empty($sekolah)): ?>
                <?php $school = $sekolah[0]; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nama Sekolah</strong></label>
                            <input type="text" class="form-control" value="<?= esc($school['nama_sekolah']) ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>NPSN</strong></label>
                            <input type="text" class="form-control" value="<?= esc($school['npsn'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>Jenjang</strong></label>
                            <input type="text" class="form-control" value="<?= esc($school['jenjang'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>Status</strong></label>
                            <input type="text" class="form-control" value="<?= esc($school['status'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>Akreditasi</strong></label>
                            <input type="text" class="form-control" value="<?= esc($school['akreditasi'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>Total Guru</strong></label>
                            <input type="text" class="form-control" value="<?= esc($school['banyak_guru'] ?? 0) ?>" readonly style="background-color: #f5f5f5;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Alamat</strong></label>
                            <textarea class="form-control" readonly style="background-color: #f5f5f5; height: 80px;"><?= esc($school['alamat'] ?? '-') ?></textarea>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <a href="<?= site_url('Sekolah/edit/' . $school['id_sekolah']) ?>" class="btn btn-primary">
                        <i class="fas fa-edit mr-1"></i> Edit Sekolah
                    </a>
                    <a href="<?= site_url('Sekolah/galeri') ?>" class="btn btn-info">
                        <i class="fas fa-images mr-1"></i> Galeri Sekolah
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Data sekolah tidak ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
