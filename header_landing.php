<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelurahan Kalampangan</title>
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
                            <a href="data_kependudukan.php" class="block px-4 py-2 text-primary-800 hover:bg-primary-100 transition">Data Kependudukan</a>
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
                        <a href="data_kependudukan.php" class="block py-2 px-4 rounded-lg hover:bg-primary-100 transition">Data Kependudukan</a>
                    </div>
                </div>
                
                <a href="tentang.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Tentang</a>
                <a href="pengajuan.php" class="block py-3 px-4 rounded-lg hover:bg-primary-100 transition">Pengajuan</a>
                <a href="page-login.php" class="block mt-2 py-2 px-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-full text-center font-medium hover:opacity-90 transition shadow-md">Login</a>
            </div>
        </div>
    </nav>
