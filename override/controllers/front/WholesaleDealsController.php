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

class WholesaleDealsControllerCore extends FrontController
{
    /** string Internal controller name */
    public $php_self = 'wholesale-deals';

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
	
		$banners	= array(
					'hero_banner'		=> 'wholesale-banner.jpg',
					'small_banner1' 	=> 'wholesale-small1.png',
					'small_banner2' 	=> 'wholesale-small2.png',
					'small_banner3' 	=> 'wholesale-small3.png',
					'small_banner4' 	=> 'wholesale-small4.png'
					);
		// Deal 1
		$deals_title['1']	= "Best Discounts";
		$deals_hash['1'] 	= "Best-discounts";
		$deals['1']			= $this->getProducts(1, '949321,949904,949402,950236,950326,949995,949404,950386,949996,950329,950247,949312,950334,949994,950243,949310,950011,950346,949906,950246,950019,950355,949325,950023,949329,950035,950484,950249,949682,950046,949696,950346,950066,262640,949529,262648,950367,264081,949704,949723,950380,949870,949871,950383,950430');

		// Deal 2
		$deals_title['2']	= "Safety Providers";
		$deals_hash['2'] 	= "Safety-deals";
		$deals['2']			= $this->getProducts(1, '949539,949540,949541,949542,949543,949544,949545,950577,949547,949548,949549,949550,949551,949552,949553,949554,949555,949556,949557,949558,949559,949560,949561,949562,949563,949564,949565,949566,949567,949568,949569,949570,949571,949572,949573,949574,949575,949576,949577,949578,949579,949580,949581,949582,949583,949584,949585,949586,949587,949588,949589,949590');
		

		// Deal 3
		$deals_title['3']	= "Electronic Deals";
		$deals_hash['3'] 	= "Electronic-deals";
		$deals['3']			= $this->getProducts(1, '949402,949403,949677,949404,949407,949529,949517,949310,949329,949321,949322,949414,949409,949701,949687,949691,949312,949313,949682,949696,949704,949723,949308,949317,949314,949316,949315,949320');


		// Deal 4
		$deals_title['4']	= "LED Deals";
		$deals_hash['4'] 	= "LED-deals";
		$deals['4']			= $this->getProducts(1, '937999,264040,264081,264084,938005,264141,264144,262640,262628,938035,262632,262636,262644,262640,262648,262652,264082,264085,263908,938050,938060,264142,264145,938113,264083,264086,938070,938080,263934,937989,264199,264143,264146,264055,263962,262656,262660,264201,263990,264018,263911,937993,938002,938100,263937,264058,263965,264220,263993,264021,263916,264221,264328,263942,264063,264329,264191,264194,264330,938110,263998,264331,264026,264332,264333,264335,264336,264337');

	
		$this->context->smarty->assign(array(
		'hide_left_column'		=> 1,
		'hide_right_column' 	=> 1,
		'path' 					=> Tools::safeOutput('Wholesale Deals'),
		'banners'				=> $banners,
		
		'deals_title' 			=> $deals_title,
		'deals_hash' 			=> $deals_hash,
		
		'deals' 				=> $deals
		));
		
		$this->setTemplate(_PS_THEME_DIR_.'wholesale-deals.tpl'); 
    }
	
	
	public function getProducts($id_lang = 1, $product_ids)
	{
		global $cookie;
		$sql = '
		SELECT cat.link_rewrite,p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new,
			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice, p.minimal_quantity
		FROM `'._DB_PREFIX_.'category_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cat ON (p.`id_category_default` = cat.`id_category`)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
		                                           AND tr.`id_country` = '.(int)Country::getDefaultCountryId().'
	                                           	   AND tr.`id_state` = 0)
	    LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
		WHERE p.`active` = 1 
		AND p.`available_for_order`=1
		AND p.`reference` IN ('.($product_ids).')
		GROUP BY cp.`id_product`
		ORDER BY FIND_IN_SET(p.`reference`,"'.($product_ids).'") ';
		$result = Db::getInstance()->ExecuteS($sql);
	
		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}

}
