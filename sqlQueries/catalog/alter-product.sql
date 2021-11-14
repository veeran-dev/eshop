ALTER TABLE  `kob_product` ADD  `id_employee` INT( 11 ) NOT NULL AFTER  `cache_default_attribute`;
ALTER TABLE  `kob_product` ADD  `id_vendor` INT( 11 ) NOT NULL AFTER  `id_employee` ;