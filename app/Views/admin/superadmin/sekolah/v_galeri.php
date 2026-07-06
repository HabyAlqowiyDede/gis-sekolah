<?php
$judul = $judul ?? 'Galeri Sekolah';
$galeri = $galeri ?? [];
$id_sekolah = $id_sekolah ?? '';
$galleryCount = count($galeri);
$galleryRemaining = max(0, 5 - $galleryCount);
?>

<style>
    .gallery-upload-wrapper {
        width: 100%;
        margin-bottom: 22px;
    }

    .gallery-upload-box {
        width: 100%;
        min-height: 220px;
        border: 2px dashed #3b82f6;
        border-radius: 20px;
        background: #f8fafc;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: .3s ease;
    }

    .gallery-upload-box:hover {
        background: #eef2ff;
        border-color: #2563eb;
    }

    .gallery-upload-box.dragover {
        background: #e0e7ff;
        border-color: #1d4ed8;
    }

    .gallery-upload-content {
        width: 100%;
        text-align: center;
        padding: 32px;
    }

    .gallery-upload-icon {
        width: 84px;
        height: 84px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1d4ed8;
        font-size: 30px;
    }

    .gallery-upload-content h4 {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }

    .gallery-upload-content p {
        margin-bottom: 14px;
        color: #475569;
    }

    .gallery-upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 28px;
        background: #2563eb;
        color: #fff;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: .3s;
    }

    .gallery-upload-btn:hover {
        background: #1d4ed8;
    }

    .gallery-upload-content small {
        color: #64748b;
        font-size: 14px;
    }

    .gallery-info-note {
        margin-bottom: 12px;
        color: #1d4ed8;
        font-size: 14px;
    }

    .gallery-card-actions {
        padding: 0 14px 14px;
        display: flex;
        justify-content: flex-end;
    }

    .gallery-card-actions .btn {
        font-size: 13px;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        width: 100%;
    }

    .gallery-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
    }

    .gallery-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }

    .gallery-card-body {
        padding: 14px 16px;
    }

    .gallery-card-body h5 {
        font-size: 16px;
        margin: 0 0 6px;
    }

    .gallery-card-body small {
        color: #64748b;
    }

    .gallery-empty {
        width: 100%;
        padding: 32px;
        border-radius: 14px;
        background: #f8fafc;
        text-align: center;
        color: #475569;
        border: 1px dashed #cbd5e1;
    }
</style>

<div class="col-md-12">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title"><?= esc($filterTitle ?? 'Galeri Sekolah') ?></h3>
            <a href="<?= site_url('Sekolah') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <?php if (isSuperAdmin() || (isAdminSekolah() && getCurrentUserSchoolId() == $id_sekolah)): ?>
            <div class="gallery-upload-wrapper">
                <input type="file" id="galleryFoto" name="foto[]" hidden multiple>
                <input type="hidden" id="galleryIdSekolah" value="<?= esc($id_sekolah) ?>">
                <input type="hidden" id="galleryRemaining" value="<?= esc($galleryRemaining) ?>">
                <label class="gallery-upload-box <?= $galleryRemaining <= 0 ? 'disabled' : '' ?>">
                    <div class="gallery-upload-content">
                        <div class="gallery-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h4>Unggah Foto Galeri Sekolah</h4>
                        <p>Drag & drop atau klik untuk memilih file gambar. Format JPG, JPEG, PNG, WEBP. Maks 2 MB per gambar.</p>
                        <div class="gallery-info-note">
                            <?= esc($galleryCount) ?> / 5 foto tersimpan.
                            <br>
                            Sisa upload: <?= esc($galleryRemaining) ?> foto.
                        </div>
                        <span class="gallery-upload-btn">
                            <i class="fas fa-folder-open mr-2"></i>Pilih Foto
                        </span>
                        <small class="d-block mt-3">Foto akan disimpan ke tabel tbl_galeri dan langsung muncul di galeri.</small>
                    </div>
                </label>
            </div>
            <?php endif; ?>
            <?php if (empty($galeri)): ?>
                <div class="gallery-empty">
                    <i class="fas fa-images fa-2x mb-3"></i>
                    <p class="mb-0">Belum ada foto dalam galeri. Silakan unggah foto di halaman sekolah.</p>
                </div>
            <?php else: ?>
                <div class="gallery-grid">
                    <?php foreach ($galeri as $item): ?>
                        <div class="gallery-card">
                            <img src="<?= base_url('foto/' . esc($item['foto'])) ?>" alt="Galeri Sekolah">
                            <div class="gallery-card-body">
                                <h5><?= esc($item['keterangan'] ?: 'Foto Sekolah') ?></h5>
                                <small>Diunggah: <?= esc(date('d M Y H:i', strtotime($item['created_at']))) ?></small>
                            </div>
                            <?php if (isSuperAdmin() || (isAdminSekolah() && getCurrentUserSchoolId() == $item['id_sekolah'])): ?>
                            <div class="gallery-card-actions">
                                <a href="<?= site_url('Sekolah/DeleteGaleri/' . $item['id_galeri']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus foto ini dari galeri?');">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (isSuperAdmin() || (isAdminSekolah() && getCurrentUserSchoolId() == $id_sekolah)): ?>
<script>
    $(function () {
        const input = $('#galleryFoto');
        const box = $('.gallery-upload-box');
        let isUploading = false;

        box.on('click', function () {
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

        input.on('change', function () {
            if (this.files && this.files.length) {
                uploadFiles(this.files);
            }
        });

        function uploadFiles(files) {
            if (isUploading) {
                return;
            }

            const idSekolah = $('#galleryIdSekolah').val();
            const remaining = parseInt($('#galleryRemaining').val(), 10) || 0;
            if (!idSekolah) {
                alert('ID sekolah tidak tersedia. Anda tidak dapat mengunggah galeri tanpa memilih sekolah.');
                return;
            }
            if (remaining <= 0) {
                alert('Kuota galeri sudah penuh. Hapus foto terlebih dahulu sebelum mengunggah lagi.');
                return;
            }

            const allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (files.length > remaining) {
                alert('Anda hanya dapat mengunggah maksimal ' + remaining + ' foto lagi.');
                return;
            }

            const fd = new FormData();
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const ext = file.name.split('.').pop().toLowerCase();

                if (allowed.indexOf(ext) === -1) {
                    alert('Format file tidak didukung: ' + file.name);
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2 MB: ' + file.name);
                    return;
                }
                fd.append('foto[]', file);
            }

            fd.append('id_sekolah', idSekolah);
            isUploading = true;

            $.ajax({
                url: '<?= site_url('Sekolah/UploadGaleri') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    isUploading = false;
                    input.val('');
                    if (res.status) {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                },
                error: function () {
                    isUploading = false;
                    input.val('');
                    alert('Terjadi kesalahan saat mengunggah file galeri.');
                }
            });
        }
    });
</script>
<?php endif; ?>
