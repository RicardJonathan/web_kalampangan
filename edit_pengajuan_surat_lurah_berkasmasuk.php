<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (!isset($_GET['id'])) {
    header("Location: berkas_masuk_lurah.php");
    exit();
}

$id_pengajuan = $_GET['id'];

// Ambil data lama
$stmt = $koneksi->prepare("SELECT * FROM pengajuan_surat WHERE id = ?");
$stmt->bind_param("i", $id_pengajuan);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_surat = $_POST['jenis_surat'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];

    // Proses file
    $foto_ktp = uploadFile("foto_ktp", $row['foto_ktp']);
    $foto_kk = uploadFile("foto_kk", $row['foto_kk']);
    $foto_formulir = uploadFile("foto_formulir", $row['foto_formulir']);
    $file_surat = uploadFile("file_surat", $row['file_surat'], ['application/pdf', 'image/jpeg', 'image/png', 'image/gif']);

    // Update data
    $query = "UPDATE pengajuan_surat SET jenis_surat=?, alamat=?, keterangan=?, foto_ktp=?, foto_kk=?, foto_formulir=?, file_surat=? WHERE id=?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssssssi", $jenis_surat, $alamat, $keterangan, $foto_ktp, $foto_kk, $foto_formulir, $file_surat, $id_pengajuan);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Berhasil diperbarui.";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui data.";
    }

    header("Location: berkas_masuk_lurah.php");
    exit();
}

function uploadFile($field, $oldFile, $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'application/pdf']) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== 0) {
        return $oldFile;
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $name = basename($_FILES[$field]['name']);
    $type = mime_content_type($tmp);

    if (!in_array($type, $allowedTypes)) {
        $_SESSION['error_message'] = "File $field harus berupa: " . implode(", ", $allowedTypes);
        header("Location: edit_pengajuan_surat_lurah.php?id=" . $_GET['id']);
        exit();
    }

    // Tentukan folder penyimpanan
    if ($field === 'file_surat') {
        if ($type === 'application/pdf') {
            $targetDir = 'uploads/surat/';
        } elseif (str_starts_with($type, 'image/')) {
            $targetDir = 'uploads/';
        } else {
            $_SESSION['error_message'] = "Format file_surat tidak didukung.";
            header("Location: edit_pengajuan_surat_lurah.php?id=" . $_GET['id']);
            exit();
        }
    } else {
        $targetDir = 'uploads/';
    }

    // Nama file unik
    $uniqueName = time() . "_" . preg_replace('/[^A-Za-z0-9_\.-]/', '_', $name);
    $destination = $targetDir . $uniqueName;

    if (!move_uploaded_file($tmp, $destination)) {
        $_SESSION['error_message'] = "Gagal mengupload file $field.";
        header("Location: edit_pengajuan_surat_lurah.php?id=" . $_GET['id']);
        exit();
    }

    return $uniqueName;
}
?>

<!DOCTYPE html>
<html lang="id">
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

    <?php include 'sidebar_lurah.php'; ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <h4 class="card-title">Edit Pengajuan Surat</h4>
                <div class="card-table">
                    <form action="edit_pengajuan_surat_lurah.php?id=<?= $row['id'] ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="jenis_surat">Jenis Surat</label>
                            <select name="jenis_surat" class="form-control" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                <?php
                                $jenis_options = [
                                    "SURAT KETERANGAN USAHA (SKU)",
                                    "SURAT KETERANGAN TIDAK MAMPU (SKTM)",
                                    "SURAT KETERANGAN KEMATIAN",
                                    "SURAT KETERANGAN KELAHIRAN",
                                    "SURAT KETERANGAN PINDAH",
                                    "SURAT KETERANGAN BELUM MENIKAH",
                                    "SURAT KETERANGAN UNTUK MENIKAH",
                                    "PENGAJUAN PBB BARU",
                                    "SURAT KETERANGAN AHLI WARIS",
                                    "SURAT KETERANGAN BERKELAKUAN BAIK",
                                    "SURAT KETERANGAN DOMISILI"
                                ];
                                foreach ($jenis_options as $opt) {
                                    $selected = ($row['jenis_surat'] == $opt) ? 'selected' : '';
                                    echo "<option value=\"$opt\" $selected>$opt</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Pengaju</label>
                            <input type="text" name="alamat" class="form-control" value="<?= $row['alamat'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="3"><?= $row['keterangan'] ?></textarea>
                        </div>

                        <?php
                        $fields = [
                            'foto_ktp' => 'Foto KTP',
                            'foto_kk' => 'Foto KK',
                            'foto_formulir' => 'Foto Formulir',
                            'file_surat' => 'File Surat'
                        ];

                        foreach ($fields as $name => $label):
                        ?>
                            <div class="form-group">
                                <label for="<?= $name ?>"><?= $label ?></label>
                                <input type="file" name="<?= $name ?>" class="form-control"
                                       accept="<?= $name == 'file_surat' ? 'application/pdf,image/*' : 'image/*' ?>">
                                <?php if ($row[$name]): ?>
                                    <?php
                                        $ext = pathinfo($row[$name], PATHINFO_EXTENSION);
                                        $folder = ($name === 'file_surat' && $ext === 'pdf') ? 'uploads/surat/' : 'uploads/';
                                        $path = $folder . $row[$name];
                                    ?>
                                    <?php if ($ext === 'pdf'): ?>
                                        <p><a href="<?= $path ?>" target="_blank">Lihat File PDF</a></p>
                                    <?php else: ?>
                                        <img src="<?= $path ?>" width="100">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="berkas_masuk_lurah.php" class="btn btn-secondary ml-2">Cancel</a>
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
