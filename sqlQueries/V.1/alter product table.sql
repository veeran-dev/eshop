ALTER TABLE `kob_product` ADD `discontinued` SMALLINT(2) NOT NULL DEFAULT '0' COMMENT '0-product active, 1- product discontinued' AFTER `available_for_order`;