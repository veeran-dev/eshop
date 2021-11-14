<?php
/**
 * Modified on: 5th August 2016
 * Author: Elumalai K
 * Changes: Pagination Variables, Variables camelCase used
*/

class DashDealsControllerCore extends DashController
{
	public function ajaxReturn()
	{	 
		global $cookie;
		$page = Tools::getValue('page');
		$specificPriceObj = new SpecificPrice();

		$deals_page = $page == 0 ? false : true;
		$products = $specificPriceObj->getDealProducts($deals_page);
		$customerProducts = $specificPriceObj->getPurchaseListData((int)$cookie->id_customer, false);
		
		$customerProductArray = array();
		$dealProducts = array();
		foreach ($customerProducts as $key => $value) {
			array_push($customerProductArray, $value['id_product']);
		}

		for($j = 1; $j < sizeof($products[3])+1; $j++)
		{
			for($i = 0; $i < sizeof($products[3][$j]); $i++)
			{
				if(!in_array($products[3][$j][$i]['id_product'], $customerProductArray))
				{
					$productObj = new Product($products[3][$j][$i]['id_product']);
					$images = $productObj->getImages(1);
					foreach ($images AS $k => $image){
						if ($image['cover']){
							$products[3][$j][$i]['cover'] = $productObj->id.'-'.$image['id_image'];
							break;
						}
					}

					if (!isset($products[3][$j][$i]['cover']))
						$products[3][$j][$i]['cover'] = Language::getIsoById((int)($cookie->id_lang)).'-default';

					$products[3][$j][$i]['imageLink'] = self::$link->getImageLink($products[3][$j][$i]['link_rewrite'], $products[3][$j][$i]['cover'], 'large');
					$products[3][$j][$i]['eliteDealProduct'] = true;
				}
				else{
					$products[3][$j][$i]['eliteDealProduct'] = false;
				}
			}
		}

 		echo Tools::jsonEncode($products);
	}
}