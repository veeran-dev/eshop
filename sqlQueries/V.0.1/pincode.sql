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

/*Table structure for table `kob_pincode_master` */

DROP TABLE IF EXISTS `kob_pincode_master`;

CREATE TABLE `kob_pincode_master` (
  `zone_id` int(255) NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(255) DEFAULT NULL,
  `zone_state` varchar(255) DEFAULT NULL,
  `zone_pin_start` varchar(10) DEFAULT NULL,
  `zone_pin_end` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`zone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*ALTER query for the table `kob_pincode_master` */

ALTER TABLE `kob_pincode_master`
ADD COLUMN cash_on_delivery SMALLINT(2) DEFAULT '0' COMMENT '0-Not available,1- COD available'
AFTER zone_pin_end

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
