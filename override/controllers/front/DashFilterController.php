<?php
class DashFilterControllerCore extends DashController
{
	public function ajaxReturn()
	{
 		$type = Tools::getValue('type');
		$id_customer = $_POST['id_customer'];
	    $page_number = $_POST['pagenum'];
		$limit = $_POST['limit'];
		$category = $_POST['categoryId'];
		$brand = $_POST['brand'];
		$searchQuery = $_POST['searchQuery'];

		// For region selection
		if(isset($this->context->cookie->delivery_region) && $this->context->cookie->delivery_region != "")
			$fc = new FulfillmentCentre($this->context->cookie->delivery_region);

  	    if($type == 1)//Get the Filter and return the filter result
	    {
 			$categoriesId=array();
			$brandId=array();
			$priceId=array();
			foreach ($_POST AS $key => $val)
			{
 				if (preg_match('/^cat_([0-9]+)/i', $key))
				{	
					if($key!= "")
					{
						$result= explode("_",$key);
 						 array_push($categoriesId, $result[1]);
					}
				}	
				elseif (preg_match('/^brand_([0-9]+)/i', $key)) 	
				{	
					if($key!= "")
					{
						$brand_result= explode("_",$key);
  						 array_push($brandId,$brand_result[1]);
					}
				}
				
				
			}
			$priceValues=array("priceMin"=>$_POST['priceMin'],"priceMax"=> $_POST['priceMax']);
			$final_result=array();
  			if(sizeof($categoriesId)==0 && sizeof($brandId)==0  && $category !=0)
			{
 				array_push($categoriesId, $category);
			}
			if(sizeof($categoriesId)==0 && sizeof($brandId)==0  && $brand !=0)
			{
				array_push($brandId, $brand);
			}
			$dumpfilters=array("category"=>$categoriesId,"manufacturer"=>$brandId,"price"=>$priceValues);
 			$productList = Filter::getFilterValues($id_category,$id_customer,$page_number,$limit,$dumpfilters);
			if(sizeof($categoriesId)==0 && sizeof($brandId)==0  && $searchQuery)
			{
				$productList = Search::getProductIdFromQueryForFilter($searchQuery,$id_customer,$page_number,$limit,$priceValues);
			}

  			$product = new Product();
			
			$result = $product->getProductsPropertiesMini($id_lang=1, $productList['result']);

			// Budget configuration - purchase order object
	 	    if($this->context->cookie->budget_configured == 1) {
				$purchaseOrderObj = new PurchaseOrder();
				$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true);
	 	    }

			for ($k = 0; $k < sizeof($result); ++$k) {
				$productObj = new Product((int)($result[$k]['id_product']));
				$result[$k]['imageLink'] = self::$link->getImageLink($productObj->link_rewrite[1], $result[$k]['cover'], 'large');

				if(isset($fc)) {
					$result[$k]['available_in_selected_region'] = (int)$fc->getProductAvailable($result[$k]['id_product']);
					$result[$k]['selected_region_name'] = $fc->getStateNameByFc();
				}

				if($this->context->cookie->budget_configured == 1) {
					for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
						if($result[$k]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
							$result[$k]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
							$result[$k]['budget_product'] = 1;
						}
					}
				}
			}
			
   			$totalPage = ceil((int)$productList['total'] / $limit);
			$final_product_result = array();

			if($_POST['priceMax'] > 0) {
				for($i=0;$i<sizeof($result); $i++) {
					if($_POST['priceMax'] >= $result[$i]['price'] && $_POST['priceMin'] <= $result[$i]['price'])
					array_push($final_product_result,$result[$i]);
 				}	
			}
			else
				$final_product_result=$result;
			
 			array_push($final_result,$final_product_result,$totalPage);
  			echo Tools::jsonEncode($final_result); 
		}		
	}
}