<?php
session_start();
include 'config.php';

// Validasi login & akses admin
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

$user_id = $_SESSION['id'];
$cek_admin = $koneksi->prepare("SELECT * FROM lurah WHERE id = ?");
$cek_admin->bind_param("i", $user_id);
$cek_admin->execute();
$cek_admin_result = $cek_admin->get_result();

if ($cek_admin_result->num_rows === 0) {
    header("Location: .php");
    exit();
}
$cek_admin->close();

$nip_error = $username_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars(trim($_POST['nama']));
    $nip = htmlspecialchars(trim($_POST['nip']));
    $pangkat = htmlspecialchars(trim($_POST['pangkat']));
    $golongan = htmlspecialchars(trim($_POST['golongan']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Validasi NIP
    $cek_nip = $koneksi->prepare("SELECT id FROM kasi WHERE nip = ?");
    $cek_nip->bind_param("s", $nip);
    $cek_nip->execute();
    $cek_nip->store_result();

    // Validasi username
    $cek_user = $koneksi->prepare("SELECT id FROM kasi WHERE username = ?");
    $cek_user->bind_param("s", $username);
    $cek_user->execute();
    $cek_user->store_result();

    if ($cek_nip->num_rows > 0) {
        $nip_error = "NIP sudah terdaftar.";
    } elseif ($cek_user->num_rows > 0) {
        $username_error = "Username sudah digunakan.";
    } else {
        // Insert data admin baru
        $stmt = $koneksi->prepare("INSERT INTO kasi (nama, nip, pangkat, golongan, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nama, $nip, $pangkat, $golongan, $username, $password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Kasi berhasil ditambahkan.";
            header("Location: kasi.php");
            exit();
        } else {
            $_SESSION['error'] = "Gagal menambahkan kasi.";
        }

        $stmt->close();
    }

    $cek_nip->close();
    $cek_user->close();
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
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <!-- Custom Stylesheet -->
    <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

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
                            <img src="images/logopky.png" alt="">
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
                                <img src="images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span> 
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
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
        <?php include 'sidebar_lurah.php'; ?>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Kasi</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                                <h4 class="card-title">Tambah Data Kasi</h4>
                            <div class="card-table">

                <div class="form-validation">
                   <!-- Tambah Data Pengguna -->
<form class="form-valide" action="tambah_kasi.php" method="post">
    <div class="form-group">
        <label for="nama">Nama <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
    </div>
    <div class="form-group">
        <label for="nip">NIP <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required>
        <span style="color: red;"><?php echo $nip_error; ?></span>
    </div>
    <div class="form-group">
        <label for="pangkat">Pangkat <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="pangkat" name="pangkat" placeholder="Masukkan pangkat" required>
    </div>
    <div class="form-group">
        <label for="golongan">Golongan <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="golongan" name="golongan" placeholder="Masukkan golongan" required>
    </div>
    <div class="form-group">
        <label for="username">Username <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
        <span style="color: red;"><?php echo $username_error; ?></span>
    </div>
    <div class="form-group">
        <label for="password">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
    </div>
    <div class="form-group text-right">
        <a href="kasi.php" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
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