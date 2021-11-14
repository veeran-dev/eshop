/*
SQLyog Ultimate v10.42 
MySQL - 5.6.17 : Database - kobstereshop
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

/*Table structure for table `kob_price_history` */

DROP TABLE IF EXISTS `kob_price_history`;

CREATE TABLE `kob_price_history` (
  `id_change_price` int(10) NOT NULL AUTO_INCREMENT,
  `id_product` int(10) NOT NULL,
  `id_group` int(10) NOT NULL,
  `old_price` decimal(17,6) NOT NULL DEFAULT '0.000000',
  `new_price` decimal(17,6) NOT NULL DEFAULT '0.000000',
  `id_employee` int(10) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_change_price`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_price_history` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
