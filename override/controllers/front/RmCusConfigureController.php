<?php
class RmCusConfigureControllerCore extends BackController
{
	public function ajaxReturn()
	{	
		global $cookie;
		$type = $_GET['type'];
		$type_post = $_POST['type'];

		$alias = $_POST['alias'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$company = $_POST['company'];
		$address1 = $_POST['address1'];
		$postcode = $_POST['postcode'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$mobile = $_POST['mobile'];
		$id_customer = $_POST['id_customer'];
		$landline = $_POST['landline'];
		$gst = $_POST['gst'];
		$sez = $_POST['sez'];
		$id_address = $_POST['id_address'];
		$id_group = Tools::getValue('id_group');
		$group_name = $_POST['group_name'];
		$discount = $_POST['group_discount'];
		$credit = $_POST['group_credit'];
		$price_display_method = $_POST['price_display_method'];
		$default_group = $_POST['group_default'];
		$creator = $_POST['creator'];
		$level_one_approver = $_POST['level_one'];
		$level_two_approver = $_POST['level_two'];
		$id_parent = $_POST['id_parent'];
		$customer_id = Tools::getValue('customerid');		
		$request_type = Tools::getValue('request_type');
 		$context=Context::getContext();
 		$po_mandatory = Tools::getValue('po_mandatory');
 		$id_relationship_manager = Tools::getValue('id_relationship_manager');
 		$esc_firstname = $_POST['esc_firstname'];
 		$esc_lastname = $_POST['esc_lastname'];
 		$esc_mobile = $_POST['esc_mobile'];
 		$esc_email = $_POST['esc_email'];
 		$id_group = $_POST['id_group'];
		
		if($customer_id == 0)
		{
			$customer_id = $id_customer;
		}
  
		if ($request_type==1)
		{
			$group_address=array();
			$result = Customer::getCustomerInGroups($id_group);
			$get_address = Customer::getGroupAddressDetails($id_group);
			array_push($group_address,$result,$get_address);
			echo Tools::jsonEncode($group_address);
		}
		elseif ($request_type==2)//get group's customer
		{
			$result = Customer::getCustomerInGroups($id_group);
			echo Tools::jsonEncode($result);
		}
		elseif ($request_type==3)
		{
			global $cookie;
			$cookie->id_customer = $id_customer; 
			$result = Address::getCustomerTagedAddress($id_customer);
			
			echo Tools::jsonEncode($result);
		}
		elseif ($request_type==4)
		{ 

			$result = Group::getGroupByName(strtolower($group_name));

			if($result[0]['id_group'] && $result[0]['id_group'] != "")
			{	
				$existing[]=(["id_group"=>"00"]);
				echo Tools::jsonEncode($existing);
			}
			else
			{
				$group = new Group();
				$group->price_display_method = $price_display_method;
				$group->credit_days = $credit;
				$group->name[1] = trim($group_name);
				$group->po_mandatory = $po_mandatory;
				$group->id_relationship_manager = self::$cookie->id_employee;
				if($group->add())
				{
					$groupname[] = Group::searchByName(trim($group_name));
					echo Tools::jsonEncode($groupname);
				}
				else
				{
					$fail[]=(["id_group"=>"0"]);
					echo Tools::jsonEncode($fail);
				}
			}
		}
		elseif ($request_type==5)//Add Address 
		{ 
			if(!Validate::isAddress($address1)) {
				echo "3";
				return false;
			}

			$address = new Address();
			$address->id_customer = $customer_id;
 			$address->id_country = $country;
			$address->id_state = $state;
			$address->alias = $alias;
			$address->address1 = $address1;
			$address->city = $city;
			$address->company = $company;
			$address->firstname = $firstname;
			$address->lastname = $lastname;
			$address->postcode = $postcode;
			$address->phone_mobile = $mobile;
			$address->phone = $landline;
			$address->vat_number = $gst;
			$address->isez = (boolval($sez) == 1 ? 1 : 0);
			if($address->save())
			{
				$customer_address_map = new CustomerAddress(); // For customer address mapping
				/*$customer_address_map->id_customer = $address->id_customer;
				$customer_address_map->id_parent = $address->id_customer;
				$customer_address_map->id_address = $address->id;*/
				if($customer_address_map->mapId($address->id_customer,$address->id)) {
					echo "1";
				}
			}
			else
			{
				echo "0";
			}
		}
		elseif ($request_type == 6)//EDIT Address 
		{ 
			if(!Validate::isAddress($address1)) {
				echo "3";
				return false;
			}

			$address = new Address($id_address);
			if($id_customer)
				$address->id_customer = $id_customer;
			$address->id_country = $country;
			$address->id_state = $state;
			$address->alias = $alias;
			$address->address1 = $address1;
			$address->city = $city;
			$address->company = $company;
			$address->firstname = $firstname;
			$address->lastname = $lastname;
			$address->postcode = $postcode;
			$address->phone_mobile = $mobile;
			$address->phone = $landline;
			// $address->vat_number = $gst;
			//$address->isez = ($sez == 1 ? 1 : 0);
			
			if($address->update()) {
				echo "1";
			}
			else {
				echo "0";
			}
		}
		elseif ($request_type == 7)
		{
			//var_dump($_POST['company_name']);
			$company_id = $_POST['group_selection'];
			$group_name = $_POST['company_name'];
			$po_mandatory = Tools::getValue('po_mandatory');

			$group = new Group($company_id);
			$group->name[1] = $group_name;
			$group->po_mandatory = $po_mandatory;
			$group->credit_days = $_POST['group_credit'];
			
			if($group->update()) {
				echo "1";
			}
			else
			{
				echo "2";
			}

		}
		elseif($request_type == 8)
		{
			$cus = explode("~", $id_customer);
			$customer = new Customer($cus[0]);
			$customer_details = array($customer->firstname,$customer->lastname,$customer->email,$customer->mobile);
			
			echo json_encode($customer_details);
		}
		elseif($request_type == 9)
		{
			$lastname = $_POST['lastName'];
			$cus = explode('~',$id_customer);
			$customer = new Customer($cus[0]);
			$customer->firstname  = $firstname;
			$customer->lastname  = $lastname;
			$customer->email  = $email;
			$customer->mobile  = $mobile;
			if($customer->update())
			{
				echo "0";
			}
			else
			{
				echo "1";
			}

		}
		
		if(isset($type))
		{

			if($type == 0) //load customer creation template
			{
				$groups = Group::getGroups(true);
				$customerObj = new Customer();
				$kam = $customerObj->getRelationShipManager();
				$context->smarty->assign(array('groups' => $groups, 'kam' => $kam));
				$context->smarty->display('rm/rm-customer-create.tpl');
			}
			elseif ($type == 1) //load customer address template
			{
 				
				$groups = Group::getGroups(true);
				// $customers = Customer::getCustomers();
				$group_name = Group::getGroupById((int)($_GET['id_group']),1);
				$group = new Group((int)($_GET['id_group']));
				$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 1000);
				$context->smarty->assign(array('groups' => $groups,'group_customers' => $group_customers,'group_name' => $group_name));
				$context->smarty->display('rm/rm-add-address.tpl');
			}
			elseif ($type == 2)
			{
				$groups = Group::getGroups(true);
				// $customers = Customer::getCustomers();
				$group_name = Group::getGroupById((int)($_GET['id_group']),1);

				//Get Group Customers
				$group = new Group((int)($_GET['id_group']));
				$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 1000);
				$context->smarty->assign(array('groups' => $groups,'group_customers' => $group_customers,'group_name' => $group_name));
				$context->smarty->display('rm/rm-add-group.tpl');				
			}
			elseif ($type == 4) //get customer details with address for address block
			{
				$customer = Customer::getGroupAddressDetails($_GET['id_customer']);
				/*$context->smarty->assign('customer',$customer);
				$context->smarty->display('rm/rm-add-address.tpl');*/
			}
			elseif ($type == 5) //search  all customers
			{
				$customer = Customer::searchAllCustomers($_GET['q']);
				echo Tools::jsonEncode($customer);
			}
			elseif ($type == 6) //Get Address detail
			{
				$address = Address::getAddressById($_GET['id_address']);
				echo Tools::jsonEncode($address);
			}
			elseif ($type == 7)
			{
				$groups = Group::getGroups(true);
				// $customers = Customer::getCustomers();
				$group_name = Group::getGroupById((int)($_GET['id_group']),1);

				//Get Group Customers
				$group = new Group((int)($_GET['id_group']));
				$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 1000);

				$context->smarty->assign(array('groups' => $groups,'group_customers' => $group_customers,'group_name' => $group_name));
				
				$context->smarty->display('rm/rm-customer-create.tpl');
			}
			elseif ($type == 8)
			{
				$groups = Group::getGroups(true);
				$context->smarty->assign(array('groups' => $groups));
				$context->smarty->display('rm/rm-create-role.tpl');
			}
			elseif($type == 9)
			{
				$groups = Group::getGroups(true);
				// $customers = Customer::getCustomers();
				$group_name = Group::getGroupById((int)($_GET['id_group']),1);

				//Get Group Customers
				$group = new Group((int)($_GET['id_group']));
				$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 1000);
				$roles = Customer::getAllRolesForCustomer();

				$context->smarty->assign(array('groups' => $groups,'group_customers' => $group_customers,'group_name' => $group_name, 'roles' => $roles));
				$context->smarty->display('rm/rm-create-role.tpl');
			}
			elseif ($type == 10)
			{
				$groups = Group::getGroups(true);
				$context->smarty->assign(array('groups' => $groups));
				$context->smarty->display('rm/rm-assign-parent.tpl');
			}
			elseif ($type == 11)
			{
				$groups = Group::getGroups(true);
				// $customers = Customer::getCustomers();
				$group_name = Group::getGroupById((int)($_GET['id_group']),1);

				//Get Group Customers
				$group = new Group((int)($_GET['id_group']));
				$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 1000);
				$roles = Customer::getAllRolesForCustomer();
				$cus_parent_array = array();

