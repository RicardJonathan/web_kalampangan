<?php
include 'config.php';
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM pengajuan_surat WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $filePath = 'files/' . $row['file_surat'];
    if (!empty($row['file_surat']) && file_exists($filePath)) {
        // Header agar file tampil sebagai PDF di browser
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=" . basename($filePath));
        @readfile($filePath);
        exit;
    } else {
        echo "File surat tidak ditemukan.";
    }
} else {
    echo "Data tidak ditemukan.";
}
?>
