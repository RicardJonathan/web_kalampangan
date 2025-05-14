<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Cek ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: struktur.php");
    exit();
}

$id = $_GET['id'];

// Ambil data struktur
$stmt = $koneksi->prepare("SELECT * FROM struktur WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    $_SESSION['error'] = "Data tidak ditemukan.";
    header("Location: struktur.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $posisi = $_POST['posisi'];
    $foto_new_name = $data['foto'];

    if (!empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];

        if (in_array($foto_ext, $allowed_ext)) {
            $foto_new_name = uniqid('foto_', true) . '.' . $foto_ext;
            $foto_path = './images/fotostruktur/' . $foto_new_name;

            if (move_uploaded_file($foto_tmp, $foto_path)) {
                // Hapus foto lama jika ada
                $old_path = "./images/fotostruktur/" . $data['foto'];
                if (!empty($data['foto']) && file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                $_SESSION['error'] = "Gagal mengunggah gambar.";
                header("Location: edit_struktur.php?id=" . urlencode($id));
                exit();
            }
        } else {
            $_SESSION['error'] = "Format gambar tidak didukung (harus JPG, JPEG, PNG).";
            header("Location: edit_struktur.php?id=" . urlencode($id));
            exit();
        }
    }

    // Gunakan prepared statement untuk update
    $stmt_update = $koneksi->prepare("UPDATE struktur SET nama = ?, posisi = ?, foto = ? WHERE id = ?");
    $stmt_update->bind_param("sssi", $nama, $posisi, $foto_new_name, $id);

    if ($stmt_update->execute()) {
        $_SESSION['message'] = "struktur berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data.";
    }

    header("Location: struktur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kelurahan Kalampangan</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <link href="plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/>
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        <!-- Nav header -->
        <div class="nav-header">
            <div class="brand-logo">
                <div class="logo-container">
                    <div class="logo-pky"><img src="images/logopky.png" alt=""></div>
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
                    <div class="hamburger"><span class="toggle-icon"><i class="icon-menu"></i></span></div>
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
        <?php include 'sidebar_admin.php'; ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit struktur</a></li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit struktur</h4>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nama">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="posisi">Posisi:</label>
                                        <input class="form-control" id="posisi" name="posisi" rows="5" value="<?= htmlspecialchars($data['posisi']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Saat Ini:</label><br>
                                        <?php if (!empty($data['foto'])): ?>
                                            <img src="./images/fotostruktur/<?= $data['foto'] ?>" alt="Foto" width="200"><br><br>
                                        <?php endif; ?>
                                        <label for="foto">Ganti Foto (Opsional - JPG, JPEG, PNG):</label>
                                        <input type="file" class="form-control-file" id="foto" name="foto" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="struktur.php" class="btn btn-secondary">Kembali</a>
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

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <?php
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