				foreach($group_customers as $customers)
					$cus_parent_array[] = Customer::getParents((int)($customers['id_customer']));

				$context->smarty->assign(array('groups' => $groups,'group_customers' => $group_customers,'group_name' => $group_name, 'roles' => $roles,'parent_array' => $cus_parent_array));
				$context->smarty->display('rm/rm-assign-parent.tpl');
			}
			elseif ($type == 12)
			{
				$groups = Group::getGroups(true);
				// $customers = Customer::getCustomers();
				$group_name = Group::getGroupById((int)($_GET['id_group']),1);

				//Get Group Customers
				$group = new Group((int)($_GET['id_group']));
				$group_customers = $group->getCustomers($count = false, $start = 0, $limit = 1000);

				$context->smarty->assign(array('groups' => $groups,'group_customers' => $group_customers,'group_name' => $group_name));
				
				$context->smarty->display('rm/rm-add-group.tpl');
			}
			elseif ($type == 13)
			{
 				$result = Customer::searchAllCustomers($_GET['q']);
				echo Tools::jsonEncode($result);
			}
			else if ($type == 14) {
				$id_group = $_GET['id_group'];
				$groupObj = new Group((int)($id_group));
				echo Tools::jsonEncode($groupObj);
			}
			elseif ($type == 15) {
				$id_group = $_GET['id_group'];
				$escalation = new CustomerEscalation($id_group);
				echo Tools::jsonEncode($escalation);
			}
		}
		elseif(isset($type_post)){
			if($type_post == 0) // Add New Customer Address block
			{
				$address = new Address();
				$address->id_customer = $id_customer;
				$address->id_country = $country;
				$address->id_state = $state;
				$address->alias = $alias;
				$address->address1 = $address1;
				$address->city = $city;
				$address->company = $company;
				$address->firstname = $firstname;
				$address->postcode = $postcode;
				$address->phone_mobile = $mobile;
				$address->phone = $landline;
				if($address->add())
				{
					$customer_address_map = new CustomerAddress(); // For customer address mapping
					$customer_address_map->id_customer = $address->id_customer;
					$customer_address_map->id_address = $address->id;
					if($customer_address_map->add())
						echo "1";
				}
				else
				{
					echo "0";
				}
			}
			elseif ($type_post == 1) // Edit Customer Address block 
			{  
				
 				
			}
			elseif ($type_post == 2) // add customers to group( can add multiple customers )
			{
					$customer = new Customer($id_customer);
					$customer->id_default_group = $id_group; 
					if($customer->update())
					{
						
						$group_exists = Customer::isExistsGroup($id_customer,$id_group);
						if($group_exists)
						{
							//do nothing if group exists
						}
						else
						{
							//map group to customer if not exists
							Customer::mapGroupToCustomer($id_customer,$id_group);
							Customer::mapGroupToCustomer($id_customer,1);
						}
					}
				//}
			}
			elseif ($type_post == 3){
				$customer_pop = new Customer($id_customer);
				if($customer_pop->id_default_group == 1){
					echo Tools::jsonEncode($customer_pop->id_default_group);
				}
				else
				{
					$group_name = Group::getGroupById((int)($customer_pop->id_default_group),1);
					$customer_pop->id_default_group = $group_name[0]['name'];
					echo Tools::jsonEncode($customer_pop);
				}
			}
			elseif ($type_post == 4)
			{
				
			}
			elseif ($type_post == 5) //delete customer from group
			{
				Group::deleteCustomerFromGroup($id_customer,$id_group);
				echo 1;
			}
			elseif ($type_post == 6)
			{
				$id_customer = $_POST['id_customer'];
				$roles = $_POST['roles'];
				foreach($id_customer as $index => $value)
				{
					if(Customer::isExistsRole($value))
						$action = true;
					else
						$action = false;
					Customer::createCustomerRole($value,$roles[$index],$action);
				}
			}
			elseif ($type_post == 7)
			{
				$id_creator = implode($creator);
				$id_level_one = implode($level_one_approver);
				$id_level_two = implode($level_two_approver);
				
				if($creator && $level_one_approver && !$level_two_approver)
				{
					if(!empty($id_creator) && !empty($id_level_one))
						Customer::assignParent($id_creator,$id_level_one);
				}
				elseif ($creator && $level_one_approver && $level_two_approver)
				{
					if(!empty($id_creator) && !empty($id_level_one))
						Customer::assignParent($id_creator,$id_level_one);

					if(!empty($id_level_two))
					{
						Customer::assignParent($id_creator,$id_level_two);
						Customer::assignParent($id_level_one,$id_level_two);
					}
				}
				elseif ($level_one_approver && $level_two_approver && !$creator)
				{
					if(!empty($id_level_two) && !empty($id_level_one))
						Customer::assignParent($id_level_one,$id_level_two);
				}
				elseif($creator && $level_two_approver && !$level_one_approver)
				{
					if(!empty($id_creator) && !empty($id_level_two))
						Customer::assignParent($id_creator,$id_level_two);
				}
			}
			elseif ($type_post == 8)
			{
				if($id_parent && !$id_customer)
				{
					Customer::removeParent($id_parent);
				}
				elseif ($id_customer && $id_parent)
				{
					Customer::removeParent($id_parent,$id_parent);
				}
			}
			else if($type_post == 9) {
				$customer = new Customer(intval($customer_id));
				$customer->id_relationship_manager = $id_relationship_manager;
				if($customer->update()) {
					echo 1;
				}
				else {
					echo 0;
				}
			}
			else if($type_post == 10) {
				$group = new Group(intval($id_group));
				$group->id_kam = $id_relationship_manager;
				if($group->update()) {
					echo 1;
				}
				else {
					echo 0;
				}
			}
			elseif ($type_post == 11) {
				$groupObj = new Group((int)($id_group));
				$groupObj->id_relationship_manager = $id_relationship_manager;
				$groupObj->addRMtoAllUsers($id_relationship_manager);
				echo $groupObj->update();
			}
			elseif ($type_post == 12) {
				$context = Context::getContext();
				$escalation = new CustomerEscalation((int)($id_group));
				if($escalation->id > 0){
					$dbData = array(
            			'id_group' 			=> $id_group,
            			'firstname' 			=> $esc_firstname,
            			'lastname' 				=> $esc_lastname,
            			'mobile'			=> $esc_mobile,
            			'id_employee'			=> $context->cookie->id_employee,
            			'email'			=> $esc_email,
            		);
            		$where = "id_group=".$id_group."";
                	echo Db::getInstance()->update("customer_escalation", $dbData, $where, $id_group);
				}
				else{
					$dbData = array(
            			'id_group' 			=> $id_group,
            			'firstname' 			=> $esc_firstname,
            			'lastname' 				=> $esc_lastname,
            			'mobile'			=> $esc_mobile,
            			'id_employee'			=> $context->cookie->id_employee,
            			'email'			=> $esc_email,
            		);
                	echo Db::getInstance()->insert("customer_escalation", $dbData);
				}
				
			}
		}		
 	}
