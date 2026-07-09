<?php

$web = $web ?? [];
$wilayah = $wilayah ?? [];
$sekolah = $sekolah ?? [];
$jenjang = $jenjang ?? [];

$jenjangList = [];
$kecamatanList = [];
$markerSekolah = [];

/*
  |--------------------------------------------------------------------------
  | Urutan tombol jenjang yang diinginkan
  |--------------------------------------------------------------------------
  */
$urutanJenjang = ['TK', 'SD', 'SMP', 'SMA', 'SMK'];

/*
  |--------------------------------------------------------------------------
  | Ambil seluruh jenjang dari database sesuai urutan di atas
  |--------------------------------------------------------------------------
  */
foreach ($urutanJenjang as $namaJenjang) {
  foreach ($jenjang as $item) {
    if ($item['jenjang'] == $namaJenjang) {
      $jenjangList[] = $namaJenjang;
    }
  }
}

/*
  |--------------------------------------------------------------------------
  | Ambil data sekolah untuk marker
  |--------------------------------------------------------------------------
  */
foreach ($sekolah as $item) {

  // Ambil koordinat dan normalisasi beberapa format umum yang mungkin masuk
  $coordinat = trim($item['coordinat'] ?? '');
  // Ganti pemisah lain seperti ; atau / dan hapus tanda kurung
  $coordinat = str_replace([';', '/', '(', ')'], ',', $coordinat);
  // Ganti multi-spasi menjadi satu spasi
  $coordinat = preg_replace('/[\s\t\r\n]+/', ' ', $coordinat);
  // Normalisasi koma-spasi
  $coordinat = preg_replace('/\s*,\s*/', ',', $coordinat);

  // Cari dua angka (lat dan lng) terlepas dari pemisah non-angka
  $lat = $lng = null;
  if (preg_match('/(-?\d+(?:\.\d+)?)[^0-9-]+(-?\d+(?:\.\d+)?)/', $coordinat, $m)) {
    $lat = $m[1];
    $lng = $m[2];
  } else {
    // Fallback: coba split dengan koma
    $parts = array_map('trim', explode(',', $coordinat));
    if (count($parts) >= 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
      $lat = $parts[0];
      $lng = $parts[1];
    }
  }

  if ($lat === null || $lng === null) {
    continue;
  }

  $jenjangSekolah = $item['jenjang'] ?? 'Lainnya';
  $kecamatan = $item['nama_kecamatan'] ?? '';

  if ($kecamatan !== '') {
    $kecamatanList[$kecamatan] = $kecamatan;
  }

  $markerSekolah[] = [
    'nama'       => $item['nama_sekolah'] ?? '-',
    'status'     => $item['status'] ?? '-',
    'akreditasi' => $item['akreditasi'] ?? '-',
    'jenjang'    => $jenjangSekolah,
    'alamat'     => $item['alamat'] ?? '-',
    'kecamatan'  => $kecamatan,
    'nagari'     => $item['nama_nagari'] ?? '',
    'lat'        => (float)$lat,
    'lng'        => (float)$lng,
    'marker'     => !empty($item['marker'])
      ? base_url('marker/' . $item['marker'])
      : '',
    'foto'       => !empty($item['foto'])
      ? base_url('foto/' . $item['foto'])
      : '',
  ];
}

ksort($kecamatanList);

$allowedKecamatan = [
  'Padang Ganting' => ['padang ganting', 'padang gantiang', 'kecamatan padang ganting', 'kecamatan padang gantiang'],
  'Tanjung Ameh' => ['tanjung ameh', 'tanjuang ameh', 'kecamatan tanjung ameh', 'kecamatan tanjuang ameh'],
  'Lintau Buo' => ['lintau buo', 'lintau buo', 'kecamatan lintau buo', 'kecamatan lintau buo'],
];
$availableKecamatan = [];
foreach ($wilayah as $item) {
  $namaWilayah = strtolower(trim($item['nama_wilayah'] ?? ''));
  foreach ($allowedKecamatan as $label => $aliases) {
    foreach ($aliases as $alias) {
      if ($alias !== '' && str_contains($namaWilayah, $alias)) {
        $availableKecamatan[] = $label;
        break 2;
      }
    }
  }
}
$availableKecamatan = array_values(array_unique($availableKecamatan));

if (empty($availableKecamatan)) {
  $availableKecamatan = array_keys($allowedKecamatan);
}

?>

