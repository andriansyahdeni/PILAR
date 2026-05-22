<?php
/**
 * views/pelapor/profil/data.php
 * Screen: Manajemen Akun Profil (Mandiri).
 */
include '../../../koneksi.php';

$active = 'profile';
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya – PILAR</title>

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

<div id="screen-manager-profile" class="screen">
  <div class="app-layout">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/pilar/template/pelapor/sidebar.php'; ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/pilar/template/pelapor/mobile_header.php'; ?>

    <main class="main-content">

      <header style="margin-bottom:1.5rem">
        <h1 class="page-script-title">Manajemen Akun Profil Saya</h1>
      </header>

      <div class="profile-card slide-up">

        <div class="profile-top">
          <div class="profile-avatar-wrap">
            <div class="profile-avatar profile-avatar-el" id="profile-card-photo">TJ</div>
            <label class="profile-cam-btn" title="Ganti foto">
              <i data-lucide="camera" style="width:14px;height:14px"></i>
              <input type="file" accept="image/*" style="display:none"
                     onchange="handleProfilePhotoUpload(event)">
            </label>
          </div>

          <div>
            <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:0.25rem">
              <span class="profile-info-name profile-card-name-el" id="profile-card-name">Taufik Jr</span>
              <span class="profile-badge profile-card-category-el" id="profile-card-category-badge">Mahasiswa</span>
            </div>
            <p class="profile-role-label">
              <i data-lucide="user" style="width:13px;height:13px;color:#f59e0b;display:inline;vertical-align:middle"></i>
              Role = Pelapor
            </p>
            <p class="profile-username profile-card-username-el" id="profile-card-username-label">@taufik_jr</p>
          </div>
        </div>

        <form onsubmit="handleUpdateProfile(event)">

          <div class="form-grid-2">
            <div>
              <label class="form-label">Nama Lengkap</label>
              <input type="text" id="profile-input-name" value="Taufik Jr" required class="form-input-sm">
            </div>
            <div>
              <label class="form-label">Username Aplikasi</label>
              <input type="text" id="profile-input-username" value="taufik_jr" required class="form-input-sm">
            </div>
          </div>

          <div class="form-grid-2">
            <div>
              <label class="form-label">Nomor Telepon / WhatsApp</label>
              <input type="tel" id="profile-input-phone" value="081234567890" required class="form-input-sm">
            </div>
            <div>
              <label class="form-label">Alamat Email</label>
              <input type="email" id="profile-input-email" value="taufik@pens.ac.id" required class="form-input-sm">
            </div>
          </div>

          <div class="form-grid-2">
            <div>
              <label class="form-label">Jabatan / Keahlian</label>
              <input type="text" id="profile-input-title" value="Role = Pelapor"
                     disabled class="form-input-sm">
            </div>
            <div>
              <label class="form-label">Kategori Pengguna</label>
              <select id="profile-input-category" class="form-input-sm">
                <option value="Mahasiswa" selected>Mahasiswa</option>
                <option value="Dosen">Dosen</option>
                <option value="Staff Kampus">Staff Kampus</option>
              </select>
            </div>
          </div>

          <hr class="form-divider">

          <div style="margin-bottom:1rem">
            <label class="form-label">Kata Sandi Baru</label>
            <input type="password" id="profile-input-pass"
                   placeholder="••••••••" class="form-input-sm">
          </div>

          <div style="display:flex;justify-content:flex-end">
            <button type="submit" class="btn-save">Simpan Perubahan Akun</button>
          </div>

        </form>
      </div>

    </main>
  </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/pilar/template/pelapor/modals.php'; ?>

<script src="../../../assets/js/pelapor/app.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // 1. Render Icon Lucide
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    }
    
    // 2. Sinkronisasi data ke card profil (jika fungsi bawaan app.js tersedia)
    if (typeof syncProfileUI === 'function') {
      syncProfileUI();
    }
  });
</script>

</body>
</html>