-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 11:59 PM
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
-- Database: `garden`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `equipid` varchar(10) NOT NULL,
  `equiptypeid` varchar(10) NOT NULL,
  `owner` varchar(10) NOT NULL DEFAULT 'IITP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`equipid`, `equiptypeid`, `owner`) VALUES
('G-01', 'E', 'IITP'),
('G-02', 'E', 'IITP'),
('G-03', 'E', 'IITP'),
('G-04', 'E', 'IITP'),
('G-05', 'E', 'IITP'),
('G-06', 'E', 'IITP'),
('G-07', 'E', 'IITP'),
('G-08', 'E', 'IITP'),
('G-09', 'E', 'IITP'),
('G-10', 'E', 'V-03'),
('LA-01', 'B', 'V-01'),
('LA-02', 'B', 'IITP'),
('LA-03', 'B', 'IITP'),
('SC-01', 'A', 'V-03'),
('SC-02', 'A', '1'),
('SC-03', 'A', 'IITP'),
('SC-04', 'A', 'IITP'),
('SC-05', 'A', 'V-03'),
('SD-01', 'D', 'IITP'),
('SD-02', 'D', 'V-01'),
('SP-01', 'C', '1'),
('SP-02', 'C', '2'),
('SP-03', 'C', 'V-03'),
('SP-04', 'C', 'IITP');

-- --------------------------------------------------------

--
-- Table structure for table `equiptype`
--

