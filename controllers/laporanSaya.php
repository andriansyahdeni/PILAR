<?php

include '../koneksi.php';
// Menghubungkan ke file koneksi.php (1 tingkat di luar folder controllers)

// ============================================================
// LOGIKA AJAX: Mengambil data lokasi untuk dropdown
// ============================================================

// 1. Jika ada request GET untuk mengambil data gedung berdasarkan kampus
if (isset($_GET['action']) && $_GET['action'] == 'get_gedung' && isset($_GET['id_kampus'])) {
    $id_kampus = $_GET['id_kampus'];
    $query = "SELECT * FROM gedung WHERE id_kampus = '$id_kampus'";
    $execute = mysqli_query($host, $query);

    echo '<option value="">Pilih Gedung</option>';
    while ($row = mysqli_fetch_assoc($execute)) {
        echo '<option value="' . $row['id_gedung'] . '">' . $row['nama_gedung'] . '</option>';
    }
    exit; 
}

// 2. Jika ada request GET untuk mengambil data ruangan berdasarkan gedung
if (isset($_GET['action']) && $_GET['action'] == 'get_ruangan' && isset($_GET['id_gedung'])) {
    $id_gedung = $_GET['id_gedung'];
    $query = "SELECT * FROM ruangan WHERE id_gedung = '$id_gedung'";
    $execute = mysqli_query($host, $query);

    echo '<option value="">Pilih Ruangan / Area</option>';
    while ($row = mysqli_fetch_assoc($execute)) {
        echo '<option value="' . $row['id_ruangan'] . '">' . $row['nama_ruangan'] . '</option>';
    }
    exit; 
}


// ============================================================
// LOGIKA CRUD: Insert, Update, Delete
// ============================================================

// ---- INSERT DATA ----
if (isset($_POST['tambah'])) {
    $id_pelapor      = $_POST['id_pelapor'];
    $id_ruangan      = $_POST['id_ruangan'];
    $judul_laporan   = $_POST['judul_laporan']; // Mengambil name="judul" dari form modals
    $deskripsi       = $_POST['deskripsi'];
    $tanggal_laporan = date('Y-m-d');
    $status          = 'Menunggu'; 

    // Proses Upload Foto
    $nama_file   = $_FILES['foto_sebelum']['name'];
    $error_file  = $_FILES['foto_sebelum']['error'];
    $tmp_name    = $_FILES['foto_sebelum']['tmp_name'];

    if ($error_file === 0) {
        $ekstensi_pisahkan = explode('.', $nama_file);
        $ekstensi_file     = strtolower(end($ekstensi_pisahkan));
        $nama_file_baru    = uniqid('img_') . '.' . $ekstensi_file;
        $folder_tujuan     = '../assets/uploads/laporan/sebelum/' . $nama_file_baru;

        move_uploaded_file($tmp_name, $folder_tujuan);
        $foto_db = $nama_file_baru; 
    } else {
        $foto_db = 'default.png'; 
    }

    $perintah = "INSERT INTO laporan (id_laporan, id_pelapor, id_ruangan, judul_laporan, deskripsi, foto_sebelum, tanggal_laporan, status) 
                 VALUES (NULL, '$id_pelapor', '$id_ruangan', '$judul_laporan', '$deskripsi', '$foto_db', '$tanggal_laporan', '$status')";
    
    $execute  = mysqli_query($host, $perintah);

    if ($execute) {
        header("location:../views/pelapor/laporan_saya/data.php?status=sukses_tambah");
    } else {
        header("location:../views/pelapor/laporan_saya/data.php?status=gagal_tambah");
    }
}

// ---- UPDATE DATA ----
if (isset($_POST['update'])) {
    $id_laporan    = $_GET['id_laporan'];
    $id_pelapor    = $_POST['id_pelapor'];
    $id_ruangan    = $_POST['id_ruangan'];
    $judul_laporan = $_POST['judul_laporan']; // Mengambil name="judul" dari form modals
    $deskripsi     = $_POST['deskripsi'];
    $status        = $_POST['status']; 
    $foto_db       = $_POST['foto_lama']; // Simpan nama foto lama sebagai default

    // Cek jika user mengunggah foto baru
    if ($_FILES['foto_sebelum']['error'] === 0) {
        $nama_file   = $_FILES['foto_sebelum']['name'];
        $tmp_name    = $_FILES['foto_sebelum']['tmp_name'];
        
        $ekstensi_pisahkan = explode('.', $nama_file);
        $ekstensi_file     = strtolower(end($ekstensi_pisahkan));
        $nama_file_baru    = uniqid('img_') . '.' . $ekstensi_file;
        $folder_tujuan     = '../assets/uploads/laporan/sebelum/' . $nama_file_baru;
        
        if (move_uploaded_file($tmp_name, $folder_tujuan)) {
            // ---- FITUR: HAPUS FOTO LAMA SAAT EDIT ----
            // Jika foto lama ada dan bukan file 'default.png', hapus dari folder
            if ($foto_db && $foto_db !== 'default.png') {
                $path_foto_lama = '../assets/uploads/laporan/sebelum/' . $foto_db;
                if (file_exists($path_foto_lama)) {
                    unlink($path_foto_lama);
                }
            }
            // ------------------------------------------
            
            $foto_db = $nama_file_baru; // Set foto baru untuk disimpan ke database
        }
    }

    $query = "UPDATE laporan SET 
                id_pelapor    = '$id_pelapor',
                id_ruangan    = '$id_ruangan',
                judul_laporan = '$judul_laporan',
                deskripsi     = '$deskripsi',
                foto_sebelum  = '$foto_db',
                status        = '$status'
              WHERE id_laporan = $id_laporan";

    $execute = mysqli_query($host, $query);

    if ($execute) {
        header("location:../views/pelapor/laporan_saya/data.php?status=sukses_update");
    } else {
        header("location:../views/pelapor/laporan_saya/data.php?status=gagal_update");
    }
}

// ---- DELETE DATA ----
if (isset($_GET['delete'])) {
    $id_laporan = $_GET['delete'];

    // ---- FITUR: HAPUS FOTO SAAT DATA TERHAPUS ----
    // 1. Cari tahu nama file foto yang digunakan pada laporan tersebut
    $query_cari_foto = "SELECT foto_sebelum FROM laporan WHERE id_laporan = '$id_laporan'";
    $hasil_cari      = mysqli_query($host, $query_cari_foto);
    
    if ($hasil_cari && mysqli_num_rows($hasil_cari) > 0) {
        $data_laporan = mysqli_fetch_assoc($hasil_cari);
        $nama_foto    = $data_laporan['foto_sebelum'];
        
        // 2. Jika nama filenya ada dan bukan 'default.png', hapus file fisiknya
        if ($nama_foto && $nama_foto !== 'default.png') {
            $path_file = '../assets/uploads/laporan/sebelum/' . $nama_foto;
            if (file_exists($path_file)) {
                unlink($path_file);
            }
        }
    }
    // -----------------------------------------------

    // 3. Setelah file fisik terhapus, baru hapus baris data di database
    $query   = "DELETE FROM laporan WHERE id_laporan = '$id_laporan'";
    $execute = mysqli_query($host, $query);

    if ($execute) {
        header("location:../views/pelapor/laporan_saya/data.php?status=sukses_hapus");
    } else {
        header("location:../views/pelapor/laporan_saya/data.php?status=gagal_hapus");
    }
}
?>