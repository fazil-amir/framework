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
-- Table structure for table `m_block_cms_categories`
--

CREATE TABLE `m_block_cms_categories` (
  `pr_id` int(11) NOT NULL,
  `cat_id` varchar(100) NOT NULL,
  `child_count` int(11) NOT NULL DEFAULT 0,
  `cat_name` varchar(500) NOT NULL,
  `headline` varchar(500) NOT NULL,
  `language` varchar(15) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT 0,
  `featured` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` varchar(50) DEFAULT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `banner_image` varchar(500) NOT NULL,
  `seo_title` varchar(500) NOT NULL,
  `seo_keyword` varchar(500) NOT NULL,
  `seo_description` varchar(500) NOT NULL,
  `seo_uri` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_block_cms_categories`
--
ALTER TABLE `m_block_cms_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `pr_id` (`pr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_block_cms_categories`
--
ALTER TABLE `m_block_cms_categories`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
