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
class		AdvancedTopMenuClass extends ObjectModel
{
	public 		$id;

	public 		$id_category;

	public 		$id_cms;

	public 		$id_supplier;

	public 		$id_manufacturer;

	/** @var string Name */
	public 		$name;

	/** @var string Link */
	public 		$link;

	/** @var boolean Status for display */
	public 		$active = 1;

	public 		$type;

	public 		$privacy;

	public 		$have_icon;

	public 		$image_type;

	public 		$value_over;

	public 		$value_under;

	public 		$target;

	public		$txt_color_menu_tab;

	public		$txt_color_menu_tab_hover;

	public		$fnd_color_menu_tab;

	public		$fnd_color_menu_tab_over;

	public 		$width_submenu;

	public 		$minheight_submenu;

	public 		$position_submenu;

	public		$fnd_color_submenu;

	public		$border_color_submenu;

	public 		$border_color_tab;

	public 		$border_size_tab;

	public 		$border_size_submenu;


	protected $tables = array ('pm_advancedtopmenu', 'pm_advancedtopmenu_lang');

	protected 	$fieldsRequired = array('active','type');
 	protected 	$fieldsSize = array('active' => 1);
 	protected 	$fieldsValidate = array('active' => 'isBool');
	protected 	$fieldsRequiredLang = array();
 	protected 	$fieldsSizeLang = array('name' => 64);
 	protected 	$fieldsValidateLang = array('name' => 'isCatalogName','link'=>'isUrl');

	protected 	$table = 'pm_advancedtopmenu';
	protected 	$identifier = 'id_menu';

	public function __construct($id_menu = NULL, $id_lang = NULL)
	{
		 if(_PS_VERSION_ < 1.3) {
			$this->fieldsValidateLang['value_over'] = 'isCleanHTML';
			$this->fieldsValidateLang['value_under'] = 'isCleanHTML';
		 }else {
		 	$this->fieldsValidateLang['value_over'] = 'isString';
			$this->fieldsValidateLang['value_under'] = 'isString';
		 }
		parent::__construct($id_menu, $id_lang);
	}

