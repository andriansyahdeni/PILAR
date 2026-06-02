/* ============================================================
   PILAR – Main JavaScript (Admin Core Framework Engine)
   ============================================================ */

'use strict';

let currentChatReportId = null;

// CENTRAL REPOSITORY DATABASE REAL TIME SIMULATION
const reports = [
  { id: 1, reporter: 'Taufik Jr', title: 'AC Ruang 301 Tidak Dingin', loc: 'Gedung A · Ruang 301', date: '2026-05-14', status: 'menunggu', desc: 'AC menyala tetapi hanya mengeluarkan angin biasa, bocor air sedikit.', note: '', manager: '' },
  { id: 2, reporter: 'Andi PENS', title: 'Lampu Koridor Lantai 2 Mati', loc: 'Gedung B · Koridor Lt.2', date: '2026-05-12', status: 'proses', desc: 'Total ada 3 lampu downlight koridor mati total membuat area remang.', note: 'Verifikasi fisik: Lampu korslet terkena rembesan air.', manager: 'Ibu Siska (Manager Kelistrikan & IT Support)' },
  { id: 3, reporter: 'Risa Staff', title: 'Kursi Patah di Lab Komputer', loc: 'Gedung A · Lab 201', date: '2026-05-10', status: 'selesai', desc: 'Sandaran kursi patah membahayakan praktikan.', note: 'Laporan valid, disetujui untuk penukaran.', manager: 'Bpk. Budiono (Manager Logistik Inventaris)' },
  { id: 4, reporter: 'Taufik Jr', title: 'Proyektor Error Ruang Seminar', loc: 'Gedung C · R. Seminar', date: '2026-05-08', status: 'diverifikasi', desc: 'Tampilan bergaris warna kuning pekat tidak terbaca.', note: 'Diverifikasi: Masalah pada konektor lensa internal proyektor.', manager: '' },
  { id: 5, reporter: 'Deni Mahasiswa', title: 'Pintu Kamar Mandi Lepas', loc: 'Gedung B · Toilet Lt.3', date: '2026-05-04', status: 'menunggu', desc: 'Engsel bawah pintu besi lapuk lepas, pintu tidak bisa ditutup rapat.', note: '', manager: '' },
  { id: 6, reporter: 'Mega Dosen', title: 'Mikrofon Ruang Kuliah Mati', loc: 'Gedung C · R.405', date: '2026-05-01', status: 'selesai', desc: 'Wireless mic tidak menangkap sinyal receiver sama sekali.', note: 'Diganti dengan mic cadangan inventaris baru.', manager: 'Ibu Siska (Manager Kelistrikan & IT Support)' }
];

const geoLocations = {
  "Kampus PENS A": {
    "Gedung Studi Elektro": ["Ruang Lab Telekomunikasi", "Ruang Kuliah 201", "Ruang Dosen D3"],
    "Gedung Pascasarjana": ["Ruang Seminar Utama", "Ruang Baca 105", "Gedung Zall Aula Teater"]
  },
  "Kampus PENS B": {
    "Gedung Terpadu D4": ["Lab Jaringan Komputer", "Ruang Kelas 302", "Studio Multimedia"],
    "Gedung Mekatronika": ["Lab Robotika Cerdas", "Ruang Workshop Bubut"]
  }
};

const usersMaster = [
  { name: 'Admin Utama Sarpras', email: 'admin@pens.ac.id', role: 'Admin', division: 'Sarana & Prasarana' },
  { name: 'Ibu Siska', email: 'siska@pens.ac.id', role: 'Manager', division: 'Manager Kelistrikan & IT Support' },
  { name: 'Bpk. Budiono', email: 'budiono@pens.ac.id', role: 'Manager', division: 'Manager Logistik Inventaris' },
  { name: 'Bpk. Hermawan', email: 'hermawan@pens.ac.id', role: 'Manager', division: 'Manager Infrastruktur Sipil' },
  { name: 'Andi Fauzan', email: 'fauzan@pens.ac.id', role: 'Admin', division: 'Staff Pengadaan Gedung' }
];

