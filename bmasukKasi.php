<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

$user_id = $_SESSION['id'];

$sql_kasi = "SELECT * FROM kasi WHERE id = ?";
$stmt_kasi = $koneksi->prepare($sql_kasi);
$stmt_kasi->bind_param("i", $user_id);
$stmt_kasi->execute();
$result_kasi = $stmt_kasi->get_result();

if ($result_kasi->num_rows == 0) {
    header("Location: page-error-400.php");
    exit();
}

$kasi_data = $result_kasi->fetch_assoc();

$jenis_surat_dikelola = json_decode($kasi_data['jenis_surat_dikelola'], true);

if (!$jenis_surat_dikelola || count($jenis_surat_dikelola) === 0) {
    die("Anda belum memiliki jenis surat yang dikelola.");
}

$placeholders = implode(',', array_fill(0, count($jenis_surat_dikelola), '?'));

$query = "
    SELECT pengajuan_surat.*, user.nik, user.nama
    FROM pengajuan_surat
    INNER JOIN user ON pengajuan_surat.user_id = user.id
    WHERE pengajuan_surat.status = 'Verifikasi Kasi'
    AND pengajuan_surat.jenis_surat IN ($placeholders)
    ORDER BY pengajuan_surat.id DESC
";

$stmt = $koneksi->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $koneksi->error);
}

$stmt->bind_param(str_repeat('s', count($jenis_surat_dikelola)), ...$jenis_surat_dikelola);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
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
        /* Custom Styles */
        .table, .table th, .table td {
            border: none !important;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table th {
            color: #F4F6FF;
            background-color: #7571F9 !important;
        }

        .table td {
            color: #3C3D37;
            background-color: #f9f9f9;
        }

        .btn-info {
            background-color: rgb(48, 160, 235);
            border-color: rgb(29, 189, 213);
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }

        .modal-dialog {
            max-width: 80%;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
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
                                        <li><a href="profile_kasi.php"><i class="icon-user"></i> Profile</a></li>
                                        <li><a href="logout.php"><i class="icon-key"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php include 'sidebar_kasi.php'; ?>

       <div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Main Menu</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengajuan Surat</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Berkas Masuk Pengajuan</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Surat</th>
                                        <th>ID</th>
                                        <th>Nama Pengaju</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Alamat</th>
                                        <th>Tanggal</th>
                                        <th>KTP</th>
                                        <th>KK</th>
                                        <th>Formulir</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nomor = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $tgl = strtotime($row['tgl_pengajuan']);
                                            $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            $tanggal_lengkap = date('d', $tgl) . ' ' . $bulan[date('n', $tgl)] . ' ' . date('Y', $tgl);
                                    ?>
                                            <tr>
                                                <td><?= $nomor++ . '.'; ?></td>
                                                <td><?= htmlspecialchars($row['jenis_surat']); ?></td>
                                                <td><?= htmlspecialchars($row['id']); ?></td>
                                                <td><?= htmlspecialchars($row['nama_pengaju']); ?></td>
                                                <td><?= htmlspecialchars($row['email_pengaju']); ?></td>
                                                <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                                                <td><?= htmlspecialchars($row['alamat']); ?></td>
                                                <td><?= $tanggal_lengkap; ?></td>
                                                <td><a href="preview_file_kasi.php?file=<?= urlencode($row['foto_ktp']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                <td><a href="preview_file_kasi.php?file=<?= urlencode($row['foto_kk']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                <td><a href="preview_file_kasi.php?file=<?= urlencode($row['foto_formulir']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                                <td><?= htmlspecialchars($row['status']); ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-warning btn-sm" onclick="prosesSurat(<?= $row['id']; ?>)">
                                                            <i class="fas fa-paper-plane"></i> Ajukan
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="tolakSurat(<?= $row['id']; ?>, 'Admin')">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </button>
                                                        <a href="edit_pengajuan_surat_kasi.php.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['id']; ?>">
                                                            <i class="fas fa-info-circle"></i> Detail
                                                        </button>
                                                        <!-- Tombol Upload Surat -->
                                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#uploadModal<?= $row['id']; ?>">
                                                            <i class="fas fa-upload"></i> Upload Surat
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Upload Surat -->
                                            <div class="modal fade" id="uploadModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="uploadModalLabel<?= $row['id']; ?>">Upload Surat - ID <?= $row['id']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="upload_surat.php" method="POST" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label for="file_surat<?= $row['id']; ?>">Pilih File Surat</label>
                                                                    <input type="file" class="form-control" name="file_surat" id="file_surat<?= $row['id']; ?>" required>
                                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                                </div>
                                                                <button type="submit" name="submit" class="btn btn-primary">Upload Surat</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='14' class='text-center'>Tidak ada data pengajuan surat.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

           

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>

    <script>
        function prosesSurat(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengajukan Surat ini kepada kepala kelurahan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ajukan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_status_surat.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                Swal.fire('Berhasil!', 'Surat berhasil diajukan.', 'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan. Surat gagal diajukan.', 'error');
                            }
                        }
                    };
                    xhr.send("id=" + id + "&status=Verifikasi Lurah");
                }
            });
        }

        function tolakSurat(id, role) {
            Swal.fire({
                title: 'Masukkan Alasan Penolakan',
                input: 'textarea',
                inputPlaceholder: 'Tuliskan alasan penolakan di sini...',
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan penolakan tidak boleh kosong!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var alasan_penolakan = result.value;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_status_surat.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            try {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    Swal.fire('Ditolak!', 'Pengajuan surat telah ditolak.', 'success')
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    Swal.fire('Gagal!', response.message || 'Terjadi kesalahan. surat gagal ditolak.', 'error');
                                }
                            } catch (e) {
                                Swal.fire('Gagal!', 'Respon server tidak valid.', 'error');
                            }
                        }
                    };

                    xhr.send("id=" + id + "&status=Ditolak&role=" + encodeURIComponent(role) + "&alasan_penolakan=" + encodeURIComponent(alasan_penolakan));
                }
            });
        }
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