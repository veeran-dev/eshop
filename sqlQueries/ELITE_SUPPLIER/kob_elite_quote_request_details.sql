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
-- Table structure for table `kob_elite_quote_request_details`
--

DROP TABLE IF EXISTS `kob_elite_quote_request_details`;
CREATE TABLE IF NOT EXISTS `kob_elite_quote_request_details` (
  `id_quote_request` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `period` int(11) NOT NULL COMMENT 'Regular / One time',
  `frequency` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `need` tinyint(4) NOT NULL,
  `deadline` date NOT NULL,
  `payment` int(11) NOT NULL,
  `postcode` int(6) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_quote_request`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kob_elite_quote_request_details`
--

INSERT INTO `kob_elite_quote_request_details` (`id_quote_request`, `id_product`, `period`, `frequency`, `quantity`, `need`, `deadline`, `payment`, `postcode`, `date_add`) VALUES
(1, 0, 0, '1', 100, 1, '0000-00-00', 0, 0, '2019-08-27 08:39:17'),
(2, 0, 0, '1', 100, 1, '0000-00-00', 0, 0, '2019-08-27 08:39:32'),
(3, 0, 0, '1', 100, 1, '0000-00-00', 0, 0, '2019-08-27 08:45:21'),
(4, 0, 0, '1', 100, 1, '0000-00-00', 0, 0, '2019-08-27 08:48:55'),
(5, 0, 0, '1', 100, 1, '0000-00-00', 0, 0, '2019-08-27 08:50:59'),
(6, 0, 1, 'weekly', 100, 1, '2019-11-07', 0, 0, '2019-08-27 09:26:18'),
(7, 0, 1, 'weekly', 100, 1, '2019-08-31', 0, 0, '2019-08-27 09:27:10'),
(8, 1, 1, 'monthly', 400, 1, '2019-08-31', 2, 600089, '2019-08-27 09:29:41'),
(9, 1, 2, '', 450, 2, '2019-08-31', 0, 0, '2019-08-29 11:48:44'),
(10, 1, 2, '', 450, 2, '2019-08-31', 0, 0, '2019-08-29 11:54:35'),
(11, 1, 2, '', 120, 2, '2019-11-30', 0, 600016, '2019-08-29 13:44:30'),
(12, 1, 2, '', 8000, 2, '2019-12-26', 0, 600089, '2019-08-29 13:55:12'),
(13, 1, 2, '', 8000, 2, '2019-12-26', 5, 600089, '2019-08-29 14:04:40'),
(14, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:15:34'),
(15, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:15:37'),
(16, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:16:54'),
(17, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:17:07'),
(18, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:17:11'),
(19, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:17:13'),
(20, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:17:16'),
(21, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:17:19'),
(22, 1, 2, '', 100, 2, '2019-12-31', 2, 600089, '2019-08-29 14:17:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
