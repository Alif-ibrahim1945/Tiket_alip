-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 01:54 AM
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
-- Database: `db_bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `name`, `password`, `created_at`) VALUES
(5, 'ibrabaenya@gmail.com', 'alip si admin', '$2y$10$6s6GZoWwbGJYKS3ecpuyOuVZextTIx51t9gX/hUIZOy8WpqWZ1fC6', '2025-02-24 14:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `akun_mall`
--

CREATE TABLE `akun_mall` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_mall` varchar(100) NOT NULL,
  `nik` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun_mall`
--

INSERT INTO `akun_mall` (`id`, `email`, `password`, `nama_mall`, `nik`) VALUES
(1, 'ibrasans9@gmail.com', '$2y$10$Fzmj6r0smJni/0Kdt2dg6urapwLLCdmlzimtc5MvaFdSmFJYbaaV6', 'Depok', '222131232');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int(100) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `trailer` varchar(111) NOT NULL,
  `nama_film` varchar(123) NOT NULL,
  `judul` longtext NOT NULL,
  `total_menit` varchar(123) NOT NULL,
  `usia` varchar(123) NOT NULL,
  `genre` varchar(123) NOT NULL,
  `dimensi` varchar(123) NOT NULL,
  `producer` varchar(111) NOT NULL,
  `Director` varchar(123) NOT NULL,
  `Writer` varchar(211) NOT NULL,
  `Cast` varchar(222) NOT NULL,
  `Distributor` varchar(222) NOT NULL,
  `harga` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `poster`, `banner`, `trailer`, `nama_film`, `judul`, `total_menit`, `usia`, `genre`, `dimensi`, `producer`, `Director`, `Writer`, `Cast`, `Distributor`, `harga`) VALUES
(26, 'upload/poster/posterr.jpg', 'upload/banner/jarjit.jpeg', 'upload/trailer/Upin & Ipin： Season 15 ｜ Official Trailer ｜ Netflix.mp4', 'Upin Ipin Siamang Tunggal', 'Film Upin Ipin', '135', 'SU', 'Adventure,Family', '3D', 'alip', 'alip', 'alip', 'alip', 'alip', '65.000'),
(28, 'upload/poster/posteriblis.jpg', 'upload/banner/posteriblis.jpg', 'upload/trailer/Upin & Ipin： Season 15 ｜ Official Trailer ｜ Netflix.mp4', 'Hantu', 'ih seram', '120', '17', 'Horror', '3D', 'alip', 'alip', 'alip', 'alip', 'alip', '100000');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_film`
--

CREATE TABLE `jadwal_film` (
  `id` int(11) NOT NULL,
  `mall_id` int(100) NOT NULL,
  `film_id` int(100) NOT NULL,
  `studio` varchar(100) NOT NULL,
  `jam_tayang_1` time NOT NULL,
  `jam_tayang_2` time NOT NULL,
  `jam_tayang_3` time NOT NULL,
  `tanggal_tayang` date NOT NULL,
  `tanggal_akhir_tayang` date NOT NULL,
  `total_menit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_film`
--

INSERT INTO `jadwal_film` (`id`, `mall_id`, `film_id`, `studio`, `jam_tayang_1`, `jam_tayang_2`, `jam_tayang_3`, `tanggal_tayang`, `tanggal_akhir_tayang`, `total_menit`) VALUES
(1, 1, 26, 'Studio 2', '16:15:00', '20:15:00', '23:15:00', '2025-02-22', '2025-03-24', '135'),
(2, 1, 28, 'Studio 1', '21:46:00', '09:46:00', '11:48:00', '2025-02-24', '2025-03-08', '120');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp_code` varchar(10) NOT NULL,
  `created _at` timestamp(1) NOT NULL DEFAULT current_timestamp(1) ON UPDATE current_timestamp(1),
  `expires_at` timestamp(1) NOT NULL DEFAULT current_timestamp(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `mall_name` varchar(255) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `status` enum('available','occupied') NOT NULL,
  `film_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `mall_name`, `seat_number`, `status`, `film_name`) VALUES
