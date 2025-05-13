<?php
include 'config.php'; // File koneksi database

// Cek jika pengguna belum login
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Cek apakah pengguna yang login ada di tabel admin
$user_id = $_SESSION['id']; // ID pengguna yang login

$sql_user = "SELECT * FROM user WHERE id = '$user_id'"; // Query untuk cek apakah pengguna ada di tabel admin
$result_user = $koneksi->query($sql_user);

if ($result_user->num_rows == 0) {
    // Jika tidak ada di tabel admin, arahkan ke halaman error
    header("Location: page-error-403.php"); // Arahkan ke halaman error
    exit();
}



$id = $_SESSION['id']; // Ambil ID admin dari session
$username = $_SESSION['username'];

// Ambil data admin dari database berdasarkan ID
$query = "SELECT * FROM admin WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

$query = "SELECT * FROM user WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

// Proses untuk menyimpan perubahan data admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $nik = $koneksi->real_escape_string($_POST['nik']);
    $no_telepon = $koneksi->real_escape_string($_POST['no_telepon']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $koneksi->real_escape_string($_POST['password']);

    // Jika password diubah, tambahkan logika untuk memperbarui password
    if (!empty($password)) {
        $update_query = "UPDATE user SET nama='$nama', nik='$nik', no_telepon='$no_telepon', email='$email', username='$username', password='$password' WHERE id='$id'";
    } else {
        $update_query = "UPDATE user SET nama='$nama', nik='$nik', no_telepon='$no_telepon', email='$email', username='$username' WHERE id='$id'";
    }
    
    if (mysqli_query($koneksi, $update_query)) {
        // Jika berhasil, reload halaman untuk menampilkan data terbaru
        header("Location: profileUser.php");
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($koneksi);
    }
}
?>
