
/*Step 1*/
/*insert new status for invoice submission pending and invoice submitted*/
INSERT INTO `kob_order_state`(`invoice`, `send_email`,  `unremovable`, `hidden`, `logable`, `delivery`, `deleted`) VALUES (0,0,0,0,0,0,0),(0,0,0,0,0,0,0)
/*Step 2*/
/*Added the lang for both the status*/
INSERT INTO `kob_order_state_lang`(`id_order_state`, `id_lang`, `name`) VALUES (39,1,"Invoice Submission Pending"),(39,2,"Invoice Submission Pending"),(39,3,"Invoice Submission Pending"),(39,4,"Invoice Submission Pending"),(39,5,"Invoice Submission Pending")

/*Step 3*/
INSERT INTO `kob_order_state_lang`(`id_order_state`, `id_lang`, `name`) VALUES (39,1,"Invoice Submitted"),(39,2,"Invoice Submitted"),(39,3,"Invoice Submitted"),(39,4,"Invoice Submitted"),(39,5,"Invoice Submitted")