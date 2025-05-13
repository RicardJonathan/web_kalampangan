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

$sql_admin = "SELECT * FROM lurah WHERE id = '$user_id'";
$result_admin = $koneksi->query($sql_admin);

if ($result_admin->num_rows == 0) {
    // Jika tidak ada di tabel lurah, arahkan ke halaman error
    header("Location: page-error-400.php");
    exit();
}

// Tangkap filter tahun dari URL jika ada
$tahun_filter = isset($_GET['tahun']) ? $_GET['tahun'] : '';

// Query untuk mengambil daftar tahun dari kolom tgl_pengajuan
$query_tahun = "SELECT DISTINCT YEAR(tgl_pengajuan) AS tahun FROM pengajuan_surat ORDER BY tahun DESC";
$result_tahun = mysqli_query($koneksi, $query_tahun);

// Query utama untuk data pengajuan_surat dengan filter tahun jika ada
$query = "SELECT 
            user.nik, 
            user.nama, 
            YEAR(pengajuan_surat.tgl_pengajuan) AS tahun,
            COUNT(*) AS total_pengajuan_surat 
          FROM pengajuan_surat 
          INNER JOIN user ON pengajuan_surat.user_id = user.id";

// Tambahkan filter tahun jika diterapkan
if ($tahun_filter) {
    $query .= " WHERE YEAR(pengajuan_surat.tgl_pengajuan) = '$tahun_filter'";
}

$query .= " GROUP BY user.id, YEAR(pengajuan_surat.tgl_pengajuan) 
            ORDER BY tahun DESC, total_pengajuan_surat DESC";

$result = mysqli_query($koneksi, $query);

// Periksa jika query gagal
if (!$result || !$result_tahun) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>DPKUKMP</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <!-- Custom Stylesheet -->
    <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        /* Menghilangkan border dari tabel */
        .table,
        .table th,
        .table td {
            border: none !important;
        }
        /* Padding dan text-align untuk header dan data tabel */
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
        }
        .table tbody tr {
            border-bottom: none;
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
            font-size: 16px;
            background-color: #7571F9 !important;
        }
        .table td {
            color: #3C3D37;
            font-size: 14px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }
        .table tfoot th {
            background-color: white !important;
            color: #333;
            font-weight: bold;
        }
        .table-bordered {
            border: 1px solid #ddd;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
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

    <!-- Main Wrapper -->
    <div id="main-wrapper">
        <!-- Nav Header -->
        <div class="nav-header">
            <div class="brand-logo">
                <div class="logo-container">
                    <div class="logo-pky">
                        <img src="images/logopky.png" alt="">
                    </div>
                    <div class="brand-title">
                        <h4>Kelurahan Kalampangan <br> PALANGKA RAYA</h4>
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
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;">
                                    <?php echo $_SESSION['username']; ?>
                                </span> 
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
        <!-- Sidebar -->
        <?php include 'sidebar_lurah.php'; ?>

        <!-- Content Body -->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Pengajuan Surat</a></li>
                    </ol>
                </div>
            </div>
            <!-- Container -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Laporan Pengajuan Surat</h4>
                                <div class="d-flex justify-content-end">
                                    <!-- Form Filter Tahun -->
                                    <form action="" method="get" class="d-flex justify-content-end mb-3 mr-4">
                                        <label for="tahun" class="mr-2">Filter Tahun:</label>
                                        <select name="tahun" id="tahun" class="form-control w-auto" onchange="this.form.submit()">
                                            <option value="">Semua Tahun</option>
                                            <?php
                                            while ($row_tahun = mysqli_fetch_assoc($result_tahun)) {
                                                $selected = ($row_tahun['tahun'] == $tahun_filter) ? 'selected' : '';
                                                echo "<option value='{$row_tahun['tahun']}' $selected>{$row_tahun['tahun']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                    <!-- Tombol untuk cetak laporan -->
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <a href="cetak_laporan_surat.php?tahun=<?php echo $tahun_filter; ?>" class="btn btn-success">
                                            <i class="fa fa-print"></i> Cetak Laporan
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Total Pengajuan</th>
                                                <th>Tahun</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomor = 1;
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $nomor++ . '.'; ?></td>
                                                        <td><?php echo $row['nik']; ?></td>
                                                        <td><?php echo $row['nama']; ?></td>
                                                        <td><?php echo $row['total_pengajuan_surat']; ?></td>
                                                        <td><?php echo $row['tahun']; ?></td>
                                                    </tr>
                                                    <?php 
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Data pengajuan surat masih kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Total Pengajuan</th>
                                                <th>Tahun</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div><!-- End Card Body -->
                        </div><!-- End Card -->
                    </div><!-- End Col -->
                </div><!-- End Row -->
            </div><!-- End Container -->
        </div><!-- End Content Body -->
    </div><!-- End Main Wrapper -->
</body>
</html>

        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
            <p class="mb-0">© <span id="current-year"></span> Kelurahan  Kalampangan Palangka Raya. All rights reserved.</p>
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