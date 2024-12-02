-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 02:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lookworkv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_pengguna`, `jabatan`) VALUES
(1, 3, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pekerjaan`
--

CREATE TABLE `kategori_pekerjaan` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_pekerjaan`
--

INSERT INTO `kategori_pekerjaan` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Teknologi Informasi'),
(2, 'Desain Grafis'),
(3, 'Keuangan'),
(4, 'Pemasaran');

-- --------------------------------------------------------

--
-- Table structure for table `keterampilan`
--

CREATE TABLE `keterampilan` (
  `id_keterampilan` int(11) NOT NULL,
  `id_pencari_kerja` int(11) NOT NULL,
  `nama_keterampilan` varchar(255) DEFAULT NULL,
  `sertifikat_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keterampilan`
--

INSERT INTO `keterampilan` (`id_keterampilan`, `id_pencari_kerja`, `nama_keterampilan`, `sertifikat_url`) VALUES
(1, 1, 'Node.js', 'sertifikat_nodejs.pdf'),
(2, 1, 'ReactJS', 'sertifikat_react.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` int(11) NOT NULL,
  `id_pekerjaan` int(11) NOT NULL,
  `id_pencari_kerja` int(11) NOT NULL,
  `surat_lamaran` varchar(225) NOT NULL,
  `cv` varchar(225) NOT NULL,
  `status` enum('dikirim','diproses','diterima','ditolak') DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_lamaran` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lamaran`
--

