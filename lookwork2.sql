-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 04:10 PM
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
-- Database: `db_lowongan_kerja`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pekerjaan`
--

CREATE TABLE `kategori_pekerjaan` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keterampilan`
--

CREATE TABLE `keterampilan` (
  `id_keterampilan` int(11) NOT NULL,
  `id_pencari_kerja` int(11) DEFAULT NULL,
  `nama_keterampilan` varchar(255) NOT NULL,
  `sertifikat_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` int(11) NOT NULL,
  `id_pekerjaan` int(11) DEFAULT NULL,
  `id_pencari_kerja` int(11) DEFAULT NULL,
  `status` enum('dikirim','diproses','diterima','ditolak') DEFAULT 'dikirim',
  `tanggal_lamaran` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `id_perusahaan` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `judul_pekerjaan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `jenis_pekerjaan` enum('full_time','part_time','freelance','internship') NOT NULL,
  `tipe_kerja` enum('remote','wfo','hybrid') NOT NULL,
  `gaji` decimal(10,2) DEFAULT NULL,
  `tanggal_posting` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pencari_kerja`
--

CREATE TABLE `pencari_kerja` (
  `id_pencari_kerja` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `cv_url` varchar(255) DEFAULT NULL,
  `keterampilan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `id_pencari_kerja` int(11) DEFAULT NULL,
  `institusi` varchar(255) NOT NULL,
  `gelar` varchar(255) DEFAULT NULL,
  `bidang_studi` varchar(255) DEFAULT NULL,
  `tahun_mulai` year(4) DEFAULT NULL,
  `tahun_selesai` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman`
--

CREATE TABLE `pengalaman` (
  `id_pengalaman` int(11) NOT NULL,
  `id_pencari_kerja` int(11) DEFAULT NULL,
  `nama_institusi` varchar(255) NOT NULL,
  `jenis_pengalaman` enum('pekerjaan','magang','sukarela','organisasi','lainnya') NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `deskripsi_pengalaman` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(200) NOT NULL, 
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum('pencari_kerja','perusahaan','admin') NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `lokasi_perusahaan` varchar(255) DEFAULT NULL,
  `industri` varchar(255) DEFAULT NULL,
  `deskripsi_perusahaan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

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
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keterampilan`
--
ALTER TABLE `keterampilan`
  MODIFY `id_keterampilan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  MODIFY `id_pencari_kerja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengalaman`
--
ALTER TABLE `pengalaman`
  MODIFY `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `keterampilan`
--
ALTER TABLE `keterampilan`
  ADD CONSTRAINT `keterampilan_ibfk_1` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE;

--
-- Constraints for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `lamaran_ibfk_2` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE;

--
-- Constraints for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pekerjaan_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pekerjaan` (`id_kategori`) ON DELETE SET NULL;

--
-- Constraints for table `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  ADD CONSTRAINT `pencari_kerja_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD CONSTRAINT `pendidikan_ibfk_1` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE;

--
-- Constraints for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD CONSTRAINT `pengalaman_ibfk_1` FOREIGN KEY (`id_pencari_kerja`) REFERENCES `pencari_kerja` (`id_pencari_kerja`) ON DELETE CASCADE;

--
-- Constraints for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD CONSTRAINT `perusahaan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
