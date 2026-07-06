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
  
<link rel="stylesheet" href="<?= base_url('AdminLTE3/css/stylel1.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="<?= base_url('AdminLTE3') ?>/css/style.css">
  <style>
    * { box-sizing: border-box; }
    html, body {  margin: 0;
  padding: 0;font-size: 16px; line-height: 1.6; }
    
    /* NAVBAR (corporate / elegan) */
    .top-nav {
      position: sticky;
      top: 0;
      z-index: 9999;
      background: #ffffff;
      padding: 14px 0;
      border-bottom: 1px solid #e5e9f0;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .nav-inner {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
    }
    .nav-brand {
      font-size: 22px;
      font-weight: 700;
      color: #1d4ed8;
      letter-spacing: .2px;
      white-space: nowrap;
      text-decoration: none;
    }
    .nav-links {
      display: flex;
      gap: 8px;
      list-style: none;
      margin: 0;
      padding: 0;
      font-size: 15px;
      flex: 1;
      margin-left: 32px;
    }
    .nav-links a {
      display: inline-block;
      color: #475569;
      text-decoration: none;
      padding: 10px 16px;
      border-radius: 8px;
      border-bottom: 2px solid transparent;
      transition: all .2s ease;
      font-weight: 600;
    }
    .nav-links a.active { color: #1d4ed8; border-bottom-color: #1d4ed8; background: rgba(29, 78, 216, 0.06); }
    .nav-links a:hover { color: #1d4ed8; background: rgba(29, 78, 216, 0.06); }

    .top-nav .nav-search { display: flex; align-items: center; gap: 8px; margin: 0; }
    .top-nav .nav-search input {
      font-size: 14px;
      padding: 9px 14px;
      border: 1px solid #dfe4ec;
      border-radius: 8px;
      width: 200px;
      color: #334155;
      background: #f8fafc;
      transition: border-color .2s ease, background .2s ease;
    }
    .top-nav .nav-search input:focus {
      outline: none;
      border-color: #1d4ed8;
      background: #fff;
    }

    .btn-login {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #1d4ed8;
      color: #fff;
      padding: 9px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      white-space: nowrap;
      transition: background .2s ease;
    }
    .btn-login:hover { background: #1e40af; color: #fff; }
    .btn-login i { font-size: 13px; }
    
    /* PAGE WRAPPER */
    .page-wrapper { max-width: 100%; margin: 0 auto; padding: 40px 32px; }
    
    /* HERO */
    .beranda-hero { padding: 56px 48px !important; border-radius: 20px !important; gap: 56px !important; }
    .hero-text h1 { font-size: 44px !important; font-weight: 800 !important; line-height: 1.2 !important; margin-bottom: 16px !important; }
    .hero-text p { font-size: 18px !important; line-height: 1.8 !important; color: #64748b !important; margin-bottom: 28px !important; }
    .btn-primary { padding: 14px 28px !important; font-size: 16px !important; border-radius: 10px !important; }
    .hero-image { min-height: 280px !important; border-radius: 18px !important; }
    .hero-image p { font-size: 13px !important; }
    .hero-image .map-icon { font-size: 72px !important; }
    
    /* FEATURE CARDS */
    .feature-box { padding: 32px 28px !important; border-radius: 20px !important; gap: 24px !important; min-height: 280px !important; }
    .feature-icon { width: 72px !important; height: 72px !important; font-size: 32px !important; border-radius: 16px !important; }
    .feature-box h3 { font-size: 22px !important; font-weight: 700 !important; }
    .feature-box p { font-size: 16px !important; line-height: 1.8 !important; }
    
    /* INTRO SECTION */
    .beranda-intro { max-width: 1300px !important; padding: 48px 40px !important; border-radius: 28px !important; }
    .intro-title { font-size: 40px !important; }
    .intro-description { font-size: 18px !important; }
    .intro-features { gap: 24px !important; }
    
    /* GRID SECTION */
    .beranda-grid-section { padding: 0 32px; }
    .grid-cards { gap: 24px !important; }
    .grid-card { padding: 32px !important; border-radius: 20px !important; }
    .card-content h3 { font-size: 24px !important; }
    .card-content p { font-size: 16px !important; }
    .card-icon-area { width: 100px !important; height: 100px !important; font-size: 48px !important; border-radius: 18px !important; }
    
    /* FOOTER */
    .main-footer { padding: 32px; max-width: 1300px; margin: 0 auto; font-size: 15px; }
    
    /* MAP PREVIEW */
    .map-preview-card { border-radius: 16px !important; }
    .map-preview-header h3 { font-size: 18px !important; }
    .map-preview-map { height: 280px !important; }

    /* Responsive navbar */
    @media (max-width: 900px) {
      .nav-search { display: none !important; }
      .nav-links { gap: 2px; margin-left: 16px; font-size: 14px; }
      .nav-links a { padding: 8px 10px; }
    }
    #loader{
    position:fixed;
    inset:0;
    background:#ffffff;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    z-index:99999;
    transition:opacity .4s ease;
}

#loader.hide{
    opacity:0;
    visibility:hidden;
}

.spinner{
    width:55px;
    height:55px;
    border:5px solid #e5e7eb;
    border-top:5px solid #2563eb;
    border-radius:50%;
    animation:spin 1s linear infinite;
}

#loader p{
    margin-top:15px;
    color:#555;
    font-size:15px;
}

@keyframes spin{
    to{
        transform:rotate(360deg);
    }
}
  </style>
</head>
<body>
  <div id="loader">
    <div class="spinner"></div>
    <p>Memuat peta...</p>
</div>

<!-- NAVBAR -->
<nav class="top-nav">
  <div class="nav-inner">
    <a href="<?= base_url('/') ?>" class="nav-brand">Pemetaan Sekolah</a>
    <ul class="nav-links">
      <li><a href="<?= base_url('beranda') ?>" class="<?= ($active_page==='beranda'||$active_page==='') ? 'active':'' ?>">Beranda</a></li>
      <li><a href="<?= base_url('datasekolah') ?>" class="<?= in_array($active_page, ['datasekolah', 'pemetaansekolah', 'sekolah']) ? 'active':'' ?>">Sekolah</a></li>
      <li><a href="<?= base_url('peta') ?>"  id="menuPeta"    class="<?= $active_page==='peta'    ? 'active':'' ?>">Peta Sekolah</a></li>
    </ul>
    <a href="<?= base_url('Admin/login') ?>" class="btn-login">
      <i class="fas fa-user"></i> Login
    </a>
  </div>
</nav>

<!-- CONTENT -->
<?php if ($is_peta): ?> 
  <?php echo view('user/' . $page); ?>
<?php else: ?>
<div class="page-wrapper">
  <?php
    if ($page) {
      echo view('user/' . $page);
    } else {
      echo view('user/landing_page/beranda');
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
<script>
const loader = document.getElementById("loader");

window.addEventListener("load", function () {
    loader.classList.add("hide");
});

document.getElementById("menuPeta").addEventListener("click", function(e){
    e.preventDefault();

    loader.classList.remove("hide");
    loader.style.display = "flex";

    setTimeout(() => {
        window.location.href = this.href;
    }, 300); // tampilkan loading 0,5 detik
});
</script>
</body>
</html>