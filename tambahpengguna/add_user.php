<?php
session_start();
include '..//config.php';

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Cek apakah pengguna yang login ada di tabel lurah
$user_id = $_SESSION['id'];
$sql_lurah = "SELECT * FROM lurah WHERE id = '$user_id'";
$result_lurah = $koneksi->query($sql_lurah);

if ($result_lurah->num_rows == 0) {
    header("Location: .php");
    exit();
}

$nik_error = '';
$username_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];

    $check_nik_query = "SELECT * FROM user WHERE nik = '$nik'";
    $check_nik_result = mysqli_query($koneksi, $check_nik_query);

    $check_username_query = "SELECT * FROM user WHERE username = '$username'";
    $check_username_result = mysqli_query($koneksi, $check_username_query);

    if (mysqli_num_rows($check_nik_result) > 0) {
        $nik_error = "NIK sudah terdaftar. Silakan gunakan NIK yang lain.";
    } elseif (mysqli_num_rows($check_username_result) > 0) {
        $username_error = "Username sudah terdaftar. Silakan gunakan username yang lain.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO user (nik, nama, username, password, no_telepon, email) 
                         VALUES ('$nik', '$nama', '$username', '$hashed_password', '$no_telepon', '$email')";
        
        if (mysqli_query($koneksi, $insert_query)) {
            header("Location: pengguna.php");
            exit();
        } else {
            $nik_error = "Error: " . mysqli_error($koneksi);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kelurahan Kalampangan</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="..//images/logopky.png">
    <!-- Custom Stylesheet -->
    <link href="..//plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="..//css/style.css" rel="stylesheet">
    <link href="..//css/styles.css" rel="stylesheet">

    <style>
        .card-title {
            padding-top: 20px;
            padding-left: 30px;
        }
        .card-table {
            padding-left: 40px;
            padding-right: 40px;
        }
    </style>

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
                            <img src="..//images/logopky.png" alt="">
                        </div>
                        <div class="brand-title">
                            <h4>Kelurahan Kalampangan <br> PALANGKA RAYA</h4>
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
                                <img src="..//images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span> 
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="profile_lurah.php"><i class="icon-user"></i> <span>Profile</span></a>
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
        <?php include '..//sidebar_lurah.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengguna</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                                <h4 class="card-title">Tambah Data Pengguna</h4>
                            <div class="card-table">

                <div class="form-validation">
                   <!-- Tambah Data Pengguna -->
<form class="form-valide" action="..//tambahpengguna/user.php" method="post">
    <div class="form-group">
        <label for="nik">NIK <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required>
        <span style="color: red;"><?php echo $nik_error; ?></span>
    </div>
    <div class="form-group">
        <label for="nama">Nama <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
    </div>
    <div class="form-group">
        <label for="no_telepon">Nomor Telepon <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Masukkan nomor telepon.." required>
    </div>
    <div class="form-group">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email.." required>
    </div>
    <div class="form-group">
        <label for="username">Username <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username.." required>
        <span style="color: red;"><?php echo $username_error; ?></span>
    </div>
    <div class="form-group">
        <label for="password">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password.." required>
    </div>
    <div class="form-group text-right">
        <a href="..//tambahpengguna/user.php" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
            <p class="mb-0">© <span id="current-year"></span> Kelurahan Kalampangan Palangka Raya. All rights reserved.</p>
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

    <script src="..//plugins/common/common.min.js"></script>
    <script src="..//js/custom.min.js"></script>
    <script src="..//js/settings.js"></script>
    <script src="..//js/gleek.js"></script>
    <script src="..//js/styleSwitcher.js"></script>

    <script src="..//plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="..//plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="..//plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>