<?php
/*
Author: Karthik R (Kobster.com)
*/

class BulkRequestCore extends ObjectModel
{
	public 		$bq_id;
	
	public 		$id_product;
	
	public 		$product_name;
	
	public 		$id_customer;
	
	public 		$quantity;
	
	public 		$quantity_unit;
	
	public 		$target_price;
	
	public		$target_price_currency;

	public 		$delivery_pincode;
	
	public 		$credit;
	
	public 		$other_details;

	public 		$triggered;
	
 	protected 	$fieldsRequired = array('id_product', 'product_name', 'id_customer', 'quantity', 'delivery_pincode', 'credit');
 	
	protected 	$table = 'bq_request';
	protected 	$identifier = 'bq_id';

	public function getFields()
	{
		parent::validateFields();
		$fields['bq_id'] = (int)($this->bq_id);
		$fields['id_product'] = (int)($this->id_product);
		$fields['product_name'] = pSQL($this->product_name);
		$fields['id_customer'] = (int)($this->id_customer);
		$fields['quantity'] = (int)($this->quantity);
		$fields['quantity_unit'] = pSQL($this->quantity_unit);
		$fields['delivery_pincode'] = (int)($this->delivery_pincode);
		$fields['credit'] = (int)($this->credit);
		$fields['other_details'] = pSQL($this->other_details);
		$fields['target_price'] = (float)($this->target_price);
		$fields['target_price_currency'] = pSQL($this->target_price_currency);
		$fields['triggered'] = (int)($this->triggered);
		
		return $fields;
	}

	public function getBulkDataForScn()
	{
		return Db::getInstance()->ExecuteS('SELECT a.`bq_id` AS request_id,a.`delivery_pincode` AS pincode,a.`id_product` AS product_code,a.`product_name` AS product_name,
											a.`quantity` AS qty,a.`triggered` AS triggered,a.`quantity_unit` AS qty_unit,a.`target_price` AS target_price,a.`target_price_currency` AS currency,b.`firstname` AS name
											FROM '._DB_PREFIX_.'bq_request a LEFT JOIN '._DB_PREFIX_.'customer b ON b.`id_customer` = a.`id_customer`');
	}
	public function getProducts($id_lang = 1,$product_ids){
		global $cookie;
		$result = Db::getInstance()->ExecuteS('SELECT p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`,pl.`available_later`, pl.`link_rewrite`, 
											pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name,
											tl.`name` AS tax_name, t.`rate`,cl.`name` AS category_default
											FROM `'._DB_PREFIX_.'category_product` cp
											LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
											LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
											LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
											LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
											LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
											LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
											LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group` AND tr.`id_country` = '.(int)Country::getDefaultCountryId().' AND tr.`id_state` = 0)
											LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
											LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
											LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
											WHERE p.`active` = 1 AND p.`id_product` IN ('.($product_ids).')
											GROUP BY cp.`id_product`
											ORDER BY cp.`id_product`');
		return Product::getProductsProperties($id_lang, $result);
	}
}

