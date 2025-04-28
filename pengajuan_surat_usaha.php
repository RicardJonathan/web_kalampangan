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

$sql_user = "SELECT * FROM user WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_user = $koneksi->query($sql_user);

if ($result_user->num_rows == 0) {
    // Jika tidak ada di tabel admin, arahkan ke halaman error
    header("Location: page-error-403.php"); // Arahkan ke halaman error
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>DPKUKMP</title>
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
                        <h4>DPKUKMP <br> PALANGKA RAYA</h4>
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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Main Menu</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengajuan Cuti</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data Pengajuan Skhu</h4>
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="tambah_pengajuan_skhu.php" class="btn btn-primary d-flex align-items-center"
                                        style="width: 140px;">
                                        <i class="fas fa-plus mr-2"></i> <!-- Ikon Plus -->
                                        <span>Tambah Data</span>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal Ajuan</th>
                                                <th>KTP 1 Lembar</th>
                                                <th>Lama Cuti</th>
                                                <th>Alasan Cuti</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Menginisialisasi nomor urut
                                            $nomor = 1;

                                            // Mengecek apakah ada data cuti
                                            if (!empty($data_cuti)) {
                                                foreach ($data_cuti as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $nomor++ . '.'; ?></td> <!-- Nomor urut otomatis -->
                                                        <td><?php
                                                        $tanggal_ajuan = strtotime($row['tgl_ajuan']);

                                                        $bulan = array(
                                                            1 => 'Januari',
                                                            'Februari',
                                                            'Maret',
                                                            'April',
                                                            'Mei',
                                                            'Juni',
                                                            'Juli',
                                                            'Agustus',
                                                            'September',
                                                            'Oktober',
                                                            'November',
                                                            'Desember'
                                                        );

                                                        $hari = date('d', $tanggal_ajuan);  // Mengambil hari
                                                        $bulan_indo = $bulan[date('n', $tanggal_ajuan)];  // Mengambil bulan dalam bahasa Indonesia
                                                        $tahun = date('Y', $tanggal_ajuan);  // Mengambil tahun
                                                
                                                        echo $hari . ' ' . $bulan_indo . ' ' . $tahun;
                                                        ?></td>
                                                        <td><?php echo $row['jenis_cuti']; ?></td>
                                                        <td><?php echo $row['lama_cuti']; ?> (hari)</td>
                                                        <td><?php echo $row['alasan_cuti']; ?></td>
                                                        <td>
                                                            <!-- Menentukan status dan menampilkan ikon sesuai dengan status -->
                                                            <?php if ($row['status'] == 'Menunggu'): ?>
                                                                <span class="badge badge-primary">
                                                                    <i class="fas fa-spinner fa-spin"></i> Menunggu Konfirmasi
                                                                </span>
                                                            <?php elseif ($row['status'] == 'Diajukan'): ?>
                                                                <span class="badge badge-primary">
                                                                    <i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi Admin
                                                                </span>
                                                            <?php elseif ($row['status'] == 'Diterima'): ?>
                                                                <span class="text-success">
                                                                    <i class="fa-solid fa-check-circle"></i> Pengajuan Diterima
                                                                </span>
                                                            <?php elseif (strpos($row['status'], 'Ditolak oleh') !== false): ?>
                                                                <span class="text-danger">
                                                                    <i class="fa-solid fa-times-circle"></i>
                                                                    <?php echo htmlspecialchars($row['status']); ?>
                                                                </span>
                                                            <?php elseif ($row['status'] == 'Diproses'): ?>
                                                                <span class="badge badge-warning">
                                                                    <i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi Kadis
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-secondary">
                                                                    <i class="fa-solid fa-question-circle"></i> Status Tidak Dikenal
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>


                                                        <td class="actions-cell">
                                                            <div class="btn-group" role="group" aria-label="Aksi">
                                                                <!-- Tombol Edit, hanya muncul jika status belum "Diajukan" -->
                                                                <?php if ($row['status'] != 'Diajukan'): ?>
                                                                    <a href="edit_pengajuan.php?id=<?php echo $row['cuti_id']; ?>"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-edit"></i> Edit
                                                                    </a>
                                                                <?php endif; ?>

                                                                <!-- Tombol Hapus -->
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="confirmDelete(<?php echo $row['cuti_id']; ?>)">
                                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                                </button>

                                                                <!-- Tombol Detail -->
                                                                <button type="button" class="btn btn-info btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#detailModal<?php echo $row['cuti_id']; ?>">
                                                                    <i class="fas fa-info-circle"></i> Detail
                                                                </button>

                                                                <!-- Tombol Ajukan, hanya muncul jika status belum "Diajukan" -->
                                                                <?php if ($row['status'] != 'Diajukan'): ?>
                                                                    <button type="button" class="btn btn-warning btn-sm"
                                                                        onclick="ajukanCuti(<?php echo $row['cuti_id']; ?>)">
                                                                        <i class="fas fa-paper-plane"></i> Ajukan
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>


                                                    </tr>

                                                    <div class="modal fade" id="detailModal<?php echo $row['cuti_id']; ?>"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="detailModalLabel<?php echo $row['id']; ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="detailModalLabel<?php echo $row['cuti_id']; ?>">
                                                                        Detail Pengajuan Cuti</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <strong>Tanggal Pengajuan:</strong>
                                                                        <p class="mb-0"> <?php
                                                                        $tanggal_akhir = strtotime($row['tgl_ajuan']);

                                                                        $bulan = array(
                                                                            1 => 'Januari',
                                                                            'Februari',
                                                                            'Maret',
                                                                            'April',
                                                                            'Mei',
                                                                            'Juni',
                                                                            'Juli',
                                                                            'Agustus',
                                                                            'September',
                                                                            'Oktober',
                                                                            'November',
                                                                            'Desember'
                                                                        );

                                                                        $hari = date('d', $tanggal_akhir);  // Mengambil hari
                                                                        $bulan_indo = $bulan[date('n', $tanggal_akhir)];  // Mengambil bulan dalam bahasa Indonesia
                                                                        $tahun = date('Y', $tanggal_akhir);  // Mengambil tahun
                                                                
                                                                        echo $hari . ' ' . $bulan_indo . ' ' . $tahun;
                                                                        ?></p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Jenis Cuti:</strong>
                                                                        <p class="mb-0"><?php echo $row['jenis_cuti']; ?></p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Lama Cuti:</strong>
                                                                        <p class="mb-0"><?php echo $row['lama_cuti']; ?> (hari)
                                                                        </p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Alasan Cuti:</strong>
                                                                        <p class="mb-0"><?php echo $row['alasan_cuti']; ?></p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Tanggal Mulai:</strong>
                                                                        <p class="mb-0"> <?php
                                                                        $tanggal_akhir = strtotime($row['tanggal_mulai']);

                                                                        $bulan = array(
                                                                            1 => 'Januari',
                                                                            'Februari',
                                                                            'Maret',
                                                                            'April',
                                                                            'Mei',
                                                                            'Juni',
                                                                            'Juli',
                                                                            'Agustus',
                                                                            'September',
                                                                            'Oktober',
                                                                            'November',
                                                                            'Desember'
                                                                        );

                                                                        $hari = date('d', $tanggal_akhir);  // Mengambil hari
                                                                        $bulan_indo = $bulan[date('n', $tanggal_akhir)];  // Mengambil bulan dalam bahasa Indonesia
                                                                        $tahun = date('Y', $tanggal_akhir);  // Mengambil tahun
                                                                
                                                                        echo $hari . ' ' . $bulan_indo . ' ' . $tahun;
                                                                        ?></p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Tanggal Akhir:</strong>
                                                                        <p class="mb-0">
                                                                            <?php
                                                                            // Mengonversi tanggal menjadi format tanggal PHP
                                                                            $tanggal_akhir = strtotime($row['tanggal_akhir']);

                                                                            // Array untuk nama bulan dalam bahasa Indonesia
                                                                            $bulan = array(
                                                                                1 => 'Januari',
                                                                                'Februari',
                                                                                'Maret',
                                                                                'April',
                                                                                'Mei',
                                                                                'Juni',
                                                                                'Juli',
                                                                                'Agustus',
                                                                                'September',
                                                                                'Oktober',
                                                                                'November',
                                                                                'Desember'
                                                                            );

                                                                            // Format tanggal: 19 November 2024
                                                                            $hari = date('d', $tanggal_akhir);  // Mengambil hari
                                                                            $bulan_indo = $bulan[date('n', $tanggal_akhir)];  // Mengambil bulan dalam bahasa Indonesia
                                                                            $tahun = date('Y', $tanggal_akhir);  // Mengambil tahun
                                                                    
                                                                            // Menampilkan tanggal dalam format yang diinginkan
                                                                            echo $hari . ' ' . $bulan_indo . ' ' . $tahun;
                                                                            ?>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Catatan:</strong>
                                                                        <p class="mb-0"><?php echo $row['catatan']; ?></p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <strong>Alamat Cuti:</strong>
                                                                        <p class="mb-0"><?php echo $row['alamat_cuti']; ?></p>
                                                                    </div>
                                                                    <?php if ($row['status'] == 'Ditolak'): ?>
                                                                        <div class="mb-3">
                                                                            <strong>Catatan Penolakan:</strong>
                                                                            <p class="mb-0"><?php echo $row['alasan_penolakan']; ?>
                                                                            </p>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">Data pengajuan cuti masih kosong
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal Ajuan</th>
                                                <th>Jenis Cuti</th>
                                                <th>Lama Cuti</th>
                                                <th>Alasan Cuti</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
                <p class="mb-0">© <span id="current-year"></span> DPKUKMP Palangka Raya. All rights reserved.</p>
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

        function ajukanCuti(cuti_id) {
            // Menggunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengajukan cuti ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ajukan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menggunakan AJAX untuk mengubah status menjadi "Diajukan"
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_status_cuti.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Jika berhasil, tampilkan SweetAlert untuk berhasil dan reload halaman
                                Swal.fire(
                                    'Berhasil!',
                                    'Cuti berhasil diajukan.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload halaman untuk memperbarui status
                                });
                            } else {
                                // Jika gagal, tampilkan SweetAlert error
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan. Cuti gagal diajukan.',
                                    'error'
                                );
                            }
                        }
                    };
                    xhr.send("cuti_id=" + cuti_id + "&status=Diajukan");
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