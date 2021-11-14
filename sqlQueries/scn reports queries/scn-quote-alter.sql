ALTER TABLE `kob_quotation`
ADD COLUMN `published` tinyint(4) DEFAULT '0' AFTER `date_generated`,
ADD COLUMN `active` tinyint(4) DEFAULT '1' AFTER `published`