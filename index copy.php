<?php
include 'config.php';

// Query pengumuman
$query_pengumuman = 'SELECT * FROM pengumuman ORDER BY created_at DESC LIMIT 3';
$stmt_pengumuman = $koneksi->prepare($query_pengumuman);
$stmt_pengumuman->execute();
$result_pengumuman = $stmt_pengumuman->get_result();

// Query kegiatan
$query_kegiatan = 'SELECT * FROM kegiatan ORDER BY created_at DESC LIMIT 3';
$stmt_kegiatan = $koneksi->prepare($query_kegiatan);
$stmt_kegiatan->execute();
$result_kegiatan = $stmt_kegiatan->get_result();

// Query struktur
$query_struktur = 'SELECT * FROM struktur ORDER BY created_at';
$stmt_struktur = $koneksi->prepare($query_struktur);
$stmt_struktur->execute();
$result_struktur = $stmt_struktur->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelurahan Kalampangan</title>
    <link rel="icon" type="image/jpg" href="./images/logo/logo.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        accent: '#4facfe',
                        dark: '#1e293b',
                        light: '#f8fafc',
                        cream: '#f5f5f0',
                        softblue: '#e6f0ff',
                        teal: '#2dd4bf',
                        muted: '#64748b'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-in-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Particles container */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,rgb(240, 245, 255) 0%, #e0f2fe 100%);
            z-index: -1;
            top: 0;
            left: 0;
        }
        
        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
         nav {
        transition: transform 0.3s ease-in-out;
    }
    
    /* Pastikan navbar memiliki z-index yang cukup tinggi */
    nav {
        z-index: 1000;
    }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #0ea5e9;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0284c7;
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #0ea5e9 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Image hover effect */
        .img-hover {
            transition: transform 0.5s ease;
        }
        .img-hover:hover {
            transform: scale(1.05);
        }
        
        .w-full {
    width: 100%!important;
}

.h-full {
    height: 150%!important;
}

