<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Operator Sekolah</title>
  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%);
      font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      color: #0f172a;
    }

    .login-wrapper {
      width: min(420px, 100%);
      background: #ffffff;
      border-radius: 28px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
      overflow: hidden;
    }

    .login-header {
      padding: 28px 28px 20px;
      border-bottom: 1px solid #e2e8f0;
      position: relative;
    }

    .login-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
    }

    .login-header h1 {
      font-size: 1.1rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: #0f172a;
      margin-bottom: 8px;
    }

    .login-header p {
      font-size: 0.95rem;
      color: #475569;
      line-height: 1.7;
    }

    .login-body {
      padding: 28px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 10px;
      font-size: 0.78rem;
      font-weight: 700;
      color: #334155;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap input {
      width: 100%;
      padding: 14px 16px;
      border-radius: 14px;
      border: 1px solid #cbd5e1;
      background: #f8fafc;
      color: #0f172a;
      font-size: 0.98rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-wrap input:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
      background: #ffffff;
    }

    .label-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .forgot-link {
      font-size: 0.84rem;
      color: #3b82f6;
      text-decoration: none;
      font-weight: 600;
    }

    .forgot-link:hover {
      text-decoration: underline;
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 18px 0 24px;
      color: #475569;
      font-size: 0.95rem;
    }

    .remember input {
      width: 16px;
      height: 16px;
      accent-color: #3b82f6;
    }

    .btn-submit {
      width: 100%;
      padding: 14px 16px;
      border-radius: 14px;
      border: none;
      background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
      color: #ffffff;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: transform 0.15s ease, box-shadow 0.2s ease;
    }

    .btn-submit:hover {
      transform: translateY(-1px);
      box-shadow: 0 18px 30px rgba(59, 130, 246, 0.22);
    }

    .footer-note {
      margin-top: 18px;
      text-align: center;
      color: #64748b;
      font-size: 0.92rem;
      line-height: 1.6;
    }

    .footer-note a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 600;
    }

    .footer-note a:hover {
      text-decoration: underline;
    }

    .alert {
      margin-bottom: 18px;
      padding: 14px 16px;
      border-radius: 14px;
      font-size: 0.95rem;
      line-height: 1.6;
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

    @media (max-width: 480px) {
      .login-wrapper {
        width: 100%;
      }

      .login-header,
      .login-body {
        padding-left: 20px;
        padding-right: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-header">
      <h1>LOGIN</h1>
     
    </div>

    <div class="login-body">
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>

      <form action="<?= site_url('Admin/cekLogin') ?>" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <div class="input-wrap">
            <input type="text" id="email" name="email" value="<?= old('email') ?>" placeholder="Masukkan email" autocomplete="username" required />
          </div>
        </div>

        <div class="form-group">
          <div class="label-row">
            <label for="password">Password</label>
          </div>
          <div class="input-wrap">
            <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required />
            <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Tampilkan password">
              <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
        </div>

        <label class="remember">
          <input type="checkbox" id="remember" name="remember" />
          <span>Biarkan saya tetap masuk</span>
        </label>

        <button type="submit" class="btn-submit">Login</button>
      </form>

      <p class="footer-note">
        <a href="<?= site_url('/') ?>">Kembali ke Beranda</a> · Butuh bantuan? <a href="#">Hubungi IT Support</a>
      </p>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon = document.getElementById('eye-icon');
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      icon.innerHTML = show
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }

    document.querySelector('form').addEventListener('submit', function () {
      const btn = this.querySelector('.btn-submit');
      btn.textContent = 'Memproses...';
      btn.disabled = true;
    });
  </script>
</body>
</html>
