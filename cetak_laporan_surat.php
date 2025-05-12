<?php
session_start();
include 'config.php'; // Koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Tangkap filter tahun dari URL (gunakan intval untuk keamanan)
$tahun_filter = isset($_GET['tahun']) ? intval($_GET['tahun']) : '';

// Buat query SQL dinamis berdasarkan filter tahun
$query = "SELECT 
            user.nik, 
            user.nama, 
            YEAR(pengajuan_surat.tgl_pengajuan) AS tahun,
            COUNT(pengajuan_surat.id) AS total_surat,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 1 THEN 1 ELSE 0 END) AS januari,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 2 THEN 1 ELSE 0 END) AS februari,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 3 THEN 1 ELSE 0 END) AS maret,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 4 THEN 1 ELSE 0 END) AS april,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 5 THEN 1 ELSE 0 END) AS mei,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 6 THEN 1 ELSE 0 END) AS juni,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 7 THEN 1 ELSE 0 END) AS juli,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 8 THEN 1 ELSE 0 END) AS agustus,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 9 THEN 1 ELSE 0 END) AS september,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 10 THEN 1 ELSE 0 END) AS oktober,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 11 THEN 1 ELSE 0 END) AS november,
            SUM(CASE WHEN MONTH(pengajuan_surat.tgl_pengajuan) = 12 THEN 1 ELSE 0 END) AS desember
          FROM pengajuan_surat
          INNER JOIN user ON pengajuan_surat.user_id = user.id";

// Jika ada filter tahun, tambahkan klausa WHERE
if ($tahun_filter) {
    $query .= " WHERE YEAR(pengajuan_surat.tgl_pengajuan) = '$tahun_filter'";
}

// Tambahkan GROUP BY dan ORDER BY
$query .= " GROUP BY user.id, YEAR(pengajuan_surat.tgl_pengajuan)
            ORDER BY tahun DESC, user.nama ASC";

$result = mysqli_query($koneksi, $query);

// Periksa jika query gagal
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!-- HTML mulai -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Surat</title>
    <link rel="icon" type="image/png" href="./images/logopky.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-responsive { overflow-x: auto; }

        @media print {
            @page { size: landscape; margin: 1cm; }
            body { margin: 0; padding: 0; }
            .table-responsive { display: block; width: 100%; overflow: auto; }
            table { width: 100%; table-layout: auto; }
            h4 { font-size: 20px; }
            th, td { font-size: 12px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header-text { font-size: 16px; }
            .divider { border-top: 2px solid #000; margin: 10px 0 20px 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="images/logopky.png" alt="Logo" style="height: 70px;">
        <div class="header-text">
            <h2 style="font-size: 24px;">PEMERINTAH KOTA PALANGKA RAYA</h2>
            <h2 style="font-weight: bold;">KECAMATAN SABANGAU<br>KELURAHAN KALAMPANGAN</h2>
            <span>Jalan Mahir Mahar KM 18, Kecamatan Sabangau Kota Palangka Raya</span><br>
            <span>Email: kelurahankalampangan@palangkaraya.go.id</span>
            <hr class="divider">
        </div>
    </div>

    <h4 class="text-center">
        Laporan Pengajuan Surat <?php echo $tahun_filter ? "Tahun $tahun_filter" : "Semua Tahun"; ?>
    </h4>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>No.</th>
                    <?php if (!$tahun_filter) echo "<th>Tahun</th>"; ?>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$nomor}</td>";
                        if (!$tahun_filter) {
                            echo "<td>{$row['tahun']}</td>";
                        }
                        echo "<td>{$row['nik']}</td>
                              <td>{$row['nama']}</td>
                              <td>{$row['januari']} surat</td>
                              <td>{$row['februari']} surat</td>
                              <td>{$row['maret']} surat</td>
                              <td>{$row['april']} surat</td>
                              <td>{$row['mei']} surat</td>
                              <td>{$row['juni']} surat</td>
                              <td>{$row['juli']} surat</td>
                              <td>{$row['agustus']} surat</td>
                              <td>{$row['september']} surat</td>
                              <td>{$row['oktober']} surat</td>
                              <td>{$row['november']} surat</td>
                              <td>{$row['desember']} surat</td>
                              <td>{$row['total_surat']} surat</td>
                        </tr>";
                        $nomor++;
                    }
                } else {
                    echo '<tr><td colspan="17" class="text-center">Data tidak ditemukan</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    window.print();
</script>
</body>
</html>
