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

$filename = basename($_GET['file']); // Hindari path traversal
$filepath = "uploads/" . $filename;

// Cek apakah file benar-benar ada
if (!file_exists($filepath)) {
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
    
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
        .preview-container {
            margin: 0 auto;
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        img, embed {
            max-width: 100%;
            height: auto;
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
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $pdf_extensions = ['pdf'];

        if (in_array(strtolower($file_ext), $image_extensions)) {
            echo "<img src='$filepath' alt='Dokumen'>";
        } elseif (in_array(strtolower($file_ext), $pdf_extensions)) {
            echo "<embed src='$filepath' type='application/pdf' width='100%' height='600px' />";
        } else {
            echo "<p>Format file tidak dapat dipreview. <a href='$filepath' download>Unduh file</a>.</p>";
        }

        // Tombol Unduh
        echo "<div class='btn-download'>
                <a href='$filepath' download class='btn btn-success'>
                    <i class='fas fa-download'></i> Unduh Dokumen
                </a>
              </div>";
        ?>

        <div class="btn-back">
            <a href="bmasukKasi.php" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>
    </div>
</body>
</html>
