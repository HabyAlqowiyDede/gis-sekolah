<?php
$sekolah = $sekolah ?? [];
$usingSampleData = empty($sekolah);
if ($usingSampleData) {
    $sekolah = [
        [
            'id_sekolah' => 1,
            'nama_sekolah' => 'SMAN 1 Jakarta',
            'npsn' => '20100234',
            'nama_kecamatan' => 'Sawah Besar',
            'status' => 'Negeri',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Budi Utomo No.7',
        ],
        [
            'id_sekolah' => 2,
            'nama_sekolah' => 'SMAS Kanisius Jakarta',
            'npsn' => '20100456',
            'nama_kecamatan' => 'Menteng',
            'status' => 'Nagari',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Menteng Raya No.64',
        ],
        [
            'id_sekolah' => 3,
            'nama_sekolah' => 'SMKN 26 Jakarta',
            'npsn' => '20100789',
            'nama_kecamatan' => 'Rawamangun',
            'status' => 'Negeri',
            'akreditasi' => 'B',
            'alamat' => 'Jl. Balai Pustaka Baru No.1',
        ],
        [
            'id_sekolah' => 4,
            'nama_sekolah' => 'SMAS Labschool Jakarta',
            'npsn' => '20100912',
            'nama_kecamatan' => 'Pulo Gadung',
            'status' => 'Nagari',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Pemuda Komplek UNJ',
        ],
        [
            'id_sekolah' => 5,
            'nama_sekolah' => 'SMAN 70 Jakarta',
            'npsn' => '20101034',
            'nama_kecamatan' => 'Kebayoran Baru',
            'status' => 'Negeri',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Bulungan No.1',
        ],
    ];
}

$totalSekolah = count($sekolah);
$jumlahTk = 0;
$jumlahSd = 0;
$jumlahSmp = 0;

foreach ($sekolah as $item) {
    $jenjang = strtolower(trim((string) ($item['jenjang'] ?? $item['nama_jenjang'] ?? '')));

    if ($jenjang === 'tk' || $jenjang === 'taman kanak-kanak' || $jenjang === 'taman kanak kanak') {
        $jumlahTk++;
    } elseif ($jenjang === 'sd' || $jenjang === 'sekolah dasar') {
        $jumlahSd++;
    } elseif ($jenjang === 'smp' || $jenjang === 'sekolah menengah pertama') {
        $jumlahSmp++;
    }
}

$totalDisplay = $usingSampleData ? '14,208' : number_format($totalSekolah, 0, ',', '.');
$jumlahTkDisplay = $usingSampleData ? '1,042' : number_format($jumlahTk, 0, ',', '.');
$jumlahSdDisplay = $usingSampleData ? '7,315' : number_format($jumlahSd, 0, ',', '.');
$jumlahSmpDisplay = $usingSampleData ? '5,851' : number_format($jumlahSmp, 0, ',', '.');
$rows = $sekolah;
?>


<link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root{
    --navy-950:#101c3a;
    --navy-900:#1a3566;
    --navy-800:#254280;
    --blue-700:#2f5bd1;
    --blue-800:#1f47b0;
    --blue-500:#4b8bf5;
    --blue-100:#eaf1ff;
    --sky-50:#f6f9ff;
    --gold-600:#b58a2e;
    --gold-500:#d1aa55;
    --slate-700:#4b5568;
    --slate-500:#6b7488;
    --slate-400:#98a1b3;
    --line:#e4e9f2;
    --paper:#f7f9fd;
    --font-display:'Sora', 'Inter', sans-serif;
    --font-body:'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .landing-wrapper{
    position:relative;
    overflow:visible;
    font-family:var(--font-body);
  }

.landing-bg{
    position:fixed;
    left:0;
    right:0;
    top:0;
    height:40vh;
    pointer-events:none;
    z-index:0;
    display:block;
    opacity:.45;
}

.landing-bg svg{
    width:120%;
    height:100%;
    transform:translateX(-10%);
    filter:blur(46px) saturate(85%);
    opacity:.55;
}

