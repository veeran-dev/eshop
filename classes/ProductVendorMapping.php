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
class ProductVendorMappingCore extends ObjectModel
{
	public function getVendors($id_product){

		return Db::getInstance()->ExecuteS('SELECT a.`id_vendor` AS id_vendor,kv.`name` as name,c.`quantity` AS qty,c.`quantity_unit` AS qty_unit,c.`product_name` AS product_name,b.`email` AS email,b.`phone2` AS phone2,b.`firstname` AS poc_name 
											FROM '._DB_PREFIX_.'vendor kv 
											LEFT JOIN '._DB_PREFIX_.'product_vendor_mapping a ON a.`id_vendor` = kv.`id_vendor`
											LEFT JOIN '._DB_PREFIX_.'vendor_poc b ON b.`id_poc` = a.`id_poc` 
											LEFT JOIN '._DB_PREFIX_.'bq_request c ON c.`id_product` = a.`id_product`
											WHERE a.`id_product` = '.(int)($id_product).' AND kv.`active`=1 GROUP BY kv.`id_vendor`');

	}
}