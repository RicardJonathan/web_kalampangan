<?php
session_start();
include '../config.php';

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Validasi file foto
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_size = $_FILES['foto']['size'];
    $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if (in_array($foto_ext, $allowed_ext)) {
        $foto_new_name = uniqid('foto_', true) . '.' . $foto_ext;
        $foto_path = '../images/fotopengumuman/' . $foto_new_name;

        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Simpan ke database
            $sql = "INSERT INTO pengumuman (judul, deskripsi, foto) VALUES ('$judul', '$deskripsi', '$foto_new_name')";
            if (mysqli_query($koneksi, $sql)) {
                $_SESSION['message'] = "Pengumuman berhasil ditambahkan.";
            } else {
                $_SESSION['error'] = "Gagal menambahkan ke database.";
            }
        } else {
            $_SESSION['error'] = "Gagal mengunggah gambar.";
        }
    } else {
        $_SESSION['error'] = "Format gambar tidak didukung. Gunakan JPG, JPEG, atau PNG.";
    }

    header("Location: ../pengumuman/pengumuman.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Tambah Pengumuman - DPKUKMP</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/logopky.png">
    <!-- Custom Stylesheet -->
    <link href="../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Tambahkan style tambahan jika diperlukan */
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
    <!-- Main wrapper -->
    <div id="main-wrapper">
        <!-- Nav header -->
        <div class="nav-header">
            <div class="brand-logo">
                <div class="logo-container">
                    <div class="logo-pky">
                        <img src="../images/logopky.png" alt="">
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
                                <img src="../images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span> 
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="../profile_admin.php"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <li><a href="../logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <?php include '../layouts/side.php'; ?>
        <!-- Content body -->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Pengumuman</a></li>
                    </ol>
                </div>
            </div>
            <!-- Container fluid -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Tambah Pengumuman</h4>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="judul">Judul Pengumuman:</label>
                                        <input type="text" class="form-control" id="judul" name="judul" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto (JPG, JPEG, PNG):</label>
                                        <input type="file" class="form-control-file" id="foto" name="foto" accept=".jpg,.jpeg,.png" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="../pengumuman/pengumuman.php" class="btn btn-secondary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="footer">
            <div class="copyright">
                <p class="mb-0">© <span id="current-year"></span> @kkn_mandiri_kalampangan | Website oleh Mahasiswa KKN-T Mandiri Kelompok 2 2025</p>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script src="../plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>
    <script src="../plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    // SweetAlert untuk pesan sukses
    if (isset($_SESSION['message'])) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{$_SESSION['message']}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>";
        unset($_SESSION['message']);
    }

    // SweetAlert untuk pesan error
    if (isset($_SESSION['error'])) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{$_SESSION['error']}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>";
        unset($_SESSION['error']);
    }
    ?>
</body>
</html>
