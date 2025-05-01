<?php
include 'config.php';

// Mulai session
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $recaptchaResponse = $_POST['g-recaptcha-response']; // Ambil respons reCAPTCHA dari form

    // Verifikasi reCAPTCHA dengan mengirim request ke server Google
    $secretKey = '6LfBOoMqAAAAAKlkb3HuWSrJFeHW07uZZhx-XhtA'; // Ganti dengan Secret Key Anda dari Google reCAPTCHA
    $verifyURL = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse";
    $response = file_get_contents($verifyURL);
    $responseKeys = json_decode($response, true);

    // Periksa apakah reCAPTCHA berhasil diverifikasi
    if (intval($responseKeys["success"]) !== 1) {
        echo "<script> 
                  window.onload = function() {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'CAPTCHA tidak valid. Silakan coba lagi.',
                      });
                  };
              </script>";
    } else {
        // Fungsi untuk menghindari SQL Injection dan mengamankan input
        function safe_input($data, $conn) {
            return htmlspecialchars(strip_tags($conn->real_escape_string($data)));
        }

        // Mengamankan input
        $username = safe_input($username, $koneksi);
        $password = safe_input($password, $koneksi);

        // 1. Cek di tabel admin
        $stmt = $koneksi->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Data admin ditemukan
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id']; // Simpan ID admin
            $_SESSION['username'] = $username; // Simpan username admin

            // Arahkan ke halaman admin
            header("Location: index_admin.php");
            exit();
        }
        $stmt->close();

    // 2. Cek di tabel lurah
$stmt = $koneksi->prepare("SELECT * FROM lurah WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Data lurah ditemukan
    $row = $result->fetch_assoc();

    // Password cocok
    $_SESSION['id'] = $row['id']; // Simpan ID lurah
    $_SESSION['username'] = $username; // Simpan username lurah

    // Arahkan ke halaman lurah
    header("Location: indexLurah.php");
    exit();
}
$stmt->close();


        // 3. Cek di tabel user
        $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Cek apakah ada hasil dari query
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verifikasi password menggunakan password_verify
            if (password_verify($password, $row['password'])) {
                // Simpan data user dalam session
                $_SESSION['id'] = $row['id']; // Simpan ID user
                $_SESSION['username'] = $username; // Simpan username

                // Arahkan ke halaman yang sesuai
                header("Location: indexUser.php");
                exit();
            } else {
                // Password tidak cocok
                echo "<script> 
                          window.onload = function() {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Password salah!',
                              });
                          };
                      </script>";
            }
        } else {
            // Username tidak ditemukan
            echo "<script> 
                      window.onload = function() {
                          Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Username tidak ditemukan!',
                          });
                      };
                  </script>";
        }
        $stmt->close(); // Tutup prepared statement
    }
}
?>



<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kelurahan Kelampangan</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/logopky.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            background-image: url('images/slider/gedung.jpeg') !important; /* Ganti dengan URL gambar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }


        .btn.login-form__btn {
            background-color: #6439FF; /* Warna dasar tombol */
            color: #fff; /* Warna teks */
            font-size: 1rem;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease; /* Transisi untuk efek hover */
        }

        .btn.login-form__btn:hover {
            background-color: #6256CA; /* Biru laut saat hover */
            transform: scale(1.05); /* Sedikit membesar */
            color: #fff; /* Warna teks tetap putih */
        }

        /* Parent Container */
        .login-form-bg {
            display: flex; /* Aktifkan Flexbox */
            justify-content: center; /* Pusatkan secara horizontal */
            align-items: center; /* Pusatkan secara vertikal */
            height: 100vh; /* Tinggi penuh layar */
            padding: 20px; /* Tambahkan padding jika layar kecil */
            box-sizing: border-box; /* Pastikan padding tidak melebihi ukuran */
        }

        /* Card Login Form */
        .card.login-form {
            width: 700px; /* Lebar card */
            max-width: 100%; /* Pastikan tidak melampaui layar pada layar kecil */
            margin: auto; /* Pusatkan jika ada margin otomatis */
            border-radius: 10px; /* Sudut membulat */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Efek bayangan */
            background-color: #ffffff; /* Warna card */
            padding: 20px; /* Ruang di dalam card */
            box-sizing: border-box; /* Memastikan padding tetap dalam batas */
        }
    </style>
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <!-- <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div> -->
    <!--*******************
        Preloader end
    ********************-->

    



<div class="login-form-bg">
    <div class="card login-form">
        <div class="card-body pt-5">
            <div class="container-logo text-center">
                <img src="images/logopky.png" alt="Logo" class="logopky">
            </div>
            <h4 class="text-center">
                Kelurahan Kelampangan
            </h4>
            <form class="mt-5 login-input" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control mt-4" placeholder="Masukkan Password" required>
                </div>
                <div class="g-recaptcha mt-3" data-sitekey="6LfBOoMqAAAAAIGFl4kVxHSVBKm874nbDW-lyh2q"></div>
                <button type="submit" class="btn login-form__btn  w-100 mt-4">Masuk</button>
                <div class="login-link text-center mt-3">
    Belum punya akun? <a href="register.php">Daftar di sini</a>
</div>

            </form>
        </div>
    </div>
</div>

    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>