INSERT INTO `lamaran` (`id_lamaran`, `id_pekerjaan`, `id_pencari_kerja`, `surat_lamaran`, `cv_url`, `status`, `deskripsi`, `tanggal_lamaran`) VALUES
(1, 1, 1, '', '', 'ditolak', '', '2024-10-26 12:24:03'),
(2, 2, 1, '', '', 'diproses', '', '2024-10-26 12:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `id_perusahaan` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `judul_pekerjaan` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `jenis_pekerjaan` enum('full_time','part_time','freelance','internship') DEFAULT NULL,
  `tipe_kerja` enum('remote','wfo','hybrid') DEFAULT NULL,
  `gaji_dari` decimal(10,2) DEFAULT NULL,
  `gaji_hingga` decimal(10,2) NOT NULL,
  `tanggal_posting` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_pekerjaan`, `id_perusahaan`, `id_kategori`, `judul_pekerjaan`, `deskripsi`, `lokasi`, `jenis_pekerjaan`, `tipe_kerja`, `gaji_dari`, `gaji_hingga`, `tanggal_posting`) VALUES
(1, 1, 1, 'Software Engineer', 'Mencari pengembang yang mahir dalam pengembangan aplikasi web.', 'Jakarta', 'full_time', 'wfo', 15000000.00, 0.00, '2024-10-26 12:24:02'),
(2, 1, 2, 'UI/UX Designer', 'Bertanggung jawab untuk mendesain user interface dan user experience.', 'Bandung', 'part_time', 'wfo', 8000000.00, 0.00, '2024-10-26 12:24:02'),
(3, 1, NULL, 'design grafis', 'xjsnkjx', 'Jakarta', 'part_time', 'hybrid', 10000.00, 0.00, '2024-10-28 16:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `pencari_kerja`
--

CREATE TABLE `pencari_kerja` (
  `id_pencari_kerja` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `cv_url` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pencari_kerja`
--

INSERT INTO `pencari_kerja` (`id_pencari_kerja`, `id_pengguna`, `cv_url`, `keterangan`) VALUES
(1, 1, 'cv_ahmad.pdf', 'Mahir dalam pengembangan aplikasi backend dengan Node.js dan Python.');

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `id_pencari_kerja` int(11) NOT NULL,
  `institusi` varchar(255) DEFAULT NULL,
  `gelar` varchar(255) DEFAULT NULL,
  `bidang_studi` varchar(255) DEFAULT NULL,
  `tahun_mulai` year(4) DEFAULT NULL,
  `tahun_selesai` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id_pendidikan`, `id_pencari_kerja`, `institusi`, `gelar`, `bidang_studi`, `tahun_mulai`, `tahun_selesai`) VALUES
(1, 1, 'Universitas Indonesia', 'S.Kom', 'Ilmu Komputer', '2017', '2021');

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman`
--

CREATE TABLE `pengalaman` (
  `id_pengalaman` int(11) NOT NULL,
  `id_pencari_kerja` int(11) NOT NULL,
  `nama_institusi` varchar(255) DEFAULT NULL,
  `jenis_pengalaman` enum('pekerjaan','magang','sukarela','organisasi','lainnya') DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `deskripsi_pengalaman` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengalaman`
--

INSERT INTO `pengalaman` (`id_pengalaman`, `id_pencari_kerja`, `nama_institusi`, `jenis_pengalaman`, `tanggal_mulai`, `tanggal_selesai`, `deskripsi_pengalaman`) VALUES
(1, 1, 'PT Maju Jaya', 'pekerjaan', '2021-05-01', '2023-07-01', 'Bekerja sebagai full-stack developer.'),
(2, 1, 'Universitas Negeri Jakarta', 'organisasi', '2020-01-01', '2020-12-31', 'Aktif di organisasi kemahasiswaan sebagai koordinator IT.');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum('pencari_kerja','perusahaan','admin') NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `apikey` text NOT NULL,
  `reset_password_otp` text NOT NULL,
  `reset_password_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `email`, `kata_sandi`, `peran`, `foto_profil`, `tanggal_dibuat`, `apikey`, `reset_password_otp`, `reset_password_created_at`, `username`) VALUES
(1, 'Ahmad Setiawan', 'ahmad@mail.com', 'password123', 'pencari_kerja', 'ahmad.jpg', '2024-10-26 12:24:02', '', '', '2024-11-11 12:52:46', ''),
(2, 'Dewi Lestari', 'dewi@mail.com', 'password123', 'perusahaan', 'dewi.jpg', '2024-10-26 12:24:02', '', '', '2024-11-11 12:52:46', ''),
(3, 'Budi Santoso', 'budi@mail.com', 'password123', 'admin', 'budi.jpg', '2024-10-26 12:24:02', '', '', '2024-11-11 12:52:46', '');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `lokasi_perusahaan` varchar(255) DEFAULT NULL,
  `industri` varchar(255) DEFAULT NULL,
  `deskripsi_perusahaan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `id_pengguna`, `lokasi_perusahaan`, `industri`, `deskripsi_perusahaan`) VALUES
(1, 2, 'Jakarta', 'Teknologi Informasi', 'Perusahaan startup teknologi yang bergerak di bidang pengembangan software.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keterampilan`
--
ALTER TABLE `keterampilan`
  ADD PRIMARY KEY (`id_keterampilan`),
  ADD KEY `id_pencari_kerja` (`id_pencari_kerja`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id_lamaran`),
  ADD KEY `id_pekerjaan` (`id_pekerjaan`),
  ADD KEY `id_pencari_kerja` (`id_pencari_kerja`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`),
  ADD KEY `id_perusahaan` (`id_perusahaan`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  ADD PRIMARY KEY (`id_pencari_kerja`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`),
  ADD KEY `id_pencari_kerja` (`id_pencari_kerja`);

--
-- Indexes for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD PRIMARY KEY (`id_pengalaman`),
  ADD KEY `id_pencari_kerja` (`id_pencari_kerja`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keterampilan`
--
ALTER TABLE `keterampilan`
  MODIFY `id_keterampilan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  MODIFY `id_pencari_kerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengalaman`
--
ALTER TABLE `pengalaman`
  MODIFY `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keterampilan`
--
ALTER TABLE `keterampilan`
  ADD CONSTRAINT `keterampilan_ibfk_1` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lamaran_ibfk_2` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `pekerjaan_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pekerjaan` (`id_kategori`);

--
-- Constraints for table `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  ADD CONSTRAINT `pencari_kerja_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD CONSTRAINT `pendidikan_ibfk_1` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD CONSTRAINT `pengalaman_ibfk_1` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD CONSTRAINT `perusahaan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
