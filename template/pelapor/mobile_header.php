<?php
/**
 * partials/mobile-header.php
 * Fixed top bar shown on mobile (<= 768px).
 * Includes hamburger to open the sidebar drawer.
 */
?>

<!-- =====================  MOBILE HEADER  ===================== -->
<header class="mobile-header">
  <div class="mobile-brand">
    <img src="/pilar/assets/img/logo_vertikal.png" alt="Logo PILAR" style="width: 30%; height: 10%; object-fit: contain;">
  </div>

  <button class="hamburger" onclick="openSidebar()" aria-label="Buka menu">
    <i data-lucide="menu" style="width:20px;height:20px"></i>
  </button>
</header>