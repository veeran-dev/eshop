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
class FestivalEmailControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;
		$customer_id = $_POST['customer_id'];
		$eliteDeals = $_GET['elite-deals'];
		if($eliteDeals == 1)
		{
			$data = array(
					'link' => configuration::get('KOB_ELITE_DEALS_LINK'),
					'img' => configuration::get('KOB_ELITE_DEALS_IMG'),
					);
			// var_dump(configuration::get('KOB_ELITE_DEALS_LINK'));
			// var_dump($data);
			echo Tools::jsonEncode($data);
		}
		else
		{
			$customer = new Customer($customer_id);
			$relationshipMananger = new Employee($customer->id_relationship_manager);
			
			$data = array(
				'{name}' => $customer->firstname,
				'{email}' => $customer->email,
				'{phone}' => $customer->mobile
			);

			Mail::Send((int)$cookie->id_lang, 'festival_order_req', Mail::l("Deal Enquiry", (int)$cookie->id_lang), $data, $relationshipMananger->email, 'Festival Offers Enquiry', 'noreply@kobster.com');	
		}
	}
}