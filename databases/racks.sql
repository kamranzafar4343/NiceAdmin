-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 02:14 PM
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
-- Database: `catmarketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `racks`
--

CREATE TABLE `racks` (
  `id` int(11) NOT NULL,
  `rack_code` varchar(50) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `horizontal` varchar(5) DEFAULT NULL,
  `rack_number` varchar(5) DEFAULT NULL,
  `column_identifier` varchar(5) DEFAULT NULL,
  `position_number` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `racks`
--

INSERT INTO `racks` (`id`, `rack_code`, `level`, `horizontal`, `rack_number`, `column_identifier`, `position_number`) VALUES
(2, 'L', '05', 'H', '01', 'C', '08'),
(3, 'L', '06', 'G', '02', 'D', '04'),
(4, 'L', '07', 'G', '03', 'D', '05'),
(5, 'L', '08', 'G', '04', 'D', '08'),
(7, 'L', '02', 'H', '06', 'G', '02'),
(8, 'M', '02', 'H', '08', 'G', '01'),
(10, 'N', '02', 'H', '08', 'G', '02'),
(11, 'N', '02', 'H', '07', 'G', '02'),
(12, 'N', '02', 'H', '07', 'G', '03'),
(14, 'N', '02', 'H', '07', 'G', '09'),
(15, 'N', '02', 'H', '07', 'G', '07'),
(16, 'L', '03', 'H', '07', 'G', '07'),
(17, 'L', '03', 'H', '07', 'G', '04'),
(18, 'A', '01', 'B', '01', 'C', '01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `racks`
--
ALTER TABLE `racks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `racks`
--
ALTER TABLE `racks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
