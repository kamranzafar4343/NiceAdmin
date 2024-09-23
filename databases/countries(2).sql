-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2024 at 06:15 PM
-- Server version: 8.0.39-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apsystemnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` mediumint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `phonecode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(238, 'Vatican City State (Holy See)', '379'),
(239, 'Venezuela', '58'),
(240, 'Vietnam', '84'),
(241, 'Virgin Islands (British)', '+1-284'),
(242, 'Virgin Islands (US)', '+1-340'),
(243, 'Wallis And Futuna Islands', '681'),
(244, 'Western Sahara', '212'),
(245, 'Yemen', '967'),
(246, 'Zambia', '260'),
(247, 'Zimbabwe', '263'),
(248, 'Kosovo', '383'),
(249, 'Curaçao', '599'),
(250, 'Sint Maarten (Dutch part)', '1721');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
