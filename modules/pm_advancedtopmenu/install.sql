CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu` (
  `id_menu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms` int(10) unsigned NOT NULL DEFAULT '0',
  `id_category` int(10) unsigned NOT NULL DEFAULT '0',
  `id_supplier` int(10) unsigned NOT NULL DEFAULT '0',
  `id_manufacturer` int(10) unsigned NOT NULL DEFAULT '0',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `have_icon` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `txt_color_menu_tab` varchar(7) NOT NULL,
  `txt_color_menu_tab_hover` varchar(7) NOT NULL,
  `fnd_color_menu_tab` varchar(7) NOT NULL,
  `fnd_color_menu_tab_over` varchar(7) NOT NULL,
  `border_size_tab` varchar(24) NOT NULL,
  `border_color_tab` varchar(7) NOT NULL,
  `fnd_color_submenu` varchar(7) NOT NULL,
  `border_color_submenu` varchar(7) NOT NULL,
  `border_size_submenu` varchar(24) NOT NULL,
  `privacy` tinyint(4)  NOT NULL DEFAULT '0',
  `active` tinyint(4)  NOT NULL DEFAULT '0',
  `target` varchar(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_menu`),
  KEY `active` (`active`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_lang` (
  `id_menu` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(256) NOT NULL,
  `value_over` text,
  `value_under` text,
  `link` varchar(256) NOT NULL,
  UNIQUE KEY `id_column` (`id_menu`,`id_lang`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_columns_wrap` (
  `id_wrap` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` int(10) unsigned NOT NULL,
  `id_menu_depend` int(10) unsigned NOT NULL,
  `internal_name` varchar(256) NOT NULL,
  `bg_color` varchar(7) NOT NULL,
  `txt_color_column` varchar(7) NOT NULL,
  `txt_color_column_over` varchar(7) NOT NULL,
  `txt_color_element` varchar(7) NOT NULL,
  `txt_color_element_over` varchar(7) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `privacy` tinyint(4)  NOT NULL DEFAULT '0',
  `active` tinyint(4)  NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_wrap`),
  KEY `active` (`active`),
  KEY `id_menu` (`id_menu`),
   KEY `id_menu_depend` (`id_menu_depend`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_columns_wrap_lang` (
  `id_wrap` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `value_over` text,
  `value_under` text,
  UNIQUE KEY `id_wrap` (`id_wrap`,`id_lang`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_columns` (
  `id_column` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` int(10) unsigned NOT NULL,
  `id_wrap` int(10) unsigned NOT NULL,
  `id_cms` int(10) unsigned NOT NULL DEFAULT '0',
  `id_category` int(10) unsigned NOT NULL DEFAULT '0',
  `id_supplier` int(10) unsigned NOT NULL DEFAULT '0',
  `id_manufacturer` int(10) unsigned NOT NULL DEFAULT '0',
  `id_menu_depend` int(10) unsigned NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `have_icon` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `privacy` tinyint(4)  NOT NULL DEFAULT '0',
  `target` varchar(10) NOT NULL,
  `active` tinyint(4)  NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_column`),
  KEY `active` (`active`),
  KEY `id_wrap` (`id_wrap`),
  KEY `id_menu_depend` (`id_menu_depend`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_columns_lang` (
  `id_column` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(256) NOT NULL,
  `value_over` text,
  `value_under` text,
  `link` varchar(256) NOT NULL,
  UNIQUE KEY `id_column` (`id_column`,`id_lang`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_elements` (
  `id_element` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_column` int(10) unsigned NOT NULL,
  `id_cms` int(10) unsigned NOT NULL DEFAULT '0',
  `id_category` int(10) unsigned NOT NULL DEFAULT '0',
  `id_supplier` int(10) unsigned NOT NULL DEFAULT '0',
  `id_manufacturer` int(10) unsigned NOT NULL DEFAULT '0',
  `id_column_depend` int(10) unsigned NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `have_icon` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `privacy` tinyint(4)  NOT NULL DEFAULT '0',
  `target` varchar(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_element`),
  KEY `id_column` (`id_column`),
  KEY `id_column_depend` (`id_column_depend`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedtopmenu_elements_lang` (
  `id_element` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `link` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  UNIQUE KEY `id_element` (`id_element`,`id_lang`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;