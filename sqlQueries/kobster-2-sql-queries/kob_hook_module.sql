-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2016 at 08:21 PM
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
-- Table structure for table `kob_hook_module`
--

CREATE TABLE IF NOT EXISTS `kob_hook_module` (
  `id_module` int(10) unsigned NOT NULL,
  `id_hook` int(10) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL DEFAULT '1',
  `position` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id_module`,`id_hook`,`id_shop`),
  KEY `id_hook` (`id_hook`),
  KEY `id_module` (`id_module`),
  KEY `position` (`id_shop`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kob_hook_module`
--

INSERT INTO `kob_hook_module` (`id_module`, `id_hook`, `id_shop`, `position`) VALUES
(217, 105, 1, 0),
(3, 1, 1, 1),
(3, 4, 1, 1),
(19, 0, 1, 1),
(19, 14, 1, 1),
(25, 11, 1, 1),
(26, 32, 1, 1),
(34, 33, 1, 1),
(39, 37, 1, 1),
(42, 95, 1, 1),
(51, 45, 1, 1),
(141, 2, 1, 1),
(141, 5, 1, 1),
(141, 13, 1, 1),
(141, 16, 1, 1),
(141, 26, 1, 1),
(141, 41, 1, 1),
(141, 42, 1, 1),
(141, 53, 1, 1),
(146, 15, 1, 1),
(146, 19, 1, 1),
(146, 23, 1, 1),
(146, 30, 1, 1),
(146, 34, 1, 1),
(146, 39, 1, 1),
(157, 21, 1, 1),
(162, 25, 1, 1),
(163, 125, 1, 1),
(179, 28, 1, 1),
(179, 29, 1, 1),
(179, 59, 1, 1),
(188, 6, 1, 1),
(188, 97, 1, 1),
(197, 8, 1, 1),
(219, 48, 1, 1),
(219, 99, 1, 1),
(221, 45, 1, 1),
(226, 9, 1, 1),
(226, 60, 1, 1),
(226, 61, 1, 1),
(226, 62, 1, 1),
(226, 103, 1, 1),
(226, 123, 1, 1),
(226, 124, 1, 1),
(230, 126, 1, 1),
(230, 127, 1, 1),
(230, 128, 1, 1),
(230, 129, 1, 1),
(235, 134, 1, 1),
(235, 135, 1, 1),
(243, 98, 1, 1),
(243, 100, 1, 1),
(243, 105, 1, 1),
(243, 145, 1, 1),
(243, 146, 1, 1),
(243, 147, 1, 1),
(243, 148, 1, 1),
(243, 149, 1, 1),
(248, 7, 1, 1),
(248, 12, 1, 1),
(248, 50, 1, 1),
(248, 151, 1, 1),
(248, 152, 1, 1),
(249, 117, 1, 1),
(249, 118, 1, 1),
(249, 130, 1, 1),
(249, 131, 1, 1),
(249, 132, 1, 1),
(249, 137, 1, 1),
(249, 138, 1, 1),
(249, 139, 1, 1),
(249, 140, 1, 1),
(249, 141, 1, 1),
(249, 142, 1, 1),
(249, 143, 1, 1),
(249, 144, 1, 1),
(251, 17, 1, 1),
(252, 122, 1, 1),
(252, 150, 1, 1),
(6, 1, 1, 2),
(6, 4, 1, 2),
(25, 25, 1, 2),
(27, 32, 1, 2),
(35, 33, 1, 2),
(41, 20, 1, 2),
(42, 14, 1, 2),
(146, 2, 1, 2),
(146, 26, 1, 2),
(162, 21, 1, 2),
(179, 0, 1, 2),
(179, 15, 1, 2),
(197, 9, 1, 2),
(219, 100, 1, 2),
(219, 105, 1, 2),
(220, 99, 1, 2),
(221, 145, 1, 2),
(248, 13, 1, 2),
(248, 16, 1, 2),
(249, 61, 1, 2),
(249, 125, 1, 2),
(249, 126, 1, 2),
(249, 127, 1, 2),
(249, 128, 1, 2),
(251, 30, 1, 2),
(251, 48, 1, 2),
(252, 6, 1, 2),
(252, 7, 1, 2),
(252, 8, 1, 2),
(252, 50, 1, 2),
(4, 1, 1, 3),
(4, 4, 1, 3),
(25, 21, 1, 3),
(28, 32, 1, 3),
(36, 33, 1, 3),
(43, 14, 1, 3),
(220, 100, 1, 3),
(220, 105, 1, 3),
(221, 99, 1, 3),
(230, 9, 1, 3),
(248, 8, 1, 3),
(30, 32, 1, 4),
(37, 33, 1, 4),
(188, 14, 1, 4),
(194, 1, 1, 4),
(194, 4, 1, 4),
(221, 100, 1, 4),
(235, 9, 1, 4),
(252, 21, 1, 4),
(19, 9, 1, 5),
(31, 32, 1, 5),
(163, 14, 1, 5),
(198, 1, 1, 5),
(32, 32, 1, 6),
(163, 9, 1, 6),
(248, 14, 1, 6),
(33, 32, 1, 7),
(248, 9, 1, 7),
(40, 32, 1, 8),
(179, 9, 1, 8),
(41, 32, 1, 9),
(249, 9, 1, 9),
(42, 32, 1, 10),
(251, 9, 1, 10),
(43, 32, 1, 11),
(252, 9, 1, 11),
(44, 32, 1, 12),
(188, 9, 1, 12),
(45, 32, 1, 13),
(47, 32, 1, 14),
(46, 32, 1, 15),
(48, 32, 1, 16),
(49, 32, 1, 17),
(50, 32, 1, 18),
(51, 32, 1, 19),
(52, 32, 1, 20),
(53, 32, 1, 21),
(55, 32, 1, 22),
(138, 32, 1, 23),
(139, 32, 1, 24);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
