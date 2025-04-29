<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST["nama"]);
    $nik = trim($_POST["nik"]);
    $username = trim($_POST["username"]);
    $no_telepon = trim($_POST["no_telepon"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Cek duplikat NIK, username, atau email
    $cek_stmt = $koneksi->prepare("SELECT * FROM user WHERE nik = ? OR username = ? OR email = ?");
    $cek_stmt->bind_param("sss", $nik, $username, $email);
    $cek_stmt->execute();
    $result = $cek_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data sudah terdaftar!',
                        text: 'NIK, username, atau email sudah digunakan. Silakan gunakan yang lain.',
                    });
                };
              </script>";
        $cek_stmt->close();
    } else {
        $cek_stmt->close();

        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $stmt = $koneksi->prepare("INSERT INTO user (nama, nik, username, no_telepon, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nama, $nik, $username, $no_telepon, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Registrasi berhasil, silakan login.',
                        }).then(function() {
                            window.location.href = 'page-login.php';
                        });
                    };
                  </script>";
        } else {
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat registrasi, data sudah terdaftar.',
                        });
                    };
                  </script>";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Akun</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        
        body {
    background-image: url('images/slider/gedung.jpeg') !important; /* Ganti dengan URL gambar */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
        }
        .card h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            background: #6439FF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #6256CA;
        }
        .login-link {
            margin-top: 15px;
            text-align: center;
        }
        .login-link a {
            color: #6439FF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Daftar Akun</h2>
        <form method="POST" action="">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="text" name="nik" placeholder="NIK" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="no_telepon" placeholder="No Telepon" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar</button>
        </form>
        <div class="login-link">
            Sudah punya akun? <a href="page-login.php">Masuk di sini</a>
        </div>
    </div>
</body>
</html>