(1, 'Depok', 'E7', 'occupied', 'Upin Ipin Siamang Tunggal'),
(2, 'Depok', 'A2', 'occupied', 'Upin Ipin Siamang Tunggal'),
(3, 'Depok', 'G10', 'occupied', 'Upin Ipin Siamang Tunggal'),
(4, 'Depok', 'F9', 'occupied', 'Upin Ipin Siamang Tunggal'),
(5, 'Depok', 'D4', 'occupied', 'Upin Ipin Siamang Tunggal'),
(6, 'Depok', 'D5', 'occupied', 'Upin Ipin Siamang Tunggal'),
(7, 'Depok', 'D6', 'occupied', 'Upin Ipin Siamang Tunggal'),
(8, 'Depok', 'D7', 'occupied', 'Upin Ipin Siamang Tunggal'),
(9, 'Depok', 'E4', 'occupied', 'Upin Ipin Siamang Tunggal'),
(10, 'Depok', 'E5', 'occupied', 'Upin Ipin Siamang Tunggal'),
(11, 'Depok', 'E6', 'occupied', 'Upin Ipin Siamang Tunggal'),
(12, 'Depok', 'E8', 'occupied', 'Upin Ipin Siamang Tunggal'),
(13, 'Depok', 'A4', 'occupied', 'Upin Ipin Siamang Tunggal'),
(14, 'Depok', 'G4', 'occupied', 'Upin Ipin Siamang Tunggal'),
(15, 'Depok', 'A7', 'occupied', 'Upin Ipin Siamang Tunggal'),
(16, 'Depok', 'A5', 'occupied', 'Upin Ipin Siamang Tunggal'),
(17, 'Depok', 'A10', 'occupied', 'Upin Ipin Siamang Tunggal'),
(18, 'Depok', 'B8', 'occupied', 'Upin Ipin Siamang Tunggal'),
(19, 'Depok', 'A8', 'occupied', 'Upin Ipin Siamang Tunggal'),
(20, 'Depok', 'B10', 'occupied', 'Upin Ipin Siamang Tunggal'),
(21, 'Depok', 'A9', 'occupied', 'Upin Ipin Siamang Tunggal'),
(22, 'Depok', 'B9', 'occupied', 'Upin Ipin Siamang Tunggal'),
(23, 'Depok', 'G5', 'occupied', 'Upin Ipin Siamang Tunggal'),
(24, 'Depok', 'A6', 'occupied', 'Upin Ipin Siamang Tunggal'),
(25, 'Depok', 'B6', 'occupied', 'Upin Ipin Siamang Tunggal'),
(26, 'Depok', 'B7', 'occupied', 'Upin Ipin Siamang Tunggal'),
(27, 'Depok', 'B4', 'occupied', 'Upin Ipin Siamang Tunggal'),
(28, 'Depok', 'B5', 'occupied', 'Upin Ipin Siamang Tunggal'),
(29, 'Depok', 'C7', 'occupied', 'Upin Ipin Siamang Tunggal'),
(30, 'Depok', 'C6', 'occupied', 'Upin Ipin Siamang Tunggal'),
(31, 'Depok', 'A4', 'occupied', 'Hantu'),
(32, 'Depok', 'A5', 'occupied', 'Hantu'),
(33, 'Depok', 'A1', 'occupied', 'Hantu'),
(34, 'Depok', 'A3', 'occupied', 'Hantu'),
(35, 'Depok', 'C10', 'occupied', 'Upin Ipin Siamang Tunggal'),
(36, 'Depok', 'A1', 'occupied', 'Upin Ipin Siamang Tunggal'),
(37, 'Depok', 'A3', 'occupied', 'Upin Ipin Siamang Tunggal'),
(38, 'Depok', 'A6', 'occupied', 'Hantu'),
(39, 'Depok', 'A7', 'occupied', 'Hantu'),
(40, 'Depok', 'B4', 'occupied', 'Hantu'),
(41, 'Depok', 'B3', 'occupied', 'Upin Ipin Siamang Tunggal');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(250) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `amount` int(250) NOT NULL,
  `transaction_time` datetime NOT NULL,
  `username` varchar(250) NOT NULL,
  `seat_number` varchar(250) NOT NULL,
  `nama_film` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `status`, `payment_type`, `amount`, `transaction_time`, `username`, `seat_number`, `nama_film`) VALUES
(1, 'TIX-1740121544', 'settlement', 'qris', 5000, '2025-02-21 14:05:55', 'alifbaenya@gmail.com', 'A10', 'Doraemon the Movie: Nobita\'s Art World Tales'),
(37, 'TIX-1740214491', 'settlement', 'qris', 65, '2025-02-22 15:54:59', 'satiadarmaaa@gmail.com', 'C6', 'Upin Ipin Siamang Tunggal'),
(38, 'TIX1740408398', 'settlement', 'qris', 200000, '2025-02-24 21:46:42', 'ibrasans9@gmail.com', 'A4,A5', 'Hantu'),
(39, 'TIX-1740450270', 'settlement', 'qris', 65, '2025-02-25 09:24:41', 'alifbaenya@gmail.com', 'A3', 'Upin Ipin Siamang Tunggal'),
(40, 'TIX-1740450391', 'settlement', 'qris', 200000, '2025-02-25 09:26:34', 'alifbaenya@gmail.com', 'A6,A7', 'Hantu'),
(41, 'TIX-1740455385', 'settlement', 'qris', 100000, '2025-02-25 10:49:48', 'ibrabaenya@gmail.com', 'B4', 'Hantu');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `created_at`) VALUES
(5, 'alifbaenya@gmail.com', 'alip', '$2y$10$7pnF0yuqOopJI8y7.UjouOdq..e/X3WCqFIWEYniYLSoO3Wau3NEm', '2025-02-25 02:18:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akun_mall`
--
ALTER TABLE `akun_mall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `akun_mall`
--
ALTER TABLE `akun_mall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
