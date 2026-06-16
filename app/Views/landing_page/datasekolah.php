<?php
$sekolah = $sekolah ?? [];
$usingSampleData = empty($sekolah);

if ($usingSampleData) {
    $sekolah = [
        [
            'nama_sekolah' => 'SMAN 1 Jakarta',
            'npsn' => '20100234',
            'nama_kecamatan' => 'Sawah Besar',
            'status' => 'Negeri',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Budi Utomo No.7',
        ],
        [
            'nama_sekolah' => 'SMAS Kanisius Jakarta',
            'npsn' => '20100456',
            'nama_kecamatan' => 'Menteng',
            'status' => 'Nagari',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Menteng Raya No.64',
        ],
        [
            'nama_sekolah' => 'SMKN 26 Jakarta',
            'npsn' => '20100789',
            'nama_kecamatan' => 'Rawamangun',
            'status' => 'Negeri',
            'akreditasi' => 'B',
            'alamat' => 'Jl. Balai Pustaka Baru No.1',
        ],
        [
            'nama_sekolah' => 'SMAS Labschool Jakarta',
            'npsn' => '20100912',
            'nama_kecamatan' => 'Pulo Gadung',
            'status' => 'Nagari',
            'akreditasi' => 'A',
            'alamat' => 'Jl. Pemuda Komplek UNJ',
        ],
        [
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
$akreditasiA = count(array_filter($sekolah, static fn ($item) => strtoupper($item['akreditasi'] ?? '') === 'A'));
$kecamatan = array_filter(array_unique(array_map(static function ($item) {
    return $item['nama_kecamatan'] ?? $item['kecamatan'] ?? $item['id_kecamatan'] ?? '';
}, $sekolah)));
$totalKecamatan = count($kecamatan);
$totalDisplay = $usingSampleData ? '14,208' : number_format($totalSekolah, 0, ',', '.');
$akreditasiDisplay = $usingSampleData ? '8,432' : number_format($akreditasiA, 0, ',', '.');
$kecamatanDisplay = $usingSampleData ? '24' : number_format($totalKecamatan, 0, ',', '.');
$rows = array_slice($sekolah, 0, 5);
?>

<style>
.school-page{padding-bottom:12px}
.school-page-header{margin-bottom:28px}
.school-page-header h1{font-size:31px;line-height:1;font-weight:800;color:#172033;margin-bottom:12px;letter-spacing:0}
.school-page-header p{font-size:13px;color:#596172}

.school-summary{display:grid;grid-template-columns:repeat(3,minmax(190px,284px));gap:24px;margin-bottom:32px}
.school-summary-card{background:#fff;border:1px solid #cfd6e3;border-radius:10px;min-height:102px;padding:24px 26px;display:flex;align-items:center;gap:18px}
.summary-icon{width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex:0 0 38px}
.summary-icon.blue{background:#eef4ff;color:#1146b9}
.summary-icon.green{background:#e9fbf2;color:#0f9f6e}
.summary-icon.gray{background:#f1f3f5;color:#3d4656}
.summary-label{font-size:10px;font-weight:800;color:#283044;letter-spacing:.03em;margin-bottom:3px}
.summary-value{font-size:20px;font-weight:800;color:#172033;line-height:1}

.school-table-card{background:#fff;border:1px solid #cfd6e3;border-radius:10px;overflow:hidden;margin-bottom:32px}
.school-toolbar{height:66px;padding:16px 20px;border-bottom:1px solid #d8deea;display:flex;align-items:center;gap:10px}
.school-search{width:337px;height:36px;border:1px solid #cfd6e3;border-radius:6px;display:flex;align-items:center;gap:10px;padding:0 12px;color:#6b7280;background:#fff}
.school-search i{font-size:12px}
.school-search input{border:0;outline:0;width:100%;font-size:12px;color:#172033;font-family:inherit}
.school-filter,.school-sort{height:36px;border:1px solid #cfd6e3;border-radius:6px;background:#fff;color:#273248;font-family:inherit;font-size:12px;font-weight:700;display:inline-flex;align-items:center;gap:8px;padding:0 14px}
.school-toolbar-spacer{flex:1}
.sort-label{font-size:12px;color:#374151;font-weight:600}
.school-sort{min-width:114px;justify-content:space-between}
.school-table-wrap{overflow-x:auto}
.school-table{width:100%;border-collapse:collapse;min-width:1020px}
.school-table thead{background:#fbfcff}
.school-table th{height:50px;padding:0 22px;text-align:left;border-bottom:1px solid #d8deea;font-size:10px;line-height:1;text-transform:uppercase;letter-spacing:.06em;color:#394150;font-weight:800}
.school-table td{height:72px;padding:0 22px;border-bottom:1px solid #d8deea;font-size:13px;color:#3d4656;vertical-align:middle;white-space:nowrap}
.school-table tbody tr:hover td{background:#f7faff}
.school-name-cell{display:flex;align-items:center;gap:13px;font-weight:800;color:#172033}
.school-mini-icon{width:28px;height:28px;border-radius:8px;background:#edf4ff;color:#1146b9;display:flex;align-items:center;justify-content:center;font-size:13px;flex:0 0 28px}
.status-badge{display:inline-flex;align-items:center;justify-content:center;height:22px;padding:0 10px;border-radius:999px;font-size:10px;font-weight:800}
.status-badge.negeri{background:#e9fbf2;color:#0f805a}
.status-badge.nagari{background:#f2f3f7;color:#636a78}
.school-akred{width:31px;height:20px;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;font-weight:800}
.school-akred.a{background:#0b3fae;color:#fff}
.school-akred.b{background:#dbe7fb;color:#46617f}
.table-note{height:72px;padding:0 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;color:#344054;font-size:12px}
.table-note strong{font-weight:800;color:#172033}
.school-pagination{display:flex;align-items:center;gap:8px}
.school-page-link{width:33px;height:33px;border-radius:8px;border:1px solid transparent;background:#fff;color:#344054;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:600}
.school-page-link.active{background:#1042b4;color:#fff}
.school-page-link.icon{border-color:#d8deea;color:#9aa3b2}

.accreditation-banner{min-height:320px;background:#2849b8;border-radius:10px;color:#fff;padding:34px 36px;display:flex;align-items:center;justify-content:space-between;overflow:hidden}
.banner-copy{max-width:330px}
.banner-icon{width:50px;height:50px;border-radius:12px;background:rgba(255,255,255,.16);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:32px}
.accreditation-banner h2{font-size:22px;font-weight:800;margin-bottom:13px;letter-spacing:0}
.accreditation-banner p{font-size:13px;line-height:1.7;color:rgba(255,255,255,.62);margin-bottom:28px}
.akred-dots{display:flex;align-items:center}
.akred-dot{width:34px;height:34px;border-radius:50%;background:#fff;color:#2849b8;border:2px solid #2849b8;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;margin-left:-7px}
.akred-dot:first-child{margin-left:0}
.banner-next{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-size:18px}

@media(max-width:900px){
  .school-summary{grid-template-columns:1fr}
  .school-toolbar{height:auto;align-items:stretch;flex-wrap:wrap}
  .school-search{width:100%}
  .school-toolbar-spacer{display:none}
  .accreditation-banner{min-height:240px}
}
</style>

<section class="school-page">
  <header class="school-page-header">
    <h1>SEKOLAH</h1>
    <p>Sistem Informasi Geografis dan Manajemen Data Pendidikan Terpusat.</p>
  </header>

  <div class="school-summary">
    <div class="school-summary-card">
      <div class="summary-icon blue"><i class="fas fa-graduation-cap"></i></div>
      <div>
        <div class="summary-label">Total Sekolah</div>
        <div class="summary-value"><?= esc($totalDisplay) ?></div>
      </div>
    </div>
    <div class="school-summary-card">
      <div class="summary-icon green"><i class="fas fa-check-double"></i></div>
      <div>
        <div class="summary-label">Akreditasi A</div>
        <div class="summary-value"><?= esc($akreditasiDisplay) ?></div>
      </div>
    </div>
    <div class="school-summary-card">
      <div class="summary-icon gray"><i class="far fa-map"></i></div>
      <div>
        <div class="summary-label">Kecamatan</div>
        <div class="summary-value"><?= esc($kecamatanDisplay) ?></div>
      </div>
    </div>
  </div>

  <div class="school-table-card">
    <div class="school-toolbar">
      <div class="school-search">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Cari nama sekolah atau NPSN...">
      </div>
      <button type="button" class="school-filter"><i class="fas fa-filter"></i> Filter</button>
      <div class="school-toolbar-spacer"></div>
      <span class="sort-label">Urutkan:</span>
      <button type="button" class="school-sort">Terbaru <i class="fas fa-chevron-down"></i></button>
    </div>

    <div class="school-table-wrap">
      <table class="school-table">
        <thead>
          <tr>
            <th>Nama Sekolah</th>
            <th>NPSN</th>
            <th>Kecamatan</th>
            <th>Status</th>
            <th>Akreditasi</th>
            <th>Alamat</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $index => $item): ?>
            <?php
              $status = $item['status'] ?? 'Negeri';
              $statusClass = strtolower($status) === 'negeri' ? 'negeri' : 'nagari';
              $akreditasi = strtoupper($item['akreditasi'] ?? '-');
              $akreditasiClass = strtolower($akreditasi) === 'a' ? 'a' : 'b';
              $npsn = $item['npsn'] ?? str_pad((string) (20100234 + $index * 111), 8, '0', STR_PAD_LEFT);
              $namaKecamatan = $item['nama_kecamatan'] ?? $item['kecamatan'] ?? $item['id_kecamatan'] ?? '-';
            ?>
            <tr>
              <td>
                <div class="school-name-cell">
                  <span class="school-mini-icon"><i class="fas fa-school"></i></span>
                  <?= esc($item['nama_sekolah'] ?? '-') ?>
                </div>
              </td>
              <td><?= esc($npsn) ?></td>
              <td><?= esc($namaKecamatan) ?></td>
              <td><span class="status-badge <?= esc($statusClass) ?>"><?= esc($status) ?></span></td>
              <td><span class="school-akred <?= esc($akreditasiClass) ?>"><?= esc($akreditasi) ?></span></td>
              <td><?= esc($item['alamat'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="table-note">
      <span>Menampilkan <strong>1-10</strong> dari <strong><?= esc($totalDisplay) ?></strong> entri</span>
      <div class="school-pagination">
        <a href="#" class="school-page-link icon"><i class="fas fa-chevron-left"></i></a>
        <a href="#" class="school-page-link active">1</a>
        <a href="#" class="school-page-link">2</a>
        <a href="#" class="school-page-link">3</a>
        <span class="school-page-link">...</span>
        <a href="#" class="school-page-link">142</a>
        <a href="#" class="school-page-link icon"><i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
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
