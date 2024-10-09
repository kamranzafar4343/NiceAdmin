-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 10:32 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `compani`
--

CREATE TABLE `compani` (
  `acc_lev_1` int(255) NOT NULL,
  `acc_lev_2` int(255) NOT NULL,
  `acc_lev_3` int(255) NOT NULL,
  `comp_id` int(255) NOT NULL,
  `acc_desc` text NOT NULL,
  `email` text DEFAULT NULL,
  `registration` date NOT NULL,
  `expiry` date NOT NULL,
  `foc` text NOT NULL,
  `foc_phone` text NOT NULL,
  `add_1` text NOT NULL,
  `add_2` text NOT NULL,
  `add_3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compani`
--

INSERT INTO `compani` (`acc_lev_1`, `acc_lev_2`, `acc_lev_3`, `comp_id`, `acc_desc`, `email`, `registration`, `expiry`, `foc`, `foc_phone`, `add_1`, `add_2`, `add_3`) VALUES
(6010, 6111, 0, 99, 'Operations Branch - 05130', NULL, '2024-10-09', '2025-10-09', 'Mr. Muhammad Rizwan', '041 - 262 1431', 'Regency Arcade', 'The Mall', 'Faislabad'),
(1320, 1321, 0, 110, 'Supplies department - 098093', NULL, '2024-10-09', '2025-10-09', 'Anshuman', '099809802', '12 abqari plaza ', 'qartaba chowk, Lahore Kasur Road', 'Lahore'),
(1320, 1321, 13210, 112, 'HR Department 1321 - 0', NULL, '2024-10-09', '2025-10-09', 'Muhammad Ashir', '03180909112', 'H#123, St. #12', 'Main Anakali Bazar', 'Lahore');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compani`
--
ALTER TABLE `compani`
  ADD PRIMARY KEY (`comp_id`),
  ADD UNIQUE KEY `comp_name` (`acc_desc`,`email`) USING HASH,
  ADD KEY `email` (`email`(768)),
  ADD KEY `email_2` (`email`(768));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compani`
--
ALTER TABLE `compani`
  MODIFY `comp_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
