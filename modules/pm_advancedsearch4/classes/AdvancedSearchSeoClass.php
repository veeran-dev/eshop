<?php
/**
 *
 * PM_AdvancedSearch_4 Front Office Feature
 *
 * @category front_office_features
 * @author Presta-Module.com <support@presta-module.com>
 * @copyright Presta-Module 2014
 *
 * 		 	 ____     __  __
 * 			|  _ \   |  \/  |
 * 			| |_) |  | |\/| |
 * 			|  __/   | |  | |
 * 			|_|      |_|  |_|
 *
 *
 *************************************
 **         AdvancedSearch_4         *
 **   http://www.presta-module.com   *
 *************************************
 * + Multi-layered search engine and search by steps
 * + PS version: 1.4, 1.5, 1.6
 ****/
class AdvancedSearchSeoClass extends ObjectModel {
	public 		$id;
	public 		$id_search;
	public 		$id_currency;
	public 		$meta_title;
	public 		$meta_description;
	public 		$meta_keywords;
	public		$title;
	public		$seo_url;
	public		$description;
	public		$criteria;
	public		$deleted;
	public		$seo_key;
	public		$cross_links;
	protected 	$tables = array ('pm_advancedsearch_seo','pm_advancedsearch_seo_lang');
	protected 	$fieldsRequired = array('id_search','criteria','seo_key');
 	protected 	$fieldsSize = array();
 	protected 	$fieldsValidate = array();
 	protected 	$fieldsRequiredLang = array('meta_title','meta_description','title','seo_url');
 	protected 	$fieldsSizeLang = array('meta_title' => 128, 'meta_description' => 255,
		'title' => 128, 'seo_url' => 128, 'meta_keywords' => 255);
 	protected 	$fieldsValidateLang = array('meta_title'=>'isGenericName',
	 	'meta_description'	=>'isGenericName',
	 	'meta_keywords'		=>'isGenericName',
	 	'title'				=>'isGenericName',
	 	'description'		=>'isString',
	 	'seo_url'			=>'isGenericName'
 	);
	public static $definition = array(
		'table' => 'pm_advancedsearch_seo',
		'primary' => 'id_seo',
		'multishop' => false,
		'fields' => array(
			'meta_title' 				=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'meta_description' 			=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'title' 					=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'seo_url' 					=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'meta_keywords' 			=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'description' 				=> 				array('type' => 3, 'lang' => true, 'required' => false)
		)
	);
	protected 	$table = 'pm_advancedsearch_seo';
	public 	$identifier = 'id_seo';
	public function __construct($id_seo = NULL, $id_lang=NULL, $id_shop=NULL) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			parent::__construct($id_seo, $id_lang, $id_shop);
		} else {
			parent::__construct($id_seo, $id_lang);
		}
	}
	public function getFields() {
		parent::validateFields();
		if (isset($this->id))
			$fields['id_seo'] = intval($this->id);
		$fields['id_search'] = intval($this->id_search);
		$fields['id_currency'] = intval($this->id_currency);
		$fields['criteria'] = pSQL($this->criteria);
		$fields['deleted'] = intval($this->deleted);
		$fields['seo_key'] = pSQL($this->seo_key);
		return $fields;
	}
	public function getTranslationsFieldsChild() {
		parent::validateFieldsLang();
		$fieldsArray = array('meta_title','meta_description','title','seo_url','meta_keywords');
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
		foreach ($languages as $language)
		{
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = intval($this->id);
			$fields[$language['id_lang']]['description'] = (isset($this->description[$language['id_lang']]) AND !empty($this->description[$language['id_lang']])) ? pSQL($this->description[$language['id_lang']], true) : pSQL($this->description[$defaultLanguage], true);
			foreach ($fieldsArray as $field)
			{
				if (!Validate::isTableOrIdentifier($field))
					die(Tools::displayError());
				if (isset($this->{$field}[$language['id_lang']]) AND !empty($this->{$field}[$language['id_lang']]))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$language['id_lang']]);
				else
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$defaultLanguage]);
			}
		}
		return $fields;
	}
	public	function save($nullValues = false, $autodate = true) {
		$newCriteria = array();
		if (!preg_match('#\{i:#', $this->criteria)) {
			$criteria = explode(',', $this->criteria);
			if (sizeof($criteria)) {
				foreach ($criteria as $k => $value )
					$newCriteria[] = preg_replace('/^biscriterion_/','', $value);
				$this->criteria = serialize($newCriteria);
			}
		}
		if ($this->id)
			$this->cleanCrossLinks();
		if (!$this->id_currency)
			$this->id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
		$ret = parent::save($nullValues, $autodate);
		if (is_array($this->cross_links) && sizeof($this->cross_links))
			$this->saveCrossLinks();
		return $ret;
	}
	public function delete() {
		$this->cleanCrossLinks();
		return parent::delete();
	}
	public static function deleteByIdSearch($id_search) {
		Db::getInstance()->Execute('DELETE adss.*, adssl.*, ascl.*  FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` )
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` ascl ON (ascl.`id_seo_linked` = adssl.`id_seo` )
		WHERE `id_search` = '.intval($id_search));
	}
	public function cleanCrossLinks() {
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` WHERE `id_seo` = '.intval($this->id) . ' OR `id_seo_linked` = '.intval($this->id));
	}
	public function saveCrossLinks() {
		foreach($this->cross_links as $id_seo_linked) {
			$row = array('id_seo' => intval($this->id), 'id_seo_linked' => intval($id_seo_linked));
			Db::getInstance()->AutoExecute(_DB_PREFIX_.'pm_advancedsearch_seo_crosslinks', $row, 'INSERT');
		}
	}
	private static $_getCrossLinksOptionsSelectedCache = array();
	public function getCrossLinksOptionsSelected($id_lang) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getCrossLinksOptionsSelectedCache[$cacheKey])) return self::$_getCrossLinksOptionsSelectedCache[$cacheKey];
		$result = Db::getInstance()->ExecuteS('
		SELECT ascl.`id_seo_linked`, adssl.`title`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` ascl
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (ascl.`id_seo_linked` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
		WHERE ascl.`id_seo` = '.(int)($this->id));
		$return = array();
		foreach($result as $row) {
			$return[$row['id_seo_linked']] = $row['title'];
		}
		self::$_getCrossLinksOptionsSelectedCache[$cacheKey] = $return;
		return self::$_getCrossLinksOptionsSelectedCache[$cacheKey];
	}
	private static $_getCrossLinksAvailableCache = array();
	public static function getCrossLinksAvailable($id_lang, $id_excludes = false, $query_search = false, $count = false, $limit = false, $start = 0) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getCrossLinksAvailableCache[$cacheKey])) return self::$_getCrossLinksAvailableCache[$cacheKey];
		if ($count) {
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT COUNT(adss.`id_seo`) AS nb
			FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
			WHERE '.($id_excludes ? ' adss.`id_seo` NOT IN('.pSQL(implode(',', $id_excludes)).') AND ':'').'adss.`deleted` = 0
			'.($query_search ? ' AND adssl.`title` LIKE "%'.pSQL($query_search).'%"' : '').'
			ORDER BY adss.`id_seo`');
			self::$_getCrossLinksAvailableCache[$cacheKey] = (int)($result['nb']);
			return self::$_getCrossLinksAvailableCache[$cacheKey];
		}
		$result = Db::getInstance()->ExecuteS('
		SELECT adss.`id_seo`, adssl.`title`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
		WHERE '.($id_excludes ? ' adss.`id_seo` NOT IN('.pSQL(implode(',', $id_excludes)).') AND ':'').'adss.`deleted` = 0
		'.($query_search ? ' AND adssl.`title` LIKE "%'.pSQL($query_search).'%"' : '').'
		ORDER BY adss.`id_seo`
		'.($limit? 'LIMIT '.$start.', '.(int)$limit : ''));
		$return = array();
		foreach($result as $row) {
			$return[$row['id_seo']] = $row['title'];
		}
		self::$_getCrossLinksAvailableCache[$cacheKey] = $return;
		return self::$_getCrossLinksAvailableCache[$cacheKey];
	}
	private static $_getSeoSearchsCache = array();
	public static function getSeoSearchs($id_lang = false, $withDeleted = 0, $id_search = false) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getSeoSearchsCache[$cacheKey])) return self::$_getSeoSearchsCache[$cacheKey];
		self::$_getSeoSearchsCache[$cacheKey] = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )' : '').'
		WHERE 1
		'.(!$withDeleted ? ' AND adss.`deleted` = 0':'').'
		'.($id_search ? ' AND adss.`id_search` = '.(int)$id_search:'').'
		GROUP BY adss.`id_seo`
		ORDER BY adss.`id_seo`');
		return self::$_getSeoSearchsCache[$cacheKey];
	}
	private static $_getCrossLinksSeoCache = array();
	public static function getCrossLinksSeo($id_lang, $id_seo) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getCrossLinksSeoCache[$cacheKey])) return self::$_getCrossLinksSeoCache[$cacheKey];
		self::$_getCrossLinksSeoCache[$cacheKey] = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` ascl ON (adss.`id_seo` = ascl.`id_seo_linked` )
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
		WHERE ascl.`id_seo` = '.(int)$id_seo.' AND adss.`id_seo` != '.(int)$id_seo.' AND adss.`deleted` = 0
		GROUP BY adss.`id_seo`
		ORDER BY adss.`id_seo`');
		return self::$_getCrossLinksSeoCache[$cacheKey];
	}
	private static $_getSeoSearchBySeoUrlCache = array();
	public static function getSeoSearchBySeoUrl($seo_url, $id_lang) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getSeoSearchBySeoUrlCache[$cacheKey])) return self::$_getSeoSearchBySeoUrlCache[$cacheKey];
		self::$_getSeoSearchBySeoUrlCache[$cacheKey] = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo`'.($id_lang?' AND adssl.`id_lang` = '.((int) $id_lang):'').' )
		WHERE `seo_url` = "'.pSQL($seo_url).'"
		LIMIT 1');
		return self::$_getSeoSearchBySeoUrlCache[$cacheKey];
	}
	private static $_getSeoSearchByIdSeoCache = array();
	public static function getSeoSearchByIdSeo($id_seo, $id_lang) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getSeoSearchByIdSeoCache[$cacheKey])) return self::$_getSeoSearchByIdSeoCache[$cacheKey];
		self::$_getSeoSearchByIdSeoCache[$cacheKey] = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).')
		WHERE adss.`id_seo` = "'.((int) $id_seo).'"
		GROUP BY adss.`id_seo`
		LIMIT 1');
		return self::$_getSeoSearchByIdSeoCache[$cacheKey];
	}
	private static $_seoExistsCache = array();
	public static function seoExists($seo_key) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_seoExistsCache[$cacheKey])) return self::$_seoExistsCache[$cacheKey];
		$row = Db::getInstance()->getRow('
			SELECT `id_seo`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_seo`
			WHERE `seo_key` = "'.pSQL($seo_key).'"
			AND `deleted`=0');
		self::$_seoExistsCache[$cacheKey] = (isset($row['id_seo']) ? $row['id_seo'] : false);
		return self::$_seoExistsCache[$cacheKey];
	}
	private static $_seoDeletedExistsCache = array();
	public static function seoDeletedExists($seo_key) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_seoDeletedExistsCache[$cacheKey])) return self::$_seoDeletedExistsCache[$cacheKey];
		$row = Db::getInstance()->getRow('
			SELECT `id_seo`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_seo`
			WHERE `seo_key` = "'.pSQL($seo_key).'" AND `deleted` = 1');
		self::$_seoDeletedExistsCache[$cacheKey] = (isset($row['id_seo']) ? $row['id_seo'] : false);
		return self::$_seoDeletedExistsCache[$cacheKey];
	}
	public static function undeleteSeoBySeoKey($seo_key) {
		$row = array('deleted' => 0);
		Db::getInstance()->AutoExecute(_DB_PREFIX_.'pm_advancedsearch_seo', $row, 'UPDATE','`seo_key` = "'.pSQL($seo_key).'" AND deleted = 1');
	}
	private static $_getSeoPageUrlCache = array();
	public static function getSeoPageUrl($idSeo, $idLang) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getSeoPageUrlCache[$cacheKey])) return self::$_getSeoPageUrlCache[$cacheKey];
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive())
			$baseUri = Context::getContext()->shop->getBaseURL() . (Language::countActiveLanguages() > 1 ? Language::getIsoById($idLang) . '/' : '') . 's/' . $idSeo . '/';
		else
			$baseUri = Tools::getShopDomain(true) . __PS_BASE_URI__ . (Language::countActiveLanguages() > 1 ? Language::getIsoById($idLang) . '/' : '') . 's/' . $idSeo . '/';
		$seoPageUrl = Db::getInstance()->getValue('SELECT `seo_url` FROM `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` WHERE `id_seo`="' . (int)$idSeo . '" AND `id_lang`="' . (int)$idLang . '"');
		self::$_getSeoPageUrlCache[$cacheKey] = ($seoPageUrl !== false ? $baseUri.$seoPageUrl : false);
		return self::$_getSeoPageUrlCache[$cacheKey];
	}
}
