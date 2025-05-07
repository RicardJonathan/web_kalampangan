-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 04:17 AM
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
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'ibu lurah', '1987654321', 'Pangkat Lurah', 'Golongan Lurah', 'ttd_image.jpg', 'lurah', 'lurah1234');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id` int(11) NOT NULL,
  `jenis_surat` enum('Surat Keterangan Tidak Mampu','Surat Keterangan Kematian','Surat Keterangan Kelahiran','Surat Keterangan Pindah','Surat Keterangan Belum Menikah','Surat Keterangan Untuk Menikah','Pengajuan PBB Baru','Surat Keterangan Ahli Waris','Surat Keterangan Berkelakuan Baik','Surat Keterangan Domisili') NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pengaju` varchar(255) NOT NULL,
  `email_pengaju` varchar(100) NOT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` enum('Menunggu','Diajukan','Diproses','Diterima','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `keterangan` text DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `foto_kk` varchar(255) DEFAULT NULL,
  `foto_formulir` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id`, `jenis_surat`, `user_id`, `nama_pengaju`, `email_pengaju`, `no_telepon`, `alamat`, `tgl_pengajuan`, `status`, `keterangan`, `foto_ktp`, `foto_kk`, `foto_formulir`) VALUES
(29, 'Surat Keterangan Domisili', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Diajukan', 'sfsaf', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png'),
(30, 'Surat Keterangan Domisili', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'sfsaf', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png'),
(31, 'Surat Keterangan Domisili', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'sfsaf', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png'),
(32, 'Surat Keterangan Domisili', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'sfsaf', 'Image_1.jpg', 'Image_134.jpg', 'Image_131.png'),
(33, 'Surat Keterangan Berkelakuan Baik', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'zdffd', 'Image_2.jpg', 'Image_4.jpg', 'Image_7.jpg'),
(34, 'Surat Keterangan Berkelakuan Baik', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'zdffd', 'Image_2.jpg', 'Image_4.jpg', 'Image_7.jpg'),
(35, 'Surat Keterangan Kelahiran', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'asaas', 'Image_2.jpg', 'Image_132.jpg', 'Image_6.jpg'),
(36, 'Surat Keterangan Pindah', 1, 'user1', 'user1@example.com', '081234567890', 'rta milono', '2025-04-30', 'Menunggu', 'sss', 'Image_134.jpg', 'Image_5.jpg', 'Image_5.jpg'),
(37, '', 1, 'user1', 'user1@example.com', '081234567890', 'Jln.baru', '2025-04-30', 'Menunggu', 'asa', 'Image_133.png', 'Image_136.jpg', 'Image_132.jpg'),
(38, 'Surat Keterangan Kematian', 2, 'user2', 'user2@gmail.com', '082122', 'rta milono', '2025-04-30', 'Menunggu', 'eeeea', 'Image_135.jpg', 'Image_135.jpg', 'Image_3.jpg'),
(41, 'Pengajuan PBB Baru', 2, 'user2', 'user2@gmail.com', '082122', 'Jln.baru', '2025-05-01', 'Diajukan', 'ssss', 'Image_135.jpg', 'Image_134.jpg', 'Image_3.jpg'),
(42, 'Surat Keterangan Untuk Menikah', 2, 'user2', 'user2@gmail.com', '082122', 'rta milono', '2025-05-01', 'Diajukan', 'aa', 'Image_134.jpg', 'Image_134.jpg', 'Image_136.jpg'),
(43, 'Surat Keterangan Kematian', 2, 'user2', 'user2@gmail.com', '082122', 'rraf', '2025-05-01', 'Menunggu', 'dd', 'Image_3.jpg', 'Image_1.jpg', 'Image_133.png'),
(44, '', 2, 'user2', 'user2@gmail.com', '082122', 'ss', '2025-05-01', 'Menunggu', 'ss', 'Image_132.jpg', 'Image_133.png', 'Image_2.jpg'),
(45, 'Surat Keterangan Kelahiran', 2, 'user2', 'user2@gmail.com', '082122', 'asdasd', '2025-05-01', 'Menunggu', 'sdsadsa', 'Image_3.jpg', 'Image_131.png', 'Image_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `struktur`
--

CREATE TABLE `struktur` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `posisi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'user2', '21212211', 'user2', '082122', 'user2@gmail.com', '$2y$10$9BBKyAWHoa5i5CLLsdUp/.hhXO5OAKPFLdZ0xgvtgAJBWEZC1TQOq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lurah`
--
ALTER TABLE `lurah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `struktur`
--
ALTER TABLE `struktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
