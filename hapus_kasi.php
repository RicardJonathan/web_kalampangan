<?php
session_start();
include 'config.php'; // File koneksi ke database

// Validasi apakah parameter ID tersedia dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Mulai transaksi untuk memastikan konsistensi data
    $koneksi->begin_transaction();

    try {
        // Query untuk menghapus data kasi
        $query_kasi = "DELETE FROM kasi WHERE id = ?";
        $stmt_kasi = $koneksi->prepare($query_kasi);

        if (!$stmt_kasi) {
            throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
        }

        $stmt_kasi->bind_param("i", $id);

        // Eksekusi query penghapusan data kasi
        if (!$stmt_kasi->execute()) {
            throw new Exception("Terjadi kesalahan saat menghapus data kasi: " . $stmt_kasi->error);
        }

        // Commit transaksi
        $koneksi->commit();
        $_SESSION['success'] = "Data kasi berhasil dihapus.";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $koneksi->rollback();
        $_SESSION['error'] = $e->getMessage();
    } finally {
        // Menutup prepared statement dan koneksi
        if (isset($stmt_kasi)) {
            $stmt_kasi->close();
        }
        $koneksi->close();
    }

    header("Location: kasi.php");
    exit();
} else {
    $_SESSION['error'] = "ID kasi tidak valid.";
    header("Location: kasi.php");
    exit();
}
?>
