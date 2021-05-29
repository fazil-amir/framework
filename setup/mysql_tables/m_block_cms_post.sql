-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 03, 2019 at 11:30 AM
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
-- Table structure for table `m_block_cms_post`
--

CREATE TABLE `m_block_cms_post` (
  `pr_id` int(11) NOT NULL,
  `page_id` varchar(100) NOT NULL,
  `page_type` varchar(15) NOT NULL,
  `title` varchar(500) NOT NULL,
  `caption` varchar(100) DEFAULT NULL,
  `short_description` text NOT NULL,
  `categories` varchar(500) NOT NULL,
  `language` varchar(15) NOT NULL,
  `author` varchar(500) NOT NULL,
  `directory` varchar(500) NOT NULL,
  `rich_data_name` varchar(100) NOT NULL,
  `gallery_images` text NOT NULL,
  `seo_title` varchar(500) NOT NULL,
  `seo_keywords` varchar(1000) NOT NULL,
  `seo_description` text NOT NULL,
  `seo_uri` varchar(500) NOT NULL,
  `featured` varchar(10) NOT NULL DEFAULT '1',
  `visibility` varchar(10) NOT NULL DEFAULT '1',
  `added_by` varchar(100) DEFAULT '1',
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `last_modified` datetime NOT NULL DEFAULT current_timestamp(),
  `trashed` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_block_cms_post`
--
ALTER TABLE `m_block_cms_post`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `pr_id` (`pr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_block_cms_post`
--
ALTER TABLE `m_block_cms_post`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
