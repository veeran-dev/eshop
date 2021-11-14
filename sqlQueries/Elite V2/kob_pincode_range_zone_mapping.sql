-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 10, 2017 at 05:34 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 7.1.8-2+ubuntu14.04.1+deb.sury.org+4

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
-- Table structure for table `kob_pincode_range_zone_mapping`
--

CREATE TABLE IF NOT EXISTS `kob_pincode_range_zone_mapping` (
  `zone_id` int(10) unsigned NOT NULL,
  `zone_pin_start` varchar(6) DEFAULT NULL,
  `zone_pin_end` varchar(6) DEFAULT NULL,
  `comment` varchar(64) DEFAULT 'NULL',
  UNIQUE KEY `zone_id` (`zone_id`,`zone_pin_start`,`zone_pin_end`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kob_pincode_range_zone_mapping`
--

INSERT INTO `kob_pincode_range_zone_mapping` (`zone_id`, `zone_pin_start`, `zone_pin_end`, `comment`) VALUES
(1, '000000', '000000', 'PAN India'),
(2, '560001', '560104', 'Bengaluru'),
(3, '500001', '501301', 'Hyderabad'),
(9, '600000', '600180', 'Chennai'),
(6, '110001', '110096', 'New Delhi'),
(5, '400001', '401703', 'Mumbai'),
(5, '411001', '411053', 'Pune'),
(6, '201301', '201301', 'Noida'),
(6, '122001', '122001', 'Gurugram');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
