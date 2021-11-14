<?php
class SupplierOrdersControllerCore extends FrontController
{
 	public function  ajaxReturn(){
 		$this->context = Context::getContext();
		$type = Tools::getValue('type');
 		$limit= $_GET['limit'];
		$offset= $_GET['offset'];
		$fromDate= $_GET['fromDate'];
		$toDate= $_GET['toDate'];        	
		$idPage= $_GET['idPage'];
		$orderBy= $_GET['orderBy'];
		$orderWay= $_GET['orderWay'];
		$q= trim($_GET['q']);
		$id_order = $_GET['id_order'];
		$id_order_state = $_GET['id_order_state'];
		$date = $_GET['date'];
		$list = $_GET['list'];
		$status = $_GET['status'];
		$id_group = $_GET['idGroup'];

 		$id_supplier = $this->context->cookie->s_id;
        $supplier_order = new EliteSupplierOrders($id_supplier);
		 
 		if($type ==1){
 			$limit ? define('PAGE_PER_NO', $limit) : define('PAGE_PER_NO', 10);
			$offset = (PAGE_PER_NO * intval($idPage));
			$orders = $supplier_order->getOrders($limit, $offset, $fromDate, $toDate, $idPage, $orderBy, $orderWay, $q, $status, $id_group);
			$counts = $supplier_order->getOrdersCount();

			$order_states = $supplier_order->getOrdersCountWithStates();
			$customers = $supplier_order->getCustomersOrderCount();
 			$result = json_encode(
						array(
 							'orders'=> $orders, 
							 'order_count'=> $counts,
							 'order_states'=> $order_states,
							 'customers' => $customers,
						));
 			echo $result;
 		}
 		if($type ==2){
 			$result = json_encode($supplier_order->getOrderDetails($id_order));
 			echo $result;
 		}
 		if($type ==3){
 			$order = new Order($id_order);
 			$customer = new Customer($order->id_customer);
 			$employee = new Employee($customer->id_relationship_manager);
 			$use_existings_payment = false;

	        if (!$order->hasInvoice()){
	            $use_existings_payment = true;
	        }
	        $orderHistory = $order->getHistory(1);
	        $order_states=array_column($orderHistory, 'id_order_state');

	        if(in_array($id_order_state, $order_states)){
				$result = json_encode(array('error'=>'The status already exists, please select next status'));
			    echo $result;
			    return false;
	        }

 			$history = new OrderHistory();
            $history->id_order = $order->id;
            $history->id_employee = $id_supplier;
            $templateVars = array();
 			$history->changeIdOrderState($id_order_state, $order, $use_existings_payment);
            if ($history->addWithemail(true, $templateVars, $internal_mail)) 
            {
            	if($id_order_state == OrderState::FLAG_READY_TO_SHIP){
					//Create new delivery number
					$supplier = new EliteSupplier($id_supplier);
					$number = $supplier->getDeliveryNumber();
					$prefix = $supplier->getDeliveryPrefix();

					//1. Create new delivery
					$delivery = new Delivery();
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
					$delivery->kob_boxes = 1;
					$delivery->other_boxes = 1;
					if($delivery->add()){
						$supplier->setDeliveryNumber($number+1);
					}
					
					//2. Map delivery to order
					$orderDelivery = new OrderDelivery();
					$orderDelivery->id_delivery = $delivery->id;
					$orderDelivery->id_order = $order->id;
					$orderDelivery->add();
					
					//3. Add products & quantity to new delivery
					$products = $order->getProductsDetail();        
					$dr_generate =1;
					foreach ($products AS $key => $product)
					{
						$deliveryDetails = new DeliveryDetails();
						$deliveryDetails->id_order = $product['id_order'];
						$deliveryDetails->id_delivery = $delivery->id;
						$deliveryDetails->id_product = $product['product_id'];
						$deliveryDetails->id_product_attribute = $product['product_attribute_id'];
						$deliveryDetails->quantity = $product['product_quantity'];
						if($deliveryDetails->add()){
							$order_detail = new OrderDetail($product['id_order_detail']);
							$order_detail->updateQtyDelivered($order_detail->product_quantity);
						}
						else{
							$dr_generate =0;
						}
					}
				}
				if($id_order_state != 19 && $id_order_state != 6 && $id_order_state != 25){
					OrderHistory::checkParentOrderStatus($id_order, $id_order_state, $id_supplier);
				}
				$success_msg ="Order status updated successfully";
				if($id_order_state == 19){
				    $success_msg = "Order Accepted Successfully";    
				}
				if($id_order_state == 6){
				    $success_msg = "Order Cancelled Successfully";    
				}
				if($id_order_state == 25){
					$success_msg = "Invoice created Successfully";    	
				}
				if($id_order_state == 20){
					$success_msg = "Delivery Receipt created and status updated Successfully";    	
				}

	            $result = json_encode(
	            					array(
	            						'success'=>$success_msg,
            							'dr_generate'=>$dr_generate
            							)
	            					);
			    echo $result;    
            }
            else{
            	$result = json_encode(array('error'=>'Something went wrong, please contact your RM'));
			    echo $result;
            }
 		}
 		if($type ==4){

 			$order = new Order($id_order); 			
 			$old_estimated_delivery_time = $order->estimated_delivery_time;
 			$new_estimated_delivery_time = $date;
 			if(strtotime($old_estimated_delivery_time) >= strtotime($new_estimated_delivery_time)){
 				$result = json_encode(array('error'=>'Please check your EDT date'));
 				echo $result;
 				return false;
 			}
 			else{
 				$order->estimated_delivery_time = $date;	
 			} 			
 			
 			if($order->update()){
 				
 				$supplier_obj = new EliteSupplier($id_supplier);
 				$customer = new Customer($order->id_customer);
 				$group = new Group($customer->id_default_group);

 				$varsTpl = array(
							'{id_order}' => $order->id, 
							'{emp_name}' => $supplier_obj->name, 
							'{new_estimated_delivery_time}' => $new_estimated_delivery_time, 
							'{old_estimated_delivery_time}' => $old_estimated_delivery_time,
							'{receiver_name}' => $customer->firstname." ".$customer->lastname,
							'{customer_name}' => $customer->firstname." ".$customer->lastname,
							'{customer_company}' => $group->name[1]);

 				Mail::Send(
 							(int)($order->id_lang), 
 							'estimated-delivery-time-change',
 							Mail::l('Estimated Delivery Time Changed - #'. $order->id .' by '. $supplier_obj->name, 1), 
 							$varsTpl, $customer->email,'alert', NULL, NULL, NULL, NULL, _PS_MAIL_DIR_, true);

 				$result = json_encode(array('success'=>'Estimated delivery time updated successfully'));
 				echo $result;
 			}
 			else{
 				$result = json_encode(array('error'=>'Process failed, please try again later'));
 				echo $result;
 			}
 		}
 		if($type == 5){
 			$order = new Order($id_order);
 			echo json_encode($order->getHistory(1));
 		}
 		if($type == 6){
 			$order = new Order($id_order);
 			
 			/** check order status **/
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
 			
 			$i=0;
 			foreach($list as $l){
 				$data = explode('~', $l);
 				$productList[$i]=$data[0];
 				$qtyList[$i]=$data[1];
 				$i++;
 			}
 			$result = $order->cancelProduct($productList, $qtyList, null, null, $currency = new Currency($order->id_currency));
 			
 			if($result == 0 || $result == 5){
 				$result = json_encode($supplier_order->getOrderDetails($id_order));
 				echo $result;
 			}
 			else{
 				if($result){
 					$result = json_encode(array('error'=>$result));
				    echo $result;
 				}
 				else{
	 				$result = json_encode(array('error'=>'Sorry something went wrong, please contact your Relationship Manager'));
				    echo $result;
				}
			    return false;
 			}
		}
		if($type == 7){

			$delivered_date = Tools::getValue('dr_date');
			$id_order = Tools::getValue("id_order");
			$delivery_id = Tools::getValue("id_delivery");
			$delivery_object = new Delivery((int)($delivery_id));
			$allowed =  array('PNG','gif','png' ,'jpg','docx','doc','pdf','rtf','zip');

			//DR Scanned copy upload section
			if($_FILES['dr_files']){
				$total_drs = count($_FILES['dr_files']['name']);
				for( $i=0 ; $i < $total_drs ; $i++ ) {
					$filename = $_FILES['dr_files']['name'][$i];
					$temp_name = $_FILES['dr_files']['tmp_name'][$i];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed)) {
						$result = json_encode(array('error'=>'Invalid file type uploaded'));
						echo $result;
						return false;
					}
					else{
						$splitName = explode(".", $filename);
						$fileExt = end($splitName);
						$generateFilename = $delivery_object->generateFilename();
						if(count($splitName) > 1)
							$newFileName  = strtolower($generateFilename.'_'.($i+1).'.'.$fileExt);  
						else
							$newFileName  = strtolower($generateFilename.'_'.($i+1));

						if(move_uploaded_file($temp_name, "scanedDRs/".$newFileName)){
							$delivery_object->dr_file_name = $generateFilename;
							$delivery_object->update();
						}
					}
				}
			}

