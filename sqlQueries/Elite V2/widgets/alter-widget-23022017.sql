/* Alter column names */
ALTER TABLE  `kob_widget` CHANGE  `is_default`  `default` TINYINT( 2 ) NOT NULL DEFAULT  '0',
CHANGE  `id_widget_type`  `type` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '0 - Normal, 1 - Dashboard, 2 - Company level',
CHANGE  `is_new`  `new` TINYINT( 1 ) NOT NULL DEFAULT  '0';

ALTER TABLE  `kob_widget_user` CHANGE  `is_paid`  `paid` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '0 - Free, 1 - Paid, 2 - Not Paid';

/* Configurable widget column */
ALTER TABLE  `kob_widget` ADD  `configure` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `new` ;