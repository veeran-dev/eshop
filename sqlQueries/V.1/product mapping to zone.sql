/*Insert bulk products to map in product zone mapping*/ 
/*zone id denote chennai or banglore  from pincode zone AND category id denote which category need to map in that zone*/
/*INSERT INTO `ps_product_zone_mapping` (`product_id`,`zone_id`) SELECT p.id_product,"Zone id"
FROM `kob_category_product` cp
LEFT JOIN `kob_product` p ON p.`id_product` = cp.`id_product`
WHERE cp.`id_category` = "category id" AND p.`active`=1*/

INSERT INTO `ps_product_zone_mapping` (`product_id`,`zone_id`) SELECT id_product,"Zone id" FROM kob_category_product WHERE id_category IN (SELECT c.id_category FROM `kob_category` c LEFT JOIN `kob_category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = 1) WHERE `id_parent` = ) )