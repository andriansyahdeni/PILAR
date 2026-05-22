<?php
include '../../../koneksi.php'; // Hubungkan koneksi di paling awal berkas

$active = 'laporan';

// 1. Ambil Semua List Laporan untuk Data Table/Grid Utama (UPDATE: Tambah l.judul_laporan)
$query_laporan = "SELECT l.id_laporan, l.judul_laporan, l.deskripsi, l.tanggal_laporan, l.status, l.foto_sebelum,
                         IFNULL(r.nama_ruangan, 'Belum Diset') AS nama_ruangan, 
                         IFNULL(g.nama_gedung, 'Belum Diset') AS nama_gedung 
                  FROM laporan l
                  LEFT JOIN ruangan r ON l.id_ruangan = r.id_ruangan
                  LEFT JOIN gedung g ON r.id_gedung = g.id_gedung
                  ORDER BY l.id_laporan DESC";
                  
$result = mysqli_query($host, $query_laporan);

$data_javascript = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data_javascript[] = [
            'id'    => (int)$row['id_laporan'],
            'title' => $row['judul_laporan'], // UPDATE: Menggunakan data judul_laporan untuk preview grid card
            'desc'  => $row['deskripsi'],     // Tambahan penampung untuk detail kerusakan jika sewaktu-waktu dibutuhkan
            'loc'   => $row['nama_gedung'] . ' · ' . $row['nama_ruangan'],
            'date'  => date('d M Y', strtotime($row['tanggal_laporan'])),
            'status'=> strtolower($row['status']), 
            'icon'  => 'alert-circle', 
            'image' => $row['foto_sebelum']
        ];
    }
}

// 2. Deklarasi Logika Mode Edit (Wajib sebelum file modals.php dimuat)
$mode_edit = false;
$data_edit = [];

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    
    // Ambil dengan tanda bintang (*) agar semua kolom baru otomatis ikut terbawa masuk ke variabel $data_edit
    $query_edit = mysqli_query($host, "SELECT l.*, g.id_kampus, r.id_gedung 
                                       FROM laporan l
                                       LEFT JOIN ruangan r ON l.id_ruangan = r.id_ruangan
                                       LEFT JOIN gedung g ON r.id_gedung = g.id_gedung 
                                       WHERE l.id_laporan = '$id_edit'");
    
    if ($query_edit && mysqli_num_rows($query_edit) > 0) {
        $mode_edit = true;
        $data_edit = mysqli_fetch_assoc($query_edit);
    }
}
?>

<script>
  window.dbReports = <?php echo json_encode($data_javascript); ?>;
</script>

<!doctype html>
k<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Saya – PILAR</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="../../../assets/css/pelapor/style.css">

  <style>
    html, body {
      overflow: auto !important;
      height: auto !important;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .screen, #screen-dashboard, #screen-laporan, #screen-manager-profile {
      display: block !important;
      opacity: 1 !important;
      visibility: visible !important;
      transform: none !important;
      width: 100%;
      min-height: 100vh;
    }

    /* FIX PERBAIKAN: Taruh di luar media query agar bekerja di HP maupun Laptop/Desktop */
    <?php if ($mode_edit): ?>
    #modal-laporan {
      display: flex !important;
      opacity: 1 !important;
      visibility: visible !important;
      pointer-events: auto !important;
    }
    <?php endif; ?>

    @media (min-width: 769px) {
      html, body {
        overflow: hidden !important;
        height: 100% !important;
      }
      .screen, #screen-dashboard, #screen-laporan, #screen-manager-profile {
        display: flex !important;
      }
      .app-layout {
        display: flex !important;
        width: 100%;
        height: 100vh !important;
        overflow: hidden !important;
      }
      .sidebar {
        display: flex !important;
        flex-direction: column;
        height: 100vh !important;
        position: sticky !important;
        top: 0;
        background: #ffffff !important;
        border-right: 1px solid var(--blush) !important;
      }
      .main-content {
        flex: 1 !important;
        overflow-y: auto !important;
        height: 100vh !important;
        padding: 2rem;
      }
    }

    @media (max-width: 768px) {
      .app-layout {
        display: block !important; 
        width: 100%;
      }
      .sidebar {
        height: 100vh !important;
        position: fixed !important;
        top: 0;
        left: 0;
        z-index: 9999 !important;
        background: #ffffff !important;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      }
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

<div id="screen-laporan" class="screen">
  <div class="app-layout">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/pilar/template/pelapor/sidebar.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/pilar/template/pelapor/mobile_header.php'; ?>

    <main class="main-content">
      <div class="laporan-header">
        <div>
          <h1 class="page-script-title">Laporan Saya</h1>
          <p class="page-sub" style="margin-top:0.25rem">Semua riwayat pengaduan kamu 📋</p>
        </div>
        <button onclick="openModal()" class="btn-primary" style="width:auto;display:flex;align-items:center;gap:0.5rem;white-space:nowrap">
          <i data-lucide="plus-circle" style="width:16px;height:16px"></i>
          Buat Laporan Baru
        </button>
      </div>

      <div class="filter-toolbar">
        <div class="filter-pills" id="filter-bar">
          <?php
          $filters = ['semua' => 'Semua', 'menunggu' => 'Menunggu', 'diverifikasi' => 'Diverifikasi', 'proses' => 'Proses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'];
          foreach ($filters as $key => $label):
            $isActive = $key === 'semua' ? ' active-filter' : '';
          ?>
          <button class="filter-btn<?= $isActive ?>" data-filter="<?= $key ?>" onclick="renderReports('<?= $key ?>')">
            <?= $label ?>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="search-box">
          <i data-lucide="search" style="width:16px;height:16px;color:var(--muted);flex-shrink:0"></i>
          <input type="text" id="report-search-bar" oninput="handleReportSearch()" placeholder="Cari laporan berdasarkan judul...">
        </div>
      </div>

      <div class="report-grid" id="report-grid"></div>
    </main>
  </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/pilar/template/pelapor/modals.php'; ?>

<script src="../../../assets/js/pelapor/app.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    if (typeof renderReports === 'function') { renderReports('semua'); }
  });
</script>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const statusAction = urlParams.get('status');

    if (statusAction === 'sukses_tambah') { showToast('Laporan baru berhasil dikirim! 🎉'); } 
    else if (statusAction === 'gagal_tambah') { showToast('Gagal mengirim laporan, coba lagi! ❌'); } 
    else if (statusAction === 'sukses_update') { showToast('Perubahan laporan berhasil disimpan! 💾'); } 
    else if (statusAction === 'gagal_update') { showToast('Gagal mengubah data laporan! ❌'); } 
    else if (statusAction === 'sukses_hapus') { showToast('Laporan telah berhasil dihapus! 🗑️'); } 
    else if (statusAction === 'gagal_hapus') { showToast('Gagal menghapus data laporan! ❌'); }

    if (statusAction) { window.history.replaceState({}, document.title, window.location.pathname); }
</script>

</body>
</html>