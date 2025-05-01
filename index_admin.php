<?php
session_start();
include 'config.php'; // Koneksi ke database

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Cek apakah pengguna ada di tabel admin
$user_id = $_SESSION['id'];
$stmt = $koneksi->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_user = $stmt->get_result();


if ($result_user->num_rows == 0) {
    header("Location: page-error-403.php");
    exit();
}

$username = $_SESSION['username'];

// Total user
$stmt = $koneksi->prepare("SELECT COUNT(*) AS total_user FROM user");
$stmt->execute();
$result = $stmt->get_result();
$totalUser = $result->fetch_assoc()['total_user'] ?? 0;

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

$koneksi->close();
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kelurahan Kelampangan</title>
    <link rel="icon" type="image/png" href="images/logopky.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <div class="brand-logo">
                <div class="logo-container">
                    <div class="logo-pky"><img src="images/logopky.png" alt=""></div>
                    <div class="brand-title">
                        <h4>KELURAHAN KELAMPANGAN<br>PALANGKA RAYA</h4>
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
                                <span class="ml-1" style="font-size: 15px; color: #494949;"><?php echo htmlspecialchars($username); ?></span>
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="profileUser.php"><i class="icon-user"></i> Profile</a></li>
                                        <li><a href="logout.php"><i class="icon-key"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php include 'sidebar_admin.php'; ?>

        <div class="content-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <!-- Total Users -->
                    <div class="col-md-4">
                        <div class="card" style="background-color: #80DEEA">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-users" style="font-size: 30px; color: #004D40"></i>
                                    <div class="ml-3">
                                        <h5 style="color: #26C6DA">Total Users</h5>
                                        <p style="color: #004D40">Jumlah: <?php echo $totalUser; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Surat -->
                    <div class="col-md-4">
                        <div class="card" style="background-color: #7E8EF1">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-file" style="font-size: 30px; color: #091057"></i>
                                    <div class="ml-3">
                                        <h5 style="color: #091057">Total Surat</h5>
                                        <p style="color: #F57F17">Jumlah: <?php echo $totalPengajuanSurat; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Surat Menunggu -->
                    <div class="col-md-4">
                        <div class="card" style="background-color: #FF7043">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-clock" style="font-size: 30px; color: #BF360C"></i>
                                    <div class="ml-3">
                                        <h5 style="color: #E64A19">Surat Menunggu</h5>
                                        <p style="color: #BF360C">Jumlah: <?php echo $totalSuratMenunggu; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Surat Diterima -->
                    <div class="col-md-4">
                        <div class="card" style="background-color: #FF8A65">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check" style="font-size: 30px; color: #D84315"></i>
                                    <div class="ml-3">
                                        <h5 style="color: #D84315">Surat Diterima</h5>
                                        <p style="color: #BF360C">Jumlah: <?php echo $totalSuratDiterima; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Surat Ditolak -->
                    <div class="col-md-4">
                        <div class="card" style="background-color: #9CCC65">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-times" style="font-size: 30px; color: #33691E"></i>
                                    <div class="ml-3">
                                        <h5 style="color: #7CB342">Surat Ditolak</h5>
                                        <p style="color: #33691E">Jumlah: <?php echo $totalSuratDitolak; ?></p>
                                    </div>
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

    <!-- Scripts -->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
