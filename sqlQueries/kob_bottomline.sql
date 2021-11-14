-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2018 at 06:50 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kobstereshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `kob_bottomline`
--

CREATE TABLE `kob_bottomline` (
  `id_line` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `id_country` int(10) UNSIGNED NOT NULL,
  `email` varchar(128) NOT NULL,
  `designation` varchar(128) NOT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kob_bottomline`
--
ALTER TABLE `kob_bottomline`
  ADD PRIMARY KEY (`id_line`),
  ADD KEY `fk_bottomline_id_country_idx` (`id_country`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kob_bottomline`
--
ALTER TABLE `kob_bottomline`
  MODIFY `id_line` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `kob_bottomline`
--
ALTER TABLE `kob_bottomline`
  ADD CONSTRAINT `fk_bottomline_id_country` FOREIGN KEY (`id_country`) REFERENCES `kob_country` (`id_country`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