const chatsData = {
  1: [{ sender: 'Pelapor', name: 'Taufik Jr', msg: 'Mohon dicek AC di kelas 301 Gedung A, hawanya panas sekali kelasnya.', time: '10:15' }],
  2: [{ sender: 'Pelapor', name: 'Andi PENS', msg: 'Selamat pagi, lampu koridor lantai 2 Gedung B mati total.', time: '08:00' }],
  3: [], 4: [], 5: [], 6: []
};

const statusMap = {
  menunggu: { label: 'Menunggu', cls: 'status-menunggu' },
  proses: { label: 'Dalam Proses', cls: 'status-proses' },
  selesai: { label: 'Selesai', cls: 'status-selesai' },
  ditolak: { label: 'Ditolak', cls: 'status-ditolak' },
  diverifikasi: { label: 'Diverifikasi', cls: 'status-diverifikasi' },
};

/* ---- Mobile Sidebar Drawer Engine ---- */
function openSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.querySelector('.sidebar-overlay');
  
  if (sidebar) sidebar.classList.add('open');
  if (overlay) overlay.classList.add('open');
}

function closeSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.querySelector('.sidebar-overlay');
  
  if (sidebar) sidebar.classList.remove('open');
  if (overlay) overlay.classList.remove('open');
}

/* ---- Standardized Automatic Count Up Engine ---- */
function triggerCountUp() {
  document.querySelectorAll('.count-up').forEach(counter => {
    counter.textContent = '0';
    const target = +counter.getAttribute('data-target');
    if (!target) return;
    let current = 0;
    const step = Math.max(Math.floor(400 / target), 40);
    const timer = setInterval(() => {
      current++;
      counter.textContent = current;
      if (current >= target) clearInterval(timer);
    }, step);
  });
}

function updateCounterBadges() {
  const count = (status) => reports.filter(r => r.status === status).length;
  
  // Suntik target angka ke dalam elemen counter badge sebelum memicu animasi interval
  const badgeMap = {
    '.total-menunggu': count('menunggu'),
    '.total-diverifikasi': count('diverifikasi'),
    '.total-proses': count('proses'),
    '.total-selesai': count('selesai'),
    '.total-ditolak': count('ditolak')
  };

  Object.keys(badgeMap).forEach(selector => {
    document.querySelectorAll(selector).forEach(el => {
        el.setAttribute('data-target', badgeMap[selector]);
    });
  });
}

/* ---- Modul 1: Dashboard Urgent Boxes ---- */
function renderAdminDashboardWidgets() {
  updateCounterBadges();
  setTimeout(triggerCountUp, 100);

  const container = document.getElementById('admin-urgent-box'); if(!container) return; container.innerHTML = '';
  const urgent = reports.filter(r => r.status === 'menunggu' || r.status === 'diverifikasi');
  
  if(urgent.length === 0) {
    container.innerHTML = `<p class="text-xs text-kf-muted italic text-center py-6">Semua antrean aman terproses! ✨</p>`; return;
  }
  urgent.forEach(r => {
    const isWaiting = r.status === 'menunggu';
    const div = document.createElement('div'); div.className = "p-3.5 rounded-2xl bg-kf-light/60 flex items-center justify-between text-xs border border-kf-sky/10";
    div.innerHTML = `<div><span class="text-[9px] ${isWaiting ? 'bg-kf-sand text-orange-800':'bg-kf-lavender text-purple-900'} px-2 py-0.5 rounded font-bold uppercase mb-1 inline-block">${isWaiting ? 'Butuh Verifikasi':'Butuh Penugasan'}</span><p class="font-bold text-kf-dark">${r.title}</p></div><button onclick="location.href='../verifikasi/data.php'" class="px-3 py-1.5 bg-white border border-kf-sky/30 rounded-xl font-bold text-kf-skyDeep">Buka</button>`;
    container.appendChild(div);
  });
}

