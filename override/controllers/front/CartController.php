<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14006 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class CartController extends CartControllerCore
{	
	public function mulProductAdd($product, $idProduct, $idSupplier, $qty, $split_order = false)
	{
 		$add = 1;
		$delete = 0;		
		$errors_m = array();
		
		if($product != 0)
		{
			if(!$idProduct){
				$idProduct = $product['id_product'];	
			}
			
			$idProductAttribute = $product['id_product_attribute'];
			if(!$qty){
				$qty = $product['quantity'];
			}
		}

		if(!isset($this->context)) {
			$context = Context::getContext();
			$this->context = $context;
		}

		if(!isset($this->context->cart->id)) {
			$cart = new Cart();
			if($cart->add()) {
				$this->context->cart = $cart;
				$this->context->cookie->id_cart = $cart->id;
			}
		}
		
		//set carrier to cart for Elite
		$this->context->cart->id_carrier = Configuration::get('PS_CARRIER_DEFAULT');
		if(!$this->context->cart->region && isset($this->context->cookie->delivery_region)) {
			$this->context->cart->region = intval($this->context->cookie->delivery_region);	
		}

		if(isset($this->context->cookie->id_address_budget) && $this->context->cookie->id_address_budget) {
			$this->context->cart->id_address_delivery = $this->context->cookie->id_address_budget;
		}
				
		$this->context->cart->update();
		if ($qty == 0)
		{
				$errors_m = 'Null quantity';
				$this->context->cart->deleteProduct($idSupplier,$idProduct,$idProductAttribute);
		}
		elseif($test = preg_match("/^[0-9]+$/", $number) && !$test){
			$errors_m = array("name" => $producToAdd->name, "msg" =>'Enter valid quantity');
		}
		elseif (!$idProduct)
		{
				$errors_m = 'Product not found';
		}
		elseif($this->context->cart->checkSameProductSupplier($idSupplier, $idProduct))
		{
		    $producToAdd = new Product((int)($idProduct), true, (int)($this->context->cookie->id_lang));
		    $errors_m = array("name" => $producToAdd->name, "msg" =>'The product is already in cart with different supplier');
		}
		else
		{
			$producToAdd = new Product((int)($idProduct), true, (int)($this->context->cookie->id_lang));
			// Budgeting system block created by Elumalai K...
			if(!$split_order) {

				if($this->context->cookie->delivery_region) {
					$product_na = EliteSupplierProducts::checkAvailabillity($idSupplier, $idProduct);
					if($product_na) {
						$errors_m = array("name" => $producToAdd->name, "msg" =>'The product is not available with '.$product_na);
					}
				}

				if($this->context->cookie->budget_configured == 1) 
				{
					$id_address_budget = $this->context->cookie->id_address_budget;
					$id_option_budget = $this->context->cookie->budget_option;

					if($id_option_budget == 1) {
						$purchaseOrderObj = new PurchaseOrder();
						$purchaseOrderProduct = $purchaseOrderObj->getPurchaseOrderProducts($id_address_budget, $id_option_budget, true, $idProduct);
						if($purchaseOrderProduct[0]['id_product'] != "") {
							if($purchaseOrderProduct[0]['available_quantity'] < $qty)
								$errors_m = array("name" => $producToAdd->name, "msg" => "Expense limit exceeded. Available limit is ".$purchaseOrderProduct[0]['available_quantity']);
						}
						else {
							$errors_m = array("name" => $producToAdd->name, "msg" => 'Product is not present in PO');
						}
					}
					else if($id_option_budget == 2) {
						$purchaseOrderObj = new PurchaseOrder($this->context->cookie->id_purchase_order);
						if($purchaseOrderObj->isAddressPoConfigured($id_address_budget, $id_option_budget, true)) 
						{
							$result = Product::getProductQuickviewDetails($idProduct, $idSupplier, $this->context->customer->id);
							$product_data = Product::getProductsPropertiesSupplier(1, $result);

							$totalPrice = ($product_data[0]['price_tax_exc'] * (1 + ($product_data[0]['rate'] / 100))) * $qty;

							$purchaseOrderValues = $purchaseOrderObj->getPurchaseOrderValues((int)($id_address_budget), $id_option_budget);
							$cartProducts = $this->context->cart->getProducts();
							
							$cartTotal = 0;
							foreach ($cartProducts as $product) {
								if((int)$product['id_product'] != (int)$idProduct) {
									$cartTotal += $product['total_wt'];
								}
							}

							(float)$totalCartValue = ($cartTotal + $totalPrice);
							
							if(date('Y-m-d H:i:s', strtotime($purchaseOrderObj->valid_from)) > date('Y-m-d H:i:s')) {
								$errors_m = array(
			  						"name" => $producToAdd->name, 
			  						"msg" => 'PO ('.$purchaseOrderObj->po_number.') is valid from '.$purchaseOrderObj->valid_from.'. Please change your PO or configure new PO.'
			  					);
							}
							else if($totalCartValue > (float)$purchaseOrderValues[0]['available_value']) {
				  				$errors_m = array(
			  						"name" => $producToAdd->name, 
			  						"msg" => 'Your cart value exceeds the expense limit. Please review your order or change PO.'
			  					);
				  			}
						}
						else {
							$errors_m = array(
		  						"name" => $producToAdd->name, 
		  						"msg" => 'PO is not valid or expired for the selected address.'
		  					);
						}
					}
				}
			}
			if (!sizeof($errors_m)){
				if ($add AND $qty >= 0){
					/*if the product exist then it will delete the product in cart*/
					$ext_product = $this->context->cart->containsProduct($idSupplier, $idProduct,$idProductAttribute,0);
					if($ext_product)
					{
						$this->context->cart->deleteProduct($idSupplier, $idProduct,$idProductAttribute);
					}
					
					if ($add AND !$producToAdd->hasAllRequiredCustomizableFields()  )
					{
						$errors_m = array('Please fill in all required fields, then save the customization.');
					}

					if (!sizeof($errors_m))
					{
						$updateQuantity = $this->context->cart->updateQty((int)($qty),(int)($idSupplier), (int)($idProduct), (int)($idProductAttribute), 0, Tools::getValue('op', 'up'));							
						if ($updateQuantity < 0){
							/* if product has attribute, minimal quantity is set with minimal quantity of attribute*/
							if ((int)$idProductAttribute)
								$minimal_quantity = Attribute::getAttributeMinimalQty((int)$idProductAttribute);
							else
								$minimal_quantity = $producToAdd->minimal_quantity;
								
							if( $minimal_quantity == $qty || $minimal_quantity > $qty)
								$errors_m = array("name" => $producToAdd->name, "msg" => 'You must add'.' '.$minimal_quantity.' '.'Minimum quantity');
						}
					}						
				}
			}
		}

		$this->context->cart->update();

		if (sizeof($errors_m))
 			return $errors_m;
		else
			return array("msg" => 'success');
 	}

 	public function ajaxReturn()
	{
		$type = Tools::getValue('type');

		if($type == 1) 
		{
			$order = new Order(Tools::getValue('id_order'));
			$productList = Tools::getValue('id_order_detail');
			$qtyList = Tools::getValue('cancelQuantity');
			$generateDiscount = Tools::getValue('generateDiscount');
		    $shippingBack = Tools::getValue('shippingBack');
		    $reinjectQuantities = Tools::getValue('reinjectQuantities');
		    $po_number = Tools::getValue('po_number');
		    $po_file = Tools::getValue('po_file');
		    $check = $order->emptiesCart($productList, $qtyList);
			$split_order = Tools::getValue('split_order');
			$id_employee = Tools::getValue('id_employee');

		    $orderHistory = $order->getHistory(1);
	        $order_states=array_column($orderHistory, 'id_order_state');


	        if(in_array(OrderState::FLAG_DELIVERY, $order_states)){
				$result = json_encode(array('error'=>'Sorry you cannot update quantity while your order status is Shipped or Delivered'));
			    echo $result;
			    return false;
	        }
	        else if(in_array(OrderState::FLAG_SHIPPED, $order_states)){
				$result = json_encode(array('error'=>'Sorry you cannot update quantity while your order status is Shipped or Delivered'));
			    echo $result;
			    return false;
	        }
	        
		    if($check == '404')
		    {
		    	$result = json_encode(array('error'=>'Sorry something went wrong, Please contact your Relationship Manager'));
			    echo $result;
		    	return false;
		    }
		    else if($check == '200')
			{	
				$split_order = isset($split_order) && $split_order == "true" ? true : false;
				$po_option = PurchaseOrder::orderExists($order->id);
				if($po_option) {
					if($po_option == 1) {
						$poProductsOld = PurchaseOrder::getPoHistoryProducts($order->id);
					}
					else if($po_option == 2) {
						$poValuesOld = PurchaseOrder::getPoHistoryValues($order->id);
					}
				}

				/* Set cookie to use it in payment module. will be unset end of code */
				if(isset($id_employee) && $id_employee) {
					$this->context->cookie->id_employee = $id_employee;
				}

				$reorderResult = $this->reOrder(Tools::getValue('id_order'), $productList, $qtyList, $split_order);

				if($reorderResult && $reorderResult > 1){

					$result = $order->cancelProduct($productList, $qtyList, (int)($generateDiscount), (int)($shippingBack), $currency = new Currency($order->id_currency));
                    
					if($result == 5 || $result == 0)
					{
						/* Unset id_employee cookie from context */
						$id_employee = $this->context->cookie->id_employee;
						$this->context->cookie->__unset('id_employee');
						
						//get cart information
						$cart_detail = new Cart((int)($this->context->cart->id));
                        $id_order = $reorderResult;
						$order_new = new Order($id_order);
						$order_total = $order_new->getOrdersTotalPaid();
                        Order::addSplitOrderDetail($id_order,$order->id);
						if(isset($po_file) && !$po_option)
						{
							$old_file_po = 'customer_PO/'.$po_file;
							$ext = pathinfo($old_file_po, PATHINFO_EXTENSION);
							$new_file_po = 'customer_PO/'.$order_new->id.'-PO.'.$ext;

							if (!copy($old_file_po, $new_file_po)) {
							    //echo "Issue in po upload";
							}
						}

						if($po_option) {
							$purchaseOrderObj = new PurchaseOrder();	
							$order_new->po_number = $order->po_number;						
							if($po_option == 1) /*** Purchase orders product based - Quantities updation***/
							{
								$products = $order_new->getProductsDetail();

								foreach ($products as $key => $product) 
								{
									$quantity_ordered = $product['product_quantity'];

									foreach ($poProductsOld as $key => $poProduct) 
									{
										if($product['id_product'] == $poProduct['id_product']) 
										{
											if($poProduct['quantity'] > 0) 
											{
												if($poProduct['quantity'] <= $quantity_ordered) 
													$quantity_to_insert = $poProduct['quantity'];
												else if($poProduct['quantity'] > $quantity_ordered) 
													$quantity_to_insert = $quantity_ordered;

												$quantity_ordered = $quantity_ordered - $quantity_to_insert;

												$data = array('id_purchase_order' => $poProduct['id_purchase_order'], 'id_order' => $product['id_order'],
														'id_product' => $product['id_product'],
														'quantity' => $quantity_to_insert);

												$insert_quantity_to_history = Db::getInstance()->insert('po_products_history', $data);
												
												if($quantity_ordered == 0)
													break;
											}
										}
									}
								}
							}
							else if($po_option == 2) /*** Purchase orders value based - values updation***/
							{
								$value_ordered = $order_total;

								foreach ($poValuesOld as $key => $poValue) 
								{
									if($poValue['value'] > 0) 
									{
										if($poValue['value'] <= $value_ordered) 
											$value_to_insert = $poValue['value'];
										else if($poValue['value'] > $value_ordered) 
											$value_to_insert = $value_ordered;

										$value_ordered = $value_ordered - $value_to_insert;
										
										$data = array('id_purchase_order' => $poValue['id_purchase_order'], 'id_order' => $id_order, 'value' => $value_to_insert);

										$insert_value_to_history = Db::getInstance()->insert('po_values_history', $data);
										
										if($value_ordered == 0)
											break;
									}
								}
							}
						}
						else if($po_number != "") {
							$order_new->po_number = $po_number;
						}

						if($order_new->po_number != "") {
							$order_new->update();
						}

						//$newfile = 'customer_PO/'.$order_new->id.'-PO.*';

						// Order comment trigger when order was splitted
						if(isset($order_new) && Validate::isLoadedObject($order_new)) {
							$old_order_message = "This order #".$order->id." has been split into new order #".$order_new->id;
							$message = new Message();
							$message->id_employee = $id_employee;
							$message->message = htmlentities($old_order_message, ENT_COMPAT, 'UTF-8');
							$message->id_order = $order->id;
							$message->private = 1;
							if($message->add()) {
								$new_order_message = "This order #".$order_new->id." was split from order #".$order->id;
								$messge = new Message();
								$message->id_employee = $id_employee;
								$message->message = htmlentities($new_order_message, ENT_COMPAT, 'UTF-8');
								$message->id_order = $order_new->id;
								$message->private = 1;
								$message->add();
							}
						}
						
						$products = $order_new->getProductsDetail((int)($id_order));
						$products_old = $order->getProductsDetail((int)($order->id));
						$product_details = "";
						foreach($products as $product){
							$product_details .= "<tr>
													<td>".$product['reference']."</td>
													<td>".$product['product_name']."</td>
													<td>".$product['unit_price_tax_excl']."</td>
													<td>".$product['product_quantity']."</td>
												</tr>";
						}
						$fc = new FulfillmentCentre($order->id_fc);
						$fc_head = new Employee($fc->id_employee);
						$customer = new Customer($order->id_customer);
						$cus_rm = new Employee($customer->id_relationship_manager);
						$employee = new Employee($id_employee);
						$result = array(
										'id_order' => $id_order,
										'order_value' => $order_total,
										'products' => sizeof($products),
										'products_old' => sizeof($products_old)
										);
						$data = array(
							'{new_order}' => $order_new->id,
							'{old_order}' => $order->id,
							'{product_details}'=> $product_details,
							'{fc}' => $fc->city_name,
							'{customer}' => $customer->email,
							'{employee}' => $employee->email,
							'{rm}' => $cus_rm->firstname,
							);
						$subject = 'Order #'.$order->id.' has been splitted';
						$to_address = array($cus_rm->email, $fc_head->email);
						Mail::Send(1, 'split_order', $subject, $data, $to_address);
						echo $id_order.'~'.$order_total.'~'.sizeof($products).'~'.sizeof($products_old);
					}
					else
					{
						$result = json_encode(array('error'=>'Sorry something went wrong, Please contact your Relationship Manager'));
					    echo $result;
				    	return false;
					}
				}
				else
				{
					$result = json_encode(array('error'=>'Sorry something went wrong, Please contact your Relationship Manager'));
				    echo $result;
			    	return false;
				}
			}
		}
	}

	function reOrder($id_order, $order_detail_list, $qty_list, $split_order) {
		$context = Context::getContext();
		$old_order = new Order($id_order);
		$customer = new Customer($old_order->id_customer);
		$address = new Address($old_order->id_address_delivery);
		$state = new State($address->id_state);
		$context->customer = $customer;
		$context->cookie->id_customer = $customer->id;
		$old_cart = Order::getCartIdStatic((int)$id_order, (int)$old_order->id_customer);
		$oldCart = new Cart(intval($old_cart));
		$product_list ='';
		$product_attribute_list='';
		$quantity_list = array();
		/**product list and quantity ordering**/
		foreach($order_detail_list as $key => $id_order_detail)
		{
			$orderDetail = new OrderDetail($id_order_detail);
			$product_list = $product_list.$orderDetail->product_id.',';
			$product_attribute_list = $product_attribute_list.$orderDetail->product_attribute_id.',';
			$quantity_list[$orderDetail->product_id] = abs($qty_list[$key]);
		}
		$product_list = rtrim($product_list,',');
		$product_attribute_list = rtrim($product_attribute_list,',');
		$product = $oldCart->getCartProducts($oldCart->id,$product_list, $product_attribute_list);
		
		if(empty($product))
		{
			return "Error occured in your cart, Please contatct admin";
		}

		$context->cart->id_customer = $old_order->id_customer;
		$context->cookie->id_state_vat= $state->id;
		$context->cookie->name_state_vat= $state->name;
		$context->cart->id_address_delivery = $old_order->id_address_delivery;
		$context->cart->id_address_invoice = $old_order->id_address_invoice;
		$context->cookie->delivery_region = $old_order->id_fc;
		$context->cart->save();
		$delivery_option = array($old_order->id_address_delivery => $oldCart->id_carrier);
		$result= array();

		for($i=0; $i < sizeof($product); $i++ )
		{
			  $final_result=ControllerFactory::getController('CartController')->mulProductAdd($product[$i], $product[$i]['id_product'], $context->cookie->s_id, $quantity_list[$product[$i]['id_product']], $split_order);
			  if($final_result['msg'] != 'success')
	          {
    		      return $final_result[0]['msg'];
	          }
		}
		
		$total = (float)$context->cart->getOrderTotal(true, Cart::BOTH);
		$cartUpdated = 1;
		$Payments = new DashPaymentMode();
		$mailVars = array();

		if($cartUpdated){
			
			if($old_order->release_order == 1){
				$this->context->cookie->release_order= 1;
			}
			else{
				$this->context->cookie->release_order= 0;
			}

			if($old_order->payment == 'Cheque'){
				$result = $Payments->Cheque((int)$context->cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, $old_order->payment,$mailVars, (int)$context->currency->id,$customer->secure_key, $split_order);
			}
			elseif($old_order->payment == 'Cash on delivery (COD)')
			{
				$result = $Payments->cashOnDelivery((int)$context->cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, $old_order->payment,$mailVars, (int)$context->currency->id,$customer->secure_key, $split_order);
			}
			elseif($old_order->payment == 'Bank Wire')
			{
				$result = $Payments->NEFT((int)$context->cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, $old_order->payment,$mailVars, (int)$context->currency->id,$customer->secure_key, $split_order);
			}
			elseif($old_order->payment == 'Credit')
			{
				$result = $Payments->Credit((int)$context->cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, $old_order->payment,$mailVars, (int)$context->currency->id,$customer->secure_key, $split_order);
			}
			elseif($old_order->payment == 'EBS')
			{
				$result = $Payments->EBS((int)$context->cart->id,Configuration::get('PS_OS_ORDERPLACED'), $total, $old_order->payment,$mailVars, (int)$context->currency->id,$customer->secure_key, $split_order);
			}
		}
        $this->context->cookie->release_order = 0;
		return $result[0];
	}
}