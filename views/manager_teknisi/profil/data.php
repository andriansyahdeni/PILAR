<?php 
$active_page = 'profile'; 
include '../../../template/manager_teknisi/header.php'; 
?>

<div class="h-full w-full overflow-auto">
    <div class="flex h-full w-full">
        
        <?php include '../../../template/manager_teknisi/sidebar.php'; ?>

        <main class="flex-1 overflow-auto bg-kf-cream/50 p-8">
            <header class="mb-6"><h1 class="font-script text-4xl text-kf-dark">Manajemen Akun Profil Saya</h1></header>
            <div class="max-w-3xl bg-white rounded-3xl p-8 border border-kf-sky/10 shadow-sm">
                
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 pb-6 border-b border-kf-sky/10">
                    <div class="relative group shrink-0">
                        <div class="w-24 h-24 rounded-3xl bg-cover bg-center border-2 border-amber-400 shadow-md transition-all group-hover:brightness-90" id="profile-card-photo" style="background-image: url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=150&auto=format&fit=crop');"></div>
                        <label class="absolute -bottom-1 -right-1 w-8 h-8 rounded-xl bg-kf-dark text-white shadow-md flex items-center justify-center cursor-pointer hover:bg-amber-500 transition">
                            <i data-lucide="camera" class="w-4 h-4"></i>
                            <input type="file" accept="image/*" class="hidden" onchange="handleProfilePhotoUpload(event)">
                        </label>
                    </div>
                    
                    <div class="text-center sm:text-left">
                        <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                            <h3 class="text-base font-bold text-kf-dark" id="profile-card-name">Ibu Siska</h3>
                            <span class="text-[9px] bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full uppercase border border-amber-200" id="profile-card-category-badge">Internal Staff</span>
                        </div>
                        <p class="text-xs text-kf-muted font-medium mb-1 flex items-center justify-center sm:justify-start gap-1"><i data-lucide="wrench" class="w-3.5 h-3.5 text-amber-500"></i> <span id="profile-card-role-label">Kelistrikan & IT Support</span></p>
                        <p class="text-[11px] text-gray-400" id="profile-card-username-label">@siska_pilar</p>
                    </div>
                </div>

                <form onsubmit="handleUpdateProfile(event)" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="text-[11px] font-bold text-kf-dark block mb-1">Nama Lengkap</label><input type="text" id="profile-input-name" value="Ibu Siska" required class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border"></div>
                        <div><label class="text-[11px] font-bold text-kf-dark block mb-1">Username Aplikasi</label><input type="text" id="profile-input-username" value="siska_pilar" required class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="text-[11px] font-bold text-kf-dark block mb-1">Nomor Telepon / WhatsApp</label><input type="tel" id="profile-input-phone" value="081234567890" required class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border"></div>
                        <div><label class="text-[11px] font-bold text-kf-dark block mb-1">Alamat Email Pengguna</label><input type="email" id="profile-input-email" value="siska@pens.ac.id" required class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="text-[11px] font-bold text-kf-dark block mb-1">Jabatan / Keahlian Utama</label><input type="text" id="profile-input-title" value="Kelistrikan & IT Support" required class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border"></div>
                        <div>
                            <label class="text-[11px] font-bold text-kf-dark block mb-1">Kategori Pengguna</label>
                            <select id="profile-input-category" class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border text-kf-dark font-medium">
                                <option value="Internal Staff">Staff Internal Sarpras</option>
                                <option value="Teknisi Utama">Teknisi Spesialis Utama</option>
                                <option value="Mitra Luar">Vendor / Pihak Ketiga</option>
                            </select>
                        </div>
                    </div>
                    <hr class="border-kf-sky/15 my-2">
                    <div><label class="text-[11px] font-bold text-kf-dark block mb-1">Kata Sandi Akun Baru</label><input type="password" id="profile-input-pass" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl bg-kf-light text-xs outline-none focus:border-amber-400 border"></div>
                    <div class="flex justify-end pt-2"><button type="submit" class="px-6 py-2.5 bg-kf-dark text-white text-xs font-bold rounded-xl shadow-md hover:bg-opacity-90 transition">Simpan Perubahan Akun</button></div>
                </form>
            </div>
        </main>

    </div>
</div>

<?php include '../../../template/manager_teknisi/footer.php';?>