-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 11:25 AM
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

INSERT INTO `admin` (`id`, `nama`, `nip`, `jabatan`, `pangkat`, `golongan`, `username`, `password`) VALUES
(1, 'Ricard', '198012122020011001', 'admin kepala', 'Pembina Utama Muda', 'IV/c', 'admin', 'admin123');

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
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kasi`
--

INSERT INTO `kasi` (`id`, `nama`, `nip`, `pangkat`, `golongan`, `username`, `password`, `created_at`) VALUES
(1, 'Billy', '198705012015121001', 'Penata Muda', 'III/a', 'kasi', 'kasi', '2025-05-09 03:55:26');

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
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lurah`
--

INSERT INTO `lurah` (`id`, `nama`, `nip`, `pangkat`, `golongan`, `ttd`, `username`, `password`) VALUES
(1, 'ibu lurah', '19876543213221', 'Pangkat Lurah', 'Golongan Lurah', 'ttd_image.jpg', 'lurah', 'lurah1234');

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
  `file_surat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `jenis_surat`, `user_id`, `nama_pengaju`, `email_pengaju`, `no_telepon`, `alamat`, `tgl_pengajuan`, `status`, `alasan_penolakan`, `keterangan`, `foto_ktp`, `foto_kk`, `foto_formulir`, `file_surat`) VALUES
(29, 'SURAT KETERANGAN DOMISILI', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Diajukan', NULL, 'sfsaf', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png', NULL),
(32, 'SURAT KETERANGAN BELUM MENIKAH', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Verifikasi Lurah', NULL, 'sfsaf', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png', '1747127959_Metodologi_Agile_dan_SCRUM_dalam_Pengemb.pdf'),
(34, 'SURAT KETERANGAN BERKELAKUAN BAIK', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', NULL, 'zdffd', 'Image_2.jpg', 'Image_4.jpg', 'Image_7.jpg', NULL),
(35, 'SURAT KETERANGAN KELAHIRAN', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', NULL, 'asaas', 'Image_2.jpg', 'Image_132.jpg', 'Image_6.jpg', NULL),
(36, 'SURAT KETERANGAN PINDAH', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', NULL, 'sss', 'Image_134.jpg', 'Image_5.jpg', 'Image_5.jpg', NULL),
(37, 'SURAT KETERANGAN KEMATIAN', 1, 'user1', 'user1@example.com', '081234567890', 'Jln.baru', '2025-04-30', 'Menunggu', NULL, 'asa', 'Image_133.png', 'Image_136.jpg', 'Image_132.jpg', NULL),
(38, 'SURAT KETERANGAN KEMATIAN', 2, 'user2', 'user2@gmail.com', '082122', 'rta milono', '2025-04-30', 'Menunggu', NULL, 'eeeea', 'Image_135.jpg', 'Image_135.jpg', 'Image_3.jpg', NULL),
(41, 'SURAT KETERANGAN KEMATIAN', 2, 'user2', 'user2@gmail.com', '082122', 'Jln.baru', '2025-05-01', 'Verifikasi Lurah', NULL, 'ssss', 'Image_135.jpg', 'Image_134.jpg', 'Image_3.jpg', '1747127906_173-Article_Text-567-1-10-20211206.pdf'),
(42, 'SURAT KETERANGAN UNTUK MENIKAH', 2, 'user2', 'user2@gmail.com', '082122', 'rta milono', '2025-05-01', '', 'ad', 'aa', 'Image_134.jpg', 'Image_134.jpg', 'Image_136.jpg', NULL),
(44, 'SURAT KETERANGAN USAHA (SKU)', 2, 'user2', 'user2@gmail.com', '082122', 'ss', '2025-05-01', 'Diterima', NULL, 'ss', 'Image_132.jpg', 'Image_133.png', 'Image_2.jpg', '44_surat_1747057629.pdf'),
(45, 'SURAT KETERANGAN KELAHIRAN', 2, 'user2', 'user2@gmail.com', '082122', 'asdasd', '2025-05-01', 'Menunggu', NULL, 'sdsadsa', 'Image_3.jpg', 'Image_131.png', 'Image_3.jpg', NULL),
(46, 'SURAT KETERANGAN KEMATIAN', 2, 'user2', 'user2@gmail.com', '082122', 'aaaa', '2025-05-11', 'Menunggu', NULL, 'czczc', 'Image_136.jpg', 'Image_136.jpg', 'Image_135.jpg', NULL);

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
(1, 'user1', '12345678', 'user11', '081234567890', 'user1@example.com', '1234'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
