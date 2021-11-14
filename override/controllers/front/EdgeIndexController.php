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
*  @version  Release: $Revision: 14006 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class EdgeIndexControllerCore extends EdgeController
{
	public $php_self = 'edge-index.php';
	
	public function displayContent()
	{	
			$edge_get_product = new BulkRequest();
			$product_papers = $edge_get_product->getProducts(1,'201296,201297,203626,20119,10125,203944,20115,20116,203895,201634,203690,203691');
			self::$smarty->assign(array('products' => $product_papers,
								  'imagetype' => 'small'));
			parent::displayContent();
			self::$smarty->display('edge/edge-index.tpl');	
	}
}

