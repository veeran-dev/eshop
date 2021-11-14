ALTER TABLE `kob_order_state`   
  DROP COLUMN `id_profile`, 
  ADD COLUMN `id_profile` INT(11) NULL AFTER `deleted`;

update `kob_order_state` set `id_profile`=5 where id_order_state IN(23,28,32,41,43)
update `kob_order_state` set `id_profile`=6 where id_order_state IN(4,18,19,21,22,24,33)
update `kob_order_state` set `id_profile`=11 where id_order_state IN(35,37,39)
update `kob_order_state` set `id_profile`=13 where id_order_state IN(5,9,25,26,27,29,30,31,34,36,40,42)
update `kob_order_state` set `id_profile`=14 where id_order_state IN(6,7,38)