<?php
$judul = $judul ?? 'Hapus Sekolah';
$sekolah = $sekolah ?? [];
?>

<div class="col-md-12">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title"><?= esc($judul) ?></h3>
        </div>

        <div class="card-body">
            <div class="alert alert-warning">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                Data sekolah berikut akan dihapus permanen.
            </div>

            <table class="table table-bordered table-sm">
                <tr>
                    <th width="220px">Nama Sekolah</th>
                    <td><?= esc($sekolah['nama_sekolah'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?= esc($sekolah['status'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Akreditasi</th>
                    <td><?= esc($sekolah['akreditasi'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Jenjang</th>
                    <td><?= esc($sekolah['jenjang'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= esc($sekolah['alamat'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Foto</th>
                    <td>
                        <?php if (!empty($sekolah['foto'])) { ?>
                            <img src="<?= base_url('foto/' . $sekolah['foto']) ?>" alt="Foto Sekolah" width="180px" height="120px" class="img-thumbnail">
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <?= form_open('Sekolah/DeleteData/' . ($sekolah['id_sekolah'] ?? '')) ?>
                <button type="submit" class="btn btn-danger btn-flat">
                    <i class="fas fa-trash"></i> Hapus
                </button>
                <a href="<?= base_url('Sekolah') ?>" class="btn btn-secondary btn-flat">Batal</a>
            <?= form_close() ?>
        </div>
    </div>
</div>
