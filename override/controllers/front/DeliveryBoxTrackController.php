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
class DeliveryBoxTrackControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $smarty;

		$type = Tools::getValue('type');
		$from_date = Tools::getValue('from_date');
		$to_date = Tools::getValue('to_date');
		$fc = Tools::getValue('id_fc');
		$id_order = Tools::getValue('id_order');
		$id_delivery = Tools::getValue('id_delivery');
		$id_customer = Tools::getValue('id_customer');
		$box_to_return = Tools::getValue('box_to_return');
		$company = Tools::getValue('company');

		$fullfillment_centre = FulfillmentCentre::getAllFCentres();
		$delivery = new Delivery();
		$box_return = new DeliveryBoxReturn();
		
		if(isset($type))
		{
			if($type == 0) //Overall boxes count data fetching 
			{
				$delivery_detail = $delivery->getDeliveryBoxDetails($from_date, $to_date, $fc, false, false);
				
				$smarty->assign(array('fc_array' => $fullfillment_centre,
									  'box_array' => 1,
									  'delivey_detail' => $delivery_detail));

				$smarty->display('scn/scn-track-delivery-box.tpl');
			}
			elseif($type == 1) // View boxes count customer wise 
			{
				$delivery_detail = $delivery->getDeliveryBoxDetails($from_date, $to_date, $fc, $id_order, $view = 1, $company);

				$smarty->assign(array('fc_array' => $fullfillment_centre, 
									  'delivey_detail' => $delivery_detail,
									  'box_sent' => 1));

				$smarty->display('scn/scn-track-delivery-box.tpl');
			}
			elseif($type == 2) // Box Return -> GET box details for particular customer
			{
				$box_detail = $delivery->getBoxDetailsForCustomer($id_customer);
				
				$smarty->assign(array('fc_array' => $fullfillment_centre, 
									  'box_detail' => $box_detail,
									  'box_returned' => 1));

				$smarty->display('scn/scn-track-delivery-box.tpl');
			}
			elseif($type == 3) // Box Return -> insert or update returned boxes for customer
			{
				// GET boxes already returned by customer
				$returned_box_old = new DeliveryBoxReturn($id_customer);

				$box_detail = $delivery->getBoxDetailsForCustomer($id_customer);
				
				if($box_detail[0]['returned_boxes'] != "")
				{
					$returned_box_old->box_returned = (int)($returned_box_old->box_returned) + (int)($box_to_return);
					$returned_box_old->points = (int)($returned_box_old->points) + ((int)($box_to_return) * 100);
					//UPDATE on customer already returned + remaining box returned
					if($returned_box_old->update())
					{
						$box_detail_new = $delivery->getBoxDetailsForCustomer($id_customer);
					}
				}
				else
				{
					$box_return->id_customer = (int)($id_customer);
					$box_return->box_returned = (int)($box_to_return);
					$box_return->points = ((int)($box_to_return) * 100);
					// ADD new customer data for boxes returned
					if($box_return->add())
					{
						$box_detail_new = $delivery->getBoxDetailsForCustomer($id_customer);
					}
				}

				$smarty->assign(array('fc_array' => $fullfillment_centre, 
									  'box_detail' => $box_detail_new,
									  'box_returned' => 1));

				$smarty->display('scn/scn-track-delivery-box.tpl');
			}
		}
	}
}