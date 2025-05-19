<?php
session_start();
include 'config.php'; // File koneksi ke database

// Validasi apakah parameter ID tersedia dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Mulai transaksi untuk memastikan konsistensi data
    $koneksi->begin_transaction();

    try {
        // Query untuk menghapus data admin
        $query_admin = "DELETE FROM admin WHERE id = ?";
        $stmt_admin = $koneksi->prepare($query_admin);

        if (!$stmt_admin) {
            throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
        }

        $stmt_admin->bind_param("i", $id);

        // Eksekusi query penghapusan data admin
        if (!$stmt_admin->execute()) {
            throw new Exception("Terjadi kesalahan saat menghapus data admin: " . $stmt_admin->error);
        }

        // Commit transaksi
        $koneksi->commit();
        $_SESSION['success'] = "Data admin berhasil dihapus.";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $koneksi->rollback();
        $_SESSION['error'] = $e->getMessage();
    } finally {
        // Menutup prepared statement dan koneksi
        if (isset($stmt_admin)) {
            $stmt_admin->close();
        }
        $koneksi->close();
    }

    header("Location: admin.php");
    exit();
} else {
    $_SESSION['error'] = "ID admin tidak valid.";
    header("Location: admin.php");
    exit();
}
?>
