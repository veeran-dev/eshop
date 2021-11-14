<?php
class DashCartControllerCore extends DashController
{
	public function ajaxReturn()
	{
 		$type = Tools::getValue('type');
 		$returnCartSummary = Tools::getValue('cartSummary');

 		if($type == 1)
        {
            $cart = new Cart($this->context->cookie->id_cart);
			$result = $cart->deleteAssociations();			 
            echo $result ;
        }
		else if($type == 0)
		{
			$products = $this->context->cart->getProducts(true);
			$useTax = true;
			$shippingPrice = Tools::displayPrice($this->context->cart->getOrderTotal($useTax, Cart::ONLY_SHIPPING));
			$price = ($this->context->cart->getOrderTotal(true));
			include_once(dirname(__FILE__).'/../../../modules/loyalty/LoyaltyModule.php');
			$points_product = LoyaltyModule::getCartNbPoints($this->context->cart);
			$totalPrice = Tools::displayPrice($this->context->cart->getOrderTotal(true));
			$totalTax = $this->context->cart->getOrderTotal(true)-$this->context->cart->getOrderTotal(false);
			$discount = $this->context->cart->getDiscounts(false,true);

			//var_dump($discount);
			$corporateuser = new CorporateUser();
			$start_memory = memory_get_usage();
			$currency = Currency::getCurrent();

			$totalTax = Product::convertAndFormatPrice($totalTax,$currency);

			if($this->context->cookie->budget_configured == 1) {
				$purchaseOrderObj = new PurchaseOrder();
				$purchaseOrderProductDetail = $purchaseOrderObj->getPurchaseOrderProducts($this->context->cookie->id_address_budget, $this->context->cookie->budget_option, true);
				for ($i = 0; $i < sizeof($purchaseOrderProductDetail); $i++) {
					for ($j = 0; $j < sizeof($products); $j++) {
						if($products[$j]['id_product'] == $purchaseOrderProductDetail[$i]['id_product'])
							$products[$j]['available_budget_quantity'] = $purchaseOrderProductDetail[$i]['available_quantity'];
					}
				}
			}
			
			
			$discount_vouchers = Discount::getVouchersToCartDisplay((int)($this->context->cookie->id_lang), (isset($this->context->cookie->id_customer) ? (int)($this->context->cookie->id_customer) : 0));
			$current_used_voucher = $this->context->cart->getDiscounts(false,true);

			for($i=0; sizeof($discount) >$i; $i++ )
			{
				$cartrule = new CartRule($discount[$i]['id_cart_rule'],1);
				//var_dump($cartrule);
				$discount[$i]['value']=$cartrule->getContextualValue(true);
				//$discount_vouchers[$i]['discount_value']=Tools::displayPrice($discount_vouchers[$i]['value']);
			}
			
			/** Sale status **/
			$saleStatus = $this->getShopSaleStatus();
			if($saleStatus != 1)
				$getimagelink = $corporateuser->getProductImageLink($products,$shippingPrice,$totalPrice,$totalTax,$discount,$points_product);
			else{
				$result = array('saleStatus' => $saleStatus);
				echo Tools::jsonEncode($result);
			}

			$logger = new FileLogger();
			$logger->setFilename('log-files/'.$this->context->cookie->id_customer.'-'.$this->context->cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".$this->context->cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	
		}
		else if($type == 3) 
		{
			$products = $this->context->cart->getProducts(true);
			// var_dump($products);
			$useTax = true;
			$shippingPrice = Tools::displayPrice($this->context->cart->getOrderTotal($useTax, Cart::ONLY_SHIPPING));
			$price = ($this->context->cart->getOrderTotal(true));
			include_once(dirname(__FILE__).'/../../../modules/loyalty/LoyaltyModule.php');
			$points_product = LoyaltyModule::getCartNbPoints($this->context->cart);
			$totalPrice = Tools::displayPrice($this->context->cart->getOrderTotal(true));
			$totalTax = $this->context->cart->getOrderTotal(true)-$this->context->cart->getOrderTotal(false);
			$discount = $this->context->cart->getDiscounts(false,true);
			
			$start_memory = memory_get_usage();

			$currency = Currency::getCurrent();

			$totalTax = Product::convertAndFormatPrice($totalTax,$currency);

			if($returnCartSummary){
				$result = array();
				$result['shippingPrice'] = $shippingPrice;
				$result['totalTax'] = $totalTax;
				$result['totalPrice'] = $totalPrice;
				$result['discounts'] = $discount;
				$result['loyaltyPoints'] = $points_product;
				$result['totalProducts'] = count($products);
				echo Tools::jsonEncode($result);
			}
		}
		else if($type == 4) { // For RM portal
			$products = $this->context->cart->getProducts(true);
			$useTax = true;
			$shippingPrice = Tools::displayPrice($this->context->cart->getOrderTotal($useTax, Cart::ONLY_SHIPPING));
			$price = ($this->context->cart->getOrderTotal(true));
			include_once(dirname(__FILE__).'/../../../modules/loyalty/LoyaltyModule.php');
			$points_product = LoyaltyModule::getCartNbPoints($this->context->cart);
			$totalPrice = Tools::displayPrice($this->context->cart->getOrderTotal(true));
			$totalTax = $this->context->cart->getOrderTotal(true)-$this->context->cart->getOrderTotal(false);
			$discount = $this->context->cart->getDiscounts(false,true);

			//var_dump($discount);
			$corporateuser = new CorporateUser();
			$start_memory = memory_get_usage();
			$currency = Currency::getCurrent();

			$totalTax = Product::convertAndFormatPrice($totalTax,$currency);

			/*for($i = 0;$i < sizeof($discount);$i++)
			$discount[$i]['value'] = Product::convertAndFormatPrice($discount[$i]['value'],$currency);*/
			if(isset($this->context->cookie->id_customer))
				$customerObj = new Customer((int)($this->context->cookie->id_customer));
			
			
			$discount_vouchers = Discount::getVouchersToCartDisplay((int)($this->context->cookie->id_lang), (isset($this->context->cookie->id_customer) ? (int)($this->context->cookie->id_customer) : 0));
			$current_used_voucher = $this->context->cart->getDiscounts(false,true);

			for($i=0; sizeof($discount) >$i; $i++ )
			{
				$cartrule = new CartRule($discount[$i]['id_cart_rule'],1);
				//var_dump($cartrule);
				$discount[$i]['value']=$cartrule->getContextualValue(true);
				//$discount_vouchers[$i]['discount_value']=Tools::displayPrice($discount_vouchers[$i]['value']);
			}
			
			if($customerObj->secure_key == $this->context->cart->secure_key)
				$getimagelink = $corporateuser->getProductImageLink($products,$shippingPrice,$totalPrice,$totalTax,$discount,$points_product);
			else
				echo Tools::jsonEncode(array());
		}
	}

	public function setCustomerId()
	{
 		$type = Tools::getValue('type');
 		$id_employee = Tools::getValue('id_employee');
		
		
 		if (!$this->context->initialized)
			$this->init();
		
		if($type == 1)
		{
			$id_customer = Tools::getValue('id_customer');
 			$this->context->cookie->id_customer = $id_customer;
			$customer = new Customer($id_customer);
			$this->context->cookie->role = $customer->getCustomerRole();				
			$credit_days = new Group((int)($customer->id_default_group));
 			$this->context->cookie->credit_days = (int)$credit_days->credit_days;
 			$last_non_ordered = $this->context->cart->lastNoneOrderedCart(intval($id_customer));

 			if(isset($id_employee) && $id_employee) {
 				$this->context->cookie->id_employee = $id_employee;
 			}

 			if(!$last_non_ordered) {
 				$this->context->cart->add();
 				$this->context->cart->secure_key = $customer->secure_key;
 				$this->context->cart->update();
 				$this->context->cookie->id_cart = $this->context->cart->id;
 				$this->context->cart->id_customer = $id_customer;
 			}
 			else {
 				$this->context->cookie->id_cart = $last_non_ordered;
 			}
		}
		else
		{
  			$this->context->cookie->id_group = $_POST['id_group'];
 			$this->context->cookie->id_state = $_POST['id_state'];
 			$this->context->cookie->id_state_vat = $_POST['id_state'];
 		}

		return true;
	}
	 
}