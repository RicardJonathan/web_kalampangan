<?php
include 'config.php';

// Periksa apakah data yang dibutuhkan tersedia
if (isset($_POST['id'], $_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];
    $alasan_penolakan = isset($_POST['alasan_penolakan']) ? mysqli_real_escape_string($koneksi, $_POST['alasan_penolakan']) : null;

    // Menangani status "Diproses"
    if ($status == 'Diproses') {
        // Update status menjadi "Diproses"
        $query = "UPDATE  SET pengajuan_surat status = 'Diproses' WHERE id = $id";
    }
    // Menangani status "Diajukan"
    else if ($status == 'Diajukan') {
        // Update status menjadi "Diajukan"
        $query = "UPDATE pengajuan_surat SET status = 'Diajukan' WHERE id = $id";
    }
    // Menangani status "Ditolak"
    else if ($status == 'Ditolak' && $alasan_penolakan !== null) {
        $role = isset($_POST['role']) ? mysqli_real_escape_string($koneksi, $_POST['role']) : 'Unknown'; // Default role jika tidak ada
        $status_full = "Ditolak oleh $role";
        $query = "UPDATE pengajuan_surat SET status = '$status_full', alasan_penolakan = '$alasan_penolakan' WHERE id = $id";
    }
    
    // Menangani status "Diterima"
    else if ($status == 'Diterima') {
        $nama_pengaju = isset($_POST['nama_pengaju']) ? mysqli_real_escape_string($koneksi, $_POST['nama_pengaju']) : null;
        $query = "UPDATE pengajuan_surat SET status = 'Diterima', nama_pengaju = '$nama_pengaju' WHERE id = $id";
    } else {
        echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
        exit();
    }

    // Eksekusi query update
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dieksekusi
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}
?>
