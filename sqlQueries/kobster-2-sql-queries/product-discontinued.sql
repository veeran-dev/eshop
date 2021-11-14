ALTER TABLE `kob_product`   
  CHANGE `discontinued` `discontinued` TINYINT(1) UNSIGNED DEFAULT 0  NOT NULL  COMMENT '0-product active, 1- product discontinued';