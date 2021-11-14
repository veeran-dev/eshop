<?php
class DeliveryAppControllerCore extends BackController
{
	public function ajaxReturn()
	{
		$dr_number = $_POST['dr_number'];
		$invoice_number = $_POST['invoice'];		
		$remove_product = $_POST['remove_product'];
		$id_order_detail = $_POST['id_order_detail'];
		$id_product = $_POST['id_product'];
		$quantity = $_POST['quantity'];
		$upload_dr = $_POST['upload_dr'];
		$type = $_POST['type'];
		$id_fc = $_POST['id_fc'];
		$id_employee = $_POST['id_employee'];
		$img_type = $_POST['img_type'];
		$order_detail_quantitys = $_POST['order_detail_quantitys'];

		if($type == 1)//search and retrieve DR details
		{
			if(isset($dr_number))
			{
				$dr = Delivery::getDrId($dr_number);
				if(empty($dr)){
					echo "0";
					return false;
				}
				$delivery = new Delivery($dr[0]['id_delivery']);
				if($delivery->checkStatus() == 0){
					echo "0";
					return true;	
				}
				else if(file_exists(_PS_ROOT_DIR_.'/scanedDRs/'.$dr_number.'.png'))
				{
					echo "0";
					return true;
				}
				else if($delivery->delivered == 1)
				{
					echo "0";
					return true;
				}
				else
				{
					$result = $delivery->getProducts();
					$orderDetails = $this->orderDetails($delivery->getOrderId());
					array_push($result, $orderDetails);

					if(is_object($delivery))
						echo json_encode($result);
					else
						echo "0";
				}
			}	
		}
		if($type == 2)//change DR produt's quantity
		{
			
			$details = json_decode($order_detail_quantitys);
			$error = 0;

			if(isset($order_detail_quantitys))
			{
				
				foreach($details as $id_order_detail)
				{
					$id = $id_order_detail->id;
					$quantity = $id_order_detail->quantity;
					
					$orderDetails = new OrderDetail($id);
					if(($orderDetails->product_quantity_delivered > $quantity) || (($orderDetails->product_quantity_delivered == $quantity))){
						$orderDetails->product_quantity_delivered = $orderDetails->product_quantity_delivered - $quantity;
						$orderDetails->update();
						$error = 0;
					}
					else
					{
						$error = 1;
					}
				}
			}
			if($error == 0)
			{
				$id_delivery = Delivery::getDrId($dr_number);
				$delivery = new Delivery($id_delivery[0]['id_delivery']);
                $delivery->delivered = 1;
                if($delivery->update()){
                	echo "1";
                }
			}
			else
			{
				echo '0';
			}
		}
		if($type == 3)//upload DR
		{
			$dr = $_POST['dr'];
			$datas = $_POST['image'];
			$datas = explode("~~",$datas);

			if($img_type == 1)
			{
				if(isset($dr))
				{
					$dr_obj = Delivery::getDrId($dr);
					if(empty($dr)){
						echo "0";
						return false;
					}
					if(empty($dr_obj)){
						echo "0";
						return false;
					}
					$delivery = new Delivery($dr_obj[0]['id_delivery']);
					
					if(is_object($delivery)){
						//no code
					}
					else{
						echo "0";
						return false;
					}
				}
				else
				{
					echo '404';
					return false;
				}

				if(file_exists(_PS_ROOT_DIR_.'/scanedDRs/'.$dr.'.png') || file_exists(_PS_ROOT_DIR_.'/scanedDRs/'.$dr.'_1.png') )
				{
					echo "0";
					return true;
				}
				$i =1;
				foreach($datas as $data){
					if($data !== ''){
						$data = str_replace('data:image/png;base64,', '', $data);
						$data = str_replace(' ', '+', $data);
						$filePath = _PS_ROOT_DIR_.'/scanedDRs/'.$delivery->generateFilename().'_'.$i.'.png';
						$ifp = fopen($filePath, "wb");
					    fwrite($ifp, base64_decode($data));		    
					    fclose($ifp);
					    $i++;
					}
				}
			    $delivery->dr_file_name = $delivery->generateFilename().".png";
			}
			else if($img_type == 2)
			{
				if(isset($dr))
				{
					$dr_obj = Delivery::getDrId($dr);
					//var_dump($dr);
					if(empty($dr)){
						echo json_encode(0);
						return false;
					}
					if(empty($dr_obj)){
						echo json_encode(0);
						return false;
					}
					$delivery = new Delivery($dr_obj[0]['id_delivery']);
					
					if(is_object($delivery)){
						//no code
					}
					else{
						echo json_encode(0);
						return false;
					}
				}
				else
				{
					echo json_encode(404);
					return false;
				}

				$file 		= $_FILES['file']['name'];
				$temp_name  = $_FILES['file']['tmp_name'];
				$allowed =  array('gif','png' ,'jpg','docx','doc','pdf');
				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if(file_exists(_PS_ROOT_DIR_.'/scanedDRs/'.$delivery->generateFilename().'*'))
				{
					echo json_encode(0);
					return true;
				}
				if(!in_array($ext,$allowed) ) {
				    echo json_encode(0);
				    return false;
				}
				else
				{
					if($_FILES['file']['size'] > (2 * 1024 * 1024))
					{
						echo json_encode(0);
				    	return false;
					}
					else
					{
						$file_name = $delivery->id;
						$splitName = explode(".", $file);
						$fileExt = end($splitName);

						if(count($splitName) > 1)
							$newFileName  = strtolower($delivery->generateFilename().'.'.$fileExt);  
						else
							$newFileName  = strtolower($delivery->generateFilename());

						$location = "scanedDRs"; 
						move_uploaded_file($temp_name, "$location/$newFileName");									
						$delivery->dr_file_name = $newFileName;
					}
			 	}
			}
			if($delivery->delivered != 1)
			{
				$delivery->delivered = 1;
			}

			$order = new Order($delivery->getOrderId());
			$current_order_state = $order->getCurrentOrderState();
			$history = new OrderHistory();
            $history->id_order = $order->id;
            $history->id_employee = $id_employee;
            $full_delivery = 0;

            $employee = new Employee($id_employee);
            $context = Context::getContext();
            $context->cookie->id_employee = $id_employee;
            $context->employee = $employee;
            if(!$order->checkIfAllProductsDelivered()){
                //$stat = $history->changeIdOrderState(OrderState::FLAG_PAR_DELIVERY,$order);
            	echo "0";
            	return false;
            }
            else
            {
            	$stat = $history->changeIdOrderState(OrderState::FLAG_DELIVERY,$order);
            	$full_delivery = 1;
            }
            
            if($delivery->update() && $history->save())
            {
            	if($full_delivery == 1)
            	{
            		$employee = new Employee($id_employee);
		            $this->context->cookie->id_employee = $id_employee;
		            $this->context->employee = $employee;

            		$history2 = new OrderHistory();
		            $history2->id_order = $order->id;
		            $history2->id_employee = $id_employee;
		            if($order->invoice_number > 0)
		            	$history2->changeIdOrderState(OrderState::FLAG_INVOICE_SUBMISSION_PENDING,$order);
		            else
	            		$history2->changeIdOrderState(OrderState::FLAG_PENDING_INVOICE,$order);
	                $history2->save();
            	}
            	echo "1";
            	return true;
            }
            else
            {
            	echo "0";
            	return false;
            }
		}
		if($type == 4)//home screen data
		{
			$fc = $id_fc > 0 ?'AND ko.`id_fc` !='.$id_fc.'':'AND ko.`id_fc` !=0';
			$sql ="SELECT LPAD(ko.`id_order`, 6, '0') as id_order,ko.`id_fc`,ks.`name`,UCASE(SUBSTRING(kfc.`city_name`,1,3)) AS city,
						DATE_FORMAT(ko.`estimated_delivery_time`,'%b') AS months,
						DATE_FORMAT(ko.`estimated_delivery_time`,'%d') AS dates,
						DATE_FORMAT(ko.`estimated_delivery_time`,'%h:%i %p') AS times 
							FROM "._DB_PREFIX_."order_history koh 
							LEFT JOIN "._DB_PREFIX_."orders ko ON(ko.`id_order` = koh.`id_order`)
							LEFT JOIN "._DB_PREFIX_."fulfillment_centre kfc ON(kfc.`id_fulfillment_centre` = ko.`id_fc`)
							LEFT JOIN "._DB_PREFIX_."state ks ON(ks.`id_state` = kfc.`id_state`)
							WHERE koh.`id_order_history` IN(SELECT  MAX(oha.`id_order_history`)
												FROM kob_order_history AS oha
												WHERE ko.id_order = oha.id_order
												GROUP BY oha.id_order)
							AND koh.`id_order_state` IN(4,18,33)
							".$fc."
							AND ko.`estimated_delivery_time` != '0000-00-00 00:00:00' 
							ORDER BY ko.`estimated_delivery_time` DESC";
			$result = Db::getInstance()->ExecuteS($sql);
			echo json_encode($result);
		}
		if($type == 5)//order page
		{
			$id_order = $_POST['order_id'];
			$order = new Order($id_order);
			if(!validate::isLoadedObject($order))
			{
				echo "404";
				return true;
			}
			echo json_encode($this->orderDetails($id_order));
		}
		if($type == 6)
		{
			$email = $_POST['email'];
			$password = $_POST['pwd'];
			
			if(!Validate::isEmail($email))
			{
				echo "0";
				return false;
			}
			$employee = new Employee();
			$employee_detail = $employee->getByemail($email, $password);
			if($employee_detail && $employee_detail->id_profile == 9)
			{
				$this->context->cookie->id_employee = $employee->id;
				$this->context->cookie->email = $employee->email;
				$this->context->cookie->profile = $employee->id_profile;
				$this->context->cookie->passwd = $employee->passwd;
				$this->context->cookie->firstname = $employee->firstname;
				$this->context->cookie->lastname = $employee->lastname;
				$this->context->cookie->remote_addr = ip2long(Tools::getRemoteAddr());
				$this->context->cookie->write();
				
				echo $employee->id;
				return true;

			}
			
			else
			{
				echo "0";
				return false;
			}
		}
		if($type == 7)
		{
			if(!empty(Order::validateInvoice($invoice_number)))
			{
				if(file_exists(_PS_ROOT_DIR_.'/Invoice-ACK/'.$invoice_number.'.png'))
				{
					echo "0";
					return false;
				}
				else
				{
					$data = $_POST['image'];
					$data = str_replace('data:image/png;base64,', '', $data);
					$data = str_replace(' ', '+', $data);
					$filePath = _PS_ROOT_DIR_.'/Invoice-ACK/'.$invoice_number.'.png';
					$ifp = fopen($filePath, "wb");
				    fwrite($ifp, base64_decode($data));		    
				    fclose($ifp);

				    $employee = new Employee($id_employee);
		            $this->context->cookie->id_employee = $id_employee;
		            $this->context->employee = $employee;

				    $order = new Order(Order::getInvoice($invoice_number)['id_order']);
					$current_order_state = $order->getCurrentOrderState();
					$history = new OrderHistory();
		            $history->id_order = $order->id;
		            $history->id_employee = $id_employee;
		            $history->changeIdOrderState(OrderState::FLAG_INVOICE_SUBMITTED,$order);
		            
		            if($history->save()){
		            	$history_new = new OrderHistory();
			            $history_new->id_order = $order->id;
			            $history_new->id_employee = $id_employee;
		            	$history_new->changeIdOrderState(OrderState::FLAG_PENDING_PAYMENT,$order);	
		            	if($history_new->save())
		            		echo "1";
		            		return true;
		            }
				}
			}
		}
 	}

