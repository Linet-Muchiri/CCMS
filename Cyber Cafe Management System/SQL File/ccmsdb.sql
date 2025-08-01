-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 03:09 PM
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
-- Database: `ccmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_ids` text NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `mpesa_code` varchar(50) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `paid_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `session_ids`, `method`, `mpesa_code`, `amount_paid`, `paid_at`) VALUES
(1, 3, '[2]', 'till', 'Xttth6', 5.00, '2025-07-30 16:29:19'),
(2, 3, '[4]', 'till', 'abcd', 1.50, '2025-07-31 13:24:39'),
(3, 5, '[5]', 'till', 'As3er', 5.00, '2025-07-31 16:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rate_per_minute` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `rate_per_minute`) VALUES
(1, 'Browsing', 1.00),
(2, 'Printing', 2.00),
(3, 'Typing', 1.50),
(4, 'Scanning', 1.00),
(5, 'Passport Photos', 3.00),
(6, 'M-Pesa Services', 0.00),
(7, 'Software Installation', 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `service_usage`
--

CREATE TABLE `service_usage` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `amount_due` decimal(10,2) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_usage`
--

INSERT INTO `service_usage` (`id`, `user_id`, `service_id`, `start_time`, `end_time`, `duration_minutes`, `amount_due`, `paid`) VALUES
(1, 3, 1, '2025-07-30 14:35:43', '2025-07-30 14:43:30', 8, 8.00, 0),
(2, 3, 1, '2025-07-30 14:46:58', '2025-07-30 14:51:10', 5, 5.00, 1),
(3, 3, 5, '2025-07-30 14:53:12', '2025-07-30 14:53:25', 1, 3.00, 0),
(4, 3, 3, '2025-07-31 12:23:55', '2025-07-31 12:24:01', 1, 1.50, 1),
(5, 5, 7, '2025-07-31 15:06:55', '2025-07-31 15:07:52', 1, 5.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8979555556, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-03-30 08:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomputers`
--

CREATE TABLE `tblcomputers` (
  `ID` int(10) NOT NULL,
  `ComputerName` varchar(120) DEFAULT NULL,
  `ComputerLocation` varchar(120) DEFAULT NULL,
  `IPAdd` varchar(120) DEFAULT NULL,
  `EntryDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcomputers`
--

INSERT INTO `tblcomputers` (`ID`, `ComputerName`, `ComputerLocation`, `IPAdd`, `EntryDate`) VALUES
(1, 'Acer', 'Cabin101', '127.0.0.1', '2024-03-31 09:25:58'),
(2, 'ASUS', 'Cabin102', '127.0.0.2', '2024-03-31 09:25:58'),
(3, 'DELL', 'Cabin103', '127.0.0.2', '2024-03-31 09:25:58'),
(4, 'DELL', 'Cabin104', '127.0.0.3', '2024-03-31 09:25:58'),
(5, 'Asus Gaming Laptop', 'Cabin 10', '127.0.0.01', '2024-03-31 09:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `tblservices`
--

CREATE TABLE `tblservices` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rate_per_min` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblservices`
--

INSERT INTO `tblservices` (`id`, `name`, `rate_per_min`, `created_at`) VALUES
(1, 'Browsing', 1.5, '2025-07-30 11:52:46'),
(2, 'Printing', 5, '2025-07-30 11:52:46'),
(3, 'Typing', 2, '2025-07-30 11:52:46'),
(4, 'Scanning', 3, '2025-07-30 11:52:46'),
(5, 'Passport Photos', 20, '2025-07-30 11:52:46'),
(6, 'M-Pesa Services', 0, '2025-07-30 11:52:46'),
(7, 'Software Installation', 10, '2025-07-30 11:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblusage`
--

CREATE TABLE `tblusage` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `rate_per_min` double DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `total_minutes` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `ID` int(10) NOT NULL,
  `EntryID` varchar(20) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `UserAddress` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `ComputerName` varchar(120) DEFAULT NULL,
  `IDProof` varchar(120) DEFAULT NULL,
  `InTime` timestamp NULL DEFAULT current_timestamp(),
  `OutTime` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Fees` varchar(120) DEFAULT NULL,
  `Remark` varchar(120) DEFAULT NULL,
  `Status` varchar(20) NOT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `user_type` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`ID`, `EntryID`, `UserName`, `UserAddress`, `MobileNumber`, `Email`, `ComputerName`, `IDProof`, `InTime`, `OutTime`, `Fees`, `Remark`, `Status`, `UpdationDate`, `user_type`) VALUES
(1, '398365517', 'PM', 'B-120', 4646464646, 'pm@gmail.com', '1', 'PM1234', '2024-04-03 06:30:01', '2025-07-29 10:37:04', '20', 'Ok', 'Out', '2025-07-29 10:37:04', 'user'),
(2, '285255862', 'SD', 'g-110', 6546464646, 'sd@gmail.com', '2', 'SD2345', '2024-04-04 09:30:10', '2025-07-29 10:38:01', '50', 'NA', 'Out', '2025-07-29 10:38:01', 'user'),
(3, '305642534', 'KC', 'B-456', 7575757575, 'kc@gmail.com', '4', 'KC4567', '2024-04-10 05:44:06', '2025-07-29 10:38:56', '80', 'Ok', 'Out', '2025-07-29 10:38:56', 'user'),
(4, '634737642', 'TM', 't-788', 1234567890, 'tm@gmail.com', '1', 'TM1243', '2024-04-20 07:55:41', '2025-07-29 10:39:50', '30', 'Check out', 'Out', '2025-07-29 10:39:50', 'user'),
(5, '777476809', 'BN', 'K-890', 9798798789, 'bn@gmail.com', '1', 'BN2542', '2024-04-24 04:49:35', NULL, NULL, NULL, '', NULL, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(3, 'EM', 'em1@gmail.com', '$2y$10$LFKpeftP0CHO6RM4bmGIi.L1jw566L.QKuIYFwp1fhR0BQxz8NOPO', '2025-07-29 12:05:50'),
(4, 'KK', 'kk@gmail.com', '$2y$10$tvjcdbsc6ycZPlxCT9Wd0ubWK1tXbrJj1EKsHp9Baqv5AQYOfU3hu', '2025-07-31 13:05:15'),
(5, 'RK', 'rk@gmail.com', '$2y$10$xt6XqgxmjyZ9fEnNftmfLedzZn97J.9VBvVMVdCId2KMPonOpCKgu', '2025-07-31 13:06:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_usage`
--
ALTER TABLE `service_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcomputers`
--
ALTER TABLE `tblcomputers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblservices`
--
ALTER TABLE `tblservices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusage`
--
ALTER TABLE `tblusage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_usage`
--
ALTER TABLE `service_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcomputers`
--
ALTER TABLE `tblcomputers`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblservices`
--
ALTER TABLE `tblservices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblusage`
--
ALTER TABLE `tblusage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_usage`
--
ALTER TABLE `service_usage`
  ADD CONSTRAINT `service_usage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_usage_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
