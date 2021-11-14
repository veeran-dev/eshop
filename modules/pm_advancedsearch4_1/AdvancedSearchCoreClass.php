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
 * +
 * + Multi-layered search engine and search by steps
 * + PS version: 1.4, 1.5, 1.6
 *
 ****/
class AdvancedSearchCoreClass extends Module {
	protected $_html;
	protected $_html_at_end;
	protected $_base_config_url;
	protected $_default_language;
	protected $_fields_options;
	protected $_iso_lang;
	protected $_languages;
	protected $_context;
	protected $_css_files;
	protected $_js_files;
	protected $_smarty;
	protected $_cookie;
	protected $_employee;
	protected $_coreClassName;
	protected $_registerOnHooks;
	public static $_module_prefix = 'as4';
	protected $_debug_mode = false;
	protected $_copyright_link = false;
	protected $_support_link = false;
	protected $_getting_started = false;
	protected $_css_js_lib_loaded = array();
	protected $_initTinyMceAtEnd = false;
	protected $_initColorPickerAtEnd = false;
	protected $_initBindFillSizeAtEnd = false;
	protected static $_gradient_separator = ' ';
	protected static $_border_separator = ' ';
	protected static $_shadow_separator = ' ';
	protected $_temp_upload_dir = '/uploads/temp/';
	protected $styles_flag_lang_init;
	protected static $_new_hook_name = array(
		'home'			=> 'displayHome',
		'leftColumn'	=> 'displayLeftColumn',
		'rightColumn'	=> 'displayRightColumn',
		'top'			=> 'displayTop'
	);
	public function __construct() {
		$this->_coreClassName = strtolower(get_class());
		parent::__construct();
		if ($this->_debug_mode) {
			if (file_exists(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/lib/firephp/fb_AS4.php'))
				include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/lib/firephp/fb_AS4.php');
		}
		$this->_initClassVar();
	}
	public function install(){
		if (parent::install() == false OR $this->_registerHooks() == false)
		  return false;
		return true;
    }
	public function checkIfModuleIsUpdate($updateDb = false, $displayConfirm = true) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $this->registerHook('displayBackOfficeHeader');
		return true;
	}
	protected function _registerHooks() {
		if (!isset($this->_registerOnHooks) || !self::_isFilledArray($this->_registerOnHooks)) return true;
		foreach($this->_registerOnHooks as $hook) {
			if (!$this->registerHook($hook)) return false;
		}
		return true;
	}
	public static function jsonEncode($data) {
		if (function_exists('json_encode'))
			return json_encode($data);
		else {
			include_once(_PS_TOOL_DIR_.'json/json.php');
			$pearJson = new Services_JSON();
			return $pearJson->encode($data);
		}
	}
	public static function Db_ExecuteS($q) {
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($q);
		else return Db::getInstance()->ExecuteS($q);
	}
	public static function Db_Execute($q) {
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) return Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute($q);
		else return Db::getInstance()->Execute($q);
	}
	private function getProductsOnLive($q, $limit, $start) {
		$result = self::Db_ExecuteS('
		SELECT p.`id_product`, CONCAT(p.`id_product`, \' - \', IFNULL(CONCAT(NULLIF(TRIM(p.reference), \'\'), \' - \'), \'\'), pl.`name`) AS name
		FROM `' . _DB_PREFIX_ . 'product` p, `' . _DB_PREFIX_ . 'product_lang` pl'. (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ', `' . _DB_PREFIX_ . 'product_shop` ps ' : '') . '
		WHERE p.`id_product`=pl.`id_product`
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND p.`id_product`=ps.`id_product` ' : '').'
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlRestriction(false, 'ps') : '').'
		AND pl.`id_lang`=' . (int)$this->_default_language . '
		AND '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'ps' : 'p').'.`active` = 1
		AND ((p.`id_product` LIKE \'%' . pSQL($q) . '%\') OR (pl.`name` LIKE \'%' . pSQL($q) . '%\') OR (p.`reference` LIKE \'%' . pSQL($q) . '%\') OR (pl.`description` LIKE \'%' . pSQL($q) . '%\') OR (pl.`description_short` LIKE \'%' . pSQL($q) . '%\'))
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'GROUP BY p.`id_product`' : '').'
		ORDER BY pl.`name` ASC ' . ($limit ? 'LIMIT ' . $start . ', ' . (int) $limit : ''));
		return $result;
	}
	private function getSuppliersOnLive($q, $limit, $start) {
		$result = self::Db_ExecuteS('
        SELECT s.`id_supplier`, s.`name`
        FROM `' . _DB_PREFIX_ . 'supplier` s
        WHERE (s.name LIKE \'%' . pSQL($q) . '%\')
        '.((version_compare(_PS_VERSION_, '1.4.0.0', '>=')) ? 'AND s.`active` = 1' : '').'
        ORDER BY s.`name` ' . ($limit ? 'LIMIT ' . $start . ', ' . ( int ) $limit : ''));
		return $result;
	}
	private function getManufacturersOnLive($q, $limit, $start) {
		$result = self::Db_ExecuteS('
        SELECT m.`id_manufacturer`, m.`name`
        FROM `' . _DB_PREFIX_ . 'manufacturer` m
        WHERE (m.name LIKE \'%' . pSQL($q) . '%\')
		'.((version_compare(_PS_VERSION_, '1.4.0.0', '>=')) ? 'AND m.`active` = 1' : '').'
        ORDER BY m.`name` ' . ($limit ? 'LIMIT ' . $start . ', ' . ( int ) $limit : ''));
		return $result;
	}
	private function getCMSPagesOnLive($q, $limit, $start) {
		$result = self::Db_ExecuteS('
        SELECT c.`id_cms`, cl.`meta_title`
        FROM `' . _DB_PREFIX_ . 'cms` c
		LEFT JOIN `'._DB_PREFIX_.'cms_lang` cl ON c.id_cms=cl.id_cms
        WHERE (cl.meta_title LIKE \'%' . pSQL($q) . '%\')
		AND cl.`id_lang`=' . (int)$this->_default_language . '
        '.((version_compare(_PS_VERSION_, '1.4.0.0', '>=')) ? 'AND c.`active` = 1' : '').'
        ORDER BY cl.`meta_title` ' . ($limit ? 'LIMIT ' . $start . ', ' . ( int ) $limit : ''));
		return $result;
	}
	private function getControllerNameOnLive($q) {
		$pages = Meta::getPages();
		$pages_names = Meta::getMetasByIdLang($this->_cookie->id_lang);
		$controllers_list = array();
		foreach ($pages_names as $page_name) {
			if (isset($page_name['page']) && ((isset($pages[$page_name['page']]) || in_array($page_name['page'], $pages)) || (isset($pages[str_replace('-', '', $page_name['page'])]) || in_array(str_replace('-', '', $page_name['page']), $pages)))) {
				if (stripos($page_name['page'], $q) !== false || stripos($page_name['title'], $q) !== false) {
					$controllers_list[] = $page_name;
				}
			}
		}
		return $controllers_list;
	}
	protected function _pmClearCache() {
		$this->_clearCompiledTpl();
		if (version_compare(_PS_VERSION_, '1.4.0.0', '<') || Configuration::get('PS_FORCE_SMARTY_2')) {
			return $this->_smarty->clear_cache(null, self::$_module_prefix);
		} else {
			return $this->_smarty->clearCache(null, self::$_module_prefix);
		}
		return true;
	}
	protected static function _clearCompiledTplAlternative($tplFileName, $compileDir) {
		$result = false;
		$compileDir = rtrim($compileDir, '/'); 
		$files = scandir($compileDir);
		if ($files && sizeof($files)) {
			foreach ($files as $filename) {
				if ($filename != '.' && $filename != '..' && is_dir($compileDir.'/'.$filename)) {
					self::_clearCompiledTplAlternative($tplFileName, $compileDir.'/'.$filename);
				} else {
					$ext = self::_getFileExtension($filename);
					if ($filename == '.' && $filename == '..' || is_dir($compileDir.'/'.$filename) || $filename == 'index.php' || $ext != 'php' || !preg_match('/file\.'.preg_quote($tplFileName).'\.php/', $filename)) continue;
					if (@file_exists($compileDir.'/'.$filename) && @unlink($compileDir.'/'.$filename)) $result = true;
				}
			}
		}
		return $result;
	}
	protected function _clearCompiledTpl() {
		$files = scandir(dirname(__FILE__));
		if ($files && sizeof($files)) {
			foreach ($files as $filename) {
				$ext = self::_getFileExtension($filename);
				if ($ext != 'tpl') continue;
				if (version_compare(_PS_VERSION_, '1.4.0.0', '<') || Configuration::get('PS_FORCE_SMARTY_2')) {
					$this->_smarty->clear_compiled_tpl($filename);
				} else {
					if (!$this->_smarty->clearCompiledTemplate($filename))
						self::_clearCompiledTplAlternative($filename, $this->_smarty->getCompileDir());
				}
			}
		}
	}
	protected function _checkPermissions() {
		if (isset($this->_file_to_check) && is_array($this->_file_to_check) && count($this->_file_to_check)) {
			$errors = array();
			foreach ($this->_file_to_check as $fileOrDir) {
				if (!is_writable(dirname(__FILE__) . '/' . $fileOrDir)) {
					$errors [] = dirname(__FILE__) . '/' . $fileOrDir;
				}
			}
			if (!sizeof($errors))
				return true;
			else {
				$this->_html .= '<div class="warning warn clear">' . $this->l('Before being able to configure the module, make sure to set write permissions to files and folders listed below:', $this->_coreClassName) . '<br />' . implode('<br />', $errors) . '</div>';
				return false;
			}
		}
		return true;
	}
	protected function getContent() {
		if ($this->_require_maintenance) {
			$this->_maintenanceWarning();
			$this->_maintenanceButton();
			$this->_html .= '<hr class="pm_hr" />';
		}
	}
	public static function _getFileExtension($filename) {
		$split = explode('.', $filename);
		$extension = end($split);
		return strtolower($extension);
	}
	protected function _pmClear(){
		$this->_html .= '<div class="clear"></div>';
	}
	protected function _showWarning($text) {
		$this->_html .= '<div class="ui-widget">
        <div style="margin-top: 20px;margin-bottom: 20px;  padding: 0 .7em;" class="ui-state-error ui-corner-all">
          <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
          ' . $text . '
        </div>
      </div>';
	}
	protected function _showRating($show = false) {
		$dismiss = (int)(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Configuration::getGlobalValue('PM_'.self::$_module_prefix.'_DISMISS_RATING') : Configuration::get('PM_'.self::$_module_prefix.'_DISMISS_RATING'));
		if ($show && $dismiss != 1 && self::_getNbDaysModuleUsage() >= 3) {
			$this->_html .= '
			<div id="addons-rating-container" class="ui-widget note">
				<div style="margin-top: 20px; margin-bottom: 20px; padding: 0 .7em; text-align: center;" class="ui-state-highlight ui-corner-all">
					<p class="invite">'
						. $this->l('You are satisfied with our module and want to encourage us to add new features ?', $this->_coreClassName)
						. '<br/>'
						. '<a href="http://addons.prestashop.com/ratings.php" target="_blank"><strong>'
						. $this->l('Please rate it on Prestashop Addons, and give us 5 stars !', $this->_coreClassName)
						. '</strong></a>
					</p>
					<p class="dismiss">'
						. '[<a href="javascript:void(0);">'
						. $this->l('No thanks, I don\'t want to help you. Close this dialog.', $this->_coreClassName)
						. '</a>]
					 </p>
				</div>
			</div>';
		}
	}
	protected function _showInfo($text) {
		$this->_html .= '<div class="ui-widget">
        <div style="margin-top: 20px;margin-bottom: 20px;  padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
          <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
          ' . $text . '
        </div>
      </div>';
	}
	protected function _displayTitle($title) {
		$this->_html .= '<h2>' . $title . '</h2>';
	}
	protected function _displaySubTitle($title) {
		$this->_html .= '<h3 class="pmSubTitle">' . $title . '</h3>';
	}
	public function _displayErrorsJs($include_script_tag = false) {
		if ($include_script_tag) $this->_html .= '<script type="text/javascript">';
		if (sizeof($this->errors)) {
			foreach ($this->errors as $key => $error )
				$this->_html .= 'parent.parent.show_error("' . $error . '");';
		}
		if ($include_script_tag) $this->_html .= '</script>';
	}
	
	private function _getPMdata() {
		$param = array();
		$param[] = 'ver-'._PS_VERSION_;
		$param[] = 'current-'.$this->name;
		
		$result = self::Db_ExecuteS('SELECT DISTINCT name FROM '._DB_PREFIX_.'module WHERE name LIKE "pm_%"');
		if ($result && self::_isFilledArray($result)) {
			foreach ($result as $module) {
				$instance = Module::getInstanceByName($module['name']);
				if ($instance && isset($instance->version)) $param[] = $module['name'].'-'.$instance->version;
			}
		}
		return urlencode(base64_encode(implode('|', $param)));
	}
	protected function _displayCS() {
		$this->_html .= '<div id="pm_panel_cs_modules_bottom" class="pm_panel_cs_modules_bottom"><br />';
		$this->_displayTitle($this->l('Check all our modules', $this->_coreClassName));
		$this->_html .= '<iframe src="//www.presta-module.com/cross-selling-addons-modules-footer?pm='.$this->_getPMdata().'" scrolling="no"></iframe></div>';
	}
	protected function _displaySupport() {
		$this->_html .= '<div id="pm_footer_container" class="ui-corner-all ui-tabs ui-tabs-panel">';
		$this->_displayCS();
		$this->_html .= '<div id="pm_support_informations" class="pm_panel_bottom"><br />';
		if (method_exists($this, '_displayTitle'))
			$this->_displayTitle($this->l('Information & Support', (isset($this->_coreClassName) ? $this->_coreClassName : false)));
		else
			$this->_html .= '<h2>' . $this->l('Information & Support', (isset($this->_coreClassName) ? $this->_coreClassName : false)) . '</h2>';
		$this->_html .= '<ul class="pm_links_block">';
		$this->_html .= '<li class="pm_module_version"><strong>' . $this->l('Module Version: ', (isset($this->_coreClassName) ? $this->_coreClassName : false)) . '</strong> ' . $this->version . '</li>';
		if (isset($this->_getting_started) && self::_isFilledArray($this->_getting_started))
			$this->_html .= '<li class="pm_get_started_link"><a href="javascript:;" class="pm_link">'. $this->l('Getting started', (isset($this->_coreClassName) ? $this->_coreClassName : false)) .'</a></li>';
		if (self::_isFilledArray($this->_support_link))
			foreach($this->_support_link as $infos)
				$this->_html .= '<li class="pm_useful_link"><a href="'.$infos['link'].'" target="_blank" class="pm_link">'.$infos['label'].'</a></li>';
		$this->_html .= '</ul>';
		if (isset($this->_copyright_link) && $this->_copyright_link) {
			$this->_html .= '<div class="pm_copy_block">';
			if (isset($this->_copyright_link['link']) && !empty($this->_copyright_link['link'])) $this->_html .= '<a href="'.$this->_copyright_link['link'].'"'.((isset($this->_copyright_link['target']) AND $this->_copyright_link['target']) ? ' target="'.$this->_copyright_link['target'].'"':'').''.((isset($this->_copyright_link['style']) AND $this->_copyright_link['style']) ? ' style="'.$this->_copyright_link['style'].'"':'').'>';
			$this->_html .= '<img src="'.str_replace('_PATH_', $this->_path, $this->_copyright_link['img']).'" />';
			if (isset($this->_copyright_link['link']) && !empty($this->_copyright_link['link'])) $this->_html .= '</a>';
			$this->_html .= '</div>';
		}
		$this->_html .= '</div>';
		$this->_html .= '</div>';
		if (isset($this->_getting_started) && self::_isFilledArray($this->_getting_started)) {
			$this->_html .= "<script type=\"text/javascript\">
			$('.pm_get_started_link a').click(function() { $.fancybox([";
			$get_started_image_list = array();
			foreach ($this->_getting_started as $get_started_image)
				$get_started_image_list[] = "{ 'href': '".$get_started_image['href']."', 'title': '".htmlentities($get_started_image['title'], ENT_QUOTES, 'UTF-8')."' }";
			$this->_html .= implode(',', $get_started_image_list);
			$this->_html .= "
					], {
					'padding'			: 0,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'image',
					'changeFade'		: 0
				}); });
			</script>";
		}
		if (method_exists($this, '_includeHTMLAtEnd')) $this->_includeHTMLAtEnd();
	}
	protected function _preProcess() {
		if (Tools::getIsset('dismissRating')) {
			$this->_cleanOutput();
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
				Configuration::updateGlobalValue('PM_'.self::$_module_prefix.'_DISMISS_RATING', 1);
			else
				Configuration::updateValue('PM_'.self::$_module_prefix.'_DISMISS_RATING', 1);
			die;
		} else if (Tools::getIsset('pm_load_function')) {
			if (method_exists($this, Tools::getValue('pm_load_function'))) {
				$this->_cleanOutput();
				if (Tools::getValue('class')) {
					if (class_exists ( Tools::getValue('class') )) {
						$class = Tools::getValue('class');
						$obj = new $class();
						if (Tools::getValue($obj->identifier)) {
							$obj = new $class(Tools::getValue($obj->identifier));
						}
						$pmLoadFunction = Tools::getValue('pm_load_function');
						$params = array('obj'=>$obj,'class'=>$class, 'method'=> $pmLoadFunction,'reload_after'=>Tools::getValue('pm_reload_after'),'js_callback'=>Tools::getValue('pm_js_callback'));
						$this->_preLoadFunctionProcess($params);
						$this->$pmLoadFunction($params);
					} else {
						$this->_cleanOutput();
						$this->_showWarning($this->l('Class', $this->_coreClassName).' '.Tools::getValue('class').' '.$this->l('does not exists', $this->_coreClassName));
						$this->_echoOutput(true);
					}
				} else {
					$pmLoadFunction = Tools::getValue('pm_load_function');
					$params = array('method' => $pmLoadFunction,'reload_after'=>Tools::getValue('pm_reload_after'),'js_callback'=>Tools::getValue('pm_js_callback'));
					$this->_preLoadFunctionProcess($params);
					$this->$pmLoadFunction($params);
				}
				$this->_echoOutput(true);
			} else {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Method unvailable', $this->_coreClassName));
				$this->_echoOutput(true);
			}
		} else if (Tools::getIsset('pm_delete_obj')) {
			if (Tools::getValue('class')) {
				if (class_exists ( Tools::getValue('class') )) {
					$class = Tools::getValue('class');
					$obj = new $class();
					$obj = new $class(Tools::getValue($obj->identifier));
					$this->_preDeleteProcess(array('obj'=>$obj,'class'=>$class));
					if ($obj->delete()) {
						$this->_cleanOutput();
						$this->_postDeleteProcess(array('class'=>$class));
						$this->_echoOutput(true);
					} else {
						$this->_cleanOutput();
						$this->_showWarning($this->l('Error while deleting object', $this->_coreClassName));
						$this->_echoOutput(true);
					}
				} else {
					$this->_cleanOutput();
					$this->_showWarning($this->l('Class', $this->_coreClassName).' '.Tools::getValue('class').' '.$this->l('does not exists', $this->_coreClassName));
					$this->_echoOutput(true);
				}
			} else {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Please send class name into "class" var', $this->_coreClassName));
				$this->_echoOutput(true);
			}
		} else if (Tools::getIsset('pm_save_order')) {
			if (!Tools::getValue('order')) {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Not receive IDS', $this->_coreClassName));
				$this->_echoOutput(true);
			} else if (!Tools::getValue('destination_table')) {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Please send destination table', $this->_coreClassName));
				$this->_echoOutput(true);
			} else if (!Tools::getValue('field_to_update')) {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Please send name of position field', $this->_coreClassName));
				$this->_echoOutput(true);
			} else if (!Tools::getValue('identifier')) {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Please send identifier', $this->_coreClassName));
				$this->_echoOutput(true);
			} else {
				$order = Tools::getValue('order');
				$identifier = Tools::getValue('identifier');
				$field_to_update = Tools::getValue('field_to_update');
				$destination_table = Tools::getValue('destination_table');
				foreach ($order as $position => $id) {
					$id = preg_replace("/^\w+_/", "", $id);
					$data = array($field_to_update=>$position);
					Db::getInstance()->AutoExecute(_DB_PREFIX_ . $destination_table, $data, 'UPDATE', $identifier.' = ' . (int) $id);
				}
				$this->_cleanOutput();
				$this->_echoOutput(true);
			}
		} elseif (Tools::getIsset('getPanel') && Tools::getValue('getPanel')) {
			self::_cleanBuffer();
			switch (Tools::getValue('getPanel')) {
				case 'getChildrenCategories':
					if (Tools::getValue('id_category_parent')){
						$children_categories = self::getChildrenWithNbSelectedSubCat(Tools::getValue('id_category_parent'), Tools::getValue('selectedCat'), $this->_default_language);
						die(self::jsonEncode($children_categories));
					}
					break;
			}
		}
	}
	protected function _maintenanceButton($return = false) {
		$returnText = '<a href="' . $this->_base_config_url . '&activeMaintenance=1" title="Maintenance" class="ajax_script_load ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" id="buttonMaintenance" style="padding-right:5px;">';
		$returnText .= '<span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;"></span>';
		if (Configuration::get('PM_' . self::$_module_prefix . '_MAINTENANCE')) {
			$returnText .= $this->l('Disable Maintenance Mode', $this->_coreClassName);
		} else {
			$returnText .= $this->l('Put the module in Maintenance Mode', $this->_coreClassName);
		}
		$returnText .= '<span id="pmImgMaintenance" class="ui-icon ui-icon-' . (Configuration::get('PM_' . self::$_module_prefix . '_MAINTENANCE') ? 'locked' : 'unlocked') . '" style="float: right; margin-left: .3em;">';
		$returnText .= '</span>';
		$returnText .= '</a>';
		if (!$return) $this->_html .= $returnText;
		else return $returnText;
	}
	protected function _maintenanceWarning() {
		$ip_maintenance = Configuration::get('PS_MAINTENANCE_IP');
		$this->_html .= '<div id="maintenanceWarning" class="warning"
								' . ((Configuration::get('PM_' . self::$_module_prefix . '_MAINTENANCE')) ? '' : 'style="display:none"') . '">
								<center>
								<img src="' . $this->_path . 'img/warning.png" style="padding-right:1em;"/>';
		if (!$ip_maintenance || empty($ip_maintenance)) {
			if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
				$tab_http_key = 'tab';
				$tab_http_value = 'AdminPreferences';
			} else {
				$tab_http_key = 'controller';
				$tab_http_value = 'AdminMaintenance';
			}
			$this->_html .= '<b>' . $this->l('You must define a maintenance IP in your', $this->_coreClassName) . '
					<a href="index.php?'.$tab_http_key.'='.$tab_http_value.'&token=' . Tools::getAdminToken($tab_http_value . intval(Tab::getIdFromClassName($tab_http_value)) . intval($this->_employee->id)) . '" style="text-decoration:underline;">
					' . $this->l('Preferences Panel.', $this->_coreClassName) . '
					</a></b><br />';
		}
		$this->_html .= $this->l('Module is currently running in Maintenance Mode.', $this->_coreClassName) . '';
		$this->_html .= '</center></div>';
		return $this->_html;
	}
	protected function _postProcessMaintenance() {
		$return = '';
		$maintenance = Configuration::get('PM_' . self::$_module_prefix . '_MAINTENANCE');
		$maintenance = ($maintenance ? 0 : 1);
		Configuration::updateValue('PM_' . self::$_module_prefix . '_MAINTENANCE', intval($maintenance));
		$return .= '$jqPm("a#buttonMaintenance").after("'.addcslashes($this->_maintenanceButton(true), '"').'").remove();';
		if ($maintenance) {
			$return .= '$jqPm("#pmImgMaintenance").attr("class", "ui-icon ui-icon-locked");';
			$return .= '$jqPm("#maintenanceWarning").slideDown();';
			$return .= 'show_info("' . $this->l('Your module is now in maintenance mode.', $this->_coreClassName) . '");';
		} else {
			$return .= '$jqPm("#pmImgMaintenance").attr("class", "ui-icon ui-icon-unlocked");';
			$return .= '$jqPm("#maintenanceWarning").slideUp();';
			$return .= 'show_info("' . $this->l('Your module is now running in normal mode.', $this->_coreClassName) . '");';
		}
		$this->_pmClearCache();
		self::_cleanBuffer();
		return $return;
	}
	protected function _isInMaintenance() {
		if (isset($this->_cacheIsInMaintenance)) return $this->_cacheIsInMaintenance;
		if (Configuration::get('PM_'.self::$_module_prefix.'_MAINTENANCE')){
			$ips = explode(',',Configuration::get('PS_MAINTENANCE_IP'));
			if (in_array($_SERVER['REMOTE_ADDR'], $ips)){
				$this->_cacheIsInMaintenance = false;
				return false;
			}
			$this->_cacheIsInMaintenance = true;
			return true;
		}
		$this->_cacheIsInMaintenance = false;
		return false;
	}
	protected function _preCopyFromPost() {
	}
	protected function _postCopyFromPost($params) {
	}
	protected function _preDeleteProcess($params) {
	}
	protected function _preLoadFunctionProcess(&$params) {
	}
	protected function _postDeleteProcess($params) {
		if (isset($params['include_script_tag']) && $params['include_script_tag']) $this->_html .= '<script type="text/javascript">';
		if (Tools::getIsset('pm_reload_after') && Tools::getValue('pm_reload_after'))
			$this->_reloadPanels(Tools::getValue('pm_reload_after'));
		if (Tools::getIsset('pm_js_callback') && Tools::getValue('pm_js_callback'))
			$this->_getJsCallback(Tools::getValue('pm_js_callback'));
		$this->_html .= 'parent.parent.show_info("'.$this->l('Successfully deleted', $this->_coreClassName).'");';
		if (isset($params['include_script_tag']) && $params['include_script_tag']) $this->_html .= '</script>';
	}
	protected function _getJsCallback($js_callback) {
		$js_callbacks = explode('|', $js_callback);
		foreach($js_callbacks as $js_callback) {
			$this->_html .= 'parent.parent.'.$js_callback.'();';
		}
	}
	protected function _reloadPanels($reload_after) {
		$reload_after = explode('|', $reload_after);
		foreach($reload_after as $panel) {
			$this->_html .= 'parent.parent.reloadPanel("'.$panel.'");';
		}
	}
	protected function _postSaveProcess($params) {
		if (isset($params['include_script_tag']) && $params['include_script_tag']) $this->_html .= '<script type="text/javascript">';
		if (isset($params['reload_after']) && $params['reload_after'])
			$this->_reloadPanels($params['reload_after']);
		if (isset($params['js_callback']) && $params['js_callback'])
			$this->_getJsCallback($params['js_callback']);
		$this->_html .= 'parent.parent.show_info("'.$this->l('Successfully saved', $this->_coreClassName).'");</script>';
		if (isset($params['include_script_tag']) && $params['include_script_tag']) $this->_html .= '</script>';
	}
	protected function _postProcess() {
		if (Tools::getValue('pm_save_obj')) {
			if (class_exists ( Tools::getValue('pm_save_obj') )) {
				$class = Tools::getValue('pm_save_obj');
				$obj = new $class();
				if (Tools::getValue($obj->identifier)) {
					$obj = new $class(Tools::getValue($obj->identifier));
				}
				$this->errors = self::_retroValidateController($obj);
				if (!self::_isFilledArray($this->errors)) {
					$this->copyFromPost($obj);
					if ($obj->save()) {
						$this->_cleanOutput();
						$this->_postSaveProcess(array('class'=>$class,'obj'=>$obj,'include_script_tag'=>true,'reload_after'=>Tools::getValue('pm_reload_after'),'js_callback'=>Tools::getValue('pm_js_callback')));
						$this->_echoOutput(true);
					}else {
						$this->_cleanOutput();
						$this->_showWarning($this->l('Error while saving object', $this->_coreClassName));
						$this->_echoOutput(true);
					}
				}else { $this->_cleanOutput();$this->_displayErrorsJs(true); $this->_echoOutput(true);}
			}else {
				$this->_cleanOutput();
				$this->_showWarning($this->l('Class', $this->_coreClassName).' '.Tools::getValue('class').' '.$this->l('does not exists', $this->_coreClassName));
				$this->_echoOutput(true);
			}
		}
		elseif (Tools::getValue('activeMaintenance')) {
			echo $this->_postProcessMaintenance(self::$_module_prefix);
			die();
		} elseif (Tools::getValue('uploadTempFile')) {
			$this->_postProcessUploadTempFile();
		} else if (Tools::getValue('getItem')) {
			$this->_cleanOutput();
			$item = Tools::getValue('itemType');
			$query = Tools::getValue('q', false);
			if (!$query || strlen($query) < 1) {
				self::_cleanBuffer();
				die();
			}
			$limit = Tools::getValue('limit', 100);
			$start = Tools::getValue('start', 0);
			switch ($item) {
				case 'product' :
					$items = $this->getProductsOnLive($query, $limit, $start);
					$item_id_column = 'id_product';
					$item_name_column = 'name';
					break;
				case 'supplier' :
					$items = $this->getSuppliersOnLive($query, $limit, $start);
					$item_id_column = 'id_supplier';
					$item_name_column = 'name';
					break;
				case 'manufacturer' :
					$items = $this->getManufacturersOnLive($query, $limit, $start);
					$item_id_column = 'id_manufacturer';
					$item_name_column = 'name';
					break;
				case 'cms' :
					$items = $this->getCMSPagesOnLive($query, $limit, $start);
					$item_id_column = 'id_cms';
					$item_name_column = 'meta_title';
					break;
				case 'controller' :
					$items = $this->getControllerNameOnLive($query);
					$item_id_column = 'page';
					$item_name_column = 'title';
					break;
			}
			if ($items)
				foreach ($items as $row )
					$this->_html .= $row [$item_id_column] . '=' . $row [$item_name_column] . "\n";
			$this->_echoOutput(true);
			die();
		}
	}
	protected function _postProcessUploadTempFile() {
		if (!empty($_FILES)) {
			$this->_cleanOutput();
			$tempFile = $_FILES ['Filedata'] ['tmp_name'];
			$targetPath = $_SERVER ['DOCUMENT_ROOT'] . $_REQUEST ['folder'] . '/';
			$targetFile = str_replace('//', '/', $targetPath) . $_FILES ['Filedata'] ['name'];
			move_uploaded_file($tempFile, $targetFile);
			$this->_html .= str_replace($_SERVER ['DOCUMENT_ROOT'], '', $targetFile);
			$this->_echoOutput(true);
		}
	}
	protected function _initClassVar() {
		global $cookie, $smarty, $currentIndex, $employee;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$this->_context = Context::getContext();
			$this->_cookie = $this->_context->cookie;
			$this->_smarty = $this->_context->smarty;
		} else {
			$this->_cookie = $cookie;
			$this->_smarty = $smarty;
		}
		$this->_employee = $employee;
		$this->_base_config_url = ((version_compare(_PS_VERSION_, '1.5.0.0', '<')) ? $currentIndex : $_SERVER['SCRIPT_NAME'].(($controller = Tools::getValue('controller')) ? '?controller='.$controller: '')) . '&configure=' . $this->name . '&token=' . Tools::getValue('token');
		$this->_default_language = (int) Configuration::get('PS_LANG_DEFAULT');
		$this->_iso_lang = Language::getIsoById($this->_cookie->id_lang);
		$this->_languages = Language::getLanguages(false);
	}
	protected function _startForm($configOptions) {
		$defaultOptions = array(
			'action' => false,
			'target' => 'dialogIframePostForm',
			'iframetarget' => true
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		if ($configOptions['iframetarget']) $this->_headerIframe();
		$this->_html .= '<form action="' . ($configOptions['action'] ? $configOptions['action'] : $this->_base_config_url) . '" method="post" class="width3" id="' . $configOptions['id'] . '" target="' . $configOptions['target'] . '">';
		if (isset($configOptions['obj']) && $configOptions['obj'] && isset($configOptions['obj']->id) && $configOptions['obj']->id) {
			$this->_html .= '<input type="hidden" name="'.$configOptions['obj']->identifier.'" value="'.$configOptions['obj']->id.'" />';
		}
		if (isset($configOptions['obj']) && $configOptions['obj'])
			$this->_html .= '<input type="hidden" name="pm_save_obj" value="'.get_class($configOptions['obj']).'" />';
		if (isset($configOptions['params']['reload_after']) && $configOptions['params']['reload_after'])
			$this->_html .= '<input type="hidden" name="pm_reload_after" value="'.$configOptions['params']['reload_after'].'" />';
		if (isset($configOptions['params']['js_callback']) && $configOptions['params']['js_callback'])
			$this->_html .= '<input type="hidden" name="pm_js_callback" value="'.$configOptions['params']['js_callback'].'" />';
	}
	protected function _endForm($configOptions) {
		$defaultOptions = array(
			'id' => NULL,
			'iframetarget' => true,
			'jquerytoolsvalidatorfunction' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '</form>';
		if ($configOptions['id'] != NULL && in_array('jquerytools', $this->_css_js_to_load)) {
			$this->_html .= '
			<script type="text/javascript">
				$jqPm("#'.$configOptions['id'].'").validator({
					lang: "'.$this->_iso_lang.'",
					messageClass: "formValidationError",
					errorClass: "elementErrorAssignedClass",
					position: "center bottom"
				})'.(($configOptions['jquerytoolsvalidatorfunction'] != false) ? '.submit('.$configOptions['jquerytoolsvalidatorfunction'].')' : '').';
			</script>';
		}
		if ($configOptions['iframetarget']) $this->_footerIframe();
	}
	public function _retrieveFormValue($type, $fieldName, $fieldDbName = false, $obj, $defaultValue = '', $compareValue = false, $key = false) {
		if (!$fieldDbName) $fieldDbName = $fieldName;
		switch ($type) {
			case 'text' :
				if ($key)
					return htmlentities(stripslashes(Tools::getValue($fieldName, ($obj && isset($obj->{$fieldDbName} [$key]) ? $obj->{$fieldDbName} [$key] : $defaultValue))), ENT_COMPAT, 'UTF-8');
				else
					return htmlentities(stripslashes(Tools::getValue($fieldName, ( $obj && isset($obj->{$fieldDbName}) ? $obj->{$fieldDbName} : $defaultValue))), ENT_COMPAT, 'UTF-8');
				break;
			case 'textpx' :
				if ($key)
					return intval(preg_replace('#px#', '', Tools::getValue($fieldName, ( $obj && isset($obj->{$fieldDbName}) ? $obj->{$fieldDbName} [$key] : $defaultValue))));
				else
					return intval(preg_replace('#px#', '', Tools::getValue($fieldName, ( $obj && isset($obj->{$fieldDbName}) ? $obj->{$fieldDbName} : $defaultValue))));
				break;
			case 'select' :
				return ((Tools::getValue($fieldName, ( $obj && isset($obj->{$fieldDbName}) ? $obj->{$fieldDbName} : $defaultValue)) == $compareValue) ? ' selected="selected"' : '');
				break;
			case 'radio' :
			case 'checkbox' :
				if (isset($obj->$fieldName) && is_array($obj->$fieldName) && sizeof($obj->$fieldName) && isset($obj->{$fieldDbName})  )
					return ( ( in_array($compareValue, $obj->$fieldName) ) ? ' checked="checked"' : '');
				return ((Tools::getValue($fieldName, ($obj && isset($obj->{$fieldDbName}) ? $obj->{$fieldDbName} : $defaultValue)) == $compareValue) ? ' checked="checked"' : '');
				break;
		}
	}
	protected function _startFieldset($title, $icone = false, $hide = true, $onclick = false) {
		$this->_html .= '<fieldset>';
		if ($title || $hide) $this->_html .= '<legend class="ui-state-default" style="cursor:pointer;" onclick="$jqPm(this).next(\'div\').slideToggle(\'fast\'); '.
		($onclick?$onclick:'').'">' . ($icone ? '<img src="' . $icone . '" alt="' . $title . '" title="' . $title . '" /> ' : '') . '' . $title . ' <small ' . (!$hide ? 'style="display:none;"' : '') . '>' . $this->l('Click here to edit', $this->_coreClassName) . '</small></legend>';
		$this->_html .= '<div' . ($hide ? ' class="hideAfterLoad"' : '') . '>';
	}
	protected function _endFieldset() {
		$this->_html .= '</div>';
		$this->_html .= '</fieldset>';
		$this->_html .= '<br />';
	}
	protected function _displayAjaxSelectMultiple($configOptions) {
		$defaultOptions = array(
			'remoteurl' => false,
			'limit' => 50,
			'limitincrement' => 20,
			'remoteparams' => false,
			'tips' => false,
			'triggeronliclick' => true,
			'displaymore' => true,
			'idcolumn' => '',
			'namecolumn' => ''
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
	    				<div class="margin-form">';
		$this->_html .= '<select id="multiselect' . $configOptions['key'] . '" class="multiselect" multiple="multiple" name="' . $configOptions['key'] . '[]">';
		if ($configOptions['selectedoptions'] && is_array($configOptions['selectedoptions']) && sizeof($configOptions['selectedoptions'])) {
			$index_column = false;
			if (isset($configOptions['namecolumn']) && isset($configOptions['idcolumn']) && !empty($configOptions['namecolumn']) && !empty($configOptions['idcolumn'])) $index_column = true;
			foreach ($configOptions['selectedoptions'] as $value => $option) {
				if ($index_column) {
					$this->_html .= '<option value="' . (is_numeric($option[$configOptions['idcolumn']]) ? (int)$option[$configOptions['idcolumn']] : $option[$configOptions['idcolumn']]) . '" selected="selected">' . htmlentities($option[$configOptions['namecolumn']], ENT_COMPAT, 'UTF-8') . '</option>';
				} else {
					$this->_html .= '<option value="' . (is_numeric($value) ? (int)$value : $value) . '" selected="selected">' . htmlentities($option, ENT_COMPAT, 'UTF-8') . '</option>';
				}
			}
		}
		$this->_html .= '</select>';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_html .= '<script type="text/javascript">
			$jqPm("#multiselect' . $configOptions['key'] . '").multiselect({
				locale: {
						addAll:\''.addcslashes($this->l('Add all', $this->_coreClassName), "'").'\',
						removeAll:\''.addcslashes($this->l('Remove all', $this->_coreClassName), "'").'\',
						itemsCount:\''.addcslashes($this->l('#{count} items selected', $this->_coreClassName), "'").'\',
						itemsTotal:\''.addcslashes($this->l('#{count} items total', $this->_coreClassName), "'").'\',
						busy:\''.addcslashes($this->l('Please wait...', $this->_coreClassName), "'").'\',
						errorDataFormat:\''.addcslashes($this->l('Cannot add options, unknown data format', $this->_coreClassName), "'").'\',
						errorInsertNode:"'.addcslashes($this->l('There was a problem trying to add the item', $this->_coreClassName).':\n\n\t[#{key}] => #{value}\n\n'.addcslashes($this->l('The operation was aborted.', $this->_coreClassName), '"'), "'").'",
						errorReadonly:\''.addcslashes($this->l('The option #{option} is readonly', $this->_coreClassName), "'").'\',
						errorRequest:\''.addcslashes($this->l('Sorry! There seemed to be a problem with the remote call. (Type: #{status})', $this->_coreClassName), "'").'\',
						sInputSearch:\''.addcslashes($this->l('Please enter the first letters of the search item', $this->_coreClassName), "'").'\',
						sInputShowMore:\''.addcslashes($this->l('Show more', $this->_coreClassName), "'").'\'
					},
				remoteUrl: "' . $configOptions['remoteurl'] . '",
				remoteLimit:' . (int) $configOptions['limit'] . ',
				remoteStart:0,
				remoteLimitIncrement:' . (int) $configOptions['limitincrement'] . ($configOptions['remoteparams'] ? ', remoteParams: { ' . $configOptions['remoteparams'] . ' }' : '') . ',
				triggerOnLiClick: '. (($configOptions['triggeronliclick'] == true) ? 'true' : 'false') .',
				displayMore: '. (($configOptions['displaymore'] == true) ? 'true' : 'false') .'
			});
		    </script>';
		$this->_pmClear();
	}
	protected function _displayInputActive($configOptions) {
		$defaultOptions = array(
			'defaultvalue' => false,
			'tips' => false,
			'onclick' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
	    <div class="margin-form"><label class="t" for="' . $configOptions['key_active'] . '_on" style="float:left;"><img src="../img/admin/enabled.gif" alt="' . $this->l('Yes', $this->_coreClassName) . '" title="' . $this->l('Yes', $this->_coreClassName) . '" /></label>
	      <input type="radio" name="' . $configOptions['key_active'] . '" id="' . $configOptions['key_active'] . '_on" ' . ($configOptions['onclick'] ? 'onclick="' . $configOptions['onclick'] . '"' : '') . ' value="1" ' . $this->_retrieveFormValue('radio', $configOptions['key_active'], $configOptions['key_db'], $configOptions['obj'], $configOptions['defaultvalue'], 1) . '  style="float:left;" />
	      <label class="t" for="' . $configOptions['key_active'] . '_on" style="float:left;"> ' . $this->l('Yes', $this->_coreClassName) . '</label>
	      <label class="t" for="' . $configOptions['key_active'] . '_off" style="float:left;"><img src="../img/admin/disabled.gif" alt="' . $this->l('No', $this->_coreClassName) . '" title="' . $this->l('No', $this->_coreClassName) . '" style="margin-left: 10px;" /></label>
	      <input type="radio" name="' . $configOptions['key_active'] . '" id="' . $configOptions['key_active'] . '_off" ' . ($configOptions['onclick'] ? 'onclick="' . $configOptions['onclick'] . '"' : '') . ' value="0" ' . $this->_retrieveFormValue('radio', $configOptions['key_active'], $configOptions['key_db'], $configOptions['obj'], $configOptions['defaultvalue'], 0) . '  style="float:left;"/>
	      <label class="t" for="' . $configOptions['key_active'] . '_off" style="float:left;"> ' . $this->l('No', $this->_coreClassName) . '</label>';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key_active'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key_active'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
	}
	protected function _displayInputGradient($configOptions) {
		$defaultOptions = array(
			'defaultvalue' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$color1 = false;
		$color2 = false;
		$val = false;
		if (isset($_POST[$configOptions['key']][0])) {
			if (is_array($_POST[$configOptions['key']])) {
				if (isset($_POST[$configOptions['key']][1])) {
					$color1 = htmlentities($_POST[$configOptions['key']][0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($_POST[$configOptions['key']][1], ENT_COMPAT, 'UTF-8');
				} else
					$color1 = htmlentities($_POST[$configOptions['key']][0], ENT_COMPAT, 'UTF-8');
			} else {
				$val = explode(self::$_gradient_separator, $_POST[$configOptions['key']]);
				if (isset($val[1])) {
					$color1 = htmlentities($val[0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($val[1], ENT_COMPAT, 'UTF-8');
				} else
					$color1 = htmlentities($val[0], ENT_COMPAT, 'UTF-8');
			}
		} else if ($configOptions['obj'] && $configOptions['obj']->{$configOptions['key']}) {
			$val = explode(self::$_gradient_separator, $configOptions['obj']->{$configOptions['key']});
			if (isset($val[1])) {
				$color1 = htmlentities($val[0], ENT_COMPAT, 'UTF-8');
				$color2 = htmlentities($val[1], ENT_COMPAT, 'UTF-8');
			} else
				$color1 = htmlentities($val[0], ENT_COMPAT, 'UTF-8');
		} else if (!$configOptions['obj'] && $configOptions['defaultvalue']) {
			$val = explode(self::$_gradient_separator, $configOptions['defaultvalue']);
			if (isset($val[1])) {
				$color1 = htmlentities($val[0], ENT_COMPAT, 'UTF-8');
				$color2 = htmlentities($val[1], ENT_COMPAT, 'UTF-8');
			} else
				$color1 = htmlentities($val[0], ENT_COMPAT, 'UTF-8');
		}
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
    <div class="margin-form">
      <input size="20" type="text" name="' . $configOptions['key'] . '[0]" id="' . $configOptions['key'] . '_0" class="colorPickerInput ui-corner-all ui-input-pm" value="' . (!$color1 ? '' : $color1) . '" size="20" style="width:60px" />
      &nbsp; <span ' . (isset($color2) && $color2 ? '' : 'style="display:none"') . ' id="' . $configOptions['key'] . '_gradient"><input size="20" type="text" class="colorPickerInput ui-corner-all ui-input-pm" name="' . $configOptions['key'] . '[1]" id="' . $configOptions['key'] . '_1" value="' . (! isset($color2) || !$color2 ? '' : $color2) . '" size="20" style="margin-left:10px;" /></span>
      &nbsp; <span id="' . $configOptions['key'] . '_gradient" style="float:left;margin-left:10px;"><input type="checkbox" name="' . $configOptions['key'] . '_gradient" value="1" ' . (isset($color2) && $color2 ? 'checked=checked' : '') . ' class="makeGradient" /> &nbsp; ' . $this->l('Make a gradient', $this->_coreClassName) . '</span>';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_initColorPickerAtEnd = true;
	}
	protected function _displayInputBorder($configOptions) {
		$defaultOptions = array(
			'defaultvalue' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$border_style_values = array(
			'solid'			=> $this->l('Border Solid'),
			'dotted'		=> $this->l('Border Dotted'),
			'dashed'		=> $this->l('Border Dashed'),
			'double'		=> $this->l('Border Double'),
		);
		$border_info = false;
		if (isset($_POST[$configOptions['key']])) {
			if (is_array($_POST[$configOptions['key']]))
				$border_info = $_POST[$configOptions['key']];
			else
				$border_info = explode(self::$_border_separator, $_POST[$configOptions['key']]);
		} elseif ($configOptions['obj'] && $configOptions['obj']->{$configOptions['key']}) {
			$border_info = explode(self::$_border_separator, $configOptions['obj']->{$configOptions['key']});
		} elseif (!$configOptions['obj'] && $configOptions['defaultvalue']) {
			$border_info = explode(self::$_border_separator, $configOptions['defaultvalue']);
		}
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
		    <div class="margin-form">
		    <div style="width:400px;float:left;">
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('top', $this->_coreClassName) . '</span> <input style="width:30px" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_1" name="' . $configOptions['key'] . '[]" value="' . (isset($border_info [0]) ? intval(preg_replace('#px#', '', $border_info [0])) : '') . '" /> &nbsp;<a herf="javascript:void(0);" class="fill_next_size icon" style="float:left;margin-left:3px;"></a>
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('right', $this->_coreClassName) . '</span> <input style="width:30px" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_2" name="' . $configOptions['key'] . '[]" value="' . (isset($border_info [1]) ? intval(preg_replace('#px#', '', $border_info [1])) : '') . '" /> &nbsp;
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('bottom', $this->_coreClassName) . '</span> <input style="width:30px" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_3" name="' . $configOptions['key'] . '[]" value="' . (isset($border_info [2]) ? intval(preg_replace('#px#', '', $border_info [2])) : '') . '" /> &nbsp;
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('left', $this->_coreClassName) . '</span> <input style="width:30px" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_4" name="' . $configOptions['key'] . '[]" value="' . (isset($border_info [3]) ? intval(preg_replace('#px#', '', $border_info [3])) : '') . '" />
		      <small style="float:left;padding: 2px 5px 0 10px;">(' . $this->l('px', $this->_coreClassName) . ')</small>';
		$this->_pmClear();
		$this->_html .= '<br/><span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('style', $this->_coreClassName) . '</span><div style="width:100px;float:left;">
		<select id="'.$configOptions['key'].'" name="' . $configOptions['key'] . '[]" style="width:150px;">';
			foreach ($border_style_values as $value=>$name )
				$this->_html .= '<option
				value="' . $value . '"' . (isset($border_info [4]) && $border_info [4] == $value ? ' selected="selected"' : '') . '>' . $name . '</option>';
		$this->_html .= '</select></div>';
		$this->_html .= '<span style="float:left; padding: 2px 5px 0 60px;">' . $this->l('color', $this->_coreClassName) . '</span><input size="20" type="text" name="' . $configOptions['key'] . '[]" id="' . $configOptions['key'] . '_6" class="colorPickerInput ui-corner-all ui-input-pm"  value="' . (isset($border_info [5]) ? $border_info [5] : '') . '" style="width:100px" />';
		if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
			$this->_html .= '<script type="text/javascript">
				$jqPm("#' . $configOptions['key'] . '").chosen({ disable_search: true, max_selected_options: 1, inherit_select_classes: true });</script>';
		} else {
			$this->_html .= '<script type="text/javascript">
								$jqPm("#' . $configOptions['key'] . '").selectmenu({wrapperElement: "<div class=\'ui_select_menu\' />"});</script>';
		}
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_initBindFillSizeAtEnd = true;
		$this->_initColorPickerAtEnd = true;
	}
	protected function _displayInputColor($configOptions) {
		$defaultOptions = array(
			'size' => '60px',
			'defaultvalue' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
		    <div class="margin-form">
		      <input size="20" type="text" name="' . $configOptions['key'] . '" id="' . $configOptions['key'] . '" class="colorPickerInput ui-corner-all ui-input-pm" value="' . $this->_retrieveFormValue('text', $configOptions['key'], false, $configOptions['obj'], $configOptions['defaultvalue']) . '" style="width:' . $configOptions['size'] . '" />
		    ';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_initColorPickerAtEnd = true;
	}
	protected function _displayInput4size($configOptions) {
		$defaultOptions = array(
			'defaultvalue' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		if (isset($_POST [$configOptions['key']])) {
			if (is_array($_POST [$configOptions['key']]))
				$borders_size = $_POST [$configOptions['key']];
			else
				$borders_size = explode(' ', $_POST [$configOptions['key']]);
		} elseif ($configOptions['obj'] && $configOptions['obj']->{$configOptions['key']}) {
			$borders_size = explode(' ', $configOptions['obj']->{$configOptions['key']});
		} elseif (!$configOptions['obj'] && $configOptions['defaultvalue']) {
			$borders_size = explode(' ', $configOptions['defaultvalue']);
		}
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
		    <div class="margin-form">
		      <span style="float:left; padding: 2px 5px 0 10px; ">' . $this->l('top', $this->_coreClassName) . '</span> <input size="3" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_1" name="' . $configOptions['key'] . '[]" value="' . (isset($borders_size [0]) ? intval(preg_replace('#px#', '', $borders_size [0])) : '') . '" /> &nbsp;<a herf="javascript:void(0);" class="fill_next_size icon" style="float:left;margin-left:3px;"></a>
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('right', $this->_coreClassName) . '</span> <input size="3" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_2" name="' . $configOptions['key'] . '[]" value="' . (isset($borders_size [1]) ? intval(preg_replace('#px#', '', $borders_size [1])) : '') . '" /> &nbsp;
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('bottom', $this->_coreClassName) . '</span> <input size="3" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_3" name="' . $configOptions['key'] . '[]" value="' . (isset($borders_size [2]) ? intval(preg_replace('#px#', '', $borders_size [2])) : '') . '" /> &nbsp;
		      <span style="float:left; padding: 2px 5px 0 10px;">' . $this->l('left', $this->_coreClassName) . '</span> <input size="3" type="text" class="ui-corner-all ui-input-pm ui-input-pm-size" id="' . $configOptions['key'] . '_4" name="' . $configOptions['key'] . '[]" value="' . (isset($borders_size [3]) ? intval(preg_replace('#px#', '', $borders_size [3])) : '') . '" />
		      <small style="float:left;padding: 2px 5px 0 10px;">(' . $this->l('px', $this->_coreClassName) . ')</small>';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_initBindFillSizeAtEnd = true;
	}
	protected function _displayInputFileLang($configOptions) {
		$defaultOptions = array(
			'uplodify' => true,
			'filetype' => '*.jpg;*.gif;*.png',
			'tips' => false,
			'extend' => false,
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			if (Configuration::getGlobalValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY') === false) Configuration::updateGlobalValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY', Tools::passwdGen(16));
		} else {
			if (Configuration::get('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY') === false) Configuration::updateValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY', Tools::passwdGen(16));
		}
		$isImage = false;
		if (preg_match('/jpg|jpeg|gif|bmp|png/i', $configOptions['filetype'])) $isImage = true;
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
          <div class="margin-form">';
		foreach ($this->_languages as $language) {
			$this->_html .= '<div id="lang' . $configOptions['key'] . '_' . $language ['id_lang'] . '" class="pmFlag pmFlagLang_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->_default_language ? 'block' : 'none') . '; float: left;">
          		 <div style="float:left;width:150px;">
					<input type="hidden" name="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_temp_file_lang_destination_lang" id="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_destination_lang" value="' . $configOptions['destination'] . '" />
		      		<input type="hidden" name="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_temp_file_lang" id="' . $configOptions['key'] . '_' . $language ['id_lang'] . '" value="" />
          		</div>';
			$this->_html .= '</div>';
		}
		$key_flag = $this->displayPMFlags();
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		if ($configOptions['uplodify']) {
			$this->_pmClear();
			foreach ($this->_languages as $language) {
				$this->_html .= '<div id="wrapper_preview-' . $configOptions['key'] . '_' . $language ['id_lang'] . '" class="wrapper_preview-' . $configOptions['key'] . '">';
				$this->_html .= '<div id="preview-' . $configOptions['key'] . '_' . $language ['id_lang'] . '" class="ui-state-highlight pm_preview_upload pm_preview_upload-' . $configOptions['key'] . '" style="' . ($configOptions['obj'] && isset($configOptions['obj']->{$configOptions['key']} [$language ['id_lang']]) && $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']] ? '' : 'display:none;') . '">';
				$file_location_dir = dirname(__FILE__) . $configOptions['destination'];
				if ($configOptions['obj'] && isset($configOptions['obj']->{$configOptions['key']} [$language ['id_lang']]) && $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']] && file_exists($file_location_dir . $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']])) {
					if ($isImage) {
						$this->_html .= '<img src="' . (substr($this->_path, 0, - 1) . $configOptions['destination'] . $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']]) . '" id="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_file" />';
					} else {
						$this->_html .= '<a href="' . (substr($this->_path, 0, - 1) . $configOptions['destination'] . $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']]) . '" target="_blank" class="pm_view_file_upload_link" id="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_file">' . $this->l('View file', $this->_coreClassName) . '</a>';
					}
				}
				$this->_html .= '<br /><span>' . $this->l('Delete this file', $this->_coreClassName) . '</span><input type="checkbox" name="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_unlink_lang" value="1" onclick="$jqPm(\'#preview-' . $configOptions['key'] . '_' . $language ['id_lang'] . '\').slideUp(\'fast\')"  /><input type="hidden" name="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_old_file_lang" id="' . $configOptions['key'] . '_' . $language ['id_lang'] . '_old_file" value="' . ($configOptions['obj'] && isset($configOptions['obj']->{$configOptions['key']} [$language ['id_lang']]) && $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']] ? $configOptions['obj']->{$configOptions['key']} [$language ['id_lang']] : '') . '" />';
				if ($configOptions['extend'])
					$this->_html .= '
					<div class="PM_CORE_CP">
						<small>'.$this->l('Apply to all languages without picture', $this->_coreClassName).'</small>&nbsp;<input type="checkbox" value=1 name="'.$configOptions['key'] .'_all_lang">
					</div>';
				$this->_html .= '</div>';
				$this->_html .= '</div>';
				$this->_html .= '<script type="text/javascript">
				  $jqPm("#' . $configOptions['key'] . '_' . $language ['id_lang'] . '").uploadify({
				    "uploader"  : "' . $this->_path . 'js/uploadify/uploadify.swf",
					"script"    : "' . $this->_path . 'js/uploadify/uploadify.php?secureKey='.urlencode('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY'.'---'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Configuration::getGlobalValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY') : Configuration::get('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY'))).'",
				    "cancelImg" : "' . $this->_path . 'js/uploadify/cancel.png",
				    "folder"    : "uploads/temp",
				    "auto"      : true,
	  				"buttonText"  : "' . $this->l('Choose file') . '",
				  	"onComplete"  : function(event, ID, fileObj, response, data) {
				  		$jqPm("#' . $configOptions['key'] . '_' . $language ['id_lang'] . '").uploadifySettings("scriptData" , {"filename":response});
				  		$jqPm("#' . $configOptions['key'] . '_' . $language ['id_lang'] . '").val(response);
				  		$jqPm("#' . $configOptions['key'] . '_' . $language ['id_lang'] . '_file").remove();
				  		' . ($isImage ? '$jqPm("#preview-' . $configOptions['key'] . '_' . $language ['id_lang'] . '").prepend("<img src=\'"+_modulePath+"uploads/temp/"+response+"\' id=\'' . $configOptions['key'] . '_' . $language ['id_lang'] . '_file\' />");' : '$jqPm("#preview-' . $configOptions['key'] . '_' . $language ['id_lang'] . '").prepend("<a href=\'"+_modulePath+"uploads/temp/"+response+"\' target=\'_blank\' class=\'pm_view_file_upload_link\' id=\'' . $configOptions['key'] . '_' . $language ['id_lang'] . '_file\'>' . $this->l('View file', $this->_coreClassName) . '</a>");') . '
						$jqPm("input[name=' . $configOptions['key'] . '_' . $language ['id_lang'] . '_unlink_lang]").attr("checked","").removeAttr("checked");
						$jqPm("#preview-' . $configOptions['key'] . '_' . $language ['id_lang'] . '").slideDown("fast");
				  	}
				 });
				</script>';
			}
			if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
				$this->_html .= '<script type="text/javascript">
					 $jqPm("#'.$key_flag.'").bind("change",function() {
						var currentIdLang = $jqPm("#'.$key_flag.' option:selected").val();
						$jqPm(".wrapper_preview-' . $configOptions['key'] . '").hide();
						$jqPm("#wrapper_preview-' . $configOptions['key'] . '_"+currentIdLang).show();
						if (currentIdLang =='.Configuration::get('PS_LANG_DEFAULT').' )
							$jqPm(".PM_CORE_CP").show("medium");
						else
							$jqPm(".PM_CORE_CP").hide("medium");
					 });
					 $jqPm("#'.$key_flag.'").trigger("change");
				</script>';
			} else {
				$this->_html .= '<script type="text/javascript">
					 $jqPm("#'.$key_flag.'-menu li a").unbind("mouseup").bind("mouseup",function() {
						 setTimeout(function() {
							var currentIdLang = $jqPm("#'.$key_flag.' option:selected").val();
							$jqPm(".wrapper_preview-' . $configOptions['key'] . '").hide();
							$jqPm("#wrapper_preview-' . $configOptions['key'] . '_"+currentIdLang).show();
							if (currentIdLang =='.Configuration::get('PS_LANG_DEFAULT').' )
								$jqPm(".PM_CORE_CP").show("medium");
							else
								$jqPm(".PM_CORE_CP").hide("medium");
						},100);
					 });
					 $jqPm("#'.$key_flag.'-menu li.ui-selectmenu-item-selected a").trigger("mouseup");
				</script>';
			}
		}
		$this->_pmClear();
		$this->_html .= '</div>';
	}
	protected function _displayInputSlider($configOptions) {
		$defaultOptions = array(
			'minvalue' => 0,
			'maxvalue' => 100,
			'suffix' => '%',
			'size' => '250px',
			'defaultvalue' => 0,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
		    <div class="margin-form">
		      <div id="slider-' . $configOptions['key'] . '" style="width:' . $configOptions['size'] . ';float:left;"></div><span id="slide_value_' . $configOptions['key'] . '" style="float:left;padding-left:10px">' . $this->_retrieveFormValue('text', $configOptions['key'], false, $configOptions['obj'], $configOptions['defaultvalue']) . '' . $configOptions['suffix'] . '</span>
		      <input size="20" type="hidden" name="' . $configOptions['key'] . '" id="' . $configOptions['key'] . '" class="sliderPicker" value="' . $this->_retrieveFormValue('text', $configOptions['key'], false, $configOptions['obj'], $configOptions['defaultvalue']) . '" size="20" />';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_html_at_end .= '<script type="text/javascript">
				    $jqPm(function() {
				      $jqPm( "#slider-' . $configOptions['key'] . '" ).slider({
				        range: "min",
				        value: ' . (int) $this->_retrieveFormValue('text', $configOptions['key'], false, $configOptions['obj'], $configOptions['defaultvalue']) . ',
				        min: ' . (int) $configOptions['minvalue'] . ',
				        max: ' . (int) $configOptions['maxvalue'] . ',
				        slide: function( event, ui) {
				          $jqPm("input[name=' . $configOptions['key'] . ']").val(ui.value );
				          $jqPm("#slide_value_' . $configOptions['key'] . '").html(ui.value+" ' . $configOptions['suffix'] . '");
				        }
				      });
				    });
				    </script>';
	}
	private function _parseOptions($defaultOptions = array(), $options = array()) {
		if (self::_isFilledArray($options)) $options = array_change_key_case($options, CASE_LOWER);
		if (isset($options['tips']) && !empty($options['tips'])) $options['tips'] = htmlentities($options['tips'], ENT_QUOTES, 'UTF-8');
		if (self::_isFilledArray($defaultOptions)) {
			$defaultOptions = array_change_key_case($defaultOptions, CASE_LOWER);
			foreach ($defaultOptions as $option_name=>$option_value)
				if (!isset($options[$option_name])) $options[$option_name] = $defaultOptions[$option_name];
		}
		return $options;
	}
	protected function _displayInputText($configOptions) {
		$defaultOptions = array(
			'type' => 'text',
			'size' => '150px',
			'defaultvalue' => false,
			'min' => false,
			'max' => false,
			'maxlength' => false,
			'onkeyup' => false,
			'onchange' => false,
			'required' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
		    <div class="margin-form">
		      <input style="width:' . $configOptions['size'] . '" type="'. $configOptions['type'] .'" name="' . $configOptions['key'] . '" id="' . $configOptions['key'] . '" value="' . $this->_retrieveFormValue('text', $configOptions['key'], false, $configOptions['obj'], $configOptions['defaultvalue']) . '" class="ui-corner-all ui-input-pm" '.(($configOptions['required'] == true) ? 'required="required" ' : '') . ($configOptions['onkeyup'] ? ' onkeyup="' . $configOptions['onkeyup'] . '"' : '') . ($configOptions['onchange'] ? ' onchange="' . $configOptions['onchange'] . '"' : '') . (($configOptions['min'] != false) ? 'min="'.(int)$configOptions['min'].'" ' : '').(($configOptions['max'] != false) ? 'max="'.(int)$configOptions['max'].'" ' : '').(($configOptions['maxlength'] != false) ? 'maxlength="'.(int)$configOptions['maxlength'].'" ' : '').'/>';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
	}
	protected function _displayInputTextLang($configOptions) {
		$defaultOptions = array(
			'size' => '150px',
			'min' => false,
			'max' => false,
			'maxlength' => false,
			'onkeyup' => false,
			'onchange' => false,
			'required' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
             <div class="margin-form">';
		foreach ($this->_languages as $language) {
			$this->_html .= '
		        <div id="lang' . $configOptions['key'] . '_' . $language ['id_lang'] . '" class="pmFlag pmFlagLang_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->_default_language ? 'block' : 'none') . '; float: left;">
		          <input style="width:' . $configOptions['size'] . ';" type="text" id="' . $configOptions['key'] . '_' . $language ['id_lang'] . '" name="' . $configOptions['key'] . '_' . $language ['id_lang'] . '" value="' . $this->_retrieveFormValue('text', $configOptions['key'] . '_' . $language ['id_lang'], $configOptions['key'], $configOptions['obj'], false, false, $language ['id_lang']) . '"' . ($configOptions['onkeyup'] ? ' onkeyup="' . $configOptions['onkeyup'] . '"' : '') . ($configOptions['onchange'] ? ' onchange="' . $configOptions['onchange'] . '"' : '') . (($configOptions['required'] == true && $language['id_lang'] == $this->_default_language) ? ' required="required" ' : '') . (($configOptions['min'] != false && $language['id_lang'] == $this->_default_language) ? 'min="'.(int)$configOptions['min'].'" ' : '').(($configOptions['max'] != false && $language['id_lang'] == $this->_default_language) ? 'max="'.(int)$configOptions['max'].'" ' : '').(($configOptions['maxlength'] != false && $language['id_lang'] == $this->_default_language) ? 'maxlength="'.(int)$configOptions['maxlength'].'" ' : '') . ' class="ui-corner-all ui-input-pm" />
		        </div>';
		}
		$this->displayPMFlags();
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
	}
	protected function _displayRichTextareaLang($configOptions) {
		$defaultOptions = array(
			'size' => '100%',
			'min' => false,
			'max' => false,
			'maxlength' => false,
			'onkeyup' => false,
			'onchange' => false,
			'required' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
             <div class="margin-form">';
		foreach ($this->_languages as $language) {
			$this->_html .= '
        <div id="lang' . $configOptions['key'] . '_' . $language ['id_lang'] . '" class="pmFlag pmFlagLang_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->_default_language ? '' : 'none') . '; float: left;">
          <textarea class="rte" style="width:' . $configOptions['size'] . ';" rows="20" name="' . $configOptions['key'] . '_' . $language ['id_lang'] . '">' . $this->_retrieveFormValue('text', $configOptions['key'] . '_' . $language ['id_lang'], $configOptions['key'], $configOptions['obj'], false, false, $language ['id_lang']) . '</textarea>
        </div>';
		}
		$this->displayPMFlags('tinyMceFlags');
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_initTinyMceAtEnd = true;
	}
	protected function _displaySelect($configOptions) {
		$defaultOptions = array(
			'size' => '200px',
			'defaultvalue' => false,
			'options' => array(),
			'onchange' => false,
			'tips' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		if ($configOptions['label']) {
			$this->_html .= '<label>' . $configOptions['label'] . '</label>
			    <div class="margin-form pm_displaySelect">';
		}
		$this->_html .= '<select id="' . $configOptions['key'] . '" name="' . $configOptions['key'] . '" style="width:' . $configOptions['size'] . '">';
		if ($configOptions['defaultvalue'])
			 $this->_html .= '<option value="0">' . $configOptions['defaultvalue'] . '</option>';
		foreach ($configOptions['options'] as $value => $text_value) {
			$this->_html .= '<option value="' . ($value) . '" ' . $this->_retrieveFormValue('select', $configOptions['key'], false, $configOptions['obj'], '0', $value) . ' '.(isset($configOptions['class']) && self::_isFilledArray($configOptions['class']) && isset($configOptions['class'][$value]) ? 'class="' . $configOptions['class'][$value] . '"':'').'>' . $text_value . '</option>';
		}
		$this->_html .= '</select>';
		if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
			$this->_html .= '<script type="text/javascript">
				$jqPm("#' . $configOptions['key'] . '").chosen({ disable_search: true, max_selected_options: 1, inherit_select_classes: true });';
		} else {
			$this->_html .= '<script type="text/javascript">
								$jqPm("#' . $configOptions['key'] . '").selectmenu({wrapperElement: "<div class=\'ui_select_menu\' />"});';
		}
		if ($configOptions['onchange']) {
			$this->_html .= '$jqPm("#' . $configOptions['key'] . '").unbind("change").bind("change",function() { ' . $configOptions['onchange'] . ' });';
		}
		$this->_html .= '</script>';
		if (isset($configOptions['tips']) && $configOptions['tips']) {
			$this->_html .= '<img title="' . $configOptions['tips'] . '" id="' . $configOptions['key'] . '-tips" class="pm_tips" src="' . $this->_path . 'img/question.png" width="16px" height="16px" />';
			$this->_html .= '<script type="text/javascript">initTips("#' . $configOptions['key'] . '")</script>';
		}
		$this->_pmClear();
		if ($configOptions['label'])
			$this->_html .= '</div>';
	}
	protected function _displayCategoryTree($configOptions) {
		$defaultOptions = array(
			'input_name' => 'categoryBox',
			'selected_cat' => array(0),
			'use_radio' => false,
			'category_root_id' =>  (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Category::getRootCategory()->id : 1)
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		$selectedCat = $this->getCategoryInformations(Tools::getValue('categoryBox', $configOptions['selected_cat']), $this->_default_language, $configOptions['input_name'], $configOptions['use_radio']);
		$this->_html .= '<div class="category-tree-table-container">';
		$this->_html .= '<label>' . $configOptions['label'] . '</label>
					<div class="margin-form">';
		$this->_html .= '<script type="text/javascript">
							var post_selected_cat;
							post_selected_cat = \'' . implode(',', array_keys($selectedCat)) . '\';
						</script>
						<div class="category-tree-table">
							<table cellpadding="5">
								<tr id="tr_categories">
									<td colspan="2">
						';
		$trads = array ('selected' => $this->l('selected', $this->_coreClassName), 'Collapse All' => $this->l('Collapse All', $this->_coreClassName), 'Expand All' => $this->l('Expand All', $this->_coreClassName), 'Check All' => $this->l('Check All', $this->_coreClassName), 'Uncheck All' => $this->l('Uncheck All', $this->_coreClassName) );
		$this->_html .= $this->_renderAdminCategorieTree($trads, $selectedCat, $configOptions['input_name'], $configOptions['use_radio'], $configOptions['category_root_id']) . '
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding-bottom:5px;"><hr style="width:100%;" /></td>
								</tr>
							</table>
						</div>
					</div>
				</div>';
		$this->_pmClear();
	}
	private static function getCategoryInformations($ids_category, $id_lang = null) {
		if ($id_lang === null) $id_lang = $this->_default_language;
		if (!self::_isFilledArray($ids_category)) return;
		$categories = array();
		if (isset($ids_category[0]['id_category'])) {
			$ids_category_tmp = array();
			foreach ($ids_category as $cat) $ids_category_tmp[] = $cat['id_category'];
			$ids_category = $ids_category_tmp;
		} else if (is_object($ids_category[0]) && isset($ids_category[0]->id_category)) {
			$ids_category_tmp = array();
			foreach ($ids_category as $cat) $ids_category_tmp[] = $cat->id_category;
			$ids_category = $ids_category_tmp;
		}
		$results = Db::getInstance()->ExecuteS('
			SELECT c.`id_category`, cl.`name`, cl.`link_rewrite`, cl.`id_lang`
			FROM `'._DB_PREFIX_.'category` c
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category`'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlRestrictionOnLang('cl'):'').')
			WHERE cl.`id_lang` = '.(int)$id_lang.'
			AND c.`id_category` IN ('.implode(',', array_map('intval', $ids_category)).')
		');
		foreach($results as $category) $categories[$category['id_category']] = $category;
		return $categories;
	}
	private function _renderAdminCategorieTree($trads, $selected_cat = array(), $input_name = 'categoryBox', $use_radio = false, $category_root_id = 1){
		if (!$use_radio) $input_name = $input_name.'[]';
		$html = '';
		$root_is_selected = false;
		foreach($selected_cat AS $cat){
			if (self::_isFilledArray($cat)) {
				if ($cat['id_category'] != $category_root_id) $html .= '<input type="hidden" name="'.$input_name.'" value="'.$cat['id_category'].'" >';
				elseif ($cat['id_category'] == $category_root_id) $root_is_selected = true;
			} else {
				if ($cat != $category_root_id) $html .= '<input type="hidden" name="'.$input_name.'" value="'.$cat.'" >';
				else $root_is_selected = true;
			}
		}
		$root_category = new Category($category_root_id, $this->_default_language);
		$root_category_name = $root_category->name;
		$html .= '<script src="'.$this->_path.'js/treeview/jquery.treeview.js" type="text/javascript"></script>
				 <script src="'.$this->_path.'js/treeview/jquery.treeview.async.js" type="text/javascript"></script>
				 <script src="'.$this->_path.'js/treeview/jquery.treeview.edit.js" type="text/javascript"></script>
				 <script src="'.$this->_path.'js/admin-categories-tree.js" type="text/javascript"></script>
				 <script type="text/javascript">
					var inputName = "'.$input_name.'";';
		if (self::_isFilledArray($selected_cat)){
			if (isset($selected_cat[0]))
				$html .= 'var selectedCat = "'.implode(',', $selected_cat).'";';
			else
				$html .= 'var selectedCat = "'.implode(',', array_keys($selected_cat)).'";';
		}
		else
			$html .= 'var selectedCat = "";';
		$html .= '	var selectedLabel = \''.$trads['selected'].'\';
					var home = \''.addcslashes($root_category_name, "'").'\';
					var use_radio = '.(int)$use_radio.';
					var category_root_id = '.(int)$category_root_id.';
				</script>
				<link type="text/css" rel="stylesheet" href="'.$this->_path.'css/jquery.treeview.css" />';
		$html .= '<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
					<a rel="'. $input_name .'" href="#" id="collapse_all" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all" style="padding:3px;">'.$trads['Collapse All'].'</a> &nbsp;
					<a rel="'. $input_name .'" href="#" id="expand_all" class="ui-button ui-widget ui-state-default ui-button-text-only  ui-corner-all" style="padding:3px;">'.$trads['Expand All'].'</a> &nbsp;
					'.(!$use_radio ? '- <a href="#" rel="'. $input_name .'" id="check_all" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all" style="padding:3px;">'.$trads['Check All'].'</a> &nbsp;
					<a href="#" rel="'. $input_name .'" id="uncheck_all" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all" style="padding:3px;">'.$trads['Uncheck All'].'</a>' : '').'
				</div>';
		$html .= '<ul id="categories-treeview" class="filetree">';
		$html .= '<li id="'.(int)$category_root_id.'" class="hasChildren">';
		$html .= '<span class="folder"><input type="'.(!$use_radio ? 'checkbox' : 'radio').'" name="'.$input_name.'" value="'.$category_root_id.'" '.($root_is_selected ? 'checked' : '').' onclick="clickOnCategoryBox($jqPm(this));" /> '.$root_category_name.'</span>';
		$html .= '<ul>
						<li><span class="placeholder">&nbsp;</span></li>
				  </ul>
				</li>
			</ul>';
		return $html;
	}
	protected function _uploadImageLang(&$obj, $key, $path, $add_to_filename = false) {
		$ext = false;
		$update = false;
		$errors = array();
		foreach ($this->_languages as $language) {
			$file = false;
			if (isset($_POST ['unlink_' . $key . '_' . $language ['id_lang']]) and $_POST ['unlink_' . $key . '_' . $language ['id_lang']] and isset($obj->{$key} [$language ['id_lang']]) and $obj->{$key} [$language ['id_lang']]) {
				@unlink(_PS_ROOT_DIR_ . $path . $obj->{$key} [$language ['id_lang']]);
				$obj->{$key} [$language ['id_lang']] = '';
				$update = true;
			}
			else {
				if (isset($_FILES [$key . '_' . $language ['id_lang']] ['tmp_name']) and $_FILES [$key . '_' . $language ['id_lang']] ['tmp_name'] != NULL) {
					$file = $_FILES [$key . '_' . $language ['id_lang']];
				}
				elseif ((! isset($obj->{$key} [$language ['id_lang']]) || (isset($obj->{$key} [$language ['id_lang']]) && !$obj->{$key} [$language ['id_lang']])) && isset($_FILES [$key . '_' . $this->_default_language] ['tmp_name']) and $_FILES [$key . '_' . $this->_default_language] ['tmp_name'] != NULL) {
					$file = $_FILES [$key . '_' . $this->_default_language];
				}
				if ($file) {
					if (!is_dir(_PS_ROOT_DIR_ . $path))
						mkdir(_PS_ROOT_DIR_ . $path, 0777, true);
					if (!is_dir(_PS_ROOT_DIR_ . $path . $language ['iso_code'] . '/'))
						mkdir(_PS_ROOT_DIR_ . $path . $language ['iso_code'] . '/', 0777, true);
					$ext = $this->getFileExtension($file ['name']);
					if (isset($obj->{$key} [$language ['id_lang']]) && $obj->{$key} [$language ['id_lang']]) {
						@unlink(_PS_ROOT_DIR_ . $path . $obj->{$key} [$language ['id_lang']]);
					}
					if (!in_array($ext, $this->allowFileExtension) || ! getimagesize($file ['tmp_name']) || ! copy($file ['tmp_name'], _PS_ROOT_DIR_ . $path . $language ['iso_code'] . '/' . $obj->id . ($add_to_filename ? $add_to_filename : '') . '.' . $ext))
						$errors [] = Tools::displayError('An error occured during the image upload');
					if (!sizeof($errors)) {
						$obj->{$key} [$language ['id_lang']] = $language ['iso_code'] . '/' . $obj->id . ($add_to_filename ? $add_to_filename : '') . '.' . $ext;
						$update = true;
					}
				}
			}
		}
		if (sizeof($errors)) return $errors;
		return $update;
	}
	protected function _getBorderSizeFromArray($borderArray) {
		if (!is_array($borderArray)) return $borderArray;
		$borderStr = '';
		$borderCountEmpty = 0;
		foreach ($borderArray as $key=>$border) {
			if ($border === '') $borderCountEmpty++;
			if ($key <= 3) $borderStr .= $border . 'px ';
			else $borderStr .= $border.' ';
		}
		return ($borderCountEmpty < count($borderArray) ? substr($borderStr, 0, - 1) : 0);
	}
	protected function _getShadowFromArray($array) {
		if (!is_array($array)) return $array;
		$shadowStr = '';
		$shadowCountEmpty = 0;
		foreach ($array as $key=>$value) {
			if ($value === '') $shadowCountEmpty++;
			if (preg_match('/\#/', $value) || !is_numeric($value)) $shadowStr .= $value.' ';
			else $shadowStr .= $value . 'px ';
		}
		return ($shadowCountEmpty < count($array) ? substr($shadowStr, 0, - 1) : 0);
	}
	protected function _getGradientFromArray($key) {
		if (is_array($_POST [$key]))
			return $_POST[$key] [0] . (Tools::getValue($key . '_gradient') && isset($_POST[$key] [1]) && $_POST[$key] [1] ? self::$_gradient_separator . $_POST[$key] [1] : '');
		else
			return $_POST[$key];
	}
	private static function getAllSubCategories($id_cat, $id_lang, $all_sub_categories = array()) {
		$category = new Category((int)$id_cat);
		$sub_cats = $category->getSubcategories($id_lang);
		if (count($sub_cats) > 0)
			foreach ($sub_cats AS $sub_cat) {
				$all_sub_categories[] = $sub_cat['id_category'];
				self::getAllSubCategories($sub_cat['id_category'], $id_lang, $all_sub_categories);
			}
		return $all_sub_categories;
	}
	public static function getChildrenWithNbSelectedSubCat($id_parent, $selectedCat, $id_lang) {
		$selectedCat = explode(',', str_replace(' ', '', $selectedCat));
		if (!is_array($selectedCat)) $selectedCat = array();
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) {
			return Db::getInstance()->ExecuteS('
					SELECT c.`id_category`, c.`level_depth`, cl.`name`, IF((
					SELECT COUNT(*)
					FROM `'._DB_PREFIX_.'category` c2
					WHERE c2.`id_parent` = c.`id_category`
			) > 0, 1, 0) AS has_children, '.($selectedCat ? '(
					SELECT count(c3.`id_category`)
					FROM `'._DB_PREFIX_.'category` c3
					WHERE c3.`nleft` > c.`nleft`
					AND c3.`nright` < c.`nright`
					AND c3.`id_category`  IN ('.implode(',', array_map('intval', $selectedCat)).')
			)' : '0').' AS nbSelectedSubCat
					FROM `'._DB_PREFIX_.'category` c
					LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category`'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlRestrictionOnLang('cl'):'').')
					WHERE `id_lang` = '.(int)($id_lang).'
					AND c.`id_parent` = '.(int)($id_parent).'
					ORDER BY `position` ASC');
		} else {
			$homecat = new Category((int)$id_parent, (int)$id_lang);
			$categories = $homecat->recurseLiteCategTree();
			$categories_table = array();
			if (self::_isFilledArray($categories)) {
				foreach ($categories['children'] as $categorie) {
					$categorie_obj = new Category((int)$categorie['id'], (int)$id_lang);
					$all_sub_categories = self::getAllSubCategories((int)$categorie['id'], (int)$id_lang);
					$categories_table[] = array(
						'id_category' => $categorie['id'],
						'level_depth' => $categorie_obj->level_depth,
						'name' => $categorie['name'],
						'has_children' => (int)(is_array($categorie['children']) && sizeof($categorie['children'])),
						'nbSelectedSubCat' => sizeof(array_intersect($selectedCat, array_values($all_sub_categories)))
					);
				}
			}
			return $categories_table;
		}
	}
	protected function _loadCssJsLibrary($library, $rememberLoadedLibrary = true) {
		if (in_array($library, $this->_css_js_lib_loaded))
			return;
		switch ($library) {
			case 'admincore' :
				$this->_html .= '<link type="text/css" rel="stylesheet" href="' . $this->_path . 'css/adminCore.css" />
	        					 <script type="text/javascript" src="' . $this->_path . 'js/adminCore.js"></script>';
				$this->_html .= '<script type="text/javascript">
					var _modulePath = "' . $this->_path . '";
					var _base_config_url = "' . $this->_base_config_url . '";
					var _id_employee = ' . ( int ) $this->_cookie->id_employee . ';
					var id_language = Number(' . $this->_default_language . ');
				</script>';
				break;
			case 'adminmodule' :
				if (file_exists(dirname(__FILE__) . '/css/admin.css'))
					$this->_html .= '<link type="text/css" rel="stylesheet" href="' . $this->_path . 'css/admin.css" />';
				if (file_exists(dirname(__FILE__) . '/js/admin.js'))
					$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/admin.js"></script>';
				break;
			case 'jquery' :
					if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
						$this->context->controller->addJqueryUI(array('ui.draggable', 'ui.droppable', 'ui.sortable', 'ui.widget', 'ui.dialog', 'ui.tabs', 'ui.progressbar'), 'base');
					} else {
						if (version_compare(_PS_VERSION_, '1.5.0.0', '<'))
							$this->_html .= '<script type="text/javascript" src="'.$this->_path . 'js/jquery.min.js"></script>';
						$this->_html .= ' <link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/jqueryui/1.8.9/themes/custom-theme/jquery-ui-1.8.16.custom.css" />
							<script type="text/javascript" src="'.$this->_path . 'js/jquery-ui-1.8.11.min.js"></script>';
					}
					$this->_html .= '<script type="text/javascript">';
					if (version_compare(_PS_VERSION_, '1.5.0.0', '<'))
						$this->_html .= 'var $jqPm = jQuery.noConflict(true);';
					else
						$this->_html .= 'var $jqPm = jQuery;';
					$this->_html .= '</script>';
			break;
			case 'jquerytools':
				$this->_html .= '<script type="text/javascript" src="'.$this->_path . 'js/jquery.tools.min.js"></script>';
				break;
			case 'jquerytiptip':
				$this->_html .= '<script type="text/javascript" src="'.$this->_path . 'js/jquery.tipTip.js"></script>';
				break;
			case 'jgrowl' :
				$this->_html .= '<link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/jGrowl/jquery.jgrowl.css" />
		    					 <script type="text/javascript" src="' . $this->_path . 'js/jGrowl/jquery.jgrowl_minimized.js"></script>';
				break;
			case 'multiselect' :
				$this->_html .= '<link rel="stylesheet" href="' . $this->_path . 'js/multiselect/ui.multiselect.css" type="text/css" />
								 <script type="text/javascript" src="' . $this->_path . 'js/multiselect/jquery.tmpl.1.1.1.js"></script>
								 <script type="text/javascript" src="' . $this->_path . 'js/multiselect/jquery.blockUI.js"></script>
								 <script type="text/javascript" src="' . $this->_path . 'js/multiselect/ui.multiselect.js"></script>';
				break;
			case 'colorpicker' :
				$this->_html .= '<link rel="stylesheet" href="' . $this->_path . 'js/colorpicker/css/colorpicker.css" type="text/css" />
								<script type="text/javascript" src="' . $this->_path . 'js/colorpicker/js/colorpicker.js"></script>';
				break;
			case 'codemirrorcore' :
				$this->_html .= '<script src="' . $this->_path . 'js/codemirror/codemirror.js" type="text/javascript"></script>
							    <link rel="stylesheet" href="' . $this->_path . 'js/codemirror/codemirror.css" type="text/css" />
							    <link rel="stylesheet" href="' . $this->_path . 'js/codemirror/default.css" type="text/css" />';
				break;
			case 'codemirrorcss' :
				$this->_html .= '<script src="' . $this->_path . 'js/codemirror/css.js" type="text/javascript"></script>';
				break;
			case 'codemirrorjavascript' :
				$this->_html .= '<script src="' . $this->_path . 'js/codemirror/javascript.js" type="text/javascript"></script>';
				break;
			case 'codemirrormixed' :
				$this->_html .= '<script src="' . $this->_path . 'js/codemirror/xml.js" type="text/javascript"></script><script src="' . $this->_path . 'js/codemirror/css.js" type="text/javascript"></script><script src="' . $this->_path . 'js/codemirror/javascript.js" type="text/javascript"></script><script src="' . $this->_path . 'js/codemirror/htmlmixed.js" type="text/javascript"></script>';
				break;
			case 'datatables' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/datatables/jquery.dataTables.min.js"></script>
		  						<link rel="stylesheet" href="' . $this->_path . 'js/datatables/demo_table_jui.css" type="text/css" />';
				break;
			case 'jeditable' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/jquery.jeditable.mini.js"></script>';
				break;
			case 'tiny_mce' :
				if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
					$this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/admin/tinymce.inc.js"></script>';
					$this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js"></script>';
				} else if (version_compare(_PS_VERSION_, '1.4.1.0', '>=')) {
					$this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js"></script>';
				} else {
					$this->_html .= '<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
				}
				break;
			case 'selectmenu' :
				if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
					$this->context->controller->addJqueryPlugin('chosen');
				} else {
					$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/ui.selectmenu.js"></script>';
				}
				break;
			case 'scrolltofixed' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/scrollToFixed/jquery.scrollToFixed.min.js"></script>
								 <script type="text/javascript" src="' . $this->_path . 'js/scrollTo.js"></script>';
				break;
			case 'uploadify' :
				$this->_html .= '<link rel="stylesheet" href="' . $this->_path . 'js/uploadify/uploadify.css" type="text/css" />';
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/uploadify/swfobject.js"></script>';
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>';
				break;
			case 'autocomplete' :
				if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
					$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/jquery.autocomplete.js"></script>
									 <link rel="stylesheet" type="text/css" href="' . __PS_BASE_URI__. 'js/jquery/plugins/autocomplete/jquery.autocomplete.css" />';
				}else {
					$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/jquery.autocomplete.js"></script>
									 <link rel="stylesheet" type="text/css" href="' . __PS_BASE_URI__ . 'css/jquery.autocomplete.css" />';
				}
				break;
			case 'form' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/jquery.form.js"></script>';
				break;
			case 'collision' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/jquerycollision/jquery.collision.js"></script>';
				break;
			case 'qtip' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/qtip/jquery.qtip.min.js"></script>';
				$this->_html .= '<link rel="stylesheet" href="' . $this->_path . 'js/qtip/jquery.qtip.min.css" type="text/css" />';
			break;
			case 'switchbutton' :
				$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/jquery.switchbutton.min.js"></script>';
				$this->_html .= '<link rel="stylesheet" href="' . $this->_path . 'css/ui.switchbutton.css" type="text/css" />';
			break;
		}
		if ($rememberLoadedLibrary)
			$this->_css_js_lib_loaded [] = $library;
	}
	protected function _loadCssJsLibraries($rememberLoadedLibrary = true) {
		if (self::_isFilledArray($this->_css_js_to_load)) {
			foreach ($this->_css_js_to_load as $library) {
				$this->_loadCssJsLibrary($library, $rememberLoadedLibrary);
			}
		}
	}
	private function _includeHTMLAtEnd() {
		if ($this->_initTinyMceAtEnd) $this->_initTinyMce();
		if ($this->_initColorPickerAtEnd) $this->_initColorPicker();
		if ($this->_initBindFillSizeAtEnd) $this->_initBindFillSize();
		$this->_html .= '<script type="text/javascript">$jqPm(\'.hideAfterLoad\').hide();</script>';
		$this->_html .= $this->_html_at_end;
	}
	protected function _addButton($configOptions) {
		$defaultOptions = array(
			'text' => '',
			'href' => '',
			'title' => '',
			'onclick' => false,
			'icon_class' => false,
			'class' => false,
			'rel' => false,
			'target' => false,
			'id' => false
		);
		$configOptions = $this->_parseOptions($defaultOptions, $configOptions);
		if (!$configOptions['id'])
			$curId = 'button_' . uniqid();
		else $curId = $configOptions['id'];
		$this->_html .= '<a href="' . htmlentities($configOptions['href'], ENT_COMPAT, 'UTF-8') . '" title="' . htmlentities($configOptions['title'], ENT_COMPAT, 'UTF-8') . '" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' . ($configOptions['class'] ? ' ' . htmlentities($configOptions['class'], ENT_COMPAT, 'UTF-8') . '' : '') . '" id="' . $curId . '" ' . ($configOptions['text'] ? 'style="padding-right:5px;"' : '') . ' ' . ($configOptions['rel'] ? 'rel="' . $configOptions['rel'] . '"' : '')  . ($configOptions['target'] ? ' target="' . $configOptions['target'] . '"' : '') . '>
		' . ($configOptions['icon_class'] ? '<span class="' . htmlentities($configOptions['icon_class'], ENT_COMPAT, 'UTF-8') . '" style="float: left; margin-right: .3em;"></span>' : '') . '
		' . $configOptions['text'] . '
		</a>';
		if ($configOptions['onclick']) $this->_html .= '<script type="text/javascript">$jqPm("#' . $curId . '").unbind("click").bind("click", function() { ' . $configOptions['onclick'] . ' });</script>';
	}
	protected function _displaySubmit($value, $name) {
		$this->_pmClear();
		$this->_html .= '<center><input type="submit" value="' . $value . '" name="' . $name . '" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" /></center><br />';
	}
	protected function _headerIframe() {
		if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
			$assets = array();
			$backupHtml = $this->_html;
			$this->_loadCssJsLibraries(false);
			foreach ($this->context->controller->css_files as $cssUri=>$media)
				if (!preg_match('/gamification/i', $cssUri))
					$assets[] = '<link href="'.$cssUri.'" rel="stylesheet" type="text/css" media="'.$media.'" />';
			foreach ($this->context->controller->js_files as $jsUri)
				if (!preg_match('#gamification|notifications\.js|help\.js#i', $jsUri))
					$assets[] = '<script type="text/javascript" src="'.$jsUri.'"></script>';
			$assets[] = '<script type="text/javascript">$jqPm = jQuery;</script>';
			$this->_html = $backupHtml;
		}
		$this->_html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="' . $this->_iso_lang . '" lang="' . $this->_iso_lang . '">
	      <head>
	        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	        <title>PrestaShop</title>
	        '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && version_compare(_PS_VERSION_, '1.6', '<') ? '<script type="text/javascript" src="'.$this->_path . 'js/jquery.min.js"></script>' : '').'
	        '.(version_compare(_PS_VERSION_, '1.6.0.0', '>=') ? implode('', $assets) : '').'
	      </head>
	      <body style="background:#fff;" class="pm_bo_ps_'.substr(str_replace('.', '', _PS_VERSION_), 0, 2).'">';
		$this->_loadCssJsLibraries();
	}
	protected function _footerIframe() {
		$this->_html .= '<iframe name="dialogIframePostForm" id="dialogIframePostForm" frameborder="0" marginheight="0" marginwidth="0" width="' . ($this->_debug_mode ? '500' : '0') . '" height="' . ($this->_debug_mode ? '500' : '0') . '"></iframe>';
		$this->_includeHTMLAtEnd();
		$this->_html .= '</body></html>';
	}
	protected function _initDataTable($id_table, $returnHTML = false, $returnAsScript = false) {
		$return = '';
		if (!$returnAsScript)
			$return .= '<script type="text/javascript">
		 		var oTable' . $id_table . ' = undefined;
		 		$jqPm(document).ready(function(){';
		$return .= 'oTable' . $id_table . ' = $jqPm(\'#' . $id_table . '\').dataTable( {
				        "sDom": \'R<"H"lfr>t<"F"ip<\',
				        "bJQueryUI": true,
				        "bStateSave": true,
				        "sPaginationType": "full_numbers",
				        "bDestory": true,
				        "oLanguage": {
				          "sLengthMenu": "' . $this->l('Display', $this->_coreClassName) . ' _MENU_ ' . $this->l('records per page', $this->_coreClassName) . '",
				          "sZeroRecords": "' . $this->l('Nothing found - sorry', $this->_coreClassName) . '",
				          "sInfo": "' . $this->l('Showing', $this->_coreClassName) . ' _START_ ' . $this->l('to', $this->_coreClassName) . ' _END_ ' . $this->l('of', $this->_coreClassName) . ' _TOTAL_ ' . $this->l('records', $this->_coreClassName) . '",
				          "sInfoEmpty": "' . $this->l('Showing', $this->_coreClassName) . ' 0 ' . $this->l('to', $this->_coreClassName) . ' 0 ' . $this->l('of', $this->_coreClassName) . ' 0 ' . $this->l('records', $this->_coreClassName) . '",
				          "sInfoFiltered": "(' . $this->l('filtered from', $this->_coreClassName) . ' _MAX_ ' . $this->l('total records', $this->_coreClassName) . ')",
				          "sPageNext": "' . $this->l('Next', $this->_coreClassName) . '",
				          "sPagePrevious": "' . $this->l('Previous', $this->_coreClassName) . '",
				          "sPageLast": "' . $this->l('Last', $this->_coreClassName) . '",
				          "sPageFirst": "' . $this->l('First', $this->_coreClassName) . '",
				          "sSearch": "' . $this->l('Search', $this->_coreClassName) . '",
						  oPaginate: {
							  "sFirst":"' . $this->l('First', $this->_coreClassName) . '",
							  "sPrevious":"' . $this->l('Previous', $this->_coreClassName) . '",
							  "sNext":"' . $this->l('Next', $this->_coreClassName) . '",
							  "sLast":"' . $this->l('Last', $this->_coreClassName) . '"
						  }
				        }
				      } );';
		if (!$returnAsScript)
			$return .= ' });</script>';
		if ($returnHTML)
			return $return;
		$this->_html .= $return;
	}
	protected function _initTinyMce() {
		if (version_compare(_PS_VERSION_, '1.4.1.0', '>=')) {
			$isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $this->_iso_lang . '.js') ? $this->_iso_lang : 'en');
			$ad = dirname($_SERVER ["PHP_SELF"]);
			$this->_html .= '<script type="text/javascript">
		        var iso = \'' . $isoTinyMCE . '\' ;
		        var pathCSS = \'' . _THEME_CSS_DIR_ . '\' ;
		        var ad = \'' . $ad . '\' ;
				var defaultIdLang = \'' . $this->_cookie->id_lang . '\' ;
		     </script>';
			$this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/pm_tinymce.inc.js"></script>';
		} else {
			$this->_html .= '
	         <script type="text/javascript">
	         tinyMCE.init({
	                  mode : "specific_textareas",
	                  editor_selector : "rte",
	                  theme : "advanced",
	                  plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
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
	                });</script>';
		}
	}
	protected function _initBindFillSize() {
		$this->_html .= '<script type="text/javascript">$jqPm(function() { bindFillNextSize() });</script>';
	}
	protected function _initColorPicker() {
		$this->_html .= '<script type="text/javascript">
	      var currentColorPicker = false;
	      $jqPm("input.colorPickerInput").ColorPicker({
	        onSubmit: function(hsb, hex, rgb, el) {
	          $jqPm(el).val("#"+hex);
	          $jqPm(el).ColorPickerHide();
	        },
	        onBeforeShow: function () {
	          currentColorPicker = $jqPm(this);
	          $jqPm(this).ColorPickerSetColor(this.value);
	        },
	        onChange: function (hsb, hex, rgb) {
	          $jqPm(currentColorPicker).val("#"+hex);
	          if ($jqPm(currentColorPicker).parent("div").find("span input.colorPickerInput").length) $jqPm(currentColorPicker).parent("div").find("span input.colorPickerInput").val("#"+hex);
	        }
	      })
	      .bind("keyup", function(){
	        $jqPm(this).ColorPickerSetColor(this.value);
	      });
	      initMakeGradient();
	    </script>';
	}
	protected function _addJS($js_uri) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$this->_context->controller->addJS($js_uri);
			return true;
		}
		elseif (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) {
			Tools::addJS($js_uri);
			return true;
		}
		if (!is_array($this->_js_files)) $this->js_files = array();
		if (in_array($js_uri, $this->_js_files)) return true;
		if (!is_array($js_uri)) $js_uri = array ($js_uri );
		foreach ($js_uri as &$file) {
			$different = 0;
			$override_path = str_replace(__PS_BASE_URI__ . 'modules/', _PS_THEME_DIR_ . '/modules/', $file, $different);
			if ($different && file_exists($override_path)) $file = str_replace(__PS_BASE_URI__ . 'modules/', __PS_BASE_URI__ . 'themes/' . _THEME_NAME_ . '/modules/', $file, $different);
		}
		$this->_js_files = array_merge($this->_js_files, $js_uri);
		return true;
	}
	protected function _addCSS($css_uri, $css_media_type = 'all') {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$this->_context->controller->addCSS($css_uri, $css_media_type);
			return true;
		}
		elseif (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) {
			Tools::addCSS($css_uri, $css_media_type);
			return true;
		}
		if (!is_array($this->_css_files)) $this->_css_files = array();
		$different = 0;
		$override_path = str_replace(__PS_BASE_URI__ . 'modules/', _PS_THEME_DIR_ . '/modules/', $css_uri, $different);
		if ($different && file_exists($override_path)) $css_uri = str_replace(__PS_BASE_URI__ . 'modules/', __PS_BASE_URI__ . 'themes/' . _THEME_NAME_ . '/modules/', $css_uri);
		if (!is_array($css_uri)) $css_uri = array ($css_uri => $css_media_type );
		$this->_css_files = array_merge($this->_css_files, $css_uri);
		return true;
	}
	protected function copyFromPost(&$destination, $destination_type = 'object', $data = false) {
		$this->_preCopyFromPost();
		$clearTempDirectory = false;
		if (!$data) $data = $_POST;
		foreach ($data as $key => $value) {
			if (preg_match('/_temp_file$/', $key) && $value) {
				$final_destination = dirname(__FILE__) . Tools::getValue($key . '_destination');
				$final_file = $final_destination . $value;
				$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . $value;
				if (self::_isRealFile($temp_file)) {
					rename($temp_file, $final_file);
				}
				$key = preg_replace('/_temp_file$/', '', $key);
				if ($old_file = Tools::getValue($key . '_old_file')) {
					if (self::_isRealFile($final_destination . Tools::getValue($key . '_old_file')))
						@unlink($final_destination . Tools::getValue($key . '_old_file'));
				}
				$clearTempDirectory = true;
			} elseif (preg_match('/_unlink$/', $key)) {
				$key = preg_replace('/_unlink$/', '', $key);
				$final_file = dirname(__FILE__) . Tools::getValue($key . '_temp_file_destination') . Tools::getValue($key . '_temp_file');
				$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . Tools::getValue($key . '_temp_file');
				if (self::_isRealFile($final_file))
					@unlink($final_file);
				if (self::_isRealFile($temp_file))
					@unlink($temp_file);
				$value = '';
				$clearTempDirectory = true;
			} elseif (preg_match('/activestatus/', $key)) {
				$key = 'active';
			}elseif (preg_match('/bg_position/', $key)) {
				if (is_array($value) || !Validate::isInt($value))
					continue;
				$value = $this->_getBgPositionFromArray($value, $key);
			}elseif (preg_match('/height$|width$/i', $key)) {
				$value=trim($value);
				if (!Validate::isInt($value)){
					$value = '' ;
					continue;
				}
				$unit = (Tools::getValue($key . '_unit') == 1?'px':'%');
				$value = $value.$unit ;
			} elseif (preg_match('/color/', $key)) {
				$value = $this->_getGradientFromArray($key);
			} elseif (preg_match('/margin|padding/', $key)) {
				$value = $this->_getBorderSizeFromArray($value);
			}elseif (preg_match('/border|shadow/', $key)) {
				$value = $this->_getShadowFromArray($value);
			}
			if (key_exists($key, $destination))
				if ($destination_type == 'object')
					$destination->{$key} = $value;
				else
					$destination[$key] = $value;
		}
		if ($destination_type == 'object'){
			$rules = call_user_func(array (get_class($destination), 'getValidationRules' ), get_class($destination));
			if (sizeof($rules ['validateLang'])) {
				$languages = Language::getLanguages(false);
				foreach ($languages as $language )
					foreach ($rules ['validateLang'] as $field => $validation) {
						if ((isset($data [$field . '_' . intval($language ['id_lang']) . '_temp_file_lang'])
						&& $data [$field . '_' . intval($language ['id_lang']) . '_temp_file_lang'])
						|| (isset($data [$field . '_all_lang']) && !$destination->{$field} [intval($language ['id_lang'])]
						&& $data [$field . '_all_lang']
						&& isset($data [$field . '_' . intval($this->_default_language) . '_temp_file_lang'])
						&& $data [$field . '_' . intval($this->_default_language) . '_temp_file_lang'])) {
							if (isset($data [$field . '_all_lang'])
							&& $data [$field . '_all_lang']
							&& $language ['id_lang'] != $this->_default_language) {
								$key_default_language = $field . '_' . intval($this->_default_language) . '_temp_file_lang';
								$old_file = $data[$key_default_language];
								$new_temp_file_lang = uniqid().'.'.self::_getFileExtension($data[$key_default_language]);
							}
							$key = $field . '_' . intval($language ['id_lang']) . '_temp_file_lang';
							$final_destination = dirname(__FILE__) . Tools::getValue($key . '_destination_lang');
							if (isset($data [$field . '_all_lang']) && $data [$field . '_all_lang'] && $language ['id_lang'] != $this->_default_language)  {
								$final_file = $final_destination . $new_temp_file_lang;
								$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . $old_file;
							}
							else {
								$final_file = $final_destination . Tools::getValue($key);
								$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . Tools::getValue($key);
							}
							if (self::_isRealFile($temp_file)) {
								copy($temp_file, $final_file);
							}
							$key = preg_replace('/_temp_file_lang$/', '', $key);
							if ($old_file = Tools::getValue($key . '_old_file_lang')) {
								if (self::_isRealFile($final_destination . Tools::getValue($key . '_old_file_lang')))
									@unlink($final_destination . Tools::getValue($key . '_old_file_lang'));
							}
							if (isset($data [$field . '_all_lang'])
							&& $data [$field . '_all_lang']
							&& $language ['id_lang'] != $this->_default_language) {
								$destination->{$field} [intval($language ['id_lang'])] = $new_temp_file_lang;
							}
							else
								$destination->{$field} [intval($language ['id_lang'])] = $_POST [$field . '_' . intval($language ['id_lang']) . '_temp_file_lang'];
							$clearTempDirectory = true;
						}
						if (isset($_POST [$field . '_' . intval($language ['id_lang']) . '_unlink_lang']) && $_POST [$field . '_' . intval($language ['id_lang']) . '_unlink_lang']) {
							$key = $field . '_' . intval($language ['id_lang']) . '_unlink_lang';
							$key = preg_replace('/_unlink_lang$/', '', $key);
							$final_file = dirname(__FILE__) . Tools::getValue($key . '_temp_file_lang_destination_lang') . Tools::getValue($key . '_old_file_lang');
							$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . Tools::getValue($key . '_old_file_lang');
							if (self::_isRealFile($final_file))
								@unlink($final_file);
							if (self::_isRealFile($temp_file))
								@unlink($temp_file);
							$destination->{$field} [intval($language ['id_lang'])] = '';
							$clearTempDirectory = true;
						}
						if (isset($_POST [$field . '_' . intval($language ['id_lang'])])) {
							$destination->{$field} [intval($language ['id_lang'])] = $_POST [$field . '_' . intval($language ['id_lang'])];
						}
					}
			}
		} else {
			$rules = call_user_func(array($destination['class_name'], 'getValidationRules'), $destination['class_name']);
			if (sizeof($rules ['validateLang'])) {
				$languages = Language::getLanguages();
				foreach ($languages as $language )
					foreach ($rules ['validateLang'] as $field => $validation) {
						if (isset($data [$field . '_' . intval($language ['id_lang']) . '_temp_file_lang']) && $_POST [$field . '_' . intval($language ['id_lang']) . '_temp_file_lang']) {
							$key = $field . '_' . intval($language ['id_lang']) . '_temp_file_lang';
							$final_destination = dirname(__FILE__) . Tools::getValue($key . '_destination_lang');
							$final_file = $final_destination . Tools::getValue($key);
							$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . Tools::getValue($key);
							if (self::_isRealFile($temp_file)) {
								rename($temp_file, $final_file);
							}
							$key = preg_replace('/_temp_file_lang$/', '', $key);
							if ($old_file = Tools::getValue($key . '_old_file_lang'))
								if (self::_isRealFile($final_destination . Tools::getValue($key . '_old_file_lang')))
									@unlink($final_destination . Tools::getValue($key . '_old_file_lang'));
							$destination[$field] [intval($language ['id_lang'])] = $_POST [$field . '_' . intval($language ['id_lang']) . '_temp_file_lang'];
							$clearTempDirectory = true;
						}
						if (isset($destination [$field . '_' . intval($language ['id_lang']) . '_unlink_lang']) && $_POST [$field . '_' . intval($language ['id_lang']) . '_unlink_lang']) {
							$key = $field . '_' . intval($language ['id_lang']) . '_unlink_lang';
							$key = preg_replace('/_unlink_lang$/', '', $key);
							$final_file = dirname(__FILE__) . Tools::getValue($key . '_temp_file_lang_destination_lang') . Tools::getValue($key . '_old_file_lang');
							$temp_file = dirname(__FILE__) . $this->_temp_upload_dir . Tools::getValue($key . '_old_file_lang');
							if (self::_isRealFile($final_file))
								@unlink($final_file);
							if (self::_isRealFile($temp_file))
								@unlink($temp_file);
							$destination[$field] [intval($language ['id_lang'])] = '';
							$clearTempDirectory = true;
						}
						if (isset($destination [$field . '_' . intval($language ['id_lang'])])){
							$destination[$field] [intval($language ['id_lang'])] = $destination [$field . '_' . intval($language ['id_lang'])];
						}
					}
				}
			}
			if ($clearTempDirectory)
				$this->_clearDirectory(dirname(__FILE__) . $this->_temp_upload_dir);
			$this->_postCopyFromPost(array('destination'=>$destination));
	}
	public static function _isFilledArray($array) {
		return ($array && is_array($array) && sizeof($array));
	}
	protected function _cleanOutput() {
		$this->_html = '';
		self::_cleanBuffer();
	}
	public static function _cleanBuffer() {
		if (ob_get_length() > 0) ob_clean();
	}
	protected function _echoOutput($die = false) {
		echo $this->_html;
		if ($die) die();
	}
	protected function _clearDirectory($dir) {
		if (!$dh = @opendir($dir)) return;
		while (false !== ($obj = readdir($dh))) {
			if ($obj == '.' || $obj == '..') continue;
			if (!@unlink($dir . '/' . $obj)) $this->_clearDirectory($dir . '/' . $obj);
		}
		closedir($dh);
		return;
	}
	public static function _isRealFile($filename) {
		return (file_exists($filename) && ! is_dir($filename));
	}
	public function _getTplPath($tpl_name, $view = 'hook') {
		return $this->_getTemplatePath('views/templates/'.$view.'/'.$tpl_name);
	}
	protected static function hex2rgb($hexstr) {
		if (strlen($hexstr) < 7) {
			$hexstr = $hexstr.str_repeat(substr($hexstr, -1), 7-strlen($hexstr));
		}
	    $int = hexdec($hexstr);
	    return array(
0 => 0xFF & ($int >> 0x10), 
1 => 0xFF & ($int >> 0x8), 
2 => 0xFF & $int);
	}
	protected static function tls2rgb($t, $l, $s) {
		if ($t<0)
			$t = 360+$t;
		if ($l<0)
			$l = 0;
		if ($s<0)
			$s = 0;
		if ($t>360)
			$t = $t-360;
		if ($l>255)
			$l = 255;
		if ($s>250)
			$s = 250;
		$l /= 255;
		$s /= 255;
		if ($l < 1/2)
			$q = $l * (1 + $s);
		elseif ($l >= 1/2)
			$q = $l + $s - ($l * $s);
		$p = 2 * $l - $q;
		$hk = $t / 360;
		$a[0] = $hk + 1/3;
		$a[1] = $hk;
		$a[2] = $hk - 1/3;
		$z = Array();
		foreach($a As $k => &$tc)
		{
			if ($tc < 0)
				$tc++;
			elseif ($tc > 1)
				$tc--;
			if ($tc < 1/6)
				$z[$k] = $p + (($q - $p) * 6 * $tc);
			elseif ($tc >= 1/6 && $tc < 1/2)
				$z[$k] = $q;
			elseif ($tc >= 1/2 && $tc < 2/3)
				$z[$k] = $p + (($q - $p) * 6 * (2/3 - $tc));
			else
				$z[$k] = $p;
		}
		$z[0] = intval(round($z[0] * 255));
		$z[1] = intval(round($z[1] * 255));
		$z[2] = intval(round($z[2] * 255));
		return $z;
	}
	protected static function rgb2tls($r, $v, $b){
		$max = max($r, $v, $b);
		$min = min($r, $v, $b);
		if ($max == $min)
			$t = 0;
		if ($max == $r) {
			@$t = 60 * (($v - $b) / ($max - $min));
		}
		elseif ($max == $v) {
			@$t = 60 * (($b - $r) / ($max - $min)) + 120;
		}
		elseif ($max == $b) {
			@$t = 60 * (($r - $v) / ($max - $min)) + 240;
		}
		$t = intval(round($t));
		$l = 1/2 * ($max + $min);
		$l2 = $l / 255;
		$l = intval(round($l));
		if ($max == $min)
			$s = 0;
		elseif ($l2 <= 1/2)
			$s = ($max - $min) / (2*$l2);
		elseif ($l2 > 1/2)
			$s = ($max - $min) / (2 - 2*$l2);
		$s = intval(round($s));
		if ($t<0)
			$t = 360+$t;
		if ($l<0)
			$l = 0;
		if ($s<0)
			$s = 0;
		if ($t>360)
			$t = $t-360;
		if ($l>255)
			$l = 255;
		if ($s>250)
			$s = 250;
		return Array($t, $l , $s);
	}
	protected static function rgb2hex($r, $g, $b) {
	    if (is_array($r) && sizeof($r) == 3)
	        list($r, $g, $b) = $r;
	    $r = intval($r); $g = intval($g);
	    $b = intval($b);
	    $r = dechex($r<0?0:($r>255?255:$r));
	    $g = dechex($g<0?0:($g>255?255:$g));
	    $b = dechex($b<0?0:($b>255?255:$b));
	    $color = (strlen($r) < 2?'0':'').$r;
	    $color .= (strlen($g) < 2?'0':'').$g;
	    $color .= (strlen($b) < 2?'0':'').$b;
	    return '#'.$color;
	}
	public static function _getCssRule($selector, $rule, $value, $is_important = false, $params = false, &$css_rules = array()) {
		$css_rule = '';
		switch ($rule) {
			case 'width' :
				$value ? $value : 0;
				$css_rule .= ' width:' . $value . ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px') . ($is_important ? '!important' : '') . ';';
				break;
			case 'height' :
				$value ? $value : 0;
				$css_rule .= ' height:' . $value . ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px') . ($is_important ? '!important' : '') . ';';
				break;
			case 'bg_gradient' :
				$val = explode(self::$_gradient_separator, $value);
				if (isset($val [1]) && $val [1]) {
					$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
					$color2 = htmlentities($val [1], ENT_COMPAT, 'UTF-8');
				} elseif (isset($val [0]) && $val [0])
					$color1 = htmlentities($val [0], ENT_COMPAT, 'UTF-8');
				if (!isset($color1))
					return '';
				$css_rule .= 'background:' . $color1 . ($is_important ? '!important' : '') . ';';
				if (isset($color2)) {
					$css_rule .= 'background: -webkit-gradient(linear, 0 0, 0 bottom, from(' . $color1 . '), to(' . $color2 . '))' . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'background: -webkit-linear-gradient(' . $color1 . ', ' . $color2 . ')' . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'background: -moz-linear-gradient(' . $color1 . ', ' . $color2 . ')' . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'background: -ms-linear-gradient(' . $color1 . ', ' . $color2 . ')' . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'background: -o-linear-gradient(' . $color1 . ', ' . $color2 . ')' . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'background: linear-gradient(' . $color1 . ', ' . $color2 . ')' . ($is_important ? '!important' : '') . ';';
					$css_rule .= '-pie-background: linear-gradient(' . $color1 . ', ' . $color2 . ')' . ($is_important ? '!important' : '') . ';';
				}
				break;
			case 'css3button' :
				if (!trim($value)) return '';
				$base_color_hex = $value;
				$base_color_rgb = self::hex2rgb($base_color_hex);
				$base_color_tls = self::rgb2tls($base_color_rgb[0], $base_color_rgb[1], $base_color_rgb[2]);
				$border_color_rgb = self::tls2rgb((int)$base_color_tls[0],(int)$base_color_tls[1]-49,(int)$base_color_tls[2]-16);
				$top0_color_rgb = self::tls2rgb((int)$base_color_tls[0],(int)$base_color_tls[1]+42,(int)$base_color_tls[2]-1);
				$bottom50_color_rgb = self::tls2rgb((int)$base_color_tls[0],(int)$base_color_tls[1]-13,(int)$base_color_tls[2]+18);
				$bottom100_color_rgb = self::tls2rgb((int)$base_color_tls[0],(int)$base_color_tls[1]-10,(int)$base_color_tls[2]+15);
				$boxshadow_color_rgb = self::tls2rgb((int)$base_color_tls[0],(int)$base_color_tls[1]+19,(int)$base_color_tls[2]-29);
				$border_color_hex = self::rgb2hex($border_color_rgb[0], $border_color_rgb[1], $border_color_rgb[2]);
				$top0_color_hex = self::rgb2hex($top0_color_rgb[0], $top0_color_rgb[1], $top0_color_rgb[2]);
				$top50_color_hex = $base_color_hex;
				$bottom50_color_hex = self::rgb2hex($bottom50_color_rgb[0], $bottom50_color_rgb[1], $bottom50_color_rgb[2]);
				$bottom100_color_hex = self::rgb2hex($bottom100_color_rgb[0], $bottom100_color_rgb[1], $bottom100_color_rgb[2]);
				$boxshadow_color_hex = self::rgb2hex($boxshadow_color_rgb[0], $boxshadow_color_rgb[1], $boxshadow_color_rgb[2]);
				$css_rule .= 'border: 1px '.$border_color_hex.' solid;'."\n";
				$css_rule .= '-webkit-box-shadow: 0px 0px 0px #aaa, inset 0 5px 10px '.$boxshadow_color_hex.';'."\n";
				$css_rule .= '-moz-box-shadow: 0px 0px 0px #aaa, inset 0 5px 10px '.$boxshadow_color_hex.';'."\n";
				$css_rule .= 'box-shadow: 0px 0px 0px #aaa, inset 0 5px 10px '.$boxshadow_color_hex.';'."\n";
				$css_rule .= 'background-color: '.$base_color_hex.'; /* Old browsers */'."\n";
				$css_rule .= 'background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, '.$top0_color_hex.'), color-stop(50%, '.$base_color_hex.'), color-stop(50%, '.$bottom50_color_hex.'), color-stop(100%, '.$bottom100_color_hex.')); /* Chrome,Safari4+ */'."\n";
				$css_rule .= 'background-image: -webkit-linear-gradient(top, '.$top0_color_hex.' 0%, '.$base_color_hex.' 50%, '.$bottom50_color_hex.' 50%, '.$bottom100_color_hex.' 100%); /* Chrome10+,Safari5.1+ */'."\n";
				$css_rule .= 'background-image: -moz-linear-gradient(top, '.$top0_color_hex.' 0%, '.$base_color_hex.' 50%, '.$bottom50_color_hex.' 50%, '.$bottom100_color_hex.' 100%); /* FF3.6+ */'."\n";
				$css_rule .= 'background-image: -ms-linear-gradient(top, '.$top0_color_hex.' 0%, '.$base_color_hex.' 50%, '.$bottom50_color_hex.' 50%, '.$bottom100_color_hex.' 100%); /* IE10+ */'."\n";
				$css_rule .= 'background-image: -o-linear-gradient(top, '.$top0_color_hex.' 0%, '.$base_color_hex.' 50%, '.$bottom50_color_hex.' 50%, '.$bottom100_color_hex.' 100%); /* Opera 11.10+ */'."\n";
				$css_rule .= 'background-image: linear-gradient(top, '.$top0_color_hex.' 0%, '.$base_color_hex.' 50%, '.$bottom50_color_hex.' 50%, '.$bottom100_color_hex.' 100%); /* W3C */'."\n";
				$css_rule .= 'filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\''.$top0_color_hex.'\', endColorstr=\''.$base_color_hex.'\'); /* IE7,8,9 */';
			break;
			case 'bg_image' :
				$css_rule .= 'background-image: url(' . $value . ')' . ($is_important ? '!important' : '') . ';';
				break;
			case 'float' :
				$css_rule .= 'float:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'position' :
				$css_rule .= 'position:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'color' :
				$css_rule .= 'color:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'font_size' :
				$value ? $value : 0;
				$css_rule .= 'font-size:' . $value . ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px') . ($is_important ? '!important' : '') . ';';
				break;
			case 'font_style' :
				$value ? $value : 'none';
				$css_rule .= 'font-style:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'font_weight' :
				$value ? $value : 'none';
				$css_rule .= 'font-weight:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'text_decoration' :
				$value ? $value : 'none';
				$css_rule .= 'text-decoration:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'line_height' :
				$value ? $value : 0;
				$css_rule .= 'line-height:' . $value . ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px') . ($is_important ? '!important' : '') . ';';
				break;
			case 'text_align' :
				$value ? $value : 'none';
				$css_rule .= 'text-align:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'border' :
				if ($value == 'none')
					$css_rule .= 'border:none!important;';
				else{
					$val = explode(self::$_border_separator, $value);
					if (isset($val [5]) && $val [5]) {
						$top	= htmlentities(str_replace('px', '', $val [0]), ENT_COMPAT, 'UTF-8');
						$right	= htmlentities(str_replace('px', '', $val [1]), ENT_COMPAT, 'UTF-8');
						$bottom	= htmlentities(str_replace('px', '', $val [2]), ENT_COMPAT, 'UTF-8');
						$left	= htmlentities(str_replace('px', '', $val [3]), ENT_COMPAT, 'UTF-8');
						$style	= htmlentities(str_replace('px', '', $val [4]), ENT_COMPAT, 'UTF-8');
						$color	= htmlentities(str_replace('px', '', $val [5]), ENT_COMPAT, 'UTF-8');
					}
					else
						return '';
					$css_rule .= 'border-top:'   . $top . ($top ? ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px'):'') . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'border-right:'  . $right . ($right ? ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px'):'') . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'border-bottom:' . $bottom . ($bottom ? ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px'):'') . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'border-left:'  . $left .  ($left ? ($params && isset($params ['suffix']) ? $params ['suffix'] : 'px'):'') . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'border-style:' . $style . ($is_important ? '!important' : '') . ';';
					$css_rule .= 'border-color:' . $color . ($is_important ? '!important' : '') . ';';
				}
				break;
			case 'text_transform' :
				$css_rule .= 'text-transform:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'border_size' :
				$css_rule .= 'border-size:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'border_radius' :
				$css_rule .= '-webkit-border-radius:' . $value . ($is_important ? '!important' : '') . ';';
				$css_rule .= '-moz-border-radius:' . $value . ($is_important ? '!important' : '') . ';';
				$css_rule .= 'border-radius:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'shadow' :
				if ($value == 'none'){
					$css_rule .= '-webkit-box-shadow:none!important;';
					$css_rule .= '-moz-box-shadow:none!important;';
					$css_rule .= 'box-shadow:none!important;';
				}
				else{
					$val = explode(self::$_shadow_separator, $value);
					$css_rule .= '-webkit-box-shadow:' . $val[0] .' '. $val[1] .' '. $val[2] .' '. $val[3].($is_important ? '!important' : '') . ';';
					$css_rule .= '-moz-box-shadow:' . $val[0] .' '. $val[1] .' '. $val[2] .' '. $val[3].($is_important ? '!important' : '') . ';';
					$css_rule .= 'box-shadow:' . $val[0] .' '. $val[1] .' '. $val[2] .' '. $val[3].($is_important ? '!important' : '') . ';';
				}
				break;
			case 'margin' :
				$css_rule .= 'margin:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'padding' :
				$css_rule .= 'padding:' . $value . ($is_important ? '!important' : '') . ';';
				break;
			case 'opacity' :
				$css_rule .= '-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=' . $value . ')"';
				$css_rule .= 'filter: alpha(opacity=' . $value . ')' . ($is_important ? '!important' : '') . ';';
				$css_rule .= '-khtml-opacity:' . ($value / 100) . ($is_important ? '!important' : '') . ';';
				$css_rule .= '-moz-opacity:' . ($value / 100) . ($is_important ? '!important' : '') . ';';
				$css_rule .= 'opacity:' . ($value / 100) . ($is_important ? '!important' : '') . ';';
				break;
			case 'custom' :
				$css_rule .= $value;
				break;
		}
		if (!isset($css_rules[$selector])) $css_rules[$selector] = array();
			$css_rules[$selector][] = $css_rule;
		return $css_rules;
	}
	protected function displayPMFlags($class = false) {
		if (!$this->styles_flag_lang_init) {
			$this->_html .= '<style type="text/css" media="all">';
			foreach ($this->_languages as $language) {
				$this->_html .= '.pmSelectFlag a.pmFlag_' . $language ['id_lang'].', .chosen-drop li.pmFlag_' . $language ['id_lang'].', .chosen-drop li.pmFlag_' . $language ['id_lang'].', .pmFlag_' . $language ['id_lang'].' .ui-selectmenu-status, .pmFlag_' . $language ['id_lang'].' a {background-image:url(../img/l/'.(int)($language['id_lang']).'.jpg), linear-gradient(transparent,transparent)!important; background-position:8px 4px;background-repeat:no-repeat;}
				.pmFlag_' . $language ['id_lang'].' a { background-position:center center;background-repeat:no-repeat;}';
			}
			$this->_html .= '</style>';
			$this->styles_flag_lang_init = true;
		}
		$key = uniqid();
		if ($class) $this->_html .= '<div class="' . htmlentities($class, ENT_COMPAT, 'UTF-8') . '">';
		$this->_html .= '<select id="'.$key.'" style="width:50px;" class="pmSelectFlag">';
		$currentIdLang = $this->_default_language;
		foreach ($this->_languages as $language) {
			$this->_html .= '<option value="' . (int)($language['id_lang']) . '" class="pmFlag_' . $language ['id_lang'].'" '.($language ['id_lang'] == $this->_default_language ? 'selected="selected"' : 'selected=""').'>&nbsp;&nbsp;</option>';
			if ($language ['id_lang'] == $this->_default_language) $currentIdLang = $this->_default_language;
		}
		$this->_html .= '</select>';
		if ($class) $this->_html .= '</div>';
		if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
			$this->_html .= '<script type="text/javascript">
				$jqPm("#' . $key . '").val("'.$currentIdLang.'");
				$jqPm("#' . $key . '").unbind("change").on("change chosen:ready", function(e, p) {
					var currentIdLang = $jqPm("#' . $key . '").val();
					$jqPm(".pmFlag").hide();
					$jqPm(".pmFlagLang_"+currentIdLang).show();
					$jqPm(".pmSelectFlag").val(currentIdLang);
					$jqPm(".pmSelectFlag").trigger("click");
					$jqPm("#' . $key . '_chosen a.chosen-single").attr("class", "chosen-single").addClass("pmFlag_"+currentIdLang);
				});
				$jqPm("#' . $key . '").chosen({ width: "50px", disable_search: true, max_selected_options: 1, inherit_select_classes: true });
			</script>';
		} else {
			$this->_html .= '<script type="text/javascript">
			$jqPm("#' . $key . '").val("'.$currentIdLang.'");
			$jqPm("#' . $key . '").selectmenu({wrapperElement: "<div class=\'ui_select_menu_lang\' />"});
			$jqPm("#' . $key . '").unbind("change").bind("change",function() {
				var currentIdLang = $jqPm("#' . $key . '").val();
				$jqPm(".pmFlag").hide();
				$jqPm(".pmFlagLang_"+currentIdLang).show();
				$jqPm(".pmSelectFlag").val(currentIdLang);
				$jqPm(".pmSelectFlag").trigger("click");
			});
			</script>
			';
		}
		return $key;
	}
	public function _displayTabsPanel($params) {
		$this->_html .= '<div id="'.$params['id_panel'].'">';
        $this->_html .= '<ul style="height: 30px;">';
        foreach($params['tabs'] as $id_tab => $tab) {
        	$label = '';
        	if (isset($tab['img']) && $tab['img'])
        		$label .= '<img src="'.$tab['img'].'" alt="'.$tab['label'].'" title="'.$tab['label'].'" /> ';
        	$label .= $tab['label'];
        	if (isset($tab['url']) && $tab['url'])
        		$href = $tab['url'];
        	elseif (isset($tab['funcs']) && $tab['funcs'])
        		$href = '#tab-'.$params['id_panel'].'-'.$id_tab;
        	else continue;
        	$this->_html .= '<li><a href="'.$href.'"><span>'.$label.'</span></a></li>';
        }
        $this->_html .= '</ul>';
        foreach($params['tabs'] as $id_tab => $tab) {
        	if (isset($tab['funcs']) && $tab['funcs']) {
        		$this->_html .= '<div id="tab-'.$params['id_panel'].'-'.$id_tab.'">';
        		if (self::_isFilledArray($tab['funcs'])) {
        			foreach($tab['funcs'] as $func) {
        				call_user_func(array($this, $func));
        			}
        		}
        		elseif (!is_array($tab['funcs'])) {
        			call_user_func(array($this, $tab['funcs']));
        		}
				$this->_html .= '</div>';
        	}
        }
    	$this->_html .= '</div>';
    	$this->_html .= '<script type="text/javascript">
			$jqPm(document).ready(function() {
				$jqPm("#'.$params['id_panel'].'").tabs({cache:true});
			});
        </script>';
	}
	public static function getNewHookName($hookName) {
		if (isset(self::$_new_hook_name[$hookName])) return self::$_new_hook_name[$hookName];
		return false;
	}
	public static function addSqlAssociation($table, $alias, $identifier, $inner_join = true, $on = null, $shops = false) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive()) {
			if ($shops == 'all') $ids_shop = array_values(Shop::getCompleteListOfShopsID());
			else if (is_array($shops) && sizeof($shops)) $ids_shop = array_values($shops);
			else if (is_numeric($shops) ) $ids_shop = array($shops);
			else $ids_shop = array_values(Shop::getContextListShopID());
			$table_alias = $alias.'_shop';
			if (strpos($table, '.') !== false) list($table_alias, $table) = explode('.', $table);
			$sql = (($inner_join) ? ' INNER' : ' LEFT').' JOIN `'._DB_PREFIX_.$table.'_shop` '.$table_alias.'
						ON '.$table_alias.'.'.$identifier.' = '.$alias.'.'.$identifier.'
						AND '.$table_alias.'.id_shop IN ('.implode(', ', $ids_shop).') '
						.(($on) ? ' AND '.$on : '');
			return $sql;
		}
		return;
	}
	public static function _getHookIdByName($hook_name) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<'))
			return Hook::get($hook_name);
		else return Hook::getIdByName($hook_name);
	}
	public static function _hookExec($hook_name) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			return Hook::exec($hook_name);
		else return Module::hookExec($hook_name);
	}
	public static function _retroValidateController($obj) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
			return $obj->validateControler();
		} else {
			$error_field = '';
			$error_field_lang = '';
			try { $error_field = $obj->validateFields(false, true);	}
			catch (Exception $e) { }
			if ($error_field !== true) return array($error_field);
			try { $error_field_lang = $obj->validateFieldsLang(false, true); }
			catch (Exception $e) { }
			if ($error_field_lang !== true) return array($error_field_lang);
			return array();
		}
	}
	public static function pregQuoteSql($str) {
		return preg_replace('#([.\+*?^$()\[\]{}=!<>|:-])#','\\\\\\\\\\\${1}', $str);
	}
	public static function _changeTimeLimit($time) {
		if (!ini_get('safe_mode')) {
			if (function_exists('set_time_limit') && (ini_get('max_execution_time') < $time || $time === 0)) {
				set_time_limit($time);
			}
		}
	}
	public static function _iniSet($key, $value) {
		if (!ini_get('safe_mode')) {
			if (function_exists('ini_set'))
				ini_set($key, $value);
		}
	}
	protected function _getTemplatePath($template) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			return $this->getTemplatePath($template);
		} else {
			$overloaded = $this->_isTemplateOverloaded($template);
			if ($overloaded === null)
				return null;
			if ($overloaded)
				return _PS_THEME_DIR_.'modules/'.$this->name.'/'.$template;
			else if (file_exists(_PS_MODULE_DIR_.$this->name.'/views/templates/hook/'.$template))
				return _PS_MODULE_DIR_.$this->name.'/views/templates/hook/'.$template;
			else
				return _PS_MODULE_DIR_.$this->name.'/'.$template;
		}
	}
	protected static function _getImageTypeFormatedName($name) {
		if (method_exists('ImageType', 'getFormatedName')) {
			return ImageType::getFormatedName($name);
		} else {
			$theme_name = Context::getContext()->shop->theme_name;
			$name_without_theme_name = str_replace(array('_'.$theme_name, $theme_name.'_'), '', $name);
			if (strstr($name, $theme_name) && ImageType::getByNameNType($name))
				return $name;
			else if (ImageType::getByNameNType($name_without_theme_name.'_'.$theme_name, 'products'))
				return $name_without_theme_name.'_'.$theme_name;
			else
				return $theme_name.'_'.$name_without_theme_name;
		}
	}
	protected static function _getNbDaysModuleUsage() {
		$sql = 'SELECT DATEDIFF(NOW(),date_add)
				FROM '._DB_PREFIX_.'configuration
				WHERE name = \''.pSQL('PM_'.self::$_module_prefix.'_LAST_VERSION').'\'
				ORDER BY date_add ASC';
		return (int)Db::getInstance()->getValue($sql);
	}
	public function hookDisplayBackOfficeHeader($params) {
		if (isset(Context::getContext()->controller) && isset(Context::getContext()->controller->controller_name) && strtolower(Context::getContext()->controller->controller_name) == 'adminmodules') {
			$this->_MHM_update();
		}
	}
	private function _MHM_needUpdate() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && defined('Module::CACHE_FILE_MUST_HAVE_MODULES_LIST')) {
			if (file_exists(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST) && is_readable(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST) && is_writable(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST)) {
				$content = file_get_contents(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST);
				if (!preg_match('#PM_MODS#', $content)) return true;
			}
		}
		return false;
	}
	private function _MHM_update() {
		if ($this->_MHM_needUpdate()) {
			$content = file_get_contents(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST);
			if (strlen($content) == 0) $content = '<?xml version="1.0" encoding="UTF-8"?><modules></modules>';
			$new_content = Tools::file_get_contents('http://www.presta-module.com/cross-selling-addons-modules-footer?xml=1&iso='.$this->_iso_lang.'&pm='.$this->_getPMdata());
			if ($new_content !== false) {
				$content = str_replace('<modules>', '<modules><!-- PM_MODS -->'.$new_content.'<!-- /PM_MODS -->', $content);
				@file_put_contents(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST, $content);
			} else {
				$content = str_replace('<modules>', '<modules><!-- PM_MODS --><!-- /PM_MODS -->', $content);
				@file_put_contents(_PS_ROOT_DIR_.Module::CACHE_FILE_MUST_HAVE_MODULES_LIST, $content);
			}
		}
	}
	protected function getCurrentCustomerGroupId() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$id_group = (int)Configuration::get('PS_UNIDENTIFIED_GROUP');
			if (Validate::isLoadedObject($this->_context->customer)) $id_group = (int)$this->_context->customer->id_default_group;
			return $id_group;
		} else {
			if ((int)$this->_cookie->id_customer > 0) {
				$customer = new Customer((int)$this->_cookie->id_customer);
				if (Validate::isLoadedObject($customer)) {
					$group = new Group((int)$customer->id_default_group);
					if (Validate::isLoadedObject($group)) return $group->id;
				}
			} else {
				return _PS_DEFAULT_CUSTOMER_GROUP_;
			}
		}
		return false;
	}
	protected function _isMobileTheme() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<') && version_compare(_PS_VERSION_, '1.4.0.0', '>=')) return (_THEME_NAME_ == 'prestashop_mobile');
		return false;
	}
	public static function _getSmartyVarValue($varName) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $smarty = Context::getContext()->smarty;
		else global $smarty;
		if (method_exists($smarty, 'getTemplateVars')) {
			return $smarty->getTemplateVars($varName);
		} else if (method_exists($smarty, 'get_template_vars')) {
			return $smarty->get_template_vars($varName);
		}
		return false;
	}
	protected function _onBackOffice() {
		if (isset($this->_cookie->id_employee) && Validate::isUnsignedId($this->_cookie->id_employee)) return true;
		return false;
	}
}