			//Invoice Scanned Copy upload section
			if($_FILES['invoice_files']){
				$total_invoices = count($_FILES['invoice_files']['name']);
				for( $i=0 ; $i < $total_invoices ; $i++ ) {
					$filename = $_FILES['invoice_files']['name'][$i];
					$temp_name = $_FILES['invoice_files']['tmp_name'][$i];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed)) {
						$result = json_encode(array('error'=>'Invalid file type uploaded'));
						echo $result;
						return false;
					}
					else{
						$splitName = explode(".", $filename);
						$fileExt = end($splitName);
						$filePath = _PS_ROOT_DIR_.'/Invoice-ACK/'.$delivery_id.'_'.($i+1).'.'.$fileExt;
						if(move_uploaded_file($temp_name, $filePath)){
							$delivery_object->dr_file_name = $generateFilename;
							$delivery_object->update();
						}
					}
				}
			}
			//update Status to delivered and pending payment
			$date=date_create($delivered_date);
            $delivered_date = date_format($date,'Y-m-d H:i:s');
			$order = new Order($id_order);
			$history = new OrderHistory();
            $history->id_order = $order->id;
            $history->id_employee = $id_supplier;
            $history->date_add = $delivered_date;
            $templateVars = array();
 			$history->changeIdOrderState(OrderState::FLAG_DELIVERY , $order, $use_existings_payment);
            if ($history->addWithemail(false, $templateVars, $internal_mail)) 
            {
            	$history_new = new OrderHistory();
				$history_new->id_order = $order->id;
				$history_new->id_employee = $id_supplier;
				$status = OrderState::FLAG_PENDING_PAYMENT;
				$history_new->changeIdOrderState($status,$order);	
				if($history_new->save()){
					OrderHistory::checkParentOrderStatus($id_order, $id_order_state, $id_supplier);
					$result = json_encode(array('success'=>'Order Status Updated successfully'));
					echo $result;	
				}

            }	
		}
		if($type == 8){
			$order = new Order($id_order);
			$date = Tools::getValue("date");
			$date = date_create($date);
            $delivered_date = date_format($date,'Y-m-d H:i:s');

			$history = new OrderHistory();
			$history->id_order = $order->id;
			$history->id_employee = $id_supplier;
			$history->date_add = $delivered_date;
			$history->changeIdOrderState(OrderState::FLAG_ORDER_COMPLETED,$order);
			$templateVars = array();
			if ($history->addWithemail(false, $templateVars, $internal_mail)){
				OrderHistory::checkParentOrderStatus($id_order, OrderState::FLAG_ORDER_COMPLETED, $id_supplier);
				$result = json_encode(array('success'=>'Order Completed successfully'));
				echo $result;					
			}
		}
		if($type == 9){
			//Get Delivery Plan
			$order = new Order($id_order);
			$customer = new Customer($order->id_customer);
			$parent_order = $id_order;

			$deliveryPlan = $order->getDeliveryPlans();
			$removedProducts = $order->getRemovedProducts();
			$table = "";
			$order_ref = 0;
			foreach($deliveryPlan as $plan) {
					$order_ref = $plan[0]['id_order'];
					$ref = $plan[0]['reference'];
					$pd =  $plan[0]['estimated_delivery_time'];
					$table .= "<div style='display: inline-block;padding: 8px 0;font-size: 14px;'><div>Reference: <span style='font-weight: bold;color:#383838;'>".$ref."</span></div><div>Delivery Planned: <span style='font-weight: bold;color:#383838;'>".$pd."</span></div></div>";
					$table .= "<table style='width:100%;font-size:14px;color:#323232;margin-bottom: 16px;'>
								<thead>
								<tr style='background-color:#f5f5f5;text-align:center;'>
									<th style='width:15%;padding:.6em 0;'>Reference</th>
									<th style='width:35%;padding:.6em 1em;text-align: left;'>Product</th>
									<th style='width:30%;padding:.6em 0;'>Unit price<br>(Tax Incl)</th>
									<th style='width:20%;padding:.6em 0;'>Quantity</th>
								</tr>
								</thead>
								<tbody>";
				foreach ($plan as $data) {
					$table .= "<tr style='text-align:right;'>
						<td style='background-color:#ffffff;padding:.6em .4em;text-align: center;'>".$data['product_reference']."</td>
						<td style='background-color:#ffffff;padding:.6em .4em;text-align: left;'>".$data['product_name']."</td>
						<td style='background-color:#ffffff;padding:.6em .4em;text-align: right;'>".$data['unit_price_tax_incl']."</td>
						<td style='background-color:#ffffff;padding:.6em .4em;text-align: center;'>".$data['product_quantity']."</td>
					</tr>";
				}
				$table .= "</tbody></table>";
			}
			if ($removedProducts != false) {
				$table .= "<div style='display: inline-block;padding: 8px 0;font-size: 14px;color:#ea6153;'><div><strong>FYI, </strong>Supplier cancelled the below  mentioned products from your order</div></div>";
				$table .= "<table style='width:100%;font-size:14px;color:#323232;margin-top: 16px;margin-bottom: 16px;'>
								<thead>
								<tr style='background-color:#f5f5f5;text-align:center;'>
									<th style='width:15%;padding:.6em 0;'>Reference</th>
									<th style='width:35%;padding:.6em 1em;text-align: left;'>Product</th>
								</tr>
								</thead>
								<tbody>";
				foreach($removedProducts as $data) {
					$table .= "<tr style='text-align:right;'>
						<td style='background-color:#ffffff;padding:.6em .4em;text-align: center;'>".$data['reference']."</td>
						<td style='background-color:#ffffff;padding:.6em .4em;text-align: left;'>".$data['name']."</td>
					</tr>";
				}
				$table .= "</tbody></table>";
			}
			$em_sub = 'Delivery schedule for the order #'.$parent_order;
			$data = array(
			    '{order_name}' => $parent_order,
				'{id_order}' => $parent_order,
				'{order_placed}' => $order_placed,
				'{table}' => $table,
				'{firstname}' => $customer->firstname,
			);
			$result = Mail::Send(1, 'order_schedule', Mail::l($em_sub, 1) , $data, $customer->email, $customer->firstname);
		}
		if ($type == 10) {
			$supplier = new EliteSupplier($id_supplier);
			echo json_encode(array('schedule'=>$supplier->getOrdersSchedule()));
		}
		if($type == 11){
			echo json_encode(array('companies'=>EliteSupplierCustomer::getSuppliersCustomer($id_supplier)));
		}
	}

}