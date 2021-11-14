<?php
/**
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
 *  @author  PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class RMCustomerRateContractControllerCore extends DashController 
{
	public function ajaxReturn()
	{	
		$smarty = Tools::getValue('smarty'); 
		$ajax = Tools::getValue('ajax');
		$id_employee = Tools::getValue('id_employee');

		/**
		* Smarty execution block
		*/
		if(isset($smarty) && $smarty) 
		{
			$id_group = Tools::getValue('id_group');
			$group_selected = Tools::getValue('group_selected');
			// Get groups
			$groups = Group::getGroups(true);

			// Get products
			$products = array();
			if(isset($group_selected) && $group_selected) {
				$specificPrice = new SpecificPrice();
 				$customer_products_list = $specificPrice->getCustomerProductList(0, NULL, NULL, NULL, $id_group, true);
  				$products = Product::getProductsProperties($id_lang = 1, $customer_products_list);
			}

			$this->context->smarty->assign(array('groups' => $groups, 'products' => $products, 'id_group' => $id_group));
			$this->context->smarty->display('rm/rm-customerratecontract.tpl');	
		}

		/**
		* Ajax execution block
		*/
		if(isset($ajax) && $ajax) 
		{
			$type = Tools::getValue('type');
			$valid_till = Tools::getValue('to');
			$id_group = Tools::getValue('id_group');
			$id_specific_price = Tools::getValue('id_specific_price');

			if($type == 1) // Date change block (includes expire and extend)
			{
				$to = date("Y-m-d h:i:s", strtotime($valid_till));
				$to = substr_replace($to, '23:59:59', 11);
				$specificPrice = new SpecificPrice($id_specific_price);
				$product = new Product(intval($specificPrice->id_product), false, true);
				$oldDate = $specificPrice->to;
				$specificPrice->to = $to;
				$extend = true;

				// Check if valid expiry date selected and contract price should not be more than MRP.
				if($to > date("Y-m-d h:i:s")) {
					if($specificPrice->price > $product->price) {
						$extend = false;
					}
				}

				if(!$extend) { // If not extend contract price exceeds MRP.
					echo "Rate contract price exceeds MRP.";
				}
				else if($specificPrice->update()) {
					// Add catalog history about rate contract change
					$content['0'] = array('from' => $oldDate, 'to' => $specificPrice->to, 'id_employee' => $id_employee);
                    CatalogHistory::addHistory(($extend ? 'rcp_extended' : 'rcp_expired'), $specificPrice->id_product, $content);

					echo $to;
				}
				else {
					echo "Error in changing price. Please try again.";
				}
			}
			else if($type == 2) // Expire block
			{
				$bulk_expire = Tools::getValue('bulk_expire');
				if(isset($bulk_expire) && $bulk_expire) { // If bulk product expire action is set
					$result = array();
					foreach ($id_specific_price as $id_price) {
						$specificPrice = new SpecificPrice($id_price);
						$oldDate = $specificPrice->to;
						$specificPrice->to = date("Y-m-d h:i:s");
						if($specificPrice->update()) {
							$content['0'] = array('from' => $oldDate, 'to' => $specificPrice->to, 'id_employee' => $id_employee);
                        	CatalogHistory::addHistory('rcp_expired', $specificPrice->id_product, $content);
							$result[] = array('id_specific_price' => $specificPrice->id, 'date' => $specificPrice->to);
						}
					}

					if(!empty($result)) {
						echo Tools::jsonEncode($result);
					}
					else {
						echo 0;
					}
				}
				else { // Single product expire action is set
					$specificPrice = new SpecificPrice($id_specific_price);
					$oldDate = $specificPrice->to;
					$specificPrice->to = date("Y-m-d h:i:s");
					if($specificPrice->update()) {
						$content['0'] = array('from' => $oldDate, 'to' => $specificPrice->to, 'id_employee' => $id_employee);
                        CatalogHistory::addHistory('rcp_expired', $specificPrice->id_product, $content);
						echo Tools::jsonEncode($specificPrice->to);
					}
					else {
						echo 0;
					}
				}
			}
			else if($type == 3) // Extend block
			{
				$response = array();
				foreach ($id_specific_price as $id_price) {
					$specificPrice = new SpecificPrice($id_price);
					$product = new Product(intval($specificPrice->id_product), false, true);
					if($specificPrice->price > $product->price) { // If contract price exceeds MRP and valid date given.
						$response[] = array(
							'name' => stripslashes($product->name), 
							'message' => 'Rate contract price exceeds MRP.',
							'success' => false,
							'reference' => $product->reference,
							'id_specific_price' => $specificPrice->id,
							'date' => $specificPrice->to
						);
					}
					else {
						$oldDate = $specificPrice->to;
						$specificPrice->to = date("Y-m-d h:i:s", strtotime($valid_till));
						if($specificPrice->update()) {
							$response[] = array(
								'name' => stripslashes($product->name), 
								'message' => 'Rate contract extended successfully.',
								'success' => true,
								'reference' => $product->reference,
								'id_specific_price' => $specificPrice->id, 
								'date' => $specificPrice->to
							);

							// Add catalog history for extension of rate contract
							$content['0'] = array('from' => $oldDate, 'to' => $specificPrice->to, 'id_employee' => $id_employee);
                        	CatalogHistory::addHistory('rcp_extended', $specificPrice->id_product, $content);
						}
					}
				}

				echo Tools::jsonEncode($response);
			}
		}
	}
}