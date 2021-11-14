<?php 
include_once(dirname(__FILE__).'/../../../modules/loyalty/LoyaltyModule.php');

class DashPurchaseControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		global $cookie, $cart;
		$type = Tools::getValue('type');
		$cus_id = Tools::getValue('id_customer');
		$list_id = Tools::getValue('list_id');
		$productarray = Tools::getValue('productarray');
		$listStatus = Tools::getValue('listStatus'); 
		$PurchaseList = new PurchaseList();
		$delproduct = Tools::getValue('rate_contract_id'); 
		$customer_email = Tools::getValue('customer_email'); 
		$Product = new Product();
 		$start_memory = memory_get_usage();
		$quick_idProduct = Tools::getValue('quick_idProduct');
		$quick_qty = Tools::getValue('quick_qty');
		$product_id = Tools::getValue('product_id');
		$setcookie = Tools::getValue('setcookie');
		$Pagination = Tools::getValue('Pagination');
 		$supplier_id = Tools::getValue('supplier_id');
 		$search_word = Tools::getValue('search_key_word');
 		$id_order = Tools::getValue('id_order');
 		$category_id = Tools::getValue('category_id');
		
		if($setcookie == 1)
			self::$cookie->id_customer = $cus_id;
		
		$specificprice = new SpecificPrice();
				 
	 	/*This is used to get all the products from the purchaselist according to purchaselist id */	
	   	if( $type == 1 || $type == 10 )
		{
			
			$list_products = PurchaseList::getProductByIdCustomer( 
																	$list_id, 
																	$cus_id, 
																	$id_lang = 1, 
																	$id_product = null, 
																	$quantity = false
																);
			
	 		$products = Product::getProductsProperties($id_lang=1, $list_products);

			$link = new Link();

	 		for ($i = 0; $i < sizeof($products); ++$i) 
	 		{
				$products[$i]['tax_value'] = Tax::getProductTaxRate($products[$i]['id_product'],$cart->id_address_delivery);
				$obj = new Product((int)($products[$i]['id_product']), false, (int)($cookie->id_lang));

				if (!Validate::isLoadedObject($obj))
					continue;
				else
				{
					if ($products[$i]['id_product_attribute'] != 0 && isset($combination_imgs[$products[$i]['id_product_attribute']][0]))
					{
						$combination_imgs = $obj->getCombinationImages((int)($cookie->id_lang));
						$products[$i]['cover'] = $obj->id.'-'.$combination_imgs[$products[$i]['id_product_attribute']][0]['id_image'];
					}
					else
					{
						$images = $obj->getImages((int)($cookie->id_lang));
						foreach ($images AS $k => $image)
							if ($image['cover'])
							{
								$products[$i]['cover'] = $obj->id.'-'.$image['id_image'];
								break;
							}
							
					}

					if (!isset($products[$i]['cover']))
						$products[$i]['cover'] = Language::getIsoById($cookie->id_lang).'-default';
											
 					$imagelink = $link->getImageLink($products[$i]['link_rewrite'], $products[$i]['cover'],'large');

 					
					$image_link = array_push($products[$i],$imagelink);					
				}
			}

			$price = array();	
			$priceDisplayValue = Product::getTaxCalculationMethod();

			if(!$priceDisplayValue || $priceDisplayValue == 2)
				$tax = true;
			elseif($priceDisplayValue == 1)
				$tax = false;
 			
			foreach($products as $product)
			{
				$useProduct = new Product($product['id_product']);
				$price[] = $useProduct->getPrice($tax);
			}

			for($i=0; $i < sizeof($products); $i++)
			{
				$points_product = LoyaltyModule::getNbPointsByPrice($price[$i]);
				array_push($products[$i],$price[$i],$points_product);
			}

			echo Tools::jsonEncode($products);
	 			
		}
		else if($type == 9) 
		{
			$listProducts = SpecificPrice::getCustomerProductList($cus_id, $Pagination, $supplier_id, $search_word, null, null, $category_id);
			$products = Product::getProductsPropertiesSupplier(1, $listProducts);
			$productCategories = array();
			array_push($productCategories, $products, sizeof($products));
			echo Tools::jsonEncode($productCategories);
		}
		/*this is use to save or add to cart the products from the purchase list to the shopping cart*/
		else if($type == 2 )//type 2 is jsut ass the product qty in DB and type 4 is add the products in cart
	 	{
		 	$productarray = explode(",",$productarray);
			$final_result = array();

			for ($i = 0; sizeof($productarray) > $i; $i++ ) {
			    $productarray[$i] = explode("-", $productarray[$i]);
				$id_supplier_product = $productarray[$i][0];
				$product_supplier = explode("_", $id_supplier_product);
				$idSupplier = $product_supplier[0];
				$idProduct = $product_supplier[1];				
				$qty = $productarray[$i][1];
				$result = ControllerFactory::getController('CartController')->mulProductAdd(0, $idProduct, $idSupplier, $qty);
				if($result != "")
					array_push($final_result, $result);
  			}

			echo Tools::jsonEncode($final_result);		
		}
		/*this is use to get the list of purchaselist according to the customer id*/
		else if($type == 3)
		{
	  		$purchaselist = PurchaseList::getByIdCustomer($cus_id);
	  		echo Tools::jsonEncode($purchaselist);
	 	}
		else if($type == 7)//this process is done for quick buy order place
		{
			/*Function changed-> assembla ticket->28*/
			/*Skipped function-> not saved in array and its directly getting added to cart*/
			$result = ControllerFactory::getController('CartController')->mulProductAdd(0, $quick_idProduct, $quick_qty);
			echo Tools::jsonEncode($result);
	 	}
		else if($type == 5)//To delete particular product from purchaselist
		{	
	 	 	 $result = RelationshipManager::deleteRateContractProduct($list_id,$delproduct);
			 echo $result;
		}
		/*from product.js to get the customer buyer id*/
		else if($type == 6)
		{
	 		$Customer = new Customer();
			$id_buyer = Customer::getBuyerId($customer_email);
	 		echo $id_buyer;
		}
		else if($type == 8)
		{
			global $cookie;
			$rate = new RateContract();
			$addinlist = $rate->toCheckProductInList($product_id,$cus_id);
			$result = Product::getProductQuickviewDetails($product_id);
	 		$products = Product::getProductProperties($id_lang=1, $result);
			$products['price'] = Tools::displayPrice($products['price']);
			$products['price_tax_exc'] = Tools::displayPrice($products['price_tax_exc']);
			$products['price_without_reduction'] = Tools::displayPrice(Product::getPriceStatic((int)$products['id_product'], true, NULL, 6, NULL, false, false));		

			$manufacturer = new Manufacturer($result['id_manufacturer']);
			$mname = $manufacturer->name;
			$cover = Product::getCover((int)$product_id);
			$img_id = $product_id.'-'.$cover['id_image'];
			$link = new Link();

			if(!$cover['id_image'])
				$img_id=Language::getIsoById((int)($cookie->id_lang)).'-default';

			$imagelink = $link->getImageLink($result.name,$img_id,'large');
			$imagelink = 'http://'.$imagelink;
			
			array_push($result,$imagelink,$mname,$addinlist,$products['price'],$products['price_tax_exc'],$products['price_without_reduction']);
			
	        echo Tools::jsonEncode($result);
		}
		else if($type == 11)
		{
			$specificPriceObj = new SpecificPrice();
			$listCategory = $specificPriceObj->getSpecificPriceProductCategories($cus_id);

			echo Tools::jsonEncode($listCategory);
		}
		else if($type == 12) {
			$customerObj = new Customer((int)($cus_id));
			$groupObj = new Group((int)($customerObj->id_default_group));
			echo Tools::jsonEncode($groupObj);
		}
		else if($type == 13) {
			$order = new Order(intval($id_order));
			$order_placed_status = true;
			if($order->payment == 'PENDING FOR APPROVAL') {
				$order_placed_status = false;
			}
			echo Tools::jsonEncode($order_placed_status);
		}
		else if($type == 14) {
			$order = new Order(intval($id_order));
			$customer = new Customer(intval($order->id_customer));
			echo Tools::jsonEncode($customer->checkCustomercredibility($order->id));
		}
		else if($type == 15){
			$specificPriceObj = new SpecificPrice();
			$supplierProducts = $specificPriceObj->getSuppliers($cus_id);
			echo Tools::jsonEncode($supplierProducts);
		}
	}
}