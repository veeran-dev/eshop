<?php

Class Feature extends FeatureCore
{
	public function getCategoryFeature($id_category)
	{
		return Db::getInstance()->ExecuteS('SELECT cf.`id_category`,cf.`id_feature`,cf.`feature_required`,fl.`name`,fl.`id_lang` 
											FROM `'._DB_PREFIX_.'category_feature_group` cf
											LEFT JOIN  `'._DB_PREFIX_.'feature_lang` fl ON cf.`id_feature` = fl.`id_feature` AND fl.`id_lang` = 1
											WHERE cf.`id_category` = '.(int)($id_category).'
											ORDER BY cf.`feature_required` DESC');
	}

	public function getAttributesWithCategory($id_category)
	{
		return Db::getInstance()->ExecuteS('SELECT f.`id_feature`,fl.`name`,category_features.`feature_required` 
											FROM `'._DB_PREFIX_.'feature` f
											LEFT JOIN ( SELECT cfg.`id_feature`,cfg.`feature_required` 
														FROM `'._DB_PREFIX_.'category_feature_group` cfg 
													    WHERE cfg.`id_category` = '.$id_category.' ) category_features ON f.`id_feature` =  category_features.`id_feature`
											LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl ON f.`id_feature` = fl.`id_feature` AND fl.`id_lang` = 1
											WHERE 1 ORDER BY fl.`name` ASC');
	}

	/**
	* Create a feature from import
	*
	* @param integer $id_feature Feature id
	* @param integer $id_product Product id	
	* @param array $value Feature Value		
	*/	
	public static function addFeatureImport($name, $position = false)
	{
		$rq = Db::getInstance()->getRow('SELECT `id_feature` FROM '._DB_PREFIX_.'feature_lang WHERE `name` = \''.pSQL($name).'\' GROUP BY `id_feature`');
		if (!empty($rq))
			return (int)($rq['id_feature']);
		// Feature doesn't exist, create it
		$feature = new Feature();
		$languages = Language::getLanguages();
		foreach ($languages as $language)
			$feature->name[$language['id_lang']] = strval($name);
		$feature->add();
		return $feature->id;
	}

	public static function getFeaturesByName($id_lang, $search_query, $with_shop = true)
    {
        return Db::getInstance()->executeS('
		SELECT DISTINCT f.id_feature, f.*, fl.*
		FROM `'._DB_PREFIX_.'feature` f
		'.($with_shop ? Shop::addSqlAssociation('feature', 'f') : '').'
		LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl ON (f.`id_feature` = fl.`id_feature` AND fl.`id_lang` = '.(int)$id_lang.')
		WHERE fl.`name` LIKE "%'.$search_query.'%"
		ORDER BY f.`position` ASC');
    }
}