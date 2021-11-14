-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2017 at 03:51 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 7.1.9-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kobstereshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `kob_widget_lang`
--

CREATE TABLE IF NOT EXISTS `kob_widget_lang` (
  `id_widget` int(10) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL DEFAULT '1',
  `id_lang` int(10) unsigned NOT NULL,
  `description` text,
  `description_short` text,
  `name` varchar(128) NOT NULL,
  `technical_name` varchar(128) NOT NULL,
  PRIMARY KEY (`id_widget`,`id_shop`,`id_lang`),
  UNIQUE KEY `id_widget` (`id_widget`,`id_shop`,`id_lang`),
  KEY `id_lang` (`id_lang`),
  KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`),
  FULLTEXT KEY `name_3` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kob_widget_lang`
--

INSERT INTO `kob_widget_lang` (`id_widget`, `id_shop`, `id_lang`, `description`, `description_short`, `name`, `technical_name`) VALUES
(19, 1, 1, 'View PO History', 'View PO History', 'View PO History', 'ViewPo');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
