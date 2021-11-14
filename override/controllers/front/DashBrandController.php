<?php
class DashBrandControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;
	    $id_manufacturer = Tools::getValue('id_brand');
	    $type = Tools::getValue('type');
		$id_customer = Tools::getValue('id_customer');
		
		$page_number = (int)Tools::getValue('pagenum');
		$limit = Tools::getValue('limit');

		// For region selection
		if(isset($this->context->cookie->delivery_region) && $this->context->cookie->delivery_region != "")
			$fc = new FulfillmentCentre($this->context->cookie->delivery_region);
 
	    if($type == 1)//Get all products in particular category
	    {
			if((int)$id_customer ==0)
				$id_customer=0;
			
			$total_product_array=array();
			$product_array=array();
			$product_price=array();
			$filters=array();
			$result=array();
			
  			$brand= new Manufacturer();
			$brand_products = $brand->getManufacturerProductList($id_manufacturer,$id_customer,$page_number,$limit);
			
			$brandAllProducts=$brand->getAllProductsFromManufacturer($id_manufacturer);
 			$brand_products_total = ceil($brand_products['total'] / $limit);
			$brand_products_result = Product::getProductsPropertiesMini($id_lang=1, $brand_products['result']);
			$brand_product_price = Product::getProductsPropertiesMini($id_lang=1, $brandAllProducts);

			// Budget configuration - purchase order object
	 	    if($this->context->cookie->budget_configured == 1) {
				$purchaseOrderObj = new PurchaseOrder();
				$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true);
	 	    }

			for ($i = 0; $i < sizeof($brand_products_result); $i++)
			{
				if($this->context->cookie->budget_configured == 1) {
					for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
						if($brand_products_result[$i]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
							$brand_products_result[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
							$brand_products_result[$i]['budget_product'] = 1;
						}
					}
				}

				if(isset($fc)) {
					$brand_products_result[$i]['available_in_selected_region'] = (int)$fc->getProductAvailable($brand_products_result[$i]['id_product']);
					$brand_products_result[$i]['selected_region_name'] = $fc->getStateNameByFc();
				}
				
				array_push($product_array,$brand_products_result[$i]['id_product']);
 			}

  			for ($k = 0; $k < sizeof($brand_product_price); $k++)
			{
				array_push($total_product_array,$brand_product_price[$k]['id_product']);
				if($brand_product_price[$k]['price'] > 0)
 					array_push($product_price,$brand_product_price[$k]['price']);
			}

  			$manufacturer_filter =Manufacturer::getManufactureIdFromProductId($product_array);
			$category_filter =Category::getCategoryIdFromProductId($total_product_array);
			if(sizeof($brand_products) > 0 ) {
				$price_filter = array("min"=>round(min($product_price)),"max"=>round(max($product_price)));
			}
			else {
				$price_filter = array("min"=>"0" , "max"=>"0");
			}

 			array_push($filters,$category_filter,$manufacturer_filter,$price_filter);
			array_push($result,$filters,$brand_products_result,$brand_products_total);

     		echo Tools::jsonEncode($result);
		}
		else if($type == 2) {
			$manufacturerName = Manufacturer::getNameById($id_manufacturer);
			echo Tools::jsonEncode($manufacturerName);
		}
		
	}

	
}