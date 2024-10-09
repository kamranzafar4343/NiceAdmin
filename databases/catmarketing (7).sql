-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 11:18 AM
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
-- Table structure for table `barcode`
--

CREATE TABLE `barcode` (
  `comp_id` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `receive_date` text NOT NULL,
  `sender` text NOT NULL,
  `receive_via` text NOT NULL,
  `barcode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barcode`
--

INSERT INTO `barcode` (`comp_id`, `branch`, `receive_date`, `sender`, `receive_via`, `barcode`) VALUES
(0, 0, '', '', '', ''),
(0, 0, '', '', '', ''),
(0, 0, '', '', '', ''),
(0, 0, '', '', '', ''),
(0, 0, '', '', '', ''),
(0, 0, '', '', '', ''),
(0, 0, '', '', '', ''),
(0, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `box`
--

CREATE TABLE `box` (
  `box_id` int(200) NOT NULL,
  `branchID_FK` int(100) NOT NULL,
  `companiID_FK` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(25) NOT NULL,
  `rec_date` varchar(100) NOT NULL,
  `sender` text NOT NULL,
  `rec_via` text NOT NULL,
  `barcode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `account_level_no` int(255) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `compID_FK` int(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `ContactPersonName` varchar(100) DEFAULT NULL,
  `ContactPersonResignation` varchar(50) DEFAULT NULL,
  `ContactPersonPhone` text DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` text DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `Status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `phonecode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `phonecode`) VALUES
(1, 'Afghanistan', '93'),
(2, 'Aland Islands', '+358-18'),
(3, 'Albania', '355'),
(4, 'Algeria', '213'),
(5, 'American Samoa', '+1-684'),
(6, 'Andorra', '376'),
(7, 'Angola', '244'),
(8, 'Anguilla', '+1-264'),
(9, 'Antarctica', '672'),
(10, 'Antigua And Barbuda', '+1-268'),
(11, 'Argentina', '54'),
(12, 'Armenia', '374'),
(13, 'Aruba', '297'),
(14, 'Australia', '61'),
(15, 'Austria', '43'),
(16, 'Azerbaijan', '994'),
(17, 'The Bahamas', '+1-242'),
(18, 'Bahrain', '973'),
(19, 'Bangladesh', '880'),
(20, 'Barbados', '+1-246'),
(21, 'Belarus', '375'),
(22, 'Belgium', '32'),
(23, 'Belize', '501'),
(24, 'Benin', '229'),
(25, 'Bermuda', '+1-441'),
(26, 'Bhutan', '975'),
(27, 'Bolivia', '591'),
(28, 'Bosnia and Herzegovina', '387'),
(29, 'Botswana', '267'),
(30, 'Bouvet Island', '0055'),
(31, 'Brazil', '55'),
(32, 'British Indian Ocean Territory', '246'),
(33, 'Brunei', '673'),
(34, 'Bulgaria', '359'),
(35, 'Burkina Faso', '226'),
(36, 'Burundi', '257'),
(37, 'Cambodia', '855'),
(38, 'Cameroon', '237'),
(39, 'Canada', '1'),
(40, 'Cape Verde', '238'),
(41, 'Cayman Islands', '+1-345'),
(42, 'Central African Republic', '236'),
(43, 'Chad', '235'),
(44, 'Chile', '56'),
(45, 'China', '86'),
(46, 'Christmas Island', '61'),
(47, 'Cocos (Keeling) Islands', '61'),
(48, 'Colombia', '57'),
(49, 'Comoros', '269'),
(50, 'Congo', '242'),
(51, 'Democratic Republic of the Congo', '243'),
(52, 'Cook Islands', '682'),
(53, 'Costa Rica', '506'),
(54, 'Cote D\'Ivoire (Ivory Coast)', '225'),
(55, 'Croatia', '385'),
(56, 'Cuba', '53'),
(57, 'Cyprus', '357'),
(58, 'Czech Republic', '420'),
(59, 'Denmark', '45'),
(60, 'Djibouti', '253'),
(61, 'Dominica', '+1-767'),
(62, 'Dominican Republic', '+1-809 and 1-829'),
(63, 'East Timor', '670'),
(64, 'Ecuador', '593'),
(65, 'Egypt', '20'),
(66, 'El Salvador', '503'),
(67, 'Equatorial Guinea', '240'),
(68, 'Eritrea', '291'),
(69, 'Estonia', '372'),
(70, 'Ethiopia', '251'),
(71, 'Falkland Islands', '500'),
(72, 'Faroe Islands', '298'),
(73, 'Fiji Islands', '679'),
(74, 'Finland', '358'),
(75, 'France', '33'),
(76, 'French Guiana', '594'),
(77, 'French Polynesia', '689'),
(78, 'French Southern Territories', '262'),
(79, 'Gabon', '241'),
(80, 'Gambia The', '220'),
(81, 'Georgia', '995'),
(82, 'Germany', '49'),
(83, 'Ghana', '233'),
(84, 'Gibraltar', '350'),
(85, 'Greece', '30'),
(86, 'Greenland', '299'),
(87, 'Grenada', '+1-473'),
(88, 'Guadeloupe', '590'),
(89, 'Guam', '+1-671'),
(90, 'Guatemala', '502'),
(91, 'Guernsey and Alderney', '+44-1481'),
(92, 'Guinea', '224'),
(93, 'Guinea-Bissau', '245'),
(94, 'Guyana', '592'),
(95, 'Haiti', '509'),
(96, 'Heard Island and McDonald Islands', '672'),
(97, 'Honduras', '504'),
(98, 'Hong Kong S.A.R.', '852'),
(99, 'Hungary', '36'),
(100, 'Iceland', '354'),
(101, 'India', '91'),
(102, 'Indonesia', '62'),
(103, 'Iran', '98'),
(104, 'Iraq', '964'),
(105, 'Ireland', '353'),
(106, 'Israel', '972'),
(107, 'Italy', '39'),
(108, 'Jamaica', '+1-876'),
(109, 'Japan', '81'),
(110, 'Jersey', '+44-1534'),
(111, 'Jordan', '962'),
(112, 'Kazakhstan', '7'),
(113, 'Kenya', '254'),
(114, 'Kiribati', '686'),
(115, 'North Korea', '850'),
(116, 'South Korea', '82'),
(117, 'Kuwait', '965'),
(118, 'Kyrgyzstan', '996'),
(119, 'Laos', '856'),
(120, 'Latvia', '371'),
(121, 'Lebanon', '961'),
(122, 'Lesotho', '266'),
(123, 'Liberia', '231'),
(124, 'Libya', '218'),
(125, 'Liechtenstein', '423'),
(126, 'Lithuania', '370'),
(127, 'Luxembourg', '352'),
(128, 'Macau S.A.R.', '853'),
(129, 'North Macedonia', '389'),
(130, 'Madagascar', '261'),
(131, 'Malawi', '265'),
(132, 'Malaysia', '60'),
(133, 'Maldives', '960'),
(134, 'Mali', '223'),
(135, 'Malta', '356'),
(136, 'Man (Isle of)', '+44-1624'),
(137, 'Marshall Islands', '692'),
(138, 'Martinique', '596'),
(139, 'Mauritania', '222'),
(140, 'Mauritius', '230'),
(141, 'Mayotte', '262'),
(142, 'Mexico', '52'),
(143, 'Micronesia', '691'),
(144, 'Moldova', '373'),
(145, 'Monaco', '377'),
(146, 'Mongolia', '976'),
(147, 'Montenegro', '382'),
(148, 'Montserrat', '+1-664'),
(149, 'Morocco', '212'),
(150, 'Mozambique', '258'),
(151, 'Myanmar', '95'),
(152, 'Namibia', '264'),
(153, 'Nauru', '674'),
(154, 'Nepal', '977'),
(155, 'Bonaire, Sint Eustatius and Saba', '599'),
(156, 'Netherlands', '31'),
(157, 'New Caledonia', '687'),
(158, 'New Zealand', '64'),
(159, 'Nicaragua', '505'),
(160, 'Niger', '227'),
(161, 'Nigeria', '234'),
(162, 'Niue', '683'),
(163, 'Norfolk Island', '672'),
(164, 'Northern Mariana Islands', '+1-670'),
(165, 'Norway', '47'),
(166, 'Oman', '968'),
(167, 'Pakistan', '92'),
(168, 'Palau', '680'),
(169, 'Palestinian Territory Occupied', '970'),
(170, 'Panama', '507'),
(171, 'Papua new Guinea', '675'),
(172, 'Paraguay', '595'),
(173, 'Peru', '51'),
(174, 'Philippines', '63'),
(175, 'Pitcairn Island', '870'),
(176, 'Poland', '48'),
(177, 'Portugal', '351'),
(178, 'Puerto Rico', '+1-787 and 1-939'),
(179, 'Qatar', '974'),
(180, 'Reunion', '262'),
(181, 'Romania', '40'),
(182, 'Russia', '7'),
(183, 'Rwanda', '250'),
(184, 'Saint Helena', '290'),
(185, 'Saint Kitts And Nevis', '+1-869'),
(186, 'Saint Lucia', '+1-758'),
(187, 'Saint Pierre and Miquelon', '508'),
(188, 'Saint Vincent And The Grenadines', '+1-784'),
(189, 'Saint-Barthelemy', '590'),
(190, 'Saint-Martin (French part)', '590'),
(191, 'Samoa', '685'),
(192, 'San Marino', '378'),
(193, 'Sao Tome and Principe', '239'),
(194, 'Saudi Arabia', '966'),
(195, 'Senegal', '221'),
(196, 'Serbia', '381'),
(197, 'Seychelles', '248'),
(198, 'Sierra Leone', '232'),
(199, 'Singapore', '65'),
(200, 'Slovakia', '421'),
(201, 'Slovenia', '386'),
(202, 'Solomon Islands', '677'),
(203, 'Somalia', '252'),
(204, 'South Africa', '27'),
(205, 'South Georgia', '500'),
(206, 'South Sudan', '211'),
(207, 'Spain', '34'),
(208, 'Sri Lanka', '94'),
(209, 'Sudan', '249'),
(210, 'Suriname', '597'),
(211, 'Svalbard And Jan Mayen Islands', '47'),
(212, 'Swaziland', '268'),
(213, 'Sweden', '46'),
(214, 'Switzerland', '41'),
(215, 'Syria', '963'),
(216, 'Taiwan', '886'),
(217, 'Tajikistan', '992'),
(218, 'Tanzania', '255'),
(219, 'Thailand', '66'),
(220, 'Togo', '228'),
(221, 'Tokelau', '690'),
(222, 'Tonga', '676'),
(223, 'Trinidad And Tobago', '+1-868'),
(224, 'Tunisia', '216'),
(225, 'Turkey', '90'),
(226, 'Turkmenistan', '993'),
(227, 'Turks And Caicos Islands', '+1-649'),
(228, 'Tuvalu', '688'),
(229, 'Uganda', '256'),
(230, 'Ukraine', '380'),
(231, 'United Arab Emirates', '971'),
(232, 'United Kingdom', '44'),
(233, 'United States', '1'),
(234, 'United States Minor Outlying Islands', '1'),
(235, 'Uruguay', '598'),
(236, 'Uzbekistan', '998'),
(237, 'Vanuatu', '678'),
(238, 'Vatican City State (Holy See)', '39'),
(239, 'Venezuela', '58'),
(240, 'Vietnam', '84'),
(241, 'Virgin Islands (British)', '+1-284'),
(242, 'Virgin Islands (US)', '+1-340'),
(243, 'Wallis And Futuna Islands', '681'),
(244, 'Western Sahara', '212'),
(245, 'Yemen', '967'),
(246, 'Zambia', '260'),
(247, 'Zimbabwe', '263'),
(248, 'Montenegro', '382'),
(249, 'Serbia', '381'),
(250, 'Aland Islands', '358');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_orders`
--

CREATE TABLE `delivery_orders` (
  `delivery_order_no` int(100) NOT NULL,
  `delivery_order_id` int(255) NOT NULL,
  `company` int(255) NOT NULL,
  `branch` int(11) NOT NULL,
  `box` int(11) NOT NULL,
  `item` text NOT NULL,
  `name` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_orders`
--

INSERT INTO `delivery_orders` (`delivery_order_no`, `delivery_order_id`, `company`, `branch`, `box`, `item`, `name`, `date`) VALUES
(0, 12, 91, 136, 73, '24324342', 'Zafarewer', '2024-09-01T12:59'),
(0, 17, 91, 136, 73, '24324342', 'Ali sherali', '2024-09-18T14:14'),
(0, 18, 91, 136, 74, '31123213', 'zaman watto', '2024-09-24T21:42'),
(0, 19, 91, 136, 73, '24324342', 'Zafarewer', '2024-09-01T12:59'),
(0, 20, 92, 137, 58, '31323', 'zaid haris', '2024-09-09T11:57'),
(0, 21, 0, 0, 0, '', '', ''),
(0, 22, 92, 137, 58, '', 'zaid haris', '2024-09-13T12:04'),
(0, 23, 92, 137, 58, '6757675', 'zaid haris', '2024-09-12T12:14'),
(0, 24, 0, 0, 0, '', '', ''),
(0, 25, 92, 137, 58, '', 'zaid haris', '2024-09-12T12:20'),
(0, 26, 92, 137, 58, '3243242', 'Zaid haris', '2024-09-18T12:31'),
(0, 27, 0, 0, 0, '', '', ''),
(0, 28, 92, 137, 81, '', 'zaid haris', '2024-09-10T13:44'),
(0, 29, 0, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(100) NOT NULL,
  `comp_FK_emp` int(255) NOT NULL,
  `branch_FK_emp` int(100) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` text NOT NULL,
  `gender` text NOT NULL,
  `Address` text DEFAULT NULL,
  `Authority` text NOT NULL,
  `auth_status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_name` varchar(200) NOT NULL,
  `item_id` int(100) NOT NULL,
  `box_FK_item` int(100) NOT NULL,
  `branch_FK_item` int(100) NOT NULL,
  `comp_FK_item` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `barcode` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_no` int(100) NOT NULL,
  `order_id` int(255) NOT NULL,
  `company` int(255) NOT NULL,
  `branch` int(11) NOT NULL,
  `box` int(11) NOT NULL,
  `item` text NOT NULL,
  `name` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `racks`
--

CREATE TABLE `racks` (
  `id` int(11) NOT NULL,
  `rack_location` varchar(255) NOT NULL,
  `rack_description` varchar(255) NOT NULL,
  `object_code` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 9,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `racks`
--

INSERT INTO `racks` (`id`, `rack_location`, `rack_description`, `object_code`, `capacity`, `created_at`) VALUES
(1, 'L1-A-02-D-06', 'Old Hall ', 'Container', 9, '2024-10-07 01:23:54'),
(2, 'L2-H-01-A-03', 'New hall', 'Container', 9, '2024-10-07 01:57:37'),
(3, 'L2-H-01-A-05', 'New hall', 'FileFolder', 9, '2024-10-07 02:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `password`, `role`) VALUES
(3, 'ali', 'a@gmail.com', 'abcdef', 'user'),
(21, 'unique user', 'uniqueuser843@gmail.com', 'godrinkacupoftea', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`Name`) VALUES
('kamran\r\n'),
('zoya\r\n'),
('shamsa\r\n'),
('anaya\r\n'),
('sania\r\n'),
('kamran\r\n'),
('zoya\r\n'),
('shamsa\r\n'),
('anaya\r\n'),
('sania\r\n');

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
-- Indexes for table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`box_id`),
  ADD KEY `branch FK` (`branchID_FK`),
  ADD KEY `company FK` (`companiID_FK`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `comp_ID_FK` (`compID_FK`),
  ADD KEY `account_level_no` (`account_level_no`);

--
-- Indexes for table `compani`
--
ALTER TABLE `compani`
  ADD PRIMARY KEY (`comp_id`),
  ADD UNIQUE KEY `comp_name` (`acc_desc`,`email`) USING HASH,
  ADD KEY `email` (`email`(768)),
  ADD KEY `email_2` (`email`(768));

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  ADD PRIMARY KEY (`delivery_order_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `employee_ibfk_1` (`branch_FK_emp`),
  ADD KEY `comp_FK_emp` (`comp_FK_emp`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `box_FK_item` (`box_FK_item`),
  ADD KEY `comp_FK_item` (`comp_FK_item`),
  ADD KEY `branch_FK_item` (`branch_FK_item`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_no` (`order_no`),
  ADD KEY `orders_ibfk_1` (`company`),
  ADD KEY `orders_ibfk_2` (`branch`),
  ADD KEY `box` (`box`);

--
-- Indexes for table `racks`
--
ALTER TABLE `racks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `box`
--
ALTER TABLE `box`
  MODIFY `box_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `compani`
--
ALTER TABLE `compani`
  MODIFY `comp_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  MODIFY `delivery_order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `racks`
--
ALTER TABLE `racks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `box`
--
ALTER TABLE `box`
  ADD CONSTRAINT `company FK` FOREIGN KEY (`companiID_FK`) REFERENCES `compani` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`compID_FK`) REFERENCES `compani` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`branch_FK_emp`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`comp_FK_emp`) REFERENCES `compani` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`box_FK_item`) REFERENCES `box` (`box_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`comp_FK_item`) REFERENCES `compani` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_3` FOREIGN KEY (`branch_FK_item`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`company`) REFERENCES `compani` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`box`) REFERENCES `box` (`box_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
