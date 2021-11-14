

CREATE TABLE IF NOT EXISTS `kob_order_delivery` (
  `id_order_delivery` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_delivery` int(11) NOT NULL,
  PRIMARY KEY (`id_order_delivery`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;