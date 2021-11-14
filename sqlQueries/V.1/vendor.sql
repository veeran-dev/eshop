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

/*Table structure for table `kob_vendor` */

DROP TABLE IF EXISTS `kob_vendor`;

CREATE TABLE `kob_vendor` (
  `id_vendor` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tin` varchar(40) DEFAULT NULL,
  `cst` varchar(40) DEFAULT NULL,
  `id_payment` int(255) DEFAULT NULL,
  `credit_days` int(20) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `replacement` smallint(2) DEFAULT '0' COMMENT '0-No replacement 1-replacement available',
  `id_default_poc` int(255) NOT NULL,
  `id_default_address` int(255) NOT NULL,
  `id_vendor_category` int(255) DEFAULT NULL,
  `comments` tinytext,
  `active` smallint(2) DEFAULT '1' COMMENT '0-No delivery,1- delivery option available',
  `delivery` smallint(2) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vendor`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

/*ALTER query for the table `kob_vendor` */
ALTER  TABLE  kob_vendor
ADD FULLTEXT (NAME)

ALTER  TABLE  kob_category_lang
ADD FULLTEXT (NAME)

ALTER TABLE `kob_vendor`
ADD COLUMN pan VARCHAR(255)
AFTER cst 

ALTER TABLE `kob_vendor`
ADD COLUMN phone VARCHAR(255)
AFTER pan 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
