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

class PincodeController extends FrontController
{
	public function ajaxCall()
	{
		$pincode = Tools::getValue('pincode');
		$productid = Tools::getValue('id_product');

		$available_zones = Db::getInstance()->getValue('SELECT GROUP_CONCAT(zone_id) FROM '._DB_PREFIX_.'product_zone_mapping 
														WHERE product_id = '.$productid);

		if($available_zones != "") 
		{
			$sql = 'SELECT COUNT(zone_id) 
					FROM '._DB_PREFIX_.'pincode_range_zone_mapping
					WHERE zone_id IN('.$available_zones.') AND '.$pincode.' BETWEEN zone_pin_start AND zone_pin_end';

			$pin_availability = Db::getInstance()->getValue($sql);
			
			if($pin_availability > 0) { // Pin available if anything matched in zone range of pins
				$result_status = 1;
			}
			else if($available_zones == "1") { // All pin available if all zones tagged default
				$result_status = 1;
			}
			else { // Pin not available
				$result_status = 0;
			}
		}
		else 
		{
			// Pin not available if none of zones tagged to product
			$result_status = 0;
		}

 		return Tools::jsonEncode(array('status' => $result_status));
	}

	public function zoneCall()
	{
		$productid = $_POST['productid'];
		
		$zoneCheckSql ='SELECT count(zone_id) as count FROM '._DB_PREFIX_.'product_zone_mapping WHERE product_id="'.$productid.'"';
		
 		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($zoneCheckSql);
		
 		$count = $result['count']; 
		
		if ($count == "" || $count == 0)
		{
			$result_status=0;
		}
		else
		{
			$result_status = 1;
		}

 		return Tools::jsonEncode(array('status' => $result_status));
	}
 
}
