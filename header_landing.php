<?php
include 'config.php';

// Query pengumuman
$query_pengumuman = 'SELECT * FROM pengumuman ORDER BY created_at DESC';
$result_pengumuman = mysqli_query($koneksi, $query_pengumuman);

// Query kegiatan
$query_kegiatan = 'SELECT * FROM kegiatan ORDER BY created_at DESC';
$result_kegiatan = mysqli_query($koneksi, $query_kegiatan);

// Query struktur
$query_struktur = 'SELECT * FROM struktur ORDER BY created_at';
$result_struktur = mysqli_query($koneksi, $query_struktur);

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="icon shortcut" type="image/jpg" href="web_kalampangan/images/logo/logo.png" style="width: 50px;">
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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
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

<body></body>