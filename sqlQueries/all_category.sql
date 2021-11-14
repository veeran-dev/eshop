CREATE TABLE IF NOT EXISTS `kob_category_listing` (
  `id_category_list` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `list_category_slider` text NOT NULL,
  `list_most_searched` text NOT NULL,
  `list_top_selling` text NOT NULL,
  `list_top_viewed` text NOT NULL,
  `list_top_discounted` text NOT NULL,
  `list_kobster_recommented` text NOT NULL,
  `list_ads` text NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_category_list`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `kob_category_sub_listing` (
  `id_subCategory_listing` int(11) NOT NULL AUTO_INCREMENT,
  `link_category_id` int(11) NOT NULL,
  `subCategory_id` int(11) NOT NULL,
  `subCategory_image` varchar(255) NOT NULL,
  `associated_products` text NOT NULL,
  `is_branded` set('0','1') NOT NULL DEFAULT '0' COMMENT '0 for ''No''; 1 for ''Yes''',
  `associated_brands` text NOT NULL,
  PRIMARY KEY (`id_subCategory_listing`),
  UNIQUE KEY `subCategory_id` (`subCategory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
