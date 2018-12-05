-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2018 at 06:34 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AID` int(11) NOT NULL,
  `AName` varchar(255) NOT NULL,
  `AUsername` varchar(255) NOT NULL,
  `APassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AID`, `AName`, `AUsername`, `APassword`) VALUES
(1, 'Admin Keng12', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'Admin2', 'admin2', 'c84258e9c39059a89ab77d846ddab909');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `LID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `CRDate` varchar(255) NOT NULL,
  `Attendance_Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AID`, `SID`, `LID`, `ClassID`, `CourseID`, `CRDate`, `Attendance_Status`) VALUES
(1, 1, 1, 10, 2, '04/18/2018', 'Absent'),
(3, 1, 1, 8, 2, '08/31/2018', 'Present'),
(4, 1, 4, 12, 4, '04/24/2018', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `classreservation`
--

CREATE TABLE `classreservation` (
  `CRID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `CRDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classreservation`
--

INSERT INTO `classreservation` (`CRID`, `ClassID`, `CourseID`, `SID`, `CRDate`) VALUES
(30, 10, 2, 1, '04/18/2018'),
(31, 10, 2, 1, '04/19/2018'),
(32, 8, 2, 5, '08/30/2018'),
(33, 8, 2, 5, '08/31/2018'),
(34, 8, 2, 6, '08/30/2018'),
(35, 8, 2, 6, '08/31/2018'),
(36, 12, 4, 1, '04/24/2018'),
(37, 12, 4, 1, '04/25/2018');

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `ClassID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `Slot` varchar(255) NOT NULL,
  `Capacity` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `StartTime` varchar(255) NOT NULL,
  `EndTime` varchar(255) NOT NULL,
  `ClassDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`ClassID`, `CourseID`, `Slot`, `Capacity`, `Location`, `StartTime`, `EndTime`, `ClassDate`) VALUES
(8, 2, '4', '4', 'Kuala Lumpur', '11:00 PM', '02:00 AM', '08/30/2018'),
(9, 7, '0', '4', 'Pahang', '11:00 PM', '01:00 AM', '08/28/2018'),
(10, 2, '1', '4', 'KL', '05:15 PM', '08:15 PM', '04/18/2018'),
(11, 9, '0', '4', 'Kuala Lumpur', '11:15 PM', '12:15 AM', '05/01/2018'),
(12, 4, '1', '4', 'Kuala Lumpur', '02:00 PM', '04:00 PM', '04/24/2018'),
(15, 4, '4', '4', 'Kuala Lumpur', '12:30 PM', '02:30 PM', '04/30/2018'),
(16, 10, '4', '4', 'Kuala Lumpur', '12:30 PM', '01:30 PM', '04/29/2018');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(255) NOT NULL,
  `CoursePrice` varchar(255) NOT NULL,
  `LID` int(11) NOT NULL,
  `CourseDesc` varchar(255) NOT NULL,
  `Session` varchar(255) NOT NULL,
  `Hours` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `CourseName`, `CoursePrice`, `LID`, `CourseDesc`, `Session`, `Hours`) VALUES
(2, 'Java Advanced', '4000', 1, 'Java is the best programming to learn.', '2', '3'),
(4, 'C Sharp Programming', '5000', 4, 'C Sharp is the best programming language', '2', '2'),
(7, 'Microsoft Excel - Beginner', '1000', 5, 'Microsoft Excel', '1', '2'),
(8, 'Microsoft Excel - Advanced', '2000', 5, 'Advanced Level', '2', '3'),
(9, 'C++ Programming1', '1500', 4, 'Epic Programming1', '1', '1'),
(10, 'MySQL Database', '2000', 5, 'MySQL FTW!', '1', '1'),
(11, 'Python Beginner', '3000', 4, 'Python Awesome', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `LID` int(11) NOT NULL,
  `LName` varchar(255) NOT NULL,
  `LUsername` varchar(255) NOT NULL,
  `LPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`LID`, `LName`, `LUsername`, `LPassword`) VALUES
(1, 'Feroz1', 'Feroz', 'b9d956c192648b54013eb14350d7734d'),
(4, 'Ms. Kumatha', 'kumatha', 'f9fcadecc5ebb460b0567f64a2872866'),
(5, 'Ms Thavamalar', 'thavamalar', '14e814e747ba44e001c004134b213156');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `BankBranch` varchar(255) NOT NULL,
  `PaymentDate` varchar(255) CHARACTER SET swe7 NOT NULL,
  `OrderDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `ClassID`, `CourseID`, `SID`, `Price`, `Status`, `BankBranch`, `PaymentDate`, `OrderDate`) VALUES
(23, 8, 2, 3, '4000', 'Pending', 'Maybank', '', '04/18/2018'),
(24, 8, 2, 5, '4000', 'Approved', 'Maybank', '04/19/2018', '04/18/2018'),
(25, 8, 2, 4, '4000', 'Pending', 'Maybank', '', '04/18/2018'),
(31, 8, 2, 6, '4000', 'Approved', 'Maybank', '04/22/2018', '04/22/2018'),
(32, 12, 4, 1, '5000', 'Approved', 'Maybank', '04/24/2018', '04/24/2018'),
(35, 15, 4, 1, '5000', 'Pending', 'Maybank', '', '04/25/2018'),
(36, 16, 10, 1, '2000', 'Pending', 'Maybank', '', '04/25/2018'),
(37, 16, 10, 2, '2000', 'Pending', 'Maybank', '', '04/25/2018'),
(38, 15, 4, 2, '5000', 'Pending', 'Maybank', '', '04/25/2018'),
(39, 15, 4, 3, '5000', 'Pending', 'Maybank', '', '04/25/2018'),
(40, 16, 10, 3, '2000', 'Pending', 'Maybank', '', '04/25/2018'),
(41, 15, 4, 5, '5000', 'Pending', 'Maybank', '', '04/25/2018'),
(42, 16, 10, 5, '2000', 'Pending', 'Maybank', '', '04/25/2018');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `SID` int(11) NOT NULL,
  `SName` varchar(255) NOT NULL,
  `SUsername` varchar(255) NOT NULL,
  `SPassword` varchar(255) NOT NULL,
  `SEmail` varchar(255) NOT NULL,
  `SActivation` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`SID`, `SName`, `SUsername`, `SPassword`, `SEmail`, `SActivation`) VALUES
(1, 'Keng Wei1', 'kengwei', '86f3a2c0c2444e6d6e08b89fac16d8cf', 'kengwei91@hotmail.com', '1'),
(2, 'Chris', 'chris', '6b34fe24ac2ff8103f6fce1f0da2ef57', 'chris@gmail.com', '1'),
(3, 'xuan', 'xuan', 'ebbb855092f574cef61b6f3ce7640d87', 'xuan@gmail.com', '1'),
(4, 'Mohammad Samiul', 'samiul', 'b66a616764e2b66ce16f054ce968d3f4', 'samiul@gmail.com', '1'),
(5, 'Mohammad Rafid', 'rafid', '7cbe45de57d8c5cc5a3ff1be94225ed2', 'rafidz@gmail.com', '1'),
(6, 'Keng Wei', 'kengwei99', '86f3a2c0c2444e6d6e08b89fac16d8cf', 'kengwei99@gmail.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `waitinglist`
--

CREATE TABLE `waitinglist` (
  `WLID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `WLDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AID`),
  ADD KEY `SID` (`SID`),
  ADD KEY `LID` (`LID`),
  ADD KEY `ClassID` (`ClassID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `classreservation`
--
ALTER TABLE `classreservation`
  ADD PRIMARY KEY (`CRID`),
  ADD KEY `ClassID` (`ClassID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `SID` (`SID`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `LID` (`LID`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`LID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `ClassID` (`ClassID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `SID` (`SID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `waitinglist`
--
ALTER TABLE `waitinglist`
  ADD PRIMARY KEY (`WLID`),
  ADD KEY `SID` (`SID`),
  ADD KEY `ClassID` (`ClassID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `classreservation`
--
ALTER TABLE `classreservation`
  MODIFY `CRID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `LID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `waitinglist`
--
ALTER TABLE `waitinglist`
  MODIFY `WLID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `student` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`LID`) REFERENCES `lecturer` (`LID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`ClassID`) REFERENCES `classroom` (`ClassID`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_4` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classreservation`
--
ALTER TABLE `classreservation`
  ADD CONSTRAINT `classreservation_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classroom` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classreservation_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classreservation_ibfk_3` FOREIGN KEY (`SID`) REFERENCES `student` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classroom`
--
ALTER TABLE `classroom`
  ADD CONSTRAINT `classroom_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`LID`) REFERENCES `lecturer` (`LID`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classroom` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`SID`) REFERENCES `student` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waitinglist`
--
ALTER TABLE `waitinglist`
  ADD CONSTRAINT `waitinglist_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `student` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waitinglist_ibfk_2` FOREIGN KEY (`ClassID`) REFERENCES `classroom` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waitinglist_ibfk_3` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
