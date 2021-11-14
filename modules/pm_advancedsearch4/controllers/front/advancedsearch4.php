<?php
/* For PS 1.4.X */
if (!class_exists('ModuleFrontController')) {
	class ModuleFrontController extends FrontController {
		public $ajax = false;
		public function __construct(){
			parent::__construct();
		}
		public function displayHeader() {
			if ($this->display_header) {
				parent::displayHeader();
			}
		}
		public function displayFooter() {
			if ($this->display_footer) {
				parent::displayFooter();
			}
		}
	}
}
class pm_advancedsearch4advancedsearch4ModuleFrontController extends ModuleFrontController {
	private $id_seo = false;
	private $id_search = false;
	private $hookName = false;
	private $realURI;
	protected $context;
	public 		$display_column_left = true;
	public 		$display_column_right = true;
	protected 	$display_header = true;
	protected 	$display_footer = true;
	private  $criterions 				= array();
	private  $criterions_hidden 		= array();
	private  $next_id_criterion_group 	= false;
	private  $reset 					= false;
	public function __construct() {
		parent::__construct();
		if (Tools::getValue('ajaxMode')) {
			$this->ajax = true;
			$this->display_column_left = false;
			$this->display_column_right = false;
			$this->display_header = false;
			$this->display_footer = false;
		}
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$this->context = Context::getContext();
		else
			$this->context = (object) null;
	}
	public function setMedia() {
		parent::setMedia();
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && (method_exists($this->context, 'getMobileDevice') && $this->context->getMobileDevice() == false || !method_exists($this->context, 'getMobileDevice'))) {
			$this->addCSS(array(
				_THEME_CSS_DIR_.'scenes.css' => 'all',
				_THEME_CSS_DIR_.'category.css' => 'all',
				_THEME_CSS_DIR_.'product_list.css' => 'all',
			));
			if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0) $this->addJS(_THEME_JS_DIR_.'products-comparison.js');
		} else if (version_compare(_PS_VERSION_, '1.4.0.0', '>=')) {
			Tools::addCSS(array(
				_PS_CSS_DIR_.'jquery.cluetip.css' => 'all',
				_THEME_CSS_DIR_.'scenes.css' => 'all',
				_THEME_CSS_DIR_.'category.css' => 'all',
				_THEME_CSS_DIR_.'product_list.css' => 'all'));
			if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0) Tools::addJS(_THEME_JS_DIR_.'products-comparison.js');
		}
	}
	public function init() {
		parent::init();
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
			$this->context->cookie = self::$cookie;
			$this->context->smarty = self::$smarty;
		}
		$this->_setSEOTags();
		$this->_setProductFilterList();
	}
	private function _setProductFilterList() {
		$productFilterListSource = Tools::getValue('productFilterListSource');
		if (in_array($productFilterListSource, array('best-sales', 'new-products', 'prices-drop', 'search'))) {
			PM_AdvancedSearch4::$productFilterListSource = $productFilterListSource;
			if ($productFilterListSource == 'search') {
				$productFilterListData = @base64_decode(Tools::getValue('productFilterListData'));
				if ($productFilterListData !== false) {
					if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
						PM_AdvancedSearch4::$productFilterListData = Tools::replaceAccentedChars(urldecode($productFilterListData));
					else
						PM_AdvancedSearch4::$productFilterListData = urldecode($productFilterListData);
					Module::getInstanceByName('pm_advancedsearch4')->setProductFilterContext();
				}
			}
		}
	}
	private function _setSEOTags() {
		$this->id_seo = Tools::getValue('id_seo',false);
		$seo_url = Tools::getValue('seo_url',false);
		if ($seo_url && $this->id_seo && !Tools::getValue('getShareBlock')) {
			$resultSeoUrl = AdvancedSearchSeoClass::getSeoSearchByIdSeo((int)$this->id_seo, (int)$this->context->cookie->id_lang);
			if (!$resultSeoUrl) {Tools::redirect('404.php');die;}
			if ($resultSeoUrl[0]['deleted']) {
				header("Status: 301 Moved Permanently", false, 301);
				Tools::redirect('index.php');
				die();
			}
			$pageNumber = (int)Tools::getValue('p');
			$this->context->smarty->assign(array(
				/*'page_name'				=>	'advancedsearch-seo-'.(int)$this->id_seo,*/
				'page_name'				=>	'advancedsearch-seo',
				'meta_title'			=>	$resultSeoUrl[0]['meta_title'].(!empty($pageNumber) ? ' ('.$pageNumber.')' : ''),
				'meta_description'		=>	$resultSeoUrl[0]['meta_description'],
				'meta_keywords'			=>	$resultSeoUrl[0]['meta_keywords'],
				'as_seo_title'			=>	$resultSeoUrl[0]['title'],
				'as_seo_description'	=>	$resultSeoUrl[0]['description']
			));
		}
		if (Tools::getValue('ajaxMode')) {
			if (!headers_sent())
				header('X-Robots-Tag: noindex, nofollow', true);
			$this->context->smarty->assign(array(
				'nofollow' => true,
				'nobots' => true,
			));
		} else if (Tools::getValue('only_products')) {
			if ($this->id_seo && (Tools::getValue('p') || Tools::getValue('n')))
				header('X-Robots-Tag: noindex, follow', true);
			else
				header('X-Robots-Tag: noindex, nofollow', true);
			$this->context->smarty->assign(array(
				'nofollow' => true,
				'nobots' => true,
			));
		}
	}
	public function process() {
		$seo_url = Tools::getValue('seo_url',false);
		if ($seo_url == 'products-comparison') {
			ob_end_clean();
			header("Status: 301 Moved Permanently", false, 301);
			Tools::redirect('products-comparison.php?ajax='.(int)Tools::getValue('ajax').'&action='.Tools::getValue('action').'&id_product='.(int)Tools::getValue('id_product'));
			die();
		}
		if ($seo_url && $this->id_seo && !Tools::getValue('getShareBlock')) {
			$resultSeoUrl = AdvancedSearchSeoClass::getSeoSearchByIdSeo((int)$this->id_seo, (int)$this->context->cookie->id_lang);
			if (!$resultSeoUrl) {Tools::redirect('404.php');die;}
			if ($resultSeoUrl[0]['deleted']) {
				header("Status: 301 Moved Permanently", false, 301);
				Tools::redirect('index.php');
				die();
			}
			$currentUri = explode('?', $_SERVER['REQUEST_URI']);
			$currentUri = $currentUri[0];
			$this->realURI = __PS_BASE_URI__.(Language::countActiveLanguages() > 1 ? Language::getIsoById($this->context->cookie->id_lang).'/': '').'s/'.$resultSeoUrl[0]['id_seo'].'/'.$resultSeoUrl[0]['seo_url'];
			if (!preg_match('#([a-z]{2})?/?s/([0-9]+)/([a-zA-Z0-9/_-]*)#', $_SERVER['REQUEST_URI'])) {
				header("Status: 301 Moved Permanently", false, 301);
				header("Location: ".$this->realURI . ((int)Tools::getValue('p') > 1 ? '?p='.(int)Tools::getValue('p') : ''));
				die();
			}
			if (!Tools::getValue('id_seo_id_search') && ($resultSeoUrl[0]['seo_url'] != $seo_url || $currentUri != $this->realURI)) {
				header("Status: 301 Moved Permanently", false, 301);
				header("Location: ".$this->realURI);
				die();
			}
			$this->id_search = $resultSeoUrl[0]['id_search'];
			$AdvancedSearchClass = new AdvancedSearchClass((int)$this->id_search, (int)$this->context->cookie->id_lang);
			if (!$AdvancedSearchClass->active) {
				header("Status: 302 Moved Temporarily", false, 302);
				Tools::redirect('index.php');
				die();
			}
			$criteria = unserialize($resultSeoUrl[0]['criteria']);
			if (is_array($criteria) && sizeof($criteria)) {
				$this->criterions = PM_AdvancedSearch4::getArrayCriteriaFromSeoArrayCriteria($criteria);
			}
			$_GET['id_seo_id_search'] = (int)$this->id_search;
			$_GET['as4c'] = $this->criterions;
			$this->hookName = AdvancedSearchClass::getHookName($AdvancedSearchClass->id_hook);
			$hasPriceCriterionGroup = false;
			if (is_array($this->criterions) && sizeof($this->criterions)) {
				$selected_criteria_groups_type = AdvancedSearchClass::getCriterionGroupsTypeAndDisplay((int)$this->id_search, array_keys($this->criterions));
				if (is_array($selected_criteria_groups_type) && sizeof($selected_criteria_groups_type)) {
					foreach ($selected_criteria_groups_type as $criterionGroup) {
						if ($criterionGroup['criterion_group_type'] == 'price') {
							$hasPriceCriterionGroup = true;
							break;
						}
					}
				}
			}
			if ($hasPriceCriterionGroup && $resultSeoUrl[0]['id_currency'] && $this->context->cookie->id_currency != (int)$resultSeoUrl[0]['id_currency']) {
				$this->context->cookie->id_currency = $resultSeoUrl[0]['id_currency'];
				header('Refresh: 1; URL='.$_SERVER['REQUEST_URI']);
				die;
			}
			$this->context->smarty->assign('as_cross_links', AdvancedSearchSeoClass::getCrossLinksSeo($this->context->cookie->id_lang, $resultSeoUrl[0]['id_seo']));
		} else {
			if (Tools::getValue('setCollapseGroup')) {
				ob_end_clean();
				$this->id_search = (int)Tools::getValue('id_search');
				$id_criterion_group = (int)Tools::getValue('id_criterion_group');
				$state = (int)Tools::getValue('state');
				$id_criterion_group = $this->id_search . '_' . $id_criterion_group;
				$criterion_state = array($id_criterion_group => $state);
				$previous_criterion = array();
				if (isset($this->context->criterion_group_state)){
					$previous_criterion = unserialize($this->context->criterion_group_state);
					if (is_array($previous_criterion) && sizeof($previous_criterion)){
						foreach($previous_criterion as $k => $v){
							if ($k == $id_criterion_group)
								$criterion_state[$k] = (int)$state;
							else
								$criterion_state[$k] = (int)$v;
						}
						$this->context->criterion_group_state = serialize($criterion_state);
						die;
					}
					else
						$this->context->criterion_group_state = serialize($criterion_state);
					die;
				}
				else
					$this->context->criterion_group_state = serialize($criterion_state);
				die;
			} elseif (Tools::getValue('setHideCriterionStatus')) {
				ob_end_clean();
				$this->id_search = (int)Tools::getValue('id_search');
				$state = (int)Tools::getValue('state');
				if (isset($this->context->hidden_criteria_state)){
					$hidden_criteria_state = unserialize($this->context->hidden_criteria_state);
					if (is_array($hidden_criteria_state))
						$hidden_criteria_state[$this->id_search] = $state;
					else
						$hidden_criteria_state = array();
					$this->context->hidden_criteria_state = serialize($hidden_criteria_state);
				} else {
					$this->context->hidden_criteria_state = serialize(array($this->id_search => $state));
				}
				die;
			} elseif (Tools::getValue('getShareBlock')) {
				ob_end_clean();
				echo Module::getInstanceByName('pm_advancedsearch4')->getShareBlock(Tools::safeOutput(Tools::getValue('ASSearchTitle')), Tools::safeOutput(Tools::getValue('ASSearchUrl')));
				die;
			} else if (Tools::getValue('resetSearchSelection')) {
				ob_end_clean();
				$this->id_search = (int)Tools::getValue('id_search');
				Module::getInstanceByName('pm_advancedsearch4')->resetSearchSelection($this->id_search);
				die('1');
			}
			$this->criterions = Tools::getValue('as4c', array());
			if (is_array($this->criterions))
				$this->criterions = PM_AdvancedSearch4::array_map_recursive('intval', $this->criterions);
			else
				$this->criterions = array();
			$this->criterions_hidden = Tools::getValue('as4c_hidden', array());
			if (is_array($this->criterions_hidden))
				$this->criterions_hidden = PM_AdvancedSearch4::array_map_recursive('intval', $this->criterions_hidden);
			else
				$this->criterions_hidden = array();
			$this->next_id_criterion_group = (int)Tools::getValue('next_id_criterion_group', false);
			$this->reset = (int)Tools::getValue('reset', false);
			$this->reset_group = (int)Tools::getValue('reset_group', false);
			if ($this->reset)
				$this->criterions = array();
			if ($this->reset_group && isset($this->criterions[$this->reset_group]))
				unset($this->criterions[$this->reset_group]);
			$this->hookName = Tools::getValue('hookName');
			$this->id_search = (int)Tools::getValue('id_search');
			$this->context->cookie->{'next_id_criterion_group_'.(int)$this->id_search} = $this->next_id_criterion_group;
		}
	}
	public function displayAjax() {
		$this->displayContent();
	}
	public function displayContent() {
		if ((!$this->id_seo && !$this->hookName) || !$this->id_search)
			die;
		if (Tools::getValue('ajaxMode'))
			$this->ajax = true;
		$objPM_AdvancedSearch4 = new PM_AdvancedSearch4();
		if (!Tools::getValue('ajaxMode')) {
			$_GET['only_products'] = 1;
			echo $objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search, $this->hookName, 'pm_advancedsearch.tpl', (int)Tools::getValue('with_product', true), $this->criterions, $this->criterions_hidden, true);
			unset($_GET['only_products']);
		} else {
			AdvancedSearchCoreClass::_hookExec('header');
			$ajaxMode = true;
			if (Tools::getValue('only_products'))
				$objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search, $this->hookName, 'pm_advancedsearch.tpl', (int)Tools::getValue('with_product',true), $this->criterions, $this->criterions_hidden, true);
			else if ($this->next_id_criterion_group && !$this->reset) {
				if (is_array($this->criterions) && sizeof($this->criterions))
					$objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search, $this->hookName, 'pm_advancedsearch.tpl', (int)Tools::getValue('with_product', true), $this->criterions, $this->criterions_hidden);
				else
					$objPM_AdvancedSearch4->displayNextStepSearch($this->id_search, $this->hookName, $this->next_id_criterion_group, (int)Tools::getValue('with_product', true), $this->criterions, $this->criterions_hidden);
			} else {
				$objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search, $this->hookName, 'pm_advancedsearch.tpl', (int)Tools::getValue('with_product', true), $this->criterions, $this->criterions_hidden);
			}
		}
		if ($this->ajax)
			die;
	}
}
