<?php
session_start();
include 'config.php'; // File koneksi ke database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Ambil data pengajuan surat yang akan dihapus
        $query_select_surat = "SELECT foto_ktp, foto_kk, foto_formulir FROM pengajuan_surat WHERE id = ?";
        $stmt_select_surat = $koneksi->prepare($query_select_surat);
        $stmt_select_surat->bind_param("i", $id);
        $stmt_select_surat->execute();
        $result = $stmt_select_surat->get_result();

        if ($result->num_rows > 0) {
            $surat_data = $result->fetch_assoc();
            $foto_ktp = $surat_data['foto_ktp'];
            $foto_kk = $surat_data['foto_kk'];
            $foto_formulir = $surat_data['foto_formulir'];

            // Hapus data pengajuan surat
            $query_delete_surat = "DELETE FROM pengajuan_surat WHERE id = ?";
            $stmt_delete_surat = $koneksi->prepare($query_delete_surat);
            $stmt_delete_surat->bind_param("i", $id);

            if (!$stmt_delete_surat->execute()) {
                throw new Exception("Gagal menghapus data pengajuan surat.");
            }

            // Hapus file terkait (foto_ktp, foto_kk, foto_formulir)
            if (file_exists($foto_ktp)) {
                unlink($foto_ktp);
            }
            if (file_exists($foto_kk)) {
                unlink($foto_kk);
            }
            if (file_exists($foto_formulir)) {
                unlink($foto_formulir);
            }

            // Commit transaksi
            mysqli_commit($koneksi);

            // Pesan berhasil
            $_SESSION['message'] = "Pengajuan surat berhasil dihapus dan data terkait diperbarui.";
        } else {
            throw new Exception("Data pengajuan surat tidak ditemukan.");
        }
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        mysqli_rollback($koneksi);
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    }

    // Tutup koneksi dan redirect
    $stmt_select_surat->close();
    $stmt_delete_surat->close();
    $koneksi->close();

    header("Location: surat.php");
    exit();
} else {
    $_SESSION['error'] = "ID pengajuan surat tidak ditemukan.";
    header("Location: surat.php");
    exit();
}
?>
