<?php
include 'config.php';

// Periksa apakah data yang dibutuhkan tersedia
if (isset($_POST['id'], $_POST['status'])) {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $alasan_penolakan = isset($_POST['alasan_penolakan']) ? mysqli_real_escape_string($koneksi, $_POST['alasan_penolakan']) : null;

    // Daftar status yang diperbolehkan
    $allowed_statuses = ['Menunggu', 'Diajukan', 'Verifikasi Kasi', 'Diproses', 'Diterima'];

    // Inisialisasi query
    $query = "";

    // Menangani status "Menunggu"
    if ($status === 'Menunggu') {
        $query = "UPDATE pengajuan_surat SET status = 'Menunggu' WHERE id = $id";
    }
    // Menangani status "Diajukan" (admin)
    else if ($status === 'Diajukan') {
        $query = "UPDATE pengajuan_surat SET status = 'Diajukan' WHERE id = $id";
    }
    // Menangani status "Verifikasi Kasi"
    else if ($status === 'Verifikasi Kasi') {
        $query = "UPDATE pengajuan_surat SET status = 'Verifikasi Kasi' WHERE id = $id";
    }
    // Menangani status "'Verifikasi Lurah" (diajukan ke lurah)
    else if ($status === 'Verifikasi Lurah') {
        $query = "UPDATE pengajuan_surat SET status = 'Verifikasi Lurah' WHERE id = $id";
    }
    // Menangani status "Diterima" (disetujui lurah)
    else if ($status === 'Diterima') {
        $query = "UPDATE pengajuan_surat SET status = 'Diterima' WHERE id = $id";
    }
    // Menangani status "Ditolak"
    else if ($status === 'Ditolak' && $alasan_penolakan !== null) {
        $role = isset($_POST['role']) ? mysqli_real_escape_string($koneksi, $_POST['role']) : 'Unknown';
        $status_full = "Ditolak oleh $role";
        $query = "UPDATE pengajuan_surat SET status = '$status_full', alasan_penolakan = '$alasan_penolakan' WHERE id = $id";
    }
    // Jika status tidak valid
    else {
        echo json_encode(['success' => false, 'message' => 'Status tidak valid atau data kurang lengkap.']);
        exit();
    }

    // Eksekusi query update
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}
?>
