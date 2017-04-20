-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2017 at 12:05 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sealofhealth`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `appointment_id` int(10) unsigned NOT NULL,
  `userID` int(11) NOT NULL,
  `summary` varchar(500) NOT NULL,
  `price` double NOT NULL,
  `streetAddress` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(25) NOT NULL,
  `zipcode` varchar(15) NOT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `taken` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `userID` int(11) NOT NULL,
  `specialty` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `case_id` int(10) unsigned NOT NULL,
  `case_name` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `doctor` varchar(20) NOT NULL,
  `doc_specialty` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `userID` int(11) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `ethnicity` varchar(15) DEFAULT NULL,
  `age` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prescribes`
--

CREATE TABLE IF NOT EXISTS `prescribes` (
  `userID_doctor` int(11) NOT NULL,
  `userID_patient` int(11) NOT NULL,
  `drugId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `drugId` int(11) NOT NULL,
  `drugName` varchar(100) NOT NULL,
  `instructions` varchar(500) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sees`
--

CREATE TABLE IF NOT EXISTS `sees` (
  `userID_patient` int(11) NOT NULL,
  `userID_doctor` int(11) NOT NULL,
  `appointment_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `userID_doctor` int(11) NOT NULL,
  `userID_patient` int(11) NOT NULL,
  `vitalsId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `userID` int(11) NOT NULL,
  `case_id` int(11) unsigned NOT NULL,
  `drugId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(16) DEFAULT NULL,
  `userPass` varchar(50) DEFAULT NULL,
  `phone_no` varchar(13) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userStatus` enum('Y','N') NOT NULL,
  `tokenCode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE IF NOT EXISTS `vitals` (
  `vitalsId` int(11) NOT NULL,
  `temperature` varchar(100) NOT NULL,
  `heartrate` varchar(100) NOT NULL,
  `bloodpressure` varchar(100) NOT NULL,
  `height` varchar(100) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `BMI` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `price` (`price`),
  ADD KEY `app_date` (`app_date`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `case_name` (`case_name`(6)),
  ADD KEY `date` (`date`),
  ADD KEY `location` (`location`(6));

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `prescribes`
--
ALTER TABLE `prescribes`
  ADD PRIMARY KEY (`userID_doctor`,`userID_patient`,`drugId`),
  ADD KEY `prescribes_ibfk_2` (`userID_patient`),
  ADD KEY `prescribes_ibfk_3` (`drugId`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`drugId`),
  ADD KEY `drug_name` (`drugName`(6));

--
-- Indexes for table `sees`
--
ALTER TABLE `sees`
  ADD PRIMARY KEY (`userID_patient`,`userID_doctor`,`appointment_id`),
  ADD KEY `userID_doctor` (`userID_doctor`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`userID_doctor`,`userID_patient`,`vitalsId`),
  ADD KEY `updates_ibfk_2` (`userID_patient`),
  ADD KEY `updates_ibfk_3` (`vitalsId`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`userID`,`case_id`,`drugId`),
  ADD KEY `uploads_ibfk_2_idx` (`case_id`),
  ADD KEY `uploads_ibfk_3` (`drugId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail_UNIQUE` (`userEmail`),
  ADD UNIQUE KEY `userName_UNIQUE` (`userName`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`vitalsId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `case_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `drugId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
  MODIFY `vitalsId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `doctor` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `prescribes`
--
ALTER TABLE `prescribes`
  ADD CONSTRAINT `prescribes_ibfk_1` FOREIGN KEY (`userID_doctor`) REFERENCES `doctor` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescribes_ibfk_2` FOREIGN KEY (`userID_patient`) REFERENCES `patient` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescribes_ibfk_3` FOREIGN KEY (`drugId`) REFERENCES `prescription` (`drugId`) ON DELETE CASCADE;

--
-- Constraints for table `sees`
--
ALTER TABLE `sees`
  ADD CONSTRAINT `sees_ibfk_1` FOREIGN KEY (`userID_patient`) REFERENCES `patient` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `sees_ibfk_2` FOREIGN KEY (`userID_doctor`) REFERENCES `doctor` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `sees_ibfk_3` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`) ON DELETE CASCADE;

--
-- Constraints for table `updates`
--
ALTER TABLE `updates`
  ADD CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`userID_doctor`) REFERENCES `doctor` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `updates_ibfk_2` FOREIGN KEY (`userID_patient`) REFERENCES `patient` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `updates_ibfk_3` FOREIGN KEY (`vitalsId`) REFERENCES `vitals` (`vitalsId`) ON DELETE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `patient` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploads_ibfk_2` FOREIGN KEY (`case_id`) REFERENCES `history` (`case_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `uploads_ibfk_3` FOREIGN KEY (`drugId`) REFERENCES `prescription` (`drugId`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
