<?php
$judul = $judul ?? 'Sekolah';
$sekolah = $sekolah ?? [];
$totalSekolah = count($sekolah);
$totalNegeri = count(array_filter($sekolah, static fn ($item) => strtolower($item['status'] ?? '') === 'negeri'));
$totalAkreditasiA = count(array_filter($sekolah, static fn ($item) => strtoupper($item['akreditasi'] ?? '') === 'A')); 
?>

<style>
    .upload-wrapper{
    width:100%;
}

.upload-box{
    width:100%;
    min-height:320px;
    border:2px dashed #27ae60;
    border-radius:20px;
    background:#fff;
    cursor:pointer;

    display:flex;
    justify-content:center;
    align-items:center;

    transition:.3s ease;
}

.upload-box:hover{
    background:#f8fffb;
    border-color:#1abc9c;
}

.upload-content{
    width:100%;
    text-align:center;
    padding:40px;
}

.upload-icon{
    width:95px;
    height:95px;
    margin:0 auto 20px;
    border-radius:50%;
    background:#eefaf3;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#16a34a;
    font-size:42px;

    box-shadow:0 10px 25px rgba(22,163,74,.12);
}

.upload-content h4{
    font-size:28px;
    font-weight:700;
    color:#1e293b;
    margin-bottom:10px;
}

.btn-upload{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:14px 36px;

    background:#16a34a;
    color:#fff;

    border-radius:10px;
    font-size:17px;
    font-weight:600;

    transition:.3s;
}

.btn-upload:hover{
    background:#15803d;
    color:#fff;
}

.upload-content small{
    font-size:14px;
    color:#94a3b8;
}

.gallery-notice-card{
    width:100%;
    display:flex;
    align-items:center;
    gap:18px;
    padding:18px 22px;
    border-radius:14px;
    background:#ffffff;
    border:1px solid rgba(14,165,233,0.06);
    box-shadow:0 12px 30px rgba(2,6,23,0.06);
    margin-bottom:18px;
    position:relative;
    overflow:hidden;
}

.gallery-notice-card::before{
    content:'';
    position:absolute;
    right:-120px;
    top:-40px;
    width:260px;
    height:260px;
    background:radial-gradient(circle at 30% 30%, rgba(29,78,216,0.06), transparent 40%);
    transform:rotate(12deg);
    pointer-events:none;
}

