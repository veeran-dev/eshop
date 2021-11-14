<?php
include_once(dirname(__FILE__).'/../../../modules/blocklayered/blocklayered.php');
class DashCategoryControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;
 	    $id_category = Tools::getValue('id_category');
 	    $id_manufacturer = Tools::getValue('id_manufacturer');
	    $id_price = Tools::getValue('price');
	    $type = Tools::getValue('type');
	    $id_customer = Tools::getValue('id_customer');
	    $page_number = Tools::getValue('pagenum');
		$limit = Tools::getValue('limit');
		 
		// For region selection
		if(isset($this->context->cookie->delivery_region) && $this->context->cookie->delivery_region != "")
			$fc = new FulfillmentCentre($this->context->cookie->delivery_region);

 	    if($type == 1)//Get all products in particular category
	    {
			$category= new Category();
			if($id_customer=="" ||(int)$id_customer == 0 )
				$id_customer = 0;
			$priceRange=array();
			if($limit =="")
				$limit = 20;
 			$category_products = $category->getProductListInCategory($id_category,$id_customer,$page_number,$limit);
			$allProductsInCategory = $category->getAllProductsInCategory($id_category);
			//var_dump($category_products);
			$category_products_total = ceil($category_products['total'] / $limit);
 			$product=New Product();
  			$category_products= $product->getProductsPropertiesMini($id_lang=1, $category_products['result']);
  			$allProductsInCategoryProperties= $product->getProductsPropertiesMini($id_lang=1, $category_products);
			/*for($k=0;$k<sizeof($category_products); $k++)
			{
				array_push($priceRange,$category_products[$k]['price']);
			}*/
			//var_dump($priceRange);
			/*$priceMin = min($priceRange);
			$priceMax = max($priceRange);*/
		 

  			$result = array();
		  /* $filterArray =array('manufacturer','category');
		   $blocklayered = new BlockLayered();
 		   $filter = $blocklayered->getFilterBlock($filterArray);
		 
			for($i=2; $i<sizeof($filter['filters']); $i++)
			{
				if($id_customer !=0)
				{
					$filter['filters'][$i]['min']=round($priceMin);
					$filter['filters'][$i]['max']=round($priceMax);
				}
				else
				{
					$filter['filters'][$i]['min']=$filter['filters'][$i]['values']['0'];
					$filter['filters'][$i]['max']=$filter['filters'][$i]['values']['1'];
				}
 				
				
				
				
			}
 			foreach( $filter as &$arr ) {
			  $arr["filter_name"] = $arr['name'];
			  unset( $arr['name'] );
			   
			} */
			$total_product_array=array();
			$product_array=array();
			$product_price=array();
			$filters=array();

			// Budget configuration - purchase order object
	 	    if($this->context->cookie->budget_configured == 1) {
				$purchaseOrderObj = new PurchaseOrder();
				$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true);
	 	    }
			
			for ($i = 0; $i < sizeof($category_products); $i++)
			{
				if($this->context->cookie->budget_configured == 1) {
					for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
						if($category_products[$i]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
							$category_products[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
							$category_products[$i]['budget_product'] = 1;
						}
					}
				}

				if(isset($fc)) {
					$category_products[$i]['available_in_selected_region'] = (int)$fc->getProductAvailable($category_products[$i]['id_product']);
					$category_products[$i]['selected_region_name'] = $fc->getStateNameByFc();
				}

				array_push($product_array,$category_products[$i]['id_product']);
 			}

			for ($k = 0; $k < sizeof($allProductsInCategoryProperties); $k++)
			{
				array_push($total_product_array,$allProductsInCategoryProperties[$k]['id_product']);
				if($allProductsInCategoryProperties[$k]['price'] > 0)
 					array_push($product_price,$allProductsInCategoryProperties[$k]['price']);
			}
			
			$manufacturer_filter =Manufacturer::getManufactureIdFromProductId($product_array);
			$category_filter =Category::getCategoryIdFromProductId($total_product_array);
			if(sizeof($category_products) > 0 )
				$price_filter = array("min"=>round(min($product_price)),"max"=>round(max($product_price)));
			else
				$price_filter = array("min"=>"0" , "max"=>"0");
			array_push($filters,$category_filter,$manufacturer_filter,$price_filter);
     		array_push($result,$filters,$category_products,$category_products_total);
      		echo Tools::jsonEncode($result);
		}
		else if($type == 2) {
			$categoryObj = new Category((int)($id_category));
			$categoryName = $categoryObj->getName();
			echo Tools::jsonEncode($categoryName);
		}
		
	}

	 

}