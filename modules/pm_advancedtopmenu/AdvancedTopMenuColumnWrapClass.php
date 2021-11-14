<?php
/**
  * PM_AdvancedTopMenu Front Office Feature
  *
  * @category menu
  * @authors Jean-Sebastien Couvert & Stephan Obadia / Presta-Module.com <support@presta-module.com>
  * @copyright Presta-Module 2011-2012
  * +
  * +Languages: EN, FR
  * +PS version: 1.4, 1.3, 1.2, 1.1
  **/
class		AdvancedTopMenuColumnWrapClass extends ObjectModel
{
	public 		$id;

	public 		$id_menu;

	/** @var string Name */
	public 		$internal_name;

	/** @var boolean Status for display */
	public 		$active = 1;

	public 		$width;

	public 		$privacy;

	public 		$position;

	public 		$value_over;

	public 		$value_under;

	public 		$bg_color;

	public 		$txt_color_column;

	public 		$txt_color_column_over;

	public 		$txt_color_element;

	public 		$txt_color_element_over;

	public 		$id_menu_depend;

	protected 	$tables = array ('pm_advancedtopmenu_columns_wrap', 'pm_advancedtopmenu_columns_wrap_lang');

	protected 	$fieldsRequired = array('active','id_menu');
 	protected 	$fieldsSize = array('active' => 1);
 	protected 	$fieldsValidate = array('active' => 'isBool');
	protected 	$fieldsRequiredLang = array();
 	protected 	$fieldsSizeLang = array();
 	protected 	$fieldsValidateLang = array();

	protected 	$table = 'pm_advancedtopmenu_columns_wrap';
	protected 	$identifier = 'id_wrap';

	public function __construct($id_wrap = NULL, $id_lang = NULL)
	{
		if(_PS_VERSION_ < 1.3) {
			$this->fieldsValidateLang['value_over'] = 'isCleanHTML';
			$this->fieldsValidateLang['value_under'] = 'isCleanHTML';
		 }else {
		 	$this->fieldsValidateLang['value_over'] = 'isString';
			$this->fieldsValidateLang['value_under'] = 'isString';
		 }
		parent::__construct($id_wrap, $id_lang);
	}

	public function getFields()
	{
		parent::validateFields();
		if (isset($this->id))
			$fields['id_wrap'] = intval($this->id);
		$fields['internal_name'] 	= pSQL($this->internal_name);
		$fields['id_menu'] 	= intval($this->id_menu);
		$fields['active'] 	= intval($this->active);
		$fields['id_menu_depend'] 	= intval($this->id_menu_depend);
		$fields['privacy'] = intval($this->privacy);
		$fields['position'] = intval($this->position);
		$fields['width'] = intval($this->width);
		$fields['bg_color'] = pSQL($this->bg_color);
		$fields['txt_color_column'] = pSQL($this->txt_color_column);
		$fields['txt_color_column_over'] = pSQL($this->txt_color_column_over);
		$fields['txt_color_element'] = pSQL($this->txt_color_element);
		$fields['txt_color_element_over'] = pSQL($this->txt_color_element_over);
		return $fields;
	}

	/**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
	public function getTranslationsFieldsChild()
	{
		parent::validateFieldsLang();
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
		foreach ($languages as $language)
		{
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = intval($this->id);
			$fields[$language['id_lang']]['value_over'] = (isset($this->value_over[$language['id_lang']])) ? pSQL($this->value_over[$language['id_lang']], true) : '';
			$fields[$language['id_lang']]['value_under'] = (isset($this->value_under[$language['id_lang']])) ? pSQL($this->value_under[$language['id_lang']], true) : '';
		}
		return $fields;
	}

	public	function add($autodate = true, $nullValues = false)
	{

		$ret = parent::add($autodate, $nullValues);
		return $ret;
	}

	public	function update($nullValues = false)
	{

		$ret = parent::update($nullValues);
		return $ret;
	}

	public function delete()
	{

		/* Get childs */
		$toDelete = array(intval($this->id));
		$toDelete = array_unique($toDelete);
		/* Delete its child from database */
		$list = sizeof($toDelete) > 1 ? implode(',', $toDelete) : intval($this->id);
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap` WHERE `id_wrap` IN ('.$list.')');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap_lang` WHERE `id_wrap` IN ('.$list.')');
		$columns = AdvancedTopMenuColumnClass::getColumnIds($list);
		foreach ($columns as $id_column) {
			$obj = new AdvancedTopMenuColumnClass($id_column);
			$obj->delete();
		}
		return true;
	}
	public static function getMenuColumnsWrap($id_menu,$id_lang,$active = true)
	{
		$sql = 'SELECT atmcw.*, atmcwl.*
				FROM `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap` atmcw
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap_lang` atmcwl ON (atmcw.`id_wrap` = atmcwl.`id_wrap` AND atmcwl.`id_lang` = '.intval($id_lang).')
				WHERE '.($active?' atmcw.`active` = 1 AND':'').' atmcw.`id_menu` = '.intval($id_menu).'
				ORDER BY atmcw.`position`';
		return Db::getInstance()->ExecuteS($sql);
	}
	public static function getMenusColumnsWrap($menus,$id_lang)
	{
		$columnWrap = array();
		foreach($menus as $menu) {
			$columnWrap[$menu['id_menu']] = self::getMenuColumnsWrap($menu['id_menu'],$id_lang);
		}

		return $columnWrap;
	}
	public static function getColumnsWrap($id_lang = false,$active = true)
	{
		$sql = 'SELECT atmcw.* '.($id_lang?',atmcwl.*':'').'
				FROM `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap` atmcw
				'.($id_lang?'LEFT JOIN `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap_lang` atmcwl ON (atmcw.`id_wrap` = atmcwl.`id_wrap` AND atmcwl.`id_lang` = '.intval($id_lang).')':'').'
				WHERE 1 '.($active?'AND atmcw.`active` = 1':'').'
				ORDER BY atmcw.`position`';
		return Db::getInstance()->ExecuteS($sql);
	}
	public static function getColumnWrapIds($ids_menu)
	{
		$result =  Db::getInstance()->ExecuteS('
		SELECT `id_wrap`
		FROM '._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap
		WHERE `id_menu` IN('.pSQL($ids_menu).')');
		$columnsWrap = array();
		foreach ($result as $row) {
			$columnsWrap[] = $row['id_wrap'];
		}
		return $columnsWrap;
	}
}

?>