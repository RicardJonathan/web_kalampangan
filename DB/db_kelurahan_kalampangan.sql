-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 07:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kelurahan_kalampangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `pangkat` varchar(50) DEFAULT NULL,
  `golongan` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `no_telepon`, `nip`, `jabatan`, `pangkat`, `golongan`, `username`, `password`) VALUES
(1, 'Ricard', '6282152695679', '198012122020011001', 'admin kepala', 'Pembina Utama Muda', 'IV/c', 'admin', '$2y$10$DPbKg.40RBTRhzFiGfgt7.hGmJDCheRUl8Y3yWvFiKZWLm145BE.C');

-- --------------------------------------------------------

--
-- Table structure for table `kasi`
--

CREATE TABLE `kasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `golongan` varchar(10) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jenis_surat_dikelola` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kasi`
--

INSERT INTO `kasi` (`id`, `nama`, `nip`, `pangkat`, `golongan`, `no_telepon`, `username`, `password`, `created_at`, `jenis_surat_dikelola`) VALUES
(1, 'Billy', '198705012015121001', 'Penata Muda', 'III/a', '6287877602333', 'kasi', 'kasi', '2025-05-09 03:55:26', '[\"SURAT KETERANGAN KEMATIAN\",\"SURAT KETERANGAN USAHA (SKU)\"]'),
(3, 'KASI PEM', '12223333', 'kasi2', 'golongan2', '6282152695679 ', 'KASI PEM', '$2y$10$brixn0jlfb5hohp6vz9kl.LMMQ76QnynOEwTPeD2XbRHATYvRXAnq', '2025-05-23 14:03:27', '[\"Pengajuan PBB\", \"Surat Keterangan Ahli Waris\", \"Keterangan Domisili\", \"Surat Keterangan Berkelakuan Baik\", \"Surat Keterangan Pindah\", \"Surat Keterangan Kematian\"]\r\n'),
(4, 'KASI KESOS', '1212121323', 'kasi3', 'golongan3', ' 6282152695679 ', 'KASI KESOS', '$2y$10$0iPvwk.TaaiOO236nyQsLOlhJvplX/U4UmrCxTCIwxBlGrULLwxkO', '2025-05-23 14:04:14', '[\"Surat Keterangan Kelahiran\", \"Surat Keterangan Belum Menikah\", \"Surat Keterangan untuk Menikah\"]\r\n'),
(6, 'Mba Janah', '198512012023032001', 'Penata Muda', 'III/a', ' 6282152695679 ', 'kasipmk', '12345', '2025-05-23 14:23:12', '[\"SURAT KETERANGAN KEMATIAN\",\"SURAT KETERANGAN USAHA (SKU)\"]');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `judul`, `deskripsi`, `foto`, `created_at`) VALUES
(1, 'HIDUP SEPERTI LARRY', 'aaaaa', 'foto_681ccc0259ef05.39487553.jpg', '2025-05-08 22:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `lurah`
--

CREATE TABLE `lurah` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `pangkat` varchar(50) DEFAULT NULL,
  `golongan` varchar(50) DEFAULT NULL,
  `ttd` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lurah`
--

