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

/*Table structure for table `kob_purchase_list` */

DROP TABLE IF EXISTS `kob_purchase_list`;

CREATE TABLE `kob_purchase_list` (
  `id_pur_list` int(255) NOT NULL AUTO_INCREMENT,
  `id_customer` int(255) NOT NULL,
  `list_name` varchar(255) NOT NULL,
  `list_active` smallint(2) NOT NULL DEFAULT '1' COMMENT '0-inactive, 1- active',
  `list_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `list_updated` date DEFAULT NULL,
  `list_status` int(3) DEFAULT '0' COMMENT '0-not started,1-inprogress,2-completed',
  PRIMARY KEY (`id_pur_list`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_purchase_list` */

/*Table structure for table `kob_rate_contract` */

DROP TABLE IF EXISTS `kob_rate_contract`;
CREATE TABLE IF NOT EXISTS `kob_rate_contract` (
  `id_rate_contract` int(255) NOT NULL AUTO_INCREMENT,
  `id_customer` int(255) NOT NULL,
  `id_product` int(255) NOT NULL,
  `id_product_attribute` int(10) NOT NULL,
  `active` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_rate_contract`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;



/*Table structure for table `kob_rate_contract_list_mapping` */

DROP TABLE IF EXISTS `kob_rate_contract_list_mapping`;
CREATE TABLE IF NOT EXISTS `kob_rate_contract_list_mapping` (
  `id_rate_contract` int(15) NOT NULL,
  `id_pur_list` int(15) NOT NULL,
  `product_quantity` int(15) DEFAULT '0',
  `active` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_rate_contract`,`id_pur_list`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_rate_contract_list_mapping` */

