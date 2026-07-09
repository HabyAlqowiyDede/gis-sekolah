<style>
  :root{
    --ink:#101a2e;
    --muted:#5b6784;
    --blue-600:#2f6ee0;
    --blue-500:#4b8bf5;
    --blue-100:#e8f0ff;
    --sky-50:#f5f9ff;
    --line:rgba(150,175,220,.28);
    --font-display:'Sora','Inter',-apple-system,sans-serif;
    --font-body:'Inter',-apple-system,sans-serif;
  }

  /* ===== Hero ===== */
  .beranda-hero{
    position:relative;
    background:linear-gradient(150deg,#ffffff 0%,var(--sky-50) 100%);
    border:1px solid var(--line);
    border-radius:44px 44px 44px 12px;
    padding:52px 56px;
    display:flex;
    align-items:center;
    gap:48px;
    margin-bottom:28px;
    overflow:hidden;
    box-shadow:0 14px 38px rgba(47,110,224,.09);
  }
  .beranda-hero::before{
    content:"";
    position:absolute;
    width:280px;height:280px;
    right:-90px;top:-110px;
    background:radial-gradient(circle at 30% 30%, rgba(75,139,245,.16), transparent 70%);
    border-radius:50%;
    pointer-events:none;
  }
  .hero-text{flex:1;position:relative;z-index:1}
  .hero-eyebrow{display:inline-flex;align-items:center;gap:6px;background:var(--blue-100);color:var(--blue-600);font-size:11px;font-weight:700;padding:7px 16px 7px 12px;border-radius:999px;margin-bottom:20px;letter-spacing:.05em}
  .hero-eyebrow::before{content:"";width:6px;height:6px;border-radius:50%;background:var(--blue-500)}
  .hero-text h1{font-family:var(--font-display);font-size:38px;font-weight:700;line-height:1.18;color:var(--ink);margin-bottom:16px;letter-spacing:-.02em}
  .hero-text p{font-family:var(--font-body);font-size:14.5px;color:var(--muted);line-height:1.85;margin-bottom:30px;max-width:440px}
  .hero-actions{display:flex;gap:12px;flex-wrap:wrap}
  .btn-primary{
    background:linear-gradient(135deg,var(--blue-500),var(--blue-600));
    color:#fff;border:none;border-radius:999px;padding:14px 28px;
    font-family:var(--font-body);font-size:13px;font-weight:600;cursor:pointer;
    text-decoration:none;display:inline-flex;align-items:center;gap:8px;
    transition:all .3s ease;box-shadow:0 10px 24px rgba(47,110,224,.3);
  }
  .btn-primary:hover{box-shadow:0 12px 30px rgba(47,110,224,.4);transform:translateY(-2px)}
@media (max-width: 768px){

  .map-preview-card{
    width: 92%;
    max-width: 100%;
    margin: 16px auto;
    border-radius: 16px;
  }

  .map-preview-map{
    height: 140px; /* lebih kecil di HP */
  }

  .map-preview-header{
    padding: 12px 14px;
  }

  .map-preview-header h3{
    font-size: 13px;
  }

  .map-placeholder-bg span{
    font-size: 12px;
  }

  .map-placeholder-btn{
    bottom: 12px;
  }

}
  /* Organic blob-shaped visual, signature element of the hero */
  .logo-container{
    position:relative;
    width:300px;
    height:300px;
    flex:0 0 300px;
    cursor:pointer;
    z-index:1;
    border-radius:62% 38% 55% 45% / 48% 45% 55% 52%;
    background:linear-gradient(155deg,var(--blue-100) 0%,#dbe8fd 65%,#cfe0fc 100%);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.7), 0 20px 40px rgba(47,110,224,.16);
    display:flex;align-items:center;justify-content:center;
    transition:border-radius .6s ease;
  }
  .logo-container:hover{border-radius:45% 55% 42% 58% / 55% 42% 58% 45%}
  .logo{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:62%;transition:opacity .5s ease-in-out}
  .logo-awal{opacity:1}
  .logo-hover{opacity:0}
  .logo-container:hover .logo-awal{opacity:0}
  .logo-container:hover .logo-hover{opacity:1}
  .hero-image-label{
    position:absolute;bottom:-14px;left:50%;transform:translateX(-50%);
    display:flex;align-items:center;gap:8px;background:#fff;border-radius:999px;
    padding:10px 18px;font-size:12px;font-weight:600;color:var(--ink);
    box-shadow:0 10px 24px rgba(16,26,46,.12);white-space:nowrap;z-index:2;
  }
  .hero-image-label i{color:var(--blue-600)}

  /* ===== Map preview ===== */
  .map-preview-card{background:linear-gradient(180deg,#ffffff 0%,var(--sky-50) 100%);border:1px solid var(--line);border-radius:12px 36px 36px 36px;overflow:hidden;box-shadow:0 10px 30px rgba(47,110,224,.06)}
  .map-preview-header{display:flex;align-items:center;justify-content:space-between;padding:20px 24px;border-bottom:1px solid var(--line)}
  .map-preview-header h3{font-family:var(--font-display);font-size:15px;font-weight:600 ;color:var(--ink)}
  .map-preview-badges{display:flex;gap:8px}
  .map-preview-map{ height:220px;background:linear-gradient(135deg,var(--sky-50) 0%,#eef3fb 45%,#e3ecfb 100%);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
  .map-placeholder-bg{width:70%;height:100%;background:linear-gradient(135deg,#ffffff 0%,var(--sky-50) 50%,#eef2fb 100%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;position:relative;border-radius:26px 8px 26px 26px;box-shadow:inset 0 0 0 1px var(--line)}
  .map-placeholder-bg::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(150,175,220,.14) 1px,transparent 1px),linear-gradient(90deg,rgba(150,175,220,.14) 1px,transparent 1px);background-size:26px 26px;opacity:.5;border-radius:26px 8px 26px 26px}
  .map-placeholder-bg i{font-size:38px;color:#7c8aa5;opacity:.5;position:relative;z-index:1}
  .map-placeholder-bg span{position:relative;z-index:1;color:#3d4a63;font-weight:600;opacity:.85;font-size:13px}
  .map-placeholder-btn{position:absolute;bottom:22px;left:50%;transform:translateX(-50%);z-index:2}

  /* ===== Intro ===== */
  .beranda-intro{background:linear-gradient(180deg,#ffffff 0%,var(--sky-50) 100%);border:1px solid var(--line);border-radius:12px 48px 48px 48px;padding:52px 36px 44px;margin:28px auto;max-width:1120px;box-shadow:0 12px 34px rgba(47,110,224,.06)}
  .beranda-intro-header{text-align:center;max-width:760px;margin:0 auto 40px}
  .intro-label{display:inline-flex;padding:9px 22px;border-radius:999px;background:var(--blue-100);color:var(--blue-600);font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:20px}
  .intro-title{font-family:var(--font-display);margin:0;font-size:36px;font-weight:700;color:var(--ink);line-height:1.2;letter-spacing:-.02em}
  .intro-description{font-family:var(--font-body);margin:18px auto 0;color:var(--muted);font-size:16px;line-height:1.9;max-width:640px}

  .intro-features{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:20px}
  @media(max-width:900px){.intro-features{grid-template-columns:repeat(auto-fit,minmax(240px,1fr))}}
  .feature-box{
    background:#fff;border:1px solid var(--line);padding:34px 26px;min-height:230px;
    display:flex;flex-direction:column;align-items:center;gap:20px;text-align:center;
    transition:all .35s ease;
  }
  .feature-box:nth-child(3n+1){border-radius:36px 36px 36px 8px}
  .feature-box:nth-child(3n+2){border-radius:8px 36px 36px 36px}
  .feature-box:nth-child(3n+3){border-radius:36px 8px 36px 36px}
  .feature-box:hover{box-shadow:0 16px 34px rgba(47,110,224,.13);transform:translateY(-5px)}
  .feature-icon{width:60px;height:60px;border-radius:50% 50% 50% 12px;background:linear-gradient(155deg,var(--blue-100),#dbe8fd);display:flex;align-items:center;justify-content:center;color:var(--blue-600);font-size:26px}
  .feature-box h3{font-family:var(--font-display);margin:0;font-size:18px;font-weight:700;color:var(--ink)}
  .feature-box p{margin:0;color:var(--muted);font-size:14.5px;line-height:1.8;max-width:250px}

  /* ===== Bento grid ===== */
  .beranda-grid-section{margin:34px 0;max-width:1240px;margin-left:auto;margin-right:auto}
  .grid-cards{
    display:grid;
    grid-template-columns:1.1fr 1fr 1fr;
    grid-template-rows:auto auto;
    gap:20px;
  }

  @media(max-width:900px){
    .grid-cards{grid-template-columns:1fr}

    /* FIX: posisi kolom/baris eksplisit di layout desktop harus di-reset,
       kalau tidak kartu akan tumpang-tindih / terpotong saat grid jadi 1 kolom */
    .grid-card{
      grid-column:auto !important;
      grid-row:auto !important;
    }
    .grid-card:nth-child(1){border-radius:12px 44px 44px 44px}
    .grid-card:nth-child(2){border-radius:44px 12px 44px 44px}
    .grid-card:nth-child(3){border-radius:44px 44px 12px 44px}
    .grid-card:nth-child(4){border-radius:44px 12px 44px 12px}
  }

  .grid-card{
    background:#fff;border:1px solid var(--line);padding:30px;
    display:flex;flex-direction:column;justify-content:space-between;gap:20px;
    transition:all .35s ease;box-shadow:0 4px 16px rgba(16,26,46,.03);
    min-height:200px;
  }
  .grid-card:hover{box-shadow:0 18px 38px rgba(47,110,224,.13);transform:translateY(-4px);border-color:rgba(75,139,245,.35)}

  /* varied organic corners so the grid doesn't read as uniform boxes */
  .grid-card:nth-child(1){
    grid-column: 1;
    grid-row: 1 / span 2;
    border-radius: 12px 44px 44px 44px;
  }

  .grid-card:nth-child(2){
    grid-column: 2;
    grid-row: 1;
    border-radius: 44px 12px 44px 44px;
  }

  .grid-card:nth-child(3){
    grid-column: 3;
    grid-row: 1;
    border-radius: 44px 44px 12px 44px;
  }

  .grid-card:nth-child(4){
    grid-column: 2 / span 2;
    grid-row: 2;
    border-radius: 44px 12px 44px 12px;
  }
  .card-content{display:flex;flex-direction:column;gap:10px}
  .card-label{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--blue-600);text-transform:uppercase;letter-spacing:.06em}
  .card-content h3{font-family:var(--font-display);margin:0;font-size:21px;font-weight:700;color:var(--ink);line-height:1.35}
  .card-content p{margin:0;color:var(--muted);font-size:14px;line-height:1.75}
  .card-icon-area{
    align-self:flex-start;width:64px;height:64px;border-radius:50% 50% 50% 14px;
    background:linear-gradient(155deg,var(--blue-100),#dbe8fd);
    display:flex;align-items:center;justify-content:center;color:var(--blue-600);
    font-size:30px;transition:transform .35s ease;
  }
  .grid-card:hover .card-icon-area{transform:scale(1.08) rotate(-4deg)}
  .grid-card-large .card-icon-area{width:76px;height:76px;font-size:36px}

  /* ===== Background blobs ===== */
  .landing-wrapper{position:relative;overflow:visible}
  .landing-bg{position:fixed;left:0;right:0;top:0;height:40vh;pointer-events:none;z-index:0;display:block;opacity:.4}
  .landing-bg svg{width:120%;height:100%;transform:translateX(-10%);filter:blur(52px) saturate(80%);opacity:.5}
  .landing-wrapper .beranda-hero,
  .landing-wrapper .beranda-intro,
  .landing-wrapper .beranda-grid-section,
  .landing-wrapper .map-preview-card{position:relative;z-index:1}

  @media(max-width:768px){
    .beranda-hero{flex-direction:column;padding:36px 28px;border-radius:32px 32px 32px 12px;text-align:center}
    .hero-text p{max-width:100%}
    .hero-actions{justify-content:center}
    .logo-container{width:220px;height:220px;flex-basis:220px}
    .beranda-intro{padding:40px 24px 34px;border-radius:12px 32px 32px 32px}
    .feature-box{padding:28px 20px;min-height:0}
  }

  /* HP sempit: rapatkan tipografi & padding supaya tidak terlalu besar/berjarak
     dibanding lebar layar, tanpa mengubah struktur atau proporsi desain */
  @media(max-width:480px){
    .beranda-hero{padding:28px 20px}
    .hero-eyebrow{font-size:10px;padding:6px 14px 6px 10px}
    .hero-text h1{font-size:28px}
    .hero-text p{font-size:13.5px}
    .btn-primary{padding:12px 22px;font-size:12.5px}
    .logo-container{width:170px;height:170px;flex-basis:170px}
    .hero-image-label{font-size:11px;padding:8px 14px;bottom:-12px}

    .beranda-intro{padding:32px 18px 28px}
    .intro-title{font-size:26px}
    .intro-description{font-size:14px;line-height:1.75}
    .intro-label{font-size:11px;padding:7px 16px}

    .feature-box{padding:22px 16px}
    .feature-icon{width:52px;height:52px;font-size:22px}
    .feature-box h3{font-size:16px}
    .feature-box p{font-size:13.5px}

    .grid-card{padding:22px}
    .card-content h3{font-size:18px}
    .card-icon-area{width:52px;height:52px;font-size:24px}
    .grid-card-large .card-icon-area{width:60px;height:60px;font-size:28px}

    .map-preview-header{flex-wrap:wrap;gap:8px}
  }
  </style>

  <!-- Hero -->
  <div class="landing-wrapper">
    <div class="landing-bg" aria-hidden="true">
      <svg viewBox="0 0 1200 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="g1" x1="0" x2="1">
            <stop offset="0" stop-color="#c7f2ff" />
            <stop offset="1" stop-color="#93c5fd" />
          </linearGradient>
          <linearGradient id="g2" x1="0" x2="1">
            <stop offset="0" stop-color="#e0f2fe" />
            <stop offset="1" stop-color="#60a5fa" />
          </linearGradient>
        </defs>
        <path d="M0 200 C300 50 900 350 1200 150 L1200 600 L0 600 Z" fill="url(#g1)" opacity="0.55"/>
        <path d="M0 300 C300 150 900 450 1200 250 L1200 600 L0 600 Z" fill="url(#g2)" opacity="0.45"/>
      </svg>
    </div>
    <div class="beranda-hero">
    <div class="hero-text">
      <span class="hero-eyebrow">Sistem Informasi Geografis</span>
      <h1>Pemetaan Sekolah<br>Digital</h1>
      <p>Sistem informasi geografis terintegrasi untuk visualisasi dan analisis data infrastruktur pendidikan di seluruh wilayah secara presisi dan realtime.</p>
      <div class="hero-actions">
        <a href="<?= base_url('datasekolah') ?>" class="btn-primary"><i class="fas fa-search"></i> Cari Sekolah</a>
      </div>
    </div>
    <div class="logo-container">
      <img src="<?= base_url('AdminLTE3/foto/logo.png') ?>"  class="logo logo-awal">
      <img src="<?= base_url('AdminLTE3/foto/logo1.png') ?>" class="logo logo-hover">
      <div class="hero-image-label"><i class="fas fa-location-dot"></i> Peta Interaktif Nasional</div>
  </div>
  </div>



  <section class="beranda-grid-section">
    <div class="grid-cards">
      <div class="grid-card grid-card-large">
        <div class="card-content">
          <span class="card-label">Data Terpusat</span>
          <h3>Akses Data Sekolah</h3>
          <p>Dapatkan informasi detail tentang profil sekolah Lokasi, dan kontak dengan mudah. Semua data tersusun rapi dalam satu platform.</p>
        </div>
        <div class="card-icon-area">
          <i class="fas fa-database"></i>
        </div>
      </div>
      <div class="grid-card">
        <div class="card-content">
          <h3>Visualisasi Peta Interaktif</h3>
          <p>Jelajahi lokasi sekolah melalui peta yang mudah dinavigasi. Zoom, filter, dan temukan sekolah sesuai kebutuhan Anda.</p>
        </div>
        <div class="card-icon-area">
          <i class="fas fa-map"></i>
        </div>
      </div>
      <div class="grid-card">
        <div class="card-content">
          <h3>Cari dengan Mudah</h3>
          <p>Gunakan fitur pencarian canggih untuk menemukan sekolah berdasarkan nama, wilayah, jenjang, atau kategori spesifik.</p>
        </div>
        <div class="card-icon-area">
          <i class="fas fa-search"></i>
        </div>
      </div>
      <div class="grid-card">
        <div class="card-content">
          <span class="card-label">Mulai Sekarang</span>
          <h3>Jelajahi Pemetaan Sekolah Digital</h3>
          <p>Temukan sekolah impian Anda dengan sistem pemetaan yang komprehensif untuk seluruh Indonesia.</p>
        </div>
        <div class="card-icon-area">
          <i class="fas fa-rocket"></i>
        </div>
      </div>
    </div>
  </section>
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

  <!-- Map Preview -->