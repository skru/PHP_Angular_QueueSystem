-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2020 at 10:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tickets`
--

-- --------------------------------------------------------

--
-- Table structure for table `payload`
--

CREATE TABLE `payload` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `ticketId` int(11) NOT NULL,
  `signature` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payload`
--

INSERT INTO `payload` (`id`, `text`, `ticketId`, `signature`) VALUES
(165, 'i dunnoi?', 480, 'KIOSK'),
(166, 'another one', 480, 'KIOSK'),
(167, 'my payload', 480, 'TELLER'),
(168, 'dsad', 487, 'KIOSK'),
(169, 'dasd', 488, 'KIOSK'),
(170, 'sdd', 488, 'KIOSK'),
(171, 'sdd', 488, 'KIOSK'),
(172, 'asdas', 489, 'KIOSK'),
(173, 'sADS', 490, 'KIOSK'),
(174, 'ds', 491, 'KIOSK'),
(175, 'sddds', 493, 'KIOSK'),
(176, 'ui089', 494, 'KIOSK'),
(177, 'op[', 510, 'KIOSK'),
(178, 'fwdrsdfg', 511, 'KIOSK'),
(179, 'a', 512, 'KIOSK'),
(180, 'dsda', 513, 'KIOSK'),
(181, 'ss', 514, 'KIOSK'),
(182, 'asas', 515, 'KIOSK'),
(183, 'sass', 515, 'KIOSK'),
(184, '123', 516, 'KIOSK'),
(185, 'fdsf', 517, 'KIOSK'),
(186, 'fsf', 517, 'KIOSK'),
(187, 'casc', 518, 'KIOSK'),
(188, 'ghfdyg', 518, 'KIOSK'),
(189, 'mnj', 519, 'KIOSK'),
(190, 'dssd', 519, 'KIOSK'),
(191, 'sdad', 490, 'TELLER'),
(192, 'sdaddasd', 490, 'TELLER'),
(193, '1234567', 521, 'KIOSK'),
(194, '90', 491, 'TELLER'),
(195, 'asd', 522, 'KIOSK'),
(196, 'ded', 492, 'TELLER'),
(197, 'hjkhjkl', 523, 'KIOSK'),
(198, 'dedbjk', 507, 'TELLER');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `issuedTime` datetime NOT NULL DEFAULT current_timestamp(),
  `tokenNumber` varchar(5) NOT NULL,
  `called` tinyint(1) NOT NULL,
  `servedTime` datetime NOT NULL,
  `served` tinyint(1) NOT NULL,
  `noShow` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `issuedTime`, `tokenNumber`, `called`, `servedTime`, `served`, `noShow`) VALUES
