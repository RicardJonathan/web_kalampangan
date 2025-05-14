<?php
session_start();
include 'config.php'; // File koneksi ke database

// Validasi apakah parameter ID tersedia dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Mulai transaksi untuk memastikan konsistensi data
    $koneksi->begin_transaction();

    try {
        // Query untuk menghapus data pengguna
        $query_pengguna = "DELETE FROM user WHERE id = ?";
        $stmt_pengguna = $koneksi->prepare($query_pengguna);

        if (!$stmt_pengguna) {
            throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
        }

        $stmt_pengguna->bind_param("i", $id);

        // Eksekusi query penghapusan data pengguna
        if (!$stmt_pengguna->execute()) {
            throw new Exception("Terjadi kesalahan saat menghapus data pengguna: " . $stmt_pengguna->error);
        }

        // Commit transaksi
        $koneksi->commit();
        $_SESSION['success'] = "Data pengguna berhasil dihapus.";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $koneksi->rollback();
        $_SESSION['error'] = $e->getMessage();
    } finally {
        // Menutup prepared statement dan koneksi
        if (isset($stmt_pengguna)) {
            $stmt_pengguna->close();
        }
        $koneksi->close();
    }

    header("Location: penggunaAdm.php");
    exit();
} else {
    $_SESSION['error'] = "ID pengguna tidak valid.";
    header("Location: penggunaAdm.php");
    exit();
}
?>
