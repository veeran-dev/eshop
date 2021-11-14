/*
SQLyog Ultimate v10.42 
MySQL - 5.6.12-log : Database - kobstereshop
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kobstereshop` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `kobstereshop`;

/*Table structure for table `kob_vendor_address` */

DROP TABLE IF EXISTS `kob_vendor_address`;

CREATE TABLE `kob_vendor_address` (
  `id_address` int(255) NOT NULL AUTO_INCREMENT,
  `id_vendor` int(255) NOT NULL,
  `address1` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `id_state` int(10) NOT NULL,
  `country` int(10) NOT NULL,
  `pincode` int(255) NOT NULL,
  `phone` int(15) DEFAULT NULL,
  `fax` int(15) DEFAULT NULL,
  `delivery` smallint(2) DEFAULT NULL COMMENT '0-No delivery,1- delivery option available',
  `working_hour` text,
  `working_days` text,
  `comments` text,
  `active` smallint(2) NOT NULL DEFAULT '1',
  `alise` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Alter query for the table `kob_vendor_address` */

ALTER TABLE `kob_vendor_address`
ADD COLUMN landmark VARCHAR(255)
AFTER pincode 

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
