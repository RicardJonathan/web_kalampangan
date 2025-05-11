<?php
include '../config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID kegiatan tidak valid.";
    exit;
}

$id = (int)$_GET['id'];

// Prepared statement untuk menghindari SQL injection
$stmt = $koneksi->prepare("SELECT * FROM kegiatan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "Kegiatan tidak ditemukan.";
    exit;
}

$row = $result->fetch_assoc();
?>


<?php include '../layouts/header_landing.php'; ?>
<?php include '../layouts/navbar_landing.php'; ?>

<style>
.detail_kegiatan {
    margin-top: 30px;
}
.detail_kegiatan img {
    width: 100%;
    height: auto; /* biarkan tinggi menyesuaikan */
    max-height: 500px; /* opsional: untuk membatasi agar tidak terlalu tinggi */
    object-fit: contain; /* gambar tidak dipotong */
    border-radius: 10px;
    background-color: #f5f5f5; /* untuk memberi latar jika gambar tidak memenuhi container */
}

.detail_kegiatan h2 {
    margin-top: 20px;
    font-weight: 700;
}
.detail_kegiatan .tanggal {
    font-size: 14px;
    color: gray;
    margin-bottom: 15px;
}
.detail_kegiatan .isi {
    margin-top: 20px;
    font-size: 16px;
    line-height: 1.7;
    text-align: justify;
}

/* Tambahkan jika belum ada */
header, nav {
    position: fixed!important;
    top: 0;
    width: 100%;
    z-index: 999;
    background-color: #ffd615!important; /* atau sesuaikan dengan tema */
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Tambahkan padding-top ke body atau container utama agar konten tidak tertimpa navbar */
body {
    padding-top: 70px; /* Sesuaikan dengan tinggi header/nav kamu */
}

</style>

<div class="page">
    <div class="container">
        <div class="page_konten">
            <div class="home_heading text-center">
                <span class="subheading">Berita Kegiatan</span>
                <h2>Kelurahan Kalampangan</h2>
            </div>

            <div class="detail_kegiatan">
                <img src="../images/fotokegiatan/<?php echo $row['foto']; ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                <li class="list-inline-item"><i class="lnr lnr-user"></i> Admin</li>
                <div class="tanggal"><?php echo date('d M Y', strtotime($row['created_at'])); ?></div>
                <div class="isi">
                    <?php echo nl2br($row['deskripsi']); ?>
                </div>
                <a href="../landingberita/berita_kegiatan.php" class="btn btn-primary mt-4">Kembali ke Kegiatan</a>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/footer_landing.php'; ?>
