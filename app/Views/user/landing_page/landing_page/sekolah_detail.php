<?php
$school = $sekolah ?? [];
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

    opacity:.95;

}


.landing-bg svg{

    width:120%;

    height:100%;

    transform:translateX(-10%);

    filter:blur(36px) saturate(120%);

    opacity:.95;

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
        <?php foreach ($galeri as $index => $g): ?>
            <img
                src="<?= base_url('foto/' . $g['foto']) ?>"
                class="thumb <?= $index == 0 ? 'aktif' : '' ?>"
                onclick="gantiFoto(this)">
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
}
</script>
</div>