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

// Query untuk menghitung jumlah setiap jenis surat
$surat_types = [
    'Surat Keterangan Tidak Mampu' => 'SKTM',
    'Surat Keterangan Kematian' => 'SKKM',
    'Surat Keterangan Kelahiran' => 'SKKL',
    'Surat Keterangan Pindah' => 'SKP',
    'Surat Keterangan Belum Menikah' => 'SKBM',
    'Surat Keterangan Untuk Menikah' => 'SKUM',
    'Pengajuan PBB Baru' => 'PBB',
    'Surat Keterangan Ahli Waris' => 'SKAW',
    'Surat Keterangan Berkelakuan Baik' => 'SKBB',
    'Surat Keterangan Domisili' => 'SKD'
];

$surat_counts = [];

foreach ($surat_types as $type_name => $type_code) {
    // Menghitung jumlah pengajuan untuk jenis surat tertentu
    $sql_count = "SELECT COUNT(*) AS jumlah FROM pengajuan_surat WHERE jenis_surat = '$type_code'";
    $result_count = $koneksi->query($sql_count);
    
    if ($result_count->num_rows > 0) {
        $row = $result_count->fetch_assoc();
        $surat_counts[$type_name] = $row['jumlah'];
    } else {
        $surat_counts[$type_name] = 0;
    }
}

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
                    <?php
                    $dataSurat = [
                        ['nama' => 'Surat Keterangan Tidak Mampu', 'jumlah' => $surat_counts['Surat Keterangan Tidak Mampu'], 'bg' => '#80DEEA', 'border' => '#26C6DA', 'text' => '#004D40', 'icon' => 'fa-file'],
                        ['nama' => 'Surat Keterangan Kematian', 'jumlah' => $surat_counts['Surat Keterangan Kematian'], 'bg' => '#7E8EF1', 'border' => '#091057', 'text' => '#091057', 'icon' => 'fa-cross'],
                        ['nama' => 'Surat Keterangan Kelahiran', 'jumlah' => $surat_counts['Surat Keterangan Kelahiran'], 'bg' => '#FFEB3B', 'border' => '#FBC02D', 'text' => '#F57F17', 'icon' => 'fa-baby'],
                        ['nama' => 'Surat Keterangan Pindah', 'jumlah' => $surat_counts['Surat Keterangan Pindah'], 'bg' => '#FF7043', 'border' => '#E64A19', 'text' => '#BF360C', 'icon' => 'fa-exchange-alt'],
                        ['nama' => 'Surat Keterangan Belum Menikah', 'jumlah' => $surat_counts['Surat Keterangan Belum Menikah'], 'bg' => '#8D6E63', 'border' => '#5D4037', 'text' => '#3E2723', 'icon' => 'fa-ring'],
                        ['nama' => 'Surat Keterangan Untuk Menikah', 'jumlah' => $surat_counts['Surat Keterangan Untuk Menikah'], 'bg' => '#FF8A65', 'border' => '#D84315', 'text' => '#BF360C', 'icon' => 'fa-gift'],
                        ['nama' => 'Pengajuan PBB Baru', 'jumlah' => $surat_counts['Pengajuan PBB Baru'], 'bg' => '#9CCC65', 'border' => '#7CB342', 'text' => '#33691E', 'icon' => 'fa-home'],
                        ['nama' => 'Surat Keterangan Ahli Waris', 'jumlah' => $surat_counts['Surat Keterangan Ahli Waris'], 'bg' => '#FF9800', 'border' => '#F57C00', 'text' => '#E65100', 'icon' => 'fa-book'],
                        ['nama' => 'Surat Keterangan Berkelakuan Baik', 'jumlah' => $surat_counts['Surat Keterangan Berkelakuan Baik'], 'bg' => '#81C784', 'border' => '#388E3C', 'text' => '#1B5E20', 'icon' => 'fa-shield-alt'],
                        ['nama' => 'Surat Keterangan Domisili', 'jumlah' => $surat_counts['Surat Keterangan Domisili'], 'bg' => '#FFEB3B', 'border' => '#FBC02D', 'text' => '#F57F17', 'icon' => 'fa-map-marker-alt']
                    ];

                    foreach ($dataSurat as $surat) {
                        echo "
                        <div class='col-md-4'>
                            <div class='card' style='background-color: {$surat['bg']}'>
                                <div class='card-body'>
                                    <div class='d-flex align-items-center'>
                                        <i class='fa {$surat['icon']}' style='font-size: 30px; color: {$surat['text']}'></i>
                                        <div class='ml-3'>
                                            <h5 class='card-title' style='color: {$surat['border']}'>{$surat['nama']}</h5>
                                            <p class='card-text' style='color: {$surat['text']}'>Jumlah: {$surat['jumlah']}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                    ?>
                </div>
            </div>
        
            <!-- Syarat Pengajuan Surat Section Below -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <h4 class="card-title">Syarat Pengajuan Surat</h4>
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
</body>
</html>
