-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2016 at 05:32 PM
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
-- Table structure for table `kob_widget_user`
--

CREATE TABLE IF NOT EXISTS `kob_widget_user` (
  `id_widget` int(10) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL DEFAULT '0',
  `is_paid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0 - Free, 1 - Paid, 2 - Not Paid',
  `position` int(10) DEFAULT NULL,
  `active` tinyint(2) DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_widget`,`id_user`),
  UNIQUE KEY `id_widget` (`id_widget`,`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kob_widget_user`
--

INSERT INTO `kob_widget_user` (`id_widget`, `id_user`, `is_paid`, `position`, `active`, `date_add`, `date_upd`) VALUES
(10, 4349, 0, 0, 1, '2016-09-21 13:35:30', '2016-09-21 13:35:30'),
(11, 4349, 0, 0, 0, '2016-09-23 16:38:25', '2016-09-23 16:38:25'),
(14, 4349, 0, 0, 1, '2016-09-23 14:15:50', '2016-09-23 14:15:50'),
(7, 4349, 0, 0, 1, '2016-09-23 14:02:15', '2016-09-23 14:02:15'),
(1, 4349, 0, 0, 1, '2016-09-23 13:57:56', '2016-09-23 13:57:56'),
(3, 4349, 0, 0, 0, '2016-09-23 13:48:45', '2016-09-23 13:48:45'),
(8, 4349, 0, 0, 1, '2016-09-23 13:15:20', '2016-09-23 13:15:20'),
(6, 4349, 0, 0, 1, '2016-09-23 12:12:33', '2016-09-23 12:12:33'),
(5, 4349, 0, 0, 1, '2016-09-23 17:23:10', '2016-09-23 17:23:10'),
(2, 4349, 0, 0, 1, '2016-09-23 13:02:32', '2016-09-23 13:02:32'),
(12, 4349, 0, 0, 1, '2016-09-23 16:38:27', '2016-09-23 16:38:27'),
(13, 4349, 0, 0, 1, '2016-09-23 16:38:56', '2016-09-23 16:38:56'),
(4, 4349, 0, 0, 0, '2016-09-23 17:14:00', '2016-09-23 17:14:00'),
(1, 48, 0, 0, 1, '2016-09-24 12:12:46', '2016-09-24 12:12:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
