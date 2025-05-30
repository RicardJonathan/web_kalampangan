<?php
session_start();
include 'config.php'; // Koneksi ke database

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Cek apakah pengguna yang login ada di tabel admin
$user_id = $_SESSION['id']; // ID pengguna yang login

$sql_admin = "SELECT * FROM lurah WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_admin = $koneksi->query($sql_admin);

if ($result_admin->num_rows == 0) {
    // Jika tidak ada di tabel lurah, arahkan ke halaman error
    header("Location: .php"); // Arahkan ke halaman error
    exit();
}

// Query untuk mengambil data surat dan data user (nik, nama) dengan JOIN dan status "Verifikasi Lurah"
$query = "SELECT pengajuan_surat.*, user.nik, user.nama
          FROM pengajuan_surat
          INNER JOIN user ON pengajuan_surat.user_id = user.id
          WHERE pengajuan_surat.status = 'Verifikasi Lurah' 
          ORDER BY pengajuan_surat.id DESC";
$result = mysqli_query($koneksi, $query);

// Cek jika query berhasil
if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}

$koneksi->close();
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
        /* Menghilangkan border dari tabel */
        .table,
        .table th,
        .table td {
            border: none !important;
        }

        /* Menambahkan padding untuk kenyamanan tampilan */
        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
        }

        /* Menghilangkan garis bawah pada setiap baris */
        .table tbody tr {
            border-bottom: none;
        }

        /* Jika ada hover effect, tetap pertahankan */
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk tabel */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Styling untuk baris header tabel */
        .table th {
            color: #F4F6FF;
            padding: 12px 15px;
            text-align: left;
            font-size: 16px;
            background-color: #7571F9 !important;
        }

        /* Styling untuk baris tabel */
        .table td {
            color: #3C3D37;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        /* Hover effect untuk baris tabel */
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk footer tabel */
        .table tfoot th {
            background-color: white !important;
            color: #333;
            font-weight: bold;
        }

        /* Menambahkan efek border pada tabel */
        .table-bordered {
            border: 1px solid #ddd;
        }

        /* Responsif - menyesuaikan tabel pada layar kecil */
        .table-responsive {
            overflow-x: auto;
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
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="profile_lurah.php"><i class="icon-user"></i>
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
            Header end
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengajuan Surat</a></li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Berkas Masuk Pengajuan Surat</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Surat</th>
                                                <th>User ID</th>
                                                <th>Nama Pengaju</th>
                                                <th>Email</th>
                                                <th>No Telepon</th>
                                                <th>Alamat</th>
                                                <th>Tanggal</th>
                                                <th>KTP</th>
                                                <th>KK</th>
                                                <th>Formulir</th>
                                                <th>File surat</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomor = 1;
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $tgl = strtotime($row['tgl_pengajuan']);
                                                    $batas_proses = strtotime("+3 days", $tgl); // Hitung batas proses
                                                    $hari_ini = strtotime("now"); // Tanggal hari ini
                                                    $selisih_hari = ($batas_proses - $hari_ini) / (60 * 60 * 24); // Hitung selisih hari

                                                    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                    $tanggal_lengkap = date('d', $tgl) . ' ' . $bulan[date('n', $tgl)] . ' ' . date('Y', $tgl);
                                                    $pesan_pengingat = "";

                                                    // Cek apakah selisih hari 2 atau 1
                                                    if ($selisih_hari == 2) {
                                                        $pesan_pengingat = "<span style='color:orange;'>Pengingat: Batas proses surat tinggal 2 hari lagi!</span>";
                                                    } elseif ($selisih_hari == 1) {
                                                        $pesan_pengingat = "<span style='color:red;'>Pengingat: Batas proses surat tinggal 1 hari lagi!</span>";
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?= $nomor++ . '.'; ?></td>
                                                        <td><?= htmlspecialchars($row['jenis_surat']); ?></td>
                                                        <td><?= htmlspecialchars($row['user_id']); ?></td>
                                                        <td><?= htmlspecialchars($row['nama_pengaju']); ?></td>
                                                        <td><?= htmlspecialchars($row['email_pengaju']); ?></td>
                                                        <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                                                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                                                        <td><?= $tanggal_lengkap; ?> <?= $pesan_pengingat; ?></td>
                                                        <td><a href="preview_file_lurah.php?file=<?= urlencode($row['foto_ktp']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                        <td><a href="preview_file_lurah.php?file=<?= urlencode($row['foto_kk']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                        <td><a href="preview_file_lurah.php?file=<?= urlencode($row['foto_formulir']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                        <td><a href="preview_file_lurah.php?file=<?= urlencode($row['file_surat']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                                                        <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-warning btn-sm" onclick="prosesSurat(<?= $row['id']; ?>)">
                                                                    <i class="fas fa-paper-plane"></i> Terima
                                                                </button>
                                                                <button class="btn btn-danger btn-sm" onclick="tolakSurat(<?= $row['id']; ?>, 'Admin')">
                                                                    <i class="fas fa-times"></i> Tolak
                                                                </button>
                                                                <a href="edit_pengajuan_surat_lurah_berkasmasuk.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['id']; ?>">
                                                                    <i class="fas fa-info-circle"></i> Detail
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Detail -->
                                                    <div class="modal fade" id="detailModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Pengajuan</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>ID:</strong> <?= $row['id']; ?></p>
                                                                    <p><strong>Jenis Surat:</strong> <?= htmlspecialchars($row['jenis_surat']); ?></p>
                                                                    <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama_pengaju']); ?></p>
                                                                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email_pengaju']); ?></p>
                                                                    <p><strong>No Telepon:</strong> <?= htmlspecialchars($row['no_telepon']); ?></p>
                                                                    <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></p>
                                                                    <p><strong>Tanggal:</strong> <?= $tanggal_lengkap; ?></p>
                                                                    <p><strong>Status:</strong> <?= htmlspecialchars($row['status']); ?></p>
                                                                    <p><strong>Keterangan:</strong> <?= htmlspecialchars($row['keterangan']); ?></p>
                                                                    <p><strong>KTP:</strong> <a href="preview_dokumen.php?file=<?= urlencode($row['foto_ktp']); ?>" class="btn btn-sm btn-info">Lihat</a></p>
                                                                    <p><strong>KK:</strong> <a href="preview_dokumen.php?file=<?= urlencode($row['foto_kk']); ?>" class="btn btn-sm btn-info">Lihat</a></p>
                                                                    <p><strong>Formulir:</strong> <a href="preview_dokumen.php?file=<?= urlencode($row['foto_formulir']); ?>" class="btn btn-sm btn-info">Lihat</a></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="14" class="text-center">Data pengajuan masih kosong</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <style>
            .btn-info {
                background-color: rgb(48, 160, 235);
                border-color: rgb(29, 189, 213);
            }

            .btn-info:hover {
                background-color: #138496;
                border-color: #117a8b;
            }

            /* Modal Styling */
            .modal-dialog {
                max-width: 80%;
            }
        </style>

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

        function prosesSurat(id) {
            // Menggunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan Menerima surat ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Terima!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menggunakan AJAX untuk mengubah status menjadi "Diajukan"
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_status_surat.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Jika berhasil, tampilkan SweetAlert untuk berhasil dan reload halaman
                                Swal.fire(
                                    'Berhasil!',
                                    'Surat berhasil diajukan.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload halaman untuk memperbarui status
                                });
                            } else {
                                // Jika gagal, tampilkan SweetAlert error
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan. Surat gagal diajukan.',
                                    'error'
                                );
                            }
                        }
                    };
                    xhr.send("id=" + id + "&status=Diterima");
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

                    // AJAX untuk mengubah status surat menjadi "Ditolak"
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

                    // Kirimkan data dengan status "Ditolak" dan alasan penolakan
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