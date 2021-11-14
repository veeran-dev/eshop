ALTER TABLE  `kob_vendor` ADD  `gst` VARCHAR( 15 ) NULL DEFAULT NULL AFTER  `name` ,
ADD INDEX (  `gst` ) ;