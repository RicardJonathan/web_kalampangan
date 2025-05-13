<?php
session_start();
include 'config.php'; // File koneksi database
include './lurah/edit.php';
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
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <img src="images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1"
                                    style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span>
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="profile_admin.php"><i class="icon-user"></i>
                                                <span>Profile</span></a>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile Akun</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="container mt-0">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($update_success) && $update_success): ?>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data Berhasil Diperbarui',
                                    text: 'Data Kepala Dinas berhasil diupdate.',
                                    showConfirmButton: false,
                                    timer: 2500,
                                });
                            </script>
                        <?php endif; ?>
                        <h4 class="text-primary mb-4">Profil Akun</h4>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'] ?? ''); ?>">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Lengkap</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="nama"
                                        value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" class="form-control"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>NIP</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="nip"
                                        value="<?php echo htmlspecialchars($row['nip'] ?? ''); ?>" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Golongan</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="golongan"
                                        value="<?php echo htmlspecialchars($row['golongan'] ?? ''); ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Pangkat</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="pangkat"
                                        value="<?php echo htmlspecialchars($row['pangkat'] ?? ''); ?>"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Username</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="username"
                                        value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" name="password"
                                        value="<?php echo htmlspecialchars($row['password'] ?? ''); ?>"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Tanda Tangan</label>
                                    <span class="text-danger">*</span>
                                    <input type="file" name="ttd" class="form-control">
                                    <?php if ($row['ttd']) { ?>
                                        <p><img src="ttd/<?php echo $row['ttd']; ?>" alt="Tanda Tangan" width="100"
                                                style="margin-top: 15px;"></p>
                                    <?php } ?>
                                </div>
                            </div>

                            <a href="index.php" class="btn btn-secondary">Batal</a>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                        <?php if (isset($error_message)): ?>
                            <p class="text-red-500"><?php echo $error_message; ?></p>
                        <?php endif; ?>
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