CREATE TABLE `equiptype` (
  `equiptypeid` varchar(10) NOT NULL,
  `cost` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equiptype`
--

INSERT INTO `equiptype` (`equiptypeid`, `cost`, `quantity`, `name`) VALUES
('A', 1000, 5, 'Scissors'),
('B', 2000, 3, 'Ladder'),
('C', 1500, 4, 'Spray Pump'),
('D', 2000, 2, 'Spade'),
('E', 500, 10, 'Gloves');

-- --------------------------------------------------------

--
-- Table structure for table `garden`
--

CREATE TABLE `garden` (
  `location` varchar(30) NOT NULL,
  `manhours` int(11) NOT NULL,
  `gardenid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `garden`
--

INSERT INTO `garden` (`location`, `manhours`, `gardenid`) VALUES
('Admin Block', 5, 'AB-01'),
('Admin Block', 6, 'AB-02'),
('New Boys Hostel', 6, 'NBH-01'),
('Old Boys Hostel', 6, 'OBH-01'),
('Residential Complexes', 8, 'RC-01');

-- --------------------------------------------------------

--
-- Table structure for table `gardener`
--

CREATE TABLE `gardener` (
  `empid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `doj` date NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gardener`
--

INSERT INTO `gardener` (`empid`, `name`, `mobile`, `doj`, `password`) VALUES
(0, 'Supervisor', 'admin', '2021-11-28', 'admin'),
(1, 'Ramlal', '123', '2021-11-28', '123'),
(2, 'Kalu', '234', '2021-11-28', '234'),
(3, 'Ramu', '987', '2021-10-30', '987');

-- --------------------------------------------------------

--
-- Table structure for table `gardening`
--

CREATE TABLE `gardening` (
  `gardenid` varchar(10) NOT NULL,
  `empid` int(11) NOT NULL,
  `worktype` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `attendence` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gardening`
--

INSERT INTO `gardening` (`gardenid`, `empid`, `worktype`, `date`, `attendence`) VALUES
('AB-01', 1, 'Grass Cutting', '2021-11-01', 'PRESENT'),
('OBH-01', 1, 'Watering', '2021-11-02', 'PRESENT'),
('AB-02', 1, 'Grass Cutting', '2021-11-03', 'PRESENT'),
('RC-01', 1, 'Flowering', '2021-11-04', 'PRESENT'),
('NBH-01', 1, 'Planting', '2021-11-05', 'PRESENT'),
('AB-01', 1, 'Cleaning', '2021-11-06', 'PRESENT'),
('OBH-01', 1, 'Flowering', '2021-11-07', 'PRESENT'),
('AB-02', 1, 'Cleaning', '2021-11-08', 'PRESENT'),
('RC-01', 1, 'Flowering', '2021-11-09', 'PRESENT'),
('NBH-01', 1, 'Grass Cutting', '2021-11-10', 'PRESENT'),
('AB-02', 1, 'Flowering', '2021-11-11', 'PRESENT'),
('RC-01', 1, 'Cleaning', '2021-11-12', 'PRESENT'),
('NBH-01', 1, 'Grass Cutting', '2021-11-13', 'PRESENT'),
('AB-01', 1, 'Planting', '2021-11-14', 'PRESENT'),
('OBH-01', 1, 'Grass Cutting', '2021-11-15', 'PRESENT'),
('AB-01', 1, 'Grass Cutting', '2021-11-16', 'PRESENT'),
('OBH-01', 1, 'Watering', '2021-11-17', 'PRESENT'),
('AB-02', 1, 'Grass Cutting', '2021-11-18', 'PRESENT'),
('RC-01', 1, 'Flowering', '2021-11-19', 'PRESENT'),
('NBH-01', 1, 'Planting', '2021-11-20', 'PRESENT'),
('AB-01', 1, 'Cleaning', '2021-11-21', 'PRESENT'),
('OBH-01', 1, 'Flowering', '2021-11-22', 'PRESENT'),
('AB-02', 1, 'Cleaning', '2021-11-23', 'PRESENT'),
('RC-01', 1, 'Flowering', '2021-11-24', 'PRESENT'),
('NBH-01', 1, 'Grass Cutting', '2021-11-25', 'PRESENT'),
('AB-02', 1, 'Flowering', '2021-11-26', 'PRESENT'),
('RC-01', 1, 'Cleaning', '2021-11-27', 'PRESENT'),
('NBH-01', 1, 'Grass Cutting', '2021-11-28', 'PRESENT'),
('AB-01', 1, 'Planting', '2021-11-29', 'PRESENT'),
('RC-01', 1, 'Grass Cutting', '2021-11-30', NULL),
('AB-02', 1, 'Grass Cutting', '2021-12-01', NULL),
('AB-01', 1, 'Grass Cutting', '2021-12-02', NULL),
('RC-01', 1, 'Cleaning', '2021-12-03', NULL),
('OBH-01', 1, 'Flowering', '2021-12-05', NULL),
('AB-02', 2, 'Flowering', '2021-11-01', 'PRESENT'),
('AB-01', 2, 'Clearning', '2021-11-02', 'PRESENT'),
('NBH-01', 2, 'Watering', '2021-11-03', 'PRESENT'),
('AB-01', 2, 'Grass Cutting', '2021-11-04', 'PRESENT'),
('OBH-01', 2, 'Grass Cutting', '2021-11-05', 'PRESENT'),
('AB-02', 2, 'Grass Cutting', '2021-11-06', 'PRESENT'),
('RC-01', 2, 'Grass Cutting', '2021-11-07', 'PRESENT'),
('NBH-01', 2, 'Grass Cutting', '2021-11-08', 'PRESENT'),
('AB-01', 2, 'Grass Cutting', '2021-11-09', 'PRESENT'),
('OBH-01', 2, 'Cleaning', '2021-11-10', 'PRESENT'),
('NBH-01', 2, 'Grass Cutting', '2021-11-11', 'PRESENT'),
('AB-01', 2, 'Grass Cutting', '2021-11-12', 'PRESENT'),
('OBH-01', 2, 'Watering', '2021-11-13', 'PRESENT'),
('AB-02', 2, 'Flowering', '2021-11-14', 'PRESENT'),
('RC-01', 2, 'Grass Cutting', '2021-11-15', 'PRESENT'),
('AB-02', 2, 'Flowering', '2021-11-16', 'PRESENT'),
('AB-01', 2, 'Clearning', '2021-11-17', 'PRESENT'),
('NBH-01', 2, 'Watering', '2021-11-18', 'PRESENT'),
('AB-01', 2, 'Grass Cutting', '2021-11-19', 'PRESENT'),
('OBH-01', 2, 'Grass Cutting', '2021-11-20', 'PRESENT'),
('AB-02', 2, 'Grass Cutting', '2021-11-21', 'PRESENT'),
('RC-01', 2, 'Grass Cutting', '2021-11-22', 'PRESENT'),
('NBH-01', 2, 'Grass Cutting', '2021-11-23', 'PRESENT'),
('AB-01', 2, 'Grass Cutting', '2021-11-24', 'PRESENT'),
('OBH-01', 2, 'Cleaning', '2021-11-25', 'ABSENT'),
('NBH-01', 2, 'Grass Cutting', '2021-11-26', 'PRESENT'),
('AB-01', 2, 'Grass Cutting', '2021-11-27', 'PRESENT'),
('OBH-01', 2, 'Watering', '2021-11-28', 'PRESENT'),
('AB-02', 2, 'Flowering', '2021-11-29', 'PRESENT'),
('RC-01', 2, 'Grass Cutting', '2021-11-30', 'PRESENT'),
('OBH-01', 2, 'Grass Cutting', '2021-12-04', NULL),
('AB-01', 3, 'flowering', '2021-11-01', 'PRESENT'),
('RC-01', 3, 'Watering', '2021-11-02', 'PRESENT'),
('OBH-01', 3, 'Flowering', '2021-11-03', 'PRESENT'),
('AB-02', 3, 'Watering', '2021-11-04', 'PRESENT'),
('RC-01', 3, 'Watering', '2021-11-05', 'PRESENT'),
('NBH-01', 3, 'Cleaning', '2021-11-06', 'PRESENT'),
('AB-01', 3, 'Watering', '2021-11-07', 'PRESENT'),
('OBH-01', 3, 'Flowering', '2021-11-08', 'ABSENT'),
('AB-02', 3, 'Watering', '2021-11-09', 'PRESENT'),
('RC-01', 3, 'Watering', '2021-11-10', 'PRESENT'),
('AB-01', 3, 'Planting', '2021-11-11', 'PRESENT'),
('OBH-01', 3, 'Planting', '2021-11-12', 'PRESENT'),
('AB-02', 3, 'Flowering', '2021-11-13', 'PRESENT'),
('RC-01', 3, 'Planting', '2021-11-14', 'PRESENT'),
('AB-02', 3, 'Flowering', '2021-11-15', 'PRESENT'),
('RC-01', 3, 'Watering', '2021-11-16', 'PRESENT'),
('OBH-01', 3, 'Flowering', '2021-11-17', 'PRESENT'),
('AB-02', 3, 'Watering', '2021-11-18', 'PRESENT'),
('RC-01', 3, 'Watering', '2021-11-19', 'PRESENT'),
('NBH-01', 3, 'Cleaning', '2021-11-20', 'PRESENT'),
('AB-01', 3, 'Watering', '2021-11-21', 'PRESENT'),
('OBH-01', 3, 'Flowering', '2021-11-22', 'ABSENT'),
('AB-02', 3, 'Watering', '2021-11-23', 'PRESENT'),
('RC-01', 3, 'Watering', '2021-11-24', 'PRESENT'),
('AB-01', 3, 'Planting', '2021-11-25', 'PRESENT'),
('OBH-01', 3, 'Planting', '2021-11-26', 'PRESENT'),
('AB-02', 3, 'Flowering', '2021-11-27', 'PRESENT'),
('RC-01', 3, 'Planting', '2021-11-28', 'PRESENT'),
('AB-01', 3, 'Grass Cutting', '2021-11-29', 'PRESENT'),
('RC-01', 3, 'Grass Cutting', '2021-11-30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repair`
--

CREATE TABLE `repair` (
  `vendorid` varchar(10) NOT NULL,
  `equipid` varchar(10) NOT NULL,
  `repairdate` date NOT NULL DEFAULT current_timestamp(),
  `returndate` date DEFAULT NULL,
  `repaircost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repair`
--

INSERT INTO `repair` (`vendorid`, `equipid`, `repairdate`, `returndate`, `repaircost`) VALUES
('V-01', 'LA-01', '2021-11-29', '2001-01-01', 500),
('V-01', 'LA-03', '2021-11-01', '2021-11-05', 500),
('V-01', 'SD-02', '2021-11-29', '2001-01-01', 500),
('V-02', 'G-01', '2021-11-30', NULL, NULL),
('V-02', 'LA-02', '2021-10-06', '2021-10-15', 500),
('V-02', 'SC-03', '2021-11-18', '2021-11-20', 500),
('V-03', 'G-10', '2021-10-12', '2021-10-15', 500),
('V-03', 'G-10', '2021-11-29', '2001-01-01', 500),
('V-03', 'SC-01', '2021-11-29', '2001-01-01', 500),
('V-03', 'SC-05', '2021-11-29', '2001-01-01', 500),
('V-03', 'SP-03', '2021-11-29', '2001-01-01', 500);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `reqid` int(11) NOT NULL,
  `equiptypeid` varchar(10) NOT NULL,
  `empid` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`reqid`, `equiptypeid`, `empid`, `date`, `status`) VALUES
(1, 'A', 1, '2021-11-28', 'ACCEPTED'),
(3, 'B', 1, '2021-11-19', 'ACCEPTED'),
(4, 'A', 1, '2021-11-12', 'DENIED'),
(7, 'A', 1, '2021-11-29', 'ACCEPTED'),
(9, 'A', 1, '2021-11-29', 'ACCEPTED'),
(11, 'C', 1, '2021-11-29', 'ACCEPTED'),
(12, 'B', 2, '2021-11-30', 'ACCEPTED'),
(13, 'C', 2, '2021-11-30', 'ACCEPTED'),
(14, 'A', 3, '2021-11-30', 'PENDING'),
(15, 'B', 3, '2021-11-30', 'DENIED'),
(16, 'C', 3, '2021-11-30', 'PENDING'),
(17, 'D', 3, '2021-11-30', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendorid` varchar(10) NOT NULL,
  `vname` varchar(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendorid`, `vname`, `mobile`, `address`) VALUES
('V-01', 'Shukla Brothers', '111', 'Bihta'),
('V-02', 'Vendor2', '222', 'Patna'),
('V-03', 'Vendor-03', '333', 'Danapur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`equipid`),
  ADD KEY `equipments_ibfk1` (`equiptypeid`);

--
-- Indexes for table `equiptype`
--
ALTER TABLE `equiptype`
  ADD PRIMARY KEY (`equiptypeid`);

--
-- Indexes for table `garden`
--
ALTER TABLE `garden`
  ADD PRIMARY KEY (`gardenid`);

--
-- Indexes for table `gardener`
--
ALTER TABLE `gardener`
  ADD PRIMARY KEY (`empid`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `gardening`
--
ALTER TABLE `gardening`
  ADD PRIMARY KEY (`empid`,`date`),
  ADD KEY `gardening_ibfk2` (`gardenid`);

--
-- Indexes for table `repair`
--
ALTER TABLE `repair`
  ADD PRIMARY KEY (`vendorid`,`equipid`,`repairdate`),
  ADD KEY `repair_ibfk2` (`equipid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`reqid`),
  ADD KEY `request_ibfk1` (`empid`),
  ADD KEY `request_ibfk2` (`equiptypeid`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendorid`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `equipments_ibfk1` FOREIGN KEY (`equiptypeid`) REFERENCES `equiptype` (`equiptypeid`);

--
-- Constraints for table `gardening`
--
ALTER TABLE `gardening`
  ADD CONSTRAINT `gardening_ibfk1` FOREIGN KEY (`empid`) REFERENCES `gardener` (`empid`),
  ADD CONSTRAINT `gardening_ibfk2` FOREIGN KEY (`gardenid`) REFERENCES `garden` (`gardenid`);

--
-- Constraints for table `repair`
--
ALTER TABLE `repair`
  ADD CONSTRAINT `repair_ibfk1` FOREIGN KEY (`vendorid`) REFERENCES `vendor` (`vendorid`),
  ADD CONSTRAINT `repair_ibfk2` FOREIGN KEY (`equipid`) REFERENCES `equipments` (`equipid`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk1` FOREIGN KEY (`empid`) REFERENCES `gardener` (`empid`),
  ADD CONSTRAINT `request_ibfk2` FOREIGN KEY (`equiptypeid`) REFERENCES `equiptype` (`equiptypeid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
