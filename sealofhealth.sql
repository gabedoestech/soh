-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 13, 2017 at 08:05 AM
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
  `price` double NOT NULL,
  `location` varchar(50) NOT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `taken` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `userID`, `price`, `location`, `app_name`, `app_date`, `start_time`, `end_time`, `taken`) VALUES
(1, 12, 20, 'Gainesville, FL 32611', 'Toenail Removal', '2017-04-20', '17:00:00', '17:30:00', 0),
(2, 12, 25, 'Orlando 32131', 'Zit Removal', '2017-04-28', '00:00:00', '01:30:00', 0),
(3, 12, 100, 'Sunrise, FL 74323', 'Laser Eye Surgery', '2017-04-18', '10:00:00', '11:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `userID` int(11) NOT NULL,
  `specialty` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`userID`, `specialty`) VALUES
(6, NULL),
(7, NULL),
(8, NULL),
(9, NULL),
(10, NULL),
(12, 'eawfawfaw');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `case_id` int(10) unsigned NOT NULL,
  `case_name` varchar(20) DEFAULT NULL,
  `text` varchar(20) DEFAULT NULL,
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
  `ethnicity` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`userID`, `birth_date`, `ethnicity`) VALUES
(1, NULL, NULL),
(2, NULL, NULL),
(3, NULL, NULL),
(4, NULL, NULL),
(5, NULL, NULL),
(11, '1986-07-17', 'Native American');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `drug_name` varchar(20) NOT NULL,
  `drug_amount` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sees`
--

CREATE TABLE IF NOT EXISTS `sees` (
  `userID_patient` int(11) NOT NULL,
  `userID_doctor` int(11) NOT NULL,
  `drug_name` varchar(20) NOT NULL,
  `appointment_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `userID` int(11) NOT NULL,
  `case_id` int(11) unsigned NOT NULL
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
  `name` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userStatus` enum('Y','N') DEFAULT NULL,
  `tokenCode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userPass`, `phone_no`, `sex`, `name`, `address`, `userEmail`, `userStatus`, `tokenCode`) VALUES
(1, 'Plawson123', '63bac83f8958ae71f7fb2b8ad892f423', NULL, NULL, NULL, NULL, 'phillylawson@gmail.com', 'Y', '506d458ccb11cf2fb3115078745f8cd3'),
(2, 'SadHoshi', '39af8eae4e0ce9eef5189ec615acdb28', NULL, NULL, NULL, NULL, 'shoshi@comcast.net', 'Y', 'f4961ae414d33b38bf2c5b7d66c09778'),
(3, 'MarinerMaria', '879c433ebb4807da4cd55a67b62b42c0', NULL, NULL, NULL, NULL, 'marmar@knights.ucf.edu', 'Y', '25b19d4cc1f43130252893c25c81ea18'),
(4, 'Governance', '275f97851b5f5eaf2799aabc36be81ef', NULL, NULL, NULL, NULL, 'groverlane@gmail.com', 'Y', '67bfb321252dd0b87aeaef17d5525d10'),
(5, 'MiaowLady', '2b31f0b0514b53937440c70bfc0ad29d', NULL, NULL, NULL, NULL, 'missmiaow@yahoo.com', 'Y', '59f0979255aeaddd4c775a3f0eefd197'),
(6, 'DrRinnebaker', '2b3720c30bee49f9507f482a56253232', NULL, NULL, NULL, NULL, 'drrplantation@gmail.com', 'Y', '58f59524794b43163ed1f86afaa6cd87'),
(7, 'ENTGuy', '4a1c488d7011f4c4bf9b152418a2f891', NULL, NULL, NULL, NULL, 'doctordoctor@yahoo.com', 'Y', '2cbec9912c31abd0951fd8df5707e30e'),
(8, 'emergencydoctor', '61ba8a6f6b00da1136e0608452251e46', NULL, NULL, NULL, NULL, 'ERemergency@gmail.com', 'Y', 'af1bc31c4c39d44e1c02d97a982bf127'),
(9, 'PatchAdams', '8beb9d2259a5c838f2ceaf69fd1a647c', NULL, NULL, NULL, NULL, 'rednoseadams@comcast.net', 'Y', '0ae64f9d8a1a510f925bfd5cafd8187a'),
(10, 'HeartRepair', '92c13ebbc6cdb02e70ebcf40dff084d1', NULL, NULL, NULL, NULL, 'lifesaver@yahoo.com', 'Y', 'a927e8cca1234c207516ae5d2062c494'),
(11, 'dshmao', 'ebcc96376289ed92e2a7563460ab057c', '432-432-5325', 'Male', 'Devin Cole', '213 huefha, lald, fl 42341', 'devmcole1991@knights.ucf.edu', 'Y', '031dcf2461b366158595a208fc7dd549'),
(12, 'Failure', 'ebcc96376289ed92e2a7563460ab057c', '432-432-5325', 'Female', 'aeeawf', '4234234dawda', 'DevinDevinC@comcast.net', 'Y', '27608b6983a6a79fb44ec3a042e6f858');

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
  ADD KEY `app_date` (`app_date`),
  ADD KEY `location` (`location`(6));

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
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`drug_name`),
  ADD KEY `drug_name` (`drug_name`(6));

--
-- Indexes for table `sees`
--
ALTER TABLE `sees`
  ADD PRIMARY KEY (`userID_patient`,`userID_doctor`,`drug_name`,`appointment_id`),
  ADD KEY `userID_doctor` (`userID_doctor`),
  ADD KEY `drug_name` (`drug_name`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`userID`,`case_id`),
  ADD KEY `uploads_ibfk_2_idx` (`case_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail_UNIQUE` (`userEmail`),
  ADD UNIQUE KEY `userName_UNIQUE` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `case_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
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
-- Constraints for table `sees`
--
ALTER TABLE `sees`
  ADD CONSTRAINT `sees_ibfk_1` FOREIGN KEY (`userID_patient`) REFERENCES `patient` (`userID`),
  ADD CONSTRAINT `sees_ibfk_2` FOREIGN KEY (`userID_doctor`) REFERENCES `doctor` (`userID`),
  ADD CONSTRAINT `sees_ibfk_3` FOREIGN KEY (`drug_name`) REFERENCES `prescription` (`drug_name`),
  ADD CONSTRAINT `sees_ibfk_4` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`) ON DELETE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `patient` (`userID`),
  ADD CONSTRAINT `uploads_ibfk_2` FOREIGN KEY (`case_id`) REFERENCES `history` (`case_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