/* ---- Modul 2: Verification Board & Verification Table ---- */
function renderAdminVerificationTable() {
  const tbody = document.getElementById('admin-tabel-verifikasi-body'); if(!tbody) return; tbody.innerHTML = '';
  reports.forEach(r => {
    const s = statusMap[r.status]; const tr = document.createElement('tr');
    tr.className = "hover:bg-kf-light/30 transition border-b border-kf-sky/5 cursor-pointer";
    tr.onclick = (e) => { if (e.target.closest('button')) return; openDetailModal(r.id); };
    
    let verifColHtml = r.status === 'menunggu' ? `<div class="flex items-center justify-center gap-1"><button onclick="openAdminActionModal(${r.id}, 'approve-verif')" class="p-2 bg-kf-mint text-green-700 rounded-xl"><i data-lucide="check" class="w-3.5 h-3.5"></i></button><button onclick="openAdminActionModal(${r.id}, 'reject-verif')" class="p-2 bg-kf-blush text-red-700 rounded-xl"><i data-lucide="x" class="w-3.5 h-3.5"></i></button></div>` : (r.status === 'ditolak' ? `<p class="text-center text-red-600 font-medium">Ditolak</p>` : `<p class="text-center text-green-600 font-semibold flex items-center justify-center gap-1"><i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Sah</p>`);
    let taskColHtml = r.status === 'diverifikasi' ? `<div class="flex justify-center"><button onclick="openAdminActionModal(${r.id}, 'assign-task')" class="px-3 py-1.5 bg-kf-dark text-white rounded-xl text-[11px] font-medium flex items-center gap-1 shadow-sm"><i data-lucide="user-plus" class="w-3 h-3"></i> Tugaskan</button></div>` : (r.status === 'menunggu' ? `<p class="text-center text-kf-muted italic">Menunggu Tahap 1</p>` : (r.status === 'ditolak' ? `<p class="text-center text-kf-muted">-</p>` : `<p class="text-center font-bold text-kf-dark">${r.manager.split(' ')[0]}</p>`));

    tr.innerHTML = `<td class="p-4"><p class="font-bold text-kf-dark text-xs">${r.title}</p><p class="text-[10px] text-kf-muted mt-0.5">Oleh: ${r.reporter} · ${r.date}</p></td><td class="p-4 text-kf-dark text-[11px]">${r.loc}</td><td class="p-4"><span class="${s.cls} text-[9px] font-bold px-2 py-0.5 rounded-full">${s.label}</span></td><td class="p-4">${verifColHtml}</td><td class="p-4">${taskColHtml}</td>`;
    tbody.appendChild(tr);
  });
  lucide.createIcons();
}

function openDetailModal(id) {
  const r = reports.find(item => item.id === id); if(!r) return;
  const s = statusMap[r.status]; const content = document.getElementById('modal-detail-content');
  content.innerHTML = `
    <div class="bg-kf-light/60 p-4 rounded-2xl border border-kf-sky/10 space-y-2">
      <div class="flex justify-between"><span>ID Pengaduan: <b>#PLR-${r.id}</b></span><span class="${s.cls} font-bold px-2 py-0.5 rounded">${s.label}</span></div>
      <h3 class="text-sm font-bold text-kf-dark">${r.title}</h3>
      <p><b>Lokasi Fisik:</b> ${r.loc}</p><p><b>Waktu Lapor:</b> ${r.date} · Pelapor: ${r.reporter}</p>
    </div>
    <div><p class="font-bold mb-1">Rincian Deskripsi Kerusakan:</p><p class="bg-kf-cream p-3 rounded-xl border border-kf-sky/5 italic">"${r.desc}"</p></div>
  `;
  document.getElementById('modal-report-detail').style.display = 'flex';
}
function closeDetailModal() { document.getElementById('modal-report-detail').style.display = 'none'; }

/* ---- Modul 3: Hub Chat 3-Arah ---- */
function renderAdminChatChannels() {
  const list = document.getElementById('admin-chat-channels-list'); if(!list) return; list.innerHTML = '';
  reports.forEach(r => {
    const s = statusMap[r.status]; const isActive = currentChatReportId === r.id;
    const btn = document.createElement('button'); btn.onclick = () => selectAdminChatChannel(r.id);
    btn.className = `w-full text-left p-3 rounded-2xl border transition ${isActive ? 'bg-white border-kf-skyDeep shadow-sm':'bg-white/40 border-transparent hover:bg-white'}`;
    btn.innerHTML = `<div class="flex justify-between items-start w-full gap-2"><p class="font-bold text-xs text-kf-dark truncate flex-1">${r.title}</p><span class="${s.cls} text-[8px] px-1.5 py-0.5 rounded font-bold">${s.label}</span></div>`;
    list.appendChild(btn);
  });
}

