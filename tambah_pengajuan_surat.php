<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

$user_id = $_SESSION['id'];
$sql_user = "SELECT * FROM user WHERE id = ?";
$stmt = $koneksi->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows == 0) {
    header("Location: page-error-403.php");
    exit();
}

$user = $result_user->fetch_assoc();
$nama_pengaju = $user['nama'];
$email_pengaju = $user['email'];
$no_telepon = $user['no_telepon'];

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_surat = $_POST['jenis_surat'];
    $alamat = $_POST['alamat'];
    $tgl_pengajuan = date('Y-m-d');
    $keterangan = $_POST['keterangan'];

    $foto_ktp = $_FILES['foto_ktp']['name'];
    $foto_kk = $_FILES['foto_kk']['name'];
    $foto_formulir = $_FILES['foto_formulir']['name'];

    $target_dir = "uploads/";
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $target_dir . $foto_ktp);
    move_uploaded_file($_FILES['foto_kk']['tmp_name'], $target_dir . $foto_kk);
    move_uploaded_file($_FILES['foto_formulir']['tmp_name'], $target_dir . $foto_formulir);

    $status = 'Menunggu';

    $query = "INSERT INTO pengajuan_surat 
        (jenis_surat, user_id, nama_pengaju, email_pengaju, no_telepon, alamat, tgl_pengajuan, status, keterangan, foto_ktp, foto_kk, foto_formulir)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sissssssssss", $jenis_surat, $user_id, $nama_pengaju, $email_pengaju, $no_telepon, $alamat, $tgl_pengajuan, $status, $keterangan, $foto_ktp, $foto_kk, $foto_formulir);

    if ($stmt->execute()) {
        $success_message = 'Pengajuan surat Anda telah berhasil diajukan.';
    } else {
        $error_message = 'Terjadi kesalahan saat mengajukan surat.';
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
                            <h4>Kelurahan <br> PALANGKA RAYA</h4>
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
                                            <a href="profileUser.php"><i class="icon-user"></i> <span>Profile</span></a>
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
        <?php include 'sidebarUser.php'; ?>
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
                        <li class="breadcrumb-item"><a href="#">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="#">Pengajuan Surat</a></li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
                <div class="card">
                    <h4 class="card-title">Tambah Pengajuan Surat</h4>
                    <div class="card-table">
                        <form id="form-pengajuan" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="jenis_surat">Jenis Surat</label>
                                <select name="jenis_surat" class="form-control" required>
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    <option value="SURAT KETERANGAN USAHA (SKU)">SURAT KETERANGAN USAHA (SKU)</option>
                                    <option value="SURAT KETERANGAN TIDAK MAMPU (SKTM)">SURAT KETERANGAN TIDAK MAMPU (SKTM)</option>
                                    <option value="SURAT KETERANGAN KEMATIAN">SURAT KETERANGAN KEMATIAN</option>
                                    <option value="SURAT KETERANGAN KELAHIRAN">SURAT KETERANGAN KELAHIRAN</option>
                                    <option value="SURAT KETERANGAN PINDAH">SURAT KETERANGAN PINDAH</option>
                                    <option value="SURAT KETERANGAN BELUM MENIKAH">SURAT KETERANGAN BELUM MENIKAH</option>
                                    <option value="SURAT KETERANGAN UNTUK MENIKAH">SURAT KETERANGAN UNTUK MENIKAH</option>
                                    <option value="PENGAJUAN PBB BARU">PENGAJUAN PBB BARU</option>
                                    <option value="SURAT KETERANGAN AHLI WARIS">SURAT KETERANGAN AHLI WARIS</option>
                                    <option value="SURAT KETERANGAN BERKELAKUAN BAIK">SURAT KETERANGAN BERKELAKUAN BAIK</option>
                                    <option value="SURAT KETERANGAN DOMISILI">SURAT KETERANGAN DOMISILI</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Pengaju</label>
                                <input type="text" class="form-control" name="alamat" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan (Opsional)</label>
                                <textarea class="form-control" name="keterangan" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="foto_ktp">Foto KTP</label>
                                <input type="file" class="form-control" name="foto_ktp" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="foto_kk">Foto KK</label>
                                <input type="file" class="form-control" name="foto_kk" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="foto_formulir">Foto Formulir</label>
                                <input type="file" class="form-control" name="foto_formulir" accept="image/*" required>
                            </div>
                            <div class="form-group text-right">
                                <a href="pengajuan_surat.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="copyright">
                <p class="mb-0">© <span id="current-year"></span> Kelurahan Kelampangan Palangka Raya. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (!empty($success_message)) : ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?php echo $success_message; ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'pengajuan_surat.php';
            }
        });
    </script>
    <?php endif; ?>

    <?php if (!empty($error_message)) : ?>
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '<?php echo $error_message; ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    <?php endif; ?>
</body>
</html>
