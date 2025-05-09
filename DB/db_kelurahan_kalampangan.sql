-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Bulan Mei 2025 pada 05.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `admin`
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
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `nip`, `jabatan`, `pangkat`, `golongan`, `username`, `password`) VALUES
(1, 'Ricard', '198012122020011001', 'admin kepala', 'Pembina Utama Muda', 'IV/c', 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `judul`, `deskripsi`, `foto`, `created_at`) VALUES
(1, 'HIDUP SEPERTI LARRY', 'aaaaa', 'foto_681ccc0259ef05.39487553.jpg', '2025-05-08 22:21:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lurah`
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
-- Dumping data untuk tabel `lurah`
--

INSERT INTO `lurah` (`id`, `nama`, `nip`, `pangkat`, `golongan`, `ttd`, `username`, `password`) VALUES
(1, 'ibu lurah', '1987654321', 'Pangkat Lurah', 'Golongan Lurah', 'ttd_image.jpg', 'lurah', 'lurah1234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_surat`
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
-- Dumping data untuk tabel `pengajuan_surat`
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
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `deskripsi`, `foto`, `created_at`) VALUES
(4, 'HIDUP SEPERTI LARRY', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'foto_681ca84ca2f210.90884078.jpg', '2025-05-08 19:49:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur`
--

CREATE TABLE `struktur` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `posisi` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `struktur`
--

INSERT INTO `struktur` (`id`, `foto`, `nama`, `posisi`, `created_at`) VALUES
(1, 'foto_681cdecf3980b7.25987588.png', 'RAYYYYY', 'WAKIL KETUA GANGSTERR', '2025-05-08 23:07:37'),
(2, 'foto_681cde82a5d4a1.45919865.png', 'BRIMAEL', 'KETUA GANGSTER', '2025-05-08 23:10:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `nik`, `username`, `no_telepon`, `email`, `password`) VALUES
(1, 'user1', '12345678', 'user11', '081234567890', 'user1@example.com', '1234'),
(2, 'user2', '21212211', 'user2', '082122', 'user2@gmail.com', '$2y$10$9BBKyAWHoa5i5CLLsdUp/.hhXO5OAKPFLdZ0xgvtgAJBWEZC1TQOq');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lurah`
--
ALTER TABLE `lurah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `struktur`
--
ALTER TABLE `struktur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lurah`
--
ALTER TABLE `lurah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `struktur`
--
ALTER TABLE `struktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `pengajuan_surat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
