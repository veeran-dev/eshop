<?php
/**
 * PM_AdvancedTopMenu Front Office Feature
 *
 * @category menu
 * @authors Jean-Sebastien Couvert & Stephan Obadia / Presta-Module.com <support@presta-module.com>
 * @copyright Presta-Module 2011-2012
 * @version 1.7.9.8
 *
 * *************************************
 * *       AdvancedTopMenu V1      		*
 * *   http://www.presta-module.com   	*
 * *               V 1.7.9.8 :         	*
 * *************************************
 * +
 * +Languages: EN, FR
 * +PS version: 1.4, 1.3, 1.2, 1.1
 **/
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedtopmenu/AdvancedTopMenuClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedtopmenu/AdvancedTopMenuColumnWrapClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedtopmenu/AdvancedTopMenuColumnClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedtopmenu/AdvancedTopMenuElementsClass.php');
class PM_AdvancedTopMenu extends Module {
	private $_html;
	private $_module_prefix = 'ATM';
	private $errors = array ();
	private $defaultLanguage;
	private $languages;
	private $iso_lang;
	//Cache var 4 category product URL (USE 4 retrieve actif category)
	private $current_category_product_url = false;
	private $activeAllreadySet = false;
	private $base_config_url;
	private $gradient_separator = '-';
	private $rebuildable_type = array (3, 4, 5 );
	private $font_families = array ("Arial, Helvetica, sans-serif", "'Arial Black', Gadget, sans-serif", "'Bookman Old Style', serif", "'Comic Sans MS', cursive", "Courier, monospace", "'Courier New', Courier, monospace", "Garamond, serif", "Georgia, serif", "Impact, Charcoal, sans-serif", "'Lucida Console', Monaco, monospace", "'Lucida Sans Unicode', 'Lucida Grande', sans-serif", "'MS Sans Serif', Geneva, sans-serif", "'MS Serif', 'New York', sans-serif", "'Palatino Linotype', 'Book Antiqua', Palatino, serif", "Symbol, sans-serif", "Tahoma, Geneva, sans-serif", "'Times New Roman', Times, serif", "'Trebuchet MS', Helvetica, sans-serif", "Verdana, Geneva, sans-serif", "Webdings, sans-serif", "Wingdings, 'Zapf Dingbats', sans-serif" );
	private $allowFileExtension = array ('gif', 'jpg', 'jpeg', 'png' );
	private $keepVarActif = array ('id_category', 'id_product', 'id_manufacturer', 'id_supplier', 'id_cms' );
	private $link_targets;
	protected static $_forceCompile;
	protected static $_caching;
	protected static $_compileCheck;
	/*Copyright and partner*/
	protected $_copy_and_partner = array(
		array(
			'link'		=> 'http://www.presta-module.com/',
			'target'	=> '_blank',
			'img'		=> 'http://www.presta-module.com/img/logo-module.jpg',
			'style'		=> 'float:left;margin-top:20px;'
		)
	);
	protected $_support_link = false;

	private $tables = array ('pm_advancedtopmenu', 'pm_advancedtopmenu_lang', 'pm_advancedtopmenu_columns_wrap', 'pm_advancedtopmenu_columns_wrap_lang', 'pm_advancedtopmenu_columns', 'pm_advancedtopmenu_columns_lang', 'pm_advancedtopmenu_elements', 'pm_advancedtopmenu_elements_lang' );
	const INSTALL_SQL_FILE = 'install.sql';
	const GLOBAL_CSS_FILE = 'css/pm_advancedtopmenu_global.css';
	const ADVANCED_CSS_FILE = 'css/pm_advancedtopmenu_advanced.css';
	const ADVANCED_CSS_FILE_RESTORE = 'css/reset-pm_advancedtopmenu_advanced.css';
	const DYN_CSS_FILE = 'css/pm_advancedtopmenu.css';
	function __construct() {
		$this->name = 'pm_advancedtopmenu';
		if (_PS_VERSION_ < 1.4)
			$this->tab = 'Presta-Module';
		else {
			$this->author = 'Presta-Module';
			$this->tab = 'front_office_features';
			$this->module_key = '22fb589ff4648a10756b4ad805180259';
		}
		$this->version = '1.7.9.8';

		parent::__construct();

		$this->page = basename(__FILE__, '.php');

		$this->displayName = $this->l('Advanced Top Menu');
		$this->description = $this->l('Horizontal menu with sub menu in column');
		$this->_fieldsOptions = array ('ATM_CACHE' => array ('title' => $this->l('Enable cache'), 'desc' => '', 'cast' => 'intval', 'type' => 'bool', 'default' => true ), 'ATM_AUTOCOMPLET_SEARCH' => array ('title' => $this->l('Enable autocomplete for search type'), 'desc' => '', 'cast' => 'intval', 'type' => 'bool', 'default' => true ), 'ATM_MENU_GLOBAL_ACTIF' => array ('title' => $this->l('Enable active state for menus.'), 'desc' => $this->l('Background and text color over are used'), 'cast' => 'intval', 'type' => 'bool', 'default' => true ), 'ATM_MENU_GLOBAL_HEIGHT' => array ('title' => $this->l('Navigation bar height (px)'), 'desc' => '', 'type' => 'text', 'default' => '30' ), 'ATM_MENU_GLOBAL_WIDTH' => array ('title' => $this->l('Navigation bar width (px)'), 'desc' => $this->l('Put 0 for automatic width'), 'type' => 'text', 'default' => '960' ), 'ATM_MENU_GLOBAL_PADDING' => array ('title' => $this->l('Navigation bar padding (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 10px 0 10px' ), 'ATM_MENU_GLOBAL_MARGIN' => array ('title' => $this->l('Navigation bar margin (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 0 10px 0' ), 'ATM_MENU_GLOBAL_BGCOLOR' => array ('title' => $this->l('Navigation bar background color'), 'desc' => '', 'type' => 'gradient', 'default' => '#ffffff' ), 'ATM_MENU_GLOBAL_BORDERCOLOR' => array ('title' => $this->l('Navigation bar border color'), 'desc' => '', 'type' => 'color', 'default' => '#cccccc' ), 'ATM_MENU_GLOBAL_BORDERSIZE' => array ('title' => $this->l('Navigation bar border size (px)'), 'desc' => '', 'type' => '4size', 'default' => '1px 0 1px 0' ), 'ATM_MENU_MARGIN' => array ('title' => $this->l('Tabs inner spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 2px 0 0' ), 'ATM_MENU_PADDING' => array ('title' => $this->l('Tabs outer spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 0 0 0' ), 'ATM_MENU_FONT_SIZE' => array ('title' => $this->l('Font size tabs (px)'), 'desc' => '', 'type' => 'select', 'default' => 11, 'list' => array (), 'identifier' => 'id' ), 'ATM_MENU_FONT_FAMILY' => array ('title' => $this->l('Font family tabs'), 'desc' => '', 'type' => 'select', 'default' => 0, 'list' => array (), 'identifier' => 'id' ), 'ATM_MENU_COLOR' => array ('title' => $this->l('Text color tabs'), 'desc' => '', 'type' => 'color', 'default' => '#666666' ), 'ATM_MENU_COLOR_OVER' => array ('title' => $this->l('Text color tabs over'), 'desc' => '', 'type' => 'color', 'default' => '#333333' ), 'ATM_MENU_BGCOLOR' => array ('title' => $this->l('Tabs background color'), 'desc' => '', 'type' => 'gradient', 'default' => '#ffffff' ), 'ATM_MENU_BGCOLOR_OVER' => array ('title' => $this->l('Tabs background color over'), 'desc' => '', 'type' => 'gradient', 'default' => '#e5e5e5' ), 'ATM_MENU_BORDERCOLOR' => array ('title' => $this->l('Tabs border color'), 'desc' => '', 'type' => 'color', 'default' => '#cccccc' ), 'ATM_MENU_BORDERSIZE' => array ('title' => $this->l('Tabs border size (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 1px 0 1px' ), 'ATM_SUBMENU_WIDTH' => array ('title' => $this->l('Submenus width (px)'), 'desc' => $this->l('Put 0 for automatic width'), 'type' => 'text', 'default' => '0' ), 'ATM_SUBMENU_HEIGHT' => array ('title' => $this->l('Submenus min-height (px)'), 'desc' => '', 'type' => 'text', 'default' => '0' ), 'ATM_SUBMENU_POSITION' => array ('title' => $this->l('Show sub-menus'), 'desc' => '', 'cast' => 'intval', 'type' => 'select', 'default' => 1, 'list' => array (array ('id' => 1, 'name' => $this->l('Left-aligned current menu') ), array ('id' => 2, 'name' => $this->l('Left-aligned global menu') ) ), 'identifier' => 'id' ), 'ATM_SUBMENU_BGCOLOR' => array ('title' => $this->l('Submenus background color'), 'desc' => '', 'type' => 'gradient', 'default' => '#f5f5f5' ), 'ATM_SUBMENU_BORDERCOLOR' => array ('title' => $this->l('Submenus border color'), 'desc' => '', 'type' => 'color', 'default' => '#e5e5e5' ), 'ATM_SUBMENU_BORDERSIZE' => array ('title' => $this->l('Submenus border size (px)'), 'desc' => '', 'type' => '4size', 'default' => '4px 4px 4px 4px' ), 'ATM_COLUMNWRAP_PADDING' => array ('title' => $this->l('Columns inner spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '10px 10px 10px 10px' ), 'ATM_COLUMN_FONT_SIZE' => array ('title' => $this->l('Groups titles font size  (px)'), 'desc' => '', 'type' => 'select', 'default' => 11, 'list' => array (), 'identifier' => 'id' ), 'ATM_COLUMN_FONT_FAMILY' => array ('title' => $this->l('Groups titles font family'), 'desc' => '', 'type' => 'select', 'default' => 0, 'list' => array (), 'identifier' => 'id' ), 'ATM_COLUMN_TITLE_COLOR' => array ('title' => $this->l('Groups titles color'), 'desc' => '', 'type' => 'color', 'default' => '#333333' ), 'ATM_COLUMN_TITLE_COLOR_OVER' => array ('title' => $this->l('Groups titles color over'), 'desc' => '', 'type' => 'color', 'default' => '#666666' ), 'ATM_COLUMN_PADDING' => array ('title' => $this->l('Groups inner spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 0 0 0' ), 'ATM_COLUMN_MARGIN' => array ('title' => $this->l('Groups outer spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 0 0 0' ), 'ATM_COLUMN_ITEM_FONT_SIZE' => array ('title' => $this->l('Items font size (px)'), 'desc' => '', 'type' => 'select', 'default' => 11, 'list' => array (), 'identifier' => 'id' ), 'ATM_COLUMN_ITEM_FONT_FAMILY' => array ('title' => $this->l('Items font family'), 'desc' => '', 'type' => 'select', 'default' => 0, 'list' => array (), 'identifier' => 'id' ), 'ATM_COLUMN_ITEM_COLOR' => array ('title' => $this->l('Items color'), 'desc' => '', 'type' => 'color', 'default' => '#999999' ), 'ATM_COLUMN_ITEM_COLOR_OVER' => array ('title' => $this->l('Items color over'), 'desc' => '', 'type' => 'color', 'default' => '#666666' ), 'ATM_COLUMN_ITEM_PADDING' => array ('title' => $this->l('Items inner spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 0 0 0' ), 'ATM_COLUMN_ITEM_MARGIN' => array ('title' => $this->l('Items outer spaces (px)'), 'desc' => '', 'type' => '4size', 'default' => '0 0 0 0' ) );

		$this->_fieldsOptions ['ATM_MENU_FONT_FAMILY'] ['list'] [] = array ('id' => 0, 'name' => $this->l('Use the same font family as my theme') );
		$this->_fieldsOptions ['ATM_COLUMN_FONT_FAMILY'] ['list'] [] = array ('id' => 0, 'name' => $this->l('Use the same font family as my theme') );
		$this->_fieldsOptions ['ATM_COLUMN_ITEM_FONT_FAMILY'] ['list'] [] = array ('id' => 0, 'name' => $this->l('Use the same font family as my theme') );
		foreach ( $this->font_families as $font_familie ) {
			$this->_fieldsOptions ['ATM_MENU_FONT_FAMILY'] ['list'] [] = array ('id' => $font_familie, 'name' => $font_familie );
			$this->_fieldsOptions ['ATM_COLUMN_FONT_FAMILY'] ['list'] [] = array ('id' => $font_familie, 'name' => $font_familie );
			$this->_fieldsOptions ['ATM_COLUMN_ITEM_FONT_FAMILY'] ['list'] [] = array ('id' => $font_familie, 'name' => $font_familie );
		}
		$this->_fieldsOptions ['ATM_MENU_FONT_SIZE'] ['list'] [] = array ('id' => 0, 'name' => $this->l('Use the same font size as my theme') );
		$this->_fieldsOptions ['ATM_COLUMN_FONT_SIZE'] ['list'] [] = array ('id' => 0, 'name' => $this->l('Use the same font size as my theme') );
		$this->_fieldsOptions ['ATM_COLUMN_ITEM_FONT_SIZE'] ['list'] [] = array ('id' => 0, 'name' => $this->l('Use the same font size as my theme') );
		for($i = 8; $i <= 30; $i ++) {
			$this->_fieldsOptions ['ATM_MENU_FONT_SIZE'] ['list'] [] = array ('id' => $i, 'name' => $i );
			$this->_fieldsOptions ['ATM_COLUMN_FONT_SIZE'] ['list'] [] = array ('id' => $i, 'name' => $i );
			$this->_fieldsOptions ['ATM_COLUMN_ITEM_FONT_SIZE'] ['list'] [] = array ('id' => $i, 'name' => $i );
		}
		$this->optionTitle = $this->l('Global Styles');
		$this->link_targets = array (0 => $this->l('No target. W3C compliant.'), '_self' => $this->l('Open document in the same frame (_self)'), '_blank' => $this->l('Open document in a new window (_blank)'), '_top' => $this->l('Open document in the same window (_top)'), '_parent' => $this->l('Open document in the parent frame (_parent)') );

		//Support links
		$this->_support_link = array(
			array(
				'link'		=> 'http://www.presta-module.com/contact-form.php',
				'target'	=> '_blank',
				'label'		=> $this->l('Support contact')
			)
		);
	}

	function install() {
		if (! file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE))
			return (false);
		else if (! $sql = file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE))
			return (false);
		$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
		if (_PS_VERSION_ >= 1.4)
			$sql = str_replace('MYSQL_ENGINE', _MYSQL_ENGINE_, $sql);
		else
			$sql = str_replace('MYSQL_ENGINE', 'MyISAM', $sql);
		$sql = preg_split("/;\s*[\r\n]+/", $sql);
		foreach ( $sql as $query )
			if (! Db::getInstance()->Execute(trim($query)))
				return (false);
		if (! parent::install())
			return false;
		if (! $this->registerHook('top') || ! $this->registerHook('header') or ! $this->installDefaultConfig())
			return false;
		Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'hook_module', array ('position' => 255 ), 'UPDATE', 'id_module = ' . $this->id . ' AND id_hook = ' . Hook::get('top'));
		/*Update*/
		$this->checkIfModuleIsUpdate(true, false);
		return true;
	}
	private function columnExists($table, $column, $createIfNotExist = false, $type = false, $insertAfter = false) {
		$resultset = Db::getInstance()->ExecuteS("SHOW COLUMNS FROM `" . _DB_PREFIX_ . $table . "`");
		foreach ( $resultset as $row )
			if ($row ['Field'] == $column)
				return true;

		if ($createIfNotExist && Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . $table . '` ADD `' . $column . '` ' . $type . ' ' . ($insertAfter ? ' AFTER `' . $insertAfter . '`' : '') . ''))
			return true;
		return false;
	}
	public function installDefaultConfig() {
		foreach ( $this->_fieldsOptions as $key => $field ) {
			$val = $field ['default'];
			if (trim($val)) {
				if (is_array($val)) {
					$val = serialize($val);
				}
				if (! Configuration::get($key, 'notset') == 'notset') {
					if (! Configuration::updateValue($key, $val))
						return false;
				}
			}
		}
		return true;
	}
	public function checkIfModuleIsUpdate($updateDb = false, $displayConfirm = true) {
		if (! $updateDb && $this->version != Configuration::get('ATM_LAST_VERSION', false))
			return false;
		$isUpdate = true;
		$toUpdate = array (array ('pm_advancedtopmenu', "width_submenu", 'varchar(5) NOT NULL', 'border_color_tab' ), array ('pm_advancedtopmenu', "minheight_submenu", 'varchar(5) NOT NULL', 'width_submenu' ), array ('pm_advancedtopmenu', "position_submenu", 'tinyint(3) unsigned NOT NULL', 'minheight_submenu' ), array ('pm_advancedtopmenu', "image_type", 'varchar(4) NOT NULL', 'have_icon' ), array ('pm_advancedtopmenu_columns', "image_type", 'varchar(4) NOT NULL', 'have_icon' ), array ('pm_advancedtopmenu_elements', "image_type", 'varchar(4) NOT NULL', 'have_icon' ), array ('pm_advancedtopmenu_elements', "active", "tinyint(4)  NOT NULL DEFAULT '1'", 'target' ) );
		foreach ( $toUpdate as $table => $infos ) {
			if (! $this->columnExists($infos [0], $infos [1], $updateDb, $infos [2], $infos [3])) {
				$isUpdate = false;
			}
		}
		$toChange = array (array ('pm_advancedtopmenu', "fnd_color_menu_tab", 'varchar(15)' ), array ('pm_advancedtopmenu', "fnd_color_menu_tab_over", 'varchar(15)' ), array ('pm_advancedtopmenu', "fnd_color_submenu", 'varchar(15)' ), array ('pm_advancedtopmenu_columns_wrap', "bg_color", 'varchar(15)' ) );
		foreach ( $toChange as $table => $infos ) {
			$resultset = Db::getInstance()->ExecuteS("SHOW COLUMNS FROM `" . _DB_PREFIX_ . $infos [0] . "` WHERE `Field` = '" . $infos [1] . "'");
			foreach ( $resultset as $row )
				if ($row ['Type'] != $infos [2]) {
					$isUpdate = false;
					if ($updateDb) {
						Db::getInstance()->ExecuteS('ALTER TABLE `' . _DB_PREFIX_ . $infos [0] . '` CHANGE `' . $infos [1] . '` `' . $infos [1] . '` ' . $infos [2] . '');
					}
				}
		}
		if ($updateDb) {
			//Update table engine 4 PS 1.4
			if (_PS_VERSION_ >= 1.4)
				$this->updateTablesEngine();
			$this->installDefaultConfig();
			Configuration::updateValue('ATM_LAST_VERSION', $this->version);
			$this->generateGlobalCss();
			$this->generateCss();
			$this->generateAdvancedCss();
			$this->clearCache();
			if ($displayConfirm)
				$this->_html .= $this->displayConfirmation($this->l('Module updated successfully'));
		}
		return $isUpdate;
	}
	function updateTablesEngine() {
		foreach ( $this->tables as $tblName ) {
			if (_MYSQL_ENGINE_ == 'InnoDB') {
				if ($this->getTableEngine($tblName) != _MYSQL_ENGINE_)
					if (! Db::getInstance()->Execute('ALTER TABLE ' . _DB_PREFIX_ . $tblName . ' ENGINE = InnoDB'))
						return (false);
			}
		}
		return true;
	}
	private function getTableEngine($table) {
		$result = Db::getInstance()->ExecuteS('SHOW TABLE STATUS WHERE `Name` = "' . _DB_PREFIX_ . pSQL($table) . '"');
		return $result [0] ['Engine'];
	}
	public function checkPermissions() {
		$verifs = array ('css', 'column_icons', 'menu_icons', 'element_icons', '../../tools/smarty/cache' );
		$errors = array ();
		foreach ( $verifs as $fileOrDir ) {
			if (! is_writable(dirname(__FILE__) . '/' . $fileOrDir)) {
				$errors [] = dirname(__FILE__) . '/' . $fileOrDir;
			}
		}
		if (! sizeof($errors)) {
			return true;
		}
		else {
			$this->_html .= '<div class="warning warn clear">' . $this->l('Before you can configure your menu, please give write permission to  file(s) / folder(s) below:') . '<br />' . implode('<br />', $errors) . '</div>';
			return false;
		}
	}
	public function generateAdvancedCss() {
		if (! trim(file_get_contents(dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE))) {
			file_put_contents(dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE, file_get_contents(dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE_RESTORE));
		}
	}
	public function uninstall() {
		/*Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_lang`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_columns_wrap_lang`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_columns`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_columns_lang`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_elements`');
      Db::getInstance ()->Execute ( 'DROP TABLE `'._DB_PREFIX_.'pm_advancedtopmenu_elements_lang`');
    $this->uninstallDefaultConfig();
    Configuration::deleteByName('ATM_LAST_VERSION');*/
		return parent::uninstall();
	}
	public function resetInstall() {
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_lang`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_columns_wrap`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_columns_wrap_lang`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_columns`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_columns_lang`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_elements`');
		Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . 'pm_advancedtopmenu_elements_lang`');
		if (! file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE))
			return (false);
		else if (! $sql = file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE))
			return (false);
		$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
		$sql = preg_split("/;\s*[\r\n]+/", $sql);
		foreach ( $sql as $query )
			if (! Db::getInstance()->Execute(trim($query)))
				return (false);
	}
	public function uninstallDefaultConfig() {
		foreach ( $this->_fieldsOptions as $key => $field ) {
			Configuration::deleteByName($key);
		}
		return true;
	}
	public function saveConfig() {
		if (Tools::getValue('submitOptions')) {
			foreach ( $this->_fieldsOptions as $key => $field ) {
				if ($field ['type'] == '4size') {
					$_POST [$key] = $this->getBorderSizeFromArray(Tools::getValue($key));
					Configuration::updateValue($key, (isset($field ['cast']) ? $field ['cast'](Tools::getValue($key)) : Tools::getValue($key)));
				}
				elseif ($field ['type'] == 'gradient') {
					$_POST [$key] = $_POST [$key] [0] . (Tools::getValue($key . '_gradient') && isset($_POST [$key] [1]) && $_POST [$key] [1] ? $this->gradient_separator . $_POST [$key] [1] : '');
					Configuration::updateValue($key, (isset($field ['cast']) ? $field ['cast'](Tools::getValue($key)) : Tools::getValue($key)));
				}
				elseif ($field ['type'] == 'textLang') {
					$languages = Language::getLanguages(false);
					$list = array ();
					foreach ( $languages as $language )
						$list [$language ['id_lang']] = (isset($field ['cast']) ? $field ['cast'](Tools::getValue($key . '_' . $language ['id_lang'])) : Tools::getValue($key . '_' . $language ['id_lang']));
					Configuration::updateValue($key, $list);
				}
				else {
					if (! isset($field ['disable']))
						Configuration::updateValue($key, (isset($field ['cast']) ? $field ['cast'](Tools::getValue($key)) : Tools::getValue($key)));
				}
			}
			$this->generateGlobalCss();
			$this->clearCache();
			$this->_html .= $this->displayConfirmation($this->l('Configuration updated successfully'));
		}
	}
	public function saveAdvancedConfig() {
		if (Tools::getValue('submitAdvancedConfig')) {
			if (file_put_contents(dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE, Tools::getValue('advancedConfig'))) {
				$this->_html .= $this->displayConfirmation($this->l('Styles updated successfully'));
			}
			else
				$this->errors [] = $this->l('Error during save advanced styles');
			;
		}
	}
	public function getContent() {
		$this->initClassVar();
		$this->displayTitle();
		if ($this->checkPermissions()) {
			if (Tools::getValue('makeUpdate')) {
				$this->checkIfModuleIsUpdate(true);
				header('Location:' . $this->base_config_url);
				die();
			}
			if (! $this->checkIfModuleIsUpdate(false)) {
				$this->_html .= '<div class="warning warn clear">' . $this->l('Your module need to be update!') . '<br /><a href="' . $this->base_config_url . '&makeUpdate=1" class="button">' . $this->l('Please click here to update AdvancedTopMenu') . '.</a></div>';
				$this->includeAdminCssJs();
			}
			else {
				/*if(Tools::getValue('reset'))
          $this->resetInstall();*/
				$this->_postProcess();
				$this->includeAdminCssJs();
				$this->displayTabsConfig();

			}
		}else $this->includeAdminCssJs();
		$this->displaySupport();
		return $this->_html;
	}
	function displayTitle() {
		echo '<h2>' . $this->displayName . '</h2>';
	}
	function displayTabsConfig() {
		$this->_maintenanceWarning();
		$this->_maintenanceButton();
		$this->_html .= '<hr class="pm_hr" />';
		$this->_html .= '
    <div id="wrapConfigTab">
    <ul style="height: 30px;" id="configTab">
          <li><a href="#config-1"><span><img src="' . $this->_path . 'logo.gif" /> ' . $this->l('Menu configuration') . '</span></a></li>
          <li><a href="#config-2"><span><img src="../img/admin/cog.gif" /> ' . $this->l('Global styles & configurations') . '</span></a></li>
          <li><a href="#config-3"><span><img src="' . $this->_path . 'img/document-code.png" /> ' . $this->l('Advanced styles') . '</span></a></li>
         <li><a href="' . $this->base_config_url . '&displayPreview=1" onclick="refreshPreview();"><span><img src="../img/admin/world.gif" /> ' . $this->l('Preview') . '</span></a></li>
        </ul>';
		$this->_html .= '<div id="config-1">';
		$this->_displayForm();
		$this->_html .= '</div>';
		$this->_html .= '<div id="config-2">';
		$this->displayConfig();
		$this->_html .= '</div>';
		$this->_html .= '<div id="config-3">';
		$this->displayAdvancedConfig();
		$this->_html .= '</div>
      </div>';
	}
	function displayPreview() {
		$this->_html .= '<iframe src="' . __PS_BASE_URI__ . '" style="width:100%;height:500px;" id="iframePreview"></iframe>';
	}
	function displayAdvancedConfig() {
		$this->_html .= '<form action="' . $this->base_config_url . '#config-3" id="formAdvancedStyles_' . $this->name . '" name="formAdvancedStyles_' . $this->name . '" method="post" class="width3"><div class="dynamicTextarea"><textarea name="advancedConfig" id="advancedConfig" cols="120" rows="30">' . @file_get_contents(dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE) . '</textarea></div>
    <br /><center>
          <input type="submit" value="' . $this->l('   Save   ') . '" name="submitAdvancedConfig" class="button" />
        </center></form>
<script type="text/javascript">
 var editor = CodeMirror.fromTextArea(document.getElementById("advancedConfig"), {});
</script>
';
	}
	function includeAdminCssJs() {
		$defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));