function selectAdminChatChannel(id) {
  currentChatReportId = id; 
  
  // Ambil kontainer wrapper pembungkus modul chat pilar
  const chatWrapper = document.getElementById('admin-chat-wrapper');
  if (chatWrapper) {
    // Jalankan saklar kelas selected untuk menyalakan penyaringan responsif
    chatWrapper.classList.add('channel-selected');
  }

  document.getElementById('admin-chat-empty-state').classList.add('hidden');
  const box = document.getElementById('admin-chat-active-box'); 
  box.classList.remove('hidden');
  
  const r = reports.find(item => item.id === id); 
  if(!r) return;
  
  document.getElementById('admin-chat-box-title').textContent = `Laporan: ${r.title}`;
  document.getElementById('admin-chat-box-participants').textContent = `Admin, Pelapor (${r.reporter}), Teknisi (${r.manager || 'Belum Ada'})`;
  
  const statusEl = document.getElementById('admin-chat-box-status'); 
  statusEl.textContent = statusMap[r.status].label;
  statusEl.className = `text-[9px] font-bold px-2 py-0.5 rounded-full ${statusMap[r.status].cls}`;
  
  renderAdminChatBoxMessages(); 
  renderAdminChatChannels();
  lucide.createIcons(); // Memastikan ikon tombol arrow-left mobile termuat sempurna
}

/**
 * FUNGSI NAVIGASI KEMBALI (BACK ACTION ENGINE)
 * Menghapus state seleksi saluran komunikasi agar daftar list kembali muncul di HP
 */
function backToAdminChannelsList() {
  const chatWrapper = document.getElementById('admin-chat-wrapper');
  if (chatWrapper) {
    // Lepas kelas penanda selected agar tampilan HP kembali ke list saluran awal
    chatWrapper.classList.remove('channel-selected');
  }

  // Sembunyikan box pesan aktif dan tampilkan status stand-by kosong untuk desktop
  document.getElementById('admin-chat-active-box').classList.add('hidden');
  document.getElementById('admin-chat-empty-state').classList.remove('hidden');
  
  currentChatReportId = null;
  renderAdminChatChannels();
}

function renderAdminChatBoxMessages() {
  const msgContainer = document.getElementById('admin-chat-box-messages-container'); if(!msgContainer) return; msgContainer.innerHTML = '';
  const messages = chatsData[currentChatReportId] || [];
  messages.forEach(m => {
    const div = document.createElement('div'); const isMe = m.sender === 'Admin'; div.className = isMe ? "flex justify-end" : "flex justify-start";
    let bubbleColor = isMe ? "bg-kf-dark text-white" : (m.sender === 'Pelapor' ? "bg-kf-sky/40 text-kf-dark" : "bg-kf-sand text-orange-900");
    div.innerHTML = `<div class="${bubbleColor} p-3 rounded-2xl text-xs max-w-[80%]"><span class="block text-[8px] font-bold opacity-75 uppercase mb-0.5">${m.name}</span><p>${m.msg}</p></div>`;
    msgContainer.appendChild(div);
  });
  msgContainer.scrollTop = msgContainer.scrollHeight;
}

function sendAdminPageChatMessage() {
  const input = document.getElementById('admin-chat-box-input'); const txt = input.value.trim(); if(!txt || !currentChatReportId) return;
  chatsData[currentChatReportId].push({ sender: 'Admin', name: 'Admin Fasilitas', msg: txt, time: 'Sekarang' });
  input.value = ''; renderAdminChatBoxMessages();
}

