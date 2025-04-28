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
                <a href="pengajuan_surat_usaha.php" aria-expanded="false">
                    <i class="fa-solid fa-file-signature menu-icon"></i><span class="nav-text">Pengajuan Surat Keterangan Usaha</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_sktm.php" aria-expanded="false">
                    <i class="fa-solid fa-file-invoice-dollar menu-icon"></i><span class="nav-text">Surat Keterangan Tidak Mampu</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_kematian.php" aria-expanded="false">
                    <i class="fa-solid fa-file-medical menu-icon"></i><span class="nav-text">Surat Keterangan Kematian</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_kelahiran.php" aria-expanded="false">
                    <i class="fa-solid fa-baby menu-icon"></i><span class="nav-text">Surat Keterangan Kelahiran</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_pindah.php" aria-expanded="false">
                    <i class="fa-solid fa-truck-moving menu-icon"></i><span class="nav-text">Surat Keterangan Pindah</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_belum_menikah.php" aria-expanded="false">
                    <i class="fa-solid fa-user-times menu-icon"></i><span class="nav-text">Surat Keterangan Belum Menikah</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_untuk_menikah.php" aria-expanded="false">
                    <i class="fa-solid fa-ring menu-icon"></i><span class="nav-text">Surat Keterangan Untuk Menikah</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_pbb_baru.php" aria-expanded="false">
                    <i class="fa-solid fa-home menu-icon"></i><span class="nav-text">Pengajuan PBB Baru</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_ahli_waris.php" aria-expanded="false">
                    <i class="fa-solid fa-user-shield menu-icon"></i><span class="nav-text">Surat Keterangan Ahli Waris</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_berkelakuan_baik.php" aria-expanded="false">
                    <i class="fa-solid fa-thumbs-up menu-icon"></i><span class="nav-text">Surat Keterangan Berkelakuan Baik</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_suket_domisili.php" aria-expanded="false">
                    <i class="fa-solid fa-map-marker-alt menu-icon"></i><span class="nav-text">Surat Keterangan Domisili</span>
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
