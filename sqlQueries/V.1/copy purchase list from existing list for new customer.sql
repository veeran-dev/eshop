/*Step 1*//*Copy purchase list from existing customer*//*8 is new cus id and 7 is old cus id */
INSERT INTO `kob_purchase_list`(id_customer, list_name,list_updated) SELECT "8", list_name,NOW() FROM `kob_purchase_list` WHERE id_customer=7

/*Step 2*//* Copy products from ratecontract from existing customer*//*8 is new cus id and 7 is old cus id */
INSERT IGNORE INTO `kob_rate_contract`(`id_customer`, `id_product`) SELECT "4298", `id_product` FROM kob_rate_contract WHERE id_product not in (select id_product FROM kob_rate_contract WHERE id_customer=4298 )and id_customer=4246;

/*step 3*//*insert into mapping with new rate contract id for particular purchase list *//*13 is new purcahse list id 11 is existing list id and 8 is cus id*/

INSERT INTO `kob_rate_contract_list_mapping`(`id_rate_contract`,`id_pur_list`,`product_quantity`) 
	SELECT `id_rate_contract`, "13","0" 
	FROM `kob_rate_contract`
	WHERE id_product IN (SELECT rc.`id_product` 
			FROM `kob_rate_contract` AS rc
			LEFT JOIN kob_rate_contract_list_mapping AS rclm
			ON rclm.`id_rate_contract`= rc.id_rate_contract
			WHERE rclm.`id_pur_list`=11)
	AND `id_customer`=8
	
	
	