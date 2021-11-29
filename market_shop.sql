-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2021 at 12:00 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `contractid` int(11) NOT NULL,
  `shopid` varchar(10) NOT NULL,
  `shopkeeperid` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `contractdate` date NOT NULL DEFAULT current_timestamp(),
  `monthlyrent` int(11) NOT NULL,
  `rating` float(8,2) NOT NULL DEFAULT 0.00,
  `feedbackresponses` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`contractid`, `shopid`, `shopkeeperid`, `startdate`, `enddate`, `contractdate`, `monthlyrent`, `rating`, `feedbackresponses`) VALUES
(1, 'F-001', 1, '2021-12-01', '2022-01-31', '2021-11-30', 50000, 0.00, 0),
(2, 'F-002', 2, '2021-12-01', '2022-01-31', '2021-11-30', 5000, 0.00, 0),
(3, 'B-001', 2, '2022-01-01', '2022-03-31', '2021-11-30', 10000, 0.00, 0),
(4, 'F-003', 1, '2021-08-01', '2021-12-31', '2021-11-30', 20000, 2.49, 4),
(5, 'B-002', 2, '2021-07-01', '2021-12-31', '2021-11-30', 20000, 3.75, 4),
(6, 'G-001', 2, '2021-11-01', '2022-03-31', '2021-11-30', 20000, 3.33, 3),
(7, 'F-004', 2, '2021-11-01', '2022-03-31', '2021-11-30', 10000, 4.00, 3),
(8, 'B-003', 2, '2021-12-01', '2022-01-31', '2021-11-30', 30000, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `extension`
--

CREATE TABLE `extension` (
  `extreqid` int(11) NOT NULL,
  `contractid` int(11) NOT NULL,
  `extperiod` int(11) NOT NULL,
  `extdate` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'PENDING',
  `extreqdate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `extension`
--

INSERT INTO `extension` (`extreqid`, `contractid`, `extperiod`, `extdate`, `status`, `extreqdate`) VALUES
(1, 6, 3, '2022-03-31', 'ACCEPTED', '2021-11-30'),
(2, 7, 3, '2022-03-31', 'ACCEPTED', '2021-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `contractid` int(11) NOT NULL,
  `feedback` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`contractid`, `feedback`, `email`) VALUES
(4, 3, '1901cs01@iitp.ac.in'),
(4, 4, '1901cs02@iitp.ac.in'),
(4, 1, '1901cs03@iitp.ac.in'),
(4, 2, '1901cs04@iitp.ac.in'),
(5, 4, '1901cs01@iitp.ac.in'),
(5, 5, '1901cs02@iitp.ac.in'),
(5, 3, '1901cs03@iitp.ac.in'),
(5, 3, '1901cs04@iitp.ac.in'),
(6, 4, '1901cs01@iitp.ac.in'),
(6, 5, '1901cs02@iitp.ac.in'),
(6, 1, '1901cs03@iitp.ac.in'),
(7, 5, '1901cs01@iitp.ac.in'),
(7, 2, '1901cs02@iitp.ac.in'),
(7, 5, '1901cs03@iitp.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `iitplogin`
--

CREATE TABLE `iitplogin` (
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `clgid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `iitplogin`
--

INSERT INTO `iitplogin` (`email`, `password`, `name`, `clgid`) VALUES
('1901cs01@iitp.ac.in', '1901cs01', '1901cs01', '1901cs01'),
('1901cs02@iitp.ac.in', '1901cs02', '1901cs02', '1901cs02'),
('1901cs03@iitp.ac.in', '1901cs03', '1901cs03', '1901cs03'),
('1901cs04@iitp.ac.in', '1901cs04', '1901cs04', '1901cs04'),
('1901cs05@iitp.ac.in', '1901cs05', '1901cs05', '1901cs05');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `adhaar` varchar(16) NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `name`, `adhaar`, `dob`, `address`, `mobile`) VALUES
('abhishek@gmail.com', 'Abhishek', 'Abhishek', '987987987987', '2001-01-09', 'Rohtak', '8768769768'),
('kailash@gmail.com', 'Kailash', 'Kailash', '123123123123', '2001-01-02', 'Delhi', '9817920198'),
('meghna@gmail.com', 'Meghna', 'Meghna', '345345345345', '2001-01-04', 'Delhi', '9712129821'),
('msadmin@iitp.ac.in', 'msadmin', 'msadmin', '0', '2001-01-01', 'NA', '0'),
('rahul@gmail.com', 'Rahul', 'Rahul', '991199119911', '2001-01-08', 'Rohtak', '9812981298'),
('raj@gmail.com', 'Raj', 'Raj', '545454656565', '2001-01-06', 'Mumbai', '7923423454'),
('ramu@gmail.com', 'Ramu', 'Ramu', '231231231231', '2001-01-01', 'Patna', '9812398123'),
('rohit@gmail.com', 'Rohit', 'Rohit', '985498439834', '2001-01-07', 'Mumbai', '8032423443'),
('samrat@gmail.com', 'Samrat', 'Samrat', '989798799879', '2001-01-03', 'Delhi', '7012398712'),
('shyam@gmail.com', 'Shyam', 'Shyam', '764764764764', '2001-01-05', 'Mumbai', '9723232323');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `contractid` int(11) NOT NULL,
  `month` date NOT NULL,
  `electricitybill` int(11) DEFAULT NULL,
  `rentstatus` varchar(10) NOT NULL DEFAULT 'PENDING',
  `electricitybillstatus` varchar(10) NOT NULL DEFAULT 'PENDING',
  `electricitybillid` varchar(10) DEFAULT NULL,
  `rentpaymentdate` date DEFAULT NULL,
  `electricitybillpaymentdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`contractid`, `month`, `electricitybill`, `rentstatus`, `electricitybillstatus`, `electricitybillid`, `rentpaymentdate`, `electricitybillpaymentdate`) VALUES
(1, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(1, '2022-01-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(2, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(2, '2022-01-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(3, '2022-01-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(3, '2022-02-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(3, '2022-03-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(4, '2021-08-01', 2000, 'DONE', 'DONE', 'E1', '2021-11-30', '2021-11-30'),
(4, '2021-09-01', 2000, 'DONE', 'DONE', 'E2', '2021-11-30', '2021-11-30'),
(4, '2021-10-01', 2000, 'DONE', 'DONE', 'E3', '2021-11-30', '2021-11-30'),
(4, '2021-11-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(4, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(5, '2021-07-01', 2000, 'DONE', 'DONE', 'E4', '2021-11-30', '2021-11-30'),
(5, '2021-08-01', 2000, 'DONE', 'DONE', 'E5', '2021-11-30', '2021-11-30'),
(5, '2021-09-01', 2000, 'DONE', 'DONE', 'E6', '2021-11-30', '2021-11-30'),
(5, '2021-10-01', 2000, 'DONE', 'DONE', 'E7', '2021-11-30', '2021-11-30'),
(5, '2021-11-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(5, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(6, '2021-11-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(6, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(6, '2022-01-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(6, '2022-02-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(6, '2022-03-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(7, '2021-11-01', 2000, 'PENDING', 'DONE', 'E10', NULL, NULL),
(7, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(7, '2022-01-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(7, '2022-02-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(7, '2022-03-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(8, '2021-12-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL),
(8, '2022-01-01', NULL, 'PENDING', 'PENDING', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `reqid` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `reqdate` date NOT NULL DEFAULT current_timestamp(),
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `location` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `shopid` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL,
  `area` varchar(20) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shopid`, `location`, `area`, `description`) VALUES
