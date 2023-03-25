-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2021 at 01:46 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boni_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `request_carpets`
--

CREATE TABLE `request_carpets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `length` double(8,2) NOT NULL,
  `width` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double(8,2) NOT NULL,
  `lng` double(8,2) NOT NULL,
  `amount` double NOT NULL,
  `request_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=>pending , 2=>accept , 3=>reject',
  `complete_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=pending , 2=>ongoing , 3=>complete',
  `on_the_way` int(11) NOT NULL DEFAULT 0 COMMENT '1=>on the way , 0=>not on the way',
  `final_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=>not complete , 2=>complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `van_id` int(11) NOT NULL DEFAULT 0,
  `started_now` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request_carpets`
--
ALTER TABLE `request_carpets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request_carpets`
--
ALTER TABLE `request_carpets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
