ALTER TABLE `kob_group`  ADD `id_relationship_manager` INT(11) NOT NULL  AFTER `id_group`,  ADD `esc_email` VARCHAR(128) NOT NULL  AFTER `id_relationship_manager`,  ADD `esc_mobile` VARCHAR(10) NOT NULL  AFTER `esc_email`;

ALTER TABLE `kob_group`
  DROP `esc_name`,
  DROP `esc_email`,
  DROP `esc_mobile`;