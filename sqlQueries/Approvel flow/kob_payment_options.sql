ALTER TABLE  `kob_payment_group_map` ADD  `id_customer` INT( 5 ) NOT NULL AFTER  `id_payment` ;

INSERT into kob_payment_group_map SELECT a.id_default_group, a.id_payment, b.id_customer FROM `kob_payment_group_map` a , kob_customer b where a.id_default_group = b.id_default_group  
DELETE FROM kob_payment_group_map WHERE id_customer = 0;