/* Pastikan card untuk Lurah memiliki rasio 9:16 */
/* Card untuk Lurah (utama) */
.card-story {
    aspect-ratio: 9 / 16;
    width: 100%;
    max-width: 280px;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Gambar dalam card utama */
.card-story img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Card untuk struktur lainnya */
.card-story-small {
    aspect-ratio: 9 / 16;
    width: 100%;
    max-width: 200px;
    border-radius: 0.75rem;
    overflow: hidden;
    margin: 0 auto; /* Tengah di grid */
}

.card-story-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero {
                min-height: 70vh;
            }
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-b from-primary-50 to-white">
    <!-- Audio (hidden) -->
    <audio src="musikdayak.mp3" autoplay loop class="hidden"></audio>
    
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 py-3 glass shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a href="index.php" class="flex items-center space-x-3">
                    <img src="./images/logo/logo.png" alt="Logo" class="h-11 w-10">
                    <img src="./images/siklepon.png" alt="Logo" class="h-10 w-13">
                    <div>
                        <h1 class="text-xl font-bold text-primary-800"> Sistem Informasi Kelurahan Lewat Pelayanan Online</h1>
                        <p class="text-xs text-primary-600 hidden md:block">Kelurahan Kalampangan</p>
                    </div>
                </a>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-primary-800 hover:text-primary-600 font-medium transition">Beranda</a>
                    
                    <div class="relative group">
                        <button class="text-primary-800 hover:text-primary-600 font-medium flex items-center space-x-1 transition">
                            <span>Berita</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 glass rounded-lg shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <a href="berita_pengumuman.php" class="block px-4 py-2 text-primary-800 hover:bg-primary-100 transition">Berita Pengumuman</a>
                            <a href="berita_kegiatan.php" class="block px-4 py-2 text-primary-800 hover:bg-primary-100 transition">Berita Kegiatan</a>
                        </div>
                    </div>
                    
                    <a href="tentang.php" class="text-primary-800 hover:text-primary-600 font-medium transition">Tentang</a>
                    <a href="pengajuan.php" class="text-primary-800 hover:text-primary-600 font-medium transition">Pengajuan</a>
                    <a href="page-login.php" class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-5 py-2 rounded-full font-medium hover:opacity-90 transition shadow-md">Login</a>
                </div>
                
                <button class="md:hidden focus:outline-none" id="mobile-menu-button">
                    <svg class="w-6 h-6 text-primary-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="md:hidden hidden mt-4 glass rounded-lg p-4" id="mobile-menu">
                <a href="index.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Beranda</a>
                
                <div class="relative">
                    <button class="w-full text-left py-3 px-4 rounded-lg hover:bg-primary-100 transition flex justify-between items-center" id="berita-mobile-toggle">
                        <span>Berita</span>
                        <svg class="w-4 h-4 transition-transform" id="berita-mobile-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden pl-4 mt-1" id="berita-mobile-dropdown">
                        <a href="berita_pengumuman.php" class="block py-2 px-4 rounded-lg hover:bg-primary-100 transition">Berita Pengumuman</a>
                        <a href="berita_kegiatan.php" class="block py-2 px-4 rounded-lg hover:bg-primary-100 transition">Berita Kegiatan</a>
                    </div>
                </div>
                
                <a href="tentang.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Tentang</a>
                <a href="pengajuan.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Pengajuan</a>
                <a href="page-login.php" class="block mt-2 py-2 px-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-full text-center font-medium hover:opacity-90 transition shadow-md">Login</a>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="relative pt-24 pb-16 md:pt-32 md:pb-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-12 md:mb-0 animate-fade-in">
                    <span class="text-primary-600 font-semibold tracking-wider">Kota Palangka Raya</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mt-4 mb-6 leading-tight">
                        Kelurahan <span class="gradient-text">Kalampangan</span>
                    </h1>
                    <p class="text-lg md:text-xl text-primary-800 mb-8 max-w-lg">
                        Membangun masyarakat yang sejahtera melalui pelayanan prima dan pemerintahan yang transparan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="tentang.php" class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white hover:opacity-90 px-6 py-3 rounded-full font-medium transition transform hover:scale-105 shadow-lg">
                            Tentang Kami <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="pengajuan.php" class="bg-white text-primary-600 border-2 border-primary-200 hover:border-primary-300 px-6 py-3 rounded-full font-medium transition transform hover:scale-105 shadow-sm">
                            Ajukan Permohonan <i class="fas fa-file-alt ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-secondary-100 rounded-full opacity-70 animate-float"></div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-primary-100 rounded-full opacity-70 animate-float" style="animation-delay: 2s;"></div>
                        <div class="relative glass rounded-2xl overflow-hidden shadow-2xl">
                            <img src="images/slider/gedungg.jpeg" alt="Kantor Kelurahan Kalampangan" class="w-full h-auto max-h-96 object-cover img-hover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-primary-600 font-semibold tracking-wider">Layanan</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 text-primary-900">Fitur Unggulan Kami</h2>
                <p class="text-primary-700 mt-4 max-w-2xl mx-auto">
                    Nikmati berbagai kemudahan dalam mengakses layanan publik Kelurahan Kalampangan secara digital.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-white to-primary-50 rounded-xl p-6 shadow-md card-hover">
                    <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-newspaper text-primary-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-900 mb-3">Informasi Terkini</h3>
                    <p class="text-primary-700">
                        Akses berita, pengumuman, dan kegiatan terbaru dari Kelurahan Kalampangan secara real-time.
                    </p>
                    <a href="berita_pengumuman.php" class="inline-block mt-4 text-primary-600 hover:text-primary-800 font-medium transition">
                        Lihat Informasi <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="bg-gradient-to-br from-white to-secondary-50 rounded-xl p-6 shadow-md card-hover">
                    <div class="w-14 h-14 bg-secondary-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-secondary-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-900 mb-3">Pengajuan Online</h3>
                    <p class="text-primary-700">
                        Ajukan permohonan surat secara online tanpa perlu datang ke kantor kelurahan.
                    </p>
                    <a href="pengajuan.php" class="inline-block mt-4 text-secondary-600 hover:text-secondary-800 font-medium transition">
                        Ajukan Sekarang <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="bg-gradient-to-br from-white to-teal-50 rounded-xl p-6 shadow-md card-hover">
                    <div class="w-14 h-14 bg-teal-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-teal-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary-900 mb-3">Struktur Organisasi</h3>
                    <p class="text-primary-700">
                        Kenali tim pemerintahan kelurahan yang siap melayani masyarakat Kalampangan.
                    </p>
                    <a href="#struktur" class="inline-block mt-4 text-teal-600 hover:text-teal-800 font-medium transition">
                        Lihat Struktur <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Walkot Section -->
    <section class="py-16 bg-gradient-to-r from-primary-50 to-white">
        <div class="container mx-auto px-4">
            <div class="glass rounded-2xl overflow-hidden shadow-xl max-w-4xl mx-auto">
                <div class="md:flex">
                    <div class="md:w-1/3">
                        <img src="images/walkot.png" alt="Walikota Palangka Raya" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-2/3 p-8">
                        <h3 class="text-2xl font-bold text-primary-900 mb-2">Sambutan Walikota</h3>
                        <p class="text-primary-700 mb-4">
                            "Kami berkomitmen untuk terus meningkatkan pelayanan publik melalui inovasi digital, termasuk website Kelurahan Kalampangan ini."
                        </p>
                        <div class="border-t border-primary-100 pt-4">
                            <p class="font-semibold text-primary-900">Fairid Naparin</p>
                            <p class="text-primary-600">Walikota Palangka Raya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pengumuman Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-primary-600 font-semibold tracking-wider">Pengumuman</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 text-primary-900">Informasi Terbaru</h2>
                <p class="text-primary-700 mt-2 max-w-2xl mx-auto">
                    Dapatkan update terbaru seputar kegiatan dan pengumuman resmi dari Kelurahan Kalampangan.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while($data = mysqli_fetch_assoc($result_pengumuman)) { ?>
                <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover animate-fade-in">
                    <div class="h-48 overflow-hidden relative">
                        <img src="images/fotopengumuman/<?php echo $data['foto']; ?>" alt="<?php echo $data['judul']; ?>" class="w-full h-full object-cover img-hover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="text-white text-sm"><?php echo date('d F, Y', strtotime($data['created_at'])); ?></span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary-900 mb-3"><?php echo $data['judul']; ?></h3>
                        <p class="text-primary-700 mb-4 line-clamp-3">
                            <?php echo substr(strip_tags($data['deskripsi']), 0, 200); ?>...
                        </p>
                        <a href="detail_pengumuman.php?id=<?php echo $data['id']; ?>" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium transition">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="berita_pengumuman.php" class="inline-flex items-center bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-6 py-3 rounded-full font-medium hover:opacity-90 transition shadow-md">
                    Lihat Semua Pengumuman <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Kegiatan Section -->
    <section class="py-16 bg-gradient-to-b from-primary-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-primary-600 font-semibold tracking-wider">Kegiatan</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 text-primary-900">Aktivitas Masyarakat</h2>
                <p class="text-primary-700 mt-2 max-w-2xl mx-auto">
                    Dokumentasi berbagai kegiatan dan program yang dilaksanakan di Kelurahan Kalampangan.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while($data = mysqli_fetch_assoc($result_kegiatan)) { ?>
                <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover animate-fade-in">
                    <div class="h-48 overflow-hidden relative">
                        <img src="images/fotokegiatan/<?php echo $data['foto']; ?>" alt="<?php echo $data['judul']; ?>" class="w-full h-full object-cover img-hover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="text-white text-sm"><?php echo date('d F, Y', strtotime($data['created_at'])); ?></span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary-900 mb-3"><?php echo $data['judul']; ?></h3>
                        <p class="text-primary-700 mb-4 line-clamp-3">
                            <?php echo substr(strip_tags($data['deskripsi']), 0, 200); ?>...
                        </p>
                        <a href="detail_kegiatan.php?id=<?php echo $data['id']; ?>" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium transition">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="berita_kegiatan.php" class="inline-flex items-center bg-white text-primary-600 border-2 border-primary-200 hover:border-primary-300 px-6 py-3 rounded-full font-medium transition shadow-md">
                    Lihat Semua Kegiatan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Struktur Section -->
    <section id="struktur" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-primary-600 font-semibold tracking-wider">Struktur</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 text-primary-900">Tim Pemerintahan</h2>
                <p class="text-primary-700 mt-2 max-w-2xl mx-auto">
                    Kenali tim yang bertanggung jawab dalam memberikan pelayanan terbaik untuk masyarakat Kalampangan.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                // Tampilkan Lurah terlebih dahulu
                mysqli_data_seek($result_struktur, 0);
                while ($data = mysqli_fetch_assoc($result_struktur)) {
                    if (strtolower($data['posisi']) == 'lurah kalampangan') {
                ?>
                <div class="col-span-1 md:col-span-3 flex justify-center">
                    <div class="bg-gradient-to-br from-primary-50 to-white rounded-xl overflow-hidden shadow-xl w-full max-w-md card-hover animate-fade-in">
                       <div class="card-story relative">
    <img src="images/fotostruktur/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama']; ?>">
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
        <h3 class="text-xl font-bold text-white"><?php echo $data['nama']; ?></h3>
        <p class="text-primary-100"><?php echo $data['posisi']; ?></p>
    </div>
</div>

                    </div>
                </div>
                <?php
                    }
                }
                
                // Tampilkan yang lainnya
                mysqli_data_seek($result_struktur, 0);
                while ($data = mysqli_fetch_assoc($result_struktur)) {
                    if (strtolower($data['posisi']) != 'lurah kalampangan') {
                ?>
                <div class="bg-white rounded-xl overflow-hidden shadow-lg card-hover animate-fade-in">
                    <div class="card-story-small relative">
    <img src="images/fotostruktur/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama']; ?>">
</div>

                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-primary-900"><?php echo $data['nama']; ?></h3>
                        <p class="text-primary-700 mt-1"><?php echo $data['posisi']; ?></p>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    
    <!-- Maps Section -->
    <section class="py-16 bg-gradient-to-b from-primary-50 to-white">
        <div class="container mx-auto px-4">
            <div class="glass rounded-2xl overflow-hidden shadow-xl">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-6">
                        <div class="md:w-1/2 mb-6 md:mb-0">
                            <h2 class="text-2xl font-bold text-primary-900 mb-2">Lokasi Kelurahan</h2>
                            <p class="text-primary-700">
                                Jl. Kalampangan, Kec. Sabangau, Kota Palangka Raya, Kalimantan Tengah 73113
                            </p>
                            <div class="mt-4">
                                <a href="https://goo.gl/maps/example" target="_blank" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium transition">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Buka di Google Maps
                                </a>
                            </div>
                        </div>
                        <div class="md:w-1/2">
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-semibold text-primary-900 mb-2">Jam Operasional</h3>
                                <p class="text-primary-700 flex items-center mb-1">
                                    <i class="fas fa-clock mr-2 text-primary-600"></i> Senin - Jumat: 08:00 - 15:30
                                </p>
                                <p class="text-primary-700 flex items-center">
                                    <i class="fas fa-phone mr-2 text-primary-600"></i> (0536) 421123
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative overflow-hidden rounded-lg" style="padding-bottom: 56.25%;">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d563.2227066806089!2d114.01151814552112!3d-2.28046346951811!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de353089e89e807%3A0x150e730e4c7482ee!2sKantor%20Kelurahan%20Kalampangan!5e0!3m2!1sid!2sid!4v1745391028452!5m2!1sid!2sid" 
                            class="absolute top-0 left-0 w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="glass rounded-2xl overflow-hidden shadow-xl">
                <div class="md:flex">
                    <div class="md:w-1/2 bg-gradient-to-br from-primary-500 to-secondary-500 text-white p-12">
                        <h2 class="text-3xl font-bold mb-6">Hubungi Kami</h2>
                        <p class="mb-8">
                            Kami siap membantu dan menjawab pertanyaan Anda seputar layanan Kelurahan Kalampangan.
                        </p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="bg-white/20 p-3 rounded-full mr-4">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Alamat</h4>
                                    <p>Jl. Kalampangan, Kec. Sabangau, Kota Palangka Raya</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-white/20 p-3 rounded-full mr-4">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Telepon</h4>
                                    <p>(0536) 421123</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-white/20 p-3 rounded-full mr-4">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Email</h4>
                                    <p>kelurahan.kalampangan@palangkaraya.go.id</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:w-1/2 p-12">
                        <h3 class="text-2xl font-bold text-primary-900 mb-6">Kirim Pesan</h3>
                        <form>
                            <div class="mb-4">
                                <label for="name" class="block text-primary-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-primary-700 mb-2">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            
                            <div class="mb-4">
                                <label for="message" class="block text-primary-700 mb-2">Pesan</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition shadow-md">
                                Kirim Pesan <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gradient-to-br from-primary-800 to-primary-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="./images/logo/logo.png" alt="Logo" class="h-10 w-10">
                        <h3 class="text-xl font-bold">Kelurahan Kalampangan</h3>
                    </div>
                    <p class="mb-4 text-primary-200">
                        Membangun masyarakat yang sejahtera melalui pelayanan prima dan pemerintahan yang transparan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.instagram.com/kelurahankalampangan80?igsh=MXZ4dzE1djdybmN0OQ==" class="text-white hover:text-primary-300 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        
                        <a href="#" class="text-white hover:text-primary-300 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Menu</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-primary-200 hover:text-white transition">Beranda</a></li>
                        <li><a href="berita_pengumuman.php" class="text-primary-200 hover:text-white transition">Berita & Pengumuman</a></li>
                        <li><a href="berita_kegiatan.php" class="text-primary-200 hover:text-white transition">Kegiatan</a></li>
                        <li><a href="tentang.php" class="text-primary-200 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="pengajuan.php" class="text-primary-200 hover:text-white transition">Pengajuan Online</a></li>
                    </ul>
                </div>
                
               
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-300"></i>
                            <span class="text-primary-200">Jl. Kalampangan, Kec. Sabangau, Kota Palangka Raya</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-primary-300"></i>
                            <span class="text-primary-200">(0536) 421123</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-300"></i>
                            <span class="text-primary-200">kelurahan.kalampangan@palangkaraya.go.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary-300"></i>
                            <span class="text-primary-200">Senin-Jumat: 08:00 - 15:30</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-primary-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-primary-300 text-sm mb-4 md:mb-0">
                        &copy; 2024 Kelurahan Kalampangan. Hak Cipta Dilindungi.
                    </p>
                    <div class="text-center">
                        <marquee behavior="scroll" direction="left" class="text-sm text-primary-300">
                            @kkn_mandiri_kalampangan | Website oleh Mahasiswa KKN-T Mandiri Kelompok 2 2025
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-gradient-to-r from-primary-500 to-secondary-500 text-white p-4 rounded-full shadow-xl opacity-0 invisible transition-all duration-300 hover:opacity-90">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
     <!-- <script src="particles.js"></script> -->
    <!-- <script src="app.js"></script> -->
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Mobile Berita Toggle
        document.getElementById('berita-mobile-toggle').addEventListener('click', function() {
            const dropdown = document.getElementById('berita-mobile-dropdown');
            const arrow = document.getElementById('berita-mobile-arrow');
            
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
        
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            const backToTop = document.getElementById('back-to-top');
            
            if (window.scrollY > 100) {
                navbar.classList.add('shadow-md');
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                navbar.classList.remove('shadow-md');
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });
        
        // Back to Top Button
        document.getElementById('back-to-top').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Initialize Particles.js with a more subtle effect
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 10,
                    "density": {
                        "enable": true,
                        "value_area": 40
                    }
                },
                "color": {
                    "value": "#ff1414"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#ff1414"
                    }
                },
                "opacity": {
                    "value": 1,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 1,
                        "opacity_min": 0,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 2,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 200,
                    "color": "#ff1414",
                    "opacity": 0.1,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 0.5,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "out"
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 200,
                        "line_linked": {
                            "opacity": 0.3
                        }
                    },
                    "push": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    </script>
    <script>
    // Scroll behavior for header
    let lastScroll = 0;
    const navbar = document.querySelector('nav');
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        // Hide/show navbar on scroll
        if (currentScroll <= 100) {
            // At top of page - always show
            navbar.classList.remove('transform', '-translate-y-full');
            navbar.classList.add('shadow-md');
        } else if (currentScroll > lastScroll && currentScroll > 100) {
            // Scrolling down - hide navbar
            navbar.classList.add('transform', '-translate-y-full');
        } else {
            // Scrolling up - show navbar
            navbar.classList.remove('transform', '-translate-y-full');
        }
        
        lastScroll = currentScroll;
        
        // Back to top button logic
        const backToTop = document.getElementById('back-to-top');
        if (currentScroll > 100) {
            backToTop.classList.remove('opacity-0', 'invisible');
            backToTop.classList.add('opacity-100', 'visible');
        } else {
            backToTop.classList.add('opacity-0', 'invisible');
            backToTop.classList.remove('opacity-100', 'visible');
        }
    });

    // ... (kode lainnya yang sudah ada)
</script>
</body>
</html>