INSERT INTO `lurah` (`id`, `nama`, `nip`, `pangkat`, `golongan`, `ttd`, `username`, `password`, `no_telepon`) VALUES
(1, 'ibu lurah1', '19876543213221', 'Pangkat Lurah', 'Golongan Lurah', 'ttd_image.jpg', 'lurah', '$2y$10$dwall5ASvOYg1MXHn.UMZ.r3P9nuWoYWqlRMTixeRBXHpxIGS.b8S', '6282152695679');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id` int(11) NOT NULL,
  `jenis_surat` enum('SURAT KETERANGAN USAHA (SKU)','SURAT KETERANGAN TIDAK MAMPU (SKTM)','SURAT KETERANGAN KEMATIAN','SURAT KETERANGAN KELAHIRAN','SURAT KETERANGAN PINDAH','SURAT KETERANGAN BELUM MENIKAH','SURAT KETERANGAN UNTUK MENIKAH','PENGAJUAN PBB BARU','SURAT KETERANGAN AHLI WARIS','SURAT KETERANGAN BERKELAKUAN BAIK','SURAT KETERANGAN DOMISILI') NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pengaju` varchar(255) NOT NULL,
  `email_pengaju` varchar(100) NOT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` enum('Menunggu','Diajukan','Verifikasi Kasi','Verifikasi Lurah','Diterima','Ditolak') NOT NULL,
  `alasan_penolakan` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `foto_kk` varchar(255) DEFAULT NULL,
  `foto_formulir` varchar(255) DEFAULT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `notif_terkirim` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `jenis_surat`, `user_id`, `nama_pengaju`, `email_pengaju`, `no_telepon`, `alamat`, `tgl_pengajuan`, `status`, `alasan_penolakan`, `keterangan`, `foto_ktp`, `foto_kk`, `foto_formulir`, `file_surat`, `notif_terkirim`) VALUES
(32, 'PENGAJUAN PBB BARU', 1, 'user1', 'user1@example.com', '081234567890', 'rta milonosa', '2025-04-30', 'Verifikasi Kasi', NULL, 'sfsafaaaa', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png', '1747127959_Metodologi_Agile_dan_SCRUM_dalam_Pengemb.pdf', '[\"Verifikasi Kasi\"]'),
(34, 'SURAT KETERANGAN BERKELAKUAN BAIK', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Diajukan', NULL, 'zdffd', 'Image_2.jpg', 'Image_4.jpg', 'Image_7.jpg', NULL, '[\"Diajukan\"]'),
(35, 'SURAT KETERANGAN KELAHIRAN', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Verifikasi Lurah', NULL, 'asaas', 'Image_2.jpg', 'Image_132.jpg', 'Image_6.jpg', NULL, '[\"Verifikasi Kasi\",\"Diajukan\",\"Verifikasi Lurah\"]'),
(36, 'SURAT KETERANGAN PINDAH', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Diajukan', NULL, 'sss', 'Image_134.jpg', 'Image_5.jpg', 'Image_5.jpg', NULL, '[\"Diajukan\"]'),
(37, 'SURAT KETERANGAN KEMATIAN', 1, 'user1', 'user1@example.com', '081234567890', 'Jln.baru', '2025-04-30', 'Verifikasi Lurah', NULL, 'asa', 'Image_133.png', 'Image_136.jpg', 'Image_132.jpg', NULL, '[\"Diajukan\",\"Verifikasi Kasi\",\"Verifikasi Lurah\"]'),
(45, 'SURAT KETERANGAN KELAHIRAN', 2, 'user2', 'user2@gmail.com', '082122', 'asdasd', '2025-05-01', 'Verifikasi Lurah', NULL, 'sdsadsa', 'Image_3.jpg', 'Image_131.png', 'Image_3.jpg', '45_surat_1747716810.pdf', '[\"Verifikasi Kasi\",\"Diajukan\",\"Verifikasi Lurah\"]'),
(50, 'SURAT KETERANGAN KELAHIRAN', 2, 'user2', 'user2@gmail.com', '082122221', 'Jln.baru', '2025-05-22', 'Diajukan', NULL, 'aaaaa', 'dh.jpg', 'pp.jpg', 'jj.jpg', NULL, '[\"Diajukan\"]'),
(51, 'SURAT KETERANGAN BERKELAKUAN BAIK', 2, 'user2', 'user2@gmail.com', '082122221', 'aswdadw', '2025-05-22', 'Diajukan', NULL, 'adwada', 'ggg.jpg', 'dh.jpg', 'jj.jpg', NULL, '[\"Verifikasi Kasi\",\"Verifikasi Lurah\",\"Diajukan\"]'),
(52, 'PENGAJUAN PBB BARU', 2, 'user2', 'user2@gmail.com', '082122221', 'ssadad', '2025-05-22', 'Verifikasi Lurah', NULL, 'adaeada', 'pp.jpg', 'dh.jpg', 'jj.jpg', '52_surat_1747925720.pdf', '[\"Verifikasi Kasi\",\"Verifikasi Lurah\"]'),
(53, 'SURAT KETERANGAN PINDAH', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-22', 'Diajukan', NULL, 'sadasdad', 'gg.jpg', 'ggg.jpg', 'jj.jpg', '53_surat_1747925512.pdf', '[\"Diajukan\"]'),
(54, 'SURAT KETERANGAN BELUM MENIKAH', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-23', 'Verifikasi Lurah', NULL, 'baru', 'pp.jpg', 'jj.jpg', 'jj.jpg', NULL, '[\"Diajukan\",\"Verifikasi Lurah\"]'),
(55, 'SURAT KETERANGAN TIDAK MAMPU (SKTM)', 2, 'user2', 'user2@gmail.com', '082122221', 'aaaawdsd', '2025-05-23', 'Diajukan', NULL, 'asasa', 'na.jpg', 'dh.jpg', 'pp.jpg', NULL, '[\"Diajukan\"]'),
(56, 'SURAT KETERANGAN AHLI WARIS', 1, 'user1', 'user1@example.com', '081234567890', 'sdsada', '2025-05-23', 'Diajukan', NULL, 'adsda', 'jj.jpg', 'pic7.jpg', 'ggg.jpg', NULL, '[\"Diajukan\"]'),
(57, 'SURAT KETERANGAN AHLI WARIS', 1, 'user1', 'user1@example.com', '081234567890', 'SASAS', '2025-05-23', 'Verifikasi Lurah', NULL, 'ASASAS', 'na.jpg', 'pp.jpg', 'dh.jpg', NULL, '[\"Verifikasi Kasi\",\"Verifikasi Lurah\"]'),
(58, 'SURAT KETERANGAN USAHA (SKU)', 1, 'user1', 'user1@example.com', '081234567890', 'baru', '2025-05-23', 'Verifikasi Kasi', NULL, 'baru', 'pp.jpg', 'jalan.jpg', 'Activity Diagram Login Admin.drawio.png', NULL, '[\"Verifikasi Kasi\"]'),
(59, 'SURAT KETERANGAN TIDAK MAMPU (SKTM)', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-23', 'Verifikasi Kasi', NULL, 'sas', 'jalan.jpg', 'pp.jpg', 'jalan.jpg', NULL, '[\"Verifikasi Kasi\"]'),
(60, 'SURAT KETERANGAN KEMATIAN', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-23', 'Verifikasi Lurah', NULL, 'adad', 'dh.jpg', 'gg.jpg', 'ggg.jpg', NULL, '[\"Diajukan\",\"Verifikasi Kasi\",\"Verifikasi Lurah\"]'),
(61, 'SURAT KETERANGAN AHLI WARIS', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-23', 'Diajukan', NULL, 'assasas', 'pp.jpg', 'na.jpg', 'pp.jpg', NULL, '[\"Verifikasi Kasi\",\"Diajukan\"]'),
(62, 'SURAT KETERANGAN KEMATIAN', 2, 'user2', 'user2@gmail.com', '082122221', 'dasdad', '2025-05-23', 'Verifikasi Lurah', NULL, 'sadsd', 'gg.jpg', 'na.jpg', 'jj.jpg', NULL, '[\"Verifikasi Kasi\",\"Diajukan\",\"Verifikasi Lurah\"]'),
(63, 'SURAT KETERANGAN KELAHIRAN', 2, 'user2', 'user2@gmail.com', '082122221', 'assdad', '2025-05-23', 'Verifikasi Lurah', NULL, 'dasdad', 'dh.jpg', 'jalan.jpg', 'na.jpg', NULL, '[\"Verifikasi Kasi\",\"Verifikasi Lurah\",\"Diajukan\"]'),
(64, 'SURAT KETERANGAN PINDAH', 2, 'user2', 'user2@gmail.com', '082122221', 'adwada', '2025-05-24', 'Verifikasi Lurah', NULL, 'awdd', 'jalan.jpg', 'ggg.jpg', 'dh.jpg', NULL, '[\"Diajukan\",\"Verifikasi Kasi\",\"Verifikasi Lurah\"]'),
(65, 'SURAT KETERANGAN TIDAK MAMPU (SKTM)', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-24', 'Diajukan', NULL, 'aaa', 'dh.jpg', 'pic7.jpg', 'jj.jpg', NULL, '[\"Diajukan\",\"Verifikasi Kasi\"]'),
(66, 'SURAT KETERANGAN TIDAK MAMPU (SKTM)', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-05-24', 'Verifikasi Kasi', NULL, 'sktm baru', 'gg.jpg', 'jalan.jpg', 'gg.jpg', NULL, '[\"Diajukan\",\"Verifikasi Kasi\"]'),
(67, 'SURAT KETERANGAN BELUM MENIKAH', 2, 'user2', 'user2@gmail.com', '082122221', 'rta milono', '2025-05-24', 'Verifikasi Kasi', NULL, 'sdadsd', 'dh.jpg', 'jalan.jpg', 'gg.jpg', NULL, '[\"Diajukan\",\"Verifikasi Kasi\"]');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `deskripsi`, `foto`, `created_at`) VALUES
(4, 'HIDUP SEPERTI LARRY', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'foto_681ca84ca2f210.90884078.jpg', '2025-05-08 19:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `struktur`
--

CREATE TABLE `struktur` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `struktur`
--

INSERT INTO `struktur` (`id`, `foto`, `nama`, `posisi`, `created_at`) VALUES
(1, 'foto_681cdecf3980b7.25987588.png', 'RAYYYYY', 'WAKIL KETUA GANGSTERR', '2025-05-08 23:07:37'),
(2, 'foto_681cde82a5d4a1.45919865.png', 'BRIMAEL', 'KETUA GANGSTER', '2025-05-08 23:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `nik`, `username`, `no_telepon`, `email`, `password`) VALUES
(1, 'user1', '12345678', 'user11', '081234567890', 'user1@example.com', '$2y$10$AHtL/uGIy24msb6m.sJ2leUvV8osKRDK11SVl78Z7LDiCQkor.wqG'),
(2, 'user2', '21212211', 'user2', '082122221', 'user2@gmail.com', '$2y$10$9BBKyAWHoa5i5CLLsdUp/.hhXO5OAKPFLdZ0xgvtgAJBWEZC1TQOq'),
(4, 'user4', '112221', 'user4', '08124443', 'user4@gmail.com', '$2y$10$cp2mJM9zbOU2z2AO7C/pK.TDV/IaF.E6DcZrwps7ryh8VFVRAePpS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kasi`
--
ALTER TABLE `kasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lurah`
--
ALTER TABLE `lurah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `struktur`
--
ALTER TABLE `struktur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kasi`
--
ALTER TABLE `kasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lurah`
--
ALTER TABLE `lurah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `struktur`
--
ALTER TABLE `struktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `pengajuan_surat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
