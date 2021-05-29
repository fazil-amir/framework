-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 14, 2019 at 02:16 PM
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
-- Table structure for table `m_form_submissions`
--

CREATE TABLE `m_form_submissions` (
  `pr_id` int(11) NOT NULL,
  `sub_id` varchar(100) NOT NULL,
  `accessor_name` varchar(100) NOT NULL,
  `subject` varchar(500) DEFAULT 'N/A',
  `fullname` varchar(500) NOT NULL,
  `email` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `page_url` text DEFAULT NULL,
  `delivered_on` datetime NOT NULL DEFAULT current_timestamp(),
  `sub_data` text NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT 0,
  `trashed` int(11) NOT NULL DEFAULT 0,
  `location` longtext DEFAULT NULL,
  `id_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_form_submissions`
--
ALTER TABLE `m_form_submissions`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `pr_id` (`pr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_form_submissions`
--
ALTER TABLE `m_form_submissions`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
