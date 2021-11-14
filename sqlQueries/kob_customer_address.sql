ALTER TABLE `kob_customer_address` ADD `id_parent` INT( 11 ) NOT NULL AFTER `id_customer` ;
ALTER TABLE kob_customer_address DROP PRIMARY KEY, ADD PRIMARY KEY(id_customer, id_parent, id_address);