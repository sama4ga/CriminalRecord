-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2022 at 03:13 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `criminal_record`
--
CREATE DATABASE IF NOT EXISTS `criminal_record` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `criminal_record`;

-- --------------------------------------------------------

--
-- Table structure for table `court`
--

CREATE TABLE `court` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` tinytext NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crime`
--

CREATE TABLE `crime` (
  `id` int(11) NOT NULL,
  `statement` text NOT NULL,
  `officerId` int(11) NOT NULL,
  `date` date NOT NULL,
  `scene` tinytext NOT NULL,
  `category` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `priority` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `officer`
--

CREATE TABLE `officer` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `rank` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passport` varchar(100) NOT NULL,
  `address` tinytext NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `regNo` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `level` varchar(3) NOT NULL,
  `address` tinytext NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passport` varchar(100) NOT NULL,
  `pg` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suspect`
--

CREATE TABLE `suspect` (
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `crimeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verdict`
--

CREATE TABLE `verdict` (
  `id` int(11) NOT NULL,
  `courtId` int(11) NOT NULL,
  `crimeId` int(11) NOT NULL,
  `judge` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `witness`
--

CREATE TABLE `witness` (
  `id` int(11) NOT NULL,
  `crimeId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `statement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crime`
--
ALTER TABLE `crime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `officerId` (`officerId`);

--
-- Indexes for table `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suspect`
--
ALTER TABLE `suspect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentId` (`studentId`),
  ADD KEY `crimeId` (`crimeId`);

--
-- Indexes for table `verdict`
--
ALTER TABLE `verdict`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courtId` (`courtId`),
  ADD KEY `crimeId` (`crimeId`);

--
-- Indexes for table `witness`
--
ALTER TABLE `witness`
  ADD KEY `studentId` (`studentId`),
  ADD KEY `crimeId` (`crimeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `court`
--
ALTER TABLE `court`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crime`
--
ALTER TABLE `crime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officer`
--
ALTER TABLE `officer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suspect`
--
ALTER TABLE `suspect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verdict`
--
ALTER TABLE `verdict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crime`
--
ALTER TABLE `crime`
  ADD CONSTRAINT `crime_ibfk_1` FOREIGN KEY (`officerId`) REFERENCES `officer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suspect`
--
ALTER TABLE `suspect`
  ADD CONSTRAINT `suspect_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `suspect_ibfk_2` FOREIGN KEY (`crimeId`) REFERENCES `crime` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verdict`
--
ALTER TABLE `verdict`
  ADD CONSTRAINT `verdict_ibfk_1` FOREIGN KEY (`courtId`) REFERENCES `court` (`id`),
  ADD CONSTRAINT `verdict_ibfk_2` FOREIGN KEY (`crimeId`) REFERENCES `crime` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `witness`
--
ALTER TABLE `witness`
  ADD CONSTRAINT `witness_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `witness_ibfk_2` FOREIGN KEY (`crimeId`) REFERENCES `crime` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
