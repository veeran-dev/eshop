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
class RmQuotePublishControllerCore extends FrontController
{
	public function ajaxReturn()
	{	
		$type = Tools::getValue('type');
		$id_quotation = Tools::getValue('id_quotation');
		$publish_from_module = Tools::getValue('publish_from_module');
		$id_group = Tools::getValue('id_group');
		$quotationObj = new ScnQuotation($id_quotation);
		$quote_details = ScnQuotation::getQuoteDetail($id_quotation);

		$rate_contract_count = 0;
		$specific_update_count = 0;
		$specific_add_count = 0;

		if($quote_details)
		{

			if($id_group == 1)
			{
				echo "2";
			}
			else
			{
				$errors = array();
				$product_details = array();

				foreach ($quote_details as $key => $product) 
				{
					$productObj = new Product(intval($product['id_product']));
					$gst = $quotationObj->getProductTaxRate($productObj->id);
					$mrp = $productObj->price + (($gst / 100) * $productObj->price);
					// Check whether product is discontinued.
					if($productObj->discontinued) {
						$errors[$key][] = "Discontinued.";
					}
					// Check product status active/inactive
					if(!$productObj->active) {
						$errors[$key][] = "Inactive.";
					}
					// Check if product is in stock
					if(StockAvailable::getQuantityAvailableByProduct($productObj->id) <= 0 && StockAvailable::outOfStock($productObj->id) == 0) {
						$errors[$key][] = "Out of Stock.";
					}
					// Check if quoted price is exceeded MRP
					if($productObj->price < $product['product_price']) {
						$errors[$key][] = "Quoted Price Exceeded MRP.";
					}
					// Check if quoted date is expired
					if($quotationObj->isQuotedDateExpired($productObj->id)) {
						$errors[$key][] = "Date expired.";
					}

					if(sizeof($errors[$key]) > 0) {
						$product_details['product_errors'][$key] = array(
							'errors' => $errors[$key],
							'name' => $productObj->name[1],
							'code' => $productObj->reference,
							'gst' => Tools::ps_round($gst, _PS_PRICE_COMPUTE_PRECISION_),
							'mrp' => Tools::ps_round($mrp, _PS_PRICE_COMPUTE_PRECISION_),
							'quoted_price' => Tools::ps_round($product['product_price'], _PS_PRICE_COMPUTE_PRECISION_),
						);
					}
				}

				if(empty($errors)) {
					for($i = 0; $i < sizeof($quote_details); $i++){
						/*
							Specific Price section
								*check availability of price for a product to customer group
								*if exists(product price){override the price} else{insert new}
						*/
						$specific_price = SpecificPrice::isExistsSpecificPrice($quote_details[$i]['id_product'], $id_group);

						if($specific_price){
							$update_specific_price = SpecificPrice::updateSpecificPrice($quote_details[$i]['product_price'], $quote_details[$i]['id_product'], $id_group, $quote_details[$i]['to']);
							$specific_update_count++;
						}
						else{
							$add_specific_price = SpecificPrice::addSpecificPrice($quote_details[$i]['product_price'], $quote_details[$i]['id_product'], $id_group, $quote_details[$i]['to']);
							$specific_add_count++;
						}
					}

					//send number of changes to browser
					$counter_array = array('specific_update' => $specific_update_count, 'specific_add' => $specific_add_count );
					
					// Update published status for RM
					if(isset($publish_from_module) && $publish_from_module) {
						$quotationObj->published = 1;
					}

					$quotationObj->rm_published = 1;
					$quotationObj->update();
					
					echo Tools::jsonEncode($counter_array);
				}
				else {
					echo Tools::jsonEncode($product_details);
				}
			}
			
		}
		else
		{
			echo "1";
		}
	}
}