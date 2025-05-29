<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

$user_id = $_SESSION['id'];
$sql_admin = "SELECT * FROM admin WHERE id = '$user_id'";
$result_admin = $koneksi->query($sql_admin);
if ($result_admin->num_rows == 0) {
    header("Location: .php");
    exit();
}

$nik_error = '';
$username_error = '';
$row = [];

if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $query = "SELECT * FROM user WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p class='text-red-500'>Data tidak ditemukan.</p>";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $koneksi->real_escape_string($_POST['id']);
    $nik = $koneksi->real_escape_string($_POST['nik']);
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $no_telepon = $koneksi->real_escape_string($_POST['no_telepon']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $check_nik_query = "SELECT * FROM user WHERE nik = '$nik' AND id != '$id'";
    $check_nik_result = mysqli_query($koneksi, $check_nik_query);

    $check_username_query = "SELECT * FROM user WHERE username = '$username' AND id != '$id'";
    $check_username_result = mysqli_query($koneksi, $check_username_query);

    if (mysqli_num_rows($check_nik_result) > 0) {
        $nik_error = "NIK sudah terdaftar. Silakan gunakan NIK yang lain.";
    } elseif (mysqli_num_rows($check_username_result) > 0) {
        $username_error = "Username sudah terdaftar. Silakan gunakan username yang lain.";
    } else {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $update_query = "UPDATE user SET nama='$nama', nik='$nik', no_telepon='$no_telepon', email='$email', username='$username', password='$hashed_password' WHERE id='$id'";
        } else {
            $update_query = "UPDATE user SET nama='$nama', nik='$nik', no_telepon='$no_telepon', email='$email', username='$username' WHERE id='$id'";
        }

        if (mysqli_query($koneksi, $update_query)) {
            header("Location: penggunaAdm.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
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
        <?php include 'sidebar_admin.php'; ?>
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
                                <h4 class="card-title">Edit Data Pengguna</h4>
                            <div class="card-table">

                            <div class="form-validation">
                                <form class="form-valide" action="edit_penggunaAdm.php?id=<?php echo $id; ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'] ?? ''); ?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="nik">NIK 
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($row['nik'] ?? ''); ?>" required>
                                                <span style="color: red;"><?php echo $nik_error; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="nama">Nama Pengguna
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="no_telepon">Nomor Telepon 
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($row['no_telepon'] ?? ''); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="email">Email 
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="username">Username
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>" required>
                                                <span style="color: red;"><?php echo $username_error; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="password">Password
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control" id="password" name="password" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="penggunaAdm.php" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
        </div>
        <!--**********************************
            Content body end
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
        document.getElementById("eye-icon").addEventListener("click", function() {
    var passwordField = document.getElementById("password");
    var icon = this.querySelector("i");
    
    if (passwordField.type === "password") {
        passwordField.type = "text"; // Tampilkan password
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password"; // Sembunyikan password
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});
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