<?php

Class Filter extends ObjectModel
{
	Public static function getFilterValues($id_category, $id_customer, $page_number, $limit, $filterArray = array())
	{	
 		$join="";
		$where="";
		$dataLimit =  ' LIMIT '.(int)(($page_number) * $limit).','.(int)($limit).'';

 		if(!empty($filterArray['category'])) {
			$join .=' LEFT JOIN kob_category_product cp ON cp.`id_product` = p.`id_product`';
			$where .=' AND cp.id_category IN ('.implode($filterArray['category'],',').')';
 		}

		if(!empty($filterArray['manufacturer'])) {
			$where .=' AND p.`id_manufacturer` IN('.implode($filterArray['manufacturer'],',').')';
		}

		if($filterArray['price']['priceMax'] > 0) {			
 			if($id_customer != 0) {	 
 				$where .= ' AND sp.id_product = p.id_product  And sp.price >= '.$filterArray['price']['priceMin'].' AND sp.price <= '.$filterArray['price']['priceMax'].'';
			}
			else {
				$where .=' AND p.price >= '.$filterArray['price']['priceMin'].' AND p.price <= '.$filterArray['price']['priceMax'].'';
			}
		}
		
		if($id_customer !=0) {	
			$customer = new Customer((int)$id_customer);
			$join .= ' LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_product =p.id_product';
			$where .= ' AND  sp.id_group ='.$customer->id_default_group;
		}
		 
 		$sql_select = 'SELECT DISTINCT(p.id_product),pl.name FROM kob_product AS p 
		Left JOIN kob_product_lang as pl on pl.id_product = p.id_product ';
		$sql_count = 'SELECT COUNT(p.id_product) AS total from kob_product AS p Left JOIN kob_product_lang as pl on pl.id_product = p.id_product';
 		
 		$sql=' '.$join.' WHERE pl.id_lang = 1  AND p.active=1 AND p.discontinued = 0 '.$where;

    	$result =  Db::getInstance()->ExecuteS($sql_select.$sql.$dataLimit);
		$count =  Db::getInstance()->getValue($sql_count.$sql);
 		
		return array('result' => $result, 'total' => $count);
	}
}