/* completed */
ALTER TABLE  `kob_payment_request` ADD  `reference` VARCHAR( 250 ) NULL DEFAULT NULL AFTER  `req_completed_by` ;
/* To Excecute */
ALTER TABLE  `kob_payment_request` ADD  `id_bank_kobster` INT( 11 ) UNSIGNED NULL DEFAULT NULL AFTER  `id_bank` ;