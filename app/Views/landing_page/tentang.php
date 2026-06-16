<style>
.tentang-hero{text-align:center;padding:56px 24px 40px;max-width:700px;margin:0 auto 40px}
.tentang-eyebrow{display:inline-block;background:var(--blue-light);color:var(--blue-primary);font-size:11px;font-weight:700;padding:4px 14px;border-radius:20px;margin-bottom:16px;letter-spacing:.07em}
.tentang-hero h1{font-size:32px;font-weight:700;color:var(--text-primary);margin-bottom:12px;line-height:1.25}
.tentang-hero p{font-size:14px;color:var(--text-muted);line-height:1.8}

.tentang-misi{display:flex;gap:40px;align-items:flex-start;background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:36px;margin-bottom:24px;box-shadow:var(--shadow-sm)}
.tentang-misi-text{flex:1}
.tentang-misi-text h2{font-size:20px;font-weight:700;margin-bottom:12px;color:var(--text-primary)}
.tentang-misi-text p{font-size:14px;color:var(--text-muted);line-height:1.8;margin-bottom:12px}
.misi-check{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--blue-primary);margin-top:6px}
.misi-check i{color:var(--blue-primary)}
.tentang-misi-img{flex:0 0 260px;background:var(--blue-light);border-radius:12px;min-height:200px;display:flex;align-items:center;justify-content:center;color:var(--blue-primary);font-size:64px}

.keunggulan-section{margin-bottom:24px}
.keunggulan-section h2{font-size:20px;font-weight:700;margin-bottom:4px;text-align:center}
.keunggulan-section .sub{font-size:13px;color:var(--text-muted);text-align:center;margin-bottom:20px}
.keunggulan-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.keunggulan-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-sm)}
.keunggulan-card .k-icon{width:44px;height:44px;border-radius:10px;background:var(--blue-light);color:var(--blue-primary);display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:12px}
.keunggulan-card h4{font-size:14px;font-weight:700;margin-bottom:6px}
.keunggulan-card p{font-size:13px;color:var(--text-muted);line-height:1.6}

