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
/*Table structure for table `kob_quotation` */

DROP TABLE IF EXISTS `kob_quotation`;

CREATE TABLE `kob_quotation` (
  `id_quotation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` int(10) unsigned NOT NULL,
  `quote_name` varchar(255) NOT NULL,
  `quote_version` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `date_generated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_quotation`)
) ENGINE=InnoDB AUTO_INCREMENT=445 DEFAULT CHARSET=utf8;

/*Data for the table `kob_quotation` */

insert  into `kob_quotation`(`id_quotation`,`id_customer`,`quote_name`,`quote_version`,`id_employee`,`date_generated`) values (279,2,'elumalai',1,3,'2015-03-12 18:37:07'),(280,2,'cfsdgfogfr',1,3,'2015-03-12 18:44:19'),(281,2,'cfsdgfog.lljk',1,3,'2015-03-12 18:46:36'),(282,2,'mahesh',1,3,'2015-03-12 18:48:42'),(283,1,'elumalai',1,3,'2015-03-12 19:38:43'),(284,1,'elumalai1',1,3,'2015-03-12 19:40:36'),(285,1,'elumalai2',1,3,'2015-03-12 19:45:34'),(286,1,'elumalai3',1,3,'2015-03-12 19:47:26'),(287,1,'elumalai4',1,3,'2015-03-12 19:49:38'),(288,2,'elumalai5',1,3,'2015-03-12 19:50:42'),(289,1,'elumalai5',1,3,'2015-03-12 19:52:59'),(290,1,'elumalai6',1,3,'2015-03-12 19:54:27'),(291,2,'elumalai6',1,3,'2015-03-12 19:55:50'),(292,1,'elumalai7',1,3,'2015-03-12 19:57:50'),(293,1,'elumalai8',1,3,'2015-03-12 20:09:41'),(294,2,'elumalai9',1,3,'2015-03-12 20:11:12'),(295,1,'elumalai10',1,3,'2015-03-12 20:13:01'),(296,2,'elumalai433',1,3,'2015-03-12 20:20:51'),(297,1,'elumalai11',1,3,'2015-03-12 20:27:13'),(298,2,'welll',1,3,'2015-03-12 20:36:01'),(299,2,'elumalai4343',1,3,'2015-03-12 20:40:36'),(300,2,'cfsdgfogfrewe',1,3,'2015-03-12 20:45:04'),(301,2,'undefined',1,3,'2015-03-12 20:48:18'),(302,2,'elumalai12',1,3,'2015-03-12 22:33:53'),(303,2,'anbu',1,3,'2015-03-12 22:38:29'),(304,2,'anbu1',1,3,'2015-03-12 22:38:50'),(305,2,'anbu2',1,3,'2015-03-12 22:39:56'),(306,2,'cfsdgfogfrwew',1,3,'2015-03-12 22:43:23'),(307,2,'hello',1,3,'2015-03-12 22:45:26'),(308,2,'elumalai123',1,3,'2015-03-12 22:46:36'),(309,2,'elumalai23',1,3,'2015-03-12 22:51:02'),(310,1,'elumalai123',1,3,'2015-03-12 22:56:45'),(311,2,'cfsdgfogfrds',1,3,'2015-03-12 23:08:33'),(312,2,'elumalai434365',1,3,'2015-03-12 23:16:07'),(313,9,'elumalai',1,3,'2015-03-12 23:18:24'),(314,1,'cfsdgfog',1,3,'2015-03-12 23:21:13'),(315,9,'elumalai4343',1,3,'2015-03-12 23:26:15'),(316,2,'cfsdgfogerer',1,3,'2015-03-12 23:27:18'),(317,4,'elumalai',1,3,'2015-03-12 23:41:07'),(318,4,'undefined',1,3,'2015-03-12 23:42:39'),(319,4,'undefined',2,3,'2015-03-12 23:42:53'),(320,4,'undefined',3,3,'2015-03-12 23:43:04'),(321,4,'undefined',4,3,'2015-03-12 23:43:14'),(322,4,'undefined',5,3,'2015-03-12 23:43:23'),(323,4,'undefined',6,3,'2015-03-12 23:43:35'),(324,4,'undefined',7,3,'2015-03-12 23:43:40'),(325,4,'undefined',8,3,'2015-03-12 23:43:46'),(326,4,'undefined',9,3,'2015-03-12 23:43:52'),(327,4,'undefined',10,3,'2015-03-12 23:43:59'),(328,2,'cfsdgfog44543ew',1,3,'2015-03-13 00:02:38'),(329,9,'cfsdgfog.lljkruf',1,3,'2015-03-13 00:05:41'),(330,2,'elumalaie33',1,3,'2015-03-13 00:08:30'),(331,5,'elumalai3535353',1,3,'2015-03-13 00:37:03'),(332,2,'4343ggrr',1,3,'2015-03-13 00:57:26'),(333,2,'fgjg',1,3,'2015-03-13 01:07:43'),(334,4,'elumalai545454',1,3,'2015-03-13 01:19:58'),(335,2,'fgchhghf',1,3,'2015-03-13 01:27:17'),(336,2,'elumalaigfgfrg',1,3,'2015-03-13 01:34:16'),(337,4,'elumalai4343',1,3,'2015-03-13 01:38:53'),(338,4,'rerererfe',1,3,'2015-03-13 01:40:55'),(339,2,'gdgrgger',1,3,'2015-03-13 01:44:25'),(340,4,'grgtghte',1,3,'2015-03-13 01:46:41'),(341,2,'dggrt',1,3,'2015-03-13 01:51:15'),(342,2,'gjghjg',1,3,'2015-03-13 01:52:40'),(343,2,'gfdghhtde',1,3,'2015-03-13 01:54:52'),(344,5,'elumalai434355',1,3,'2015-03-13 01:58:32'),(345,4,'cfsdgfogfrrtr',1,3,'2015-03-13 02:02:51'),(346,2,'trerreer',1,3,'2015-03-13 02:05:44'),(347,2,'fdgggre',1,3,'2015-03-13 02:18:18'),(348,2,'elumalai5654654',1,3,'2015-03-13 02:20:37'),(349,2,'6564565464',1,3,'2015-03-13 02:21:39'),(350,2,'trtreye',1,3,'2015-03-13 02:25:24'),(351,5,'gfdgtgege',1,3,'2015-03-13 02:27:16'),(352,4,'feffew',1,3,'2015-03-13 02:30:51'),(353,2,'tytujijo',1,3,'2015-03-13 02:37:36'),(354,2,'ghjgihkl',1,3,'2015-03-13 02:39:14'),(355,2,'uiiuuiio',1,3,'2015-03-13 02:46:37'),(356,2,'rrewrttre',1,3,'2015-03-13 02:47:53'),(357,2,'57677',1,3,'2015-03-13 03:09:28'),(358,5,'hgjhj',1,3,'2015-03-13 03:11:39'),(359,2,'hjbkjkk',1,3,'2015-03-13 03:18:57'),(360,4,'uytt8',1,3,'2015-03-13 03:26:09'),(361,2,'uyuyuiu',1,3,'2015-03-13 03:32:19'),(362,9,'hkhiuuouio',1,3,'2015-03-13 03:35:28'),(363,2,'gbhtgf',1,3,'2015-03-13 10:09:27'),(364,2,'55455ggreerree',1,3,'2015-03-13 10:18:18'),(365,1,'erer44355',1,3,'2015-03-13 10:20:24'),(366,2,'4rrerereter',1,3,'2015-03-13 10:43:57'),(367,2,'elumalai32232',1,3,'2015-03-13 10:54:22'),(368,2,'ewgewje6733',1,3,'2015-03-13 10:55:51'),(369,4,'wewee6534343',1,3,'2015-03-13 10:57:15'),(370,5,'hjffr45454',1,3,'2015-03-13 11:04:01'),(371,15,'4rrerereterwewe',1,3,'2015-03-13 11:05:08'),(372,5,'hello4343',1,3,'2015-03-13 11:06:53'),(373,4,'ghkggjg',1,3,'2015-03-13 12:25:50'),(374,2,'rertrtrtr',1,3,'2015-03-13 13:49:24'),(375,5,'ggfdgd',1,3,'2015-03-13 13:50:30'),(376,2,'535355353gfdfggf',1,3,'2015-03-13 14:03:52'),(377,2,'4rrerereterwewe5454',1,3,'2015-03-13 14:05:32'),(378,4,'4rrerereterwewe35353',1,3,'2015-03-13 14:06:29'),(379,5,'76385345343',1,3,'2015-03-13 14:07:23'),(380,4,'jfhdfrer',1,3,'2015-03-13 14:09:14'),(381,2,'rereree',1,3,'2015-03-13 14:10:32'),(382,4,'jhtrtrtr',1,3,'2015-03-13 14:12:30'),(383,2,'gghgdhdf',1,3,'2015-03-13 17:05:23'),(384,2,'arun raj',1,3,'2015-03-13 17:09:22'),(385,2,'arun raj',2,3,'2015-03-13 17:13:03'),(386,2,'reeer',1,3,'2015-03-16 10:20:03'),(387,2,'helloworld',1,3,'2015-03-16 11:09:27'),(388,2,'hello world 1',1,3,'2015-03-16 11:13:13'),(389,2,'gydehdfdee',1,3,'2015-03-16 11:44:39'),(390,2,'wewufefee',1,3,'2015-03-16 11:49:08'),(391,2,'gydehdfdee3',1,3,'2015-03-16 13:01:19'),(392,2,'8765654645',1,3,'2015-03-16 13:29:57'),(393,5,'hgtrgre',1,3,'2015-03-16 13:33:49'),(394,4,'8765654645erere',1,3,'2015-03-16 13:35:22'),(395,2,'vvghj',1,3,'2015-03-16 14:10:06'),(396,2,'hgdgfduf',1,3,'2015-03-16 14:12:51'),(397,2,'hgdgfdufs',1,3,'2015-03-16 14:18:20'),(398,4,'reruui3',1,3,'2015-03-16 14:30:00'),(399,2,'fdfdjfkf',1,3,'2015-03-16 14:53:01'),(400,2,'geurererere',1,3,'2015-03-16 14:57:44'),(401,4,'4fjdfdfdf',1,3,'2015-03-16 15:01:56'),(402,2,'xdfgh',1,3,'2015-03-16 15:03:05'),(403,4,'erwr3e3',1,3,'2015-03-16 15:04:13'),(404,10,'434353fgr',1,3,'2015-03-16 15:09:06'),(405,5,'reureretrt',1,3,'2015-03-16 15:18:31'),(406,2,'ewerere',1,3,'2015-03-16 15:22:41'),(407,2,'fgdhjghj',1,3,'2015-03-16 15:44:21'),(408,2,'fdfghj',1,3,'2015-03-16 15:45:33'),(409,4,'elumalaiit',1,3,'2015-03-16 22:43:29'),(410,2,'elumalaiit',1,3,'2015-03-16 22:44:31'),(411,17,'elumalai',1,3,'2015-03-16 22:51:55'),(412,2,'ipod',1,3,'2015-03-16 23:03:34'),(413,4,'wewew',1,3,'2015-03-16 23:07:15'),(414,4,'3232',1,3,'2015-03-16 23:08:48'),(415,2,'232322',1,3,'2015-03-16 23:12:32'),(416,4,'ewwrwr',1,3,'2015-03-16 23:13:35'),(417,2,'wewewew',1,3,'2015-03-16 23:16:09'),(418,2,'dfere',1,3,'2015-03-16 23:18:32'),(419,4,'3hfe',1,3,'2015-03-16 23:21:44'),(420,2,'ee2e2e2w',1,3,'2015-03-16 23:26:40'),(421,2,'56789',1,3,'2015-03-16 23:35:09'),(422,2,'dfsdggrf',1,3,'2015-03-16 23:37:33'),(423,4,'ghjkl',1,3,'2015-03-16 23:41:05'),(424,2,'ghjffr',1,3,'2015-03-16 23:43:45'),(425,2,'45678',1,3,'2015-03-16 23:47:02'),(426,4,'673deffr',1,3,'2015-03-16 23:48:02'),(427,2,'efdefe',1,3,'2015-03-16 23:49:00'),(428,2,'fhkuykjyrt',1,3,'2015-03-16 23:49:55'),(429,4,'ewewww',1,3,'2015-03-16 23:53:32'),(430,2,'wewe3',1,3,'2015-03-16 23:59:04'),(431,2,'defnjefd',1,3,'2015-03-17 00:00:46'),(432,4,'dfghjk',1,3,'2015-03-17 00:23:45'),(433,2,'dfghjk',1,3,'2015-03-17 00:30:41'),(434,2,'tyyyuu',1,3,'2015-03-17 00:30:59'),(435,5,'4356789',1,3,'2015-03-17 00:43:05'),(436,2,'567776ikjk',1,3,'2015-03-17 00:47:28'),(437,2,'guuyu',1,3,'2015-03-17 00:52:16'),(438,2,'ddgggh',1,3,'2015-03-17 00:57:12'),(439,2,'ddggghk',1,3,'2015-03-17 00:58:23'),(440,2,'ddggghkm',1,3,'2015-03-17 01:01:25'),(441,2,'ssds',1,3,'2015-03-17 10:12:44'),(442,2,'hdjfdfdfd',1,3,'2015-03-17 10:58:38'),(443,2,'hdjfdfdfd',2,3,'2015-03-17 11:00:00'),(444,2,'ghjk',1,3,'2015-03-17 11:06:27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
DROP TABLE IF EXISTS `kob_quotation_detail`;

CREATE TABLE `kob_quotation_detail` (
  `id_quotation` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  `product_price` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kob_quotation_detail` */

insert  into `kob_quotation_detail`(`id_quotation`,`id_product`,`product_price`) values (279,8,678889.000000),(279,2,768.000000),(279,9,67787.000000),(301,8,3232.000000),(301,7,2322.000000),(301,9,3232.000000),(316,98,332.000000),(316,8,4343.000000),(316,2,343.000000),(316,9,4343.000000),(316,7,343.000000),(316,1,343.000000),(316,10,4343.000000),(316,78,4343.000000),(316,76,333.000000),(316,79,4434.000000),(316,5,4343.000000),(316,83,34343.000000),(316,84,4343.000000),(316,82,4343.000000),(318,9,5665.000000),(318,7,788768.000000),(319,9,5665.000000),(319,7,788768.000000),(320,9,5665.000000),(320,7,788768.000000),(321,9,5665.000000),(321,7,788768.000000),(322,9,5665.000000),(322,7,788768.000000),(323,9,5665.000000),(323,7,788768.000000),(324,9,5665.000000),(324,7,788768.000000),(325,9,5665.000000),(325,7,788768.000000),(326,9,5665.000000),(326,7,788768.000000),(327,9,5665.000000),(327,7,788768.000000),(384,9,23311.000000),(384,7,4343.000000),(384,8,78784.000000),(385,7,4343.000000),(385,8,78784.000000),(385,10,544545.000000),(385,90,332434.000000),(396,8,100.000000),(396,2,743.000000),(396,98,443.000000),(396,133,433.000000),(396,9,433.000000),(396,1,4343.000000),(396,10,4384343.000000),(396,78,4343.000000),(396,76,5494.000000),(396,79,4343.000000),(396,77,232.000000),(396,83,3232.000000),(396,84,3873.000000),(396,82,833.000000),(396,6,3232.000000),(396,5,37438.000000),(410,2,100.000000),(410,8,7454.000000),(410,133,5484.000000),(410,9,7454.000000),(410,7,4343.000000),(410,98,4343.000000),(410,78,434.000000),(410,76,433.000000),(410,79,3353.000000),(410,77,54543.000000),(410,5,42342.000000),(410,83,343.000000),(410,84,4543.000000),(410,82,343.000000),(442,8,6232.000000),(443,8,6232.000000),(443,2,443.000000);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