		if (_PS_VERSION_ >= 1.4) {
			$this->_html .= '
			<link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/jqueryui/1.8.9/themes/smoothness/jquery-ui-1.8.9.custom.css" />
			<script type="text/javascript" src="' . $this->_path . 'js/jqueryui/1.8.9/jquery-ui-1.8.9.custom.min.js"></script>
			';
		}
		else {
			$this->_html .= '<link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/jqueryui/themes/default/ui.all.css" />
			<script type="text/javascript" src="' . $this->_path . 'js/ui.core.min.js"></script>
			<script type="text/javascript" src="' . $this->_path . 'js/ui.dialog.min.js"></script>
			<script type="text/javascript" src="' . $this->_path . 'js/ui.sortable.min.js"></script>
			<script type="text/javascript" src="' . $this->_path . 'js/ui.tabs.min.js"></script>
			';
		}

		if (_PS_VERSION_ >= "1.4.1.0") {
			$isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $this->iso_lang . '.js') ? $this->iso_lang : 'en');
			$ad = dirname($_SERVER ["PHP_SELF"]);
			$this->_html .= '<script type="text/javascript">
				var iso = \'' . $isoTinyMCE . '\' ;
				var pathCSS = \'' . _THEME_CSS_DIR_ . '\' ;
				var ad = \'' . $ad . '\' ;
			</script>';
			$this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js"></script>';
		}
		else {
			$this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
		}

		$this->_html .= '
		<link type="text/css" rel="stylesheet" href="' . $this->_path . 'css/admin.css" />
		<link type="text/css" rel="stylesheet" href="' . $this->_path . 'css/mbTabset.css" />
		<script type="text/javascript" src="' . $this->_path . 'js/admin.js"></script>
		<script type="text/javascript" src="' . $this->_path . 'js/jquery.tablednd_0_5.js"></script>
		<script type="text/javascript" src="' . $this->_path . 'js/mbTabset.min.js"></script>
		<script type="text/javascript" src="' . $this->_path . 'js/jquery.metadata.js"></script>
		<link rel="stylesheet" href="' . $this->_path . 'js/colorpicker/css/colorpicker.css" type="text/css" />
		<script type="text/javascript" src="' . $this->_path . 'js/colorpicker/js/colorpicker.js"></script>

		<script src="' . $this->_path . 'js/codemirror/codemirror.js" type="text/javascript"></script>
		<script src="' . $this->_path . 'js/codemirror/css.js" type="text/javascript"></script>
		<link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/codemirror/codemirror.css" />
		<link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/codemirror/default.css" />

		<script type="text/javascript">
			var id_language = Number(' . $defaultLanguage . ');
			var modulePath = "' . $this->_path . '";
			var base_config_url = "' . $this->base_config_url . '";
		</script>';
	}
	function displayConfig() {
		global $cookie;

		if (! isset($this->_fieldsOptions) or ! sizeof($this->_fieldsOptions))
			return;

		$defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);

		$this->_html .= '<form action="' . $this->base_config_url . '#config-2" id="formGlobal_' . $this->name . '" name="form_' . $this->name . '" method="post" class="width3">
      <fieldset>';
		foreach ( $this->_fieldsOptions as $key => $field ) {
			$val = Tools::getValue($key, Configuration::get($key, false));
			$this->_html .= '
        <label>' . $field ['title'] . ' </label>
        <div class="margin-form">';

			switch ($field ['type']) {
				case 'select' :
					$this->_html .= '<select name="' . $key . '">';
					foreach ( $field ['list'] as $value )
						$this->_html .= '<option
              value="' . (isset($field ['cast']) ? $field ['cast']($value [$field ['identifier']]) : $value [$field ['identifier']]) . '"' . (($val === false && isset($field ['default']) && $field ['default'] === $value [$field ['identifier']]) || ($val == $value [$field ['identifier']]) ? ' selected="selected"' : '') . '>' . $value ['name'] . '</option>';
					$this->_html .= '</select>';
					break;

				case 'bool' :
					$this->_html .= '<label class="t" for="' . $key . '_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
          <input type="radio" name="' . $key . '" id="' . $key . '_on" value="1"' . ($val ? ' checked="checked"' : '') . '' . (isset($field ['disable']) && $field ['disable'] ? 'disabled="disabled"' : '') . ' />
          <label class="t" for="' . $key . '_on"> ' . $this->l('Yes') . '</label>
          <label class="t" for="' . $key . '_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
          <input type="radio" name="' . $key . '" id="' . $key . '_off" value="0" ' . (! $val ? 'checked="checked"' : '') . '' . (isset($field ['disable']) && $field ['disable'] ? 'disabled="disabled"' : '') . '/>
          <label class="t" for="' . $key . '_off"> ' . $this->l('No') . '</label>';
					break;

				case 'textLang' :
					foreach ( $languages as $language ) {
						$val = Tools::getValue($key . '_' . $language ['id_lang'], Configuration::get($key, $language ['id_lang']));
						$this->_html .= '
            <div id="' . $key . '_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $defaultLanguage ? 'block' : 'none') . '; float: left;">
              <input size="' . $field ['size'] . '" type="text" name="' . $key . '_' . $language ['id_lang'] . '" value="' . $val . '" />
            </div>';
					}
					$this->displayFlags($languages, $defaultLanguage, $key, $key);
					$this->_html .= '<br style="clear:both" />';
					break;
				case 'color' :
					$this->_html .= '<input type="text" name="' . $key . '" value="' . ($val === false && isset($field ['default']) && $field ['default'] ? $field ['default'] : $val) . '" size="20" class="colorPicker" />' . (isset($field ['suffix']) ? $field ['suffix'] : '');
					break;
				case 'gradient' :
					$val = explode($this->gradient_separator, $val);
					if (isset($val [1])) {
						$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
						$color2 = htmlentities($val [1], ENT_COMPAT, 'UTF-8');
					}
					else
						$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
					$this->_html .= '<input type="text" name="' . $key . '[0]" id="' . $key . '_0" value="' . (!isset($color1) && isset($field ['default']) && $field ['default'] ? $field ['default'] : (isset($color1)?$color1:'')) . '" size="20" class="colorPicker" />' . (isset($field ['suffix']) ? $field ['suffix'] : '');

					$this->_html .= '&nbsp; <span ' . (isset($color2) ? '' : 'style="display:none"') . ' id="' . $key . '_gradient"><input type="text" name="' . $key . '[1]" id="' . $key . '_1" value="' . (! isset($color2) ? '' : $color2) . '" size="20" class="colorPicker" />' . (isset($field ['suffix']) ? $field ['suffix'] : '') . '</span>';
					$this->_html .= '&nbsp; <input type="checkbox" name="' . $key . '_gradient" value="1" ' . (isset($color2) ? 'checked=checked' : '') . ' /> &nbsp; ' . $this->l('Make a gradient');

					$this->_html .= '<script type="text/javascript">
            $("input[name=' . $key . '_gradient]").click(function() {
				showSpanIfChecked($(this),"#' . $key . '_gradient")
			});
            </script>';
					unset($color1);
					unset($color2);
					break;
				case 'password' :
					$this->_html .= '<input type="password" name="' . $key . '" value="' . $val . '" size="20" ' . (isset($field ['disable']) && $field ['disable'] ? 'disabled="disabled"' : '') . ' />' . (isset($field ['suffix']) ? $field ['suffix'] : '');
					break;
				case '4size' :
					if ($val || (isset($field ['default']) && $field ['default'])) {
						$borders = ($val !== false ? $val : @$field ['default']);
						$borders_size_tab = explode(' ', $borders);
					}

					$this->_html .= $this->l('top') . ' <input size="3" type="text" name="' . $key . '[]" value="' . (isset($borders_size_tab) && is_array($borders_size_tab) ? intval(preg_replace('#px#', '', $borders_size_tab [0])) : 0) . '" /> &nbsp; ' . $this->l('right') . ' <input size="3" type="text" name="' . $key . '[]" value="' . (isset($borders_size_tab) && is_array($borders_size_tab) ? intval(preg_replace('#px#', '', $borders_size_tab [1])) : 0) . '" /> &nbsp; ' . $this->l('bottom') . ' <input size="3" type="text" name="' . $key . '[]" value="' . (isset($borders_size_tab) && is_array($borders_size_tab) ? intval(preg_replace('#px#', '', $borders_size_tab [2])) : 0) . '" /> &nbsp; ' . $this->l('left') . ' <input size="3" type="text" name="' . $key . '[]" value="' . (isset($borders_size_tab) && is_array($borders_size_tab) ? intval(preg_replace('#px#', '', $borders_size_tab [3])) : 0) . '" />';
					break;
				case 'text' :
				default :
					$this->_html .= '<input type="text" name="' . $key . '" value="' . ($val === false && isset($field ['default']) && $field ['default'] ? $field ['default'] : $val) . '" size="20" />' . (isset($field ['suffix']) ? $field ['suffix'] : '');
			}
			$this->_html .= (isset($field ['desc']) ? ' &nbsp; <span>' . $field ['desc'] . '</span>' : '');
			$this->_html .= '</div>';
		}
		$this->_html .= '<center>
          <input type="submit" value="' . $this->l('   Save   ') . '" name="submitOptions" class="button" />
        </center>
      </fieldset>
    </form>';
	}
	private function initClassVar() {
		global $cookie, $currentIndex;
		$this->base_config_url = $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getValue('token');
		$defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$this->defaultLanguage = $defaultLanguage;
		$this->iso_lang = Language::getIsoById($cookie->id_lang);
		$this->languages = $languages;
	}
	private function _displayForm() {
		global $cookie, $currentIndex;
		$this->initClassVar();

		if (sizeof($this->errors)) {
			foreach ( $this->errors as $error )
				$this->_html .= $this->displayError($error);
		}
		$menus = AdvancedTopMenuClass::getMenus($cookie->id_lang, false);

		if (! sizeof($menus))
			$this->_html .= '<p style="text-align:center;">' . $this->l('No tab') . '</p>';
		else {

			$this->_html .= '<div class="tabset" id="tabsetMenu">';
			foreach ( $menus as $menu ) {
				$this->_html .= '<a id="' . $menu ['id_menu'] . '" class="tab ' . ($menu ['id_menu'] == Tools::getValue('id_menu', false) ? 'sel' : '') . ' {content:\'cont_' . $menu ['id_menu'] . '\'}">' . $this->getAdminOutputNameValue($menu, false) . '</a>';
			}
			$this->_html .= '</div>';
			foreach ( $menus as $menu ) {
				$this->_html .= '<div id="cont_' . $menu ['id_menu'] . '">';
				$this->_html .= '<p>';
				$this->_html .= '<b>' . $this->getAdminOutputNameValue($menu, true, 'menu') . '</b>';
				$this->_html .= ' | ' . $this->getAdminOutputPrivacyValue($menu ['privacy']);
				$this->_html .= ' | <a href="' . $this->base_config_url . '&editMenu=1&id_menu=' . $menu ['id_menu'] . '"><img src="../img/admin/edit.gif" /></a>';
				$this->_html .= ' | <a href="' . $this->base_config_url . '&deleteMenu=1&id_menu=' . $menu ['id_menu'] . '" onclick="return confirm(\'' . addcslashes($this->l('Delete item #'), "'") . $menu ['id_menu'] . ' ?\');"><img src="../img/admin/delete.gif" /></a>';
				$this->_html .= ' | ' . $this->l('Displayed:') . ' <a href="' . $this->base_config_url . '&activeMenu=1&id_menu=' . $menu ['id_menu'] . '" class="ajax_script_load"><img src="../img/admin/' . ($menu ['active'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveMenu' . $menu ['id_menu'] . '" /></a>';
				$this->_html .= '</p>';

				$columnsWrap = AdvancedTopMenuColumnWrapClass::getMenuColumnsWrap($menu ['id_menu'], $cookie->id_lang, false);
				$this->_html .= '<div class="columnWrapSort">';
				if (! sizeof($columnsWrap))
					$this->_html .= '<p style="text-align:center;">' . $this->l('No column') . '</p>';
				else {
					foreach ( $columnsWrap as $columnWrap ) {
						$this->_html .= '<div class="menuColumnWrap" id="' . $columnWrap ['id_wrap'] . '">';
						$this->_html .= '<p>';
						$this->_html .= '<img src="' . $this->_path . 'img/arrow-move.png" class="dragWrap" /><b>' . $columnWrap ['internal_name'] . '</b>';
						$this->_html .= ' | ' . $this->getAdminOutputPrivacyValue($columnWrap ['privacy']);
						if ($columnWrap ['width'])
							$this->_html .= ' | ' . $this->l('Width:') . ' ' . $columnWrap ['width'] . 'px';
						$this->_html .= ' | <a href="' . $this->base_config_url . '&editColumnWrap=1&id_wrap=' . $columnWrap ['id_wrap'] . '&id_menu=' . $menu ['id_menu'] . '"><img src="../img/admin/edit.gif" /></a>';
						$this->_html .= ' | <a href="' . $this->base_config_url . '&deleteColumnWrap=1&id_wrap=' . $columnWrap ['id_wrap'] . '&id_menu=' . $menu ['id_menu'] . '" onclick="return confirm(\'' . addcslashes($this->l('Delete item #'), "'") . $columnWrap ['id_wrap'] . ' ?\');"><img src="../img/admin/delete.gif" /></a>';
						$this->_html .= ' | ' . $this->l('Displayed:') . ' <a href="' . $this->base_config_url . '&activeColumnWrap=1&id_wrap=' . $columnWrap ['id_wrap'] . '" class="ajax_script_load"><img src="../img/admin/' . ($columnWrap ['active'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveColumnWrap' . $columnWrap ['id_wrap'] . '" /></a>';
						$this->_html .= '</p>';
						$columns = AdvancedTopMenuColumnClass::getMenuColums($columnWrap ['id_wrap'], $cookie->id_lang, false);
						$this->_html .= '<div class="columnSort columnSort-' . $columnWrap ['id_wrap'] . '">';
						if (! sizeof($columns))
							$this->_html .= '<p style="text-align:center;">' . $this->l('No group') . '</p>';
						else {
							foreach ( $columns as $column ) {
								$columnElements = AdvancedTopMenuElementsClass::getMenuColumnElements($column ['id_column'], $cookie->id_lang, false);
								//print_r($columnElements);
								$this->_html .= '
                      <div class="menuColumn" id="' . $column ['id_column'] . '">';
								$this->_html .= '';
								$this->_html .= '<img src="' . $this->_path . 'img/arrow-move.png" class="dragColumn" /><b>' . $this->getAdminOutputNameValue($column, true, 'column') . '</b>';
								$this->_html .= ' | ' . $this->getAdminOutputPrivacyValue($column ['privacy']);
								$this->_html .= ' | <a href="' . $this->base_config_url . '&editColumn=1&id_column=' . $column ['id_column'] . '&id_menu=' . $menu ['id_menu'] . '"><img src="../img/admin/edit.gif" /></a>';
								$this->_html .= ' | <a href="' . $this->base_config_url . '&deleteColumn=1&id_column=' . $column ['id_column'] . '&id_menu=' . $menu ['id_menu'] . '" onclick="return confirm(\'' . addcslashes($this->l('Delete item #'), "'") . $column ['id_column'] . ' ?\');"><img src="../img/admin/delete.gif" /></a>';
								$this->_html .= ' | ' . $this->l('Displayed:') . ' <a href="' . $this->base_config_url . '&activeColumn=1&id_column=' . $column ['id_column'] . '" class="ajax_script_load"><img src="../img/admin/' . ($column ['active'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveColumn' . $column ['id_column'] . '" /></a>';
								$this->_html .= ' | <form style="display:inline;" action="' . $this->base_config_url . '" method="post"><select name="id_wrap"><option>' . $this->l('Move to Column') . '</option>';
								foreach ( $columnsWrap as $columnWrap2 ) {
									$this->_html .= '<option value="' . intval($columnWrap2 ['id_wrap']) . '">' . $columnWrap2 ['internal_name'] . '</option>';
								}
								$this->_html .= '</select><input type="hidden" name="id_column" value="' . intval($column ['id_column']) . '" /><input type="hidden" name="id_menu" value="' . intval($menu ['id_menu']) . '" /><input type="submit" value="' . $this->l('OK') . '" name="submitFastChangeColumn" class="button" /></form>';
								$this->_html .= '<br /><br />';
								$this->_html .= '<table cellspacing="0" cellpadding="0" class="table table_sort" style="width:100%">
                      <tbody>
                        <tr class="nodrag nodrop">
                          <th width="50">' . $this->l('ID') . '</th>
                          <th width="100">' . $this->l('Type') . '</th>
                          <th width="150">' . $this->l('Permit') . '</th>
                          <th>' . $this->l('Value') . '</th>
                          <th width="50">' . $this->l('Actions') . '</th>
                          <th width="50">' . $this->l('Displayed:') . '</th>
                        </tr>

                      ';
								foreach ( $columnElements as $columnElement ) {
									$this->_html .= '<tr id="' . $columnElement ['id_element'] . '"><td>' . intval($columnElement ['id_element']) . '</td>
                  <td>' . $this->getType($columnElement ['type']) . '</td>
                  <td>' . $this->getAdminOutputPrivacyValue($columnElement ['privacy']) . '</td>
                  <td>' . $this->getAdminOutputNameValue($columnElement, true, 'element') . '</td>
                  <td> <a href="' . $this->base_config_url . '&editElement=1&id_element=' . $columnElement ['id_element'] . '&id_menu=' . $menu ['id_menu'] . '"><img src="../img/admin/edit.gif" /></a> <a href="' . $this->base_config_url . '&deleteElement=1&id_element=' . intval($columnElement ['id_element']) . '&id_menu=' . $menu ['id_menu'] . '" onclick="return confirm(\'' . addcslashes($this->l('Delete item #'), "'") . intval($columnElement ['id_element']) . ' ?\');"><img src="../img/admin/delete.gif" /></a></td>';
									$this->_html .= ' <td> <a href="' . $this->base_config_url . '&activeElement=1&id_element=' . $columnElement ['id_element'] . '" class="ajax_script_load"><img src="../img/admin/' . ($columnElement ['active'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveElement' . $columnElement ['id_element'] . '" /></a></td>';
									$this->_html .= '</tr>';
								}
								$this->_html .= '</tbody>
                          </table>
                          </div>';

							}
						}
						$this->_html .= '<br class="clear" /></div>';
						$this->_html .= '
            <script stype="text/javascript">
            $( ".columnSort-' . $columnWrap ['id_wrap'] . '" ).sortable({
              placeholder: "ui-state-highlight",
              delay: 300,
              handle : ".dragColumn",
              update: function(event, ui) {
                var orderColumn = $(this).sortable("toArray");
                saveOrderColumn(orderColumn.join(","));
              }
            });
            </script>';
						$this->_html .= '</div>';
					}
				}
				$this->_html .= '</div>';

				$this->_html .= '</div>';
			}
		}
		$this->_html .= ' <br />
                  <br />';

		$this->_html .= '<div id="wrapFormTab"><ul style="height: 30px;" id="formTab">
          <li' . (Tools::getValue('editMenu') && Tools::getValue('id_menu') ? ' class="ui-tabs-selected"' : '') . '><a href="' . $this->base_config_url . '&getMenuForm=1' . (Tools::getValue('editMenu') && Tools::getValue('id_menu') ? '&editMenu=1&id_menu=' . Tools::getValue('id_menu') : '') . '"><span><img src="' . $this->_path . 'img/menu.png" />' . (Tools::getValue('editMenu') && Tools::getValue('id_menu') ? $this->l('Edit tab') : $this->l('Add tab')) . '</span></a></li>
          <li' . (Tools::getValue('editColumnWrap') && Tools::getValue('id_wrap') ? ' class="ui-tabs-selected"' : '') . '><a href="' . $this->base_config_url . '&getColumnWrapForm=1' . (Tools::getValue('editColumnWrap') && Tools::getValue('id_wrap') ? '&editColumnWrap=1&id_wrap=' . Tools::getValue('id_wrap') : '') . '"><span><img src="' . $this->_path . 'img/column.png" />' . (Tools::getValue('editColumnWrap') && Tools::getValue('id_wrap') ? $this->l('Edit column') : $this->l('Add column')) . '</span></a></li>
          <li' . (Tools::getValue('editColumn') && Tools::getValue('id_column') ? ' class="ui-tabs-selected"' : '') . '><a href="' . $this->base_config_url . '&getColumnForm=1' . (Tools::getValue('editColumn') && Tools::getValue('id_column') ? '&editColumn=1&id_column=' . Tools::getValue('id_column') : '') . '"><span><img src="' . $this->_path . 'img/group.png" />' . (Tools::getValue('editColumn') && Tools::getValue('id_column') ? $this->l('Edit item group') : $this->l('Add item group')) . '</span></a></li>
          <li' . (Tools::getValue('editElement') && Tools::getValue('id_element') ? ' class="ui-tabs-selected"' : '') . '><a href="' . $this->base_config_url . '&getElementForm=1' . (Tools::getValue('editElement') && Tools::getValue('id_element') ? '&editElement=1&id_element=' . Tools::getValue('id_element') : '') . '"><span><img src="' . $this->_path . 'img/item.png" />' . (Tools::getValue('editElement') && Tools::getValue('id_element') ? $this->l('Edit item') : $this->l('Add item')) . '</span></a></li>
        </ul>
      </div>';
		if (Tools::getValue('editMenu') || Tools::getValue('editColumnWrap') || Tools::getValue('editColumn') || Tools::getValue('editElement')) {
			$this->_html .= '<script type="text/javascript">$(document).ready(function() {
          location.href = "' . $_SERVER ['REQUEST_URI'] . '#formTab";
      });</script><br />';
		}
		$this->initColorPicker();

	}

	private function initColorPicker() {
		$this->_html .= '<script type="text/javascript">
          var currentColorPicker = false;
            $("input[class=colorPicker]").ColorPicker({
              onSubmit: function(hsb, hex, rgb, el) {
                $(el).val("#"+hex);
                $(el).ColorPickerHide();
              },
              onBeforeShow: function () {
                currentColorPicker = $(this);
                $(this).ColorPickerSetColor(this.value);
              },
              onChange: function (hsb, hex, rgb) {
                $(currentColorPicker).val("#"+hex);
              }
            })
            .bind("keyup", function(){
              $(this).ColorPickerSetColor(this.value);
            });

    </script>';
	}
private function initTinyMce()
	{
		if (_PS_VERSION_ < "1.4.1.0") {
			$this->_html .= '
			<script type="text/javascript">
				tinyMCE.init({
					mode : "specific_textareas",
					editor_selector : "rte",
					theme : "advanced",
					plugins : "safari,directionality,searchreplace,layer,pagebreak,style,table,advimage,advlink,inlinepopups,media,contextmenu,paste,fullscreen",
					// Theme options
					theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
					theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
					theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : false,
					content_css : "' . __PS_BASE_URI__ . 'themes/' . _THEME_NAME_ . '/css/global.css",
					document_base_url : "' . __PS_BASE_URI__ . '",
					width: "600",
					height: "auto",
					font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
					// Drop lists for link/image/media/template dialogs
					template_external_list_url : "lists/template_list.js",
					external_link_list_url : "lists/link_list.js",
					external_image_list_url : "lists/image_list.js",
					media_external_list_url : "lists/media_list.js",
					elements : "nourlconvert",
					convert_urls : false,
					language : "' . (file_exists(_PS_ROOT_DIR_ . '/js/tinymce/jscripts/tiny_mce/langs/' . $this->iso_lang . '.js') ? $this->iso_lang : 'en') . '"
				});
			</script>';
		} else {
			$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/pm_tinymce.inc.js"></script>';
		}
	}
	private function displayMenuForm($cms, $categories, $manufacturer, $supplier, $ObjAdvancedTopMenuClass) {

		$imgIconMenuDirIsWritable = is_writable(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/menu_icons');
		$haveDepend = false;
		$ids_lang = 'menuname¤menulink¤menu_value_over¤menu_value_under';
		$this->_html .= '<script type="text/javascript">id_language = ' . intval($this->defaultLanguage) . ';</script>';
		if ($ObjAdvancedTopMenuClass)
			$haveDepend = AdvancedTopMenuClass::menuHaveDepend($ObjAdvancedTopMenuClass->id);
		$this->_html .= '<form action="' . $this->base_config_url . '" method="post" id="menuform_' . $this->name . '" name="menuform_' . $this->name . '" method="post" enctype="multipart/form-data" class="width3">
    <div id="blocMenuForm">
        ' . ($ObjAdvancedTopMenuClass ? '<input type="hidden" name="id_menu" value="' . intval($ObjAdvancedTopMenuClass->id) . '" /><br /><a href="' . $this->base_config_url . '"><img src="../img/admin/arrow2.gif" />' . $this->l('Back') . '</a><br class="clear" /><br />' : '');
		$this->_html .= '<label>' . $this->l('Tab type') . '</label>
       <div class="margin-form"><select name="type" id="type_menu">
          <option value="">' . $this->l('Choose') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 1 ? 'selected="selected"' : '') . '>' . $this->l('CMS') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 2 ? 'selected="selected"' : '') . '>' . $this->l('Link') . '</option>
          <option value="3" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 3 ? 'selected="selected"' : '') . '>' . $this->l('Category') . '</option>
           <option value="4" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 4 ? 'selected="selected"' : '') . '>' . $this->l('Manufacturer') . '</option>
          <option value="5" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 5 ? 'selected="selected"' : '') . '>' . $this->l('Supplier') . '</option>
          <option value="6" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 6 ? 'selected="selected"' : '') . '>' . $this->l('Search') . '</option>
          <option value="7" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 7 ? 'selected="selected"' : '') . '>' . $this->l('Only image or icon') . '</option>
       </select></div>';
		$this->_html .= '<script type="text/javascript">$("#type_menu").change(function() {showMenuType($(this),"menu");});</script>';
		$this->_html .= '<label>' . $this->l('Menu link not clickable') . '</label>
          <div class="margin-form">
          <input type="checkbox" name="clickable" id="menu_clickable" value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->link [$this->defaultLanguage] == '#' ? ' checked=checked' : '') . '  />
          <small>' . $this->l('Add a # in the link field. Do not remove.') . '</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("#menu_clickable").click(function() {setUnclickable($(this));});</script>';
		if ($ObjAdvancedTopMenuClass && in_array($ObjAdvancedTopMenuClass->type, $this->rebuildable_type)) {
			$this->_html .= '<label>' . $this->l('Rebuild tree') . '</label>
          <div class="margin-form"><label class="t" for="rebuild_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="rebuild" id="rebuild_on" value="1" />
            <label class="t" for="rebuild_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="rebuild_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="rebuild" id="rebuild_off" value="0" checked=checked />
            <label class="t" for="rebuild_off"> ' . $this->l('No') . '</label><br />' . $this->l('Caution, this may change the appearance of your menu !') . '</div>';
		}
		$this->_html .= '<div class="add_title menu_element"  ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 7 ? 'style="display:none;"' : '') . '>';
		$this->_html .= '<label>' . $this->l('Title') . '</label>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="menuname_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <input size="20" type="text" name="name_' . $language ['id_lang'] . '" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->name [$language ['id_lang']] : '') . '" />
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'menuname', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '</div>';

		$this->_html .= '<div class="add_category menu_element" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 3 ? '' : 'style="display:none;"') . '>';

		$this->displayCategoriesSelect($categories, ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->id_category : 0));
		$this->_html .= '<label>' . $this->l('Include Subcategories') . '</label>
          <div class="margin-form"><label class="t" for="menu_subcats_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="include_subs" id="menu_subcats_on" value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 3 && $haveDepend ? ' checked=checked' : '') . ' />
            <label class="t" for="menu_subcats_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="menu_subcats_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="include_subs" id="menu_subcats_off" value="0" ' . (! $ObjAdvancedTopMenuClass || ($ObjAdvancedTopMenuClass->type == 3 && ! $haveDepend) ? ' checked=checked' : '') . ' />
            <label class="t" for="menu_subcats_off"> ' . $this->l('No') . '</label></div>';
		$this->_html .= ' </div>';
		$this->_html .= '<div class="add_cms menu_element"   ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 1 ? '' : 'style="display:none;"') . '>';

		$this->displayCmsSelect($cms, ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->id_cms : 0));

		$this->_html .= ' </div>';

		$this->_html .= '<div class="add_manufacturer menu_element"  ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 4 ? '' : 'style="display:none;"') . '>';

		$this->_html .= '<label>' . $this->l('All manufacturers') . '</label>
          <div class="margin-form"><label class="t" for="menu_submanu_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="include_subs_manu" id="menu_submanu_on" value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 4 && $haveDepend ? ' checked=checked' : '') . ' />
            <label class="t" for="menu_submanu_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="menu_submanu_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="include_subs_manu" id="menu_submanu_off" value="0" ' . (! $ObjAdvancedTopMenuClass || ($ObjAdvancedTopMenuClass->type == 4 && ! $haveDepend) ? ' checked=checked' : '') . ' />
            <label class="t" for="menu_submanu_off"> ' . $this->l('No') . '</label></div>';
		$this->_html .= '<script type="text/javascript">$("#menu_submanu_on, #menu_submanu_off").click(function() {hideNextIfTrue($(this));});</script>';
		$this->_html .= '<div ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 4 && $haveDepend ? ' style="display:none"' : '') . '>';
		$this->displayManufacturerSelect($manufacturer, ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->id_manufacturer : 0));
		$this->_html .= '</div>';
		$this->_html .= ' </div>';

		$this->_html .= '<div class="add_supplier menu_element"  ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 5 ? '' : 'style="display:none;"') . '>';
		$this->_html .= '<label>' . $this->l('All suppliers') . '</label>
          <div class="margin-form"><label class="t" for="menu_subsuppl_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="include_subs_suppl" id="menu_subsuppl_on" value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 5 && $haveDepend ? ' checked=checked' : '') . ' />
            <label class="t" for="menu_subsuppl_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="menu_subsuppl_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="include_subs_suppl" id="menu_subsuppl_off" value="0" ' . (! $ObjAdvancedTopMenuClass || ($ObjAdvancedTopMenuClass->type == 5 && ! $haveDepend) ? ' checked=checked' : '') . ' />
            <label class="t" for="menu_subsuppl_off"> ' . $this->l('No') . '</label></div>';
		$this->_html .= '<script type="text/javascript">$("#menu_subsuppl_on, #menu_subsuppl_off").click(function() {hideNextIfTrue($(this));});</script>';
		$this->_html .= '<div ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 5 && $haveDepend ? ' style="display:none"' : '') . '>';
		$this->displaySupplierSelect($supplier, ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->id_supplier : 0));
		$this->_html .= ' </div>';
		$this->_html .= ' </div>';
		$this->_html .= '<div class="add_link menu_element"  ' . ($ObjAdvancedTopMenuClass && ($ObjAdvancedTopMenuClass->type != 2 || $ObjAdvancedTopMenuClass->type != 7) ? 'style="display:none;"' : '') . '>
          <label>' . $this->l('Link') . '</label>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="menulink_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <input size="20" type="text" name="link_' . $language ['id_lang'] . '" class="adtmInputLink" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->link [$language ['id_lang']] : '') . '" />
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'menulink', true);
		$this->_html .= '<div class="clear"></div></div></div>';

		$this->displayTargetSelect(($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->target : 0));
		$this->_html .= '<div class="add_title menu_element"  ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->type == 7 ? 'style="display:none;"' : '') . '>';
		$this->_html .= '<label>' . $this->l('Text color') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="txt_color_menu_tab" class="colorPicker" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->txt_color_menu_tab : '') . '" />
      <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Text color over') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="txt_color_menu_tab_hover" class="colorPicker" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->txt_color_menu_tab_hover : '') . '" />
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '</div>';
		$color1 = false;
		$color2 = false;
		$val = false;
		if ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->fnd_color_menu_tab) {
			$val = explode($this->gradient_separator, $ObjAdvancedTopMenuClass->fnd_color_menu_tab);
			if (isset($val [1])) {
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
				$color2 = htmlentities($val [1], ENT_COMPAT, 'UTF-8');
			}
			else
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
		}
		$this->_html .= '<label>' . $this->l('Background color') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="fnd_color_menu_tab[0]" id="fnd_color_menu_tab_0" class="colorPicker" value="' . (! $color1 ? '' : $color1) . '" size="20" />
          &nbsp; <span ' . (isset($color2) && $color2 ? '' : 'style="display:none"') . ' id="fnd_color_menu_tab_gradient"><input size="20" type="text" class="colorPicker" name="fnd_color_menu_tab[1]" id="fnd_color_menu_tab_1" value="' . (! isset($color2) || ! $color2 ? '' : $color2) . '" size="20" /></span>
          &nbsp; <input type="checkbox" name="fnd_color_menu_tab_gradient" value="1" ' . (isset($color2) && $color2 ? 'checked=checked' : '') . ' /> &nbsp; ' . $this->l('Make a gradient') . '
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("input[name=fnd_color_menu_tab_gradient]").click(function() {showSpanIfChecked($(this),"#fnd_color_menu_tab_gradient");});</script>';
		$color1 = false;
		$color2 = false;
		$val = false;
		if ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->fnd_color_menu_tab_over) {
			$val = explode($this->gradient_separator, $ObjAdvancedTopMenuClass->fnd_color_menu_tab_over);
			if (isset($val [1])) {
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
				$color2 = htmlentities($val [1], ENT_COMPAT, 'UTF-8');
			}
			else
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
		}
		$this->_html .= '<label>' . $this->l('Background color over') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="fnd_color_menu_tab_over[0]" id="fnd_color_menu_tab_over_0" class="colorPicker" value="' . (! $color1 ? '' : $color1) . '" size="20" />
          &nbsp; <span ' . (isset($color2) && $color2 ? '' : 'style="display:none"') . ' id="fnd_color_menu_tab_over_gradient"><input size="20" type="text" class="colorPicker" name="fnd_color_menu_tab_over[1]" id="fnd_color_menu_tab_over_1" value="' . (! isset($color2) || ! $color2 ? '' : $color2) . '" size="20" /></span>
          &nbsp; <input type="checkbox" name="fnd_color_menu_tab_over_gradient" value="1" ' . (isset($color2) && $color2 ? 'checked=checked' : '') . ' /> &nbsp; ' . $this->l('Make a gradient') . '
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("input[name=fnd_color_menu_tab_over_gradient]").click(function() {showSpanIfChecked($(this),"#fnd_color_menu_tab_over_gradient");});</script>';
		if ($ObjAdvancedTopMenuClass) {
			$borders_size_tab = explode(' ', $ObjAdvancedTopMenuClass->border_size_tab);
		}
		$this->_html .= '<label>' . $this->l('Border size') . '</label>
          <div class="margin-form">
          ' . $this->l('top') . ' <input size="3" type="text" name="border_size_tab[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_tab !== '0' && isset($borders_size_tab [0]) ? intval(preg_replace('#px#', '', $borders_size_tab [0])) : '') . '" /> &nbsp;
          ' . $this->l('right') . ' <input size="3" type="text" name="border_size_tab[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_tab !== '0' && isset($borders_size_tab [1]) ? intval(preg_replace('#px#', '', $borders_size_tab [1])) : '') . '" /> &nbsp;
          ' . $this->l('bottom') . ' <input size="3" type="text" name="border_size_tab[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_tab !== '0' && isset($borders_size_tab [2]) ? intval(preg_replace('#px#', '', $borders_size_tab [2])) : '') . '" /> &nbsp;
          ' . $this->l('left') . ' <input size="3" type="text" name="border_size_tab[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_tab !== '0' && isset($borders_size_tab [3]) ? intval(preg_replace('#px#', '', $borders_size_tab [3])) : '') . '" />
          <br /><small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Border color') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="border_color_tab" class="colorPicker" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->border_color_tab : '') . '" />
      <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Submenu width (px)') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="width_submenu" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->width_submenu : '') . '" />
          <small>(' . $this->l('If empty, the global styles are used') . ',' . $this->l('Put 0 for automatic width') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Submenu min-height (px)') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="minheight_submenu" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->minheight_submenu : '') . '" />
          <small>(' . $this->l('If empty, the global styles are used') . ', ' . $this->l('Put 0 for automatic height') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Show sub-menu') . '</label>
      <div class="margin-form"><select name="position_submenu">
      <option value="" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->position_submenu == 0 ? 'selected="selected"' : '') . '>' . $this->l('Use global styles') . '</option>
      <option value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->position_submenu == 1 ? 'selected="selected"' : '') . '>' . $this->l('Left-aligned current menu') . '</option>
      <option value="3" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->position_submenu == 3 ? 'selected="selected"' : '') . '>' . $this->l('Right-aligned current menu') . '</option>
      <option value="2" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->position_submenu == 2 ? 'selected="selected"' : '') . '>' . $this->l('Left-aligned global menu') . '</option>
      </select> &nbsp; <span></span>
      </div>';
		$color1 = false;
		$color2 = false;
		$val = false;
		if ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->fnd_color_submenu) {
			$val = explode($this->gradient_separator, $ObjAdvancedTopMenuClass->fnd_color_submenu);
			if (isset($val [1])) {
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
				$color2 = htmlentities($val [1], ENT_COMPAT, 'UTF-8');
			}
			else
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
		}
		$this->_html .= '<label>' . $this->l('Submenu background color') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="fnd_color_submenu[0]" id="fnd_color_submenu_0" class="colorPicker" value="' . (! $color1 ? '' : $color1) . '" size="20" />
          &nbsp; <span ' . (isset($color2) && $color2 ? '' : 'style="display:none"') . ' id="fnd_color_submenu_gradient"><input size="20" type="text" class="colorPicker" name="fnd_color_submenu[1]" id="fnd_color_submenu_1" value="' . (! isset($color2) || ! $color2 ? '' : $color2) . '" size="20" /></span>
          &nbsp; <input type="checkbox" name="fnd_color_submenu_gradient" value="1" ' . (isset($color2) && $color2 ? 'checked=checked' : '') . ' /> &nbsp; ' . $this->l('Make a gradient') . '
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("input[name=fnd_color_submenu_gradient]").click(function() {showSpanIfChecked($(this),"#fnd_color_submenu_gradient");});</script>';
		if ($ObjAdvancedTopMenuClass) {
			$borders_size_submenu = explode(' ', $ObjAdvancedTopMenuClass->border_size_submenu);
		}
		$this->_html .= '<label>' . $this->l('Submenu border size') . '</label>
          <div class="margin-form">
          ' . $this->l('top') . ' <input size="3" type="text" name="border_size_submenu[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_submenu !== '0' && isset($borders_size_submenu [0]) ? intval(preg_replace('#px#', '', $borders_size_submenu [0])) : '') . '" /> &nbsp;
          ' . $this->l('right') . ' <input size="3" type="text" name="border_size_submenu[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_submenu !== '0' && isset($borders_size_submenu [1]) ? intval(preg_replace('#px#', '', $borders_size_submenu [1])) : '') . '" /> &nbsp;
          ' . $this->l('bottom') . ' <input size="3" type="text" name="border_size_submenu[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_submenu !== '0' && isset($borders_size_submenu [2]) ? intval(preg_replace('#px#', '', $borders_size_submenu [2])) : '') . '" /> &nbsp;
          ' . $this->l('left') . ' <input size="3" type="text" name="border_size_submenu[]" value="' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->border_size_submenu !== '0' && isset($borders_size_submenu [3]) ? intval(preg_replace('#px#', '', $borders_size_submenu [3])) : '') . '" />
          <br /><small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Submenu border color') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="border_color_submenu" class="colorPicker" value="' . ($ObjAdvancedTopMenuClass ? $ObjAdvancedTopMenuClass->border_color_submenu : '') . '" />
      <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<label>' . $this->l('Text displayed above columns') . '</label>
      <div class="clear"></div>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="menu_value_over_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <textarea class="rte" cols="100" rows="20" name="value_over_' . $language ['id_lang'] . '">' . ($ObjAdvancedTopMenuClass ? htmlentities(stripslashes($ObjAdvancedTopMenuClass->value_over [$language ['id_lang']]), ENT_COMPAT, 'UTF-8') : '') . '</textarea>
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'menu_value_over', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '<label>' . $this->l('Text displayed below columns') . '</label>
      <div class="clear"></div>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="menu_value_under_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
          <textarea class="rte" cols="100" rows="20"  name="value_under_' . $language ['id_lang'] . '">' . ($ObjAdvancedTopMenuClass ? htmlentities(stripslashes($ObjAdvancedTopMenuClass->value_under [$language ['id_lang']]), ENT_COMPAT, 'UTF-8') : '') . '</textarea>
               </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'menu_value_under', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '<label>' . $this->l('Active') . '</label>
          <div class="margin-form"><label class="t" for="menu_active_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="active_menu" id="menu_active_on" value="1"' . (! $ObjAdvancedTopMenuClass || ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->active) ? ' checked="checked"' : '') . ' />
            <label class="t" for="active_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="menu_active_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="active_menu" id="menu_active_off" value="0" ' . ($ObjAdvancedTopMenuClass && ! $ObjAdvancedTopMenuClass->active ? 'checked="checked"' : '') . '/>
            <label class="t" for="active_off"> ' . $this->l('No') . '</label></div>';

		$this->_html .= '<label>' . $this->l('Privacy Options') . '</label>
        <div class="margin-form"><select name="privacy">
          <option value="0" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->privacy == 0 ? 'selected="selected"' : '') . '>' . $this->l('For all') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->privacy == 1 ? 'selected="selected"' : '') . '>' . $this->l('Only for visitors') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->privacy == 2 ? 'selected="selected"' : '') . '>' . $this->l('Only for registered users') . '</option>
       </select></div>';
		if (! $imgIconMenuDirIsWritable)
			$this->_html .= '<div class="warning warn clear">' . $this->l('To upload an icon, please assign CHMOD 777 to the directory:') . ' ' . _PS_ROOT_DIR_ . '/modules/' . $this->name . '/column_icons' . '</div>';

		$this->_html .= '<label>' . $this->l('Icon or image') . '</label>
          <div class="margin-form"><input type="file" name="icon" size="20" ' . (! $imgIconMenuDirIsWritable ? 'disabled=disabled' : '') . ' />
          ' . ($ObjAdvancedTopMenuClass && $ObjAdvancedTopMenuClass->have_icon ? '<input type="hidden" name="have_icon" value="' . intval($ObjAdvancedTopMenuClass->have_icon) . '" /><br /><img src="' . $this->_path . 'menu_icons/' . $ObjAdvancedTopMenuClass->id . '.' . ($ObjAdvancedTopMenuClass->image_type ? $ObjAdvancedTopMenuClass->image_type : 'jpg') . '?' . uniqid() . '" /><br /><input type="checkbox" name="unlink_icon" value="1" /> &nbsp; ' . $this->l('Delete this image') : '') . '
          <small>(' . $this->l('gif, jpg, png') . ')</small></div>';
		$this->_html .= '<center>
            <input type="submit" value="' . $this->l('   Save   ') . '" name="submitMenu" class="button" />
          </center>
      </form></div><br />';
		if ($ObjAdvancedTopMenuClass)
			$this->_html .= '<script type="text/javascript">$(function(){showMenuType($("#type_menu"),"menu")});</script>';
	}

	private function displayColumnWrapForm($menus, $ObjAdvancedTopMenuColumnWrapClass) {
		$ids_lang = 'columnwrap_value_over¤columnwrap_value_under';
		$this->_html .= '<script type="text/javascript">id_language = ' . intval($this->defaultLanguage) . ';</script>';
		$this->_html .= '<form action="' . $this->base_config_url . '" id="formColumn_' . $this->name . '" name="form_' . $this->name . '" method="post" enctype="multipart/form-data" class="width3">
    <div id="blocColumnWrapForm">
        ' . ($ObjAdvancedTopMenuColumnWrapClass ? '<input type="hidden" name="id_wrap" value="' . intval($ObjAdvancedTopMenuColumnWrapClass->id) . '" /><br /><a href="' . $this->base_config_url . '"><img src="../img/admin/arrow2.gif" />' . $this->l('Back') . '</a><br class="clear" /><br />' : '') . '
     <label>' . $this->l('Parent tab') . '</label>
       <div class="margin-form"><select name="id_menu">
          <option value="">' . $this->l('Choose') . '</option>';
		foreach ( $menus as $menu ) {
			$this->_html .= '<option value="' . $menu ['id_menu'] . '" ' . ($ObjAdvancedTopMenuColumnWrapClass && $ObjAdvancedTopMenuColumnWrapClass->id_menu == $menu ['id_menu'] ? 'selected="selected"' : '') . '>' . $this->getAdminOutputNameValue($menu, false) . '</option>';
		}
		$this->_html .= ' </select></div>';
		$this->_html .= '<label>' . $this->l('Column title (is not displayed in front office)') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="internal_name" value="' . ($ObjAdvancedTopMenuColumnWrapClass ? $ObjAdvancedTopMenuColumnWrapClass->internal_name : '') . '" />
          </div>';
		$this->_html .= '<label>' . $this->l('Width') . '</label>
         <div class="margin-form">
        <input type="text" name="width" value="' . ($ObjAdvancedTopMenuColumnWrapClass ? $ObjAdvancedTopMenuColumnWrapClass->width : '') . '" size="20" />
      </div>';
		$color1 = false;
		$color2 = false;
		$val = false;
		if ($ObjAdvancedTopMenuColumnWrapClass && $ObjAdvancedTopMenuColumnWrapClass->bg_color) {
			$val = explode($this->gradient_separator, $ObjAdvancedTopMenuColumnWrapClass->bg_color);
			if (isset($val [1])) {
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
				$color2 = htmlentities($val [1], ENT_COMPAT, 'UTF-8');
			}
			else
				$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
		}
		$this->_html .= '<label>' . $this->l('Background color') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="bg_color[0]" id="bg_color_0" class="colorPicker" value="' . (! $color1 ? '' : $color1) . '" size="20" />
          &nbsp; <span ' . (isset($color2) && $color2 ? '' : 'style="display:none"') . ' id="bg_color_gradient"><input size="20" type="text" class="colorPicker" name="bg_color[1]" id="bg_color_1" value="' . (! isset($color2) || ! $color2 ? '' : $color2) . '" size="20" /></span>
          &nbsp; <input type="checkbox" name="bg_color_gradient" value="1" ' . (isset($color2) && $color2 ? 'checked=checked' : '') . ' /> &nbsp; ' . $this->l('Make a gradient') . '
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("input[name=bg_color_gradient]").click(function() {showSpanIfChecked($(this),"#bg_color_gradient");});</script>';
		$this->_html .= '<label>' . $this->l('Text color group') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="txt_color_column" class="colorPicker" value="' . ($ObjAdvancedTopMenuColumnWrapClass ? $ObjAdvancedTopMenuColumnWrapClass->txt_color_column : '') . '" />
      <small>(' . $this->l('If empty, the global styles are used') . ')</small>
         </div>';
		$this->_html .= '<label>' . $this->l('Text color group over') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="txt_color_column_over" class="colorPicker" value="' . ($ObjAdvancedTopMenuColumnWrapClass ? $ObjAdvancedTopMenuColumnWrapClass->txt_color_column_over : '') . '" />
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
        </div>';
		$this->_html .= '<label>' . $this->l('Text color items') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="txt_color_element" class="colorPicker" value="' . ($ObjAdvancedTopMenuColumnWrapClass ? $ObjAdvancedTopMenuColumnWrapClass->txt_color_element : '') . '" />
          <small>(' . $this->l('If empty, the global styles are used') . ')</small>
         </div>';
		$this->_html .= '<label>' . $this->l('Text color items over') . '</label>
          <div class="margin-form">
          <input size="20" type="text" name="txt_color_element_over" class="colorPicker" value="' . ($ObjAdvancedTopMenuColumnWrapClass ? $ObjAdvancedTopMenuColumnWrapClass->txt_color_element_over : '') . '" />
      <small>(' . $this->l('If empty, the global styles are used') . ')</small>
        </div>';
		$this->_html .= '<label>' . $this->l('Text displayed above column') . '</label>
      <div class="clear"></div>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="columnwrap_value_over_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <textarea class="rte" cols="100" rows="20" name="value_over_' . $language ['id_lang'] . '">' . ($ObjAdvancedTopMenuColumnWrapClass ? htmlentities(stripslashes($ObjAdvancedTopMenuColumnWrapClass->value_over [$language ['id_lang']]), ENT_COMPAT, 'UTF-8') : '') . '</textarea>
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'columnwrap_value_over', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '<label>' . $this->l('Text displayed below column') . '</label>
      <div class="clear"></div>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="columnwrap_value_under_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
          <textarea class="rte" cols="100" rows="20"  name="value_under_' . $language ['id_lang'] . '">' . ($ObjAdvancedTopMenuColumnWrapClass ? htmlentities(stripslashes($ObjAdvancedTopMenuColumnWrapClass->value_under [$language ['id_lang']]), ENT_COMPAT, 'UTF-8') : '') . '</textarea>
               </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'columnwrap_value_under', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '<label>' . $this->l('Active') . '</label>
          <div class="margin-form"><label class="t" for="columnwrap_active_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="active_column" id="columnwrap_active_on" value="1"' . (! $ObjAdvancedTopMenuColumnWrapClass || ($ObjAdvancedTopMenuColumnWrapClass && $ObjAdvancedTopMenuColumnWrapClass->active) ? ' checked="checked"' : '') . ' />
            <label class="t" for="columnwrap_active_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="columnwrap_active_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="active_column" id="columnwrap_active_off" value="0" ' . ($ObjAdvancedTopMenuColumnWrapClass && ! $ObjAdvancedTopMenuColumnWrapClass->active ? 'checked="checked"' : '') . '/>
            <label class="t" for="columnwrap_active_off"> ' . $this->l('No') . '</label></div>';

		$this->_html .= '<label>' . $this->l('Privacy Options') . '</label>
        <div class="margin-form"><select name="privacy">
          <option value="0" ' . ($ObjAdvancedTopMenuColumnWrapClass && $ObjAdvancedTopMenuColumnWrapClass->privacy == 0 ? 'selected="selected"' : '') . '>' . $this->l('For all') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuColumnWrapClass && $ObjAdvancedTopMenuColumnWrapClass->privacy == 1 ? 'selected="selected"' : '') . '>' . $this->l('Only for visitors') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuColumnWrapClass && $ObjAdvancedTopMenuColumnWrapClass->privacy == 2 ? 'selected="selected"' : '') . '>' . $this->l('Only for registered users') . '</option>
       </select></div>';
		$this->_html .= '<center>
            <input type="submit" value="' . $this->l('   Save   ') . '" name="submitColumnWrap" class="button" />
          </center>
      </form></div><br /><br />';
	}
	private function displayColumnForm($menus, $cms, $categories, $manufacturer, $supplier, $ObjAdvancedTopMenuColumnClass) {
		$ids_lang = 'columnname¤columnlink¤column_value_over¤column_value_under';
		$this->_html .= '<script type="text/javascript">id_language = ' . intval($this->defaultLanguage) . ';</script>';
		$imgIconColumnDirIsWritable = is_writable(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/column_icons');
		$haveDepend = false;
		if ($ObjAdvancedTopMenuColumnClass)
			$haveDepend = AdvancedTopMenuColumnClass::columnHaveDepend($ObjAdvancedTopMenuColumnClass->id);
		$this->_html .= '<form action="' . $this->base_config_url . '" id="formColumn_' . $this->name . '" name="form_' . $this->name . '" method="post" enctype="multipart/form-data" class="width3">
    <div id="blocColumnForm">
        ' . ($ObjAdvancedTopMenuColumnClass ? '<input type="hidden" name="id_column" value="' . intval($ObjAdvancedTopMenuColumnClass->id) . '" /><br /><a href="' . $this->base_config_url . '"><img src="../img/admin/arrow2.gif" />' . $this->l('Back') . '</a><br class="clear" /><br />' : '') . '
     <label>' . $this->l('Parent tab') . '</label>
       <div class="margin-form"><select name="id_menu" id="id_menu_select2">
          <option value="">' . $this->l('Choose') . '</option>';
		foreach ( $menus as $menu ) {
			$this->_html .= '<option value="' . $menu ['id_menu'] . '" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->id_menu == $menu ['id_menu'] ? 'selected="selected"' : '') . '>' . $this->getAdminOutputNameValue($menu, false) . '</option>';
		}
		$this->_html .= ' </select></div>';
		$this->_html .= '<script type="text/javascript">$("#id_menu_select2").change(function() {showColumnWrapSelect($(this));});</script>';
		$this->_html .= '<label>' . $this->l('Parent column') . '</label>
       <div class="margin-form" id="columnWrap_select">' . $this->l('Please select a parent menu!') . '</div>';
		if ($ObjAdvancedTopMenuColumnClass) {
			$this->_html .= '<script type="text/javascript">showColumnWrapSelect($("#id_menu_select2"),' . intval($ObjAdvancedTopMenuColumnClass->id_wrap) . ');</script>';
		}
		$this->_html .= '<label>' . $this->l('Type group') . '</label>
       <div class="margin-form"><select name="type" id="type_column">
          <option value="">' . $this->l('Choose') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 1 ? 'selected="selected"' : '') . '>' . $this->l('CMS') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 2 ? 'selected="selected"' : '') . '>' . $this->l('Link') . '</option>
          <option value="3" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 3 ? 'selected="selected"' : '') . '>' . $this->l('Category') . '</option>
           <option value="4" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 4 ? 'selected="selected"' : '') . '>' . $this->l('Manufacturer') . '</option>
          <option value="5" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 5 ? 'selected="selected"' : '') . '>' . $this->l('Supplier') . '</option>
          <option value="6" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 6 ? 'selected="selected"' : '') . '>' . $this->l('Search') . '</option>
           <option value="7" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 7 ? 'selected="selected"' : '') . '>' . $this->l('Only image or icon') . '</option>
        </select></div>';
		$this->_html .= '<script type="text/javascript">$("#type_column").change(function() {showMenuType($(this),"column");});</script>';
		$this->_html .= '<label>' . $this->l('Group title link not clickable') . '</label>
          <div class="margin-form">
          <input type="checkbox" name="clickable" id="group_clickable" value="1" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->link [$this->defaultLanguage] ? ' checked=checked' : '') . '  />
          <small>' . $this->l('Add a # in the link field. Do not remove.') . '</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("#group_clickable").click(function() {setUnclickable($(this));});</script>';
		if ($ObjAdvancedTopMenuColumnClass && in_array($ObjAdvancedTopMenuColumnClass->type, $this->rebuildable_type)) {
			$this->_html .= '<label>' . $this->l('Rebuild tree') . '</label>
          <div class="margin-form"><label class="t" for="rebuild_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="rebuild" id="rebuild_on" value="1" />
            <label class="t" for="rebuild_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="rebuild_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="rebuild" id="rebuild_off" value="0" checked=checked />
            <label class="t" for="rebuild_off"> ' . $this->l('No') . '</label><br />' . $this->l('Caution, this may change the appearance of your menu !') . '</div>';
		}

		$this->_html .= '<div class="add_title menu_element"  ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 7 ? 'style="display:none;"' : '') . '>';
		$this->_html .= '<label>' . $this->l('Title') . '</label>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="columnname_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <input size="20" type="text" name="name_' . $language ['id_lang'] . '" value="' . ($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->name [$language ['id_lang']] : '') . '" />
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'columnname', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '</div>';
		$this->_html .= '<div class="add_category menu_element" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 3 ? '' : 'style="display:none;"') . '>';

		$this->displayCategoriesSelect($categories, ($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->id_category : 0));
		$this->_html .= '<label>' . $this->l('Include Subcategories') . '</label>
          <div class="margin-form"><label class="t" for="column_subcats_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="include_subs" id="column_subcats_on" value="1" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 3 && $haveDepend ? ' checked=checked' : '') . ' />
            <label class="t" for="column_subcats_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="column_subcats_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="include_subs" id="column_subcats_off" value="0" ' . (! $ObjAdvancedTopMenuColumnClass || ($ObjAdvancedTopMenuColumnClass->type == 3 && ! $haveDepend) ? ' checked=checked' : '') . ' />
            <label class="t" for="column_subcats_off"> ' . $this->l('No') . '</label></div>';
		$this->_html .= ' </div>';
		$this->_html .= '<div class="add_cms menu_element"   ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 1 ? '' : 'style="display:none;"') . '>';

		$this->displayCmsSelect($cms, ($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->id_cms : 0));

		$this->_html .= ' </div>';

		$this->_html .= '<div class="add_manufacturer menu_element"  ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 4 ? '' : 'style="display:none;"') . '>';

		$this->_html .= '<label>' . $this->l('All manufacturers') . '</label>
          <div class="margin-form"><label class="t" for="column_submanu_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="include_subs_manu" id="column_submanu_on" value="1" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 4 && $haveDepend ? ' checked=checked' : '') . ' />
            <label class="t" for="column_submanu_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="column_submanu_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="include_subs_manu" id="column_submanu_off" value="0" ' . (! $ObjAdvancedTopMenuColumnClass || ($ObjAdvancedTopMenuColumnClass->type == 4 && ! $haveDepend) ? ' checked=checked' : '') . ' />
            <label class="t" for="column_submanu_off"> ' . $this->l('No') . '</label></div>';
		$this->_html .= '<div ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 4 && $haveDepend ? ' style="display:none"' : '') . '>';

		$this->_html .= '<script type="text/javascript">$("#column_submanu_off,#column_submanu_on").click(function() {hideNextIfTrue($(this));});</script>';

		$this->displayManufacturerSelect($manufacturer, ($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->id_manufacturer : 0));
		$this->_html .= '</div>';
		$this->_html .= ' </div>';

		$this->_html .= '<div class="add_supplier menu_element"  ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 5 ? '' : 'style="display:none;"') . '>';
		$this->_html .= '<label>' . $this->l('All suppliers') . '</label>
          <div class="margin-form"><label class="t" for="column_subsuppl_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="include_subs_suppl" id="column_subsuppl_on" value="1" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 5 && $haveDepend ? ' checked=checked' : '') . ' />
            <label class="t" for="column_subsuppl_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="column_subsuppl_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="include_subs_suppl" id="column_subsuppl_off" value="0" ' . (! $ObjAdvancedTopMenuColumnClass || ($ObjAdvancedTopMenuColumnClass->type == 5 && ! $haveDepend) ? ' checked=checked' : '') . ' />
            <label class="t" for="column_subsuppl_off"> ' . $this->l('No') . '</label></div>';

		$this->_html .= '<script type="text/javascript">$("#column_subsuppl_on,#column_subsuppl_off").click(function() {hideNextIfTrue($(this));});</script>';

		$this->_html .= '<div ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type == 5 && $haveDepend ? ' style="display:none"' : '') . '>';
		$this->displaySupplierSelect($supplier, ($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->id_supplier : 0));
		$this->_html .= ' </div>';
		$this->_html .= ' </div>';
		$this->_html .= '<div class="add_link menu_element"  ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->type != 2 ? 'style="display:none;"' : '') . '>
          <label>' . $this->l('Link') . '</label>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="columnlink_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <input size="20" type="text" name="link_' . $language ['id_lang'] . '" class="adtmInputLink" value="' . ($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->link [$language ['id_lang']] : '') . '" />
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'columnlink', true);
		$this->_html .= '<div class="clear"></div></div></div>';

		$this->displayTargetSelect(($ObjAdvancedTopMenuColumnClass ? $ObjAdvancedTopMenuColumnClass->target : 0));

		$this->_html .= '<label>' . $this->l('Text displayed above group') . '</label>
      <div class="clear"></div>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="column_value_over_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <textarea class="rte" cols="100" rows="20" name="value_over_' . $language ['id_lang'] . '">' . ($ObjAdvancedTopMenuColumnClass ? htmlentities(stripslashes($ObjAdvancedTopMenuColumnClass->value_over [$language ['id_lang']]), ENT_COMPAT, 'UTF-8') : '') . '</textarea>
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'column_value_over', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '<label>' . $this->l('Text displayed below group') . '</label>
      <div class="clear"></div>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="column_value_under_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
          <textarea class="rte" cols="100" rows="20"  name="value_under_' . $language ['id_lang'] . '">' . ($ObjAdvancedTopMenuColumnClass ? htmlentities(stripslashes($ObjAdvancedTopMenuColumnClass->value_under [$language ['id_lang']]), ENT_COMPAT, 'UTF-8') : '') . '</textarea>
               </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'column_value_under', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '<label>' . $this->l('Active') . '</label>
          <div class="margin-form"><label class="t" for="column_active_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="active_column" id="column_active_on" value="1"' . (! $ObjAdvancedTopMenuColumnClass || ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->active) ? ' checked="checked"' : '') . ' />
            <label class="t" for="active_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="column_active_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="active_column" id="column_active_off" value="0" ' . ($ObjAdvancedTopMenuColumnClass && ! $ObjAdvancedTopMenuColumnClass->active ? 'checked="checked"' : '') . '/>
            <label class="t" for="active_off"> ' . $this->l('No') . '</label></div>';

		$this->_html .= '<label>' . $this->l('Privacy Options') . '</label>
        <div class="margin-form"><select name="privacy">
          <option value="0" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->privacy == 0 ? 'selected="selected"' : '') . '>' . $this->l('For all') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->privacy == 1 ? 'selected="selected"' : '') . '>' . $this->l('Only for visitors') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->privacy == 2 ? 'selected="selected"' : '') . '>' . $this->l('Only for registered users') . '</option>
       </select></div>';

		if (! $imgIconColumnDirIsWritable)
			$this->_html .= '<div class="warning warn clear">' . $this->l('To upload an icon, please assign CHMOD 777 to the directory:') . ' ' . _PS_ROOT_DIR_ . '/modules/' . $this->name . '/column_icons' . '</div>';

		$this->_html .= '<label>' . $this->l('Icon or image') . '</label>
          <div class="margin-form"><input type="file" name="icon" size="20" ' . (! $imgIconColumnDirIsWritable ? 'disabled=disabled' : '') . ' />
          ' . ($ObjAdvancedTopMenuColumnClass && $ObjAdvancedTopMenuColumnClass->have_icon ? '<input type="hidden" name="have_icon" value="' . intval($ObjAdvancedTopMenuColumnClass->have_icon) . '" /><br /><img src="' . $this->_path . 'column_icons/' . $ObjAdvancedTopMenuColumnClass->id . '.' . ($ObjAdvancedTopMenuColumnClass->image_type ? $ObjAdvancedTopMenuColumnClass->image_type : 'jpg') . '?' . uniqid() . '" /><br /><input type="checkbox" name="unlink_icon" value="1" /> &nbsp; ' . $this->l('Delete this image') : '') . '
           <small>(' . $this->l('gif, jpg, png') . ')</small></div>';
		$this->_html .= '<center>
            <input type="submit" value="' . $this->l('   Save   ') . '" name="submitColumn" class="button" />
          </center>
      </form></div><br /><br />';
		if ($ObjAdvancedTopMenuColumnClass)
			$this->_html .= '<script type="text/javascript">$(function(){showMenuType($("#type_column"),"column")});</script>';
	}
	private function displayElementForm($menus, $columns, $cms, $categories, $manufacturer, $supplier, $ObjAdvancedTopMenuElementClass) {
		$imgIconElementDirIsWritable = is_writable(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/element_icons');
		$ids_lang = 'elementname¤elementlink';
		$this->_html .= '<script type="text/javascript">id_language = ' . intval($this->defaultLanguage) . ';</script>';
		$this->_html .= '<form action="' . $this->base_config_url . '" id="formElement_' . $this->name . '" name="formElement_' . $this->name . '" method="post" enctype="multipart/form-data" class="width3">
    <div id="blocElementForm">
        ' . ($ObjAdvancedTopMenuElementClass ? '<input type="hidden" name="id_element" value="' . intval($ObjAdvancedTopMenuElementClass->id) . '" /><br /><a href="' . $this->base_config_url . '"><img src="../img/admin/arrow2.gif" />' . $this->l('Back') . '</a><br class="clear" /><br />' : '') . '
     <label>' . $this->l('Parent menu') . '</label>
       <div class="margin-form"><select name="id_menu" id="id_menu_select">
          <option value="">' . $this->l('Choose') . '</option>';
		foreach ( $menus as $menu ) {
			$this->_html .= '<option value="' . $menu ['id_menu'] . '" ' . ($ObjAdvancedTopMenuElementClass && AdvancedTopMenuColumnClass::getIdMenuByIdColumn($ObjAdvancedTopMenuElementClass->id_column) == $menu ['id_menu'] ? 'selected="selected"' : '') . '>' . $this->getAdminOutputNameValue($menu, false) . '</option>';
		}
		$this->_html .= ' </select></div>';
		$this->_html .= '<script type="text/javascript">$("#id_menu_select").change(function() {showColumnSelect($(this));});</script>';
		$this->_html .= '<label>' . $this->l('Parent group') . '</label>
       <div class="margin-form" id="column_select">' . $this->l('Please select a parent menu!') . '</div>';
		if ($ObjAdvancedTopMenuElementClass) {
			$this->_html .= '<script type="text/javascript">showColumnSelect($("#id_menu_select"),' . intval($ObjAdvancedTopMenuElementClass->id_column) . ');</script>';
		}
		$this->_html .= '<label>' . $this->l('Item type') . '</label>
       <div class="margin-form"><select name="type" id="type_element">
          <option value="">' . $this->l('Choose') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 1 ? 'selected="selected"' : '') . '>' . $this->l('CMS') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 2 ? 'selected="selected"' : '') . '>' . $this->l('Link') . '</option>
          <option value="3" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 3 ? 'selected="selected"' : '') . '>' . $this->l('Category') . '</option>
           <option value="4" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 4 ? 'selected="selected"' : '') . '>' . $this->l('Manufacturer') . '</option>
          <option value="5" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 5 ? 'selected="selected"' : '') . '>' . $this->l('Supplier') . '</option>
          <option value="6" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 6 ? 'selected="selected"' : '') . '>' . $this->l('Search') . '</option>
           <option value="7" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 7 ? 'selected="selected"' : '') . '>' . $this->l('Only image or icon') . '</option>
       </select></div>';
		$this->_html .= '<script type="text/javascript">$("#type_element").change(function() {showMenuType($(this),"element");});</script>';
		$this->_html .= '<label>' . $this->l('Element not clickable') . '</label>
          <div class="margin-form">
          <input type="checkbox" name="clickable" id="element_clickable" value="1" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->link [$this->defaultLanguage] ? ' checked=checked' : '') . '  />
          <small>' . $this->l('Add a # in the link field. Do not remove.') . '</small>
          </div>';
		$this->_html .= '<script type="text/javascript">$("#element_clickable").click(function() {setUnclickable($(this));});</script>';
		$this->_html .= '<div class="add_title menu_element"  ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 7 ? 'style="display:none;"' : '') . '>';
		$this->_html .= '<label>' . $this->l('Title') . '</label>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="elementname_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <input size="20" type="text" name="name_' . $language ['id_lang'] . '" value="' . ($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->name [$language ['id_lang']] : '') . '" />
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'elementname', true);
		$this->_html .= '<div class="clear"></div></div>';
		$this->_html .= '</div>';
		$this->_html .= '<div class="add_category menu_element" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 3 ? '' : 'style="display:none;"') . '>';

		$this->displayCategoriesSelect($categories, ($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->id_category : 0));

		$this->_html .= ' </div>';
		$this->_html .= '<div class="add_cms menu_element"   ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 1 ? '' : 'style="display:none;"') . '>';

		$this->displayCmsSelect($cms, ($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->id_cms : 0));

		$this->_html .= ' </div>';

		$this->_html .= '<div class="add_manufacturer menu_element"  ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 4 ? '' : 'style="display:none;"') . '>';
		$this->displayManufacturerSelect($manufacturer, ($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->id_manufacturer : 0));
		$this->_html .= ' </div>';

		$this->_html .= '<div class="add_supplier menu_element"  ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type == 5 ? '' : 'style="display:none;"') . '>';
		$this->displaySupplierSelect($supplier, ($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->id_supplier : 0));
		$this->_html .= ' </div>';
		$this->_html .= '<div class="add_link menu_element"  ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->type != 2 ? 'style="display:none;"' : '') . '>
          <label>' . $this->l('Link') . '</label>
          <div class="margin-form">';
		foreach ( $this->languages as $language ) {
			$this->_html .= '
              <div id="elementlink_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->defaultLanguage ? 'block' : 'none') . '; float: left;">
                <input size="20" type="text" name="link_' . $language ['id_lang'] . '" class="adtmInputLink" value="' . ($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->link [$language ['id_lang']] : '') . '" />
              </div>';
		}
		$this->_html .= $this->displayFlags($this->languages, $this->defaultLanguage, $ids_lang, 'elementlink', true);
		$this->_html .= '<div class="clear"></div></div></div>';

		$this->displayTargetSelect(($ObjAdvancedTopMenuElementClass ? $ObjAdvancedTopMenuElementClass->target : 0));

		$this->_html .= '<label>' . $this->l('Active') . '</label>
          <div class="margin-form"><label class="t" for="element_active_on"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
            <input type="radio" name="active_element" id="element_active_on" value="1"' . (! $ObjAdvancedTopMenuElementClass || ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->active) ? ' checked="checked"' : '') . ' />
            <label class="t" for="active_on"> ' . $this->l('Yes') . '</label>
            <label class="t" for="element_active_off"><img src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" style="margin-left: 10px;" /></label>
            <input type="radio" name="active_element" id="element_active_off" value="0" ' . ($ObjAdvancedTopMenuElementClass && ! $ObjAdvancedTopMenuElementClass->active ? 'checked="checked"' : '') . '/>
            <label class="t" for="active_off"> ' . $this->l('No') . '</label></div>';

		$this->_html .= '<label>' . $this->l('Privacy Options') . '</label>
        <div class="margin-form"><select name="privacy">
          <option value="0" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->privacy == 0 ? 'selected="selected"' : '') . '>' . $this->l('For all') . '</option>
          <option value="1" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->privacy == 1 ? 'selected="selected"' : '') . '>' . $this->l('Only for visitors') . '</option>
          <option value="2" ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->privacy == 2 ? 'selected="selected"' : '') . '>' . $this->l('Only for registered users') . '</option>
       </select></div>';

		if (! $imgIconElementDirIsWritable)
			$this->_html .= '<div class="warning warn clear">' . $this->l('To upload an icon, please assign CHMOD 777 to the directory:') . ' ' . _PS_ROOT_DIR_ . '/modules/' . $this->name . '/element_icons' . '</div>';

		$this->_html .= '<label>' . $this->l('Icon or image') . '</label>
          <div class="margin-form"><input type="file" name="icon" size="20" ' . (! $imgIconElementDirIsWritable ? 'disabled=disabled' : '') . ' />
          ' . ($ObjAdvancedTopMenuElementClass && $ObjAdvancedTopMenuElementClass->have_icon ? '<input type="hidden" name="have_icon" value="' . intval($ObjAdvancedTopMenuElementClass->have_icon) . '" /><br /><img src="' . $this->_path . 'element_icons/' . $ObjAdvancedTopMenuElementClass->id . '.' . ($ObjAdvancedTopMenuElementClass->image_type ? $ObjAdvancedTopMenuElementClass->image_type : 'jpg') . '?' . uniqid() . '" /><br /><input type="checkbox" name="unlink_icon" value="1" /> &nbsp; ' . $this->l('Delete this image') : '') . '
           <small>(' . $this->l('gif, jpg, png') . ')</small></div>';
		$this->_html .= '<center>
            <input type="submit" value="' . $this->l('   Save   ') . '" name="submitElement" class="button" />
          </center>
      </form></div><br /><br />';
		if ($ObjAdvancedTopMenuElementClass)
			$this->_html .= '<script type="text/javascript">$(function(){showMenuType($("#type_element"),"element")});</script>';
	}
	static public function hideCategoryPosition($name) {
		return preg_replace('/^[0-9]+\./', '', $name);
	}
	private function recurseCategory($categories, $current, $id_category = 1, $id_selected = 1) {
		global $currentIndex;
		$this->_html .= '<option value="' . $id_category . '"' . (($id_selected == $id_category) ? ' selected="selected"' : '') . '>' . str_repeat('&nbsp;', $current ['infos'] ['level_depth'] * 5) . (_PS_VERSION_ < 1.4 ? self::hideCategoryPosition(stripslashes($current ['infos'] ['name'])) : stripslashes($current ['infos'] ['name'])) . '</option>';
		if (isset($categories [$id_category]))
			foreach ( $categories [$id_category] as $key => $row )
				$this->recurseCategory($categories, $categories [$id_category] [$key], $key, $id_selected);
	}
	private function displayCategoriesSelect($categories, $selected) {
		$this->_html .= '<label>' . $this->l('Category') . '</label>
      <div class="margin-form"><select name="id_category">
        <option value="">' . $this->l('Choose') . '</option>';
		$this->recurseCategory($categories, $categories [0] [1], 1, $selected);
		/*foreach($categories as $category) {
      $this->_html .= '<option value="'.$category['id_category'].'" ' . ($selected == $category['id_category'] ? 'selected="selected"' : '') . '>' . $category['name'] . '</option>';
    }*/
		$this->_html .= ' </select></div>';
	}

	private function displayTargetSelect($selected) {
		$this->_html .= '<label>' . $this->l('Target') . '</label>
      <div class="margin-form"><select name="target">';
		foreach ( $this->link_targets as $target => $value ) {
			$this->_html .= '<option value="' . $target . '" ' . ($selected === $target ? 'selected="selected"' : '') . '>' . $value . '</option>';
		}
		$this->_html .= ' </select></div>';
	}
	private function displayCmsSelect($cmss, $selected) {
		$this->_html .= '<label>' . $this->l('CMS') . '</label>
      <div class="margin-form"><select name="id_cms">
        <option value="">' . $this->l('Choose') . '</option>';
		foreach ( $cmss as $cms ) {
			$this->_html .= '<option value="' . $cms ['id_cms'] . '" ' . ($selected == $cms ['id_cms'] ? 'selected="selected"' : '') . '>' . $cms ['meta_title'] . '</option>';
		}
		$this->_html .= ' </select></div>';
	}
	private function displayManufacturerSelect($manufacturers, $selected) {
		$this->_html .= '<label>' . $this->l('Manufacturer') . '</label>
      <div class="margin-form"><select name="id_manufacturer">
        <option value="">' . $this->l('Choose') . '</option>';
		foreach ( $manufacturers as $manufacturer ) {
			$this->_html .= '<option value="' . $manufacturer ['id_manufacturer'] . '" ' . ($selected == $manufacturer ['id_manufacturer'] ? 'selected="selected"' : '') . '>' . $manufacturer ['name'] . '</option>';
		}
		$this->_html .= ' </select></div>';
	}
	private function displaySupplierSelect($suppliers, $selected) {
		$this->_html .= '<label>' . $this->l('Supplier') . '</label>
      <div class="margin-form"><select name="id_supplier">
        <option value="">' . $this->l('Choose') . '</option>';
		foreach ( $suppliers as $supplier ) {
			$this->_html .= '<option value="' . $supplier ['id_supplier'] . '" ' . ($selected == $supplier ['id_supplier'] ? 'selected="selected"' : '') . '>' . $supplier ['name'] . '</option>';
		}
		$this->_html .= ' </select></div>';
	}
	protected function getType($type) {
		if ($type == 1)
			return $this->l('CMS');
		elseif ($type == 2)
			return $this->l('Link');
		elseif ($type == 3)
			return $this->l('Category');
		elseif ($type == 4)
			return $this->l('Manufacturer');
		elseif ($type == 5)
			return $this->l('Supplier');
		elseif ($type == 6)
			return $this->l('Search');
	}
	public function getLinkOutputValue($row, $type, $withExtra = true, $haveSub = false, $first_level = false) {
		global $link, $cookie;
		$return = false;
		$name = false;
		$icone = false;
		$url = false;
		$linkNotClickable = false;
		//print_r($row);
		if ((trim($row ['link'])) == '#')
			$linkNotClickable = true;
		//CMS
		if ($row ['type'] == 1) {
			if (trim($row ['name']))
				$name .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$name .= htmlentities($row ['meta_title'], ENT_COMPAT, 'UTF-8');
			if ($withExtra && trim($row ['have_icon']))
				$icone .= $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg');
			$url .= $link->getCMSLink(intval($row ['id_cms']), $row ['link_rewrite']);
		}
		//Lien
		elseif ($row ['type'] == 2) {
			if (trim($row ['name']))
				$name .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
				//else $name .= $this->l('No label');
			if ($withExtra && trim($row ['have_icon']))
				$icone .= $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg');
			if (trim($row ['link']))
				$url .= htmlentities($row ['link'], ENT_COMPAT, 'UTF-8');
			else
				$linkNotClickable = true;
		}
		//Category
		elseif ($row ['type'] == 3) {
			if (trim($row ['name']))
				$name .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$name .= htmlentities($row ['category_name'], ENT_COMPAT, 'UTF-8');
			if (_PS_VERSION_ < 1.4) {
				$name = self::hideCategoryPosition($name);
			}
			if ($withExtra && trim($row ['have_icon']))
				$icone .= $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg');

			$url .= $link->getCategoryLink(intval($row ['id_category']), $row ['category_link_rewrite']);
		}
		//Fabricant
		elseif ($row ['type'] == 4) {
			if (trim($row ['name']))
				$name .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$name .= htmlentities($row ['manufacturer_name'], ENT_COMPAT, 'UTF-8') . '';
			if ($withExtra && trim($row ['have_icon']))
				$icone .= $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg');

			$url .= $link->getManufacturerLink(intval($row ['id_manufacturer']), Tools::link_rewrite($row ['manufacturer_name'], false));
		}
		//Fornisseur
		elseif ($row ['type'] == 5) {

			if (trim($row ['name']))
				$name .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$name .= htmlentities($row ['supplier_name'], ENT_COMPAT, 'UTF-8') . '';

			if ($withExtra && trim($row ['have_icon']))
				$icone .= $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg');

			$url .= $link->getSupplierLink(intval($row ['id_supplier']), Tools::link_rewrite($row ['supplier_name'], false));
		}
		//Recherche
		elseif ($row ['type'] == 6) {
			$return .= '<form method="get" action="' . (_PS_VERSION_ < 1.4 ? __PS_BASE_URI__ . 'search.php' : $link->getPageLink('search.php')) . '" class="searchboxATM">
        <label for="search_query_atm_' . $type . '_' . $row ['id_' . $type] . '">' . ($withExtra && trim($row ['have_icon']) ? '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="" title="" class="adtm_menu_icon" />' : '') . '</label>
        <input type="hidden" name="orderby" value="position" />
        <input type="hidden" name="orderway" value="desc" />
        <input type="text" class="search_query_atm" id="search_query_atm_' . $type . '_' . $row ['id_' . $type] . '" name="search_query" value="' . (trim($row ['name']) ? htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') : '') . '"' . (trim($row ['name']) ? ' onfocus="javascript:if(this.value==\'' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '\')this.value=\'\';" onblur="javascript:if(this.value==\'\')this.value=\'' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '\';"' : '') . ' />
        <input type="submit" name="submit_search" value="' . $this->l('OK') . '" class="button_mini" />
      </form>';
			if (Configuration::get('ATM_AUTOCOMPLET_SEARCH')) {
				if (_PS_VERSION_ < 1.4) {
					$return .= '<script type="text/javascript">
			          function formatSearch(row) {
			            return row[2] + " > " + row[1];
			          }

			          function redirectSearch(event, data, formatted) {
			            $("#search_query_atm_' . $type . '_' . $row ['id_' . $type] . '").val(data[1]);
			            document.location.href = data[3];
			          }

			          $("document").ready( function() {
			            $("#search_query_atm_' . $type . '_' . $row ['id_' . $type] . '").autocomplete(
			              "' . __PS_BASE_URI__ . 'search.php", {
			              minChars: 3,
			              max:10,
			              selectFirst:false,
			              width:500,
			              scroll: false,
			              formatItem:formatSearch,
			              extraParams:{ajaxSearch:1,id_lang:' . $cookie->id_lang . '}
			            }).result(redirectSearch)
			          });
			        </script>';
				}
				else {
					$return .= '<script type="text/javascript">
			         $("#search_query_atm_' . $type . '_' . $row ['id_' . $type] . '")
					.autocomplete(
						 "' . $link->getPageLink('search.php') . '", {
							minChars: 3,
							max: 10,
							width: 500,
							selectFirst: false,
							scroll: false,
							dataType: "json",
							formatItem: function(data, i, max, value, term) {
								return value;
							},
							parse: function(data) {
								var mytab = new Array();
								for (var i = 0; i < data.length; i++)
									mytab[mytab.length] = { data: data[i], value: data[i].cname + \' > \' + data[i].pname };
								return mytab;
							},
							extraParams: {
								ajaxSearch: 1,
								id_lang: ' . $cookie->id_lang . '
							}
						}
					)
					.result(function(event, data, formatted) {
						$(\'#search_query_atm_' . $type . '_' . $row ['id_' . $type] . '\').val(data.pname);
						document.location.href = data.product_link;
					})
			        </script>';
				}

			}
			return $return;
		}
		//Image seul
		elseif ($row ['type'] == 7) {
			$name = '';
			if ($withExtra && trim($row ['have_icon']))
				$icone .= $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg');
			if (trim($row ['link']))
				$url .= htmlentities($row ['link'], ENT_COMPAT, 'UTF-8');
			else
				$linkNotClickable = true;
		}
		$urlIsActive = false;
		if (! $this->activeAllreadySet && Configuration::get('ATM_MENU_GLOBAL_ACTIF')) {
			if($id_product = Tools::getValue('id_product')) {
				//Check if url be cached
				if(!$this->current_category_product_url) {
					//Get product default category URL
					$product = new Product($id_product,false,$cookie->id_lang);
					//Put on cache
					if($product->category)
						$this->current_category_product_url = $link->getCategoryLink($product->id_category_default, $product->category);
				}
				$curUrl = $this->current_category_product_url;
			}
			if(!isset($curUrl) || !$curUrl) {
				$curUrl = explode('?', $_SERVER ['REQUEST_URI']);
				$curUrl = $curUrl [0] . $this->getKeepVar();
			}
			$destUrl = explode('?', $url);

			$destUrl = $destUrl [0] . (isset($destUrl [1]) ? $this->getKeepVar($destUrl [1]) : '');
			//Url de destination
			$destUrl = preg_replace('#https?://' . preg_quote($_SERVER ['HTTP_HOST'],'#') . '#i', '', $destUrl);
			//If PS_CANONICAL_REDIRECT add iso_lang
			if (_PS_VERSION_ >= 1.4 && $destUrl == __PS_BASE_URI__ && Configuration::get('PS_REWRITING_SETTINGS') && Configuration::get('PS_CANONICAL_REDIRECT') && Language::countActiveLanguages() > 1)
				$destUrl .= Language::getIsoById($cookie->id_lang).'/';
			//Url courante
			$curUrl = preg_replace('#https?://' . preg_quote($_SERVER ['HTTP_HOST'],'#') . '#i', '', $curUrl);
			$pregCurUrl = preg_quote($curUrl,'#');
			$pregDestUrl = preg_quote($destUrl,'#');
			$urlIsActive = ((strlen($curUrl) <= strlen($destUrl)) ? preg_match('#' . $pregDestUrl . '#i', $curUrl) : false);
		}
		///prestashop_1\.4\.1\.0/cms\.php\?id_cms\=1
		///prestashop_1\.4\.1\.0/cms\.php\?id_cms\=1
		if ($url && $urlIsActive) {
			$idActif = 'advtm_menu_actif_' . uniqid();
		}
		$return .= '<a href="' . ($linkNotClickable ? '#' : $url) . '" title="' . $name . '" ' . ($row ['target'] ? 'target="' . htmlentities($row ['target'], ENT_COMPAT, 'UTF-8') . '"' : '') . ' class="' . ($linkNotClickable ? 'adtm_unclickable' : '') . '' . ($first_level ? ' a-niveau1' : '') . '' . ($url && $urlIsActive ? ' advtm_menu_actif ' . $idActif : '') . '">';
		if ($type == 'menu')
			$return .= '<span class="advtm_menu_span advtm_menu_span_' . intval($row ['id_menu']) . '">';
		if ($icone)
			$return .= '<img src="' . $icone . '" alt="' . $name . '" title="' . $name . '" class="adtm_menu_icon" />';
		$return .= $name;
		if ($type == 'menu')
			$return .= '</span>';

		if ($haveSub)
			$return .= '<!--[if gte IE 7]><!-->';
		$return .= '</a>';

		if ($url && $urlIsActive) {
			$return .= '<script type="text/javascript">activateParentMenu(".' . $idActif . '","' . $type . '");</script>';
			$this->activeAllreadySet = true;
		}

		return $return;
	}
	public function getAdminOutputPrivacyValue($privacy) {
		$return = '<img src="' . $this->_path . 'img/privacy-' . $privacy . '.png" />';
		if (! $privacy)
			$return .= ' ' . $this->l('For all');
		if ($privacy == 1)
			$return .= ' ' . $this->l('Only for visitors');
		if ($privacy == 2)
			$return .= ' ' . $this->l('Only for registered users');
		return $return;
	}
	public function getAdminOutputNameValue($row, $withExtra = true, $type = false) {
		$return = '';
		//print_r($row);
		if ($row ['type'] == 1) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			if (trim($row ['name']))
				$return .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$return .= htmlentities($row ['meta_title'], ENT_COMPAT, 'UTF-8');
		}
		elseif ($row ['type'] == 2) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			if (trim($row ['name']))
				$return .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$return .= $this->l('No label');
		}
		elseif ($row ['type'] == 3) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			if (trim($row ['name']))
				$return .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else {
				if (_PS_VERSION_ < 1.4) {
					$row ['category_name'] = self::hideCategoryPosition($row ['category_name']);
				}
				$return .= htmlentities($row ['category_name'], ENT_COMPAT, 'UTF-8');
			}
		}
		elseif ($row ['type'] == 4) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			if (trim($row ['name']))
				$return .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			elseif (! $row ['id_manufacturer'] && ! trim($row ['name']))
				$return .= $this->l('No label');
			else
				$return .= htmlentities($row ['manufacturer_name'], ENT_COMPAT, 'UTF-8') . '';
		}
		elseif ($row ['type'] == 5) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			if (trim($row ['name']))
				$return .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			elseif (! $row ['id_supplier'] && ! trim($row ['name']))
				$return .= $this->l('No label');
			else
				$return .= htmlentities($row ['supplier_name'], ENT_COMPAT, 'UTF-8') . '';
		}
		elseif ($row ['type'] == 6) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			if (trim($row ['name']))
				$return .= htmlentities($row ['name'], ENT_COMPAT, 'UTF-8');
			else
				$return .= $this->l('No label');
		}
		elseif ($row ['type'] == 7) {
			if ($withExtra && trim($row ['have_icon']))
				$return .= '<img src="' . $this->_path . $type . '_icons/' . $row ['id_' . $type] . '.' . ($row ['image_type'] ? $row ['image_type'] : 'jpg') . '" alt="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($row ['name'], ENT_COMPAT, 'UTF-8') . '" />';
			$return .= $this->l('No label');
		}
		return $return;
	}
	/**
	 * Copy datas from $_POST to object
	 *
	 * @param object &$object Object
	 * @param string $table Object table
	 */
	protected function copyFromPost(&$object) {
		/* Classical fields */
		foreach ( $_POST as $key => $value ) {
			if ($key == 'active_column' || $key == 'active_menu' || $key == 'active_element') {
				$key = 'active';
			}
			if (key_exists($key, $object)) {
				$object->{$key} = $value;
			}
		}
		/* Multilingual fields */
		$rules = call_user_func(array (get_class($object), 'getValidationRules' ), get_class($object));
		if (sizeof($rules ['validateLang'])) {
			$languages = Language::getLanguages(false);
			foreach ( $languages as $language )
				foreach ( $rules ['validateLang'] as $field => $validation )
					if (isset($_POST [$field . '_' . intval($language ['id_lang'])])) {
						$object->{$field} [intval($language ['id_lang'])] = $_POST [$field . '_' . intval($language ['id_lang'])];
					}
		}
	}
	private function udpdateMenuType($AdvancedTopMenuClass, $id_lang) {
		switch ($AdvancedTopMenuClass->type) {
			case 3 :
				if (Tools::getValue('include_subs')) {
					if ($AdvancedTopMenuClass->id_category) {
						$firstChildCategories = array ();
						$firstChildCategories = $this->getSubCategoriesId($AdvancedTopMenuClass->id_category);
						$lastChildCategories = array ();
						$columnWithNoDepth = false;
						$columnWrapWithNoDepth = false;
						if (sizeof($firstChildCategories)) {
							foreach ( $firstChildCategories as $firstChildCategorie ) {
								$lastChildCategories = $this->getSubCategoriesId($firstChildCategorie ['id_category']);
								if (sizeof($lastChildCategories)) {
									$id_column = false;
									if (Tools::getValue('id_menu', false)) {
										$id_column = AdvancedTopMenuColumnClass::getIdColumnCategoryDepend($AdvancedTopMenuClass->id, $firstChildCategorie ['id_category']);
										if (! $id_column && ! Tools::getValue('rebuild'))
											continue;
									}
									$AdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass($id_column);
									if (! $id_column) {
										$AdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass();
										$AdvancedTopMenuColumnWrapClass->active = 1;

										$AdvancedTopMenuColumnWrapClass->id_menu = $AdvancedTopMenuClass->id;
										$AdvancedTopMenuColumnWrapClass->id_menu_depend = $AdvancedTopMenuClass->id;
										$AdvancedTopMenuColumnWrapClass->save();
										$AdvancedTopMenuColumnWrapClass->internal_name = $this->l('column') . '-' . $AdvancedTopMenuColumnWrapClass->id_menu . '-' . $AdvancedTopMenuColumnWrapClass->id;

										if (! $AdvancedTopMenuColumnWrapClass->save()) {
											$this->errors [] = Tools::displayError('An error occured during save column');
										}
										$AdvancedTopMenuColumnClass->id_wrap = $AdvancedTopMenuColumnWrapClass->id;
									}
									$AdvancedTopMenuColumnClass->active = ($id_column ? $AdvancedTopMenuColumnClass->active : 1);
									$AdvancedTopMenuColumnClass->id_menu = $AdvancedTopMenuClass->id;
									$AdvancedTopMenuColumnClass->id_menu_depend = $AdvancedTopMenuClass->id;
									$AdvancedTopMenuColumnClass->type = $AdvancedTopMenuClass->type;
									$AdvancedTopMenuColumnClass->id_category = $firstChildCategorie ['id_category'];
									if ($AdvancedTopMenuColumnClass->save()) {
										foreach ( $lastChildCategories as $lastChildCategory ) {
											$id_element = false;
											if (Tools::getValue('id_menu', false)) {
												$id_element = AdvancedTopMenuElementsClass::getIdElementCategoryDepend($id_column, $lastChildCategory ['id_category']);
												if (! $id_element && ! Tools::getValue('rebuild'))
													continue;
											}

											$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
											$AdvancedTopMenuElementsClass->active = ($id_element ? $AdvancedTopMenuElementsClass->active : 1);
											$AdvancedTopMenuElementsClass->type = $AdvancedTopMenuClass->type;
											$AdvancedTopMenuElementsClass->id_category = $lastChildCategory ['id_category'];
											$AdvancedTopMenuElementsClass->id_column = $AdvancedTopMenuColumnClass->id;
											$AdvancedTopMenuElementsClass->id_column_depend = $AdvancedTopMenuColumnClass->id;
											if (! $AdvancedTopMenuElementsClass->save()) {
												$this->errors [] = Tools::displayError('An error occured during save children category');
											}
										}
									}
									else {
										$this->errors [] = Tools::displayError('An error occured during save children category');
									}
								}
								else {
									$id_column = false;
									if (Tools::getValue('id_menu', false)) {
										$id_column = AdvancedTopMenuColumnClass::getIdColumnCategoryDependEmptyColumn($AdvancedTopMenuClass->id, $firstChildCategorie ['id_category']);
										if (! $id_column && ! Tools::getValue('rebuild'))
											continue;
										if ($id_column)
											$columnWithNoDepth = $id_column;
									}
									$AdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass($columnWithNoDepth);
									if (! $columnWithNoDepth) {
										$AdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass($columnWrapWithNoDepth);
										$AdvancedTopMenuColumnWrapClass->active = 1;

										$AdvancedTopMenuColumnWrapClass->id_menu = $AdvancedTopMenuClass->id;
										$AdvancedTopMenuColumnWrapClass->id_menu_depend = $AdvancedTopMenuClass->id;
										$AdvancedTopMenuColumnWrapClass->save();
										$AdvancedTopMenuColumnWrapClass->internal_name = $this->l('column') . $AdvancedTopMenuColumnWrapClass->id_menu . '-' . $AdvancedTopMenuColumnWrapClass->id;
										$AdvancedTopMenuColumnWrapClass->save();
										$AdvancedTopMenuColumnClass->id_wrap = $AdvancedTopMenuColumnWrapClass->id;
									}
									$AdvancedTopMenuColumnClass->active = 1;
									$AdvancedTopMenuColumnClass->id_menu = $AdvancedTopMenuClass->id;
									$AdvancedTopMenuColumnClass->id_menu_depend = $AdvancedTopMenuClass->id;
									$AdvancedTopMenuColumnClass->type = $AdvancedTopMenuClass->type;
									$AdvancedTopMenuColumnClass->id_category = $firstChildCategorie ['id_category'];
									//$AdvancedTopMenuColumnClass->type = 2;
									if ($AdvancedTopMenuColumnClass->save()) {
										if (! $columnWrapWithNoDepth)
											$columnWrapWithNoDepth = $AdvancedTopMenuColumnClass->id_wrap;
									}
									else {
										$this->errors [] = Tools::displayError('An error occured during save children category');
									}
								}
							}
						}
					}
				}
				break;
			case 4 :
				if (Tools::getValue('include_subs_manu')) {
					$manufacturersId = $this->getManufacturersId();
					$columnWithNoDepth = false;
					if (sizeof($manufacturersId)) {
						foreach ( $manufacturersId as $manufacturerId ) {
							$id_column = false;
							if (Tools::getValue('id_menu', false)) {
								$id_column = AdvancedTopMenuColumnClass::getIdColumnManufacturerDependEmptyColumn($AdvancedTopMenuClass->id, $manufacturerId ['id_manufacturer']);
								if (! $id_column && ! Tools::getValue('rebuild'))
									continue;
								if ($id_column)
									$columnWithNoDepth = $id_column;
							}
							$AdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass($columnWithNoDepth);
							if (! $columnWithNoDepth) {
								$AdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass($columnWithNoDepth);
								$AdvancedTopMenuColumnWrapClass->active = 1;

								$AdvancedTopMenuColumnWrapClass->id_menu = $AdvancedTopMenuClass->id;
								$AdvancedTopMenuColumnWrapClass->id_menu_depend = $AdvancedTopMenuClass->id;
								$AdvancedTopMenuColumnWrapClass->save();
								$AdvancedTopMenuColumnWrapClass->internal_name = $this->l('column') . $AdvancedTopMenuColumnWrapClass->id_menu . '-' . $AdvancedTopMenuColumnWrapClass->id;
								$AdvancedTopMenuColumnWrapClass->save();
								$AdvancedTopMenuColumnClass->id_wrap = $AdvancedTopMenuColumnWrapClass->id;
							}
							$AdvancedTopMenuColumnClass->active = 1;
							$AdvancedTopMenuColumnClass->id_menu = $AdvancedTopMenuClass->id;
							$AdvancedTopMenuColumnClass->id_menu_depend = $AdvancedTopMenuClass->id;
							$AdvancedTopMenuColumnClass->type = 2;
							if ($AdvancedTopMenuColumnClass->save()) {
								if (! $columnWithNoDepth)
									$columnWithNoDepth = $AdvancedTopMenuColumnClass->id;
								$id_element = false;
								if (Tools::getValue('id_menu', false)) {
									$id_element = AdvancedTopMenuElementsClass::getIdElementManufacturerDepend($columnWithNoDepth, $manufacturerId ['id_manufacturer']);
									if (! $id_element && ! Tools::getValue('rebuild'))
										continue;
								}
								$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
								$AdvancedTopMenuElementsClass->active = 1;
								$AdvancedTopMenuElementsClass->type = $AdvancedTopMenuClass->type;
								$AdvancedTopMenuElementsClass->id_manufacturer = $manufacturerId ['id_manufacturer'];
								$AdvancedTopMenuElementsClass->id_column = $AdvancedTopMenuColumnClass->id;
								$AdvancedTopMenuElementsClass->id_column_depend = $AdvancedTopMenuColumnClass->id;
								if (! $AdvancedTopMenuElementsClass->save()) {
									$this->errors [] = Tools::displayError('An error occured during save manufacturer');
								}
							}
							else {
								$this->errors [] = Tools::displayError('An error occured during save manufacturer');
							}
						}
					}
				}
				break;
			case 5 :
				if (Tools::getValue('include_subs_suppl')) {
					$suppliersId = $this->getSuppliersId();
					$columnWithNoDepth = false;
					if (sizeof($suppliersId)) {
						foreach ( $suppliersId as $supplierId ) {
							$id_column = false;
							if (Tools::getValue('id_menu', false)) {
								$id_column = AdvancedTopMenuColumnClass::getIdColumnSupplierDependEmptyColumn($AdvancedTopMenuClass->id, $supplierId ['id_supplier']);
								if (! $id_column && ! Tools::getValue('rebuild'))
									continue;
								if ($id_column)
									$columnWithNoDepth = $id_column;
							}
							$AdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass($columnWithNoDepth);
							if (! $columnWithNoDepth) {
								$AdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass($columnWithNoDepth);
								$AdvancedTopMenuColumnWrapClass->active = 1;

								$AdvancedTopMenuColumnWrapClass->id_menu = $AdvancedTopMenuClass->id;
								$AdvancedTopMenuColumnWrapClass->id_menu_depend = $AdvancedTopMenuClass->id;
								$AdvancedTopMenuColumnWrapClass->save();
								$AdvancedTopMenuColumnWrapClass->internal_name = $this->l('column') . $AdvancedTopMenuColumnWrapClass->id_menu . '-' . $AdvancedTopMenuColumnWrapClass->id;
								$AdvancedTopMenuColumnWrapClass->save();
								$AdvancedTopMenuColumnClass->id_wrap = $AdvancedTopMenuColumnWrapClass->id;
							}
							$AdvancedTopMenuColumnClass->active = 1;
							$AdvancedTopMenuColumnClass->id_menu = $AdvancedTopMenuClass->id;
							$AdvancedTopMenuColumnClass->id_menu_depend = $AdvancedTopMenuClass->id;
							$AdvancedTopMenuColumnClass->type = 2;
							if ($AdvancedTopMenuColumnClass->save()) {
								if (! $columnWithNoDepth)
									$columnWithNoDepth = $AdvancedTopMenuColumnClass->id;
								$id_element = false;
								if (Tools::getValue('id_menu', false)) {
									$id_element = AdvancedTopMenuElementsClass::getIdElementSupplierDepend($columnWithNoDepth, $supplierId ['id_supplier']);
									if (! $id_element && ! Tools::getValue('rebuild'))
										continue;
								}
								$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
								$AdvancedTopMenuElementsClass->active = 1;
								$AdvancedTopMenuElementsClass->type = $AdvancedTopMenuClass->type;
								$AdvancedTopMenuElementsClass->id_supplier = $supplierId ['id_supplier'];
								$AdvancedTopMenuElementsClass->id_column = $AdvancedTopMenuColumnClass->id;
								$AdvancedTopMenuElementsClass->id_column_depend = $AdvancedTopMenuColumnClass->id;
								if (! $AdvancedTopMenuElementsClass->save()) {
									$this->errors [] = Tools::displayError('An error occured during save supplier');
								}
							}
							else {
								$this->errors [] = Tools::displayError('An error occured during save supplier');
							}
						}
					}
				}
				break;
		}
	}

	private function udpdateColumnType($AdvancedTopMenuColumnClass, $id_lang) {
		switch ($AdvancedTopMenuColumnClass->type) {
			case 3 :
				if (Tools::getValue('include_subs')) {
					if ($AdvancedTopMenuColumnClass->id_category) {
						$childCategories = array ();
						$childCategories = $this->getSubCategoriesId($AdvancedTopMenuColumnClass->id_category);
						if (sizeof($childCategories)) {
							foreach ( $childCategories as $childCategory ) {
								$id_element = false;
								if (Tools::getValue('id_column', false)) {
									$id_element = AdvancedTopMenuElementsClass::getIdElementCategoryDepend(Tools::getValue('id_column'), $childCategory ['id_category']);
									if (! $id_element && ! Tools::getValue('rebuild'))
										continue;
								}
								$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
								$AdvancedTopMenuElementsClass->active = 1;
								$AdvancedTopMenuElementsClass->type = $AdvancedTopMenuColumnClass->type;
								$AdvancedTopMenuElementsClass->id_category = $childCategory ['id_category'];
								$AdvancedTopMenuElementsClass->id_column = $AdvancedTopMenuColumnClass->id;
								$AdvancedTopMenuElementsClass->id_column_depend = $AdvancedTopMenuColumnClass->id;
								if (! $AdvancedTopMenuElementsClass->save()) {
									$this->errors [] = Tools::displayError('An error occured during save children category');
								}
							}
						}
					}
				}
				break;
			case 4 :
				if (Tools::getValue('include_subs_manu')) {
					$manufacturersId = $this->getManufacturersId();
					if (sizeof($manufacturersId)) {
						foreach ( $manufacturersId as $manufacturerId ) {
							$id_element = false;
							if (Tools::getValue('id_column', false)) {
								$id_element = AdvancedTopMenuElementsClass::getIdElementManufacturerDepend(Tools::getValue('id_column'), $manufacturerId ['id_manufacturer']);
								if (! $id_element && ! Tools::getValue('rebuild'))
									continue;
							}
							$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
							$AdvancedTopMenuElementsClass->active = 1;
							$AdvancedTopMenuElementsClass->type = $AdvancedTopMenuColumnClass->type;
							$AdvancedTopMenuElementsClass->id_manufacturer = $manufacturerId ['id_manufacturer'];
							$AdvancedTopMenuElementsClass->id_column = $AdvancedTopMenuColumnClass->id;
							$AdvancedTopMenuElementsClass->id_column_depend = $AdvancedTopMenuColumnClass->id;
							if (! $AdvancedTopMenuElementsClass->save()) {
								$this->errors [] = Tools::displayError('An error occured during save manufacturer');
							}
						}
					}
				}
				break;
			case 5 :
				if (Tools::getValue('include_subs_suppl')) {
					$suppliersId = $this->getSuppliersId();
					if (sizeof($suppliersId)) {
						foreach ( $suppliersId as $supplierId ) {
							$id_element = false;
							if (Tools::getValue('id_column', false)) {
								$id_element = AdvancedTopMenuElementsClass::getIdElementSupplierDepend(Tools::getValue('id_column'), $supplierId ['id_supplier']);
								if (! $id_element && ! Tools::getValue('rebuild'))
									continue;
							}
							$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
							$AdvancedTopMenuElementsClass->active = 1;
							$AdvancedTopMenuElementsClass->type = $AdvancedTopMenuColumnClass->type;
							$AdvancedTopMenuElementsClass->id_supplier = $supplierId ['id_supplier'];
							$AdvancedTopMenuElementsClass->id_column = $AdvancedTopMenuColumnClass->id;
							$AdvancedTopMenuElementsClass->id_column_depend = $AdvancedTopMenuColumnClass->id;
							if (! $AdvancedTopMenuElementsClass->save()) {
								$this->errors [] = Tools::displayError('An error occured during save supplier');
							}
						}
					}
				}
				break;
		}
	}

	public function getManufacturersId() {
		return Db::getInstance()->ExecuteS('
    SELECT m.`id_manufacturer`
    FROM `' . _DB_PREFIX_ . 'manufacturer` m
    ORDER BY m.`id_manufacturer` ASC');
	}
	public function getSuppliersId() {

		return Db::getInstance()->ExecuteS('
    SELECT s.`id_supplier`
    FROM `' . _DB_PREFIX_ . 'supplier` s
    ORDER BY s.`id_supplier` ASC');
	}
	public function getSubCategoriesId($id_category, $active = true) {
		if (! Validate::isBool($active))
			die(Tools::displayError());

		$result = Db::getInstance()->ExecuteS('
    SELECT c.id_category
    FROM `' . _DB_PREFIX_ . 'category` c
    WHERE `id_parent` = ' . intval($id_category) . '
    ' . ($active ? 'AND `active` = 1' : '') . '
    GROUP BY c.`id_category`
    ORDER BY c.`id_category` ASC');
		return $result;
	}
	private function getFileExtension($filename) {
		$split = explode('.', $filename);
		$extension = end($split);
		return $extension;
	}

	private function _postProcessMenu() {
		global $cookie;
		$id_menu = Tools::getValue('id_menu', false);
		$AdvancedTopMenuClass = new AdvancedTopMenuClass($id_menu);
		$this->errors = $AdvancedTopMenuClass->validateControler();
		if (! sizeof($this->errors)) {

			$_POST ['border_size_tab'] = $this->getBorderSizeFromArray(Tools::getValue('border_size_tab'));
			$_POST ['border_size_submenu'] = $this->getBorderSizeFromArray(Tools::getValue('border_size_submenu'));
			$_POST ['fnd_color_menu_tab'] = $_POST ['fnd_color_menu_tab'] [0] . (Tools::getValue('fnd_color_menu_tab_gradient') && isset($_POST ['fnd_color_menu_tab'] [1]) && $_POST ['fnd_color_menu_tab'] [1] ? $this->gradient_separator . $_POST ['fnd_color_menu_tab'] [1] : '');
			$_POST ['fnd_color_menu_tab_over'] = $_POST ['fnd_color_menu_tab_over'] [0] . (Tools::getValue('fnd_color_menu_tab_over_gradient') && isset($_POST ['fnd_color_menu_tab_over'] [1]) && $_POST ['fnd_color_menu_tab_over'] [1] ? $this->gradient_separator . $_POST ['fnd_color_menu_tab_over'] [1] : '');
			$_POST ['fnd_color_submenu'] = $_POST ['fnd_color_submenu'] [0] . (Tools::getValue('fnd_color_submenu_gradient') && isset($_POST ['fnd_color_submenu'] [1]) && $_POST ['fnd_color_submenu'] [1] ? $this->gradient_separator . $_POST ['fnd_color_submenu'] [1] : '');
			$this->copyFromPost($AdvancedTopMenuClass);
			if (($AdvancedTopMenuClass->type == 4 && Tools::getValue('include_subs_manu')) || ($AdvancedTopMenuClass->type == 5 && Tools::getValue('include_subs_suppl'))) {
				$AdvancedTopMenuClass->id_manufacturer = 0;
				$AdvancedTopMenuClass->id_supplier = 0;
			}
			if (! $id_menu) {
				if (! $AdvancedTopMenuClass->add())
					$this->errors [] = $this->l('Error during add menu');
			}
			elseif (! $AdvancedTopMenuClass->update())
				$this->errors [] = $this->l('Error during update menu');
			if (! sizeof($this->errors)) {
				$this->udpdateMenuType($AdvancedTopMenuClass, $cookie->id_lang);
				if (! sizeof($this->errors)) {
					if (isset($_FILES ['icon'] ['tmp_name']) and $_FILES ['icon'] ['tmp_name'] != NULL) {
						$ext = $this->getFileExtension($_FILES ['icon'] ['name']);
						if (! in_array($ext, $this->allowFileExtension) || ! getimagesize($_FILES ['icon'] ['tmp_name']) || ! move_uploaded_file($_FILES ['icon'] ['tmp_name'], _PS_ROOT_DIR_ . '/modules/' . $this->name . '/menu_icons/' . $AdvancedTopMenuClass->id . '.' . $ext))
							$this->errors [] = Tools::displayError('An error occured during the image upload');
						else {
							if ($AdvancedTopMenuClass->have_icon) {
								unlink(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/menu_icons/' . $AdvancedTopMenuClass->id . '.' . ($AdvancedTopMenuClass->image_type ? $AdvancedTopMenuClass->image_type : 'jpg'));
							}
							$AdvancedTopMenuClass->image_type = $ext;
							$AdvancedTopMenuClass->have_icon = 1;
							$AdvancedTopMenuClass->update();
						}
					}
					else if (Tools::getValue('unlink_icon')) {
						unlink(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/menu_icons/' . $AdvancedTopMenuClass->id . '.' . ($AdvancedTopMenuClass->image_type ? $AdvancedTopMenuClass->image_type : 'jpg'));
						$AdvancedTopMenuClass->have_icon = 0;
						$AdvancedTopMenuClass->image_type = '';
						$AdvancedTopMenuClass->update();
					}
					$this->generateCss();
					$this->_html .= $this->displayConfirmation($this->l('Menu has been updated successfully'));
				}
			}
			unset($_POST ['active']);
		}
	}
	private function _postProcessColumnWrap() {
		global $cookie;
		$id_wrap = Tools::getValue('id_wrap', false);
		$AdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass($id_wrap);

		$this->errors = $AdvancedTopMenuColumnWrapClass->validateControler();
		if (! sizeof($this->errors)) {
			$_POST ['bg_color'] = $_POST ['bg_color'] [0] . (Tools::getValue('bg_color_gradient') && isset($_POST ['bg_color'] [1]) && $_POST ['bg_color'] [1] ? $this->gradient_separator . $_POST ['bg_color'] [1] : '');
			$this->copyFromPost($AdvancedTopMenuColumnWrapClass);

			unset($_POST ['active']);
			if (! $id_wrap) {
				if (! $AdvancedTopMenuColumnWrapClass->add())
					$this->errors [] = $this->l('Error during add column');
			}
			elseif (! $AdvancedTopMenuColumnWrapClass->update())
				$this->errors [] = $this->l('Error during update column');
			if (! sizeof($this->errors)) {
				$this->generateCss();
				$this->_html .= $this->displayConfirmation($this->l('Column has been updated successfully'));
			}
		}
	}
	private function _postProcessColumn() {
		global $cookie;
		$id_column = Tools::getValue('id_column', false);
		$AdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass($id_column);
		$this->errors = $AdvancedTopMenuColumnClass->validateControler();
		//$this->_html .= $this->displayError($this->l('Bad URL'));
		if (! sizeof($this->errors)) {
			$this->copyFromPost($AdvancedTopMenuColumnClass);

			unset($_POST ['active']);
			if (! $id_column) {
				if (! $AdvancedTopMenuColumnClass->add())
					$this->errors [] = $this->l('Error during add submenu');
			}
			elseif (! $AdvancedTopMenuColumnClass->update())
				$this->errors [] = $this->l('Error during update submenu');
			if (! sizeof($this->errors)) {
				$this->udpdateColumnType($AdvancedTopMenuColumnClass, $cookie->id_lang);
				if (isset($_FILES ['icon'] ['tmp_name']) and $_FILES ['icon'] ['tmp_name'] != NULL) {
					$ext = $this->getFileExtension($_FILES ['icon'] ['name']);
					if (! in_array($ext, $this->allowFileExtension) || ! getimagesize($_FILES ['icon'] ['tmp_name']) || ! move_uploaded_file($_FILES ['icon'] ['tmp_name'], _PS_ROOT_DIR_ . '/modules/' . $this->name . '/column_icons/' . $AdvancedTopMenuColumnClass->id . '.' . $ext))
						$this->errors [] = Tools::displayError('An error occured during the image upload');
					else {
						if ($AdvancedTopMenuColumnClass->have_icon) {
							unlink(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/column_icons/' . $AdvancedTopMenuColumnClass->id . '.' . ($AdvancedTopMenuColumnClass->image_type ? $AdvancedTopMenuColumnClass->image_type : 'jpg'));
						}
						$AdvancedTopMenuColumnClass->image_type = $ext;
						$AdvancedTopMenuColumnClass->have_icon = 1;
						$AdvancedTopMenuColumnClass->update();
					}
				}
				else if (Tools::getValue('unlink_icon')) {
					unlink(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/column_icons/' . $AdvancedTopMenuColumnClass->id . '.' . ($AdvancedTopMenuColumnClass->image_type ? $AdvancedTopMenuColumnClass->image_type : 'jpg'));
					$AdvancedTopMenuColumnClass->have_icon = 0;
					$AdvancedTopMenuColumnClass->image_type = '';
					$AdvancedTopMenuColumnClass->update();
				}
				$this->_html .= $this->displayConfirmation($this->l('Submenu has been updated successfully'));
			}
		}
	}
	private function _postProcessColumnElement() {
		$id_element = Tools::getValue('id_element', false);
		$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass($id_element);
		$this->errors = $AdvancedTopMenuElementsClass->validateControler();
		//$this->_html .= $this->displayError($this->l('Bad URL'));
		if (! sizeof($this->errors)) {
			$this->copyFromPost($AdvancedTopMenuElementsClass);
			if (! $id_element) {
				if (! $AdvancedTopMenuElementsClass->add())
					$this->errors [] = $this->l('Error during add element');
			}
			elseif (! $AdvancedTopMenuElementsClass->update())
				$this->errors [] = $this->l('Error during update element');
			if (! sizeof($this->errors)) {
				if (isset($_FILES ['icon'] ['tmp_name']) and $_FILES ['icon'] ['tmp_name'] != NULL) {
					$ext = $this->getFileExtension($_FILES ['icon'] ['name']);
					if (! in_array($ext, $this->allowFileExtension) || ! getimagesize($_FILES ['icon'] ['tmp_name']) || ! move_uploaded_file($_FILES ['icon'] ['tmp_name'], _PS_ROOT_DIR_ . '/modules/' . $this->name . '/element_icons/' . $AdvancedTopMenuElementsClass->id . '.' . $ext))
						$this->errors [] = Tools::displayError('An error occured during the image upload');
					else {
						if ($AdvancedTopMenuElementsClass->have_icon) {
							unlink(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/element_icons/' . $AdvancedTopMenuElementsClass->id . '.' . ($AdvancedTopMenuElementsClass->image_type ? $AdvancedTopMenuElementsClass->image_type : 'jpg'));
						}
						$AdvancedTopMenuElementsClass->image_type = $ext;
						$AdvancedTopMenuElementsClass->have_icon = 1;
						$AdvancedTopMenuElementsClass->update();
					}
				}
				else if (Tools::getValue('unlink_icon')) {
					unlink(_PS_ROOT_DIR_ . '/modules/' . $this->name . '/element_icons/' . $AdvancedTopMenuElementsClass->id . '.' . ($AdvancedTopMenuElementsClass->image_type ? $AdvancedTopMenuElementsClass->image_type : 'jpg'));
					$AdvancedTopMenuElementsClass->have_icon = 0;
					$AdvancedTopMenuElementsClass->image_type = '';
					$AdvancedTopMenuElementsClass->update();
				}
				$this->_html .= $this->displayConfirmation($this->l('Element has been updated successfully'));
			}
		}
	}
	private function _postProcess() {
		global $cookie;
		$this->saveConfig();
		$this->saveAdvancedConfig();
		if (isset($_GET ['displayPreview'])) {
			$this->_html = '';
			$this->displayPreview();
			ob_clean();
			echo $this->_html;
			die();
		}
		elseif (Tools::getValue('activeMaintenance')) {
			echo $this->_postProcessMaintenance($this->_module_prefix);
			die();
		}
		elseif (isset($_GET ['columnElementsPosition'])) {
			$order = $_GET ['columnElementsPosition'] ? explode(',', $_GET ['columnElementsPosition']) : array ();
			foreach ( $order as $position => $id_element ) {
				$row = array ('position' => intval($position) );
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedtopmenu_elements', $row, 'UPDATE', 'id_element =' . intval($id_element));
			}
			$this->clearCache();
			ob_clean();
			echo $this->l('Save');
			die();
		}
		elseif (isset($_GET ['menuPosition'])) {
			$order = $_GET ['menuPosition'] ? explode(',', $_GET ['menuPosition']) : array ();

			foreach ( $order as $position => $id_menu ) {
				if (! trim($id_menu))
					continue;
				$row = array ('position' => intval($position) );
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedtopmenu', $row, 'UPDATE', 'id_menu =' . intval($id_menu));
			}
			$this->clearCache();
			ob_clean();
			echo $this->l('Save');
			die();
		}
		elseif (isset($_GET ['columnPosition'])) {
			$order = $_GET ['columnPosition'] ? explode(',', $_GET ['columnPosition']) : array ();

			foreach ( $order as $position => $id_column ) {
				if (! trim($id_column))
					continue;
				$row = array ('position' => intval($position) );
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedtopmenu_columns', $row, 'UPDATE', 'id_column =' . intval($id_column));
			}
			$this->clearCache();
			ob_clean();
			echo $this->l('Save');
			die();
		}
		elseif (isset($_GET ['columnWrapPosition'])) {
			$order = $_GET ['columnWrapPosition'] ? explode(',', $_GET ['columnWrapPosition']) : array ();

			foreach ( $order as $position => $id_wrap ) {
				if (! trim($id_wrap))
					continue;
				$row = array ('position' => intval($position) );
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedtopmenu_columns_wrap', $row, 'UPDATE', 'id_wrap =' . intval($id_wrap));
			}
			$this->clearCache();
			ob_clean();
			echo $this->l('Save');
			die();
		}
		elseif (Tools::getValue('activeMenu') && Tools::getValue('id_menu')) {
			$return = '';
			$ObjAdvancedTopMenuClass = new AdvancedTopMenuClass(Tools::getValue('id_menu'));
			$ObjAdvancedTopMenuClass->active = ($ObjAdvancedTopMenuClass->active ? 0 : 1);
			if ($ObjAdvancedTopMenuClass->save()) {
				$return .= '$("#imgActiveMenu' . $ObjAdvancedTopMenuClass->id . '").attr("src","../img/admin/' . ($ObjAdvancedTopMenuClass->active ? 'enabled' : 'disabled') . '.gif");';
				$return .= 'show_info("activemenu","' . $this->l('Save') . '");';
			}
			else {
				$return .= 'show_info("activemenu","' . $this->l('Error during update menu') . '");';
			}
			$this->clearCache();
			ob_clean();
			echo $return;
			die();
		}
		elseif (Tools::getValue('activeColumnWrap') && Tools::getValue('id_wrap')) {
			$return = '';
			$ObjAdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass(Tools::getValue('id_wrap'));
			$ObjAdvancedTopMenuColumnWrapClass->active = ($ObjAdvancedTopMenuColumnWrapClass->active ? 0 : 1);
			if ($ObjAdvancedTopMenuColumnWrapClass->save()) {
				$return .= '$("#imgActiveColumnWrap' . $ObjAdvancedTopMenuColumnWrapClass->id . '").attr("src","../img/admin/' . ($ObjAdvancedTopMenuColumnWrapClass->active ? 'enabled' : 'disabled') . '.gif");';
				$return .= 'show_info("activecolumnwrap","' . $this->l('Save') . '");';
			}
			else {
				$return .= 'show_info("activecolumnwrap","' . $this->l('Error during update column') . '");';
			}
			$this->clearCache();
			ob_clean();
			echo $return;
			die();
		}
		elseif (Tools::getValue('activeColumn') && Tools::getValue('id_column')) {
			$return = '';
			$ObjAdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass(Tools::getValue('id_column'));
			$ObjAdvancedTopMenuColumnClass->active = ($ObjAdvancedTopMenuColumnClass->active ? 0 : 1);
			if ($ObjAdvancedTopMenuColumnClass->save()) {
				$return .= '$("#imgActiveColumn' . $ObjAdvancedTopMenuColumnClass->id . '").attr("src","../img/admin/' . ($ObjAdvancedTopMenuColumnClass->active ? 'enabled' : 'disabled') . '.gif");';
				$return .= 'show_info("activegroup","' . $this->l('Save') . '");';
			}
			else {
				$return .= 'show_info("activegroup","' . $this->l('Error during update group') . '");';
			}
			$this->clearCache();
			ob_clean();
			echo $return;
			die();
		}
		elseif (Tools::getValue('activeElement') && Tools::getValue('id_element')) {
			$return = '';
			$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass(Tools::getValue('id_element'));
			$AdvancedTopMenuElementsClass->active = ($AdvancedTopMenuElementsClass->active ? 0 : 1);
			if ($AdvancedTopMenuElementsClass->save()) {
				$return .= '$("#imgActiveElement' . $AdvancedTopMenuElementsClass->id . '").attr("src","../img/admin/' . ($AdvancedTopMenuElementsClass->active ? 'enabled' : 'disabled') . '.gif");';
				$return .= 'show_info("activeelement","' . $this->l('Save') . '");';
			}
			else {
				$return .= 'show_info("activeelement","' . $this->l('Error during update element') . '");';
			}
			$this->clearCache();
			ob_clean();
			echo $return;
			die();
		}
		elseif (Tools::getValue('deleteMenu') && Tools::getValue('id_menu')) {
			$ObjAdvancedTopMenuClass = new AdvancedTopMenuClass(Tools::getValue('id_menu'));
			if ($ObjAdvancedTopMenuClass->delete())
				$this->_html .= $this->displayConfirmation($this->l('Menu has been deleted'));
			else
				$this->errors [] = $this->l('Error during delete column');
			$this->clearCache();
		}
		elseif (Tools::getValue('deleteColumnWrap') && Tools::getValue('id_wrap')) {
			$ObjAdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass(Tools::getValue('id_wrap'));
			if ($ObjAdvancedTopMenuColumnWrapClass->delete())
				$this->_html .= $this->displayConfirmation($this->l('Column has been deleted'));
			else
				$this->errors [] = $this->l('Error during delete column');
			$this->clearCache();
		}
		elseif (Tools::getValue('deleteColumn') && Tools::getValue('id_column')) {
			$ObjAdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass(Tools::getValue('id_column'));
			if ($ObjAdvancedTopMenuColumnClass->delete())
				$this->_html .= $this->displayConfirmation($this->l('Group has been deleted'));
			else
				$this->errors [] = $this->l('Error during delete Group');
			$this->clearCache();
		}
		elseif (Tools::getValue('deleteElement') && Tools::getValue('id_element')) {
			$AdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass(Tools::getValue('id_element'));
			if ($AdvancedTopMenuElementsClass->delete())
				$this->_html .= $this->displayConfirmation($this->l('Item has been deleted'));
			else
				$this->errors [] = $this->l('Error during delete item');
			$this->clearCache();
		}
		elseif (Tools::getValue('getMenuForm')) {
			$ObjAdvancedTopMenuClass = false;
			if (Tools::getValue('editMenu') && Tools::getValue('id_menu')) {
				$ObjAdvancedTopMenuClass = new AdvancedTopMenuClass(Tools::getValue('id_menu'));
			}
			$cms = CMS::listCms(intval($cookie->id_lang));
			$categories = Category::getCategories(intval($cookie->id_lang), false);
			$manufacturer = Manufacturer::getManufacturers(false, $cookie->id_lang, true);
			$supplier = Supplier::getSuppliers(false, $cookie->id_lang, true);
			ob_clean();
			$this->displayMenuForm($cms, $categories, $manufacturer, $supplier, $ObjAdvancedTopMenuClass);
			$this->initColorPicker();
			$this->initTinyMce();
			echo $this->_html;
			die();
		}
		elseif (Tools::getValue('getColumnWrapForm')) {
			$ObjAdvancedTopMenuColumnWrapClass = false;
			if (Tools::getValue('editColumnWrap') && Tools::getValue('id_wrap')) {
				$ObjAdvancedTopMenuColumnWrapClass = new AdvancedTopMenuColumnWrapClass(Tools::getValue('id_wrap'));
			}
			$menus = AdvancedTopMenuClass::getMenus($cookie->id_lang, false);
			ob_clean();
			$this->displayColumnWrapForm($menus, $ObjAdvancedTopMenuColumnWrapClass);
			$this->initColorPicker();
			$this->initTinyMce();
			echo $this->_html;
			die();
		}
		elseif (Tools::getValue('getColumnForm')) {
			$ObjAdvancedTopMenuColumnClass = false;
			if (Tools::getValue('editColumn') && Tools::getValue('id_column')) {
				$ObjAdvancedTopMenuColumnClass = new AdvancedTopMenuColumnClass(Tools::getValue('id_column'));
			}
			$cms = CMS::listCms(intval($cookie->id_lang));
			$categories = Category::getCategories(intval($cookie->id_lang), false);
			$manufacturer = Manufacturer::getManufacturers(false, $cookie->id_lang, true);
			$supplier = Supplier::getSuppliers(false, $cookie->id_lang, true);
			$menus = AdvancedTopMenuClass::getMenus($cookie->id_lang, false);
			ob_clean();
			$this->displayColumnForm($menus, $cms, $categories, $manufacturer, $supplier, $ObjAdvancedTopMenuColumnClass);
			$this->initColorPicker();
			$this->initTinyMce();
			echo $this->_html;
			die();
		}
		elseif (Tools::getValue('getElementForm')) {
			$ObjAdvancedTopMenuElementsClass = false;
			if (Tools::getValue('editElement') && Tools::getValue('id_element')) {
				$ObjAdvancedTopMenuElementsClass = new AdvancedTopMenuElementsClass(Tools::getValue('id_element'));
			}
			$cms = CMS::listCms(intval($cookie->id_lang));
			$categories = Category::getCategories(intval($cookie->id_lang), false);
			$manufacturer = Manufacturer::getManufacturers(false, $cookie->id_lang, true);
			$supplier = Supplier::getSuppliers(false, $cookie->id_lang, true);
			$menus = AdvancedTopMenuClass::getMenus($cookie->id_lang, false);
			ob_clean();
			$this->displayElementForm($menus, array (), $cms, $categories, $manufacturer, $supplier, $ObjAdvancedTopMenuElementsClass);
			$this->initColorPicker();
			echo $this->_html;
			die();
		}

		elseif (isset($_POST ['submitMenu'])) {
			$this->_postProcessMenu();
			$this->clearCache();
		}
		elseif (isset($_POST ['submitColumnWrap'])) {
			$this->_postProcessColumnWrap();
			$this->clearCache();
		}
		elseif (isset($_POST ['submitColumn'])) {
			$this->_postProcessColumn();
			$this->clearCache();
		}
		elseif (isset($_POST ['submitElement'])) {
			$this->_postProcessColumnElement();
			$this->clearCache();
		}
		elseif (isset($_POST ['submitFastChangeColumn'])) {
			$id_column = Tools::getValue('id_column');
			$id_wrap = Tools::getValue('id_wrap');
			if ($id_wrap && $id_column) {
				$row = array ('id_wrap' => intval($id_wrap) );
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedtopmenu_columns', $row, 'UPDATE', 'id_column =' . intval($id_column));
			}
			$this->clearCache();
		}

	}
	public function realStripTags4Smarty($str, $allowable_tags = false) {
		return strip_tags($str, $allowable_tags);
	}
	private function getKeepVar($vars = false) {
		if (! intval(Configuration::get('PS_REWRITING_SETTINGS'))) {
			if ($vars)
				parse_str($vars, $vars);
			else
				$vars = $_GET;
			foreach ( $this->keepVarActif as $key ) {
				if (isset($vars [$key])) {
					return '?' . $key . '=' . intval($vars [$key]);
				}
			}
		}
		return '';
	}
	private function getBorderSizeFromArray($borderArray) {
		if (! is_array($borderArray))
			return false;
		$borderStr = '';
		$borderCountEmpty = 0;
		foreach ( $borderArray as $border ) {
			if ($border === '')
				$borderCountEmpty ++;
			$borderStr .= intval($border) . 'px ';
		}
		return ($borderCountEmpty < count($borderArray) ? substr($borderStr, 0, - 1) : 0);
	}
	function generateGlobalCss() {
		$config = array ('ATM_MENU_GLOBAL_HEIGHT', 'ATM_MENU_GLOBAL_WIDTH', 'ATM_MENU_GLOBAL_BGCOLOR', 'ATM_MENU_GLOBAL_PADDING', 'ATM_MENU_GLOBAL_MARGIN', 'ATM_MENU_GLOBAL_BORDERCOLOR', 'ATM_MENU_GLOBAL_BORDERSIZE', 'ATM_MENU_MARGIN', 'ATM_MENU_PADDING', 'ATM_MENU_COLOR', 'ATM_MENU_COLOR_OVER', 'ATM_MENU_BGCOLOR', 'ATM_MENU_BGCOLOR_OVER', 'ATM_MENU_BORDERCOLOR', 'ATM_MENU_BORDERSIZE', 'ATM_SUBMENU_BGCOLOR', 'ATM_SUBMENU_BORDERCOLOR', 'ATM_SUBMENU_BORDERSIZE', 'ATM_COLUMN_TITLE_COLOR', 'ATM_COLUMN_TITLE_COLOR_OVER', 'ATM_COLUMN_ITEM_COLOR', 'ATM_COLUMN_ITEM_COLOR_OVER', 'ATM_SUBMENU_POSITION', 'ATM_SUBMENU_WIDTH', 'ATM_SUBMENU_HEIGHT', 'ATM_COLUMNWRAP_PADDING', 'ATM_COLUMNWRAP_MARGIN', 'ATM_COLUMN_PADDING', 'ATM_COLUMN_MARGIN', 'ATM_COLUMN_ITEM_PADDING', 'ATM_COLUMN_ITEM_MARGIN', 'ATM_MENU_FONT_FAMILY', 'ATM_COLUMN_FONT_FAMILY', 'ATM_COLUMN_ITEM_FONT_FAMILY', 'ATM_MENU_FONT_SIZE', 'ATM_COLUMN_FONT_SIZE', 'ATM_COLUMN_ITEM_FONT_SIZE' );
		$configGlobalCss = Configuration::getMultiple($config);
		$css = array ();
		$configGlobalCss ['ATM_MENU_GLOBAL_BGCOLOR'] = explode($this->gradient_separator, $configGlobalCss ['ATM_MENU_GLOBAL_BGCOLOR']);
		if (isset($configGlobalCss ['ATM_MENU_GLOBAL_BGCOLOR'] [1])) {
			$color1 = htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_BGCOLOR'] [0], ENT_COMPAT, 'UTF-8');
			$color2 = htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_BGCOLOR'] [1], ENT_COMPAT, 'UTF-8');
			$css [] = '#adtm_menu_inner {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\'); background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '));background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ');}';
		}
		else
			$css [] = '#adtm_menu_inner {background-color:' . htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_BGCOLOR'] [0], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '#adtm_menu_inner {padding:' . htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_PADDING'], ENT_COMPAT, 'UTF-8') . ';margin:' . htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_MARGIN'], ENT_COMPAT, 'UTF-8') . ';border-color:' . htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_BORDERCOLOR'], ENT_COMPAT, 'UTF-8') . ';border-width:' . htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_BORDERSIZE'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '#adtm_menu .li-niveau1 a.a-niveau1 {height:' . intval($configGlobalCss ['ATM_MENU_GLOBAL_HEIGHT']) . 'px;line-height:' . (intval($configGlobalCss ['ATM_MENU_GLOBAL_HEIGHT']) - 1) . 'px;}';
		if ($configGlobalCss ['ATM_MENU_GLOBAL_WIDTH'])
			$css [] = '#adtm_menu_inner {width:' . htmlentities($configGlobalCss ['ATM_MENU_GLOBAL_WIDTH'], ENT_COMPAT, 'UTF-8') . 'px;}';
		$css [] = '#adtm_menu .li-niveau1 {line-height:' . (intval($configGlobalCss ['ATM_MENU_GLOBAL_HEIGHT']) - 1) . 'px;}';
		$css [] = '#adtm_menu .li-niveau1 a.a-niveau1 .advtm_menu_span  {height:' . (intval($configGlobalCss ['ATM_MENU_GLOBAL_HEIGHT'])) . 'px;line-height:' . (intval($configGlobalCss ['ATM_MENU_GLOBAL_HEIGHT']) - 1) . 'px;}';
		$css [] = '#adtm_menu ul#menu li div.adtm_sub {top:' . intval($configGlobalCss ['ATM_MENU_GLOBAL_HEIGHT']) . 'px;}';
		$css [] = '.li-niveau1 {padding:' . htmlentities($configGlobalCss ['ATM_MENU_PADDING'], ENT_COMPAT, 'UTF-8') . ';margin:' . htmlentities($configGlobalCss ['ATM_MENU_MARGIN'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '.li-niveau1 .advtm_menu_span, .li-niveau1 a .advtm_menu_span {color:' . htmlentities($configGlobalCss ['ATM_MENU_COLOR'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '.li-niveau1 a:hover .advtm_menu_span, .li-niveau1 a.advtm_menu_actif .advtm_menu_span, .li-niveau1:hover > a.a-niveau1 .advtm_menu_span {color:' . htmlentities($configGlobalCss ['ATM_MENU_COLOR_OVER'], ENT_COMPAT, 'UTF-8') . ';}';

		$configGlobalCss ['ATM_MENU_BGCOLOR'] = explode($this->gradient_separator, $configGlobalCss ['ATM_MENU_BGCOLOR']);
		if (isset($configGlobalCss ['ATM_MENU_BGCOLOR'] [1])) {
			$color1 = htmlentities($configGlobalCss ['ATM_MENU_BGCOLOR'] [0], ENT_COMPAT, 'UTF-8');
			$color2 = htmlentities($configGlobalCss ['ATM_MENU_BGCOLOR'] [1], ENT_COMPAT, 'UTF-8');
			$css [] = '.li-niveau1 a .advtm_menu_span, .li-niveau1 .advtm_menu_span {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\'); background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '));background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ');}';
		}
		else
			$css [] = '.li-niveau1 a .advtm_menu_span, .li-niveau1 .advtm_menu_span {background-color:' . htmlentities($configGlobalCss ['ATM_MENU_BGCOLOR'] [0], ENT_COMPAT, 'UTF-8') . ';}';

		$configGlobalCss ['ATM_MENU_BGCOLOR_OVER'] = explode($this->gradient_separator, $configGlobalCss ['ATM_MENU_BGCOLOR_OVER']);
		if (isset($configGlobalCss ['ATM_MENU_BGCOLOR_OVER'] [1])) {
			$color1 = htmlentities($configGlobalCss ['ATM_MENU_BGCOLOR_OVER'] [0], ENT_COMPAT, 'UTF-8');
			$color2 = htmlentities($configGlobalCss ['ATM_MENU_BGCOLOR_OVER'] [1], ENT_COMPAT, 'UTF-8');
			$css [] = '.li-niveau1 a:hover .advtm_menu_span, .li-niveau1 a.advtm_menu_actif .advtm_menu_span, .li-niveau1 .advtm_menu_span:hover, .li-niveau1:hover > a.a-niveau1 .advtm_menu_span {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\'); background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '));background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ');}';
		}
		else
			$css [] = '.li-niveau1 a:hover .advtm_menu_span, .li-niveau1 a.advtm_menu_actif .advtm_menu_span, .li-niveau1 .advtm_menu_span:hover, .li-niveau1:hover > a.a-niveau1 .advtm_menu_span {background-color:' . htmlentities($configGlobalCss ['ATM_MENU_BGCOLOR_OVER'] [0], ENT_COMPAT, 'UTF-8') . ';}';

		$css [] = '.li-niveau1 a.a-niveau1 {border-color:' . htmlentities($configGlobalCss ['ATM_MENU_BORDERCOLOR'], ENT_COMPAT, 'UTF-8') . ';border-width:' . htmlentities($configGlobalCss ['ATM_MENU_BORDERSIZE'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '.li-niveau1 .adtm_sub {border-color:' . htmlentities($configGlobalCss ['ATM_SUBMENU_BORDERCOLOR'], ENT_COMPAT, 'UTF-8') . ';border-width:' . htmlentities($configGlobalCss ['ATM_SUBMENU_BORDERSIZE'], ENT_COMPAT, 'UTF-8') . ';}';

		$configGlobalCss ['ATM_SUBMENU_BGCOLOR'] = explode($this->gradient_separator, $configGlobalCss ['ATM_SUBMENU_BGCOLOR']);
		if (isset($configGlobalCss ['ATM_SUBMENU_BGCOLOR'] [1])) {
			$color1 = htmlentities($configGlobalCss ['ATM_SUBMENU_BGCOLOR'] [0], ENT_COMPAT, 'UTF-8');
			$color2 = htmlentities($configGlobalCss ['ATM_SUBMENU_BGCOLOR'] [1], ENT_COMPAT, 'UTF-8');
			$css [] = '.li-niveau1 .adtm_sub  {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\'); background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '));background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ');}';
		}
		else
			$css [] = '.li-niveau1 .adtm_sub  {background-color:' . htmlentities($configGlobalCss ['ATM_SUBMENU_BGCOLOR'] [0], ENT_COMPAT, 'UTF-8') . ';}';

		if ($configGlobalCss ['ATM_SUBMENU_WIDTH']) {
			$css [] = '.li-niveau1 .adtm_sub {width:' . htmlentities($configGlobalCss ['ATM_SUBMENU_WIDTH'], ENT_COMPAT, 'UTF-8') . 'px;}';
		}
		if ($configGlobalCss ['ATM_SUBMENU_HEIGHT']) {
			$css [] = '.li-niveau1 .adtm_sub {min-height:' . htmlentities($configGlobalCss ['ATM_SUBMENU_HEIGHT'], ENT_COMPAT, 'UTF-8') . 'px;}';
			$css [] = '* html .li-niveau1 .adtm_sub {height:' . htmlentities($configGlobalCss ['ATM_SUBMENU_HEIGHT'], ENT_COMPAT, 'UTF-8') . 'px;}';
			$css [] = '#adtm_menu div.adtm_column_wrap {min-height:' . htmlentities($configGlobalCss ['ATM_SUBMENU_HEIGHT'], ENT_COMPAT, 'UTF-8') . 'px;}';
			$css [] = '* html #adtm_menu div.adtm_column_wrap {height:' . htmlentities($configGlobalCss ['ATM_SUBMENU_HEIGHT'], ENT_COMPAT, 'UTF-8') . 'px;}';
		}
		$css [] = '.adtm_column_wrap h5, .adtm_column_wrap h5 a {color:' . htmlentities($configGlobalCss ['ATM_COLUMN_TITLE_COLOR'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '.adtm_column_wrap h5:hover, .adtm_column_wrap h5 a:hover {color:' . htmlentities($configGlobalCss ['ATM_COLUMN_TITLE_COLOR_OVER'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '.adtm_column_wrap a {color:' . htmlentities($configGlobalCss ['ATM_COLUMN_ITEM_COLOR'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '.adtm_column_wrap a:hover {color:' . htmlentities($configGlobalCss ['ATM_COLUMN_ITEM_COLOR_OVER'], ENT_COMPAT, 'UTF-8') . ';}';

		$css [] = '#adtm_menu .adtm_column_wrap {padding:' . htmlentities($configGlobalCss ['ATM_COLUMNWRAP_PADDING'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '#adtm_menu .adtm_column {padding:' . htmlentities($configGlobalCss ['ATM_COLUMN_PADDING'], ENT_COMPAT, 'UTF-8') . ';margin:' . htmlentities($configGlobalCss ['ATM_COLUMN_MARGIN'], ENT_COMPAT, 'UTF-8') . ';}';
		$css [] = '#adtm_menu .adtm_column ul.adtm_elements li a {padding:' . htmlentities($configGlobalCss ['ATM_COLUMN_ITEM_PADDING'], ENT_COMPAT, 'UTF-8') . ';margin:' . htmlentities($configGlobalCss ['ATM_COLUMN_ITEM_MARGIN'], ENT_COMPAT, 'UTF-8') . ';}';

		if ($configGlobalCss ['ATM_MENU_FONT_SIZE'])
			$css [] = '#adtm_menu .li-niveau1 a.a-niveau1 .advtm_menu_span {font-size:' . htmlentities($configGlobalCss ['ATM_MENU_FONT_SIZE'], ENT_COMPAT, 'UTF-8') . 'px;}';
		if ($configGlobalCss ['ATM_MENU_FONT_FAMILY'])
			$css [] = '#adtm_menu .li-niveau1 a.a-niveau1 .advtm_menu_span {font-family:' . htmlentities($configGlobalCss ['ATM_MENU_FONT_FAMILY'], ENT_COMPAT, 'UTF-8') . ';}';
		if ($configGlobalCss ['ATM_COLUMN_FONT_SIZE'])
			$css [] = '#adtm_menu .adtm_column h5, #adtm_menu .adtm_column h5 a {font-size:' . htmlentities($configGlobalCss ['ATM_COLUMN_FONT_SIZE'], ENT_COMPAT, 'UTF-8') . 'px;}';
		if ($configGlobalCss ['ATM_COLUMN_FONT_FAMILY'])
			$css [] = '#adtm_menu .adtm_column h5, #adtm_menu .adtm_column h5 a {font-family:' . htmlentities($configGlobalCss ['ATM_COLUMN_FONT_FAMILY'], ENT_COMPAT, 'UTF-8') . ';}';
		if ($configGlobalCss ['ATM_COLUMN_ITEM_FONT_SIZE'])
			$css [] = '#adtm_menu .adtm_column ul.adtm_elements li, #adtm_menu .adtm_column ul.adtm_elements li a {font-size:' . htmlentities($configGlobalCss ['ATM_COLUMN_ITEM_FONT_SIZE'], ENT_COMPAT, 'UTF-8') . 'px;}';
		if ($configGlobalCss ['ATM_COLUMN_ITEM_FONT_FAMILY'])
			$css [] = '#adtm_menu .adtm_column ul.adtm_elements li, #adtm_menu .adtm_column ul.adtm_elements li a {font-family:' . htmlentities($configGlobalCss ['ATM_COLUMN_ITEM_FONT_FAMILY'], ENT_COMPAT, 'UTF-8') . ';}';

		if (intval($configGlobalCss ['ATM_SUBMENU_POSITION']) == 1)
			$css [] = '#adtm_menu ul#menu li.li-niveau1:hover, #adtm_menu ul#menu li.li-niveau1 a.a-niveau1:hover  {position:relative;}';
		if (sizeof($css))
			file_put_contents(dirname(__FILE__) . '/' . self::GLOBAL_CSS_FILE, implode("\n", $css));
	}
	function generateCss() {
		global $cookie;
		$menus = AdvancedTopMenuClass::getMenus($cookie->id_lang);
		$columnsWrap = AdvancedTopMenuColumnWrapClass::getColumnsWrap();
		$css = array ();
		foreach ( $menus as $menu ) {
			if ($menu ['txt_color_menu_tab'])
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ' a .advtm_menu_span_' . $menu ['id_menu'] . ' {color:' . htmlentities($menu ['txt_color_menu_tab'], ENT_COMPAT, 'UTF-8') . '!important;}';
			if ($menu ['txt_color_menu_tab_hover']) {
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' a:hover .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ':hover > a.a-niveau1 .advtm_menu_span_' . $menu ['id_menu'] . ' {color:' . htmlentities($menu ['txt_color_menu_tab_hover'], ENT_COMPAT, 'UTF-8') . '!important;}';
				//ie6
				$css [] = '* html .advtm_menu_' . $menu ['id_menu'] . ' a:hover .advtm_menu_span_' . $menu ['id_menu'] . ', * html .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif .advtm_menu_span_' . $menu ['id_menu'] . ' {color:' . htmlentities($menu ['txt_color_menu_tab_hover'], ENT_COMPAT, 'UTF-8') . '!important;}';
			}
			if ($menu ['fnd_color_menu_tab']) {
				$menu ['fnd_color_menu_tab'] = explode($this->gradient_separator, $menu ['fnd_color_menu_tab']);
				if (isset($menu ['fnd_color_menu_tab'] [1])) {
					$color1 = htmlentities($menu ['fnd_color_menu_tab'] [0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($menu ['fnd_color_menu_tab'] [1], ENT_COMPAT, 'UTF-8');
					$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' a .advtm_menu_span_' . $menu ['id_menu'] . ' {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\')!important; background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '))!important;background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ')!important;}';
				}
				else
					$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' a .advtm_menu_span_' . $menu ['id_menu'] . ' {background-color:' . htmlentities($menu ['fnd_color_menu_tab'] [0], ENT_COMPAT, 'UTF-8') . '!important;filter: none!important; background: ' . htmlentities($menu ['fnd_color_menu_tab'] [0], ENT_COMPAT, 'UTF-8') . '!important;background: ' . htmlentities($menu ['fnd_color_menu_tab'] [0], ENT_COMPAT, 'UTF-8') . '!important;}';
			}
			if ($menu ['fnd_color_menu_tab_over']) {
				$menu ['fnd_color_menu_tab_over'] = explode($this->gradient_separator, $menu ['fnd_color_menu_tab_over']);
				if (isset($menu ['fnd_color_menu_tab_over'] [1])) {
					$color1 = htmlentities($menu ['fnd_color_menu_tab_over'] [0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($menu ['fnd_color_menu_tab_over'] [1], ENT_COMPAT, 'UTF-8');
					$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' a:hover .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ':hover > a.a-niveau1 .advtm_menu_span_' . $menu ['id_menu'] . ' {background-color: ' . $color1 . '!important;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\')!important; background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '))!important;background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ')!important;}';
					$css [] = '* html .advtm_menu_' . $menu ['id_menu'] . ' a:hover .advtm_menu_span_' . $menu ['id_menu'] . ', * html .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif .advtm_menu_span_' . $menu ['id_menu'] . ' {background-color:transparent!important;background:transparent!important;filter:none!important;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\')!important;}';
				}
				else {
					$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' a:hover .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ':hover > a.a-niveau1 .advtm_menu_span_' . $menu ['id_menu'] . ' {background-color:' . htmlentities($menu ['fnd_color_menu_tab_over'] [0], ENT_COMPAT, 'UTF-8') . '!important;filter: none!important; background: ' . htmlentities($menu ['fnd_color_menu_tab_over'] [0], ENT_COMPAT, 'UTF-8') . '!important;background: ' . htmlentities($menu ['fnd_color_menu_tab_over'] [0], ENT_COMPAT, 'UTF-8') . '!important;}';
					//ie6
					$css [] = '* html .advtm_menu_' . $menu ['id_menu'] . ' a:hover .advtm_menu_span_' . $menu ['id_menu'] . ', .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif .advtm_menu_span_' . $menu ['id_menu'] . ' {background-color:' . htmlentities($menu ['fnd_color_menu_tab_over'] [0], ENT_COMPAT, 'UTF-8') . '!important;filter:none!important;}';
					$css [] = '* html .advtm_menu_' . $menu ['id_menu'] . ' a:hover, .advtm_menu_' . $menu ['id_menu'] . ' a.advtm_menu_actif {filter:none!important;}';
				}
			}
			if ($menu ['border_size_tab']) {
				$css [] = 'li.advtm_menu_' . $menu ['id_menu'] . ' a.a-niveau1 {border-width:' . htmlentities($menu ['border_size_tab'], ENT_COMPAT, 'UTF-8') . '!important;}';
			}
			if ($menu ['border_color_tab']) {
				$css [] = 'li.advtm_menu_' . $menu ['id_menu'] . ' a.a-niveau1 {border-color:' . htmlentities($menu ['border_color_tab'], ENT_COMPAT, 'UTF-8') . '!important;}';
			}

			if ($menu ['width_submenu']) {
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {width:' . htmlentities($menu ['width_submenu'], ENT_COMPAT, 'UTF-8') . 'px!important;}';
			}
			elseif ($menu ['width_submenu'] === '0')
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {width:auto!important;}';

			if ($menu ['minheight_submenu']) {
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {min-height:' . htmlentities($menu ['minheight_submenu'], ENT_COMPAT, 'UTF-8') . 'px!important;}';
				$css [] = '* html .advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {height:' . htmlentities($menu ['minheight_submenu'], ENT_COMPAT, 'UTF-8') . 'px!important;}';
				$css [] = '#adtm_menu .advtm_menu_' . $menu ['id_menu'] . ' div.adtm_column_wrap {min-height:' . htmlentities($menu ['minheight_submenu'], ENT_COMPAT, 'UTF-8') . 'px!important;}';
				$css [] = '* html #adtm_menu .advtm_menu_' . $menu ['id_menu'] . ' div.adtm_column_wrap {height:' . htmlentities($menu ['minheight_submenu'], ENT_COMPAT, 'UTF-8') . 'px!important;}';
			}
			elseif ($menu ['minheight_submenu'] === '0') {
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {height:auto!important;min-height:0!important;}';
				$css [] = '#adtm_menu .advtm_menu_' . $menu ['id_menu'] . ' div.adtm_column_wrap {height:auto!important;min-height:0!important;}';
			}

			if ($menu ['position_submenu']) {
				if (intval($menu ['position_submenu']) == 1 || intval($menu ['position_submenu']) == 3)
					$css [] = '#adtm_menu ul#menu li.advtm_menu_' . $menu ['id_menu'] . ':hover, #adtm_menu ul#menu li.advtm_menu_' . $menu ['id_menu'] . ' a.a-niveau1:hover  {position:relative!important;}';
				elseif (intval($menu ['position_submenu']) == 2)
					$css [] = '#adtm_menu ul#menu li.advtm_menu_' . $menu ['id_menu'] . ':hover, #adtm_menu ul#menu li.advtm_menu_' . $menu ['id_menu'] . ' a.a-niveau1:hover  {position:static!important;}';
				if (intval($menu ['position_submenu']) == 3) {
					$css [] = '#adtm_menu ul#menu li.advtm_menu_' . $menu ['id_menu'] . ':hover div.adtm_sub  {left:auto!important;right:0!important;}';
					$css [] = '#adtm_menu ul#menu li.advtm_menu_' . $menu ['id_menu'] . ' a:hover div.adtm_sub  {left:auto!important;right:1px!important;}';
				}

			}
			if ($menu ['fnd_color_submenu']) {
				$menu ['fnd_color_submenu'] = explode($this->gradient_separator, $menu ['fnd_color_submenu']);
				if (isset($menu ['fnd_color_submenu'] [1])) {
					$color1 = htmlentities($menu ['fnd_color_submenu'] [0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($menu ['fnd_color_submenu'] [1], ENT_COMPAT, 'UTF-8');
					$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\')!important; background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '))!important;background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ')!important;}';
				}
				else
					$css [] = '.advtm_menu_' . $menu ['id_menu'] . ' .adtm_sub {background-color:' . htmlentities($menu ['fnd_color_submenu'] [0], ENT_COMPAT, 'UTF-8') . '!important;filter: none!important; background: ' . htmlentities($menu ['fnd_color_submenu'] [0], ENT_COMPAT, 'UTF-8') . '!important;background: ' . htmlentities($menu ['fnd_color_submenu'] [0], ENT_COMPAT, 'UTF-8') . '!important;}';
			}

			if ($menu ['border_color_submenu'])
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . '  div.adtm_sub {border-color:' . htmlentities($menu ['border_color_submenu'], ENT_COMPAT, 'UTF-8') . '!important;}';
			if ($menu ['border_size_submenu']) {
				$css [] = '.advtm_menu_' . $menu ['id_menu'] . '  div.adtm_sub {border-width:' . htmlentities($menu ['border_size_submenu'], ENT_COMPAT, 'UTF-8') . '!important;}';
			}

		}
		foreach ( $columnsWrap as $columnWrap ) {
			if ($columnWrap ['bg_color']) {
				$columnWrap ['bg_color'] = explode($this->gradient_separator, $columnWrap ['bg_color']);
				if (isset($columnWrap ['bg_color'] [1])) {
					$color1 = htmlentities($columnWrap ['bg_color'] [0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($columnWrap ['bg_color'] [1], ENT_COMPAT, 'UTF-8');
					$css [] = '.advtm_column_wrap_td_' . $columnWrap ['id_wrap'] . ' {background-color: ' . $color1 . ';filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $color1 . '\', endColorstr=\'' . $color2 . '\')!important; background: -webkit-gradient(linear, left top, left bottom, from(' . $color1 . '), to(' . $color2 . '))!important;background: -moz-linear-gradient(top,  ' . $color1 . ',  ' . $color2 . ')!important;}';
				}
				else
					$css [] = '.advtm_column_wrap_td_' . $columnWrap ['id_wrap'] . ' {background-color:' . htmlentities($columnWrap ['bg_color'] [0], ENT_COMPAT, 'UTF-8') . '!important;filter: none!important; background: ' . htmlentities($columnWrap ['bg_color'] [0], ENT_COMPAT, 'UTF-8') . '!important;background: ' . htmlentities($columnWrap ['bg_color'] [0], ENT_COMPAT, 'UTF-8') . '!important;}';
			}
			if ($columnWrap ['txt_color_column'])
				$css [] = '.advtm_column_wrap_' . $columnWrap ['id_wrap'] . ' h5, .advtm_column_wrap_' . $columnWrap ['id_wrap'] . ' h5 a  {color:' . htmlentities($columnWrap ['txt_color_column'], ENT_COMPAT, 'UTF-8') . '!important;}';
			if ($columnWrap ['txt_color_column_over'])
				$css [] = '.advtm_column_wrap_' . $columnWrap ['id_wrap'] . ' h5 a:hover  {color:' . htmlentities($columnWrap ['txt_color_column_over'], ENT_COMPAT, 'UTF-8') . '!important;}';
			if ($columnWrap ['txt_color_element'])
				$css [] = '.advtm_column_wrap_' . $columnWrap ['id_wrap'] . ', .advtm_column_wrap_' . $columnWrap ['id_wrap'] . ' a  {color:' . htmlentities($columnWrap ['txt_color_element'], ENT_COMPAT, 'UTF-8') . '!important;}';
			if ($columnWrap ['txt_color_element_over'])
				$css [] = '.advtm_column_wrap_' . $columnWrap ['id_wrap'] . ' a:hover  {color:' . htmlentities($columnWrap ['txt_color_element_over'], ENT_COMPAT, 'UTF-8') . '!important;}';
			if ($columnWrap ['width'])
				$css [] = '.advtm_column_wrap_' . $columnWrap ['id_wrap'] . ' {width:' . htmlentities($columnWrap ['width'], ENT_COMPAT, 'UTF-8') . 'px!important;}';
		}
		if (sizeof($css))
			file_put_contents(dirname(__FILE__) . '/' . self::DYN_CSS_FILE, implode(" ", $css));
		else
			file_put_contents(dirname(__FILE__) . '/' . self::DYN_CSS_FILE, '');
	}
	public function fetchWithCache($file, $template, $cacheid = NULL, $cache_lifetime = 0) {
		global $smarty;
		$previousTemplate = $smarty->currentTemplate;
		$smarty->currentTemplate = substr(basename($template), 0, - 4);
		$smarty->assign('module_dir', __PS_BASE_URI__ . 'modules/' . basename($file, '.php') . '/');
		$smarty->cache_lifetime = $cache_lifetime;
		if (file_exists(_PS_THEME_DIR_ . 'modules/' . basename($file, '.php') . '/' . $template)) {
			$smarty->assign('module_template_dir', _THEME_DIR_ . 'modules/' . basename($file, '.php') . '/');
			$result = $smarty->fetch(_PS_THEME_DIR_ . 'modules/' . basename($file, '.php') . '/' . $template, $cacheid);
		}
		elseif (file_exists(dirname($file) . '/' . $template)) {
			$smarty->assign('module_template_dir', __PS_BASE_URI__ . 'modules/' . basename($file, '.php') . '/');
			$result = $smarty->fetch(dirname($file) . '/' . $template, $cacheid);
		}
		else
			$result = '';
		$smarty->currentTemplate = $previousTemplate;
		return $result;
	}
	public static function enableCachePM($level = 1) {
		global $smarty;

		if ((_PS_VERSION_ < 1.4 && ! Configuration::get('ATM_CACHE')) || (_PS_VERSION_ >= 1.4 && ! Configuration::get('PS_SMARTY_CACHE')))
			return;
		if ($smarty->force_compile == 0 and $smarty->compile_check == 0 and $smarty->caching == $level)
			return;
		self::$_forceCompile = ( int ) ($smarty->force_compile);
		self::$_compileCheck = ( int ) ($smarty->compile_check);
		self::$_caching = ( int ) ($smarty->caching);
		$smarty->force_compile = 0;
		$smarty->compile_check = 0;
		$smarty->caching = ( int ) ($level);
	}

	public static function restoreCacheSettingsPM() {
		global $smarty;

		if (isset(self::$_forceCompile))
			$smarty->force_compile = ( int ) (self::$_forceCompile);
		if (isset(self::$_compileCheck))
			$smarty->compile_check = ( int ) (self::$_compileCheck);
		if (isset(self::$_caching))
			$smarty->caching = ( int ) (self::$_caching);
	}
	public function clearCache() {
		global $smarty;
		if (_PS_VERSION_ < 1.4 || Configuration::get('PS_FORCE_SMARTY_2')) {
			$smarty->clear_compiled_tpl(dirname(__FILE__) . '/pm_advancedtopmenu.tpl');
			return $smarty->clear_cache(null, 'ADTM');
		}
		else {
			$smarty->clearCompiledTemplate(dirname(__FILE__) . '/pm_advancedtopmenu.tpl');
			return $smarty->clearCache(null, 'ADTM');
		}
		return true;
	}
	function hookHeader($params) {
		if($this->_isInMaintenance())
			return;
		global $smarty;
		if (_PS_VERSION_ >= 1.4) {
			/*Tools::addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/css/pm_advancedtopmenu_base.css', 'all');
			Tools::addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/css/pm_advancedtopmenu_global.css', 'all');
			Tools::addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/css/pm_advancedtopmenu_advanced.css', 'all');
			Tools::addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/css/pm_advancedtopmenu.css', 'all');
			Tools::addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/pm_advancedtopmenu.js');*/
		}
		return $this->display(__FILE__, 'pm_advancedtopmenu_header.tpl');
	}
	function hookTop($params) {
		if($this->_isInMaintenance())
			return;
		global $smarty, $cookie;
		$return = '';
		$cache = Configuration::get('ATM_CACHE', true);
		if (_PS_VERSION_ >= 1.4 && ! Configuration::get('PS_SMARTY_CACHE'))
			$cache = false;
		if ($cache) {
			if (Configuration::get('ATM_MENU_GLOBAL_ACTIF')) {
				$curUrl = explode('?', $_SERVER ['REQUEST_URI']);
				$curUrl = $curUrl [0] . $this->getKeepVar();
				$strCacheUrl = preg_replace('#https?://' . preg_quote(htmlspecialchars($_SERVER ['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__,'#') . '#i', '', $curUrl);
			}
			else
				$strCacheUrl = 'global';
			$adtmCacheId = sprintf('ADTM|%s|%d|%s', $strCacheUrl, $cookie->id_lang, $cookie->isLogged());
			self::enableCachePM(2);
		}
		if ((! $cache || (_PS_VERSION_ < 1.4 && ! $smarty->is_cached(dirname(__FILE__) . '/pm_advancedtopmenu.tpl', $adtmCacheId)) || (_PS_VERSION_ >= 1.4 && ! $this->isCached('pm_advancedtopmenu.tpl', $adtmCacheId)))) {
			$menus = AdvancedTopMenuClass::getMenus($cookie->id_lang);
			if (! sizeof($menus)) {
				self::restoreCacheSettingsPM();
				return;
			}

			$columnsWrap = AdvancedTopMenuColumnWrapClass::getMenusColumnsWrap($menus, $cookie->id_lang);
			$columns = AdvancedTopMenuColumnClass::getMenusColums($columnsWrap, $cookie->id_lang);
			$elements = AdvancedTopMenuElementsClass::getMenuColumnsElements($columns, $cookie->id_lang);
			$smarty->assign(array ('advtm_menus' => $menus, 'advtm_columns_wrap' => $columnsWrap, 'advtm_columns' => $columns, 'advtm_elements' => $elements, 'advtm_obj' => $this, 'isLogged' => $cookie->isLogged() ));
		}
		if ($cache) {
			if (_PS_VERSION_ < 1.4)
				$return = $this->fetchWithCache(__FILE__, 'pm_advancedtopmenu.tpl', $adtmCacheId, 3600);
			else {
				$smarty->cache_lifetime = 3600;
				$return = $this->display(__FILE__, 'pm_advancedtopmenu.tpl', $adtmCacheId);
			}
			self::restoreCacheSettingsPM();
			return $return;
		}
		else {
			$return = $this->display(__FILE__, 'pm_advancedtopmenu.tpl');
			$smarty->caching = 0;
			return $return;
		}
	}
	public static function _isFilledArray($array) {
		return ($array && is_array($array) && sizeof($array));
	}
	/*Display copyright*/
	protected function displaySupport() {
		$this->_html .= '<div class="ui-corner-all ui-tabs ui-tabs-panel pm_panel_bottom"><br />';

		$have_copy_and_partner = self::_isFilledArray($this->_copy_and_partner);

		if($have_copy_and_partner)
			$this->_html .= '<div style="width:240px;float:left;">';

		$this->_html .= '<h2>'.$this->l('Information & Support').'</h2>';
		$this->_html .= '<strong>' . $this->l('Module Version: ') . '</strong>' . $this->version . '<br /><br/>';

		if(self::_isFilledArray($this->_support_link)) {
			$this->_html .= '<h2 style="color:#333;font-size:1.1em;">'.$this->l('Useful links').'</h2>';
			foreach($this->_support_link as $infos) {
				$this->_html .= '<a href="'.$infos['link'].'" target="_blank" class="pm_link">'.$infos['label'].'</a><br />';
			}
		}

		if($have_copy_and_partner) {
			$this->_html .= '</div>';
			$this->_html .= '<div id="pm_copy_bloc">';

			foreach($this->_copy_and_partner as $infos) {
				if(isset($infos['link']) AND $infos['link'])
					$this->_html .= '<a href="'.$infos['link'].'"'.((isset($infos['target']) AND $infos['target']) ? ' target="'.$infos['target'].'"':'').''.((isset($infos['style']) AND $infos['style']) ? ' style="'.$infos['style'].'"':'').'>';

				if(isset($infos['img']) AND $infos['img']) {
					$img = str_replace('_PATH_',$this->_path,$infos['img']);
					$this->_html .= '<img src="'.$img.'" />';
				}

				if(isset($infos['link']) AND $infos['link'])
						$this->_html .= '</a>';
			}
			$this->_html .= '</div>';
		}
		$this->_html .= '</div>';

		$this->_displayFormNewsletter();
	}

	protected function _displayFormNewsletter() {
		$firstname = false;
		$lastname = false;
		if (_PS_VERSION_ < 1.4 || !isset($this->_employee))
			global $employee;
		else $employee = $this->_employee;
		$mail = Configuration::get('PS_SHOP_EMAIL');

		//Get firstname from PS 1.4 and >
		if(isset($employee->firstname))
			$firstname = $employee->firstname;

		//Get lastname from PS 1.4 and >
		if(isset($employee->lastname))
			$lastname = $employee->lastname;

		$this->_html .= '<div class="ui-corner-all ui-tabs ui-tabs-panel pm_panel_bottom">';
		$this->_html .= '<form action="" method="post" class="width3">';
				$this->_html .= '<br />';
		$this->_html .= '<h2 style="margin-bottom:0;">' . $this->l('Get our Newsletter ! ') . '</h2>';
		$this->_html .= '<blockquote><p>' . $this->l('Every month, get our actuality about updates, news and pomotional offer.') . '</p></blockquote>';
		$this->_html .= '<label style="width:170px">'.$this->l('Mail:') .'</label><input style="width:190px" type="text" name="newsletter" id="pm_send_newsletter_email" value="' . $mail . '" class="ui-corner-all ui-input-pm" /><br class="clear" />';
		$this->_html .= '<label style="width:170px">'.$this->l('Firstname:') .'</label><input style="width:190px" type="text" name="firstname" id="pm_send_newsletter_firstname" value="' . (isset($firstname) ? $firstname : '') . '" class="ui-corner-all ui-input-pm" /><br class="clear" />';
		$this->_html .= '<label style="width:170px">'.$this->l('Lastname:') .'</label><input style="width:190px" type="text" name="lastname" id="pm_send_newsletter_lastname" value="' .  (isset($lastname) ? $lastname : ''). '" class="ui-corner-all ui-input-pm" /><br class="clear" />';
		$this->_html .= '<input type="hidden" name="version" id="pm_send_newsletter_psversion" value="' . _PS_VERSION_ . '" />';
		$this->_html .= '<input type="hidden" name="domaine" id="pm_send_newsletter_domaine" value="' . $_SERVER['HTTP_HOST'] . '" />';
		$this->_html .= '<input type="hidden" name="module_name" id="pm_send_newsletter_module_name" value="' . $this->name . '" />';

		$this->_html .= '<span id="pm_newsletter_terms">'.$this->l('Please').' <a href="javascript:void(0)" class="pm_link" onclick="openDialogInline(\'#pm_newsletter_trms_dialog\',500,700,0)">'.$this->l('read').'</a> '.$this->l('and accept the terms and conditions').' <input type="checkbox" name="cgu" id="pm_send_newsletter_cgu" value="1" /></span>';

		//$this->_html .= '<a id="pm_send_newsletter" style="width:20px; height:20px; margin-left:5px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" title="'.$this->l('Send').'" href="javascript:void(0);">';
		$this->_addButton($this->l('Subscribe'), 'javascript:void(0)', 'pmSubscribeNewsletter();','ui-icon ui-icon-mail-closed','pm_send_newsletter');
		//$this->_html .= '<span class="ui-icon ui-icon-mail-closed" style="float: left; margin:2px;"></span></a>';
		$this->_html .= '</form>';
		$this->_html .= '</div>';
		$this->_html .= '<script type="text/javascript">
		    var msgPMNewsOK = "'.$this->l('Thanks for your subscribing').'";
		    var msgPMNewsReadCGU = "'.$this->l('Please read and accept the terms and conditions').'";
		    </script>';
		$this->_html .= '<div id="pm_newsletter_trms_dialog" style="display:none;">
		<h2>'.$this->l('Terms and conditions').'</h2>
		<p>'.$this->l('If you wish to subscribe to the newsletter e-mail, you must agree to the processing of data provided for these purposes by clicking on the "send" button. In this case, data will be processed by computer (automatic transmission) to send to the email address specified, information about our software offers and information on our company Presta Module. Communication data consent are absolutely optional and won\'t have any consequences other than the fact of not receiving the newsletter.Even after accepting, you will be able to remove your adress from the list for free at any time simply by clicking the "unsubscribe" link in all our newsletters, or by writing to contact@presta-module.com. The data will not be disclosed to third parties and will be managed only by personnel appointed for the purpose (technicians, operators, marketing staff to customer relations) if necessary.').'</p>
		<p>'.$this->l('The the company in charge of the data processing is Presta Module SARL, whose registered office is 90 rue Stanislas Torrents, 13006 Marseille, France.').'</p>
		<p>'.$this->l('The processing manager is the Director of Information Systems, domiciled for the purpose of these functions at the headquarters of the company said. It is to him that you can apply for in the manner rovided by law, the rights mentioned in the extract of Article 4 of Law No. 78-17 of 6 January 1978, and for a complete list and update any other officials (all communication should be addressed "to the charge of data processing").').'</p>
		</div>';
	}

	protected function _addButton($text = '', $href = '', $onclick = false, $icon_class = false, $class = false, $title = '', $rel = false) {
			$curId = 'button_' . uniqid();
			$this->_html .= '<a href="' . htmlentities($href, ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($title, ENT_COMPAT, 'UTF-8') . '" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' . ($class ? ' ' . htmlentities($class, ENT_COMPAT, 'UTF-8') . '' : '') . '" id="' . $curId . '" ' . ($text ? 'style="padding-right:5px;"' : '') . ' ' . ($rel ? 'rel="' . $rel . '"' : '') . '>
	      ' . ($icon_class ? '<span class="' . htmlentities($icon_class, ENT_COMPAT, 'UTF-8') . '" style="float: left; margin-right: .3em;"></span>' : '') . '
	      ' . $text . '
	      </a>';
			if ($onclick)
				$this->_html .= '<script type="text/javascript">$("#' . $curId . '").unbind("click").bind("click", function() {
	        ' . $onclick . '
	      });</script>';
	}
	protected function _maintenanceButton() {
		$this->_html .= '<a href="' . $this->base_config_url . '&activeMaintenance=1" title="Maintenance" class="ajax_script_load ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" id="buttonMaintenance" style="padding-right:5px;">';
		$this->_html .= '<span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;"></span>';
		$this->_html .= $this->l('Maintenance');
		$this->_html .= '<span id="pmImgMaintenance" class="ui-icon ui-icon-' . (Configuration::get('PM_' . $this->_module_prefix . '_MAINTENANCE') ? 'locked' : 'unlocked') . '" style="float: right; margin-left: .3em;">';
		$this->_html .= '</span>';
		$this->_html .= '</a>';
	}
	/**
	 * Displays a warning if maintenance is enabled
	 * @param char $cache_prefix
	 */
	protected function _maintenanceWarning() {
		global $employee;
		$ip_maintenance = Configuration::get('PS_MAINTENANCE_IP');
		$this->_html .= '<div id="maintenanceWarning" class="warning"
								' . ((Configuration::get('PM_' . $this->_module_prefix . '_MAINTENANCE')) ? '' : 'style="display:none"') . '">
								<center>
								<img src="' . $this->_path . 'img/warning.png" style="padding-right:1em;"/>';
		if (! $ip_maintenance || empty($ip_maintenance)) {
			$this->_html .= '<b>' . $this->l('You must define a maintenance IP in your') . '
					<a href="index.php?tab=AdminPreferences&token=' . Tools::getAdminToken('AdminPreferences' . intval(Tab::getIdFromClassName('AdminPreferences')) . intval($employee->id)) . '" style="text-decoration:underline;">
					' . $this->l('Preferences Panel.') . '
					</a></b><br />';
		}
		$this->_html .= $this->l('Module is currently running in Maintenance Mode.') . '';
		$this->_html .= '</center></div>';
		return $this->_html;
	}
	/**
	 * Toggle button locked/unlocked and save mode to DB
	 * @param char $cache_prefix
	 */
	public function _postProcessMaintenance() {
		$return = '';
		$maintenance = Configuration::get('PM_' . $this->_module_prefix . '_MAINTENANCE');
		$maintenance = ($maintenance ? 0 : 1);
		Configuration::updateValue('PM_' . $this->_module_prefix . '_MAINTENANCE', intval($maintenance));
		if ($maintenance) {
			$return .= '$("#pmImgMaintenance").attr("class", "ui-icon ui-icon-locked");';
			$return .= '$("#maintenanceWarning").slideDown();';
			$return .= 'show_info("' . $this->l('Your module is now in maintenance mode.') . '");';
		} else {
			$return .= '$("#pmImgMaintenance").attr("class", "ui-icon ui-icon-unlocked");';
			$return .= '$("#maintenanceWarning").slideUp();';
			$return .= 'show_info("' . $this->l('Your module is now running in normal mode.') . '");';
		}
		$this->clearCache();
		ob_clean();
		return $return;
	}

	protected function _isInMaintenance() {
		if(isset($this->_cacheIsInMaintenance))
			return $this->_cacheIsInMaintenance;
		if(Configuration::get('PM_'.$this->_module_prefix.'_MAINTENANCE')){
			$ips = explode(',',Configuration::get('PS_MAINTENANCE_IP'));
			if(in_array($_SERVER['REMOTE_ADDR'],$ips)){
				$this->_cacheIsInMaintenance = false;
				return false;
			}
			$this->_cacheIsInMaintenance = true;
			return true;
		}
		$this->_cacheIsInMaintenance = false;
		return false;
	}
}

?>