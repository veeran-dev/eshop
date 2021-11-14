<?php 
class DashShoppingCartControllerCore extends DashController
{
	public function ajaxReturn()
	{	
		$type = Tools::getValue('type');

	 	if($type == 1)// get the voucher code 
		{
			$id_customer = Tools::getValue('id_customer');

			$loyaltyObj = new LoyaltyPoints();
			$loyaltypts = $loyaltyObj->getPointsByCustomer($id_customer);
	 		
			$result = array();
	 		$discount_vouchers_array = CartRule::getCustomerCartRules((int)(self::$cookie->id_lang), (isset(self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0), true, true, true, null, false, true);
			
			$discount_vouchers = array();

			foreach($discount_vouchers_array as $dva)
				if(!empty($dva))
					array_push($discount_vouchers,$dva);


	 		$current_used_voucher = self::$cart->getDiscounts(false,true);

			for($i = 0; sizeof($discount_vouchers) > $i; $i++ ) {
	 			$cartrule = new CartRule($discount_vouchers[$i]['id_cart_rule'],1);
				$discount_vouchers[$i]['discount_value'] = $cartrule->getContextualValue(true);
			}

			array_push($result, $discount_vouchers, $current_used_voucher, $loyaltypts);

			echo Tools::jsonEncode($result);	 
		}
	 	else if($type == 2) 
	 	{
 		    $discountName = Tools::getValue('discount_name');
		    $id_discount = Tools::getValue('id_discount');

		    $logger = new FileLogger();
			$logger->setFilename('test1.txt');
			
 			if($id_discount == 0)
				$discount = new Discount((int)(Discount::getIdByName($discountName)));
			else
				$discount = new Discount($id_discount);

			$logger->logError("-------approver pagination discount--------");
			
			$result ="";

 			if (Validate::isLoadedObject($discount)) {
				if ($tmpError = self::$cart->checkDiscountValidity($discount, self::$cart->getDiscounts(), self::$cart->getOrderTotal(), self::$cart->getProducts(), true))
					$result = $tmpError;
			}
			else {
				$result = "Voucher code invalid.";
			}

			if ($result == "") {
				$result = array();
				
				if(self::$cart->getOrderTotal() > $discount->reduction_amount) {
					self::$cart->addDiscount((int)($discount->id));
					$res = "success";
				}
				else {
					$res = "Discount amount exceeds total shopping value.";
				}

				array_push($result, $res, $discountName, Discount::getIdByName($discountName));
			}

 			echo Tools::jsonEncode($result);
		}
		else if($type == 3) 
		{
			$id_discount = Tools::getValue('id_discount');
			self::$cart->deleteDiscount($id_discount);
		}
		else if($type == 4) 
		{
			$id_discount = Tools::getValue('id_discount');	 
		}
		else if($type == 7) 
		{
			$productarray = Tools::getValue('productarray');
			for ($i = 0; sizeof($productarray["productarray"]) > $i; $i++) {
				$idProduct = $productarray["productarray"][$i]['idProduct'];
				$qty = $productarray["productarray"][$i]['quantity'];
				$id_supplier = $productarray['productarray'][$i]['id_supplier'];
				ControllerFactory::getController('CartController')->mulProductAdd(0, $idProduct, $id_supplier, $qty);
			}
		}
		else if($type == 8) //this process is done for shopping summary change in quantity
		{ 
			$productarray = Tools::getValue('productarray');
			$id_customer = Tools::getValue('id_customer');

			$productarray = explode(",",$productarray);

			for ($i = 0; sizeof($productarray) > $i; $i++) {
				$productarray[$i] = explode("-",$productarray[$i]);
				$logger = new FileLogger();
				$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
				$idProduct = $productarray[$i][0];
				$qty = $productarray[$i][1];
				ControllerFactory::getController('CartController')->mulProductAdd(0,$idProduct,$qty);
			}
		}
	}
 }