-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2026 at 04:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `wh_clients`
--

CREATE TABLE `wh_clients` (
  `CId` varchar(50) NOT NULL,
  `WId` varchar(50) NOT NULL,
  `CName` varchar(250) NOT NULL,
  `CAddress` varchar(500) NOT NULL,
  `CDateExpr` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wh_warehouse`
--

CREATE TABLE `wh_warehouse` (
  `WId` varchar(50) NOT NULL,
  `WName` varchar(250) NOT NULL,
  `Price` float NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wh_warehouse`
--

INSERT INTO `wh_warehouse` (`WId`, `WName`, `Price`, `Status`) VALUES
('4d571dbc3eb4c7264ef7a2c7ec767af30a2596675ebac482c6', 'WareHouse 1', 5999.86, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wh_clients`
--
ALTER TABLE `wh_clients`
  ADD PRIMARY KEY (`CId`),
  ADD KEY `CID_WID FK` (`WId`);

--
-- Indexes for table `wh_warehouse`
--
ALTER TABLE `wh_warehouse`
  ADD PRIMARY KEY (`WId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wh_clients`
--
ALTER TABLE `wh_clients`
  ADD CONSTRAINT `CID_WID FK` FOREIGN KEY (`WId`) REFERENCES `wh_warehouse` (`WId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
