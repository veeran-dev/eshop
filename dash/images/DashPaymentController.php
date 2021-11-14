<?php
class DashPaymentControllerCore extends DashController
{
	public function ajaxReturn()
	{
		$id_customer=$_POST['id_customer'];
		$type=$_POST['type'];
		$paymentmode=$_POST['paymentmode'];
		$deliveryAddressId=$_POST['deliveryAddressId'];
 		$Payments= new DashPaymentMode();
		$customer = new Customer((int)self::$cart->id_customer);
		$total = (float)self::$cart->getOrderTotal(true, Cart::BOTH);
		$currency = new Currency($cookie->id_currency);
		$upload_po = $_FILES['po_file_name']['name'];
		$temp_name  = $_FILES['po_file_name']['tmp_name'];
		$start_memory = memory_get_usage();

		if($type==1)
		{
			$payment=new DashPaymentOption();
			$result=$payment->getPaymentOptions($id_customer);
		}
		if($type==2)//Cash on delivery (COD)
		{
 			$name ='Cash on delivery (COD)';
 			$result=$Payments->cashOnDelivery((int)self::$cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, $name, $customer->secure_key);
			
				$result=1;
		}
		if($type==3)//Cheque
		{
 			
			$name ='Cheque';
			$mailVars =	array(
							'{cheque_name}' => Configuration::get('CHEQUE_NAME'),
							'{cheque_address}' => Configuration::get('CHEQUE_ADDRESS'),
							'{cheque_address_html}' => str_replace("\n", '<br />', Configuration::get('CHEQUE_ADDRESS')));
			
			$result=$Payments->Cheque((int)self::$cart->id, Configuration::get('PS_OS_ORDERPLACED'), $total, $name,  $mailVars, (int)$currency->id,  $customer->secure_key);
			 
				$result=1;
		}
		if($type==4)//NEFT
		{
			$name ='Bank Wire';
			$mailVars = array(
							'{bankwire_owner}' => Configuration::get('BANK_WIRE_OWNER'),
							'{bankwire_details}' => nl2br(Configuration::get('BANK_WIRE_DETAILS')),
							'{bankwire_address}' => nl2br(Configuration::get('BANK_WIRE_ADDRESS'))
						);
			$result=$Payments->NEFT((int)self::$cart->id, Configuration::get('PS_OS_ORDERPLACED'), $total, $name,  $mailVars, (int)$currency->id,  $customer->secure_key);
			
				$result=1;
		}
					echo $result;
		$logger = new FileLogger();
		$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
		$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	
		if($type==5)
		{
			
			self::$cart->id_address_delivery =(int)$deliveryAddressId;
			self::$cart->id_address_invoice =(int)$deliveryAddressId;
			self::$cart->update();
		}
		/*if($type==6)//EBS
		{
			$chequedetail =	array(
							'cheque_name' => Configuration::get('CHEQUE_NAME'),
							'cheque_address' => Configuration::get('CHEQUE_ADDRESS'),
							'cheque_address_html' => str_replace("\n", '<br />', Configuration::get('CHEQUE_ADDRESS')));
			$bankdetail = array(
							'bankwire_owner' => Configuration::get('BANK_WIRE_OWNER'),
							'bankwire_details' => nl2br(Configuration::get('BANK_WIRE_DETAILS')),
							'bankwire_address' => nl2br(Configuration::get('BANK_WIRE_ADDRESS'))
						);
			$tax[] = Configuration::get('PS_TAX');
			$allpaymentmodedata = array();
			$total[]=$total;
			array_push($allpaymentmodedata,$total,$chequedetail,$bankdetail,$tax);
			echo Tools::jsonEncode($allpaymentmodedata);
		}*/
		if($upload_po){
			$dataresult = Order::getCustomerOrders((int)(self::$cookie->id_customer));
			for ($i=0 ; $i < 1 ; $i++ ) {
				if(!empty($upload_po))
				{   $file_name = $dataresult[$i]['id_order']."-PO";
					$splitName = explode(".", $upload_po);
					$fileExt = end($splitName);
					$newFileName  = strtoupper($file_name.'.'.$fileExt);  		
					$location = "customer_PO/"; 
						move_uploaded_file($temp_name, "$location/$newFileName");
				} 
			}
		}
	}
}