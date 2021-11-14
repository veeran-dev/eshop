/*added a new column po_number in table kob_orders. this is to save the po number which is uploaded in the database 
*/

ALTER TABLE `kob_orders` ADD COLUMN po_number VARCHAR(32) AFTER date_upd 