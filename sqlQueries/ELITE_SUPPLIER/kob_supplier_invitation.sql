-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2019 at 11:30 AM
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
-- Table structure for table `kob_supplier_invitation`
--

DROP TABLE IF EXISTS `kob_supplier_invitation`;
CREATE TABLE IF NOT EXISTS `kob_supplier_invitation` (
  `id_invitation` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(6) NOT NULL,
  `enterprise_name` varchar(60) NOT NULL,
  `enterprise_email` varchar(60) NOT NULL,
  `contact_person` varchar(60) NOT NULL,
  `contact_mobile` varchar(12) NOT NULL,
  `city` varchar(10) NOT NULL,
  `category` varchar(10) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_invitation`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kob_supplier_invitation`
--

INSERT INTO `kob_supplier_invitation` (`id_invitation`, `id_customer`, `enterprise_name`, `enterprise_email`, `contact_person`, `contact_mobile`, `city`, `category`, `date_add`) VALUES
(1, 49, 'kobster.com', 'veeran.ambalam@gmail.com', 'Balakrishnan ambalam', '984272238', '2', '3,4', '2019-12-18 11:19:12'),
(2, 49, 'kobster.com', 'veeran.ambalam@gmail.com', 'Balakrishnan ambalam', '2147483647', '2', '3,11', '2019-12-18 11:23:30'),
(3, 49, 'Kobster E Shop Pvt Ltd', 'veeran.b@kobster.com', 'veeran', '2147483647', '3', '3', '2019-12-18 11:24:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
