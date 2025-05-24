<?php
include 'config.php';
header('Content-Type: application/json');

if (isset($_POST['id'], $_POST['status'])) {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $alasan_penolakan = isset($_POST['alasan_penolakan']) ? mysqli_real_escape_string($koneksi, $_POST['alasan_penolakan']) : null;

    $query = "";

    if ($status === 'Menunggu') {
        $query = "UPDATE pengajuan_surat SET status = 'Menunggu' WHERE id = $id";
    } else if ($status === 'Diajukan') {
        $query = "UPDATE pengajuan_surat SET status = 'Diajukan' WHERE id = $id";
    } else if ($status === 'Verifikasi Kasi') {
        $query = "UPDATE pengajuan_surat SET status = 'Verifikasi Kasi' WHERE id = $id";
    } else if ($status === 'Verifikasi Lurah') {
        $query = "UPDATE pengajuan_surat SET status = 'Verifikasi Lurah' WHERE id = $id";
    } else if ($status === 'Diproses') {
        $query = "UPDATE pengajuan_surat SET status = 'Diproses' WHERE id = $id";
    } else if ($status === 'Diterima') {
        $query = "UPDATE pengajuan_surat SET status = 'Diterima' WHERE id = $id";
    } else if ($status === 'Ditolak' && $alasan_penolakan !== null) {
        $role = isset($_POST['role']) ? mysqli_real_escape_string($koneksi, $_POST['role']) : 'Unknown';
        $status_full = "Ditolak oleh $role";
        $query = "UPDATE pengajuan_surat SET status = '$status_full', alasan_penolakan = '$alasan_penolakan' WHERE id = $id";
    } else {
        echo json_encode(['success' => false, 'message' => 'Status tidak valid atau data kurang lengkap.']);
        exit();
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if ($status === 'Diajukan') {
            ob_start();
            include 'send_notifications.php';
            ob_end_clean();
        } else if ($status === 'Verifikasi Kasi') {
            ob_start();
            include 'send_notifications_kasi.php';
            ob_end_clean();
        } else if ($status === 'Verifikasi Lurah') {
            ob_start();
            include 'send_notifications_lurah.php'; // <--- INI YANG DITAMBAHKAN
            ob_end_clean();
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}
