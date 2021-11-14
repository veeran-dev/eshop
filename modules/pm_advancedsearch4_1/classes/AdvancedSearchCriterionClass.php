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
class AdvancedSearchCriterionClass extends ObjectModel {
	public 		$id;
	public 		$id_criterion_group;
	public		$id_criterion_linked;
	public 		$value;
	public 		$icon;
	public 		$color;
	public 		$single_value;
	public		$visible = 1;
	public 		$level_depth;
	public 		$id_parent;
	public 		$position;
	public 		$is_custom;
	protected 	$tables = array ('pm_advancedsearch_criterion','pm_advancedsearch_criterion_lang');
	protected 	$originalTables = array ('pm_advancedsearch_criterion','pm_advancedsearch_criterion_lang');
	public 	$id_search;
	protected 	$fieldsRequired = array('id_criterion_group');
 	protected 	$fieldsSize = array();
 	protected 	$fieldsValidate = array();
 	protected 	$fieldsRequiredLang = array('value');
 	protected 	$fieldsSizeLang = array();
 	protected 	$fieldsValidateLang = array('value'=>'isString');
	protected 	$table = 'pm_advancedsearch_criterion';
	protected 	$originalTable = 'pm_advancedsearch_criterion';
	public 	$identifier = 'id_criterion';
	public static $definition = array(
		'table' => 'pm_advancedsearch_criterion',
		'primary' => 'id_criterion',
		'multishop' => false,
		'fields' => array(
			'value' 		=> 				array('type' => 3, 'lang' => true, 'required' => true, 'validate' => 'isString'),
			'icon' 			=> 				array('type' => 3, 'lang' => true, 'required' => false)
		)
	);
	private function _overrideTableDefinition($id_search) {
		$this->id_search = ((int)$id_search ? (int)$id_search : (Tools::getIsset('id_search') && Tools::getValue('id_search') ? (int)Tools::getValue('id_search') : die('Missing id_search')));
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$className = get_class($this);
			self::$definition['table'] = $this->originalTable . '_' . (int)$this->id_search;
			self::$definition['classname'] = $className . '_' . (int)$this->id_search;
			$this->def['table'] = $this->originalTable . '_' . (int)$this->id_search;
			$this->def['classname'] = $className . '_' . (int)$this->id_search;
			if (isset(ObjectModel::$loaded_classes) && isset(ObjectModel::$loaded_classes[$className]))
				unset(ObjectModel::$loaded_classes[$className]);
		}
		$this->table = $this->originalTable . '_' . (int)$this->id_search;
		foreach($this->originalTables as $key => $table)
			$this->tables[$key] = $table . '_' . (int)$this->id_search;
	}
	protected function setDefinitionRetrocompatibility() {
		parent::setDefinitionRetrocompatibility();
		$this->_overrideTableDefinition((int)$this->id_search);
	}
	public function __construct($id_criterion = NULL, $id_search = NULL, $id_lang=NULL, $id_shop = null) {
		$this->_overrideTableDefinition((int)$id_search);
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			parent::__construct($id_criterion, $id_lang, $id_shop);
		} else {
			parent::__construct($id_criterion, $id_lang);
		}
		if ($this->id && !isset($this->id_criterion_linked)) {
			$id_criterion_link = self::getIdCriterionLinkByIdCriterion($this->id_search, $this->id);
			if ($id_criterion_link !== false)
				$this->id_criterion_linked = $id_criterion_link;
			unset($id_criterion_link);
		}
	}
	public function save($null_values = false, $autodate = true) {
	 	$saveResult = parent::save($null_values, $autodate);
		if ($saveResult) {
			self::populateCriterionsLink((int)$this->id_search, $this->id, $this->id_criterion_linked);
			self::addCriterionToList((int)$this->id_search, $this->id, $this->id);
		}
		return $saveResult;
	}
	public function __destruct() {
		if (is_object($this)) {
			$class = get_class($this);
			if (method_exists('Cache', 'clean')) Cache::clean('objectmodel_def_'.$class);
			if (method_exists($this, 'clearCache')) $this->clearCache(true);
		}
	}
	public function delete() {
		if (isset($this->icon) && AdvancedSearchCoreClass::_isFilledArray($this->icon)) {
			foreach ($this->icon as $icon) {
				if ($icon && file_exists(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions/'.$icon)) {
					@unlink(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions/'.$icon);
				}
			}
		}
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$this->id_search.'_link` WHERE `'.$this->identifier.'` = '.intval($this->id));
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$this->id_search.'_list` WHERE `id_criterion_parent` = ' . (int)$this->id . ' OR `id_criterion` = ' . (int)$this->id);
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int)$this->id_search.'` WHERE `id_criterion` = '.(int) $this->id);
		return parent::delete ();
	}
	public function getFields() {
		parent::validateFields();
		if (isset($this->id))
			$fields['id_criterion'] = intval($this->id);
		$fields['id_criterion_group'] = intval($this->id_criterion_group);
		$fields['level_depth'] = intval($this->level_depth);
		$fields['color'] = pSQL($this->color);
		$fields['single_value'] = pSQL($this->single_value);
		$fields['visible'] = intval($this->visible);
		$fields['id_parent'] = intval($this->id_parent);
		$fields['position'] = intval($this->position);
		$fields['is_custom'] = intval($this->is_custom);
		return $fields;
	}
	public function getTranslationsFieldsChild() {
		parent::validateFieldsLang();
		return parent::getTranslationsFields(array('value','icon'));
	}
	private static $_getCriterionsStaticIdCache = array();
	public static function getCriterionsStatic($id_search, $id_criterion_group, $id_lang = false) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getCriterionsStaticIdCache[$cacheKey])) return self::$_getCriterionsStaticIdCache[$cacheKey];
		self::$_getCriterionsStaticIdCache[$cacheKey] = Db::getInstance()->ExecuteS('SELECT ac.* '.((int) $id_lang ? ', acl.*':'').'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').'
		WHERE ac.`id_criterion_group` = '.(int)$id_criterion_group);
		return self::$_getCriterionsStaticIdCache[$cacheKey];
	}
	private static $_getCustomCriterionsCache = array();
	public static function getCustomCriterions($idSearch, $idCriterionGroup, $idLang = false) {
		$cacheKey = $idSearch.'-'.(int)$idCriterionGroup.'-'.(int)$idLang;
		if (isset(self::$_getCustomCriterionsCache[$cacheKey])) return self::$_getCustomCriterionsCache[$cacheKey];
		else $result = Db::getInstance()->ExecuteS('SELECT ac.* '.((int) $idLang ? ', acl.*':'').'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'` ac
		'.($idLang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $idLang.')' : '').'
		WHERE ac.`is_custom`=1
		AND ac.`id_criterion_group` = '.(int)$idCriterionGroup);
		self::$_getCustomCriterionsCache[$cacheKey] = array();
		if (is_array($result) && sizeof($result))
			foreach ($result as $row)
				self::$_getCustomCriterionsCache[$cacheKey][$row['id_criterion']] = $row['value'];
		return self::$_getCustomCriterionsCache[$cacheKey];
	}
	private static $_getIdCriterionsGroupByIdCriterionCache = array();
	public static function getIdCriterionsGroupByIdCriterion($id_search, $selected_criterion, $visible = false) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getIdCriterionsGroupByIdCriterionCache[$cacheKey])) return self::$_getIdCriterionsGroupByIdCriterionCache[$cacheKey];
		$results = Db::getInstance()->ExecuteS('
		SELECT DISTINCT ac.`id_criterion_group`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		WHERE ac.`id_criterion` IN('.implode(',', $selected_criterion).')
		'.($visible ? ' AND `visible` = 1' : '').'');
		$return = array();
		foreach($results as $row)
			$return[] = $row['id_criterion_group'];
		self::$_getIdCriterionsGroupByIdCriterionCache[$cacheKey] = $return;
		return self::$_getIdCriterionsGroupByIdCriterionCache[$cacheKey];
	}
	private static $_getCriterionsByIdCache = array();
	public static function getCriterionsById($id_search, $id_lang, $selected_criterion, $visible = false) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getCriterionsByIdCache[$cacheKey])) return self::$_getCriterionsByIdCache[$cacheKey];
		self::$_getCriterionsByIdCache[$cacheKey] = Db::getInstance()->ExecuteS('
		SELECT ac.* '.((int) $id_lang ? ', acl.*':'').'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').'
		WHERE ac.`id_criterion` IN('.implode(',', $selected_criterion).')
		'.($visible ? ' AND `visible` = 1' : '').'');
		return self::$_getCriterionsByIdCache[$cacheKey];
	}
	private static $_getCriterionValueByIdCache = array();
	public static function getCriterionValueById($id_search, $id_lang, $id_criterion) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getCriterionValueByIdCache[$cacheKey])) return self::$_getCriterionValueByIdCache[$cacheKey];
		self::$_getCriterionValueByIdCache[$cacheKey] = Db::getInstance()->getRow('
				SELECT ac.id_criterion, IF(ac.`single_value` != "",ac.`single_value`,acl.`value`) AS `value`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')
				WHERE ac.`id_criterion` = '.(int)$id_criterion);
		return self::$_getCriterionValueByIdCache[$cacheKey];
	}
	private static $_getIdCriterionByTypeAndIdLinkedCache = array();
	public static function getIdCriterionByTypeAndIdLinked($id_search, $criterions_group_type, $id_criterion_group_linked, $id_criterion_linked) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getIdCriterionByTypeAndIdLinkedCache[$cacheKey])) return self::$_getIdCriterionByTypeAndIdLinkedCache[$cacheKey];
		$row = Db::getInstance()->getRow('
		SELECT ac.`id_criterion`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion_group` = acg.`id_criterion_group`)
		JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_link` aclink ON (ac.`is_custom` = 0 AND ac.`id_criterion` = aclink.`id_criterion`)
		WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).' AND aclink.`id_criterion_linked` = '.(int)($id_criterion_linked));
		if (isset($row['id_criterion']) AND $row['id_criterion']) {
			self::$_getIdCriterionByTypeAndIdLinkedCache[$cacheKey] = (int)$row['id_criterion'];
			return self::$_getIdCriterionByTypeAndIdLinkedCache[$cacheKey];
		}
		return 0;
	}
	private static $_getIdCriterionByTypeAndValueCache = array();
	public static function getIdCriterionByTypeAndValue($id_search, $id_lang, $criterions_group_type, $id_criterion_group_linked, $criterion_value) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getIdCriterionByTypeAndValueCache[$cacheKey])) return self::$_getIdCriterionByTypeAndValueCache[$cacheKey];
		$row = Db::getInstance()->getRow('
		SELECT ac.`id_criterion`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion_group` = acg.`id_criterion_group`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')
		WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).' AND TRIM(acl.`value`) LIKE "'.trim(pSQL($criterion_value)).'"');
		if (isset($row['id_criterion']) AND $row['id_criterion']) {
			self::$_getIdCriterionByTypeAndValueCache[$cacheKey] = (int)$row['id_criterion'];
			return self::$_getIdCriterionByTypeAndValueCache[$cacheKey];
		}
		return 0;
	}
	private static $_getIdCriterionByTypeAndSingleValueCache = array();
	public static function getIdCriterionByTypeAndSingleValue($id_search, $criterions_group_type, $id_criterion_group_linked, $criterion_value) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getIdCriterionByTypeAndSingleValueCache[$cacheKey])) return self::$_getIdCriterionByTypeAndSingleValueCache[$cacheKey];
		$row = Db::getInstance()->getRow('
				SELECT ac.`id_criterion`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion_group` = acg.`id_criterion_group`)
				WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).' AND TRIM(ac.`single_value`) LIKE "'.trim(pSQL($criterion_value)).'"');
		if (isset($row['id_criterion']) AND $row['id_criterion']) {
			self::$_getIdCriterionByTypeAndSingleValueCache[$cacheKey] = (int)$row['id_criterion'];
			return self::$_getIdCriterionByTypeAndSingleValueCache[$cacheKey];
		}
		return 0;
	}
	private static $_getIdCriterionGroupByIdCriterionCache = array();
	public static function getIdCriterionGroupByIdCriterion($id_search, $id_criterion) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getIdCriterionGroupByIdCriterionCache[$cacheKey])) return self::$_getIdCriterionGroupByIdCriterionCache[$cacheKey];
		$row = Db::getInstance()->getRow('
		SELECT ac.`id_criterion_group`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		WHERE ac.`id_criterion` = "'.(int)($id_criterion).'"');
		if (isset($row['id_criterion_group']) AND $row['id_criterion_group']) {
			self::$_getIdCriterionGroupByIdCriterionCache[$cacheKey] = (int)$row['id_criterion_group'];
			return self::$_getIdCriterionGroupByIdCriterionCache[$cacheKey];
		}
		return 0;
	}
	private static $_getCustomCriterionsLinkIdsCache = array();
	public static function getCustomCriterionsLinkIds($idSearch, $criterions = array()) {
		$cacheKey = $idSearch.'-'.sizeof($criterions);
		if (isset(self::$_getCustomCriterionsLinkIdsCache[$cacheKey])) return self::$_getCustomCriterionsLinkIdsCache[$cacheKey];
		else $result = Db::getInstance()->ExecuteS('
		SELECT aclist.`id_criterion_parent`, aclist.`id_criterion`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'` ac
		JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'_list` aclist ON (ac.`id_criterion` = aclist.`id_criterion_parent`)
		WHERE ac.`is_custom`=1');
		self::$_getCustomCriterionsLinkIdsCache[$cacheKey] = array();
		if (is_array($result) && sizeof($result))
			foreach ($result as $row)
				self::$_getCustomCriterionsLinkIdsCache[$cacheKey][(int)$row['id_criterion_parent']][] = (int)$row['id_criterion'];
		return self::$_getCustomCriterionsLinkIdsCache[$cacheKey];
	}
	private static $_getCustomCriterionsLinkIdsByGroupCache = array();
	public static function getCustomCriterionsLinkIdsByGroup($idSearch, $idCriterionGroup) {
		$cacheKey = $idSearch.'-'.$idCriterionGroup;
		if (isset(self::$_getCustomCriterionsLinkIdsByGroupCache[$cacheKey])) return self::$_getCustomCriterionsLinkIdsByGroupCache[$cacheKey];
		else $result = Db::getInstance()->ExecuteS('
		SELECT aclist.`id_criterion_parent`, aclist.`id_criterion`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'` ac
		JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'_list` aclist ON (ac.`id_criterion` = aclist.`id_criterion_parent`)
		WHERE ac.`is_custom`=1 AND ac.`id_criterion_group`=' . (int)$idCriterionGroup);
		self::$_getCustomCriterionsLinkIdsByGroupCache[$cacheKey] = array();
		if (is_array($result) && sizeof($result))
			foreach ($result as $row)
				self::$_getCustomCriterionsLinkIdsByGroupCache[$cacheKey][(int)$row['id_criterion_parent']][] = (int)$row['id_criterion'];
		return self::$_getCustomCriterionsLinkIdsByGroupCache[$cacheKey];
	}
	private static $_getCustomMasterIdCriterionCache = array();
	public static function getCustomMasterIdCriterion($idSearch, $idCriterion) {
		$cacheKey = $idSearch.'-'.(int)$idCriterion;
		if (isset(self::$_getCustomMasterIdCriterionCache[$cacheKey])) return self::$_getCustomMasterIdCriterionCache[$cacheKey];
		else $result = Db::getInstance()->getValue('SELECT aclist.`id_criterion_parent`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'` ac
		JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $idSearch.'_list` aclist ON (ac.`id_criterion` = aclist.`id_criterion_parent`)
		WHERE ac.`is_custom`=1 AND aclist.`id_criterion`='.(int)$idCriterion);
		if ($result > 0) self::$_getCustomMasterIdCriterionCache[$cacheKey] = (int)$result;
		else self::$_getCustomMasterIdCriterionCache[$cacheKey] = false;
		return self::$_getCustomMasterIdCriterionCache[$cacheKey];
	}
	private static $_getIdCriterionLinkByIdCriterionCache = array();
	public static function getIdCriterionLinkByIdCriterion($id_search, $id_criterion) {
		$cacheKey = sha1(serialize(func_get_args()));
		if (isset(self::$_getIdCriterionLinkByIdCriterionCache[$cacheKey])) return self::$_getIdCriterionLinkByIdCriterionCache[$cacheKey];
		$row = Db::getInstance()->getRow('
		SELECT GROUP_CONCAT(`id_criterion_linked`) as `id_criterion_linked`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_' . (int)$id_search . '_link`
		WHERE `id_criterion` = ' . (int)$id_criterion);
		self::$_getIdCriterionLinkByIdCriterionCache[$cacheKey] = isset($row['id_criterion_linked']) ? explode(',', $row['id_criterion_linked']) : false;
		return self::$_getIdCriterionLinkByIdCriterionCache[$cacheKey];
	}
	public static function addCriterionToList($idSearch, $idCriterionParent, $idCriterion) {
		return Db::getInstance()->Execute('
		INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_list`
		(`id_criterion_parent`, `id_criterion`) 
		VALUES ('. (int)$idCriterionParent. ', '. (int)$idCriterion .')');
	}
	public static function removeCriterionFromList($idSearch, $idCriterionParent, $idCriterion) {
		return Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_list` WHERE `id_criterion_parent`='.(int)$idCriterionParent . ' AND `id_criterion`='.(int)$idCriterion);
	}
	public static function populateCriterionsLink($idSearch, $idCriterion, $idCriterionLinked = false, $criterionsGroupList = array()) {
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_link` WHERE `id_criterion` = '.(int)$idCriterion);
		if (!$idCriterionLinked && is_array($criterionsGroupList) && sizeof($criterionsGroupList)) {
			Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_link` (`id_criterion`, `id_criterion_linked`) 
			(SELECT "'. (int)$idCriterion .'" AS `id_criterion`, `id_criterion_linked` FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_link` WHERE `id_criterion` IN (' . implode(',', $criterionsGroupList) . '))');
		} else if ($idCriterionLinked || is_array($idCriterionLinked) && sizeof($idCriterionLinked)) {
			if (!is_array($idCriterionLinked))
				$idCriterionLinked = array($idCriterionLinked);
			foreach ($idCriterionLinked as $idCriterionLinkedValue)
				Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_link` (`id_criterion`, `id_criterion_linked`) VALUES ('. (int)$idCriterion. ', '. (int)$idCriterionLinkedValue .')');
		} else if (!$idCriterionLinked) {
			Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_link` (`id_criterion`, `id_criterion_linked`) VALUES ('. (int)$idCriterion. ', 0)');
		}
	}
}
