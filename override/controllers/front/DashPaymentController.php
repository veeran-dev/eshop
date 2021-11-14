<?php
class DashPaymentControllerCore extends DashController
{	
	public function ajaxReturn() {
		$id_customer = Tools::getValue('id_customer');
		$rm_payment_option = Tools::getValue('rm_payment_option');
		$type = Tools::getValue('type');
		$epay_later_order_id = Tools::getValue("id_pay_later");
		$epaylater_otp = Tools::getValue("epaylater_otp");
		
		$paymentmode = Tools::getValue('paymentmode');
		$deliveryAddressId = Tools::getValue('deliveryAddressId');
		$billingAddressId = Tools::getValue('billingAddressId');
		$ebs_po_upload = Tools::getValue('ebs_po_upload');
		// Uploading PO
		$po_number = Tools::getValue('po-number');
		$upload_po = $_FILES['po-file']['name'];
		$temp_name  = $_FILES['po-file']['tmp_name'];
		$id_order_rm = Tools::getValue('id_order_rm');

 		$Payments = new DashPaymentMode();
   
		$customer = new Customer((int)$this->context->cart->id_customer);
		$total = (float)$this->context->cart->getOrderTotal(true, Cart::BOTH);
		$currency = new Currency($this->context->currency->id);
		
		$start_memory = memory_get_usage();
 		$status = "";
 		$result = ""; 		

		$logger = new FileLogger();
		$logger->setFilename('log-files/'.$this->context->cookie->id_customer.'-'.$this->context->cookie->customer_firstname.'.txt');

  		/* Update delivery and billing address */
  		if(isset($deliveryAddressId) && $deliveryAddressId != "") 
  		{
  			$cartObj = new Cart(intval($this->context->cart->id));
  			$cartObj->id_address_delivery = (int)$deliveryAddressId;

  			if(isset($billingAddressId) && $billingAddressId != "")
				$cartObj->id_address_invoice = (int)$billingAddressId;
			else
				$cartObj->id_address_invoice = (int)$deliveryAddressId;

			if($cartObj->update()) {
				// Update cart product address
				$cartObj->updateNewAddressId($cartObj->id_address_delivery);

				$this->context->cart = $cartObj;
			}
  		}

  		if($type == 1) {
			$payment = new DashPaymentOption();
			$saleStatus = $this->getShopSaleStatus();
			if($saleStatus != 1) {
				if(isset($rm_payment_option) && $rm_payment_option) {
					$result = $payment->getAllPaymentOptions($id_customer);
					echo Tools::jsonEncode($result);
				}
				else {
					$payment->getPaymentOptions($id_customer);
				}
			}
			else{
				$result = array('saleStatus' => $saleStatus);
			}
		}
		else if($type == 2) {
 			$this->context->cookie->payment_type = 2;
			$result = $Payments->cashOnDelivery((int)$this->context->cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, 'Cash on delivery (COD)',$mailVars = array(), (int)$currency->id,$customer->secure_key);
		}
		else if($type == 3) {
   			
            $this->context->cookie->payment_type = 3;
			$mailVars =	array(
				'{cheque_name}' => Configuration::get('CHEQUE_NAME'),
				'{cheque_address}' => Configuration::get('CHEQUE_ADDRESS'),
				'{cheque_address_html}' => str_replace("\n", '<br />', Configuration::get('CHEQUE_ADDRESS'))
			);
			
			$result=$Payments->Cheque((int)$this->context->cart->id, Configuration::get('PS_OS_ORDERPLACED'), $total, 'Cheque',  $mailVars, (int)$currency->id,  $customer->secure_key);
		}
		else if($type == 4) {
			$this->context->cookie->payment_type = 4;
			$mailVars = array(
				'{bankwire_owner}' => Configuration::get('BANK_WIRE_OWNER'),
				'{bankwire_details}' => nl2br(Configuration::get('BANK_WIRE_DETAILS')),
				'{bankwire_address}' => nl2br(Configuration::get('BANK_WIRE_ADDRESS'))
			);
			$result = $Payments->NEFT((int)$this->context->cart->id, Configuration::get('PS_OS_ORDERPLACED'), $total, 'Bank Wire',  $mailVars, (int)$currency->id,  $customer->secure_key);
		}
		else if($type == 6) {
			$customer_role = Customer::getCurrentCustomerRole();

			if($customer_role ==1)
			{
  				$status = Configuration::get('PS_OS_PENDINGAPPROVAL');
			}
			else if($customer_role ==2)
			{
				$this->context->cookie->payment_type = 5;// setting payment options to display the final step(order placed tpl)  
				$status = OrderState::FLAG_LEVEL2_APPROVED;
			}
			else if($customer_role ==3)
			{
				$this->context->cookie->payment_type = 5;// setting payment options to display the final step(order placed tpl)
				$status = OrderState::FLAG_LEVEL3_APPROVED;
			}
			
 			$result=$Payments->PFA((int)$this->context->cart->id, $status, $total, 'PENDING FOR APPROVAL',  $mailVars= NULL, (int)$currency->id,  $customer->secure_key);

			$logger->logInfo("Dash payment controller test -> Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".$this->context->cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB  '. "Payment Status -> ".$status."Customer Role-> ".$this->context->cookie->role);
		}
		else if($type == 7) {
			$result = $Payments->Credit((int)$this->context->cart->id, Configuration::get('PS_OS_ORDERPLACED'), $total, 'Credit',  $mailVars, (int)$currency->id,  $customer->secure_key);
		}
		
		if($result && is_array($result))
		{
			if(sizeof($result) > 0) {
				$products = $this->context->cart->getProducts();
				$order_total_true = $this->context->cart->getOrderTotal(true);
				$order_total_false = $this->context->cart->getOrderTotal(false);

				foreach($result as $id_order) {

					$order = new Order(intval($id_order));

					if($po_number != "" && !$order->po_number) {
                        $order->po_number = trim($po_number);
                    }

                    if($order->po_number != "")
                        $order->update();
                    
                    // Elite Upload PO
                    if(isset($upload_po) && $upload_po)
                    {
                        if(!empty($upload_po))
                        {                       
                            $file_name = $id_order."-(".str_replace(",", "-", $order->po_number).")-PO";          
                            $splitName = explode(".", $upload_po);
                            $fileExt = end($splitName);
                            $newFileName  = strtoupper($file_name.'.'.$fileExt);        
                            $location = "customer_PO/"; 
                            move_uploaded_file($temp_name, "$location/$newFileName");
                        }
                    }
				}

				echo Tools::jsonEncode(
					array('id_order' => implode('_', $result), 
						'order_value' => $order_total_false, 
						'products' => $products, 
						'tax_rate' => ($order_total_true - $order_total_false), 
						'result' => 1, 
						'id_cart' => $this->context->cart->id,
						'secure_key' => $customer->secure_key
					)
				);
			}
		}			
	}
}