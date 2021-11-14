<?php
/*
* 2016-2017 Kobster.com
*
*  @author Elumalai K <elumalai.k@kobster.com>
*  @copyright  2016-2017 Kobster.com
*  @version  Release: $Revision: 1786 $
*/
class OrdersControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $smarty,$cookie;

		$type = Tools::getValue('type');

		//Get execution type
		$smarty_execute = Tools::getValue('smarty');

		//Get order management filter variables
		$order_by 		= Tools::getValue('order_by');
		$order_way 		= Tools::getValue('order_way');
		$id_order 		= trim(Tools::getValue('id_order'));
		$customer 		= Tools::getValue('cus_name');
		$grp_name 		= Tools::getValue('grp_name');
		$buyer_type 	= Tools::getValue('id_buyer');
		$state 			= Tools::getValue('state');
		$order_total 	= Tools::getValue('total');
		$payment 		= Tools::getValue('payment');
		$order_status 	= Tools::getValue('status');
		$fc 			= Tools::getValue('fc');
		$from_date 		= Tools::getValue('from_date');
		$to_date 		= Tools::getValue('to_date');
		$status 		= Tools::getValue('status');

		//Get file variable to upload
		$file 		= $_FILES['file']['name'];
		$temp_name  = $_FILES['file']['tmp_name'];

		//Get variables for single order changes
		$fc_single_order 		 = Tools::getValue('f_center');
		$estimated_delivery_time = Tools::getValue('estimated_delivery_time');
		$delivery_id 			 = Tools::getValue('id_delivery');
		$kob_box 				 = Tools::getValue('kob_box');
		$other_box 				 = Tools::getValue('other_box');
		$file_upload_true 		 = Tools::getValue('file_upload_true');
		$message 				 = Tools::getValue('message');
		$id_order_single 		 = Tools::getValue('id_order_single');
		$message_visibility 	 = Tools::getValue('visibility');
		$productList             = Tools::getValue('id_order_detail');
		$qtyList 				 = Tools::getValue('cancelQuantity');
		$tab 					 = Tools::getValue('tab');

		//Get pagination variables
		$per_page  = Tools::getValue('order_per_page');
		$page 	   = Tools::getValue('page');
		$jump_page = Tools::getValue('jump_page');
		$per_page && $per_page != "" ? define('PAGE_PER_NO', $per_page) : define('PAGE_PER_NO', 50);
		$jump_page = $jump_page == 0 ? 0 : ($jump_page-1);
	 	$id_page   = isset($page) && !empty($page) && $jump_page == 0 ? $page : $jump_page;
		$pageLimit = (PAGE_PER_NO * $id_page);

		//Order object for particular order
		$order = new Order((int)($id_order_single));

		//Get access token for current employee
		$token = Tools::getAdminTokenLiteCustom('AdminPdf', (int)(self::$cookie->id_employee));

		//Set condition variable for single order view 
		isset($id_order_single) && $id_order_single != "" ? $single_order = true : $single_order = false;
		
		$delivery = new Delivery();
		/**invoice number **/
		$today = Configuration::get('PS_INVOICE_PREFIX_DATE');
        $date = date($order->invoice_date);
        $title_new='';
        if(strtotime($today) < strtotime($date)){
            $title_new =FulfillmentCentre::getInvoicePrefix($order->id_fc)[0]['prefix'].sprintf('%06d',$order->invoice_number);
        }
        else{
            $title_new = Configuration::get('PS_INVOICE_PREFIX').sprintf('%06d', $order->invoice_number);
        }
        /** ends here **/

		if($single_order)
		{
			$employee = new Employee();
			$products = $order->getProducts();
			$currentState = new OrderState((int)($order->current_state));
			$invoice_number = $title_new;
			$messages = Message::getMessagesByOrderId($order->id, true);
			$delivery = $delivery->getDeliverySlips((int)($id_order_single));
			$cart = Cart::getCartByOrderId($order->id);
			$customerObject = new Customer((int)($order->id_customer));
			$companyObject = new Group((int)($customerObject->id_default_group));
			$customerStats = $customerObject->getStats();
			$addressDelivery = new Address($order->id_address_delivery, (int)($cookie->id_lang));
			$addressInvoice = new Address($order->id_address_invoice, (int)($cookie->id_lang));
			$invoice_address = AddressFormat::generateAddress($addressInvoice, $patternRules, '<br />');
			$shipping_address = AddressFormat::generateAddress($addressDelivery, $patternRules, '<br />');
			$stateObj = new State((int)($addressDelivery->id_state));
			$discounts = $order->getDiscounts();
			$invoices_collection = $order->getInvoicesCollection();
			$currentStateTab = $order->getCurrentStateFull(1);
			$history = $order->getHistory(1);
			$delivery_object = new Delivery((int)($delivery_id));
			$idProof = $customerObject->id_proof;
			$invoice_file = $this->getInvoiceFile($order->invoice_number);
			$perksCustomerFile = "";
			$block_account = $customerObject->checkCustomerCredibility($order->id);
			/** get all dr copies **/

			if($idProof)
				$perksCustomerFile = "./perks-identity/".$idProof;
		}
		
		$history = $order->getHistory(1);
		$history_id = array();

		if(isset($type)) 
		{			
			if($type == 0) // display scn orders template
			{
				$statedata = State::getStatesByIdCountry(110);
				$states = OrderState::getOrderStates(1);
				$fullfillment_centre = FulfillmentCentre::getAllFCentres();
				$paymentMode = ScnVendorInfo::getPaymentMode();
				$currencyDefault = Currency::getDefaultCurrency();
				$carriers = Carrier::getCarriers(1,true);
				$patternRules = array('avoid' => array());

				if($single_order)
				{
					//Get order history IDs
					foreach($history as $history_ids)
						array_push($history_id, $history_ids['id_order_state']);

					//Get customer PO
					$budget = false;
					$po_option = PurchaseOrder::orderExists($order->id);
					if($po_option == 1 || $po_option == 2) {
						$order_po_name = $order->po_number;
						$budget = true;
					}

					if(!$budget) {
						$file_po = glob("customer_PO/$order->id*.*");
						if(!empty($file_po))
						{
							foreach ($file_po as $file_po_info)
							{
							   $info = pathinfo($file_po_info);
							   $order_po_name = $po_name_original = $info['filename'].".".$info['extension'];
							}
						}
					}

					if(isset($order->id_employee) && $order->id_employee) {
						$employee = new Employee(intval($order->id_employee));
						$order_placed_by = $employee->firstname." ".$employee->lastname;
					}
					
					//Get order products
				 	$product_detail = $order->getOrderProducts($products);

				 	//Get consolidated invoice
					// $consolidatedInvoice = $order->getConsolidatedInvoice();
					$consolidatedInvoice = "";
			        $consolidated_invoice = '';
			        if(sizeof($consolidatedInvoice) > 1)
			        {
			            foreach($consolidatedInvoice as $cin)
			            {
			                $consolidated_invoice .="&id_order[]=".$cin['id_order'];
			            }
			        }

			        //Get order current FC 
					$fc_city = new FulfillmentCentre((int)($order->id_fc));

					//Set prefix for DR and Delivery label
					for($i = 0; $i < sizeof($delivery); $i++)
					{
						$delivery[$i]['delivery_label'] = 'LABEL'.sprintf('%06d', $delivery[$i]['delivery_number']);

						$delivery[$i]['delivery_number'] = $delivery[$i]['dr_prefix'].sprintf('%06d', $delivery[$i]['delivery_number']);

						$delivery_box = new Delivery((int)$delivery[$i]['id_delivery']);
						$delivery[$i]['kob_boxes'] = $delivery_box->kob_boxes;
						$delivery[$i]['other_boxes'] = $delivery_box->other_boxes;
					}
				}

				$orders_true = Order::getOrdersDetail($count = true, false, false, $order_by, $order_way,$id_order, $customer, 
													  $buyer_type, $state, $order_total, $payment, $order_status, $fc, $from_date, 
													  $to_date,$grp_name);
				
				$orders_false = Order::getOrdersDetail($count = false, $limit = $pageLimit, PAGE_PER_NO, $order_by, $order_way, 
											   $id_order, $customer, $buyer_type, $state, $order_total, $payment, 
											   $order_status, $fc, $from_date, $to_date,$grp_name);

				$count = count($orders_true);
				$paginationCount = ceil($count / PAGE_PER_NO);

				
				if($smarty_execute == 1)
				{
					$smarty->assign(array(
										  'state_array' => $statedata, 'order_state' => $states, 'fc' => $fullfillment_centre,
										  'payment_options' => $paymentMode, 'orders' => $orders_false, 'currency' => $currencyDefault, 
										  'paginationCount' => $paginationCount, 'page' => $id_page, 'count' => $count,
										  'perPage' => PAGE_PER_NO, 'jump_page' => $jump_page, 'orderBy' => $order_by, 
										  'orderWay' => $order_way,'id_order' => $id_order, 'customer' => $customer,'group' => $grp_name, 
										  'buyer_type' => $buyer_type, 'state' => $state, 'order_total_list' => $order_total, 
										  'payment' => $payment, 'order_status' => $order_status, 'id_fc' => $fc, 
										  'from_date' => $from_date, 'to_date' => $to_date, 'token' => $token,
										  'states' => $states, 'single_order' => $single_order,'customerObj' => $customerObject,
										  'currentState' => $currentStateTab, 'history' => $history, 
										  'order_id' => $id_order_single,'history_id' => $history_id, 
										  'fc_city' => $fc_city, 'order' => $order, 'tab' => $tab,
										  'currentStateOrder' => $currentState, 'invoice_number' => $invoice_number, 'delivery_slip' => $delivery,
										  'order_messages' => $messages,'employee' => $employee, 'cart' => $cart,'order_po_name' => $order_po_name,
										  'po_name_original' => $po_name_original,
										  'cus_total_performance' => $customerStats, 'product_detail' => $product_detail,
										  'invoice_address' => $invoice_address,'shipping_address' => $shipping_address,
										  'invoice_file' =>$invoice_file,'tax_exclusive' => PS_TAX_EXC,'discounts' => $discounts,
										  'perksCustomerFile' => $perksCustomerFile,
										  'consolidated_invoice' => $consolidated_invoice, 'invoices_collection' => $invoices_collection,
										  'company' => $companyObject, 'stateObj' => $stateObj, 'config' => $config,'carriers'=>$carriers,
										  'budget' => $budget, 'block_account' => $block_account, 'order_placed_by' => $order_placed_by));

					$smarty->display('scn/scn-orders.tpl');
				}
			}
			elseif($type == 1)
			{
				//DR Scanned copy upload section
				if($file != "" && isset($file) && isset($delivery_id))
				{
					$allowed =  array('gif','png' ,'jpg','docx','doc','pdf','rtf','zip');
					$filename = $_FILES['file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed) ) {
					    echo '1';
					}
					else
					{
						if($_FILES['file']['size'] > (2 * 1024 * 1024))
						{
							echo "2";
						}
						else
						{
							$file_name = $delivery_object->delivery_number;
							$splitName = explode(".", $file);
							$fileExt = end($splitName);

							if(count($splitName) > 1)
								$newFileName  = strtolower($delivery_object->generateFilename().'.'.$fileExt);  
							else
								$newFileName  = strtolower($delivery_object->generateFilename());

							$location = "scanedDRs"; 
								move_uploaded_file($temp_name, "$location/$newFileName");		
							
							$delivery_object->dr_file_name = $newFileName;

							if($delivery_object->update())
								echo "3";
							else
								echo "4";
						}
				 	}
				}
				elseif((isset($kob_box) && $kob_box != "") && (isset($other_box) && $other_box != "") && $smarty_execute == 0 && $file_upload_true != 1) //Update delivery labels
				{
					$delivery = new Delivery();
					$delivery->updateLabels($delivery_id,$kob_box,$other_box);
						echo "5";
				}
 				//Trigger comment for a product
				if ($message != '')
				{
					$messageObject = new Message();
					$messageObject->id_employee = (int)(self::$cookie->id_employee);
					$messageObject->message = htmlentities($message, ENT_COMPAT, 'UTF-8');
					$messageObject->id_order = $id_order_single;
					
					$messageObject->private = $message_visibility;
					
					$customer = new Customer((int)($order->id_customer));
					if ($messageObject->add())
					{

						if ($messageObject->private){
							
							/* Email alert to the customer support & supply chain team */
							$order = new Order((int)($messageObject->id_order));
							$employee = new Employee((int)(self::$cookie->id_employee));

							$customer = new Customer($order->id_customer);
							$group = new Group($customer->id_default_group, $this->context->cookie->id_lang);

							$relationship_manager = new Employee((int)($customer->id_relationship_manager));

							$fc = new FulfillmentCentre((int)($order->id_fc));
							$fc_head = new Employee((int)($fc->id_employee));

							$varsTpl = array(
								'{id_order}' => $messageObject->id_order, 
								'{emp_name}' => $employee->firstname, 
								'{message}' => (Configuration::get('PS_MAIL_TYPE') == 2 ? $messageObject->message : nl2br2($messageObject->message)),
								'{company}' => $group->name
							);

							if($customer->id_relationship_manager != "" && $customer->id_relationship_manager != 0 && $message_visibility != 4)
							{
								Mail::Send((int)($order->id_lang), 'order_internal_comment',
											Mail::l('Order Comment - #'. $messageObject->id_order .' by '. $employee->firstname, 
											(int)($order->id_lang)), 
											$varsTpl, 
											$relationship_manager->email,
											'Team', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
							}
							else if($message_visibility != 4)
							{
								Mail::Send((int)($order->id_lang), 
											'order_internal_comment',
											Mail::l('Order Comment - #'. $messageObject->id_order .' by '. $employee->firstname, 
											(int)($order->id_lang)), $varsTpl, 'support@kobster.com',
											'Team', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
							}

							if($fc_head->email != "")
							{
								Mail::Send((int)($order->id_lang), 
											'order_internal_comment',
											Mail::l('Order Comment - #'. $messageObject->id_order .' by '. $employee->firstname, 
											(int)($order->id_lang)), 
											$varsTpl, $fc_head->email,
											'Team', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
							}

							Mail::Send((int)($order->id_lang), 
										'order_internal_comment',
										Mail::l('Order Comment - #'. $messageObject->id_order .' by '. $employee->firstname, 
										(int)($order->id_lang)), $varsTpl, 'ops@kobster.com',
										'Team', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);

							if($message_visibility != 4){
								Mail::Send((int)($order->id_lang), 
											'order_internal_comment',
											Mail::l('Order Comment - #'. $messageObject->id_order .' by '. $employee->firstname, 
											(int)($order->id_lang)), $varsTpl, 'lingakani.g@kobster.com',
											'Team', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
							}
						}
						elseif ($message_visibility == 0)
						{
							$order = new Order((int)($messageObject->id_order));
							
							if (Validate::isLoadedObject($order))
							{
 								$varsTpl = array('{lastname}' => $customer->lastname, '{firstname}' => $customer->firstname, '{id_order}' => $messageObject->id_order, '{message}' => (Configuration::get('PS_MAIL_TYPE') == 2 ? $messageObject->message : ($messageObject->message)));
 								
 								Mail::Send((int)($order->id_lang), 
 											'order_merchant_comment',
											Mail::l('New message regarding your order', 
											(int)($order->id_lang)), $varsTpl, $customer->email,
											$customer->firstname.' '.$customer->lastname, NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
							}
						}

						echo 1;
					}
				}
			}
			elseif($type == 2) //Change order status of an order
			{
				$order_state = new OrderState(Tools::getValue('status'));

				if (!Validate::isLoadedObject($order_state)) 
				{
                    echo 0;
                }
                else
                {
                	$current_order_state = $order->getCurrentOrderState();
                    
                    $newOrderStatusId = (int)(Tools::getValue('status'));
					/*Please past the code from adminordercontroller*/
                    if(($newOrderStatusId == Configuration::get('PS_OS_INVOICE_GEN')) OR ($newOrderStatusId == Configuration::get('PS_OS_DELIVERED')))
                    {
                        $order = new Order($order->id);
                        if(!$order->isDelivered()){
                            echo 1;
                            return;
                        }
                    }

                    if($newOrderStatusId == OrderState::GENERATE_INVOICE){
                        $order = new Order((int)$order->id);
                        $customer = new Customer($order->id_customer);
                        $group = new Group($customer->id_default_group);
                        $order->credit_days=$group->credit_days;
                        $order->update();
                    }

                    if($newOrderStatusId == OrderState::FLAG_INVOICE_SUBMITTED)
                    {
						// Checking DR upload count
                        $order = new Order($order->id);
						$delivery_check = new Delivery();
						$delivery_count = $delivery_check->getDeliveDetailFromOrderId($order->id);
						
						if($delivery_count != 0 )
						{
							echo 4;
							return;
						}
						if(!$order->isInvoiceGenerated()){
							echo 6;
							return;
						}
						
                    }

                    if ($current_order_state->id != $order_state->id) 
                    {
                        // Create new OrderHistory
                        $history = new OrderHistory();
                        $history->id_order = $order->id;
                        $history->id_employee = (int)(self::$cookie->id_employee);

                        $use_existings_payment = false;

                        if (!$order->hasInvoice()) 
                        {
                            $use_existings_payment = true;
                        }
                        if($newOrderStatusId == OrderState::FLAG_PENDING_PAYMENT)
                        {
                            $status = $history->checkStatus($order->id,OrderState::FLAG_INVOICE_SUBMITTED);//Check for Invoice Submitted 
                            if($status == 0)
                            {
                                echo "5";
                                return false;
                            }
                        }
                    	if($newOrderStatusId == OrderState::FLAG_ORDER_PLACED)
                    	{
                    		$status = $history->checkStatus($order->id,OrderState::FLAG_ORDER_PLACED);//Check for Invoice Submitted 
                            if($status == 0)
                            {
                                date_default_timezone_set('Asia/Kolkata');
		                        $orderPlacedTime = new DateTime();
		                        $cutOffTime = new DateTime();
		                        $cutOffTime->setTime(12, 0, 0);
		                        
		                        $estimated_delivery_time = new DateTime();
		                        $estimated_delivery_time = $orderPlacedTime;
		                        
		                        if($orderPlacedTime < $cutOffTime){
		                            $estimated_delivery_time->modify('+1 day');
		                        }
		                        else{
		                            $estimated_delivery_time->modify('+2 day');
		                        }
		                         $estimated_delivery_time->setTime(22, 0, 0);
		                        $order->estimated_delivery_time = $estimated_delivery_time->format('Y-m-d H:i:s');
		                        $order->update();
                            }
                    	}
                        $history->changeIdOrderState((int)$order_state->id, $order, $use_existings_payment);

                        $carrier = new Carrier($order->id_carrier, $order->id_lang);

                        $templateVars = array();

                        if ($history->id_order_state == Configuration::get('PS_OS_SHIPPING') && $order->shipping_number) 
                        {
                            $templateVars['{followup}'] = str_replace('@', $order->shipping_number, $carrier->url);
                        }

                        // Save all changes
                        if($order_state->id == 46){
                        	$internal_mail = true;
                        	$templateVars['to_mail'] = 'category@kobster.com';
                        	$templateVars['to_name'] = 'Category Team';
                        }

                        if ($history->addWithemail(true, $templateVars, $internal_mail)) 
                        {
                            // synchronizes quantities if needed..
                            if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) 
                            {
                                foreach ($order->getProducts() as $product) 
                                {
                                    if (StockAvailable::dependsOnStock($product['product_id'])) 
                                    {
                                        StockAvailable::synchronize($product['product_id'], (int)$product['id_shop']);
                                    }
                                }
                            }

                            $delivery_status = $history->checkStatus($order->id,OrderState::FLAG_DELIVERY);//check the order get deliver or not                             
                            
                            if($delivery_status !=0)
                            {
                                $delivery_status = $history->automatedStatus($order->id);
                            }
                        }
                        echo 2;
                    } 
                    else 
                    {
                        echo 3;
                    }
                }	
			}
			else if($type == 3) //Generate DR for an order
			{
				$error = array();

				if($productList && $qtyList)
				{	
					$products = $order->getProductsDetail();

					if(sizeof($productList) < sizeof($products)) {
						echo 3;
						return false;
					}

					if($order->checkIfAllProductsDelivered()) {
						echo 4;
						return false;
					}

					foreach ($productList AS $key => $id_order_detail)
					{
						//Check if Quantity is entered
						$qtyDeliveredProduct = abs($qtyList[$key]);
						if (!$qtyDeliveredProduct)
							$error[] = 1;	
						
						//Check if Quantity entered is correct
						$order_detail = new OrderDetail($id_order_detail);
						if (($qtyDeliveredProduct < $order_detail->product_quantity))
							$error[] = 1;
					}
					
					if(!sizeof($error))
					{
						//Generate the DR
						
						//Create new delivery number
						// $number = (int)(Configuration::get('PS_DELIVERY_NUMBER'));
						// if (!(int)($number))
						// 	die(Tools::displayError('Invalid delivery number'));
						// Configuration::updateValue('PS_DELIVERY_NUMBER', $number + 1);
						$id_supplier = EliteSupplierOrders::getSupplierByOrderDetail($id_order_detail);
						$supplier = new EliteSupplier($id_supplier);
						$number = $supplier->getDeliveryNumber();
						$prefix = $supplier->getDeliveryPrefix();

						//1. Create new delivery
						$delivery = new Delivery();
						//
						$delivery->id_carrier = 0;
						$delivery->id_zone = 0;
						$delivery->id_shop = 1;
						$delivery->id_shop_group = 1;
						$delivery->price = 0;
						$delivery->id_range_price = 0;
						$delivery->id_range_weight = 0;
						$delivery->dr_prefix = $prefix;
						$delivery->delivery_number = $number;
						$delivery->delivery_date = date('Y-m-d H:i:s');
						$delivery->kob_boxes = $kob_box;
						$delivery->other_boxes = $other_box;
						if($delivery->add()){
							$supplier->setDeliveryNumber($number+1);
						}
						
						//2. Map delivery to order
						$orderDelivery = new OrderDelivery();
						$orderDelivery->id_delivery = $delivery->id;
						$orderDelivery->id_order = $order->id;
						$orderDelivery->add();
						
						//3. Add products & quantity to new delivery
						foreach ($productList AS $key => $id_order_detail)
						{
						
							$qtyDeliveredProduct = abs($qtyList[$key]);
							$order_detail = new OrderDetail($id_order_detail);
							
							$deliveryDetails = new DeliveryDetails();
							$deliveryDetails->id_order = $order_detail->id_order;
							$deliveryDetails->id_delivery = $delivery->id;
							$deliveryDetails->id_product = $order_detail->product_id;
							$deliveryDetails->id_product_attribute = $order_detail->product_attribute_id;
							$deliveryDetails->quantity = $qtyDeliveredProduct;
							$deliveryDetails->add();
							$order_detail->updateQtyDelivered($order_detail->product_quantity_delivered + $qtyDeliveredProduct);
						}
						echo 0;
					}
					else
					{
						echo 1;
					}
				}
				else
				{
					echo 2;
				}
			}
			elseif ($type == 4) // Cancel order products
			{
				$context = Context::getContext();
			    $generateDiscount = Tools::getValue('generateDiscount');
			    $shippingBack = Tools::getValue('shippingBack');
			    $reinjectQuantities = Tools::getValue('reinjectQuantities');
			    $result = $order->cancelProduct($productList, $qtyList, (int)($generateDiscount), (int)($shippingBack), $currency = new Currency($order->id_currency));
				echo Tools::jsonEncode($result);
			}
			elseif ($type == 5) //Return order products
			{
				$error = array();

				if($productList && $qtyList)
				{	
					foreach ($productList AS $key => $id_order_detail)
					{
						$order_detail = new OrderDetail($id_order_detail);

						//Check if Quantity is entered
						$qtyReturnedProduct = abs($qtyList[$key]);
						if (!$qtyReturnedProduct)
							$error[$key]['error'] = 'No quantity selected for product - '.$order_detail->product_name;

						//Check if Quantity entered is correct
						if (($order_detail->product_quantity_delivered < $qtyReturnedProduct)) {
							$error[$key]['error'] = 'Invalid quantity selected for product - '.$order_detail->product_name;
						}
						else
							$order_detail->updateQtyDelivered($order_detail->product_quantity_delivered - $qtyReturnedProduct);
					}
				}
				else
					$error[0]['error'] = 'No products selected.';

				if(sizeof($error) < 1)
					echo 1;
				else {
					$error_def = '';
					foreach ($error as $key => $value) {
						$error_def .= ++$key.'. '.$value['error'].'.<br />';
					}
					echo $error_def;
				}
			}
			elseif($type == 6) //Get order comments for pop-out window
			{
				$msgObj = new Message();
				$msg = $msgObj->getMessagesByOrderId($id_order, true);
				$smarty->assign(array('messages' => $msg, 'conversation' => Tools::getValue('conversation'), 'order_id' => $id_order));
				$smarty->display('scn/scn-orders.tpl');
			}
			elseif($type == 7) //Update fulfillment center to order
			{
				if(isset($fc_single_order) && $fc_single_order != undefined && $fc_single_order != "")
				{
					$old_fc = $order->id_fc;
					$order->id_fc = $fc_single_order;

					if($order->update())
					{
						$employee = new Employee((int)(self::$cookie->id_employee));
						$customer = new Customer((int)($order->id_customer));
						$relationship_manager = new Employee((int)($customer->id_relationship_manager));
						$new_fc = $order->id_fc;
						$fc_old = new FulfillmentCentre((int)($old_fc));
						$fc_new = new FulfillmentCentre((int)($new_fc));
						$fc_head = new Employee((int)($fc_new->id_employee));
						$emp_name = $employee->firstname.' '.$employee->lastname;

						$message =$emp_name.' changed Fulfillment Centre from '.$fc_old->city_name.' to '.$fc_new->city_name.'';
				        $messageObject = new Message();
				        $messageObject->id_employee = self::$cookie->id_employee;
				        $messageObject->message = htmlentities($message, ENT_COMPAT, 'UTF-8');
				        $messageObject->id_order = $order->id;
				        $messageObject->private = 1;
				        $messageObject->add();

						$data = array('{emp_name}'=>$emp_name,					
									  '{order_id}' => $id_order_single,
									  '{fc_old}' => $fc_old->city_name,
									  '{fc_new}' => $fc_new->city_name);

						$em_sub = 'Fulfillment Centre changed - #'.$order->id.' by '.$emp_name.'';

						if($customer->id_relationship_manager != "" && $customer->id_relationship_manager != 0)
						{
							Mail::Send((int)$cookie->id_lang, 'fcChange', Mail::l($em_sub, (int)$cookie->id_lang), $data,  $relationship_manager->email, 'Supply Chain Team', NULL, NULL, NULL);
						}
						else
						{
							Mail::Send((int)$cookie->id_lang, 'fcChange', Mail::l($em_sub, (int)$cookie->id_lang), $data,  'support@kobster.com', 'Supply Chain Team', NULL, NULL, NULL);
						}

						if($fc_head->email != "")
						{
							Mail::Send((int)$cookie->id_lang, 'fcChange', Mail::l($em_sub, (int)$cookie->id_lang), $data,  $fc_head->email, 'Supply Chain Team', NULL, NULL, NULL);
						}

						Mail::Send((int)$context->cookie->id_lang, 'fcChange', Mail::l($em_sub, (int)$cookie->id_lang), $data,  'scn.operations@kobster.com', 'Supply Chain Team', NULL, NULL, NULL);

						Mail::Send((int)$cookie->id_lang, 'fcChange', Mail::l($em_sub, (int)$cookie->id_lang), $data,  'ops
							@kobster.com', 'Supply Chain Team', NULL, NULL, NULL);

						echo 1;
					}
					else
						echo 0;
				}

			}
			elseif($type == 8) //Update estimated delivery time to order
			{
				if(isset($estimated_delivery_time) && $estimated_delivery_time != undefined && $estimated_delivery_time != "")
				{
					$array_date = explode('$', $estimated_delivery_time);
					$old_estimated_delivery_time = $order->estimated_delivery_time;
					$order->estimated_delivery_time = implode(' ', $array_date);

					if($order->update())
					{
						$employee = new Employee((int)(self::$cookie->id_employee));
						$customer = new Customer((int)($order->id_customer));
						$group = new Group($customer->id_default_group, $this->context->cookie->id_lang);
						$relationship_manager = new Employee((int)($customer->id_relationship_manager));
						$fc = new FulfillmentCentre((int)($order->id_fc));
						$fc_head = new Employee((int)($fc->id_employee));
						$new_estimated_delivery_time = $order->estimated_delivery_time;
						$emp_name = $employee->firstname." ".($employee->lastname) ? $employee->lastname : '';
						$message =$emp_name.' changed Estimated Delivery Time from '.$old_estimated_delivery_time.' to '.$new_estimated_delivery_time.'';
	                    $messageObject = new Message();
	                    $messageObject->id_employee = self::$cookie->id_employee;
	                    $messageObject->message = htmlentities($message, ENT_COMPAT, 'UTF-8');
	                    $messageObject->id_order = $order->id;
	                    $messageObject->private = 1;
	                    $messageObject->add();

						$varsTpl = array(
							'{id_order}' => $order->id, 
							'{emp_name}' => $employee->firstname, 
							'{new_estimated_delivery_time}' => $new_estimated_delivery_time, 
							'{old_estimated_delivery_time}' => $old_estimated_delivery_time, 
							'{customer_name}' => $customer->firstname." ".$customer->lastname." / ".$group->name);

						if($customer->id_relationship_manager != "" && $customer->id_relationship_manager != 0)
						{
							Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, $relationship_manager->email,
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						}
						else
						{
							Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, 'support@kobster.com',
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						}

						if($fc_head->email != "")
						{
							Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, $fc_head->email,
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						}

						Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, 'ops@kobster.com',
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, 'lingakani.g@kobster.com',
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, 'narayan.s@kobster.com',
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						Mail::Send((int)($order->id_lang), 'estimated-delivery-time-change',
								Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $employee->firstname, (int)($order->id_lang)), $varsTpl, 'irthu.suresh@kobster.com',
								'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);
						echo 1;
					}
					else
						echo 0;
				}
			}
			elseif($type==9)//SET Carrier and tracking number to a particular order
			{
 				
				$order->id_carrier = Tools::getValue('id_carrier');
				$order->shipping_number = Tools::getValue('tracking_number');
				$order_carrier = new OrderCarrier(Tools::getValue('id_carrier'));
				
				
				
				
				$carrier = new Carrier(Tools::getValue('id_carrier'), 1);
				$customer = new Customer((int)$order->id_customer);
 				
				
				
				$order_carrier->UpdateOrderCarrier($order->id,Tools::getValue('id_carrier'),Tools::getValue('tracking_number')); 
				
				//$order_carrier->update();
 				if ($order->update())
				{
					$message ='This order was shipped through '.$carrier->name.' with the tracking ID '.Tools::getValue('tracking_number');
                    $messageObject = new Message();
                    $messageObject->id_employee = self::$cookie->id_employee;
                    $messageObject->message = htmlentities($message, ENT_COMPAT, 'UTF-8');
                    $messageObject->id_order = $order->id;
                    $messageObject->private = 1;
                    $messageObject->add();

					 $templateVars = array(
                            '{followup}' => str_replace('@', $order->shipping_number, $carrier->url),
                            '{firstname}' => $customer->firstname,
                            '{lastname}' => $customer->lastname,
                            '{id_order}' => $order->id,
                            '{shipping_number}' => $order->shipping_number,
                            '{trackingid}' => $order->shipping_number,
                            '{order_name}' => $order->getUniqReference()
                        );
						 echo 1;
						 if($customer->id_buyer == 10 && @Mail::Send((int)$order->id_lang, 'perks_in_transit', Mail::l('Package in transit', (int)$order->id_lang), $templateVars, $customer->email, $customer->firstname.' '.$customer->lastname, null, null, null, null,_PS_MAIL_DIR_, true, (int)$order->id_shop))
                        {
                            Hook::exec('actionAdminOrdersTrackingNumberUpdate', array('order' => $order, 'customer' => $customer, 'carrier' => $carrier), null, false, true, false, $order->id_shop);
                            //Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=4&token='.$this->token);
                        }
                        elseif (@Mail::Send((int)$order->id_lang, 'in_transit', Mail::l('Package in transit', (int)$order->id_lang), $templateVars,
                            $customer->email, $customer->firstname.' '.$customer->lastname, null, null, null, null,
                            _PS_MAIL_DIR_, true, (int)$order->id_shop)) {
                            Hook::exec('actionAdminOrdersTrackingNumberUpdate', array('order' => $order, 'customer' => $customer, 'carrier' => $carrier), null, false, true, false, $order->id_shop);
                            //Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=4&token='.$this->token);
                        }
				}
				else
				{
					echo 0;
				}
			}
			elseif($type == 10){
				echo Tools::jsonEncode(Order::SplitOrderDetail($id_order));
			}
		}
	}
	public function getInvoiceFile($number)
	{
		if(file_exists('Invoice-ACK/'.$number.'.png'))
		{
			return 'Invoice-ACK/'.$number.'.png';
		}
		else if(file_exists('Invoice-ACK/0'.$number.'.png'))
		{
			return 'Invoice-ACK/'.$number.'.png';
		}
		else
		{
			return false;
		}
	}
}



 