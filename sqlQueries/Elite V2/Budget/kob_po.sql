-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2017 at 04:03 PM
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
-- Table structure for table `kob_po`
--

CREATE TABLE IF NOT EXISTS `kob_po` (
  `id_purchase_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `po_number` varchar(128) DEFAULT NULL,
  `po_date` date NOT NULL,
  `uploaded_by` int(11) unsigned DEFAULT NULL,
  `valid_from` datetime NOT NULL,
  `valid_through` datetime NOT NULL,
  `date_add` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_purchase_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
