<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin – Login Admin</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f0f2f5;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      color: #1a1a2e;
    }

    .card {
      background: #ffffff;
      border: 1px solid #e2e6ea;
      border-radius: 12px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
      width: 100%;
      max-width: 480px;
      padding: 40px 44px 36px;
    }

    /* Header */
    .header {
      text-align: center;
      margin-bottom: 28px;
    }

    .logo-wrap {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 60px;
      height: 60px;
      background: #e8eaf6;
      border-radius: 14px;
      margin-bottom: 16px;
    }

    .logo-wrap svg {
      width: 30px;
      height: 30px;
      color: #1a237e;
    }

    .header h1 {
      font-size: 1.45rem;
      font-weight: 700;
      color: #1a237e;
      letter-spacing: -0.2px;
    }

    .header p {
      margin-top: 4px;
      font-size: 0.85rem;
      color: #6b7280;
    }

    .divider {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 0 0 28px;
    }

    /* Form */
    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      color: #374151;
      text-transform: uppercase;
      margin-bottom: 7px;
    }

    .input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 13px;
      color: #9ca3af;
      display: flex;
      align-items: center;
    }

    .input-icon svg { width: 17px; height: 17px; }

    .input-wrap input {
      width: 100%;
      padding: 11px 13px 11px 40px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 0.92rem;
      color: #1f2937;
      background: #fff;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-wrap input:focus {
      border-color: #1a237e;
      box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
    }

    .input-wrap input::placeholder { color: #9ca3af; }

    .toggle-pass {
      position: absolute;
      right: 13px;
      background: none;
      border: none;
      cursor: pointer;
      color: #9ca3af;
      display: flex;
      align-items: center;
      padding: 0;
      transition: color 0.15s;
    }

    .toggle-pass:hover { color: #6b7280; }
    .toggle-pass svg { width: 18px; height: 18px; }

    /* Password row label */
    .label-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 7px;
    }

    .label-row label {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      color: #374151;
      text-transform: uppercase;
    }

    .forgot-link {
      font-size: 0.82rem;
      color: #1a237e;
      text-decoration: none;
      font-weight: 500;
    }

    .forgot-link:hover { text-decoration: underline; }

    /* Remember me */
    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 18px 0 22px;
      cursor: pointer;
      user-select: none;
    }

    .remember input[type="checkbox"] {
      width: 15px;
      height: 15px;
      accent-color: #1a237e;
      cursor: pointer;
    }

    .remember span {
      font-size: 0.87rem;
      color: #4b5563;
    }

    /* Submit */
    .btn-submit {
      width: 100%;
      padding: 13px;
      background: #1a237e;
      color: #fff;
      font-size: 0.95rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background 0.2s, transform 0.1s;
      letter-spacing: 0.01em;
    }

    .btn-submit:hover { background: #151b6e; }
    .btn-submit:active { transform: scale(0.995); }

    .btn-submit svg { width: 18px; height: 18px; }

    .back-landing {
      width: 100%;
      margin-top: 12px;
      padding: 12px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #fff;
      color: #1a237e;
      font-size: 0.9rem;
      font-weight: 600;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background 0.2s, border-color 0.2s;
    }

    .back-landing:hover {
      background: #f8fafc;
      border-color: #1a237e;
    }

    .back-landing svg { width: 18px; height: 18px; }

    .alert {
      margin-bottom: 18px;
      padding: 12px 14px;
      border-radius: 8px;
      font-size: 0.86rem;
      line-height: 1.4;
    }

    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #991b1b;
    }

    .alert-success {
      background: #ecfdf5;
      border: 1px solid #bbf7d0;
      color: #166534;
    }

    /* Footer */
    .footer-note {
      margin-top: 20px;
      font-size: 0.83rem;
      color: #6b7280;
      text-align: center;
    }

    .footer-note a {
      color: #1a237e;
      font-weight: 500;
      text-decoration: none;
    }

    .footer-note a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="card">
    <div class="header">
      <div class="logo-wrap">
        <!-- Map/grid icon -->
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/>
          <line x1="9" y1="3" x2="9" y2="18"/>
          <line x1="15" y1="6" x2="15" y2="21"/>
        </svg>
      </div>
      <h1>Login Admin</h1>
      <p>Sistem Pemetaan Sekolah</p>
    </div>

    <hr class="divider" />

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <form action="<?= site_url('Admin/cekLogin') ?>" method="post">
      <!-- Email / Username -->
      <div class="form-group">
        <label for="email">Email atau Username</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </span>
          <input type="text" id="email" name="email" value="<?= old('email') ?>" placeholder="admin@map.id" autocomplete="username" required />
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <div class="label-row">
          <label for="password">Password</label>
        </div>
        <div class="input-wrap">
          <span class="input-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </span>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required />
          <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Tampilkan password">
            <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Remember me -->
      <label class="remember">
        <input type="checkbox" id="remember" name="remember" />
        <span>Biarkan saya tetap masuk</span>
      </label>

      <!-- Submit -->
      <button type="submit" class="btn-submit">
        Masuk ke Panel Admin
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </button>

      <a href="<?= site_url('/') ?>" class="back-landing">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"/>
          <polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali ke Beranda
      </a>
    </form>

    <p class="footer-note">
      Butuh bantuan akses? <a href="#">Hubungi IT Support</a>
    </p>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('eye-icon');
      const show  = input.type === 'password';
      input.type  = show ? 'text' : 'password';
      icon.innerHTML = show
        ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
           <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
           <line x1="1" y1="1" x2="23" y2="23"/>`
        : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
           <circle cx="12" cy="12" r="3"/>`;
    }

    document.querySelector('form').addEventListener('submit', function () {
      const btn = this.querySelector('.btn-submit');
      btn.textContent = 'Memproses...';
      btn.disabled = true;
    });
  </script>
</body>
</html>
