<?php
$judul = $judul ?? 'Setting';
$profil = $profil ?? [];

?>

<style>
    .setting-hero {
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

    .setting-hero h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .setting-hero p {
        color: rgba(255, 255, 255, .78);
        margin: 0;
    }

    .setting-hero-icon {
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

    .setting-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
        margin-bottom: 18px;
    }

    .setting-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .setting-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .setting-title .title-icon {
        width: 34px;
        height: 34px;
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

    /* Improved form inputs */
    .input-group .input-group-prepend { display:flex; align-items:center; padding:0 10px; background:#f1f5f9; border:1px solid #eef2ff; border-right:0; border-radius:8px 0 0 8px }
    .input-group .form-control { border-radius:0 8px 8px 0; }
    .setting-card .card-header { background: linear-gradient(90deg,#f8fbff,#fff); }
    .help-text { font-size:12px;color:#64748b;margin-top:6px }
    .section-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px }
    @media (max-width:768px) { .section-grid { grid-template-columns:1fr } }
    .toggle-pass { cursor:pointer; background:transparent; border:none; padding:6px 8px; color:#475569 }

    .form-group label {
        font-weight: 600;
    }

    .alert ul { margin-bottom: 0; }

    @media (max-width: 768px) {
        .setting-hero { align-items: flex-start; flex-direction: column; }
    }
</style>

<div class="col-md-12">

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            <?= esc(session()->getFlashdata('pesan')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Kesalahan</h5>
            <?php $errors = session()->getFlashdata('errors'); ?>
            <?php if (is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><?= esc($errors) ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- <div class="card setting-card">
        <div class="card-header">
            <h3 class="setting-title">
                <span class="title-icon"><i class="fas fa-building"></i></span>
                Edit Profil Dinas
            </h3>
        </div>
        <div class="card-body">
            <?= form_open('User/UpdateProfil') ?>
            <div class="section-grid">
                <div>
                    <div class="form-group">
                        <label>Nama Dinas</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><i class="fas fa-building"></i></div>
                            <input type="text" name="nama_dinas" value="<?= esc($profil['nama_dinas'] ?? '') ?>" class="form-control" placeholder="Nama Dinas Pendidikan" required>
                        </div>
                        <div class="help-text">Nama dinas ini akan tampil pada header aplikasi.</div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.toggle-pass').forEach(function(btn){
                                btn.addEventListener('click', function(){
                                    var target = document.querySelector(this.getAttribute('data-target'));
                                    if (!target) return;
                                    if (target.type === 'password') {
                                        target.type = 'text';
                                        this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                                    } else {
                                        target.type = 'password';
                                        this.innerHTML = '<i class="fas fa-eye"></i>';
                                    }
                                });
                            });
                        });
                    </script>
                </div>
                <div>
                    <div class="form-group">
                        <label>Email Dinas</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><i class="fas fa-envelope"></i></div>
                            <input type="text" name="email" value="<?= esc($profil['email'] ?? '') ?>" class="form-control" placeholder="Contoh: admin_dinas" required>
                        </div>
                        <div class="help-text">Boleh memakai format tanpa '@' jika menggunakan NPSN atau kode internal.</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Profil</button>
            </div>
            <?= form_close() ?>
        </div>
    </div> -->

    <div class="card setting-card">
        <div class="card-header">
            <h3 class="setting-title">
                <span class="title-icon"><i class="fas fa-key"></i></span>
                Ubah Password Super Admin
            </h3>
        </div>
        <div class="card-body">
            <?= form_open('User/UpdatePassword') ?>
            <input type="hidden" name="id_user" value="<?= esc(session()->get('id_user')) ?>">
            <div class="section-grid">
                <div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="newPassword" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                            <div class="input-group-append"><button type="button" class="toggle-pass" data-target="#newPassword"></button></div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="pass_confirm" id="confirmPassword" class="form-control" placeholder="Ketik ulang password" required>
                            <div class="input-group-append"><button type="button" class="toggle-pass" data-target="#confirmPassword"></button></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-warning"><i class="fas fa-key mr-1"></i> Ubah Password</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
