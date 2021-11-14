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

/*Table structure for table `kob_payment_group_map` */

DROP TABLE IF EXISTS `kob_payment_group_map`;

CREATE TABLE `kob_payment_group_map` (
  `id_default_group` int(11) NOT NULL DEFAULT '0',
  `id_payment` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_payment`,`id_default_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_payment_group_map` */

 
/*Table structure for table `kob_payment_option_master` */

DROP TABLE IF EXISTS `kob_payment_option_master`;

CREATE TABLE `kob_payment_option_master` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `Payment Name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_payment`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `kob_payment_option_master` */

insert  into `kob_payment_option_master`(`id_payment`,`Payment Name`) values (1,'CASH ON DELIVERY'),(2,'CHEQUE'),(3,'NEFT/RTGS'),(4,'EBS'),(5,'PLACE ORDER');

/*Table structure for table `kob_relationship_manager` */



/*Data for the table `kob_relationship_manager` */



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/* One column is added for relationship manager*/

ALTER TABLE kob_customer
ADD id_relationship_manager INT