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

/*Table structure for table `kob_access` */

DROP TABLE IF EXISTS `kob_access`;

CREATE TABLE `kob_access` (
  `id_profile` int(10) unsigned NOT NULL,
  `id_tab` int(10) unsigned NOT NULL,
  `view` int(11) NOT NULL,
  `add` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  PRIMARY KEY (`id_profile`,`id_tab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kob_access` */

LOCK TABLES `kob_access` WRITE;

insert  into `kob_access`(`id_profile`,`id_tab`,`view`,`add`,`edit`,`delete`) values (1,1,1,1,1,1),(1,2,1,1,1,1),(1,3,1,1,1,1),(1,4,1,1,1,1),(1,5,1,1,1,1),(1,6,1,1,1,1),(1,7,1,1,1,1),(1,8,1,1,1,1),(1,9,1,1,1,1),(1,10,1,1,1,1),(1,11,1,1,1,1),(1,12,1,1,1,1),(1,13,1,1,1,1),(1,14,1,1,1,1),(1,15,1,1,1,1),(1,16,1,1,1,1),(1,17,1,1,1,1),(1,18,1,1,1,1),(1,19,1,1,1,1),(1,20,1,1,1,1),(1,21,1,1,1,1),(1,22,1,1,1,1),(1,23,1,1,1,1),(1,24,1,1,1,1),(1,26,1,1,1,1),(1,27,1,1,1,1),(1,28,1,1,1,1),(1,29,1,1,1,1),(1,30,1,1,1,1),(1,31,1,1,1,1),(1,32,1,1,1,1),(1,33,1,1,1,1),(1,34,1,1,1,1),(1,35,1,1,1,1),(1,36,1,1,1,1),(1,37,1,1,1,1),(1,38,1,1,1,1),(1,39,1,1,1,1),(1,40,1,1,1,1),(1,41,1,1,1,1),(1,42,1,1,1,1),(1,43,1,1,1,1),(1,44,1,1,1,1),(1,46,1,1,1,1),(1,47,1,1,1,1),(1,48,1,1,1,1),(1,49,1,1,1,1),(1,51,1,1,1,1),(1,52,1,1,1,1),(1,53,1,1,1,1),(1,54,1,1,1,1),(1,55,1,1,1,1),(1,56,1,1,1,1),(1,57,1,1,1,1),(1,58,1,1,1,1),(1,59,1,1,1,1),(1,60,1,1,1,1),(1,61,1,1,1,1),(1,62,1,1,1,1),(1,63,1,1,1,1),(1,64,1,1,1,1),(1,65,1,1,1,1),(1,66,1,1,1,1),(1,67,1,1,1,1),(1,68,1,1,1,1),(1,69,1,1,1,1),(1,70,1,1,1,1),(1,71,1,1,1,1),(1,72,1,1,1,1),(1,73,1,1,1,1),(1,80,1,1,1,1),(1,81,1,1,1,1),(1,82,1,1,1,1),(1,83,1,1,1,1),(1,84,1,1,1,1),(1,85,1,1,1,1),(1,86,1,1,1,1),(1,87,1,1,1,1),(1,88,1,1,1,1),(1,89,1,1,1,1),(1,90,1,1,1,1),(1,91,1,1,1,1),(2,1,1,1,1,1),(2,2,1,1,1,1),(2,3,1,1,1,1),(2,4,0,0,0,0),(2,5,1,1,1,1),(2,6,0,0,0,0),(2,7,0,0,0,0),(2,8,0,0,0,0),(2,9,0,0,0,0),(2,10,0,0,0,0),(2,11,0,0,0,0),(2,12,1,1,1,1),(2,13,1,1,1,1),(2,14,0,0,0,0),(2,15,0,0,0,0),(2,16,0,0,0,0),(2,17,1,1,1,1),(2,18,0,0,0,0),(2,19,0,0,0,0),(2,20,1,1,1,1),(2,21,1,1,1,1),(2,22,0,0,0,0),(2,23,0,0,0,0),(2,24,0,0,0,0),(2,26,0,0,0,0),(2,27,0,0,0,0),(2,28,0,0,0,0),(2,29,0,0,0,0),(2,30,0,0,0,0),(2,31,0,0,0,0),(2,32,0,0,0,0),(2,33,0,0,0,0),(2,34,1,1,1,1),(2,35,0,0,0,0),(2,36,0,0,0,0),(2,37,0,0,0,0),(2,38,0,0,0,0),(2,39,0,0,0,0),(2,40,0,0,0,0),(2,41,0,0,0,0),(2,42,1,1,1,1),(2,43,0,0,0,0),(2,44,0,0,0,0),(2,46,0,0,0,0),(2,47,1,1,1,1),(2,48,0,0,0,0),(2,49,1,1,1,1),(2,51,0,0,0,0),(2,52,0,0,0,0),(2,53,0,0,0,0),(2,54,0,0,0,0),(2,55,1,1,1,1),(2,56,0,0,0,0),(2,57,0,0,0,0),(2,58,0,0,0,0),(2,59,1,1,1,1),(2,60,1,1,1,1),(2,61,0,0,0,0),(2,62,0,0,0,0),(2,63,0,0,0,0),(2,64,0,0,0,0),(2,65,0,0,0,0),(2,66,0,0,0,0),(2,67,0,0,0,0),(2,68,0,0,0,0),(2,69,0,0,0,0),(2,70,0,0,0,0),(2,71,0,0,0,0),(2,72,0,0,0,0),(2,73,1,1,1,1),(2,80,0,0,0,0),(2,81,0,0,0,0),(2,82,0,0,0,0),(2,83,0,0,0,0),(2,84,0,0,0,0),(2,85,0,0,0,0),(2,86,0,0,0,0),(2,87,0,0,0,0),(2,88,1,1,1,1),(3,1,1,1,1,1),(3,2,0,0,0,0),(3,3,0,0,0,0),(3,4,0,0,0,0),(3,5,0,0,0,0),(3,6,0,0,0,0),(3,7,0,0,0,0),(3,8,0,0,0,0),(3,9,1,0,0,0),(3,10,0,0,0,0),(3,11,0,0,0,0),(3,12,0,0,0,0),(3,13,0,0,0,0),(3,14,0,0,0,0),(3,15,0,0,0,0),(3,16,0,0,0,0),(3,17,0,0,0,0),(3,18,0,0,0,0),(3,19,0,0,0,0),(3,20,0,0,0,0),(3,21,0,0,0,0),(3,22,0,0,0,0),(3,23,0,0,0,0),(3,24,0,0,0,0),(3,26,0,0,0,0),(3,27,0,0,0,0),(3,28,0,0,0,0),(3,29,0,0,0,0),(3,30,0,0,0,0),(3,31,0,0,0,0),(3,32,1,1,1,1),(3,33,1,1,1,1),(3,34,0,0,0,0),(3,35,0,0,0,0),(3,36,0,0,0,0),(3,37,0,0,0,0),(3,38,0,0,0,0),(3,39,0,0,0,0),(3,40,0,0,0,0),(3,41,0,0,0,0),(3,42,0,0,0,0),(3,43,1,0,0,0),(3,44,0,0,0,0),(3,46,0,0,0,0),(3,47,0,0,0,0),(3,48,0,0,0,0),(3,49,0,0,0,0),(3,51,0,0,0,0),(3,52,0,0,0,0),(3,53,0,0,0,0),(3,54,0,0,0,0),(3,55,0,0,0,0),(3,56,0,0,0,0),(3,57,1,1,1,1),(3,58,0,0,0,0),(3,59,0,0,0,0),(3,60,0,0,0,0),(3,61,0,0,0,0),(3,62,0,0,0,0),(3,63,0,0,0,0),(3,64,0,0,0,0),(3,65,0,0,0,0),(3,66,0,0,0,0),(3,67,0,0,0,0),(3,68,0,0,0,0),(3,69,0,0,0,0),(3,70,0,0,0,0),(3,71,0,0,0,0),(3,72,0,0,0,0),(3,73,0,0,0,0),(3,80,0,0,0,0),(3,81,0,0,0,0),(3,82,0,0,0,0),(3,83,0,0,0,0),(3,84,0,0,0,0),(3,85,0,0,0,0),(3,86,0,0,0,0),(3,87,0,0,0,0),(3,88,1,1,1,1),(4,1,1,1,1,1),(4,2,1,1,1,1),(4,3,1,1,1,1),(4,4,0,0,0,0),(4,5,0,0,0,0),(4,6,1,1,1,1),(4,7,0,0,0,0),(4,8,0,0,0,0),(4,9,0,0,0,0),(4,10,1,0,0,0),(4,11,0,0,0,0),(4,12,1,1,1,1),(4,13,0,0,0,0),(4,14,0,0,0,0),(4,15,0,0,0,0),(4,16,0,0,0,0),(4,17,0,0,0,0),(4,18,0,0,0,0),(4,19,0,0,0,0),(4,20,0,0,0,0),(4,21,0,0,0,0),(4,22,0,0,0,0),(4,23,0,0,0,0),(4,24,0,0,0,0),(4,26,0,0,0,0),(4,27,0,0,0,0),(4,28,0,0,0,0),(4,29,0,0,0,0),(4,30,0,0,0,0),(4,31,0,0,0,0),(4,32,0,0,0,0),(4,33,0,0,0,0),(4,34,0,0,0,0),(4,35,0,0,0,0),(4,36,0,0,0,0),(4,37,0,0,0,0),(4,38,0,0,0,0),(4,39,0,0,0,0),(4,40,0,0,0,0),(4,41,0,0,0,0),(4,42,1,1,1,1),(4,43,1,0,0,0),(4,44,0,0,0,0),(4,46,0,0,0,0),(4,47,0,0,0,0),(4,48,0,0,0,0),(4,49,1,1,1,1),(4,51,0,0,0,0),(4,52,0,0,0,0),(4,53,0,0,0,0),(4,54,1,1,1,1),(4,55,0,0,0,0),(4,56,0,0,0,0),(4,57,0,0,0,0),(4,58,0,0,0,0),(4,59,1,1,1,1),(4,60,0,0,0,0),(4,61,0,0,0,0),(4,62,1,1,1,1),(4,63,1,1,1,1),(4,64,0,0,0,0),(4,65,1,1,1,1),(4,66,0,0,0,0),(4,67,0,0,0,0),(4,68,0,0,0,0),(4,69,0,0,0,0),(4,70,0,0,0,0),(4,71,0,0,0,0),(4,72,0,0,0,0),(4,73,0,0,0,0),(4,80,0,0,0,0),(4,81,0,0,0,0),(4,82,1,1,1,1),(4,83,0,0,0,0),(4,84,0,0,0,0),(4,85,0,0,0,0),(4,86,0,0,0,0),(4,87,0,0,0,0),(4,88,1,1,1,1),(5,1,1,1,1,1),(5,2,1,1,1,1),(5,3,1,1,1,1),(5,4,0,0,0,0),(5,5,0,0,0,0),(5,6,1,1,1,1),(5,7,0,0,0,0),(5,8,0,0,0,0),(5,9,0,0,0,0),(5,10,1,0,0,0),(5,11,0,0,0,0),(5,12,1,1,1,1),(5,13,0,0,0,0),(5,14,0,0,0,0),(5,15,0,0,0,0),(5,16,0,0,0,0),(5,17,0,0,0,0),(5,18,0,0,0,0),(5,19,0,0,0,0),(5,20,0,0,0,0),(5,21,0,0,0,0),(5,22,0,0,0,0),(5,23,0,0,0,0),(5,24,0,0,0,0),(5,26,0,0,0,0),(5,27,0,0,0,0),(5,28,0,0,0,0),(5,29,0,0,0,0),(5,30,0,0,0,0),(5,31,0,0,0,0),(5,32,0,0,0,0),(5,33,0,0,0,0),(5,34,0,0,0,0),(5,35,0,0,0,0),(5,36,0,0,0,0),(5,37,0,0,0,0),(5,38,0,0,0,0),(5,39,0,0,0,0),(5,40,0,0,0,0),(5,41,0,0,0,0),(5,42,1,1,1,1),(5,43,1,0,0,0),(5,44,0,0,0,0),(5,46,0,0,0,0),(5,47,0,0,0,0),(5,48,0,0,0,0),(5,49,1,1,1,1),(5,51,0,0,0,0),(5,52,0,0,0,0),(5,53,0,0,0,0),(5,54,1,1,1,1),(5,55,0,0,0,0),(5,56,0,0,0,0),(5,57,0,0,0,0),(5,58,0,0,0,0),(5,59,1,1,1,1),(5,60,0,0,0,0),(5,61,0,0,0,0),(5,62,1,1,1,1),(5,63,1,1,1,1),(5,64,0,0,0,0),(5,65,1,1,1,1),(5,66,0,0,0,0),(5,67,0,0,0,0),(5,68,0,0,0,0),(5,69,0,0,0,0),(5,70,0,0,0,0),(5,71,0,0,0,0),(5,72,0,0,0,0),(5,73,0,0,0,0),(5,80,0,0,0,0),(5,81,0,0,0,0),(5,82,1,1,1,1),(5,83,0,0,0,0),(5,84,0,0,0,0),(5,85,0,0,0,0),(5,86,0,0,0,0),(5,87,0,0,0,0),(5,88,1,1,1,1);

UNLOCK TABLES;

/*Table structure for table `kob_customer` */

DROP TABLE IF EXISTS `kob_customer`;

CREATE TABLE `kob_customer` (
  `id_customer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_gender` int(10) unsigned NOT NULL,
  `id_default_group` int(10) unsigned NOT NULL DEFAULT '1',
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `last_passwd_gen` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(2) DEFAULT '0' COMMENT '0for 2tmelogin, 1 for first time login[only for cop user]',
  `company` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT '0',
  `ip_registration_newsletter` varchar(15) DEFAULT NULL,
  `newsletter_date_add` datetime DEFAULT NULL,
  `optin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `secure_key` varchar(32) NOT NULL DEFAULT '-1',
  `note` text,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_guest` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `Id_buyer` int(2) NOT NULL,
  `id_relationship_manager` int(3) DEFAULT NULL,
  PRIMARY KEY (`id_customer`),
  KEY `customer_email` (`email`),
  KEY `customer_login` (`email`,`passwd`),
  KEY `id_customer_passwd` (`id_customer`,`passwd`),
  KEY `id_gender` (`id_gender`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `kob_customer` */

LOCK TABLES `kob_customer` WRITE;

insert  into `kob_customer`(`id_customer`,`id_gender`,`id_default_group`,`firstname`,`lastname`,`email`,`passwd`,`last_passwd_gen`,`status`,`company`,`occupation`,`mobile`,`birthday`,`newsletter`,`ip_registration_newsletter`,`newsletter_date_add`,`optin`,`secure_key`,`note`,`active`,`is_guest`,`deleted`,`date_add`,`date_upd`,`Id_buyer`,`id_relationship_manager`) values (1,1,1,'John','DOE','pub@prestashop.com','754217947dac5390883d67c864e9e20e','2014-05-07 09:53:40',0,NULL,NULL,'0','1970-01-15',1,NULL,'2014-05-07 09:53:40',1,'47ce86627c1f3c792a80773c5d2deaf8',NULL,1,0,0,'2014-01-25 12:32:49','2014-05-07 09:53:40',9,3),(2,1,1,'Sreeni','s','seenu2706@gmail.com','cc594320df4cabdfb2dd1f4fc2757e5e','2014-07-08 14:32:24',0,'kobster',NULL,'0',NULL,0,NULL,NULL,0,'47ce86627c1f3c792a80773c5d2deaf8',NULL,1,0,0,'2014-02-06 14:27:47','2014-07-08 14:35:25',2,3),(3,1,1,'Balaji',NULL,'bala@gmail.com','af53f3aa684d1bd6ae2b1285f15a61b4','2014-02-08 08:16:45',0,'cts','sys admin','1234567890',NULL,0,NULL,NULL,0,'9e5b3b025306bded9123bfa479cba9d7',NULL,1,0,0,'2014-02-08 14:16:45','2014-11-19 12:36:32',3,3),(4,1,1,'srini',NULL,'srini2706@gmail.com','cc594320df4cabdfb2dd1f4fc2757e5e','2014-05-07 09:40:07',0,'cts',NULL,'0','1990-06-27',0,NULL,NULL,0,'9e5b3b025306bded9123bfa479cba9d7',NULL,1,0,0,'2014-02-20 11:24:05','2014-05-07 09:40:07',1,3),(5,1,1,'seenu',NULL,'se2706@gmail.com','cc594320df4cabdfb2dd1f4fc2757e5e','2014-05-07 09:37:06',0,'nanonino',NULL,'0','1990-06-27',0,NULL,NULL,0,'9e5b3b025306bded9123bfa479cba9d7',NULL,1,0,0,'2014-02-20 11:24:05','2014-05-07 09:37:06',9,3),(6,1,1,'Mahesh','p','magesh@gmail.com','cc594320df4cabdfb2dd1f4fc2757e5e','2014-05-07 09:37:06',0,'kobster','developer','1234567890','1990-06-27',0,NULL,NULL,0,'9e5b3b025306bded9123bfa479cba9d7',NULL,1,0,0,'2014-02-20 11:24:05','2014-05-07 09:37:06',3,3),(7,9,1,'malai',NULL,'malai@gmail.com','cc594320df4cabdfb2dd1f4fc2757e5e','2014-12-09 09:44:00',0,NULL,NULL,'0',NULL,0,NULL,NULL,0,'4ecf1a719747637d3abc3426c0668716',NULL,1,0,0,'2014-12-09 09:44:00','2014-12-09 09:44:00',3,0);

UNLOCK TABLES;

/*Table structure for table `kob_delivery_details` */

DROP TABLE IF EXISTS `kob_delivery_details`;

CREATE TABLE `kob_delivery_details` (
  `id_delivery_details` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_delivery` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_generated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_delivery_details`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_delivery_details` */

LOCK TABLES `kob_delivery_details` WRITE;

UNLOCK TABLES;

/*Table structure for table `kob_feedback` */

DROP TABLE IF EXISTS `kob_feedback`;

CREATE TABLE `kob_feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(250) NOT NULL,
  PRIMARY KEY (`id_feedback`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

/*Data for the table `kob_feedback` */

LOCK TABLES `kob_feedback` WRITE;

insert  into `kob_feedback`(`id_feedback`,`name`,`email`,`message`) values (57,'Hitesh Dugar','hiteshdugar@yahoo.com','Nice Concept....... Best Of Luck '),(58,'Mohd Junaid','junaid.srm@gmail.com','Its really great to see such venture coming up. Its really amazing. Good to luck to whole team.\n\nAnd it will much better if you can add price ruler to the horizontal scroller of price range in each domain. :) It help people to scrutinize on exact pri'),(59,'KaarthikCR','kaarthikcr@gmail.com','Way to go bro :) kalakitinga ponga..'),(67,'senthil kumar m','senthilkumar_hce@gmail.com','1. extra-ordinary user interface.\n2. awesome cartoon sketches.\n3. huge collection of products.\n4. business idea on the outside can be rated as a 6 on 10. Its a personal opinion, since your customers(companies) switching cost from their current suppli'),(61,'VB','nicks_hon@yahoo.com','Hey,\n\nI had one product suggestion.  You guys can introduce colorful retractors/pully (the id card holder which can be hung near the waist and has an elastic, used for swiping!)\n\nI think this will be a huge hit!\n\nThanks,\nVB'),(62,'Sujitha','sujisrv@gmail.com, Sujitha.Saravanan@cognizant.com','Hey Karthik....!!! Awesome....!! Amazed to see u bringing up such a good work in short span off time... You guys really rocked..!! \nHearty wishes... n Keep rocking...!'),(64,'Raghavan','raghavanksrinivas@gmail.com','the web site is nice and i liked it\nbut the market is very less in scope may better supply  groceries which may fetch u good results this is just a suggestion'),(65,'kiruthika','amul_ras_it@yahoo.com','1) In Home page in different sections like new products, top products, top brands, etc., view all can be included\n\n2) Logins can be done with FB, twitter, etc.,\n\n'),(66,'Umesh.G.Chavan','umeshgchavan@rediffmail.com','Need to buy a punch.'),(68,'BEENA SINGH','beena.singh6@gmail.com','there are most og people use korex for addition like alcohal , its misuse of korex'),(69,'ashok','ags1977@rediffmail.com','send details'),(70,'saurav','saurav646@gmail.com','site is impressive.i think i will wrk.'),(71,'Prakash Viswanathan','pacxi.v@gmail.com','very slow user interface'),(72,'T RAMAIAH','rdma_55@yahoo.co.in','WHAT A BEAUTIFUL  OUTLET FOR ALL PURCHASES!\nLET ME SHOWER THE BLESSINGS TO GROW GLOBALLY.. BEST WISHES!'),(73,'vinay pratap singh','vinaypratap@yahoo.in','7860515842'),(74,'ARUMUGAM T','ulagusree5@gmail.com','A 4   paper wanted '),(75,'ARUMUGAM T','ulagusree5@gmail.com','A 4   paper wanted '),(76,'tammy','tchristensen425@comcast.net','i am located in the USA. I have found that I like the Maxriter pen very much, however, I can not find it here in the US. I found your webside by looking for a location in the US. You have the product that I am interrested in, but I am not familiar wi'),(77,'chris hessey','c.hessey@yahoo.com','how much is the double grimper'),(78,'anubhav','singhanubhav49@gmail.com','i found the pen dat i lngd for! thnx a lot'),(79,'shanmugam','t_shanmugam@sify.com','please send the diary where will available call 9380102681\n'),(80,'yuvaa prasath ','yuvaa.prasath25@gmail.com','good items'),(81,'HImanshu Bansal','dr.bansal1998@gmail.com','sir/madam,\nIT IS FOR YOUR KIND INFORMATION \n\ni purchased a product\n\nKOBSO1325 	Solo 3-Subjects Note Book (240 Pages) (Grey)\n\nit is very old and the diary having calendar  year 2008\n\n'),(82,'HIMANSU BANSAL','dr.bansal1998@gmail.com','sir/madam,\nIT IS FOR YOUR KIND INFORMATION \n\ni purchased a product\n\nKOBSO1325 	Solo 3-Subjects Note Book (240 Pages) (Grey)\n\nit is very old and the diary having calendar  year 2008\n\nHimanshu Bansal\n\n07838726008'),(83,'Gajula N Chandrashekar','gajula.chandrashekar@gmail.com','I ordered diaries through Kobster. I was informed that it was out of stock initially and then was advised it is being sent. The same diary ordered on Flipkart has already reached me, which I ordered post placing an order on KObster. This clearly dist'),(84,'Girish','girish.an@gmail.com','Hi , I am Girish -  Balaji\'s friend. I simply loved your website. I wish you all the best for the success of your business. I will refer this website to my circle of friends and maybe purchase of few stuff shortly.\n\nCheers\nGirish !'),(85,'ASHISH','ashishsadhuka@gmail.com','I know rate of floor mop 264 code GA 1437or your  nearest  sale point I live in Faridabad.'),(86,'ASHISH','ashishsadhuka@gmail.com','I know rate of floor mop 264 code GA 1437or your  nearest  sale point I live in Faridabad.'),(87,'adarsh','adarshjain9515@yahoo.in','i have not received my material yet.\nit\'s been 8 days .please deliver the goods as fast as possible.\nref no re-2086'),(88,'jayesh koli','jayeshjkoli@gmail.com','i purches this product 15/04/13   '),(89,'Shekhar kapur','drskhp@gmail.com','In my order No 010245 placed on  12/01/2013 22:48 I did not receive OBAPD14050 (Slim - Week at a glance - Hard Bound Black Cover - 2013 Diary worth 	Rs. 62.10 ) as it was out of stock. The amount has still not been credited to my account. Kindly do t'),(90,'md shahnwaz ansari','mdansari2222@gmail.com','this is really very good pen.i have been using it for four years, could i get it in green and black color.'),(91,'aswin from aruppukottai','rajaaswin1998@gmail.com','hi karthik anna this aswin your website amazing what about your work pls reply on rajaaswin1998@gmail.com'),(92,'ali','aliakberr@gmail.com','you just cancel the order without any hesitation, just because you have issues with your COD guys,?\nGet your backend sorted first and then do business, \nJust wasting customers time and effort.\nUseless people.'),(93,'Thoddanna Jayakrishnan','vizhijai@gmail.com','Hello kobster team,\n\nWish you all the best first.\nWhile tried for registration, I find it a bit cumbersome at two places.\n1. You are accepting beyond the max allowable characters in the alias field. Either restrict it while giving input or allow litt'),(94,'dr manish nair','drmanishnair@yahoo.co.in','Please include the option to choose the courier service by the customer during the process of confirmation of order so that customer itself can choose the courier service . some courier service are not good in some interior parts of town.'),(95,'divya','divya23726@yahoo.com','this pendrive wanted pls\n'),(96,'WAJAHAT IQBAL','kwajahat@gmail.com','this is with reference to order no 010535 placed on 4 july. it has been now almost 14 days i hv only recieved white self adhesive envolopes 25 pieces against 50. this was our first order with you and we are really disappointed with the service. pl le'),(97,'Jitendra','jitendrad@hdfc.com','Need more Variety '),(98,'kishor','brajakishorsahoo1@gmail.com','im praches hp prnter 2515 i dont Know how to sending massge plz help me'),(99,'KIRTIKUMAR PILANKAR','drpilankar@gmail.com','my part order has been delivered. What about rest of order? No one is responding. I have already made payments as well'),(100,'RADHIKA STATIONERY','radhika240412@gmail.com','Please send your quatetion  NJ MPL 01 '),(101,'PRIYADARSHINI DASH            ','iluvkittens1@gmail.com','It has been more than a week i have ordered a set of pens with order no. 010647.\n\nit has not been shipped yet. How much more time will you take? Other e commerce site like flipkart , e bay deliver within 3 - 4 days.\ncompletely disappointing.'),(102,'Santosh Balasaheb Ghadage','sbghadage@gmail.com','My Order: #010674 is cancelled and I received email on that without providing any reasons for it. What a unprofessional approach. Further, I am asked to reorder the conveniently!!!\nThanks to wake me up in time otherwise I was about to order some more'),(103,'PRIYADARSHINI DASH            ','iluvkittens1@gmail.com','I was informed that my order no 10647 will be shipped by today i.e. 10.09.2013.( i had placed the order on 30 th august and it has been 11 days.)\n\nIf there are any stock issues then i REQUEST YOU TO CANCEL MY ORDER AND REFUND MY MONEY. \nI would perma'),(104,'PRIYADARSHINI DASH            ','iluvkittens1@gmail.com','my order no 10647 was cancelled on my request.pls inform me when the amount will be refunded.'),(105,'saikiran','saikiranrayabarapus@gmail.com','6 days have passed . i dint receive any mail from courier service. any prodeuct taken online will be delivered within 3-4 days .\nbut this has taken more than 5 days .How bad the service is?'),(106,'','',''),(107,'','',''),(108,'','',''),(109,'','',''),(110,'Pratiyush','pratiyush1@gmail.com','http://www.mouthshut.com/review/Kobster-com-review-ptoosppttr\n\nPut some more reviews here.'),(111,'CH. Sreeram','sreeramch_70@rediff.com','I have purchased 1016 punching (Single) machine however, I am unable to use the same properly. Also, the Super dealer M/s. Aswini stationary shop did not give me a sealed piece and also the user manual. I am unable to use the same professionally. Kin'),(112,'Atif M Ali	','sudapost2000@gmail.com','Hi good day, please send samples pens and pens catalogue to my postal address:\nAtif M Ali	\nSUDAPOST COMPANY\nP.O.BOX 11191\nKHARTOUM 11111\nSUDAN\nMobile phone: 00249903890960\n\nBest regards\nAtif M Ali	\n\n'),(113,'ramesh','ramesh.ramamurthy@aloftchennaiomr.com','login today '),(114,'Ramakrishnan','lokeshtraders13@gmail.com','origami plates invoice and wholesale price for trade'),(115,'Ramakrishnan','lokeshtraders13@gmail.com','origami plates invoice and wholesale price for trade'),(116,'rohit','bansalrohit10@gmail.com','how can i fill ink in renolads teckpoint..?'),(117,'amit chadha','amitchadha53@gmail.com','Sir,\nI want fancy sofa ,Dining table top glass  4chairs '),(118,'testing','testing@gmail.com','testing'),(119,'BHARAT SHARMA','bharat.sharma@ashokleyland.com','Hi, please call me. We buy a lot of office supplies, recently online.\n\nNeed your help. please call 9543988209'),(120,'Dinesh Potdar','drdinesh0974@gmail.com','send the papers earlier. '),(121,'sreeni','sreenivasan.s@kobster.com','hiu this is locvalhost');

UNLOCK TABLES;

/*Table structure for table `kob_order_delivery` */

DROP TABLE IF EXISTS `kob_order_delivery`;

CREATE TABLE `kob_order_delivery` (
  `id_order_delivery` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_delivery` int(11) NOT NULL,
  PRIMARY KEY (`id_order_delivery`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_order_delivery` */

LOCK TABLES `kob_order_delivery` WRITE;

UNLOCK TABLES;

/*Table structure for table `kob_payment_cc` */

DROP TABLE IF EXISTS `kob_payment_cc`;

CREATE TABLE `kob_payment_cc` (
  `id_payment_cc` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(10) unsigned DEFAULT NULL,
  `id_currency` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(254) DEFAULT NULL,
  `card_number` varchar(254) DEFAULT NULL,
  `card_brand` varchar(254) DEFAULT NULL,
  `card_expiration` char(7) DEFAULT NULL,
  `card_holder` varchar(254) DEFAULT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_payment_cc`),
  KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kob_payment_cc` */

LOCK TABLES `kob_payment_cc` WRITE;

UNLOCK TABLES;

/*Table structure for table `kob_payment_group_map` */

DROP TABLE IF EXISTS `kob_payment_group_map`;

CREATE TABLE `kob_payment_group_map` (
  `id_default_group` int(11) DEFAULT NULL,
  `id_payment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_payment_group_map` */

LOCK TABLES `kob_payment_group_map` WRITE;

insert  into `kob_payment_group_map`(`id_default_group`,`id_payment`) values (1,1),(1,2),(1,3),(1,4),(3,1);

UNLOCK TABLES;

/*Table structure for table `kob_payment_option_master` */

DROP TABLE IF EXISTS `kob_payment_option_master`;

CREATE TABLE `kob_payment_option_master` (
  `id_payment` int(11) DEFAULT NULL,
  `Payment_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_payment_option_master` */

LOCK TABLES `kob_payment_option_master` WRITE;

insert  into `kob_payment_option_master`(`id_payment`,`Payment_Name`) values (1,'CASH ON DELIVERY'),(2,'CHEQUE'),(3,'NEFT/RTGS'),(4,'EBS');

UNLOCK TABLES;

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

/*Data for the table `kob_pincode_master` */

LOCK TABLES `kob_pincode_master` WRITE;

insert  into `kob_pincode_master`(`zone_id`,`zone_name`,`zone_state`,`zone_pin_start`,`zone_pin_end`) values (1,'Chennai','TamilNadu','600000','600180'),(2,'Banglore','Karnataka','560001','560100');

UNLOCK TABLES;

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

LOCK TABLES `kob_product_vendor_mapping` WRITE;

insert  into `kob_product_vendor_mapping`(`id_product`,`id_vendor`,`id_address`,`id_poc`,`id_vendor_category`,`id_category`) values (1,1,4,1,1,1),(2,1,4,1,1,1),(6,1,4,1,1,1),(7,1,4,1,1,1),(9,1,4,1,2,0);

UNLOCK TABLES;

/*Table structure for table `kob_product_zone_mapping` */

DROP TABLE IF EXISTS `kob_product_zone_mapping`;

CREATE TABLE `kob_product_zone_mapping` (
  `product_id` int(255) DEFAULT NULL,
  `zone_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_product_zone_mapping` */

LOCK TABLES `kob_product_zone_mapping` WRITE;

insert  into `kob_product_zone_mapping`(`product_id`,`zone_id`) values (1,1),(1,1),(8,1),(9,1);

UNLOCK TABLES;

/*Table structure for table `kob_profile` */

DROP TABLE IF EXISTS `kob_profile`;

CREATE TABLE `kob_profile` (
  `id_profile` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `kob_profile` */

LOCK TABLES `kob_profile` WRITE;

insert  into `kob_profile`(`id_profile`) values (1),(2),(3),(4),(5),(6);

UNLOCK TABLES;

/*Table structure for table `kob_profile_lang` */

DROP TABLE IF EXISTS `kob_profile_lang`;

CREATE TABLE `kob_profile_lang` (
  `id_lang` int(10) unsigned NOT NULL,
  `id_profile` int(10) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id_profile`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kob_profile_lang` */

LOCK TABLES `kob_profile_lang` WRITE;

insert  into `kob_profile_lang`(`id_lang`,`id_profile`,`name`) values (1,1,'Administrator'),(2,1,'Administrateur'),(3,1,'Administrador'),(4,1,'Administrator'),(5,1,'Administrator'),(1,2,'Logistician'),(2,2,'Logisticien'),(3,2,'Logistician'),(4,2,'Logistiker'),(5,2,'Logista'),(1,3,'Translator'),(2,3,'Traducteur'),(3,3,'Translator'),(4,3,'Übersetzer'),(5,3,'Traduttore'),(1,4,'Salesman'),(2,4,'Commercial'),(3,4,'Salesman'),(4,4,'Verkäufer'),(5,4,'Venditore'),(1,5,'Relationship Manager'),(1,6,'Supply Chain');

UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `kob_purchase_list` */

LOCK TABLES `kob_purchase_list` WRITE;

insert  into `kob_purchase_list`(`id_pur_list`,`id_customer`,`list_name`,`list_active`,`list_added`,`list_updated`,`list_status`) values (1,3,'office electronics',1,'2014-06-24 15:55:02','2014-06-24',0),(2,3,'office supplies',1,'2014-06-24 15:55:14','2014-06-24',0),(3,3,'home supplies',1,'2014-07-02 14:25:59',NULL,2),(4,2,'office electronics',1,'2014-09-09 11:33:52','2014-09-09',0),(5,2,'office supplies',1,'2014-09-09 11:33:52','2014-09-09',0),(6,2,'home supplies',1,'2014-09-09 11:33:52','2014-09-09',0),(7,6,'office electronics',1,'2014-09-09 11:45:47','2014-09-09',0),(8,6,'office supplies',1,'2014-09-09 11:45:47','2014-09-09',0),(9,6,'home supplies',1,'2014-09-09 11:45:47','2014-09-09',0),(10,3,'test1',1,'2014-09-09 11:45:47','2014-09-09',0),(11,7,'test2',1,'2014-09-09 11:45:47','2014-09-09',0),(12,8,'test1',1,'2014-09-09 14:32:18','2014-09-09',0),(13,3,'test2',1,'2014-09-09 14:32:18','2014-09-09',0);

UNLOCK TABLES;

/*Table structure for table `kob_rate_contract` */

DROP TABLE IF EXISTS `kob_rate_contract`;

CREATE TABLE `kob_rate_contract` (
  `id_rate_contract` int(255) NOT NULL AUTO_INCREMENT,
  `id_customer` int(255) NOT NULL,
  `id_product` int(255) NOT NULL,
  `id_product_attribute` int(10) NOT NULL,
  PRIMARY KEY (`id_rate_contract`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=latin1;

/*Data for the table `kob_rate_contract` */

LOCK TABLES `kob_rate_contract` WRITE;

insert  into `kob_rate_contract`(`id_rate_contract`,`id_customer`,`id_product`,`id_product_attribute`) values (1,2,1,0),(2,2,2,0),(3,2,5,0),(4,2,6,0),(5,3,1,42),(6,3,2,8),(7,3,5,15),(8,3,6,0),(9,0,11063,0),(10,2,11063,0),(11,2,55496,0),(12,2,8689,0),(13,2,45465,0),(14,2,2132,0),(15,2,87987,0),(16,2,2121,0),(17,2,845,0),(18,2,87854,0),(19,2,211,0),(20,2,21,0),(21,2,1,0),(22,2,54,0),(23,2,545,0),(24,2,8787,0),(25,2,21,0),(26,2,545,0),(27,2,21,0),(28,2,545454,0),(29,2,212,0),(30,2,54121,0),(31,2,154,0),(32,2,54,0),(33,0,11,0),(34,0,22,0),(35,0,33,0),(36,0,11,0),(37,0,22,0),(38,0,33,0),(39,4,11,0),(40,4,22,0),(41,4,55,0),(42,4,66,0),(43,4,88,0),(44,5,11,0),(45,5,11,0),(46,5,11,0),(47,5,11,0),(48,5,11,0),(49,2,11,0),(50,5,1,0),(51,5,1,0),(52,5,1,0),(53,5,11,0),(54,5,0,0),(55,5,0,0),(56,5,2,0),(57,5,5,0),(58,5,6,0),(59,5,2,0),(60,5,1,0),(61,3,1,0),(62,3,2,0),(63,3,5,0),(64,3,6,0),(65,3,7,0),(66,3,8,0),(67,3,9,0),(68,3,1,0),(69,3,2,0),(70,3,5,0),(71,3,6,0),(72,3,7,0),(73,3,8,0),(74,3,9,0),(75,3,1,0),(76,3,1,0),(77,3,1,0),(78,3,1,0),(79,3,1,0),(80,3,1,0),(81,3,1,0),(82,3,1,0),(83,3,1,0),(84,3,1,0),(85,3,1,0),(86,3,1,0),(87,3,1,0),(88,3,2,0),(89,6,1,0),(90,6,2,0),(91,6,5,0),(92,6,6,0),(93,6,1,0),(94,6,2,0),(95,6,5,0),(96,6,6,0),(97,6,7,0),(98,6,8,0),(99,6,9,0),(100,6,1,0),(101,6,2,0),(102,6,5,0),(103,6,6,0),(104,6,7,0),(105,6,8,0),(106,6,9,0),(107,6,1,0),(108,6,1,0),(109,6,1,0),(110,6,1,0),(111,6,1,0),(112,6,1,0),(113,6,1,0),(114,6,1,0),(115,6,1,0),(116,6,1,0),(117,6,1,0),(118,6,1,0),(119,6,1,0),(120,6,2,0),(152,7,8,0),(153,7,9,0),(154,7,1,0),(155,7,2,0),(156,7,5,0),(157,8,8,0),(158,8,9,0),(159,8,1,0),(160,8,2,0),(161,8,5,0),(162,3,7,0),(163,3,7,0),(164,3,7,0),(165,3,8,0),(166,3,8,0),(167,3,10,0),(168,3,10,0),(169,3,10,0),(170,3,10,0),(171,3,11,0),(172,3,11,0),(173,3,11,0),(174,3,12,0),(175,3,13,0),(176,3,15,0),(177,3,16,0),(178,3,17,0),(179,3,20,0),(180,3,21,0),(181,3,22,0),(182,2,23,0),(183,2,24,0),(184,2,25,0),(185,2,26,0),(186,2,27,0),(187,2,28,0),(188,2,29,0),(189,2,30,0),(190,2,31,0),(191,2,32,0),(192,2,33,0),(193,2,34,0),(194,2,35,0),(195,2,36,0),(196,2,37,0),(197,2,38,0),(198,2,39,0),(199,2,40,0),(200,2,41,0),(201,2,42,0),(202,2,43,0),(203,2,44,0),(204,2,45,0),(205,2,46,0),(206,2,47,0),(207,2,48,0),(208,3,49,0),(209,2,50,0),(210,2,51,0),(211,3,52,0),(212,3,55,0),(213,2,56,0),(214,2,57,0),(215,3,58,0),(216,3,59,0),(217,3,60,0),(218,2,61,0);

UNLOCK TABLES;

/*Table structure for table `kob_rate_contract_list_mapping` */

DROP TABLE IF EXISTS `kob_rate_contract_list_mapping`;

CREATE TABLE `kob_rate_contract_list_mapping` (
  `id_rate_contract` int(15) NOT NULL,
  `id_pur_list` int(15) NOT NULL,
  `product_quantity` int(15) DEFAULT NULL,
  PRIMARY KEY (`id_rate_contract`,`id_pur_list`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_rate_contract_list_mapping` */

LOCK TABLES `kob_rate_contract_list_mapping` WRITE;

insert  into `kob_rate_contract_list_mapping`(`id_rate_contract`,`id_pur_list`,`product_quantity`) values (0,0,0),(5,1,0),(6,1,0),(7,1,0),(8,1,0),(22,4,NULL),(61,2,0),(62,2,0),(63,2,0),(64,2,0),(65,2,0),(66,2,0),(67,2,0),(70,3,0),(71,4,0),(72,4,0),(73,3,0),(73,4,0),(74,3,0),(74,5,0),(89,2,0),(90,2,0),(91,2,0),(91,3,0),(92,2,0),(93,2,0),(94,8,0),(95,3,0),(95,8,0),(96,2,0),(97,8,0),(98,3,0),(98,8,0),(99,3,0),(99,8,0),(100,8,0),(101,8,0),(102,2,0),(102,3,0),(103,8,0),(104,8,0),(105,3,0),(105,8,0),(106,3,0),(106,8,0),(107,8,0),(108,8,0),(109,8,0),(110,8,0),(111,8,0),(112,8,0),(113,8,0),(114,8,0),(115,8,0),(116,8,0),(117,8,0),(118,8,0),(119,8,0),(120,8,0),(152,10,0),(153,10,0),(154,11,0),(155,11,0),(156,11,0),(157,12,0),(158,12,0),(162,13,0),(163,10,0),(164,10,0),(165,10,0),(166,13,0),(167,10,0),(168,10,0),(169,13,0),(170,13,0),(171,3,0),(172,13,0),(173,13,0),(174,10,0),(175,10,0),(176,3,0),(177,3,0),(178,3,0),(179,3,0),(180,1,0),(181,1,0),(182,4,0),(183,6,0),(184,6,0),(185,6,0),(186,5,0),(187,6,0),(188,6,0),(189,6,0),(190,6,0),(191,6,0),(192,6,0),(193,6,0),(194,6,0),(195,6,0),(196,6,0),(197,6,0),(198,6,0),(199,6,0),(200,6,0),(201,6,0),(202,6,0),(203,6,0),(204,6,0),(205,6,0),(206,6,0),(207,6,0),(208,3,0),(209,6,0),(210,6,0),(211,3,0),(212,3,0),(213,6,0),(214,6,0),(215,3,0),(216,2,0),(217,3,0),(218,4,NULL);

UNLOCK TABLES;

/*Table structure for table `kob_relationship_manager` */

DROP TABLE IF EXISTS `kob_relationship_manager`;

CREATE TABLE `kob_relationship_manager` (
  `id_relationship_manager` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_relationship_manager`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `kob_relationship_manager` */

LOCK TABLES `kob_relationship_manager` WRITE;

insert  into `kob_relationship_manager`(`id_relationship_manager`,`name`,`email`,`phone`) values (1,'Vineet Neeraj','vineet.neeraj@kobster.com','9884893165'),(2,'BalaMurugan','bala.murugan@kobster.com','7687232311'),(3,'Prashanth','prasanth.v@kobster.com','8956743288'),(4,'ini','ini@gmail.com','1234567890');

UNLOCK TABLES;

/*Table structure for table `kob_tab` */

DROP TABLE IF EXISTS `kob_tab`;

CREATE TABLE `kob_tab` (
  `id_tab` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `class_name` varchar(64) NOT NULL,
  `module` varchar(64) DEFAULT NULL,
  `position` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_tab`),
  KEY `class_name` (`class_name`),
  KEY `id_parent` (`id_parent`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

/*Data for the table `kob_tab` */

LOCK TABLES `kob_tab` WRITE;

insert  into `kob_tab`(`id_tab`,`id_parent`,`class_name`,`module`,`position`) values (1,0,'AdminCatalog',NULL,1),(2,0,'AdminCustomers',NULL,2),(3,0,'AdminOrders',NULL,3),(4,0,'AdminPayment',NULL,4),(5,0,'AdminShipping',NULL,5),(6,0,'AdminStats',NULL,6),(7,0,'AdminModules',NULL,7),(8,0,'AdminPreferences',NULL,9),(9,0,'AdminTools',NULL,10),(10,1,'AdminManufacturers',NULL,5),(11,1,'AdminAttributesGroups',NULL,1),(12,2,'AdminAddresses',NULL,1),(13,3,'AdminStatuses',NULL,3),(14,4,'AdminDiscounts',NULL,4),(15,4,'AdminCurrencies',NULL,1),(16,4,'AdminTaxes',NULL,2),(17,5,'AdminCarriers',NULL,1),(18,5,'AdminCountries',NULL,2),(19,5,'AdminZones',NULL,5),(20,5,'AdminRangePrice',NULL,6),(21,5,'AdminRangeWeight',NULL,7),(22,7,'AdminModulesPositions',NULL,4),(23,8,'AdminDb',NULL,2),(24,8,'AdminEmails',NULL,3),(26,8,'AdminImages',NULL,4),(27,8,'AdminPPreferences',NULL,11),(28,29,'AdminContacts',NULL,3),(29,0,'AdminEmployees',NULL,8),(30,29,'AdminProfiles',NULL,1),(31,29,'AdminAccess',NULL,2),(32,9,'AdminLanguages',NULL,2),(33,9,'AdminTranslations',NULL,3),(34,1,'AdminSuppliers',NULL,6),(35,29,'AdminTabs',NULL,6),(36,1,'AdminFeatures',NULL,2),(37,29,'AdminQuickAccesses',NULL,5),(38,8,'AdminAppearance',NULL,1),(39,8,'AdminContact',NULL,12),(40,8,'AdminAliases',NULL,8),(41,9,'AdminImport',NULL,1),(42,3,'AdminInvoices',NULL,2),(43,-1,'AdminSearch',NULL,0),(44,8,'AdminLocalization',NULL,9),(46,5,'AdminStates',NULL,3),(47,3,'AdminReturn',NULL,5),(48,3,'AdminPDF',NULL,8),(49,3,'AdminSlip',NULL,6),(51,6,'AdminStatsConf',NULL,1),(52,9,'AdminSubDomains',NULL,5),(53,9,'AdminBackup',NULL,9),(54,3,'AdminOrderMessage',NULL,7),(55,3,'AdminDeliverySlip',NULL,4),(56,8,'AdminMeta',NULL,6),(57,9,'AdminCMSContent',NULL,6),(58,1,'AdminScenes',NULL,4),(59,3,'AdminMessages',NULL,1),(60,1,'AdminTracking',NULL,9),(61,6,'AdminSearchEngines',NULL,2),(62,6,'AdminReferrers',NULL,3),(63,2,'AdminGroups',NULL,2),(64,9,'AdminGenerator',NULL,4),(65,2,'AdminCarts',NULL,3),(66,1,'AdminTags',NULL,8),(67,8,'AdminSearchConf',NULL,7),(68,1,'AdminAttachments',NULL,3),(69,9,'AdminInformation',NULL,11),(70,8,'AdminPerformance',NULL,5),(71,29,'AdminCustomerThreads',NULL,4),(72,9,'AdminWebservice',NULL,8),(73,1,'AdminStockMvt',NULL,7),(80,7,'AdminAddonsCatalog',NULL,1),(81,7,'AdminAddonsMyAccount',NULL,2),(82,9,'AdminStores',NULL,7),(83,7,'AdminThemes',NULL,3),(84,8,'AdminGeolocation',NULL,10),(85,4,'AdminTaxRulesGroup',NULL,3),(86,9,'AdminLogs',NULL,10),(87,5,'AdminCounty',NULL,4),(88,-1,'AdminHome',NULL,0),(89,2,'AdminCustomerMasterList',NULL,4),(90,1,'AdminVendor',NULL,10),(91,1,'AdminAddWishListProduct',NULL,11),(92,1,'AdminAddWishListProduct',NULL,11);

UNLOCK TABLES;

/*Table structure for table `kob_tab_lang` */

DROP TABLE IF EXISTS `kob_tab_lang`;

CREATE TABLE `kob_tab_lang` (
  `id_tab` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_tab`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kob_tab_lang` */

LOCK TABLES `kob_tab_lang` WRITE;

insert  into `kob_tab_lang`(`id_tab`,`id_lang`,`name`) values (0,2,'CustomerMasterList'),(0,3,'CustomerMasterList'),(0,4,'CustomerMasterList'),(1,1,'Catalog'),(1,2,'Catalogue'),(1,3,'Catálogo'),(1,4,'Katalog'),(1,5,'Catalogo'),(2,1,'Customers'),(2,2,'Clients'),(2,3,'Clientes'),(2,4,'Kunden'),(2,5,'Clienti'),(3,1,'Orders'),(3,2,'Commandes'),(3,3,'Pedidos'),(3,4,'Bestellungen'),(3,5,'Ordini'),(4,1,'Payment'),(4,2,'Paiement'),(4,3,'Pago'),(4,4,'Zahlung'),(4,5,'Pagamento'),(5,1,'Shipping'),(5,2,'Transport'),(5,3,'Transporte'),(5,4,'Versandkosten'),(5,5,'Spedizione'),(6,1,'Stats'),(6,2,'Stats'),(6,3,'Estadísticas'),(6,4,'Statistik'),(6,5,'Stat'),(7,1,'Modules'),(7,2,'Modules'),(7,3,'Módulos'),(7,4,'Module'),(7,5,'Moduli'),(8,1,'Preferences'),(8,2,'Préférences'),(8,3,'Preferencias'),(8,4,'Voreinstellungen'),(8,5,'Preferenze'),(9,1,'Tools'),(9,2,'Outils'),(9,3,'Herramientas'),(9,4,'Tools'),(9,5,'Strumenti'),(10,1,'Manufacturers'),(10,2,'Marques'),(10,3,'Fabricantes'),(10,4,'Hersteller'),(10,5,'Produttori'),(11,1,'Attributes and Groups'),(11,2,'Attributs et groupes'),(11,3,'Atributos y grupos'),(11,4,'Varianten & Kombinationen'),(11,5,'Attributi e Gruppi'),(12,1,'Addresses'),(12,2,'Adresses'),(12,3,'Direcciones'),(12,4,'Adressen'),(12,5,'Indirizzi'),(13,1,'Statuses'),(13,2,'Statuts'),(13,3,'Estados'),(13,4,'Status'),(13,5,'Status'),(14,1,'Vouchers'),(14,2,'Bons de réduction'),(14,3,'Vales de descuento'),(14,4,'Gutscheine'),(14,5,'Voucher'),(15,1,'Currencies'),(15,2,'Devises'),(15,3,'Divisas'),(15,4,'Währungen'),(15,5,'Valute'),(16,1,'Taxes'),(16,2,'Taxes'),(16,3,'Impuestos'),(16,4,'Steuern'),(16,5,'Tasse'),(17,1,'Carriers'),(17,2,'Transporteurs'),(17,3,'Transportistas'),(17,4,'Versanddienste'),(17,5,'Corrieri'),(18,1,'Countries'),(18,2,'Pays'),(18,3,'Países'),(18,4,'Länder'),(18,5,'Nazioni'),(19,1,'Zones'),(19,2,'Zones'),(19,3,'Zonas'),(19,4,'Zonen'),(19,5,'Zone'),(20,1,'Price Ranges'),(20,2,'Tranches de prix'),(20,3,'Franja de precios'),(20,4,'Preisklasse'),(20,5,'Fasce di prezzo'),(21,1,'Weight Ranges'),(21,2,'Tranches de poids'),(21,3,'Franja de pesos'),(21,4,'Gewichtsklassen'),(21,5,'Fasce di peso'),(22,1,'Positions'),(22,2,'Positions'),(22,3,'Posiciones'),(22,4,'Positionen'),(22,5,'Posizioni'),(23,1,'Database'),(23,2,'Base de données'),(23,3,'Base de datos'),(23,4,'Datenbank'),(23,5,'Database'),(24,1,'E-mail'),(24,2,'Emails'),(24,3,'Emails'),(24,4,'E-Mail'),(24,5,'E-mail'),(26,1,'Images'),(26,2,'Images'),(26,3,'Imágenes'),(26,4,'Bild'),(26,5,'Immagine'),(27,1,'Products'),(27,2,'Produits'),(27,3,'Productos'),(27,4,'Produkte'),(27,5,'Prodotti'),(28,1,'Contacts'),(28,2,'Contacts'),(28,3,'Contactos'),(28,4,'Kontakte'),(28,5,'Contatti'),(29,1,'Employees'),(29,2,'Employés'),(29,3,'Empleados'),(29,4,'Mitarbeiter'),(29,5,'Impiegati'),(30,1,'Profiles'),(30,2,'Profils'),(30,3,'Perfiles'),(30,4,'Profile'),(30,5,'Profili'),(31,1,'Permissions'),(31,2,'Permissions'),(31,3,'Permisos'),(31,4,'Berechtigungen'),(31,5,'Permessi'),(32,1,'Languages'),(32,2,'Langues'),(32,3,'Idiomas'),(32,4,'Sprachen'),(32,5,'Lingue'),(33,1,'Translations'),(33,2,'Traductions'),(33,3,'Traducciones'),(33,4,'Übersetzungen'),(33,5,'Traduzioni'),(34,1,'Suppliers'),(34,2,'Fournisseurs'),(34,3,'Proveedores'),(34,4,'Lieferanten'),(34,5,'Fornitori'),(35,1,'Tabs'),(35,2,'Onglets'),(35,3,'Pestañas'),(35,4,'Tabs'),(35,5,'Tab'),(36,1,'Features'),(36,2,'Caractéristiques'),(36,3,'Características'),(36,4,'Produktmerkmale'),(36,5,'Caratteristiche'),(37,1,'Quick Access'),(37,2,'Accès rapide'),(37,3,'Acceso rápido'),(37,4,'Schnellzugriff'),(37,5,'Accesso rapido'),(38,1,'Appearance'),(38,2,'Apparence'),(38,3,'Aspecto'),(38,4,'Aussehen'),(38,5,'Aspetto'),(39,1,'Contact Information'),(39,2,'Coordonnées'),(39,3,'Datos'),(39,4,'Kontaktinformation'),(39,5,'Informazioni di contatto'),(40,1,'Keyword Typos'),(40,2,'Alias'),(40,3,'Alias'),(40,4,'Alias'),(40,5,'Alias'),(41,1,'CSV Import'),(41,2,'Import'),(41,3,'Importar'),(41,4,'Import'),(41,5,'Importa'),(42,1,'Invoices'),(42,2,'Factures'),(42,3,'Facturas'),(42,4,'Rechnungen'),(42,5,'Fatture'),(43,1,'Search'),(43,2,'Recherche'),(43,3,'Búsqueda'),(43,4,'Suche'),(43,5,'Cerca'),(44,1,'Localization'),(44,2,'Localisation'),(44,3,'Ubicación'),(44,4,'Lokalisierung'),(44,5,'Localizzazione'),(46,1,'States'),(46,2,'Etats'),(46,3,'Estados'),(46,4,'Staaten'),(46,5,'Stati'),(47,1,'Merchandise Returns'),(47,2,'Retours produits'),(47,3,'Devolución productos'),(47,4,'Warenrücksendungen'),(47,5,'Resi merci'),(48,1,'PDF'),(48,2,'PDF'),(48,3,'PDF'),(48,4,'PDF'),(48,5,'PDF'),(49,1,'Credit Slips'),(49,2,'Avoirs'),(49,3,'Vales'),(49,4,'Gutscheine'),(49,5,'Note di credito'),(51,1,'Settings'),(51,2,'Configuration'),(51,3,'Configuración'),(51,4,'Einstellungen'),(51,5,'Impostazioni'),(52,1,'Subdomains'),(52,2,'Sous domaines'),(52,3,'Subcampos'),(52,4,'Subdomains'),(52,5,'Sottodomini'),(53,1,'DB Backup'),(53,2,'Sauvegarde BDD'),(53,3,'Copia de seguridad'),(53,4,'DB-Backup'),(53,5,'DB backup'),(54,1,'Order Messages'),(54,2,'Messages prédéfinis'),(54,3,'Mensajes de Orden'),(54,4,'Bestellnachrichten'),(54,5,'Messaggi ordine'),(55,1,'Delivery Slips'),(55,2,'Bons de livraison'),(55,3,'Albaranes de entrega'),(55,4,'Lieferscheine'),(55,5,'Note di consegna'),(56,1,'SEO & URLs'),(56,2,'SEO & URLs'),(56,3,'SEO & URLs'),(56,4,'SEO & URLs'),(56,5,'SEO & URLs'),(57,1,'CMS'),(57,2,'CMS'),(57,3,'CMS'),(57,4,'CMS'),(57,5,'CMS'),(58,1,'Image Mapping'),(58,2,'Scènes'),(58,3,'Mapeo de la imagen'),(58,4,'Image Mapping'),(58,5,'Mappatura immagine'),(59,1,'Customer Messages'),(59,2,'Messages clients'),(59,3,'Mensajes del cliente'),(59,4,'Kundennachrichten'),(59,5,'Messaggi cliente'),(60,1,'Monitoring'),(60,2,'Suivi'),(60,3,'Rastreo'),(60,4,'Tracking'),(60,5,'Rintracciare'),(61,1,'Search Engines'),(61,2,'Moteurs de recherche'),(61,3,'Motores de búsqueda'),(61,4,'Suchmaschinen'),(61,5,'Motori di ricerca'),(62,1,'Referrers'),(62,2,'Sites affluents'),(62,3,'Referido'),(62,4,'Referrer'),(62,5,'Referenti'),(63,1,'Groups'),(63,2,'Groupes'),(63,3,'Grupos'),(63,4,'Gruppen'),(63,5,'Gruppi'),(64,1,'Generators'),(64,2,'Générateurs'),(64,3,'Generadores'),(64,4,'Generatoren'),(64,5,'Generatori'),(65,1,'Shopping Carts'),(65,2,'Paniers'),(65,3,'Carritos'),(65,4,'Warenkörbe'),(65,5,'Carrelli shopping'),(66,1,'Tags'),(66,2,'Tags'),(66,3,'Etiquetas'),(66,4,'Tags'),(66,5,'Tag'),(67,1,'Search'),(67,2,'Recherche'),(67,3,'Búsqueda'),(67,4,'Suche'),(67,5,'Cerca'),(68,1,'Attachments'),(68,2,'Documents joints'),(68,3,'Adjuntos'),(68,4,'Anhänge'),(68,5,'Allegati'),(69,1,'Configuration Information'),(69,2,'Informations'),(69,3,'Informaciones'),(69,4,'Konfigurationsinformationen'),(69,5,'Informazioni di configurazione'),(70,1,'Performance'),(70,2,'Performances'),(70,3,'Rendimiento'),(70,4,'Leistung'),(70,5,'Performance'),(71,1,'Customer Service'),(71,2,'SAV'),(71,3,'Servicio al cliente'),(71,4,'Kundenservice'),(71,5,'Servizio clienti'),(72,1,'Webservice'),(72,2,'Service web'),(72,3,'Web service'),(72,4,'Webservice'),(72,5,'Webservice'),(73,1,'Stock Movement'),(73,2,'Mouvements de Stock'),(73,3,'Movimiento de Stock'),(73,4,'Lagerbewegungen'),(73,5,'Movimenti magazzino'),(80,1,'Modules & Themes Catalog'),(80,2,'Catalogue de modules et thèmes'),(80,3,'Modules & Themes Catalog'),(80,4,'Module und Themenkatalog'),(80,5,'Moduli & Temi catalogo'),(81,1,'My Account'),(81,2,'Mon compte'),(81,3,'My Account'),(81,4,'Mein Konto'),(81,5,'Il mio Account'),(82,1,'Stores'),(82,2,'Magasins'),(82,3,'Tiendas'),(82,4,'Shops'),(82,5,'Negozi'),(83,1,'Themes'),(83,2,'Thèmes'),(83,3,'Temas'),(83,4,'Template'),(83,5,'Temi'),(84,1,'Geolocation'),(84,2,'Géolocalisation'),(84,3,'Geolocalización'),(84,4,'Geotargeting'),(84,5,'Geolocalizzazione'),(85,1,'Tax Rules'),(85,2,'Règles de taxes'),(85,3,'Reglas de Impuestos'),(85,4,'Steuerregeln'),(85,5,'Regimi fiscali'),(86,1,'Logs'),(86,2,'Log'),(86,3,'Log'),(86,4,'Log'),(86,5,'Log'),(87,1,'Counties'),(87,2,'Comtés'),(87,3,'Condados'),(87,4,'Landkreise/Kanton'),(87,5,'Counties'),(88,1,'Home'),(88,2,'Accueil'),(88,3,'Home'),(88,4,'Home'),(88,5,'Home'),(89,1,'Customer Master List'),(90,1,'Vendor'),(91,1,'Add WishList Product'),(92,1,'Add WishList Product');

UNLOCK TABLES;

/*Table structure for table `kob_vendor` */

DROP TABLE IF EXISTS `kob_vendor`;

CREATE TABLE `kob_vendor` (
  `id_vendor` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tin` varchar(40) DEFAULT NULL,
  `cst` varchar(40) DEFAULT NULL,
  `pan` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
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
  PRIMARY KEY (`id_vendor`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor` */

LOCK TABLES `kob_vendor` WRITE;

insert  into `kob_vendor`(`id_vendor`,`name`,`tin`,`cst`,`pan`,`phone`,`id_payment`,`credit_days`,`website`,`replacement`,`id_default_poc`,`id_default_address`,`id_vendor_category`,`comments`,`active`,`delivery`,`date_add`,`date_update`) values (1,'srini','123456789','123456789','A12Cd56','9865321010',3,20,'http://www.kobster.com',1,10,4,NULL,'this is for testing',1,1,'2014-08-22 13:27:50','2014-08-22 13:27:50'),(2,'PRAKASH','1234567890','1234567890','1234567890','9894322703',4,20,'http://www.facebook.com',0,10,5,NULL,'hi srini',1,1,'2014-08-22 16:03:08','2014-08-22 16:03:08'),(3,'qewe','23121','123213','','',1,0,'readonly',0,0,23,NULL,'testing 3',1,0,'0000-00-00 00:00:00','2014-08-27 14:57:28'),(4,'dwftfwd','321312','2313123','','',1,0,'',0,12,15,NULL,'          ',1,0,'0000-00-00 00:00:00','2014-08-27 16:10:17'),(5,'srtdsrtds','324234','32432423','','',1,0,'',0,0,10,NULL,'          ',1,0,'0000-00-00 00:00:00','2014-08-27 16:22:43'),(6,'werw','342432','234324','','',1,0,'',0,13,11,NULL,'          ',1,0,'0000-00-00 00:00:00','2014-08-27 16:23:58'),(7,'srinivas','123546','123456','2032','',1,0,'',0,14,24,NULL,'          ',1,0,'0000-00-00 00:00:00','2014-09-24 10:38:32'),(8,'mahesh','789654213','312465897','213546','879546',1,0,'',0,17,0,NULL,'          ',1,0,'0000-00-00 00:00:00','2014-09-24 10:43:27'),(9,'arun','1213221111111','ab67jh8878','','9894322703,2256',1,20,'',0,19,25,NULL,'          this is for teasting',1,1,'0000-00-00 00:00:00','2014-11-15 10:44:05'),(10,'test two','87998798797897897','89879879787845455','121252xcdf','9894322703',1,20,'http://www.facebook.com',1,20,26,NULL,'this is for testing          ',1,1,'0000-00-00 00:00:00','2014-11-15 11:06:12'),(11,'test','21212212','22221','2221','121211212121',2,15,'',1,0,28,NULL,'this is kdmns vf          ',1,1,'0000-00-00 00:00:00','2014-11-15 11:16:47'),(12,'five','7878787878','5455548754','85458dxf','9894322703/2013',1,15,'',0,22,29,NULL,'sdfds adsifg hjsdf dshbf',1,1,'0000-00-00 00:00:00','2014-11-15 11:23:42'),(13,'srinivasan','114243456','7458','','',1,0,'',0,0,0,NULL,'          ',1,0,'0000-00-00 00:00:00','2014-11-26 17:39:38');

UNLOCK TABLES;

/*Table structure for table `kob_vendor_address` */

DROP TABLE IF EXISTS `kob_vendor_address`;

CREATE TABLE `kob_vendor_address` (
  `id_address` int(255) NOT NULL AUTO_INCREMENT,
  `id_vendor` int(255) NOT NULL,
  `address1` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `id_state` int(10) NOT NULL,
  `country` int(10) NOT NULL,
  `pincode` int(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` int(15) DEFAULT NULL,
  `delivery` smallint(2) DEFAULT NULL COMMENT '0-No delivery,1- delivery option available',
  `working_hour` text,
  `working_days` text,
  `comments` text,
  `active` smallint(2) NOT NULL DEFAULT '1',
  `alise` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor_address` */

LOCK TABLES `kob_vendor_address` WRITE;

insert  into `kob_vendor_address`(`id_address`,`id_vendor`,`address1`,`city`,`id_state`,`country`,`pincode`,`landmark`,`phone`,`fax`,`delivery`,`working_hour`,`working_days`,`comments`,`active`,`alise`,`date_add`,`date_update`) values (1,1,'14e,3rd cross st, bhudar nagar, new perungalathur chennai','Chennai',313,110,600063,'temple','2147483647',1234567890,1,'15','15','this is for testing',1,'new perungalathur','2014-08-22 15:33:04','2014-08-22 15:33:04'),(2,1,'tambaram,123 street, chennai','chennai',313,110,60063,'temple','2147483647',2147483647,1,'12','12','this is for testing',1,'tambaram','2014-08-22 15:36:42','2014-08-22 15:36:42'),(3,1,'omr chennai','chennnai',313,110,600063,'temple','2147483647',2147483647,1,'12','12','this is for testoing',1,'sholinganalur','2014-08-22 15:54:43','2014-08-22 15:54:43'),(4,1,'omr ECR chennai','chennnai',313,110,600063,'temple','2147483647',2147483647,1,'12','12','this is for testoing',1,'sholinganalur','2014-08-22 15:54:48','2014-08-22 15:54:48'),(5,2,'address1','coimbatore',313,110,600006,'hospital','2147483647',1231265446,1,'21','12','this is goftgkld',1,'address1','2014-08-22 16:04:06','2014-08-22 16:04:06'),(6,4,'','',313,110,423321,'','0',0,0,'','','',1,'eqrweqwreqrqe','2014-08-27 16:10:27','2014-08-27 16:10:27'),(7,4,'','',313,110,321321,'','0',0,0,'','','',0,'dqweeqwe','2014-08-27 16:12:04','2014-08-27 16:12:04'),(8,4,'','',313,110,321312,'','0',0,0,'','','',1,'fesfweefewfw','2014-08-27 16:13:34','2014-08-27 16:13:34'),(9,4,'','',313,110,341232,'','0',0,0,'','','',1,'dsfsdfsd','2014-08-27 16:18:19','2014-08-27 16:18:19'),(10,5,'','',313,110,432432,'','0',0,0,'','','',1,'dsfsdfsdfsd','2014-08-27 16:22:50','2014-08-27 16:22:50'),(11,6,'','',313,110,123231,'','0',0,0,'','','',0,'werrwerwe','2014-08-27 16:24:07','2014-08-27 16:24:07'),(12,6,'','',313,110,123213,'','0',0,0,'','','',0,'werwewerwerwrewrwerw','2014-08-27 16:24:48','2014-08-27 16:24:48'),(13,2,'thisi sfor testing','coimbatore',313,110,600043,'temple','2147483647',0,1,'','','',1,'sivaji colony','2014-10-01 11:13:55','2014-10-01 11:13:55'),(14,4,'tehsy','coimbatore',313,110,400063,'','0',0,1,'','','',1,'address1','2014-10-01 11:18:17','2014-10-01 11:18:17'),(15,4,'thisi for ','co',313,110,123456,'','0',0,1,'','','',1,'test1','2014-10-01 11:19:49','2014-10-01 11:19:49'),(16,7,'the','oihdf',313,110,312564,'','0',0,0,'','','',1,'test1','2014-10-01 11:21:56','2014-10-01 11:21:56'),(17,2,'test','',0,231,0,'','0',0,0,'','','',1,'test1','2014-10-01 11:22:30','2014-10-01 11:22:30'),(18,1,'this is ','dufh',313,110,600063,'te','125478962',0,0,'','','',1,'test','2014-10-01 11:30:40','2014-10-01 11:30:40'),(19,1,'thuis ihs kln','lknl',313,110,213456,'321','0',0,1,'','','',1,'test2','2014-10-09 16:54:57','2014-10-09 16:54:57'),(20,3,'kdjflkj','llkjhk',313,110,879465,'231654','2147483647',65456,0,'65465','564654','',1,'test','2014-10-09 16:55:47','2014-10-09 16:55:47'),(21,4,'RTHFD KN','dkmfklgm ',313,110,546516,'fdg32','21',12,1,'','','',1,'xyz','2014-10-09 16:57:15','2014-10-09 16:57:15'),(22,4,'JKLNHJNkjnkn','kjnLKJN',314,110,231654,'212','0',6256,0,'326','3263','',1,'last','2014-10-09 17:07:57','2014-10-09 17:07:57'),(23,3,'sdfkjh','lkjlkj',314,110,1213,'23','2132',1231,0,'21','212','',1,'testinf','2014-10-09 17:44:26','2014-10-09 17:44:26'),(24,7,'2','chennai',314,110,654879123,'212','21',21,1,'21','21','',1,'test2','2014-10-09 17:51:47','2014-10-09 17:51:47'),(25,9,'this is for testing','coimbatoer',313,110,641025,'temple','2147483647',0,0,'9-6','7','',1,'sivajicolony','2014-11-15 10:47:26','2014-11-15 10:47:26'),(26,10,'dsf j jjbdsj fnjndsf gjn','coimbatore',313,110,989896,'temple','9894322702',2147483647,1,'9-10','7','this ihs kldfsn gu fsgb ng',1,'second address','2014-11-15 11:08:15','2014-11-15 11:08:15'),(27,10,'thress','chennai',313,110,600063,'temple','9894322703',878754545,1,'9am-9pm','mon-friday','',1,'address three','2014-11-15 11:09:28','2014-11-15 11:09:28'),(28,11,'testinvg','chennai',313,110,545454,'2121','78754544',1212,1,'210212121','2121','',1,'testing 2','2014-11-15 11:17:45','2014-11-15 11:17:45'),(29,12,'1','cbe',313,110,640125,'dasfsd','9894322703/0422-404246',0,1,'9am-10pm','6','dfug dfyds dsjb jbsdf ',1,'1','2014-11-15 11:24:26','2014-11-15 11:24:26'),(30,12,'jdhsfh jsdf dsjh','2',313,110,604025,'gfgj','9894322703/0422-404244',0,0,'9am-5pm','5','',1,'2','2014-11-15 11:25:29','2014-11-15 11:25:29');

UNLOCK TABLES;

/*Table structure for table `kob_vendor_bank_details` */

DROP TABLE IF EXISTS `kob_vendor_bank_details`;

CREATE TABLE `kob_vendor_bank_details` (
  `id_bank` int(255) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `branch_address` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `account_type` smallint(3) DEFAULT NULL COMMENT '1-saving Ac,2-Current Ac, 3-Credit Ac',
  `ifsc_code` varchar(255) DEFAULT NULL,
  `id_vendor` int(255) DEFAULT NULL,
  `id_address` int(255) DEFAULT NULL,
  `active` smallint(2) DEFAULT '1' COMMENT '0-inactive, 1-active',
  `date_add` datetime DEFAULT NULL,
  `date_upd` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bank`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor_bank_details` */

LOCK TABLES `kob_vendor_bank_details` WRITE;

insert  into `kob_vendor_bank_details`(`id_bank`,`bank_name`,`branch`,`branch_address`,`account_name`,`account_no`,`account_type`,`ifsc_code`,`id_vendor`,`id_address`,`active`,`date_add`,`date_upd`) values (1,'iv','chennai','thisi for testionmf','check ac name','1234567899',1,'hdn213654',1,1,1,'2014-09-04 11:57:42','2014-09-04 11:57:42'),(2,'icici','perungalathur','new perungalathur','1234567890','1234564980',2,'icici201365',2,5,1,'2014-09-04 16:00:59','2014-09-04 16:00:59'),(3,'city bank','tambaram','tambaram chennai','city bank','1234567890',3,'city123456',2,5,1,'2014-09-04 17:17:43','2014-09-04 17:17:43'),(4,'icici','chennai','this is for testing','test name1','123654879321',1,'31465w',4,9,1,'2014-10-01 11:02:16','2014-10-01 11:02:16'),(5,'','hdfc','coimbatore','testing','1',0,'1234567890',0,0,1,'2014-10-01 12:21:29','2014-10-01 12:21:29'),(6,'','test1','tes','dfjoh','1',0,'879654321',321546,1,1,'2014-10-01 12:42:17','2014-10-01 12:42:17'),(7,'','hdfc','chnn','edfj','2',0,'123654',0,1,1,'2014-10-01 12:44:18','2014-10-01 12:44:18'),(8,'hdfc','bengal','tyfsdkj dsfyhgdsfkln skdbhfh','test ac','123465789132',1,'213dsdf ',1,1,1,'2014-10-01 12:47:08','2014-10-01 12:47:08'),(9,'city','shol','thjk','jhjhk','321654',2,'321;lkj',1,3,1,'2014-10-01 12:49:15','2014-10-01 12:49:15'),(10,'test','test','dfg','dsf','123sdf',1,'ds32f1',1,1,1,'2014-10-01 12:50:18','2014-10-01 12:50:18'),(11,'hdfc','chennai','cvnb','2134','4242',2,'fgh',1,1,1,'2014-10-01 12:51:55','2014-10-01 12:51:55'),(12,'hdfc','sholiganallur','this is for testong','srini','2134567891',1,'dsfsd21',7,16,1,'2014-10-01 13:09:42','2014-10-01 13:09:42');

UNLOCK TABLES;

/*Table structure for table `kob_vendor_category` */

DROP TABLE IF EXISTS `kob_vendor_category`;

CREATE TABLE `kob_vendor_category` (
  `id_vendor_category` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_vendor_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor_category` */

LOCK TABLES `kob_vendor_category` WRITE;

insert  into `kob_vendor_category`(`id_vendor_category`,`name`) values (1,'DISTRIBUTOR'),(2,'RESELLER'),(3,'MANUFACTURER');

UNLOCK TABLES;

/*Table structure for table `kob_vendor_poc` */

DROP TABLE IF EXISTS `kob_vendor_poc`;

CREATE TABLE `kob_vendor_poc` (
  `id_poc` int(255) NOT NULL AUTO_INCREMENT,
  `id_vendor` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `id_address` int(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `smart_phone` smallint(2) DEFAULT '0' COMMENT '1-customer using smartphone 0-not using smartphone',
  `comments` text,
  `active` smallint(2) DEFAULT '1' COMMENT '0-No delivery,1- delivery option available',
  `date_add` datetime DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_poc`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor_poc` */

LOCK TABLES `kob_vendor_poc` WRITE;

insert  into `kob_vendor_poc`(`id_poc`,`id_vendor`,`firstname`,`designation`,`id_address`,`phone1`,`phone2`,`email`,`smart_phone`,`comments`,`active`,`date_add`,`date_update`) values (1,1,'balaji','developer',NULL,'9894322703','9994612357','bala@gmail.com',1,'',0,'2014-08-22 15:46:06','2014-08-22 15:46:06'),(5,2,'prakash','',NULL,'9894322703','9894322270','prakash@gmail.com',1,'this is for testing',1,'2014-08-22 16:04:40','2014-08-22 16:04:40'),(7,0,'poc 4 ','testing',3,'1234567890','9876543211','mano@gmail.com',0,'this is for testing',1,'2014-08-27 11:27:34','2014-08-27 11:27:34'),(8,0,'chandru','manager',5,'1234567890','1234567890','chandru@gmail.com',0,'chnadru is the manager',1,'2014-08-27 11:31:59','2014-08-27 11:31:59'),(9,0,'chandru','manager',5,'1234567890','9876543210','chandru@gmail.com',0,'',1,'2014-08-27 11:33:37','2014-08-27 11:33:37'),(10,2,'srini','tester',1,'9894322703','9894322703','sreenivasan.s@kobster.com',0,'',1,'2014-08-27 11:41:28','2014-08-27 11:41:28'),(12,4,'fefesafa','',6,'','','',0,'',1,'2014-08-27 16:10:31','2014-08-27 16:10:31'),(13,6,'qwewqeqweqweqweqweqweqwewqeq','',12,'','','',0,'',0,'2014-08-27 16:25:24','2014-08-27 16:25:24'),(14,7,'sri','',0,'','','',0,'',1,'2014-09-24 10:38:48','2014-09-24 10:38:48'),(15,7,'srni','',0,'','','',0,'',1,'2014-09-24 10:39:00','2014-09-24 10:39:00'),(16,7,'srinica','',0,'','','',0,'',1,'2014-09-24 10:39:11','2014-09-24 10:39:11'),(17,8,'srini','',0,'','9894322703','',0,'',1,'2014-09-24 10:43:41','2014-09-24 10:43:41'),(18,8,'fsdgj','',0,'','','',0,'',1,'2014-09-24 10:43:53','2014-09-24 10:43:53'),(19,9,'balaji','developer',25,'989432270345896356','9894322703','',0,'',1,'2014-11-15 10:48:59','2014-11-15 10:48:59'),(20,10,'three','',26,'542158421545421','5454455545','seenu2706@gmail.com',1,'',1,'2014-11-15 11:10:16','2014-11-15 11:10:16'),(21,11,'rtr','',28,'9894322702,1234567890/0987654321','9894322703','seenu2706@gmail.com',1,'',1,'2014-11-15 11:20:38','2014-11-15 11:20:38'),(22,12,'test','testing designation',29,'989432703/0422-04222222','9894322703/1234567890','seenu2706@gmail.com',0,'',1,'2014-11-15 11:26:34','2014-11-15 11:26:34');

UNLOCK TABLES;

/*Table structure for table `kob_vendor_product_mapping` */

DROP TABLE IF EXISTS `kob_vendor_product_mapping`;

CREATE TABLE `kob_vendor_product_mapping` (
  `id` int(235) NOT NULL AUTO_INCREMENT,
  `id_product_reference` int(235) DEFAULT NULL,
  `id_vendor` int(235) DEFAULT NULL,
  `product_price` int(10) DEFAULT NULL,
  `status` int(2) DEFAULT '1' COMMENT '0- not active 1 active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor_product_mapping` */

LOCK TABLES `kob_vendor_product_mapping` WRITE;

UNLOCK TABLES;

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
  `id_payment` smallint(4) NOT NULL COMMENT '1-cod,2-cheque,3-NEFT,4-credit',
  `id_payments` varchar(15) DEFAULT NULL COMMENT '1-0 tax value,2-5% tax,3-14.5% tax',
  `active` smallint(2) DEFAULT '1' COMMENT '0-not active, 1 active',
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vendor_purchase`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `kob_vendor_purchase_bill` */

LOCK TABLES `kob_vendor_purchase_bill` WRITE;

insert  into `kob_vendor_purchase_bill`(`id_vendor_purchase`,`id_vendor`,`id_bill_no`,`id_product`,`bill_date`,`product_qty`,`unit_price`,`tax`,`id_payment`,`id_payments`,`active`,`date_add`) values (1,1,'1455',2,'2014-11-27','2',1000.000000,'2',0,NULL,0,'2014-11-28 10:35:22'),(2,1,'1455',7,'2014-11-27','5',5000.000000,'3',0,NULL,0,'2014-11-28 10:36:02'),(3,1,'1455',7,'2014-11-27','4',4000.000000,'2',0,NULL,1,'2014-11-28 10:36:30'),(4,8,'7785',8,'2014-11-28','3',3000.000000,'2',0,NULL,1,'2014-11-28 10:37:17'),(5,8,'7785',1,'2014-11-28','1',1000.000000,'3',0,NULL,0,'2014-11-28 10:37:34'),(6,8,'7855',9,'2014-11-28','5',5000.000000,'2',4,NULL,1,'2014-11-28 10:42:34'),(7,8,'7855',8,'2014-11-28','2',2000.000000,'2',4,NULL,0,'2014-11-28 10:42:48'),(8,8,'7855',7,'2014-11-28','5',5000.000000,'2',4,NULL,0,'2014-11-28 10:43:04'),(9,1,'1455',8,'2014-11-28','10',1500.000000,'2',0,NULL,0,'2014-11-28 11:43:54'),(10,8,'	7855',8,'2014-11-28','3',3000.000000,'3',4,NULL,1,'2014-11-28 12:03:39'),(11,8,'	7855',8,'2014-11-28','1',1500.000000,'3',4,NULL,0,'2014-11-28 12:04:46'),(12,8,'	7855',2,'2014-11-28','2',5000.000000,'2',4,NULL,1,'2014-11-28 12:05:38'),(13,13,'1005',2,'2014-12-03','15',100.000000,'2',1,NULL,1,'2014-12-03 10:01:22');

UNLOCK TABLES;

/*Table structure for table `kob_zone` */

DROP TABLE IF EXISTS `kob_zone`;

CREATE TABLE `kob_zone` (
  `id_zone` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `kob_zone` */

LOCK TABLES `kob_zone` WRITE;

insert  into `kob_zone`(`id_zone`,`name`,`active`) values (1,'Europe',1),(2,'North America',1),(3,'Asia',1),(4,'Africa',1),(5,'Oceania',1),(6,'South America',1),(7,'Europe (out E.U)',1),(8,'Centrale America/Antilla',1);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
