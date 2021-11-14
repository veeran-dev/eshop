<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 15173 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
class CatalogControllerCore extends FrontController
{
	public $catalog_auth = false;
 	
	public function run()
	{
		$this->init();
		$this->postProcess();
		$this->displayHeader();
		$this->process();
		$this->displayContent();
		$this->displayFooter();
	}
	public function init()
	{
		parent::init();
		global $useSSL, $cookie, $smarty,$protocol_link, $protocol_content, $link;
 		ob_start();
		$timerStart = microtime(true);
 		$currentFileName = array_reverse(explode("/", $_SERVER['SCRIPT_NAME']));
		$cookieLifetime = (time() + (((int)Configuration::get('PS_COOKIE_LIFETIME_BO') > 0 ? (int)Configuration::get('PS_COOKIE_LIFETIME_BO') : 1)* 3600));
 		$cookie = new Cookie('psAdmin', substr($_SERVER['SCRIPT_NAME'], strlen(__PS_BASE_URI__), -strlen($currentFileName['0'])), $cookieLifetime);
		//$cookie = new Cookie('psAdmin', substr($_SERVER['PHP_SELF'], strlen(__PS_BASE_URI__), -10));
		
		global $currency;
		$currency = Tools::setCurrency($this->context->cookie);
		$cookie->currency_format_value= $currency->format;
		
		$smarty->assign('content_dir',$protocol_content.Tools::getHttpHost().__PS_BASE_URI__);
		
   		$link = new Link();

 		if (isset($_GET['catalogLogout'])) {
 			$cookie->logout();
		}
		  
 		if (!$cookie->isLoggedBackCatalog((int)$cookie->id_poc) && $this->catalog_auth) {
  				Tools::redirect('catalog-auth.php');
		}

		/* Server Params */
		$protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
		$protocol_content = (isset($useSSL) AND $useSSL AND Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
		
		$employee = new Vendor((int)$cookie->id_poc);

		$iso = strtolower(Language::getIsoById($cookie->id_lang ? $cookie->id_lang : Configuration::get('PS_LANG_DEFAULT')));
		
		//$link->preloadPageLinks();
			$smarty->assign(array('logged' => $cookie->isLogged()));
		$smarty->assign(array('link' => $link,'cookie'=>$cookie));
		$assignArray = array(
		'img_ps_dir' => _PS_IMG_,
		'img_cat_dir' => _THEME_CAT_DIR_,
		'img_lang_dir' => _THEME_LANG_DIR_,
		'img_prod_dir' => _THEME_PROD_DIR_,
		'img_manu_dir' => _THEME_MANU_DIR_,
		'img_sup_dir' => _THEME_SUP_DIR_,
		'img_ship_dir' => _THEME_SHIP_DIR_,
		'img_store_dir' => _THEME_STORE_DIR_,
		'img_col_dir' => _THEME_COL_DIR_,
		'img_dir' => _THEME_IMG_DIR_,
		'css_dir' => _THEME_CSS_DIR_,
		'js_dir' => _THEME_JS_DIR_,
		'pic_dir' => _THEME_PROD_PIC_DIR_,
		'content_dir' => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__
		);
		
		self::$cookie = $cookie;
			self::$smarty = $smarty;
		self::$link = $link;
	}
	public function displayHeader($display= true)
	{
		global $css_files, $js_files;

		if (!self::$initialized)
			$this->init();

		// P3P Policies (http://www.w3.org/TR/2002/REC-P3P-20020416/#compact_policies)
		header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

		/* Hooks are volontary out the initialize array (need those variables already assigned) */
		self::$smarty->assign(array(
			'time' => time(),
			'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
			'static_token' => Tools::getToken(false),
			'token' => Tools::getToken(),
			'logo_image_width' => Configuration::get('SHOP_LOGO_WIDTH'),
			'logo_image_height' => Configuration::get('SHOP_LOGO_HEIGHT'),
			'priceDisplayPrecision' => _PS_PRICE_DISPLAY_PRECISION_,
			'content_only' => (int)Tools::getValue('content_only')
		));

		self::$smarty->assign('css_files', $css_files);
		self::$smarty->assign('js_files', array_unique($js_files));
		self::$smarty->display('catalog/views/catalog-header.tpl');
	}
	
	public function displayFooter($display= true)
	{
		if (!self::$initialized)
			$this->init();

		
		self::$smarty->display('catalog/views/catalog-footer.tpl');
	}
}