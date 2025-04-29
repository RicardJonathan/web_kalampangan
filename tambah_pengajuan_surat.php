<?php
session_start();
include 'config.php';

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php"); 
    exit();
}

// Ambil ID user yang login
$user_id = $_SESSION['id'];

// Cek apakah user ada di tabel user
$sql_user = "SELECT * FROM user WHERE id = '$user_id'";
$result_user = $koneksi->query($sql_user);

if ($result_user->num_rows == 0) {
    header("Location: page-error-403.php");
    exit();
}

// Ambil detail user
$user = $result_user->fetch_assoc();
$nama_pengaju = $user['nama']; // Pastikan di tabel user ada kolom 'nama'
$email_pengaju = $user['email']; // Pastikan di tabel user ada kolom 'email'
$no_telepon = $user['no_telepon']; // Pastikan di tabel user ada kolom 'telepon'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $jenis_surat = $_POST['jenis_surat']; 
    $alamat = $_POST['alamat'];
    $tgl_pengajuan = date('Y-m-d'); // Atau bisa ambil dari input form kalau mau manual
    $keterangan = $_POST['keterangan'];

    // Ambil file foto
    $foto_ktp = $_FILES['foto_ktp']['name'];
    $foto_kk = $_FILES['foto_kk']['name'];
    $foto_formulir = $_FILES['foto_formulir']['name'];

    // Upload file ke folder (misal folder uploads/)
    $target_dir = "uploads/";
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $target_dir.$foto_ktp);
    move_uploaded_file($_FILES['foto_kk']['tmp_name'], $target_dir.$foto_kk);
    move_uploaded_file($_FILES['foto_formulir']['tmp_name'], $target_dir.$foto_formulir);

    $status = 'Menunggu';

    // Insert ke database
    $query = "INSERT INTO pengajuan_surat 
        (jenis_surat, user_id, nama_pengaju, email_pengaju, no_telepon, alamat, tgl_pengajuan, status, keterangan, foto_ktp, foto_kk, foto_formulir)
        VALUES 
        ('$jenis_surat', '$user_id', '$nama_pengaju', '$email_pengaju', '$no_telepon', '$alamat', '$tgl_pengajuan', '$status', '$keterangan', '$foto_ktp', '$foto_kk', '$foto_formulir')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: pengajuan_surat_usaha.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>KELURAHAN KELAMPANGAN</title>
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
                            <h4>KELURAHAN KELAMPANGAN <br> PALANGKA RAYA</h4>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengajuan Surat</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h4 class="card-title">Tambah Pengajuan Surat</h4>
                <div class="card-table">
                    
                       
        <form action="tambah_pengajuan.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="jenis_surat">Jenis Surat</label>
                <select name="jenis_surat" id="jenis_surat" class="form-control" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="SURAT KETERANGAN USAHA (SKU)">SURAT KETERANGAN USAHA (SKU)</option>
                    <option value="SURAT KETERANGAN TIDAK MAMPU (SKTM)">SURAT KETERANGAN TIDAK MAMPU (SKTM)</option>
                    <option value="SURAT KETERANGAN KEMATIAN">SURAT KETERANGAN KEMATIAN</option>
                    <option value="SURAT KETERANGAN KELAHIRAN">SURAT KETERANGAN KELAHIRAN</option>
                    <option value="SURAT KETERANGAN PINDAH">SURAT KETERANGAN PINDAH</option>
                    <option value="SURAT KETERANGAN BELUM MENIKAH">SURAT KETERANGAN BELUM MENIKAH</option>
                    <option value="SURAT KETERANGAN UNTUK MENIKAH">SURAT KETERANGAN UNTUK MENIKAH</option>
                    <option value="PENGAJUAN PBB BARU">PENGAJUAN PBB BARU</option>
                    <option value="SURAT KETERANGAN AHLI WARIS">SURAT KETERANGAN AHLI WARIS</option>
                    <option value="SURAT KETERANGAN BERKELAKUAN BAIK">SURAT KETERANGAN BERKELAKUAN BAIK</option>
                    <option value="SURAT KETERANGAN DOMISILI">SURAT KETERANGAN DOMISILI</option>
                </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="nama_pengaju">Nama Pengaju
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama_pengaju" name="nama_pengaju" placeholder="Masukkan nama pengaju.." required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="email_pengaju">Email Pengaju
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="email_pengaju" name="email_pengaju" placeholder="Masukkan email pengaju.." required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="no_telepon">No. Telepon Pengaju
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" class="form-control" id="no_telepon" name="no_telepon" placeholder="Masukkan nomor telepon pengaju.." required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="alamat">Alamat Pengaju
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat pengaju.." required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="tgl_pengajuan">Tanggal Pengajuan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="tgl_pengajuan" name="tgl_pengajuan" required>
                                    </div>

                              

                                    <div class="form-group">
                                        <label class="col-form-label" for="keterangan">Keterangan
                                        </label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan jika ada.."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="foto_ktp">Foto KTP
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" id="foto_ktp" name="foto_ktp" accept="image/*" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="foto_kk">Foto KK
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" id="foto_kk" name="foto_kk" accept="image/*" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="foto_formulir">Foto Formulir
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" id="foto_formulir" name="foto_formulir" accept="image/*" required>
                                    </div>

                                  <!-- Tombol Simpan dan Batal -->
                                  <div class="form-group text-right">
                                        <a href="pengajuan_surat.php" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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