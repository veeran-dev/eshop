<?php

Class Category extends CategoryCore
{
	public static function getPerksCategories()
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
										select cl.id_category,cl.name,count(id_category) as count from '._DB_PREFIX_.'specific_price sp		
         								left join '._DB_PREFIX_.'product p on(p.id_product = sp.id_product)
         								left join '._DB_PREFIX_.'category_lang cl on(cl.id_category = p.id_category_default and cl.id_lang=1)
         								where sp.id_group = 3
        								group by id_category
        								HAVING COUNT >= 5 
									  	ORDER BY cl.`name` ASC');
	}
	public static function getAllCategories($id_lang)
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('SELECT c.`id_category`,cl.`name` 
															  FROM `'._DB_PREFIX_.'category` c
															  LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category` 
															  AND cl.`id_lang` = '.$id_lang.'
															  WHERE 1 ORDER BY cl.`name` ASC');
	}

	public static function getNamingRuleForCategory($id_category){
		$rule =  Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('SELECT cp.`pattern_rule` FROM `'._DB_PREFIX_.'category_pattern` cp
															  WHERE cp.`id_category` = '.$id_category.'');

		$naming_rule = array();
		$convert_pattern_to_array = explode("$", $rule[0]['pattern_rule']);
		foreach ($convert_pattern_to_array as $key => $value) 
		{
			array_push($naming_rule, Vendor::getFeatureDetail($value, $id_lang = 1));
		}

		return $naming_rule;
	}

	public static function getOnboardCategories($id_parent, $id_lang, $active = true)
	{
		if (!Validate::isBool($active))
	 		die(Tools::displayError());

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT c.`id_category`, cl.`name`, cl.`link_rewrite`
		FROM `'._DB_PREFIX_.'category` c
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`
		WHERE `id_lang` = '.(int)($id_lang).'
		AND c.`id_parent` = '.(int)($id_parent).'
		AND c.`id_category` NOT IN(4001,4002,4003,4101,4104,4105,4113,208615,208628,41200043,41200045,41200073,41200075)
		'.($active ? 'AND `active` = 1' : '').'
		ORDER BY `position` ASC');
	}

	public static  function getCategoryProductVendorMapping($id_category,$total_products = false)
	{
		if($total_products)
		{
 			return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT  count(`id_product`) FROM `'._DB_PREFIX_.'category_product`  WHERE `id_category` = '.$id_category );
		}
		else
		{
		/*get all the products which are taged to that products from kob_category_product*/
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('SELECT  cp. `id_product`,pl.name FROM `'._DB_PREFIX_.'category_product` cp LEFT JOIN `'._DB_PREFIX_.'product_lang` AS pl ON cp.`id_product` = pl.`id_product` WHERE cp.`id_category` = '.$id_category.' AND pl.`id_lang` = 1');
		}
	}

	public function getParent($levelDepth = false, $id_lang = NULL) 
	{
		if (is_null($id_lang))
            $id_lang = Context::getContext()->language->id;

		$addSql = $levelDepth ? ' AND c.`level_depth` = '.$levelDepth.'' : "";

		return Db::getInstance()->ExecuteS('SELECT c.`id_category`, cl.`name` AS category 
											FROM `'._DB_PREFIX_.'category` c
											LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`
											WHERE cl.`id_lang` = '.$id_lang.' AND c.`nleft` < '.$this->nleft.'
											AND c.`nright` > '.$this->nright.' '.$addSql.'
											GROUP BY c.`id_category` ORDER BY cl.`name` ASC');
	}
	public function getProductListInCategory($id_category,$id_customer,$page_number,$limit)
	{
  		$join="";
		$where="";
 		
		if($id_customer !=0)
		{
			$customer = new Customer((int)$id_customer); 
			$join = 'LEFT JOIN '._DB_PREFIX_.'specific_price as sp on sp.id_product = cp.id_product ';
			$where = 'AND sp.id_group='.$customer->id_default_group.'';
		} 
		
		$sql_select = 'SELECT cp.`id_product`, pl.`name`, pl.`link_rewrite`';
		$sql_count = 'SELECT COUNT(*) AS total';
		$dataLimit =  ' LIMIT '.(int)(($page_number) * $limit).','.(int)($limit).'';
		
		$sql = ' FROM `'._DB_PREFIX_.'category_product` cp left join '._DB_PREFIX_.'product_lang as pl on pl.id_product = cp.id_product and id_lang = 1
		LEFT JOIN kob_product p ON p.`id_product` = cp.id_product '.$join.' WHERE cp.`id_category` ='.$id_category.' AND p.active=1 AND p.`discontinued` =0 '.$where.' ORDER BY `position` ASC ';
		 
 		$data = Db::getInstance()->ExecuteS($sql_select.$sql.$dataLimit);
		$count = Db::getInstance()->getValue($sql_count.$sql);
 		return array('result' => $data, 'total' => $count);
 	}
	public function getCategoryIdFromProductId($product_array)
	{
		$sql = 'SELECT DISTINCT(cp.id_category),cl.name from '._DB_PREFIX_.'category_product as cp LEFT JOIN '._DB_PREFIX_.'category as c on c.id_category = cp.id_category AND c.active = 1 LEFT JOIN '._DB_PREFIX_.'category_lang cl on cl.id_category = c.id_category and cl.id_lang = 1 where  cl.name !="" AND cp.id_product in('.implode($product_array,",").')';
 		return Db::getInstance()->ExecuteS($sql);
	}
	public function getAllProductsInCategory($id_category)
	{
		$sql = 'SELECT DISTINCT(cp.`id_product`) from '._DB_PREFIX_.'category_product as cp LEFT JOIN '._DB_PREFIX_.'product as p on p.id_product = cp.id_product AND p.active = 1 and  p.discontinued = 0  where  cp.id_category='.$id_category;
 		return Db::getInstance()->ExecuteS($sql);
	}

	public static function getCategoryName($ids){
		$sql ="SELECT GROUP_CONCAT(name) as cname from `"._DB_PREFIX_."category_lang` where id_lang=1 and id_category in(".$ids.")";
		$result = Db::getInstance()->ExecuteS($sql)[0]['cname'];
		return $result;
	}
}