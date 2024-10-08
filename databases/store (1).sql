-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 09:12 AM
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
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `level1` varchar(255) NOT NULL,
  `level2` varchar(255) NOT NULL,
  `level3` varchar(255) NOT NULL,
  `barcode_select` int(11) NOT NULL,
  `alt_code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `rack_select` int(11) NOT NULL,
  `object_code` enum('Container','FileFolder') NOT NULL,
  `status` enum('In') NOT NULL,
  `add_date` date NOT NULL,
  `destroy_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `level1`, `level2`, `level3`, `barcode_select`, `alt_code`, `description`, `rack_select`, `object_code`, `status`, `add_date`, `destroy_date`) VALUES
(1, '5001', '5011', '5111', 118, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(2, '5001', '5011', '5111', 58, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(3, '5001', '5011', '5111', 58, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(4, '5001', '5011', '5111', 58, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(7, '6001', '6011', '6111', 53, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(8, '6001', '6011', '6111', 53, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(10, '6001', '6011', '6111', 59, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(11, '6001', '6011', '6111', 62, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(13, '6001', '6011', '6111', 62, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(14, '6001', '6011', '6111', 112, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(15, '6001', '6011', '6111', 114, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(16, '6001', '6011', '6111', 101, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(17, '6001', '6011', '6111', 110, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(18, '6001', '6011', '6111', 84, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(19, '6001', '6011', '6111', 59, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(21, '6001', '6011', '6111', 53, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(24, '6001', '6011', '6111', 53, 'K-127865', 'for Mcb', 1, 'Container', 'In', '2024-10-07', '2034-10-07'),
(25, '6001', '6011', '6111', 108, 'K-127865', 'for Mcb', 2, 'Container', 'In', '2024-10-08', '2034-10-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barcode_select` (`barcode_select`),
  ADD KEY `rack_select` (`rack_select`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`barcode_select`) REFERENCES `box` (`box_id`),
  ADD CONSTRAINT `store_ibfk_2` FOREIGN KEY (`rack_select`) REFERENCES `racks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
