<?php
session_start(); // Mulai sesi
session_destroy(); // Hancurkan sesi
header("Location: page-login.php"); // Arahkan ke halaman login
exit(); // Pastikan tidak ada kode lain yang dijalankan
?>
