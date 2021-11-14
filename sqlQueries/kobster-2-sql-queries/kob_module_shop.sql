-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2016 at 08:23 PM
-- Server version: 5.5.48-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `karthik_kobster_eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `kob_module_shop`
--

CREATE TABLE IF NOT EXISTS `kob_module_shop` (
  `id_module` int(11) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL,
  `enable_device` tinyint(1) NOT NULL DEFAULT '7',
  PRIMARY KEY (`id_module`,`id_shop`),
  KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kob_module_shop`
--

INSERT INTO `kob_module_shop` (`id_module`, `id_shop`, `enable_device`) VALUES
(3, 1, 7),
(4, 1, 7),
(6, 1, 7),
(19, 1, 7),
(25, 1, 7),
(26, 1, 7),
(27, 1, 7),
(28, 1, 7),
(30, 1, 7),
(31, 1, 7),
(32, 1, 7),
(33, 1, 7),
(34, 1, 7),
(35, 1, 7),
(36, 1, 7),
(37, 1, 7),
(39, 1, 7),
(40, 1, 7),
(41, 1, 7),
(42, 1, 7),
(43, 1, 7),
(44, 1, 7),
(45, 1, 7),
(46, 1, 7),
(47, 1, 7),
(48, 1, 7),
(49, 1, 7),
(50, 1, 7),
(51, 1, 7),
(52, 1, 7),
(53, 1, 7),
(55, 1, 7),
(57, 1, 7),
(59, 1, 7),
(60, 1, 7),
(138, 1, 7),
(139, 1, 7),
(146, 1, 7),
(157, 1, 7),
(162, 1, 7),
(163, 1, 7),
(179, 1, 7),
(188, 1, 7),
(192, 1, 7),
(194, 1, 7),
(197, 1, 7),
(198, 1, 7),
(217, 1, 7),
(219, 1, 7),
(220, 1, 7),
(221, 1, 7),
(226, 1, 7),
(230, 1, 7),
(231, 1, 1),
(235, 1, 7),
(243, 1, 7),
(248, 1, 7),
(249, 1, 7),
(251, 1, 7),
(252, 1, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
