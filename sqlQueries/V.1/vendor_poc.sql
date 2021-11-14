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

/*Table structure for table `kob_vendor_poc` */

DROP TABLE IF EXISTS `kob_vendor_poc`;

CREATE TABLE `kob_vendor_poc` (
  `id_poc` int(255) NOT NULL AUTO_INCREMENT,
  `id_vendor` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `phone1` int(255) DEFAULT NULL,
  `phone2` int(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `smart_phone` smallint(2) DEFAULT '0' COMMENT '1-customer using smartphone 0-not using smartphone',
  `comments` text,
  `active` smallint(2) DEFAULT '1' COMMENT '0-No delivery,1- delivery option available',
  `date_add` datetime DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_poc`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

/*ALTER query for the table `kob_vendor_poc` */

ALTER TABLE `kob_vendor_poc`
ADD COLUMN designation VARCHAR(255)
AFTER firstname 

ALTER TABLE `kob_vendor_poc`
ADD COLUMN id_address INT(255)
AFTER firstname 

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
