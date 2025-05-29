<?php
include 'config.php';
$query_kegiatan = 'SELECT * FROM kegiatan ORDER BY created_at DESC';
$stmt_kegiatan = $koneksi->prepare($query_kegiatan);
$stmt_kegiatan->execute();
$result_kegiatan = $stmt_kegiatan->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan - Kelurahan Kalampangan</title>
    <link rel="icon" type="image/jpg" href="images/logo/logo.png">
    
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
        
        .page_cover {
            position: relative;
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .overlay_dark {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .breadcrumbs-container {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
        }
        
        .breadcrumbs {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 8px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumbs li {
            position: relative;
            margin: 0 10px;
            color: white;
            font-size: 14px;
            font-weight: 500;
        }
        
        .breadcrumbs a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .breadcrumbs a:hover {
            color: #38bdf8;
            transform: translateY(-1px);
        }
        
        .breadcrumbs .separator {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }
        
        .breadcrumbs .current-page {
            color: white;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
        }
        
        .breadcrumbs a::before {
            content: "";
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background-color: #38bdf8;
            transition: width 0.3s ease;
        }
        
        .breadcrumbs a:hover::before {
            width: 100%;
        }
        
        .about_img {
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .about_img img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        
        .heading span {
            color: #0ea5e9;
        }
        
        .text-justify {
            text-align: justify;
        }
        
        /* Custom styles for activity cards */
        .activity-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .activity-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .activity-card:hover .activity-image {
            transform: scale(1.05);
        }
        
        .activity-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .activity-date {
            color: #64748b;
            font-size: 0.875rem;
        }
        
        .activity-excerpt {
            margin: 1rem 0;
            color: #475569;
            flex-grow: 1;
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
                            <a href="data_kependudukan.php" class="block px-4 py-2 text-primary-800 hover:bg-primary-100 transition">Data Balita</a>
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
                        <a href="data_kependudukan.php" class="block py-2 px-4 rounded-lg hover:bg-primary-100 transition">Data Balita</a>
                    </div>
                </div>
                
                <a href="tentang.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Tentang</a>
                <a href="pengajuan.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Pengajuan</a>
                <a href="page-login.php" class="block mt-2 py-2 px-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-full text-center font-medium hover:opacity-90 transition shadow-md">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="page_cover relative" style="background-image: url('images/slider/tulisanDepan.jpeg');">
        <div class="overlay_dark absolute inset-0"></div>
        <div class="container mx-auto px-4 relative z-10 h-full flex items-center justify-center">
            <div class="w-full text-center">
                <div class="page_cover_content">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 animate-fade-in">Kegiatan</h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto">Informasi terbaru tentang kegiatan Kelurahan Kalampangan</p>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Breadcrumbs -->
        <div class="breadcrumbs-container">
            <ul class="breadcrumbs">
                <li>
                    <a href="index.php" class="hover:text-primary-300 transition">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li>
                    <span class="current-page">Kegiatan</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Activities Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-primary-600 font-semibold text-lg">Aktivitas Terkini</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Kegiatan Kelurahan Kalampangan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Dapatkan informasi terbaru seputar kegiatan yang dilakukan oleh Kelurahan Kalampangan</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($row = mysqli_fetch_assoc($result_kegiatan)) : ?>
                <div class="activity-card bg-white">
                    <div class="overflow-hidden">
                        <img src="./images/fotokegiatan/<?php echo $row['foto']; ?>"
                              alt="<?php echo htmlspecialchars($row['judul']); ?>"
                              class="activity-image w-full">
                    </div>
                    <div class="activity-content">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-user-circle mr-2 text-primary-500"></i>
                            <span>Admin</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar-alt mr-2 text-primary-500"></i>
                            <span><?php echo date('d M Y', strtotime($row['created_at'])); ?></span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <p class="activity-excerpt"><?php echo substr(strip_tags($row['deskripsi']), 0, 120); ?>...</p>
                        <a href="detail_kegiatan.php?id=<?php echo $row['id']; ?>"
                            class="mt-auto inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-full hover:opacity-90 transition">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!-- <div class="text-center mt-12">
                <a href="berita_kegiatan.php" class="inline-flex items-center px-6 py-3 border border-primary-500 text-primary-600 rounded-full hover:bg-primary-50 transition">
                    <i class="fas fa-history mr-2"></i>
                    Lihat Kegiatan Lainnya
                </a>
            </div> -->
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
    </script>
</body>
</html>