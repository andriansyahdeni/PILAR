<?php
/**
 * partials/sidebar.php
 * Shared sidebar navigation.
 * Usage: <?php include 'partials/sidebar.php'; ?>
 *
 * @param string $active  One of: 'dashboard' | 'laporan' | 'profile'
 */
$active = $active ?? 'dashboard';

function navItem(string $label, string $icon, string $url, string $current, string $key): string {
    $cls = ($current === $key) ? 'nav-item active' : 'nav-item';
    
    return <<<HTML
    <a href="{$url}" class="{$cls}" style="text-decoration: none; display: flex; align-items: center; gap: 0.75rem; width: 100%; border: none;">
        <i data-lucide="{$icon}"></i>
        <span>{$label}</span>
    </a>
    HTML;
}
?>

<!-- =====================  SIDEBAR  ===================== -->
<aside class="sidebar">

  <!-- Brand -->
  <div class="sidebar-brand">
    <img src="/pilar/assets/img/logo_vertikal.png" alt="Logo PILAR" style="width: 80%; height: 100%; object-fit: contain;">
  </div>

  <!-- Nav -->
  <nav class="sidebar-nav">
    <?= navItem('Dashboard',       'layout-dashboard', '/pilar/views/pelapor/dashboard/data.php',    $active, 'dashboard') ?>
    <?= navItem('Laporan Saya', 'file-text',        '/pilar/views/pelapor/laporan_saya/data.php', $active, 'laporan') ?>
    <?= navItem('Profil Saya',  'user',             '/pilar/views/pelapor/profil/data.php',       $active, 'profile') ?>
  </nav>

  <!-- User card -->
  <div class="sidebar-user float-anim">
    <div class="sidebar-user-inner">
      <div class="avatar global-profile-photo">TJ</div>
      <div style="min-width:0">
        <p class="avatar-name global-profile-name">Taufik Jr</p>
        <p class="avatar-role global-profile-category">Mahasiswa</p>
      </div>
    </div>
  </div>

  <!-- Logout -->
  <button onclick="confirmAction('logout')" class="sidebar-logout">
    <i data-lucide="log-out" style="width:16px;height:16px"></i>
    Keluar
  </button>

</aside>

<!-- Mobile sidebar overlay (tap to close) -->
<div class="sidebar-overlay" onclick="closeSidebar()"></div>