/* ---- Modul 4: Manajemen Master Otoritas User ---- */
function renderUsersList() {
  const tbody = document.getElementById('user-table-body'); if(!tbody) return; tbody.innerHTML = '';
  usersMaster.forEach((u, index) => {
    const tr = document.createElement('tr'); tr.className = "border-b border-kf-sky/5 hover:bg-kf-light/20";
    tr.innerHTML = `<td class="p-3 font-semibold">${u.name}</td><td class="p-3 text-kf-muted">${u.email}</td><td class="p-3"><span class="px-2 py-0.5 font-bold rounded ${u.role==='Admin'?'bg-kf-lavender text-purple-900':'bg-kf-sand text-orange-900'}">${u.role}</span></td><td class="p-3 text-kf-muted">${u.division}</td><td class="p-3"><div class="flex items-center justify-center gap-2"><button onclick="editUserField(${index})" class="p-1.5 bg-kf-light text-kf-dark rounded-lg"><i data-lucide="edit-2" class="w-3.5 h-3.5"></i></button><button onclick="deleteUserField(${index})" class="p-1.5 bg-kf-blush text-red-600 rounded-lg"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button></div></td>`;
    tbody.appendChild(tr);
  });

  const select = document.getElementById('admin-manager-select');
  if(select) {
    select.innerHTML = '';
    usersMaster.filter(u => u.role === 'Manager').forEach(m => {
      select.innerHTML += `<option value="${m.name} (${m.division})">${m.name} - ${m.division}</option>`;
    });
  }
  lucide.createIcons();
}

function handleUserSubmit(e) {
  e.preventDefault();
  const name = document.getElementById('user-fullname').value;
  const email = document.getElementById('user-email').value;
  const role = document.getElementById('user-role').value;
  const division = document.getElementById('user-division').value;
  const editIndex = parseInt(document.getElementById('user-edit-index').value);

  if (editIndex === -1) {
    usersMaster.push({ name, email, role, division });
    showToast('Personel Otoritas Baru Berhasil Ditambahkan! ✨');
  } else {
    usersMaster[editIndex] = { name, email, role, division };
    showToast('Perubahan Data Akun Berhasil Disimpan! 📝');
  }
  resetUserForm(); renderUsersList();
}

function editUserField(index) {
  const u = usersMaster[index];
  document.getElementById('user-edit-index').value = index;
  document.getElementById('user-fullname').value = u.name;
  document.getElementById('user-email').value = u.email;
  document.getElementById('user-role').value = u.role;
  document.getElementById('user-division').value = u.division;
  document.getElementById('user-form-title').textContent = "Ubah Data User";
  document.getElementById('user-submit-btn').textContent = "Perbarui User";
  document.getElementById('user-cancel-btn').classList.remove('hidden');
}

function deleteUserField(index) {
  if(confirm(`Apakah Anda yakin menghapus akses pengelola untuk ${usersMaster[index].name}?`)) {
    showToast(`Akun ${usersMaster[index].name} telah dicabut.`);
    usersMaster.splice(index, 1); renderUsersList();
  }
}

function resetUserForm() {
  document.getElementById('user-edit-index').value = "-1";
  document.getElementById('user-fullname').value = "";
  document.getElementById('user-email').value = "";
  document.getElementById('user-division').value = "";
  document.getElementById('user-form-title').textContent = "Tambah User Baru";
  document.getElementById('user-submit-btn').textContent = "Simpan Personel";
  document.getElementById('user-cancel-btn').classList.add('hidden');
}

/* ---- Modul 5: Manajemen Pemetaan Wilayah & Ruang ---- */
// AJAX Cascading Dropdown Loader Engine (Mengarah ke controllers/Lokasi.php)
function loadGedungOption(idKampus) {
    const selectGedung = document.getElementById('select-gedung-for-room');
    if (!idKampus) {
        selectGedung.innerHTML = '<option value="">Pilih Gedung (Pilih Kampus Dahulu)</option>';
        return;
    }
    
    // Perubahan path menjadi ../../../controllers/Lokasi.php
    fetch(`../../../controllers/Lokasi.php?action=get_gedung&id_kampus=${idKampus}`)
        .then(response => response.text())
        .then(htmlOutput => {
            selectGedung.innerHTML = htmlOutput;
        })
        .catch(err => showToast('Gagal memuat interkoneksi data gedung ❌'));
}

