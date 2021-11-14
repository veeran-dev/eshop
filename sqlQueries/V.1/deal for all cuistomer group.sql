

INSERT INTO `kob_specific_price`( `id_product`, `id_shop`, `id_currency`, `id_country`, `id_group`, `price`, `from_quantity`, `reduction`, `reduction_type`, `from`, `to`) SELECT "206363",0,0,0,id_group,40.000000,0,0.00000,"amount","0000-00-00 00:00:00","0000-00-00 00:00:00" FROM `kob_group` where id_group not in(1,21)

INSERT INTO `kob_deal`( `id_group`, `id_specific_price`, `id_employee`, `date_add`, `date_upd`, `active`) SELECT id_group,id_specific_price,"10",NOW(),NOW(),1 from kob_specific_price where id_group not in(1,21) and id_product = 206363