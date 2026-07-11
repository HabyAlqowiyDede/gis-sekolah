<?php
$school = $sekolah ?? [];
$galeri = $galeri ?? [];
$fotoSekolah = $school['foto_sekolah'] ?? $school['foto'] ?? null;
$fotoPath = $fotoSekolah ? base_url('foto/' . esc($fotoSekolah)) : null;
$akreditasi = strtoupper($school['akreditasi'] ?? '-');
$status = esc($school['status'] ?? '-');
$jenjang = esc($school['jenjang'] ?? '-');
$kabupaten = esc($school['nama_kabupaten'] ?? '-');
$kecamatan = esc($school['nama_kecamatan'] ?? '-');
$nagari = esc($school['nama_nagari'] ?? '-');
$alamat = esc($school['alamat'] ?? '-');
$npsn = esc($school['npsn'] ?? '-');
$jumlahGuru = esc($school['banyak_guru'] ?? $school['jumlah_guru'] ?? '-');
$statusSekolah = esc($school['status_sekolah'] ?? $school['status'] ?? '-');
$kontakAdmin = esc($school['kontak_admin'] ?? '-');
$misi = esc($school['misi'] ?? $school['moto'] ?? 'Membentuk generasi cerdas, berkarakter, dan berdaya saing global berlandaskan iman dan takwa.');
$visi = esc($school['visi'] ?? $school['visi_sekolah'] ?? $school['vision'] ?? 'Visi belum diisi.');
$namaSekolahJs = esc($school['nama_sekolah'] ?? 'Lokasi Sekolah');

// Parse kolom 'coordinat' format "lat,lng" (mis. -0.460000,100.594000)
$coordinatRaw = trim((string) ($school['coordinat'] ?? ''));
$coordinat = str_replace([';', '/', '(', ')'], ',', $coordinatRaw);
$coordinat = preg_replace('/[\s\t\r\n]+/', ' ', $coordinat);
$coordinat = preg_replace('/\s*,\s*/', ',', $coordinat);
$lat = null;
$lng = null;
if ($coordinat !== '' && $coordinat !== '-') {
  if (preg_match('/(-?\d+(?:\.\d+)?)[^0-9-]+(-?\d+(?:\.\d+)?)/', $coordinat, $m)) {
    $lat = (float) $m[1];
    $lng = (float) $m[2];
  } else {
    $parts = array_map('trim', explode(',', $coordinat));
    if (count($parts) >= 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
      $lat = (float) $parts[0];
      $lng = (float) $parts[1];
    }
  }
}
$hasLocation = $lat !== null && $lng !== null;
$markerFile = trim((string) ($school['marker'] ?? ''));
$markerUrl = $markerFile !== '' ? base_url('marker/' . $markerFile) : '';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
<style>
  .landing-wrapper{

    position:relative;

    overflow:visible;

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

    opacity:.35;

}


.landing-bg svg{

    width:120%;

    height:100%;

    transform:translateX(-10%);

    filter:blur(52px) saturate(85%);

    opacity:.5;

}


