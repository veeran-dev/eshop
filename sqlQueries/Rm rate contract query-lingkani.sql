SELECT distinct(p.reference), plang.name,sp.price,
							CASE WHEN (p.`id_tax_rules_group`) = 8 THEN "5 %"
							WHEN (p.`id_tax_rules_group`) = 6 THEN "14.5 %"
							ELSE "0 %" END AS tax_value
											FROM `kob_rate_contract` as rc 
											left join kob_rate_contract_list_mapping as rclm
											on rc.id_rate_contract = rclm.id_rate_contract
											left join kob_product as p
											on p.id_product = rc.id_product
											left join kob_product_lang plang
											on plang.id_product = p.id_product
											left join kob_purchase_list as pl
											on rclm.id_pur_list = pl.id_pur_list
											left join kob_specific_price sp 
											on sp.id_product = p.id_product
											where rc.id_customer="3131" AND p.discontinued = 0 AND  plang.id_lang=1 AND rc.active=1 AND p.active= 1