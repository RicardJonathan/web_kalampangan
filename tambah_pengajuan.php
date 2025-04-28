<?php
session_start();
include 'config.php';

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

// Inisialisasi variabel
$cuti_error = '';
$kuota_cuti = 0; // Default kuota cuti
$cuti_terpakai = 0; // Default cuti terpakai

// Ambil data pegawai dan sisa kuota cuti
$pegawai_query = "SELECT id, nip, nama, kuota_cuti, cuti_terpakai FROM user WHERE id = '$user_id'";
$pegawai_result = mysqli_query($koneksi, $pegawai_query);

if ($pegawai_result && mysqli_num_rows($pegawai_result) > 0) {
    $pegawai_data = mysqli_fetch_assoc($pegawai_result);
    $kuota_cuti = $pegawai_data['kuota_cuti'];
    $cuti_terpakai = $pegawai_data['cuti_terpakai'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $tgl_ajuan = $_POST['tgl_ajuan'];
    $jenis_cuti = $_POST['jenis_cuti'];
    $alasan_cuti = $_POST['alasan_cuti'];
    $lama_cuti = intval($_POST['lama_cuti']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $status = 'Menunggu';
    $catatan = $_POST['catatan'];
    $alamat_cuti = $_POST['alamat_cuti'];

    // Periksa kuota cuti pegawai
    if ($lama_cuti > $kuota_cuti) {
        $cuti_error = "Kuota cuti tidak mencukupi. Sisa kuota: $kuota_cuti hari.";
    } else {
        // Mulai transaksi
        mysqli_begin_transaction($koneksi);
        try {
            // Tambahkan data cuti
            $insert_cuti = "INSERT INTO cuti (user_id, nomor_cuti, tgl_ajuan, jenis_cuti, alasan_cuti, lama_cuti, tanggal_mulai, tanggal_akhir, catatan, alamat_cuti, status) 
                            VALUES ('$user_id', '', '$tgl_ajuan', '$jenis_cuti', '$alasan_cuti', '$lama_cuti', '$tanggal_mulai', '$tanggal_akhir', '$catatan', '$alamat_cuti', '$status')";
            mysqli_query($koneksi, $insert_cuti) or throw new Exception("Gagal menambahkan data cuti.");

            // Perbarui kuota cuti
            $update_user = "UPDATE user SET kuota_cuti = kuota_cuti - $lama_cuti, cuti_terpakai = cuti_terpakai + $lama_cuti WHERE id = '$user_id'";
            mysqli_query($koneksi, $update_user) or throw new Exception("Gagal memperbarui kuota cuti.");

            // Commit transaksi
            mysqli_commit($koneksi);
            header("Location: pengajuan_cuti.php");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $cuti_error = $e->getMessage();
        }
    }
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
                <h4 class="card-title">Tambah Pengajuan Cuti</h4>
                <div class="card-table">
                    <div class="alert alert-success">
                        <strong>Sisa Kuota Cuti:</strong> <?php echo $kuota_cuti; ?> hari
                    </div>
                    <div class="form-validation">
                        <form class="form-valide" action="tambah_pengajuan.php" method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="tgl_ajuan">Tanggal Pengajuan 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="tgl_ajuan" name="tgl_ajuan" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="jenis_cuti">Jenis Cuti
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" id="jenis_cuti" name="jenis_cuti" required>
                                            <option value="">Pilih Jenis Cuti</option>
                                            <option value="Cuti Tahunan">Cuti Tahunan</option>
                                            <option value="Cuti Besar">Cuti Besar</option>
                                            <option value="Cuti Sakit">Cuti Sakit</option>
                                            <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                            <option value="Cuti Karena Alasan Penting">Cuti Karena Alasan Penting</option>
                                            <option value="Cuti di Luar Tanggungan Negara">Cuti di Luar Tanggungan Negara</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="alasan_cuti">Alasan Cuti
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="alasan_cuti" name="alasan_cuti" rows="3" placeholder="Masukkan alasan cuti.." required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="lama_cuti">Lama Cuti (Hari)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" id="lama_cuti" name="lama_cuti" placeholder="Masukkan lama cuti.." required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="tanggal_mulai">Tanggal Mulai
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="tanggal_akhir">Tanggal Akhir
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="catatan">Catatan
                                        </label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Tambahkan catatan (jika ada).."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="alamat_cuti">Alamat Selama Cuti
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="alamat_cuti" name="alamat_cuti" placeholder="Masukkan alamat selama cuti.." required>
                                    </div>
                                    <!-- Tombol Simpan dan Batal -->
                                    <div class="form-group text-right">
                                        <a href="pengajuan_cuti.php" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php if (!empty($cuti_error)): ?>
                            <p style="color: red;"><?php echo $cuti_error; ?></p>
                        <?php endif; ?>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#nomor_cuti').on('input', function () {
        let nomorCuti = $(this).val();

        // Jika input tidak kosong
        if (nomorCuti) {
            $.ajax({
                url: 'check_nomor_cuti.php', // File PHP untuk memeriksa nomor cuti
                type: 'POST',
                data: { nomor_cuti: nomorCuti },
                success: function (response) {
                    let feedback = $('#nomorCutiFeedback');

                    // Tampilkan pesan dari server
                    feedback.text(response);

                    // Ganti warna teks berdasarkan respons
                    if (response.includes('sudah digunakan')) {
                        feedback.css('color', 'red'); // Warna merah jika tidak tersedia
                        $('#nomor_cuti').addClass('is-invalid').removeClass('is-valid');
                    } else {
                        feedback.css('color', 'green'); // Warna hijau jika tersedia
                        $('#nomor_cuti').addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });
        } else {
            $('#nomorCutiFeedback').text('');
            $('#nomor_cuti').removeClass('is-invalid is-valid');
        }
    });
});
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const lamaCutiInput = document.getElementById("lama_cuti");
            const tanggalMulaiInput = document.getElementById("tanggal_mulai");
            const tanggalAkhirInput = document.getElementById("tanggal_akhir");

            function updateTanggalAkhir() {
                const tanggalMulai = new Date(tanggalMulaiInput.value);
                const lamaCuti = parseInt(lamaCutiInput.value);

                if (!isNaN(tanggalMulai) && !isNaN(lamaCuti) && lamaCuti > 0) {
                    const tanggalAkhir = new Date(tanggalMulai);
                    tanggalAkhir.setDate(tanggalAkhir.getDate() + lamaCuti - 1); // Hitung tanggal akhir
                    tanggalAkhirInput.value = tanggalAkhir.toISOString().split('T')[0]; // Format ke YYYY-MM-DD
                }
            }

            lamaCutiInput.addEventListener("input", updateTanggalAkhir);
            tanggalMulaiInput.addEventListener("input", updateTanggalAkhir);
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