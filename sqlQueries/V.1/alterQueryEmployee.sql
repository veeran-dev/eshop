
ALTER TABLE `kob_employee` ADD COLUMN phone VARCHAR(15) AFTER email


UPDATE `kob_employee`
SET `phone`=9884893165
WHERE id_employee=4;

UPDATE `kob_employee`
SET `phone`=9884746822
WHERE id_employee=1;

UPDATE `kob_employee`
SET `phone`=7687232311
WHERE id_employee=16;
