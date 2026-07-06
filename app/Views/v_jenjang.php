<?php
$judul = $judul ?? 'Jenjang';
$jenjang = $jenjang ?? [];
$web = $web ?? [];
$totalJenjang = count($jenjang);
?>

<style>
    .jenjang-hero {
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

    .jenjang-hero h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .jenjang-hero p {
        color: rgba(255, 255, 255, .78);
        margin: 0;
    }

    .jenjang-hero-icon {
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

    .jenjang-stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .jenjang-stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
    }

    .jenjang-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .jenjang-stat-icon.blue { background: #eff6ff; color: #1d4ed8; }

    .jenjang-stat-label {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .jenjang-stat-value {
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
    }

    .jenjang-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .jenjang-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .jenjang-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .jenjang-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .marker-preview {
        width: 32px;
        height: 32px;
        border-radius: 4px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .jenjang-hero { align-items: flex-start; flex-direction: column; }
        .jenjang-stat-grid { grid-template-columns: repeat(1, 1fr); }
    }
</style>

<div class="col-md-12">
    <div class="jenjang-hero">
        <div>
            <h3>Data Jenjang Pendidikan</h3>
            <p>Kelola data jenjang pendidikan dan marker peta</p>
        </div>
        <div class="jenjang-hero-icon">
            <i class="fas fa-book-open"></i>
        </div>
    </div>

    <div class="jenjang-stat-grid">
        <div class="jenjang-stat-card">
            <div class="jenjang-stat-icon blue"><i class="fas fa-list"></i></div>
            <div>
                <div class="jenjang-stat-label">Total Jenjang</div>
                <div class="jenjang-stat-value"><?= $totalJenjang ?? 0 ?></div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('Insert')) : ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('Insert')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('Update')) : ?>
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-edit"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('Update')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('delete')) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-trash"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('delete')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Data belum valid</h5>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card jenjang-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="jenjang-title">
                <span class="title-icon"><i class="fas fa-book-open"></i></span>
                Daftar Jenjang
            </h3>
            <a href="<?= site_url('Jenjang') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Jenjang
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tableJenjang" class="table table-striped table-sm table-bordered mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Jenjang</th>
                            <th>Marker</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($jenjang)): ?>
                            <?php foreach ($jenjang as $item): ?>
                                <tr>
                                    <td><?= esc($item['jenjang'] ?? '-') ?></td>
                                    <td>
                                        <?php if (!empty($item['marker'])): ?>
                                            <img src="<?= base_url('marker/' . $item['marker']) ?>" alt="Marker" class="marker-preview" title="<?= esc($item['jenjang']) ?>">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('Jenjang/UpdateData/' . $item['id_jenjang']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <a href="<?= site_url('Jenjang/DeleteData/' . $item['id_jenjang']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data jenjang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof $().DataTable === 'function') {
            $('#tableJenjang').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                columnDefs: [
                    { orderable: false, targets: 2 }
                ]
            });
        }
    });
</script>
