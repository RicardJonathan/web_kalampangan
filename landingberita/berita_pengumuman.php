<?php
include '../config.php';
$query_pengumuman = 'SELECT * FROM pengumuman ORDER BY created_at DESC LIMIT 3';
$stmt_pengumuman = $koneksi->prepare($query_pengumuman);
$stmt_pengumuman->execute();
$result_pengumuman = $stmt_pengumuman->get_result();
?>

<?php include '../layouts/header_landing.php'; ?>
<?php include '../layouts/navbar_landing.php'; ?>

<style>
.bh_item {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.bh_isi {
    margin-top: 10px;
}
.bh_item h5 {
    font-weight: 600;
    font-size: 18px;
}
.bh_item p {
    font-size: 14px;
    line-height: 1.5;
}
.bh_item .btn {
    font-size: 14px;
    padding: 6px 15px;
    border-radius: 20px;
}
.bh_img img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
</style>

<div class="page_cover parallax-window" data-parallax="scroll" style="background-image: url('images/slider/tulisanDepan.jpeg');">
    <div class="overlay_dark"></div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <div class="page_cover_content"></div>
            </div>
        </div>
        <div class="breadcrumbs">
            <ul>
                <li><a href="index.php">Beranda</a> | </li>
                <li><span>Berita Pengumuman</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="page_konten">
            <div class="home_heading text-center">
                <span class="subheading">Pengumuman</span>
                <h2>Kelurahan Kalampangan</h2>
                <p>Pengumuman Kegiatan Kelurahan Kalampangan</p>
            </div>
<div class="row">
    <?php while ($row = mysqli_fetch_assoc($result_pengumuman)) : ?>
        <div class="col-md-4 mb-4">
            <div class="bh_item h-100">
                <div class="bh_img">
                    <img src="../images/fotopengumuman/<?php echo $row['foto']; ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                </div>
                <div class="bh_isi">
                    <h5 class="mt-3"><?php echo htmlspecialchars($row['judul']); ?></h5>
                <li class="list-inline-item"><i class="lnr lnr-user"></i> Admin</li>

                    <p class="text-muted mb-1"><?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                    <p><?php echo substr(strip_tags($row['deskripsi']), 0, 120); ?>...</p>
                    <a href="../landingberita/detail_pengumuman.php?id=<?php echo $row['id']; ?>" class="btn btn-warning text-white">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

        </div>
    </div>
</div>

<?php include '../layouts/footer_landing.php'; ?>
