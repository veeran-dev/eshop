<?php
/*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class DealsControllerCore extends FrontController
{
    /** string Internal controller name */
    public $php_self = 'deals';

    public function setMedia()
    {
        parent::setMedia();
		
		$this->addCSS(array(
			_THEME_CSS_DIR_.'deals.css' => 'all',
		));
		$this->addJS(array(
			_THEME_JS_DIR_.'modules/blockcart/ajax-cart.js',
		));
    }

    public function initContent()
    {
        parent::initContent();
		$category 		= new CategoryList();
		$deals_page = Tools::getValue('page');
		// General Deals
		$deals = SpecificPrice::getDealProducts($deals_page);
		
		$this->context->smarty->assign(array(
		'hide_left_column'		=> 1,
		'hide_right_column' 	=> 1,
		'path' 					=> Tools::safeOutput('Deals'),
		'banners'				=> $deals[0],
		
		'deals_title' 			=> $deals[1],
		'deals_hash' 			=> $deals[2],
		
		'deals' 				=> $deals[3]
		));
		
		$this->setTemplate(_PS_THEME_DIR_.'deals.tpl'); 
    }
}
