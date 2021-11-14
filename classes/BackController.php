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
class BackControllerCore extends FrontController
{
	public $scn_auth = false;
 	public $RM_auth = false;
	public $finance_auth = false;

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
		// any valid date in the past
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		// always modified right now
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		// HTTP/1.1
		header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
		// HTTP/1.0
		header("Pragma: no-cache");

 		global $useSSL, $cookie, $smarty,$protocol_link, $protocol_content, $link;

 		ob_start();

		$timerStart = microtime(true);
 		$currentFileName = array_reverse(explode("/", $_SERVER['SCRIPT_NAME']));
		$cookieLifetime = (time() + (((int)Configuration::get('PS_COOKIE_LIFETIME_BO') > 0 ? (int)Configuration::get('PS_COOKIE_LIFETIME_BO') : 1)* 3600));
 		$cookie = new Cookie('psAdmin', substr($_SERVER['SCRIPT_NAME'], strlen(__PS_BASE_URI__), -strlen($currentFileName['0'])), $cookieLifetime);
		
		/* Server Params */
		$protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
		$protocol_content = (isset($useSSL) AND $useSSL AND Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';

		global $currency;
		$tools = new Tools();
		$currency = $tools->setCurrency($this->context->cookie);
		$cookie->currency_format_value= $currency->format;
		
		$smarty->assign('content_dir', $protocol_link.Tools::getHttpHost().__PS_BASE_URI__);
		
   		$link = new Link();

 		if (isset($_GET['scnLogout']) || isset($_GET['RMLogout']) || isset($_GET['FinanceLogout'])) {
 			$cookie->logout();
 		}
		  
 		if (!$cookie->isLoggedBack() && $this->scn_auth) {
 			Tools::redirect($protocol_content.Tools::getHttpHost().__PS_BASE_URI__."index.php?controller=scn-login");
		}
		else if(!$cookie->isLoggedBack() && $this->RM_auth) {
			Tools::redirect($protocol_content.Tools::getHttpHost().__PS_BASE_URI__."index.php?controller=rm-login");
		}
		else if(!$cookie->isLoggedBack() && $this->finance_auth) {
			Tools::redirect($protocol_content.Tools::getHttpHost().__PS_BASE_URI__."index.php?controller=finance-login");
		}
		
		$employee = new Employee((int)$cookie->id_employee);

		$cookie->profile = $employee->id_profile;
		$cookie->id_lang = (int)$employee->id_lang;
		$iso = strtolower(Language::getIsoById($cookie->id_lang ? $cookie->id_lang : Configuration::get('PS_LANG_DEFAULT')));
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
		$smarty->assign("assignArray",$assignArray);
		self::$cookie = $cookie;
			self::$smarty = $smarty;
		self::$link = $link;
	}
	
	public function displayHeader($display = true)
	{
		//global $css_files, $js_files;

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
		if($this->RM_auth)
			self::$smarty->display('rm/rm-header.tpl');
		else if($this->scn_auth)
 			self::$smarty->display('scn/scn-header.tpl');
		else
			self::$smarty->display('finance/finance-header.tpl');
	}
	
	public function displayFooter($display = true)
	{
		if (!self::$initialized)
			$this->init();

		if($this->RM_auth)
			self::$smarty->display('rm/rm-footer.tpl');
		else if($this->scn_auth)
			self::$smarty->display('scn/scn-footer.tpl');
		else
			self::$smarty->display('finance/finance-footer.tpl');
	}

	public function ajaxReturn() {
		$this->init();
		global $cookie;
		
		if($this->scn_auth && $cookie->logged_as != 'scn') {
			die(Tools::displayError("Your session was expired"));			
		}
		else if($this->RM_auth && $cookie->logged_as != 'rm') {
			die(Tools::displayError("Your session was expired"));
		}
		else if($this->finance_auth && $cookie->logged_as != 'finance') {
			die(Tools::displayError("Your session was expired"));
		}
	}
}

?>