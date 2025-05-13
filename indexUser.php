<?php
session_start();
include 'config.php'; // Koneksi ke database

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Cek apakah pengguna yang login ada di tabel admin
$user_id = $_SESSION['id']; // ID pengguna yang login

$sql_user = "SELECT * FROM user WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_user = $koneksi->query($sql_user);

if ($result_user->num_rows == 0) {
    // Jika tidak ada di tabel admin, arahkan ke halaman error
    header("Location: page-error-403.php"); // Arahkan ke halaman error
    exit();
}
// Total pengajuan surat
$stmt = $koneksi->prepare("SELECT COUNT(*) AS total_surat FROM pengajuan_surat");
$stmt->execute();
$result = $stmt->get_result();
$totalPengajuanSurat = $result->fetch_assoc()['total_surat'] ?? 0;

// Surat menunggu
$stmt = $koneksi->prepare("SELECT COUNT(*) AS total_menunggu FROM pengajuan_surat WHERE status = 'Diajukan'");
$stmt->execute();
$result = $stmt->get_result();
$totalSuratMenunggu = $result->fetch_assoc()['total_menunggu'] ?? 0;

// Surat diterima
$stmt = $koneksi->prepare("SELECT COUNT(*) AS total_diterima FROM pengajuan_surat WHERE status = 'Diterima'");
$stmt->execute();
$result = $stmt->get_result();
$totalSuratDiterima = $result->fetch_assoc()['total_diterima'] ?? 0;

// Surat ditolak
$stmt = $koneksi->prepare("SELECT COUNT(*) AS total_ditolak FROM pengajuan_surat WHERE status = 'Ditolak'");
$stmt->execute();
$result = $stmt->get_result();
$totalSuratDitolak = $result->fetch_assoc()['total_ditolak'] ?? 0;
// Menutup koneksi
$koneksi->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kelurahan Kelampangan</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<style>
.btn-biru-keren {
  background-color: #007bff; /* Biru Bootstrap */
  border-color: #007bff;
  color: white;
  font-weight: bold;
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 123, 255, 0.3);
}

.btn-biru-keren:hover {
  background-color: #0056b3; /* Biru lebih gelap saat hover */
  box-shadow: 0 6px 8px rgba(0, 86, 179, 0.4);
  color: white;
}
</style>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <div class="brand-logo">
                <div class="logo-container">
                    <div class="logo-pky">
                        <img src="images/logopky.png" alt="">
                    </div>
                    <div class="brand-title">
                        <h4>KELURAHAN KELAMPANGAN <br> PALANGKA RAYA</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-content clearfix">
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <img src="images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span>
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="profileUser.php"><i class="icon-user"></i> <span>Profile</span></a></li>
                                        <li><a href="logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php include 'sidebarUser.php'; ?>

       <!-- Content body -->
       <div class="content-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card" style="background-color: #7E8EF1; border: 1px solid #F44336; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <h3 class="card-title" style="color: #091057; font-weight: normal;">Menunggu Persetujuan</h3>
                                <h2 style="color: #091057; font-weight: normal;"><?php echo $totalSuratMenunggu; ?> Pengajuan</h2>
                                <span class="float-right display-5 opacity-5" style="color: #091057;"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card" style="background-color: #C8E6C9; border: 1px solid #388E3C; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <h3 class="card-title" style="color: #1B5E20; font-weight: normal;">Pengajuan Diterima</h3>
                                <h2 style="color: #1B5E20; font-weight: normal;"><?php echo $totalSuratDiterima; ?> Pengajuan</h2>
                                <span class="float-right display-5 opacity-5" style="color: #388E3C;"><i class="fa fa-check-circle"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card" style="background-color: #FFEBEE; border: 1px solid #F44336; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <h3 class="card-title" style="color: #D32F2F; font-weight: normal;">Pengajuan Ditolak</h3>
                                <h2 style="color: #D32F2F; font-weight: normal;"><?php echo $totalSuratDitolak; ?> Pengajuan</h2>
                                <span class="float-right display-5 opacity-5" style="color: #F44336;"><i class="fa fa-times-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Syarat Pengajuan Surat Section Below -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pb-0">
                                   <div class="d-flex justify-content-between align-items-center mb-2">
    <h4 class="card-title mb-0">Syarat Pengajuan Surat</h4>
    <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
</div>

<p class="card-text">Berikut adalah syarat yang harus dipenuhi untuk mengajukan surat:</p>

                        <!-- Surat Keterangan Usaha -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Usaha (SKU)</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Akta yang sudah diisi (apabila ada)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Tidak Mampu -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Tidak Mampu (SKTM)</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Kematian -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Kematian</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Kelahiran -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Kelahiran</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Belum Menikah -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Belum Menikah</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan untuk Menikah -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan untuk Menikah</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Pengajuan PBB Baru -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Pengajuan PBB Baru</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy Sertifikat/IMB 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Ahli Waris -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Ahli Waris</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Berkelakuan Baik -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Berkelakuan Baik</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Surat Keterangan Domisili -->
                        <div class="card mb-3" style="border: 1px solid #ccc; border-radius: 10px;">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom: 10px;">Surat Keterangan Domisili</h5>
                                <div style="border-bottom: 2px solid black; margin-bottom: 10px;"></div>
                                <ul class="card-text">
                                    <li>Foto Copy KTP 1 Lembar</li>
                                    <li>Foto Copy KK 1 Lembar</li>
                                    <li>Foto Copy Formulir yang sudah diisi dan TTD RT 1 lembar</li>
                                </ul>
                            </div>
                        </div>

                        <div class="text-center mt-4 mb-4">
                            <a href="pengajuan_surat.php" class="btn btn-primary">Ajukan Surat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="footer">
            <div class="copyright">
                <p class="mb-0">© <span id="current-year"></span> DPKUKMP Palangka Raya. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
    <script src="./js/dashboard/dashboard-1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'info',
            iconColor: '#C51F1A',
            title: 'Perhatian',
            html: 'Jika sudah mendownload formulir dan mengisi formulir,<br>untuk pengajuan surat silahkan ke pengajuan surat.',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#3085d6'
        });
    });
</script>
</body>
</html>
