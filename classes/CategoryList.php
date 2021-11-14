<?php

class CategoryList extends ObjectModel
{
	public		$category_id;
	public		$list_category_slider;
	public		$list_most_searched;
	public		$list_top_selling;
	public		$list_top_viewed;
	public		$list_top_discounted;
	public		$list_kobster_recommented;
	public		$list_ads;

	public static $definition = array(
        'table' 	=> 'category_listing',
        'primary' 	=> 'id_category_list',
        'fields' 	=> array(
			'category_id' 				=> array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'list_category_slider' 		=> array('type' => self::TYPE_STRING, 'required' => true),
			'list_most_searched' 		=> array('type' => self::TYPE_STRING, 'required' => true),
			'list_top_selling' 			=> array('type' => self::TYPE_STRING, 'required' => true),
			'list_top_viewed' 			=> array('type' => self::TYPE_STRING, 'required' => true),
			'list_top_discounted' 		=> array('type' => self::TYPE_STRING, 'required' => true),
			'list_kobster_recommented' 	=> array('type' => self::TYPE_STRING, 'required' => true),			
			'list_ads' 					=> array('type' => self::TYPE_STRING, 'required' => true),
        ),
    );
	
	public function getCategoryListDetails($category_id)
	{
		$query	= 'select * from `'._DB_PREFIX_.'category_listing` WHERE category_id = "'.$category_id.'"';	
		$result	= Db::getInstance()->ExecuteS($query);
		return $result;
	}
	public function getSubCategoryList($category_id, $is_branded)
	{
		$query	= 'SELECT name, description, sl.subCategory_id, sl.subCategory_image, sl.associated_products, sl.associated_brands from `'._DB_PREFIX_.'category_sub_listing` as sl LEFT JOIN `kob_category_lang` b ON (b.`id_category` = sl.`subCategory_id` AND b.`id_lang` = 1 AND b.`id_shop` = 1) LEFT JOIN `kob_category_shop` sa ON (sl.`subCategory_id` = sa.`id_category` AND sa.id_shop = 1) LEFT JOIN `kob_category` a ON (a.`id_category` = sl.`subCategory_id`) WHERE sl.link_category_id = "'.$category_id.'" and sl.is_branded = "'.$is_branded.'"';	
		$result	= Db::getInstance()->ExecuteS($query);
		return $result;
	}
	public function mostSearchedProducts($msp_list =  NULL)
	{
		$query = "SELECT a.`id_product`, b.`name` AS `product_name`, sa.`active` AS `active` FROM `kob_product` a LEFT JOIN `kob_product_lang` b ON (b.`id_product` = a.`id_product` AND b.`id_lang` = 1 AND b.`id_shop` = 1) JOIN `kob_product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default) WHERE a.id_product IN (".$msp_list.")";
		$result = Db::getInstance()->ExecuteS($query);
		return $result;
	}
	
	public static function isControllerExist($id_Category)
	{
		// $query = 'select * from `'._DB_PREFIX_.'category_listing` WHERE category_id = '.$id_Category;	
		// $result = Db::getInstance()->Execute($query);
		return false;
	}
	
	public function getProducts($id_lang = 1, $product_ids)
	{
		global $cookie;
		$sql = '
		SELECT cat.link_rewrite,p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new,
			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice, p.minimal_quantity
		FROM `'._DB_PREFIX_.'category_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cat ON (p.`id_category_default` = cat.`id_category`)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
		                                           AND tr.`id_country` = '.(int)Country::getDefaultCountryId().'
	                                           	   AND tr.`id_state` = 0)
	    LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
		WHERE p.`active` = 1 
		AND p.`available_for_order`=1
		AND p.`id_product` IN ('.($product_ids).')
		GROUP BY cp.`id_product`';
		//ORDER BY RAND()';
		$result = Db::getInstance()->ExecuteS($sql);
		
		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}

}