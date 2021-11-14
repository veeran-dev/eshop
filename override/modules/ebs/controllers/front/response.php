<?php
/*
*  Update this file if any changes in EBS module response controller 
*  @author Elumalai K <elumalai.k@kobster.com>
*/

class EBSResponseModuleFrontControllerOverride extends EBSResponseModuleFrontController {
	public function postProcess() {
        $response = $_REQUEST;		
        $secureHash = $response['SecureHash'];
		unset($response['SecureHash']);
        $params = Configuration::get('SECRET_KEY'); 
        $hashType = Configuration::get('HASH_TYPE');	
	
        /*ksort($response);
        foreach ($response as $key => $value){
	        if (strlen($value) > 0) {
		        $params .= '|'.$value;
	        }
        }*/
				
		if($response['Amount'] != NULL)
			$params .= '|'.$response['Amount'];
		if($response['BillingAddress'] != NULL)
			$params .= '|'.$response['BillingAddress'];
		if($response['BillingCity'] != NULL)
			$params .= '|'.$response['BillingCity'];
		if($response['BillingCountry'] != NULL)
			$params .= '|'.$response['BillingCountry'];
		if($response['BillingEmail'] != NULL)
			$params .= '|'.$response['BillingEmail'];
		if($response['BillingName'] != NULL)
			$params .= '|'.$response['BillingName'];
		if($response['BillingPhone'] != NULL)
			$params .= '|'.$response['BillingPhone'];
		if($response['BillingPostalCode'] != NULL)
			$params .= '|'.$response['BillingPostalCode'];
		if($response['BillingState'] != NULL)
			$params .= '|'.$response['BillingState'];
		if($response['DateCreated'] != NULL)
			$params .= '|'.$response['DateCreated'];
		if($response['DeliveryAddress'] != NULL)
			$params .= '|'.$response['DeliveryAddress'];
		if($response['DeliveryCity'] != NULL)
			$params .= '|'.$response['DeliveryCity'];
		if($response['DeliveryCountry'] != NULL)
			$params .= '|'.$response['DeliveryCountry'];
		if($response['DeliveryName'] != NULL)
			$params .= '|'.$response['DeliveryName'];
		if($response['DeliveryPhone'] != NULL)
			$params .= '|'.$response['DeliveryPhone'];
		if($response['DeliveryPostalCode'] != NULL)
			$params .= '|'.$response['DeliveryPostalCode'];
		if($response['DeliveryState'] != NULL)
			$params .= '|'.$response['DeliveryState'];
		if($response['Description'] != NULL)
			$params .= '|'.$response['Description'];
		if($response['IsFlagged'] != NULL)
			$params .= '|'.$response['IsFlagged'];
		if($response['MerchantRefNo'] != NULL)
			$params .= '|'.$response['MerchantRefNo'];
		if($response['Mode'] != NULL)
			$params .= '|'.$response['Mode'];
		if($response['PaymentID'] != NULL)
			$params .= '|'.$response['PaymentID'];
		if($response['PaymentMethod'] != NULL)
			$params .= '|'.$response['PaymentMethod'];
		if($response['RequestID'] != NULL)
			$params .= '|'.$response['RequestID'];
		if($response['ResponseCode'] != NULL)
			$params .= '|'.$response['ResponseCode'];
		if($response['ResponseMessage'] != NULL)
			$params .= '|'.$response['ResponseMessage'];				
		if($response['TransactionID'] != NULL)
			$params .= '|'.$response['TransactionID'];

		if (strlen($params) > 0) {
            if($hashType == "MD5")
	            $hashValue = strtoupper(md5($params));
            if($hashType == "SHA512")
		        $hashValue = strtoupper(hash('SHA512',$params));	
	        if($hashType == "SHA1")
		        $hashValue = strtoupper(sha1($params));			
        }			
		
		$hashValid = ($hashValue == $secureHash) ? true : false; 
	
		$cartID = $response['MerchantRefNo'];
		$extras = array();
		$extras['transaction_id'] = $response['TransactionID'];
		$cart = new Cart(intval($cartID));
		$amount = $cart->getOrderTotal(true,Cart::BOTH);
		$responseMsg = $response['ResponseMessage'];

		if($response['ResponseCode'] == 0 && $hashValid) {
			$status_code = "Ok";
			if($response['IsFlagged'] == "NO" && $response['Amount'] == $amount) {
				$customer = new Customer(intval($cart->id_customer));

				if($customer->verification_status != 2)
					$status = Configuration::get('PS_OS_CUSTOMER_VERIFICATION_PENDING');
				else
					$status = Configuration::get('PS_OS_ORDERPLACED');

				$message = "Your Transaction was Successful";
			}
			else{
				$status = Configuration::get('EBS_ID_ORDER_PENDING');
				$responseMsg .= ". The payment has been kept on hold until the manual verification is completed and authorized by EBS";
				$message = "Your Transaction was Successful";
			}
		}
		else{
			$status_code = "Failed";
			$status = Configuration::get('EBS_ID_ORDER_FAILED');
			$message = "Your Transaction has Failed, please retry!";
		}
		
		$history_message = $responseMsg.'. EBS Payment ID: '.$response['PaymentID'];		
		$ebs = new EBS();
		

		if(Customer::getCurrentCustomerRole() != 1 && $cart->OrderExists()){
			$order = new Order();
			$orderId = $order->getOrderByCartId(intval($cart->id));
			$orderObject = new Order(intval($orderId));
			$payment_mode = 'EBS';
			$payment_type = 3;	
			$orderObject->updateOrderPayment($payment_mode);
			$orderObject->approveOrder($orderObject->id_customer, $payment_type, $orderId);
		}
		elseif($this->context->cookie->is_perks == 1)
		{
			$ebs->validateOrder(intval($cart->id), Configuration::get('PS_OS_ORDERPLACED'), $response['Amount'], 'Online Payment', $history_message, $extras, '', false, $cart->secure_key);
		}
		else{
			$ebs->validateOrder(intval($cart->id), $status, $response['Amount'], $ebs->displayName, $history_message, $extras, '', false, $cart->secure_key);
		}
		
		if($this->context->cookie->id_buyer == 3) {
			$order = new Order();
			$orderId = $order->getOrderByCartId(intval($cart->id));
			$orderObject = new Order(intval($orderId));
			// If po uploading done by user for EBS
			$files = glob("customer_PO/".$cart->id."-PO-EBS|*.*");
			if(!empty($files)) {
				foreach ($files as $file) {
				   $pathinfo = pathinfo($file);
				   $poNumber = explode("|", $pathinfo['filename'])[1];
				   rename("customer_PO/".$pathinfo['filename'].".".$pathinfo["extension"], "customer_PO/".$orderObject->id."-(".str_replace(",", "-", $poNumber).')-PO.'.$pathinfo["extension"]);
				   //Update po number for an order
				   $orderObject->po_number = $poNumber;
				   $orderObject->update();
				}
			}

			// Check PO configured for PO number updation
			if($this->context->cookie->budget_configured == 1) {
				
				$products = $orderObject->getProductsDetail();
				$order_total_true = $cart->getOrderTotal(true);

				if(!PurchaseOrder::orderExists($orderObject->id)) {
					/** Update PO Number **/
					$purchaseOrderObj = new PurchaseOrder();
					$orderObject->po_number = $purchaseOrderObj->getPoStringByAddress($this->context->cookie->id_address_budget, $this->context->cookie->budget_option);
					$orderObject->update();
					$customerObj = new Customer(intval($orderObject->id_customer));
					$po_option = $purchaseOrderObj->getPoOption(intval($customerObj->id_default_group));

					if($po_option == 1) /*** Purchase orders product based - Quantities updation***/
					{
						$poProducts = $purchaseOrderObj->getPurchaseOrderProducts($this->context->cookie->id_address_budget, $this->context->cookie->budget_option);
				
						foreach ($products as $key => $product) 
						{
							$quantity_ordered = $product['product_quantity'];

							foreach ($poProducts as $key => $poProduct) 
							{
								if($product['id_product'] == $poProduct['id_product']) 
								{
									if($poProduct['available_quantity'] > 0) 
									{
										if($poProduct['available_quantity'] <= $quantity_ordered) {
											$quantity_to_insert = $poProduct['available_quantity'];
										} 
										else if($poProduct['available_quantity'] > $quantity_ordered) {
											$quantity_to_insert = $quantity_ordered;
										}

										$data = array('id_purchase_order' => $poProduct['id_purchase_order'], 'id_order' => $product['id_order'],
												'id_product' => $product['id_product'],
												'quantity' => $quantity_to_insert);

										$insert_quantity_to_history = Db::getInstance()->insert('po_products_history', $data);

										$quantity_ordered = $quantity_ordered - $quantity_to_insert;
										
										if($quantity_ordered == 0)
											break;
									}
								}
							}
						}
					}
					else if($po_option == 2) /*** Purchase orders value based - values updation***/
					{
						$poValues = $purchaseOrderObj->getPurchaseOrderValues($this->context->cookie->id_address_budget, $this->context->cookie->budget_option, true);

						$value_ordered = $order_total_true;

						foreach ($poValues as $key => $poValue) 
						{
							if($poValue['available_value'] > 0) 
							{
								if($poValue['available_value'] <= $value_ordered) 
									$value_to_insert = $poValue['available_value'];
								else if($poValue['available_value'] > $value_ordered) 
									$value_to_insert = $value_ordered;

								$value_ordered = $value_ordered - $value_to_insert;

								$data = array('id_purchase_order' => $poValue['id_purchase_order'], 'id_order' => $orderObject->id, 'value' => $value_to_insert);

								$insert_value_to_history = Db::getInstance()->insert('po_values_history', $data);
								
								if($value_ordered == 0)
									break;
							}
						}
					}
				}
			}

			if(isset($this->context->cookie->child_approver) && $this->context->cookie->child_approver != 1) {
				if($this->context->cookie->child_id_order != 0) {
					$orderChild = new Order($this->context->cookie->child_id_order);
					$orderChild->updateOrderPayment($ebs->displayName);
				}
			}

			$this->context->cookie->child_id_order = 0;
			$this->context->cookie->child_approver = 0;

			Tools::redirect('index.php?controller=dash-index#/order/'.$orderId.'/'.$status_code.'/thankyou');
		}
		else 
		{
			$this->context->smarty->assign(array(
				'status' => $status_code,
				'responseMsg' => $message,
				'this_path' => $this->module->getPathUri(),
				'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/'
			));
			
			$this->setTemplate('payment_response.tpl');
		}
	}
}