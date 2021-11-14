-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2016 at 06:36 PM
-- Server version: 5.5.52-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

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
-- Table structure for table `kob_notification_user`
--

CREATE TABLE IF NOT EXISTS `kob_notification_user` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) unsigned NOT NULL DEFAULT '0',
  `id_notification_type` int(11) NOT NULL,
  `content` text,
  `url` text,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_notification`),
  KEY `id_notification_type` (`id_notification_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kob_notification_user`
--
ALTER TABLE `kob_notification_user`
  ADD CONSTRAINT `kob_notification_user_ibfk_1` FOREIGN KEY (`id_notification_type`) REFERENCES `kob_notification_type_master` (`id_notification_type`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
