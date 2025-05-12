<?php
session_start();
require_once 'config.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $file_surat = $_FILES['file_surat'] ?? null;

    if (empty($id) || !$file_surat) {
        echo "<script>alert('ID atau file tidak valid.'); window.location.href='bmasukKasi.php';</script>";
        exit;
    }

    if ($file_surat['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file.'); window.location.href='bmasukKasi.php';</script>";
        exit;
    }

    $nama_file = $file_surat['name'];
    $tmp_file = $file_surat['tmp_name'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $allowed_ext = ['pdf', 'doc', 'docx'];

    if (!in_array($ext, $allowed_ext)) {
        echo "<script>alert('Hanya file PDF, DOC, atau DOCX yang diperbolehkan.'); window.location.href='bmasukKasi.php';</script>";
        exit;
    }

    $new_file_name = $id . '_surat_' . time() . '.' . $ext;
    $folder_upload = 'uploads/surat/';

    // Pastikan folder ada
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0755, true);
    }

    $path_file = $folder_upload . $new_file_name;

    if (move_uploaded_file($tmp_file, $path_file)) {
        // Gunakan prepared statement untuk keamanan
        $stmt = mysqli_prepare($koneksi, "UPDATE pengajuan_surat SET file_surat = ? WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $new_file_name, $id);
            $execute = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($execute) {
                echo "<script>alert('File berhasil di-upload dan disimpan.'); window.location.href='bmasukKasi.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ke database.'); window.location.href='bmasukKasi.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal menyiapkan query.'); window.location.href='bmasukKasi.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal meng-upload file ke server.'); window.location.href='bmasukKasi.php';</script>";
    }
} else {
    header("Location: bmasukKasi.php");
    exit;
}
?>
