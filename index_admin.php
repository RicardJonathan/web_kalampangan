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

// Data statistik
$username = $_SESSION['username'];

// Total user
$sql_user = "SELECT COUNT(*) as total_user FROM user";
$result_user = $koneksi->query($sql_user);
$totalUser = ($result_user->num_rows > 0) ? $result_user->fetch_assoc()['total_user'] : 0;

// Total pengajuan surat
$sql_surat = "SELECT COUNT(*) as total_surat FROM pengajuan_surat";
$result_surat = $koneksi->query($sql_surat);
$totalPengajuanSurat = ($result_surat->num_rows > 0) ? $result_surat->fetch_assoc()['total_surat'] : 0;

// Surat menunggu
$sql_menunggu = "SELECT COUNT(*) as total_menunggu FROM pengajuan_surat WHERE status = 'Diajukan'";
$result_menunggu = $koneksi->query($sql_menunggu);
$totalSuratMenunggu = ($result_menunggu->num_rows > 0) ? $result_menunggu->fetch_assoc()['total_menunggu'] : 0;

// Surat diterima
$sql_diterima = "SELECT COUNT(*) as total_diterima FROM cuti WHERE status = 'Diterima'";
$result_diterima = $koneksi->query($sql_diterima);
$totalSuratDiterima = ($result_diterima->num_rows > 0) ? $result_diterima->fetch_assoc()['total_diterima'] : 0;

// Surat ditolak
$sql_ditolak = "SELECT COUNT(*) as total_ditolak FROM cuti WHERE status = 'Ditolak'";
$result_ditolak = $koneksi->query($sql_ditolak);
$totalSuratDitolak = ($result_ditolak->num_rows > 0) ? $result_ditolak->fetch_assoc()['total_ditolak'] : 0;

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

        <div class="content-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card" style="background-color: #80DEEA">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-users" style="font-size: 30px; color: #004D40"></i>
                                    <div class="ml-3">
                                        <h5 class="card-title" style="color: #26C6DA">Total Users</h5>
                                        <p class="card-text" style="color: #004D40">Jumlah: <?php echo $totalUser; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card" style="background-color: #7E8EF1">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-file" style="font-size: 30px; color: #091057"></i>
                                    <div class="ml-3">
                                        <h5 class="card-title" style="color: #091057">Total Surat</h5>
                                        <p class="card-text" style="color: #F57F17">Jumlah: <?php echo $totalPengajuanSurat; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card" style="background-color: #FF7043">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-clock" style="font-size: 30px; color: #BF360C"></i>
                                    <div class="ml-3">
                                        <h5 class="card-title" style="color: #E64A19">Surat Menunggu</h5>
                                        <p class="card-text" style="color: #BF360C">Jumlah: <?php echo $totalSuratMenunggu; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card" style="background-color: #FF8A65">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check" style="font-size: 30px; color: #D84315"></i>
                                    <div class="ml-3">
                                        <h5 class="card-title" style="color: #D84315">Surat Diterima</h5>
                                        <p class="card-text" style="color: #BF360C">Jumlah: <?php echo $totalSuratDiterima; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card" style="background-color: #9CCC65">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-times" style="font-size: 30px; color: #33691E"></i>
                                    <div class="ml-3">
                                        <h5 class="card-title" style="color: #7CB342">Surat Ditolak</h5>
                                        <p class="card-text" style="color: #33691E">Jumlah: <?php echo $totalSuratDitolak; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


                

        
                    </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
            <p class="mb-0">© <span id="current-year"></span> DPKUKMP Palangka Raya. All rights reserved.</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script>
    document.getElementById('filterTahun').addEventListener('change', function () {
        const selectedYear = this.value;
        window.location.href = `index.php?tahun=${selectedYear}`;
    });

    // Data dari PHP
    const dataCutiBulanan = <?php echo $jsonCutiBulanan; ?>;

    // Label bulan
    const bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    // Konfigurasi Chart.js
    const ctx = document.getElementById('grafikCuti').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Jumlah Pengajuan Cuti',
                data: dataCutiBulanan,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>



    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>