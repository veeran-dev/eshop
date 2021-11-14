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
class CusVerificationControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		//global $smarty;
		//global $cookie;
		$context=Context::getContext();
		 
		 
 

		$type = Tools::getValue('type');
		$mail_type = Tools::getValue('mail_type');
		$file = $_FILES['file']['name'];
		$temp_name  = $_FILES['file']['tmp_name'];
		$id_customer = $_POST['id_customer'];
		$ajax_type = $_POST['type_ajax'];
		$search_customer = Tools::getValue('search_customer');
		$id_group = Tools::getValue('id_group');
 		$req_type = Tools::getValue('req_type');
		
		$query = Tools::getValue('q');
 	
 
		if($type)
		{
 			if($type != 1 && $type != 3)
			{
 				$customer = new Customer();
				$customer_array = $customer->getCusForVerification($id_customer);  
				echo Tools::jsonEncode($customer_array);				
			}
			elseif ($type == 1)
			{
 				$group = new Group();	
 				$group_array = $group->getGroupForVerification($req_type,1,$id_group);
				echo Tools::jsonEncode($group_array);
			}
			elseif($type == 3){
				echo Tools::jsonEncode(RelationshipManager::searchCustomer($query));
			}
			 
			

		}

		if($ajax_type == 1){ // verify cusomer by uploading document by RM
			if($file)
			{
  				$allowed =  array('gif','png' ,'jpg','docx','doc','pdf','rtf','zip','GIF','PNG' ,'JPG','DOCX','DOC','PDF','RTF','ZIP');
				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed) ) {
 				    echo '1';
				}
				else
				{
 					if($_FILES['file']['size'] > (5 * 1024 * 1024))
					{
 						echo "2";
					}
					else
					{
 						$customer = new Customer((int)($id_customer));
				
						$file_name = $customer->id."-".$customer->firstname;
						$splitName = explode(".", $file);
						$fileExt = end($splitName);

						if(count($splitName) > 1)
							$newFileName  = strtolower($file_name.'.'.$fileExt);  
						else
							$newFileName  = strtolower($file_name);

						$location = "Buyer_Verification_Document"; 
							move_uploaded_file($temp_name, "$location/$newFileName");		
						
						$customer->verification_document = $file;
						$customer->verification_status = 2;
						$customer->verified_by = $context->cookie->id_employee;
						
						if ($customer->update()){
 							$orders = Order::getCusOrders($id_customer);
							$order_history = new OrderHistory();

							foreach ($orders as $orders_detail)
							{
 									$status = OrderHistory::getAllStatus((int)($orders_detail['id_order']),1);
									$latest_status = array_reverse($status);
									if($latest_status[0]['id_order_state'] == 41)
									{	
 										$order_history->changeIdOrderStateByApprover(OrderState::FLAG_CUSTOMER_VERIFIED,$orders_detail['id_order'],NULL,$cookie->id_employee);
										$order_history->changeIdOrderStateByApprover(OrderState::FLAG_ORDER_PLACED,$orders_detail['id_order'],NULL,$cookie->id_employee);
									}
							}

							$vars = array('{firstname}' => $customer->firstname,
										  '{lastname}' => $customer->lastname,
										  '{email}' => $customer->email);

							Mail::Send(1, 'customer_verified', Mail::l('Registration with Kobster.com', 1), $vars, $customer->email, $customer->firstname,NULL, NULL, NULL);

							echo "3";
						}
						else
						{
 							echo "4";
						}
					}
			 	}
			}
			else{
 				echo "0";
			}
		}
		elseif($ajax_type == 3) // verify document uploaded customers
		{
  			$customer = new Customer((int)($id_customer));
			$customer->verification_status = 2;
			$customer->verified_by = $context->cookie->id_employee;
			if($customer->update())
			{
 				$orders = Order::getCusOrders($id_customer);
				$order_history = new OrderHistory();

				foreach ($orders as $orders_detail)
				{
 						$status = OrderHistory::getAllStatus((int)($orders_detail['id_order']),1);
						$latest_status = array_reverse($status);
						if($latest_status[0]['id_order_state'] == 41)
						{
 							$order_history->changeIdOrderStateByApprover(OrderState::FLAG_CUSTOMER_VERIFIED,$orders_detail['id_order'],NULL,$context->cookie->id_employee);
							$order_history->changeIdOrderStateByApprover(OrderState::FLAG_ORDER_PLACED,$orders_detail['id_order'],NULL,$context->cookie->id_employee);
						}
				}

				$vars = array(
					'{firstname}' => $customer->firstname,
					'{lastname}' => $customer->lastname,
				    '{email}' => $customer->email
				);

				Mail::Send(1, 'customer_verified', Mail::l('Registration with Kobster.com', 1), $vars, $customer->email, $customer->firstname,NULL, NULL, NULL);
				
				echo "success";
			}
			else
				echo "failed";
		}
		else if($ajax_type == 4) // verify customers by group
		{
  			if(isset($file))
			{
 				$allowed =  array('gif','png' ,'jpg','docx','doc','pdf','rtf','zip','GIF','PNG' ,'JPG','DOCX','DOC','PDF','RTF','ZIP');
				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed) ) {
 				    echo '1';
				}
				else
				{
 					if($_FILES['file']['size'] > (5 * 1024 * 1024))
					{
 						echo "2";
					}
					else
					{
 						$group = new Group((int)($id_group));
						$group_name = Group::getGroupById((int)($group->id),1);
				
						$file_name = $group->id."-".$group_name[0]['name'];
						$splitName = explode(".", $file);
						$fileExt = end($splitName);

						if(count($splitName) > 1)
							$newFileName  = strtolower($file_name.'.'.$fileExt);  
						else
							$newFileName  = strtolower($file_name);

						$location = "Buyer_Verification_Document"; 
							move_uploaded_file($temp_name, "$location/$newFileName");		
						
						$group->verification_document = $file;
						$group->verification_status = 2;
						
						if ($group->update()){
 							$group = new Group((int)($group->id));
							$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 0);

							foreach($group_customers as $customers)
							{
 								$customer = new Customer((int)($customers['id_customer']));
								$customer->verification_document = $file;
								$customer->verification_status = 2;
								$customer->verified_by = $context->cookie->id_employee;
								if($customer->update())
								{
 									$orders = Order::getCusOrders($customer->id);
									$order_history = new OrderHistory();

									foreach ($orders as $orders_detail)
									{
											$status = OrderHistory::getAllStatus((int)($orders_detail['id_order']),1);
											$latest_status = array_reverse($status);
											if($latest_status[0]['id_order_state'] == 41)
											{	
												$order_history->changeIdOrderStateByApprover(OrderState::FLAG_CUSTOMER_VERIFIED,$orders_detail['id_order'],NULL,$context->cookie->id_employee);
												$order_history->changeIdOrderStateByApprover(OrderState::FLAG_ORDER_PLACED,$orders_detail['id_order'],NULL,$context->cookie->id_employee);
											}
									}
								}
							}
							
							echo "3";
						}
						else
						{
 							echo "4";
						}
					}
			 	}
			}
			else{
 				echo "0";
			}	
		}
		 

		if($mail_type)
		{
  			$customer =  new Customer((int)($id_customer));
			$vars = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
			    '{email}' => $customer->email
			);

			if($mail_type == 0)
			{
  				//Fresh Alert if document not found
				if(Mail::Send(1, 'notify_doc_upload', Mail::l('Registration with Kobster.com', 1), $vars, $customer->email, $customer->firstname,NULL, NULL, NULL))
				{
 					$customer->verification_alert_sent = date("Y-m-d H:i:s");
					$customer->update();
					echo "0";
				}
			}
			elseif($mail_type == 2)
			{
  				//Fresh alert when Pending and Invalid document found
				if(Mail::Send(1, 'notify_valid_doc_upload', Mail::l('Registration with Kobster.com', 1), $vars, $customer->email, $customer->firstname,NULL, NULL, NULL))
				{
 					$customer->verification_alert_sent = date("Y-m-d H:i:s");
					$customer->update();
					echo "2";
				}
			}
			elseif($mail_type == 1)
			{
  				//Resend alert if Document Not yet recieved
				if(Mail::Send(1, 'reminder_doc_upload', Mail::l('Reminder - Registration with Kobster.com', 1), $vars, $customer->email, $customer->firstname,NULL, NULL, NULL))
				{ 
					$customer->verification_alert_sent = date("Y-m-d H:i:s");
					$customer->update();
					echo "1";
				}
			}
			elseif($mail_type == 3)
			{
  				//Resend alert if valid document not yet recieved
				if(Mail::Send(1, 'reminder_valid_doc_upload', Mail::l('Reminder - Registration with Kobster.com', 1), $vars, $customer->email, $customer->firstname,NULL, NULL, NULL))
				{ 
					$customer->verification_alert_sent = date("Y-m-d H:i:s");
					$customer->update();
					echo "3";
				}
			}
		}
	}
		
	 
}