	public function getFields()
	{
		parent::validateFields();
		if (isset($this->id))
			$fields['id_menu'] = intval($this->id);
		$fields['active'] 	= intval($this->active);
		$fields['have_icon'] = intval($this->have_icon);
		$fields['image_type'] = pSQL($this->image_type);
		$fields['id_category'] = intval($this->id_category);
		$fields['id_cms'] = intval($this->id_cms);
		$fields['id_supplier'] = intval($this->id_supplier);
		$fields['id_manufacturer'] = intval($this->id_manufacturer);
		$fields['type'] = intval($this->type);
		$fields['target'] = pSQL($this->target);
		$fields['privacy'] = intval($this->privacy);
		$fields['txt_color_menu_tab'] = pSQL($this->txt_color_menu_tab);
		$fields['txt_color_menu_tab_hover'] = pSQL($this->txt_color_menu_tab_hover);
		$fields['fnd_color_menu_tab'] = pSQL($this->fnd_color_menu_tab);
		$fields['fnd_color_menu_tab_over'] = pSQL($this->fnd_color_menu_tab_over);
		$fields['width_submenu'] = pSQL($this->width_submenu);
		$fields['minheight_submenu'] = pSQL($this->minheight_submenu);
		$fields['position_submenu'] = intval($this->position_submenu);
		$fields['fnd_color_submenu'] = pSQL($this->fnd_color_submenu);
		$fields['border_color_submenu'] = pSQL($this->border_color_submenu);
		$fields['border_color_tab'] = pSQL($this->border_color_tab);
		$fields['border_size_tab'] = pSQL($this->border_size_tab);
		$fields['border_size_submenu'] = pSQL($this->border_size_submenu);
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
		$fieldsArray = array('name','link');
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
		foreach ($languages as $language)
		{
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = intval($this->id);
			$fields[$language['id_lang']]['value_over'] = (isset($this->value_over[$language['id_lang']])) ? pSQL($this->value_over[$language['id_lang']], true) : '';

			$fields[$language['id_lang']]['value_under'] = (isset($this->value_under[$language['id_lang']])) ? pSQL($this->value_under[$language['id_lang']], true) : '';
			foreach ($fieldsArray as $field)
			{
				if (!Validate::isTableOrIdentifier($field))
					die(Tools::displayError());

				/* Check fields validity */
				if (isset($this->{$field}[$language['id_lang']]) AND !empty($this->{$field}[$language['id_lang']]))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$language['id_lang']]);
				elseif (in_array($field, $this->fieldsRequiredLang))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$defaultLanguage]);
				else
					$fields[$language['id_lang']][$field] = '';
			}
		}
		return $fields;
	}

	public	function add($autodate = true, $nullValues = false)
	{

		$ret = parent::add($autodate,$nullValues);
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
		foreach ($toDelete as $id_menu) {
			if(file_exists(_PS_ROOT_DIR_.'/modules/pm_advancedtopmenu/menu_icons/'.$id_menu. '.'.($this->image_type?$this->image_type:'jpg'))) {
				@unlink(_PS_ROOT_DIR_.'/modules/pm_advancedtopmenu/menu_icons/'.$id_menu. '.'.($this->image_type?$this->image_type:'jpg'));
			}
		}
		/* Delete its child from database */
		$list = sizeof($toDelete) > 1 ? implode(',', $toDelete) : intval($this->id);
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedtopmenu` WHERE `id_menu` IN ('.$list.')');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedtopmenu_lang` WHERE `id_menu` IN ('.$list.')');
		$columnsWrap = AdvancedTopMenuColumnWrapClass::getColumnWrapIds($list);
		foreach ($columnsWrap as $id_wrap) {
			$obj = new AdvancedTopMenuColumnWrapClass($id_wrap);
			$obj->delete();
		}
		return true;
	}
	public static function menuHaveDepend($id_menu)
	{
		$sql = 'SELECT `id_column`
				FROM `'._DB_PREFIX_.'pm_advancedtopmenu_columns`
				WHERE `id_menu_depend` = '.intval($id_menu);
		return Db::getInstance()->ExecuteS($sql);
	}
	public static function getMenus($id_lang,$active = true)
	{
		$sql = 'SELECT atp.*, atpl.*,
				cl.link_rewrite, cl.meta_title,
				cal.link_rewrite as category_link_rewrite, cal.name as category_name,
				m.name as manufacturer_name,
				s.name as supplier_name
				FROM `'._DB_PREFIX_.'pm_advancedtopmenu` atp
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedtopmenu_lang` atpl ON (atp.`id_menu` = atpl.`id_menu` AND atpl.`id_lang` = '.intval($id_lang).')
				LEFT JOIN '._DB_PREFIX_.'cms c ON (c.id_cms = atp.`id_cms`)
				LEFT JOIN '._DB_PREFIX_.'cms_lang cl ON (c.id_cms = cl.id_cms AND cl.id_lang = '.intval($id_lang).')
				LEFT JOIN '._DB_PREFIX_.'category ca ON (ca.id_category = atp.`id_category`)
				LEFT JOIN '._DB_PREFIX_.'category_lang cal ON (ca.id_category = cal.id_category AND cal.id_lang = '.intval($id_lang).')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (atp.`id_manufacturer` = m.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (atp.`id_supplier` = s.`id_supplier`)
				'.($active?'WHERE atp.`active` = 1 ':'').'
				'.($active?'AND	((atp.`id_manufacturer` = 0 AND atp.`id_supplier` = 0 AND atp.`id_category` = 0 AND atp.`id_cms` = 0)
				OR c.id_cms IS NOT NULL OR m.id_manufacturer IS NOT NULL OR ca.id_category IS NOT NULL OR s.`id_supplier` IS NOT NULL)':'').'
				ORDER BY atp.`position`';
		return Db::getInstance()->ExecuteS($sql);
	}
}

?>