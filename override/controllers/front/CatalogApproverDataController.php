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
class CatalogApproverDataControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $smarty;
		
		$type = Tools::getValue('type');
		$id_product = Tools::getValue('id_product');
		$id_state = Tools::getValue('id_product_state');
		$live_state = Tools::getValue('live_state');
		$reject_reason = Tools::getValue('reject_reason');
		$id_category = Tools::getValue('id_category');
		$status_type = Tools::getValue('status_type');
		$id_feature = Tools::getValue('id_feature');
		$feature_name = Tools::getValue('feature_name');
		$pattern = Tools::getValue('pattern');
		$feature_status = Tools::getValue('featureStatus');
		$feature_required = Tools::getValue('featureRequired');
		$product_array = Tools::getValue('product_array');

		$id_page = Tools::getValue('page');
		$productsPerPage = Tools::getValue('productsPerPage');
		$orderBy = Tools::getValue('orderBy');
		$orderWay = Tools::getValue('orderWay');

		$page_num = ($id_page == 0) ? 0 : ($id_page - 1);

		$productsPerPage && $productsPerPage != "" ? define('PAGE_PER_NO', $productsPerPage) : define('PAGE_PER_NO', 2);

		$pageLimit = (PAGE_PER_NO * $page_num);

		// $logger = new FileLogger();
		// $logger->setFilename('test1.txt');
		// $logger->logError("-------approver pagination--------".$productsPerPage."----".$pageLimit);

		if(isset($type)) 
		{
			if($type == 1) //GET products counts by respected employee's vendors
			{
				$result = array();
				$vendor = Vendor::getVendorByEmployee((int)(self::$cookie->id_employee));
								
					for($i = 0; $i < sizeof($vendor); $i++)
					{
						$pending_count_total = Vendor::getProductCountByStatus($id_status = 1, $vendor[$i]['id_poc'], 0);
						$pending_count = $pending_count + (int)$pending_count_total[0]['total_products'];
						$qc_count_total = Vendor::getProductCountByStatus($id_status = 2, $vendor[$i]['id_poc'], 0);
						$qc_count = $qc_count + (int)$qc_count_total[0]['total_products'];
						$live_count_total = Vendor::getProductCountByStatus($id_status = 3, $vendor[$i]['id_poc'], 0);
						$live_count = $live_count + (int)$live_count_total[0]['total_products'];
						$rejected_count_total = Vendor::getProductCountByStatus($id_status = 4, $vendor[$i]['id_poc'], 0);
						$rejected_count = $rejected_count + (int)$rejected_count_total[0]['total_products'];
					}

					$qc_count_by_employee = Vendor::getProductCountByStatus($id_status = 2, 0, (int)(self::$cookie->id_employee));
					$live_count_by_employee = Vendor::getProductCountByStatus($id_status = 3, 0, (int)(self::$cookie->id_employee));
					$reject_count_by_employee = Vendor::getProductCountByStatus($id_status = 4, 0, (int)(self::$cookie->id_employee));

					array_push($result, $pending_count, $qc_count, $live_count, $rejected_count, $qc_count_by_employee[0]['total_products'], $live_count_by_employee[0]['total_products'], $reject_count_by_employee[0]['total_products']);
				
				echo Tools::jsonEncode($result);
			}
			else if($type == 2) // For approver level products display
			{
				$result = array();

				if($status_type == 0)
				{
					$vendor = Vendor::getVendorByEmployee((int)(self::$cookie->id_employee));		
					for($i = 0; $i < sizeof($vendor); $i++)
					{
						$products = Vendor::getProductDetails((int)($vendor[$i]['id_poc']), $id_state, false);
						if($products != null)
							array_push($result, $products);
					}
					
				}
				else
				{
					$products = Vendor::getProductDetails(0, $id_state, (int)(self::$cookie->id_employee));
							if($products != null)
								array_push($result, $products);
				}

				echo Tools::jsonEncode($result);
			}
			else if($type == 3) // Approve and Reject section
			{ 
				if(!Vendor::isExistsProductState($id_product, self::$cookie->id_employee, $id_state)){
					Vendor::addToProductHistory($id_product, self::$cookie->id_employee, $id_state, $reject_reason);
					if($live_state)
					{
						$product = new Product((int)($id_product));
						$product->active = 1;
						if($product->update())
						{
							Search::indexation(false,(int)($product->id));
							echo 0;
						}
					}
				}
				else
					echo 1;
			}
			else if($type == 4) //GET all products details for QC
			{	
				$result = array();
				$result_product = Vendor::getProductDetails(false, $id_state, false);
				echo Tools::jsonEncode($result_product);
			}
			else if($type == 5) //For QC level products counts
			{
				$result = array();
				$pending_count = Vendor::getProductCountByStatus($id_status = 1, false, false);
				$qc_count = Vendor::getProductCountByStatus($id_status = 2, false, false);
				$live_count = Vendor::getProductCountByStatus($id_status = 3, false, false);
				$rejected_count = Vendor::getProductCountByStatus($id_status = 4, false, false);

				array_push($result, $pending_count, $qc_count, $live_count, $rejected_count);
				echo Tools::jsonEncode($result);
			}
			else if($type == 6)
			{
				$result = Vendor::getCategoryPattern($id_category);
				echo $result[0]['pattern_rule'];
			}
			else if($type == 7){
				$feature_values = FeatureValue::getFeatureValuesWithLang(true, $id_feature);
				echo Tools::jsonEncode($feature_values);
			}
			else if($type == 8){
				$feature_add = Feature::addFeatureImport($feature_name, false);
				if($feature_add){
					$feature_values = Vendor::getFeatureValuesWithLang(true, $feature_add);
					echo Tools::jsonEncode($feature_values);
				}
			}
			else if($type == 9){
				$taxes = TaxRulesGroup::getAssociatedTaxRatesByIdCountry(110);
				echo Tools::jsonEncode($taxes);
			}
			else if($type == 10){
				$result = Category::getAllCategories(1);
				echo Tools::jsonEncode($result);
			}
			else if($type == 11){
				$result = Feature::getAttributesWithCategory($id_category);
				echo Tools::jsonEncode($result);
			}
			else if($type == 12)
			{
				$result = array();
				$naming_rule = array();
				$category_features = Feature::getCategoryFeature($id_category);
				$category_naming_rule = Category::getNamingRuleForCategory($id_category);
				foreach ($category_naming_rule as $key => $value) {
					$naming_rule[$key] = $value[0];
				}
				array_push($result, $category_features, $naming_rule);
				echo Tools::jsonEncode($result);
			}
			else if($type == 13)
			{
				$result = Vendor::addPatternToCategory($pattern, $id_category);
				echo Tools::jsonEncode($result);
			}
			else if($type == 14)
			{
				$result = Vendor::addFeatureToCategory($id_feature, $id_category, $feature_required, $feature_status);
				echo Tools::jsonEncode($result);
			}
			else if($type == 15) // Approve and Reject section
			{ 
				foreach($product_array as $single_product)
				{
					if(!Vendor::isExistsProductState((int)$single_product, self::$cookie->id_employee, $id_state)){
						Vendor::addToProductHistory((int)$single_product, self::$cookie->id_employee, $id_state);
						if($live_state)
						{
							$product = new Product((int)($single_product));
							$product->active = 1;
							if($product->update())
							{
								Search::indexation(false,(int)($product->id));
								echo 0;
							}
						}
					}
					else {
						if(Vendor::addToProductHistory((int)$single_product, self::$cookie->id_employee, $id_state))
							echo 1;
					}
				}
			}
		}
	}
}