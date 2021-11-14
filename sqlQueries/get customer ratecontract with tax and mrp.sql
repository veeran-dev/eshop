SELECT rc.`id_rate_contract` , rc.`id_customer`,rc.`id_product`,rc.`id_product_attribute`, pl.list_name,pl.id_pur_list, p.reference, plang.name,rclm.active as purchaselist_active,	t.rate as tax_value, ((sp.price *t.rate/100 )+ sp.price)as cus_price, ((p.price *t.rate/100 )+ p.price) as mrp 
											FROM `kob_rate_contract` as rc 
											left join kob_rate_contract_list_mapping as rclm
											on rc.id_rate_contract = rclm.id_rate_contract
											left join kob_product as p
											on p.id_product = rc.id_product
											left join kob_product_lang plang
											on plang.id_product = p.id_product
											left join kob_purchase_list as pl
											on rclm.id_pur_list = pl.id_pur_list										
											left join kob_tax_rule as tr on tr.id_tax_rules_group = p.id_tax_rules_group
											left join kob_tax as t on tr.id_tax = t.id_tax  
											left join kob_specific_price as sp on sp.id_product = p.id_product 
											where  p.discontinued = 0 AND  plang.id_lang=1 AND rc.active=1 AND p.active= 1 and rc.id_customer="4172" and 
											if((select count(id_tax) from kob_tax_rule where id_tax_rules_group = p.id_tax_rules_group and id_state = 324) != 0, tr.id_state =324,tr.id_state =0) and sp.id_group = 62