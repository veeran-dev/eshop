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
*  @version  Release: $Revision: 14007 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
class SellwithusControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		$type = Tools::getValue('registrationFlag');

		if($type == 1) 
		{
			$recievedData = array(
				'seller_name' 		=> trim(Tools::getValue('seller_name')),
				'firm_name' 		=> trim(Tools::getValue('firm_name')),
				'city' 				=> trim(Tools::getValue('city')),
				'mobile' 			=> trim(Tools::getValue('mobile')),
				'email' 			=> trim(Tools::getValue('email')),
				'seller_type' 		=> trim(Tools::getValue('seller_type'))
			);
			
			$table_name = "sellers";

			if(Db::getInstance()->insert($table_name, $recievedData)) 
			{
				$rec_email 	= $recievedData['email'];
				$sell_name 	='Harish from Kobster';

				echo "success";
				
				$sql = "SELECT city_name FROM "._DB_PREFIX_."seller_cities WHERE id_seller_city = '".$recievedData['city']."' ";
				$results = Db::getInstance()->ExecuteS($sql);
				
				
				$mailData = array(
					'{seller_name}' 	=> $recievedData['seller_name'],
					'{firm_name}' 		=> $recievedData['firm_name'],
					'{city}' 			=> $results[0]['city_name'],
					'{mobile}' 			=> $recievedData['mobile'],
					'{email}' 			=> $recievedData['email'],
					'{seller_type}' 	=> $recievedData['seller_type']
				);
				
				// Mail sent to Registered Seller
				$to			= $recievedData['email'];
				$toName 	= $recievedData['fullname'];
				$subject 	= $recievedData['seller_name'].', Thanks for Registering with Kobster!';
				Mail::Send(1, 'sellwithus_seller', $subject, $mailData, $to, $toName);
				
				// Mail sent to Category team
				$to			= "category@kobster.com";
				$toName 	= "Category Team";
				$from		= $recievedData['email'];
				$fromName 	= $recievedData['fullname']. ' from '. $recievedData['firm_name'];
				$subject 	= 'Seller Registration request from '. $recievedData['seller_name'];
				Mail::Send(1, 'sellwithus_category', $subject, $mailData, $to, $toName, $from, $fromName);
				
			}
			else {
				echo "failed";	
			}
		}
		else {
			$cities = Db::getInstance()->ExecuteS("SELECT `id_seller_city`, `city_name` 
												   FROM "._DB_PREFIX_."seller_cities ORDER BY `city_name` ASC");
			self::$smarty->assign(array('cities' => $cities));
			self::$smarty->display(_PS_THEME_DIR_.'sell-with-us.tpl');
		}	
	}
}