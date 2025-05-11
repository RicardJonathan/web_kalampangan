<?php
include 'config.php';

// Query pengumuman
$query_pengumuman = 'SELECT * FROM pengumuman ORDER BY created_at DESC LIMIT 3';
$stmt_pengumuman = $koneksi->prepare($query_pengumuman);
$stmt_pengumuman->execute();
$result_pengumuman = $stmt_pengumuman->get_result();

// Query kegiatan
$query_kegiatan = 'SELECT * FROM kegiatan ORDER BY created_at DESC LIMIT 3';
$stmt_kegiatan = $koneksi->prepare($query_kegiatan);
$stmt_kegiatan->execute();
$result_kegiatan = $stmt_kegiatan->get_result();

// Query struktur
$query_struktur = 'SELECT * FROM struktur ORDER BY created_at';
$stmt_struktur = $koneksi->prepare($query_struktur);
$stmt_struktur->execute();
$result_struktur = $stmt_struktur->get_result();

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="icon shortcut" type="image/jpg" href="./images/logo/logo.png" style="width: 50px;">
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->


    <title>Kelurahan Kalampangan</title>

</head>

<style>

    
    .credit-marquee {
        /* background-color: #222; */
        color: #fff;
        padding: 10px 0;
        font-size: 14px;
        text-align: center;
    }

    .credit-marquee marquee {
        white-space: nowrap;
    }
    .bh_img {
    width: 100%;
    height: 200px; /* Ukuran tetap */
    overflow: hidden;
    position: relative;
    border-radius: 10px;
}

.bh_img img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Menjaga rasio tanpa distorsi */
    transition: transform 0.3s ease;
}

.bh_img:hover img {
    transform: scale(1.1); /* Membesar saat hover */
}

.struktur_section {
    padding: 60px 0;
    background-color: #f0f4f8;
}

.struktur_heading .subheading {
    font-size: 16px;
    font-weight: 600;
    color: #007BFF;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.struktur_heading h2 {
    font-size: 30px;
    color: #333;
    font-weight: 700;
    margin-bottom: 30px;
}

.struktur_card {
    background:rgb(242, 242, 242);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: 0.3s ease;
    text-align: center;
    display: flex;
    flex-direction: column;
}

.struktur_card:hover {
    transform: translateY(-5px);
}
.struktur_img {
    width: 100%;
    height: 450px; /* tinggi menyesuaikan */
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 15px;
    border: 2px solid #007BFF;
}

.struktur_img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.struktur_card:hover .struktur_img img {
    transform: scale(1.05);
}


.struktur_nama h5 {
    font-size: 18px;
    color: #222;
    font-weight: 600;
    margin-top: 15px;
}

.struktur_posisi p {
    font-size: 14px;
    color: #555;
    margin-top: 10px;
}

</style>

