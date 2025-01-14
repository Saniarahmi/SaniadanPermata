-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 07:18 AM
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
-- Database: `admin_kendaraan`
--

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `nomor_urut` int(11) NOT NULL,
  `no_pol` varchar(20) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `merk_kendaraan` varchar(100) NOT NULL,
  `tipe_kendaraan` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `nomor_urut`, `no_pol`, `nama_pemilik`, `alamat`, `merk_kendaraan`, `tipe_kendaraan`, `keterangan`, `tanggal`) VALUES
(2, 1, 'PY 1101 A', 'Atika Aulia', 'Kpr pepabri', 'fazio', 'a23gsjsw', 'Pajak 5th', '2025-01-08'),
(3, 2, 'PB 1234 AA', 'SANIA RAHMI UTARI', 'KM. 12', 'VARIO', 'G21-A', 'Balik Nama Kendaraan', '2025-01-04'),
(10, 0, 'PY 1101 AM', 'MEMEI CANTIK', 'jl suteja km 12 sorong (Jayapura)', 'VARIO', 'ABC21', 'perpanjang pajak', '2025-01-11'),
(12, 0, 'PY 1101 AM', 'MEMEI CANTIK', 'jl suteja km 12 sorong (Jayapura)', 'VARIO', 'ABC21', 'Duplikat STNK', '2025-02-12'),
(13, 0, 'PY 2301 EE', 'EVI ERIANY', 'JL. HANDAYANI BLOK B', 'VARIO', '125', 'Pajak Pertahun', '2025-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_cek`
--

CREATE TABLE `riwayat_cek` (
  `id` int(11) NOT NULL,
  `no_pol` varchar(20) NOT NULL,
  `tanggal_cek` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'e00cf25ad42683b3df678c61f42c6bda');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_cek`
--
ALTER TABLE `riwayat_cek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_pol` (`no_pol`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `riwayat_cek`
--
ALTER TABLE `riwayat_cek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `riwayat_cek`
--
ALTER TABLE `riwayat_cek`
  ADD CONSTRAINT `riwayat_cek_ibfk_1` FOREIGN KEY (`no_pol`) REFERENCES `kendaraan` (`no_pol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
