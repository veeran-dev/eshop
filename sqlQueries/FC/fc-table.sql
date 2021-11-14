CREATE TABLE `kob_fullfillment_centre` (
  `id_fc` int(11) NOT NULL AUTO_INCREMENT,
  `id_state` int(11) NOT NULL,
  `city_name` varchar(25) NOT NULL,
  `id_address` int(11) DEFAULT NULL,
  `id_employee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fc`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1