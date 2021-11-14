ALTER TABLE `kob_delivery`   
  ADD COLUMN `kob_boxes` INT(11) NULL AFTER `delivery_number`,
  ADD COLUMN `other_boxes` INT(11) NULL AFTER `kob_boxes`,
  ADD COLUMN `kob_boxes_returned` INT(11) NULL AFTER `other_boxes`;