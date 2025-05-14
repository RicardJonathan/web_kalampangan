<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID pengumuman tidak valid.";
    exit;
}

$id = (int)$_GET['id'];

// Prepared statement untuk menghindari SQL injection
$stmt = $koneksi->prepare("SELECT * FROM pengumuman WHERE id = ?");
$stmt->bind_param("i", $id);  // "i" untuk integer
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "Pengumuman tidak ditemukan.";
    exit;
}

$row = $result->fetch_assoc();
?>

<?php include 'header_landing.php'; ?>
<?php include 'navbar_landing.php'; ?>

<style>
.detail_pengumuman {
    margin-top: 30px;
}
.detail_pengumuman img {
    width: 100%;
    height: auto; /* biarkan tinggi menyesuaikan */
    max-height: 500px; /* opsional: untuk membatasi agar tidak terlalu tinggi */
    object-fit: contain; /* gambar tidak dipotong */
    border-radius: 10px;
    background-color: #f5f5f5; /* untuk memberi latar jika gambar tidak memenuhi container */
}

.detail_pengumuman h2 {
    margin-top: 20px;
    font-weight: 700;
}
.detail_pengumuman .tanggal {
    font-size: 14px;
    color: gray;
    margin-bottom: 15px;
}
.detail_pengumuman .isi {
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
                <span class="subheading">Berita Pengumuman</span>
                <h2>Kelurahan Kalampangan</h2>
            </div>

            <div class="detail_pengumuman">
                <img src="./images/fotopengumuman/<?php echo $row['foto']; ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                <li class="list-inline-item"><i class="lnr lnr-user"></i> Admin</li>
                <div class="tanggal"><?php echo date('d M Y', strtotime($row['created_at'])); ?></div>
                <div class="isi">
                    <?php echo nl2br($row['deskripsi']); ?>
                </div>
                <a href="berita_pengumuman.php" class="btn btn-primary mt-4">Kembali ke Pengumuman</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer_landing.php'; ?>
