<?php
session_start();
include 'config.php'; // Koneksi ke database

if (isset($_POST['submit'])) {
    $id_pengajuan = $_POST['id_pengajuan'];
    $file_surat = $_FILES['file_surat'];

    if ($file_surat['error'] === 0) {
        $nama_file = $file_surat['name'];
        $tmp_file = $file_surat['tmp_name'];
        $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $allowed_ext = ['pdf', 'doc', 'docx'];

        if (!in_array($ext, $allowed_ext)) {
            echo "<script>alert('Hanya file PDF, DOC, atau DOCX yang diperbolehkan.'); window.location.href='bmasukKasi.php';</script>";
            exit;
        }

        $new_file_name = $id_pengajuan . '_surat.' . $ext;
        $folder_upload = 'uploads/surat/';

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0755, true); // Buat folder jika belum ada
        }

        $path_file = $folder_upload . $new_file_name;

        if (move_uploaded_file($tmp_file, $path_file)) {
            $sql = "UPDATE pengajuan_surat SET file_surat = '$new_file_name' WHERE id = '$id_pengajuan'";
            if (mysqli_query($koneksi, $sql)) {
                echo "<script>alert('File berhasil di-upload dan disimpan.'); window.location.href='bmasukKasi.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan ke database: " . mysqli_error($koneksi) . "'); window.location.href='bmasukKasi.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal meng-upload file ke server.'); window.location.href='bmasukKasi.php';</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file.'); window.location.href='bmasukKasi.php';</script>";
    }
}
?>
