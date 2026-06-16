<?php
$judul = $judul ?? 'Jenjang';
$jenjang = $jenjang ?? [];
$errors = session()->getFlashdata('errors') ?? [];
$totalJenjang = count($jenjang);
$totalMarker = count(array_filter($jenjang, static fn ($item) => ! empty($item['marker'])));
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
        grid-template-columns: repeat(3, minmax(160px, 1fr));
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
    .jenjang-stat-icon.green { background: #ecfdf5; color: #047857; }
    .jenjang-stat-icon.slate { background: #f1f5f9; color: #334155; }

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
        width: 54px;
        height: 54px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
    }

    .marker-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .jenjang-name {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #111827;
    }

    .jenjang-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 5px 10px;
        background: #eef2ff;
        color: #3730a3;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-action {
        border-radius: 8px;
        padding: 7px 10px;
    }

    .empty-state {
        padding: 44px 20px;
        text-align: center;
        color: #64748b;
    }

    .empty-state i {
        font-size: 42px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .jenjang-hero { align-items: flex-start; flex-direction: column; }
        .jenjang-stat-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="col-md-12">
    <div class="jenjang-hero">
        <div>
            <h3>Kelola Jenjang Pendidikan</h3>
            <p>Tambah, ubah, dan rapikan marker peta untuk setiap jenjang sekolah.</p>
        </div>
        <div class="jenjang-hero-icon">
            <i class="nav-icon fas fa-swimming-pool "></i>
        </div>
    </div>

    <div class="jenjang-stat-grid">
        <div class="jenjang-stat-card">
            <div class="jenjang-stat-icon blue"><i class="fas fa-school"></i></div>
            <div>
                <div class="jenjang-stat-label">Total Jenjang</div>
                <div class="jenjang-stat-value"><?= esc($totalJenjang) ?></div>
            </div>
        </div>
        <div class="jenjang-stat-card">
            <div class="jenjang-stat-icon green"><i class="fas fa-map-marker-alt"></i></div>
            <div>
                <div class="jenjang-stat-label">Marker Aktif</div>
                <div class="jenjang-stat-value"><?= esc($totalMarker) ?></div>
            </div>
        </div>
        <div class="jenjang-stat-card">
            <div class="jenjang-stat-icon slate"><i class="fas fa-database"></i></div>
            <div>
                <div class="jenjang-stat-label">Sumber Data</div>
                <div class="jenjang-stat-value">GIS</div>
            </div>
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

    <?php if (session()->getFlashdata('Insert')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('Insert')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('Update')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('Update')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('delete')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-info-circle"></i> Informasi</h5>
            <?= esc(session()->getFlashdata('delete')) ?>
        </div>
    <?php endif; ?>

    <div class="card jenjang-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="jenjang-title">
                <span class="title-icon"><i class="fas fa-list"></i></span>
                Data Jenjang
            </h3>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahJenjang" style="margin-left: auto;">
                <i class="fas fa-plus mr-1"></i> Tambah Jenjang
            </button>
        </div>
        <div class="card-body">
            <?php if (empty($jenjang)): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h5>Belum ada data jenjang</h5>
                    <p class="mb-0">Klik tombol Tambah Jenjang untuk membuat data pertama.</p>
                </div>
            <?php else: ?>
                <table id="tableJenjang" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="60px" class="text-center">No</th>
                            <th>Jenjang</th>
                            <th class="text-center">Marker</th>
                            <th class="text-center">Status</th>
                            <th width="210px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($jenjang as $value): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no++ ?></td>
                                <td class="align-middle">
                                    <div class="jenjang-name">
                                        <i class="fas fa-graduation-cap text-primary"></i>
                                        <?= esc($value['jenjang']) ?>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="marker-preview">
                                        <?php if (! empty($value['marker'])): ?>
                                            <img src="<?= base_url('marker/' . $value['marker']) ?>" alt="Marker <?= esc($value['jenjang']) ?>">
                                        <?php else: ?>
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="jenjang-badge">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" data-toggle="modal" data-target="#modalEdit<?= esc($value['id_jenjang']) ?>" class="btn btn-warning btn-sm btn-action">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#modalDelete<?= esc($value['id_jenjang']) ?>" class="btn btn-danger btn-sm btn-action">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahJenjang">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open_multipart('Jenjang/InsertData') ?>
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-plus-circle text-primary mr-2"></i>Tambah Jenjang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Jenjang</label>
                    <input type="text" name="jenjang" value="<?= old('jenjang') ?>" class="form-control" placeholder="Contoh: SD, SMP, SMA" required>
                </div>
                <div class="form-group mb-0">
                    <label>Marker</label>
                    <input type="file" name="marker" class="form-control" accept="image/png,image/jpeg,image/webp" required>
                    <small class="text-muted">Format png, jpg, jpeg, atau webp. Maksimal 2 MB.</small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?php foreach ($jenjang as $value): ?>
    <div class="modal fade" id="modalEdit<?= esc($value['id_jenjang']) ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <?= form_open_multipart('Jenjang/UpdateData/' . $value['id_jenjang']) ?>
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit text-warning mr-2"></i>Edit Jenjang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenjang</label>
                        <input type="text" name="jenjang" value="<?= esc($value['jenjang']) ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Marker Saat Ini</label>
                        <div>
                            <span class="marker-preview">
                                <?php if (! empty($value['marker'])): ?>
                                    <img src="<?= base_url('marker/' . $value['marker']) ?>" alt="Marker <?= esc($value['jenjang']) ?>">
                                <?php else: ?>
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Ganti Marker</label>
                        <input type="file" name="marker" class="form-control" accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted">Kosongkan jika marker tidak ingin diganti.</small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete<?= esc($value['id_jenjang']) ?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?= site_url('Jenjang/DeleteData/' . $value['id_jenjang']) ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-trash text-danger mr-2"></i>Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Hapus jenjang <strong><?= esc($value['jenjang']) ?></strong>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(function () {
        $('#tableJenjang').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                paginate: {
                    first: 'Awal',
                    last: 'Akhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });
    });
</script>
