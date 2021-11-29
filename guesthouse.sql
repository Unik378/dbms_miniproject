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
-- Database: `guesthouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingId` int(11) NOT NULL,
  `bookingDate` date NOT NULL DEFAULT current_timestamp(),
  `arrival` date NOT NULL,
  `departure` date NOT NULL,
  `foodServices` tinyint(1) NOT NULL,
  `bookedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingId`, `bookingDate`, `arrival`, `departure`, `foodServices`, `bookedBy`) VALUES
(1, '2020-01-29', '2020-03-05', '2020-03-08', 1, 'unique_1901cs66@iitp.ac.in'),
(2, '2020-10-29', '2020-11-09', '2020-11-15', 1, 'ranjeet_1901cs45@iitp.ac.in'),
(3, '2021-03-12', '2021-04-29', '2021-05-05', 1, 'ranjeet_1901cs45@iitp.ac.in'),
(4, '2021-09-29', '2021-10-01', '2021-10-15', 1, 'vishesh_1901cs71@iitp.ac.in'),
(5, '2021-09-22', '2021-10-20', '2021-11-02', 1, 'vishesh_1901cs71@iitp.ac.in'),
(6, '2020-03-13', '2020-04-25', '2020-05-01', 0, 'pic_tnp@iitp.ac.in'),
(7, '2021-02-11', '2021-03-23', '2021-03-28', 1, 'director@iitp.ac.in'),
(8, '2021-11-29', '2021-12-02', '2021-12-06', 1, 'utkarsh_1901cs67@iitp.ac.in'),
(9, '2021-11-29', '2021-12-02', '2021-12-06', 1, 'utkarsh_1901cs67@iitp.ac.in'),
(11, '2021-11-29', '2021-12-01', '2021-12-04', 0, 'unique_1901cs66@iitp.ac.in'),
(12, '2021-11-29', '2021-11-30', '2021-12-01', 1, 'unique_1901cs66@iitp.ac.in'),
(13, '2021-11-30', '2021-12-01', '2021-12-03', 1, 'unique_1901cs66@iitp.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` varchar(20) NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `customerName`, `gender`, `age`) VALUES
('100000000001', 'Rahul', 'M', 20),
('100000000002', 'Ram', 'M', 21),
('100000000003', 'Rakesh', 'M', 21),
('100000000004', 'Khusi', 'F', 19),
('100000000005', 'Priya', 'F', 19),
('100000000006', 'Jenish', 'M', 20),
('100000000007', 'Madhur', 'M', 20),
('100000000008', 'Tarushi', 'F', 20),
('100000000009', 'Tanishq', 'M', 21),
('100000000010', 'Venkat', 'M', 21),
('100000000011', 'Pankaj', 'M', 22),
('100000000012', 'Simram', 'F', 20),
('100000000013', 'Chetan', 'M', 21),
('100000000014', 'Ravina', 'F', 20),
('100000000015', 'Antima', 'F', 20),
('100000000016', 'Abhi', 'M', 21),
('100000000017', 'Abhinav', 'M', 22),
('100000000018', 'Maya', 'F', 35),
('100000000019', 'Annu', 'F', 25),
('100000000020', 'Rakesh', 'M', 30),
('100000000021', 'Ravi', 'M', 22),
('100000000022', 'Jitender', 'M', 23),
('100000000023', 'Manshi', 'F', 19),
('100000000024', 'Akshika', 'F', 20),
('100000000025', 'Kelash', 'M', 40),
('100000000026', 'Anshul', 'M', 32),
('100000000027', 'Manish', 'M', 25),
('100000000028', 'Ravi', 'M', 22),
('100000000029', 'Ramkesh', 'M', 21),
('100000000030', 'Dinesh', 'M', 20),
('123123', 'dfs', 'M', 23),
('3746', 'gdhf', 'M', 23),
('734637', 'dhgfghjs', 'M', 72),
('843', 'jhdfg', 'M', 23),
('874534', 'dkf', 'M', 24);

-- --------------------------------------------------------

--
-- Table structure for table `hasbooked`
--

CREATE TABLE `hasbooked` (
  `bookingId` int(11) NOT NULL,
  `customerid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasbooked`
--

INSERT INTO `hasbooked` (`bookingId`, `customerid`) VALUES
(1, '100000000001'),
(2, '100000000010'),
(3, '100000000021'),
(3, '100000000022'),
(3, '100000000023'),
(3, '100000000024'),
(4, '100000000020'),
(5, '100000000011'),
(5, '100000000012'),
(6, '100000000002'),
(6, '100000000003'),
(6, '100000000004'),
(6, '100000000005'),
(7, '100000000006'),
(7, '100000000007'),
(7, '100000000008'),
(7, '100000000009'),
(8, '100000000015'),
(8, '100000000016'),
(9, '100000000017'),
(9, '100000000018'),
(11, '100000000012'),
(11, '100000000013'),
(12, '100000000001'),
(13, '123123');

-- --------------------------------------------------------

--
-- Table structure for table `isbooked`
--

CREATE TABLE `isbooked` (
  `bookingID` int(11) NOT NULL,
  `roomID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isbooked`
--

INSERT INTO `isbooked` (`bookingID`, `roomID`) VALUES
(1, 'A-101'),
(2, 'A-101'),
(3, 'C-301'),
(4, 'A-101'),
(5, 'A-101'),
(6, 'C-301'),
(7, 'B-201'),
(8, 'A-101'),
(9, 'A-102'),
(11, 'A-103'),
(12, 'A-101'),
(13, 'B-201');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `emailID` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `clgID` varchar(20) NOT NULL,
  `mob` text NOT NULL,
  `Aadhaar` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`emailID`, `Name`, `password`, `designation`, `clgID`, `mob`, `Aadhaar`) VALUES
('1801cs01@iitp.ac.in', '1801cs01', '1801cs01', 'Student', '1801cs01', '11111', '102010101'),
('1901cs01@iitp.ac.in', '1901cs01', '1901cs01', 'Student', '1901cs01', '1111111110', '10293401202'),
('2001cs01@iitp.ac.in', '2001cs01', '2001cs01', 'Student', '2001cs01', '1234321432', '123945'),
('adean@iitp.ac.in', 'Adean', 'adean', 'IITP', 'adean', '0', '0'),
('director@iitp.ac.in', 'T.N.Singh', 'T.N.Singh', 'IITP', 'DR1', '8764329677', '786387629877'),
('ghreception@iitp.ac.in', 'GH Reception', 'ghreception', 'GH', 'GH', '1', '1'),
('jimson@iitp.ac.in', 'Jimson', 'Jimson', 'Staff', 'PRCS3', '9864539876', '328932389234'),
('pic_auto@iitp.ac.in', 'Smriti', 'Smriti', 'IITP', 'PIC2', '9723232323', '764764764764'),
('pic_medical@iitp.ac.in', 'Meghna', 'Meghna', 'IITP', 'PIC1', '9712129821', '345345345345'),
('pic_tnp@iitp.ac.in', 'Josh', 'Josh', 'IITP', 'PIC4', '8032423443', '985498439834'),
('pic_ug@iitp.ac.in', 'Sushant', 'Sushant', 'IITP', 'PIC3', '7923423454', '545454656565'),
('ranjeet_1901cs45@iitp.ac.in', 'Ranjeet', 'Ranjeet', 'Student', '1901CS45', '9812981298', '991199119911'),
('rishav_1901cs46@iitp.ac.in', 'Rishav', 'Rishav', 'Student', '1901CS46', '9874329872', '432876428642'),
('samrat@iitp.ac.in', 'Samrat', 'Samrat', 'Staff', 'PRCS1', '7012398712', '989798799879'),
('som@iitp.ac.in', 'Somnath', 'Somnath', 'Staff', 'PRCS2', '9879862323', '543899345987'),
('tarushi_1901cs62@iitp.ac.in', 'Tarushi', 'Tarushi', 'Student', '1901CS62', '8764239872', '543535435553'),
('unique_1901cs66@iitp.ac.in', 'Unique', 'Unique', 'Student', '1901CS66', '9817920198', '123123123123'),
('utkarsh_1901cs67@iitp.ac.in', 'Utkarsh', 'Utkarsh', 'Student', '1901CS67', '8768769768', '987987987987'),
('vishesh_1901cs71@iitp.ac.in', 'Vishesh', 'Vishesh', 'Student', '1901CS71', '9812398123', '231231231231');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `bookingid` int(11) NOT NULL,
  `paymentDate` date DEFAULT NULL,
  `amount` float(10,2) NOT NULL,
  `status` text NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`bookingid`, `paymentDate`, `amount`, `status`) VALUES
(1, '2020-03-05', 2400.00, 'DONE'),
(2, '2020-11-09', 4800.00, 'DONE'),
(3, '2021-04-29', 14400.00, 'DONE'),
(4, '2021-10-01', 11200.00, 'DONE'),
(5, '2021-10-20', 14300.00, 'DONE'),
(6, '2020-03-13', 7200.00, 'BY IITP'),
(7, '2021-02-11', 11000.00, 'BY IITP'),
(8, NULL, 4400.00, 'PENDING'),
(9, NULL, 4400.00, 'PENDING'),
(11, NULL, 1500.00, 'PENDING'),
(12, NULL, 800.00, 'PENDING'),
(13, NULL, 2600.00, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomid` varchar(10) NOT NULL,
  `roomtypeid` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomid`, `roomtypeid`) VALUES
('A-101', 'A'),
('A-102', 'A'),
('A-103', 'A'),
('A-104', 'A'),
('A-105', 'A'),
('B-201', 'B'),
('B-202', 'B'),
('B-203', 'B'),
('B-204', 'B'),
('B-205', 'B'),
('C-301', 'C'),
('C-302', 'C'),
('C-303', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `roomTypeId` char(1) NOT NULL,
  `roomtype` varchar(100) NOT NULL,
  `cost` float(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `numberOfRooms` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`roomTypeId`, `roomtype`, `cost`, `capacity`, `numberOfRooms`) VALUES
('A', '2 Single Beds', 500.00, 2, 5),
('B', '4 single beds', 1000.00, 4, 5),
('C', '2 Double Bed + Attached Washroom', 1200.00, 4, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingId`),
  ADD KEY `booking_ibfk_2` (`bookedBy`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `hasbooked`
--
ALTER TABLE `hasbooked`
  ADD PRIMARY KEY (`bookingId`,`customerid`),
  ADD KEY `customerid` (`customerid`);

--
-- Indexes for table `isbooked`
--
ALTER TABLE `isbooked`
  ADD PRIMARY KEY (`bookingID`,`roomID`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`emailID`),
  ADD UNIQUE KEY `Aadhaar` (`Aadhaar`),
  ADD UNIQUE KEY `clgID` (`clgID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`bookingid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomid`),
  ADD KEY `roomtypeid` (`roomtypeid`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`roomTypeId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`bookedBy`) REFERENCES `login` (`emailID`);

--
-- Constraints for table `hasbooked`
--
ALTER TABLE `hasbooked`
  ADD CONSTRAINT `hasbooked_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `customer` (`customerId`),
  ADD CONSTRAINT `hasbooked_ibfk_2` FOREIGN KEY (`bookingId`) REFERENCES `booking` (`bookingId`);

--
-- Constraints for table `isbooked`
--
ALTER TABLE `isbooked`
  ADD CONSTRAINT `isbooked_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingId`),
  ADD CONSTRAINT `isbooked_ibfk_2` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomid`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`bookingid`) REFERENCES `booking` (`bookingId`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`roomtypeid`) REFERENCES `room_type` (`roomTypeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
