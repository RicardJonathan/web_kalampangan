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

$sql_lurah = "SELECT * FROM lurah WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_lurah = $koneksi->query($sql_lurah);

if ($result_lurah->num_rows == 0) {
    // Jika tidak ada di tabel admin, arahkan ke halaman error
    header("Location: page-error-400.php"); // Arahkan ke halaman error
    exit();
}

// Query untuk mengambil data pengajuan surat  dengan status "Diterima" dan data user (nik, nama) dengan JOIN
$query = "SELECT pengajuan_surat.*, user.nik, user.nama
          FROM pengajuan_surat
          INNER JOIN user ON pengajuan_surat.user_id = user.id
          WHERE pengajuan_surat.status != 'diajukan'
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
            /* Hapus border dari tabel, header, dan kolom */
        }

        /* Menambahkan padding untuk kenyamanan tampilan */
        .table th,
        .table td {
            padding: 12px 15px;
            /* Memberikan jarak antar teks dan batas tabel */
            text-align: left;
            /* Mengatur teks agar rata kiri */
        }

        /* Menghilangkan garis bawah pada setiap baris */
        .table tbody tr {
            border-bottom: none;
            /* Menghilangkan garis pemisah antar baris */
        }

        /* Jika ada hover effect, tetap pertahankan */
        .table tbody tr:hover {
            background-color: #f1f1f1;
            /* Sedikit perubahan warna saat hover */
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
            /* Warna teks putih */
            padding: 12px 15px;
            text-align: left;
            /* Teks di header rata kiri */
            font-size: 16px;
            background-color: #7571F9 !important;
        }

        /* Styling untuk baris tabel */
        .table td {
            color: #3C3D37;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            /* Garis pemisah antar baris */
            font-size: 14px;
            background-color: #f9f9f9;
            /* Warna latar belakang yang konsisten untuk seluruh tabel */
        }

        /* Hover effect untuk baris tabel */
        .table tbody tr:hover {
            background-color: #f1f1f1;
            /* Sedikit perubahan warna saat hover */
        }

        /* Styling untuk footer tabel */
        .table tfoot th {
            background-color: white !important;
            /* Warna latar belakang footer */
            color: #333;
            font-weight: bold;
        }

        /* Menambahkan efek border pada tabel */
        .table-bordered {
            border: 1px solid #ddd;
            /* Border untuk tabel */
        }

        /* Responsif - menyesuaikan tabel pada layar kecil */
        .table-responsive {
            overflow-x: auto;
            /* Membuat tabel bisa digulir horizontal di layar kecil */
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
                        <h4>Kelurahan Kelampangan <br> PALANGKA RAYA</h4>
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
    <!-- row -->

    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Data Pengajuan Surat</h4>

<div class="d-flex justify-content-between mb-3">
   

    <!-- Tombol Tambah Data -->
    <a href="tambah_pengajuan_surat.php" class="btn btn-primary d-flex align-items-center ml-auto" style="width: 140px;">
        <i class="fas fa-plus mr-2"></i>
        <span>Tambah Data</span>
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered zero-configuration">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Surat</th>
                <th>User ID</th>
                <th>Nama Pengaju</th>
                <th>Email Pengaju</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Tanggal Pengajuan</th>
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
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $nomor++ . '.'; ?></td>
                        <td><?= htmlspecialchars($row['jenis_surat']); ?></td>
                        <td><?= htmlspecialchars($row['user_id']); ?></td>
                        <td><?= htmlspecialchars($row['nama_pengaju']); ?></td>
                        <td><?= htmlspecialchars($row['email_pengaju']); ?></td>
                        <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td>
                            <?php
                            $tgl = strtotime($row['tgl_pengajuan']);
                            $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                            echo date('d', $tgl) . ' ' . $bulan[date('n', $tgl)-1] . ' ' . date('Y', $tgl);
                            ?>
                        </td>
                        <td><a href="preview_file.php?file=<?= urlencode($row['foto_ktp']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                        <td><a href="preview_file.php?file=<?= urlencode($row['foto_kk']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                        <td><a href="preview_file.php?file=<?= urlencode($row['foto_formulir']); ?>" class="btn btn-sm btn-info">Lihat</a></td>
                        <td><?= htmlspecialchars($row['keterangan']); ?></td>
                        <td>
 <?php if ($row['status'] == 'Menunggu'): ?>
                                <span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Menunggu Konfirmasi</span>
                            <?php elseif ($row['status'] == 'Diajukan'): ?>
                                <span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi Admin</span>
<?php elseif ($row['status'] == 'Verifikasi Kasi'): ?>
    <span class="badge badge-info"><i class="fas fa-spinner fa-spin"></i> Verifikasi Kasi</span>
    <?php elseif ($row['status'] == 'Verifikasi Lurah'): ?>
    <span class="badge badge-warning"><i class="fas fa-spinner fa-spin"></i> Verifikasi Lurah</span>

<?php elseif ($row['status'] == 'Diterima'): ?>
    <span class="text-success"><i class="fa-solid fa-check-circle"></i> Diterima</span>
<?php elseif (strpos($row['status'], 'Ditolak oleh') !== false): ?>
    <span class="text-danger"><i class="fa-solid fa-times-circle"></i> <?= htmlspecialchars($row['status']); ?></span>
<?php else: ?>
    <span class="text-secondary"><i class="fa-solid fa-question-circle"></i> Tidak Diketahui</span>
<?php endif; ?>

                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- Edit Button: Only visible if the status is not 'Diajukan' -->
                                <?php if ($row['status'] != 'Diajukan'): ?>
                                    <a href="edit_pengajuan_surat.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                <?php endif; ?>

                                <!-- Delete Button -->
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>

                                <!-- Tombol Detail -->
                                <button type="button" class="btn btn-info btn-sm"
                                    data-toggle="modal"
                                    data-target="#detailModal<?php echo $row['id']; ?>">
                                    <i class="fas fa-info-circle"></i> Detail
                                </button>

                          
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal<?= $row['id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pengajuan Surat</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Jenis Surat:</strong> <?= htmlspecialchars($row['jenis_surat']); ?></p>
                                    <p><strong>Nama Pengaju:</strong> <?= htmlspecialchars($row['nama_pengaju']); ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email_pengaju']); ?></p>
                                    <p><strong>Telepon:</strong> <?= htmlspecialchars($row['no_telepon']); ?></p>
                                    <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></p>
                                    <p><strong>KTP:</strong> 
                                        <a href="preview_file.php?file=<?= urlencode($row['foto_ktp']); ?>" class="btn btn-sm btn-info">Preview KTP</a>
                                    </p>
                                    <p><strong>KK:</strong> 
                                        <a href="preview_file.php?file=<?= urlencode($row['foto_kk']); ?>" class="btn btn-sm btn-info">Preview KK</a>
                                    </p>
                                    <p><strong>Formulir:</strong> 
                                        <a href="preview_file.php?file=<?= urlencode($row['foto_formulir']); ?>" class="btn btn-sm btn-info">Preview Formulir</a>
                                    </p>
                                    <p><strong>Keterangan:</strong> <?= htmlspecialchars($row['keterangan']); ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($row['status']); ?></p>
                                    <?php if (!empty($row['alasan_penolakan'])): ?>
                                        <p><strong>Catatan Penolakan:</strong> <?= htmlspecialchars($row['alasan_penolakan']); ?></p>
                                    <?php endif; ?>
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
                echo '<tr><td colspan="14" class="text-center">Data pengajuan surat masih kosong.</td></tr>';
            }
            ?>
        </tbody>
                          
                        </table>
                    </div> <!-- table-responsive -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->



        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p class="mb-0">© <span id="current-year"></span> Kelurahan Kelampangan Palangka Raya. All rights reserved.</p>
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
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `hapus_pengajuan.php?id=${id}`;
                }
            });
        }

        function ajukanSurat(id) {
    // Menggunakan SweetAlert untuk konfirmasi
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan mengajukan surat ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, ajukan!',
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
            xhr.send("id=" + id + "&status=Diajukan");
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