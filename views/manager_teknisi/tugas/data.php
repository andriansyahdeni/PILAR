<?php 
$active_page = 'tasks'; 
include '../../../template/manager_teknisi/header.php';
?>

<div class="h-full w-full overflow-auto">
    <div class="flex h-full w-full">
        
        <?php include '../../../template/manager_teknisi/sidebar.php'; ?>

        <main class="flex-1 overflow-auto bg-kf-cream/50 p-8">
            <header class="mb-6">
                <h1 class="font-script text-4xl text-kf-dark">Meja Kerja Penugasan</h1>
                <p class="text-sm text-kf-muted mt-1">Kelola dan selesaikan instruksi laporan sarpras fisik kampus.</p>
            </header>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Penugasan Aktif -->
                <div class="bg-white rounded-3xl p-6 border border-kf-sky/10 shadow-sm flex flex-col">
                    <h2 class="text-xs font-bold text-kf-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Tugas Berjalan (Dalam Proses)
                    </h2>
                    <div class="space-y-4 overflow-y-auto max-h-[460px] pr-1" id="manager-active-tasks"></div>
                </div>

                <!-- Riwayat Selesai -->
                <div class="bg-white rounded-3xl p-6 border border-kf-sky/10 shadow-sm flex flex-col">
                    <h2 class="text-xs font-bold text-kf-dark uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> Dokumentasi Riwayat Selesai
                    </h2>
                    <div class="space-y-4 overflow-y-auto max-h-[460px] pr-1" id="manager-finished-tasks"></div>
                </div>
            </div>
        </main>

    </div>
</div>

<?php include '../../../template/manager_teknisi/footer.php';?>