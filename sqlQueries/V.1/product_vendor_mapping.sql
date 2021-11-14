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

/*Table structure for table `kob_product_vendor_mapping` */

DROP TABLE IF EXISTS `kob_product_vendor_mapping`;

CREATE TABLE `kob_product_vendor_mapping` (
  `id_product` int(255) NOT NULL,
  `id_vendor` int(255) NOT NULL,
  `id_address` int(255) DEFAULT NULL,
  `id_poc` int(255) DEFAULT NULL,
  `id_vendor_category` int(255) DEFAULT NULL,
  `id_category` int(255) DEFAULT NULL,
  PRIMARY KEY (`id_product`,`id_vendor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_product_vendor_mapping` */


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
