<?php
session_start();
include 'config.php';

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header('Location: page-login.php');
    exit();
}

// Cek apakah pengguna yang login adalah admin
$user_id = $_SESSION['id'];
$stmt = $koneksi->prepare('SELECT * FROM admin WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result_admin = $stmt->get_result();

if ($result_admin->num_rows == 0) {
    header('Location: .php');
    exit();
}

// Proses hapus jika ada parameter id
if (isset($_GET['id'])) {
    $id_struktur = intval($_GET['id']);

    // Ambil nama file foto untuk dihapus dari folder
    $query_get_foto = 'SELECT foto FROM struktur WHERE id = ?';
    $stmt = $koneksi->prepare($query_get_foto);
    $stmt->bind_param('i', $id_struktur);
    $stmt->execute();
    $result_foto = $stmt->get_result();
    if ($result_foto->num_rows > 0) {
        $row = $result_foto->fetch_assoc();
        $foto = $row['foto'];

        // Hapus file foto dari folder jika ada
        $foto_path = "../images/fotostruktur/$foto";
        if (file_exists($foto_path)) {
            unlink($foto_path);
        }

        // Hapus data dari database
        $stmt = $koneksi->prepare('DELETE FROM struktur WHERE id = ?');
        $stmt->bind_param('i', $id_struktur);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Data berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus data!';
        }
    } else {
        $_SESSION['error'] = 'Data tidak ditemukan!';
    }

    header('Location: struktur.php');
    exit();
}

// Query untuk menampilkan data struktur
$query = 'SELECT * FROM struktur ORDER BY id DESC';
$result = mysqli_query($koneksi, $query);

// SweetAlert untuk notifikasi
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
    <link href="plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
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
                                        <li><a href="logout.php"><i class="icon-key"></i> <span>Logout</span></a>
                                        </li>
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
        <?php include 'sidebar_admin.php'; ?>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Struktur</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data struktur</h4>
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="tambah_struktur.php"
                                        class="btn btn-primary d-flex align-items-center" style="width: 140px;">
                                        <i class="fas fa-plus mr-2"></i>
                                        <span>Tambah Data</span>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Posisi</th>
                                                <th>Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                $nomor = 1;
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                            <tr>
                                                <td><?php echo $nomor++ . '.'; ?></td>
                                                <td>
                                                    <img src="./images/fotostruktur/<?php echo $row['foto']; ?>"
                                                        alt="Foto struktur"
                                                        style="width: 80px; height: auto; border-radius: 4px;">
                                                </td>

                                                <td><?php echo $row['nama']; ?></td>
                                                <td><?php echo $row['posisi']; ?></td>
                                                <td><?php echo date('H:i:s d-m-Y', strtotime($row['created_at'])); ?></td>
                                                <td class="actions-cell">
                                                    <div class="btn-group" role="group" aria-label="Aksi">
                                                        <a href="edit_struktur.php?id=<?php echo $row['id']; ?>"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                            <i class="fas fa-trash-alt"></i> Hapus
                                                        </button>
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#detailModal<?php echo $row['id']; ?>">
                                                            <i class="fas fa-info-circle"></i> Detail
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Detail Pengguna -->
                                            <div class="modal fade" id="detailModal<?php echo $row['id']; ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="detailModalLabel<?php echo $row['id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="detailModalLabel<?php echo $row['id']; ?>">Detail
                                                                Pengguna</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3"><strong>Foto:</strong>
                                                                <p class="mb-0"> <img
                                                                        src="./images/fotostruktur/<?php echo $row['foto']; ?>"
                                                                        alt="Foto struktur"
                                                                        style="width: 80px; height: auto; border-radius: 4px;">
                                                                    </td>
                                                            </div>
                                                            <div class="mb-3"><strong>Nama:</strong>
                                                                <p class="mb-0"><?php echo $row['nama']; ?></p>
                                                            </div>
                                                            <div class="mb-3"><strong>Posisi:</strong>
                                                                <p class="mb-0"><?php echo $row['posisi']; ?></p>
                                                            </div>
                                                            <div class="mb-3"><strong>Dibuat:</strong>
                                                                <p class="mb-0"><?php echo date('H:i:s d-m-Y', strtotime($row['created_at'])); ?></p>
                                                            </div>
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
                                                <td colspan="7" class="text-center">Data pengguna masih kosong</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Posisi</th>
                                                <th>Dibuat</th>
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

        </div>

        <div class="footer">
            <div class="copyright">
                <p class="mb-0">© <span id="current-year"></span> @kkn_mandiri_kalampangan | Website oleh Mahasiswa
                    KKN-T Mandiri Kelompok 2 2025</p>
            </div>
        </div>

    </div>

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
                    window.location.href = `struktur.php?id=${id}`;
                }
            });
        }
    </script>

    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>
