-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 29, 2019 at 07:45 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kobster_elite`
--

-- --------------------------------------------------------

--
-- Table structure for table `kob_elite_quote_request`
--

DROP TABLE IF EXISTS `kob_elite_quote_request`;
CREATE TABLE IF NOT EXISTS `kob_elite_quote_request` (
  `id_quote_request` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `denied` tinyint(1) NOT NULL,
  `price` float NOT NULL,
  `expiry` date NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_quote_request`,`id_customer`,`id_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kob_elite_quote_request`
--

INSERT INTO `kob_elite_quote_request` (`id_quote_request`, `id_customer`, `id_supplier`, `denied`, `price`, `expiry`, `date_add`) VALUES
(8, 49, 1, 0, 2323, '2019-08-30', '2019-08-27 09:29:41'),
(9, 49, 1, 0, 555, '2019-09-11', '2019-08-29 11:48:44'),
(10, 49, 1, 0, 750, '2019-08-30', '2019-08-29 11:54:35'),
(11, 49, 1, 0, 0, '0000-00-00', '2019-08-29 13:44:30'),
(12, 49, 1, 0, 0, '0000-00-00', '2019-08-29 13:55:12'),
(13, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:04:40'),
(14, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:15:34'),
(15, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:15:37'),
(16, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:16:54'),
(17, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:17:07'),
(18, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:17:11'),
(19, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:17:14'),
(20, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:17:16'),
(21, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:17:19'),
(22, 49, 1, 0, 0, '0000-00-00', '2019-08-29 14:17:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
