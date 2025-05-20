<?php
session_start();
include 'config.php';
include './profileUser/edit.php';

// Pastikan pengguna telah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kelurahan Kalampangan</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
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

        <!-- Nav Header -->
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
                                <span class="ml-1" style="font-size: 15px; color: #494949;"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="#"><i class="icon-user"></i> <span>Profile</span></a></li>
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
        <?php include 'sidebarUser.php'; ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="indexUser.php">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="#">Profile Akun</a></li>
                    </ol>
                </div>
            </div>

            <div class="container">
                <h4 class="text-primary mb-4">Profil Akun</h4>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'] ?? ''); ?>">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control" value="<?php echo htmlspecialchars($row['nik'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telepon" class="form-control" value="<?php echo htmlspecialchars($row['no_telepon'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                         <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($row['password'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <a href="indexUser.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Edit Akun</button>
                        </form>

                        <?php if (isset($error_message)): ?>
                            <div class="mt-3 alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                        <?php endif; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
