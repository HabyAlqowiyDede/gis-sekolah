<style>
.beranda-hero{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:40px;display:flex;align-items:center;gap:40px;margin-bottom:24px;box-shadow:var(--shadow-sm)}
.hero-text{flex:1}
.hero-eyebrow{display:inline-block;background:var(--blue-light);color:var(--blue-primary);font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;margin-bottom:16px;letter-spacing:.05em}
.hero-text h1{font-size:34px;font-weight:700;line-height:1.2;color:var(--text-primary);margin-bottom:12px}
.hero-text p{font-size:14px;color:var(--text-muted);line-height:1.7;margin-bottom:24px}
.hero-actions{display:flex;gap:12px;flex-wrap:wrap}
.btn-primary{background:var(--blue-primary);color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .15s}
.btn-primary:hover{background:var(--blue-dark);color:#fff}
.btn-outline{background:#fff;color:var(--text-primary);border:1px solid var(--border);border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .15s}
.btn-outline:hover{background:var(--bg)}
.hero-image{flex:0 0 320px;background:var(--blue-light);border-radius:12px;min-height:200px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;text-align:center}
.hero-image .map-icon{font-size:60px;color:var(--blue-primary);margin-bottom:12px}
.hero-image-label{display:flex;align-items:center;gap:8px;background:#fff;border-radius:8px;padding:8px 14px;margin-top:12px;font-size:12px;font-weight:600;color:var(--text-primary);box-shadow:var(--shadow-sm)}
.hero-image-label i{color:var(--blue-primary)}
.hero-image p{font-size:11px;font-weight:700;letter-spacing:.08em;color:var(--blue-primary);text-transform:uppercase;margin-bottom:4px}

.beranda-stats{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px}
.bstat-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:20px 22px;box-shadow:var(--shadow-sm)}
.bstat-card .growth{font-size:12px;font-weight:600;color:#16a34a}
.bstat-card .growth.max{color:#ef4444}
.bstat-card .bstat-label{font-size:13px;color:var(--text-muted);margin-top:4px}
.bstat-card .bstat-value{font-size:28px;font-weight:700;color:var(--text-primary)}
.bstat-card .bstat-top{display:flex;align-items:center;gap:10px;margin-bottom:4px}
.bstat-card .bstat-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px}

.map-preview-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-sm)}
.map-preview-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
.map-preview-header h3{font-size:15px;font-weight:600}
.map-preview-badges{display:flex;gap:8px}
.map-preview-map{height:220px;background:#dbeafe;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.map-placeholder-bg{width:100%;height:100%;background:linear-gradient(135deg,#bfdbfe 0%,#93c5fd 50%,#60a5fa 100%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px}
.map-placeholder-bg i{font-size:40px;color:var(--blue-dark);opacity:.4}
.map-placeholder-btn{position:absolute;bottom:20px;left:50%;transform:translateX(-50%)}
</style>

<!-- Hero -->
<div class="beranda-hero">
  <div class="hero-text">
    <span class="hero-eyebrow">GIS DASHBOARD V2.4</span>
    <h1>Pemetaan Sekolah<br>Digital</h1>
    <p>Sistem informasi geografis terintegrasi untuk visualisasi dan analisis data infrastruktur pendidikan di seluruh wilayah secara presisi dan realtime.</p>
    <div class="hero-actions">
      <a href="<?= base_url('peta') ?>" class="btn-primary"><i class="fas fa-map"></i> Lihat Peta Interaktif</a>
      <?php if (session()->get('is_admin_login')): ?>
        <a href="<?= base_url('Admin') ?>" class="btn-outline"><i class="fas fa-user-cog"></i> Dashboard Admin</a>
      <?php else: ?>
        <a href="<?= base_url('Admin/login') ?>" class="btn-outline"><i class="fas fa-user-lock"></i> Login Admin</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="hero-image">
    <p>SCHOOL MAPPING APP</p>
    <div class="map-icon"><i class="fas fa-map-marked-alt"></i></div>
    <div class="hero-image-label">
      <i class="fas fa-sync-alt"></i>
      <span>Update Terkini — 12 Sekolah Baru Terpetakan</span>
    </div>
  </div>
</div>

<!-- Stat Cards -->
<div class="beranda-stats">
  <div class="bstat-card">
    <div class="bstat-top">
      <div class="bstat-icon blue" style="background:var(--blue-light);color:var(--blue-primary)"><i class="fas fa-school"></i></div>
      <span class="growth">+2.4%</span>
    </div>
    <div class="bstat-value"><?= esc(number_format($totalSekolah ?? 0, 0, ',', '.')) ?></div>
    <div class="bstat-label">Total Sekolah</div>
  </div>
  <div class="bstat-card">
    <div class="bstat-top">
      <div class="bstat-icon" style="background:#eff6ff;color:#2563eb"><i class="fas fa-map-pin"></i></div>
      <span class="growth max">Max</span>
    </div>
    <div class="bstat-value"><?= esc(number_format($totalKecamatan ?? 0, 0, ',', '.')) ?></div>
    <div class="bstat-label">Kecamatan Terdata</div>
  </div>
</div>

<!-- Map Preview -->
<div class="map-preview-card">
  <div class="map-preview-header">
    <h3>Layer Visualisasi Map</h3>
    <div class="map-preview-badges">
      <span class="badge badge-green"><i class="fas fa-circle" style="font-size:8px;margin-right:4px"></i>Zonasi Aktif</span>
      <span class="badge badge-blue">Aksesibilitas</span>
    </div>
  </div>
  <div class="map-preview-map">
    <div class="map-placeholder-bg">
      <i class="fas fa-map"></i>
      <span style="font-size:13px;color:var(--blue-dark);font-weight:500;opacity:.6">Preview Peta</span>
    </div>
    <div class="map-placeholder-btn">
      <a href="<?= base_url('peta') ?>" class="btn-primary"><i class="fas fa-expand-alt"></i> Buka Map Navigasi Penuh</a>
    </div>
  </div>
</div>
