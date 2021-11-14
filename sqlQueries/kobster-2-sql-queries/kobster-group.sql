ALTER TABLE `kob_group`   
  ADD COLUMN `verification_status` INT(11) DEFAULT 0  NOT NULL AFTER `date_upd`,
  ADD COLUMN `verification_document` VARCHAR(300) NULL AFTER `verification_status`;
