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
(1, 1, 1, NULL, NULL, 'Procure / Buy', 'Procure'),
(2, 1, 1, NULL, NULL, 'Orders', 'Orders'),
(3, 1, 1, NULL, NULL, 'Reports', 'Reports'),
(4, 1, 1, NULL, NULL, 'Invoices', 'Invoices'),
(5, 1, 1, NULL, NULL, 'Approvals', 'Approvals'),
(6, 1, 1, NULL, NULL, 'Deals', 'Deals'),
(7, 1, 1, NULL, NULL, 'Services', 'Services'),
(8, 1, 1, NULL, NULL, 'Settings', 'Settings'),
(9, 1, 1, NULL, NULL, 'Loyalty Pints', 'LoyaltyPoints'),
(10, 1, 1, NULL, NULL, 'Order Status – Dashboard', 'OrderStatus'),
(11, 1, 1, NULL, NULL, 'Approvals – Dashboard', 'Approvals'),
(12, 1, 1, NULL, NULL, 'Top Categories – Dashboard', 'TopCategories'),
(13, 1, 1, NULL, NULL, 'Top 4 Products – Dashboard', 'Top4Products'),
(14, 1, 1, NULL, NULL, 'Dashboard', 'Dashboard');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
