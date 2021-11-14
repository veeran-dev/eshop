<?php
include_once(dirname(__FILE__).'/../../../modules/blocklayered/blocklayered.php');
class DashSearchAllProductControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;
	    $q = Tools::getValue('search_query');
	    $mode = Tools::getValue('mode');
	    $pagenumber = Tools::getValue('pagenum');
	    $customerid = Tools::getValue('id_customer');
	    $type = Tools::getValue('type');
	    $limit = Tools::getValue('limit');

	    $limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 20);

	    // For region selection
		if(isset($this->context->cookie->delivery_region) && $this->context->cookie->delivery_region != "")
			$fc = new FulfillmentCentre($this->context->cookie->delivery_region);
		
 	    if($type == 0)
	    {
 		    $imageObj = new Image();
			$product_array=array();
			$product_price=array();
			$filters=array();
			$result=array();
			$linkObj = new Link();
		    //$searchResults = Search::find($this->context->language->id, $q, $pagenumber, PAGE_PER_NO, 'position', 'desc', true, false, null, null, $customerid);
		    $searchResults = Search::customAllSearch($q,$customerid,$pagenumber,$limit);
			
	 	    $products = Product::getProductsPropertiesMini($id_lang=1, $searchResults['result']);
 			
	 	    $count = ceil((int)sizeof($searchResults['filter_data']) / PAGE_PER_NO);

	 	    // Budget configuration - purchase order object
	 	    if($this->context->cookie->budget_configured == 1) {
				$purchaseOrderObj = new PurchaseOrder();
				$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true);
	 	    }

		    for ($i = 0; $i < sizeof($products); ++$i)
			{
				
				$products[$i]['count'] = $count;
				$productObj = new Product((int)($products[$i]['id_product']));
				
				$coverImage = $imageObj->getCover($productObj->id);
				$products[$i]['cover'] = $productObj->id.'-'.$coverImage['id_image'];
					
				if (!$coverImage['id_image'])
					$products[$i]['cover'] = Language::getIsoById((int)($cookie->id_lang)).'-default';

				$products[$i]['imageLink'] = $linkObj->getImageLink($productObj->link_rewrite[1], $products[$i]['cover'], 'large');
					 
				$products[$i]['minimal_quantity'] = $productObj->minimal_quantity;
				$products[$i]['name']= $products[$i]['pname'];

				if(isset($fc)) {
					$products[$i]['available_in_selected_region'] = (int)$fc->getProductAvailable($productObj->id);
					$products[$i]['selected_region_name'] = $fc->getStateNameByFc();
				}
				
				if($products[$i]['price'] > 0)
					array_push($product_price,$products[$i]['price']);

				if($this->context->cookie->budget_configured == 1) {
					for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
						if($products[$i]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
							$products[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
							$products[$i]['budget_product'] = 1;
						}
					}
				}
				
			}

			for($k = 0; $k <sizeof($searchResults['filter_data']); $k++)				
			{
				array_push($product_array,$searchResults['filter_data'][$k]['id_product']);
				
			}
			
			if(!empty($product_array)) {
				$category_filter = Category::getCategoryIdFromProductId($product_array);
				$manufacturer_filter = Manufacturer::getManufactureIdFromProductId($product_array);
			}
			
 			$price_filter = array("min"=>round(min($product_price)),"max"=>round(max($product_price)));
			array_push($filters,$category_filter,$manufacturer_filter,$price_filter);
			array_push($result,$filters,$products,$count);
   			echo Tools::jsonEncode($result);
		}
		else if($type == 1)
		{
			global $cookie;
			$id_product = Tools::getValue('id_product');
			$id_customer = Tools::getValue('id_customer');
			$id_supplier = Tools::getValue('id_supplier');

			$result = Product::getProductQuickviewDetails($id_product, $id_supplier, $id_customer);
			$products = Product::getProductsPropertiesSupplier(1, $result);

			for ($i = 0; $i < sizeof($products); ++$i)
			{
				$productObj = new Product((int)($products[$i]['id_product']));
				$imageObj = new Image();
				$coverImage = $imageObj->getCover($productObj->id);
				$products[$i]['cover'] = $productObj->id.'-'.$coverImage['id_image'];

				if(isset($fc)) {
					$products[$i]['available_in_selected_region'] = (int)$fc->getProductAvailable($productObj->id);
					$products[$i]['selected_region_name'] = $fc->getStateNameByFc();
				}
					
				if (!$coverImage['id_image'])
					$products[$i]['cover'] = Language::getIsoById((int)($cookie->id_lang)).'-default';

				$products[$i]['imageLink'] = self::$link->getImageLink($productObj->link_rewrite[1], $products[$i]['cover'], 'large');


				// Budget configuration - purchase order object
		 	    if($this->context->cookie->budget_configured == 1) {
		 	    	$purchaseOrderObj = new PurchaseOrder();
					$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true, $id_product);
					if($products[$i]['id_product'] == $purchaseOrderProducts[$i]['id_product']) {
						$products[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$i]['available_quantity'];
						$products[$i]['budget_product'] = 1;
					}
		 	    }
			}
			
			echo Tools::jsonEncode($products);
		}
	}

	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display('dash/dash-search.tpl');
	}

}