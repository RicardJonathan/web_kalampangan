<?php
include 'config.php'; // Koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

$username = $_SESSION['username'];

// Tutup koneksi
$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>DPKUKMP Palangka Raya </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logokalteng.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Datatable -->
    <link href="./vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!--**********************************
    Sidebar start
***********************************-->
<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Utama</li>
            <li>
                <a href="indexUser.php" aria-expanded="false">
                    <i class="fa-solid fa-house-chimney"></i><span class="nav-text">Beranda</span>
                </a>
            </li>

            <li class="nav-label">Main Menu</li>
            <li>
                <a href="pengajuan_surat.php" aria-expanded="false">
                    <i class="fa-solid fa-file-signature menu-icon"></i><span class="nav-text">Pengajuan Surat</span>
                </a>
            </li>
            <li>
                <a href="arsip_surat.php" aria-expanded="false">
                    <i class="fa-solid fa-archive menu-icon"></i><span class="nav-text">Arsip Surat</span>
                </a>
            </li>

            <li class="nav-label">Lainnya</li>
            <li>
                <a href="logout.php" aria-expanded="false" class="<?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-right-from-bracket"></i><span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->