('B-001', 'Near Old Boys Hostel', '40ft x 40ft', 'NA'),
('B-002', 'Near Old Boys Hostel', '40ft x 40ft', 'NA'),
('B-003', 'Near Old Boys Hostel', '40ft x 40ft', 'NA'),
('F-001', 'Food Court', '30ft x 40ft', '...NA..'),
('F-002', 'Food Court', '30ft x 40ft', 'NA'),
('F-003', 'Food Court', '30ft x 40ft', 'NA'),
('F-004', 'Food Court', '30ft x 40ft', 'NA'),
('F-005', 'Food Court', '30ft x 40ft', 'NA'),
('G-001', 'Near Gate No.2', '50ft x 40ft', 'NA'),
('G-002', 'Near Gate No.2', '50ft x 40ft', 'NA'),
('G-003', 'Near Gate No.2', '50ft x 40ft', 'NA'),
('G-004', 'Near Gate No.2', '50ft x 40ft', 'NA'),
('G-005', 'Near Gate No.2', '50ft x 40ft', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `shopkeepers`
--

CREATE TABLE `shopkeepers` (
  `shopkeeperid` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `securitypassid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shopkeepers`
--

INSERT INTO `shopkeepers` (`shopkeeperid`, `email`, `securitypassid`) VALUES
(1, 'raj@gmail.com', 'SC-1'),
(2, 'rahul@gmail.com', 'SC-2'),
(3, 'ramu@gmail.com', 'SC-3'),
(4, 'rohit@gmail.com', 'SC-4'),
(5, 'meghna@gmail.com', 'SC-5'),
(6, 'kailash@gmail.com', 'SC-6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`contractid`),
  ADD KEY `contract_ibfk1` (`shopid`),
  ADD KEY `contract_ibfk2` (`shopkeeperid`);

--
-- Indexes for table `extension`
--
ALTER TABLE `extension`
  ADD PRIMARY KEY (`extreqid`),
  ADD KEY `extension_ibfk1` (`contractid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`contractid`,`email`),
  ADD KEY `feedback_ibfk2` (`email`);

--
-- Indexes for table `iitplogin`
--
ALTER TABLE `iitplogin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `adhaar` (`adhaar`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`contractid`,`month`),
  ADD UNIQUE KEY `electricitybillid` (`electricitybillid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`reqid`),
  ADD KEY `request_ibk1` (`email`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`shopid`);

--
-- Indexes for table `shopkeepers`
--
ALTER TABLE `shopkeepers`
  ADD PRIMARY KEY (`shopkeeperid`),
  ADD UNIQUE KEY `securitypassid` (`securitypassid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk1` FOREIGN KEY (`shopid`) REFERENCES `shop` (`shopid`),
  ADD CONSTRAINT `contract_ibfk2` FOREIGN KEY (`shopkeeperid`) REFERENCES `shopkeepers` (`shopkeeperid`);

--
-- Constraints for table `extension`
--
ALTER TABLE `extension`
  ADD CONSTRAINT `extension_ibfk1` FOREIGN KEY (`contractid`) REFERENCES `contract` (`contractid`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk2` FOREIGN KEY (`email`) REFERENCES `iitplogin` (`email`),
  ADD CONSTRAINT `feedback_ibk1` FOREIGN KEY (`contractid`) REFERENCES `contract` (`contractid`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk1` FOREIGN KEY (`contractid`) REFERENCES `contract` (`contractid`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibk1` FOREIGN KEY (`email`) REFERENCES `login` (`email`);

--
-- Constraints for table `shopkeepers`
--
ALTER TABLE `shopkeepers`
  ADD CONSTRAINT `shopkeeper_ibfk1` FOREIGN KEY (`email`) REFERENCES `login` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
