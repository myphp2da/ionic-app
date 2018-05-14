-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: 172.31.23.140
-- Generation Time: Jul 31, 2016 at 01:30 PM
-- Server version: 10.1.16-MariaDB-1~xenial
-- PHP Version: 5.5.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apps`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_error_logs`
--

DROP TABLE IF EXISTS `mst_error_logs`;
CREATE TABLE `mst_error_logs` (
  `id` int(11) NOT NULL,
  `strErrorDate` varchar(100) NOT NULL,
  `strErrorType` varchar(20) DEFAULT NULL,
  `txtErrorDetails` text,
  `dtiCreated` datetime DEFAULT NULL,
  `tinStatus` tinyint(1) DEFAULT '0' COMMENT '0 = New, 1=Closed, 2=Deleted, 3=Lived',
  `intModifiedBy` int(11) DEFAULT '0',
  `dtiModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_error_logs`
--
ALTER TABLE `mst_error_logs`
  ADD UNIQUE KEY `error_id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_error_logs`
--
ALTER TABLE `mst_error_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
