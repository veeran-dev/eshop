ALTER TABLE  `kob_customer` ADD  `status` INT( 2 ) NOT NULL DEFAULT  '0' AFTER  `last_passwd_gen` ;
ALTER TABLE `kob_customer`
ADD COLUMN company VARCHAR(100),
ADD COLUMN occupation VARCHAR(100), 
ADD COLUMN mobile VARCHAR (20) AFTER status 