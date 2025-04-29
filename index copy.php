<?php
session_start();
include 'config.php'; // Koneksi ke database

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Cek apakah pengguna yang login adalah admin
$user_id = $_SESSION['id'];
$sql_admin = "SELECT * FROM admin WHERE id = '$user_id'";
$result_admin = $koneksi->query($sql_admin);

if ($result_admin->num_rows == 0) {
    header("Location: page-error-400.php");
    exit();
}

// Ambil tahun dari parameter GET, default tahun sekarang
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query data pengajuan surat per bulan di tahun tersebut
$sql_pengajuan_surat_bulanan = "
    SELECT 
        MONTH(tgl_ajuan) AS bulan,
        COUNT(*) AS total
    FROM pengajuan_surat
    WHERE YEAR(tgl_ajuan) = '$tahun'
    GROUP BY MONTH(tgl_ajuan)
    ORDER BY bulan ASC";
$result_pengajuan_surat_bulanan = $koneksi->query($sql_pengajuan_surat_bulanan);

// Siapkan array default dengan 12 bulan (1-12)
$dataPengajuanSuratBulanan = array_fill(1, 12, 0);
if ($result_pengajuan_surat_bulanan->num_rows > 0) {
    while ($row = $result_pengajuan_surat_bulanan->fetch_assoc()) {
        $dataPengajuanSuratBulanan[(int)$row['bulan']] = $row['total'];
    }
}
$jsonCutiBulanan = json_encode(array_values($dataPengajuanSuratBulanan));

// Ambil daftar tahun dari tabel 
$sql_tahun = "SELECT DISTINCT YEAR(tgl_ajuan) AS tahun FROM pengajuan_surat ORDER BY tahun ASC";
$result_tahun = $koneksi->query($sql_tahun);
$listTahun = [];
if ($result_tahun->num_rows > 0) {
    while ($row = $result_tahun->fetch_assoc()) {
        $listTahun[] = $row['tahun'];
    }
}


// Total pengajuan cuti
$sql_pengajuan = "SELECT COUNT(*) as total_surat FROM pengajuan_surat";
$result_pengajuan = $koneksi->query($sql_pengajuan);
$totalPengajuanSurat = ($result_pengajuan->num_rows > 0) ? $result_pengajuan->fetch_assoc()['total_surat'] : 0;


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
    <title>KELURAHAN</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                    <div class="logo-container">
                        <div class="logo-pky">
                            <img src="images/logopky.png" alt="">
                        </div>
                        <div class="brand-title">
                            <h4>KELURAHAN  KELAMPANGAN<br> PALANGKA RAYA</h4>
                        </div>
                    </div>
            </div>
        </div>

        <!--**********************************
            Nav header end
        ***********************************-->
        <!--**********************************
            Header start
        ***********************************-->
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
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <img src="images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span> 
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="profile_admin.php"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <li><a href="logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include 'sidebar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
            <div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card" style="background-color: #FFEB3B; border: 1px solid #FFC107; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h3 class="card-title" style="color: #212121; font-weight: normal;">Pengguna</h3>
                <h2 style="color: #212121; font-weight: normal;"><?php echo $totalUser; ?> User</h2>
                <span class="float-right display-5 opacity-5" style="color: #FF5722;"><i class="fa fa-users"></i></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card" style="background-color: #80DEEA; border: 1px solid #26C6DA; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h3 class="card-title" style="color: #004D40; font-weight: normal;">Pengajuan Surat</h3>
                <h2 style="color: #004D40; font-weight: normal;"><?php echo $totalPengajuanSurat; ?> Pengajuan</h2>
                <span class="float-right display-5 opacity-5" style="color: #009688;"><i class="fa-solid fa-pen-to-square"></i></span>
            </div>
        </div>
    </div>
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






        

                <div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="container mt-5">
                            <h4 class="text-center">Grafik Pengajuan Cuti Per Bulan</h4>
                            <!-- Dropdown Filter Tahun -->
                            <div class="d-flex justify-content-center mb-6">
    <label for="filterTahun" class="me-2 text-lg font-semibold text-gray-700">Pilih Tahun:</label>
    <select id="filterTahun" class="form-select px-4 py-2 border rounded-lg shadow-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-300 ease-in-out">
        <?php foreach ($listTahun as $tahunItem): ?>
            <option value="<?= $tahunItem ?>" <?= $tahunItem == $tahun ? 'selected' : '' ?>>
                <?= $tahunItem ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

                            <canvas id="grafikCuti"></canvas>
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