<?php
$jenjang = $jenjang ?? [];
$kecamatan = $kecamatan ?? [];
?>


<div class="container-fluid">

    <div class="card card-primary card-outline">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-school"></i>
                Form Input Sekolah
            </h3>
        </div>

        <form action="<?= site_url('Sekolah/InsertData') ?>" method="post">
            <?= csrf_field(); ?>

            <div class="card-body">

                <?php
                $errors = session()->getFlashdata('errors') ?? [];
                ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Data belum valid</h5>
                        <?php foreach ($errors as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="row">

                    <!-- Nama Sekolah -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Sekolah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-school"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="nama_sekolah"
                                    class="form-control"
                                    placeholder="Masukkan nama sekolah"
                                    value="<?= old('nama_sekolah') ?>"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- NPSN -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NPSN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    name="npsn"
                                    class="form-control"
                                    placeholder="Masukkan NPSN"
                                    maxlength="8"
                                    value="<?= old('npsn') ?>"
                                    required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <!-- Jenjang -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenjang</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-layer-group"></i>
                                    </span>
                                </div>

                                <select name="id_jenjang" class="form-control" required>
                                    <option value="">-- Pilih Jenjang --</option>

                                    <?php foreach($jenjang as $j): ?>

                                        <option value="<?= $j['id_jenjang']; ?>"
                                            <?= old('id_jenjang')==$j['id_jenjang']?'selected':''; ?>>
                                            <?= $j['jenjang']; ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>
                        </div>
                    </div>

                    <!-- Kecamatan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                </div>

                                <select name="id_kecamatan" class="form-control" required>
                                    <option value="">-- Pilih Kecamatan --</option>

                                    <?php foreach($kecamatan as $k): ?>

                                        <option value="<?= $k['id_kecamatan']; ?>"
                                            <?= old('id_kecamatan')==$k['id_kecamatan']?'selected':''; ?>>
                                            <?= $k['nama_kecamatan']; ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="card-footer">

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>

                <a href="<?= site_url('Sekolah'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>