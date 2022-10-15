-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 14, 2022 at 11:12 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidding`
--

DROP TABLE IF EXISTS `bidding`;
CREATE TABLE IF NOT EXISTS `bidding` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `security` int(50) NOT NULL,
  `profit` int(50) NOT NULL,
  `bid_user` varchar(50) NOT NULL,
  `bid_value` varchar(100) NOT NULL,
  `bid_await` varchar(20) NOT NULL DEFAULT 'await',
  `bid_end_datetime` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `biddingwins`
--

DROP TABLE IF EXISTS `biddingwins`;
CREATE TABLE IF NOT EXISTS `biddingwins` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `security` int(50) NOT NULL,
  `profit` int(50) NOT NULL,
  `bid_user` varchar(50) NOT NULL,
  `bid_value` varchar(100) NOT NULL,
  `bid_end_datetime` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `security` int(50) NOT NULL,
  `profit` int(50) NOT NULL,
  `bid_value` varchar(100) NOT NULL DEFAULT 'await',
  `bid_end_datetime` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `symbol`, `price`, `security`, `profit`, `bid_value`, `bid_end_datetime`, `date_created`) VALUES
(1, 'ABEOW', 0.06, 32777, 700, 'await', '2022-07-25 11:29:00', '2022-07-15 04:41:55'),
(2, 'WLRHW', 5.31, 20492, 7200, 'await', '2022-07-28 16:32:00', '2022-07-14 20:58:18'),
(3, 'VPCOU', 9.52, 48706, 8200, 'await', '2022-08-01 20:02:00', '2022-07-15 04:42:04'),
(4, 'UNAM', 8.25, 73199, 1800, 'await', '2022-08-12 22:06:00', '2022-07-14 20:59:55'),
(5, 'TWOU', 5.74, 23990, 3900, 'await', '2022-09-15 12:09:00', '2022-07-14 21:00:37'),
(6, 'SMMF', 5.24, 37050, 3100, 'await', '2022-08-06 03:11:00', '2022-07-14 21:01:17'),
(7, 'QTNTW', 1.77, 31700, 5800, 'await', '2022-07-20 07:16:00', '2022-07-15 02:46:59'),
(8, 'PRSNW', 5.33, 94818, 5600, 'await', '2022-07-24 23:22:00', '2022-07-14 21:02:28'),
(9, 'NGHCZ', 7.11, 49902, 500, 'await', '2022-08-12 05:26:00', '2022-07-14 21:03:05'),
(10, 'LMBS', 8.7, 10161, 4600, 'await', '2022-07-25 13:06:00', '2022-07-14 21:03:54'),
(11, 'SLYCT', 7.59, 49642, 7800, 'await', '2022-07-19 21:13:00', '2022-07-15 04:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
