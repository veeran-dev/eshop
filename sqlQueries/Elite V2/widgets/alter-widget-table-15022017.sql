ALTER TABLE  `kob_widget` CHANGE  `is_dashboard`  `id_widget_type` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT '0 - Normal, 1 - Dashboard, 2 - Company level';