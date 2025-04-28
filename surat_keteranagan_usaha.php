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

$sql_admin = "SELECT * FROM admin WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_admin = $koneksi->query($sql_admin);

if ($result_admin->num_rows == 0) {
    // Jika tidak ada di tabel admin, arahkan ke halaman error
    header("Location: page-error-400.php"); // Arahkan ke halaman error
    exit();
}


$query = "SELECT pengajuan_surat.*, user.nik, nama_pemohon,jenis_surat  
          FROM pengajuan_surat
          INNER JOIN user ON pengajuan_surat.user_id = user.id
          WHERE pengajuan_surat.status = 'diterima' 
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
            border: none !important; /* Hapus border dari tabel, header, dan kolom */
        }
        
                /* Menambahkan padding untuk kenyamanan tampilan */
                .table th, .table td {
            padding: 12px 15px; /* Memberikan jarak antar teks dan batas tabel */
            text-align: left; /* Mengatur teks agar rata kiri */
        }
        
        /* Menghilangkan garis bawah pada setiap baris */
        .table tbody tr {
            border-bottom: none; /* Menghilangkan garis pemisah antar baris */
        }
        
        /* Jika ada hover effect, tetap pertahankan */
        .table tbody tr:hover {
            background-color: #f1f1f1; /* Sedikit perubahan warna saat hover */
        }
        
                /* Styling untuk tabel */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        /* Styling untuk baris header tabel */
        .table th {
            color: #F4F6FF; /* Warna teks putih */
            padding: 12px 15px;
            text-align: left; /* Teks di header rata kiri */
            font-size: 16px;
            background-color: #7571F9 !important;
        }
        
        /* Styling untuk baris tabel */
        .table td {
            color: #3C3D37;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Garis pemisah antar baris */
            font-size: 14px;
            background-color: #f9f9f9; /* Warna latar belakang yang konsisten untuk seluruh tabel */
        }
        
        /* Hover effect untuk baris tabel */
        .table tbody tr:hover {
            background-color: #f1f1f1; /* Sedikit perubahan warna saat hover */
        }
        
        /* Styling untuk footer tabel */
        .table tfoot th {
            background-color: white !important; /* Warna latar belakang footer */
            color: #333;
            font-weight: bold;
        }
        
        /* Menambahkan efek border pada tabel */
        .table-bordered {
            border: 1px solid #ddd; /* Border untuk tabel */
        }
        
        /* Responsif - menyesuaikan tabel pada layar kecil */
        .table-responsive {
            overflow-x: auto; /* Membuat tabel bisa digulir horizontal di layar kecil */
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
                        <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <img src="images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span> 
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="profile_admin.php"><i class="icon-user"></i> <span>Profile</span></a>
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
        <?php include 'sidebar.php'; ?>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Surat Cuti</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data Surat Cuti</h4>
                                <div class="d-flex justify-content-end">
                                    </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Nomor Cuti</th>
                                                <th>Tanggal Ajuan</th>
                                                <th>Jenis Cuti</th>
                                                <th>Lama Cuti</th>
                                                <th>Alasan Cuti</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            // Menginisialisasi nomor urut
                                            $nomor = 1;

                                            // Mengecek apakah ada data pegawai
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $nomor++ . '.'; ?></td> <!-- Nomor urut otomatis -->
                                                        <td><?php echo $row['nip']; ?></td>
                                                        <td><?php echo $row['nama']; ?></td>
                                                        <td><?php echo $row['nomor_cuti']; ?></td>
                                                        <td><?php 
                                                            $tanggal_akhir = strtotime($row['tgl_ajuan']);
                                                            
                                                            $bulan = array(
                                                                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                                            );
                                                            
                                                            $hari = date('d', $tanggal_akhir);  // Mengambil hari
                                                            $bulan_indo = $bulan[date('n', $tanggal_akhir)];  // Mengambil bulan dalam bahasa Indonesia
                                                            $tahun = date('Y', $tanggal_akhir);  // Mengambil tahun
                                                            
                                                            echo $hari . ' ' . $bulan_indo . ' ' . $tahun;
                                                        ?></td>
                                                        <td><?php echo $row['jenis_cuti']; ?></td>
                                                        <td><?php echo $row['lama_cuti']; ?> (hari)</td>
                                                        <td><?php echo $row['alasan_cuti']; ?></td>


                                                        <td class="actions-cell">
                                                            <div class="btn-group" role="group" aria-label="Aksi">

                                                                <!-- Tombol Detail -->
                                                                <a href="cetak_surat_cuti.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn btn-success btn-sm">
                                                                    <i class="fa-solid fa-print"></i> Cetak Surat
                                                                </a>


                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <?php 
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">Data pengajuan cuti masih kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Nomor Cuti</th>
                                                <th>Tanggal Ajuan</th>
                                                <th>Jenis Cuti</th>
                                                <th>Lama Cuti</th>
                                                <th>Alasan Cuti</th>
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
            window.location.href = `hapus_cuti.php?id=${id}`;
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