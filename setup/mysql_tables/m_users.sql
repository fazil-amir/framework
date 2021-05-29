-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2019 at 02:44 PM
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
-- Table structure for table `m_users`
--

CREATE TABLE `m_users` (
  `pr_id` int(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `user_name` varchar(500) NOT NULL,
  `user_type` enum('ADMIN','USER') NOT NULL DEFAULT 'ADMIN',
  `password` varchar(500) NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT 0,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `user_full_name` varchar(500) NOT NULL,
  `user_email` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_users`
--

INSERT INTO `m_users` (`pr_id`, `user_id`, `user_name`, `user_type`, `password`, `disabled`, `creation_date`, `trashed`, `user_full_name`, `user_email`) VALUES
(1, 'USER_001', 'fazil_amir', 'ADMIN', 'fazil_amir', 0, '2019-10-23 00:00:00', 0, 'Fazil Amir', 'webmasterfazil@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_users`
--
ALTER TABLE `m_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `pr_id` (`pr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_users`
--
ALTER TABLE `m_users`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
