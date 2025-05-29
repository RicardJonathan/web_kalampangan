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

$sql_kasi= "SELECT * FROM kasi WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_kadis = $koneksi->query($sql_kasi);

// if ($result_kadis->num_rows == 0) {
//     // Jika tidak ada di tabel admin, arahkan ke halaman error
//     header("Location: .php"); // Arahkan ke halaman error
//     exit();
// }

// Ambil tahun yang dipilih
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

// Ambil jumlah pengajuan per bulan untuk tahun tertentu
$dataPerBulan = [];
for ($bulan = 1; $bulan <= 12; $bulan++) {
    $stmt = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM pengajuan_surat WHERE YEAR(tgl_pengajuan) = ? AND MONTH(tgl_pengajuan) = ?");
    $stmt->bind_param("ii", $tahun, $bulan);
    $stmt->execute();
    $result = $stmt->get_result();
    $jumlah = $result->fetch_assoc()['jumlah'] ?? 0;
    $dataPerBulan[] = (int)$jumlah;
}
$jsonCutiBulanan = json_encode($dataPerBulan);

// Ambil daftar tahun unik
$stmt = $koneksi->prepare("SELECT DISTINCT YEAR(tgl_pengajuan) as tahun FROM pengajuan_surat ORDER BY tahun DESC");
$stmt->execute();
$result = $stmt->get_result();
$listTahun = [];
while ($row = $result->fetch_assoc()) {
    $listTahun[] = $row['tahun'];
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

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kelurahan Kalampangan</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper">

        <!-- Nav header -->
        <div class="nav-header">
            <div class="brand-logo">
                <div class="logo-container">
                    <div class="logo-pky">
                        <img src="images/logopky.png" alt="">
                    </div>
                    <div class="brand-title">
                        <h4>Kelurahan Kalampangan<br> PALANGKA RAYA</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
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
                                        <li>
                                            <a href="profile_kasi.php"><i class="icon-user"></i> <span>Profile</span></a>
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

        <!-- Sidebar -->
        <?php include 'sidebar_kasi.php'; ?>

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

                <!-- Grafik -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="container mt-5">
                                    <h4 class="text-center">Grafik Pengajuan Surat Per Bulan</h4>
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

                                    <canvas id="grafikSurat"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="copyright">
                <p class="mb-0">© <span id="current-year"></span> Kelurahan Kalampangan Palangka Raya. All rights reserved.</p>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();

        document.getElementById('filterTahun').addEventListener('change', function () {
            const selectedYear = this.value;
            window.location.href = `index.php?tahun=${selectedYear}`;
        });

        // Data dari PHP
        const dataPengajuanBulan = <?php echo $jsonCutiBulanan; ?>;

        // Label bulan
        const bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Konfigurasi Chart.js
        const ctx = document.getElementById('grafikSurat').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Jumlah Pengajuan Surat',
                    data: dataPengajuanBulan,
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

</body>
</html>
