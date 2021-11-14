ALTER TABLE `kob_rate_contract` ADD `active` SMALLINT(2) NOT NULL DEFAULT '1' ;

ALTER TABLE `kob_rate_contract_list_mapping` ADD `active` SMALLINT(2) NOT NULL DEFAULT '1' AFTER `product_quantity`;