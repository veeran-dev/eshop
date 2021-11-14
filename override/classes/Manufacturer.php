<?php

Class Manufacturer extends ManufacturerCore
{
	public function getManufacturerProductList($id_manufacturer,$id_customer,$page_number,$limit)
	{
		
		
		if((int)$page_number == 0)
		{
 			$page_number =1;
		}
		if($id_customer !=0)
		{
			$customer = new Customer((int)$id_customer); 
			$join = 'LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_product = p.id_product ';
			$where = 'AND sp.id_group='.$customer->id_default_group.'';
		} 

		$sql_select = 'SELECT p.`id_product`, pl.`name`, pl.`link_rewrite`';
		$sql_count = 'SELECT COUNT(*) AS total';
		$dataLimit =  ' LIMIT '.(int)(($page_number - 1) * $limit).','.(int)($page_number*$limit).'';

		$sql = ' FROM `'._DB_PREFIX_.'product` p
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
			p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = 1
		)
		'.$join.'
		WHERE p.`id_manufacturer` = '.$id_manufacturer.' AND p.active = 1 and p.discontinued = 0 '.$where.'';
 		$data = Db::getInstance()->ExecuteS($sql_select.$sql.$dataLimit);
		$count = Db::getInstance()->getValue($sql_count.$sql);
		
		return array('result' => $data, 'total' => $count);
 	}
	public function getManufactureIdFromProductId($product_array)
	{
 		
		$sql = 'SELECT DISTINCT(m.id_manufacturer),name from '._DB_PREFIX_.'manufacturer as m LEFT JOIN '._DB_PREFIX_.'product as p on p.id_manufacturer = m.id_manufacturer AND m.active = 1  where name !="" AND p.id_product in('.implode($product_array,",").')';
  		return Db::getInstance()->ExecuteS($sql);
	}
	public function getAllProductsFromManufacturer($id_manufacturer)
	{

		$sql = 'SELECT DISTINCT(id_product) from '._DB_PREFIX_.'product where id_manufacturer='.$id_manufacturer.' AND active = 1 AND discontinued = 0';
 		return Db::getInstance()->ExecuteS($sql);
	}
}