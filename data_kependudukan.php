<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengumuman - Kelurahan Kalampangan</title>
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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
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
        
        /* Content spacing for fixed navbar */
        .content-container {
            padding-top: 80px;
        }
        
        /* Image container */
        .image-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            overflow: hidden;
            border-radius: 0.5rem;
            background-color: #f5f5f5;
        }
        
        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        /* Breadcrumbs */
        .breadcrumbs {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 8px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumbs li {
            position: relative;
            margin: 0 10px;
            color: #1e293b;
            font-size: 14px;
            font-weight: 500;
        }
        
        .breadcrumbs a {
            color: #1e293b;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .breadcrumbs a:hover {
            color: #0ea5e9;
        }
        
        .breadcrumbs .separator {
            color: rgba(30, 41, 59, 0.6);
            font-size: 12px;
        }
        
        .breadcrumbs .current-page {
            color: #0ea5e9;
            font-weight: 600;
        }
        
        /* Content styling */
        .announcement-content {
            line-height: 1.8;
        }
        
        .announcement-content p {
            margin-bottom: 1.5rem;
        }
        
        /* Data visualization styles */
        .data-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .tab-button {
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background-color: #0ea5e9;
            color: white;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .data-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        
        .data-table tr:hover {
            background-color: #f9fafb;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-pink {
            background-color: #fce7f3;
            color: #be185d;
        }
        
        .badge-blue {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <audio src="musikdayak.mp3" autoplay loop class="hidden"></audio>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 py-3 bg-white shadow-sm">
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
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
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
            <div class="md:hidden hidden mt-4 bg-white rounded-lg p-4" id="mobile-menu">
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

    <!-- Main Content -->
    <main class="content-container">
        <div class="container mx-auto px-4 py-8">
            <!-- Breadcrumbs -->
            <div class="mb-8 text-center">
                <ul class="breadcrumbs">
                    <li>
                        <a href="index.php" class="hover:text-primary-600 transition">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                 
                    <li class="separator">
                        <i class="fas fa-chevron-right"></i>
                    </li>
                    <li>
                        <span class="current-page">Detail Data Balita</span>
                    </li>
                </ul>
            </div>
            
       
                    <!-- Tabs Navigation -->
                    <div class="flex flex-wrap border-b border-gray-200 mb-6">
                        <button class="tab-button px-4 py-2 font-medium rounded-t-lg mr-2 mb-2 bg-gray-100 text-gray-700 active" data-tab="total">
                            <i class="fas fa-chart-pie mr-2"></i>Total
                        </button>
                        <button class="tab-button px-4 py-2 font-medium rounded-t-lg mr-2 mb-2 bg-gray-100 text-gray-700" data-tab="jembowati">
                            <i class="fas fa-home mr-2"></i>Jembowati
                        </button>
                        <button class="tab-button px-4 py-2 font-medium rounded-t-lg mr-2 mb-2 bg-gray-100 text-gray-700" data-tab="srikandi">
                            <i class="fas fa-home mr-2"></i>Srikandi
                        </button>
                        <button class="tab-button px-4 py-2 font-medium rounded-t-lg mr-2 mb-2 bg-gray-100 text-gray-700" data-tab="arimbi">
                            <i class="fas fa-home mr-2"></i>Arimbi
                        </button>
                        <button class="tab-button px-4 py-2 font-medium rounded-t-lg mr-2 mb-2 bg-gray-100 text-gray-700" data-tab="larasati">
                            <i class="fas fa-home mr-2"></i>Larasati
                        </button>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="tab-content" id="total">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Distribusi Usia Balita</h3>
                                <div class="chart-container">
                                    <canvas id="ageDistributionChart"></canvas>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Perbandingan Jenis Kelamin</h3>
                                <div class="chart-container">
                                    <canvas id="genderComparisonChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
                            <h3 class="text-lg font-semibold mb-4">Detail Data Balita</h3>
                            <div class="overflow-x-auto">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Usia</th>
                                            <th>Perempuan</th>
                                            <th>Laki-laki</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0-12 Bulan</td>
                                            <td>25</td>
                                            <td>30</td>
                                            <td>55</td>
                                        </tr>
                                        <tr>
                                            <td>13-24 Bulan</td>
                                            <td>28</td>
                                            <td>24</td>
                                            <td>52</td>
                                        </tr>
                                        <tr>
                                            <td>25-36 Bulan</td>
                                            <td>28</td>
                                            <td>29</td>
                                            <td>57</td>
                                        </tr>
                                        <tr>
                                            <td>37-48 Bulan</td>
                                            <td>20</td>
                                            <td>19</td>
                                            <td>39</td>
                                        </tr>
                                        <tr>
                                            <td>49-60 Bulan</td>
                                            <td>21</td>
                                            <td>22</td>
                                            <td>43</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content hidden" id="jembowati">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Distribusi Usia Balita - Jembowati</h3>
                                <div class="chart-container">
                                    <canvas id="jembowatiAgeChart"></canvas>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Perbandingan Jenis Kelamin - Jembowati</h3>
                                <div class="chart-container">
                                    <canvas id="jembowatiGenderChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold mb-4">Detail Data Balita - Jembowati</h3>
                            <div class="overflow-x-auto">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Usia</th>
                                            <th>Perempuan</th>
                                            <th>Laki-laki</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0-12 Bulan</td>
                                            <td>11</td>
                                            <td>10</td>
                                            <td>21</td>
                                        </tr>
                                        <tr>
                                            <td>13-24 Bulan</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>11</td>
                                        </tr>
                                        <tr>
                                            <td>25-36 Bulan</td>
                                            <td>1</td>
                                            <td>5</td>
                                            <td>6</td>
                                        </tr>
                                        <tr>
                                            <td>37-48 Bulan</td>
                                            <td>7</td>
                                            <td>3</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>49-60 Bulan</td>
                                            <td>9</td>
                                            <td>5</td>
                                            <td>14</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content hidden" id="srikandi">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Distribusi Usia Balita - Srikandi</h3>
                                <div class="chart-container">
                                    <canvas id="srikandiAgeChart"></canvas>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Perbandingan Jenis Kelamin - Srikandi</h3>
                                <div class="chart-container">
                                    <canvas id="srikandiGenderChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold mb-4">Detail Data Balita - Srikandi</h3>
                            <div class="overflow-x-auto">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Usia</th>
                                            <th>Perempuan</th>
                                            <th>Laki-laki</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0-12 Bulan</td>
                                            <td>5</td>
                                            <td>5</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>13-24 Bulan</td>
                                            <td>7</td>
                                            <td>5</td>
                                            <td>12</td>
                                        </tr>
                                        <tr>
                                            <td>25-36 Bulan</td>
                                            <td>7</td>
                                            <td>6</td>
                                            <td>13</td>
                                        </tr>
                                        <tr>
                                            <td>37-48 Bulan</td>
                                            <td>4</td>
                                            <td>6</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>49-60 Bulan</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>8</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content hidden" id="arimbi">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Distribusi Usia Balita - Arimbi</h3>
                                <div class="chart-container">
                                    <canvas id="arimbiAgeChart"></canvas>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Perbandingan Jenis Kelamin - Arimbi</h3>
                                <div class="chart-container">
                                    <canvas id="arimbiGenderChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold mb-4">Detail Data Balita - Arimbi</h3>
                            <div class="overflow-x-auto">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Usia</th>
                                            <th>Perempuan</th>
                                            <th>Laki-laki</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0-12 Bulan</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>8</td>
                                        </tr>
                                        <tr>
                                            <td>13-24 Bulan</td>
                                            <td>5</td>
                                            <td>3</td>
                                            <td>8</td>
                                        </tr>
                                        <tr>
                                            <td>25-36 Bulan</td>
                                            <td>8</td>
                                            <td>10</td>
                                            <td>18</td>
                                        </tr>
                                        <tr>
                                            <td>37-48 Bulan</td>
                                            <td>5</td>
                                            <td>5</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>49-60 Bulan</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>7</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content hidden" id="larasati">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Distribusi Usia Balita - Larasati</h3>
                                <div class="chart-container">
                                    <canvas id="larasatiAgeChart"></canvas>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold mb-4">Perbandingan Jenis Kelamin - Larasati</h3>
                                <div class="chart-container">
                                    <canvas id="larasatiGenderChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold mb-4">Detail Data Balita - Larasati</h3>
                            <div class="overflow-x-auto">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Usia</th>
                                            <th>Perempuan</th>
                                            <th>Laki-laki</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0-12 Bulan</td>
                                            <td>5</td>
                                            <td>11</td>
                                            <td>16</td>
                                        </tr>
                                        <tr>
                                            <td>13-24 Bulan</td>
                                            <td>11</td>
                                            <td>10</td>
                                            <td>21</td>
                                        </tr>
                                        <tr>
                                            <td>25-36 Bulan</td>
                                            <td>12</td>
                                            <td>8</td>
                                            <td>20</td>
                                        </tr>
                                        <tr>
                                            <td>37-48 Bulan</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>9</td>
                                        </tr>
                                        <tr>
                                            <td>49-60 Bulan</td>
                                            <td>5</td>
                                            <td>9</td>
                                            <td>14</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="mt-10">
                    <a href="berita_pengumuman.php" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Pengumuman
                    </a>
                </div> -->
            </div>
        </div>
    </main>

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
        });
        
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                
                // Add active class to clicked button
                button.classList.add('active');
                button.classList.remove('bg-gray-100', 'text-gray-700');
                
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show selected tab content
                const tabId = button.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
        
        // Chart initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Total Age Distribution Chart
            const ageDistributionCtx = document.getElementById('ageDistributionChart').getContext('2d');
            const ageDistributionChart = new Chart(ageDistributionCtx, {
                type: 'bar',
                data: {
                    labels: ['0-12 Bulan', '13-24 Bulan', '25-36 Bulan', '37-48 Bulan', '49-60 Bulan'],
                    datasets: [
                        {
                            label: 'Perempuan',
                            data: [25, 28, 28, 20, 21],
                            backgroundColor: '#ec4899',
                            borderColor: '#ec4899',
                            borderWidth: 1
                        },
                        {
                            label: 'Laki-laki',
                            data: [30, 24, 29, 19, 22],
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Balita'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kelompok Usia'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            });
            
            // Total Gender Comparison Chart
            const genderComparisonCtx = document.getElementById('genderComparisonChart').getContext('2d');
            const genderComparisonChart = new Chart(genderComparisonCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Perempuan', 'Laki-laki'],
                    datasets: [{
                        data: [122, 124],
                        backgroundColor: ['#ec4899', '#3b82f6'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
    const label = context.label || '';
    const value = context.raw || 0;
    const total = context.dataset.data.reduce((a, b) => a + b, 0);
    const percentage = ((value / total) * 100).toFixed(1); // Ubah di sini
    return `${label}: ${value} (${percentage}%)`;
}

                            }
                        }
                    }
                }
            });
            
            // Jembowati Charts
            const jembowatiAgeCtx = document.getElementById('jembowatiAgeChart').getContext('2d');
            new Chart(jembowatiAgeCtx, {
                type: 'bar',
                data: {
                    labels: ['0-12 Bulan', '13-24 Bulan', '25-36 Bulan', '37-48 Bulan', '49-60 Bulan'],
                    datasets: [
                        {
                            label: 'Perempuan',
                            data: [11, 5, 1, 7, 9],
                            backgroundColor: '#ec4899',
                            borderColor: '#ec4899',
                            borderWidth: 1
                        },
                        {
                            label: 'Laki-laki',
                            data: [10, 6, 5, 3, 5],
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Balita'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kelompok Usia'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            });
            
            const jembowatiGenderCtx = document.getElementById('jembowatiGenderChart').getContext('2d');
            new Chart(jembowatiGenderCtx, {
                type: 'pie',
                data: {
                    labels: ['Perempuan', 'Laki-laki'],
                    datasets: [{
                        data: [33, 29],
                        backgroundColor: ['#ec4899', '#3b82f6'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
            
            // Srikandi Charts
            const srikandiAgeCtx = document.getElementById('srikandiAgeChart').getContext('2d');
            new Chart(srikandiAgeCtx, {
                type: 'bar',
                data: {
                    labels: ['0-12 Bulan', '13-24 Bulan', '25-36 Bulan', '37-48 Bulan', '49-60 Bulan'],
                    datasets: [
                        {
                            label: 'Perempuan',
                            data: [5, 7, 7, 4, 4],
                            backgroundColor: '#ec4899',
                            borderColor: '#ec4899',
                            borderWidth: 1
                        },
                        {
                            label: 'Laki-laki',
                            data: [5, 5, 6, 6, 4],
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Balita'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kelompok Usia'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            });
            
            const srikandiGenderCtx = document.getElementById('srikandiGenderChart').getContext('2d');
            new Chart(srikandiGenderCtx, {
                type: 'pie',
                data: {
                    labels: ['Perempuan', 'Laki-laki'],
                    datasets: [{
                        data: [27, 26],
                        backgroundColor: ['#ec4899', '#3b82f6'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
            
            // Arimbi Charts
            const arimbiAgeCtx = document.getElementById('arimbiAgeChart').getContext('2d');
            new Chart(arimbiAgeCtx, {
                type: 'bar',
                data: {
                    labels: ['0-12 Bulan', '13-24 Bulan', '25-36 Bulan', '37-48 Bulan', '49-60 Bulan'],
                    datasets: [
                        {
                            label: 'Perempuan',
                            data: [4, 5, 8, 5, 3],
                            backgroundColor: '#ec4899',
                            borderColor: '#ec4899',
                            borderWidth: 1
                        },
                        {
                            label: 'Laki-laki',
                            data: [4, 3, 10, 5, 4],
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Balita'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kelompok Usia'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            });
            
            const arimbiGenderCtx = document.getElementById('arimbiGenderChart').getContext('2d');
            new Chart(arimbiGenderCtx, {
                type: 'pie',
                data: {
                    labels: ['Perempuan', 'Laki-laki'],
                    datasets: [{
                        data: [25, 26],
                        backgroundColor: ['#ec4899', '#3b82f6'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
            
            // Larasati Charts
            const larasatiAgeCtx = document.getElementById('larasatiAgeChart').getContext('2d');
            new Chart(larasatiAgeCtx, {
                type: 'bar',
                data: {
                    labels: ['0-12 Bulan', '13-24 Bulan', '25-36 Bulan', '37-48 Bulan', '49-60 Bulan'],
                    datasets: [
                        {
                            label: 'Perempuan',
                            data: [5, 11, 12, 4, 5],
                            backgroundColor: '#ec4899',
                            borderColor: '#ec4899',
                            borderWidth: 1
                        },
                        {
                            label: 'Laki-laki',
                            data: [11, 10, 8, 5, 9],
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Balita'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kelompok Usia'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            });
            
            const larasatiGenderCtx = document.getElementById('larasatiGenderChart').getContext('2d');
            new Chart(larasatiGenderCtx, {
                type: 'pie',
                data: {
                    labels: ['Perempuan', 'Laki-laki'],
                    datasets: [{
                        data: [37, 43],
                        backgroundColor: ['#ec4899', '#3b82f6'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>