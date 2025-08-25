-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 03:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create the database
CREATE DATABASE IF NOT EXISTS `user_db`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `user_db`;
-- --------------------------------------------------------

--
-- Table structure for table `education_entries`
--

CREATE TABLE `education_entries` (
  `education_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education_entries`
--

INSERT INTO `education_entries` (`education_id`, `profile_id`, `degree`, `college`, `year`) VALUES
(20, 4, 'asfadfafsaf', 'fafasf', 5235),
(21, 4, 'fafasf', 'asfaf', 4234),
(99, 6, 'sdfs', 'df', 2345),
(123, 7, 'BS Computer Engineering', 'PUP', 1996),
(125, 3, 'engineering', 'Bulacan State University', 1990);

-- --------------------------------------------------------

--
-- Table structure for table `login_info`
--

CREATE TABLE `login_info` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_info`
--

INSERT INTO `login_info` (`id`, `email`, `password`) VALUES
(8, 'raleonlorenzoo@gmail.com', '$2y$10$NecLmL9Ypt7U5mfUtSVS8ePJpL96FzL9D0TFrbgmkmft68G36QF7S'),
(9, 'test@gmail.com', '$2y$10$azKadssKfnFkEIS30j8s5.D0MqVX0cyupeybDDonemWS4coQBNK0.'),
(10, 'Katherinebautistaa679@gmail.com', '$2y$10$tfsI0H86vqucWTGHq43S7eZWqnG9uZ/Ufu3GnwKNgu30qMkGpyFdu'),
(11, 'lorenzoleannesda@gmail.com', '$2y$10$6.p8JhDj1pWYn5dbzhf7iOLAGTtWoMN4X91aeSAiwveorJV3l8SHu'),
(12, 'demo@gmail.com', '$2y$10$8PehpMm1HkdvmqgzKdONJu0sv7U5KeCXd8e3YJVHHLHjcKyLqFylq'),
(13, 'test1234@gmail.com', '$2y$10$sxP5Tsi.9VRSRtydNu7FXuCczKpnJSZNfhN2YX3cDWVacmuIEbX1y'),
(14, 'rosalielorenzo@yahoo.com', '$2y$10$azMwshMRCJIE36vshyGvgulAE7YUWZ/DKGugefPVrftymTjeudH8W');

-- --------------------------------------------------------

--
-- Table structure for table `simulation_profiles`
--

CREATE TABLE `simulation_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` enum('male','female','other') NOT NULL,
  `country` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `occupancy` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) NOT NULL,
  `monthly_expense` decimal(10,2) NOT NULL,
  `savings` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `simulation_profiles`
--

INSERT INTO `simulation_profiles` (`profile_id`, `user_id`, `name`, `sex`, `country`, `dob`, `occupancy`, `position`, `religion`, `salary`, `monthly_expense`, `savings`, `created_at`) VALUES
(3, 8, 'Lorenzo Raleon James', 'male', 'Philippines', '1975-01-15', 'employed', 'engineer', 'Roman catholic', 60000.00, 50000.00, 1000000.00, '2025-08-07 08:51:29'),
(4, 10, 'faf', 'male', 'fasf', '2028-07-06', 'faf', 'afas', 'asf', 34234.00, 4234.00, 24234.00, '2025-08-09 07:59:44'),
(5, 11, '', '', '', '0000-00-00', '', '', '', 0.00, 0.00, 0.00, '2025-08-16 11:45:44'),
(6, 13, '234', 'female', '124', '2022-06-24', '124', 'fsdf', 'sdf', 324.00, 235.00, 2345.00, '2025-08-24 09:31:56'),
(7, 14, 'Rosalie Lorenzo', 'female', 'Philippines', '1975-01-12', 'QMR', 'engineer', 'ROMAN CATHOLIC', 65000.00, 40000.00, 300000.00, '2025-08-25 11:06:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education_entries`
--
ALTER TABLE `education_entries`
  ADD PRIMARY KEY (`education_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `login_info`
--
ALTER TABLE `login_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `simulation_profiles`
--
ALTER TABLE `simulation_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education_entries`
--
ALTER TABLE `education_entries`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `login_info`
--
ALTER TABLE `login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `simulation_profiles`
--
ALTER TABLE `simulation_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `education_entries`
--
ALTER TABLE `education_entries`
  ADD CONSTRAINT `education_entries_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `simulation_profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simulation_profiles`
--
ALTER TABLE `simulation_profiles`
  ADD CONSTRAINT `simulation_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