 	public function orderDetails($id_order)
 	{
 		$sql ='SELECT GROUP_CONCAT(DISTINCT(kd.`delivery_number`) SEPARATOR ", ") AS delivery_numbers,LPAD(ko.`id_order`, 6, "0") AS id_order,CONCAT(ke.`firstname`,ke.`lastname`) AS NAME,ks.`name` AS state,
						ka.`alias`,ka.`city`,ka.`company`,ka.`firstname`,ka.`phone`,ka.`phone_mobile`,
						ka.`postcode`,ka.`address1`,ke.`phone` AS emobile,ke.`firstname` AS ename,						
						DATE_FORMAT(ko.`estimated_delivery_time`,"%c") AS mon,
						DATE_FORMAT(ko.`estimated_delivery_time`,"%b") AS month,
						DATE_FORMAT(ko.`estimated_delivery_time`,"%Y") AS year,
						DATE_FORMAT(ko.`estimated_delivery_time`,"%d") AS dates,
						DATE_FORMAT(ko.`estimated_delivery_time`,"%h") AS mins,
						DATE_FORMAT(ko.`estimated_delivery_time`,"%b %d %h:%i %p") AS times, 
						DATE_FORMAT(ko.`estimated_delivery_time`,"%M %d %Y %T") AS dtime 
							FROM '._DB_PREFIX_.'order_history koh 
							LEFT JOIN '._DB_PREFIX_.'orders ko ON(ko.`id_order` = koh.`id_order`)
							LEFT JOIN '._DB_PREFIX_.'address ka ON(ka.`id_address` = ko.`id_address_delivery`)
							LEFT JOIN '._DB_PREFIX_.'state ks ON(ks.`id_state` = ka.`id_state`)
							LEFT JOIN '._DB_PREFIX_.'customer kc ON(ko.`id_customer` = kc.`id_customer`)
							LEFT JOIN '._DB_PREFIX_.'employee ke ON(ke.`id_employee` = kc.id_relationship_manager)
							LEFT JOIN '._DB_PREFIX_.'delivery_details kdd ON(kdd.`id_order` = ko.`id_order`)
							LEFT JOIN '._DB_PREFIX_.'delivery kd ON(kd.`id_delivery`=kdd.`id_delivery` and kd.delivered !=1)
							WHERE ko.`id_order` = '.$id_order.'
							limit 1';
			$result = Db::getInstance()->ExecuteS($sql);
			return $result;
 	}
	
}