<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Cek user
$user_id = $_SESSION['id'];
$sql_admin = "SELECT * FROM user WHERE id = '$user_id'";
$result_admin = $koneksi->query($sql_admin);

if ($result_admin->num_rows == 0) {
    header("Location: .php");
    exit();
}

// Ambil data pengajuan_surat yang diterima
$query = "SELECT pengajuan_surat.*, user.nik, user.nama
          FROM pengajuan_surat
          INNER JOIN user ON pengajuan_surat.user_id = user.id
          WHERE pengajuan_surat.status = 'diterima' 
          ORDER BY pengajuan_surat.id DESC";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kelurahan Kalampangan</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .table, .table th, .table td {
            border: none !important;
        }
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            color: #F4F6FF;
            background-color: #7571F9 !important;
            font-size: 16px;
        }
        .table td {
            color: #3C3D37;
            background-color: #f9f9f9;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }
        .table tfoot th {
            background-color: white !important;
            color: #333;
            font-weight: bold;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
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
                    <div class="logo-pky">
                        <img src="images/logopky.png" alt="">
                    </div>
                    <div class="brand-title">
                        <h4>Kelurahan Kalampangan<br> PALANGKA RAYA</h4>
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
                                <span class="ml-1" style="font-size: 15px; color: #494949;"><?php echo $_SESSION['username']; ?></span> 
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="profile_admin.php"><i class="icon-user"></i> <span>Profile</span></a></li>
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
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="#">Surat Cuti</a></li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Pengajuan Surat</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Surat</th>
                                                <th>User ID</th>
                                                <th>Nama Pengaju</th>
                                                <th>Email</th>
                                                <th>No Telepon</th>
                                                <th>Alamat</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomor = 1;
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $filePath = 'uploads/surat/' . $row['file_surat'];
                                            ?>
                                            <tr>
                                                <td><?php echo $nomor++ . '.'; ?></td>
                                                <td><?php echo $row['jenis_surat']; ?></td>
                                                <td><?php echo $row['nik']; ?></td>
                                                <td><?php echo $row['nama']; ?></td>
                                                <td><?php echo $row['email_pengaju']; ?></td>
                                                <td><?php echo $row['no_telepon']; ?></td>
                                                <td><?php echo $row['alamat']; ?></td>
                                                <td>
                                                    <?php 
                                                    $tanggal = strtotime($row['tgl_pengajuan']);
                                                    $bulan = [
                                                        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                                    ];
                                                    echo date('d', $tanggal) . ' ' . $bulan[date('n', $tanggal)] . ' ' . date('Y', $tanggal);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['status'] == 'Menunggu'): ?>
                                                        <span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Menunggu Konfirmasi</span>
                                                    <?php elseif ($row['status'] == 'Diajukan'): ?>
                                                        <span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi Admin</span>
                                                    <?php elseif ($row['status'] == 'Diterima'): ?>
                                                        <span class="text-success"><i class="fa-solid fa-check-circle"></i> Diterima</span>
                                                    <?php elseif (strpos($row['status'], 'Ditolak oleh') !== false): ?>
                                                        <span class="text-danger"><i class="fa-solid fa-times-circle"></i> <?= htmlspecialchars($row['status']); ?></span>
                                                    <?php elseif ($row['status'] == 'Diproses'): ?>
                                                        <span class="badge badge-warning"><i class="fas fa-spinner fa-spin"></i> Verifikasi Kadis</span>
                                                    <?php else: ?>
                                                        <span class="text-secondary"><i class="fa-solid fa-question-circle"></i> Tidak Diketahui</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($row['file_surat']) && file_exists($filePath)) { ?>
                                                        <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-success btn-sm">
                                                            <i class="fa fa-print"></i> Cetak Surat
                                                        </a>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="alert('File surat tidak ditemukan!');">
                                                            <i class="fa fa-exclamation-triangle"></i> File Hilang
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            } else {
                                            ?>
                                            <tr>
                                                <td colspan="10" class="text-center">Data pengajuan surat masih kosong</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Surat</th>
                                                <th>User ID</th>
                                                <th>Nama Pengaju</th>
                                                <th>Email</th>
                                                <th>No Telepon</th>
                                                <th>Alamat</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
    <script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script>
    function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `hapus_cuti.php?id=${id}`;
        }
    });
}

</script>

    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>