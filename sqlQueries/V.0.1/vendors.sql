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

/*Table structure for table `ps_vendor_product_mapping` */

DROP TABLE IF EXISTS `ps_vendor_product_mapping`;

CREATE TABLE `ps_vendor_product_mapping` (
  `id` int(235) NOT NULL AUTO_INCREMENT,
  `id_product_reference` int(235) DEFAULT NULL,
  `id_vendor` int(235) DEFAULT NULL,
  `product_price` int(10) DEFAULT NULL,
  `status` int(2) DEFAULT '1' COMMENT '0- not active 1 active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `ps_vendors` */

DROP TABLE IF EXISTS `ps_vendors`;

CREATE TABLE `ps_vendors` (
  `id_vendor` int(235) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(235) NOT NULL,
  `vendor_address` text,
  `vendor_email` varchar(235) DEFAULT NULL,
  `vendor_mobile` varchar(12) DEFAULT NULL,
  `vendor_credit` smallint(2) DEFAULT '0' COMMENT '0-credit not available 1- available',
  `vendor_delivery` smallint(2) DEFAULT '0' COMMENT '0-delivery not available 1- available',
  `vendor_tin_no` varchar(20) DEFAULT NULL,
  `vendor_cst_no` varchar(20) DEFAULT NULL,
  `vendor_preference` smallint(5) DEFAULT NULL,
  `vendor_active` smallint(2) DEFAULT '1' COMMENT '0-non active 1- active',
  PRIMARY KEY (`id_vendor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
