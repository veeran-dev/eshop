<?php
class EBSResponseModuleFrontController extends ModuleFrontController {
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
		if($response['ResponseCode'] == 0 && $hashValid){
			$status_code = "Ok";
			if($response['IsFlagged'] == "NO" && $response['Amount'] == $amount){
				$status = Configuration::get('EBS_ID_ORDER_SUCCESS');
				$message= "Your Transaction was Successful";
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
		
		
		if($this->context->cookie->elite == 1 && Customer::getCurrentCustomerRole() != 1 && $this->context->cart->OrderExists() == true){
			$order = new Order();
			$orderId = $order->getOrderByCartId(intval($cart->id));
			$orderObject = new Order(intval($orderId));
			$payment_mode = 'EBS';
			$payment_type = 3;
			$order->updateOrderPayment($payment_mode);
			$orderObject->approveOrder($orderObject->id_customer, $payment_type, $orderId);
		}
		else{
			$ebs->validateOrder(intval($cart->id), Configuration::get('PS_OS_ORDERPLACED'), $response['Amount'], $ebs->displayName, $history_message, $extras, '', false, $cart->secure_key);
		}	
		
		if($this->context->cookie->elite == 1 && $this->context->cookie->id_buyer == 3) 
		{
			$order = new Order();
			$orderId = $order->getOrderByCartId(intval($cart->id));
			$orderObject = new Order(intval($orderId));

			// If po uploading done by user for EBS
			$files = glob("customer_PO/".$cart->id."-PO-EBS|*.*");
			if(!empty($files)) {
				foreach ($files as $file)
				{
				   $pathinfo = pathinfo($file);
				   $poNumber = explode("|", $pathinfo['filename'])[1];
				   rename("customer_PO/".$pathinfo['filename'].".".$pathinfo["extension"], "customer_PO/".$orderObject->id.'-PO.'.$pathinfo["extension"]);
				   //Update po number for an order
				   $orderObject->po_number = $poNumber;
				   $orderObject->update();
				}
			}

			Tools::redirect('index.php?controller=dash-index#/order/'.$orderId.'/'.$status_code.'/thankyou');
		}
		else 
		{
			$this->context->smarty->assign(array(
				'status' => $status_code,
				'responseMsg' => $message,
				'this_path' => $this->module->getPathUri(),
				'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
				'id_order' => $order->getOrderByCartId(intval($cart->id));
			));
			
			$this->setTemplate('payment_response.tpl');
		}
	}
}
