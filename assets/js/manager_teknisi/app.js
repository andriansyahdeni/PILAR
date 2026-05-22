let currentChatReportId = null;
let simulatedPhotoBase64 = "";

// INITIAL DATA MOCK DATABASE
const reports = [
  { id: 2, reporter: 'Andi PENS', title: 'Lampu Koridor Lantai 2 Mati', loc: 'Gedung B · Koridor Lt.2', date: '2026-05-12', status: 'proses', desc: 'Total ada 3 lampu downlight koridor mati total membuat area remang.', note: 'Verifikasi fisik: Lampu korslet terkena rembesan air.', repairPhoto: '' },
  { id: 6, reporter: 'Mega Dosen', title: 'Mikrofon Ruang Kuliah Mati', loc: 'Gedung C · R.405', date: '2026-05-01', status: 'selesai', desc: 'Wireless mic tidak menangkap sinyal receiver sama sekali.', note: 'Diganti dengan mic cadangan inventaris baru oleh Ibu Siska.', repairPhoto: 'https://images.unsplash.com/photo-1590650516494-0c8e4a4dd67e?q=80&w=150&auto=format&fit=crop' },
  { id: 7, reporter: 'Budi Staf', title: 'Korsleting Panel Listrik Server', loc: 'Gedung Terpadu · Lt.3', date: '2026-05-15', status: 'proses', desc: 'Tercium bau hangus dari arah panel sekring utama ruang server lokal.', note: 'Penugasan darurat dari Sarpras.', repairPhoto: '' },
  { id: 8, reporter: 'Rani Mahasiswa', title: 'Koneksi Wi-Fi AP Putus', loc: 'Gedung D4 · Ruang Kelas 202', date: '2026-05-14', status: 'proses', desc: 'Access point berkedip merah dan tidak memancarkan SSID sama sekali.', note: 'Butuh pengecekan PoE Adaptor.', repairPhoto: '' },
  { id: 9, reporter: 'Hasan Laboran', title: 'Instalasi Jaringan LAN Putus', loc: 'Gedung Mekatronika · Lab Jaringan', date: '2026-05-13', status: 'proses', desc: 'Kabel LAN di meja praktikan baris C putus digigit hama/tikus.', note: 'Sediakan kabel Cat6 baru sepanjang 15 meter.', repairPhoto: '' },
  { id: 10, reporter: 'Dedi Dosen', title: 'PC Overheat Ruang Dosen D3', loc: 'Gedung Studi Elektro · R.102', date: '2026-05-10', status: 'selesai', desc: 'Komputer inventaris sering mati mendadak saat rendering materi kuliah.', note: 'Pembersihan heatsink fan dan penggantian thermal pasta selesai.', repairPhoto: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=150&auto=format&fit=crop' },
  { id: 11, reporter: 'Siti Staff', title: 'Stopkontak Keluar Percikan Api', loc: 'Gedung Pascasarjana · Ruang Baca', date: '2026-05-08', status: 'selesai', desc: 'Stopkontak dekat jendela longgar, keluar percikan api saat dicolok charger.', note: 'Penggantian dudukan stopkontak broco baru aman.', repairPhoto: 'https://images.unsplash.com/photo-1620288627223-53302f4e8c74?q=80&w=150&auto=format&fit=crop' }
];

const chatsData = {
  2: [
    { sender: 'Pelapor', name: 'Andi PENS', msg: 'Selamat pagi, lampu koridor lantai 2 Gedung B mati total.', time: '08:00' },
    { sender: 'Admin', name: 'Admin Sarpras', msg: 'Laporan dikonfirmasi sah. Sudah ditugaskan ke @Ibu Siska.', time: '08:15' }
  ],
  6: [
    { sender: 'Pelapor', name: 'Mega Dosen', msg: 'Mic mati saat kuliah tadi pagi mohon dibantu.', time: '09:00' },
    { sender: 'Admin', name: 'Admin Sarpras', msg: 'Tolong ditukar dengan mic baru dari laci logistik utama.', time: '11:00' },
    { sender: 'Teknisi', name: 'Ibu Siska (Manager)', msg: 'PEMBERITAHUAN SELESAI: "Diganti dengan mic cadangan inventaris baru oleh Ibu Siska". Berkas dokumentasi foto terbaru telah diunggah.', time: '13:00' }
  ],
  7: [
    { sender: 'Admin', name: 'Admin Sarpras', msg: 'Mendesak! Tolong dahulukan panel server agar tidak mengganggu aktivitas SIAKAD.', time: '13:00' }
  ],
  8: [], 9: [], 10: [], 11: []
};

const statusMap = {
  proses: { label: 'Dalam Proses', cls: 'status-proses' },
  selesai: { label: 'Selesai', cls: 'status-selesai' },
};

// INITIALIZATION DETECTOR BASED ON PAGE VARIANT
document.addEventListener('DOMContentLoaded', () => {
    // Jalankan render sesuai halaman aktif
    if (currentActivePage === 'dashboard') {
        refreshStatsAndWidgets();
    } else if (currentActivePage === 'tasks') {
        renderManagerTasks();
    } else if (currentActivePage === 'chat') {
        renderManagerChatChannels();
    }
    
    // Paksa jalan sekali lagi di sini
    if (typeof lucide !== 'undefined') lucide.createIcons();
});

// DASHBOARD PERFORMANCE RENDERING (DIUBAH AGAR MENDUKUNG PATTERN DATA-TARGET)
function refreshStatsAndWidgets() {
  const prosesCount = reports.filter(r => r.status === 'proses').length;
  const selesaiCount = reports.filter(r => r.status === 'selesai').length;
  const totalCount = reports.length;

  const elProses = document.getElementById('count-proses');
  const elSelesai = document.getElementById('count-selesai');
  const elTotal = document.getElementById('count-total');

  // Suntikkan hasil kalkulasi array ke atribut data-target sebelum animasi dimulai
  if(elProses) elProses.setAttribute('data-target', prosesCount);
  if(elSelesai) elSelesai.setAttribute('data-target', selesaiCount);
  if(elTotal) elTotal.setAttribute('data-target', totalCount);

  // Jalankan fungsi animasi count up global
  initAllCountUp();

  // Render widget urgent boks di bawahnya
  const urgentBox = document.getElementById('manager-urgent-box');
  if(urgentBox) {
    urgentBox.innerHTML = '';
    const activeTasks = reports.filter(r => r.status === 'proses');
    if(activeTasks.length === 0) {
      urgentBox.innerHTML = `<p class="text-xs text-kf-muted italic text-center py-6">Semua pekerjaan rampung! ✨</p>`;
    } else {
      activeTasks.forEach(t => {
        const div = document.createElement('div');
        div.className = "p-3.5 rounded-2xl bg-kf-light/60 flex items-center justify-between text-xs border border-kf-sky/10";
        div.innerHTML = `<div><span class="text-[9px] bg-blue-100 text-blue-800 px-2 py-0.5 rounded font-bold uppercase mb-1 inline-block">Proses</span><p class="font-bold text-kf-dark">${t.title}</p></div><a href="tasks.php" class="px-3 py-1.5 bg-white border border-kf-sky/30 rounded-xl font-bold text-kf-skyDeep hover:bg-kf-light transition">Tangani</a>`;
        urgentBox.appendChild(div);
      });
    }
  }
}

// Fungsi Utama Count Up Otomatis Berdasarkan Atribut HTML
function initAllCountUp() {
  const elements = document.querySelectorAll('.count-up');
  const duration = 1000; // Durasi animasi 1 detik

  elements.forEach(element => {
    const targetValue = parseInt(element.getAttribute('data-target')) || 0;
    const startValue = 0;
    const startTime = performance.now();

    if (targetValue === 0) {
      element.textContent = 0;
      return;
    }

    function updateCount(currentTime) {
      const elapsedTime = currentTime - startTime;
      const progress = Math.min(elapsedTime / duration, 1);
      const easeProgress = progress * (2 - progress); // Efek melambat (easeOutQuad)

      const currentValue = Math.floor(startValue + (targetValue - startValue) * easeProgress);
      element.textContent = currentValue;

      if (progress < 1) {
        requestAnimationFrame(updateCount);
      } else {
        element.textContent = targetValue;
      }
    }
    requestAnimationFrame(updateCount);
  });
}

// MANAGEMENT LIFECYCLE PAGE
document.addEventListener('DOMContentLoaded', () => {
    if (currentActivePage === 'dashboard') {
        refreshStatsAndWidgets();
    } else if (currentActivePage === 'tasks') {
        renderManagerTasks();
    } else if (currentActivePage === 'chat') {
        renderManagerChatChannels();
    }
    
    if (typeof lucide !== 'undefined') lucide.createIcons();
});

// WORK DESK DATA POPULATOR (TASKS PAGE)
function renderManagerTasks() {
  const activeBox = document.getElementById('manager-active-tasks');
  const finishedBox = document.getElementById('manager-finished-tasks');
  if(!activeBox || !finishedBox) return;

  activeBox.innerHTML = '';
  finishedBox.innerHTML = '';

  const activeTasks = reports.filter(r => r.status === 'proses');
  const finishedTasks = reports.filter(r => r.status === 'selesai');

  if(activeTasks.length === 0) {
    activeBox.innerHTML = `<p class="text-xs text-kf-muted italic text-center py-8">Tidak ada tugas aktif berjalan. 👍</p>`;
  } else {
    activeTasks.forEach(t => {
      const div = document.createElement('div');
      div.className = "bg-white p-5 rounded-2xl border border-kf-sky/20 shadow-sm space-y-3";
      div.innerHTML = `
        <div class="flex justify-between items-start">
          <span class="text-[9px] bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded uppercase">Penugasan Terbuka</span>
          <span class="text-[10px] text-kf-muted">${t.date}</span>
        </div>
        <div>
          <h3 class="text-xs font-bold text-kf-dark">${t.title}</h3>
          <p class="text-[11px] text-kf-muted mt-0.5">📍 ${t.loc}</p>
          <p class="text-[11px] text-kf-dark bg-kf-cream/50 p-2.5 rounded-xl mt-2 border border-dashed">"${t.desc}"</p>
        </div>
        <div class="flex gap-2 pt-1 border-t border-gray-100">
          <button onclick="openFinishModal(${t.id})" class="flex-1 py-2 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl text-[11px] font-bold shadow-sm flex items-center justify-center gap-1 hover:brightness-105 transition"><i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Perbarui & Selesai</button>
          <a href="chat.php" class="px-3 py-2 bg-kf-light text-kf-dark border border-kf-sky/20 rounded-xl text-[11px] font-bold flex items-center justify-center hover:bg-kf-sky/20 transition" title="Buka Chat Hub"><i data-lucide="message-square" class="w-3.5 h-3.5"></i></a>
        </div>
      `;
      activeBox.appendChild(div);
    });
  }

  if(finishedTasks.length === 0) {
    finishedBox.innerHTML = `<p class="text-xs text-kf-muted italic text-center py-8">Belum ada riwayat perbaikan.</p>`;
  } else {
    finishedTasks.forEach(t => {
      const div = document.createElement('div');
      div.className = "bg-kf-light/30 p-4 rounded-2xl border border-gray-200/60 text-xs space-y-2";
      let imgBadge = t.repairPhoto ? `<div class="w-12 h-12 rounded-lg bg-cover bg-center border shrink-0 shadow-xs" style="background-image: url('${t.repairPhoto}')"></div>` : '';
      
      div.innerHTML = `
        <div class="flex justify-between items-center">
          <span class="text-[9px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded uppercase">Selesai</span>
          <span class="text-[10px] text-kf-muted">#PLR-${t.id}</span>
        </div>
        <div class="flex gap-3 items-start">
          ${imgBadge}
          <div class="min-w-0 flex-1">
            <h4 class="font-bold text-kf-dark truncate">${t.title}</h4>
            <p class="text-[10px] text-kf-muted truncate">${t.loc}</p>
            <p class="text-[10px] text-gray-500 italic mt-1 line-clamp-1">Hasil: ${t.note}</p>
          </div>
        </div>
      `;
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
  }
  lucide.createIcons();
}

// MODAL CONTROLLERS
function openFinishModal(id) {
  const t = reports.find(item => item.id === id); if(!t) return;
  document.getElementById('manager-target-id').value = id;
  document.getElementById('manager-note').value = '';
  simulatedPhotoBase64 = "";
  document.getElementById('photo-preview-box').classList.add('hidden');
  document.getElementById('upload-label').textContent = "Klik untuk lampirkan file foto fisik";
  document.getElementById('manager-file-input').value = "";
  
  document.getElementById('manager-modal-info').innerHTML = `<b>Laporan Masalah:</b> ${t.title}<br><b>Lokasi Aset:</b> ${t.loc}`;
  document.getElementById('modal-manager-finish').style.display = 'flex';
  lucide.createIcons();
}

function closeFinishModal() { 
    document.getElementById('modal-manager-finish').style.display = 'none'; 
}

function handleSimulatedPhotoUpload(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      simulatedPhotoBase64 = e.target.result;
      document.getElementById('photo-preview-box').classList.remove('hidden');
      document.getElementById('photo-preview-thumbnail').style.backgroundImage = `url('${e.target.result}')`;
      document.getElementById('upload-label').textContent = "Gambar siap dikirim!";
    }
    reader.readAsDataURL(file);
  }
}

function executeFinishTask(e) {
  e.preventDefault();
  const id = parseInt(document.getElementById('manager-target-id').value);
  const note = document.getElementById('manager-note').value;
  const r = reports.find(item => item.id === id);
  
  if(r) {
    r.status = 'selesai';
    r.repairPhoto = simulatedPhotoBase64 || "https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=150&auto=format&fit=crop";
    r.note = note;

    chatsData[id].push({ 
      sender: 'Teknisi', 
      name: 'Ibu Siska (Manager)', 
      msg: `⚙️ PEMBERITAHUAN SELESAI: "${note}". Berkas dokumentasi foto terbaru sudah diunggah.`, 
      time: 'Baru Saja' 
    });
  }
  closeFinishModal();
  showToast('Laporan selesai diperbarui & dokumen foto terkirim ke sarpras! 🛠️');
  renderManagerTasks();
}

// COORDINATION CHAT HUB SYSTEM
function renderManagerChatChannels() {
  const list = document.getElementById('manager-chat-channels-list'); if(!list) return; list.innerHTML = '';
  reports.forEach(r => {
    const s = statusMap[r.status] || {label: 'Selesai', cls: 'status-selesai'}; 
    const isActive = currentChatReportId === r.id;
    const btn = document.createElement('button'); btn.onclick = () => selectManagerChatChannel(r.id);
    btn.className = `w-full text-left p-3 rounded-2xl border transition ${isActive ? 'bg-white border-amber-500 shadow-xs':'bg-white/40 border-transparent hover:bg-white'}`;
    btn.innerHTML = `<div class="flex justify-between items-start w-full gap-2"><p class="font-bold text-xs text-kf-dark truncate flex-1">${r.title}</p><span class="${s.cls} text-[8px] px-1.5 py-0.5 rounded font-bold">${s.label}</span></div>`;
    list.appendChild(btn);
  });
}

function selectManagerChatChannel(id) {
  currentChatReportId = id; document.getElementById('manager-chat-empty-state').classList.add('hidden');
  const box = document.getElementById('manager-chat-active-box'); box.classList.remove('hidden');
  const r = reports.find(item => item.id === id); if(!r) return;
  
  document.getElementById('manager-chat-box-title').textContent = `Saluran Koordinasi: ${r.title}`;
  document.getElementById('manager-chat-box-participants').textContent = `Anggota Hub: Admin Sarpras · Pelapor (${r.reporter}) · Anda (Manager Teknisi)`;
  
  const currentStatus = statusMap[r.status] || {label: 'Selesai', cls: 'status-selesai'};
  const statusEl = document.getElementById('manager-chat-box-status'); statusEl.textContent = currentStatus.label;
  statusEl.className = `text-[9px] font-bold px-2 py-0.5 rounded-full ${currentStatus.cls}`;
  
  renderManagerChatBoxMessages(); renderManagerChatChannels();
  if (typeof lucide !== 'undefined') {
      lucide.createIcons();
  }
}

function renderManagerChatBoxMessages() {
  const msgContainer = document.getElementById('manager-chat-box-messages-container'); if(!msgContainer) return; msgContainer.innerHTML = '';
  const messages = chatsData[currentChatReportId] || [];
  
  messages.forEach(m => {
    const div = document.createElement('div'); const isMe = m.sender === 'Teknisi'; div.className = isMe ? "flex justify-end" : "flex justify-start";
    let bubbleColor = isMe ? "bg-amber-600 text-white" : (m.sender === 'Admin' ? "bg-kf-dark text-white" : "bg-kf-sky/40 text-kf-dark");
    div.innerHTML = `<div class="${bubbleColor} p-3 rounded-2xl text-xs max-w-[80%] shadow-2xs"><span class="block text-[8px] font-bold opacity-75 uppercase mb-0.5">${m.name}</span><p>${m.msg}</p></div>`;
    msgContainer.appendChild(div);
  });
  msgContainer.scrollTop = msgContainer.scrollHeight;
}

function sendManagerPageChatMessage() {
  const input = document.getElementById('manager-chat-box-input'); const txt = input.value.trim(); if(!txt || !currentChatReportId) return;
  chatsData[currentChatReportId].push({ sender: 'Teknisi', name: 'Ibu Siska', msg: txt, time: 'Sekarang' });
  input.value = ''; renderManagerChatBoxMessages();
}

// PROFILE CONFIG SAVING
function handleUpdateProfile(e) {
  e.preventDefault();
  const newName = document.getElementById('profile-input-name').value;
  const newTitle = document.getElementById('profile-input-title').value;
  
  if(document.getElementById('sidebar-name')) document.getElementById('sidebar-name').textContent = newName;
  if(document.getElementById('sidebar-title')) document.getElementById('sidebar-title').textContent = newTitle;
  if(document.getElementById('profile-card-name')) document.getElementById('profile-card-name').textContent = newName;
  if(document.getElementById('profile-card-role-label')) document.getElementById('profile-card-role-label').textContent = newTitle;
  if(document.getElementById('welcome-heading')) document.getElementById('welcome-heading').textContent = `Hi, ${newName}! 👋`;
  
  const initials = newName.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();
  if(document.getElementById('sidebar-avatar')) document.getElementById('sidebar-avatar').textContent = initials;

  showToast('Informasi Profil Anda Berhasil Disimpan! 📝');
}

// SYSTEM LOGOUT CONFIRM OVERLAYS
function closeConfirm() { 
    document.getElementById('modal-confirm').style.display = 'none'; 
}

function confirmAction(type) {
    const modal = document.getElementById('modal-confirm'); const btn = document.getElementById('confirm-btn-primary');
    if(type === 'logout') {
        document.getElementById('confirm-icon-container').className = "w-14 h-14 mx-auto mb-4 flex items-center justify-center rounded-2xl bg-kf-blush"; 
        document.getElementById('confirm-icon-container').innerHTML = '<i data-lucide="log-out" class="w-6 h-6 text-red-500"></i>';
        document.getElementById('confirm-title').textContent = "Keluar Portal"; 
        btn.textContent = "Keluar Sesi"; 
        btn.className = "w-full py-3 rounded-xl bg-red-500 text-white font-bold text-xs"; 
        btn.onclick = () => { closeConfirm(); showToast('Simulasi Keluar Berhasil!'); };
    }
    modal.style.display = 'flex'; lucide.createIcons();
}

// GLOBAL FLASH MESSAGE NOTIFICATION
function showToast(msg) {
  const t = document.getElementById('toast'); t.textContent = msg; t.style.opacity = '1';
  setTimeout(() => { t.style.opacity = '0'; }, 2500);
}

// =========================================================================
// FITUR TOGGLE SIDEBAR MOBILE (DRAWER)
// =========================================================================
function toggleSidebar() {
  const sidebar = document.querySelector('aside'); 
  const overlay = document.getElementById('sidebar-overlay');

  if (sidebar && overlay) {
    sidebar.classList.toggle('open');
    
    // Toggle status overlay background hitam
    if (overlay.classList.contains('hidden')) {
      overlay.classList.remove('hidden');
      overlay.classList.add('open');
    } else {
      overlay.classList.add('hidden');
      overlay.classList.remove('open');
    }
  }
}