.gallery-notice-card .gallery-notice-icon{
    width:76px;
    height:76px;
    border-radius:12px;
    background:linear-gradient(180deg,#eef2ff,#dbeafe);
    color:#1d4ed8;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    flex:0 0 auto;
    box-shadow:0 10px 26px rgba(29,78,216,0.08);
}

.gallery-notice-card .gallery-notice-content{flex:1;min-width:0}

.gallery-notice-card .gallery-notice-content h5{margin:0 0 6px;font-size:20px;font-weight:800;color:#0f172a}
.gallery-notice-card .gallery-notice-content p{margin:0;color:#475569;font-size:14px}

.gallery-notice-card .gallery-notice-action{flex:0 0 auto}
.gallery-notice-card .gallery-notice-action .btn{
    white-space:nowrap;border-radius:10px;padding:10px 16px;font-weight:700;
    background:linear-gradient(90deg,#2563eb,#06b6d4);border:none;color:#fff;box-shadow:0 8px 20px rgba(37,99,235,0.12);transition:transform .12s ease,box-shadow .12s ease;
}
.gallery-notice-card .gallery-notice-action .btn:hover{transform:translateY(-3px);box-shadow:0 16px 36px rgba(37,99,235,0.14)}

@media (max-width:768px){
    .gallery-notice-card{flex-direction:column;align-items:stretch;padding:16px}
    .gallery-notice-card .gallery-notice-action{width:100%;display:flex;justify-content:flex-end;margin-top:12px}
    .gallery-notice-card .gallery-notice-action .btn{width:100%;display:inline-flex;justify-content:center}
}

    .school-hero {
        background: linear-gradient(135deg, #0f766e 0%, #1d4ed8 100%);
        color: #fff;
        border-radius: 12px;
        padding: 24px 26px;
        margin-bottom: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
    }

    .school-hero h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .school-hero p {
        color: rgba(255, 255, 255, .78);
        margin: 0;
    }

    .school-hero-icon {
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

    .school-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .school-stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
    }

    .school-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .school-stat-icon.blue { background: #eff6ff; color: #1d4ed8; }
    .school-stat-icon.green { background: #ecfdf5; color: #047857; }
    .school-stat-icon.amber { background: #fffbeb; color: #b45309; }

    .school-stat-label {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .school-stat-value {
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
    }

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

    .school-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 280px;
    }

    .school-photo {
        width: 58px;
        height: 44px;
        border-radius: 8px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e5e7eb;
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .school-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .school-name {
        font-weight: 700;
        color: #111827;
        margin-bottom: 2px;
    }

    .school-location {
        font-size: 12px;
        color: #64748b;
    }

    .status-pill,
    .akred-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-pill.negeri { background: #ecfdf5; color: #047857; }
    .status-pill.swasta { background: #eef2ff; color: #3730a3; }
    .akred-pill { min-width: 34px; background: #eff6ff; color: #1d4ed8; }
    .akred-pill.a { background: #1d4ed8; color: #fff; }

    .btn-action {
        border-radius: 8px;
        padding: 7px 10px;
    }

    .dataTables_wrapper {
        padding: 0 !important;
    }

    .dataTables_length, .dataTables_filter {
        padding: 16px 0 !important;
        color: #0f172a !important;
        font-size: 14px;
    }

    .dataTables_length label, .dataTables_filter label {
        margin-bottom: 0 !important;
    }

    .dataTables_length select, .dataTables_filter input {
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        font-size: 13px;
    }

    .dataTables_info {
        padding: 12px 0 !important;
        color: #64748b !important;
        font-size: 13px;
    }

    .dataTables_paginate {
        padding: 12px 0 !important;
    }

    .paginate_button {
        border: 1px solid #e5e7eb !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        margin: 0 2px !important;
        background: #fff !important;
        color: #0f172a !important;
        font-size: 13px;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }

    .paginate_button:hover {
        background: #f1f5f9 !important;
        border-color: #1d4ed8 !important;
    }

    .paginate_button.current {
        background: #1d4ed8 !important;
        color: #fff !important;
        border-color: #1d4ed8 !important;
    }

    .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
    }

    @media (max-width: 768px) {
        .school-hero { align-items: flex-start; flex-direction: column; }
        .school-stat-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="col-md-12">
    <?php if (!isAdminSekolah()): ?>
    <div class="school-stat-grid">
        <div class="school-stat-card">
            <div class="school-stat-icon blue"><i class="fas fa-database"></i></div>
            <div>
                    <div class="school-stat-label">Total Sekolah</div>
                <div class="school-stat-value"><?= esc($totalSekolah) ?></div>
            </div>
        </div>
        <div class="school-stat-card">
            <div class="school-stat-icon green"><i class="fas fa-landmark"></i></div>
            <div>
                <div class="school-stat-label">Sekolah Negeri</div>
                <div class="school-stat-value"><?= esc($totalNegeri) ?></div>
            </div>
        </div>
        <div class="school-stat-card">
            <div class="school-stat-icon amber"><i class="fas fa-award"></i></div>
            <div>
                <div class="school-stat-label">Akreditasi A</div>
                <div class="school-stat-value"><?= esc($totalAkreditasiA) ?></div>
            </div>
        </div>
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

    <div class="card school-card">
        <div class="card-header d-flex align-items-center">
            <h3 class="school-title">
                <span class="title-icon"><i class="fas fa-list"></i></span>
                <?php if (isAdminSekolah()): ?>
                    Data Sekolah Saya
                <?php else: ?>
                    Data Sekolah
                <?php endif; ?>
            </h3>
            <?php if (!isAdminSekolah()): ?>
                <a href="<?= site_url('Sekolah/input') ?>" class="btn btn-primary btn-sm" style="margin-left: auto;">
                    <i class="fas fa-plus mr-1"></i> Tambah Sekolah
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            
            <?php if (isAdminSekolah() && count($sekolah) > 0): ?>
                <!-- Form Edit untuk Admin Sekolah -->
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Informasi:</strong> Anda hanya dapat mengelola data sekolah Anda sendiri. Perubahan akan tersimpan secara otomatis.
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-edit mr-2"></i>Edit Data Sekolah
                        </h5>
                    </div>
                    <div class="card-body">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Jenjang</strong></label>
                                    <input type="text" class="form-control" value="<?= esc($school['jenjang'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Kabupaten</strong></label>
                                    <input type="text" class="form-control" value="<?= esc($school['nama_kabupaten'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Status</strong></label>
                                    <input type="text" class="form-control" value="<?= esc($school['status'] ?? '-') ?>" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><strong>Alamat Lengkap</strong></label>
                            <textarea class="form-control" rows="3" readonly style="background-color: #f5f5f5;"><?= esc($school['alamat'] ?? '-') ?></textarea>
                        </div>

                        <div class="form-group">
                            <a href="<?= site_url('Sekolah/Edit/' . $school['id_sekolah']) ?>" class="btn btn-primary">
                                <i class="fas fa-pencil-alt mr-2"></i>Edit Data Lengkap
                            </a>
                        </div>
                    </div>
                </div>

            <?php elseif (!isAdminSekolah()): ?>
                <!-- Tabel untuk Super Admin -->
                <table id="tableSekolah" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50px" class="text-center">No</th>
                            <th>Nama Sekolah</th>
                            <th>Status</th>
                            <th>Akreditasi</th>
                            <th>Jenjang</th>
                            <th>Alamat</th>
                            <th width="160px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sekolah as $value): ?>
                            <?php
                            $status = $value['status'] ?? '-';
                            $statusClass = strtolower($status) === 'negeri' ? 'negeri' : 'swasta';
                            $akreditasi = strtoupper($value['akreditasi'] ?? '-');
                            ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no++ ?></td>
                                <td class="align-middle">
                                    <div class="school-name-cell">
                                        <div class="school-photo">
                                            <?php if (! empty($value['foto'])): ?>
                                                <img src="<?= base_url('foto/' . $value['foto']) ?>" alt="<?= esc($value['nama_sekolah']) ?>">
                                            <?php else: ?>
                                                <i class="fas fa-image"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="school-name"><?= esc($value['nama_sekolah']) ?></div>
                                            <div class="school-location">
                                                <?= esc($value['nama_kecamatan'] ?? '-') ?>, <?= esc($value['nama_nagari'] ?? '-') ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle"><span class="status-pill <?= esc($statusClass) ?>"><?= esc($status) ?></span></td>
                                <td class="align-middle"><span class="akred-pill <?= strtolower($akreditasi) === 'a' ? 'a' : '' ?>"><?= esc($akreditasi) ?></span></td>
                                <td class="align-middle"><?= esc($value['jenjang'] ?? '-') ?></td>
                                <td class="align-middle"><?= esc($value['alamat'] ?? '-') ?></td>
                                <td class="text-center align-middle">
                                    <a href="<?= site_url('Sekolah/Edit/' . $value['id_sekolah']) ?>" class="btn btn-warning btn-sm btn-action" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" data-toggle="modal" data-target="#modalDeleteSekolah<?= esc($value['id_sekolah']) ?>" class="btn btn-danger btn-sm btn-action" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Tidak ada data sekolah.</strong> Hubungi administrator untuk membuat akun sekolah Anda.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php foreach ($sekolah as $value): ?>
    <div class="modal fade" id="modalDeleteSekolah<?= esc($value['id_sekolah']) ?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?= site_url('Sekolah/DeleteData/' . $value['id_sekolah']) ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-trash text-danger mr-2"></i>Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Hapus data <strong><?= esc($value['nama_sekolah']) ?></strong>?</p>
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
<!-- disiniii -->
<?php if (isAdminSekolah()): ?>
<div class="gallery-notice-card">
    <div class="gallery-notice-icon"><i class="fas fa-image"></i></div>
    <div class="gallery-notice-content">
        <h5>Galeri Foto Sekolah</h5>
        <p>Klik tombol untuk unggah foto yang sudah diunggah ke galeri sekolah.</p>
    </div>
    <div class="gallery-notice-action">
        <a href="<?= site_url('Sekolah/galeri') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-photo-video mr-1"></i>Upload Galeri
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Upload Area -->

<script>
    // Upload gallery JS
    $(function () {
        const input = $('#foto');
        const box = $('.upload-box');

        box.on('click', function (e) {
            input.trigger('click');
        });

        box.on('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        box.on('dragleave drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });

        box.on('drop', function (e) {
            const dt = e.originalEvent.dataTransfer;
            if (dt && dt.files && dt.files.length) {
                uploadFiles(dt.files);
            }
        });

        input.on('change', function (e) {
            if (this.files && this.files.length) {
                uploadFiles(this.files);
            }
        });

        function uploadFiles(files) {
            const idSekolah = $('#id_sekolah').val();
            if (!idSekolah) {
                alert('ID sekolah tidak tersedia. Mohon buka halaman sekolah Anda terlebih dahulu.');
                return;
            }

            const allowed = ['jpg', 'jpeg', 'png', 'webp'];
            const fd = new FormData();

            for (let i = 0; i < files.length; i++) {
                const f = files[i];
                const ext = f.name.split('.').pop().toLowerCase();
                if (allowed.indexOf(ext) === -1) {
                    alert('Format file tidak didukung: ' + f.name);
                    return;
                }
                if (f.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2 MB: ' + f.name);
                    return;
                }
                fd.append('foto[]', f);
            }

            fd.append('id_sekolah', idSekolah);

            $.ajax({
                url: '<?= site_url('Sekolah/UploadGaleri') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    if (res.status) {
                        alert(res.message);
                        window.location.href = '<?= site_url('Sekolah/galeri') ?>';
                    } else {
                        alert(res.message);
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat mengunggah file.');
                }
            });
        }
    });

    $(function () {
        $('#tableSekolah').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', 'Semua']],
            ordering: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                paginate: {
                    first: '<i class="fas fa-step-backward"></i>',
                    last: '<i class="fas fa-step-forward"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
