<aside class="w-64 bg-white/90 backdrop-blur-sm border-r border-kf-sky/15 flex flex-col shrink-0">
  <div class="p-6 pb-4">
    <div class="flex flex-col gap-2">
      <div class="sidebar-brand flex items-center justify-start">
        <img src="../../../assets/img/logo_vertikal.png" alt="Logo PILAR" style="width: 80%; height: 100%; object-fit: contain;">
      </div>
      
      <div class="flex items-center">
        <span class="text-[10px] bg-amber-600 text-white px-2.5 py-0.5 rounded font-semibold uppercase tracking-wider shadow-2xs">
          Manager
        </span>
      </div>
    </div>
  </div>
  
  <nav class="flex-1 px-3 space-y-1 mt-4">
    <a href="../dashboard/data.php" class="sidebar-item <?php echo $active_page === 'dashboard' ? 'active-nav' : ''; ?> w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm text-left text-kf-dark"> 
        <i data-lucide="layout-dashboard" class="w-[18px] h-[18px]"></i> Ringkasan Dasbor 
    </a>
    <a href="../tugas/data.php" class="sidebar-item <?php echo $active_page === 'tasks' ? 'active-nav' : ''; ?> w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm text-left text-kf-dark"> 
        <i data-lucide="briefcase" class="w-[18px] h-[18px]"></i> Tugas & Penugasan 
    </a>
    <a href="../chat/data.php" class="sidebar-item <?php echo $active_page === 'chat' ? 'active-nav' : ''; ?> w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm text-left text-kf-dark"> 
        <i data-lucide="message-square" class="w-[18px] h-[18px]"></i> Hub Chat 3-Arah 
    </a>
    <a href="../profil/data.php" class="sidebar-item <?php echo $active_page === 'profile' ? 'active-nav' : ''; ?> w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm text-left text-kf-dark"> 
        <i data-lucide="user-cog" class="w-[18px] h-[18px]"></i> Profil Saya 
    </a>
  </nav>
  
  <div class="p-4 mx-3 mb-4 bg-kf-light rounded-2xl float-anim border border-kf-sky/15">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-500 to-kf-dark flex items-center justify-center text-white text-xs font-bold" id="sidebar-avatar">IS</div>
      <div class="min-w-0">
        <p class="text-xs font-semibold text-kf-dark truncate" id="sidebar-name">Ibu Siska</p>
        <p class="text-[10px] text-kf-muted truncate" id="sidebar-title">Kelistrikan & IT Support</p>
      </div>
    </div>
  </div>
  
  <button onclick="confirmAction('logout')" class="mx-3 mb-4 flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl text-xs text-kf-muted hover:bg-kf-blush/30 hover:text-red-400 transition"> 
    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar 
  </button>
</aside>