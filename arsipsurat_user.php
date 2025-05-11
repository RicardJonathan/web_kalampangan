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


// Query untuk mengambil data pengajuan surat milik pengguna yang statusnya diterima
$query = "SELECT 
              pengajuan_surat.id AS pengajuan_id, 
              pengajuan_surat.jenis_surat, 
              pengajuan_surat.user_id, 
              pengajuan_surat.nama_pengaju, 
              pengajuan_surat.email_pengaju, 
              pengajuan_surat.no_telepon, 
              pengajuan_surat.alamat, 
              pengajuan_surat.tgl_pengajuan, 
              pengajuan_surat.status, 
              pengajuan_surat.keterangan, 
              pengajuan_surat.foto_ktp, 
              pengajuan_surat.foto_kk, 
              pengajuan_surat.foto_formulir, 
              user.nama
          FROM pengajuan_surat
          INNER JOIN user ON pengajuan_surat.user_id = user.id
          WHERE user.id = ? AND pengajuan_surat.status = 'Diterima'
          ORDER BY pengajuan_surat.id DESC";


$stmt = $koneksi->prepare($query);
if (!$stmt) {
    die("Prepared statement error: " . $koneksi->error);
}

$stmt->bind_param("i", $user_id); // Mengikat parameter user_id untuk menghindari SQL injection
$stmt->execute();
$result = $stmt->get_result();


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
                        <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <img src="images/user-ikon.jpg" height="40" width="40" alt="">
                                <span class="ml-1" style="font-size: 15px; color: #494949; cursor: pointer;"><?php echo $_SESSION['username']; ?></span> 
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengajuan Surat</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Surat</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jenis Surat</th>
                                        <th>User ID</th>
                                        <th>Nama Pengaju</th>
                                        <th>Email Pengaju</th>
                                        <th>No Telepon</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Keterangan</th>
                                        <th>Foto KTP</th>
                                        <th>Foto KK</th>
                                        <th>Foto Formulir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['jenis_surat']) . "</td>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_pengaju']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email_pengaju']) . "</td>";
        echo "<td>" . htmlspecialchars($row['no_telepon']) . "</td>";
        echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
        echo "<td>" . date('d F Y', strtotime($row['tgl_pengajuan'])) . "</td>";

        // Status
        echo "<td>";
        if ($row['status'] == 'Menunggu') {
            echo '<span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Menunggu Persetujuan</span>';
        } elseif ($row['status'] == 'Diajukan') {
            echo '<span class="badge badge-info"><i class="fas fa-paper-plane"></i> Diajukan</span>';
        } elseif ($row['status'] == 'Diterima') {
            echo '<span class="text-success"><i class="fa-solid fa-check-circle"></i> Diterima</span>';
        } elseif ($row['status'] == 'Ditolak') {
            echo '<span class="text-danger"><i class="fa-solid fa-times-circle"></i> Ditolak</span>';
        } else {
            echo '<span class="text-secondary"><i class="fa-solid fa-question-circle"></i> Tidak Diketahui</span>';
        }
        echo "</td>";

        // Keterangan
        echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";

        // Foto KTP
        echo "<td>";
        echo !empty($row['foto_ktp']) ? "<a href='../uploads/{$row['foto_ktp']}' target='_blank'>Lihat</a>" : "Tidak tersedia";
        echo "</td>";

        // Foto KK
        echo "<td>";
        echo !empty($row['foto_kk']) ? "<a href='../uploads/{$row['foto_kk']}' target='_blank'>Lihat</a>" : "Tidak tersedia";
        echo "</td>";

        // Foto Formulir
        echo "<td>";
        echo !empty($row['foto_formulir']) ? "<a href='../uploads/{$row['foto_formulir']}' target='_blank'>Lihat</a>" : "Tidak tersedia";
        echo "</td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13' class='text-center'>Data pengajuan surat masih kosong.</td></tr>";
}
?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                 
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
    $(document).ready(function() {
        $('.zero-configuration').DataTable({
            "paging": true,  // Aktifkan pagination
            "lengthChange": true,  // Pengaturan jumlah item yang ditampilkan per halaman
            "searching": true,  // Aktifkan fitur pencarian
            "ordering": true,  // Aktifkan fitur pengurutan
            "info": true,  // Menampilkan informasi halaman dan total data
            "autoWidth": false, // Menyesuaikan lebar kolom dengan kontennya
            "responsive": true, // Menyesuaikan tampilan di perangkat mobile
            "language": {
                "paginate": {
                    "previous": "<", // Teks untuk tombol "sebelumnya"
                    "next": ">"      // Teks untuk tombol "berikutnya"
                }
            }
        });
    });
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