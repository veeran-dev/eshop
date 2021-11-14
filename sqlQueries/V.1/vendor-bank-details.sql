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

/*Table structure for table `kob_vendor_bank_details` */

DROP TABLE IF EXISTS `kob_vendor_bank_details`;

CREATE TABLE `kob_vendor_bank_details` (
  `id_bank` int(255) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `branch_address` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `id_vendor` int(255) DEFAULT NULL,
  `id_address` int(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_upd` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bank`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*ALTER query for the table `kob_vendor_bank_details` */

 ALTER TABLE kob_vendor_bank_details 
 MODIFY branch_address TEXT
 
 ALTER TABLE kob_vendor_bank_details
ADD COLUMN active SMALLINT(2) DEFAULT '1' COMMENT '0-No delivery,1- delivery option available'
AFTER date_upd 

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