//Create New Customer from RM Portal begins

 	public function createCustomer()
 	{
 		$firstname = $_POST['firstName'];
		$lastname = $_POST['lastName'];
		$company = $_POST['companyName'];
		$password = $_POST['password'];
		$email = $_POST['emailId'];
		$mobile = $_POST['mobileNum'];
		$type = $_POST['type'];
		$id_employee = $_POST['id_employee'];
		$id_group = $_POST['id_group'];
 
 		if (Customer::customerExists($email))
		{
			$status_2[] = ["status" => "2","id_customer" => "0"];
			echo Tools::jsonEncode($status_2);
		}
		elseif(!preg_match('/^[^!<>,;?=+@#"°{}_$%:]*$/u', stripslashes($company)))
		{
			$status_5[] = ["status" => "5","id_customer" => "0"];
			echo Tools::jsonEncode($status_5);
			 
		}
		else if(!Validate::isName($firstname)) {
			echo Tools::jsonEncode(["status" => "6","id_customer" => "0"]);
		}	
		else
		{
			$customer = new Customer();
			$customer->email = $email;
			$customer->passwd = md5(_COOKIE_KEY_.$password);
			$customer->firstname = $firstname;
			$customer->lastname = $lastname;
			$customer->id_default_group = $id_group;
			$customer->company = $company;
			$customer->mobile = $mobile;
			// $customer->id_relationship_manager = $id_employee;
			$customer->id_buyer = 3;
		
			if($customer->add())
			{	
				

 					$group = new Group((int)($customer->id_default_group));
					Customer::mapGroupToCustomer($customer->id,1);
 					if($group->verification_document)
					{
						$customer->verification_document = $group->verification_document;
						$customer->verification_status = 2;
						$customer->verified_by = $this->context->cookie->id_employee;
						$customer->update();
  					}
					/*else
					{
  						$status_1[]=(["status"=>"1","id_customer"=>"0"]);
						echo Tools::jsonEncode($status_1);
 					}*/
					
					/*if (Mail::Send(1, 'account', Mail::l('Welcome to Kobster.com!', 1),
									array('{firstname}' => $customer->firstname, '{lastname}' => $customer->lastname, '{email}' => $customer->email, '{passwd}' => Tools::getValue('password')), $customer->email, $customer->firstname.' '.$customer->lastname))
					{*/
						$status_3[]=(["status"=>"3","id_customer"=>$customer->id,"company"=>$customer->company]);
						echo Tools::jsonEncode($status_3);
					//}
 			}
			else 
			{
 				$status_0[]=(["status"=>"0","id_customer"=>"0"]);
				echo Tools::jsonEncode($status_0);
 			}
		}
 	}
	
}