(469, '2020-05-25 14:38:39', 'A000', 1, '2020-05-25 14:38:55', 1, 0),
(470, '2020-05-25 14:49:00', 'A001', 1, '2020-05-25 14:50:34', 1, 0),
(471, '2020-05-25 15:06:08', 'A002', 1, '2020-05-25 15:06:38', 1, 0),
(472, '2020-05-25 15:06:14', 'A003', 1, '2020-05-25 15:07:05', 1, 0),
(473, '2020-05-25 15:06:20', 'A004', 1, '2020-05-25 15:07:21', 1, 0),
(474, '2020-05-25 15:07:23', 'A005', 1, '2020-05-25 15:07:28', 1, 0),
(475, '2020-05-25 15:07:38', 'A006', 1, '2020-05-25 15:07:51', 1, 0),
(476, '2020-05-25 15:08:25', 'A007', 1, '2020-05-25 15:24:32', 1, 0),
(477, '2020-05-25 16:04:16', 'A008', 1, '2020-05-25 16:04:25', 1, 0),
(478, '2020-05-25 16:05:18', 'A009', 1, '2020-05-25 16:05:44', 1, 1),
(479, '2020-05-25 16:07:07', 'A010', 1, '2020-05-25 16:10:19', 1, 0),
(480, '2020-05-25 16:13:39', 'A011', 1, '2020-05-25 16:14:29', 1, 1),
(481, '2020-05-25 16:46:11', 'A012', 1, '2020-05-25 16:46:21', 1, 0),
(482, '2020-05-25 16:55:55', 'A013', 1, '2020-05-25 16:56:02', 1, 0),
(483, '2020-05-25 17:06:21', 'A014', 1, '0000-00-00 00:00:00', 0, 1),
(484, '2020-05-25 17:42:35', 'A015', 1, '0000-00-00 00:00:00', 0, 1),
(485, '2020-05-25 17:47:36', 'A016', 1, '2020-05-25 17:49:46', 1, 0),
(486, '2020-05-25 17:48:36', 'A017', 0, '0000-00-00 00:00:00', 0, 1),
(487, '2020-05-25 18:38:11', 'A018', 0, '2020-05-25 18:48:31', 1, 0),
(488, '2020-05-25 18:40:39', 'A019', 0, '0000-00-00 00:00:00', 0, 1),
(489, '2020-05-25 18:41:45', 'A020', 0, '2020-05-25 18:52:24', 1, 0),
(490, '2020-05-25 18:42:20', 'A021', 0, '2020-05-25 19:08:06', 1, 0),
(491, '2020-05-25 18:43:19', 'A022', 0, '2020-05-25 19:09:32', 1, 0),
(492, '2020-05-25 18:44:32', 'A023', 0, '2020-05-25 19:15:47', 1, 0),
(493, '2020-05-25 18:44:58', 'A024', 1, '2020-05-25 19:16:08', 1, 0),
(494, '2020-05-25 18:45:45', 'A025', 1, '2020-05-25 19:16:09', 1, 0),
(495, '2020-05-25 18:46:24', 'A026', 1, '0000-00-00 00:00:00', 0, 1),
(496, '2020-05-25 18:47:19', 'A027', 1, '2020-05-25 18:47:32', 1, 0),
(497, '2020-05-25 18:47:38', 'A028', 1, '0000-00-00 00:00:00', 0, 0),
(498, '2020-05-25 18:48:00', 'A029', 1, '0000-00-00 00:00:00', 0, 0),
(499, '2020-05-25 18:49:14', 'A030', 1, '0000-00-00 00:00:00', 0, 0),
(500, '2020-05-25 18:52:31', 'A031', 1, '0000-00-00 00:00:00', 0, 0),
(501, '2020-05-25 18:53:13', 'A032', 0, '2020-05-25 19:16:11', 1, 0),
(502, '2020-05-25 18:54:23', 'A033', 1, '2020-05-25 19:16:13', 1, 0),
(503, '2020-05-25 18:56:26', 'A034', 1, '2020-05-25 19:16:15', 1, 0),
(504, '2020-05-25 18:56:44', 'A035', 1, '0000-00-00 00:00:00', 0, 0),
(505, '2020-05-25 18:57:03', 'A036', 0, '2020-05-25 19:16:16', 1, 0),
(506, '2020-05-25 18:57:43', 'A037', 1, '2020-05-25 19:16:18', 1, 0),
(507, '2020-05-25 18:57:58', 'A038', 0, '2020-05-25 19:16:34', 1, 0),
(508, '2020-05-25 18:59:01', 'A039', 1, '2020-05-26 08:56:33', 1, 0),
(509, '2020-05-25 18:59:57', 'A040', 1, '2020-05-26 09:05:14', 1, 0),
(510, '2020-05-25 19:00:54', 'A041', 1, '2020-05-26 09:05:15', 1, 0),
(511, '2020-05-25 19:01:06', 'A042', 1, '0000-00-00 00:00:00', 0, 1),
(512, '2020-05-25 19:01:39', 'A043', 1, '2020-05-26 09:05:18', 1, 0),
(513, '2020-05-25 19:02:37', 'A044', 1, '0000-00-00 00:00:00', 0, 1),
(514, '2020-05-25 19:03:14', 'A045', 1, '2020-05-26 09:05:20', 1, 0),
(515, '2020-05-25 19:03:36', 'A046', 1, '2020-05-26 09:05:22', 1, 0),
(516, '2020-05-25 19:04:19', 'A047', 1, '2020-05-26 09:05:23', 1, 0),
(517, '2020-05-25 19:04:48', 'A048', 1, '0000-00-00 00:00:00', 0, 0),
(518, '2020-05-25 19:05:45', 'A049', 0, '2020-05-26 09:05:24', 1, 0),
(519, '2020-05-25 19:07:02', 'A050', 1, '0000-00-00 00:00:00', 0, 0),
(520, '2020-05-25 19:07:37', 'A051', 1, '0000-00-00 00:00:00', 0, 0),
(521, '2020-05-25 19:08:04', 'A052', 1, '0000-00-00 00:00:00', 0, 0),
(522, '2020-05-25 19:09:30', 'A053', 1, '0000-00-00 00:00:00', 0, 0),
(523, '2020-05-25 19:16:22', 'A054', 1, '0000-00-00 00:00:00', 0, 0),
(524, '2020-05-26 08:56:00', 'A055', 1, '2020-05-26 09:05:26', 1, 0),
(525, '2020-05-26 09:19:34', 'A056', 0, '0000-00-00 00:00:00', 0, 0),
(526, '2020-05-26 09:19:51', 'A057', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `ticketId` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `ticketId`, `time`) VALUES
(148, 469, '2020-05-25 14:38:55'),
(149, 470, '2020-05-25 14:50:34'),
(150, 471, '2020-05-25 15:06:38'),
(151, 472, '2020-05-25 15:07:05'),
(152, 473, '2020-05-25 15:07:21'),
(153, 474, '2020-05-25 15:07:28'),
(154, 475, '2020-05-25 15:07:51'),
(155, 476, '2020-05-25 15:24:32'),
(156, 477, '2020-05-25 16:04:25'),
(157, 478, '2020-05-25 16:05:44'),
(158, 479, '2020-05-25 16:10:19'),
(159, 480, '2020-05-25 16:14:29'),
(160, 481, '2020-05-25 16:46:21'),
(161, 481, '2020-05-25 16:46:21'),
(162, 481, '2020-05-25 16:46:21'),
(163, 482, '2020-05-25 16:56:02'),
(164, 485, '2020-05-25 17:49:46'),
(165, 496, '2020-05-25 18:47:32'),
(166, 487, '2020-05-25 18:48:31'),
(167, 489, '2020-05-25 18:52:24'),
(168, 490, '2020-05-25 19:08:06'),
(169, 491, '2020-05-25 19:09:32'),
(170, 492, '2020-05-25 19:15:47'),
(171, 493, '2020-05-25 19:16:08'),
(172, 494, '2020-05-25 19:16:09'),
(173, 501, '2020-05-25 19:16:11'),
(174, 502, '2020-05-25 19:16:13'),
(175, 503, '2020-05-25 19:16:15'),
(176, 505, '2020-05-25 19:16:16'),
(177, 506, '2020-05-25 19:16:18'),
(178, 507, '2020-05-25 19:16:34'),
(179, 508, '2020-05-26 08:56:34'),
(180, 509, '2020-05-26 09:05:14'),
(181, 510, '2020-05-26 09:05:15'),
(182, 512, '2020-05-26 09:05:18'),
(183, 514, '2020-05-26 09:05:20'),
(184, 515, '2020-05-26 09:05:22'),
(185, 516, '2020-05-26 09:05:23'),
(186, 518, '2020-05-26 09:05:24'),
(187, 524, '2020-05-26 09:05:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payload`
--
ALTER TABLE `payload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticketId`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticketId` (`ticketId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payload`
--
ALTER TABLE `payload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=527;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payload`
--
ALTER TABLE `payload`
  ADD CONSTRAINT `payload_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `ticket` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `ticket` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