// Interactive Trigger Pop Up Modal Hapus (Mengarah ke controllers/Lokasi.php)
function triggerDeletePopup(type, id, name) {
    const modal = document.getElementById('delete-popup-modal');
    document.getElementById('delete-target-name').textContent = `"${name}"`;
    document.getElementById('delete-title-label').textContent = `Hapus ${type.charAt(0).toUpperCase() + type.slice(1)}`;
    
    // Perubahan path menjadi ../../../controllers/Lokasi.php
    document.getElementById('delete-confirm-btn').href = `../../../controllers/Lokasi.php?delete_type=${type}&id=${id}`;
    
    modal.style.display = 'flex';
}

/* ---- Modul 6: Profil Keamanan Akun Admin ---- */
function handleProfilePhotoUpload(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('profile-card-photo').style.backgroundImage = `url('${e.target.result}')`;
      showToast('Foto profil admin berhasil diperbarui! 📸');
    };
    reader.readAsDataURL(file);
  }
}

function handleUpdateProfile(e) {
  e.preventDefault();
  const newName = document.getElementById('profile-input-name').value;
  const newTitle = document.getElementById('profile-input-title').value;
  if(document.getElementById('sidebar-profile-name')) document.getElementById('sidebar-profile-name').textContent = newName;
  if(document.getElementById('sidebar-profile-title')) document.getElementById('sidebar-profile-title').textContent = newTitle;
  if(document.getElementById('profile-card-name')) document.getElementById('profile-card-name').textContent = newName;
  if(document.getElementById('profile-card-role-label')) document.getElementById('profile-card-role-label').textContent = newTitle;
  showToast('Informasi Akun Anda Berhasil Disimpan! ✨');
}

/* ---- Modul 7: Saringan & Cetak Berkas Rekapitulasi ---- */
function executeComprehensiveFilter() {
  const startDate = document.getElementById('print-filter-start-date')?.value;
  const endDate = document.getElementById('print-filter-end-date')?.value;
  const filterStatus = document.getElementById('print-filter-status')?.value;
  const filterArea = document.getElementById('print-filter-area')?.value;
  const tbody = document.getElementById('print-table-body'); if(!tbody) return; tbody.innerHTML = '';

  const filtered = reports.filter(r => {
    if(startDate && r.date < startDate) return false;
    if(endDate && r.date > endDate) return false;
    if(filterStatus && filterStatus !== 'semua' && r.status !== filterStatus) return false;
    if(filterArea && filterArea !== 'semua' && !r.loc.includes(filterArea)) return false;
    return true;
  });

  if(filtered.length === 0) {
    tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-gray-400 italic">Tidak ditemukan rekap keluhan yang cocok.</td></tr>`; return;
  }
  filtered.forEach(r => {
    const tr = document.createElement('tr'); tr.className = "border-b text-gray-800 text-[11px]";
    tr.innerHTML = `<td class="p-3">#${r.id}</td><td class="p-3"><b>${r.reporter}</b><br><span class="text-[10px] text-gray-400">${r.date}</span></td><td class="p-3"><b>${r.title}</b></td><td class="p-3">${r.loc}</td><td class="p-3 font-bold text-center">${statusMap[r.status].label}</td><td class="p-3 text-gray-600">${r.manager || '-'}</td>`;
    tbody.appendChild(tr);
  });
}

/* ---- Validation Action Form Modal Handlers ---- */
function openAdminActionModal(id, actionType) {
  const r = reports.find(item => item.id === id); if(!r) return;
  document.getElementById('admin-target-id').value = id; 
  document.getElementById('admin-target-type').value = actionType; 
  document.getElementById('admin-note').value = '';
  document.getElementById('admin-modal-info').innerHTML = `<b>Judul Laporan:</b> ${r.title}`;
  
  const mgrSelect = document.getElementById('manager-select-container'); 
  const submitBtn = document.getElementById('admin-submit-btn');
  
  if(actionType === 'approve-verif') {
    document.getElementById('admin-modal-title').textContent = "Sahkan Laporan"; mgrSelect.classList.add('hidden'); submitBtn.textContent = "Sahkan Valid"; submitBtn.className = "w-full py-2.5 rounded-xl bg-green-600 text-white font-bold text-xs";
  } else if (actionType === 'reject-verif') {
    document.getElementById('admin-modal-title').textContent = "Tolak Pengaduan"; mgrSelect.classList.add('hidden'); submitBtn.textContent = "Tolak Keluhan"; submitBtn.className = "w-full py-2.5 rounded-xl bg-red-500 text-white font-bold text-xs";
  } else if (actionType === 'assign-task') {
    document.getElementById('admin-modal-title').textContent = "Tugaskan Kerja Teknisi"; mgrSelect.classList.remove('hidden'); submitBtn.textContent = "Kirim Surat Tugas"; submitBtn.className = "w-full py-2.5 rounded-xl bg-kf-dark text-white font-bold text-xs";
  }
  document.getElementById('modal-admin-action').classList.add('open');
}

