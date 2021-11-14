-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2016 at 05:31 PM
-- Server version: 5.5.52-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kobster2`
--

-- --------------------------------------------------------

--
-- Table structure for table `kob_widget`
--

CREATE TABLE IF NOT EXISTS `kob_widget` (
  `id_widget` int(11) NOT NULL AUTO_INCREMENT,
  `is_default` tinyint(2) NOT NULL DEFAULT '0',
  `is_dashboard` tinyint(2) NOT NULL DEFAULT '0',
  `id_role` tinyint(5) DEFAULT '0',
  `price` decimal(20,6) NOT NULL,
  `ratings` tinyint(6) NOT NULL DEFAULT '0',
  `active` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_widget`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kob_widget`
--

INSERT INTO `kob_widget` (`id_widget`, `is_default`, `is_dashboard`, `id_role`, `price`, `ratings`, `active`) VALUES
(1, 0, 0, 0, 0.000000, 0, 1),
(2, 0, 0, 3, 0.000000, 0, 1),
(3, 0, 0, 2, 10.000000, 4, 1),
(4, 0, 0, 2, 0.000000, 0, 1),
(5, 0, 0, 2, 0.000000, 0, 1),
(6, 0, 0, 2, 0.000000, 0, 1),
(7, 0, 0, 1, 0.000000, 0, 1),
(8, 0, 0, 0, 0.000000, 0, 1),
(9, 0, 0, 0, 0.000000, 0, 1),
(10, 1, 1, 0, 0.000000, 0, 1),
(11, 0, 1, 2, 0.000000, 0, 1),
(12, 1, 1, 0, 0.000000, 0, 1),
(13, 1, 1, 2, 0.000000, 0, 1),
(14, 0, 0, 2, 0.000000, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
