-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2025 at 03:00 PM
-- Server version: 8.0.44-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websyslab8`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `crn` int NOT NULL,
  `prefix` varchar(4) COLLATE utf8mb3_unicode_ci NOT NULL,
  `number` smallint NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `section` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`crn`, `prefix`, `number`, `title`, `section`, `year`) VALUES
(36053, 'Algo', 2300, 'Introduction To Algorithms ', '6', 2026),
(37367, 'PSof', 2600, 'Principles Of Software ', '2', 2026),
(37564, 'HCI', 2210, 'Introduction To Hci', '1', 2026),
(38945, 'AQC', 4960, 'Applied Quantum Computing', '1', 2026);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int NOT NULL,
  `crn` int NOT NULL,
  `rin` int NOT NULL,
  `grade` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `crn`, `rin`, `grade`) VALUES
(1, 37367, 662073456, 85),
(2, 36053, 662072345, 90),
(3, 37367, 662071234, 78),
(4, 37564, 662074567, 88),
(5, 38945, 662071234, 92),
(6, 36053, 662073456, 81),
(7, 37564, 662072345, 75),
(8, 38945, 662073456, 89),
(9, 36053, 662074567, 94),
(10, 37367, 662074567, 87);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `rin` int NOT NULL,
  `rcsID` char(7) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` bigint DEFAULT NULL,
  `street` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `city` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `state` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `zip` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`rin`, `rcsID`, `first_name`, `last_name`, `alias`, `phone`, `street`, `city`, `state`, `zip`) VALUES
(662071234, 'bbitd01', 'Ben', 'Bitdiddle', 'bbitd', 1234567890, '123 Elm St', 'Troy', 'NY', '12180'),
(662072345, 'tmjun01', 'Thilanka', 'mango', 'thilm', 2345678901, '456 Oak Ave', 'Troy', 'NY', '12180'),
(662073456, 'nhuan01', 'Juniper', 'Huang', 'jhuan', 3456789012, '789 Pine Rd', 'Troy', 'NY', '12180'),
(662074567, 'ndang01', 'Nathan', 'Dang', 'ndang', 4567890123, '101 Maple Ln', 'Troy', 'NY', '12180');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`crn`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crn` (`crn`),
  ADD KEY `rin` (`rin`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`rin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`crn`) REFERENCES `courses` (`crn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`rin`) REFERENCES `students` (`rin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