.kontak-section{background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue-accent) 100%);border-radius:var(--radius);padding:40px;color:#fff;display:flex;gap:40px;margin-bottom:24px}
.kontak-text{flex:1}
.kontak-text h2{font-size:22px;font-weight:700;margin-bottom:10px}
.kontak-text p{font-size:14px;opacity:.85;line-height:1.7;margin-bottom:20px}
.kontak-info{display:flex;flex-direction:column;gap:10px}
.kontak-info-item{display:flex;align-items:center;gap:10px;font-size:13px;opacity:.9}
.kontak-info-item i{width:20px;text-align:center;opacity:.7}
.kontak-form{flex:0 0 280px;background:rgba(255,255,255,.1);border-radius:10px;padding:24px;display:flex;flex-direction:column;gap:12px}
.kontak-form input,.kontak-form textarea{
  background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
  border-radius:8px;padding:10px 14px;color:#fff;font-size:13px;outline:none;font-family:inherit;
  width:100%
}
.kontak-form input::placeholder,.kontak-form textarea::placeholder{color:rgba(255,255,255,.6)}
.kontak-form textarea{resize:vertical;min-height:80px}
.btn-kirim{background:#fff;color:var(--blue-primary);border:none;border-radius:8px;padding:10px;font-size:13px;font-weight:700;cursor:pointer;transition:opacity .15s;width:100%}
.btn-kirim:hover{opacity:.9}

.site-footer-full{background:var(--white);border-top:1px solid var(--border);padding:20px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;font-size:12px;color:var(--text-muted)}
.footer-links{display:flex;gap:16px}
.footer-links a{color:var(--text-muted);text-decoration:none}
.footer-links a:hover{color:var(--blue-primary)}

@media(max-width:768px){
  .tentang-misi,.kontak-section{flex-direction:column}
  .keunggulan-grid{grid-template-columns:1fr}
  .tentang-misi-img{min-height:140px}
}
</style>

<!-- Hero -->
<div class="tentang-hero">
  <span class="tentang-eyebrow">TRANSFORMASI DIGITAL PENDIDIKAN</span>
  <h1>Tentang Pemetaan Sekolah</h1>
  <p>Mewujudkan pemetaan kualitas pendidikan nasional melalui visualisasi data geospasial yang akurat, transparan, dan terintegrasi untuk pengambilan keputusan berbasis data yang lebih baik.</p>
</div>

<!-- Misi -->
<div class="tentang-misi">
  <div class="tentang-misi-text">
    <h2>Misi Kami</h2>
    <p>Kami percaya bahwa setiap anak berhak mendapatkan akses pendidikan yang layak, di mana pun mereka berada. Pemetaan Sekolah hadir untuk memperbaharui kesenjangan infrastruktur pendidikan antar wilayah.</p>
    <p>Dengan kemampuan ribuan titik peta pendidikan, kami membantu pemerintah, peneliti, dan masyarakat untuk mengidentifikasi area yang membutuhkan perhatian lebih, mulai dari guru hingga kondisi fisik bangunan sekolah.</p>
    <div class="misi-check"><i class="fas fa-check-circle"></i> Data Terverifikasi Nasional</div>
    <div class="misi-check"><i class="fas fa-check-circle"></i> Aksesibilitas Informasi Publik</div>
  </div>
  <div class="tentang-misi-img"><i class="fas fa-chalkboard-teacher"></i></div>
</div>

<!-- Keunggulan -->
<div class="keunggulan-section">
  <h2>Keunggulan Sistem</h2>
  <p class="sub">Solusi komprehensif untuk tata kelola data pendidikan geospasial.</p>
  <div class="keunggulan-grid">
    <div class="keunggulan-card">
      <div class="k-icon"><i class="fas fa-map-marked-alt"></i></div>
      <h4>Visualisasi Peta Interaktif</h4>
      <p>Kami menyediakan pemetaan dengan filter lengkap berdasarkan jenjang, akreditasi, dan fasilitas sekolah.</p>
    </div>
    <div class="keunggulan-card">
      <div class="k-icon"><i class="fas fa-chart-bar"></i></div>
      <h4>Statistik Real-time</h4>
      <p>Dashboard integrasi data statistik sistem secara otomatis untuk mendukung analisis kebijakan dan rencana pengembangan sekolah.</p>
    </div>
    <div class="keunggulan-card">
      <div class="k-icon"><i class="fas fa-database"></i></div>
      <h4>Manajemen Data Terpadu</h4>
      <p>Sinkronisasi data otomatis dengan basis data pendidikan nasional untuk memastikan akurasi dan validitas. Historis yang disimpan.</p>
    </div>
  </div>
</div>

<!-- Kontak -->
<div class="kontak-section">
  <div class="kontak-text">
    <h2>Butuh Bantuan atau Informasi Lebih Lanjut?</h2>
    <p>Tim dukungan kami siap melayani pertanyaan terkait sistem maupun kerja sama pemetaan wilayah.</p>
    <div class="kontak-info">
      <div class="kontak-info-item"><i class="fas fa-map-marker-alt"></i> Gedung Pendidikan Lt. 4, Jl. Merdeka No. 123, Jakarta Pusat</div>
      <div class="kontak-info-item"><i class="fas fa-envelope"></i> dukungan@pemetaan-sekolah.go.id</div>
      <div class="kontak-info-item"><i class="fas fa-phone"></i> (021) 8888-9999</div>
    </div>
  </div>
  <div class="kontak-form">
    <input type="text" placeholder="Nama Lengkap">
    <input type="email" placeholder="email@mail.com">
    <textarea placeholder="Tulis pesan Anda..."></textarea>
    <button class="btn-kirim">Kirim Pesan</button>
  </div>
</div>
