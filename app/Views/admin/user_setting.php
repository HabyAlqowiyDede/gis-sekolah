<?php
$judul = $judul ?? 'Pengaturan Akun';
$errors = session()->getFlashdata('errors') ?? [];
?>

<style>
    .user-setting-card { border-radius:12px; box-shadow:0 8px 28px rgba(15,23,42,.06); overflow:hidden; }
    .user-setting-card .card-header { background: linear-gradient(90deg,#f8fbff,#fff); border-bottom:1px solid #eef2ff; }
    .user-setting-title { font-weight:800; color:#0f172a; display:flex; align-items:center; gap:10px }
    .user-setting-title .icon{width:36px;height:36px;border-radius:8px;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#1d4ed8}
    .form-group label{font-weight:700;color:#334155}
    .help-text{font-size:13px;color:#64748b;margin-top:6px}
    .input-icon { display:flex; align-items:center; padding:8px 10px; background:#f1f5f9; border:1px solid #eef2ff; border-right:0; border-radius:8px 0 0 8px }
    .input-with-icon .form-control{ border-radius:0 8px 8px 0 }
    .toggle-pass { background:transparent;border:none;padding:6px 8px;color:#475569; cursor:pointer }
    .btn-primary { background:#1146b9;border-color:#1146b9 }
    @media (max-width:768px){ .user-setting-title{font-size:16px} }
</style>

<div class="col-md-12 mt-4">
    <div class="card user-setting-card">
        <div class="card-header">
            <h3 class="card-title user-setting-title"><span class="icon"><i class="fas fa-user-cog"></i></span>Pengaturan Akun</h3>
        </div>
        <div class="card-body">
            <?php if (! empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('User/UpdatePassword') ?>" method="post">
                <input type="hidden" name="id_user" value="<?= esc(session()->get('id_user')) ?>">

                <div class="form-group input-with-icon">
                    <label>Password Baru</label>
                    <div style="display:flex;gap:0">
                        <div class="input-icon"><i class="fas fa-lock"></i></div>
                        <input type="password" name="password" id="us_new_password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                        <button type="button" class="toggle-pass" data-target="#us_new_password" title="Tampilkan/Sembunyikan"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="help-text">Gunakan kombinasi huruf, angka, dan simbol agar lebih aman.</div>
                </div>

                <div class="form-group input-with-icon">
                    <label>Konfirmasi Password</label>
                    <div style="display:flex;gap:0">
                        <div class="input-icon"><i class="fas fa-check"></i></div>
                        <input type="password" name="pass_confirm" id="us_confirm_password" class="form-control" required placeholder="Ketik ulang password">
                        <button type="button" class="toggle-pass" data-target="#us_confirm_password" title="Tampilkan/Sembunyikan"><i class="fas fa-eye"></i></button>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.toggle-pass').forEach(function(btn){
            btn.addEventListener('click', function(){
                var target = document.querySelector(this.getAttribute('data-target'));
                if (!target) return;
                if (target.type === 'password') { target.type = 'text'; this.innerHTML = '<i class="fas fa-eye-slash"></i>'; }
                else { target.type = 'password'; this.innerHTML = '<i class="fas fa-eye"></i>'; }
            });
        });
    });
</script>
