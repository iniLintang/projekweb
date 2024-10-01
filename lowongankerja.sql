  -- phpMyAdmin SQL Dump
  -- version 5.2.1
  -- https://www.phpmyadmin.net/
  --
  -- Host: 127.0.0.1
  -- Generation Time: Sep 30, 2024 at 02:53 AM
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
  -- Database: `lowongan_kerja`
  --

  -- --------------------------------------------------------

  --
  -- Table structure for table `admin`
  --

  CREATE TABLE `admin` (
    `admin_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `admin`
  --

  INSERT INTO `admin` (`admin_id`, `username`, `password`, `created_at`) VALUES
  (1, 'admin1', 'admin123', '2024-01-01 01:00:00'),
  (2, 'admin2', 'admin1234', '2024-01-02 02:00:00');

  -- --------------------------------------------------------

  --
  -- Table structure for table `companies`
  --

  CREATE TABLE `companies` (
    `company_id` int(11) NOT NULL,
    `company_name` varchar(100) NOT NULL,
    `company_description` text DEFAULT NULL,
    `contact_email` varchar(100) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `companies`
  --

  INSERT INTO `companies` (`company_id`, `company_name`, `company_description`, `contact_email`, `created_at`) VALUES
  (101, 'PT Teknologi Nusantara', 'Perusahaan teknologi terkemuka di Indonesia yang fokus pada pengembangan software dan aplikasi digital.', 'hr@teknologinusantara.co.id', '2023-12-25 03:00:00'),
  (102, 'CV Kreatif Media', 'Agensi kreatif yang berfokus pada pembuatan konten visual dan pemasaran digital.', 'info@kreatifmedia.com', '2023-12-26 04:00:00'),
  (103, 'PT Energi Hijau Indonesia', 'Perusahaan yang bergerak di bidang energi terbarukan, fokus pada solusi energi ramah lingkungan.', 'contact@energihijau.co.id', '2023-12-27 05:00:00'),
  (104, 'PT Fintech Solusi', 'Perusahaan teknologi finansial yang menyediakan layanan pembayaran digital dan solusi keuangan berbasis teknologi.', 'career@fintechsolusi.com', '2023-12-28 02:30:00'),
  (105, 'PT Dunia Edukasi', 'Platform pembelajaran online yang menyediakan berbagai kursus untuk pengembangan pribadi dan profesional.', 'support@duniaedukasi.co.id', '2023-12-29 01:45:00');

  -- --------------------------------------------------------

  --
  -- Table structure for table `jobs`
  --

  CREATE TABLE `jobs` (
    `job_id` int(11) NOT NULL,
    `company_id` int(11) NOT NULL,
    `job_title` varchar(100) NOT NULL,
    `job_description` text NOT NULL,
    `location` varchar(100) DEFAULT NULL,
    `salary_range` varchar(50) DEFAULT NULL,
    `job_type` enum('Full-Time','Part-Time','Contract','Internship') DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `jobs`
  --

  INSERT INTO `jobs` (`job_id`, `company_id`, `job_title`, `job_description`, `location`, `salary_range`, `job_type`, `created_at`) VALUES
  (1, 101, 'Pengembang Perangkat Lunak', 'Bertanggung jawab untuk mengembangkan aplikasi berbasis web dan mobile.', 'Jakarta, Indonesia', 'IDR 10.000.000 - 15.000.000', 'Full-Time', '2024-01-01 01:00:00'),
  (2, 102, 'Desainer Grafis', 'Membuat desain visual untuk keperluan pemasaran digital, cetak, dan media sosial.', 'Bandung, Indonesia', 'IDR 8.000.000 - 12.000.000', 'Contract', '2024-01-02 02:00:00'),
  (3, 103, 'Manajer Proyek', 'Mengelola proyek-proyek energi terbarukan dan memimpin tim lintas fungsi.', 'Surabaya, Indonesia', 'IDR 15.000.000 - 20.000.000', 'Full-Time', '2024-01-03 03:00:00'),
  (4, 104, 'Pengembang Aplikasi Mobile', 'Mengembangkan dan memelihara aplikasi mobile untuk platform Android dan iOS.', 'Jakarta, Indonesia', 'IDR 12.000.000 - 18.000.000', 'Part-Time', '2024-01-04 04:00:00'),
  (5, 105, 'Penulis Konten Kursus', 'Menulis konten edukasi untuk kursus-kursus online pada berbagai topik.', 'Yogyakarta, Indonesia', 'IDR 7.000.000 - 10.000.000', '', '2024-01-05 05:00:00');

  -- --------------------------------------------------------

  --
  -- Table structure for table `users`
  --

  CREATE TABLE `users` (
    `user_id` int(11) NOT NULL,
    `username` varchar(10) NOT NULL,
    `full_name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Dumping data for table `users`
  --

  INSERT INTO `users` (`user_id`, `username`, `full_name`, `email`, `password`, `created_at`) VALUES
  (1, 'lintang', 'lintang raina', 'lintangrainaa@mail.com', 'pass123', '2024-01-05 07:00:00'),
  (2, 'akbar123', 'akbar aleldul', 'akbarbirburbor@mail.com', 'pass1234', '2024-01-06 06:00:00'),
  (3, 'abiyy', 'abi cekut', 'abicekut@mail.com', 'pass12345', '2024-01-07 05:00:00'),
  (4, 'daven yo', 'daven algoritma', 'davenalgoritma@mail.com', 'pass123456', '2024-01-08 04:00:00'),
  (5, 'rizal ndut', 'rizal mexico', 'rizalmexico@mail.com', 'pass1234567', '2024-01-09 03:00:00');

  --
  -- Indexes for dumped tables
  --

  --
  -- Indexes for table `admin`
  --
  ALTER TABLE `admin`
    ADD PRIMARY KEY (`admin_id`),
    ADD UNIQUE KEY `username` (`username`);

  --
  -- Indexes for table `companies`
  --
  ALTER TABLE `companies`
    ADD PRIMARY KEY (`company_id`);

  --
  -- Indexes for table `jobs`
  --
  ALTER TABLE `jobs`
    ADD PRIMARY KEY (`job_id`),
    ADD KEY `company_id` (`company_id`);

  --
  -- Indexes for table `users`
  --
  ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
    ADD UNIQUE KEY `email` (`email`);

  --
  -- AUTO_INCREMENT for dumped tables
  --

  --
  -- AUTO_INCREMENT for table `admin`
  --
  ALTER TABLE `admin`
    MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

  --
  -- AUTO_INCREMENT for table `companies`
  --
  ALTER TABLE `companies`
    MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

  --
  -- AUTO_INCREMENT for table `jobs`
  --
  ALTER TABLE `jobs`
    MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

  --
  -- AUTO_INCREMENT for table `users`
  --
  ALTER TABLE `users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

  --
  -- Constraints for dumped tables
  --

  --
  -- Constraints for table `jobs`
  --
  ALTER TABLE `jobs`
    ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`);
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
