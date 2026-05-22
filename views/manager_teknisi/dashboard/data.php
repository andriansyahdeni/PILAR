<?php 
$active_page = 'dashboard'; 
include '../../../template/manager_teknisi/header.php'; 
?>

<div class="h-full w-full overflow-auto">
    <div class="flex h-full w-full">
        
        <?php include '../../../template/manager_teknisi/sidebar.php'; ?>

        <main class="flex-1 overflow-auto bg-kf-cream/50 p-8">
            <header class="mb-8">
                <h1 class="text-2xl font-bold text-kf-dark" id="welcome-heading">Hi, Ibu Siska! 👋</h1>
                <p class="text-sm text-kf-muted mt-1">Ringkasan status performa perbaikan dan antrean kerja Anda.</p>
            </header>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-kf-sky/10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-xl bg-kf-light flex items-center justify-center text-kf-skyDeep"><i data-lucide="loader" class="w-5 h-5"></i></div>
                        <span class="text-xs font-medium text-kf-muted">Dalam Proses</span>
                    </div>
                    <p class="text-3xl font-bold text-kf-dark count-up" id="count-proses" data-target="0">0</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-kf-sky/10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-xl bg-kf-mint flex items-center justify-center text-green-600"><i data-lucide="check-circle" class="w-5 h-5"></i></div>
                        <span class="text-xs font-medium text-kf-muted">Selesai Diperbaiki</span>
                    </div>
                    <p class="text-3xl font-bold text-kf-dark count-up" id="count-selesai" data-target="0">0</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-kf-sky/10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-xl bg-kf-lavender flex items-center justify-center text-purple-600"><i data-lucide="briefcase" class="w-5 h-5"></i></div>
                        <span class="text-xs font-medium text-kf-muted">Total Penugasan</span>
                    </div>
                    <p class="text-3xl font-bold text-kf-dark count-up" id="count-total" data-target="0">0</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-kf-sky/10 shadow-sm flex flex-col">
                    <h2 class="text-sm font-bold text-kf-dark mb-4 flex items-center gap-2"><i data-lucide="alert-circle" class="text-amber-500 w-4 h-4"></i> Tugas Mendesak Yang Harus Ditangani</h2>
                    <div class="space-y-3 flex-1 overflow-y-auto max-h-[250px] pr-1" id="manager-urgent-box"></div>
                </div>
                <div class="bg-gradient-to-br from-white to-kf-light rounded-3xl p-6 border border-kf-sky/20 flex flex-col justify-between shadow-sm">
                    <div>
                        <h3 class="font-bold text-kf-dark text-base">Alur Kerja Perbaikan</h3>
                        <p class="text-xs text-kf-muted leading-relaxed mt-2">Dapatkan info tugas dari admin, periksa kerusakan di lapangan, lakukan perbaikan, unggah bukti foto aset terbaru, lalu ubah status menjadi Selesai.</p>
                    </div>
                    <a href="../tugas/data.php" class="w-full mt-6 py-3.5 bg-kf-dark text-white rounded-2xl text-xs font-semibold shadow-md flex items-center justify-center gap-2">Buka Daftar Tugas</a>
                </div>
            </div>
        </main>

    </div>
</div>

<?php include '../../../template/manager_teknisi/footer.php';?>