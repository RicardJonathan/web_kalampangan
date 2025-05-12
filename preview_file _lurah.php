<?php
session_start();

// Pastikan hanya pengguna yang sudah login bisa mengakses
if (!isset($_SESSION['id'])) {
    header("Location: page-login.php");
    exit();
}

// Validasi input file
if (!isset($_GET['file']) || empty($_GET['file'])) {
    echo "File tidak ditemukan.";
    exit();
}

// Hindari path traversal dan ambil nama file murni
$filename = basename($_GET['file']);
$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// Validasi ekstensi file
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx'];
if (!in_array($file_ext, $allowed_extensions)) {
    echo "Format file tidak didukung untuk preview.";
    exit();
}

// Tentukan path berdasarkan tipe file
if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
    $filepath = "uploads/" . $filename;
} else {
    $filepath = "uploads/surat/" . $filename;
}

// Cek apakah file ada
if (!file_exists($filepath) || !is_file($filepath)) {
    echo "File tidak tersedia.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Dokumen</title>
    <link rel="icon" type="image/png" href="images/logopky.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
        .preview-container {
            margin: 0 auto;
            max-width: 800px; /* diperkecil dari 1000px */
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        img, embed {
            width: 100%;
            height: 500px;
            border: none;
            object-fit: contain;
        }
        .btn-back, .btn-download {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <h4 class="mb-4">Preview Dokumen</h4>

        <?php
        // Menampilkan file berdasarkan ekstensi
        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<img src='" . htmlspecialchars($filepath) . "' alt='Dokumen'>";
        } elseif ($file_ext === 'pdf') {
            echo "<embed src='" . htmlspecialchars($filepath) . "#toolbar=0&navpanes=0&scrollbar=0' type='application/pdf' />";
        } elseif ($file_ext === 'docx') {
            // Jika file .docx, tampilkan menggunakan Google Docs Viewer atau solusi lokal tanpa domain
            // Jika tidak menggunakan domain, Anda bisa menampilkan file dengan Office Viewer lokal
            $local_file_url = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/" . $filepath);
            $office_online_url = "https://view.officeapps.live.com/op/view.aspx?src=" . $local_file_url;
            echo "<iframe src='" . $office_online_url . "' width='100%' height='500px' style='border: none;'></iframe>";
        } else {
            echo "<p>Format file tidak dapat dipreview.</p>";
        }
        ?>

        <!-- Tombol Unduh -->
        <div class="btn-download">
            <a href="<?= htmlspecialchars($filepath) ?>" class="btn btn-success" download>
                ⬇️ Unduh Dokumen
            </a>
        </div>

        <!-- Tombol Kembali -->
        <div class="btn-back">
            <a href="berkas_masuk_lurah.php" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</body>
</html>