<style>
  /* ==========================================================================
      Peta Sekolah — token lokal (modern & minimalist)
      Warna brand tetap memakai var(--blue-primary) dari tema utama agar
      konsisten dengan halaman lain; token baru hanya melengkapi.
      ========================================================================== */
  .peta-wrapper {
    --pj-tk: #16a34a;
    --pj-tk-bg: #ecfdf3;
    --pj-sd: #e11d48;
    --pj-sd-bg: #fef1f3;
    --pj-smp: #2563eb;
    --pj-smp-bg: #eff6ff;
    --pj-sma: #d97706;
    --pj-sma-bg: #fffaeb;
    --pj-smk: #7c3aed;
    --pj-smk-bg: #f5f3ff;
    --pj-ink: #0f172a;
    --pj-muted: #64748b;
    --pj-line: #e5e9f0;
    --pj-surface: #ffffff;
    --pj-surface-2: #f8fafc;
    --pj-radius: 16px;
    --pj-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 12px 28px -12px rgba(15, 23, 42, .16);

    position: relative;
    width: 100%;
    height: calc(100vh - 70px);
    min-height: 620px;
    display: flex;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  #map {
    height: 100%;
    width: 100%;
    background: #eef1f6;
  }

  /* ---------- Panel kiri ---------- */
  .peta-panel {
    position: fixed;
    top: 16px;
    left: 16px;
    z-index: 1030;
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: min(288px, calc(100vw - 32px));
    max-height: calc(100vh - 32px);
    overflow-y: auto;
    scrollbar-width: thin;
  }

  .peta-panel::-webkit-scrollbar {
    width: 6px;
  }

  .peta-panel::-webkit-scrollbar-thumb {
    background: #d6dce5;
    border-radius: 6px;
  }

  .panel-card {
    background: var(--pj-surface);
    border: 1px solid var(--pj-line);
    border-radius: var(--pj-radius);
    padding: 16px;
    box-shadow: var(--pj-shadow);
    animation: pj-rise .35s ease both;
  }

  .peta-panel .panel-card:nth-child(1) {
    animation-delay: .02s;
  }

  .peta-panel .panel-card:nth-child(2) {
    animation-delay: .07s;
  }

  .peta-panel .panel-card:nth-child(3) {
    animation-delay: .12s;
  }

  .peta-panel .panel-card:nth-child(4) {
    animation-delay: .17s;
  }

  @keyframes pj-rise {
    from {
      opacity: 0;
      transform: translateY(6px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .panel-card {
      animation: none;
    }
  }

  .panel-card h6 {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--pj-muted);
    margin: 0 0 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .panel-card h6 a {
    font-size: 11px;
    font-weight: 600;
    color: var(--blue-primary, #2563eb);
    text-transform: none;
    letter-spacing: 0;
    text-decoration: none;
  }

  /* Search */
  .peta-search {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid var(--pj-line);
    border-radius: 10px;
    padding: 9px 12px;
    background: var(--pj-surface-2);
    transition: border-color .15s, background .15s, box-shadow .15s;
  }

  .peta-search:focus-within {
    border-color: var(--blue-primary, #2563eb);
    background: var(--pj-surface);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--blue-primary, #2563eb) 12%, transparent);
  }

  .peta-search i.fa-search {
    color: var(--pj-muted);
    font-size: 12px;
  }

  .peta-search input {
    border: none;
    outline: none;
    font-size: 13px;
    width: 100%;
    background: transparent;
    color: var(--pj-ink);
  }

  .search-clear {
    display: none;
    border: none;
    background: #eef1f6;
    color: var(--pj-muted);
    width: 18px;
    height: 18px;
    border-radius: 50%;
    font-size: 10px;
    line-height: 1;
    cursor: pointer;
    flex-shrink: 0;
  }

  .search-clear.show {
    display: block;
  }

  /* Filters */
  .filter-section {
    margin-bottom: 14px;
  }

  .filter-section:last-child {
    margin-bottom: 0;
  }

  .filter-label {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--pj-ink);
    margin-bottom: 8px;
  }

  .jenjang-btns {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
  }

  .jenjang-btn {
    padding: 6px 13px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid var(--pj-line);
    cursor: pointer;
    background: var(--pj-surface);
    color: var(--pj-muted);
    transition: all .15s ease;
  }

  .jenjang-btn:hover {
    border-color: var(--blue-primary, #2563eb);
    color: var(--pj-ink);
  }

  .jenjang-btn.active {
    background: var(--pj-ink);
    color: #fff;
    border-color: var(--pj-ink);
  }

  .jenjang-btn[data-jenjang="TK"].active {
    background: var(--pj-tk);
    border-color: var(--pj-tk);
  }

  .jenjang-btn[data-jenjang="SD"].active {
    background: var(--pj-sd);
    border-color: var(--pj-sd);
  }

  .jenjang-btn[data-jenjang="SMP"].active {
    background: var(--pj-smp);
    border-color: var(--pj-smp);
  }

  .jenjang-btn[data-jenjang="SMA"].active {
    background: var(--pj-sma);
    border-color: var(--pj-sma);
  }

  .jenjang-btn[data-jenjang="SMK"].active {
    background: var(--pj-smk);
    border-color: var(--pj-smk);
  }

  .kecamatan-select {
    width: 100%;
    border: 1px solid var(--pj-line);
    border-radius: 10px;
    padding: 8px 30px 8px 11px;
    font-size: 13px;
    outline: none;
    background: var(--pj-surface-2) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 8px center / 16px;
    appearance: none;
    color: var(--pj-ink);
    cursor: pointer;
    transition: border-color .15s;
  }

  .kecamatan-select:focus {
    border-color: var(--blue-primary, #2563eb);
  }

  /* Stats */
  .stat-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 9px;
  }

  .stat-row:last-child {
    margin-bottom: 0;
  }

  .stat-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    flex-shrink: 0;
  }

  .stat-label {
    font-size: 12.5px;
    color: var(--pj-ink);
    flex: 1;
  }

  .stat-track {
    flex: 1.4;
    height: 6px;
    background: var(--pj-surface-2);
    border-radius: 6px;
    overflow: hidden;
  }

  .stat-bar {
    height: 100%;
    border-radius: 6px;
    transition: width .4s ease;
  }

  .stat-value {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--pj-ink);
    min-width: 20px;
    text-align: right;
  }

  .stat-total {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    padding-top: 10px;
    margin-top: 10px;
    border-top: 1px dashed var(--pj-line);
  }

  .stat-total .num {
    font-size: 20px;
    font-weight: 800;
    color: var(--pj-ink);
    letter-spacing: -.02em;
  }

  .stat-total .lbl {
    font-size: 11px;
    color: var(--pj-muted);
  }

  /* Legend */
  .legend-item {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 8px;
    font-size: 12.5px;
    color: var(--pj-ink);
  }

  .legend-item:last-child {
    margin-bottom: 0;
  }

  .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
  }

  .dot.tk {
    background: var(--pj-tk);
  }

  .dot.sd {
    background: var(--pj-sd);
  }

  .dot.smp {
    background: var(--pj-smp);
  }

  .dot.sma {
    background: var(--pj-sma);
  }

  .dot.smk {
    background: var(--pj-smk);
  }

  /* ---------- Layer control ---------- */
  .map-layer-control {
    position: fixed;
    top: 16px;
    right: 16px;
    z-index: 1030;
  }

  .map-layer-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 13px;
    border: 1px solid var(--pj-line);
    border-radius: 12px;
    background: var(--pj-surface);
    box-shadow: var(--pj-shadow);
    font-size: 13px;
    font-weight: 600;
    color: var(--pj-ink);
    cursor: pointer;
    transition: box-shadow .15s, border-color .15s;
  }

  .map-layer-toggle:hover {
    border-color: var(--blue-primary, #2563eb);
  }

  .map-layer-toggle i:first-child {
    color: var(--blue-primary, #2563eb);
  }

  .map-layer-toggle .fa-chevron-down {
    font-size: 10px;
    color: var(--pj-muted);
    margin-left: 2px;
    transition: transform .15s;
  }

  .map-layer-toggle.open .fa-chevron-down {
    transform: rotate(180deg);
  }

  .map-layer-dropdown {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-4px) scale(.98);
    transform-origin: top right;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 190px;
    background: var(--pj-surface);
    border: 1px solid var(--pj-line);
    border-radius: 12px;
    padding: 6px;
    box-shadow: var(--pj-shadow);
    overflow: hidden;
    transition: opacity .14s ease, transform .14s ease;
  }

  .map-layer-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
  }

  .map-layer-option {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 10px;
    border: none;
    background: transparent;
    border-radius: 8px;
    text-align: left;
    font-size: 13px;
    color: #334155;
    cursor: pointer;
    transition: background .12s;
  }

  .map-layer-option:hover,
  .map-layer-option.active {
    background: var(--pj-surface-2);
    color: var(--blue-primary, #2563eb);
    font-weight: 600;
  }

  /* ---------- Popup sekolah ---------- */
  .leaflet-popup-content-wrapper {
    border-radius: 14px;
    box-shadow: var(--pj-shadow);
    padding: 0;
  }

  .leaflet-popup-content {
    font-family: 'Inter', sans-serif;
    font-size: 12.5px;
    line-height: 1.5;
    margin: 0;
    width: 232px !important;
  }

  .leaflet-popup-tip {
    box-shadow: none;
  }

  .popup-sekolah {
    min-width: 0;
  }

  .popup-sekolah .popup-photo {
    width: 100%;
    height: 108px;
    object-fit: cover;
    display: block;
  }

  .popup-sekolah .popup-body {
    padding: 13px 14px 14px;
  }

  .popup-sekolah .popup-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .03em;
    text-transform: uppercase;
    padding: 3px 8px;
    border-radius: 999px;
    margin-bottom: 7px;
  }

  .popup-sekolah strong {
    display: block;
    font-size: 13.5px;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--pj-ink);
    line-height: 1.35;
  }

  .popup-sekolah .popup-row {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    color: #475569;
    margin-bottom: 5px;
  }

  .popup-sekolah .popup-row:last-child {
    margin-bottom: 0;
  }

  .popup-sekolah .popup-row i {
    width: 13px;
    margin-top: 2px;
    color: var(--pj-muted);
    font-size: 11px;
    flex-shrink: 0;
  }

  .popup-sekolah .pill {
    display: inline-block;
    font-size: 10.5px;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 6px;
    background: var(--pj-surface-2);
    color: var(--pj-ink);
  }

  /* ---------- Marker default (tanpa foto marker custom) ---------- */
  .default-school-marker {
    width: 26px;
    height: 26px;
    border-radius: 50% 50% 50% 0;
    background: var(--blue-primary, #2563eb);
    border: 2.5px solid #fff;
    transform: rotate(-45deg);
    box-shadow: 0 3px 10px rgba(15, 23, 42, .3);
  }

  .default-school-marker::after {
    content: '';
    position: absolute;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #fff;
    left: 6.5px;
    top: 6.5px;
  }

  /* ---------- Hasil pencarian ---------- */
  .search-results {
    position: fixed;
    top: 16px;
    left: 320px;
    z-index: 1025;
    width: min(340px, calc(100vw - 360px));
    max-height: 70vh;
    overflow: auto;
    display: none;
    border-radius: var(--pj-radius);
    padding: 14px;
    background: var(--pj-surface);
    border: 1px solid var(--pj-line);
    box-shadow: var(--pj-shadow);
    animation: pj-rise .2s ease both;
  }

  .search-results .results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }

  .search-results .results-header h6 {
    margin: 0;
  }

  .search-results .results-header a {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--pj-muted);
    text-decoration: none;
  }

  .search-results .results-header a:hover {
    color: var(--pj-ink);
  }

  .search-results .results-list {
    display: flex;
    flex-direction: column;
    gap: 7px;
  }

  .search-result-item {
    background: var(--pj-surface);
    border-radius: 10px;
    padding: 10px 11px;
    border: 1px solid var(--pj-line);
    cursor: pointer;
    transition: border-color .15s, transform .1s, box-shadow .15s;
  }

  .search-result-item:hover,
  .search-result-item:focus-visible {
    border-color: var(--blue-primary, #2563eb);
    box-shadow: 0 4px 12px -4px rgba(15, 23, 42, .18);
    transform: translateY(-1px);
    outline: none;
  }

  .search-result-item h4 {
    margin: 0;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--pj-ink);
  }

  .search-result-item p {
    margin: 4px 0 0;
    font-size: 12px;
    color: var(--pj-muted);
  }

  .results-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 6px;
    padding: 22px 8px 6px;
    color: var(--pj-muted);
  }

  .results-empty i {
    font-size: 20px;
    color: #cbd5e1;
  }

  .results-empty span {
    font-size: 12.5px;
  }

  /* Tombol lipat panel — hanya tampil di mobile */
  .panel-toggle {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 5;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 999px;
    border: 1px solid var(--pj-line);
    background: var(--pj-surface);
    box-shadow: var(--pj-shadow);
    font-size: 13px;
    font-weight: 600;
    color: var(--pj-ink);
    width: fit-content;
  }

  .panel-toggle i {
    color: var(--blue-primary, #2563eb);
    transition: transform .2s ease;
  }

  .peta-panel.collapsed .panel-toggle i {
    transform: rotate(180deg);
  }

  @media (max-width: 768px) {
    .peta-wrapper {
      height: calc(100dvh - 58px);
      min-height: 560px;
    }

    .peta-panel {
      top: 12px;
      left: 12px;
      right: 12px;
      width: auto;
      max-height: calc(100dvh - 90px);
      padding-top: 52px;
    }

    .panel-toggle {
      display: flex;
    }

    /* Default di mobile: hanya search + filter kelihatan, sisanya disembunyikan */
    .peta-panel.collapsed .panel-card:nth-of-type(n+3) {
      display: none;
    }

    .panel-card {
      padding: 14px;
    }

    /* Target sentuh lebih besar */
    .peta-search {
      padding: 11px 13px;
    }

    .peta-search input {
      font-size: 15px;
    }

    .jenjang-btns {
      overflow-x: auto;
      padding-bottom: 2px;
    }

    .jenjang-btn {
      white-space: nowrap;
      padding: 9px 16px;
      font-size: 13px;
    }

    .kecamatan-select {
      padding: 11px 30px 11px 13px;
      font-size: 14px;
    }

    .search-clear {
      width: 24px;
      height: 24px;
      font-size: 12px;
    }

    .search-results {
      position: static;
      left: auto;
      top: auto;
      margin-top: 8px;
      width: auto;
      display: none;
    }

    .leaflet-popup-content {
      width: min(232px, calc(100vw - 80px)) !important;
    }

    .map-layer-toggle {
      padding: 11px 14px;
    }
  }

  /* ---------- Kontrol zoom (+/-) — dipindah ke kanan bawah ---------- */
  .leaflet-bottom.leaflet-right .leaflet-control-zoom {
    margin: 0 16px 16px 0;
    border: 1px solid var(--pj-line);
    border-radius: 12px;
    box-shadow: var(--pj-shadow);
    overflow: hidden;
  }

  .leaflet-control-zoom a {
    width: 36px !important;
    height: 36px !important;
    line-height: 36px !important;
    background: var(--pj-surface) !important;
    color: var(--pj-ink) !important;
    font-size: 16px !important;
    border: none !important;
  }

  .leaflet-control-zoom a:hover {
    background: var(--pj-surface-2) !important;
    color: var(--blue-primary, #2563eb) !important;
  }

  .leaflet-control-zoom-in {
    border-bottom: 1px solid var(--pj-line) !important;
  }

  @media (max-width: 768px) {
    .leaflet-bottom.leaflet-right .leaflet-control-zoom {
      margin: 0 12px 12px 0;
    }
  }
</style>

<!-- Peta fullscreen -->
<div class="peta-wrapper">

  <!-- Panel kiri -->
  <div class="peta-panel collapsed" id="petaPanel">

    <button type="button" class="panel-toggle" id="panelToggleBtn">
      <i class="fas fa-sliders-h"></i>
      <span id="panelToggleLabel">Filter &amp; Info</span>
    </button>

    <!-- Search -->
    <div class="panel-card">
      <h6>Cari Sekolah</h6>
      <div class="peta-search">
        <i class="fas fa-search"></i>
        <input type="text" id="searchSekolah" placeholder="Nama atau alamat sekolah...">
        <button type="button" class="search-clear" id="searchClear" aria-label="Bersihkan pencarian">✕</button>
      </div>
    </div>

    <!-- Filter -->
    <div class="panel-card">
      <h6>Filter Data</h6>

      <div class="filter-section">
        <div class="filter-label">Jenjang Pendidikan</div>
        <?php $fixedJenjang = ['TK', 'SD', 'SMP']; ?>
        <div class="jenjang-btns">
          <button type="button" class="jenjang-btn active" data-jenjang="">Semua</button>
          <?php foreach ($fixedJenjang as $fj) { ?>
            <button type="button" class="jenjang-btn" data-jenjang="<?= esc($fj) ?>"><?= esc($fj) ?></button>
          <?php } ?>
          <?php foreach ($jenjangList as $j) { ?>
            <?php if (in_array($j, $fixedJenjang)) continue; ?>
            <button type="button" class="jenjang-btn" data-jenjang="<?= esc($j) ?>"><?= esc($j) ?></button>
          <?php } ?>
        </div>
      </div>

      <div class="filter-section">
        <div class="filter-label">Wilayah Kecamatan</div>
        <select class="kecamatan-select" id="filterKecamatan">
          <option value="">Semua Kecamatan</option>
          <?php foreach ($availableKecamatan as $kecamatan) { ?>
            <option value="<?= esc($kecamatan) ?>"><?= esc($kecamatan) ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <!-- Statistik ringkas (mengikuti filter aktif) -->
    <div class="panel-card">
      <h6>Statistik</h6>
      <div id="statsList"></div>
      <div class="stat-total">
        <span class="lbl">Total ditampilkan</span>
        <span class="num" id="statsTotal">0</span>
      </div>
    </div>

    <!-- Legenda -->
    <div class="panel-card">
      <h6>Legenda</h6>
      <div class="legend-item"><span class="dot tk"></span> TK — Taman Kanak-kanak</div>
      <div class="legend-item"><span class="dot sd"></span> SD — Sekolah Dasar</div>
      <div class="legend-item"><span class="dot smp"></span> SMP — Sekolah Menengah Pertama</div>
    </div>

  </div>

  <div class="map-layer-control">
    <button type="button" id="layerToggleBtn" class="map-layer-toggle">
      <i class="fas fa-layer-group"></i>
      <span id="layerButtonLabel">Light</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <div id="layerDropdown" class="map-layer-dropdown" role="menu" aria-label="Pilihan mode peta">
      <button type="button" class="map-layer-option active" data-layer="Light">Light</button>
      <button type="button" class="map-layer-option" data-layer="OpenStreetMap">OpenStreetMap</button>
      <button type="button" class="map-layer-option" data-layer="Satelit">Satelit</button>
    </div>
  </div>

  <!-- Map -->
  <div id="map"></div>
  <!-- Search Results (akan muncul di samping pada layar lebar) -->
  <div id="searchResults" class="search-results" aria-live="polite">
    <div class="results-header">
      <h6>Hasil Pencarian</h6>
      <a href="#" id="closeResults">Tutup</a>
    </div>
    <div class="results-list" id="resultsList"></div>
  </div>
</div>

<script>
  var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  });

  var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri'
  });

  var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
  });

  // Inisialisasi Peta
  const map = L.map('map', {
    center: [<?= $web['coordinat_wilayah'] ?>], // Tanah Datar
    zoom: <?= $web['zoom_view'] ?>,
    layers: [peta1],
    zoomControl: false
  });

  // Tombol zoom (+/-) dipindahkan ke pojok kanan bawah
  L.control.zoom({
    position: 'bottomright'
  }).addTo(map);

  const baseMaps = {
    "Light": peta1,
    "Satelit": peta2,
    "OpenStreetMap": peta3
  };
  // Ambil layer terakhir yang dipilih
  const savedLayer = localStorage.getItem('selectedLayer') || 'Light';

  const layerToggleBtn = document.getElementById('layerToggleBtn');
  const layerButtonLabel = document.getElementById('layerButtonLabel');
  const layerDropdown = document.getElementById('layerDropdown');
  const layerOptions = Array.from(document.querySelectorAll('.map-layer-option'));
  let activeBaseLayer = peta1;

  function setActiveBaseLayer(name) {
    if (!baseMaps[name]) return;

    if (map.hasLayer(activeBaseLayer)) {
        map.removeLayer(activeBaseLayer);
    }

    baseMaps[name].addTo(map);
    activeBaseLayer = baseMaps[name];

    // Simpan pilihan ke browser
    localStorage.setItem('selectedLayer', name);

    layerButtonLabel.textContent = name;

    layerOptions.forEach((option) => {
        option.classList.toggle(
            'active',
            option.dataset.layer === name
        );
    });
}

  layerToggleBtn.addEventListener('click', function(event) {
    event.stopPropagation();
    layerDropdown.classList.toggle('show');
    layerToggleBtn.classList.toggle('open');
  });

  document.addEventListener('click', function() {
    layerDropdown.classList.remove('show');
    layerToggleBtn.classList.remove('open');
  });

  layerOptions.forEach((option) => {
    option.addEventListener('click', function() {
      setActiveBaseLayer(this.getAttribute('data-layer'));
      layerDropdown.classList.remove('show');
      layerToggleBtn.classList.remove('open');
    });
  });

  setActiveBaseLayer(savedLayer);
  var sekolahData = <?= json_encode($markerSekolah, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  var sekolahLayer = L.layerGroup().addTo(map);
  var selectedJenjang = '';

  var jenjangColors = {
    'TK': {
      color: '#16a34a',
      bg: '#ecfdf3',
      dot: 'tk'
    },
    'SD': {
      color: '#e11d48',
      bg: '#fef1f3',
      dot: 'sd'
    },
    'SMP': {
      color: '#2563eb',
      bg: '#eff6ff',
      dot: 'smp'
    },
    'SMA': {
      color: '#d97706',
      bg: '#fffaeb',
      dot: 'sma'
    },
    'SMK': {
      color: '#7c3aed',
      bg: '#f5f3ff',
      dot: 'smk'
    }
  };

  function jenjangStyle(j) {
    return jenjangColors[j] || {
      color: '#64748b',
      bg: '#f1f5f9',
      dot: ''
    };
  }

  function sekolahIcon(markerUrl) {
    if (markerUrl) {
      return L.icon({
        iconUrl: markerUrl,
        iconSize: [34, 42],
        iconAnchor: [17, 42],
        popupAnchor: [0, -38]
      });
    }

    return L.divIcon({
      className: '',
      html: '<div class="default-school-marker"></div>',
      iconSize: [28, 28],
      iconAnchor: [14, 28],
      popupAnchor: [0, -28]
    });
  }

  function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function(char) {
      return {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      } [char];
    });
  }

  function popupSekolah(item) {
    var foto = item.foto ? '<img class="popup-photo" src="' + escapeHtml(item.foto) + '" alt="Foto ' + escapeHtml(item.nama) + '">' : '';
    var style = jenjangStyle(item.jenjang);
    var badge = '<span class="popup-badge" style="color:' + style.color + ';background:' + style.bg + '">' + escapeHtml(item.jenjang) + '</span>';

    return '<div class="popup-sekolah">' +
      foto +
      '<div class="popup-body">' +
      badge +
      '<strong>' + escapeHtml(item.nama) + '</strong>' +
      '<div class="popup-row"><i class="fas fa-map-marker-alt"></i><span>' + escapeHtml(item.alamat) + '</span></div>' +
      '<div class="popup-row"><i class="fas fa-building-columns"></i><span>' + escapeHtml(item.status) + ' &middot; <span class="pill">' + escapeHtml(item.akreditasi) + '</span></span></div>' +
      '</div>' +
      '</div>';
  }

  var kecamatanAliasMap = {
    'Padang Ganting': ['padang ganting', 'padang gantiang', 'kecamatan padang ganting', 'kecamatan padang gantiang'],
    'Tanjung Ameh': ['tanjung ameh', 'tanjuang ameh', 'kecamatan tanjung ameh', 'kecamatan tanjuang ameh'],
    'Lintau Buo Utara': ['lintau buo utara', 'lintau buo', 'kecamatan lintau buo utara', 'kecamatan lintau buo'],
  };

  function kecamatanMatches(value, selectedKecamatan) {
    if (!selectedKecamatan) {
      return true;
    }
    var normalizedValue = (value || '').toLowerCase();
    var aliases = kecamatanAliasMap[selectedKecamatan] || [selectedKecamatan.toLowerCase()];
    return aliases.some(function(alias) {
      return alias && normalizedValue.includes(alias);
    });
  }

  // Perbarui panel statistik ringkas berdasarkan hasil yang sedang tampil
  function renderStats(matches) {
    var counts = {};
    matches.forEach(function(item) {
      counts[item.jenjang] = (counts[item.jenjang] || 0) + 1;
    });

    var order = Object.keys(counts).sort(function(a, b) {
      return counts[b] - counts[a];
    });

    var max = Math.max.apply(null, order.map(function(k) {
      return counts[k];
    }).concat([1]));
    var list = document.getElementById('statsList');
    list.innerHTML = '';

    if (order.length === 0) {
      list.innerHTML = '<div style="font-size:12.5px;color:var(--pj-muted)">Tidak ada data untuk filter ini.</div>';
    }

    order.forEach(function(j) {
      var style = jenjangStyle(j);
      var pct = Math.round((counts[j] / max) * 100);
      var row = document.createElement('div');
      row.className = 'stat-row';
      row.innerHTML =
        '<span class="stat-dot" style="background:' + style.color + '"></span>' +
        '<span class="stat-label">' + escapeHtml(j) + '</span>' +
        '<span class="stat-track"><span class="stat-bar" style="width:' + pct + '%;background:' + style.color + '"></span></span>' +
        '<span class="stat-value">' + counts[j] + '</span>';
      list.appendChild(row);
    });

    document.getElementById('statsTotal').textContent = matches.length;
  }

  function renderSekolahMarkers() {
    var keyword = document.getElementById('searchSekolah').value.toLowerCase();
    var selectedKecamatan = getSelectedKecamatan();

    document.getElementById('searchClear').classList.toggle('show', keyword.length > 0);

    sekolahLayer.clearLayers();

    var matches = [];
    sekolahData.forEach(function(item) {
      var cocokJenjang = !selectedJenjang || item.jenjang === selectedJenjang;
      var cocokKecamatan = kecamatanMatches(item.kecamatan, selectedKecamatan);
      var cocokKeyword = !keyword || item.nama.toLowerCase().includes(keyword) || item.alamat.toLowerCase().includes(keyword);

      if (!cocokJenjang || !cocokKecamatan || !cocokKeyword) {
        return;
      }

      L.marker([item.lat, item.lng], {
        icon: sekolahIcon(item.marker)
      }).bindPopup(popupSekolah(item)).addTo(sekolahLayer);
      matches.push(item);
    });

    // Tampilkan daftar hasil di panel samping hanya saat sedang mencari (maks 20)
    if (keyword) {
      showSearchResults(matches.slice(0, 20));
    } else {
      document.getElementById('searchResults').style.display = 'none';
    }

    renderStats(matches);
    renderWilayahLayers(selectedKecamatan);
  }

  // Render daftar hasil pencarian ke DOM
  function showSearchResults(items) {
    var container = document.getElementById('searchResults');
    var list = document.getElementById('resultsList');
    list.innerHTML = '';

    if (!items || items.length === 0) {
      list.innerHTML = '<div class="results-empty"><i class="fas fa-map-marker-alt"></i><span>Tidak ditemukan sekolah yang cocok.</span></div>';
      container.style.display = 'block';
      return;
    }

    items.forEach(function(item) {
      var el = document.createElement('div');
      el.className = 'search-result-item';
      el.tabIndex = 0;
      el.innerHTML = '<h4>' + escapeHtml(item.nama) + '</h4>' +
        '<p>' + escapeHtml(item.alamat) + ' • ' + escapeHtml(item.jenjang) + '</p>';
      el.addEventListener('click', function() {
        map.setView([item.lat, item.lng], 16);
        L.popup({
          maxWidth: 300
        }).setLatLng([item.lat, item.lng]).setContent(popupSekolah(item)).openOn(map);
      });
      el.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          el.click();
        }
      });
      list.appendChild(el);
    });

    container.style.display = 'block';
  }

  var petaPanel = document.getElementById('petaPanel');
  var panelToggleBtn = document.getElementById('panelToggleBtn');
  var panelToggleLabel = document.getElementById('panelToggleLabel');

  panelToggleBtn.addEventListener('click', function() {
    var collapsed = petaPanel.classList.toggle('collapsed');
    panelToggleLabel.textContent = collapsed ? 'Filter & Info' : 'Sembunyikan';
  });

  document.getElementById('closeResults').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('searchResults').style.display = 'none';
  });

  document.getElementById('searchClear').addEventListener('click', function() {
    var input = document.getElementById('searchSekolah');
    input.value = '';
    input.focus();
    renderSekolahMarkers();
  });

  document.querySelectorAll('.jenjang-btn').forEach(function(button) {
    button.addEventListener('click', function() {
      document.querySelectorAll('.jenjang-btn').forEach(function(item) {
        item.classList.remove('active');
      });

      button.classList.add('active');
      selectedJenjang = button.dataset.jenjang;
      renderSekolahMarkers();
    });
  });

  document.getElementById('searchSekolah').addEventListener('input', renderSekolahMarkers);
  document.getElementById('filterKecamatan').addEventListener('change', renderSekolahMarkers);

  var wilayahData = [];
  var wilayahLayers = {};

  function getSelectedKecamatan() {
    return document.getElementById('filterKecamatan').value;
  }

  function buildWilayahLayer(item) {
    return L.geoJSON(item.geojson, {
      style: {
        color: item.warna,
        fillColor: item.warna,
        fillOpacity: 0.2,
        weight: 2,
        opacity: 0.8
      },
      onEachFeature: function(feature, layer) {
        var namaPopup = '<b>' + escapeHtml(item.nama) + '</b>';
        if (feature.properties) {
          if (feature.properties.nama) {
            namaPopup += '<br>' + escapeHtml(feature.properties.nama);
          }
          if (feature.properties.village) {
            namaPopup += '<br>Desa/Nagari: ' + escapeHtml(feature.properties.village);
          } else if (feature.properties.VILLAGE) {
            namaPopup += '<br>Desa/Nagari: ' + escapeHtml(feature.properties.VILLAGE);
          }
        }
        layer.bindPopup(namaPopup);
      }
    });
  }

  function renderWilayahLayers(selectedKecamatan) {
    Object.values(wilayahLayers).forEach(function(layer) {
        if (map.hasLayer(layer)) {
            map.removeLayer(layer);
        }
    });

    wilayahLayers = [];

    var group = L.featureGroup();

    var showAll = !selectedKecamatan;

    wilayahData.forEach(function(item, index) {
        var cocokWilayah = showAll || kecamatanMatches(item.nama, selectedKecamatan);

        if (cocokWilayah) {
            wilayahLayers[index] = buildWilayahLayer(item).addTo(map);
            group.addLayer(wilayahLayers[index]);
        }
    });

    // Fokus ke tengah semua wilayah
    if (group.getLayers().length > 0) {
        map.fitBounds(group.getBounds(), {
            padding: [40, 40]
        });
    }
}

  <?php foreach ($wilayah as $key => $value) {
    $raw_geojson = $value['geojson'];
    $teks_rusak = '"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}},';
    $clean_geojson = str_replace($teks_rusak, '', $raw_geojson);
    $clean_geojson = preg_replace('/[\r\n\t]+/', ' ', $clean_geojson);
  ?>
    try {
      let geojsonString_<?= $key ?> = `<?= $clean_geojson ?>`;
      wilayahData.push({
        nama: "<?= addslashes($value['nama_wilayah']) ?>",
        geojson: JSON.parse(geojsonString_<?= $key ?>),
        warna: "<?= addslashes($value['warna']) ?>"
      });
    } catch (e) {
      console.error("Gagal memuat wilayah [<?= addslashes($value['nama_wilayah']) ?>]:", e.message);
    }
  <?php } ?>

  // Render initial markers, statistik, dan wilayah layers setelah wilayahData terisi
  renderSekolahMarkers();

  // Fix panels so they stay solid below the top navbar (no scroll repositioning)
  function fixPanelsBelowHeader() {
    var header = document.querySelector('.top-nav') || document.querySelector('header') || document.querySelector('.main-header') || document.querySelector('.navbar');
    var headerBottom = 0;
    if (header) {
      var rect = header.getBoundingClientRect();
      headerBottom = rect.bottom > 0 ? rect.bottom : 0;
    }

    var panel = document.querySelector('.peta-panel');
    if (panel) {
      panel.style.position = 'fixed';
      panel.style.top = (Math.ceil(headerBottom) + 12) + 'px';
      panel.style.left = '16px';
      panel.style.zIndex = 900;
    }

    var results = document.getElementById('searchResults');
    if (results) {
      results.style.position = 'fixed';
      var pr = panel ? panel.getBoundingClientRect() : {
        right: 300
      };
      results.style.left = (Math.ceil(pr.right + 12)) + 'px';
      results.style.top = (Math.ceil(headerBottom) + 12) + 'px';
      results.style.zIndex = 880;
    }

    var layerControl = document.querySelector('.map-layer-control');
    if (layerControl) {
      layerControl.style.position = 'fixed';
      layerControl.style.top = (Math.ceil(headerBottom) + 24) + 'px';
      layerControl.style.right = '16px';
      layerControl.style.zIndex = 900;
    }
  }

  window.addEventListener('load', fixPanelsBelowHeader);
  window.addEventListener('resize', fixPanelsBelowHeader);
  setTimeout(fixPanelsBelowHeader, 60);
</script>