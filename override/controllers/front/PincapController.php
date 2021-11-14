<?php
class PincapControllerCore extends DashController
{
	public function getInvoiceFile($number)
	{
		if(file_exists(_PS_ROOT_DIR_.'/Invoice-ACK/'.$number.'.png'))
		{
			return 'Invoice-ACK/'.$number.'.png';
		}
		else
		{
			return false;
		}
	}

	public function getDrAckFile($dr){

		$files = glob(_PS_ROOT_DIR_.'/scanedDRs/'.$dr.'_*.*');
		return $files;
	}

	public function ajaxReturn()
	{	
		$pwd = Tools::getValue('pwd');
		$email = Tools::getValue('email');
		$type = Tools::getValue('type');
// var_dump($type);
		if($type == 1){
			$customer = new Customer();
			$authentication = $customer->getByEmail(trim($email), trim($pwd));
			self::$cookie->id_customer = (int)($customer->id);
			self::$cookie->customer_lastname = $customer->lastname;
			self::$cookie->customer_firstname = $customer->firstname;
			self::$cookie->id_buyer = $customer->id_buyer;
			self::$cookie->logged = 1;
			self::$cookie->is_guest = $customer->isGuest();
			self::$cookie->passwd = $customer->passwd;
			self::$cookie->email = $customer->email;
			self::$cookie->role = $customer->getCustomerRole();
			
			$credit_days = new Group((int)($customer->id_default_group));
			self::$cookie->credit_days = (int)$credit_days->credit_days;
			self::$cookie->companyName = $credit_days->name[1];
			
			if (Configuration::get('PS_CART_FOLLOWING') AND (empty(self::$cookie->id_cart) OR Cart::getNbProducts(self::$cookie->id_cart) == 0))
				self::$cookie->id_cart = (int)(Cart::lastNoneOrderedCart((int)($customer->id)));
			/* Update cart address */
			self::$cart->id_carrier = 0;
			self::$cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
			self::$cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
			// If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
			self::$cart->secure_key = $customer->secure_key;
			self::$cart->update();
			Module::hookExec('authentication');
			$logger = new FileLogger();
			$logger->setFilename("test.txt");
			$logger->logError($authentication->id_customer);			
			if($authentication->id > 0){
				$result = array(
					'id_customer' => $authentication->id,
					'email' => $authentication->email,
				);
				$logger->logError("done");
				echo Tools::jsonEncode($result);
			}
			else{
				echo Tools::jsonEncode(array('error' => 1));	
			}
		}
		if($type == 2){
			$id_customer = Tools::getValue('user');
			echo Tools::jsonEncode(Pincap::companies($id_customer));
		}
		if($type == 3 )
		{
			$idUser = Tools::getValue('idUser');
			$fromDate = Tools::getValue('fromDate');
			$toDate = Tools::getValue('toDate');
			$duration = Tools::getValue('duration');
			$idPage = Tools::getValue('idPage');
			$limit = Tools::getValue('limit');
			$orderBy = Tools::getValue('orderBy');
			$orderWay = Tools::getValue('orderWay');
			$searchQuery = Tools::getValue('q');
			$limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
			$offset = (PAGE_PER_NO * intval($idPage));
		
		$invoice = Order::getViewOrders($idUser, $limit, $offset, $fromDate, $toDate, $duration, $orderBy, $orderWay, $searchQuery, $filter_status);

		if($invoice['results']) {
			for($i=0; $i<sizeof($invoice['results']); $i++){
				$invoice['results'][$i]['invoice_ack'] = $this->getInvoiceFile($invoice['results'][$i]['invoice_number']);
				if($invoice['results'][$i]['dr_file']){
					if(glob(_PS_ROOT_DIR_.'/scanedDRs/'.$invoice['results'][$i]['dr_file'])){
						$invoice['results'][$i]['dr_file']	= array(0=>'scanedDRs/'.$invoice['results'][$i]['dr_file']);
					}
					else{
						$invoice['results'][$i]['dr_file']	= $this->getDrAckFile($invoice['results'][$i]['delivery_number']);
					}
				}
				
				// $invoice['results'][$i]['dr_file'] = $this->getDrAckFile($invoice['results'][$i]['id_delivery']);

				// $invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['invoice_number']);
				$today = date(Configuration::get('PS_INVOICE_PREFIX_DATE'));
		        $date = date($invoice['results'][$i]['invoice_date_a']);
		        if(strtotime($today) < strtotime($date)){
		            $invoice['results'][$i]['invoice_number'] =FulfillmentCentre::getInvoicePrefix($invoice['results'][$i]['id_fc'])[0]['prefix'].sprintf('%06d',$invoice['results'][$i]['invoice_number']);
		        }
		        else{
		          //  $invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX').sprintf('%06d', $invoice['results'][$i]['invoice_number']);
		            $invoice['results'][$i]['invoice_number'] = Configuration::get('PS_INVOICE_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['invoice_number']);
		        }

				$invoice['results'][$i]['delivery_number'] = Configuration::get('PS_DELIVERY_PREFIX', (int)($this->context->language->id)).sprintf('%06d', $invoice['results'][$i]['delivery_number']);

			}
			$invoice['results'] = array_values($invoice['results']);

			
			$invoice['total'] = ceil($invoice['total'] / PAGE_PER_NO);
		}
		
 		echo Tools::jsonEncode($invoice);
		}
		else if($type == 4)
		{
			$id_order = Tools::getValue('id_order');
			$delivery_add = Tools::getValue('delivery_add');
			$invoice_add = Tools::getValue('invoice_add');
			$result = array();
			$addressObj = new Address();
			$order = new Order($id_order);
			// For Order Status flow
			$history = OrderHistory::getAllStatus($id_order, $id_lang = 1);
			// Fetching addresses
 			$addressInvoice = $addressObj->getParticularAddress($order->id_address_invoice);
			$addressDelivery = $addressObj->getParticularAddress($order->id_address_delivery);
			// GET ordered products
 			$productDetails = $order->getDashProducts($products = false, $selectedProducts = false, $selectedQty = false, $orderid = $id_order);
 			// GET Tax type incl. or excl. 
 			$tax[] = Configuration::get('PS_TAX');
			// GET shopping summary
  			$order_details = $order->getFields();

			array_push($result,$history,$addressInvoice,$addressDelivery,$productDetails,$tax,$order_details);
			
			echo Tools::jsonEncode($result);
		}
	}
}