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
-- Table structure for table `request_upholsterys`
--

CREATE TABLE `request_upholsterys` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `no_of_couches` int(11) DEFAULT NULL,
  `no_of_dinning_chair` int(11) DEFAULT NULL,
  `no_of_side_chair` int(11) DEFAULT NULL,
  `others` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `time` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double(8,2) NOT NULL,
  `lng` double(8,2) NOT NULL,
  `amount` double DEFAULT 0 COMMENT '0 => only others are selected ',
  `request_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=>pending , 2=>accept , 3=>reject',
  `complete_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=>pending , 2=>ongoing , 3=>complete',
  `on_the_way` int(11) NOT NULL DEFAULT 0 COMMENT '1=>on the way , 0=>not on the way',
  `final_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=>not complete , 2=>complete',
  `van_id` int(11) NOT NULL DEFAULT 0 COMMENT '0=> no van allocate',
  `started_now` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request_upholsterys`
--
ALTER TABLE `request_upholsterys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request_upholsterys`
--
ALTER TABLE `request_upholsterys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
