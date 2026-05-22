<?php
/**
 * views/pelapor/dashboard/data.php
 * Screen: Dasbor utama (Mandiri).
 */
include '../../../koneksi.php';

$active = 'dashboard';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard – PILAR</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

  <link rel="stylesheet" href="../../../assets/css/pelapor/style.css">

<style>
    /* ==========================================================================
       GLOBAL RESET: Membebaskan kunci scroll dasar
       ========================================================================== */
    html, body {
      overflow: auto !important;
      height: auto !important;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* Paksa semua tipe screen pelapor agar aktif & terlihat */
    .screen, 
    #screen-dashboard, 
    #screen-laporan, 
    #screen-manager-profile {
      display: block !important;
      opacity: 1 !important;
      visibility: visible !important;
      transform: none !important;
      width: 100%;
      min-height: 100vh;
    }

    /* ==========================================================================
       1. MODE DESKTOP / LAYAR LEBAR (Komputer, Laptop, Tablet Gede > 768px)
       ========================================================================== */
    @media (min-width: 769px) {
      html, body {
        overflow: hidden !important; /* Mengunci scroll bar browser utama */
        height: 100% !important;
      }

      .screen, 
      #screen-dashboard, 
      #screen-laporan, 
      #screen-manager-profile {
        display: flex !important; /* Menyusun sidebar & main-content kiri-kanan */
      }

      .app-layout {
        display: flex !important;
        width: 100%;
        height: 100vh !important;
        overflow: hidden !important;
      }

      /* Sidebar kokoh menetap di sebelah kiri */
      .sidebar {
        display: flex !important;
        flex-direction: column;
        height: 100vh !important;
        position: sticky !important;
        top: 0;
        background: #ffffff !important;
        border-right: 1px solid var(--blush) !important;
      }

      /* Hanya area dashboard/konten kanan yang boleh di-scroll */
      .main-content {
        flex: 1 !important;
        overflow-y: auto !important;
        height: 100vh !important;
        padding: 2rem; /* Jarak padding standar desktop */
      }
    }

      /* ==========================================================================
       2. MODE RESPONSIF / LAYAR KECIL (HP & Tablet Kecil <= 768px)
       ========================================================================== */
    @media (max-width: 768px) {
      .app-layout {
        display: block !important; 
        width: 100%;
      }

      /* Modifikasi bagian ini: Jangan kunci mati dengan !important */
      .sidebar {
        /* Secara default di mobile dia tersembunyi lewat sistem style.css aslimu */
        height: 100vh !important;
        position: fixed !important;
        top: 0;
        left: 0;
        z-index: 9999 !important; /* Memastikan menu berada di paling depan di atas blur */
        background: #ffffff !important;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      }

      /* JAGA-JAGA: Jika sistem JS-mu menggunakan class .active untuk memunculkan sidebar */
      .sidebar.active {
        display: flex !important;
      }

      .main-content {
        display: block !important;
        width: 100% !important;
        padding: 1rem !important;
        padding-top: 5rem !important; 
        overflow: visible !important;
      }
    }
  </style>
</head>
<body>

<div id="screen-dashboard" class="screen">
  <div class="app-layout">

    <?php include __DIR__ . '/../../../template/pelapor/sidebar.php'; ?>

    <?php include __DIR__ . '/../../../template/pelapor/mobile_header.php'; ?>

    <main class="main-content">

      <div class="page-header">
        <h1 class="page-title">Hi, <span class="global-profile-name">Taufik Jr</span>! 👋</h1>
        <p class="page-sub">Portal Pengaduan Fasilitas PILAR</p>
      </div>

      <div class="stat-grid">
        <div class="stat-card">
          <div class="stat-icon" style="background:var(--sand)">
            <i data-lucide="clock" style="width:16px;height:16px;color:#f59f00"></i>
          </div>
          <p class="stat-label">Menunggu</p>
          <p class="stat-value count-up" data-target="2">0</p>
        </div>

        <div class="stat-card">
          <div class="stat-icon" style="background:var(--lavender)">
            <i data-lucide="shield-check" style="width:16px;height:16px;color:#7b2d8e"></i>
          </div>
          <p class="stat-label">Diverifikasi</p>
          <p class="stat-value count-up" data-target="1">0</p>
        </div>

        <div class="stat-card">
          <div class="stat-icon" style="background:var(--light)">
            <i data-lucide="loader" style="width:16px;height:16px;color:var(--sky-deep)"></i>
          </div>
          <p class="stat-label">Proses</p>
          <p class="stat-value count-up" data-target="1">0</p>
        </div>

        <div class="stat-card">
          <div class="stat-icon" style="background:var(--mint)">
            <i data-lucide="check-circle" style="width:16px;height:16px;color:#2b8a3e"></i>
          </div>
          <p class="stat-label">Selesai</p>
          <p class="stat-value count-up" data-target="1">0</p>
        </div>

        <div class="stat-card">
          <div class="stat-icon" style="background:var(--blush)">
            <i data-lucide="x-circle" style="width:16px;height:16px;color:#c92a2a"></i>
          </div>
          <p class="stat-label">Ditolak</p>
          <p class="stat-value count-up" data-target="1">0</p>
        </div>
      </div><div class="cta-banner">
        <div class="shrink-0 float-anim" style="flex-shrink:0">
          <svg width="88" height="88" viewBox="0 0 90 90" fill="none">
            <circle cx="45" cy="45" r="40" fill="#FFF3E0" stroke="#FFD6D6" stroke-width="2"/>
            <rect x="28" y="25" width="34" height="40" rx="4" fill="white" stroke="#A5D8FF" stroke-width="2"/>
            <path d="M35 35h20M35 42h15M35 49h18" stroke="#74C0FC" stroke-width="2" stroke-linecap="round"/>
            <circle cx="60" cy="60" r="12" fill="#FFB3B3" stroke="white" stroke-width="3"/>
            <path d="M56 60h8M60 56v8" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="cta-text">
          <p class="cta-title">Kamu Nemu fasilitas kampus yang rusak? Laporin yuk...</p>
          <p class="cta-sub">Bantu kampus jadi lebih baik! 🏫</p>
        </div>
        <button onclick="openModal()"
                class="btn-primary"
                style="flex-shrink:0;width:auto;display:flex;align-items:center;gap:0.5rem;white-space:nowrap">
          <i data-lucide="plus-circle" style="width:16px;height:16px"></i>
          Buat Laporan Baru
        </button>
      </div>

      <h2 class="section-title">Riwayat Pengaduan Terbaru</h2>
      <div id="recent-reports-container"></div>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../../template/pelapor/modals.php'; ?>

<script src="../../../assets/js/pelapor/app.js"></script>

<script>
  lucide.createIcons();
</script>

</body>
</html>