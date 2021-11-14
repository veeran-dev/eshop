<?php
/**
 *
 * PM_AdvancedSearch_4 Front Office Feature
 *
 * @category front_office_features
 * @author Presta-Module.com <support@presta-module.com>
 * @copyright Presta-Module 2014
 * @version 4.10.12
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
 **             V 4.10.12            *
 *************************************
 * +
 * + Multi-layered search engine and search by steps
 * + Languages: EN, FR
 * + PS version: 1.4, 1.5, 1.6
 *
 ****/
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/classes/ShopOverrided.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/classes/AdvancedSearchClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/classes/AdvancedSearchCriterionGroupClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/classes/AdvancedSearchCriterionClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/classes/AdvancedSearchSeoClass.php');
include_once (_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/AdvancedSearchCoreClass.php');
class PM_AdvancedSearch4 extends AdvancedSearchCoreClass {
	protected $errors = array();
	private $gradient_separator = '-';
	private $options_show_hide_crit_method;
	private $options_remind_selection;
	private $options_launch_search_method;
	private $orderByValues = array (0 => 'name', 1 => 'price', 2 => 'date_add', 3 => 'date_upd', 4 => 'position', 5 => 'manufacturer_name', 6 => 'quantity', 7 => 'reference');
	private $orderWayValues = array (0 => 'asc', 1 => 'desc' );
	private $options_defaut_order_by;
	private $options_defaut_order_way;
	private $options_criteria_group_type;
	private $allowFileExtension = array ('gif', 'jpg', 'jpeg', 'png' );
	private $sortableCriterion = array ('attribute', 'feature', 'manufacturer', 'supplier', 'category', 'weight', 'width', 'weight', 'height', 'depth', 'condition');
	private $criteriaGroupLabels;
	private $criterionGroupIsTemplatisable = array ('attribute', 'feature', 'manufacturer', 'supplier', 'category' );
	private $keepVarForCache = array ('id_category', 'id_product', 'id_manufacturer', 'id_supplier', 'id_cms', 'id_search' );
	private $display_horizontal_search_block = array (8, 14, '-1');
	private $productLinksNCIsInstalled;
	public 	$_require_maintenance = true;
	public static $_module_prefix = 'as4';
	private $bench = false;
	protected $_debug_mode = false;
	private $bench_output = array();
	private $bench_start;
	private $bench_step;
	private $MagicZoomInstance = false;
	private $_htFile;
	protected $_copyright_link = array(
		'link'	=> '',
		'img'	=> '//www.presta-module.com/img/logo-module.JPG'
	);
	protected $_support_link = false;
	protected $_css_js_to_load = array ('jquery',
									 	'jquerytiptip',
									 	'jqueryui',
										'admincore',
									 	'adminmodule',
									 	'codemirrorcore',
									 	'codemirrorcss',
									 	'colorpicker',
									 	'datatables',
									 	'jgrowl',
									 	'multiselect',
									 	'scrolltofixed',
									 	'uploadify',
									 	'tiny_mce',
									 	'form',
										'selectmenu');
	protected $_dyn_tables = array ('pm_advancedsearch_product_price_ID_SEARCH',
								 	'pm_advancedsearch_cache_product_ID_SEARCH',
									'pm_advancedsearch_cache_product_criterion_ID_SEARCH',
								 	'pm_advancedsearch_criterion_ID_SEARCH',
								 	'pm_advancedsearch_criterion_ID_SEARCH_lang',
								 	'pm_advancedsearch_criterion_group_ID_SEARCH',
								 	'pm_advancedsearch_criterion_group_ID_SEARCH_lang');
	protected $_static_tables = array (	'pm_advancedsearch',
									 	'pm_advancedsearch_category',
										'pm_advancedsearch_cms',
									 	'pm_advancedsearch_lang',
									 	'pm_advancedsearch_seo',
									 	'pm_advancedsearch_seo_crosslinks',
									 	'pm_advancedsearch_seo_lang');
	protected $_file_to_check = array('css','css/pm_advancedsearch4_dynamic.css','search_files', 'search_files/criterions', 'search_files/criterions_group', 'sitemap', 'uploads/temp' );
	public static $productFilterList = array();
	public static $productFilterListData = false;
	public static $productFilterListSource = false;
	const INSTALL_SQL_BASE_FILE = 'install_base.sql';
	const INSTALL_SQL_DYN_FILE = 'install_dyn.sql';
	const DYN_CSS_FILE = 'css/pm_advancedsearch4_dynamic.css';
	const ADVANCED_CSS_FILE = 'css/pm_advancedsearch4_advanced.css';
	public function __construct() {
		if (!$this->_debug_mode) $this->bench = false;
		$this->_addToFBLog("Start");
		$this->name = 'pm_advancedsearch4';
		if (version_compare(_PS_VERSION_, '1.4.0.0', '<'))
			$this->tab = 'Presta Module';
		else {
			$this->author = 'Presta-Module';
			$this->tab = 'search_filter';
			$this->need_instance = 0;
			$this->module_key = 'e0578dd1826016f7acb8045ad15372b4';
		}
		$this->version = '4.10.12';
		$this->controllers = array('advancedsearch4');
		parent::__construct();
		$this->criteriaGroupLabels = array('category'=>$this->l('category'),'feature'=>$this->l('feature'),'attribute'=>$this->l('attribute'),'supplier'=>$this->l('supplier'),'manufacturer'=>$this->l('manufacturer'),'price'=>$this->l('price'),'weight'=>$this->l('product properties'),'on_sale'=>$this->l('product properties'),'stock'=>$this->l('product properties'),'available_for_order'=>$this->l('product properties'),'online_only'=>$this->l('product properties'),'condition'=>$this->l('product properties'),'width'=>$this->l('product properties'),'height'=>$this->l('product properties'),'depth'=>$this->l('product properties'));
		$this->criteria_group_type_interal_name = array (1 => 'select', 3 => 'link', 4 => 'checkbox', 5 => 'slider', 6 => 'searchbox', 2 => 'image', 7 => 'colorsquare' );
		if (file_exists(dirname(__FILE__) . '/../magiczoomplus/magiczoomplus.php') && self::moduleIsInstalled('magiczoomplus')) {
			include_once (_PS_ROOT_DIR_ . '/modules/magiczoomplus/magiczoomplus.php');
			if (method_exists('magiczoomplus','hookHeader') && method_exists('magiczoomplus','parseTemplateStandard'))
				$this->MagicZoomInstance = new MagicZoomPlus();
			else
				$this->MagicZoomInstance = false;
		} elseif (file_exists(dirname(__FILE__) . '/../magiczoom/magiczoom.php') && self::moduleIsInstalled('magiczoom')) {
			include_once (_PS_ROOT_DIR_ . '/modules/magiczoom/magiczoom.php');
			if (method_exists('magiczoom','hookHeader') && method_exists('magiczoom','parseTemplateStandard'))
				$this->MagicZoomInstance = new MagicZoom();
			else
				$this->MagicZoomInstance = false;
		}
		if (file_exists(dirname(__FILE__) . '/../productlinksnc/productlinksnc.php') && self::moduleIsInstalled('productlinksnc'))
			$this->productLinksNCIsInstalled = true;
		if ($this->_onBackOffice()) {
			$this->displayName = $this->l('Advanced Search 4');
			$this->description = $this->l('Multi-layered search engine and search by steps');
			$this->options_remind_selection = array (0 => $this->l('Don\'t show selection'), 1 => $this->l('Show selection over product\'s results'), 2 => $this->l('Show selection on search block'), 3 => $this->l('Show selection over product\'s results and on search block') );
			$this->options_show_hide_crit_method = array (1 => $this->l('On mouse over'), 2 => $this->l('On click'), 3 => $this->l('In an overflow block') );
			$this->options_launch_search_method = array (1 => $this->l('Instant search'), 2 => $this->l('Search on submit') );
			$this->options_defaut_order_by = array (0 => $this->l('Product name'), 1 => $this->l('Product price'), 2 => $this->l('Product added date') .' ('.$this->l('Recommended for heavy catalog').')', 4 => $this->l('Position inside category'), 5 => $this->l('Manufacturer'), 3 => $this->l('Product modified date').' ('.$this->l('Recommended for heavy catalog').')' );
			$this->options_defaut_order_way = array (0 => $this->l('Ascending'), 1 => $this->l('Descending') );
			$this->options_criteria_group_type = array (1 => $this->l('Selectbox'), 3 => $this->l('Link'), 4 => $this->l('Checkbox'), 5 => $this->l('Slider')/*, 8 => $this->l('Range')*/,
			//6 => $this->l('Search box'),
			2 => $this->l('Image') );
			$this->_htFile = dirname(__FILE__) . '/../../.htaccess';
			$doc_url_tab['fr'] = 'http://www.presta-module.com/docs/fr/advancedsearch4/';
			$doc_url_tab['en'] = 'http://www.presta-module.com/docs/en/advancedsearch4/';
			$doc_url = $doc_url_tab['en'];
			if ($this->_iso_lang == 'fr') $doc_url = $doc_url_tab['fr'];
			$forum_url_tab['fr'] = 'http://www.prestashop.com/forums/topic/113804-module-pm-advanced-search-4-elu-meilleur-module-2012/';
			$forum_url_tab['en'] = 'http://www.prestashop.com/forums/topic/113831-module-pm-advancedsearch-4-winner-at-the-best-module-awards-2012/';
			$forum_url = $forum_url_tab['en'];
			if ($this->_iso_lang == 'fr') $forum_url = $forum_url_tab['fr'];
			$this->_support_link = array(
				array('link' => $forum_url, 'target' => '_blank', 'label' => $this->l('Forum topic')),
				
				array('link' => 'http://addons.prestashop.com/contact-community.php?id_product=2778', 'target' => '_blank', 'label' => $this->l('Support contact')),
			);
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
				$this->display_horizontal_search_block = array('-1');
				foreach (array('displayHome', 'displayTop') as $hookName)
					if (Hook::getIdByName($hookName) !== false)
						$this->display_horizontal_search_block[] = Hook::getIdByName($hookName);
			}
		}
	}
	private function _getBestSellersProductsIds() {
		$sqlGroups = '';
		if ((version_compare(_PS_VERSION_, '1.6.0.0', '>=') && Group::isFeatureActive()) && version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
			$currentGroups = FrontController::getCurrentCustomerGroups();
			$sqlGroups = 'AND cg.`id_group` '.(is_array($currentGroups) && sizeof($currentGroups) ? 'IN ('.implode(',', $currentGroups).')' : '= 1');
		}
		Db::getInstance()->Execute('SET group_concat_max_len := @@max_allowed_packet');
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT GROUP_CONCAT(p.id_product) as pid_list
		FROM `'._DB_PREFIX_.'product_sale` ps
		JOIN `'._DB_PREFIX_.'product` p ON (ps.`id_product` = p.`id_product`)
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlAssociation('product', 'p') : '').'
		WHERE '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'product_shop' : 'p').'.`active` = 1
		AND p.`id_product` IN (
			SELECT cp.`id_product`
			FROM `'._DB_PREFIX_.'category_group` cg
			LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
			WHERE cg.`id_group` '.$sqlGroups.'
		)');
		if ($result && isset($result['pid_list']) && !empty($result['pid_list'])) return explode(',', $result['pid_list']);
		return array();
	}
	private function _getNewProductsIds() {
		$sqlGroups = '';
		if ((version_compare(_PS_VERSION_, '1.6.0.0', '>=') && Group::isFeatureActive()) && version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
			$currentGroups = FrontController::getCurrentCustomerGroups();
			$sqlGroups = 'AND cg.`id_group` '.(is_array($currentGroups) && sizeof($currentGroups) ? 'IN ('.implode(',', $currentGroups).')' : '= 1');
		}
		Db::getInstance()->Execute('SET group_concat_max_len := @@max_allowed_packet');
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT GROUP_CONCAT(p.id_product) as pid_list
		FROM `'._DB_PREFIX_.'product` p
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlAssociation('product', 'p') : '').'
		WHERE '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'product_shop' : 'p').'.`active` = 1
		AND DATEDIFF('.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'product_shop' : 'p').'.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND product_shop.`visibility` IN ("both", "catalog") ' : '').'
		AND p.`id_product` IN (
			SELECT cp.`id_product`
			FROM `'._DB_PREFIX_.'category_group` cg
			LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
			WHERE cg.`id_group` '.$sqlGroups.'
		)');
		if ($result && isset($result['pid_list']) && !empty($result['pid_list'])) return explode(',', $result['pid_list']);
		return array();
	}
	private function _getPricesDropProductsIds() {
		$sqlGroups = '';
		if ((version_compare(_PS_VERSION_, '1.6.0.0', '>=') && Group::isFeatureActive()) && version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
			$currentGroups = FrontController::getCurrentCustomerGroups();
			$sqlGroups = 'AND cg.`id_group` '.(is_array($currentGroups) && sizeof($currentGroups) ? 'IN ('.implode(',', $currentGroups).')' : '= 1');
		}
		$currentDate = date('Y-m-d H:i:s');
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
			global $cookie, $cart;
			$id_group = $cookie->id_customer ? (int)(Customer::getDefaultGroupId((int)($cookie->id_customer))) : _PS_DEFAULT_CUSTOMER_GROUP_;
			$id_address = $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
			$ids = Address::getCountryAndState($id_address);
			$id_country = (int)($ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));
			$ids_product = SpecificPrice::getProductIdByDate((int)(Shop::getCurrentShop()), (int)($cookie->id_currency), $id_country, $id_group, $currentDate, $currentDate);
		} else {
			$id_address = $this->_context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
			$ids = Address::getCountryAndState($id_address);
			$id_country = (int)($ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));
			$ids_product = SpecificPrice::getProductIdByDate($this->_context->shop->id, $this->_context->currency->id, $id_country, $this->_context->customer->id_default_group, $currentDate, $currentDate, 0, false);
		}
		$tab_id_product = array();
		foreach ($ids_product as $product) {
			if (is_array($product)) $tab_id_product[] = (int)$product['id_product'];
			else $tab_id_product[] = (int)$product;
		}
		Db::getInstance()->Execute('SET group_concat_max_len := @@max_allowed_packet');
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT GROUP_CONCAT(p.id_product) as pid_list
		FROM `'._DB_PREFIX_.'product` p
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlAssociation('product', 'p') : '').'
		WHERE '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'product_shop' : 'p').'.`active` = 1
		AND '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'product_shop' : 'p').'.`show_price` = 1
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND product_shop.`visibility` IN ("both", "catalog") ' : '').'
		AND '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? 'product_shop' : 'p').'.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')
		AND p.`id_product` IN (
			SELECT cp.`id_product`
			FROM `'._DB_PREFIX_.'category_group` cg
			LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
			WHERE cg.`id_group` '.$sqlGroups.'
		)');
		if ($result && isset($result['pid_list']) && !empty($result['pid_list'])) return explode(',', $result['pid_list']);
		return array();
	}
	public function hookSearch($params) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) return;
		if (isset($params['expr']) && !empty($params['expr']) && strlen(trim($params['expr'])) > 0) {
			self::$productFilterListData = $params['expr'];
			self::$productFilterListSource = 'search';
			$this->setProductFilterContext();
		}
	}
	private function _getProductsByNativeSearch($expr) {
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$intersectArray = array();
		$scoreArray = array();
		$words = explode(' ', Search::sanitize($expr, (int)$this->_cookie->id_lang));
		foreach ($words AS $key => $word)
			if (!empty($word) AND strlen($word) >= (int)Configuration::get('PS_SEARCH_MINWORDLEN')) {
				$word = str_replace('%', '\\%', $word);
				$word = str_replace('_', '\\_', $word);
				if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) $word = Tools::replaceAccentedChars($word);
				$intersectArray[] = 'SELECT id_product
					FROM '._DB_PREFIX_.'search_word sw
					LEFT JOIN '._DB_PREFIX_.'search_index si ON sw.id_word = si.id_word
					WHERE sw.id_lang = '.(int)$this->_cookie->id_lang.
					(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND sw.id_shop = '.Context::getContext()->shop->id.' ' : '').
					' AND sw.word LIKE
					'.($word[0] == '-'
						? ' \''.pSQL(Tools::substr($word, 1, PS_SEARCH_MAX_WORD_LENGTH)).'%\''
						: '\''.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).'%\''
					);
				if ($word[0] != '-')
					$scoreArray[] = 'sw.word LIKE \''.pSQL(Tools::substr($word, 0, PS_SEARCH_MAX_WORD_LENGTH)).'%\'';
			}
			else
				unset($words[$key]);
		if (!sizeof($words)) return array();
		$sqlGroups = '';
		if ((version_compare(_PS_VERSION_, '1.6.0.0', '>=') && Group::isFeatureActive()) && version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
			$currentGroups = FrontController::getCurrentCustomerGroups();
			$sqlGroups = 'AND cg.`id_group` '.(is_array($currentGroups) && sizeof($currentGroups) ? 'IN ('.implode(',', $currentGroups).')' : '= 1');
		}
		$result = $db->ExecuteS('
		SELECT DISTINCT cp.`id_product`
		FROM `'._DB_PREFIX_.'category_product` cp
		'.((version_compare(_PS_VERSION_, '1.6.0.0', '>=') && Group::isFeatureActive()) && version_compare(_PS_VERSION_, '1.6.0.0', '<') ? 'INNER JOIN `'._DB_PREFIX_.'category_group` cg ON cp.`id_category` = cg.`id_category`' : '').'
		INNER JOIN `'._DB_PREFIX_.'category` c ON cp.`id_category` = c.`id_category`
		INNER JOIN `'._DB_PREFIX_.'product` p ON cp.`id_product` = p.`id_product` '
		.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Shop::addSqlAssociation('product', 'p', false) : '').' 
		WHERE c.`active` = 1 
		' . (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND product_shop.`active` = 1 AND product_shop.`visibility` IN ("both", "search") AND product_shop.indexed = 1 ' : ' AND p.`active` = 1 AND indexed = 1 ' ) .
		$sqlGroups, false);
		$eligibleProducts = array();
		while ($row = $db->nextRow($result)) $eligibleProducts[] = (int)$row['id_product'];
		foreach ($intersectArray as $query) {
			$result = $db->ExecuteS($query, false);
			$eligibleProducts2 = array();
			while ($row = $db->nextRow($result)) $eligibleProducts2[] = (int)$row['id_product'];
			$eligibleProducts = array_intersect($eligibleProducts, $eligibleProducts2);
			if (!count($eligibleProducts)) return array();
		}
		array_unique($eligibleProducts);
		return $eligibleProducts;
	}
	public function install() {
		if (!$this->installDB() || ! parent::install())
			return false;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$valid_hooks = AdvancedSearchClass::$_valid_hooks_1_5;
		else
			$valid_hooks = AdvancedSearchClass::$_valid_hooks;
		foreach ($valid_hooks as $k => $hook_name) {
			if (!$this->registerHook($hook_name))
				return false;
		}
		if (!$this->registerHook('backOfficeHeader') || !$this->registerHook('header') || !$this->registerHook('updateProduct') || !$this->registerHook('addProduct')
 || !$this->registerHook('deleteProduct'))
			return false;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && (!$this->registerHook('actionObjectSpecificPriceDeleteAfter') || !$this->registerHook('actionAdminProductsControllerSaveAfter'))) return false;
		$this->checkIfModuleIsUpdate(true, false);
		return true;
	}
	public function installDB() {
		if (!file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_BASE_FILE))
			return (false);
		else if (!$sql = file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_BASE_FILE))
			return (false);
		$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
			$sql = str_replace('MYSQL_ENGINE', _MYSQL_ENGINE_, $sql);
		else
			$sql = str_replace('MYSQL_ENGINE', 'MyISAM', $sql);
		$sql = preg_split("/;\s*[\r\n]+/", $sql);
		foreach ($sql as $query )
			if (!Db::getInstance()->Execute(trim($query)))
				return (false);
		return true;
	}
	public function installDBCache($id_search, $with_drop = true) {
		if (!file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_DYN_FILE))
			return (false);
		else if (!$sql = file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_DYN_FILE))
			return (false);
		$sql = str_replace('ID_SEARCH', $id_search, $sql);
		$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
			$sql = str_replace('MYSQL_ENGINE', _MYSQL_ENGINE_, $sql);
		else
			$sql = str_replace('MYSQL_ENGINE', 'MyISAM', $sql);
		$sql = preg_split("/;\s*[\r\n]+/", $sql);
		foreach ($sql as $query) {
			if (!$with_drop && preg_match('#^DROP#i',trim($query))) continue;
			if (!Db::getInstance()->Execute(trim($query)))
				return (false);
		}
		return true;
	}
	public function checkIfModuleIsUpdate($updateDb = false, $displayConfirm = true) {
		parent::checkIfModuleIsUpdate($updateDb, $displayConfirm);
		$isUpdate = true;
		if (Configuration::get('AS4_LAST_VERSION', false) !== false && Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false) === false) {
			Configuration::updateValue('PM_' . self::$_module_prefix . '_LAST_VERSION', Configuration::get('AS4_LAST_VERSION', false));
			Configuration::deleteByName('AS4_LAST_VERSION');
		}
		if (!$updateDb && $this->version != Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false))
			return false;
		if ($updateDb) {
			$oldModuleVersion = Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false);
			if (Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false) !== false && version_compare(Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false), '4.8', '>=') && version_compare(Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false), '4.9.1',  '<=')) {
				$updateShopTable = true;
			} else {
				$updateShopTable = false;
			}
			unset($_GET ['makeUpdate']);
			if (!$this->isRegisteredInHook('backOfficeHeader'))
				$this->registerHook('backOfficeHeader');
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && !$this->isRegisteredInHook('actionObjectSpecificPriceDeleteAfter'))
				$this->registerHook('actionObjectSpecificPriceDeleteAfter');
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && !$this->isRegisteredInHook('actionAdminProductsControllerSaveAfter'))
				$this->registerHook('actionAdminProductsControllerSaveAfter');
			Configuration::updateValue('PM_' . self::$_module_prefix . '_LAST_VERSION', $this->version);
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
				if (!Configuration::getGlobalValue('PM_AS4_SECURE_KEY')) Configuration::updateGlobalValue('PM_AS4_SECURE_KEY', strtoupper(Tools::passwdGen(16)));
			} else {
				if (!Configuration::get('PM_AS4_SECURE_KEY')) Configuration::updateValue('PM_AS4_SECURE_KEY', strtoupper(Tools::passwdGen(16)));
			}
			$this->installDB();
			$this->updateSearchTable($updateShopTable, $oldModuleVersion);
			$this->generateCss();
			$this->generateSeoGSiteMap();
			$this->_pmClearCache();
			if ($displayConfirm) {
				$this->_html .= $this->displayConfirmation($this->l('Module updated successfully'));
			}
		}
		return $isUpdate;
	}
	public function updateSearchTable($updateShopTable = false, $oldModuleVersion = false) {
		$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);
		$toAdd = array();
		$toChange = array();
		$indexToAdd = array();
		$primaryToAdd = array();
		$toChange [] = array ('pm_advancedsearch', 'id_hook', 'int(11) NOT NULL');
		if (is_array($advanced_searchs_id) && sizeof($advanced_searchs_id)) {
			foreach ($advanced_searchs_id as $key => $row) {
				$this->installDBCache($row ['id_search'],false);
				foreach($this->_dyn_tables as $table) {
					$table = str_replace('ID_SEARCH', $row ['id_search'], $table);
					if (!Db::getInstance()->Execute('ALTER TABLE `'. _DB_PREFIX_ .pSQL($table).'` ENGINE=`MyISAM`'))
						$this->_errors[] = $this->l('Can\'t change engine for').' '. _DB_PREFIX_ .$table;
				}
				$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` WHERE `column_name` = "id_criterion_group"');
				if ($result && Db::getInstance()->numRows())
					Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` DROP INDEX `id_product` , ADD INDEX `id_product` ( `id_currency` , `id_country` , `id_group` , `price` , `price_wt` , `from` , `to` ) ');
				$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` WHERE `Key_name` = "PRIMARY" AND `Column_name` = "reduction_amount"');
				$result2 = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` WHERE `Key_name` = "PRIMARY"');
				if (!$result && $result2)
					Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` DROP PRIMARY KEY');
				$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_cache_product_criterion_' . (int)($row ['id_search']) . '` WHERE `key_name` = "id_criterion2"');
				if (!$result || !Db::getInstance()->numRows()) {
					Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_cache_product_criterion_' . (int)($row ['id_search']) . '` ADD INDEX `id_criterion2` ( `id_criterion`)');
					Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_cache_product_criterion_' . (int)($row ['id_search']) . '` ADD INDEX `id_cache_product` ( `id_cache_product`)');
				}
				$result = Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` WHERE `Field` = "price"');
				if ($result && Db::getInstance()->numRows())
					Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_product_price_' . (int)($row ['id_search']) . '` DROP `price`');
				$toAdd [] = array ('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'visible', 'tinyint(4)  NOT NULL DEFAULT "1"', 'level_depth' );
				$toAdd [] = array ('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'id_parent', 'int(10) unsigned DEFAULT NULL', 'level_depth' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']), 'show_all_depth', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'is_multicriteria' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']), 'only_children', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'is_multicriteria' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_'. (int)($row ['id_search']),'is_collapsed','tinyint(3) unsigned NOT NULL DEFAULT "0"');
				$toAdd [] = array ('pm_advancedsearch_criterion_group_'. (int)($row ['id_search']),'hidden','tinyint(3) unsigned NOT NULL DEFAULT "0"');
				$toAdd [] = array ('pm_advancedsearch_criterion_group_'. (int)($row ['id_search']),'range_nb','decimal(10,2) unsigned NOT NULL DEFAULT "15"');
				$toAdd [] = array ('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'single_value', 'varchar(255) default NULL', 'color' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']), 'range', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'is_multicriteria' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']), 'sort_by', 'varchar(10) default "position"', 'is_multicriteria' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']), 'sort_way', 'varchar(4) default "ASC"', 'is_multicriteria' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']).'_lang', 'range_sign', 'varchar(32) default NULL', 'icon' );
				$toAdd [] = array ('pm_advancedsearch_criterion_group_' . (int)($row ['id_search']).'_lang', 'range_interval', 'varchar(255) default NULL', 'icon' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'reduction_amount', 'decimal(20,6) NOT NULL default "0"', 'price_wt' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'is_specific', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'to' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'id_shop', 'int(10) unsigned DEFAULT "0"', 'id_criterion_group' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'id_specific_price', 'int(10) unsigned DEFAULT "0"', 'is_specific' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'valid_id_specific_price', 'int(10) unsigned DEFAULT "0"', 'id_specific_price' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'reduction_type', 'enum(\'amount\',\'percentage\')', 'reduction_amount' );
				$toAdd [] = array ('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'has_no_specific', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'is_specific' );
				$toAdd [] = array ('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'is_custom', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'visible' );
				$toChange [] = array ('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'position', 'int(10) unsigned DEFAULT "0"' );
				$indexToAdd[] = array('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'single_value', '`single_value`');
				$indexToAdd[] = array('pm_advancedsearch_criterion_' . (int)($row ['id_search']) . '_lang', 'value','`value`');
				$indexToAdd[] = array('pm_advancedsearch_criterion_' . (int)($row ['id_search']), 'is_custom', '`is_custom`');
				$indexToAdd[] = array('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'is_specific','`is_specific`');
				$indexToAdd[] = array('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'valid_id_specific_price','`valid_id_specific_price`');
				$indexToAdd[] = array('pm_advancedsearch_product_price_' . (int)($row ['id_search']), 'has_no_specific','`has_no_specific`');
				$indexToAdd[] = array('feature_value_lang', 'id_feature_value','`id_feature_value`');
				$indexToAdd[] = array('feature_value_lang', 'id_lang','`id_lang`');
				$indexToAdd[] = array('pm_advancedsearch_cache_product_criterion_' . (int)($row ['id_search']), 'id_criterion','`id_criterion`, `id_cache_product`');
				$primaryToAdd[] = array(
					'pm_advancedsearch_criterion_group_' . (int)($row ['id_search']).'_lang',
					'`id_criterion_group`, `id_lang`',
					'id_criterion_group',
				);
				$primaryToAdd[] = array(
					'pm_advancedsearch_criterion_' . (int)($row ['id_search']).'_lang',
					'`id_criterion`, `id_lang`',
					'id_criterion',
				);
				$primaryToAdd[] = array(
					'pm_advancedsearch_cache_product_criterion_' . (int)($row ['id_search']),
					'`id_criterion`, `id_cache_product`',
					'id_criterion',
				);
				$primaryToAdd[] = array(
					'pm_advancedsearch_product_price_' . (int)($row ['id_search']),
					'`id_cache_product` , `id_currency` , `id_country` , `id_group` , `price_wt` , `reduction_amount` , `from` , `to`',
					'id_product',
				);
			}
		}
		foreach($this->_static_tables as $table) {
			if (!Db::getInstance()->Execute('ALTER TABLE `'. _DB_PREFIX_ .pSQL($table).'` ENGINE=`MyISAM`'))
				$this->_errors[] = $this->l('Can\'t change engine for').' '. _DB_PREFIX_ .$table;
		}
		$toAdd [] = array ('pm_advancedsearch', 'keep_category_information', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'step_search' );
		$toAdd [] = array ('pm_advancedsearch', 'display_empty_criteria', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'step_search' );
		$toAdd [] = array ('pm_advancedsearch', 'recursing_indexing', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'step_search' );
		$toAdd [] = array ('pm_advancedsearch', 'share', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'step_search' );
		$toAdd [] = array ('pm_advancedsearch', 'search_results_selector', 'varchar(64) NOT NULL DEFAULT "#center_column"', 'share' );
		$toAdd [] = array ('pm_advancedsearch', 'smarty_var_name', 'varchar(64) NOT NULL', 'share' );
		$toAdd [] = array ('pm_advancedsearch', 'insert_in_center_column', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'share' );
		$toAdd [] = array ('pm_advancedsearch', 'collapsable_criterias', 'tinyint(3) unsigned NOT NULL DEFAULT "1"', 'share' );
		$toAdd [] = array ('pm_advancedsearch', 'reset_group', 'tinyint(3) unsigned NOT NULL DEFAULT "1"', 'share' );
		$toAdd [] = array ('pm_advancedsearch', 'unique_search', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'share' );
		$toAdd [] = array ('pm_advancedsearch', 'scrolltop_active', 'tinyint(3) unsigned NOT NULL DEFAULT "1"', 'unique_search' );
		$toAdd [] = array ('pm_advancedsearch', 'id_category_root', 'int(10) unsigned NOT NULL DEFAULT "0"', 'scrolltop_active' );
		$toAdd [] = array ('pm_advancedsearch', 'redirect_one_product', 'tinyint(3) unsigned NOT NULL DEFAULT "1"', 'id_category_root' );
		$toAdd [] = array ('pm_advancedsearch', 'add_anchor_to_url', 'tinyint(3) unsigned NOT NULL DEFAULT "0"', 'redirect_one_product' );
		$toChange [] = array ('pm_advancedsearch_seo', 'criteria', 'TEXT NOT NULL' );
		$toChange [] = array ('pm_advancedsearch', 'background_color', 'VARCHAR( 15 ) NULL' );
		$toChange [] = array ('pm_advancedsearch', 'border_color', 'VARCHAR( 7 ) NULL' );
		$toChange [] = array ('pm_advancedsearch', 'border_size', 'VARCHAR( 24 ) NULL' );
		$toChange [] = array ('pm_advancedsearch', 'color_group_title', 'VARCHAR( 7 ) NULL' );
		$toChange [] = array ('pm_advancedsearch', 'font_size_group_title', 'SMALLINT( 4 ) UNSIGNED NULL DEFAULT "0"' );
		$toChange [] = array ('pm_advancedsearch', 'border_radius', 'SMALLINT( 4 ) UNSIGNED NULL DEFAULT "0"' );
		$toChange [] = array ('pm_advancedsearch', 'color_title', 'VARCHAR( 7 ) NULL' );
		$toChange [] = array ('pm_advancedsearch', 'font_size_title', 'SMALLINT( 4 ) UNSIGNED NULL DEFAULT "0"' );
		$primaryToAdd[] = array(
				'pm_advancedsearch_seo_lang',
		'`id_seo`, `id_lang`',
	'id_seo',
		);
		$primaryToAdd[] = array(
			'pm_advancedsearch_lang',
			'`id_search`, `id_lang`',
			'id_search',
		);
		$primaryToAdd[] = array(
			'pm_advancedsearch_category',
			'`id_search`, `id_category`',
			'id_search',
		);
		$primaryToAdd[] = array(
			'pm_advancedsearch_seo_crosslinks',
			'`id_seo`, `id_seo_linked`',
			'id_seo',
		);
		if (sizeof($toAdd)) {
			foreach ($toAdd as $table => $infos) {
				if (!$this->columnExists($infos [0], $infos [1], true, $infos [2], (isset($infos[3]) ? $infos[3] : false))) {
					$isUpdate = false;
				}
			}
		}
		if (sizeof($toChange)) {
			foreach ($toChange as $table => $infos) {
				$resultset = Db::getInstance()->ExecuteS("SHOW COLUMNS FROM `" . _DB_PREFIX_ . $infos [0] . "` WHERE `Field` = '" . $infos [1] . "'");
				foreach ($resultset as $row) {
					if ($row ['Type'] != $infos [2]) {
						Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . $infos [0] . '` CHANGE `' . $infos [1] . '` `' . $infos [1] . '` ' . $infos [2] . '');
					}
				}
			}
		}
		if (sizeof($indexToAdd)) {
			foreach ($indexToAdd as $infos) {
				$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . $infos[0] . '` WHERE `Key_name` = "'.$infos[1].'"');
				if (!$result || !Db::getInstance()->numRows())
					Db::getInstance()->Execute('ALTER TABLE  `' . _DB_PREFIX_ . $infos[0] . '` ADD INDEX (  '.$infos[2].' )');
			}
		}
		if (sizeof($primaryToAdd)) {
			foreach ($primaryToAdd as $infos) {
				$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . $infos[0] . '` WHERE `Key_name` = "PRIMARY"');
				if (!$result || !Db::getInstance()->numRows()) {
					if (isset($infos[2])) {
						$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . $infos[0] . '` WHERE `column_name` = "'.$infos[2].'"');
						if ($result && Db::getInstance()->numRows())
							Db::getInstance()->Execute('ALTER TABLE  `' . _DB_PREFIX_ . $infos[0] . '` DROP INDEX `'.$infos[2].'`');
					}
					Db::getInstance()->Execute('ALTER TABLE  `' . _DB_PREFIX_ . $infos[0] . '` ADD PRIMARY KEY ('.$infos[1].')');
				}
			}
		}
		$seo = AdvancedSearchSeoClass::getSeoSearchs(false, true);
		$seo_url_updated = false;
		foreach ($seo as $row) {
			if (preg_match('#\{i:#', $row['criteria'])) break;
			$newCriteria = array();
			$criteria = explode(',', $row['criteria']);
			if (sizeof($criteria)) {
				foreach ($criteria AS $k => $value) {
					if (preg_match('/-/', $value))
						$id_criterion_group = AdvancedSearchCriterionGroupClass::getIdCriterionGroupByTypeAndIdLinked($row['id_search'],'price',0);
					else
						$id_criterion_group = AdvancedSearchCriterionClass::getIdCriterionGroupByIdCriterion($row['id_search'], $value);
					if (!$id_criterion_group) continue;
					$newCriteria[] = $id_criterion_group.'_'.$value;
					$save_seo = true;
				}
			}
			if (sizeof($newCriteria)) {
				$row['criteria'] = serialize($newCriteria);
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedsearch_seo', $row, 'UPDATE', 'id_seo = ' . (int) $row['id_seo']);
				if ($seo_url_updated) {
					Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'pm_advancedsearch_seo_lang` SET `seo_url` = REPLACE(`seo_url`,"/","-")');
					$seo_url_updated = true;
				}
			}
		}
		if ($updateShopTable) {
			$result = Db::getInstance()->ExecuteS('SELECT * FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_shop` ORDER BY `id_search` , `id_shop`');
			if ($result && self::_isFilledArray($result)) {
				$first_shop = array();
				foreach ($result as $row) {
					if (!isset($first_shop[$row['id_search']])) $first_shop[$row['id_search']] = $row['id_shop'];
					else continue;
				}
				foreach ($first_shop as $id_search => $id_shop) {
					Db::getInstance()->Execute('DELETE FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_shop` WHERE `id_search`='.(int)$id_search.' AND `id_shop`!='.(int)$id_shop);
				}
			}
		}
		if ($oldModuleVersion !== false && version_compare($oldModuleVersion, '4.10.0', '<=')) {
			$result = Db::getInstance()->ExecuteS('SELECT * FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_seo`');
			if ($result && self::_isFilledArray($result)) {
				foreach ($result as $row) {
					$criteria = unserialize($row['criteria']);
					$newSeoKey = $this->getSeoKeyFromCriteria($row['id_search'], $criteria, $row['id_currency']);
					if ($newSeoKey != $row['seo_key'])
						Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'pm_advancedsearch_seo` SET `seo_key`="' . pSQL($newSeoKey) . '" WHERE id_seo="' . (int)$row['id_seo'] . '"');
				}
			}
		}
		if ($oldModuleVersion !== false && version_compare($oldModuleVersion, '4.10.1', '<=')) {
			if (is_array($advanced_searchs_id) && sizeof($advanced_searchs_id)) {
				foreach ($advanced_searchs_id as $key => $row) {
					$result = Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$row['id_search'] . '` WHERE `Field` = "id_criterion_linked"');
					if ($result && Db::getInstance()->numRows()) {
						if (Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$row['id_search'].'_link` (`id_criterion`, `id_criterion_linked`) (SELECT `id_criterion`, `id_criterion_linked` FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$row['id_search'].'`)'))
							Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$row['id_search'] . '` DROP `id_criterion_linked`');
					}
					$criterionsCount = (int)Db::getInstance()->getValue('SELECT COUNT(*) FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$row['id_search'] . '`');
					$criterionsListCount = (int)Db::getInstance()->getValue('SELECT COUNT(*) FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$row['id_search'] . '_list`');
					if ($criterionsCount > 0 && $criterionsListCount == 0)
						Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$row['id_search'].'_list` (`id_criterion_parent`, `id_criterion`) (SELECT `id_criterion` AS `id_criterion_parent`, `id_criterion` FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$row['id_search'].'`)');
					$result = Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$row['id_search'] . '` WHERE `Field` = "criterions_list"');
					if ($result && Db::getInstance()->numRows()) {
						$result = Db::getInstance()->ExecuteS('SELECT `id_criterion`, `criterions_list` FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$row['id_search'].'`');
						if ($result && self::_isFilledArray($result)) {
							foreach ($result as $criterionRow) {
								if ($criterionRow['criterions_list'] != '' && !empty($criterionRow['criterions_list'])) {
									$criterionRow['criterions_list'] = array_unique(explode(',', $criterionRow['criterions_list']));
									if (self::_isFilledArray($criterionRow['criterions_list']))
										foreach ($criterionRow['criterions_list'] as $k=>$idCriterionToAdd)
											if (empty($idCriterionToAdd) || !is_numeric($idCriterionToAdd))
												unset($criterionRow['criterions_list'][$k]);
								}
								if (self::_isFilledArray($criterionRow['criterions_list'])) {
									$idCriterionToAddList = array();
									foreach ($criterionRow['criterions_list'] as $idCriterionToAdd) {
										$idCriterionToAddList[] = (int)$idCriterionToAdd;
										AdvancedSearchCriterionClass::addCriterionToList((int)$row['id_search'], $criterionRow['id_criterion'], $idCriterionToAdd);
									}
									AdvancedSearchCriterionClass::populateCriterionsLink((int)$row['id_search'], $criterionRow['id_criterion'], false, $idCriterionToAddList);
								} else {
									AdvancedSearchCriterionClass::addCriterionToList((int)$row['id_search'], $criterionRow['id_criterion'], $criterionRow['id_criterion']);
								}
							}
						}
						Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$row['id_search'] . '` DROP `criterions_list`');
					}
				}
			}
		}
		return;
	}
	private function columnExists($table, $column, $createIfNotExist = false, $type = false, $insertAfter = false) {
		$resultset = Db::getInstance()->ExecuteS("SHOW COLUMNS FROM `" . _DB_PREFIX_ . $table . "`");
		foreach ($resultset as $row )
			if ($row ['Field'] == $column)
				return true;
		if ($createIfNotExist && Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . $table . '` ADD `' . $column . '` ' . $type . ' ' . ($insertAfter ? ' AFTER `' . $insertAfter . '`' : '') . ''))
			return true;
		return false;
	}
	public function updateAdvancedStyles($css_styles) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive())
			$advanced_css_file_db = Configuration::updateGlobalValue('PM_'.self::$_module_prefix.'_ADVANCED_STYLES', base64_encode($css_styles));
		else
			$advanced_css_file_db = Configuration::updateValue('PM_'.self::$_module_prefix.'_ADVANCED_STYLES', base64_encode($css_styles));
		$this->generateCss();
	}
	public function getAdvancedStylesDb() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive())
			$advanced_css_file_db = Configuration::getGlobalValue('PM_'.self::$_module_prefix.'_ADVANCED_STYLES');
		else
			$advanced_css_file_db = Configuration::get('PM_'.self::$_module_prefix.'_ADVANCED_STYLES');
		if ($advanced_css_file_db !== false)
			return base64_decode($advanced_css_file_db);
		return false;
	}
	public function displayAdvancedConfig() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive())
			$advanced_css_file = str_replace('.css','-'.$this->_context->shop->id.'.css',dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE);
		else
			$advanced_css_file = dirname(__FILE__) . '/' . self::ADVANCED_CSS_FILE;
		if ($this->getAdvancedStylesDb() == false) {
			if (file_exists($advanced_css_file) && is_readable($advanced_css_file) && strlen(file_get_contents($advanced_css_file)) > 0)
				$this->updateAdvancedStyles(file_get_contents($advanced_css_file));
			else
				$this->updateAdvancedStyles("/* Advanced Search 4 - Advanced Styles Content */\n");
		}
		$this->_html .= '<form action="' . $this->_base_config_url . '#config-2" id="formAdvancedStyles_' . $this->name . '" name="formAdvancedStyles_' . $this->name . '" method="post">
		<div class="dynamicTextarea"><textarea name="advancedConfig" id="advancedConfig" cols="120" rows="30">' . $this->getAdvancedStylesDb() . '</textarea>
		</div>';
		$this->_pmClear();
		$this->_html .= '<br /><center>
	            <input type="submit" value="' . $this->l('   Save   ') . '" name="submitAdvancedConfig" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" />
	          </center></form>
		  <script type="text/javascript">
		   var editor = CodeMirror.fromTextArea(document.getElementById("advancedConfig"), {});
		  </script>';
		$this->_pmClear();
	}
	public function displayMaintenance() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false, $this->_context->shop->id);
		else
			$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);
		if (self::_isFilledArray($advanced_searchs_id)) {
			$this->_html .= '<script type="text/javascript">';
			$this->_html .= 'var criteriaGroupToReindex = [];';
			$key = 0;
			foreach ($advanced_searchs_id as $row) {
				$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexed($row ['id_search'], $this->_cookie->id_lang, false);
				if (self::_isFilledArray($criterions_groups_indexed)) {
					foreach ($criterions_groups_indexed as $criterions_group_indexed) {
						$this->_html .= 'criteriaGroupToReindex['.$key.'] = {"id_search" : '.$row ['id_search'].', "id_criterion_group" : '.(int)$criterions_group_indexed ['id_criterion_group'].'};';
						$key++;
					}
				}
			}
			$this->_html .= '</script>';
		}
		$this->_html .= '<h2>' . $this->l('Reindex all the search engines') . '</h2>';
		$this->_html .= '<a href="javascript:void(0);" id="reindexAllSearchLink" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="padding:7px 5px;">' . $this->l('Reindexing all advanced search') . '</a><div class="progressbar_wrapper"><div class="progressbar" id="progressbarReindexAllSearch"></div><div class="progressbarpercent"></div></div>';
		$this->_html .= '<script type="text/javascript">';
		$this->_html .= '$jqPm("#reindexAllSearchLink").unbind("click").bind("click",function() {reindexSearchCritriaGroups($jqPm("#reindexAllSearchLink"),criteriaGroupToReindex,"#progressbarReindexAllSearch");});';
		$this->_html .= '</script>';
		$this->_html .= '<h2>' . $this->l('Clear all modules tables') . '</h2>';
		$this->_html .= '<div class="warning">' . $this->l('Warning ! This will delete all your advanced searches & configuration.') . '</h2></div>';
		$this->_html .= '<a href="'.$this->_base_config_url . '&pm_load_function=processClearAllTables" title="' . $this->l('This will remove all search\'s tables and datas! Are you sure?') . '" class="ajax_script_load ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only pm_confirm" style="padding:7px 5px;">' . $this->l('Clear all advanced searches') . '</a>';
	}
	public static function moduleIsInstalled($moduleName) {
		Db::getInstance()->ExecuteS('SELECT `id_module` FROM `' . _DB_PREFIX_ . 'module` WHERE `name` = \'' . pSQL($moduleName) . '\' AND `active` = 1');
		return (bool)Db::getInstance()->NumRows();
	}
	public function generateCssGradientBackground($selector, $background_color) {
		$css = '';
		$background_color = explode($this->gradient_separator, $background_color);
		if (isset($background_color [1])) {
			$color1 = htmlentities($background_color [0], ENT_COMPAT, 'UTF-8');
			$color2 = htmlentities($background_color [1], ENT_COMPAT, 'UTF-8');
			$css = $selector . ' {background: ' . $color1 . ';background: -webkit-gradient(linear, 0 0, 0 bottom, from(' . $color1 . '), to(' . $color2 . '));background: -moz-linear-gradient(' . $color1 . ', ' . $color2 . ');background: linear-gradient(' . $color1 . ', ' . $color2 . ');-pie-background: linear-gradient(' . $color1 . ', ' . $color2 . ');}';
		} else {
			$css = $selector . ' {background-color:' . htmlentities($background_color [0], ENT_COMPAT, 'UTF-8') . '!important;filter: none!important; }';
		}
		return $css;
	}
	public function generateCssBorderRadius($selector, $size) {
		$css = $selector . ' {-moz-border-radius:' . (int)$size . 'px;-webkit-border-radius:' . (int)$size . 'px;border-radius:' . (int)$size . 'px;behavior: url(' . $this->_path . 'js/PIE.htc);}';
		return $css;
	}
	public function generateCss() {
		$advanced_searchs = AdvancedSearchClass::getSearchs($this->_cookie->id_lang, false, false);
		$css = array();
		foreach ($advanced_searchs as $advanced_search) {
			if (in_array($advanced_search ['id_hook'], $this->display_horizontal_search_block)) {
				if ($advanced_search ['width'])
					$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' {width:' . (int)$advanced_search ['width'] . 'px;}';
				if ($advanced_search ['height'])
					$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' {height:' . (int)$advanced_search ['height'] . 'px;}';
				if ($advanced_search ['background_color'])
					$css [] = $this->generateCssGradientBackground('#PM_ASBlockOutput_' . $advanced_search ['id_search'], $advanced_search ['background_color']);
				if ($advanced_search ['border_color'])
					$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' {border-color:' . htmlentities($advanced_search ['border_color'], ENT_COMPAT, 'UTF-8') . ';}';
				if ($advanced_search ['border_size'])
					$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' {border-width:' . htmlentities($advanced_search ['border_size'], ENT_COMPAT, 'UTF-8') . '!important;}';
				if ($advanced_search ['border_radius'])
					$css [] = $this->generateCssBorderRadius('#PM_ASBlockOutput_' . $advanced_search ['id_search'], $advanced_search ['border_radius']);
				if ($advanced_search ['color_title'])
					$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' .PM_ASearchTitle {color:' . htmlentities($advanced_search ['color_title'], ENT_COMPAT, 'UTF-8') . ';}';
				if ($advanced_search ['font_size_title'])
					$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' .PM_ASearchTitle {font-size:' . (int)$advanced_search ['font_size_title'] . 'px!important;}';
			}
			if ($advanced_search ['color_group_title'])
				$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' .PM_ASCriterionsGroupTitle {color:' . htmlentities($advanced_search ['color_group_title'], ENT_COMPAT, 'UTF-8') . ';}';
			if ($advanced_search ['font_size_group_title'])
				$css [] = '#PM_ASBlockOutput_' . $advanced_search ['id_search'] . ' .PM_ASCriterionsGroupTitle {font-size:' . (int)$advanced_search ['font_size_group_title'] . 'px!important;}';
			$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexed($advanced_search ['id_search'], $this->_cookie->id_lang);
			foreach ($criterions_groups_indexed as $criterions_group) {
				if ($advanced_search ['show_hide_crit_method'] == 3 && $criterions_group ['overflow_height'])
					$css [] = '#PM_ASCriterions_' . $advanced_search ['id_search'] . '_' . $criterions_group ['id_criterion_group'] . ' .PM_ASCriterionsGroupOuter {overflow:auto;height:' . (int)$criterions_group ['overflow_height'] . 'px;}';
				if (in_array($advanced_search ['id_hook'], $this->display_horizontal_search_block) && $criterions_group ['width'])
					$css [] = '#PM_ASCriterionsGroup_' . $advanced_search ['id_search'] . '_' . $criterions_group ['id_criterion_group'] . ' {width:' . (int)$criterions_group ['width'] . 'px!important;}';
			}
		}
		$advanced_styles = "\n".$this->getAdvancedStylesDb();
		if (is_writable(dirname(__FILE__) . '/css/') && is_writable(dirname(__FILE__) . '/' . self::DYN_CSS_FILE)) {
			if (sizeof($css))
				file_put_contents(dirname(__FILE__) . '/' . self::DYN_CSS_FILE, implode(" ", $css).$advanced_styles);
			else
				file_put_contents(dirname(__FILE__) . '/' . self::DYN_CSS_FILE, ''.$advanced_styles);
		} else {
			if (!is_writable(dirname(__FILE__) . '/css/')) {
				$this->errors[] = $this->_showWarning($this->l('Please set write permision to folder:'). ' '.dirname(__FILE__) . '/css/');
			}
			if (!is_writable(dirname(__FILE__) . '/' . self::DYN_CSS_FILE)) {
				$this->errors[] = $this->l('Please set write permision to file:'). ' '.dirname(__FILE__) . '/' . self::DYN_CSS_FILE;
			}
		}
	}
	public function getCriterionsGroupsValue($id_lang) {
		$criterions_groups = array();
		$attributes_groups = AdvancedSearchClass::getAttributesGroups($id_lang);
		foreach ($attributes_groups as $row )
			$criterions_groups [] = array ('id' => $row ['id_attribute_group'], 'name' => $row ['public_name'], 'type' => 'attribute' );
		$features = AdvancedSearchClass::getFeatures($id_lang);
		foreach ($features as $row)
			$criterions_groups [] = array ('id' => $row ['id_feature'], 'name' => $row ['name'], 'type' => 'feature' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Manufacturer'), 'type' => 'manufacturer' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Supplier'), 'type' => 'supplier' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('All category levels'), 'type' => 'category' );
		$categories_level_depth = AdvancedSearchClass::getCategoriesLevelDepth();
		foreach ($categories_level_depth as $category_level_depth) {
			$criterions_groups [] = array ('id' => $category_level_depth ['level_depth'], 'name' => $this->l('Categories level') . ' ' . $category_level_depth ['level_depth'], 'type' => 'category' );
		}
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Price'), 'type' => 'price' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('On sale'), 'type' => 'on_sale' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('In stock'), 'type' => 'stock' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Available for order'), 'type' => 'available_for_order' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Only online'), 'type' => 'online_only' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Condition'), 'type' => 'condition' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Width'), 'type' => 'width' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Height'), 'type' => 'height' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Depth'), 'type' => 'depth' );
		$criterions_groups [] = array ('id' => 0, 'name' => $this->l('Weight'), 'type' => 'weight' );
		return $criterions_groups;
	}
	public function displayErrorsJs($with_script = true) {
		if (sizeof($this->errors)) {
			$this->_html .= '<script type="text/javascript">
			parent.hidePageLoader();
			';
			foreach ($this->errors as $key => $error )
				$this->_html .= 'parent.parent.show_error("' . $error . '");';
			$this->_html .= '</script>';
		}
	}
	private function _postProcessSearch() {
		$id_search = Tools::getValue('id_search', false);
		$ObjAdvancedSearchClass = new AdvancedSearchClass($id_search);
		$reindexing_categories = false;
		$index_filter_by_emplacement = false;
		$desindex_filter_by_emplacement = false;
		$this->_cleanOutput(true);
		if (!Tools::getValue('bool_cat'))
			$_POST['categories_association'] = array();
		if (!Tools::getValue('bool_prod'))
			$_POST['products_association'] = array();
		if (!Tools::getValue('bool_manu'))
			$_POST['manufacturers_association'] = array();
		if (!Tools::getValue('bool_supp'))
			$_POST['suppliers_association'] = array();
		if (!Tools::getValue('bool_spe'))
			$_POST['special_pages_association'] = array();
		$this->errors = self::_retroValidateController($ObjAdvancedSearchClass);
		$_POST['background_color'] = $this->_getGradientFromArray('background_color');
		$_POST['border_size'] = $this->_getBorderSizeFromArray(Tools::getValue('border_size'));
		if ($id_search && Tools::getValue('recursing_indexing') != $ObjAdvancedSearchClass->recursing_indexing) {
			$reindexing_categories = true;
		}
		if (Tools::getValue('filter_by_emplacement') && !$ObjAdvancedSearchClass->filter_by_emplacement)
			$index_filter_by_emplacement = true;
		elseif (!Tools::getValue('filter_by_emplacement') && $ObjAdvancedSearchClass->filter_by_emplacement)
			$desindex_filter_by_emplacement = true;
		if (!sizeof($this->errors)) {
			$this->copyFromPost($ObjAdvancedSearchClass);
			if (!$ObjAdvancedSearchClass->save())
				$this->errors [] = $this->l('Error while saving');
			if (!sizeof($this->errors)) {
				if (!$id_search && !$this->installDBCache($ObjAdvancedSearchClass->id))
					$this->errors [] = $this->l('Error while making cache table');
				elseif (!$id_search && !$ObjAdvancedSearchClass->addCacheProduct())
					$this->errors [] = $this->l('Error while creating products index');
				elseif ($id_search && !$ObjAdvancedSearchClass->updateCacheProduct())
					$this->errors [] = $this->l('Error while creating products index');
				if ($index_filter_by_emplacement) {
					AdvancedSearchClass::indexFilterByEmplacement($ObjAdvancedSearchClass->id);
				} elseif ($desindex_filter_by_emplacement)
					AdvancedSearchClass::desIndexFilterByEmplacement($ObjAdvancedSearchClass->id);
				if ($reindexing_categories) {
					AdvancedSearchClass::reindexingCategoriesGroups($ObjAdvancedSearchClass);
				}
				$this->generateCss();
				$this->_html .= '<script type="text/javascript">';
				if (!$id_search)
					$this->_html .= 'parent.parent.addTabPanel("#wrapAsTab","' . $ObjAdvancedSearchClass->internal_name . '",' . $ObjAdvancedSearchClass->id . ', true, '.(int)version_compare(_PS_VERSION_, '1.6.0.0', '>=').');';
				else {
					$this->_html .= 'parent.parent.loadTabPanel("#wrapAsTab","li#TabSearchAdminPanel' . $ObjAdvancedSearchClass->id . '","ul#asTab",' . $ObjAdvancedSearchClass->id . ');';
					$this->_html .= 'parent.parent.updateSearchNameIntoTab("li#TabSearchAdminPanel' . $ObjAdvancedSearchClass->id . '", '.Tools::jsonEncode($ObjAdvancedSearchClass->internal_name).');';
				}
				$this->_html .= 'parent.parent.show_info("' . $this->l('Search has been updated successfully') . '");parent.parent.closeDialogIframe();';
				$this->_html .= '</script>';
			}
		}
		$this->displayErrorsJs();
		$this->_echoOutput(true);
	}
	private function _postProcessCriteria() {
		$id_search = Tools::getValue('id_search', false);
		$id_criterion = Tools::getValue('id_criterion', false);
		$key_criterions_group = Tools::getValue('key_criterions_group', false);
		$return = '';
		if (!$id_search || !$id_criterion)
			$return .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('An error occured') . '");</script>';
		else {
			$objAdvancedSearchCriterionClass = new AdvancedSearchCriterionClass($id_criterion, $id_search);
			$update = $this->_uploadImageLang($objAdvancedSearchCriterionClass, 'icon', '/modules/pm_advancedsearch4/search_files/criterions/', '-' . $id_search);
			if (is_array($update) && sizeof($update))
				foreach ($update as $error)
					$return .= '<script type="text/javascript">parent.parent.show_error("' . $error . '");</script>';
			elseif ($update)
				$objAdvancedSearchCriterionClass->save();
			$return .= '<script type="text/javascript">parent.parent.closeDialogIframe();parent.parent.getCriterionGroupActions("' . $key_criterions_group . '",true);parent.parent.show_info("' . $this->l('Saved') . '");</script>';
		}
		self::_cleanBuffer();
		echo $return;
		die();
	}
	private function _postProcessSeoSearch() {
		$id_search = Tools::getValue('id_search', false);
		$id_seo = Tools::getValue('id_seo', false);
		$id_currency = Tools::getValue('id_currency', false);
		if (!$id_currency)
			$id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
		self::_cleanBuffer();
		$return = '';
		if (!$id_search)
			$return .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('An error occured') . '");</script>';
		else {
			$seo_key = $this->getSeoKeyFromCriteria($id_search, explode(',', Tools::getValue('criteria')), $id_currency);
			if (!$id_seo)
				$id_seo = AdvancedSearchSeoClass::seoDeletedExists($seo_key);
			if (!$id_seo && AdvancedSearchSeoClass::seoExists($seo_key)) {
				$return .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('This SEO result page already exists') . '");</script>';
			} else {
				$objAdvancedSearchSeoClass = new AdvancedSearchSeoClass($id_seo);
				$this->copyFromPost($objAdvancedSearchSeoClass);
				$objAdvancedSearchSeoClass->seo_key = $seo_key;
				$objAdvancedSearchSeoClass->deleted = 0;
				$error = $objAdvancedSearchSeoClass->validateFields(false, true);
				$errorLang = $objAdvancedSearchSeoClass->validateFieldsLang(false, true);
				if ($error !== true)
					$return .= '<script type="text/javascript">parent.parent.show_error("' . addcslashes($error, '"') . '");</script>';
				if ($errorLang !== true)
					$return .= '<script type="text/javascript">parent.parent.show_error("' . addcslashes($errorLang, '"') . '");</script>';
				elseif ($objAdvancedSearchSeoClass->save()) {
					$return .= '<script type="text/javascript">parent.parent.show_info("' . $this->l('Saved') . '");parent.parent.reloadPanel("seo_search_panel_' . (int)$id_search . '");parent.parent.closeDialogIframe();</script>';
				}
				else {
					$return .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('Error while updating seo search') . '");</script>';
				}
			}
		}
		$this->generateSeoGSiteMap();
		echo $return;
		die();
	}
	public static function str2url($str) {
		if (function_exists('mb_strtolower'))
			$str = mb_strtolower($str, 'utf-8');
		$str = trim($str);
		$str = preg_replace('/[\x{0105}\x{0104}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}]/u','a', $str);
		$str = preg_replace('/[\x{00E7}\x{010D}\x{0107}\x{0106}]/u','c', $str);
		$str = preg_replace('/[\x{010F}]/u','d', $str);
		$str = preg_replace('/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{011B}\x{0119}\x{0118}]/u','e', $str);
		$str = preg_replace('/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}]/u','i', $str);
		$str = preg_replace('/[\x{0142}\x{0141}\x{013E}\x{013A}]/u','l', $str);
		$str = preg_replace('/[\x{00F1}\x{0148}]/u','n', $str);
		$str = preg_replace('/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}\x{00D3}]/u','o', $str);
		$str = preg_replace('/[\x{0159}\x{0155}]/u','r', $str);
		$str = preg_replace('/[\x{015B}\x{015A}\x{0161}]/u','s', $str);
		$str = preg_replace('/[\x{00DF}]/u','ss', $str);
		$str = preg_replace('/[\x{0165}]/u','t', $str);
		$str = preg_replace('/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{016F}]/u','u', $str);
		$str = preg_replace('/[\x{00FD}\x{00FF}]/u','y', $str);
		$str = preg_replace('/[\x{017C}\x{017A}\x{017B}\x{0179}\x{017E}]/u','z', $str);
		$str = preg_replace('/[\x{00E6}]/u','ae', $str);
		$str = preg_replace('/[\x{0153}]/u','oe', $str);
		$str = preg_replace('/[^a-zA-Z0-9\s\'\:\/\[\]-]/','', $str);
		$str = preg_replace('/[\s\'\:\/\[\]-]+/',' ', $str);
		$str = preg_replace('/[ ]/','-', $str);
		$str = preg_replace('/[\/]/','-', $str);
		$str = strtolower($str);
		return $str;
	}
	public function getSeoStrings($criteria, $id_search, $id_currency, $fields_to_get = false) {
		$fieldToFill = array ('meta_title', 'meta_description', 'meta_keywords', 'title', 'seo_url' );
		$fieldWithGroupName = array ('meta_title', 'meta_description' );
		$groupTypeWithoutGroupName = array ('category', 'supplier', 'manufacturer' );
		$offersSelectionStr = $this->translateMultiple('offers_selection');
		$betweenLangStr = $this->translateMultiple('from');
		$andLangStr = $this->translateMultiple('to');
		foreach ($criteria as $k => $value) {
			$info_criterion = explode('_', $value);
			if (isset($info_criterion[2])) {
				$id_criterion_group = $info_criterion[1];
				$id_criterion = $info_criterion[2];
			}else {
				$id_criterion_group = $info_criterion[0];
				$id_criterion = $info_criterion[1];
			}
			if (!isset($newCriteria [$id_criterion_group]))
				$newCriteria [$id_criterion_group] = array();
			$newCriteria [$id_criterion_group] [] = $id_criterion;
		}
		foreach ($this->_languages as $language) {
			foreach ($criteria as $k => $criterion) {
				$endLoop = (($k + 1) == sizeof($criteria));
				$info_criterion = explode('_', $criterion);
				if (isset($info_criterion[2])) {
					$id_criterion_group = $info_criterion[1];
					$id_criterion = $info_criterion[2];
				} else {
					$id_criterion_group = $info_criterion[0];
					$id_criterion = $info_criterion[1];
				}
				$isPriceCriterion = false;
				$objAdvancedSearchCriterionGroupClass = new AdvancedSearchCriterionGroupClass($id_criterion_group, $id_search);
				if (preg_match('#-#', $id_criterion)) {
					$isPriceCriterion = true;
					$range = explode('-', $id_criterion);
					$currency = new Currency($id_currency);
					$min = $range [0];
					$max = Tools::displayPrice($range[1], $currency);
					$citerion_value = $betweenLangStr [$language ['id_lang']] . ' ' . $min . ' ' . $andLangStr [$language ['id_lang']] . ' ' . $max;
				} else {
					$objAdvancedSearchCriterionClass = new AdvancedSearchCriterionClass($id_criterion, $id_search, $language ['id_lang']);
					$citerion_value = (!$objAdvancedSearchCriterionClass->value && $objAdvancedSearchCriterionClass->single_value ? $objAdvancedSearchCriterionClass->single_value : trim($objAdvancedSearchCriterionClass->value));
				}
				foreach ($fieldToFill as $k2 => $field) {
					if ($fields_to_get && ! in_array($field, $fields_to_get))
						continue;
					if (!$k && $field == 'meta_description')
						@$defaultReturnSeoStr [$language ['id_lang']] [$field] .= Configuration::get('PS_SHOP_NAME') . ' ' . $offersSelectionStr [$language ['id_lang']] . ' ';
					if (!$isPriceCriterion && in_array($field, $fieldWithGroupName) and ! in_array($objAdvancedSearchCriterionGroupClass->criterion_group_type, $groupTypeWithoutGroupName)) {
						@$defaultReturnSeoStr [$language ['id_lang']] [$field] .= $objAdvancedSearchCriterionGroupClass->name[$language ['id_lang']] . ' ';
					}
					if ($field == 'seo_url')
						@$defaultReturnSeoStr [$language ['id_lang']] [$field] .= self::str2url($citerion_value) . (!$endLoop ? '-' : '');
					else
						@$defaultReturnSeoStr [$language ['id_lang']] [$field] .= $citerion_value . (!$endLoop && ($field == 'meta_title' || $field == 'meta_description' || $field == 'meta_keywords') ? ', ' : ($endLoop ? '' : ' '));
				}
			}
		}
		return $defaultReturnSeoStr;
	}
	private function _cartesianReOrder($array) {
		$current = array_shift($array);
		if (count($array) > 0) {
			$results = array();
			$temp = $this->_cartesianReOrder($array);
			foreach ($current as $value)
				foreach ($temp as $value2)
					$results[] = $value . ',' . $value2;
			return $results;
		} else {
			return $current;
		}
	}
	public static function getArrayCriteriaFromSeoArrayCriteria($criteria) {
		$newCriteria = array();
		foreach ($criteria as $k => $value) {
			$info_criterion = explode('_', $value);
			if (isset($info_criterion[2])) {
				$id_criterion_group = (int)$info_criterion[1];
				$id_criterion = $info_criterion[2];
			} else {
				$id_criterion_group = (int)$info_criterion[0];
				$id_criterion = $info_criterion[1];
			}
			$id_criterion = preg_replace('/[^0-9.,-]/', '', $id_criterion);
			if (!isset($newCriteria[$id_criterion_group]))
				$newCriteria[$id_criterion_group] = array();
			$newCriteria[$id_criterion_group][] = $id_criterion;
		}
		return $newCriteria;
	}
	private function countProductFromSeoCriteria($id_search, $criteria, $id_currency) {
		if (self::_isFilledArray($criteria) && $criteria[0]) {
			$selected_criteria_groups_type = array();
			$newCriteria = self::getArrayCriteriaFromSeoArrayCriteria($criteria);
			if (sizeof($newCriteria)) {
				$selected_criteria_groups_type = AdvancedSearchClass::getCriterionGroupsTypeAndDisplay($id_search, array_keys($newCriteria));
			}
			$search = AdvancedSearchClass::getSearch($id_search, $this->_cookie->id_lang,false);
			$search = $search[0];
			$resultTotalProducts = Db::getInstance()->getRow(AdvancedSearchClass::getQueryCountResults($search, $this->_cookie->id_lang, $newCriteria, $selected_criteria_groups_type, $id_currency));
		}
		$total_product = isset($resultTotalProducts) ? $resultTotalProducts ['total'] : 0;
		return $total_product;
	}
	private function _seoCriterionSort($criterions) {
		if (is_array($criterions)) {
			asort($criterions);
			foreach ($criterions as $k=>$criterionList) {
				if (is_array($criterions[$k]))
					$criterions[$k] = $this->_seoCriterionSort($criterions[$k]);
			}
		}
		return $criterions;
	}
	private function getSeoKeyFromCriteria($id_search, $criteria, $id_currency) {
		if (!$id_currency)
			$id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
		if (is_array($criteria))
			$criteria = $this->_seoCriterionSort($criteria);
		$criteria = str_replace('biscriterion_', '', $criteria);
		$seo_key = (int)$id_search . '-' . implode('-', $criteria) . '-' . (int)$id_currency;
		$seo_key = md5($seo_key);
		return $seo_key;
	}
	private function _postProcessMassSeoSearch() {
		$id_search = Tools::getValue('id_search', false);
		$id_currency = Tools::getValue('id_currency', false);
		if (!$id_currency)
			$id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
		self::_cleanBuffer();
		$return = '';
		if (!$id_search)
			$return .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('An error occured') . '");</script>';
		else {
			$criteria_groups = explode(',', Tools::getValue('criteria_groups', ''));
			$criteria = Tools::getValue('criteria', false);
			$seoIds = array();
			if (!sizeof($criteria_groups) || ! sizeof($criteria))
				$return .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('Please select at least one criteria') . '");</script>';
			else {
				$criteria_reorder = array();
				foreach ($criteria_groups as $key_criterion_group) {
					$id_criterion_group = self::parseInt($key_criterion_group);
					if (isset($criteria [$id_criterion_group]) && sizeof($criteria [$id_criterion_group]))
						$criteria_reorder [] = $criteria [$id_criterion_group];
				}
				$criteria_cartesian = $this->_cartesianReOrder($criteria_reorder);
				foreach ($criteria_cartesian as $k => $criteria_final_str) {
					$criteria_final = explode(',', $criteria_final_str);
					$resultTotalProducts = $this->countProductFromSeoCriteria($id_search, $criteria_final, $id_currency);
					if (!$resultTotalProducts)
						continue;
					$seo_key = $this->getSeoKeyFromCriteria($id_search, $criteria_final, $id_currency);
					$cur_id_seo = AdvancedSearchSeoClass::seoDeletedExists($seo_key);
					if ($cur_id_seo)
						AdvancedSearchSeoClass::undeleteSeoBySeoKey($seo_key);
					$defaultReturnSeoStr = $this->getSeoStrings($criteria_final, $id_search, $id_currency);
					$objAdvancedSearchSeoClass = new AdvancedSearchSeoClass($cur_id_seo);
					$objAdvancedSearchSeoClass->id_search = $id_search;
					$objAdvancedSearchSeoClass->criteria = $criteria_final_str;
					$objAdvancedSearchSeoClass->seo_key = $seo_key;
					foreach ($defaultReturnSeoStr as $id_lang => $fields) {
						foreach ($fields as $field => $fieldValue) {
							$objAdvancedSearchSeoClass->{$field} [$id_lang] = $fieldValue;
						}
					}
					$error = $objAdvancedSearchSeoClass->validateFields(false, true);
					$errorLang = $objAdvancedSearchSeoClass->validateFieldsLang(false, true);
					if ($error !== true)
						$return .= '<script type="text/javascript">parent.parent.show_error("' . addcslashes($error, '"') . '");</script>';
					elseif ($errorLang !== true)
						$return .= '<script type="text/javascript">parent.parent.show_error("' . addcslashes($errorLang, '"') . '");</script>';
					else {
						$objAdvancedSearchSeoClass->save();
						$seoIds [] = $objAdvancedSearchSeoClass->id;
					}
				}
				if (sizeof($seoIds)) {
					foreach ($seoIds as $id_seo) {
						foreach ($seoIds as $id_seo2) {
							if ($id_seo == $id_seo2)
								continue;
							$row = array ('id_seo' => intval($id_seo), 'id_seo_linked' => intval($id_seo2) );
							Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedsearch_seo_crosslinks', $row, 'INSERT');
						}
					}
				}
				$return .= '<script type="text/javascript">parent.parent.show_info("' . $this->l('Saved') . '");parent.parent.reloadPanel("seo_search_panel_' . (int)$id_search . '");parent.parent.closeDialogIframe();</script>';
			}
		}
		$this->generateSeoGSiteMap();
		echo $return;
		die();
	}
	private function _postProcessSeoRegenerate() {
		$id_search = Tools::getValue('id_search', false);
		$fields_to_regenerate = Tools::getValue('fields_to_regenerate', false);
		self::_cleanBuffer();
		if (!$id_search)
			$this->_html .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('An error occured') . '");</script>';
		if (!$fields_to_regenerate || ! sizeof($fields_to_regenerate))
			$this->_html .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('You must select at least one field to regenerate') . '");</script>';
		else {
			$seoSearchs = AdvancedSearchSeoClass::getSeoSearchs($this->_cookie->id_lang, false, $id_search);
			foreach ($seoSearchs as $row) {
				$defaultReturnSeoStr = $this->getSeoStrings(unserialize($row ['criteria']), $id_search, $row ['id_currency'], $fields_to_regenerate);
				if ($defaultReturnSeoStr && is_array($defaultReturnSeoStr) && sizeof($defaultReturnSeoStr)) {
					$objAdvancedSearchSeoClass = new AdvancedSearchSeoClass($row ['id_seo']);
					$objAdvancedSearchSeoClass->id_search = $id_search;
					foreach ($defaultReturnSeoStr as $id_lang => $fields) {
						foreach ($fields as $field => $fieldValue) {
							$objAdvancedSearchSeoClass->{$field} [$id_lang] = $fieldValue;
						}
					}
					$error = $objAdvancedSearchSeoClass->validateFields(false, true);
					$errorLang = $objAdvancedSearchSeoClass->validateFieldsLang(false, true);
					if ($error !== true)
						$this->_html .= '<script type="text/javascript">parent.parent.show_error("' . addcslashes($error, '"') . '");</script>';
					elseif ($errorLang !== true)
						$this->_html .= '<script type="text/javascript">parent.parent.show_error("' . addcslashes($errorLang, '"') . '");</script>';
					else {
						if (!$objAdvancedSearchSeoClass->save())
							$this->_html .= '<script type="text/javascript">parent.parent.show_error("' . $this->l('Error while updating seo search') . '");</script>';
					}
				}
			}
			$this->_html .= '<script type="text/javascript">parent.parent.show_info("' . $this->l('Seo data regenerated successfully') . '");parent.parent.reloadPanel("seo_search_panel_' . (int)$id_search . '");parent.parent.closeDialogIframe();</script>';
		}
		$this->generateSeoGSiteMap();
		echo $this->_html;
		die();
	}
	public static function parseInt($string) {
		if (preg_match('/(\d+)/', $string, $array)) {
			return $array [1];
		}
		else {
			return 0;
		}
	}
	public function saveAdvancedConfig() {
		if (Tools::getValue('submitAdvancedConfig')) {
			$this->updateAdvancedStyles(Tools::getValue('advancedConfig'));
			$this->_html .= $this->displayConfirmation($this->l('Styles updated successfully'));
		}
	}
	public function checkRewriteRule() {
		$htaccess = file_get_contents($this->_htFile);
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$rule_match = 'index.php?fc=module&module=pm_advancedsearch4&controller=advancedsearch4&isolang=$1&id_seo=$2&seo_url=$3';
		else
			$rule_match = 'RewriteCond %{QUERY_STRING} ^id_seo=([0-9]+)&seo_url=([a-zA-Z0-9/_-]*)';
		if (!preg_match('#'.preg_quote($rule_match).'#', $htaccess))
			return false;
		if (!preg_match('#\^\(\[a-z\]\{2\}\)\?\/\?s/#', $htaccess))
			return false;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive()) {
			foreach (array_values(Shop::getCompleteListOfShopsID()) AS $id_shop) {
				$shopUrl = new Shop($id_shop);
				$base_uri = $shopUrl->virtual_uri;
				if (!preg_match('#\^'.str_replace('\-', '-', preg_quote($base_uri)).'\(\[a-z\]\{2\}\)\?\/\?s/#', $htaccess))
					return false;
			}
		}
		return true;
	}
	private function _writeRewriteRule() {
		if ($this->checkRewriteRule())
			return true;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$htaccess_source = file_get_contents($this->_htFile);
			$dest_rule = 'index.php?fc=module&module=pm_advancedsearch4&controller=advancedsearch4&isolang=$1&id_seo=$2&seo_url=$3';
		} else {
			$htaccess_source = Configuration::get('PS_HTACCESS_SPECIFIC');
			$dest_rule = __PS_BASE_URI__ . 'modules/pm_advancedsearch4/advancedsearch4.php?isolang=$1&id_seo=$2&seo_url=$3';
			$dest_rule_2 = __PS_BASE_URI__ . 'modules/pm_advancedsearch4/advancedsearch4.php?';
		}
		if (preg_match('#\^\(\[a-z\]\{2\}\)\/s/#', $htaccess_source)) {
			$PS_HTACCESS_SPECIFIC = preg_replace('#\^\(\[a-z\]\{2\}\)\/s/#','^([a-z]{2})?/?s/', $htaccess_source);
		} else {
			if (preg_match('#\#START AS4 RULES#', $htaccess_source)) {
				$htaccess_source = preg_replace('#\#START AS4 RULES(.*)\#END AS4 RULES\n?#s','', $htaccess_source);
			}
			$PS_HTACCESS_SPECIFIC = '#START AS4 RULES (Do not remove)'."\n";
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
				$PS_HTACCESS_SPECIFIC .= '<IfModule mod_rewrite.c>'."\n".'RewriteEngine on'."\n";
			$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^as4_seositemap.xml$ modules/pm_advancedsearch4/sitemap/seositemap.xml [L]'."\n";
			$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^as4_seositemap-([0-9]+).xml$ modules/pm_advancedsearch4/sitemap/seositemap-$1.xml [L]'."\n";
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive()) {
				foreach (array_values(Shop::getCompleteListOfShopsID()) AS $id_shop) {
					$shopUrl = new Shop($id_shop);
					$base_uri = $shopUrl->virtual_uri;
					$PS_HTACCESS_SPECIFIC .= 'RewriteCond %{QUERY_STRING} !^controller=products-comparison [NC]'."\n";
					$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^'.str_replace('\-', '-', preg_quote($base_uri)).'([a-z]{2})?/?s/([0-9]+)/([a-zA-Z0-9/_-]*) '.$dest_rule.' [QSA,L]'."\n";
				}
			} else {
				if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $PS_HTACCESS_SPECIFIC .= 'RewriteCond %{QUERY_STRING} !^controller=products-comparison [NC]'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^([a-z]{2})?/?s/([0-9]+)/([a-zA-Z0-9/_-]*) '.$dest_rule.' [QSA,L]'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteCond %{QUERY_STRING} ^isolang=([a-z]{2})&id_seo=([0-9]+)&seo_url=([a-zA-Z0-9/_-]*).*p=([0-9]+)$'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^advancedsearch4.php '.__PS_BASE_URI__.'%1/s/%2/%3?p=%4 [R=301,L]'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteCond %{QUERY_STRING} ^isolang=([a-z]{2})&id_seo=([0-9]+)&seo_url=([a-zA-Z0-9/_-]*)'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^advancedsearch4.php '.__PS_BASE_URI__.'%1/s/%2/%3? [R=301,L]'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteCond %{QUERY_STRING} ^id_seo=([0-9]+)&seo_url=([a-zA-Z0-9/_-]*).*p=([0-9]+)$'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^advancedsearch4.php '.__PS_BASE_URI__.'s/%1/%2?p=%3 [R=301,L]'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteCond %{QUERY_STRING} ^id_seo=([0-9]+)&seo_url=([a-zA-Z0-9/_-]*)'."\n";
				$PS_HTACCESS_SPECIFIC .= 'RewriteRule ^advancedsearch4.php '.__PS_BASE_URI__.'s/%1/%2? [R=301,L]'."\n";
			}
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
				$PS_HTACCESS_SPECIFIC .= '</IfModule>'."\n";
			$PS_HTACCESS_SPECIFIC .= '#END AS4 RULES'."\n";
			$PS_HTACCESS_SPECIFIC .= $htaccess_source;
		}
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			return file_put_contents($this->_htFile, $PS_HTACCESS_SPECIFIC);
		}else {
			Configuration::updateValue('PS_HTACCESS_SPECIFIC', $PS_HTACCESS_SPECIFIC, true);
			if (Tools::generateHtaccess($this->_htFile, Configuration::get('PS_REWRITING_SETTINGS'), Configuration::get('PS_HTACCESS_CACHE_CONTROL'), $PS_HTACCESS_SPECIFIC, Configuration::get('PS_HTACCESS_DISABLE_MULTIVIEWS')))
				return true;
		}
		return false;
	}
	protected function _postProcess() {
		$this->saveAdvancedConfig();
		if (Tools::getIsset('submitSearch'))
			$this->_postProcessSearch();
		elseif (Tools::getIsset('submitCriteria'))
			$this->_postProcessCriteria();
		elseif (Tools::getIsset('submitSeoSearchForm'))
			$this->_postProcessSeoSearch();
		elseif (Tools::getIsset('submitMassSeoSearchForm'))
			$this->_postProcessMassSeoSearch();
		elseif (Tools::getIsset('submitSeoRegenerate'))
			$this->_postProcessSeoRegenerate();
		elseif (Tools::getIsset('action') && Tools::getValue('action') == 'orderCriterion') {
			$this->_cleanOutput();
			$order = Tools::getValue('order') ? explode(',', Tools::getValue('order')) : array();
			$id_search = Tools::getValue('id_search');
			foreach ($order as $position => $id_criterion) {
				if (!trim($id_criterion))
					continue;
				$row = array ('position' => intval($position) );
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedsearch_criterion_' . (int)$id_search, $row, 'UPDATE', 'id_criterion =' . self::parseInt($id_criterion));
			}
			$this->_html .= $this->l('Saved');
			$this->_echoOutput(true);
		} elseif (Tools::getIsset('action') && Tools::getValue('action') == 'orderCriterionGroup') {
			$this->_cleanOutput();
			$order = Tools::getValue('order') ? explode(',', Tools::getValue('order')) : array();
			$id_search = Tools::getValue('id_search');
			$auto_hide = Tools::getValue('auto_hide');
			$hidden = false;
			foreach ($order as $position => $key_criterions_group) {
				if ($key_criterions_group == "hide_after_".$id_search) {
					if ($auto_hide == 'true')
						$hidden = true;
					continue;
				}
				if (!trim($key_criterions_group))
					continue;
				$row = array ('position' => intval($position), 'hidden' => (int)$hidden );
				$infos_criterions_group = explode('-', $key_criterions_group);
				list ( $criterions_group_type, $id_criterion_group_linked, $id_search ) = $infos_criterions_group;
				if (!$criterions_group_type || !$id_search)
					continue;
				$id_criterion_group = AdvancedSearchCriterionGroupClass::getIdCriterionGroupByTypeAndIdLinked($id_search, $criterions_group_type, $id_criterion_group_linked);
				Db::getInstance()->AutoExecute(_DB_PREFIX_ . 'pm_advancedsearch_criterion_group_' . (int)$id_search, $row, 'UPDATE', 'id_criterion_group = ' . (int)$id_criterion_group);
			}
			$this->_html .= $this->l('Saved');
			$this->_echoOutput(true);
		}
		parent::_postProcess();
	}
	protected function _postSaveProcess($params) {
		parent::_postSaveProcess($params);
		if ($params['class'] == 'AdvancedSearchCriterionGroupClass' && Tools::isSubmit('submitCriteriaGroupOptions')) {
			$this->generateCss();
			if (Validate::isLoadedObject($params['obj'])) {
				$this->_html .= '<script type="text/javascript">parent.parent.updateCriterionGroupName("'.(int)$params['obj']->id.'", '.Tools::jsonEncode($params['obj']->name[$this->_cookie->id_lang]).');</script>';
			}
			$this->_html .= '<script type="text/javascript">parent.parent.closeDialogIframe();</script>';
		}
	}
	protected function _postDeleteProcess($params) {
		parent::_postDeleteProcess($params);
		if ($params['class'] == 'AdvancedSearchClass') {
			$this->_html .= 'removeTabPanel("#wrapAsTab","li#TabSearchAdminPanel' . Tools::getValue('id_search') . '","ul#asTab", '.(int)version_compare(_PS_VERSION_, '1.6.0.0', '>=').');';
			$this->generateSeoGSiteMap();
		}
	}
	protected function checkSeoCriteriaCombination(){
		$criteria = Tools::getValue('criteria', false);
		$id_search = Tools::getValue('id_search', false);
		$id_currency = Tools::getValue('id_currency', false);
		if (!$criteria || !$id_search)
			die();
		$criteria = explode(',', $criteria);
		$resultTotalProducts = $this->countProductFromSeoCriteria($id_search, $criteria, $id_currency);
		if (!$resultTotalProducts) {
			$this->_html .= '$jqPm("input[name=submitSeoSearchForm]").hide();$jqPm("#errorCombinationSeoSearchForm").show();';
			$this->_html .= '$jqPm("#nbProductsCombinationSeoSearchForm").html(\'<p class="ui-state-error ui-corner-all" style="padding:5px;"><b>0 ' . $this->l('result found') . '</b></p>\');';
		}
		else {
			$this->_html .= '$jqPm("input[name=submitSeoSearchForm]").show();$jqPm("#errorCombinationSeoSearchForm").hide();';
			$this->_html .= '$jqPm("#nbProductsCombinationSeoSearchForm").html(\'<p class="ui-state-highlight ui-corner-all" style="padding:5px;"><b>' . $resultTotalProducts . ' ' . $this->l('result(s) found(s)') . '</b></p>\');';
		}
	}
	public function displaySearchAdminPanel() {
		$id_search = (int) Tools::getValue('id_search');
		$advanced_search = AdvancedSearchClass::getSearch($id_search, $this->_cookie->id_lang, false);
		if (!isset($advanced_search [0]))
			return;
		$advanced_search = $advanced_search [0];
		$criterions_groups = $this->getCriterionsGroupsValue($this->_cookie->id_lang);
		$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexed($advanced_search ['id_search'], $this->_cookie->id_lang);
		$keys_criterions_group_indexed = array();
		$criterions_groups_to_reindex = AdvancedSearchClass::getCriterionsGroupsIndexed($advanced_search ['id_search'], $this->_cookie->id_lang,false);
		if (self::_isFilledArray($criterions_groups_to_reindex)) {
			$this->_html .= '<script type="text/javascript">';
			$this->_html .= 'var criteriaGroupToReindex'.$id_search.' = [];';
			foreach ($criterions_groups_to_reindex as $key=>$criterions_group_indexed) {
				$this->_html .= 'criteriaGroupToReindex'.$id_search.'['.$key.'] = {"id_search" : '.$id_search.', "id_criterion_group" : '.(int)$criterions_group_indexed ['id_criterion_group'].'};';
			}
			$this->_html .= '</script>';
		}
		$this->_html .= '<div class="searchSort">';
		$this->_addButton(array('text'=> $this->l('Edit'),'href'=>$this->_base_config_url . '&pm_load_function=displaySearchForm&class=AdvancedSearchClass&pm_js_callback=closeDialogIframe&id_search=' . $advanced_search ['id_search'],'class'=>'open_on_dialog_iframe','rel'=>'980_530_1','icon_class'=>'ui-icon ui-icon-pencil'));
		$this->_addButton(array('text'=> $this->l('Delete'),'href'=>$this->_base_config_url . '&pm_delete_obj=1&class=AdvancedSearchClass&id_search=' . $advanced_search ['id_search'],'class'=>'ajax_script_load pm_confirm','icon_class'=>'ui-icon ui-icon-trash', 'title'=>addcslashes($this->l('Delete item #'), "'") . $advanced_search ['id_search'] . ' ?'));
		$this->_addButton(array('text'=> $this->l('Status:') . ' <em id="searchStatusLabel' . (int)$advanced_search ['id_search'] . '">' . ($advanced_search ['active'] ? $this->l('enabled') : $this->l('disable')) . '</em>','href'=>$this->_base_config_url . '&pm_load_function=processActiveSearch&id_search=' . $advanced_search ['id_search'],'class'=>'ajax_script_load status_search_' . (int)$advanced_search ['id_search'],'icon_class'=>'ui-icon ' . ($advanced_search ['active'] ? 'ui-icon-circle-check' : 'ui-icon-circle-close'), 'title'=>addcslashes($this->l('Change status'), "'")));
		$this->_addButton(array('text'=> $this->l('Reindexing this search'),'href'=>'javascript:void(0);','class'=>'ajax_script_load','icon_class'=>'ui-icon ui-icon-shuffle','onclick'=>'reindexSearchCritriaGroups(this,criteriaGroupToReindex'.$id_search.',"#progressbarReindexSpecificSearch' . (int)$advanced_search ['id_search'] . '");'));
		$this->_html .= '<div class="progressbar_wrapper progressbarReindexSpecificSearch"><div class="progressbar" id="progressbarReindexSpecificSearch' . (int)$advanced_search ['id_search'] . '"></div><div class="progressbarpercent"></div></div>';
		$this->_pmClear();
		$this->_html .= '<div class="connectedSortableDiv" id="IndexCriterionsGroup">
        				<h3 style="float:left">' . $this->l('Active criteria groups') . '</h3>';
		$this->_html .= '<div style="float:right;"><abbr title="' . $this->l('This option allows you to display a "Show more options" with hidden groups in your front-office ') . '" >' . $this->l('Allow groups to be hidden:') . '  </abbr><input type="checkbox" onclick="displayHideBar($jqPm(this));" name="auto_hide" value="'. (int)$advanced_search ['id_search'] .'"/>';
		$this->_html .= '</div>';
		$this->_pmClear();
		$keys_criterions_group_indexed = array();
		$hidden = true;
        $this->_html .= '<ul class="connectedSortable connectedSortableIndex">';
		foreach ($criterions_groups_indexed as $criterions_group_indexed) {
			if ($criterions_group_indexed['hidden'] && $hidden){
				$this->_html .= '<li class="ui-state-default ui-state-pm-separator" style="height:12px" id="hide_after_'.(int)$advanced_search['id_search'].'">
        					<span class="ui-icon ui-icon-arrow-4-diag dragIcon dragIconCriterionGroup"></span>
        					<p style="font-size:10px; margin-top:0!important;padding-left:90px;">' . $this->l('Groups under this line will be hidden') . '</p>
        					<input name="id_search" value="' . (int)$advanced_search ['id_search'] . '" type="hidden" />
        				</li>';
				$hidden = false;
			}
			$key_criterions_group_indexed = $criterions_group_indexed ['criterion_group_type'] . '-' . (int)$criterions_group_indexed ['id_criterion_group_linked'] . '-' . (int)$advanced_search ['id_search'];
			$keys_criterions_group_indexed [] = $key_criterions_group_indexed;
			$this->_html .= '<li class="ui-state-default" id="' . $key_criterions_group_indexed . '" rel="'.(int)$criterions_group_indexed ['id_criterion_group'].'"><span class="ui-icon ui-icon-arrow-4-diag dragIcon dragIconCriterionGroup"></span><span class="criterionGroupName">' . $criterions_group_indexed ['name'] . '</span> <span style="font-size:10px;">('.$this->criteriaGroupLabels[$criterions_group_indexed ['criterion_group_type']].')</span><input name="id_search" value="' . (int)$advanced_search ['id_search'] . '" type="hidden" /></li>';
			$this->_html .= '<script type="text/javascript">setCriterionGroupActions("' . $key_criterions_group_indexed . '",true);</script>';
		}
		if ($hidden){
			$this->_html .= '<li class="ui-state-default ui-state-pm-separator" style="display:none; height:12px" id="hide_after_'.(int)$advanced_search['id_search'] . '">
        					<span class="ui-icon ui-icon-arrow-4-diag dragIcon dragIconCriterionGroup"></span>
        					<p style="font-size:10px; margin-top:0!important;padding-left:90px;">' . $this->l('Groups under this line will be hidden') . '</p>
        					<input name="id_search" value="' . (int)$advanced_search ['id_search'] . '" type="hidden" />
        				</li>';
		}
		$this->_html .= '</ul></div>';
		$this->_html .= ' 	<script type="text/javascript">
									 $jqPm(document).ready($jqPm("input[name=auto_hide]").attr("checked", '.($hidden ? 'false' : 'true').'));
							</script>';
		$this->_html .= '
    <div class="connectedSortableDiv" id="DesindexCriterionsGroup">
      <h3>' . $this->l('Available criteria groups') . '</h3>
      <ul class="connectedSortable">';
		foreach ($criterions_groups as $criterions_group) {
			$key_criterions_group = $criterions_group ['type'] . '-' . (int)$criterions_group ['id'] . '-' . (int)$advanced_search ['id_search'];
			if (in_array($key_criterions_group, $keys_criterions_group_indexed))
				continue;
			$this->_html .= '<li class="ui-state-default" id="' . $key_criterions_group . '"><span class="ui-icon ui-icon-arrow-4-diag dragIcon dragIconCriterionGroup"></span>' . $criterions_group ['name'] . ' <span style="font-size:10px;">('.$this->criteriaGroupLabels[$criterions_group ['type']].')</span><input name="id_search" value="' . (int)$advanced_search ['id_search'] . '" type="hidden" /></li>';
		}
		$this->_html .= '</ul>
      </div>';
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_html .= '<div class="seo_search_panel" id="seo_search_panel_' . (int)$advanced_search ['id_search'] . '">';
		$this->_html .= '</div>';
		$this->_html .= '
      <script type="text/javascript">
        loadPanel("seo_search_panel_' . (int)$advanced_search ['id_search'] . '","' . $this->_base_config_url . '&pm_load_function=displaySeoSearchPanelList&id_search=' . (int)$advanced_search ['id_search'] . '");
         $jqPm( ".connectedSortable" ).sortable({
        handle : ".dragIconCriterionGroup",
        connectWith: ".connectedSortable",
        placeholder: "ui-state-highlight",
        receive: function(event, ui) {
          receiveCriteria(ui.item);
        }
      });
      $jqPm( ".connectedSortableIndex" ).sortable({
        update: function(event, ui) {
                //alert($jqPm(ui.item).children("input[name=id_search]").val());
         	  var order = $jqPm(this).sortable("toArray");
              saveOrder(order.join(","),"orderCriterionGroup",$jqPm(ui.item).children("input[name=id_search]").val(),$jqPm("input[name=auto_hide]").is(":checked"));
              }
      });
      loadAjaxLink();
    </script>
     ';
	}
	public function generateSeoGSiteMap() {
		$res = true;
		$xmlSiteMapHeader = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
</urlset>
XML;
		$xml = array();
		foreach (AdvancedSearchClass::getSearchsId(true) as $searchRow) {
			$idSearch = (int)$searchRow['id_search'];
			$idShop = (int)AdvancedSearchClass::getShopBySearch($idSearch);
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
				$shop = new Shop($idShop);
			if (!isset($xml[$idShop]))
				$xml[$idShop] = new SimpleXMLElement($xmlSiteMapHeader);
			foreach (Language::getLanguages(true) as $language) {
				$seoSearchs = AdvancedSearchSeoClass::getSeoSearchs($language['id_lang'], false, $idSearch);
				foreach ($seoSearchs as $seoSearch) {
					$nbCriteria = count(unserialize($seoSearch['criteria']));
					if ($nbCriteria <= 3)
						$priority = 0.7;
					else if ($nbCriteria <= 5)
						$priority = 0.6;
					else
						$priority = 0.5;
					$sitemap[$idShop] = $xml[$idShop]->addChild('url');
					if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
						$url = $shop->getBaseURL() . (Language::countActiveLanguages() > 1 ? $language['iso_code'] . '/': '') . 's/' . (int)$seoSearch['id_seo'] . '/' . htmlentities($seoSearch['seo_url'], ENT_COMPAT, 'UTF-8');
						if (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) {
							$url = 'https://' . ltrim($url, 'http://');
						}
						$sitemap[$idShop]->addChild('loc', $url);
					} else {
						$sitemap[$idShop]->addChild('loc', _PS_BASE_URL_.__PS_BASE_URI__.(Language::countActiveLanguages() > 1 ? $language['iso_code'].'/': '').'s/'.(int)$seoSearch['id_seo'].'/'.htmlentities($seoSearch['seo_url'],ENT_COMPAT,'UTF-8'));
					}
					$sitemap[$idShop]->addChild('priority', $priority);
					$sitemap[$idShop]->addChild('changefreq', 'weekly');
				}
			}
		}
		foreach ($xml as $idShop => $xmlContent)
			if ($idShop)
				$res &= file_put_contents(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/sitemap/seositemap-'.(int)$idShop.'.xml', $xmlContent->asXML());
			else
				$res &= file_put_contents(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/sitemap/seositemap.xml', $xmlContent->asXML());
		return $res;
	}
	protected function processIndexCriterionsGroup($optimization = true) {
		self::_changeTimeLimit(0);
		$key_criterions_group = Tools::getValue('key_criterions_group',false);
		if (!$key_criterions_group) die;
		$infos_criterions_group = explode('-', $key_criterions_group);
		$error = 0;
		list($criterions_group_type, $id_criterion_group_linked, $id_search) = $infos_criterions_group;
		if (!$criterions_group_type || !$id_search) die;
		$objSearch = new AdvancedSearchClass($id_search, $this->_cookie->id_lang);
		$id_criterion_group = AdvancedSearchClass::indexCriterionsGroup($criterions_group_type, $id_criterion_group_linked, $objSearch);
		AdvancedSearchClass::optimizedSearchTables($objSearch->id);
		$this->_html .= '$jqPm("#'.$key_criterions_group.'").children(".loadingOnConnectList").hide().remove();';
		$this->_html .= 'setCriterionGroupActions("'.$key_criterions_group.'");';
		$this->_html .= '$jqPm("#'.$key_criterions_group.'").attr("rel",'.(int)$id_criterion_group.');';
		$this->_html .= 'getCriterionGroupActions("'.$key_criterions_group.'");';
	}
	protected function processDesindexCriterionsGroup() {
		$key_criterions_group = Tools::getValue('key_criterions_group',false);
		if (!$key_criterions_group) die;
		$infos_criterions_group = explode('-', $key_criterions_group);
		$error = 0;
		list($criterions_group_type, $id_criterion_group_linked, $id_search) = $infos_criterions_group;
		if (!$criterions_group_type || !$id_search) die;
		AdvancedSearchClass::desIndexCriterionsGroup($criterions_group_type, $id_criterion_group_linked, $id_search);
		AdvancedSearchClass::optimizedSearchTables($id_search);
		$this->_html .= '$jqPm("#'.$key_criterions_group.'").children(".loadingOnConnectList").fadeOut("fast");';
	}
	protected function processRemoveEmptySeo() {
		$id_search = Tools::getValue('id_search', false);
		if (!$id_search)
			die();
		$seoSearchs = AdvancedSearchSeoClass::getSeoSearchs($this->_cookie->id_lang, false, $id_search);
		foreach ($seoSearchs as $row) {
			$resultTotalProducts = $this->countProductFromSeoCriteria($id_search, unserialize($row ['criteria']), $row ['id_currency']);
			if (!$resultTotalProducts) {
				$objAdvancedSearchSeoClass = new AdvancedSearchSeoClass($row ['id_seo']);
				if (!$objAdvancedSearchSeoClass->delete())
					$this->_html .= 'show_error("' . $this->l('Error while deleting seo search') . ' ' . $row ['id_seo'] . '");';
			}
		}
		$this->_html .= 'show_info("' . $this->l('Empty SEO pages has been deleted') . '");reloadPanel("seo_search_panel_' . (int)$id_search . '");';
	}
	protected function processFillSeoFields() {
		$criteria = Tools::getValue('criteria',false);
		$id_search = Tools::getValue('id_search',false);
		$id_currency = Tools::getValue('id_currency',false);
		if (!$criteria || !$id_search) die;
		$criteria = explode(',', $criteria);
		$defaultReturnSeoStr = $this->getSeoStrings($criteria, $id_search, $id_currency);
		foreach($defaultReturnSeoStr as $id_lang => $fields) {
			foreach($fields as $field => $fieldValue) {
				$this->_html .= '$jqPm("input[name='.$field.'_'.$id_lang.']").val("'.addcslashes($fieldValue,'"').'");';
			}
		}
	}
	protected function processClearAllTables() {
		$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);
		AdvancedSearchClass::clearAllTables();
		foreach($advanced_searchs_id as $key=>$row) {
			$this->_html .= 'removeTabPanel("#wrapAsTab","li#TabSearchAdminPanel'.$row['id_search'].'","ul#asTab", '.(int)version_compare(_PS_VERSION_, '1.6.0.0', '>=').');';
		}
		$this->_html .= '$jqPm(window).scrollTo("#wrapAsTab",500,{onAfter:function() {
			show_info("'.addcslashes($this->l('Clear done'),'"').'");
			$jqPm("#msgNoResults").slideDown();
		}});';
	}
	protected function processReindexSpecificSearch() {
		self::_changeTimeLimit(0);
		$id_search = Tools::getValue('id_search');
		$this->reindexSpecificSearch($id_search);
		$this->_html .= '$jqPm( "#progressbarReindexSpecificSearch'.(int)$id_search.'" ).progressbar( "option", "value", 100 );show_info("'.addcslashes($this->l('Indexation done'),'"').'")';
	}
	protected function processDeleteCriterionImg() {
		$id_search = Tools::getValue('id_search');
		$id_criterion = Tools::getValue('id_criterion');
		$id_lang = Tools::getValue('id_lang');
		$objCriterion = new AdvancedSearchCriterionClass($id_criterion, $id_search);
		$file_name = $objCriterion->icon[$id_lang];
		$file_name_final_path = _PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions/'.$file_name;
		$objCriterion->icon[$id_lang] = '';
		if (AdvancedSearchCoreClass::_isRealFile($file_name_final_path))
				unlink($file_name_final_path);
		if ($objCriterion->save())
			$this->_html .= 'show_info("'.addcslashes($this->l('Criterion image deleted'),'"').'");';
		else
			$this->_html .= 'show_info("'.addcslashes($this->l('An error occured'),'"').'");';
	}
	protected function processSaveCriterionImg() {
		$id_search = Tools::getValue('id_search');
		$id_criterion = Tools::getValue('id_criterion');
		$id_lang = Tools::getValue('id_lang');
		$file_name = Tools::getValue('file_name');
		$file_name_temp_path = _PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/uploads/temp/'.$file_name;
		$file_name_final_path = _PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions/'.$file_name;
		if (AdvancedSearchCoreClass::_isRealFile($file_name_temp_path)) {
			rename($file_name_temp_path, $file_name_final_path);
			$objCriterion = new AdvancedSearchCriterionClass($id_criterion, $id_search);
			$objCriterion->icon[$id_lang] = $file_name;
			if ($objCriterion->save())
				$this->_html .= 'ok';
			else $this->_html .= 'ko';
		}else $this->_html .= 'ko';
	}
	protected function processDeleteCustomCriterion() {
		$objCriterion = new AdvancedSearchCriterionClass((int)Tools::getValue('id_criterion'), (int)Tools::getValue('id_search'));
		if (Validate::isLoadedObject($objCriterion)) {
			if ($objCriterion->delete()) {
				$this->_html .= 'parent.show_info("' . $this->l('Successfully deleted') . '");';
				$this->_html .= 'this.location.reload(true);';
			} else {
				$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterion') . '");';
			}
		} else {
			$this->_html .= 'parent.show_error("' . $this->l('Error while deleting criterion') . '");';
		}
	}
	protected function processAddCustomCriterion() {
		$objCriterion = new AdvancedSearchCriterionClass(null, (int)Tools::getValue('id_search'));
		$objCriterion->id_criterion_group = (int)Tools::getValue('id_criterion_group');
		$objCriterion->id_criterion_linked = 0;
		$objCriterion->is_custom = 1;
		$this->copyFromPost($objCriterion);
		$validationErrors = AdvancedSearchCoreClass::_retroValidateController($objCriterion);
		if (!self::_isFilledArray($validationErrors)) {
			if ($objCriterion->add()) {
				$this->_html .= 'parent.show_info("' . $this->l('Saved') . '");';
				$this->_html .= 'this.location.reload(true);';
			} else {
				$this->_html .= 'parent.show_error("' . $this->l('Error while adding criterion') . '");';
			}
		} else {
			$this->_html .= 'parent.show_error("' . $this->l('Error while adding criterion') . '");';
			foreach ($validationErrors as $error)
				$this->_html .= 'parent.show_error("' . $error . '");';
		}
	}
	protected function processUpdateCustomCriterion() {
		$objCriterion = new AdvancedSearchCriterionClass((int)Tools::getValue('id_criterion'), (int)Tools::getValue('id_search'));
		$this->copyFromPost($objCriterion);
		if (Validate::isLoadedObject($objCriterion)) {
			if ($objCriterion->save()) {
				$this->_html .= 'parent.show_info("' . $this->l('Saved') . '");';
				$this->_html .= 'this.location.reload(true);';
			} else {
				$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterion') . '");';
			}
		} else {
			$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterion') . '");';
		}
	}
	protected function processAddCustomCriterionToGroup() {
		$idSearch = (int)Tools::getValue('id_search');
		$idCriterionGroup = (int)Tools::getValue('id_criterion_group');
		$criterionsGroupList = explode(',', Tools::getValue('criterionsGroupList'));
		$newCriterionsGroupList = array();
		if (self::_isFilledArray($criterionsGroupList)) {
			foreach ($criterionsGroupList as $criterionsGroupListRow) {
				$criterionsGroupListRow = explode('-', $criterionsGroupListRow);
				$idCriterion = (int)$criterionsGroupListRow[0];
				$idCriterionParent = (int)$criterionsGroupListRow[1];
				if (!$idCriterionParent)
					continue;
				$newCriterionsGroupList[$idCriterionParent][] = $idCriterion;
			}
		}
		$customCriterionList = AdvancedSearchCriterionClass::getCustomCriterionsLinkIdsByGroup($idSearch, $idCriterionGroup);
		foreach ($customCriterionList as $idCriterionParent => $currentCriterionsGroupList) {
			Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_list` WHERE `id_criterion_parent`='.(int)$idCriterionParent);
			AdvancedSearchCriterionClass::populateCriterionsLink($idSearch, $idCriterionParent);
		}
		foreach ($newCriterionsGroupList as $idCriterionParent => $currentCriterionsGroupList) {
			Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$idSearch.'_list` WHERE `id_criterion_parent`='.(int)$idCriterionParent);
			if (self::_isFilledArray($currentCriterionsGroupList)) {
				foreach ($currentCriterionsGroupList as $idCriterion)
					AdvancedSearchCriterionClass::addCriterionToList($idSearch, $idCriterionParent, $idCriterion);
			}
			AdvancedSearchCriterionClass::populateCriterionsLink($idSearch, $idCriterionParent, false, $currentCriterionsGroupList);
		}
		$this->_html .= 'parent.show_info("' . $this->l('Saved') . '");';
	}
	protected function processEnableAllCriterions() {
		$objCriterionGoup = new AdvancedSearchCriterionGroupClass((int)Tools::getValue('id_criterion_group'), (int)Tools::getValue('id_search'));
		if (Validate::isLoadedObject($objCriterionGoup)) {
			if (AdvancedSearchCriterionGroupClass::enableAllCriterions((int)Tools::getValue('id_search'), (int)Tools::getValue('id_criterion_group'))) {
				$this->_html .= '$jqPm("img[id^=imgActiveCriterion]").attr("src","../img/admin/enabled.gif");';
				$this->_html .= 'parent.show_info("' . $this->l('Saved') . '");';
			} else {
				$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterions status') . '");';
			}
		} else {
			$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterions status') . '");';
		}
	}
	protected function processDisableAllCriterions() {
		$objCriterionGoup = new AdvancedSearchCriterionGroupClass((int)Tools::getValue('id_criterion_group'), (int)Tools::getValue('id_search'));
		if (Validate::isLoadedObject($objCriterionGoup)) {
			if (AdvancedSearchCriterionGroupClass::disableAllCriterions((int)Tools::getValue('id_search'), (int)Tools::getValue('id_criterion_group'))) {
				$this->_html .= '$jqPm("img[id^=imgActiveCriterion]").attr("src","../img/admin/disabled.gif");';
				$this->_html .= 'parent.show_info("' . $this->l('Saved') . '");';
			} else {
				$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterions status') . '");';
			}
		} else {
			$this->_html .= 'parent.show_error("' . $this->l('Error while updating criterions status') . '");';
		}
	}
	protected function processActiveCriterion() {
		$ObjAdvancedSearchCriterionClass = new AdvancedSearchCriterionClass(Tools::getValue('id_criterion'), Tools::getValue('id_search'));
		$ObjAdvancedSearchCriterionClass->visible = ($ObjAdvancedSearchCriterionClass->visible ? 0 : 1);
		if ($ObjAdvancedSearchCriterionClass->save()) {
			$this->_html .= '$jqPm("#imgActiveCriterion' . $ObjAdvancedSearchCriterionClass->id . '").attr("src","../img/admin/' . ($ObjAdvancedSearchCriterionClass->visible ? 'enabled' : 'disabled') . '.gif");';
			$this->_html .= 'parent.show_info("' . $this->l('Saved') . '");';
		}
		else {
			$this->_html .= 'parent.show_error("' . $this->l('Error while updating search') . '");';
		}
	}
	protected function processActiveSearch() {
		$ObjAdvancedSearchClass = new AdvancedSearchClass(Tools::getValue('id_search'));
		$ObjAdvancedSearchClass->active = ($ObjAdvancedSearchClass->active ? 0 : 1);
		if ($ObjAdvancedSearchClass->save()) {
			if ($ObjAdvancedSearchClass->active)
				$this->_html .= '$jqPm("#searchStatusLabel' . $ObjAdvancedSearchClass->id . '").html("' . $this->l('enabled') . '");$jqPm(".status_search_' . $ObjAdvancedSearchClass->id . ' span").removeClass("ui-icon-circle-close").addClass("ui-icon-circle-check");';
			else
				$this->_html .= '$jqPm("#searchStatusLabel' . $ObjAdvancedSearchClass->id . '").html("' . $this->l('disabled') . '");$jqPm(".status_search_' . $ObjAdvancedSearchClass->id . ' span").removeClass("ui-icon-circle-check").addClass("ui-icon-circle-close");';
			$this->_html .= 'show_info("' . $this->l('Saved') . '");';
		}
		else {
			$this->_html .= 'show_error("' . $this->l('Error while updating search') . '");';
		}
	}
	protected function processDeleteSeoSearch() {
		$ObjAdvancedSearchSeoClass = new AdvancedSearchSeoClass(Tools::getValue('id_seo'));
		$ObjAdvancedSearchSeoClass->deleted = 1;
		if ($ObjAdvancedSearchSeoClass->save()) {
			$this->_html .= 'show_info("' . $this->l('Seo Search has been deleted') . '");reloadPanel("seo_search_panel_' . (int)Tools::getValue('id_search') . '");';
		}
		else
			$this->_html .= 'show_error("' . $this->l('Error while deleting seo search') . '");';
	}
	protected function processWriteSeoRewriteRule() {
		$id_search = Tools::getValue('id_search');
		if ($this->_writeRewriteRule())
			$this->_html .= 'show_info("' . $this->l('Htaccess has been updated') . '");reloadPanel("seo_search_panel_' . (int)$id_search . '");';
		else
			$this->_html .= 'show_error("' . $this->l('Error while updating Htaccess') . '");';
	}
	protected function processDeleteMassSeo() {
		$id_seos = Tools::getValue('seo_group_action', false);
		$id_search = Tools::getValue('id_search', false);
		if (self::_isFilledArray($id_seos)) {
			foreach ($id_seos as $id_seo) {
				$objAdvancedSearchSeoClass = new AdvancedSearchSeoClass($id_seo);
				$objAdvancedSearchSeoClass->deleted = 1;
				$objAdvancedSearchSeoClass->save();
			}
			$this->_html .= 'show_info("' . $this->l('Seo Pages has been deleted') . '");reloadPanel("seo_search_panel_' . (int)$id_search . '");';
		}else $this->_html .= 'show_error("' . $this->l('Please select at least one seo page') . '");';
	}
	protected function displaySeoPriceSlider() {
		$id_search = Tools::getValue('id_search', false);
		$id_criterion_group_linked = Tools::getValue('id_criterion_group_linked', false);
		$id_currency = Tools::getValue('id_currency', false);
		$currency = new Currency($id_currency);
		if (!$id_search || !$id_currency)
			die();
		$search = AdvancedSearchClass::getSearch($id_search,false);
		$price_range = AdvancedSearchClass::getPriceRangeForSearchBloc($search[0], $id_criterion_group_linked, (int)$id_currency, $this->getCurrentCustomerGroupId(), 0, false, array(), array());
		$min_price_id_currency = (int)$price_range [0] ['min_price_id_currency'];
		$max_price_id_currency = (int)$price_range [0] ['max_price_id_currency'];
		if (($min_price_id_currency == 0 && $min_price_id_currency != $id_currency) || ($min_price_id_currency != 0 && $min_price_id_currency != $id_currency))
			$price_range [0] ['min_price'] = Tools::convertPrice($price_range [0] ['min_price'], $id_currency);
		if (($max_price_id_currency == 0 && $max_price_id_currency != $id_currency) || ($max_price_id_currency != 0 && $max_price_id_currency != $id_currency))
			$price_range [0] ['max_price'] = Tools::convertPrice($price_range [0] ['max_price'], $id_currency);
		$price_range [0] ['min_price'] = floor($price_range [0] ['min_price']);
		$price_range [0] ['max_price'] = ceil($price_range [0] ['max_price']);
		$this->_html .= '$jqPm( "#PM_ASSeoPriceRange" ).slider({
	        range: true,
	        min: ' . (int)$price_range[0] ['min_price'] . ',
	        max: ' . (int)$price_range[0] ['max_price'] . ',
	          values: [ ' . (int)$price_range[0]['min_price'] . ', ' . (int)$price_range[0]['max_price'] . ' ],
	        slide: function( event, ui) {
	          $jqPm( "#PM_ASPriceRangeValue" ).html( "" + ui.values[ 0 ] + " - " + "'.$currency->getSign('left').'" + ui.values[ 1 ]  + "'.$currency->getSign('right').'" );
	          $jqPm( "#massSeoSearchCriterionPriceInput" ).val("-" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
	          $jqPm( ".seoSearchCriterionPriceSortable" ).attr("id", "criterion_price-" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
	          $jqPm( ".seoSearchCriterionPriceSortable" ).attr("title", "' . $this->l('From') . ' " + ui.values[ 0 ] + " ' . $this->l('to') . ' " + "'.$currency->getSign('left').'" + ui.values[ 1 ] + "'.$currency->getSign('right').'" );
	        }
	      });
	      $jqPm( "#PM_ASPriceRangeValue" ).html( "' . (int)$price_range[0]['min_price'] . ' - ' . Tools::displayPrice((int)$price_range[0]['max_price'], $currency) . '" );
	      $jqPm( ".seoSearchCriterionPriceSortable" ).attr("id", "criterion_price-' . (int)$price_range[0]['min_price'] . '-' . (int)$price_range[0]['max_price'] . '" );
	      $jqPm( ".seoSearchCriterionPriceSortable" ).attr("title", "' . $this->l('From') . ' ' . (int)$price_range[0]['min_price'] . ' ' . $this->l('to') . ' ' . Tools::displayPrice((int)$price_range[0]['max_price'], $currency) . '" );';
	}
	protected function displaySeoSearchOptions() {
		if (Tools::getValue('id_seo_excludes'))
			$id_seo_excludes = explode(',', Tools::getValue('id_seo_excludes', false));
		else
			$id_seo_excludes = array();
		if (Tools::getValue('id_seo_origin'))
			$id_seo_excludes[] = (int)Tools::getValue('id_seo_origin');
		$query_search = Tools::getValue('q', false);
		$limit = Tools::getValue('limit', 100);
		$start = Tools::getValue('start', 0);
		$nbResults = AdvancedSearchSeoClass::getCrossLinksAvailable($this->_cookie->id_lang, $id_seo_excludes, $query_search, true);
		$results = AdvancedSearchSeoClass::getCrossLinksAvailable($this->_cookie->id_lang, $id_seo_excludes, $query_search, false, $limit, $start);
		foreach ($results as $key => $value) {
			$this->_html .= $key . '=' . $value . "\n";
		}
		if ($nbResults > ($start + $limit))
			$this->_html .= 'DisplayMore' . "\n";
	}
	protected function displayCmsOptions() {
		$query = Tools::getValue('q', false);
		if (trim($query)) {
			$limit = Tools::getValue('limit', 100);
			$start = Tools::getValue('start', 0);
			$items = Db::getInstance()->ExecuteS('
				SELECT c.`id_cms`, cl.`meta_title`
				FROM `'._DB_PREFIX_.'cms` c
				LEFT JOIN `'._DB_PREFIX_.'cms_lang` cl ON (c.`id_cms` = cl.`id_cms`)
				WHERE (cl.`meta_title` LIKE \'%'.pSQL($query).'%\')
				AND cl.`id_lang` = '.(int)($this->_cookie->id_lang).'
				AND c.`active` = 1
				ORDER BY cl.`meta_title`
				'.($limit? 'LIMIT '.$start.', '.(int)$limit : '')
			);
			if ($items)
				foreach($items as $row)
					$this->_html .= $row['id_cms']. '=' .$row['meta_title']. "\n";
		}
	}
	protected function displaySeoSearchPanelList() {
		$id_search = Tools::getValue('id_search');
		$this->_html .= '<h2>' . $this->l('Pages generator for SEO') . '</h2>';
		if (!Configuration::get('PS_REWRITING_SETTINGS'))
			$this->_showInfo($this->l('Please activate Friendly URL to use this option'));
		elseif (!is_writable($this->_htFile))
			$this->_showInfo($this->l('Please give write permission to  file') . ' ' . $this->_htFile);
		elseif (!$this->checkRewriteRule())
			$this->_showInfo($this->l('The rewrite rule is not present in your htaccess file.') . '<br /><br /><a href="' . $this->_base_config_url . '&pm_load_function=processWriteSeoRewriteRule&id_search=' . $id_search . '" class="ajax_script_load"><b>' . $this->l('Click here to update your htaccess.') . '</b></a>');
		else {
			$this->_html .= '<div class="seoGsiteMapUrl">';
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
				$this->_showInfo($this->l('The SEO google sitemap is located at: ').' <a target="_blank" href="' . $this->context->shop->getBaseURL() . 'as4_seositemap-' . (int)$this->context->shop->id . '.xml">' . $this->context->shop->getBaseURL() . 'as4_seositemap-' . (int)$this->context->shop->id . '.xml</a>');
			else
				$this->_showInfo($this->l('The SEO google sitemap is located at: ').' <a target="_blank" href="'._PS_BASE_URL_.__PS_BASE_URI__.'as4_seositemap.xml">'._PS_BASE_URL_.__PS_BASE_URI__.'as4_seositemap.xml</a>');
			$this->_html .= '</div>';
			$this->_addButton(array('text'=> $this->l('Add products page'),'href'=>$this->_base_config_url . '&pm_load_function=displaySeoSearchForm&class=AdvancedSearchSeoClass&pm_js_callback=closeDialogIframe&id_search=' . (int)$id_search,'class'=>'open_on_dialog_iframe','rel'=>'950_530_1','icon_class'=>'ui-icon ui-icon-circle-plus'));
			$this->_addButton(array('text'=> $this->l('Massive add of products pages'),'href'=>$this->_base_config_url . '&pm_load_function=displayMassSeoSearchForm&pm_js_callback=closeDialogIframe&id_search=' . (int)$id_search,'class'=>'open_on_dialog_iframe','rel'=>'950_530_1','icon_class'=>'ui-icon ui-icon-circle-plus'));
			$seoSearchs = AdvancedSearchSeoClass::getSeoSearchs($this->_cookie->id_lang, false, $id_search);
			if ($seoSearchs && self::_isFilledArray($seoSearchs)) {
				$this->_html .= '<hr class="clear" />';
				$this->_addButton(array('text'=> $this->l('Remove empty results pages'),'href'=>$this->_base_config_url . '&pm_load_function=processRemoveEmptySeo&id_search=' . $id_search,'class'=>'ajax_script_load','icon_class'=>'ui-icon ui-icon-trash'));
				$this->_addButton(array('text'=> $this->l('Regenerate SEO data'),'href'=>$this->_base_config_url . '&pm_load_function=displaySeoRegenerateForm&id_search=' . (int)$id_search,'class'=>'open_on_dialog_iframe','rel'=>'700_315','icon_class'=>'ui-icon ui-icon-refresh'));
				$this->_addButton(array('text'=> $this->l('List all SEO URL'),'href'=>$this->_base_config_url . '&pm_load_function=displaySeoUrlList&id_search=' . (int)$id_search,'class'=>'open_on_dialog_iframe','rel'=>'950_530_1','icon_class'=>'ui-icon ui-icon-link'));
				$this->_html .= '<table cellspacing="0" cellpadding="0" id="dataTable' . (int)$id_search . '" style="width:100%;">
		        <thead>
		    	<tr>
		    					  <th width="10"></th>
		                          <th width="50">' . $this->l('Id') . '</th>
		                          <th style="width:auto">' . $this->l('Title') . '</th>
		                          <th style="text-align:center;">' . $this->l('Nb products') . '</th>
		                          <th style="text-align:center;">' . $this->l('Edit') . '</th>
		                          <th style="text-align:center;">' . $this->l('SEO URL') . '</th>
		                          <th style="text-align:center;">' . $this->l('Delete') . '</th>
		                        </tr>
		                        </thead>';
				$this->_html .= '<tbody>';
				foreach ($seoSearchs as $row) {
					$resultTotalProducts = $this->countProductFromSeoCriteria($id_search, unserialize($row ['criteria']), $row ['id_currency']);
					$this->_html .= '<tr>';
					$this->_html .= '<td><input type="checkbox" name="seo_group_action[]" value="' . (int)$row ['id_seo'].'" /></td>';
					$this->_html .= '<td>' . $row ['id_seo'] . '</td>';
					$this->_html .= '<td>' . htmlentities($row ['title'], ENT_COMPAT, 'UTF-8') . '</td>';
					$this->_html .= '<td style="text-align:center;">' . ($resultTotalProducts ? '<b>' . $resultTotalProducts . '</b>' : '<b style="color:#cc0000">' . $resultTotalProducts . '</b>') . '</td>';
					$this->_html .= '<td style="text-align:center;">';
					$this->_addButton(array('text'=> '','href'=>$this->_base_config_url . '&pm_load_function=displaySeoSearchForm&class=AdvancedSearchSeoClass&pm_js_callback=closeDialogIframe&id_search=' . (int)$id_search . '&id_seo=' . (int)$row ['id_seo'],'class'=>'open_on_dialog_iframe','rel'=>'950_530_1','icon_class'=>'ui-icon ui-icon-pencil'));
					$this->_html .= '</td>';
					$this->_html .= '<td style="text-align:center;">';
					$this->_addButton(array('text'=> '','href'=>$this->_base_config_url . '&pm_load_function=displaySeoUrl&id_search=' . (int)$id_search . '&id_seo=' . (int)$row ['id_seo'],'class'=>'open_on_dialog_iframe','rel'=>'950_250','icon_class'=>'ui-icon ui-icon-link'));
					$this->_html .= '</td>';
					$this->_html .= '<td style="text-align:center;">';
					$this->_addButton(array('text'=> '','href'=>$this->_base_config_url . '&pm_load_function=processDeleteSeoSearch&id_search=' . (int)$id_search . '&id_seo=' . (int)$row ['id_seo'],'class'=>'ajax_script_load pm_confirm','title'=>addcslashes($this->l('Delete item #'), "'") . $row ['id_seo'] . ' ?','icon_class'=>'ui-icon ui-icon-trash'));
					$this->_html .= '</td>';
					$this->_html .= '</tr>';
				}
				$this->_html .= '</tbody>';
				$this->_html .= '</table><br />';
				$this->_addButton(array('text'=> $this->l('Check/Uncheck all'),'href'=>'javascript:void(0);','onclick'=>'checkAllSeoItems('.(int)$id_search.');','icon_class'=>'ui-icon'));
				$this->_addButton(array('text'=> $this->l('Delete selected items'),'href'=>'javascript:void(0);','onclick'=>'deleteSeoItems('.(int)$id_search.');','icon_class'=>'ui-icon ui-icon-trash'));
				$this->_html .= '<script type="text/javascript">$jqPm(document).ready(function(){
		      loadAjaxLink();
		      var oTable = $jqPm(\'#dataTable' . (int)$id_search . '\').dataTable( {
		        "sDom": \'R<"H"lfr>t<"F"ip<\',
		        "bJQueryUI": true,
		        "sPaginationType": "full_numbers",
		        "bStateSave": true,
		        "oLanguage": {
		          "sLengthMenu": "' . $this->l('Display') . ' _MENU_ ' . $this->l('records per page') . '",
		          "sZeroRecords": "' . $this->l('Nothing found - sorry') . '",
		          "sInfo": "' . $this->l('Showing') . ' _START_ ' . $this->l('to') . ' _END_ ' . $this->l('of') . ' _TOTAL_ ' . $this->l('records') . '",
		          "sInfoEmpty": "' . $this->l('Showing') . ' 0 ' . $this->l('to') . ' 0 ' . $this->l('of') . ' 0 ' . $this->l('records') . '",
		          "sInfoFiltered": "(' . $this->l('filtered from') . ' _MAX_ ' . $this->l('total records') . ')",
		          "sPageNext": "' . $this->l('Next') . '",
		          "sPagePrevious": "' . $this->l('Previous') . '",
		          "sPageLast": "' . $this->l('Last') . '",
		          "sPageFirst": "' . $this->l('First') . '",
		          "sSearch": "' . $this->l('Search') . '",
		          "sFirst":"' . $this->l('First') . '",
		          "sPrevious":"' . $this->l('Previous') . '",
		          "sNext":"' . $this->l('Next') . '",
		          "sLast":"' . $this->l('Last') . '"
		        }
		      } );
		      	$jqPm(document).on("click", \'#dataTable' . (int)$id_search . ' tr td:gt(0)\', function() {
		      		if ($jqPm(this).parent("tr").children("td:first-child").find("input:checked").length)
		      			$jqPm(this).parent("tr").children("td:first-child").find("input").removeAttr("checked");
		      		else
						$jqPm(this).parent("tr").children("td:first-child").find("input").attr("checked","checked");
				});
		    });</script>';
			}else {
				$this->_showInfo($this->l('No seo page at this time please add one'));
			}
		}
	}
	protected function displaySeoUrl($id_search) {
		$id_search = Tools::getValue('id_search',false);
		$id_seo = Tools::getValue('id_seo',false);
		if (!$id_seo || !$id_search) die;
		$ObjAdvancedSearchSeoClass = new AdvancedSearchSeoClass($id_seo,null);
		$this->_startForm(array('id' => 'SEOpages'));
		$this->_displayTitle($this->l('Products page URL'));
		$this->_showInfo($this->l('Use this URL in your slideshows, menus and others. One link per language is available.'));
		$this->_html .= '
             <div class="margin-form" style="padding-left:100px;">';
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive()) {
			$shopUrl = new Shop($this->_context->shop->id);
			$base_url = $shopUrl->getBaseURL();
		} else {
			$base_url = Tools::getShopDomain(true) . __PS_BASE_URI__ ;
		}
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) {
			$base_url = 'https://' . ltrim($base_url, 'http://');
		}
		foreach ($this->_languages as $language) {
			$this->_html .= '
        <div id="langseo_url_' . $language ['id_lang'] . '" class="pmFlag pmFlagLang_' . $language ['id_lang'].'" style="display: ' . ($language ['id_lang'] == $this->_default_language ? 'block' : 'none') . '; float: left;">
          <input size="130" type="text" name="seo_url_' . $language ['id_lang'] . '" onfocus="this.select();" value="' . $base_url. (Language::countActiveLanguages() > 1 ? $language ['iso_code'].'/': '') . 's/' . (int)$ObjAdvancedSearchSeoClass->id . '/' . $ObjAdvancedSearchSeoClass->seo_url [$language ['id_lang']] . '" />
        </div>';
		}
		$this->displayPMFlags();
		$this->_pmClear();
		$this->_html .= '</div>';
		$this->_endForm(array('id' => 'SEOpages'));
	}
	protected function displaySeoUrlList() {
		$id_search = Tools::getValue('id_search');
		$this->_startForm(array('id' => 'SEOURLListForm'));
		$this->_displayTitle($this->l('SEO URL list'));
		$this->_showInfo($this->l('You will find here the list of all the SEO URLs pages you have created for this search engine. You have to add them in your menu, slideshow, footer, blocks, or anywhere you want in your website for Google crawling'));
		$seoSearchs = AdvancedSearchSeoClass::getSeoSearchs($this->_cookie->id_lang, false, $id_search);
		if ($seoSearchs && self::_isFilledArray($seoSearchs)) {
			$new_SeoSearch = array();
			foreach ($seoSearchs as $row) {
				$resultTotalProducts = $this->countProductFromSeoCriteria($id_search, unserialize($row ['criteria']), $row ['id_currency']);
				$ObjAdvancedSearchSeoClass = new AdvancedSearchSeoClass($row['id_seo'], null);
				if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive()) {
					$shopUrl = new Shop($this->_context->shop->id);
					$base_url = $shopUrl->getBaseURL();
				} else {
					$base_url = Tools::getShopDomain(true) . __PS_BASE_URI__ ;
				}
				if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) {
					$base_url = 'https://' . ltrim($base_url, 'http://');
				}
				foreach ($this->_languages as $language) {
					$url = $base_url . (Language::countActiveLanguages() > 1 ? $language ['iso_code'].'/': '') . 's/' . (int)$ObjAdvancedSearchSeoClass->id . '/' . $ObjAdvancedSearchSeoClass->seo_url [$language ['id_lang']];
					$title = htmlentities($ObjAdvancedSearchSeoClass->title[$language ['id_lang']], ENT_COMPAT, 'UTF-8');
					$new_SeoSearch[$language['id_lang']][$ObjAdvancedSearchSeoClass->id]['url'] = $url;
					$new_SeoSearch[$language['id_lang']][$ObjAdvancedSearchSeoClass->id]['title'] = $title;
				}
			}
			$seoSearchs = $new_SeoSearch;
			unset($new_SeoSearch);
			if ($seoSearchs && self::_isFilledArray($seoSearchs)) {
				$this->_html .= '<p>'.$this->l('Please select the language :').'<p>';
				$this->displayPMFlags();
				$this->_html .= '<div class="clear"></div>';
				foreach ($seoSearchs as $id_lang=>$seo_urls) {
					$this->_html .= '<div id="langseo_url_' . $id_lang . '" class="pmFlag pmFlagLang_' . $id_lang.'" style="display: ' . ($id_lang == $this->_default_language ? 'block' : 'none') . '; float: left;">';
					$this->_html .= '<h3>'.$this->l('HTML version:').'</h3>';
					$this->_html .= '<textarea cols="110" rows="10">';
					$this->_html .= htmlentities('<ul>', ENT_COMPAT, 'UTF-8')."\n";
					foreach ($seo_urls as $seo_url) {
						$this->_html .= htmlentities('<li><a href="'.$seo_url['url'].'" title="'.$seo_url['title'].'">'.$seo_url['title'].'</a></li>', ENT_COMPAT, 'UTF-8')."\n";
					}
					$this->_html .= htmlentities('</ul>', ENT_COMPAT, 'UTF-8')."\n";
					$this->_html .= '</textarea>';
					$this->_html .= '<h3>'.$this->l('CSV version:').'</h3>';
					$this->_html .= '<textarea cols="110" rows="10">';
					foreach ($seo_urls as $seo_url) {
						$this->_html .= '"'.$seo_url['title'].'";"'.$seo_url['url'].'"'."\n";
					}
					$this->_html .= '</textarea>';
					$this->_html .= '</div>';
				}
			}
		} else {
			$this->_showInfo($this->l('No seo page at this time please add one'));
		}
		$this->_endForm(array('id' => 'SEOURLListForm'));
	}
	protected function displaySeoRegenerateForm() {
		$id_search = Tools::getValue('id_search');
		$this->_startForm(array('id' => 'seoRegenerateForm'));
		$this->_displayTitle($this->l('Regenerate SEO data'));
		$this->_showInfo($this->l('Select data bellow to regenerate'));
		$this->_html .= '<input type="hidden" name="id_search" id="id_search" value="' . (int)$id_search . '" />';
		$this->_html .= '<div id="buttonSetSeoRegenerate">
	        <input type="checkbox" name="fields_to_regenerate[]" id="check1" value="meta_title" /> <label for="check1">' . $this->l('Meta Title') . '</label>
	        <input type="checkbox" name="fields_to_regenerate[]" id="check2" value="meta_description" /> <label for="check2">' . $this->l('Meta description') . '</label>
	        <input type="checkbox" name="fields_to_regenerate[]" id="check3" value="meta_keywords" /> <label for="check3">' . $this->l('Meta keywords') . '</label>
	        <input type="checkbox" name="fields_to_regenerate[]" id="check4" value="title" /> <label for="check4">' . $this->l('Title (H1)') . '</label>
	        <input type="checkbox" name="fields_to_regenerate[]" id="check5" value="seo_url" /> <label for="check5">' . $this->l('Friendly URL') . '</label>
	      </div>';
		$this->_pmClear();
	   $this->_html .= '<br />';
		$this->_displaySubmit($this->l('   Regenerate   '),'submitSeoRegenerate');
		$this->_html .= '<script type="text/javascript">$jqPm(document).ready(function(){
						    $jqPm( "#buttonSetSeoRegenerate" ).buttonset();
						    });</script>';
    	$this->_endForm(array('id' => 'seoRegenerateForm'));
	}
	protected function displaySeoSearchForm($params) {
		$id_search = Tools::getValue('id_search');
		$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexedForSEO($id_search, $this->_cookie->id_lang);
		$search = AdvancedSearchClass::getSearch($id_search,false,false);
		$criteria = false;
		if ($params['obj'] && $params['obj']->criteria) {
			$criteria = unserialize($params['obj']->criteria);
		}
		$this->_startForm(array('id' => 'seoSearchForm','obj' => $params['obj'],'params'=>$params));
		if (!self::_isFilledArray($criterions_groups_indexed)) {
			$this->_showWarning($this->l('Before add SEO page, please add criteria to your search'));
		}else {
			$this->_displayTitle(($params['obj'] ? $this->l('Edit products page') : $this->l('Add products page')));
			$this->_html .= '<div id="seoSearchPanelCriteriaTabs">
	    <ul>';
			foreach ($criterions_groups_indexed as $key => $criterions_group_indexed) {
				$this->_html .= '<li><a href="#seoSearchPanelCriteriaTabs-' . $key . '">' . htmlentities($criterions_group_indexed ['name'], ENT_COMPAT, 'UTF-8') . '</a></li>';
			}
			$this->_html .= '</ul>';
			foreach ($criterions_groups_indexed as $key => $criterions_group_indexed) {
				$this->_html .= '<div id="seoSearchPanelCriteriaTabs-' . $key . '" class="seoSearchPanelCriteriaTabsContent" style="height:100px;overflow:auto;">
				<ul class="ui-helper-reset ui-sortable">';
				if ($criterions_group_indexed ['range'] == 1) {
					if ($criterions_group_indexed ['criterion_group_type'] == 'price') {
						$default_currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
						$criterions_group_indexed ['range_sign'] = $default_currency->sign;
						$rangeSignLeft = $default_currency->getSign('left');
						$rangeSignRight = $default_currency->getSign('right');
					} else {
						$rangeSignLeft = '';
						$rangeSignRight = ' '.$criterions_group_indexed['range_sign'];
					}
					$ranges = explode(',', $criterions_group_indexed ['range_interval']);
					$criterions = array();
					foreach($ranges as $krange => $range) {
						$rangeUp = (isset($ranges[$krange+1]) ? $ranges[$krange+1]:'');
						$range1 = $range.'-'.$rangeUp;
						$range2 = ($rangeUp?$this->l('From'):$this->l('More than')).' '.$rangeSignLeft.$range.$rangeSignRight.($rangeUp?' '.$this->l('to').' '.$rangeSignLeft.$rangeUp.$rangeSignRight:'');
						$selected_criteria_groups_type = AdvancedSearchClass::getCriterionGroupsTypeAndDisplay($id_search,array($criterions_group_indexed ['id_criterion_group']));
						$criterions [] = array('id_criterion' => $range1, 'value' => $range2);
					}
					if ($criterions && sizeof($criterions)) {
						foreach ($criterions as $row) {
							$this->_html .= '<li class="ui-state-default seoSearchCriterionSortable" id="criterion_'.$criterions_group_indexed ['id_criterion_group'].'_' .  $row ['id_criterion'] . '" title="' . htmlentities($row ['value'], ENT_COMPAT, 'UTF-8') . '">';
							$this->_html .= htmlentities($row ['value'], ENT_COMPAT, 'UTF-8');
							$this->_html .= '</li>';
						}
					}
				}
				elseif ($criterions_group_indexed ['criterion_group_type'] == 'price') {
					$default_currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
					$price_range = AdvancedSearchClass::getPriceRangeForSearchBloc($search[0], $criterions_group_indexed ['id_criterion_group_linked'], (int)$default_currency->id, $this->getCurrentCustomerGroupId(), 0, $count_product = false, $selected_criterion = array(), $selected_criteria_groups_type = array());
					$this->_html .= '<li class="ui-state-default seoSearchCriterionSortable seoSearchCriterionPriceSortable" id="criterion_'. (int) $criterions_group_indexed ['id_criterion_group'].'_' . (isset($curPriceRange) ? $curPriceRange :  (float)$price_range [0] ['min_price'].'-'. (float)$price_range [0] ['max_price']) . '" title="' . $this->l('From') . ' ' . (int)$price_range [0] ['min_price'] . ' ' . $this->l('to') . ' ' . $default_currency->getSign('left') . (int)$price_range [0] ['max_price'] . $default_currency->getSign('right') . '" style="width:50%">';
					$this->_html .= $this->l('Choose your price range bellow : ') . '<br />';
					$this->_html .= '<div id="PM_ASSeoPriceRange" style="width:30%;margin-left:10px;float:left"></div>';
					$this->_html .= '<span id="PM_ASPriceRangeValue" style="width:35%;display:block;float:left;font-size:11px;margin-left:10px;">' . (int)$price_range [0] ['min_price'] . ' - ' . $default_currency->getSign('left') . (int)$price_range [0] ['max_price'] . $default_currency->getSign('right') . '</span>';
					$this->_html .= '<select id="id_currency" name="id_currency" style="float:left;margin-left:10px;width:50px;">';
					foreach (Currency::getCurrencies() as $row )
						$this->_html .= '<option value="' . (int)$row ['id_currency'] . '" ' . ($default_currency->id == $row ['id_currency'] ? 'selected="selected"' : '') . '>' . $row ['sign'] . '</option>';
					$this->_html .= '</select>';
					$this->_html .= '<script type="text/javascript">
	            $jqPm( "#id_currency" ).change(function() {
	              var id_currency = $jqPm(this).val();
	              $jqPm.ajax( {
	                type : "GET",
	                url : "' . $this->_base_config_url . '&pm_load_function=displaySeoPriceSlider&id_search=' . (int)$criterions_group_indexed ['id_search'] . '&id_criterion_group_linked=' . (int)$criterions_group_indexed ['id_criterion_group_linked'] . '&id_currency="+id_currency,
	                dataType : "script"
	              });
	            });
	            $jqPm( "#PM_ASSeoPriceRange" ).slider({
	              range: true,
	              min: ' . (int)$price_range [0] ['min_price'] . ',
	              max: ' . (int)$price_range [0] ['max_price'] . ',
	                values: [ ' . (int)$price_range [0] ['min_price'] . ', ' . (int)$price_range [0] ['max_price'] . ' ],
	              slide: function( event, ui) {
	                $jqPm( "#PM_ASPriceRangeValue" ).html( "" + ui.values[ 0 ] + " - " + "'.$default_currency->getSign('left').'" + ui.values[ 1 ] + "'.$default_currency->getSign('right').'" );
	                $jqPm( ".seoSearchCriterionPriceSortable" ).attr("id", "criterion_'.$criterions_group_indexed ['id_criterion_group'].'_" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
	                $jqPm( ".seoSearchCriterionPriceSortable" ).attr("title", "' . $this->l('From') . ' " + ui.values[ 0 ] + " ' . $this->l('And') . ' " + "'.$default_currency->getSign('left').'" + ui.values[ 1 ] + "'.$default_currency->getSign('right').'" );
	              }
	            });
	          </script>';
					$this->_html .= '</li>';
				}
				elseif ($criterions_group_indexed ['display_type'] == 5) {
					$range = AdvancedSearchClass::getCriterionsRange($search[0], $criterions_group_indexed ['id_criterion_group'], $this->_cookie->id_lang,false,array(),array(),false,false,false, $criterions_group_indexed);
					$this->_html .= '<li class="ui-state-default seoSearchCriterionSortable seoSearchCriterionRangeSortable'.$criterions_group_indexed ['id_criterion_group'].'" id="criterion_'. (int) $criterions_group_indexed ['id_criterion_group'].'_' . (isset($curPriceRange) ?  $curPriceRange : (float)$range [0] ['min'].'-'.(float)$range [0] ['max']) . '" title="' . $this->l('From') . ' ' . (float)$range [0] ['min'] . ' ' . $this->l('to') . ' ' . (float)$range [0] ['max'] . ' (' . $criterions_group_indexed ['range_sign'] . ')" style="width:50%">';
					$this->_html .= $this->l('Choose your range bellow : ') . '<br />';
					$this->_html .= '<div id="PM_ASSeoRange'.$criterions_group_indexed ['id_criterion_group'].'" style="width:30%;margin-left:10px;float:left"></div>';
					$this->_html .= '<span id="PM_ASRangeValue'.$criterions_group_indexed ['id_criterion_group'].'" style="width:35%;display:block;float:left;font-size:11px;margin-left:10px;">' . (float)$range [0] ['min'] . ' - ' . (float)$range [0] ['max'] . ' (' . $criterions_group_indexed ['range_sign'] . ')</span>';
					$this->_html .= '<script type="text/javascript">
					$jqPm( "#PM_ASSeoRange'.$criterions_group_indexed ['id_criterion_group'].'" ).slider({
					range: true,
					min: ' . (float)$range [0] ['min'] . ',
					max: ' . (float)$range [0] ['max'] . ',
					values: [ ' . (float)$range [0] ['min'] . ', ' . (float)$range [0] ['max'] . ' ],
					slide: function( event, ui) {
					$jqPm( "#PM_ASRangeValue'.$criterions_group_indexed ['id_criterion_group'].'" ).html( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]  + " (' . $criterions_group_indexed['range_sign'] . ')" );
					$jqPm( ".seoSearchCriterionRangeSortable'.$criterions_group_indexed ['id_criterion_group'].'" ).attr("id", "criterion_'.$criterions_group_indexed ['id_criterion_group'].'_" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
					$jqPm( ".seoSearchCriterionRangeSortable'.$criterions_group_indexed ['id_criterion_group'].'" ).attr("title", "' . $this->l('From') . ' " + ui.values[ 0 ] + " ' . $this->l('to') . ' " + ui.values[ 1 ] + " (' . $criterions_group_indexed ['range_sign'] . ')" );
					}
					});
					</script>';
					$this->_html .= '</li>';
				}
				else {
					$criterions = AdvancedSearchClass::getCriterionsFromCriterionGroup($criterions_group_indexed ['criterion_group_type'], $criterions_group_indexed ['id_criterion_group_linked'], $criterions_group_indexed ['id_search'], $criterions_group_indexed ['sort_by'], $criterions_group_indexed ['sort_way'], $this->_cookie->id_lang);
					if ($criterions && sizeof($criterions)) {
						foreach ($criterions as $row) {
							$this->_html .= '<li class="ui-state-default seoSearchCriterionSortable" id="criterion_'.$criterions_group_indexed ['id_criterion_group'].'_' . (int)$row ['id_criterion'] . '" title="' . htmlentities($row ['value'], ENT_COMPAT, 'UTF-8') . '">';
							$this->_html .= htmlentities($row ['value'], ENT_COMPAT, 'UTF-8');
							$this->_html .= '</li>';
						}
					}
				}
				$this->_html .= '</ul></div>';
			}
			$this->_html .= '</div>';
			$this->_showInfo($this->l('Add criteria of your choice to generate pre-defined searches.') . '<br />' . $this->l('Drag selected criteria above and drop them bellow.'));
			$this->_html .= '<div id="nbProductsCombinationSeoSearchForm" style="height:30px;"></div>';
			$this->_html .= '<div id="seoSearchPanelCriteriaSelected">
	      <div class="ui-widget-content" style="padding:10px;">
	        <ul style="width:835px;float:left;min-height:50px;" class="ui-helper-reset ui-sortable">';
			if ($criteria && sizeof($criteria)) {
				foreach ($criteria as $criterion) {
					$info_criterion = explode('_', $criterion);
					$id_criterion_group = $info_criterion[0];
					$id_criterion = $info_criterion[1];
					$isPriceCriterion = false;
					$objAdvancedSearchCriterionGroupClass = new AdvancedSearchCriterionGroupClass($id_criterion_group, $id_search);
					if (preg_match('#-#', $id_criterion)) {
						$isPriceCriterion = true;
						$range = explode('-', $id_criterion);
						$currency = new Currency($params['obj']->id_currency);
						$min = $range [0];
						$max = Tools::displayPrice($range[1], $currency);
						$citerion_value = $this->l('From') . ' ' . $min . ' ' . $this->l('to') . ' ' . $max;
					}
					else {
						$objAdvancedSearchCriterionClass = new AdvancedSearchCriterionClass($id_criterion, $id_search, $this->_cookie->id_lang);
						$citerion_value = (!$objAdvancedSearchCriterionClass->value && $objAdvancedSearchCriterionClass->single_value ? $objAdvancedSearchCriterionClass->single_value : trim($objAdvancedSearchCriterionClass->value));
					}
					$this->_html .= '<li class=\'ui-state-default seoSearchCriterionSortable\' id=\'biscriterion_' . $criterion . '\' rel=\'criterion_' . $criterion . '\'><span class=\'ui-icon ui-icon-close\' style=\'float: left; margin-right: .3em;cursor:pointer;\' onclick=\'removeSelectedSeoCriterion(this);\'></span> ' . $citerion_value ;
					$this->_html .= '<script type="text/javascript">$jqPm("#criterion_' . $criterion . '").hide();</script>';
					$this->_html .= '</li>';
				}
			}
			else {
				$this->_html .= '<li class="placeholder">' . $this->l('Add your criteria here') . '</li>';
			}
			$this->_html .= '</ul>';
			$this->_pmClear();
	        $this->_html .= '
	      </div>
	    </div>';
			$this->_html .= '<script type="text/javascript">
	      	var msgNoSeoCriterion = "' . $this->l('You must choose at least one criteria to use this option') . '";
	              $jqPm(document).ready(function() {
	                  $jqPm("#seoSearchPanelCriteriaTabs").tabs({cache:false});
	                  $jqPm( ".seoSearchPanelCriteriaTabsContent li" ).draggable({
	            appendTo: "body",
	            helper: "clone"
	          });
	          $jqPm( "#seoSearchPanelCriteriaSelected ul" ).droppable({
	            activeClass: "ui-state-default",
	            hoverClass: "ui-state-hover",
	            accept: ":not(.ui-sortable-helper)",
	            drop: function( event, ui) {
	              $jqPm( this ).find( ".placeholder" ).remove();
	              if (ui.draggable.hasClass("seoSearchCriterionPriceSortable")) {
	                $jqPm( "<li class=\'ui-state-default seoSearchCriterionSortable\' id=\'bis"+ui.draggable.attr("id")+"\' rel=\'"+ui.draggable.attr("id")+"\'></li>" ).html( "<span class=\'ui-icon ui-icon-close\' style=\'float: left; margin-right: .3em;cursor:pointer;\' onclick=\'removeSelectedSeoCriterion(this);\'></span> "+ui.draggable.attr("title") ).appendTo( this );
	              }
	              else
	                $jqPm( "<li class=\'ui-state-default seoSearchCriterionSortable\' id=\'bis"+ui.draggable.attr("id")+"\' rel=\'"+ui.draggable.attr("id")+"\'></li>" ).html( "<span class=\'ui-icon ui-icon-close\' style=\'float: left; margin-right: .3em;cursor:pointer;\' onclick=\'removeSelectedSeoCriterion(this);\'></span> "+ui.draggable.attr("title") ).appendTo( this );
	              ui.draggable.fadeOut("fast");
	              seoSearchCriteriaUpdate();
	            }
	          }).sortable({
	            items: "li:not(.placeholder)",
	            placeholder: "ui-state-highlight seoSearchCriterionSortable",
	            sort: function() {
	              $jqPm( this ).removeClass( "ui-state-default" );
	            },
	                  update: function(event, ui) {
	            seoSearchCriteriaUpdate();
	                }
	          });
	        seoSearchCriteriaUpdate();
	        });
	          </script>';
			$this->_showInfo($this->l('Then, you can re-order them to automaticaly generate friendly strings and urls'));
			$this->_addButton(array('text'=> $this->l('Auto Fill'),'href'=>'javascript:void(0);','onclick'=>'fillSeoFields();','icon_class'=>'ui-icon ui-icon-refresh'));
			$this->_pmClear();
			$this->_html .= ' <input type="hidden" name="id_currency" id="posted_id_currency" />
		    <input type="hidden" name="criteria" id="seoSearchCriteriaInput" />
		    <input type="hidden" name="id_search" id="id_search" value="' . (int)$id_search . '" />
	    ' . ($params['obj'] ? '<input type="hidden" name="id_seo" value="' . intval($params['obj']->id) . '" /><br class="clear" /><br />' : '');
			$this->_displayInputTextLang(array('obj' => $params['obj'], 'key' => 'meta_title', 'label' => $this->l('Meta Title')));
			$this->_displayInputTextLang(array('obj' => $params['obj'], 'key' => 'meta_description', 'label' => $this->l('Meta description')));
			$this->_displayInputTextLang(array('obj' => $params['obj'], 'key' => 'meta_keywords', 'label' => $this->l('Meta keywords')));
			$this->_displayInputTextLang(array('obj' => $params['obj'], 'key' => 'title', 'label' => $this->l('Title (H1)')));
			$this->_displayInputTextLang(array('obj' => $params['obj'], 'key' => 'seo_url', 'label' => $this->l('Friendly URL'),'onkeyup'=>'ASStr2url(this);','onchange'=>'ASStr2url(this);'));
			$this->_displayRichTextareaLang(array('obj' => $params['obj'], 'key' => 'description', 'label' => $this->l('Description')));
			$crossLinksSelected = false;
			if ($params['obj'] && Validate::isLoadedObject($params['obj']))
				$crossLinksSelected = $params['obj']->getCrossLinksOptionsSelected($this->_cookie->id_lang);
			$this->_displayAjaxSelectMultiple(array('selectedoptions' => $crossLinksSelected, 'key' => 'cross_links', 'label' => $this->l('Products pages to link under results'), 'remoteurl' => $this->_base_config_url.'&pm_load_function=displaySeoSearchOptions&id_seo_origin=' . $params['obj']->id));
			$this->_html .= '<center>
	        		<p class="ui-state-error ui-corner-all" id="errorCombinationSeoSearchForm" style="display:none;padding:10px;">
	        			<b>' . $this->l('Your criteria combination led to no result, please reorder them before submiting') . '</b>
	        		</p></center>';
			$this->_displaySubmit($this->l('   Save   '), 'submitSeoSearchForm');
		}
        $this->_endForm(array('id' => 'seoSearchForm'));
	}
	protected function displayMassSeoSearchForm() {
		$id_search = Tools::getValue('id_search');
		$search = AdvancedSearchClass::getSearch($id_search,false,false);
		$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexedForSEO($id_search, $this->_cookie->id_lang);
		$this->_startForm(array('id' => 'seoMassSearchForm'));
		$this->_displayTitle($this->l('Massive add of products pages'));
		$this->_showInfo($this->l('Select your criteria'));
   		$this->_html .= '<div id="seoSearchPanelCriteriaTabs">
   		 <ul>';
		foreach ($criterions_groups_indexed as $key => $criterions_group_indexed) {
			$this->_html .= '<li><a href="#seoSearchPanelCriteriaTabs-' . $key . '">' . htmlentities($criterions_group_indexed ['name'], ENT_COMPAT, 'UTF-8') . '</a></li>';
		}
		$this->_html .= '</ul>';
		foreach ($criterions_groups_indexed as $key => $criterions_group_indexed) {
			$this->_html .= '<div id="seoSearchPanelCriteriaTabs-' . $key . '" class="seoSearchPanelCriteriaTabsContent" style="height:150px;overflow:auto;text-align:left;">';
			$this->_html .= '<input type="hidden" name="id_criterion_group" value="' . (int)$criterions_group_indexed ['id_criterion_group'] . '" style="margin-left:4px;" /><input type="checkbox" value="0" style="margin-left:4px;" onclick="enableAllCriterion4MassSeo(this);" /> &nbsp; <small>' . $this->l('Check all') . '</small><br /><br />';
			$this->_html .= '<ul class="ui-helper-reset ui-sortable">';
			if ($criterions_group_indexed ['range'] == 1) {
				if ($criterions_group_indexed ['criterion_group_type'] == 'price') {
					$default_currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
					$criterions_group_indexed ['range_sign'] = $default_currency->sign;
					$rangeSignLeft = $default_currency->getSign('left');
					$rangeSignRight = $default_currency->getSign('right');
				} else {
					$rangeSignLeft = '';
					$rangeSignRight = ' '.$criterions_group_indexed['range_sign'];
				}
				$ranges = explode(',', $criterions_group_indexed ['range_interval']);
				$criterions = array();
				foreach($ranges as $krange => $range) {
					$rangeUp = (isset($ranges[$krange+1]) ? $ranges[$krange+1]:'');
					$range1 = $range.'-'.$rangeUp;
					$range2 = ($rangeUp?$this->l('From'):$this->l('More than')).' '.$rangeSignLeft.$range.$rangeSignRight.($rangeUp?' '.$this->l('to').' '.$rangeSignLeft.$rangeUp.$rangeSignRight:'');
					$selected_criteria_groups_type = AdvancedSearchClass::getCriterionGroupsTypeAndDisplay($id_search,array($criterions_group_indexed ['id_criterion_group']));
					$criterions [] = array('id_criterion' => $range1, 'value' => $range2);
				}
				if ($criterions && sizeof($criterions)) {
					foreach ($criterions as $row) {
						$this->_html .= '<li class="ui-state-default massSeoSearchCriterion" id="criterion_'.$criterions_group_indexed ['id_criterion_group'].'_' .  $row ['id_criterion'] . '" title="' . htmlentities($row ['value'], ENT_COMPAT, 'UTF-8') . '" onclick="enableCriterion4MassSeo(this);">';
						$this->_html .= '<input type="checkbox" name="criteria[' . (int)$criterions_group_indexed ['id_criterion_group'] . '][]" value="'.$criterions_group_indexed ['id_criterion_group'].'_' . $row ['id_criterion'] . '" onclick="enableCriterion4MassSeo($jqPm( this ).parent(\'li\'));" /> &nbsp; ';
						$this->_html .= htmlentities($row ['value'], ENT_COMPAT, 'UTF-8');
						$this->_html .= '</li>';
					}
				}
			} elseif ($criterions_group_indexed ['criterion_group_type'] == 'price') {
				$default_currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
				$price_range = AdvancedSearchClass::getPriceRangeForSearchBloc($search[0], $criterions_group_indexed ['id_criterion_group_linked'], (int)$default_currency->id, $this->getCurrentCustomerGroupId(), 0, $count_product = false, $selected_criterion = array(), $selected_criteria_groups_type = array());
				$this->_html .= '<li class="ui-state-default massSeoSearchCriterion massSeoSearchCriterionPrice" id="criterion_price' . (isset($price_range [0] ['min_price']) ? '-' . (int)$price_range [0] ['min_price'] . '-' . (int)$price_range [0] ['max_price'] : '') . '" title="' . $this->l('From') . ' ' . (int)$price_range [0] ['min_price'] . ' ' . $this->l('to') . ' ' . Tools::displayPrice((int)$price_range[0]['max_price'], $default_currency) . '"  onclick="enableCriterion4MassSeo(this);" style="height:50px;">';
				$this->_html .= '<input type="checkbox" id="massSeoSearchCriterionPriceInput" name="criteria[' . (int)$criterions_group_indexed ['id_criterion_group'] . '][]" value="'.$criterions_group_indexed ['id_criterion_group'].'_' . (isset($price_range [0] ['min_price']) ? (float)$price_range [0] ['min_price'] . '-' . (float)$price_range [0] ['max_price'] : '') . '" onclick="enableCriterion4MassSeo($jqPm( this ).parent(\'li\'));" /> &nbsp; ';
				$this->_html .= $this->l('Choose your price range bellow : ') . '<br />';
				$this->_html .= '<div id="PM_ASSeoPriceRange" style="width:30%;margin-left:10px;margin-top:10px;float:left"></div>';
				$this->_html .= '<span id="PM_ASPriceRangeValue" style="width:35%;display:block;margin-top:10px;float:left;font-size:11px;margin-left:10px;">' . (int)$price_range [0] ['min_price'] . ' - ' . Tools::displayPrice((int)$price_range[0]['max_price'], $default_currency) . '</span>';
				$this->_html .= '<select id="id_currency" name="id_currency" style="float:left;margin-left:10px;width:50px;margin-top:10px;">';
				foreach (Currency::getCurrencies() as $row )
					$this->_html .= '<option value="' . (int)$row ['id_currency'] . '" ' . ($default_currency->id == $row ['id_currency'] ? 'selected="selected"' : '') . '>' . $row ['sign'] . '</option>';
				$this->_html .= '</select>';
				$this->_html .= '<script type="text/javascript">
            $jqPm( "#id_currency" ).change(function() {
              var id_currency = $jqPm(this).val();
              $jqPm.ajax( {
                type : "GET",
                url : "' . $this->_base_config_url . '&pm_load_function=displaySeoPriceSlider&id_search=' . (int)$criterions_group_indexed ['id_search'] . '&id_criterion_group_linked=' . (int)$criterions_group_indexed ['id_criterion_group_linked'] . '&id_currency="+id_currency,
                dataType : "script"
              });
            });
            $jqPm( "#PM_ASSeoPriceRange" ).slider({
              range: true,
              min: ' . (int)$price_range [0] ['min_price'] . ',
              max: ' . (int)$price_range [0] ['max_price'] . ',
                values: [ ' . (int)$price_range [0] ['min_price'] . ', ' . (int)$price_range [0] ['max_price'] . ' ],
              slide: function( event, ui) {
                $jqPm( "#PM_ASPriceRangeValue" ).html( "" + ui.values[0] + " - " + "'.$default_currency->getSign('left').'" + ui.values[1] + "'.$default_currency->getSign('right').'" );
                $jqPm( "#massSeoSearchCriterionPriceInput" ).val('.$criterions_group_indexed ['id_criterion_group'].' + "_" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
                $jqPm( ".seoSearchCriterionPriceSortable" ).attr("id", "criterion_price-" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
                $jqPm( ".seoSearchCriterionPriceSortable" ).attr("title", "' . $this->l('From') . ' " + ui.values[ 0 ] + " ' . $this->l('to') . ' " + "'.$default_currency->getSign('left').'" + ui.values[1] + "'.$default_currency->getSign('right').'" );
              }
            });
          </script>';
				$this->_html .= '</li>';
			} elseif ($criterions_group_indexed ['display_type'] == 5) {
				$range = AdvancedSearchClass::getCriterionsRange($search[0], $criterions_group_indexed ['id_criterion_group'], $this->_cookie->id_lang,false,array(),array(),false,false,false, $criterions_group_indexed);
				$this->_html .= '<li class="ui-state-default massSeoSearchCriterion seoSearchCriterionRangeSortable'.$criterions_group_indexed ['id_criterion_group'].'" id="criterion_'. (int) $criterions_group_indexed ['id_criterion_group'].'_' .(float)$range [0] ['min'].'-'.(float)$range [0] ['max']. '" title="' . $this->l('From') . ' ' . (float)$range [0] ['min'] . ' ' . $this->l('to') . ' ' . (float)$range [0] ['max'] . ' (' . $criterions_group_indexed ['range_sign'] . ')"  onclick="enableCriterion4MassSeo(this);" style="height:50px;">';
				$this->_html .= '<input type="checkbox" id="massSeoSearchCriterionRangeInput' . (int)$criterions_group_indexed ['id_criterion_group'] . '" name="criteria[' . (int)$criterions_group_indexed ['id_criterion_group'] . '][]" value="'.$criterions_group_indexed ['id_criterion_group'].'_'. (int) $criterions_group_indexed ['id_criterion_group'].'_' .(float)$range [0] ['min'].'-'.(float)$range [0] ['max']. '" onclick="enableCriterion4MassSeo($jqPm( this ).parent(\'li\'));" /> &nbsp; ';
				$this->_html .= $this->l('Choose your range bellow : ') . '<br />';
				$this->_html .= '<div id="PM_ASSeoRange'.$criterions_group_indexed ['id_criterion_group'].'" style="width:30%;margin-left:10px;float:left"></div>';
				$this->_html .= '<span id="PM_ASRangeValue'.$criterions_group_indexed ['id_criterion_group'].'" style="width:35%;display:block;float:left;font-size:11px;margin-left:10px;">' . (float)$range [0] ['min'] . ' - ' . (float)$range [0] ['max'] . ' (' . $criterions_group_indexed ['range_sign'] . ')</span>';
				$this->_html .= '<script type="text/javascript">
				$jqPm( "#PM_ASSeoRange'.$criterions_group_indexed ['id_criterion_group'].'" ).slider({
				range: true,
				min: ' . (float)$range [0] ['min'] . ',
				max: ' . (float)$range [0] ['max'] . ',
				values: [ ' . (float)$range [0] ['min'] . ', ' . (float)$range [0] ['max'] . ' ],
				slide: function( event, ui) {
				$jqPm( "#PM_ASRangeValue'.$criterions_group_indexed ['id_criterion_group'].'" ).html( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]  + " (' . $criterions_group_indexed['range_sign'] . ')" );
				$jqPm( "#massSeoSearchCriterionRangeInput' . (int)$criterions_group_indexed ['id_criterion_group'] . '" ).val('.$criterions_group_indexed ['id_criterion_group'].' + "_" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
				$jqPm( ".seoSearchCriterionRangeSortable'.$criterions_group_indexed ['id_criterion_group'].'" ).attr("id", "criterion_'.$criterions_group_indexed ['id_criterion_group'].'_" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
				$jqPm( ".seoSearchCriterionRangeSortable'.$criterions_group_indexed ['id_criterion_group'].'" ).attr("title", "' . $this->l('From') . ' " + ui.values[ 0 ] + " ' . $this->l('to') . ' " + ui.values[ 1 ] + " (' . $criterions_group_indexed ['range_sign'] . ')" );
			}
			});
			</script>';
				$this->_html .= '</li>';
			} else {
				$criterions = AdvancedSearchClass::getCriterionsFromCriterionGroup($criterions_group_indexed ['criterion_group_type'], $criterions_group_indexed ['id_criterion_group_linked'], $criterions_group_indexed ['id_search'], $criterions_group_indexed ['sort_by'], $criterions_group_indexed ['sort_way'], $this->_cookie->id_lang);
				if ($criterions && sizeof($criterions)) {
					foreach ($criterions as $row) {
						$this->_html .= '<li class="ui-state-default massSeoSearchCriterion" id="criterion_' . (int)$row ['id_criterion'] . '" title="' . htmlentities($row ['value'], ENT_COMPAT, 'UTF-8') . '" onclick="enableCriterion4MassSeo(this);">';
						$this->_html .= '<input type="checkbox" name="criteria[' . (int)$criterions_group_indexed ['id_criterion_group'] . '][]" value="'.(int) $criterions_group_indexed ['id_criterion_group'].'_' . (int)$row ['id_criterion'] . '" onclick="enableCriterion4MassSeo($jqPm( this ).parent(\'li\'));" /> &nbsp; ';
						$this->_html .= htmlentities($row ['value'], ENT_COMPAT, 'UTF-8');
						$this->_html .= '</li>';
					}
				}
			}
			$this->_html .= '</ul></div>';
		}
		$this->_html .= '</div>';
		$this->_showInfo($this->l('Reorder criteria groups for making human reading expressions'));
		$this->_html .= '<div id="seoMassSearchPanelCriteriaGroupsTabs">
    <ul style="width:835px;min-height:50px;" class="ui-helper-reset ui-sortable">';
		foreach ($criterions_groups_indexed as $key => $criterions_group_indexed) {
			$this->_html .= '<li class="ui-state-default seoSearchCriterionSortable ui-state-disabled seoSearchCriterionGroupSortable" id="criterion_group_' . (int)$criterions_group_indexed ['id_criterion_group'] . '" style="display:none;"><a href="#seoSearchPanelCriteriaTabs-' . $key . '">' . htmlentities($criterions_group_indexed ['name'], ENT_COMPAT, 'UTF-8') . '</a></li>';
		}
		$this->_html .= '</ul></div>
    <input type="hidden" name="id_search" id="id_search" value="' . (int)$id_search . '" />
    <input type="hidden" name="criteria_groups" id="massSeoSearchCriterionGroupsInput" />';
		$this->_pmClear();
		$this->_html .= '<script type="text/javascript">
      var msgMaxCriteriaForMass = "' . $this->l('You can not select more than three groups of criteria') . '";
      var msgNoSeoCriterion = "' . $this->l('You must choose at least one criterion to use this option') . '";
              $jqPm(document).ready(function() {
                  $jqPm("#seoSearchPanelCriteriaTabs").tabs({cache:false});
                  $jqPm("#seoMassSearchPanelCriteriaGroupsTabs ul").sortable({
            items: "li:not(.ui-state-disabled)",
            placeholder: "ui-state-highlight seoSearchCriterionSortable",
            sort: function() {
              $jqPm( this ).removeClass( "ui-state-default" );
            },
                    update: function(event, ui) {
              massSeoSearchCriteriaGroupUpdate();
                  }
          });
        });
          </script>';
		$this->_showInfo($this->l('Then, you can click bellow to automaticaly generate friendly strings and urls'));
		$this->_displaySubmit($this->l('Generate SEO pages'), 'submitMassSeoSearchForm');
		$this->_pmClear();
		$this->_endForm(array('id' => 'seoMassSearchForm'));
	}
	public function getContent() {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $this->_html .= '<div id="pm_backoffice_wrapper" class="pm_bo_ps_'.substr(str_replace('.', '', _PS_VERSION_), 0, 2).'">';
		$this->_displayTitle($this->displayName);
		if ($this -> _checkPermissions()) {
			if (Tools::getValue('makeUpdate'))
				$this->checkIfModuleIsUpdate(true);
			if (!$this->checkIfModuleIsUpdate(false)) {
				if (Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false) !== false && version_compare(Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false), '4.8', '>=') && version_compare(Configuration::get('PM_' . self::$_module_prefix . '_LAST_VERSION', false), '4.9.1',  '<=')) {
				$this->_html .= '
					<div class="warning warn clear">
						'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? '
						<p>' . $this->l('You have an old version of the module, this new version has a new approach for multishop features.') . '</p>
						<p>' . $this->l('Because of a lot of constraints, you will not be able to associate one search engine to multiple shops anymore.') . '</p>
						<p>' . $this->l('If it is your case at this time, we will only associate your search engine to one shop (from all the shops it was currently associated).') . '</p>
						' : '').'
						<p>' . $this->l('We really recommand you to re-index all the search engines after this update. Thank you for your comprehension.') . '</p>
					</div><br />';
				}
				$this->_html .= '
					<div class="warning warn clear"><p>' . $this->l('We have detected that you installed a new version of the module on your shop') . '</p>
						<p style="text-align: center"><a href="' . $this->_base_config_url . '&makeUpdate=1" class="button">' . $this->l('Please click here in order to finish the installation process') . '</a></p>
					</div>';
				$this->_loadCssJsLibraries();
			} else {
				if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::getContext() != Shop::CONTEXT_SHOP) {
					$this->_loadCssJsLibraries();
					$this->_html .= '<div class="module_error alert error">' . $this->l('You must select a specific shop in order to continue, you can\'t create/edit a search engine from the "all shop" or "group shop" context.'). '</div>';
				} else {
					$this ->_preProcess();
					$this->_loadCssJsLibraries();
					$this->_postProcess();
					$this->_showRating(true);
					parent::getContent();
					$this->_html .= '
					<script type="text/javascript">
						  var editTranlate = "' . $this->l('Edit') . '";
						  var reindexationInprogressMsg = "' . addcslashes($this->l('Another reindexing is in progress. Please wait.'),'"') . '";
						  var reindexingCriteriaMsg = "'.addcslashes($this->l('Reindexing criteria group'),'"').'";
						  var reindexingCriteriaOfMsg = "'.addcslashes($this->l('of'),'"').'";
						  $jqPm(document).ready(function() {
						  //Initialise the second table specifying a dragClass and an onDrop function that will display an alert
							$jqPm("#wrapConfigTab, #wrapAsTab").tabs({cache:false});
						 });
					  </script>';
					$advanced_searchs = AdvancedSearchClass::getSearchs($this->_cookie->id_lang, false);
					$this->_addButton(array('text'=> $this->l('Add a new search'),'href'=>$this->_base_config_url . '&pm_load_function=displaySearchForm&class=AdvancedSearchClass&pm_js_callback=closeDialogIframe','icon_class'=>'ui-icon ui-icon-circle-plus','class'=>'open_on_dialog_iframe','rel'=>'950_530_1'));
					$this->_html .= '<br /><br /><div id="wrapAsTab">
										<ul id="asTab">';
					if ($advanced_searchs && sizeof($advanced_searchs)) {
						foreach ($advanced_searchs as $k => $advanced_search) {
							$this->_html .= '<li id="TabSearchAdminPanel' . (int)$advanced_search ['id_search'] . '"><a href="' . $this->_base_config_url . '&pm_load_function=displaySearchAdminPanel&id_search=' . $advanced_search ['id_search'] . '"><span>' . $advanced_search ['internal_name'] . '</span></a></li>';
						}
					}
					$this->_html .= '</ul>';
					$this->_html .= '</div><br />';
					$this->_html .= '<div id="msgNoResults" style="' . ($advanced_searchs && sizeof($advanced_searchs) ? 'display:none;' : '') . '">';
					$this->_showInfo($this->l('You do not have added a search engine yet. Please click on the click "Add a new search" in order to start.'));
					$this->_html .= '<br /></div>';
					$this->_html .= '<div id="wrapConfigTab">
										<ul id="configTab">
										  <li><a href="#config-2"><span><img src="' . $this->_path . 'img/document-code.png" /> ' . $this->l('Advanced styles') . '</span></a></li>
										  <li><a href="#config-3"><span><img src="' . $this->_path . 'img/clock.png" /> ' . $this->l('Crontab') . '</span></a></li>
										  <li><a href="#config-4"><span><img src="' . $this->_path . 'img/drill.png" /> ' . $this->l('Maintenance') . '</span></a></li>
										</ul>';
					$this->_html .= '<div id="config-2">';
					$this->displayAdvancedConfig();
					$this->_html .= '</div>';
					$this->_html .= '<div id="config-3">';
					$this->_html .= '<br /><div class="conf confirm">' . $this->l('Use this URL for CRON Tasks (reindexation)') . '<br />' . (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? $this->context->shop->getBaseURL() : Tools::getHttpHost(true, true) . __PS_BASE_URI__) . 'modules/pm_advancedsearch4/cron.php?secure_key=' . (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Configuration::getGlobalValue('PM_AS4_SECURE_KEY') : Configuration::get('PM_AS4_SECURE_KEY')). '</div>';
					$this->_html .= '</div>';
					$this->_html .= '<div id="config-4">';
					$this->displayMaintenance();
					$this->_html .= '</div>';
					$this->_html .= '</div>';
				}
			}
		}else {
			$this->_loadCssJsLibraries();
		}
		$this->_displaySupport();
		$this->_html .= '</div>';
		return $this->_html;
	}
	protected function displaySearchForm($params) {
		if ($params['obj']->id) {
			$categoriesAssociation = AdvancedSearchClass::getCategoriesAssociation($params['obj']->id, $this->_cookie->id_lang);
			$cmsAssociation = AdvancedSearchClass::getCMSAssociation($params['obj']->id, $this->_cookie->id_lang);
			$manufacturersAssociation = AdvancedSearchClass::getManufacturersAssociation($params['obj']->id);
			$suppliersAssociation = AdvancedSearchClass::getSuppliersAssociation($params['obj']->id);
			$productsAssociation = AdvancedSearchClass::getProductsAssociation($params['obj']->id, $this->_cookie->id_lang);
			$specialPagesAssociation = AdvancedSearchClass::getSpecialPagesAssociation($params['obj']->id, true, $this->_cookie->id_lang);
		}else {
			$categoriesAssociation = array();
			$cmsAssociation = array();
			$manufacturersAssociation = array();
			$suppliersAssociation = array();
			$productsAssociation = array();
			$specialPagesAssociation = array();
		}
		$this->_startForm(array('id' => 'searchForm','obj' => $params['obj'],'params'=>$params));
		$this->_displayTitle((isset($params['obj']) && Validate::isLoadedObject($params['obj']) ? $this->l('Edit Search') : $this->l('Add Search')));
		$this->_startFieldset(false, false, false);
		$this->_displayInputText(array('obj' => $params['obj'],'key' => 'internal_name', 'label' => $this->l('Internal name') ));
		$this->_endFieldset();
		$this->_startFieldset($this->l('Display'), $this->_path . 'img/eye.png', false);
		$this->_displayInputTextLang(array('obj' => $params['obj'], 'key' => 'title', 'label' => $this->l('Public title')));
		$this->_displayRichTextareaLang(array('obj' => $params['obj'], 'key' => 'description', 'label' => $this->l('Description')));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'activestatus', 'key_db' => 'active', 'label' => $this->l('Active')));
		$hooks = array();
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$valid_hooks = AdvancedSearchClass::$_valid_hooks_1_5;
		else
			$valid_hooks = AdvancedSearchClass::$_valid_hooks;
		foreach ($valid_hooks as $k => $hook_name) {
			$id_hook = self::_getHookIdByName($hook_name);
			if (!$id_hook)
				continue;
			$hooks[$id_hook] = $hook_name;
		}
		$hooks[-1] = $this->l('Custom (advanced user only)');
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Transplant to hook'),
			'key' 		=> 'id_hook',
			'options' 	=> $hooks,
			'defaultvalue'=>$this->l('Do not show'),
			'onchange' => 'updateHookOptions($jqPm(this));'
		);
		$this->_displaySelect($configOptions);
		$this->_html .= '<div class="hookOptions hookOption-displayTop hookOption-top hookOption-displayHome hookOption-home" style="display:none;"><br />' . $this->l('The transplantation on hook top and home are experimental. No support will be made ​​on these option.') . '</div>';
		$this->_html .= '<div class="hookOptions hookOption-1" style="display:none;">';
			$this->_displayInputText(array('obj' => $params['obj'],'key' => 'smarty_var_name', 'label' => $this->l('Smarty var name'),'defaultvalue'=>'as4_'.uniqid() ));
			$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'insert_in_center_column', 'key_db' => 'insert_in_center_column', 'label' => $this->l('Do you want to insert your search engine in your center column?')));
			$this->_showInfo($this->l('Please insert the following code in your template at the line where you want the search engine to appear:').'<br /><div id="custom_content_results" onclick="selectText(\'custom_content_results\')"><p id="smarty_var_name_picker"></p><div '.($params['obj'] && $params['obj']->insert_in_center_column ? '':'style="display:none;"').' id="custom_content_area_results">&lt;div id="as_custom_content_results"&gt;&lt;/div&gt;</div></div>');
			$this->_html .= '<script type="text/javascript">';
			$this->_html .= '$jqPm("input[name=insert_in_center_column]").unbind("click").bind("click",function() {
				if (parseInt($jqPm(this).val())) {
					$jqPm("#custom_content_area_results").show();
					$jqPm("#blc_search_results_selector").hide();
					$jqPm("#search_results_selector").val("#as_custom_content_results");
				}else {
					$jqPm("#custom_content_area_results").hide();
					$jqPm("#blc_search_results_selector").show();
					$jqPm("#search_results_selector").val("#center_column");
				}
			});';
			$this->_html .= '$jqPm("#smarty_var_name").unbind("keyup").bind("keyup",function() {
				updateSmartyVarNamPicker();
			});
			updateSmartyVarNamPicker();';
			$this->_html .= '</script>';
		$this->_html .= '</div>';
		$this->_html .= '<div id="blc_search_results_selector" style="'.($params['obj'] && $params['obj']->id_hook && ($params['obj']->id_hook == 8 || $params['obj']->insert_in_center_column) ? 'display:none;':'').'">';
		$this->_html .= '<hr class="pm_hr" />';
		$this->_html .= '<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>'.$this->l('Set here the ID of your center column. (If you are not sure do not change this value)').'</p>';
		$this->_displayInputText(array('obj' => $params['obj'],'key' => 'search_results_selector', 'label' => $this->l('Search results area'),'defaultvalue'=>'#center_column' ));
		$this->_html .= '<hr class="pm_hr" />';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'unique_search', 'key_db' => 'unique_search', 'label' => $this->l('Unique search'),'tips'=>$this->l('Only search to be displayed. If several searches have the unique option activated, they will all be displayed on your page.')));
		$this->_html .= '</div>';
		$this->_html .= '<div class="hookOptions hookOption-displayTop hookOption-top hookOption-displayHome hookOption-home hookOption-1" style="display:none;">';
		$this->_displayInputText(array('obj' => $params['obj'],'key' => 'width', 'label' => $this->l('Width')));
		$this->_displayInputText(array('obj' => $params['obj'],'key' => 'height', 'label' => $this->l('Height')));
		$this->_html .= '</div>';
		$this->_endFieldset();
		$this->_startFieldset($this->l('Behaviour'), $this->_path . 'img/clapperboard.png', true);
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'keep_category_information', 'key_db' => 'keep_category_information', 'label' => $this->l('Keep category information while searching')));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'display_nb_result_on_blc', 'key_db' => 'display_nb_result_on_blc', 'label' => $this->l('Display number of results on search block')));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'display_nb_result_criterion', 'key_db' => 'display_nb_result_criterion', 'label' => $this->l('Display number of results per criteria')));
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Display a remind of selection'),
			'key' 		=> 'remind_selection',
			'options' 	=> $this->options_remind_selection,
			'size' 		=> '400px'
		);
		$this->_displaySelect($configOptions);
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Method to display hidden criteria'),
			'key' 		=> 'show_hide_crit_method',
			'options' 	=> $this->options_show_hide_crit_method
		);
		$this->_displaySelect($configOptions);
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'step_search', 'key_db' => 'step_search', 'label' => $this->l('Search by steps'), 'onclick'=>'toogleDisplayCriteriaOptions(); showRelatedOptions($jqPm(this))'));
		$this->_html .= '<div class="collapse">';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'collapsable_criterias', 'key_db' => 'collapsable_criterias', 'label' => $this->l('Allow criterias to be collapsed')));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'reset_group', 'key_db' => 'reset_group', 'label' => $this->l('Display an option to reset user choices'),'defaultvalue'=>true));
		$this->_html .= '</div>';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'filter_by_emplacement', 'key_db' => 'filter_by_emplacement', 'label' => $this->l('Show available criteria only for displayed products'),'defaultvalue'=>true, 'onclick'=>'toogleDisplayCategoryRootOption()'));
		$categorySelect = array(0 => $this->l('-- User-context category --'));
		foreach (Category::getCategories($this->_cookie->id_lang) as $shopCategory) {
			foreach ($shopCategory as $idCategory=>$categoryInformations) {
				if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Configuration::get('PS_ROOT_CATEGORY') == $idCategory)
					continue;
				$categorySelect[$idCategory] = str_repeat('&#150 ', (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? $categoryInformations['infos']['level_depth'] - 1 : $categoryInformations['infos']['level_depth'])) . $categoryInformations['infos']['name'];
			}
		}
		$this->_html .= '<div class="id_category_root_container">';
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Set the root category for your search (default is user-context category)'),
			'key' 		=> 'id_category_root',
			'options' 	=> $categorySelect,
			'size' 	=> '500px'
		);
		$this->_displaySelect($configOptions);
		$this->_html .= '</div>';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'recursing_indexing', 'key_db' => 'recursing_indexing', 'label' => $this->l('Recursive indexing of categories'),'defaultvalue'=>true));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'share', 'key_db' => 'share', 'label' => $this->l('Display share block under search results'),'defaultvalue'=>true));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'search_on_stock', 'key_db' => 'search_on_stock', 'label' => $this->l('Search only products in stock'),'defaultvalue'=>false));
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'display_empty_criteria', 'key_db' => 'display_empty_criteria', 'label' => $this->l('Display empty criteria'),'defaultvalue'=>false,'onclick'=>'toogleDisplayCriteriaOptions()'));
		$this->_html .= '<div id="criteriaOptions">';
			$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'hide_empty_crit_group', 'key_db' => 'hide_empty_crit_group', 'label' => $this->l('Hide empty criteria groups'),'defaultvalue'=>false));
		$this->_html .= '</div>';
		$this->_html .= '<div class="displaySaveSelection">';
			$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'save_selection', 'key_db' => 'save_selection', 'label' => $this->l('Save selection during navigation'), 'onclick'=>'toogleDisplayCriteriaOptions()'));
		$this->_html .= '</div>';
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Submit search method'),
			'key' 		=> 'search_method',
			'options' 	=> $this->options_launch_search_method,
			'onchange'	=> 'display_search_method_options();'
		);
		$this->_displaySelect($configOptions);
		$this->_html .= '<script type="text/javascript">
					     $jqPm(document).ready($jqPm(".collapse").' . ($params['obj'] && (int)$params['obj']->step_search ? 'hide' : 'show') . '("fast"));
					      </script>';
		$this->_html .= '<div class="search_method_options_1" ' . (((Tools::getIsset('search_method') && Tools::getValue('search_method') == 2) or ($params['obj'] && $params['obj']->search_method == 2)) ? '' : ' style="display:none"') . '>';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'dynamic_criterion', 'key_db' => 'dynamic_criterion', 'label' => $this->l('Dynamic criteria'),'defaultvalue'=>true));
		$this->_html .= '</div>';
		$this->_html .= '<div class="search_method_options_2" ' . (((isset($_POST ['search_method']) && Tools::getValue('search_method') == 2) or ($params['obj'] && $params['obj']->search_method == 2)) ? '' : ' style="display:none"') . '>';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'redirect_one_product', 'key_db' => 'redirect_one_product', 'label' => $this->l('Redirect to product sheet if only one product found'),'defaultvalue'=>true));
		$this->_html .= '</div>';
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'priority_on_combination_image', 'key_db' => 'priority_on_combination_image', 'label' => $this->l('Display combination image on priority'),'defaultvalue'=>true));
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'add_anchor_to_url', 'key_db' => 'add_anchor_to_url', 'label' => $this->l('Pre-select product\'s combination for product page'), 'defaultvalue'=> false));
		else
			$this->_html .= '<input name="add_anchor_to_url" value="0" type="hidden" />';
		$this->_displayInputText(array('obj' => $params['obj'],'key' => 'products_per_page', 'label' => $this->l('Number of products per page'), 'defaultvalue'=>Configuration::get('PS_PRODUCTS_PER_PAGE')));
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Default order by'),
			'key' 		=> 'products_order_by',
			'options' 	=> $this->options_defaut_order_by,
			'size' 		=> '500px'
		);
		$this->_displaySelect($configOptions);
		$configOptions = array(
			'obj'		=> $params['obj'],
			'label'		=> $this->l('Default order way'),
			'key' 		=> 'products_order_way',
			'options' 	=> $this->options_defaut_order_way
		);
		$this->_displaySelect($configOptions);
		$this->_displayInputActive(array('obj' => $params['obj'], 'key_active' => 'scrolltop_active', 'key_db' => 'scrolltop_active', 'label' => $this->l('Activate auto scrolling effect'),'defaultvalue'=>true));
		$this->_endFieldset();
		$this->_startFieldset($this->l('Appearance'), $this->_path . 'img/color-swatch.png', true);
		$this->_html .= '<div class="hookOptions hookOption-displayTop hookOption-top hookOption-displayHome hookOption-home hookOption-1" style="display:none;">';
		$this->_displayInputGradient(array('obj' => $params['obj'], 'key' => 'background_color', 'label' => $this->l('Background'),'defaultvalue'=>'#ffffff-#ebebeb'));
		$this->_displayInputSlider(array('obj' => $params['obj'], 'key' => 'border_radius', 'label' => $this->l('Border radius'), 'minvalue' => '0', 'maxvalue' => '100', 'defaultvalue' => '30', 'suffix' => 'px'));
		$this->_displayInput4size(array('obj' => $params['obj'], 'key' => 'border_size', 'label' => $this->l('Border size'), 'defaultvalue' => '1px 1px 1px 1px'));
		$this->_displayInputColor(array('obj' => $params['obj'], 'key' => 'border_color', 'label' => $this->l('Border color'),'defaultvalue'=>'#b6b7ba'));
		$this->_displayInputSlider(array('obj' => $params['obj'], 'key' => 'font_size_title', 'label' => $this->l('Font size title search'), 'minvalue' => '8', 'maxvalue' => '30', 'defaultvalue' => '12', 'suffix' => 'px'));
		$this->_html .= '</div>';
		$this->_displayInputColor(array('obj' => $params['obj'], 'key' => 'color_group_title', 'label' => $this->l('Criteria group color title'),'defaultvalue'=>'#333333'));
		$this->_displayInputSlider(array('obj' => $params['obj'], 'key' => 'font_size_group_title', 'label' => $this->l('Criteria group title font size'), 'minvalue' => '8', 'maxvalue' => '30', 'defaultvalue' => '12', 'suffix' => 'px'));
		$this->_endFieldset();
		$this-> _startFieldset($this->l('Associations'));
		$this -> _displayInputActive(array(
			'obj' => $params['obj'],
			'key_active' => 'bool_cat',
			'key_db' => 'bool_cat',
			'label' => $this->l('Apply this rule to some categories'),
			'defaultvalue' => ($categoriesAssociation && self::_isFilledArray($categoriesAssociation) ? 1 : 0),
			'onclick' => 'display_cat_picker();'
		));
		$this -> _html .= '<div id="category_picker">';
		$this->_displayCategoryTree(array(
			'label' => $this->l('Categories'),
			'input_name' => 'categories_association',
			'selected_cat' => ($categoriesAssociation && self::_isFilledArray($categoriesAssociation) ? $categoriesAssociation : array(0)),
			'category_root_id' => (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Category::getRootCategory()->id : 1)
		));
		$this -> _html .= '</div>';
		$this -> _displayInputActive(array(
			'obj' => $params['obj'],
			'key_active' => 'bool_prod',
			'key_db' => 'bool_prod',
			'label' => $this->l('Apply this rule to some products'),
			'defaultvalue' => ($productsAssociation && self::_isFilledArray($productsAssociation) ? 1 : 0),
			'onclick' => 'display_prod_picker();'
		));
		$this -> _html .= '<div id="product_picker">';
		$this -> _displayAjaxSelectMultiple(array(
			'selectedoptions' => ($productsAssociation && self::_isFilledArray($productsAssociation) ?$productsAssociation:false), 
			'key' => 'products_association',
			'label' => $this->l('Products'),
			'remoteurl' => $this -> _base_config_url . '&getItem=1&itemType=product',
			'limit' => 50,
			'limitincrement' => 20,
			'remoteparams' => false,
			'idcolumn' => 'id_product',
			'namecolumn' => 'name',
			'triggeronliclick' => true,
			'displaymore' => true,
		));
		$this -> _html .= '</div>';
		$this -> _displayInputActive(array(
			'obj' => $params['obj'],
			'key_active' => 'bool_manu',
			'key_db' => 'bool_manu',
			'label' => $this->l('Apply this rule to some manufacturers'),
			'defaultvalue' => ($manufacturersAssociation && self::_isFilledArray($manufacturersAssociation) ? 1 : 0),
			'onclick' => 'display_manu_picker();'
		));
		$this -> _html .= '<div id="manu_picker">';
		$this -> _displayAjaxSelectMultiple(array(
			'selectedoptions' => ($manufacturersAssociation && self::_isFilledArray($manufacturersAssociation) ?$manufacturersAssociation:false), 
			'key' => 'manufacturers_association',
			'label' => $this->l('Manufacturers'),
			'remoteurl' => $this -> _base_config_url . '&getItem=1&itemType=manufacturer',
			'limit' => 50,
			'limitincrement' => 20,
			'remoteparams' => false,
			'idcolumn' => 'id_manufacturer',
			'namecolumn' => 'name',
			'triggeronliclick' => true,
			'displaymore' => true,
		));
		$this -> _html .= '</div>';
		$this -> _displayInputActive(array(
			'obj' => $params['obj'],
			'key_active' => 'bool_supp',
			'key_db' => 'bool_supp',
			'label' => $this->l('Apply this rule to some suppliers'),
			'defaultvalue' => ($suppliersAssociation && self::_isFilledArray($suppliersAssociation) ? true : false),
			'onclick' => 'display_supp_picker();'
		));
		$this -> _html .= '<div id="supp_picker">';
		$this -> _displayAjaxSelectMultiple(array(
			'selectedoptions' => ($suppliersAssociation && self::_isFilledArray($suppliersAssociation) ?$suppliersAssociation:false), 
			'key' => 'suppliers_association',
			'label' => $this->l('Suppliers'),
			'remoteurl' => $this -> _base_config_url . '&getItem=1&itemType=supplier',
			'limit' => 50,
			'limitincrement' => 20,
			'remoteparams' => false,
			'idcolumn' => 'id_supplier',
			'namecolumn' => 'name',
			'triggeronliclick' => true,
			'displaymore' => true,
		));
		$this -> _html .= '</div>';
		$this -> _displayInputActive(array(
			'obj' => $params['obj'],
			'key_active' => 'bool_cms',
			'key_db' => 'bool_cms',
			'label' => $this->l('Apply this rule to some CMS pages'),
			'defaultvalue' => (self::_isFilledArray($cmsAssociation) ?true:false),
			'onclick' => 'display_cms_picker();'
		));
		$this -> _html .= '<div id="cms_picker">';
		$this -> _displayAjaxSelectMultiple(array(
			'selectedoptions' => ($cmsAssociation && self::_isFilledArray($cmsAssociation) ?$cmsAssociation:false), 
			'key' => 'cms_association',
			'label' => $this->l('CMS Pages'),
			'remoteurl' => $this -> _base_config_url . '&getItem=1&itemType=cms',
			'limit' => 50,
			'limitincrement' => 20,
			'remoteparams' => false,
			'idcolumn' => 'id_cms',
			'namecolumn' => 'meta_title',
			'triggeronliclick' => true,
			'displaymore' => true,
		));
		$this -> _html .= '</div>';
		$this -> _displayInputActive(array(
			'obj' => $params['obj'],
			'key_active' => 'bool_spe',
			'key_db' => 'bool_spe',
			'label' => $this->l('Apply this rule to some special pages'),
			'defaultvalue' => ($specialPagesAssociation && self::_isFilledArray($specialPagesAssociation) ?true:false),
			'onclick' => 'display_spe_picker();'
		));
		$this->_html .='<div id="special_pages">';
		$this -> _html .= '<div id="controller_picker">';
		$this -> _displayAjaxSelectMultiple(array(
			'selectedoptions' => ($specialPagesAssociation && self::_isFilledArray($specialPagesAssociation) ?$specialPagesAssociation:false), 
			'key' => 'special_pages_association',
			'label' => $this->l('Select the controller where you want the search engine to be shown'),
			'remoteurl' => $this -> _base_config_url . '&getItem=1&itemType=controller',
			'limit' => 50,
			'limitincrement' => 20,
			'remoteparams' => false,
			'idcolumn' => 'page',
			'namecolumn' => 'title',
			'triggeronliclick' => true,
			'displaymore' => true,
		));
		$this -> _html .= '</div>';
		$this -> _html .= '</div>';
	$this->_html .='
		<script type="text/javascript">
			display_cms_picker();
			display_spe_picker();
			display_cat_picker();
			display_prod_picker();
			display_manu_picker();
			display_supp_picker();
			toogleDisplayCriteriaOptions();
			toogleDisplayCategoryRootOption();
		</script>';
		$this->_endFieldset();
		$this->_displaySubmit($this->l('   Save   '), 'submitSearch');
		$this->_html .= '<br /><br />';
		$this->_html .= '<script type="text/javascript">
		updateHookOptions($jqPm("#id_hook"));
		</script>';
		$this->_endForm(array('id' => 'searchForm'));
		return;
	}
	private function _lWithoutCache($string, $specific = false) {
		global $_MODULES, $_MODULE;
		$_MODULES = array();
		$id_lang = (! isset($this->_cookie) or ! is_object($this->_cookie)) ? intval(Configuration::get('PS_LANG_DEFAULT')) : intval($this->_cookie->id_lang);
		$iso_lang = Language::getIsoById($id_lang);
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
			$file = _PS_MODULE_DIR_ . $this->name . '/' . $iso_lang . '.php';
			if (file_exists($file) and include($file))
				$_MODULES = ! empty($_MODULES) ? array_merge($_MODULES, $_MODULE) : $_MODULE;
		} else {
			$filesByPriority = array(
				_PS_THEME_DIR_.'modules/'.$this->name.'/translations/'.$iso_lang.'.php', 
				_PS_THEME_DIR_.'modules/'.$this->name.'/'.$iso_lang.'.php', 
				_PS_MODULE_DIR_.$this->name.'/translations/'.$iso_lang.'.php',
				_PS_MODULE_DIR_.$this->name.'/'.$iso_lang.'.php'
			);
			foreach ($filesByPriority as $file)
				if (Tools::file_exists_cache($file) && include($file))
					$_MODULES = !empty($_MODULES) ? $_MODULES + $_MODULE : $_MODULE;
		}
		if (!is_array($_MODULES))
			return (str_replace('"', '&quot;', $string));
		$source = Tools::strtolower($specific ? $specific : get_class($this));
		$string2 = str_replace('\'', '\\\'', $string);
		$currentKey = '<{' . $this->name . '}' . _THEME_NAME_ . '>' . $source . '_' . md5($string2);
		$defaultKey = '<{' . $this->name . '}prestashop>' . $source . '_' . md5($string2);
		if (key_exists($currentKey, $_MODULES))
			$ret = stripslashes($_MODULES [$currentKey]);
		elseif (key_exists($defaultKey, $_MODULES))
			$ret = stripslashes($_MODULES [$defaultKey]);
		else
			$ret = $string;
		return str_replace('"', '&quot;', $ret);
	}
	public function translateMultiple($type, $category_level_depth = false) {
		$defaultIdLang = $this->_cookie->id_lang;
		$return = array();
		/*
		$this->l('Manufacturer');
		$this->l('Supplier');
		$this->l('Categories level');
		$this->l('Categories');
		$this->l('Price');
		$this->l('offers a selection of');
		$this->l('Between');
		$this->l('and');
		$this->l('From');
		$this->l('to');
		$this->l('On sale');
		$this->l('In stock');
		$this->l('Available for order');
		$this->l('Online only');
		$this->l('Weight');
		$this->l('Width');
		$this->l('Height');
		$this->l('Depth');
		$this->l('Condition');
		$this->l('New');
		$this->l('Used');
		$this->l('Refurbished');
		$this->l('Yes');
		$this->l('No');
		*/
		foreach ($this->_languages as $language) {
			$this->_cookie->id_lang = $language['id_lang'];
			switch ($type) {
				case 'manufacturer' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Manufacturer');
					break;
				case 'supplier' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Supplier');
					break;
				case 'categories' :
					if ($category_level_depth)
						$return[$language['id_lang']] = $this->_lWithoutCache('Categories level').' '.$category_level_depth;
					else
						$return[$language['id_lang']] = $this->_lWithoutCache('Categories');
					break;
				case 'price' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Price');
					break;
				case 'offers_selection' :
					$return[$language['id_lang']] = $this->_lWithoutCache('offers a selection of');
					break;
				case 'between' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Between');
					break;
				case 'and' :
					break;
				case 'from' :
					$return[$language['id_lang']] = $this->_lWithoutCache('From');
					break;
				case 'to' :
					$return[$language['id_lang']] = $this->_lWithoutCache('to');
					break;
				case 'on_sale' :
					$return[$language['id_lang']] = $this->_lWithoutCache('On sale');
					break;
				case 'stock' :
					$return[$language['id_lang']] = $this->_lWithoutCache('In stock');
					break;
				case 'available_for_order' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Available for order');
					break;
				case 'online_only' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Online only');
					break;
				case 'weight' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Weight');
					break;
				case 'width' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Width');
					break;
				case 'height' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Height');
					break;
				case 'depth' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Depth');
					break;
				case 'condition' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Condition');
					break;
				case 'new' :
					$return[$language['id_lang']] = $this->_lWithoutCache('New');
					break;
				case 'used' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Used');
					break;
				case 'refurbished' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Refurbished');
					break;
				case 'yes' :
					$return[$language['id_lang']] = $this->_lWithoutCache('Yes');
					break;
				case 'no' :
					$return[$language['id_lang']] = $this->_lWithoutCache('No');
					break;
			}
		}
		$this->_cookie->id_lang = $defaultIdLang;
		return $return;
	}
	private function _getCriteriaFromEmplacement($id_search, $id_category_root = false) {
		if ($id_category_root !== false && is_numeric($id_category_root) && (int)$id_category_root > 0)
			$criterion = AdvancedSearchClass::getCriterionsWithIdGroupFromIdLinked('category', (int)$id_category_root, (int)$id_search);
		else if ($id_category = (Tools::getIsset('id_category') ? (int)Tools::getValue('id_category') : (int)Tools::getValue('id_category_search')))
			$criterion = AdvancedSearchClass::getCriterionsWithIdGroupFromIdLinked('category', $id_category, (int)$id_search);
		elseif ($id_manufacturer = (Tools::getIsset('id_manufacturer') ? (int)Tools::getValue('id_manufacturer') : (int)Tools::getValue('id_manufacturer_search')))
			$criterion = AdvancedSearchClass::getCriterionsWithIdGroupFromIdLinked('manufacturer', $id_manufacturer, (int)$id_search);
		elseif ($id_supplier = (Tools::getIsset('id_supplier') ? (int)Tools::getValue('id_supplier') : (int)Tools::getValue('id_supplier_search')))
			$criterion = AdvancedSearchClass::getCriterionsWithIdGroupFromIdLinked('supplier', $id_supplier, (int)$id_search);
		return (isset($criterion) && $criterion ? $criterion : array());
	}
	private function _addToFBLog($nom_etape) {
		if ($this->bench) {
			if (!$this->bench_start)
				$this->bench_start = microtime(true);
			if ($this->bench_step)
				$time_elapsed_step = microtime(true) - $this->bench_step;
			$this->bench_step = microtime(true);
			$time_elapsed_start = $this->bench_step - $this->bench_start;
			if (is_array($nom_etape) || is_object($nom_etape)) {
				$this->bench_output [] = $nom_etape;
				$this->bench_output [] = '=> Temps écoulé depuis départ ' . $time_elapsed_start . ' secondes' . (isset($time_elapsed_step) ? ' - Temps écoulé depuis step ' . $time_elapsed_step : '');
			} else {
				$this->bench_output [] = $nom_etape . ' : Temps écoulé depuis départ ' . $time_elapsed_start . ' secondes' . (isset($time_elapsed_step) ? ' - Temps écoulé depuis step ' . $time_elapsed_step : '');
			}
		}
	}
	private function _assignProductSort($orderByDefault, $orderWayDefault) {
		$stock_management = (int)(Configuration::get('PS_STOCK_MANAGEMENT')) ? true : false; 
		$orderBy = Tools::strtolower(Tools::getValue('orderby', $this->orderByValues [(int)($orderByDefault)]));
		$orderWay = Tools::strtolower(Tools::getValue('orderway', $this->orderWayValues [(int)($orderWayDefault)]));
		if (!in_array($orderBy, $this->orderByValues))
			$orderBy = $this->orderByValues[0];
		if (!in_array($orderWay, $this->orderWayValues))
			$orderWay = $this->orderWayValues[0];
		$this->_smarty->assign(array(
			'orderby' => $orderBy,
			'orderway' => $orderWay,
			'orderbydefault' => $this->orderByValues[(int)($orderByDefault)],
			'orderwayposition' => $this->orderWayValues[(int)($orderWayDefault)], 
			'orderwaydefault' => $this->orderWayValues[(int)($orderWayDefault)],
			'stock_management' => (int)$stock_management
		));
	}
	private function _assignPagination($products_per_page, $nbProducts = 10) {
		$nArray = array_unique(array((int)$products_per_page, 20, 40, 80));
		asort($nArray);
		$this->n = abs((int)(Tools::getValue('n', ((isset($this->_cookie->nb_item_per_page) && $this->_cookie->nb_item_per_page >= 10) ? $this->_cookie->nb_item_per_page : (int)$products_per_page))));
		$this->p = abs((int)(Tools::getValue('p', 1)));
		$range = 2; 
		if ($this->p < 0)
			$this->p = 0;
		if (isset($this->_cookie->nb_item_per_page) && $this->n != $this->_cookie->nb_item_per_page && in_array($this->n, $nArray))
			$this->_cookie->nb_item_per_page = $this->n;
		if ($this->p > ($nbProducts / $this->n))
			$this->p = ceil($nbProducts / $this->n);
		$pages_nb = ceil($nbProducts / (int)$this->n);
		$start = (int)($this->p - $range);
		if ($start < 1)
			$start = 1;
		$stop = (int)($this->p + $range);
		if ($stop > $pages_nb)
			$stop = (int)$pages_nb;
		$this->_smarty->assign('nb_products', (int)$nbProducts);
		$pagination_infos = array(
			'pages_nb' => (int)$pages_nb,
			'p' => (int)$this->p,
			'n' => (int)$this->n,
			'nArray' => $nArray,
			'range' => (int)$range,
			'start' => (int)$start,
			'stop' => (int)$stop,
			'products_per_page' => (int)$products_per_page
		);
		$this->_smarty->assign($pagination_infos);
	}
	public function resetSearchSelection($id_search) {
		$this->_cookie->as4_reset_selection = true;
	}
	private function saveSearchSelection4ProductLinkNC($id_search, $selected_criterion, $search_on_stock, $default_order_by, $default_order_way) {
		$this->_cookie->as4_id_search_nc = $id_search;
		$this->_cookie->as4_on_stock_nc = $search_on_stock;
		if (Tools::getValue('orderway') && in_array(Tools::strtolower(Tools::getValue('orderway')), $this->orderWayValues))
			$this->_cookie->as4_orderway_nc = Tools::strtolower(Tools::getValue('orderway'));
		elseif (!isset($this->_cookie->as4_orderway_nc) || !$this->_cookie->as4_orderway_nc) $this->_cookie->as4_orderway_nc = $this->orderWayValues [$default_order_way];
		else $this->_cookie->as4_orderway_nc = false;
		if (Tools::getValue('orderby') && in_array(Tools::strtolower(Tools::getValue('orderby')), $this->orderByValues))
			$this->_cookie->as4_orderby_nc = Tools::strtolower(Tools::getValue('orderby'));
		elseif (!isset($this->_cookie->as4_orderby_nc) || !$this->_cookie->as4_orderby_nc) $this->_cookie->as4_orderby_nc = $this->orderByValues [$default_order_by];
		else $this->_cookie->as4_orderby_nc = false;
		if ($selected_criterion && is_array($selected_criterion) && sizeof($selected_criterion))
			$this->_cookie->as4_selected_criterion_nc = serialize($selected_criterion);
		else $this->_cookie->as4_selected_criterion_nc = false;
	}
	private function clearSearchSelection4ProductLinkNC() {
		unset($this->_cookie->as4_id_search_nc, $this->_cookie->as4_on_stock_nc, $this->_cookie->as4_selected_criterion_nc, $this->_cookie->as_price_range_nc);
	}
	private function saveSearchSelection(&$row, &$selectedCriterions) {
		$globalKey = implode('-', array((int)$row['id_search']));
		$contextKey = implode('-', array(
			(int)$row['id_search'],
			(int)$row['step_search'],
			(int)$row['search_method'],
			(Tools::getIsset('id_category') ? (int)Tools::getValue('id_category') : (int)Tools::getValue('id_category_search')),
			(Tools::getIsset('id_manufacturer') ? (int)Tools::getValue('id_manufacturer') : (int)Tools::getValue('id_manufacturer_search')),
			(Tools::getIsset('id_supplier') ? (int)Tools::getValue('id_supplier') : (int)Tools::getValue('id_supplier_search')),
		));
		$cookieGlobalIndexKey = 'as4SC_' .$globalKey;
		$cookieContextIndexKey = 'as4SC_' .$contextKey;
		$selectedCriterionsGlobal = $selectedCriterionsCurrent = $selectedCriterions;
		$preSelectedCriterions = $this->_getCriteriaFromEmplacement($row['id_search'], $row['id_category_root']);
		if (self::_isFilledArray($selectedCriterionsGlobal)) {
			foreach ($selectedCriterionsGlobal as $idCriterionGroup=>$criterions) {
				if (isset($preSelectedCriterions[$idCriterionGroup]) || (self::_isFilledArray($criterions) && isset($criterions[0]) && $criterions[0] == ''))
					unset($selectedCriterionsGlobal[$idCriterionGroup]);
			}
		} else {
			$selectedCriterionsGlobal = $preSelectedCriterions;
		}
		if (self::_isFilledArray($selectedCriterionsCurrent)) {
			foreach ($selectedCriterionsCurrent as $idCriterionGroup=>$criterions) {
				if (isset($preSelectedCriterions[$idCriterionGroup]) || (self::_isFilledArray($criterions) && isset($criterions[0]) && $criterions[0] == ''))
					unset($selectedCriterionsCurrent[$idCriterionGroup]);
			}
		} else {
			$selectedCriterionsCurrent = $preSelectedCriterions;
		}
		$cookieSelectedCriterionsCurrent = $cookieSelectedCriterionsGlobal = array();
		if (isset($this->_cookie->{$cookieContextIndexKey})) $cookieSelectedCriterionsCurrent = unserialize($this->_cookie->{$cookieContextIndexKey});
		if (isset($this->_cookie->{$cookieGlobalIndexKey})) $cookieSelectedCriterionsGlobal = unserialize($this->_cookie->{$cookieGlobalIndexKey});
		if (Tools::getValue('reset_group') && Tools::getValue('ajaxMode') && isset($cookieSelectedCriterionsGlobal[(int)Tools::getValue('reset_group')]))
			unset($cookieSelectedCriterionsGlobal[(int)Tools::getValue('reset_group')]);
		if (Tools::getValue('reset_group') && Tools::getValue('ajaxMode') && isset($cookieSelectedCriterionsCurrent[(int)Tools::getValue('reset_group')]))
			unset($cookieSelectedCriterionsCurrent[(int)Tools::getValue('reset_group')]);
		if ($selectedCriterionsGlobal == false && self::_isFilledArray($cookieSelectedCriterionsGlobal)) {
			$selectedCriterionsGlobal = $cookieSelectedCriterionsGlobal;
		}
		if ($selectedCriterionsCurrent == false && self::_isFilledArray($cookieSelectedCriterionsCurrent)) {
			$selectedCriterionsCurrent = $cookieSelectedCriterionsCurrent;
		}
		if (self::_isFilledArray($selectedCriterions)) {
			foreach ($selectedCriterions as $idCriterionGroup=>$criterions) {
				if (!isset($preSelectedCriterions[$idCriterionGroup])) {
					$selectedCriterionsGlobal[$idCriterionGroup] = $criterions;
				}
				$selectedCriterionsCurrent[$idCriterionGroup] = $criterions;
			}
		} else if (self::_isFilledArray($preSelectedCriterions) && !self::_isFilledArray($selectedCriterionsCurrent)) {
			$selectedCriterionsCurrent = $preSelectedCriterions;
		}
		if (self::_isFilledArray($selectedCriterionsCurrent) && self::_isFilledArray($cookieSelectedCriterionsCurrent)) {
			foreach ($cookieSelectedCriterionsCurrent as $idCriterionGroup=>$criterions) {
				if (!Tools::getValue('reset_group') && Tools::getValue('ajaxMode') && is_array($selectedCriterions) && isset($selectedCriterions[$idCriterionGroup])) {
					$selectedCriterionsCurrent[$idCriterionGroup] = $selectedCriterions[$idCriterionGroup];
				} else if (Tools::getValue('reset_group') && Tools::getValue('ajaxMode') && isset($selectedCriterionsCurrent[(int)Tools::getValue('reset_group')])) {
					unset($selectedCriterionsCurrent[(int)Tools::getValue('reset_group')]);
				} else {
					$selectedCriterionsCurrent[$idCriterionGroup] = $criterions;
				}
			}
		}
		if (self::_isFilledArray($selectedCriterionsGlobal) && self::_isFilledArray($cookieSelectedCriterionsGlobal)) {
			foreach ($cookieSelectedCriterionsGlobal as $idCriterionGroup=>$criterions) {
				if (!Tools::getValue('reset_group') && Tools::getValue('ajaxMode') && is_array($selectedCriterions) && isset($selectedCriterions[$idCriterionGroup])) {
					$selectedCriterionsGlobal[$idCriterionGroup] = $selectedCriterions[$idCriterionGroup];
				} else if (Tools::getValue('reset_group') && Tools::getValue('ajaxMode') && isset($selectedCriterionsGlobal[(int)Tools::getValue('reset_group')])) {
					unset($selectedCriterionsGlobal[(int)Tools::getValue('reset_group')]);
				} else if (AdvancedSearchCriterionGroupClass::getCriterionGroupType($row['id_search'], $idCriterionGroup) == 'category') {
					unset($selectedCriterionsGlobal[$idCriterionGroup]);
				} else {
					$selectedCriterionsGlobal[$idCriterionGroup] = $criterions;
				}
			}
		}
		if (self::_isFilledArray($preSelectedCriterions)) {
			foreach ($preSelectedCriterions as $idCriterionGroup=>$criterions) {
				if ($row['search_method'] != 2 && self::_isFilledArray($selectedCriterionsGlobal) && isset($selectedCriterionsGlobal[$idCriterionGroup])) unset($selectedCriterionsGlobal[$idCriterionGroup]);
				if (self::_isFilledArray($selectedCriterionsCurrent)) $selectedCriterionsCurrent[$idCriterionGroup] = $criterions;
			}
		}
		if ((self::_isFilledArray($selectedCriterionsCurrent) || self::_isFilledArray($selectedCriterionsGlobal)) && $row['search_method'] == 1 && $row['step_search'] == 1) {
			$row['save_selection_active'] = 1;
		}
		if (isset($this->_cookie->as4_reset_selection)) {
			$selectedCriterions = array();
			unset($this->_cookie->{$cookieGlobalIndexKey});
			unset($this->_cookie->{$cookieContextIndexKey});
			unset($this->_cookie->as4_reset_selection);
			return;
		} elseif ($row['save_selection']) {
			$cookieSelectedCriterionsCurrent = array();
			if (self::_isFilledArray($selectedCriterionsCurrent)) {
				foreach ($selectedCriterionsCurrent as $idCriterionGroup=>$criterions) {
					if (isset($preSelectedCriterions[$idCriterionGroup]) || (self::_isFilledArray($criterions) && isset($criterions[0]) && $criterions[0] != ''))
						$cookieSelectedCriterionsCurrent[$idCriterionGroup] = $criterions;
				}
			}
			$cookieSelectedCriterionsGlobal = array();
			if (self::_isFilledArray($selectedCriterionsGlobal)) {
				foreach ($selectedCriterionsGlobal as $idCriterionGroup=>$criterions) {
					if (!isset($preSelectedCriterions[$idCriterionGroup]) && (self::_isFilledArray($criterions) && isset($criterions[0]) && $criterions[0] != ''))
						$cookieSelectedCriterionsGlobal[$idCriterionGroup] = $criterions;
				}
			}
			if (self::_isFilledArray($selectedCriterionsCurrent)) {
				if (Tools::getValue('ajaxMode'))
					foreach (array_keys($selectedCriterionsCurrent) as $idCriterionGroup) {
						if (!isset($selectedCriterions[$idCriterionGroup])) {
							unset($selectedCriterionsCurrent[$idCriterionGroup]);
							unset($cookieSelectedCriterionsCurrent[$idCriterionGroup]);
						}
					}
				$this->_cookie->{$cookieContextIndexKey} = serialize($cookieSelectedCriterionsCurrent);
			}
			if (self::_isFilledArray($selectedCriterionsGlobal)) {
				if (Tools::getValue('ajaxMode'))
					foreach (array_keys($cookieSelectedCriterionsGlobal) as $idCriterionGroup) {
						if (!isset($selectedCriterions[$idCriterionGroup])) {
							unset($selectedCriterionsGlobal[$idCriterionGroup]);
							unset($cookieSelectedCriterionsGlobal[$idCriterionGroup]);
						}
					}
				$this->_cookie->{$cookieGlobalIndexKey} = serialize($cookieSelectedCriterionsGlobal);
			}
			if ($row['step_search'] == 1) {
				if (self::_isFilledArray($selectedCriterionsGlobal))
					foreach ($selectedCriterionsGlobal as $idCriterionGroup => $criterions)
						$selectedCriterions[$idCriterionGroup] = $criterions;
				if (self::_isFilledArray($selectedCriterionsCurrent))
					foreach ($selectedCriterionsCurrent as $idCriterionGroup => $criterions)
						if (!isset($selectedCriterions[$idCriterionGroup]) && Tools::getValue('ajaxMode')) $selectedCriterions[$idCriterionGroup] = $criterions;
						else if (!Tools::getValue('ajaxMode')) $selectedCriterions[$idCriterionGroup] = $criterions;
			} else {
				if ($row['search_method'] == 2) {
					if (self::_isFilledArray($selectedCriterionsGlobal))
						foreach ($selectedCriterionsGlobal as $idCriterionGroup => $criterions)
							$selectedCriterions[$idCriterionGroup] = $criterions;
					if (self::_isFilledArray($selectedCriterionsCurrent))
						foreach ($selectedCriterionsCurrent as $idCriterionGroup => $criterions)
							if (!isset($selectedCriterions[$idCriterionGroup]) && Tools::getValue('ajaxMode')) $selectedCriterions[$idCriterionGroup] = $criterions;
							else if (!Tools::getValue('ajaxMode')) $selectedCriterions[$idCriterionGroup] = $criterions;
				}
			}
		}
	}
	private function getCriterionsGroupsAndCriterionsForSearch($result, $id_lang, $selected_criterion = array(), $selected_criterion_hidden = array(), $with_products = false, $id_criterion_group = 0, $on_search = false) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $currency = Context::getContext()->currency;
		else global $currency;
		$criterion_group_state = (isset($this->_cookie->criterion_group_state) ? @unserialize($this->_cookie->criterion_group_state):array());
		$hidden_criteria_state = (isset($this->_cookie->hidden_criteria_state) ? @unserialize($this->_cookie->hidden_criteria_state):array());
		$set_base_selection = false;
		$selected_criteria_groups_type = array();
		if (!$selected_criterion || (is_array($selected_criterion) && ! sizeof($selected_criterion)))
			$reinit_selected_criterion = true;
		if (AdvancedSearchCoreClass::_isFilledArray($result)) {
			foreach ($result as $key => $row) {
				if ($row['filter_by_emplacement'] && Tools::getValue('id_seo') !== false && is_numeric(Tools::getValue('id_seo')) && Tools::getValue('id_seo') > 0) {
					if (!isset($result[$key]['seo_criterion_groups'])) $result[$key]['seo_criterion_groups'] = array();
					if ($row['filter_by_emplacement'] && Tools::getValue('id_seo') !== false && is_numeric(Tools::getValue('id_seo')) && Tools::getValue('id_seo') > 0) {
						$seo_search = new AdvancedSearchSeoClass((int)Tools::getValue('id_seo'));
						if (Validate::isLoadedObject($seo_search) && isset($seo_search->criteria) && !empty($seo_search->criteria)) {
							$criteres_seo = @unserialize($seo_search->criteria);
							if (AdvancedSearchCoreClass::_isFilledArray($criteres_seo)) {
								foreach ($criteres_seo as $critere_seo) {
									$critere_seo = explode('_', $critere_seo);
									$id_criterion_group_seo = (int)$critere_seo[0];
									$result[$key]['seo_criterion_groups'][] = $id_criterion_group_seo;
								}
							}
						}
					}
					$result[$key]['seo_criterion_groups'] = array_unique($result[$key]['seo_criterion_groups']);
				} else {
					$result[$key]['seo_criterion_groups'] = array();
				}
				if (isset($reinit_selected_criterion))
					$selected_criterion = array();
				if (Tools::getValue('seo_url') && Tools::getValue('id_seo_id_search') == $row ['id_search']) {
					$selected_criterion = Tools::getValue('as4c', array());
				}
				if (Tools::getValue('seo_url')) {
					$result [$key] ['keep_category_information'] = 0;
					$row ['keep_category_information'] = 0;
				}
				if ($row['save_selection']) {
			        if ($on_search && ((!$selected_criterion || (is_array($selected_criterion) && !sizeof($selected_criterion)))))
			          $this->resetSearchSelection($row['id_search']);
			        $this->saveSearchSelection($row, $selected_criterion);
			      }
				if ($row ['filter_by_emplacement'] && (!$selected_criterion || (is_array($selected_criterion) && ! sizeof($selected_criterion)))) {
					$selected_criterion = $this->_getCriteriaFromEmplacement($row['id_search'], $row['id_category_root']);
					$set_base_selection = true;
				}
				if ($row['filter_by_emplacement'] && Tools::getValue('id_seo') !== false && is_numeric(Tools::getValue('id_seo')) && Tools::getValue('id_seo') > 0) {
					$this->_addToFBLog('SEO page, looking for pre-selected criterions');
					$seo_search = new AdvancedSearchSeoClass((int)Tools::getValue('id_seo'));
					if (Validate::isLoadedObject($seo_search) && isset($seo_search->criteria) && !empty($seo_search->criteria)) {
						$criteres_seo = @unserialize($seo_search->criteria);
						if (self::_isFilledArray($criteres_seo)) {
							foreach ($criteres_seo as $critere_seo) {
								$critere_seo = explode('_', $critere_seo);
								$id_criterion_group_seo = (int)$critere_seo[0];
								if (strpos($critere_seo[1], '-') === false) $id_criterion_value = (int)$critere_seo[1];
								else $id_criterion_value = $critere_seo[1];
								if (isset($selected_criterion[$id_criterion_group_seo])) {
									if (!in_array($id_criterion_value, $selected_criterion[$id_criterion_group_seo])) {
										$selected_criterion[$id_criterion_group_seo][] = $id_criterion_value;
									}
								} else {
									$selected_criterion[$id_criterion_group_seo] = array();
									$selected_criterion[$id_criterion_group_seo][] = $id_criterion_value;
								}
							}
						}
						$row['id_seo'] = (int)Tools::getValue('id_seo');
						$row['id_seo_id_search'] = (int)$row['id_search'];
						$row['seo_url'] = (string)trim(Tools::getValue('seo_url'));
					}
				}
				if (is_array($selected_criterion) && sizeof($selected_criterion)) {
					$selected_criterion = AdvancedSearchClass::cleanArrayCriterion($selected_criterion);
					$selected_criteria_groups_type = AdvancedSearchClass::getCriterionGroupsTypeAndDisplay($row ['id_search'], array_keys($selected_criterion));
				}
				if ($set_base_selection || ($result [$key] ['base_selection'] = Tools::getValue('as4_base_selection',false))) {
					if (!isset($result [$key] ['base_selection'])) {
						if (isset($selected_criterion[key($selected_criterion)]))
							$result [$key] ['base_selection'] = $selected_criterion[key($selected_criterion)];
					}else $result [$key] ['base_selection'] = unserialize(base64_decode($result [$key] ['base_selection']));
				}
				if ($row ['step_search'] && is_array($selected_criterion) && sizeof($selected_criterion)) {
					$selected_criterion_groups = array_keys($selected_criterion);
				}
				if ($row ['dynamic_criterion'] && $row ['search_method'] && Tools::getIsset('with_product') && Tools::getIsset('old_selected_criterion'))
					$current_selected_criterion = unserialize(base64_decode(Tools::getValue('old_selected_criterion')));
				else
					$current_selected_criterion = $selected_criterion;
				$selectedCriterionsForSeo = array();
				if (self::_isFilledArray($current_selected_criterion)) {
					foreach ($current_selected_criterion as $idCriterionGroupSeo=>$idCriterionsForSeo)
						foreach (array_values($idCriterionsForSeo) as $idCriterionForSeo)
							$selectedCriterionsForSeo[] = (int)$idCriterionGroupSeo.'_'.(int)$idCriterionForSeo;
					$selectedCriterionsForSeo = array_unique($selectedCriterionsForSeo);
				}
				if ($this->productLinksNCIsInstalled && (Tools::getValue('id_search') || Tools::getValue('id_seo'))
) {
					$this->saveSearchSelection4ProductLinkNC($row['id_search'], $selected_criterion, $row['search_on_stock'], $row ['products_order_by'], $row ['products_order_way']);
				}elseif ($this->productLinksNCIsInstalled && !Tools::getValue('id_product',false)) {
					$this->clearSearchSelection4ProductLinkNC();
				}
				if (!$id_criterion_group)
					$result [$key] ['criterions_groups'] = AdvancedSearchCriterionGroupClass::getCriterionsGroupsFromIdSearch($row ['id_search'], $id_lang, false);
				else
					$result [$key] ['criterions_groups'] = AdvancedSearchCriterionGroupClass::getCriterionsGroup($row ['id_search'], $id_criterion_group, $id_lang);
				if ($row ['remind_selection'] && is_array($current_selected_criterion) && sizeof($current_selected_criterion)) {
					$result [$key] ['criterions_groups_selected'] = AdvancedSearchCriterionGroupClass::getCriterionsGroup($row ['id_search'], array_keys($current_selected_criterion), $id_lang);
					foreach($current_selected_criterion as $id_criterion_group_selected => $selected_criteria) {
						foreach($selected_criteria as $criterion_value) {
							if (!isset($result [$key] ['criterions_selected'] [$id_criterion_group_selected]))
								$result [$key] ['criterions_selected'] [$id_criterion_group_selected] = array();
							if (preg_match('#-#', $criterion_value)) {
								$range = explode('-', $criterion_value);
								$groupInfo = AdvancedSearchCriterionGroupClass::getCriterionGroupTypeAndRangeSign($row ['id_search'], $id_criterion_group_selected, $id_lang);
								if (self::_isFilledArray($groupInfo) && isset($groupInfo['criterion_group_type']) && $groupInfo['criterion_group_type'] == 'price') {
									$rangeSignLeft = $currency->getSign('left');
									$rangeSignRight = $currency->getSign('right');
								} else {
									$rangeSignLeft = '';
									if (self::_isFilledArray($groupInfo) && isset($groupInfo['criterion_group_type'])) {
										$rangeSignRight = ' '.$groupInfo['range_sign'];
									} else {
										$rangeSignRight = '';
									}
								}
								$result [$key] ['criterions_selected'] [$id_criterion_group_selected] [] = array('value' => $this->l('from').' '.$rangeSignLeft.$range[0].$rangeSignRight.' '.$this->l('to').' '.$rangeSignLeft.$range[1].$rangeSignRight, 'id_criterion' => $criterion_value);
							} else {
								$result [$key] ['criterions_selected'] [$id_criterion_group_selected] [] = AdvancedSearchCriterionClass::getCriterionValueById($row ['id_search'], $id_lang, $criterion_value);
							}
						}
					}
				}
				if (!Tools::getValue('only_products')) {
					if (isset($hidden_criteria_state[$row['id_search']])) {
						$result [$key] ['advanced_search_open'] = $hidden_criteria_state[$row['id_search']];
					}else $result [$key] ['advanced_search_open'] = 0;
					$this->_addToFBLog("Retrieve criterions groups");
					if (sizeof($result [$key] ['criterions_groups'])) {
						$prev_id_criterion_group = false;
						foreach ($result [$key] ['criterions_groups'] as $key2 => $row2) {
							if ($row2['visible'] == 0) continue;
							if ($row['collapsable_criterias'] && isset($criterion_group_state[$row['id_search'].'_'.$row2 ['id_criterion_group']]) && (int)$criterion_group_state[$row['id_search'].'_'.$row2 ['id_criterion_group']] == 0) {
								$result [$key] ['criterions_groups'][$key2]['is_collapsed'] = true;
							}
							elseif (isset($criterion_group_state[$row['id_search'].'_'.$row2 ['id_criterion_group']]) && $criterion_group_state[$row['id_search'].'_'.$row2 ['id_criterion_group']]) $result [$key] ['criterions_groups'][$key2]['is_collapsed'] = false;
							if (!$row2 ['visible'] && ! isset($selected_criterion [$row2 ['id_criterion_group']]) && (($row2 ['criterion_group_type'] == 'manufacturer' && ! Tools::getValue('id_manufacturer')) || ($row2 ['criterion_group_type'] == 'supplier' && ! Tools::getValue('id_supplier')) || ($row2 ['criterion_group_type'] == 'category' && ! Tools::getValue('id_category'))))
								continue;
							if (!$row ['step_search'] || (($row ['step_search'] && ($key2 == 0 || (isset($selected_criterion_groups) && (in_array($row2 ['id_criterion_group'], $selected_criterion_groups) || ($prev_id_criterion_group && in_array($prev_id_criterion_group, $selected_criterion_groups)) || ! sizeof($result [$key] ['criterions'] [$prev_id_criterion_group]))))))) {
								if ($row2 ['range'] == 1) {
									if ($row2 ['criterion_group_type'] == 'price') {
										$rangeSignLeft = $currency->getSign('left');
										$rangeSignRight = $currency->getSign('right');
									} else {
										$rangeSignLeft = '';
										$rangeSignRight = ' '.$row2['range_sign'];
									}
									$ranges = explode(',', $row2 ['range_interval']);
									$criteria_formated = array();
									foreach($ranges as $krange => $range) {
										$rangeUp = (isset($ranges[$krange+1]) ? $ranges[$krange+1]:'');
										$range1 = $range.'-'.$rangeUp;
										$range2 = ($rangeUp?$this->l('from'):$this->l('more than')).' '.$rangeSignLeft.$range.$rangeSignRight.($rangeUp?' '.$this->l('to').' '.$rangeSignLeft.$rangeUp.$rangeSignRight:'');
										if (is_array($selected_criterion))
											$citeria4count = $selected_criterion;
										else
											$citeria4count = array();
										$citeria4count[$row2 ['id_criterion_group']] = array($range1);
										$selected_criteria_groups_type2 = AdvancedSearchClass::getCriterionGroupsTypeAndDisplay($row['id_search'],array_keys($citeria4count));
										$nb_products = AdvancedSearchClass::getProductsSearched($row, $id_lang,false, $citeria4count, $selected_criteria_groups_type2, NULL, NULL, NULL, NULL, true,false,false,false,false,true,false, $row['search_on_stock']);
										if (!$row['display_empty_criteria'] && !$nb_products) continue;
										$criteria_formated [$range1] = array('id_criterion' => $range1, 'value' => $range2,'nb_product'=> $nb_products);
									}
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']] = $criteria_formated;
								}
								elseif ($row2 ['criterion_group_type'] == 'price') {
									$range_selected_criterion = $selected_criterion;
									unset($range_selected_criterion[$row2 ['id_criterion_group']]);
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']] = AdvancedSearchClass::getPriceRangeForSearchBloc($row, $row2 ['id_criterion_group'], $this->_cookie->id_currency, (isset($this->_cookie->id_country) ? $this->_cookie->id_country : 0), $this->getCurrentCustomerGroupId(), false, ($row ['step_search'] && !$id_criterion_group && $key2 == 0 ? array() : $range_selected_criterion), ($row ['step_search'] && !$id_criterion_group && $key2 == 0 ? array() : $selected_criteria_groups_type));
									$this->_addToFBLog("Retrieve price range group " . $row2 ['id_criterion_group']);
									$min_price_id_currency = (int)$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['min_price_id_currency'];
									$max_price_id_currency = (int)$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['max_price_id_currency'];
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['min'] = $result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['min_price'];
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['max'] = $result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['max_price'];
									if (($min_price_id_currency == 0 && $min_price_id_currency != $this->_cookie->id_currency) || ($min_price_id_currency != 0 && $min_price_id_currency != $this->_cookie->id_currency))
										$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['min'] = floor(Tools::convertPrice($result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['min_price'], NULL, $this->_cookie->id_currency));
									if (($max_price_id_currency == 0 && $max_price_id_currency != $this->_cookie->id_currency) || ($max_price_id_currency != 0 && $max_price_id_currency != $this->_cookie->id_currency))
										$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['max'] = ceil(Tools::convertPrice($result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['max_price'], NULL, $this->_cookie->id_currency));
									if ($row['step_search'] && $result[$key]['criterions'][$row2 ['id_criterion_group']][0]['min'] == 0 && $result[$key]['criterions'][$row2 ['id_criterion_group']][0]['max'] == 0) {
										unset($result [$key] ['criterions_groups'][$key2]);
										continue;
									}
									$result [$key] ['criterions_groups'][$key2]['left_range_sign'] = $currency->getSign('left');
									$result [$key] ['criterions_groups'][$key2]['right_range_sign'] = $currency->getSign('right');
									if (AdvancedSearchCoreClass::_isFilledArray($selected_criterion) && isset($selected_criterion[$row2 ['id_criterion_group']]) && sizeof($selected_criterion[$row2 ['id_criterion_group']])) {
										$range = explode('-', $selected_criterion[$row2 ['id_criterion_group']][0]);
										$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['cur_min'] = $range [0];
										if (isset($range [1])) $result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['cur_max'] = $range [1];
									}
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']][0]['step'] = ((float)$row2['range_nb'] <= 0 ? 1 : $row2['range_nb']);
								}
								elseif ($row2 ['display_type'] == 5) {
									$range_selected_criterion = $selected_criterion;
									unset($range_selected_criterion[$row2 ['id_criterion_group']]);
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']] = AdvancedSearchClass::getCriterionsRange($row, $row2 ['id_criterion_group'], $id_lang,false, $range_selected_criterion, $selected_criteria_groups_type, $this->_cookie->id_currency, (isset($this->_cookie->id_country) ? $this->_cookie->id_country : 0), $this->getCurrentCustomerGroupId(), $row2);
									if ($row['step_search'] && $result[$key]['criterions'][$row2 ['id_criterion_group']][0]['min'] == 0 && $result[$key]['criterions'][$row2 ['id_criterion_group']][0]['max'] == 0) {
										unset($result [$key] ['criterions_groups'][$key2]);
										continue;
									}
									if (AdvancedSearchCoreClass::_isFilledArray($selected_criterion) && isset($selected_criterion[$row2 ['id_criterion_group']]) && sizeof($selected_criterion[$row2 ['id_criterion_group']])) {
										$range = explode('-', $selected_criterion[$row2 ['id_criterion_group']][0]);
										$result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['cur_min'] = $range [0];
										if (isset($range [1])) $result [$key] ['criterions'] [$row2 ['id_criterion_group']] [0] ['cur_max'] = $range [1];
									}
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']][0]['step'] = ((float)$row2['range_nb'] <= 0 ? 1 : $row2['range_nb']);
									$result [$key] ['criterions_groups'][$key2]['left_range_sign'] = '';
									$result [$key] ['criterions_groups'][$key2]['right_range_sign'] = (isset($row2['range_sign']) && strlen($row2['range_sign']) > 0 ? ' '.$row2['range_sign'] : '');
								}
								else {
									$criteria = AdvancedSearchClass::getCriterionsForSearchBloc($row, $row2 ['id_criterion_group'], $id_lang, $row ['display_nb_result_criterion'],
$selected_criterion, $selected_criteria_groups_type, $this->_cookie->id_currency, (isset($this->_cookie->id_country) ? $this->_cookie->id_country : 0), $this->getCurrentCustomerGroupId(), true, $row2,(isset($result [$key] ['base_selection']) && $result [$key] ['base_selection'] && self::_isFilledArray($result [$key] ['base_selection']) ? $result [$key] ['base_selection'] : false), $result[$key]['criterions_groups']);
									$criteria_formated = array();
									if ($criteria && sizeof($criteria)) {
										$criteria_formated = array();
										foreach ($criteria as $rowCriteria) {
											$criteria_formated [$rowCriteria ['id_criterion']] = $rowCriteria;
											$idSeoCriterionLink = AdvancedSearchSeoClass::seoExists($this->getSeoKeyFromCriteria($row['id_search'], array_merge($selectedCriterionsForSeo, array((int)$rowCriteria ['id_criterion_group'].'_'.(int)$rowCriteria['id_criterion'])), $this->_cookie->id_currency));
											if ($idSeoCriterionLink) {
												$criteria_formated [$rowCriteria ['id_criterion']]['id_seo'] = $idSeoCriterionLink;
												$criteria_formated [$rowCriteria ['id_criterion']]['seo_page_url'] = AdvancedSearchSeoClass::getSeoPageUrl($idSeoCriterionLink, $this->_cookie->id_lang);
											} else {
												$criteria_formated [$rowCriteria ['id_criterion']]['id_seo'] = false;
												$criteria_formated [$rowCriteria ['id_criterion']]['seo_page_url'] = false;
											}
										}
									}
									$result [$key] ['criterions'] [$row2 ['id_criterion_group']] = $criteria_formated;
									$this->_addToFBLog("Retrieve criterions for group " . $row2 ['id_criterion_group']);
								}
								$prev_id_criterion_group = $row2 ['id_criterion_group'];
							}
						}
					}
				}
				if ($with_products) {
					$orderBy = Tools::strtolower(Tools::getValue('orderby',  $this->orderByValues[$row['products_order_by']]));
					$orderWay = Tools::strtolower(Tools::getValue('orderway', $this->orderWayValues[$row['products_order_way']]));
					if (!in_array($orderBy, $this->orderByValues))
						$orderBy = $this->orderByValues[$row['products_order_by']];
					if (!in_array($orderWay, $this->orderWayValues))
						$orderWay = $this->orderWayValues[$row['products_order_way']];
					$result [$key] ['products'] = AdvancedSearchClass::getProductsSearched($row, $id_lang, false, $selected_criterion, $selected_criteria_groups_type, (int)Tools::getValue('p', 1), (int)Tools::getValue('n', $row ['products_per_page']), $orderBy, $orderWay, 
 false, $this->_cookie->id_currency, (isset($this->_cookie->id_country) ? $this->_cookie->id_country : 0), $this->getCurrentCustomerGroupId(), true);
					$this->_addToFBLog("Retrieve results");
				}
				if ($with_products || $row ['display_nb_result_on_blc']) {
					$result [$key] ['total_products'] = AdvancedSearchClass::getProductsSearched($row, $id_lang, false, $selected_criterion, $selected_criteria_groups_type, 1, 10, NULL, NULL, true, $this->_cookie->id_currency, (isset($this->_cookie->id_country) ? $this->_cookie->id_country : 0), $this->getCurrentCustomerGroupId(), true);
					$this->_addToFBLog("Retrieve results count");
				}
				$result [$key] ['selected_criterion'] = $selected_criterion;
				if ($row ['dynamic_criterion'] && $row ['search_method'] && Tools::getIsset('with_product') && Tools::getIsset('old_selected_criterion')) {
					$result [$key] ['old_selected_criterion'] = unserialize(base64_decode(Tools::getValue('old_selected_criterion')));
				}
				$result [$key] ['save_selection_active'] = isset($row ['save_selection_active']);
			}
		}
		return $result;
	}
	public function getShareBlock($ASSearchTitle, $searchUrl) {
		$this->_smarty->assign(array('ASShareUrl'=> $this->getTinyurl($searchUrl), 'ASSearchTitle' => $ASSearchTitle));
		return $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_share_block.tpl');
	}
	private function _assignForProductsResults() {
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) {
			$css_files = array();
			$js_files = array();
			if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
				include_once (_PS_ROOT_DIR_ . '/controllers/CategoryController.php');
				$CategoryController = new CategoryControllerCore();
				$CategoryController->setMedia();
			}
			if ((version_compare(_PS_VERSION_, '1.5.0.0', '>=') && !sizeof($this->_context->controller->css_files)) || (version_compare(_PS_VERSION_, '1.5.0.0', '<') && !sizeof($css_files)))
				$css_files = array (_PS_CSS_DIR_ . 'jquery.cluetip.css' => 'all', _THEME_CSS_DIR_ . 'scenes.css' => 'all', _THEME_CSS_DIR_ . 'category.css' => 'all', _THEME_CSS_DIR_ . 'product_list.css' => 'all' );
			if (!sizeof($js_files)) {
				if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0)
					$js_files = array (_THEME_JS_DIR_ . 'products-comparison.js' );
			}
			$this->_smarty->assign(array ('comparator_max_item' => (int)(Configuration::get('PS_COMPARATOR_MAX_ITEM')), 'css_files_result_search' => $css_files, 'js_files_result_search' => $js_files));
		}
		if (Tools::getIsset('id_seo') && (int)Tools::getValue('id_seo') > 0) {
			$resultSeoUrl = AdvancedSearchSeoClass::getSeoSearchByIdSeo((int)Tools::getValue('id_seo'), (int)$this->_cookie->id_lang);
			if (self::_isFilledArray($resultSeoUrl)) {
				$this->_smarty->assign(array(
					'as_seo_title'			=>	$resultSeoUrl[0]['title'],
					'as_seo_description'	=>	$resultSeoUrl[0]['description']
				));
			}
		}
		$this->_smarty->assign(array ('categorySize' => $this->_getImageSize('category'), 'mediumSize' => $this->_getImageSize('medium'), 'thumbSceneSize' => $this->_getImageSize('thumb_scene'), 'homeSize' => $this->_getImageSize('home'), 'static_token' => Tools::getToken(false) ));
	}
	private function _getImageSize($imageType) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			$img_size = Image::getSize($imageType);
			if (!self::_isFilledArray($img_size)) $img_size = Image::getSize(self::_getImageTypeFormatedName($imageType));
			else return $img_size;
			if (!self::_isFilledArray($img_size)) $img_size = Image::getSize($imageType.'_default');
			return $img_size;
		} else {
			return Image::getSize($imageType);
		}
	}
	private function getLocationName($id_lang) {
		$location_name = false;
		$id_category = (int)Tools::getValue('id_category');
		$id_category_search = (int)Tools::getValue('id_category_search');
		if ($id_category) $location_name = AdvancedSearchClass::getCategoryName($id_lang, $id_category);
		else if ($id_category_search) $location_name = AdvancedSearchClass::getCategoryName($id_lang, $id_category_search);
		return $location_name;
	}
	public function getTinyurl($url) {
		$url = str_replace('&amp;', '&', $url);
		$urlParse = parse_url($url);
		if (is_array($urlParse) && isset($urlParse['fragment']) && !empty($urlParse['fragment']) && isset($urlParse['scheme']) && ($urlParse['scheme'] == 'http' || $urlParse['scheme'] == 'https')) {
			$tinyUrl = @file_get_contents('http://tinyurl.com/api-create.php?url=' . urlencode($url));
		}
		return (isset($tinyUrl) && !empty($tinyUrl) && preg_match('/tinyurl/i', $tinyUrl) ? $tinyUrl : '');
	}
	public function getNextIdCriterionGroup($id_search) {
		if (isset($this->_cookie->{'next_id_criterion_group_'.(int)$id_search})) {
			return $this->_cookie->{'next_id_criterion_group_'.(int)$id_search};
		}
		return '';
	}
	private function _fixPaginationLinks($pageContent) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$pageContent = str_replace(array('?controller=advancedsearch4?fc=module', '?controller=advancedsearch4?'), array('?controller=advancedsearch4&fc=module', '?controller=advancedsearch4&'), $pageContent);
		return $pageContent;
	}
	public function displayNextStepSearch($id_search, $hookName, $id_criterion_group, $with_product, $selected_criterion = array(), $selected_criterion_hidden = array()) {
		$json_return = array();
		$searchs = AdvancedSearchClass::getSearch($id_search, $this->_cookie->id_lang);
		$json_return['next_id_criterion_group'] = $this->getNextIdCriterionGroup($id_search);
		$this->_addToFBLog("Retrieve steps");
		$searchs = $this->getCriterionsGroupsAndCriterionsForSearch($searchs, $this->_cookie->id_lang, $selected_criterion, $selected_criterion_hidden, $with_product, $id_criterion_group);
		$next_id_criterion_group = AdvancedSearchCriterionGroupClass::getNextIdCriterionGroup($id_search, $id_criterion_group);
		$this->_addToFBLog("Retrieve criterons and results 1");
		$this->_smarty->assign(array ('as_searchs' => $searchs, 'as_search' => $searchs [0], 'hookName' => $hookName, 'criterions_group' => $searchs [0] ['criterions_groups'] [0], 'as_obj' => $this, 'as_path' => $this->_path, 'as_selected_criterion' => $selected_criterion, 'as_criteria_group_type_interal_name' => $this->criteria_group_type_interal_name, 'next_id_criterion_group' => $next_id_criterion_group, 'col_img_dir' => _PS_COL_IMG_DIR_ ));
		$json_return ['html_criteria_block'] = $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_criterions.tpl');
		if ($searchs [0] ['remind_selection'] == 3 || $searchs [0] ['remind_selection'] == 2) {
			$json_return ['html_selection_block'] = $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_selection_block.tpl');
		}
		if ($with_product) {
			$this->_assignForProductsResults();
			$this->_assignProductSort($searchs [0] ['products_order_by'], $searchs [0] ['products_order_way']);
			$this->_assignPagination($searchs [0] ['products_per_page'], $searchs [0] ['total_products']);
			if ($this->MagicZoomInstance) {
				$initial_script_name = $GLOBALS ['_SERVER'] ['SCRIPT_NAME'];
				$GLOBALS ['_SERVER'] ['SCRIPT_NAME'] = '/category.php';
				$json_return ['html_products'] = $this->MagicZoomInstance->hookHeader(array ('cookie', $this->_cookie ));
				$GLOBALS ['_SERVER'] ['SCRIPT_NAME'] = $initial_script_name;
				$this->_smarty->assign('products', $searchs [0] ['products']);
				ob_end_clean();
				if (!Configuration::get('PS_FORCE_SMARTY_2'))
					$this->_smarty->template_resource = 'category.tpl';
				else
					$this->_smarty->currentTemplate = 'category';
				$json_return ['html_products'] .= $this->MagicZoomInstance->parseTemplateStandard($this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_results.tpl'), $this->_smarty);
			}
			else {
				$json_return ['html_products'] = $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_results.tpl');
			}
			$json_return['html_products'] = $this->_fixPaginationLinks($json_return['html_products']);
		}
		self::_cleanBuffer();
		if (Tools::getValue('ajaxMode'))
			echo json_encode($json_return);
		else {
			foreach ($json_return as $value )
				echo $value;
		}
		return false;
	}
	public function displayAjaxSearchBlocks($id_search, $hookName, $tplName, $with_product, $selected_criterion = array(), $selected_criterion_hidden = array(), $only_product = false) {
		ob_start();
		$json_return = array();
		$searchs = AdvancedSearchClass::getSearch($id_search, $this->_cookie->id_lang);
		$this->_addToFBLog("Retrieve searchs");
		$searchs = $this->getCriterionsGroupsAndCriterionsForSearch($searchs, $this->_cookie->id_lang, $selected_criterion, $selected_criterion_hidden, $with_product, false, true);
		$this->_addToFBLog("Retrieve criterons and results 2");
		$ajaxMode = Tools::getValue('ajaxMode', false);
		if ($ajaxMode)
			$json_return['next_id_criterion_group'] = $this->getNextIdCriterionGroup($id_search);
		$location_name = $this->getLocationName($this->_cookie->id_lang);
		if (preg_match('/displayHome/i', $hookName))
			$hookName = 'home';
		if (Tools::getValue('id_seo')) {
			$needHiddenForm = false;
			if ($only_product && version_compare(_PS_VERSION_, '1.5.0.0', '>=') && ((preg_match('/leftcolumn/i', $hookName) && !$this->context->controller->display_column_left)
			|| (preg_match('/rightcolumn/i', $hookName) && !$this->context->controller->display_column_right))) {
				$needHiddenForm = true;
				$hookName = '';
			} else if (isset($searchs[0]) && isset($searchs[0]['id_hook']) && $searchs[0]['id_hook'] == -1) {
				$needHiddenForm = false;
				$hookName = '';
			}
			if ((empty($hookName) && isset($searchs[0]) && isset($searchs[0]['id_hook']) && $searchs[0]['id_hook'] != -1) || $hookName == 'home')
				$needHiddenForm = true;
			$this->_smarty->assign(array('hideAS4Form' => $needHiddenForm, 'ajaxMode' => $ajaxMode, 'as_searchs' => $searchs, 'hookName' => $hookName, 'as_obj' => $this, 'as_path' => $this->_path, 'as_selected_criterion' => $selected_criterion, 'as_criteria_group_type_interal_name' => $this->criteria_group_type_interal_name, 'col_img_dir' => _PS_COL_IMG_DIR_ , 'as_location_name' => $location_name));
			unset($_GET ['ajaxMode']);
			if (!$only_product || ($only_product && $needHiddenForm))
				$json_return ['html_block'] = $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').$tplName);
		} else {
			$this->_smarty->assign(array('hideAS4Form' => (((empty($hookName) && isset($searchs[0]) && isset($searchs[0]['id_hook']) && $searchs[0]['id_hook'] != -1) || $hookName == 'home') ? false : false), 'ajaxMode' => $ajaxMode, 'as_searchs' => $searchs, 'hookName' => $hookName, 'as_obj' => $this, 'as_path' => $this->_path, 'as_selected_criterion' => $selected_criterion, 'as_criteria_group_type_interal_name' => $this->criteria_group_type_interal_name, 'col_img_dir' => _PS_COL_IMG_DIR_ , 'as_location_name' => $location_name));
			unset($_GET ['ajaxMode']);
			if (!$only_product || ($only_product && ((empty($hookName) && isset($searchs[0]) && isset($searchs[0]['id_hook']) && $searchs[0]['id_hook'] != -1) || $hookName == 'home')))
				$json_return ['html_block'] = $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').$tplName);
		}
		if ($with_product) {
			$this->_assignForProductsResults();
			$this->_assignProductSort($searchs [0] ['products_order_by'], $searchs [0] ['products_order_way']);
			$this->_assignPagination($searchs [0] ['products_per_page'], $searchs [0] ['total_products']);
			if ($ajaxMode && !Tools::getIsset('back_from_redirect') && isset($searchs[0]['redirect_one_product']) && $searchs[0]['redirect_one_product'] && isset($searchs[0]['search_method']) && $searchs[0]['search_method'] == 2 && self::_isFilledArray($searchs[0]['products']) && sizeof($searchs[0]['products']) == 1) {
				self::_cleanBuffer();
				echo json_encode(array('html_products' => '', 'html_blocks' => '', 'redirect_to_product' => $searchs[0]['products'][0]['link']));
				die;
			}
			if ($this->MagicZoomInstance) {
				$initial_script_name = $GLOBALS ['_SERVER'] ['SCRIPT_NAME'];
				$GLOBALS ['_SERVER'] ['SCRIPT_NAME'] = '/category.php';
				$json_return ['html_products'] = $this->MagicZoomInstance->hookHeader(array ('cookie', $this->_cookie ));
				$GLOBALS ['_SERVER'] ['SCRIPT_NAME'] = $initial_script_name;
				$this->_smarty->assign('products', $searchs [0] ['products']);
				ob_end_clean();
				if (!Configuration::get('PS_FORCE_SMARTY_2'))
					$this->_smarty->template_resource = 'category.tpl';
				else
					$this->_smarty->currentTemplate = 'category';
				$json_return ['html_products'] .= $this->MagicZoomInstance->parseTemplateStandard($this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_results.tpl'), $this->_smarty);
			} else {
				$json_return ['html_products'] = $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_results.tpl');
			}
			$json_return['html_products'] = $this->_fixPaginationLinks($json_return['html_products']);
		}
		self::_cleanBuffer();
		if ($ajaxMode) {
			$return = json_encode($json_return);
			if (function_exists('json_last_error') && json_last_error() == 5 && function_exists('mb_convert_encoding')) {
				foreach ($json_return as $k=>$v)
					$json_return[$k] = mb_convert_encoding($json_return[$k], 'UTF-8', 'UTF-8');
				$return = json_encode($json_return);
			}
			echo $return;
			unset($return);
		} else {
			$return = '';
			foreach ($json_return as $value )
				$return .= $value;
			return $return;
		}
		return false;
	}
	public function displaySearchBlock($hookName, $tplName, $selected_criterion = array()) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$newHookName = self::getNewHookName($hookName);
		else
			$newHookName = $hookName;
		$searchs = AdvancedSearchClass::getSearchsFromHook($newHookName, $this->_cookie->id_lang);
		$this->_addToFBLog("Retrieve searchs for hook ".$hookName);
		if (sizeof($searchs)) {
			$location_name = $this->getLocationName($this->_cookie->id_lang);
			$searchs = $this->getCriterionsGroupsAndCriterionsForSearch($searchs, $this->_cookie->id_lang, $selected_criterion, array(), false);
			$this->_smarty->assign(array ('as4_productFilterListSource' => self::$productFilterListSource, 'as4_productFilterListData' => (isset(self::$productFilterListSource) && self::$productFilterListSource == 'search' && !empty(self::$productFilterListData) ? base64_encode(self::$productFilterListData) : ''), 'as_searchs' => $searchs, 'hookName' => $hookName, 'as_obj' => $this, 'as_path' => $this->_path, 'as_selected_criterion' => $selected_criterion, 'as_criteria_group_type_interal_name' => $this->criteria_group_type_interal_name, 'col_img_dir' => _PS_COL_IMG_DIR_, 'as_location_name' => $location_name ));
			return ($this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').$tplName));
		}
		return false;
	}
	public function assignSearchVar($selected_criterion = array()) {
		$as4_smartyVarList = AdvancedSearchClass::getSearchsIdFromHook(-1);
		$this->_addToFBLog("Retrieve id_search by smarty variable");
		if (self::_isFilledArray($as4_smartyVarList)) {
			$searchs = AdvancedSearchClass::getSearchsFromHook(-1, $this->_cookie->id_lang);
			$location_name = $this->getLocationName($this->_cookie->id_lang);
			foreach($searchs as $search) {
				$search['next_id_criterion_group'] = $this->getNextIdCriterionGroup((int)$search['id_search']);
				$this->_addToFBLog("Retrieve criterions by smarty variable");
				$search = $this->getCriterionsGroupsAndCriterionsForSearch(array(0 => $search), $this->_cookie->id_lang, $selected_criterion, array(), false);
				$this->_smarty->assign(array('as4_productFilterListSource' => self::$productFilterListSource, 'as4_productFilterListData' => (isset(self::$productFilterListSource) && self::$productFilterListSource == 'search' && !empty(self::$productFilterListData) ? base64_encode(self::$productFilterListData) : ''),'as_searchs' => $search, 'hookName' => 'home', 'as_obj' => $this, 'as_path' => $this->_path, 'as_selected_criterion' => $selected_criterion, 'as_criteria_group_type_interal_name'=> $this->criteria_group_type_interal_name, 'col_img_dir' => _PS_COL_IMG_DIR_, 'as_location_name' => $location_name));
				$this->_smarty->assign($search[0] ['smarty_var_name'], $this->_smarty->fetch($this->_getTemplatePath('views/templates/hook/pm_advancedsearch.tpl')));
			}
		}
		return;
	}
	public function setProductFilterContext() {
		if (self::$productFilterListSource == 'best-sales') {
			self::$productFilterList = $this->_getBestSellersProductsIds();
		} else if (self::$productFilterListSource == 'new-products') {
			self::$productFilterList = $this->_getNewProductsIds();
		} else if (self::$productFilterListSource == 'prices-drop') {
			self::$productFilterList = $this->_getPricesDropProductsIds();
		} else if (self::$productFilterListSource == 'search' && !empty(self::$productFilterListData)) {
			self::$productFilterList = $this->_getProductsByNativeSearch(self::$productFilterListData);
		}
	}
	public function hookHeader() {
		if ($this->_isInMaintenance() || $this->_isMobileTheme()) return;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
			if (isset($_SERVER['PHP_SELF']) && preg_match('#'.preg_quote('best-sales.php').'#', $_SERVER['PHP_SELF'])) {
				self::$productFilterListSource = 'best-sales';
			} else if (isset($_SERVER['PHP_SELF']) && preg_match('#'.preg_quote('new-products.php').'#', $_SERVER['PHP_SELF'])) {
				self::$productFilterListSource = 'new-products';
			} else if (isset($_SERVER['PHP_SELF']) && preg_match('#'.preg_quote('prices-drop.php').'#', $_SERVER['PHP_SELF'])) {
				self::$productFilterListSource = 'prices-drop';
			} else if (isset($_SERVER['PHP_SELF']) && preg_match('#'.preg_quote('search.php').'#', $_SERVER['PHP_SELF']) && Tools::getIsset('q') && Tools::getValue('q')) {
				self::$productFilterListData = urldecode(Tools::getValue('q'));
				self::$productFilterListSource = 'search';
			}
		} else if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && isset($this->_context->controller) && is_object($this->_context->controller) && isset($this->_context->controller->php_self)) {
			if (in_array($this->_context->controller->php_self, array('best-sales', 'new-products', 'prices-drop', 'search'))) {
				self::$productFilterListSource = $this->_context->controller->php_self;
				if ($this->_context->controller->php_self == 'search' && Tools::getIsset('search_query') && Tools::getValue('search_query'))
					self::$productFilterListData = Tools::replaceAccentedChars(urldecode(Tools::getValue('search_query')));
			}
		}
		$this->setProductFilterContext();
		$this->_addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/css/' . $this->name . '.css', 'all' );
		$this->_addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/' . self::DYN_CSS_FILE, 'all' );
		$this->_addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jqueryui/ui_theme_front/theme1/jquery-ui-1.8.13.custom.css', 'all');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jquery.min.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jqueryui/1.8.9/jquery-ui-1.8.9.custom.min.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jqueryui/jquery.ui.touch-punch.min.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/loadjqPm.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jquery.actual.min.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jquery.history/jquery.history.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jquery.history/jquery.observehashchange.pack.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/pm_advancedsearch.js');
		$this->_addJS(__PS_BASE_URI__ . 'modules/' . $this->name . '/js/jquery.form.js');
		if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0)
			$this->_addJS(_THEME_JS_DIR_ . 'products-comparison.js');
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $ASSearchUrl = $this->_context->link->getModuleLink('pm_advancedsearch4', 'advancedsearch4');
		else $ASSearchUrl = __PS_BASE_URI__.'modules/pm_advancedsearch4/advancedsearch4.php';
		$this->_smarty->assign('ASSearchUrlForm', $ASSearchUrl);
		if (!Tools::getValue('ajaxMode'))
			$this->assignSearchVar();
		return $this->display(__FILE__, (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? '/views/templates/hook/':'').'pm_advancedsearch_header.tpl');
	}
	public function hookHome($params) {
		if ($this->_isInMaintenance() || $this->_isMobileTheme()) return;
		return $this->displaySearchBlock('home', 'pm_advancedsearch.tpl');
	}
	public function hookTop($params) {
		if ($this->_isInMaintenance() || $this->_isMobileTheme()) return;
		return $this->displaySearchBlock('top', 'pm_advancedsearch.tpl');
	}
	public function hookLeftColumn($params) {
		if ($this->_isInMaintenance() || $this->_isMobileTheme()) return;
		return $this->displaySearchBlock('leftColumn', 'pm_advancedsearch.tpl');
	}
	public function hookRightColumn($params) {
		if ($this->_isInMaintenance() || $this->_isMobileTheme()) return;
		return $this->displaySearchBlock('rightColumn', 'pm_advancedsearch.tpl');
	}
	public function hookDisplayBackOfficeHeader($params) {
		parent::hookDisplayBackOfficeHeader($params);
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $this->hookBackOfficeHeader($params);
	}
	public function hookBackOfficeHeader($params) {
		if (
			(Tools::getValue('id_product') && Tools::getIsset('addproduct') && (Tools::getValue('tabs') == 0 || Tools::getValue('tabs') == 1 || Tools::getValue('tabs') == 2 || Tools::getValue('tabs') == 3 || Tools::getValue('tabs') == 4 
 || Tools::getValue('key_tab') == 'Features' || Tools::getValue('key_tab') == 'Combinations' || Tools::getValue('key_tab') == 'Prices' || Tools::getValue('key_tab') == 'Informations' || Tools::getValue('key_tab') == 'Shipping'))
			|| (Tools::getValue('id_product') && Tools::getIsset('action') && strtolower(Tools::getValue('action')) == 'updatecover')
		) {
			$id_product = Tools::getValue('id_product');
			$product = new Product($id_product);
			if (Validate::isLoadedObject($product))
				AdvancedSearchClass::indexCriterionsFromProduct($product);
		}
	}
	public function hookActionObjectSpecificPriceDeleteAfter($params) {
		if (isset($params['object']) && isset($params['object']->id_product)) {
			$id_product = $params['object']->id_product;
			$product = new Product($id_product);
			if (Validate::isLoadedObject($product))
				AdvancedSearchClass::indexCriterionsFromProduct($product);
		}
	}
	public function hookUpdateProduct($params) {
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && get_class($this->context->controller) == 'AdminProductsController')
			return;
		static $hookUpdateRun = false;
		if ($hookUpdateRun)
			return;
		$product = false;
		if (isset($params['product']) && Validate::isLoadedObject($params['product']))
			$product = $params['product'];
		else if (isset($params['id_product']))
			$product = new Product($params['id_product']);
		if (Validate::isLoadedObject($product)) {
			AdvancedSearchClass::indexCriterionsFromProduct($product);
			AdvancedSearchClass::optimizedSearchTables(false);
			$hookUpdateRun = true;
		}
	}
	public function hookActionAdminProductsControllerSaveAfter($params) {
		if (isset($params['return']) && Validate::isLoadedObject($params['return'])) {
			AdvancedSearchClass::indexCriterionsFromProduct($params['return']);
			AdvancedSearchClass::optimizedSearchTables(false);
		}
	}
	public function hookAddProduct($params) {
		$product = false;
		if (isset($params['product']) && Validate::isLoadedObject($params['product']))
			$product = $params['product'];
		else if (isset($params['id_product']))
			$product = new Product($params['id_product']);
		if (Validate::isLoadedObject($product)) {
			AdvancedSearchClass::indexCriterionsFromProduct($product, true);
			AdvancedSearchClass::optimizedSearchTables(false);
		}
	}
	public function hookDeleteProduct($params) {
		$product = false;
		if (isset($params['product']) && Validate::isLoadedObject($params['product']))
			$product = $params['product'];
		else if (isset($params['id_product']))
			$product = new Product($params['id_product']);
		if (Validate::isLoadedObject($product)) {
			AdvancedSearchClass::desIndexCriterionsFromProduct($product->id);
			AdvancedSearchClass::optimizedSearchTables(false);
		}
	}
	public function reindexAllSearchs($fromCron = false) {
		self::_changeTimeLimit(0);
		if ($fromCron && version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false, $this->context->shop->id);
		else
			$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);
		foreach ($advanced_searchs_id as $key => $row)
			$this->reindexSpecificSearch($row['id_search']);
		$this->_html = '$jqPm( "#progressbarReindexAllSearch" ).progressbar( "option", "value", 100 );show_info("'.addcslashes($this->l('Indexation done'),'"').'")';
	}
	public function reindexSpecificSearch($id_search) {
		$objSearch = new AdvancedSearchClass($id_search, $this->_cookie->id_lang);
		$objSearch->updateCacheProduct();
		$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexed($id_search, $this->_cookie->id_lang, false);
		if (self::_isFilledArray($criterions_groups_indexed)) {
			foreach ($criterions_groups_indexed as $key2 => $row2) {
				AdvancedSearchClass::indexCriterionsGroup($row2 ['criterion_group_type'], $row2 ['id_criterion_group_linked'], $objSearch, $row2 ['visible'], false, true);
			}
		}
		AdvancedSearchClass::optimizedSearchTables($objSearch->id, true);
		unset($objSearch, $criterions_groups_indexed, $id_search);
	}
	public function reindexCriteriaGroup() {
		self::_changeTimeLimit(0);
		$id_search = Tools::getValue('id_search');
		$objSearch = new AdvancedSearchClass($id_search, $this->_cookie->id_lang);
		$id_criterion_group = Tools::getValue('id_criterion_group');
		$objCritGroup = new AdvancedSearchCriterionGroupClass($id_criterion_group, $id_search);
		AdvancedSearchClass::indexCriterionsGroup($objCritGroup->criterion_group_type, $objCritGroup->id_criterion_group_linked, $objSearch, $objCritGroup->visible, false, true);
		AdvancedSearchClass::optimizedSearchTables($objSearch->id);
		unset($objSearch, $id_search, $objCritGroup);
	}
	public function cronTask() {
		$this->reindexAllSearchs(true);
	}
	public function displayCriterionGroupForm($params) {
		$objCrit = $params['obj'];
		$ObjASClass = new AdvancedSearchClass($objCrit->id_search);
		$this->_startForm(array('id' => 'criteriaGroupOptions_'.(int)$objCrit->id,'obj' => $params['obj'],'params'=>$params));
		$this->_displayTitle($this->l('Options'));
		$this->_displayInputTextLang(array('obj' => $objCrit, 'key' => 'name', 'label' => $this->l('Group name')));
		if (in_array($objCrit->criterion_group_type, $this->criterionGroupIsTemplatisable)) {
			if ($objCrit->criterion_group_type == 'attribute' && AdvancedSearchClass::isColorAttributesGroup($objCrit->id_criterion_group_linked))
				$this->options_criteria_group_type [7] = $this->l('Color Square');
		}
		$classType = array();
		foreach ($this->options_criteria_group_type as $key=>$val)
			$classType[$key] = 'display_type-'.$key;
		$configOptions = array(
			'obj'		=> $objCrit,
			'label'		=> $this->l('Type'),
			'key' 		=> 'display_type',
			'class'		=>	$classType,
			'options' 	=> $this->options_criteria_group_type,
			'defaultvalue'=>false,
			'onchange' => 'showRelatedOptions($jqPm(this),"'.$objCrit->criterion_group_type.'");'
		);
		$this->_displaySelect($configOptions);
		//$this->_displaySelect($objCrit, $this->options_criteria_group_type, 'display_type', $this->l('Type'),false,'300px','showRelatedOptions($jqPm(this),"'.$objCrit->criterion_group_type.'")');
		$this->_html .= '<div class="blc_range">';
		$this->_displayInputActive(array('obj' => $objCrit, 'key_active' => 'range', 'key_db' => 'range', 'label' => $this->l('Display group as range'),'onclick'=>'displayRangeOptions($jqPm(this),\''.$objCrit->criterion_group_type.'\');'));
		$this->_html .= '</div>';
		$this->_html .= '<div class="blc_range_nb" style="display:none">';
		$this->_displayInputText(array('obj' => $objCrit,'key' => 'range_nb', 'label' => $this->l('Number of range') ));
		$this->_html .= '</div>';
		$this->_html .= '<div class="blc_range_interval" style="display:none">';
		$this->_displayInputTextLang(array('obj' => $objCrit, 'key' => 'range_interval', 'label' => $this->l('Range')));
		$this->_html .= '</div>';
		$this->_html .= '<div class="blc_range_sign" style="display:none">';
		$this->_displayInputTextLang(array('obj' => $objCrit, 'key' => 'range_sign', 'label' => $this->l('Unit sign')));
		$this->_html .= '</div>';
		$this -> _displayInputFileLang(array(
			'obj' => $objCrit,
			'key' => 'icon',
			'label' => $this->l('Image'),
			'destination' => '/search_files/criterions_group/',
			'required' => false,
			'tips' => $this->l('You can upload a picture from your hard disk. This picture could be different for each language.'),
			'extend'=> true
		));
		if ($objCrit->criterion_group_type == 'category' && !$objCrit->id_criterion_group_linked)
			$this->_displayInputActive(array('obj' => $objCrit, 'key_active' => 'show_all_depth', 'key_db' => 'show_all_depth', 'label' => $this->l('Show all level categories')));
		if ($objCrit->criterion_group_type == 'category')
			$this->_displayInputActive(array('obj' => $objCrit, 'key_active' => 'only_children', 'key_db' => 'only_children', 'label' => $this->l('Search only on children categories')));
		if ($ObjASClass->collapsable_criterias) {
			$this->_html .= '<div class="is_collapse" style="'.((int)$ObjASClass->step_search ?'display:none':'').'">';
			$this->_displayInputActive(array('obj' => $objCrit, 'key_active' => 'is_collapsed', 'key_db' => 'is_collapsed', 'label' => $this->l('Collapse the group at loading')));
			$this->_html .= '</div>';
		}else $this->_html .= '<input type="hidden" name="is_collapsed" value="0" />';
		$this->_html .= '<div class="multicrit" style="display:none">';
			$this->_displayInputActive(array('obj' => $objCrit, 'key_active' => 'is_multicriteria', 'key_db' => 'is_multicriteria', 'label' => $this->l('Multicriteria')));
		$this->_html .= '</div>';
		if (in_array($ObjASClass->id_hook, $this->display_horizontal_search_block))
			$this->_displayInputText(array('obj' => $objCrit,'key' => 'width', 'label' => $this->l('Group width') ));
		if ($ObjASClass->show_hide_crit_method == 3)
			$this->_displayInputText(array('obj' => $objCrit,'key' => 'overflow_height', 'label' => $this->l('Overflow height') ));
		if (($ObjASClass->show_hide_crit_method == 1 || $ObjASClass->show_hide_crit_method == 2)) {
			$this->_html .= '<div class="max_display_container" style="display:none">';
			$this->_displayInputText(array('obj' => $objCrit,'key' => 'max_display', 'label' => $this->l('Maximum number of criteria to display') ));
			$this->_html .= '</div>';
		}
		$this->_html .= '<input name="id_search" value="' . (int)$objCrit->id_search . '" type="hidden" />';
		$this->_html .= '<input name="id_criterion_group" value="' . (int)$objCrit->id . '" type="hidden" />';
		$this->_pmClear();
		$this->_displaySubmit($this->l('Save'), 'submitCriteriaGroupOptions');
		$this->_endForm(array('id' => 'criteriaGroupOptions_'.(int)$objCrit->id,'iframetarget'=>false));
		$this->_html .= '<script type="text/javascript">
						   $jqPm(document).ready(function () {
						   		$jqPm("#range_on:checked").trigger("click");
						   		$jqPm("#range_off:checked").trigger("click");
						   		$jqPm("#display_type").trigger("change");
						   		loadAjaxLink();
							});
      					</script>';
		if (in_array($objCrit->criterion_group_type, $this->sortableCriterion)) {
			$this->_displayTitle($this->l('Sort criteria'));
			$configOptions = array(
				'obj'		=> $objCrit,
				'label'		=> false,
				'key' 		=> 'sort_by',
				'options' 	=> array(0=>$this->l('Sort by'),'numeric'=>$this->l('Numéric'),'alphabetic'=>$this->l('Alphabetic'),'position'=>$this->l('Position'),'nb_product'=>$this->l('Products count')),
				'defaultvalue'=>0,
				'onchange' => 'reorderCriteria($jqPm("#sort_by").val(),$jqPm("#sort_way").val(),$jqPm("input[name=\'id_criterion_group\']").val(),'.(int)$objCrit->id_search.');'
			);
			$this->_html .= '<div style="width:380px;float:left;"><span style="float:left;line-height:25px;"><b><em>'.$this->l('Apply specific sort :').'</em></b> &nbsp; &nbsp; </span> ';
			$this->_displaySelect($configOptions);
			$this->_html .= '</div>';
			$configOptions = array(
				'obj'		=> $objCrit,
				'label'		=> false,
				'key' 		=> 'sort_way',
				'options' 	=> array('ASC'=>$this->l('ASC'),'DESC'=>$this->l('DESC')),
				'defaultvalue'=> 0,
				'onchange' => 'reorderCriteria($jqPm("#sort_by").val(),$jqPm("#sort_way").val(),$jqPm("input[name=\'id_criterion_group\']").val(),'.(int)$objCrit->id_search.');'
			);
			$this->_html .= '<div style="width:250px;float:left;">';
			$this->_displaySelect($configOptions);
			$this->_html .= '</div>';
			$this->displaySortCriteriaPanel($objCrit);
			$this->_html .= '<div class="clear"></div><br />';
			if ($objCrit->criterion_group_type == 'attribute' && AdvancedSearchClass::isColorAttributesGroup($objCrit->id_criterion_group_linked))
				$this->displayCustomCriteriaPanel($objCrit, $params);
		}
		$this->_footerIframe();
	}
	protected function displaySortCriteriaPanel($objCrit = false){
		if (Tools::getValue('pm_load_function') != 'displaySortCriteriaPanel') {
			$this->_html .= '<div id="sortCriteriaPanel">';
		} else {
			$objCrit = new AdvancedSearchCriterionGroupClass(Tools::getValue('id_criterion_group'),Tools::getValue('id_search'));
			if (Tools::getValue('sort_way')) {
				$objCrit->sort_by = Tools::getValue('sort_by');
				$objCrit->sort_way = Tools::getValue('sort_way');
				$objCrit->save();
				$msgConfirm = $this->l('Specific sort apply');
				if ($objCrit->sort_by == 'position') $msgConfirm .= '<br />'.$this->l('Now, you can sort criteria by drag n drop');
				$this->_html .= '<script type="text/javascript">show_info("'.addcslashes($msgConfirm,'"').'");</script>';
			}
		}
		$criterions = AdvancedSearchClass::getCriterionsFromCriterionGroup($objCrit->criterion_group_type, $objCrit->id_criterion_group_linked, $objCrit->id_search, $objCrit->sort_by, $objCrit->sort_way, $this->_cookie->id_lang);
		$this->_html .= '
		<div class="clear"></div>
		<div class="criterionGroupActions">
			<ul>
				<li><a href="' . $this->_base_config_url . '&pm_load_function=processEnableAllCriterions&id_criterion_group=' . $objCrit->id . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load activeAllCriterions" title="'.$this->l('Activate all criterions').'">'.$this->l('Activate all criterions').'</a></li>
				<li><a href="' . $this->_base_config_url . '&pm_load_function=processDisableAllCriterions&id_criterion_group=' . $objCrit->id . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load disableAllCriterions" title="'.$this->l('Disable all criterions').'">'.$this->l('Disable all criterions').'</a></li>
			</ul>
		</div>
		';
		$this->_html .= '<div class="clear"></div><ul class="sortableCriterion" id="sortableCriterion_' . (int)$objCrit->id_criterion_group_linked . '">';
		foreach ($criterions as $row) {
			$objCritClass = new AdvancedSearchCriterionClass($row ['id_criterion'], $objCrit->id_search);
			$this->_html .= '<li class="ui-state-highlight'.(isset($row['is_custom']) && $row['is_custom'] ? ' customCriterionLi' : '').'" id="criterion_' . $row ['id_criterion'] . '" style="height:30px;">';
			$this->_html .= '<span class="ui-icon ui-icon-arrow-4-diag dragIcon dragIconCriterion" style="float:left;margin:0!important;'.($objCrit->sort_by  == 'position' ? '':' visibility:hidden').'">
							</span>';
			$this->_html .= '<span class="critName">'. $row ['value'] . '</span>';
			if ($objCrit->display_type == 2) {
				$this->_html .= '<div class="criterionImageContainer">';
				$this->_html .= '<form class="criterionForm" action="' . $this->_base_config_url . '" method="post" enctype="multipart/form-data" target="dialogIframePostForm">';
				$this->displayInlineUploadFile($objCritClass,'icon'.$row ['id_criterion'] ,'icon', $this->l('Image'), '/search_files/criterions/');
				$this->_html .= '<input name="id_search" value="' . (int)$objCrit->id_search . '" type="hidden" />';
				$this->_html .= '<input name="id_criterion" value="' . (int)$row ['id_criterion'] . '" type="hidden" />';
				$this->_html .= '<input name="key_criterions_group" value="' . $objCrit->criterion_group_type . '-' . (int)$objCrit->id_criterion_group_linked . '-' . (int)$objCrit->id_search . '" type="hidden" />';
				$this->_html .= '<a href="' . $this->_base_config_url . '&pm_load_function=processActiveCriterion&id_criterion=' . $row ['id_criterion'] . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load activeCriterion">
									<img src="../img/admin/' . ($row ['visible'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveCriterion' . $row ['id_criterion'] . '" class="imgActiveCrit" />
								</a>';
				$this->_html .= '</form>';
				$this->_html .= '</div>';
			} else if ($objCrit->criterion_group_type == 'attribute' && AdvancedSearchClass::isColorAttributesGroup($objCrit->id_criterion_group_linked) && isset($row['is_custom']) && $row['is_custom']) {
				$this->_html .= '<div class="criterionCustomLiveEditContainer" data-id-criterion="'.(int)$row['id_criterion'].'" data-id-search="'.(int)$objCrit->id_search.'">';
				$this->_html .= '<div class="criterionCustomLiveField">';
				$this->_displayInputTextLang(array('obj' => $objCritClass, 'key' => 'value', 'label' => $this->l('Criterion label:')));
				$this->_html .= '</div>';
				$this->_html .= '<div class="criterionCustomLiveField">';
				$this->_displayInputColor(array('obj' => $objCritClass, 'key' => 'color', 'label' => $this->l('Color:')));
				$this->_html .= '</div>';
				$this->_html .= '<div style="float: right;">';
				$this->_displaySubmit($this->l('Save'), 'submitCustomCriterionForm');
				$this->_html .= '</div>';
				$this->_html .= '</div>';
				$this->_html .= '<a href="' . $this->_base_config_url . '&pm_load_function=processActiveCriterion&id_criterion=' . $row ['id_criterion'] . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load activeCriterion"><img src="../img/admin/' . ($row ['visible'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveCriterion' . $row ['id_criterion'] . '" /></a>';
				$this->_html .= '<a href="javascript:void(0)" class="editCustomCriterion"><img src="../img/admin/edit.gif" id="imgEditCriterion' . $row ['id_criterion'] . '" class="imgEditCriterion" /></a>';
				$this->_html .= '<a href="' . $this->_base_config_url . '&pm_load_function=processDeleteCustomCriterion&id_criterion=' . $row ['id_criterion'] . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load deleteCustomCriterion"><img src="../img/admin/delete.gif" id="imgDeleteCriterion' . $row ['id_criterion'] . '" class="imgDeleteCriterion" /></a>';
			} else if ($objCrit->criterion_group_type == 'attribute' && AdvancedSearchClass::isColorAttributesGroup($objCrit->id_criterion_group_linked) && (!isset($row['is_custom']) || isset($row['is_custom']) && !$row['is_custom'])) {
				$this->_html .= '<a href="' . $this->_base_config_url . '&pm_load_function=processActiveCriterion&id_criterion=' . $row ['id_criterion'] . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load activeCriterion"><img src="../img/admin/' . ($row ['visible'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveCriterion' . $row ['id_criterion'] . '" /></a>';
				$customCriterionsList = AdvancedSearchCriterionClass::getCustomCriterions($objCrit->id_search, $objCrit->id, $this->_cookie->id_lang);
				$customCriterionsIdsList = AdvancedSearchCriterionClass::getCustomMasterIdCriterion((int)$objCrit->id_search, $row['id_criterion']);
				if (is_array($customCriterionsList) && sizeof($customCriterionsList)) {
					$customCriterionsList = array(0 => $this->l('None')) + $customCriterionsList;
					$this->_html .= '<div class="addCriterionToCustomGroupContainer">';
					$this->_displaySelect(array(
						'obj'		=> (object)array('custom_group_link_id_'.(int)$row['id_criterion'] => AdvancedSearchCriterionClass::getCustomMasterIdCriterion((int)$objCrit->id_search, $row['id_criterion'])),
						'label'		=> $this->l('Add to a group of custom criterion:'),
						'key' 		=> 'custom_group_link_id_'.(int)$row['id_criterion'],
						'options' 	=> $customCriterionsList,
						'defaultvalue'=> false,
						'onchange' => 'processAddCustomCriterionToGroup($jqPm(this), '.(int)$objCrit->id_search.', '.(int)Tools::getValue('id_criterion_group').')'
					));
					$this->_html .= '</div>';
				}
			} else {
				$this->_html .= '<a href="' . $this->_base_config_url . '&pm_load_function=processActiveCriterion&id_criterion=' . $row ['id_criterion'] . '&id_search=' . $objCrit->id_search . '" class="ajax_script_load activeCriterion"><img src="../img/admin/' . ($row ['visible'] ? 'enabled' : 'disabled') . '.gif" id="imgActiveCriterion' . $row ['id_criterion'] . '" /></a>';
			}
			$this->_html .= '</li>';
		}
		$this->_html .= '</ul>';
		if ($objCrit->sort_by  == 'position')
		$this->_html .= '<script type="text/javascript">$jqPm("#sortableCriterion_' . (int)$objCrit->id_criterion_group_linked . '").sortable({
					        handle : ".dragIconCriterion",
					                update: function(event, ui) {
					           var order = $jqPm(this).sortable("toArray");
					                saveOrder(order.join(","),"orderCriterion",' . (int)$objCrit->id_search . ');
					              }
					      });</script>';
		if (Tools::getValue('pm_load_function') != 'displaySortCriteriaPanel') {
			$this->_html .= '</div>';
		}
	}
	protected function displayCustomCriteriaPanel($objCrit = false, $params){
		$this->_displayTitle($this->l('Add a new custom criterion group'));
		$objCriterion = new AdvancedSearchCriterionClass(null, $objCrit->id_search);
		$this->_html .= '<div id="addCustomCriterionContainer" data-id-search="'.(int)$objCrit->id_search.'" data-id-criterion-group="'.(int)$objCrit->id.'">';
		$this->_displayInputTextLang(array('obj' => $objCriterion, 'key' => 'value', 'label' => $this->l('Criterion label:')));
		$this->_displayInputColor(array('obj' => $objCriterion, 'key' => 'color', 'label' => $this->l('Color:')));
		$this->_html .= '<div style="float: left; margin-top: 10px;">';
		$this->_displaySubmit($this->l('Save'), 'submitAddCustomCriterionForm');
		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}
	protected function displayInlineUploadFile($obj, $key, $key_db, $label, $destination, $uplodify = true, $filetype = '*.jpg;*.gif;*.png', $tips = false){
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			if (Configuration::getGlobalValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY') === false) Configuration::updateGlobalValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY', Tools::passwdGen(16));
		} else {
			if (Configuration::get('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY') === false) Configuration::updateValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY', Tools::passwdGen(16));
		}
		$isImage = false;
		if (preg_match('/jpg|jpeg|gif|bmp|png/i', $filetype))
			$isImage = true;
		$this->_html .= '<label>' . $label . '</label>
          <div class="margin-form" id="blc_lang' . $key.'">';
		foreach ($this->_languages as $language) {
			$this->_html .= '<div id="lang' . $key . '_' . $language ['id_lang'] . '" class="pmFlag pmFlagLang_' . $language ['id_lang'] . '" style="display: ' . ($language ['id_lang'] == $this->_default_language ? 'block' : 'none') . ';">
          		 <div style="float:left;width:150px;">
					<input type="hidden" name="' . $key . '_' . $language ['id_lang'] . '_temp_file_lang_destination_lang" id="' . $key . '_' . $language ['id_lang'] . '_destination_lang" value="' . $destination . '" />
		      		<input type="hidden" name="' . $key . '_' . $language ['id_lang'] . '_temp_file_lang" id="' . $key . '_' . $language ['id_lang'] . '" value="" />
          		</div>';
			$this->_html .= '</div>';
		}
		$this->displayPMFlags();
		if ($uplodify) {
			foreach ($this->_languages as $language) {
				$this->_html .= '<div id="wrapper_preview-' . $key . '_' . $language ['id_lang'] . '" class="wrapper_preview-' . $key . '" style="float:right; width:30px;height:30px;">';
				$this->_html .= '<div id="preview-' . $key . '_' . $language ['id_lang'] . '" class="pm_preview_upload pm_preview_upload_2 pm_preview_upload-' . $key . '" style="' . ($obj && $obj->{$key_db} [$language ['id_lang']] ? '' : 'display:none;') . '">';
				$file_location_dir = dirname(__FILE__) . $destination;
				if ($obj && $obj->{$key_db} [$language ['id_lang']] && file_exists($file_location_dir . $obj->{$key_db} [$language ['id_lang']])) {
					if ($isImage) {
						$this->_html .= '<img src="' . (substr($this->_path, 0, - 1) . $destination . $obj->{$key_db} [$language ['id_lang']]) . '" id="' . $key . '_' . $language ['id_lang'] . '_file"/>';
					} else {
						$this->_html .= '<a href="' . (substr($this->_path, 0, - 1) . $destination . $obj->{$key_db} [$language ['id_lang']]) . '" target="_blank" class="pm_view_file_upload_link" id="' . $key . '_' . $language ['id_lang'] . '_file">' . $this->l('View file') . '</a>';
					}
				}
				$this->_html .= '<span>' . $this->l('Delete this file') . '</span>
				<input type="checkbox" name="' . $key . '_' . $language ['id_lang'] . '_unlink_lang" value="1" onclick="$jqPm(\'#preview-' . $key . '_' . $language ['id_lang'] . '\').slideUp(\'fast\',function(){deleteCriterionImg(\''.(int)$obj->id.'\',\''.(int)$obj->id_search.'\',\''.$language ['id_lang'].'\');})"  />
				<input type="hidden" name="' . $key . '_' . $language ['id_lang'] . '_old_file_lang" id="' . $key . '_' . $language ['id_lang'] . '_old_file" value="' . ($obj && $obj->{$key_db} [$language ['id_lang']] ? $obj->{$key_db} [$language ['id_lang']] : '') . '" />';
				$this->_html .= '</div>';
				$this->_html .= '</div>';
				$this->_html .= '<script type="text/javascript">
				  $jqPm("#' . $key . '_' . $language ['id_lang'] . '").uploadify({
				    "uploader"  : "' . $this->_path . 'js/uploadify/uploadify.swf",
				    "script"    : "' . $this->_path . 'js/uploadify/uploadify.php?secureKey='.urlencode('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY'.'---'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? Configuration::getGlobalValue('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY') : Configuration::get('PM_'.self::$_module_prefix.'_UPLOAD_SECURE_KEY'))).'",
				    "cancelImg" : "' . $this->_path . 'js/uploadify/cancel.png",
				    "folder"    : "uploads/temp",
				    "auto"      : true,
	  				"buttonText"  : "' . $this->l('Choose file') . '",
				  	"onComplete"  : function(event, ID, fileObj, response, data) {
				  		$jqPm("#' . $key . '_' . $language ['id_lang'] . '").uploadifySettings("scriptData" , {"filename":response});
				  		$jqPm("#' . $key . '_' . $language ['id_lang'] . '").val(response);
				  		$jqPm("#' . $key . '_' . $language ['id_lang'] . '_file").remove();
				  		' . ($isImage ? '$jqPm("#preview-' . $key . '_' . $language ['id_lang'] . '").prepend("<img src=\'"+_modulePath+"uploads/temp/"+response+"\' id=\'' . $key . '_' . $language ['id_lang'] . '_file\' />");' : '$jqPm("#preview-' . $key . '_' . $language ['id_lang'] . '").prepend("<a href=\'"+_modulePath+"uploads/temp/"+response+"\' target=\'_blank\' class=\'pm_view_file_upload_link\' id=\'' . $key . '_' . $language ['id_lang'] . '_file\'>' . $this->l('View file') . '</a>");') . '
						$jqPm("input[name=' . $key . '_' . $language ['id_lang'] . '_unlink_lang]").attr("checked","").removeAttr("checked");
						$jqPm("#preview-' . $key . '_' . $language ['id_lang'] . '").slideDown("fast");
						$jqPm.ajax( {
							type : "GET",
							url : _base_config_url+"&pm_load_function=processSaveCriterionImg&file_name="+response+"&id_criterion='.(int)$obj->id.'&id_search='.(int)$obj->id_search.'&id_lang='.(int)$language ['id_lang'].'",
							dataType : "script",
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								alert(msgAjaxError);
							}
						});
				  	}
				 });
				</script>';
			}
			$this->_html .= '<script type="text/javascript">
				 $jqPm("#blc_lang' . $key.' .pmSelectFlag").bind("change",function() {
				 var current_id_language = $jqPm(this).val();
				 setTimeout(function() {
					$jqPm(".wrapper_preview-' . $key . '").hide();
					$jqPm("#wrapper_preview-' . $key . '_"+current_id_language).show();
				},100);
				 });
			</script>';
		}
		$this->_pmClear();
		$this->_html .= '</div>';
	}
	public function __destruct() {
		if ($this->bench) {
			$this->_addToFBLog('End');
			foreach ($this->bench_output as $message )
				FB_AS4::log($message);
		}
	}
	public static function array_map_recursive($fn, $arr) {
		$rarr = array();
		foreach ($arr as $k => $v) {
			if (is_array($v)) {
				$rarr[$k] = self::array_map_recursive($fn, $v);
				if (!count($rarr[$k]))
					unset($rarr[$k]);
			} else {
				$interval = explode('-', $v);
				if (is_array($interval) && count($interval) == 2) {
					$isValidInterval = true;
					foreach ($interval as $kInterval=>$intervalValue) {
						if (!is_numeric($intervalValue)) {
							$isValidInterval = false;
							break;
						}
					}
					if ($isValidInterval)
						$rarr[$k] = $v;
				} else {
					$rarr[$k] = call_user_func($fn, $v);
					if ($rarr[$k] == 0)
						unset($rarr[$k]);
				}
			}
		}
		return $rarr;
	}
}
