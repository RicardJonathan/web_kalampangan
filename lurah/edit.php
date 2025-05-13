<?php
include 'config.php'; // File koneksi database

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Cek apakah pengguna yang login ada di tabel lurah
$user_id = $_SESSION['id']; // ID pengguna yang login

$sql_lurah = "SELECT * FROM lurah WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel kadis
$result_lurah = $koneksi->query($sql_lurah);

if ($result_lurah->num_rows == 0) {
    // Jika tidak ada di tabel lurah, arahkan ke halaman error
    header("Location: page-error-400.php"); // Arahkan ke halaman error
    exit();
}

$id = $_SESSION['id']; // Ambil ID admin dari session
$username = $_SESSION['username'];

// Ambil data admin dari database berdasarkan ID
$query = "SELECT * FROM lurah WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

// Simpan gambar ttd lama
$old_ttd = $row['ttd']; // Nama file gambar ttd yang lama

// Proses untuk menyimpan perubahan data admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $nip = $koneksi->real_escape_string($_POST['nip']);
    $pangkat = $koneksi->real_escape_string($_POST['pangkat']);
    $golongan = $koneksi->real_escape_string($_POST['golongan']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $koneksi->real_escape_string($_POST['password']);
    $ttd = $old_ttd; // Setel nama gambar ttd ke nama yang lama, jika tidak ada perubahan

    // Cek apakah ada file gambar tanda tangan yang diupload
    if (isset($_FILES['ttd']) && $_FILES['ttd']['error'] == 0) {
        $target_dir = "ttd/"; // Direktori untuk menyimpan gambar tanda tangan
        $ttd = basename($_FILES["ttd"]["name"]); // Nama file gambar
        $target_file = $target_dir . $ttd; // Lokasi lengkap file

        // Cek apakah file yang di-upload adalah gambar
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
        if (!in_array($imageFileType, $allowed_types)) {
            $error_message = "Hanya file gambar yang diperbolehkan.";
        } else {
            // Pindahkan file gambar ke folder ttd
            if (move_uploaded_file($_FILES["ttd"]["tmp_name"], $target_file)) {
                $error_message = "File tanda tangan berhasil diunggah.";
            } else {
                $error_message = "Terjadi kesalahan saat mengunggah gambar tanda tangan.";
            }
        }
    }

    // Jika password diubah, tambahkan logika untuk memperbarui password
    if (!empty($password)) {
        $update_query = "UPDATE lurah SET nama='$nama', nip='$nip', pangkat='$pangkat', golongan='$golongan', username='$username', password='$password', ttd='$ttd' WHERE id='$id'";
    } else {
        // Jika tidak ada perubahan password, simpan data lain termasuk ttd
        $update_query = "UPDATE lurah SET nama='$nama', nip='$nip', pangkat='$pangkat', golongan='$golongan', username='$username', ttd='$ttd' WHERE id='$id'";
    }

    if (mysqli_query($koneksi, $update_query)) {
        // Jika berhasil, reload halaman untuk menampilkan data terbaru
        header("Location: profile_lurah.php");
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($koneksi);
    }
}
?>