/* Ensure all direct children (content) sit above the background */
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

    .thumb{
      width:150px;
      height:100px;
      object-fit:cover;
      border-radius:10px;
      cursor:pointer;
      border:3px solid transparent;
      transition:0.25s;
      flex-shrink:0;
  }

  .thumb:hover{
      transform:scale(1.05);
  }

  .thumb.aktif{
      border-color:#0d6efd;
  }
    .galeri-thumbnail { 
      display: flex;
      flex-wrap: wrap;
      /* Boleh turun ke bawah, tumbuh vertikal */
      gap: 12px;
      overflow-x: hidden;
      overflow-y: auto;
      /* Scroll vertikal jika kebanyakan foto */
      padding: 10px 12px;
      flex: 0 0 auto;
      max-height: 220px;

      scrollbar-width: thin;
      /* Firefox */
    }

    .galeri-thumbnail::-webkit-scrollbar {
      width: 8px;
    }

    .galeri-thumbnail::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .galeri-thumbnail::-webkit-scrollbar-thumb {
      background: #0d6efd;
      border-radius: 10px;
    }

    .galeri-thumbnail::-webkit-scrollbar-thumb:hover {
      background: #0b5ed7;
    }

    .thumb {
      width: 150px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
      cursor: pointer;
      flex-shrink: 0;
      /* Supaya ukuran tidak mengecil */
      transition: .3s;
    }

    .thumb:hover {
      transform: scale(1.05);
    }


    .detail-page {
      padding: 32px 0;
      max-width: 1200px;
      margin: 0 auto;
    }

    .detail-header {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 34px;
    }

    .detail-header h1 {
      font-size: 34px;
      font-weight: 800;
      margin: 0;
      color: #0f172a;
      position: relative;
      padding-bottom: 12px;
    }

    .detail-header h1::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 46px;
      height: 4px;
      border-radius: 4px;
      background: #2563eb;
    }

    .detail-header h1::before {
      content: "";
      position: absolute;
      left: 54px;
      bottom: 1px;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #93c5fd;
    }

    .btn-back {
      position: absolute;
      left: 0;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      border-radius: 14px;
      background: #fff;
      color: #0f172a;
      border: 1px solid #e2e8f0;
      text-decoration: none;
      font-weight: 700;
      font-size: 14.5px;
      box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
      transition: background .15s ease;
    }

    .btn-back:hover {
      background: #f8fafc;
      color: #0f172a;
    }

    .btn-back i {
      color: #2563eb;
    }

    .detail-grid {
      display: grid;
      grid-template-columns: 1fr 1.15fr;
      gap: 14px;
      margin-bottom: 24px;
      align-items: stretch;
    }

    /* Card foto + peta (tab switch, memanfaatkan ruang yang sama) */
    .detail-card-image-wrap {
      position: relative;
      border-radius: 24px;
      overflow: hidden;
      height: 640px;
      background: #f1f5f9;
      box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
    }

    .image-tabs {
      position: absolute;
      top: 16px;
      left: 16px;
      z-index: 20;
      display: flex;
      gap: 4px;
      background: rgba(255, 255, 255, .92);
      backdrop-filter: blur(6px);
      padding: 4px;
      border-radius: 999px;
      box-shadow: 0 6px 16px rgba(15, 23, 42, .14);
    }

    .image-tabs button {
      border: none;
      background: transparent;
      padding: 9px 16px;
      border-radius: 999px;
      font-size: 12.5px;
      font-weight: 700;
      color: #475569;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 7px;
      transition: background .15s ease, color .15s ease;
    }

    .image-tabs button i {
      font-size: 12px;
    }

    .image-tabs button.active {
      background: #2563eb;
      color: #fff;
    }

    .image-tabs button:not(.active):hover {
      background: #eef2f7;
    }

    .tab-panel {
      display: none;
      width: 100%;
      height: 100%;
      flex-direction: column;
    }

    .tab-panel.active {
      display: flex;
    }

    .detail-card-image {
      width: 100%;
      flex: 1 1 300px;
      min-height: 300px;
    }

    .detail-card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .detail-card-image.no-image {
      display: grid;
      place-items: center;
      color: #93c5fd;
      font-size: 70px;
    }

    #schoolMap {
      width: 100%;
      flex: 1;
      min-height: 0;
    }

    .map-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 10px;
      flex: 1;
      min-height: 0;
      color: #94a3b8;
      text-align: center;
      padding: 0 24px;
    }

    .map-empty i {
      font-size: 38px;
      color: #cbd5e1;
    }

    .map-empty span {
      font-size: 13.5px;
      font-weight: 600;
    }

    .marker-pin {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: #2563eb;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 14px rgba(37, 99, 235, .45);
      border: 2px solid #fff;
    }

    .marker-pin i {
      color: #fff;
      font-size: 14px;
    }

    .detail-card-info {
      background: #fff;
      border-radius: 24px;
      padding: 34px;
      box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
      display: flex;
      flex-direction: column;
    }

    .detail-badge {
      width: 72px;
      height: 72px;
      border-radius: 18px;
      background: linear-gradient(160deg, #2563eb, #1d4ed8);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #fff;
      margin-bottom: 18px;
      box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
    }

    .detail-badge span.letter {
      font-size: 22px;
      font-weight: 800;
      line-height: 1;
    }

    .detail-badge span.label {
      font-size: 8.5px;
      font-weight: 700;
      letter-spacing: .5px;
      margin-top: 3px;
      opacity: .9;
    }

    .detail-badge.badge-b {
      background: linear-gradient(160deg, #f97316, #ea580c);
      box-shadow: 0 10px 24px rgba(249, 115, 22, 0.35);
    }

    .detail-badge.badge-c {
      background: linear-gradient(160deg, #eab308, #ca8a04);
      box-shadow: 0 10px 24px rgba(234, 179, 8, 0.35);
    }

    .detail-badge.badge-d,
    .detail-badge.badge-\-,
    .detail-badge.badge- {
      background: linear-gradient(160deg, #64748b, #475569);
      box-shadow: 0 10px 24px rgba(100, 116, 139, 0.3);
    }

    .detail-card-info h2 {
      font-size: 30px;
      margin: 0 0 12px;
      color: #0f172a;
      line-height: 1.15;
      font-weight: 800;
    }

    .detail-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 18px;
    }

    .detail-tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      border-radius: 999px;
      background: #eef2f7;
      color: #334155;
      font-size: 13.5px;
      font-weight: 600;
    }

    .detail-tag i {
      color: #2563eb;
      font-size: 13px;
    }

    p.description {
      color: #64748b;
      font-size: 14.5px;
      line-height: 1.8;
      margin-bottom: 24px;
    }

    .detail-meta {
      display: grid;
      grid-template-columns: repeat(2, minmax(140px, 1fr));
      gap: 14px;
      margin-top: auto;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 14px;
      background: #f8fafc;
      border: 1px solid #eef2f7;
      border-radius: 16px;
      padding: 14px 16px;
    }

    .meta-icon {
      flex-shrink: 0;
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: #e8eefc;
      color: #2563eb;
      display: grid;
      place-items: center;
      font-size: 15px;
    }

    .meta-item strong {
      display: block;
      font-size: 12px;
      color: #64748b;
      font-weight: 600;
      margin-bottom: 3px;
    }

    .meta-item span {
      display: block;
      font-size: 15px;
      font-weight: 700;
      color: #111827;
    }

    .meta-item span.status-aktif {
      color: #16a34a;
    }

    .meta-item span.status-aktif::before {
      content: "";
    }

    .detail-bottom {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
    }

    .panel {
      width: 100%;
      background: #fff;
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 18px 50px rgba(15, 23, 42, 0.06);
    }

    .panel-title {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 19px;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 22px;
    }

    .panel-title i {
      color: #2563eb;
      font-size: 17px;
    }

    .detail-location {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .detail-location div {
      background: #f8fafc;
      border: 1px solid #eef2f7;
      border-radius: 16px;
      padding: 18px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .detail-location .loc-icon {
      flex-shrink: 0;
      width: 34px;
      height: 34px;
      border-radius: 10px;
      background: #e8eefc;
      color: #2563eb;
      display: grid;
      place-items: center;
      font-size: 13px;
      margin-top: 2px;
    }

    .detail-location strong {
      display: block;
      font-size: 12px;
      color: #64748b;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .detail-location span {
      display: block;
      font-size: 14.5px;
      color: #0f172a;
      font-weight: 700;
      line-height: 1.55;
    }

    .detail-description p {
      color: #475569;
      font-size: 14.5px;
      line-height: 1.85;
      margin: 0 0 22px;
    }

    .quote-box {
      background: #eef2ff;
      border-radius: 16px;
      margin-bottom: 50px;
      padding: 55px 22px;
    }

    .quote-box p {
      margin: 0;
      color: #2563eb;
      font-style: italic;
      font-weight: 600;
      font-size: 14.5px;
      line-height: 1.7;
    }

    .quote-box i.fa-quote-left {
      color: #93c5fd;
      margin-right: 6px;
    }

    @media (max-width: 960px) {

      .detail-grid,
      .detail-bottom {
        grid-template-columns: 1fr;
      }

      .detail-meta,
      .detail-location {
        grid-template-columns: 1fr;
      }

      .btn-back {
        position: static;
        margin-bottom: 16px;
      }

      .detail-header {
        flex-direction: column;
        align-items: flex-start;
      }
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

  <section class="detail-page">
  <div class="detail-header">
    <a href="<?= base_url('datasekolah') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Sekolah</a>
    <h1>Detail Sekolah</h1>
  </div>
  <div class="detail-grid">
    <div class="detail-card-image-wrap">
      <div class="image-tabs">
        <button type="button" class="active" data-tab="foto"><i class="fas fa-image"></i> Foto Sekolah</button>
        <button type="button" data-tab="peta"><i class="fas fa-location-dot"></i> Peta Lokasi</button>
      </div>

     <div class="tab-panel active" data-panel="foto">

    <!-- Foto Utama -->
    <div class="detail-card-image <?php if (!$fotoPath) echo 'no-image'; ?>">
        <?php if ($fotoPath): ?>
            <img
                id="fotoUtama"
                src="<?= $fotoPath ?>"
                alt="Foto <?= esc($school['nama_sekolah'] ?? 'Sekolah') ?>">
        <?php else: ?>
            <i class="fas fa-school"></i>
        <?php endif; ?>
    </div>

    <!-- Thumbnail -->
    <?php if (!empty($galeri)): ?>
    <div class="galeri-thumbnail">
        <?php $urutanFoto = 0; ?>
        <?php foreach ($galeri as $g): ?>
            <?php $fotoGaleri = $g['foto'] ?? $g['foto_galeri'] ?? null; ?>
            <?php if (!$fotoGaleri) continue; ?>
            <img
                src="<?= base_url('foto/' . esc($fotoGaleri)) ?>"
                alt="Foto galeri <?= esc($school['nama_sekolah'] ?? 'Sekolah') ?> <?= $urutanFoto + 1 ?>"
                class="thumb <?= $urutanFoto === 0 ? 'aktif' : '' ?>"
                onclick="gantiFoto(this)">
            <?php $urutanFoto++; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

      <div class="tab-panel" data-panel="peta">
        <?php if ($hasLocation): ?>
          <div id="schoolMap" data-lat="<?= $lat ?>" data-lng="<?= $lng ?>" data-marker="<?= esc($markerUrl) ?>"></div>
        <?php else: ?>
          <div class="map-empty">
            <i class="fas fa-map-location-dot"></i>
            <span>Lokasi belum diinput oleh operator</span>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="detail-card-info">
      <div class="detail-badge badge-<?= strtolower($akreditasi) ?>">
        <span class="letter"><?= esc($akreditasi) ?></span>
        <span class="label">AKREDITASI</span>
      </div>

      <h2><?= esc($school['nama_sekolah'] ?? '-') ?></h2>

      <div class="detail-tags">
        <span class="detail-tag"><i class="fas fa-graduation-cap"></i> <?= $jenjang ?></span>
        <span class="detail-tag"><i class="fas fa-school"></i> <?= $status ?></span>
      </div>

      <p class="description">Sekolah ini berkomitmen untuk memberikan pendidikan berkualitas dan membentuk generasi yang berkarakter, berprestasi, serta berakhlak mulia. Informasi berikut merupakan data lengkap sekolah yang dapat digunakan sebagai referensi.</p>

      <div class="detail-meta">
        <div class="meta-item">
          <div class="meta-icon"><i class="fas fa-id-card"></i></div>
          <div>
            <strong>NPSN</strong>
            <span><?= $npsn ?></span>
          </div>
        </div>
        <div class="meta-item">
          <div class="meta-icon"><i class="fas fa-school"></i></div>
          <div>
            <strong>Status Sekolah</strong>
            <span class="status-aktif"></i><?= $statusSekolah ?></span>
          </div>
        </div>
        <div class="meta-item">
          <div class="meta-icon"><i class="fas fa-graduation-cap"></i></div>
          <div>
            <strong>Jenjang Pendidikan</strong>
            <span><?= $jenjang ?></span>
          </div>
        </div>
        <div class="meta-item">
          <div class="meta-icon"><i class="fas fa-star"></i></div>
          <div>
            <strong>Akreditasi</strong>
            <span><?= $akreditasi ?></span>
          </div>
        </div>
        <div class="meta-item">
          <div class="meta-icon"><i class="fas fa-phone"></i></div>
          <div>
            <strong>Kontak Admin</strong>
            <span><?= $kontakAdmin ?></span>
          </div>
        </div>
        <div class="meta-item">
          <div class="meta-icon"><i class="fas fa-users"></i></div>
          <div>
            <strong>Jumlah Guru</strong>
            <span>
              <?php if ($jumlahGuru === '-' || $jumlahGuru === '' || $jumlahGuru === null): ?>
                -
              <?php elseif (is_numeric($jumlahGuru)): ?>
                <?= $jumlahGuru ?> Orang
              <?php else: ?>
                <?= esc($jumlahGuru) ?>
              <?php endif; ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="detail-bottom">
    <div class="panel">
      <div class="panel-title"><i class="fas fa-location-dot"></i> Informasi Lokasi</div>
      <div class="detail-location">
        <div>
          <div class="loc-icon"><i class="fas fa-city"></i></div>
          <div>
            <strong>Kabupaten / Kota</strong>
            <span><?= $kabupaten ?></span>
          </div>
        </div>
        <div>
          <div class="loc-icon"><i class="fas fa-map"></i></div>
          <div>
            <strong>Kecamatan</strong>
            <span><?= $kecamatan ?></span>
          </div>
        </div>
        <div>
          <div class="loc-icon"><i class="fas fa-flag"></i></div>
          <div>
            <strong>Nagari / Kelurahan</strong>
            <span><?= $nagari ?></span>
          </div>
        </div>
        <div>
          <div class="loc-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <strong>Alamat Lengkap</strong>
            <span><?= $alamat ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="panel detail-description">
      <div class="quote-box">
        <div class="panel-title"><i class="fas fa-book-open"></i>Visi Sekolah</div>      
        <p><i class="fas fa-quote-left"></i><?= $visi ?>”</p>
      </div>
      <div class="quote-box">
        <div class="panel-title"><i class="fas fa-book-open"></i>Misi Sekolah</div>      
        <p><i class="fas fa-quote-left"></i><?= $misi ?>”</p>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var tabButtons = document.querySelectorAll('.image-tabs button');
    var panels = document.querySelectorAll('.detail-card-image-wrap .tab-panel');
    var leafletMap = null;
    var mapInitialized = false;

    function initSchoolMap() {
      var mapEl = document.getElementById('schoolMap');
      if (!mapEl || typeof L === 'undefined') return;

      var lat = parseFloat(mapEl.getAttribute('data-lat'));
      var lng = parseFloat(mapEl.getAttribute('data-lng'));
      if (isNaN(lat) || isNaN(lng)) return;

      leafletMap = L.map('schoolMap', {
        scrollWheelZoom: false
      }).setView([lat, lng], 16);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
      }).addTo(leafletMap);

      var markerUrl = mapEl.getAttribute('data-marker');
      var schoolIcon;

      if (markerUrl) {
        schoolIcon = L.icon({
          iconUrl: markerUrl,
          iconSize: [40, 40],
          iconAnchor: [20, 40],
          popupAnchor: [0, -40]
        });
      } else {
        schoolIcon = L.divIcon({
          className: 'school-marker',
          html: '<div class="marker-pin"><i class="fas fa-school"></i></div>',
          iconSize: [34, 34],
          iconAnchor: [17, 34]
        });
      }

      L.marker([lat, lng], {
          icon: schoolIcon
        })
        .addTo(leafletMap)
        .bindPopup(<?= json_encode($namaSekolahJs) ?>)
        .openPopup();

      setTimeout(function() {
        leafletMap.invalidateSize();
      }, 150);
    }

    tabButtons.forEach(function(btn) {
      btn.addEventListener('click', function() {
        tabButtons.forEach(function(b) {
          b.classList.remove('active');
        });
        panels.forEach(function(p) {
          p.classList.remove('active');
        });
        this.classList.add('active');

        var target = this.getAttribute('data-tab');
        var targetPanel = document.querySelector('.detail-card-image-wrap .tab-panel[data-panel="' + target + '"]');
        if (targetPanel) targetPanel.classList.add('active');

        if (target === 'peta') {
          if (!mapInitialized) {
            initSchoolMap();
            mapInitialized = true;
          } else if (leafletMap) {
            setTimeout(function() {
              leafletMap.invalidateSize();
            }, 150);
          }
        }
      });
    });

    function createIcon(markerUrl) {
      if (!markerUrl) {
        return L.divIcon({
          className: 'school-marker',
          html: '<div class="marker-pin"><i class="fas fa-school"></i></div>',
          iconSize: [34, 34],
          iconAnchor: [17, 34]
        });
      }

      return L.icon({
        iconUrl: markerUrl,
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
      });
    }
  });
</script>
<script>
function gantiFoto(foto){

    // Ganti foto utama
    document.getElementById('fotoUtama').src = foto.src;

    // Hapus border aktif dari semua thumbnail
    document.querySelectorAll('.thumb').forEach(function(item){
        item.classList.remove('aktif');
    });

    // Tambahkan border ke thumbnail yang dipilih
    foto.classList.add('aktif');

    // Scroll otomatis agar thumbnail yang dipilih selalu terlihat
    foto.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest',
        inline: 'center'
    });
}
</script>
</div>