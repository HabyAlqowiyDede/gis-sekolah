<?php
$judul = $judul ?? 'Profil Dinas Pendidikan';
$profil = $profil ?? [];
$errors = session()->getFlashdata('errors') ?? [];
?>

<style>
    .profil-hero {
        background: linear-gradient(135deg, #1d4ed8 0%, #0f766e 100%);
        color: #fff;
        border-radius: 12px;
        padding: 24px 26px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
    }

    .profil-hero h3 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
    .profil-hero p { color: rgba(255,255,255,.78); margin: 0; }

    .profil-hero-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .profil-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .08);
    }

    .profil-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 18px 20px;
    }

    .profil-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .profil-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profil-logo {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        object-fit: cover;
        margin-bottom: 16px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 8px 0 16px;
    }

    .section-title span {
        width: 32px;
        height: 32px;
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

    .info-group {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
    }

    .info-value {
        font-size: 14px;
        color: #0f172a;
        font-weight: 500;
    }

    /* Table improvements */
    .table thead th { background: #f8fafc; border-bottom: 2px solid #eef2ff; }
    #tableUsers tbody tr { background: #ffffff; }
    .user-email-badge { display:inline-block; background:#eef2ff; color:#0f172a; padding:4px 8px; border-radius:999px; font-size:13px; }
    .truncate { max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .action-btns .btn { margin-right:6px; }
    @media (max-width:576px) {
        .truncate { max-width:120px; }
        .action-btns .btn { margin-bottom:6px; }
    }

    @media (max-width: 768px) {
        .profil-hero { align-items: flex-start; flex-direction: column; }
    }
</style>


<?php if (isSuperAdmin()): ?>
<div class="col-md-12 mt-4">
    <div class="card profil-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="profil-title">
                <span class="title-icon"><i class="fas fa-users"></i></span>
                Daftar User Sekolah
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableUsers" class="table table-sm mb-0" style="width:100%">
                    <thead>
                        <tr><th>Pengguna</th></tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-npsn="<?= esc($user['npsn'] ?? '') ?>" data-email="<?= esc($user['email'] ?? '') ?>">
                                    <td>
                                        <div class="user-card" style="display:flex;gap:12px;align-items:center;padding:10px;border:1px solid #eef2ff;border-radius:8px;background:#fff">
                                            <div style="width:54px;height:54px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-weight:700;color:#0f172a">U</div>
                                            <div style="flex:1">
                                                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px">
                                                    <div>
                                                        <div style="font-weight:800;color:#0f172a"><?= esc($user['nama_user']) ?></div>
                                                        <div style="font-size:12px;color:#64748b">NPSN: <?= esc($user['npsn'] ?? '-') ?></div>
                                                    </div>
                                                    <div style="text-align:right">
                                                        <?php if (!empty($user['email'])): ?>
                                                            <div class="user-email-badge" style="margin-bottom:6px"><?= esc($user['email']) ?></div>
                                                        <?php else: ?>
                                                            <div class="text-muted" style="font-size:12px;margin-bottom:6px">-</div>
                                                        <?php endif; ?>
                                                        <div style="font-size:12px;color:#94a3b8">********</div>
                                                    </div>
                                                </div>
                                                <div style="margin-top:8px;display:flex;gap:8px">
                                                    <button type="button" class="btn btn-info btn-sm btn-edit-email" data-user-id="<?= esc($user['id_user']) ?>" data-user-email="<?= esc($user['email']) ?>" data-user-name="<?= esc($user['nama_user']) ?>">
                                                        <i class="fas fa-envelope mr-1"></i> Ubah Email
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm btn-edit-password" data-user-id="<?= esc($user['id_user']) ?>" data-user-name="<?= esc($user['nama_user']) ?>">
                                                        <i class="fas fa-key mr-1"></i> Ubah Password
                                                    </button>
                                                </div>
                                                <!-- Hidden searchable fields -->
                                                <span class="d-none"><?= esc($user['nama_user']) ?> <?= esc($user['npsn'] ?? '') ?> <?= esc($user['email'] ?? '') ?></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="text-center">Belum ada user terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEmailEdit" tabindex="-1" role="dialog" aria-labelledby="modalEmailEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('User/UpdateEmail') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEmailEditLabel">Ubah Email User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="modalEmailUserId">
                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" id="modalEmailUserName" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                            <input type="text" name="email" id="modalEmailInput" class="form-control" required placeholder="Contoh: 123456789 atau adminsekolah">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPasswordEdit" tabindex="-1" role="dialog" aria-labelledby="modalPasswordEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('User/UpdatePassword') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPasswordEditLabel">Ubah Password User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="modalUserId">
                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" id="modalUserName" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" id="modalPassword" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="pass_confirm" id="modalPasswordConfirm" class="form-control" required placeholder="Ketik ulang password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-edit-password').forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = this.dataset.userId;
                var userName = this.dataset.userName;

                document.getElementById('modalUserId').value = userId;
                document.getElementById('modalUserName').value = userName;
                document.getElementById('modalPassword').value = '';
                document.getElementById('modalPasswordConfirm').value = '';

                $('#modalPasswordEdit').modal('show');
            });
        });

        document.querySelectorAll('.btn-edit-email').forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = this.dataset.userId;
                var userEmail = this.dataset.userEmail;
                var userName = this.dataset.userName;

                document.getElementById('modalEmailUserId').value = userId;
                document.getElementById('modalEmailUserName').value = userName;
                document.getElementById('modalEmailInput').value = userEmail;

                $('#modalEmailEdit').modal('show');
            });
        });

        if (typeof $().DataTable === 'function') {
                $('#tableUsers').DataTable({
                    responsive: true,
                    autoWidth: false,
                    pageLength: 6,
                    lengthChange: false,
                    ordering: false,
                    language: { searchPlaceholder: "Cari nama, NPSN, atau email...", search: "" },
                    columnDefs: [
                        { targets: 0, orderable: false }
                    ],
                    drawCallback: function(settings) {
                        // small tweak: make card buttons work for dropdowns if used
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });
            }
        });
    </script>
<?php endif; ?>
