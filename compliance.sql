-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2014 at 04:07 AM
-- Server version: 5.6.22
-- PHP Version: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `compliance`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL,
  `COMPANY` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `COMPANY`) VALUES
(1, 'Company1'),
(2, 'Company2'),
(3, 'Company3');

-- --------------------------------------------------------

--
-- Table structure for table `lawdocfreq`
--

CREATE TABLE IF NOT EXISTS `lawdocfreq` (
  `id` int(11) NOT NULL,
  `period` varchar(100) DEFAULT 'When Required',
  `duedate` date DEFAULT NULL,
  `duedatedesc` varchar(100) DEFAULT NULL,
  `LAWDOCUMENT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lawdocuments`
--

CREATE TABLE IF NOT EXISTS `lawdocuments` (
  `id` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `LAW_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lawdocuments`
--

INSERT INTO `lawdocuments` (`id`, `NAME`, `DESCRIPTION`, `LAW_ID`) VALUES
(1, 'Registration Certificate', 'Registration Certificate', 1),
(2, 'Annual Return in Form XXV', 'Annual Return in Form XXV', 1),
(3, 'Form VI-B (Commencement & Completion)', 'Form VI-B (Commencement & Completion)', 1),
(4, 'Contractors'' Ammendment', 'Contractors'' Ammendment', 1),
(5, 'Notice Reply', 'Notice Reply', 1),
(6, 'Register in Form XII', 'Register in Form XII', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operations`
--

CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(11) NOT NULL,
  `OPERATION` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operations`
--

INSERT INTO `operations` (`id`, `OPERATION`) VALUES
(1, 'CAN_CREATE_COMPANY'),
(13, 'CAN_CREATE_REPORT'),
(5, 'CAN_CREATE_UNIT'),
(9, 'CAN_CREATE_USER'),
(2, 'CAN_DELETE_COMPANY'),
(14, 'CAN_DELETE_REPORT'),
(6, 'CAN_DELETE_UNIT'),
(10, 'CAN_DELETE_USER'),
(3, 'CAN_UPDATE_COMPANY'),
(15, 'CAN_UPDATE_REPORT'),
(7, 'CAN_UPDATE_UNIT'),
(11, 'CAN_UPDATE_USER'),
(4, 'CAN_VIEW_COMPANY'),
(16, 'CAN_VIEW_REPORT'),
(8, 'CAN_VIEW_UNIT'),
(12, 'CAN_VIEW_USER');

-- --------------------------------------------------------

--
-- Table structure for table `roleopmapping`
--

CREATE TABLE IF NOT EXISTS `roleopmapping` (
  `id` int(11) NOT NULL,
  `ROLE_ID` int(11) NOT NULL,
  `OPERATION_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roleopmapping`
--

INSERT INTO `roleopmapping` (`id`, `ROLE_ID`, `OPERATION_ID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `ROLE` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `ROLE`, `DESCRIPTION`) VALUES
(1, 'ADMIN', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statutorylaw`
--

CREATE TABLE IF NOT EXISTS `statutorylaw` (
  `id` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statutorylaw`
--

INSERT INTO `statutorylaw` (`id`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Contract Labour (R & A) Act, 1970', 'Contract Labour (R & A) Act, 1970'),
(2, 'Employment ExchangeAct, 1959', 'Employment Exchange (Compulsory Notification of Vacancies) Act, 1959'),
(3, 'Employees State Insurance Act, 1948', 'Employees'' State Insurance Act, 1948'),
(4, 'Profession Tax Act (Bihar), 2011', 'Profession Tax Act (Bihar), 2011'),
(5, 'The Payment of Gratuity Act, 1972', 'The Payment of Gratuity Act, 1972'),
(6, 'The Minimum Wages Act, 1948', 'The Minimum Wages Act, 1948'),
(7, 'Equal Remunaration Act, 1976', 'Equal Remunaration Act, 1976');

-- --------------------------------------------------------

--
-- Table structure for table `unitdocuments`
--

CREATE TABLE IF NOT EXISTS `unitdocuments` (
  `id` int(11) NOT NULL,
  `UNIT_ID` int(11) NOT NULL,
  `STATUTORYLAW_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL,
  `UNIT` varchar(50) NOT NULL,
  `COMPANY_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `UNIT`, `COMPANY_ID`) VALUES
(1, 'Unit1', 1),
(2, 'Unit2', 1),
(3, 'Unit3', 1),
(4, 'Unit4', 1),
(5, 'Unit5', 1),
(6, 'Unit1', 2),
(7, 'Unit2', 2),
(8, 'Unit3', 2),
(9, 'Unit4', 2),
(10, 'Unit1', 3),
(11, 'Unit2', 3),
(12, 'Unit3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `unitstatus`
--

CREATE TABLE IF NOT EXISTS `unitstatus` (
  `id` int(11) NOT NULL,
  `UNIDOCUMENTS_ID` int(11) NOT NULL,
  `FILENAME` varchar(100) DEFAULT NULL,
  `FILELOCATION` varchar(255) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL,
  `LASTUPDATED` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `FIRSTNAME` varchar(100) DEFAULT NULL,
  `LASTNAME` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `ROLE_ID` int(11) DEFAULT NULL,
  `UNIT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `USERNAME`, `PASSWORD`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `ROLE_ID`, `UNIT_ID`) VALUES
(2, 'bikash', 'e0ada8ee50ecef44918b86418e1aa2f8', 'Bikash', 'Biswas', NULL, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `lawdocfreq`
--
ALTER TABLE `lawdocfreq`
  ADD PRIMARY KEY (`id`), ADD KEY `LAWDOCUMENT_ID` (`LAWDOCUMENT_ID`);

--
-- Indexes for table `lawdocuments`
--
ALTER TABLE `lawdocuments`
  ADD PRIMARY KEY (`id`), ADD KEY `LAW_ID` (`LAW_ID`);

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `OPERATION` (`OPERATION`);

--
-- Indexes for table `roleopmapping`
--
ALTER TABLE `roleopmapping`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `ROLE_ID` (`ROLE_ID`,`OPERATION_ID`), ADD KEY `OPERATION_ID` (`OPERATION_ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `ROLE` (`ROLE`);

--
-- Indexes for table `statutorylaw`
--
ALTER TABLE `statutorylaw`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `NAME` (`NAME`);

--
-- Indexes for table `unitdocuments`
--
ALTER TABLE `unitdocuments`
  ADD PRIMARY KEY (`id`), ADD KEY `UNIT_ID` (`UNIT_ID`), ADD KEY `STATUTORYLAW_ID` (`STATUTORYLAW_ID`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`), ADD KEY `COMPANY_ID` (`COMPANY_ID`);

--
-- Indexes for table `unitstatus`
--
ALTER TABLE `unitstatus`
  ADD PRIMARY KEY (`id`), ADD KEY `UNIDOCUMENTS_ID` (`UNIDOCUMENTS_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `USERNAME` (`USERNAME`,`UNIT_ID`,`ROLE_ID`), ADD KEY `ROLE_ID` (`ROLE_ID`), ADD KEY `UNIT_ID` (`UNIT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lawdocfreq`
--
ALTER TABLE `lawdocfreq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lawdocuments`
--
ALTER TABLE `lawdocuments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `roleopmapping`
--
ALTER TABLE `roleopmapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `statutorylaw`
--
ALTER TABLE `statutorylaw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `unitdocuments`
--
ALTER TABLE `unitdocuments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `unitstatus`
--
ALTER TABLE `unitstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `lawdocfreq`
--
ALTER TABLE `lawdocfreq`
ADD CONSTRAINT `lawdocfreq_ibfk_1` FOREIGN KEY (`LAWDOCUMENT_ID`) REFERENCES `lawdocuments` (`id`);

--
-- Constraints for table `lawdocuments`
--
ALTER TABLE `lawdocuments`
ADD CONSTRAINT `lawdocuments_ibfk_1` FOREIGN KEY (`LAW_ID`) REFERENCES `statutorylaw` (`id`);

--
-- Constraints for table `roleopmapping`
--
ALTER TABLE `roleopmapping`
ADD CONSTRAINT `roleopmapping_ibfk_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `roles` (`id`),
ADD CONSTRAINT `roleopmapping_ibfk_2` FOREIGN KEY (`OPERATION_ID`) REFERENCES `operations` (`id`);

--
-- Constraints for table `unitdocuments`
--
ALTER TABLE `unitdocuments`
ADD CONSTRAINT `unitdocuments_ibfk_1` FOREIGN KEY (`UNIT_ID`) REFERENCES `units` (`id`),
ADD CONSTRAINT `unitdocuments_ibfk_2` FOREIGN KEY (`STATUTORYLAW_ID`) REFERENCES `statutorylaw` (`id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`COMPANY_ID`) REFERENCES `companies` (`id`);

--
-- Constraints for table `unitstatus`
--
ALTER TABLE `unitstatus`
ADD CONSTRAINT `unitstatus_ibfk_1` FOREIGN KEY (`UNIDOCUMENTS_ID`) REFERENCES `unitdocuments` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `roles` (`id`),
ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`UNIT_ID`) REFERENCES `units` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