.landing-wrapper > *:not(.landing-bg) {
  position: relative;
  z-index: 2;
}

.landing-wrapper .beranda-hero,
.landing-wrapper .beranda-intro,
.landing-wrapper .beranda-grid-section,
.landing-wrapper .map-preview-card{
  position:relative;
  z-index:1;
}

.school-page{padding-bottom:12px}

.school-page-header{
  margin-bottom:26px;
  display:flex;
  align-items:flex-end;
  justify-content:space-between;
  gap:20px;
  flex-wrap:wrap;
}
.school-page-header .eyebrow{
  display:block;
  font-family:var(--font-body);
  font-size:11px;
  font-weight:700;
  letter-spacing:.16em;
  text-transform:uppercase;
  color:var(--blue-700);
  margin-bottom:8px;
}
.school-page-header h1{
  font-family:var(--font-display);
  font-size:30px;
  line-height:1.15;
  font-weight:800;
  color:var(--navy-950);
  letter-spacing:-.01em;
  margin:0;
}
.school-page-header p{font-size:13.5px;color:var(--slate-500);font-family:var(--font-body);margin:6px 0 0}

/* ===== Stat bar (menyatu, bukan 4 kartu terpisah) ===== */
.school-summary{
  display:flex;
  background:#fff;
  border:1px solid var(--line);
  border-radius:22px;
  padding:8px;
  margin-bottom:28px;
  box-shadow:0 6px 24px rgba(31,71,176,.06);
  flex-wrap:wrap;
}
.school-summary-card{
  flex:1;
  min-width:170px;
  padding:18px 24px;
  display:flex;
  align-items:center;
  gap:16px;
  border-radius:16px;
  transition:background .25s ease;
  position:relative;
}
.school-summary-card:hover{background:var(--sky-50)}
.school-summary-card:not(:last-child)::after{
  content:"";position:absolute;right:0;top:18%;bottom:18%;width:1px;background:var(--line);
}
.summary-icon{width:46px;height:46px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:18px;flex:0 0 46px;background:var(--blue-100);color:var(--blue-800)}
.summary-icon.blue{background:var(--blue-100);color:var(--blue-800)}
.summary-icon.green{background:#eaf7ee;color:#2f9e5c}
.summary-icon.red{background:#fdf1e4;color:var(--gold-600)}
.summary-icon.gray{background:var(--paper);color:var(--slate-500)}
.summary-label{font-family:var(--font-body);font-size:10.5px;font-weight:700;color:var(--slate-500);letter-spacing:.06em;text-transform:uppercase;margin-bottom:4px}
.summary-value{font-family:var(--font-display);font-size:25px;font-weight:800;color:var(--navy-950);line-height:1}

@media(max-width:700px){
  .school-summary-card:not(:last-child)::after{display:none}
}

.school-grid-wrapper{margin-bottom:34px}
.school-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:26px}

.school-card{
  position:relative;
  background:#fff;
  border:1px solid var(--line);
  border-radius:22px;
  overflow:hidden;
  box-shadow:0 4px 18px rgba(16,28,58,.05);
  transition:box-shadow .35s ease, transform .35s ease, border-color .35s ease;
  cursor:pointer;
  display:flex;
  flex-direction:column;
  height:100%;
  text-decoration:none;
  color:inherit;
}
.school-card:hover{box-shadow:0 22px 44px rgba(31,71,176,.16);transform:translateY(-6px);border-color:#d3ddf0}

.school-card-image{width:100%;height:190px;background:var(--paper);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.school-card-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.school-card:hover .school-card-image img{transform:scale(1.07)}
.school-card-image i{color:var(--blue-800);opacity:.25;font-size:44px}
.school-card-image::after{
  content:"";position:absolute;left:0;right:0;bottom:0;height:60%;
  background:linear-gradient(to top, rgba(16,28,58,.55), transparent);
  pointer-events:none;
}
.school-card-image.no-image::after{display:none}

.school-card-badge{
  position:absolute;top:14px;right:14px;z-index:2;
  display:flex;align-items:center;justify-content:center;
  width:42px;height:42px;border-radius:14px;background:#fff;
  font-size:16px;font-weight:800;font-family:var(--font-display);
  color:var(--blue-800);box-shadow:0 6px 16px rgba(16,28,58,.22);
}
.school-card-badge.a{color:var(--blue-800)}
.school-card-badge.b{color:var(--gold-600)}
.school-card-badge.c{color:var(--slate-500)}

.school-card-kecamatan{
  position:absolute;left:14px;bottom:12px;z-index:2;
  font-family:var(--font-body);font-size:11px;font-weight:700;color:#fff;
  background:rgba(255,255,255,.18);backdrop-filter:blur(4px);
  padding:5px 12px;border-radius:999px;letter-spacing:.02em;
  display:flex;align-items:center;gap:6px;
}
.school-card-kecamatan i{font-size:9px}

.school-card-content{padding:20px 20px 22px;display:flex;flex-direction:column;flex:1;gap:8px}
.school-card-status{font-family:var(--font-body);font-size:10.5px;font-weight:700;color:var(--gold-600);text-transform:uppercase;letter-spacing:.09em}
.school-card-name{font-family:var(--font-display);font-size:17px;font-weight:700;color:var(--navy-950);margin:0;line-height:1.35;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;min-height:2.7em}
.school-card-npsn{font-family:var(--font-body);font-size:11.5px;color:var(--slate-500);letter-spacing:.03em}
.school-card-address{display:flex;align-items:flex-start;gap:7px;font-family:var(--font-body);font-size:12px;color:var(--slate-500);line-height:1.55;margin-top:2px;padding-top:12px;border-top:1px solid var(--line)}
.school-card-address i{flex:0 0 13px;margin-top:3px;color:var(--blue-700);font-size:11px}
.school-card-image.no-image{display:flex;align-items:center;justify-content:center;background:var(--paper)}

/* ===== Search / filter ===== */
.school-search-section{background:#fff;border:1px solid var(--line);border-radius:22px;padding:20px;margin-bottom:26px;box-shadow:0 6px 22px rgba(31,71,176,.05)}
.filter-grid{display:flex;flex-direction:column;gap:14px;align-items:stretch}
.col-search{display:flex;gap:10px;align-items:center}
.col-search input{flex:1;height:48px;padding:0 20px;border:1px solid var(--line);border-radius:999px;font-size:14px;font-family:var(--font-body);color:var(--navy-950);background:var(--paper);transition:border-color .2s ease, background .2s ease}
.col-search input:focus{outline:none;border-color:var(--blue-700);background:#fff}
.col-search .btn-search{height:48px;padding:0 28px;flex-shrink:0}
.col-kab{display:none}
.col-kab input{width:100%;height:48px;padding:0 18px;border:1px solid var(--line);border-radius:999px}
.col-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.col-actions .filter-select{height:48px;padding:0 16px;border:1px solid var(--line);border-radius:999px}
.col-actions .filter-buttons{display:flex;gap:8px;background:var(--paper);padding:5px;border-radius:999px}
.col-actions .btn-reset{margin-left:auto}

@media(max-width:900px){
  .school-grid{grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px}
  .filter-grid{grid-template-columns:1fr;gap:10px}
  .col-actions{flex-wrap:wrap}
}

.btn-search{height:48px;padding:0 30px;background:linear-gradient(135deg,var(--blue-500),var(--blue-700));color:#fff;border:none;border-radius:999px;font-size:13.5px;font-weight:700;letter-spacing:.02em;cursor:pointer;transition:all .3s ease;font-family:var(--font-body);box-shadow:0 8px 20px rgba(47,91,209,.28)}
.btn-search:hover{box-shadow:0 10px 24px rgba(47,91,209,.36);transform:translateY(-1px)}
.btn-reset{height:44px;padding:0 20px;border:1px solid var(--line);background:#fff;color:var(--navy-900);border-radius:999px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .25s ease;display:flex;align-items:center;gap:6px;font-family:var(--font-body)}
.btn-reset:hover{background:var(--sky-50);border-color:var(--blue-700);color:var(--blue-700)}
.btn-reset i{font-size:12px}

.filter-input{width:100%;height:48px;padding:0 18px;border:1px solid var(--line);border-radius:999px;font-size:14px;color:var(--navy-950);font-family:var(--font-body)}
.filter-select{width:100%;height:48px;padding:0 16px;border:1px solid var(--line);border-radius:999px;font-size:14px;color:var(--navy-950);font-family:var(--font-body);background:#fff}
.filter-buttons button{height:38px;padding:0 18px;border:none;background:transparent;color:var(--slate-700);border-radius:999px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .25s ease;font-family:var(--font-body)}
.filter-buttons button.active{background:var(--navy-900);color:#fff;box-shadow:0 4px 10px rgba(16,28,58,.22)}
.filter-buttons button:hover{color:var(--blue-700)}
.filter-buttons button.active:hover{color:#fff}

/* ===== Pagination ===== */
.table-note{padding:0 4px;display:flex;align-items:center;justify-content:space-between;gap:16px;color:var(--slate-700);font-size:12.5px;margin-top:24px;padding-top:20px;border-top:1px solid var(--line);font-family:var(--font-body)}
.table-note strong{font-weight:800;color:var(--navy-950)}
.school-pagination{display:flex;align-items:center;gap:6px}
.school-page-link{width:36px;height:36px;border-radius:12px;border:1px solid transparent;background:#fff;color:var(--slate-700);text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;font-family:var(--font-body);transition:all .2s ease}
.school-page-link:hover{background:var(--blue-100);color:var(--blue-800)}
.school-page-link.active{background:var(--navy-900);color:#fff;box-shadow:0 6px 14px rgba(16,28,58,.24)}
.school-page-link.icon{border-color:var(--line);color:var(--slate-400)}

/* ===== Banner ===== */
.accreditation-banner{
  min-height:280px;
  background:linear-gradient(135deg, var(--navy-900) 0%, var(--blue-700) 100%);
  border-radius:28px;
  color:#fff;
  padding:42px 44px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  overflow:hidden;
  margin-top:36px;
  position:relative;
  box-shadow:0 24px 50px rgba(16,28,58,.24);
}
.accreditation-banner::before{
  content:"";position:absolute;top:-70px;right:-70px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.08);
}
.accreditation-banner::after{
  content:"";position:absolute;bottom:-90px;left:20%;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.05);
}
.banner-copy{max-width:360px;font-family:var(--font-body);position:relative;z-index:1}
.banner-icon{width:52px;height:52px;border-radius:16px;background:rgba(255,255,255,.14);display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:28px;color:#fff}
.accreditation-banner h2{font-family:var(--font-display);font-size:25px;font-weight:800;margin-bottom:13px;letter-spacing:-.01em}
.accreditation-banner p{font-size:13.5px;line-height:1.75;color:rgba(255,255,255,.78);margin-bottom:28px}
.akred-dots{display:flex;align-items:center}
.akred-dot{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.28);display:flex;align-items:center;justify-content:center;font-size:12.5px;font-weight:800;margin-left:-9px;font-family:var(--font-display)}
.akred-dot:first-child{margin-left:0;background:#fff;color:var(--blue-700);border-color:#fff}
.banner-next{width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.14);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-size:17px;transition:all .3s ease;position:relative;z-index:1}
.banner-next:hover{background:#fff;color:var(--blue-700);transform:translateX(3px)}

@media(max-width:900px){
  .accreditation-banner{min-height:240px;flex-direction:column;align-items:flex-start;gap:26px;padding:32px}
}
</style>

<div class="landing-wrapper">
  <div class="landing-bg" aria-hidden="true">
    <svg viewBox="0 0 1200 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="g1" x1="0" x2="1">
          <stop offset="0" stop-color="#c7f2ff"/>
          <stop offset="1" stop-color="#93c5fd"/>
        </linearGradient>

        <linearGradient id="g2" x1="0" x2="1">
          <stop offset="0" stop-color="#e0f2fe"/>
          <stop offset="1" stop-color="#60a5fa"/>
        </linearGradient>
      </defs>

      <path d="M0 200 C300 50 900 350 1200 150 L1200 600 L0 600 Z" fill="url(#g1)" opacity="0.55"/>

      <path d="M0 300 C300 150 900 450 1200 250 L1200 600 L0 600 Z" fill="url(#g2)" opacity="0.45"/>

    </svg>
  </div>

  <section class="school-page">
  <header class="school-page-header">
    
  </header>

  <div class="school-summary">
    <div class="school-summary-card">
      <div class="summary-icon green  "><i class="fas fa-school"></i></div>
      <div>
        <div class="summary-label">Jumlah TK</div>
        <div class="summary-value"><?= esc($jumlahTkDisplay) ?></div>
      </div>
    </div>
    <div class="school-summary-card">
      <div class="summary-icon red"><i class="fas fa-school"></i></div>
      <div>
        <div class="summary-label">Jumlah SD</div>
        <div class="summary-value"><?= esc($jumlahSdDisplay) ?></div>
      </div>
    </div>
    <div class="school-summary-card">
      <div class="summary-icon blue"><i class="fas fa-school"></i></div>
      <div>
        <div class="summary-label">Jumlah SMP</div>
        <div class="summary-value"><?= esc($jumlahSmpDisplay) ?></div>
      </div>
    </div>
    <div class="school-summary-card">
      <div class="summary-icon blue"><i class="fas fa-graduation-cap"></i></div>
      <div>
        <div class="summary-label">Total Sekolah</div>
        <div class="summary-value"><?= esc($totalDisplay) ?></div>
      </div>
    </div>
  </div>

  <div class="school-search-section">
    <div class="filter-grid">
      <div class="col col-search">
        <input type="text" id="searchInput" placeholder="Cari nama sekolah" autofocus/>
        <button class="btn-search" onclick="performSearch()"><i class="fas fa-search"></i> Cari</button>
      </div>

      <div class="col col-kab">
        <input type="text" class="filter-input" placeholder="Cari Kabupaten/Kota min 3 huruf" />
      </div>

      <div class="col col-actions">
        <select class="filter-select">
          <option value="">Pilih Bentuk Pendidikan</option>
          <option value="tk">TK (Taman Kanak-kanak)</option>
          <option value="sd">SD (Sekolah Dasar)</option>
          <option value="smp">SMP (Sekolah Menengah Pertama)</option>
        </select>
        <div class="filter-buttons">
          <button class="filter-btn" data-status="all" onclick="filterByStatus(this)">Semua</button>
          <button class="filter-btn" data-status="negeri" onclick="filterByStatus(this)">Negeri</button>
          <button class="filter-btn" data-status="swasta" onclick="filterByStatus(this)">Swasta</button>
        </div>
        <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
      </div>
    </div>
  </div>

  <div class="school-grid-wrapper">
    <div class="school-grid" id="schoolGrid">
      <?php foreach ($rows as $index => $item): ?>
        <?php
          $status = $item['status'] ?? 'Negeri';
          $akreditasi = strtoupper($item['akreditasi'] ?? '-');
          $akreditasiClass = strtolower($akreditasi) === 'a' ? 'a' : (strtolower($akreditasi) === 'b' ? 'b' : 'c');
          $npsn = $item['npsn'] ?? str_pad((string) (20100234 + $index * 111), 8, '0', STR_PAD_LEFT);
          $namaKecamatan = $item['nama_kecamatan'] ?? $item['kecamatan'] ?? $item['id_kecamatan'] ?? '';
          $fotoSekolah = $item['foto_sekolah'] ?? $item['foto'] ?? null;
          $fotoPath = $fotoSekolah ? base_url('foto/' . esc($fotoSekolah)) : null;
          $idSekolah = $item['id_sekolah'] ?? $index;
          // Link ke halaman detail sekolah landing page pengguna
          $detailUrl = base_url('datasekolah/detail/' . $idSekolah);
        ?>
        <a href="<?= $detailUrl ?>" class="school-card" data-school-id="<?= esc($idSekolah) ?>" data-kecamatan="<?= esc($namaKecamatan) ?>">
          <div class="school-card-image <?php if (!$fotoPath) echo 'no-image'; ?>">
            <?php if ($fotoPath): ?>
              <img src="<?= $fotoPath ?>" alt="<?= esc($item['nama_sekolah'] ?? '') ?>">
            <?php else: ?>
              <i class="fas fa-school"></i>
            <?php endif; ?>
            <?php if ($namaKecamatan): ?>
              <span class="school-card-kecamatan"><i class="fas fa-location-dot"></i> <?= esc($namaKecamatan) ?></span>
            <?php endif; ?>
          </div>
          <div class="school-card-badge <?= esc($akreditasiClass) ?>"><?= esc($akreditasi) ?></div>
          <div class="school-card-content">
            <div class="school-card-status"><?= esc($status) ?></div>
            <h3 class="school-card-name"><?= esc($item['nama_sekolah'] ?? '-') ?></h3>
            <div class="school-card-npsn">NPSN : <?= esc($npsn) ?></div>
            <div class="school-card-address">
              <i class="fas fa-map-pin"></i>
              <span><?= esc($item['alamat'] ?? '-') ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="table-note">
    <span>Menampilkan <strong id="resultRange">0-0</strong> dari <strong id="resultTotal">0</strong> entri</span>
    <div class="school-pagination" id="schoolPagination"></div>
  </div>

  <section class="accreditation-banner">
    <div class="banner-copy">
      <div class="banner-icon"><i class="fas fa-magic"></i></div>
      <h2>Statistik Akreditasi</h2>
      <p>Lihat perkembangan kualitas pendidikan nasional melalui dashboard statistik yang komprehensif.</p>
      <div class="akred-dots">    
        <span class="akred-dot">A</span>
        <span class="akred-dot">B</span>
        <span class="akred-dot">C</span>
      </div>
    </div>
    <a href="#" class="banner-next"><i class="fas fa-arrow-right"></i></a>
  </section>
</section>

<script>
let allSchools = [];
let currentFilters = {
  search: '',
  status: 'all',
  bentuk: '',
  kabupaten: ''
};
let currentPage = 1;
const itemsPerPage = 24;

document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('#schoolGrid .school-card');
  allSchools = Array.from(cards).map(card => ({
    element: card,
    name: card.querySelector('.school-card-name')?.textContent || '',
    npsn: card.querySelector('.school-card-npsn')?.textContent || '',
    status: card.querySelector('.school-card-status')?.textContent || '',
    address: card.querySelector('.school-card-address span')?.textContent || ''
  }));

  document.querySelector('[data-status="all"]')?.classList.add('active');

  function debounce(fn, ms) {
    let t;
    return function(...args) {
      clearTimeout(t);
      t = setTimeout(() => fn.apply(this, args), ms);
    };
  }

  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', debounce(function() {
      performSearch();
    }, 250));
    searchInput.addEventListener('keyup', function(e) { if (e.key === 'Enter') performSearch(); });
  }

  const selectFilter = document.querySelector('.filter-select');
  if (selectFilter) {
    selectFilter.addEventListener('change', applyFilters);
  }

  const kabFilter = document.querySelector('.filter-input');
  if (kabFilter) {
    kabFilter.addEventListener('input', debounce(applyFilters, 250));
  }

  applyFilters();
});

function performSearch() {
  const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
  currentFilters.search = searchValue;
  applyFilters();
}

function filterByStatus(element) {
  document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
  element.classList.add('active');

  currentFilters.status = element.dataset.status;
  applyFilters();
}

function getFilteredSchools() {
  return allSchools.filter(school => {
    let show = true;

    if (currentFilters.search) {
      const matches = school.name.toLowerCase().includes(currentFilters.search);
      if (!matches) show = false;
    }

    if (currentFilters.status !== 'all') {
      const schoolStatus = school.status.toLowerCase();
      if (schoolStatus !== currentFilters.status) show = false;
    }

    if (currentFilters.bentuk) {
      const bentukMap = { tk: 'TK', sd: 'SD', smp: 'SMP', sma: 'SMA', smk: 'SMK' };
      const bentukLabel = bentukMap[currentFilters.bentuk] || '';
      const schoolNameUpper = school.name.toUpperCase();
      if (!schoolNameUpper.includes(bentukLabel)) show = false;
    }

    if (currentFilters.kabupaten && currentFilters.kabupaten.length >= 3) {
      if (!school.address.toLowerCase().includes(currentFilters.kabupaten)) show = false;
    }

    return show;
  });
}

function renderPagination(totalPages, activePage) {
  const pagination = document.getElementById('schoolPagination');
  if (!pagination) return;

  pagination.innerHTML = '';

  if (totalPages <= 1) {
    return;
  }

  const createButton = (label, page, isActive = false, isIcon = false, disabled = false) => {
    const btn = document.createElement('a');
    btn.href = '#';
    btn.className = 'school-page-link' + (isActive ? ' active' : '') + (isIcon ? ' icon' : '');
    if (disabled) {
      btn.classList.add('disabled');
      btn.setAttribute('aria-disabled', 'true');
      btn.style.pointerEvents = 'none';
    }
    btn.innerHTML = label;
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      if (!disabled) {
        currentPage = page;
        renderPage();
      }
    });
    pagination.appendChild(btn);
  };

  createButton('<i class="fas fa-chevron-left"></i>', Math.max(1, activePage - 1), false, true, activePage === 1);

  for (let i = 1; i <= totalPages; i++) {
    createButton(i, i, i === activePage);
  }

  createButton('<i class="fas fa-chevron-right"></i>', Math.min(totalPages, activePage + 1), false, true, activePage === totalPages);
}

function renderPage() {
  const filteredSchools = getFilteredSchools();
  const totalPages = Math.max(1, Math.ceil(filteredSchools.length / itemsPerPage));
  currentPage = Math.min(currentPage, totalPages);

  const start = (currentPage - 1) * itemsPerPage;
  const end = start + itemsPerPage;

  allSchools.forEach((school, index) => {
    const isVisible = filteredSchools.includes(school) && index >= start && index < end;
    school.element.style.display = isVisible ? 'flex' : 'none';
  });

  const range = document.getElementById('resultRange');
  const total = document.getElementById('resultTotal');
  if (range && total) {
    if (filteredSchools.length === 0) {
      range.textContent = '0-0';
      total.textContent = '0';
    } else {
      const from = start + 1;
      const to = Math.min(end, filteredSchools.length);
      range.textContent = `${from}-${to}`;
      total.textContent = filteredSchools.length;
    }
  }

  renderPagination(totalPages, currentPage);
}

function applyFilters() {
  currentFilters.search = document.getElementById('searchInput').value.toLowerCase().trim();
  currentFilters.bentuk = document.querySelector('.filter-select').value;
  currentFilters.kabupaten = document.querySelector('.filter-input').value.toLowerCase().trim();
  currentPage = 1;
  renderPage();
}

function resetFilters() {
  document.getElementById('searchInput').value = '';
  document.querySelector('.filter-input').value = '';
  document.querySelector('.filter-select').value = '';

  document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
  document.querySelector('[data-status="all"]').classList.add('active');

  currentFilters = { search: '', status: 'all', bentuk: '', kabupaten: '' };
  currentPage = 1;
  renderPage();
}
</script>
</div>