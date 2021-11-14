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

/*Table structure for table `kob_customer_address` */

DROP TABLE IF EXISTS `kob_customer_address`;

CREATE TABLE `kob_customer_address` (
  `id_customer` int(11) NOT NULL,
  `id_address` int(11) NOT NULL,
  PRIMARY KEY (`id_customer`,`id_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_customer_address` */

/*Table structure for table `kob_customer_parent` */

DROP TABLE IF EXISTS `kob_customer_parent`;

CREATE TABLE `kob_customer_parent` (
  `id_customer` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  PRIMARY KEY (`id_customer`,`id_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_customer_parent` */

/*Table structure for table `kob_customer_role` */

DROP TABLE IF EXISTS `kob_customer_role`;

CREATE TABLE `kob_customer_role` (
  `id_customer` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_customer`,`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_customer_role` */

/*Table structure for table `kob_role_master` */

DROP TABLE IF EXISTS `kob_role_master`;

CREATE TABLE `kob_role_master` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_role_master` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