<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./images/logo/logo.png" alt="Logo"
                    style="height: 30px; margin-right: 8px;">
                Kelurahan Kalampangan
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Beranda <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="beritaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Berita
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="beritaDropdown">
                            <li><a class="dropdown-item" href="./landingberita/berita_pengumuman.php">Berita Pengumuman</a></li>
                            <li><a class="dropdown-item" href="./landingberita/berita_kegiatan.php">Berita Kegiatan</a></li>
                        </ul>
                        </li>

                    <li class="nav-item">
                        <a class="nav-link" href="tentang.php">Tentang</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="pengajuan.php">Pengajuan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="page-login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    <div id="sliderHome" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image:url(images/slider/gedungg.jpeg);">
                <div class="slider_item text-center">
                    <div class="text">
                        <div class="subheading">
                            <span>Kota Palangka Raya</span>
                        </div>
                        <h1 class="mb-4">Kelurahan <span> Kalampangan</span></h1>
                        <p><a href="tentang.php" class="btn btn-primary py-2 px-4">Tentang</a> <a href="pengajuan.php"
                                class="btn btn-primary btn-outline-primary py-2 px-4">Pengajuan</a></p>
                    </div>
                </div>
            </div </div>
        </div>


        <div class="welcome">
            <div class="row">
                <div class="welcome_konten justify-content-center align-items-center">
                    <div class="home_heading text-center">
                        <span class="subheading">Website</span>
                    </div>
                    <h3 class="heading justify-content-center align-items-center text-center">Website Kelurahan<span>
                            Kalampangan</span></h3>
                    <div class="welcome_text justify-content-center align-items-center text-center">
                        <p>
                            Website Kelurahan Kalampangan merupakan platform digital resmi yang dibangun untuk
                            meningkatkan
                            pelayanan publik, transparansi, dan partisipasi masyarakat dalam pembangunan kelurahan.
                            Melalui
                            website ini, warga dapat mengakses informasi terkait pelayanan, kegiatan kelurahan, struktur
                            kelurahan,
                            serta galeri kegiatan kelurahan kelampangan. Selain itu, website ini juga
                            memfasilitasi permintaan surat menyurat,
                            sehingga mendorong tata kelola pemerintahan yang lebih akun tabel dan efisien. Dengan adanya
                            website Kelurahan Kalampangan, diharapkan komunikasi antara pemerintah kelurahan dan
                            masyarakat
                            kalampangan menjadi lebih lancar, sekaligus mendukung percepatan transformasi digital dalam
                            pelayanan publik.
                        </p>
                    </div>
                </div>
            </div>
        </div>



        <div class="container">
            <div class="home_heading text-center">
                <span class="subheading">Pengumuman</span>
                <h2>Kelurahan Kelampangan</h2>
                <p>Pengumuman Kegiatan Kelurahan Kelampangan</p>
            </div>

            <div class="bh_konten">
                <div class="row">
                <?php while($data = mysqli_fetch_assoc($result_pengumuman)) { ?>

                    <div class="col-md-4">
                        <div class="bh_item">
                            <div class="bh_img">
                                <img src="images/fotopengumuman/<?php echo $data['foto']; ?>" class="img-fluid" alt="">
                            </div>
                            <br>
                            <div class="bh_judul">
                                <a title="">
                                    <h5 class="text-capitalize"><?php echo $data['judul']; ?></h5>
                                </a>
                            </div>
                            <div class="bh_meta">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="lnr lnr-user"></i> Admin</li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item"><i class="lnr lnr-calendar-full"></i>
                                        <?php echo date('d F, Y', strtotime($data['created_at'])); ?></li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item"><i class="lnr lnr-clock"></i> <?php echo date('H:i', strtotime($data['created_at'])); ?> WIB
                                    </li>
                                </ul>
                            </div>
                            <div class="bh_isi">
                                <p class="text-justify">
                                    <?php echo substr(strip_tags($data['deskripsi']), 0, 200); ?>...
                                </p>

                                <a class="btn btn-primary" href="./landingberita/detail_pengumuman.php?id=<?php echo $data['id']; ?>">Baca
                                    Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>



    <div class="berita_home">
        <div class="container">
            <div class="home_heading text-center">
                <span class="subheading">Kegiatan</span>
                <h2>Kelurahan Kelampangan</h2>
                <p>Kegiatan Terbaru Kelurahan Kelampangan</p>
            </div>

            <div class="bh_konten">
                <div class="row">
                <?php while($data = mysqli_fetch_assoc($result_kegiatan)) { ?>

                    <div class="col-md-4">
                        <div class="bh_item">
                            <div class="bh_img">
                                <img src="images/fotokegiatan/<?php echo $data['foto']; ?>" class="img-fluid" alt="">
                            </div>
                            <br>
                            <div class="bh_judul">
                                <a title="">
                                    <h5 class="text-capitalize"><?php echo $data['judul']; ?></h5>
                                </a>
                            </div>
                            <div class="bh_meta">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="lnr lnr-user"></i> Admin</li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item"><i class="lnr lnr-calendar-full"></i>
                                        <?php echo date('d F, Y', strtotime($data['created_at'])); ?></li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item"><i class="lnr lnr-clock"></i> <?php echo date('H:i', strtotime($data['created_at'])); ?> WIB
                                    </li>
                                </ul>
                            </div>
                            <div class="bh_isi">
                                <p class="text-justify">
                                    <?php echo substr(strip_tags($data['deskripsi']), 0, 200); ?>...
                                </p>

                                <a class="btn btn-primary" href="./landingberita/detail_kegiatan.php?id=<?php echo $data['id']; ?>">Baca
                                    Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="berita_home">
        <div class="container">
            <div class="home_heading text-center">
                <span class="subheading">Struktur</span>
            <h2>Kelurahan Kelampangan</h2>
        </div>
        <div class="struktur_content">
            <div class="row">
            <?php while($data = mysqli_fetch_assoc($result_struktur)) { ?>

                <div class="col-md-4 d-flex">
                    <div class="struktur_card w-100">
                        <div class="struktur_img">
                            <img src="images/fotostruktur/<?php echo $data['foto']; ?>" class="img-fluid" alt="">
                        </div>
                        <br>
                        <div class="struktur_nama">
                            <h5 class="text-capitalize"><?php echo $data['nama']; ?></h5>
                        </div>
                        <div class="struktur_posisi">
                            <p class="text-justify-center">
                                <?php echo substr(strip_tags($data['posisi']), 0, 200); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>



    <!-- Lokasi Google Maps -->
    <div class="container mt-5">
        <div class="card shadow-lg rounded-3">
            <div class="card-body">
                <h5 class="card-title">Lokasi Kelurahan Kalampangan</h5>
                <p class="card-text">Berikut adalah lokasi kantor Kelurahan Kalampangan di Google Maps:</p>
                <div class="map-responsive"
                    style="overflow:hidden; padding-bottom:56.25%; position:relative; height:0;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d563.2227066806089!2d114.01151814552112!3d-2.28046346951811!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de353089e89e807%3A0x150e730e4c7482ee!2sKantor%20Kelurahan%20Kalampangan!5e0!3m2!1sid!2sid!4v1745391028452!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0; position:absolute; top:0; left:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

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
            <div class="credit-marquee">
                <marquee behavior="scroll" direction="left">@kkn_mandiri_kalampangan | Website oleh Mahasiswa KKN-T
                    Mandiri Kelompok 2 2025</marquee>
            </div>
        </div>
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>

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
    
</body>

</html>
