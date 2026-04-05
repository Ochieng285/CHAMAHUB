-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2026 at 10:03 PM
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
-- Database: `community_growth`
--

-- --------------------------------------------------------

--
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `id` int(11) NOT NULL,
  `wallet_address` varchar(42) NOT NULL,
  `contribution_type` enum('code','content','design') NOT NULL,
  `evidence_url` varchar(255) NOT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `points_earned` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contributions`
--

INSERT INTO `contributions` (`id`, `wallet_address`, `contribution_type`, `evidence_url`, `status`, `points_earned`, `created_at`) VALUES
(1, '0x71C7656EC7ab88b098defB751B7401B5f6d8976F', 'code', 'https://github.com/community/pull/42', 'verified', 50, '2026-03-11 20:27:54'),
(2, '0x32Be343B94f860124dC4fEe278FDCBD38C102D88', 'content', 'https://mirror.xyz/post/how-to-scale', 'pending', 0, '2026-03-12 20:27:54'),
(3, '0xAb5801a7D398351b8bE11C439e05C5B3259aeC9B', 'design', 'https://figma.com/file/brand-assets', 'verified', 30, '2026-03-13 15:27:54'),
(4, '0x1234567890abcdef1234567890abcdef12345678', 'code', 'https://github.com/community/smart-contracts', 'rejected', 0, '2026-03-13 19:27:54'),
(5, '0xd8dA6BF26964aF9D7eEd9e03E53415D37aA96045', 'content', 'https://twitter.com/thread/12345', 'pending', 0, '2026-03-13 20:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `screenshot_path` varchar(255) DEFAULT NULL,
  `detected_amount` decimal(10,2) DEFAULT 0.00,
  `status` enum('pending','verified','flagged') DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `member_id`, `screenshot_path`, `detected_amount`, `status`, `payment_date`, `user_id`) VALUES
(10, 0, 'uploads/rcpt_1773438624_1.jpeg', 20.00, 'verified', '2026-03-13 21:50:24', 1),
(12, 0, 'uploads/rcpt_1773438775_1.jpeg', 20.00, 'verified', '2026-03-13 21:52:56', 1),
(13, 0, 'uploads/rcpt_1773439966_2.jpeg', 20.00, 'verified', '2026-03-13 22:12:47', 2),
(30, 0, 'uploads/rcpt_1773443939_1.jpeg', 20.00, 'verified', '2026-03-13 23:19:00', 1),
(31, 0, 'uploads/rcpt_1773445479_3.jpeg', 20.00, 'verified', '2026-03-13 23:44:40', 3),
(32, 0, 'uploads/rcpt_1773445541_3.jpeg', 50.00, 'flagged', '2026-03-13 23:45:42', 3),
(33, 0, 'uploads/rcpt_1773445811_3.jpeg', 20.00, 'verified', '2026-03-13 23:50:12', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `member_number` varchar(10) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `member_number`, `full_name`, `phone_number`, `password`, `created_at`) VALUES
(1, 'CHM-5137', 'MICHAEL OCHIENG', '0745001764', '$2y$10$LMxXyiC0JB1mrV3Ct8FQh.EF7aShKugM1S67onfoJqBdy5Mw0EeRO', '2026-03-13 21:04:06'),
(2, 'CHM-1331', 'SIMON', '0745213968', '$2y$10$prcLBcBL.xtWCE0GtA1duuMwL5mXNYZ9vP0gJXTIifuTFv1jc7VfO', '2026-03-13 21:05:26'),
(3, 'CHM-7954', 'muthungu', '0758958016', '$2y$10$ReXxO.cL/i7XhqvFUeWuve9hrb2M34ZCJvZxBTKmNz67ihOVpj95K', '2026-03-13 23:43:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_number` (`member_number`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
