<?php
class B2cStateControllerCore extends FrontController
{
	public function getStates()
	{
		parent::init();

		$type = Tools::getValue('type');
 		$state = new State();

 		global $cookie;
		global $cart;
		
		if($type == 1)
		{
			$statename = State::getStatesByIdCountry((int)Country::getDefaultCountryId());
			echo Tools::jsonEncode($statename);
		}
		else if($type == 2)
		{	
			$set = Tools::getValue('set');
			$stateId = Tools::getValue('stateId');
 			$this->context->cookie->id_state_vat = $stateId;
			$this->context->cookie->name_state_vat = Tools::getValue('stateName');
			if($set == 1)
			{
				$id_address = $state->getaddresbystate($stateId);				
				$this->context->cart->id_address_delivery = $id_address[0]['id_address'];
				$this->context->cart->id_address_invoice = $id_address[0]['id_address'];
				$this->context->cart->update();
			}

			if($this->context->cookie->id_state_vat)
				echo Tools::jsonEncode($stateId);
		}
		else if($type == 3)
		{
			$this->context->cookie->elite = 1;

			$result = array();

			if($this->context->cookie->budget_configured == 1) 
			{
				$customerObj = new Customer((int)($this->context->cookie->id_customer));
				$result = $customerObj->getAddresses(1);
			}
			else 
			{
				$states = $state->getstatesofcustomerWithCount($this->context->cookie->id_customer);

				if(empty($states)) {
					$result = $state->getStatesByIdCountry((int)Country::getDefaultCountryId());
				}
				else if(count($states) > 1) { // If having state
					$result = $states;
				}
			}

			echo Tools::jsonEncode($result);
		}
		else if($type == 4) 
		{
			$idAddress = Tools::getValue('id_address');
			$id_purchase_order = Tools::getValue('id_purchase_order');
			$address = new Address(intval($idAddress));
			$purchaseOrderObj = new PurchaseOrder();
			$response = array('data' => '', 'error' => '', 'type' => 0);

			if(!$this->context) {
				$this->context = Context::getContext();
			}

			if($purchaseOrderObj->isAddressPoConfigured((int)($address->id), $this->context->cookie->budget_option, true)) {
				$stateObj = new State(intval($address->id_state));
				
				if($this->context->cookie->delivery_region != (int)$stateObj->getFcIdByState()) {
	 				$cart = new Cart($this->context->cookie->id_cart);
	 				$cart->deleteAssociations();
	 			}
	 			
	 			$old_address = $this->context->cart->id_address_delivery;
	 			$this->context->cart->id_address_delivery = $address->id;
	 			$this->context->cart->update();
	 			
	 			if(isset($id_purchase_order) && $id_purchase_order) { //Setting purchase order id tio cookie
					$purchaseOrderObj = new PurchaseOrder($id_purchase_order);
					$purchaseOrderValues = $purchaseOrderObj->getPurchaseOrderValues((int)($address->id), $this->context->cookie->budget_option, true);
					$cartProducts = $this->context->cart->getProducts();
					$cartTotal = 0;
					foreach ($cartProducts as $key => $product) {
						$cartTotal += $product['total_wt'];
					}

					if(date('Y-m-d H:i:s', strtotime($purchaseOrderObj->valid_from)) > date('Y-m-d H:i:s') && sizeof($cartProducts) > 0) {
						$response['error'] = 'PO is valid from '.$purchaseOrderObj->valid_from.'. Please select other PO to proceed.';
						$response['type'] = 3;
					}
					else if($purchaseOrderValues[0]['available_value'] < $cartTotal) {
						$response['error'] = 'PO expense limit is less than cart value. Please select other PO to proceed.';
						$response['type'] = 2;
					}

					if($response['error'] != "") {
						$this->context->cart->id_address_delivery = $old_address;
						$this->context->cart->update();
						die(Tools::jsonEncode($response));
					}
					
	 				$this->context->cookie->id_purchase_order = $id_purchase_order;
	 				$this->context->cookie->po_number = $purchaseOrderObj->po_number;
	 			}

	 			$this->context->cookie->id_address_budget = $address->id;
	 			$this->context->cookie->id_address_delivery = $address->id;

	 			$this->context->cookie->delivery_region = $stateObj->getFcIdByState();
	 			$this->context->cookie->id_state = $stateObj->id;
	 			$this->context->cookie->delivery_region_name = $stateObj->name;
				$this->context->cookie->name_state_vat = Tools::getValue('addressName');
				
				die(Tools::jsonEncode($response));
			}
			else {
				echo "PO is not configured/expired.";
			}
		}
		else if($type == 5) {
			// Get state ID as input and process with FC
			$delivery_region = Tools::getValue('delivery_region');
			$reorder = Tools::getValue('id_order');
			$id_customer = Tools::getValue('id_customer');
			$rm_request_no_delete = Tools::getValue('rm_request_no_delete');
			$stateObj = new State(intval($delivery_region));
			$fc = new FulfillmentCentre(intval($stateObj->getFcIdByState()));			
			
			if(!$this->context) {
				$this->context = Context::getContext();
			} 

			if(isset($id_customer) && $id_customer != "")
				$this->context->cookie->id_customer = $id_customer;

			if(isset($this->context->cookie->delivery_region) && $this->context->cookie->delivery_region) {
				if($this->context->cookie->delivery_region != (int)$stateObj->getFcIdByState()) {
	 				$cart = new Cart($this->context->cookie->id_cart);
	 				$result = $cart->deleteAssociations();
	 			}
			}

			
			if(!$reorder) {
				$this->context->cookie->delivery_region = $stateObj->getFcIdByState(); // Set cookie for delivery region
				$this->context->cookie->id_state = $stateObj->id;
				$this->context->cookie->delivery_region_name = $stateObj->name;
				$id_address = $state->getaddresbystate($delivery_region);				
				$this->context->cart->id_address_delivery = $id_address[0]['id_address'];
	 			$this->context->cart->update();
				echo 1;
			}
			else {
				$order = new Order(intval($reorder));
				$order_detail = $order->getOrderDetailList();
				$cart = new Cart($order->getCartIdStatic((int)$reorder, (int)$order->id_customer));
				$supplier_id = $order->getSupplier();
	 			$product = $cart->getReorderProducts($cart->id, $supplier_id);
	 			$address = new Address(intval($order->id_address_delivery));
	 			$state = new State(intval($address->id_state));

	 			if($address->id_state != $stateObj->id) {
	 				die(Tools::jsonEncode(array( 'msg' => 'Order contains supplier from '.$state->name.' state. Please change the state to proceed.', 'error' => true)));
	 			}

	 			// if(!sizeof($order_detail)) {
	 			// 	die(Tools::jsonEncode(array( 'msg' => 'Order should contains atleast one product to reorder.', 'error' => true)));
	 			// }

 				$this->context->cookie->delivery_region = $stateObj->getFcIdByState(); // Set cookie for delivery region
				$this->context->cookie->id_state = $stateObj->id;
				$this->context->cookie->delivery_region_name = $stateObj->name;

				$this->context->cart->id_address_delivery = $order->id_address_delivery;
	 			$this->context->cart->update();

	  			$result = array();

	 			$product = $order->getAllProductsDetails();
	 			$productRemoved = $order->getRemovedProducts();

	  			
	  			if(sizeof($product) > 0 || $productRemoved[0]['id_product']) {
	  				if(sizeof($product) > 0) {
		  				for($i = 0; $i < sizeof($product); $i++ )
						{
							$final_result = ControllerFactory::getController('CartController')->mulProductAdd($product[$i], 
								$product[$i]['product_id'], 
								$supplier_id,
								$product[$i]['product_quantity']
							);

							if($final_result != "") {
								array_push($result,$final_result);
							}
						}
					}
					if($productRemoved[0]['id_product']){
						for($i = 0; $i < sizeof($productRemoved); $i++ )
						{
							$final_result = ControllerFactory::getController('CartController')->mulProductAdd($productRemoved[$i], 
								$productRemoved[$i]['id_product'], 
								$supplier_id,
								$productRemoved[$i]['product_quantity']
							);

							if($final_result != "") {
								array_push($result,$final_result);
							}
						}	
					}
	  			}
	  			else {
	  				$errors_m = array(
						"name" => 'All Products', 
						"msg" => 'Sorry unable to find the products to reorder.'
					);
	  				array_push($result, $errors_m);
	  			}
				
				die(Tools::jsonEncode($result));
			}
		}
		else if($type == 6) {
			$states = $state->getstatesofcustomerWithCount($this->context->cookie->id_customer);
			if(empty($states)) {
				$states = State::getStates(1, true);
			}
			echo Tools::jsonEncode($states);
		}
		else if($type == 7) {
			$id_customer = Tools::getValue('id_customer');
			/* Set delivery region automatically if user have only one state */
			$this->context->cookie->id_customer = $id_customer;
	        if(isset($this->context->cookie->id_customer)) {
	            $state = new State();
	            $single_state = false;
	            $result = array();
	            $states = $state->getstatesofcustomerWithCount($this->context->cookie->id_customer);
	            if(count($states) == 1) {
	                $stateObj = new State(intval($states[0]['id_state']));
	                $this->context->cookie->delivery_region = (int)$stateObj->getFcIdByState();
	                $this->context->cookie->id_state = $stateObj->id;
	                $this->context->cookie->delivery_region_name = $stateObj->name;
	                $single_state = $stateObj->id;
	            }

	            if(empty($states)) {
					$states = State::getStates(1, true);
				}

				array_push($result, $states, $single_state);

				echo Tools::jsonEncode($result);
	        }
		}
	}
}