<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="icon shortcut" type="image/jpg" href="images/logopky.png" style="width: 50px;">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="fonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="fonts/linericon/style.css">
    <link rel="stylesheet" href="fonts/flaticon.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/baguetteBox.min.css">

    <title>Kelurahan Kelampangan</title>
</head>
<style>
.btn-biru-keren {
  background-color: #007bff; /* Biru Bootstrap */
  border-color: #007bff;
  color: white;
  font-weight: bold;
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 123, 255, 0.3);
}

.btn-biru-keren:hover {
  background-color: #0056b3; /* Biru lebih gelap saat hover */
  box-shadow: 0 6px 8px rgba(0, 86, 179, 0.4);
  color: white;
}
</style>

<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./images/logo/logo.png" alt="Logo" style="height: 30px; margin-right: 8px;">
                Kelurahan Kalampangan
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="beritaDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Berita
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="beritaDropdown">
                            <li><a class="dropdown-item" href="./landingberita/berita_pengumuman.php">Berita
                                    Pengumuman</a></li>
                            <li><a class="dropdown-item" href="./landingberita/berita_kegiatan.php">Berita Kegiatan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tentang.php">Tentang</a>
                    </li>

                    <li class="nav-item active ">
                        <a class="nav-link" href="pengajuan.php">Pengajuan <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="page-login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>


    <div class="page_cover parallax-window" data-parallax="scroll"
        style="background-image: url('images/slider/tulisanDepan.jpeg');">
        <div class="overlay_dark"></div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-12">
                    <div class="page_cover_content">
                    </div>
                </div>
            </div>

            <div class="breadcrumbs">
                <ul>
                    <li><a href="index.php">Beranda</a> | </li>
                    <li><span>Pengajuan</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="container">
            <div class="page_artikel">
                <div class="row">
                    <div class="col-lg-12">
                    

                        <div class="left_konten">
                            <div class="left_konten_list">
                                <div class="row">


                                    <!-- Surat Keterangan Usaha -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Usaha (SKU)</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Akta yang sudah diisi (apabila ada)
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Tidak Mampu -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Tidak Mampu (SKTM)</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Kematian -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Kematian</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Kelahiran -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Kelahiran</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Belum Menikah -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Belum Menikah</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan untuk Menikah -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan untuk Menikah</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pengajuan PBB Baru -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Pengajuan PBB Baru</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto Sertifikat/IMB 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Ahli Waris -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Ahli Waris</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Berkelakuan Baik -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Berkelakuan Baik</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Keterangan Domisili -->
                                    <div class="col-md-6">
                                        <div class="konten_post">
                                            <div class="konten_details">
                                                <h4>Surat Keterangan Domisili</h4>
                                                </a>
                                                <p class="text-justify">
                                                    - Foto KTP 1 Lembar <br>
                                                    - Foto KK 1 Lembar <br>
                                                    - Foto Formulir yang sudah diisi dan TTD RT 1 lembar
                                                </p>
                                                <a class="btn btn-biru-keren" href="baca_artikel.html">Download Formulir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- row -->
                        </div> <!-- left_konten_list -->
                    </div> <!-- left_konten -->
                </div> <!-- col-lg-12 -->
            </div> <!-- row -->
        </div> <!-- page_artikel -->
    </div> <!-- container -->
    </div> <!-- page -->
    <footer class="ftco-footer ftco-bg-dark ftco-section mt-3">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2 logo"><span>Kelurahan</span> Kalampangan</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                            there live the blind texts.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <!-- <li class="ftco-animate"><a href="#"><span class="mdi mdi-twitter"></span></a>
                                </li> -->
                            <li class="ftco-animate"><a href="https://www.facebook.com/share/1DbtGN4awP/"><span
                                        class="mdi mdi-facebook"></span></a>
                            </li>
                            <li class="ftco-animate"><a
                                    href="https://www.instagram.com/kelurahankalampangan80?igsh=MXZ4dzE1djdybmN0OQ=="><span
                                        class="mdi mdi-instagram"></span></a></li>
                            <li class="ftco-animate">
                                <a href="#" target="_blank">
                                    <span class="mdi mdi-youtube-play"></span>
                                </a>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Quick Link</h2>
                        <ul class="list-unstyled">
                            <li><a href="index.php" class="py-1 d-block"><span
                                        class="mdi mdi-view-dashboard mr-3"></span>Beranda</a></li>
                            <li><a href="tentang.php" class="py-1 d-block"><span
                                        class="mdi mdi-church mr-3"></span>Tentang</a></li>
                            <li><a href="pengajuan.php" class="py-1 d-block"><span
                                        class="mdi mdi-newspaper mr-3"></span>Pengajuan</a></li>

                        </ul>
                    </div>
                </div>

                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Jam Operasional Kelurahan</h2>
                        <div class="opening-hours">
                            <p>Senin - Juma'at: <span class="mb-3">Jam 8:00 - 15:30</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // When the user scrolls down 20px from the top of the document, slide down the navbar
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                $('body').addClass("fixed-nav");
            } else {
                $('body').removeClass("fixed-nav");
            }
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'info',
            iconColor: '#C51F1A',
            title: 'Perhatian',
            html: 'Setelah mendownload formulir dan mengisi formulir,<br>untuk pengajuan surat silahkan login terlebih dahulu.',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#3085d6'
        });
    });
</script>
 
</body>

</html>
