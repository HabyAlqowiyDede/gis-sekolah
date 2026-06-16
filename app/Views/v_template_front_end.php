<?php
$judul = $judul ?? '';
$page  = $page  ?? '';
$active_page = basename($page);
$is_peta = ($active_page === 'peta');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pemetaan Sekolah | <?= $judul ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue-primary: #1a56db;
      --blue-dark:    #1e3a8a;
      --blue-light:   #eff6ff;
      --blue-accent:  #2563eb;
      --text-primary: #111827;
      --text-muted:   #6b7280;
      --border:       #e5e7eb;
      --bg:           #f9fafb;
      --white:        #ffffff;
      --green:        #16a34a;
      --green-light:  #dcfce7;
      --radius:       10px;
      --shadow-sm:    0 1px 3px rgba(0,0,0,.08);
      --shadow-md:    0 4px 12px rgba(0,0,0,.1);
    }

    html { width:100%; min-height:100%; }
    body { width:100%; min-height:100vh; font-family:'Inter',sans-serif; background:var(--bg); color:var(--text-primary); display:flex; flex-direction:column; overflow-x:hidden; }

    /* NAVBAR */
    .top-nav { background:var(--white); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:500; box-shadow:var(--shadow-sm); }
    .nav-inner { width:100%; max-width:none; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 clamp(24px,4vw,56px); height:58px; }
    .nav-brand { font-size:15px; font-weight:700; color:var(--blue-primary); text-decoration:none; white-space:nowrap; }
    .nav-links { display:flex; gap:2px; list-style:none; flex:1; }
    .nav-links a { display:block; padding:6px 14px; border-radius:6px; text-decoration:none; font-size:13px; font-weight:500; color:var(--text-muted); transition:background .15s,color .15s; }
    .nav-links a:hover { background:var(--bg); color:var(--text-primary); }
    .nav-links a.active { color:var(--blue-primary); border-bottom:2px solid var(--blue-primary); border-radius:0; background:transparent; padding-bottom:4px; }
    .nav-search { display:flex; align-items:center; background:var(--bg); border:1px solid var(--border); border-radius:8px; padding:6px 12px; gap:8px; min-width:180px; }
    .nav-search input { border:none; background:transparent; outline:none; font-size:13px; color:var(--text-primary); width:100%; }
    .nav-search i { color:var(--text-muted); font-size:13px; }
    .btn-login { display:flex; align-items:center; gap:6px; background:var(--blue-primary); color:var(--white); border:none; border-radius:8px; padding:7px 16px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; white-space:nowrap; transition:background .15s; }
    .btn-login:hover { background:var(--blue-dark); color:var(--white); }

    /* MAIN WRAPPER */
    .page-wrapper { width:100%; max-width:none; margin:0 auto; padding:32px clamp(24px,4vw,56px); flex:1; }
    .page-wrapper.full-width { max-width:100%; padding:0; }

    /* STAT CARDS */
    .stat-cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; margin-bottom:28px; }
    .stat-card { background:var(--white); border:1px solid var(--border); border-radius:var(--radius); padding:20px 22px; display:flex; align-items:center; gap:16px; box-shadow:var(--shadow-sm); }
    .stat-icon { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
    .stat-icon.blue  { background:var(--blue-light); color:var(--blue-primary); }
    .stat-icon.green { background:var(--green-light); color:var(--green); }
    .stat-icon.gray  { background:#f3f4f6; color:#374151; }
    .stat-label { font-size:12px; color:var(--text-muted); margin-bottom:2px; }
    .stat-value { font-size:22px; font-weight:700; color:var(--text-primary); }

    /* PAGE HEADER */
    .page-header { margin-bottom:24px; }
    .page-header h1 { font-size:28px; font-weight:700; letter-spacing:-.5px; }
    .page-header p { font-size:14px; color:var(--text-muted); margin-top:4px; }

    /* TABLE */
    .table-card { background:var(--white); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:28px; }
    .table-toolbar { display:flex; align-items:center; gap:12px; padding:16px 20px; border-bottom:1px solid var(--border); flex-wrap:wrap; }
    .search-box { display:flex; align-items:center; border:1px solid var(--border); border-radius:8px; padding:7px 12px; gap:8px; flex:1; min-width:200px; }
    .search-box input { border:none; outline:none; font-size:13px; width:100%; color:var(--text-primary); }
    .search-box i { color:var(--text-muted); font-size:13px; }
    .btn-filter { display:flex; align-items:center; gap:6px; border:1px solid var(--border); background:var(--white); border-radius:8px; padding:7px 14px; font-size:13px; font-weight:500; cursor:pointer; color:var(--text-primary); transition:background .15s; }
    .btn-filter:hover { background:var(--bg); }
    .toolbar-right { margin-left:auto; display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted); }
    .sort-select { border:1px solid var(--border); border-radius:8px; padding:6px 10px; font-size:13px; outline:none; cursor:pointer; }

    .data-table { width:100%; border-collapse:collapse; }
    .data-table thead { background:var(--bg); }
    .data-table th { text-align:left; padding:12px 20px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted); border-bottom:1px solid var(--border); }
    .data-table td { padding:14px 20px; font-size:13px; color:var(--text-primary); border-bottom:1px solid var(--border); vertical-align:middle; }
    .data-table tbody tr:last-child td { border-bottom:none; }
    .data-table tbody tr:hover td { background:var(--blue-light); }

    .school-name { display:flex; align-items:center; gap:10px; font-weight:500; }
    .school-icon { width:32px; height:32px; background:var(--blue-light); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--blue-primary); font-size:14px; flex-shrink:0; }

    .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-green { background:var(--green-light); color:var(--green); }
    .badge-blue  { background:var(--blue-light);  color:var(--blue-primary); }

    .akred-badge { width:26px; height:26px; border-radius:6px; background:var(--blue-primary); color:#fff; font-size:12px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; }
    .akred-badge.b { background:#6b7280; }

    .table-footer { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; font-size:13px; color:var(--text-muted); border-top:1px solid var(--border); flex-wrap:wrap; gap:8px; }
    .pagination { display:flex; align-items:center; gap:4px; }
    .page-btn { width:32px; height:32px; border:1px solid var(--border); background:var(--white); border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:500; cursor:pointer; color:var(--text-primary); text-decoration:none; transition:background .15s; }
    .page-btn:hover { background:var(--bg); }
    .page-btn.active { background:var(--blue-primary); color:#fff; border-color:var(--blue-primary); }

    /* STATISTIK BANNER */
    .statistik-banner { background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue-accent) 100%); border-radius:var(--radius); padding:32px 36px; color:#fff; display:flex; align-items:center; justify-content:space-between; gap:24px; margin-bottom:28px; }
    .statistik-banner .icon-circle { width:48px; height:48px; border-radius:50%; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:16px; }
    .statistik-banner h3 { font-size:20px; font-weight:700; margin-bottom:8px; }
    .statistik-banner p  { font-size:13px; opacity:.8; max-width:300px; line-height:1.5; }
    .badge-row { display:flex; gap:8px; margin-top:16px; }
    .badge-pill { background:rgba(255,255,255,.2); color:#fff; border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .banner-arrow { width:44px; height:44px; border-radius:50%; background:rgba(255,255,255,.2); border:none; color:#fff; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:background .15s; }
    .banner-arrow:hover { background:rgba(255,255,255,.3); }

    /* FOOTER */
    .main-footer { width:100%; background:var(--white); border-top:1px solid var(--border); padding:18px clamp(24px,4vw,56px); font-size:12px; color:var(--text-muted); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; }
    .main-footer a { color:var(--text-muted); text-decoration:none; }
    .main-footer a:hover { color:var(--blue-primary); }
    .footer-links { display:flex; gap:16px; }

    @media(max-width:768px){
      .nav-inner { padding:0 18px; }
      .page-wrapper { padding:24px 18px; }
      .nav-links,.nav-search { display:none; }
      .stat-cards { grid-template-columns:1fr 1fr; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="top-nav">
  <div class="nav-inner">
    <a href="<?= base_url('/') ?>" class="nav-brand">Pemetaan Sekolah</a>
    <ul class="nav-links">
      <li><a href="<?= base_url('beranda') ?>" class="<?= ($active_page==='beranda'||$active_page==='') ? 'active':'' ?>">Beranda</a></li>
      <li><a href="<?= base_url('datasekolah') ?>" class="<?= in_array($active_page, ['datasekolah', 'pemetaansekolah', 'sekolah']) ? 'active':'' ?>">Sekolah</a></li>
      <li><a href="<?= base_url('peta') ?>"    class="<?= $active_page==='peta'    ? 'active':'' ?>">Peta Sekolah</a></li>
      <li><a href="<?= base_url('tentang') ?>" class="<?= $active_page==='tentang' ? 'active':'' ?>">Tentang</a></li>
    </ul>
    <div class="nav-search">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Cari data...">
    </div>
    <?php if (session()->get('is_admin_login')): ?>
      <a href="<?= base_url('Admin') ?>" class="btn-login">
        <i class="fas fa-user-cog"></i> Admin Dashboard
      </a>
    <?php else: ?>
      <a href="<?= base_url('Admin/login') ?>" class="btn-login">
        <i class="fas fa-user"></i> Login
      </a>
    <?php endif; ?>
  </div>
</nav>

<!-- CONTENT -->
<?php if ($is_peta): ?>
  <?php echo view($page); ?>
<?php else: ?>
<div class="page-wrapper">
  <?php
    if ($page) {
      echo view($page);
    } else {
      echo view('landing_page/beranda');
    }
  ?>
</div>
<?php endif; ?>

<!-- FOOTER (sembunyikan di halaman peta) -->
<?php if (!$is_peta): ?>
<footer class="main-footer">
  <span>© 2026 <strong>Pemetaan Sekolah</strong> — Sistem Manajemen Data Pendidikan Terpadu.</span>
  <div class="footer-links">
    <a href="#">Kebijakan Privasi</a>
    <a href="#">Syarat &amp; Ketentuan</a>
    <a href="#">Kontak Kami</a>
    <a href="#">Bantuan</a>
  </div>
</footer>
<?php endif; ?>

<script src="<?= base_url('AdminLTE3') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('AdminLTE3') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
