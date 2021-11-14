ALTER TABLE  `kob_vendor_poc` ADD  `passwd` VARCHAR( 32 ) NOT NULL AFTER  `designation` ;
ALTER TABLE  `kob_vendor_poc` ADD  `last_passwd_gen` TIMESTAMP NULL DEFAULT NULL AFTER  `passwd`;