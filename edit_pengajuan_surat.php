<?php
session_start();
include 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Ambil data pengajuan surat dari database
if (isset($_GET['id'])) {
    $id_pengajuan = $_GET['id'];
    $sql = "SELECT * FROM pengajuan_surat WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_pengajuan);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
} else {
    header("Location: pengajuan_surat.php");
    exit();
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_surat = $_POST['jenis_surat'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];

    $foto_ktp = $_FILES['foto_ktp']['name'] ? $_FILES['foto_ktp']['name'] : $row['foto_ktp'];
    $foto_kk = $_FILES['foto_kk']['name'] ? $_FILES['foto_kk']['name'] : $row['foto_kk'];
    $foto_formulir = $_FILES['foto_formulir']['name'] ? $_FILES['foto_formulir']['name'] : $row['foto_formulir'];

    $target_dir = "uploads/";

    if ($_FILES['foto_ktp']['name']) {
        move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $target_dir . $foto_ktp);
    }
    if ($_FILES['foto_kk']['name']) {
        move_uploaded_file($_FILES['foto_kk']['tmp_name'], $target_dir . $foto_kk);
    }
    if ($_FILES['foto_formulir']['name']) {
        move_uploaded_file($_FILES['foto_formulir']['tmp_name'], $target_dir . $foto_formulir);
    }

    // Update data pengajuan surat
    $query = "UPDATE pengajuan_surat 
              SET jenis_surat = ?, alamat = ?, keterangan = ?, foto_ktp = ?, foto_kk = ?, foto_formulir = ? 
              WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssssi", $jenis_surat, $alamat, $keterangan, $foto_ktp, $foto_kk, $foto_formulir, $id_pengajuan);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Pengajuan surat Anda berhasil diperbarui.';
    } else {
        $_SESSION['error_message'] = 'Terjadi kesalahan saat memperbarui pengajuan surat.';
    }

    header("Location: pengajuan_surat.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kelurahan Kelampangan</title>
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
                                <span class="ml-1" style="font-size: 15px; color: #494949;"><?php echo $_SESSION['username']; ?></span>
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="profileUser.php"><i class="icon-user"></i> <span>Profile</span></a></li>
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

        <!-- Content -->
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
                    <h4 class="card-title">Edit Pengajuan Surat</h4>
                    <div class="card-table">
                        <form id="form-pengajuan" action="edit_pengajuan_surat.php?id=<?php echo $row['id']; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="jenis_surat">Jenis Surat</label>
                                <select name="jenis_surat" class="form-control" required>
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    <option value="SURAT KETERANGAN USAHA (SKU)" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN USAHA (SKU)') ? 'selected' : ''; ?>>SURAT KETERANGAN USAHA (SKU)</option>
                                    <option value="SURAT KETERANGAN TIDAK MAMPU (SKTM)" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN TIDAK MAMPU (SKTM)') ? 'selected' : ''; ?>>SURAT KETERANGAN TIDAK MAMPU (SKTM)</option>
                                    <option value="SURAT KETERANGAN KEMATIAN" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN KEMATIAN') ? 'selected' : ''; ?>>SURAT KETERANGAN KEMATIAN</option>
                                    <option value="SURAT KETERANGAN KELAHIRAN" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN KELAHIRAN') ? 'selected' : ''; ?>>SURAT KETERANGAN KELAHIRAN</option>
                                    <option value="SURAT KETERANGAN PINDAH" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN PINDAH') ? 'selected' : ''; ?>>SURAT KETERANGAN PINDAH</option>
                                    <option value="SURAT KETERANGAN BELUM MENIKAH" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN BELUM MENIKAH') ? 'selected' : ''; ?>>SURAT KETERANGAN BELUM MENIKAH</option>
                                    <option value="SURAT KETERANGAN UNTUK MENIKAH" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN UNTUK MENIKAH') ? 'selected' : ''; ?>>SURAT KETERANGAN UNTUK MENIKAH</option>
                                    <option value="PENGAJUAN PBB BARU" <?php echo ($row['jenis_surat'] == 'PENGAJUAN PBB BARU') ? 'selected' : ''; ?>>PENGAJUAN PBB BARU</option>
                                    <option value="SURAT KETERANGAN AHLI WARIS" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN AHLI WARIS') ? 'selected' : ''; ?>>SURAT KETERANGAN AHLI WARIS</option>
                                    <option value="SURAT KETERANGAN BERKELAKUAN BAIK" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN BERKELAKUAN BAIK') ? 'selected' : ''; ?>>SURAT KETERANGAN BERKELAKUAN BAIK</option>
                                    <option value="SURAT KETERANGAN DOMISILI" <?php echo ($row['jenis_surat'] == 'SURAT KETERANGAN DOMISILI') ? 'selected' : ''; ?>>SURAT KETERANGAN DOMISILI</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Pengaju</label>
                                <input type="text" class="form-control" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan (Opsional)</label>
                                <textarea class="form-control" name="keterangan" rows="3"><?php echo $row['keterangan']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="foto_ktp">Foto KTP</label>
                                <input type="file" class="form-control" name="foto_ktp" accept="image/*">
                                <?php if ($row['foto_ktp']): ?>
                                    <img src="uploads/<?php echo $row['foto_ktp']; ?>" width="100">
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="foto_kk">Foto KK</label>
                                <input type="file" class="form-control" name="foto_kk" accept="image/*">
                                <?php if ($row['foto_kk']): ?>
                                    <img src="uploads/<?php echo $row['foto_kk']; ?>" width="100">
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="foto_formulir">Foto Formulir</label>
                                <input type="file" class="form-control" name="foto_formulir" accept="image/*">
                                <?php if ($row['foto_formulir']): ?>
                                    <img src="uploads/<?php echo $row['foto_formulir']; ?>" width="100">
                                <?php endif; ?>
                            <div class="form-group text-right">
                 <!-- Update Button -->
                <button type="submit" class="btn btn-primary">Update</button>
                 <!-- Cancel Button -->
                    <a href="pengajuan_surat.php" class="btn btn-secondary ml-2">Cancel</a>
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
</body>
</html>
