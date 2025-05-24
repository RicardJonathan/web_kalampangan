<?php
session_start();
include 'config.php'; // koneksi database

date_default_timezone_set("Asia/Makassar");
$today = new DateTime();
$tanggal_hari_ini = $today->format('Y-m-d');
$token = "F7RV17yysViG7qTU3vuY"; // Token Fonnte

// Fungsi bantu untuk menyimpan status notifilurah ke kolom notif_terkirim
function tambahStatusNotifTerkirim($koneksi, $id, $status) {
    $q = "SELECT notif_terkirim FROM pengajuan_surat WHERE id = $id";
    $res = mysqli_query($koneksi, $q);
    if ($row = mysqli_fetch_assoc($res)) {
        $data = json_decode($row['notif_terkirim'], true);
        if (!is_array($data)) {
            $data = [];
        }
        if (!in_array($status, $data)) {
            $data[] = $status;
            $data_json = mysqli_real_escape_string($koneksi, json_encode($data));
            $update = "UPDATE pengajuan_surat SET notif_terkirim = '$data_json' WHERE id = $id";
            mysqli_query($koneksi, $update);
        }
    }
}

// Ambil semua lurah
$sql_lurah_all = "SELECT * FROM lurah";
$result_lurah_all = $koneksi->query($sql_lurah_all);
if (!$result_lurah_all || $result_lurah_all->num_rows == 0) {
    die("Tidak ada lurah ditemukan.");
}

// Ambil semua pengajuan dengan status 'Diajukan' dan belum terkirim notifikasiuntuk status tersebut
$query_pengajuan = "SELECT pengajuan_surat.*, user.nama
                    FROM pengajuan_surat
                    INNER JOIN user ON pengajuan_surat.user_id = user.id
                    WHERE pengajuan_surat.status = 'Verifikasi Lurah'";
$result_pengajuan = mysqli_query($koneksi, $query_pengajuan);
if (!$result_pengajuan) {
    die("Query failed: " . mysqli_error($koneksi));
}

$surat_baru = [];
$surat_terlambat = [];
$pengajuan_ids = [];

while ($row = mysqli_fetch_assoc($result_pengajuan)) {
    // Cek apakah notifikasi untuk status "Verifikasi Lurah" sudah terkirim
    $notifikasi = json_decode($row['notif_terkirim'], true);
    if (is_array($notifikasi) && in_array('Verifikasi Lurah', $notifikasi)) {
        continue; // sudah terkirim, skip
    }

    if (empty($row['tgl_pengajuan'])) continue;

    $tgl_pengajuan = new DateTime($row['tgl_pengajuan']);
    $interval = $tgl_pengajuan->diff($today)->days;

    if ($tgl_pengajuan->format('Y-m-d') == $tanggal_hari_ini) {
        $surat_baru[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'jenis_surat' => $row['jenis_surat'],
            'tanggal_pengajuan' => $tgl_pengajuan->format('Y-m-d'),
        ];
    } elseif ($interval >= 3) {
        $surat_terlambat[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'jenis_surat' => $row['jenis_surat'],
            'tanggal_pengajuan' => $tgl_pengajuan->format('Y-m-d'),
            'hari_terlambat' => $interval,
        ];
    }

    $pengajuan_ids[] = $row['id'];
}

// Fungsi Kirim Fonnte
function kirimFonnte($target, $message, $token)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.fonnte.com/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'target' => $target,
            'message' => $message,
            'delay' => 1,
            'countryCode' => '62',
        ],
        CURLOPT_HTTPHEADER => [
            "Authorization: $token"
        ],
        CURLOPT_TIMEOUT => 5,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// Kirim pesan ke semua lurah
while ($lurah = $result_lurah_all->fetch_assoc()) {
    $no_telepon = $lurah['no_telepon'];
    if (!$no_telepon) continue;

    $lurah_wa = (substr($no_telepon, 0, 1) === '0') ? '62' . substr($no_telepon, 1) : $no_telepon;

    if (!empty($surat_baru)) {
        $pesan_baru = "📬 *Berkas Baru Masuk Hari Ini*\n\n";
        foreach ($surat_baru as $surat) {
            $pesan_baru .= "📄 *{$surat['jenis_surat']}* oleh *{$surat['nama']}*\n";
            $pesan_baru .= "📅 Tgl Pengajuan: {$surat['tanggal_pengajuan']}\n\n";
        }
        $pesan_baru .= "Silakan cek dan proses segera. 🙏";
        kirimFonnte($lurah_wa, $pesan_baru, $token);
    }

    if (!empty($surat_terlambat)) {
        $pesan_terlambat = "⚠️ *Pengingat Surat Belum Diproses*\n\n";
        foreach ($surat_terlambat as $surat) {
            $pesan_terlambat .= "📄 *{$surat['jenis_surat']}* oleh *{$surat['nama']}*\n";
            $pesan_terlambat .= "📅 Tgl Pengajuan: {$surat['tanggal_pengajuan']}\n";
            $pesan_terlambat .= "⏳ Belum diproses selama {$surat['hari_terlambat']} hari\n\n";
        }
        $pesan_terlambat .= "Mohon segera ditindaklanjuti. 🙏";
        kirimFonnte($lurah_wa, $pesan_terlambat, $token);
    }
}

// Update notif_terkirim untuk status "Diajukan"
foreach ($pengajuan_ids as $id) {
    tambahStatusNotifTerkirim($koneksi, $id, 'Verifikasi Lurah');
}

$koneksi->close();
?>
