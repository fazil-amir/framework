-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2019 at 09:07 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cody_framework`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_widgets`
--

CREATE TABLE `m_widgets` (
  `pr_id` int(11) NOT NULL,
  `widget_id` varchar(100) NOT NULL,
  `widget_type` varchar(100) DEFAULT NULL,
  `accessor_name` varchar(100) DEFAULT 'NULL',
  `language` varchar(100) DEFAULT 'NULL',
  `directory` varchar(500) DEFAULT 'NULL',
  `rich_data_name` varchar(100) DEFAULT 'NULL',
  `added_on` datetime DEFAULT current_timestamp(),
  `last_modified` datetime DEFAULT current_timestamp(),
  `visibility` tinyint(4) DEFAULT 1,
  `featured` tinyint(4) DEFAULT 1,
  `added_by` varchar(100) DEFAULT NULL,
  `trashed` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_widgets`
--
ALTER TABLE `m_widgets`
  ADD PRIMARY KEY (`widget_id`),
  ADD KEY `pr_id` (`pr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_widgets`
--
ALTER TABLE `m_widgets`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
