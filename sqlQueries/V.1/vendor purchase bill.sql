/*
SQLyog Ultimate v10.42 
MySQL - 5.5.8-log : Database - kobstereshop
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

/*Table structure for table `kob_vendor_purchase_bill` */

DROP TABLE IF EXISTS `kob_vendor_purchase_bill`;

CREATE TABLE `kob_vendor_purchase_bill` (
  `id_vendor_purchase` int(255) NOT NULL AUTO_INCREMENT,
  `id_vendor` int(255) NOT NULL,
  `id_bill_no` varchar(255) NOT NULL,
  `id_product` int(255) NOT NULL,
  `bill_date` date NOT NULL,
  `product_qty` varchar(255) NOT NULL,
  `unit_price` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `tax` enum('1','2','3') NOT NULL COMMENT '1-0 tax value,2-5% tax,3-14.5% tax',
  `active` smallint(2) DEFAULT '1' COMMENT '0-not active, 1 active',
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vendor_purchase`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
