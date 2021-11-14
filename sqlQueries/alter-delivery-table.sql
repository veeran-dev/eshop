ALTER TABLE  `kob_delivery` ADD  `kob_boxes` INT( 11 ) NULL DEFAULT  '0' AFTER  `delivery_number` ,
ADD  `other_boxes` INT( 11 ) NULL DEFAULT  '0' AFTER  `kob_boxes` ,
ADD  `kob_boxes_returned` INT( 11 ) NULL DEFAULT  '0' AFTER  `other_boxes` ;