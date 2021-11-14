CREATE TABLE IF NOT EXISTS `kob_bq_request` (
  `bq_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_unit` varchar(10) NOT NULL COMMENT '`',
  `target_price` decimal(11,0) DEFAULT NULL,
  `target_price_currency` varchar(10) NOT NULL,
  `delivery_pincode` int(11) NOT NULL,
  `credit` tinyint(1) NOT NULL,
  `other_details` varchar(400) DEFAULT NULL,
  `id_product` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;