function closeAdminModal() { document.getElementById('modal-admin-action').classList.remove('open'); }

function executeAdminAction(e) {
  e.preventDefault(); 
  const id = parseInt(document.getElementById('admin-target-id').value); 
  const actionType = document.getElementById('admin-target-type').value; 
  const note = document.getElementById('admin-note').value; 
  const r = reports.find(item => item.id === id);
  
  if(r) {
    if(actionType === 'approve-verif') { r.status = 'diverifikasi'; r.note = "Verifikasi: " + note; chatsData[id].push({ sender: 'Admin', name: 'Sistem', msg: `🟢 Laporan diverifikasi valid. Catatan: "${note}"` }); } 
    else if (actionType === 'reject-verif') { r.status = 'ditolak'; r.note = "Ditolak: " + note; chatsData[id].push({ sender: 'Admin', name: 'Sistem', msg: `🔴 Laporan ditolak. Alasan: "${note}"` }); } 
    else if (actionType === 'assign-task') { const manager = document.getElementById('admin-manager-select').value; r.status = 'proses'; r.manager = manager; r.note += ` | Ditugaskan ke: ${manager}`; chatsData[id].push({ sender: 'Admin', name: 'Sistem', msg: `⚙️ Tugas diterbitkan ke ${manager}.` }); }
  }
  closeAdminModal(); renderAdminVerificationTable(); showToast('Aksi Validasi Log Berhasil Diperbarui!');
}

/* ---- Confirmation & Utility Overlays ---- */
// function confirmAction(type, id = null) {
//     const modal = document.getElementById('modal-confirm');
//     const iconWrap = document.getElementById('confirm-icon-container');
//     const title = document.getElementById('confirm-title');
//     const desc = document.getElementById('confirm-desc');
//     const btn = document.getElementById('confirm-btn-primary');

//     if (type === 'reject_report') {
//         iconWrap.style.background = 'var(--blush)';
//         iconWrap.innerHTML = '<i data-lucide="x-circle" class="w-6 h-6 text-red-500"></i>';
//         title.textContent = 'Tolak Laporan';
//         desc.innerHTML = `<p class="text-xs mb-2">Alasan penolakan:</p><textarea id="reject-note-input" class="w-full p-2 border rounded-xl text-xs" rows="3"></textarea>`;
//         btn.textContent = 'Tolak Laporan';
//         btn.onclick = () => { 
//             const note = document.getElementById('reject-note-input').value;
//             if (!note.trim()) return alert('Isi alasan!');
//             window.location.href = `../../../controllers/VerifikasiController.php?action=reject&id=${id}&note=${encodeURIComponent(note)}`; 
//         };
//     }
//     modal.classList.add('open');
// }

function closeConfirm() { document.getElementById('modal-confirm').classList.remove('open'); }

function showToast(msg) {
  const t = document.getElementById('toast'); if(!t) return;
  t.textContent = msg; t.classList.add('show');
  setTimeout(() => { t.classList.remove('show'); }, 2500);
}

/* ---- Standard Lifecycle Routing Controller ---- */
document.addEventListener('DOMContentLoaded', () => {
  closeSidebar();
  lucide.createIcons();

  if (currentActivePage === 'dashboard') {
    renderAdminDashboardWidgets();
  } else if (currentActivePage === 'verifikasi') {
    renderAdminVerificationTable();
  } else if (currentActivePage === 'chat') {
    renderAdminChatChannels();
  } else if (currentActivePage === 'users') {
    renderUsersList();
  } else if (currentActivePage === 'locations') {
    renderLocationManagement();
  } else if (currentActivePage === 'cetak') {
    executeComprehensiveFilter();
  }
});