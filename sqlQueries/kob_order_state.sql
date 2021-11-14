-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2015 at 01:04 PM
-- Server version: 5.5.42-cll
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
-- Table structure for table `kob_order_state`
--

CREATE TABLE IF NOT EXISTS `kob_order_state` (
  `id_order_state` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` tinyint(1) unsigned DEFAULT '0',
  `send_email` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `color` varchar(32) DEFAULT NULL,
  `unremovable` tinyint(1) unsigned NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `logable` tinyint(1) NOT NULL DEFAULT '0',
  `delivery` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_order_state`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `kob_order_state`
--

INSERT INTO `kob_order_state` (`id_order_state`, `invoice`, `send_email`, `color`, `unremovable`, `hidden`, `logable`, `delivery`, `deleted`) VALUES
(1, 0, 1, '#ffffc5', 1, 1, 0, 0, 1),
(2, 0, 1, '#ddeeff', 1, 1, 0, 0, 1),
(3, 0, 1, '#FFDD99', 1, 0, 0, 0, 1),
(4, 0, 1, '#EEDDFF', 1, 0, 0, 1, 0),
(5, 0, 1, '#DDFFAA', 1, 0, 0, 1, 0),
(6, 0, 1, '#DADADA', 1, 0, 0, 0, 0),
(7, 1, 1, '#FFFFBB', 1, 0, 0, 0, 0),
(8, 0, 1, '#ffdfdf', 1, 1, 0, 0, 1),
(9, 0, 0, '#FFD3D3', 1, 1, 0, 0, 0),
(10, 0, 1, '#d9f3ff', 1, 1, 0, 0, 1),
(11, 0, 0, '#c9ffe8', 1, 1, 0, 0, 1),
(12, 0, 0, '#ddeeff', 1, 1, 1, 0, 1),
(13, 0, 0, '#33FF99', 0, 0, 0, 0, 1),
(14, 0, 0, '#33FF99', 0, 0, 0, 0, 1),
(15, 1, 0, '#33FF99', 0, 0, 0, 0, 1),
(16, 0, 0, '#33FF99', 0, 0, 0, 0, 1),
(17, 1, 0, '#96ffb5', 0, 0, 1, 0, 1),
(18, 0, 0, '#ffa358', 0, 0, 0, 0, 0),
(19, 0, 0, '#9eff99', 0, 0, 0, 0, 0),
(20, 0, 0, '#b1baff', 0, 0, 0, 0, 1),
(21, 0, 0, '#ff9383', 0, 0, 0, 0, 0),
(22, 0, 0, '#ff647b', 0, 0, 0, 0, 0),
(23, 0, 0, '#e17300', 0, 1, 0, 0, 0),
(24, 0, 0, '#ffade3', 0, 1, 0, 0, 0),
(25, 1, 0, '#f3ffd8', 0, 1, 1, 0, 0),
(26, 0, 0, '#33FF99', 0, 0, 0, 0, 0),
(27, 0, 0, '#33FF99', 0, 0, 0, 0, 0),
(28, 0, 0, '#dbe400', 0, 0, 0, 0, 0),
(29, 0, 0, '#5ec000', 0, 0, 0, 0, 0),
(30, 0, 0, '#ffa8e7', 0, 0, 0, 0, 0),
(31, 0, 0, '#cdc300', 0, 0, 0, 0, 0),
(32, 0, 0, '#77abff', 0, 0, 0, 0, 0),
(33, 0, 0, '', 0, 0, 0, 0, 0),
(34, 0, 0, '#ffbd91', 0, 0, 0, 0, 0),
(35, 0, 0, '#ff6df4', 0, 0, 0, 0, 0),
(36, 0, 0, '#00ff00', 0, 0, 0, 0, 0),
(37, 0, 0, '#ffd0c8', 0, 0, 0, 0, 0),
(38, 0, 0, '', 0, 0, 0, 0, 0),
(39, 0, 0, '#f496ff', 0, 1, 0, 0, 0),
(40, 0, 0, '', 0, 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
