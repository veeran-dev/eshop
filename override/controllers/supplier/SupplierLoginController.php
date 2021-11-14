<?php
class SupplierLoginControllerCore extends FrontController
{
    public $php_self = 'supplier-login';
    public function postProcess()
	{
		parent::postProcess();
	}
 	
 	public function  ajaxReturn(){
 		$passwd = trim(Tools::getValue('passwd'));
 		$email = trim(Tools::getValue('email'));
 		$resetPassword = trim(Tools::getValue('resetPassword'));
 		$newPasswd = trim(Tools::getValue('newPasswd'));
		
		$register = trim(Tools::getValue('register'));
		$login = trim(Tools::getValue('login'));
		$id_supplier = trim(Tools::getValue('id_supplier'));
		$checkAuth = trim(Tools::getValue('checkAuth'));
		$clearAuth = trim(Tools::getValue('clearAuth'));
		$id_group = trim(Tools::getValue('id_group'));
		$id_customer = trim(Tools::getValue('id_customer'));
		$logger = new FileLogger();
		$logger->setFilename("test1.txt");
		$logger->logError("auth");
		$logger->logError($register);
		$logger->logError($login);
		$logger->logError($passwd);
		$logger->logError($email);
		if($register == 1){
			$email = trim(Tools::getValue('enterprise_email'));
			$name = trim(Tools::getValue('contact_name'));
			$mobile = trim(Tools::getValue('contact_mobile'));
			$passwd = trim(Tools::getValue('password'));
			$company = Tools::getValue('enterprise_name');
			$supplier = new EliteSupplier();
			$supplier->email = $email;
			$supplier->company = $company;
			$supplier->name = $name;
			$supplier->mobile = $mobile;
			$supplier->active = 1;
			$supplier->passwd = Tools::encrypt($passwd);
			$logger->logError("==========================Supplier=================================");
			$logger->logError($supplier);
			if(!$supplier::validateRegistration($email, $mobile)){
				if($supplier->add()){
					$logger->logError($supplier);
					$supplier->reference = "AA".sprintf('%04d',$supplier->id);
					$supplier->update();
					if(!$this->context)
						$this->context = Context::getContext();
					$this->context->cookie->supplier_reg_id = $supplier->id;
					$this->context->cookie->s_id = $supplier->id;
					$this->context->cookie->s_name = $supplier->name;
					$this->context->cookie->remote_addr = ip2long(Tools::getRemoteAddr());
					$this->context->cookie->last_activity = time();
					$template = 'supplier_welcome';
					$subject = 'Welcome to kobzo';
					$data = array(
						'{email}' => $supplier->email, 
						'{passwd}' => $passwd, 
						'{firstname}' => $name);
					$to = $supplier->email;

					Mail::Send(1, $template, $subject, $data, $to, null,"noreply@kobzo.com","Welcome to kobzo");

					/** Customers confirmation mail **/
										/** Customers confirmation mail **/
					if($id_group){
						$supplierCustomer = new EliteSupplierCustomer();
						$supplierCustomer->id_supplier = $supplier->id;
						$supplierCustomer->id_group = $id_group;
						$supplierCustomer->save();

						$group = new Group($id_group);
						$customer = new Customer($id_customer);

						$template = 'supplier_registered';
						$supplier_template = 'supplier_registered_internal';
						$subject = 'Congratualtions your supplier is registered with kobzo';
						$data = array(
							'{company}' =>$group->name,
							'{email}' => $supplier->email, 
							'{name}' => $name);
						$supplier_data = array(
							'{supplier_enterprise}' =>$supplier->company,
							'{user_email}' => $supplier->email, 
							'{name}' => $supplier->name,
							'{company}' => $group->name,
							'{user_email}' => $supplier->email, 
							'{user_address}' => EliteSupplierAddress::getSupplierAddress($supplier->id), 
							'{user_mobile}'=> $supplier->mobile,
							);
						
						$to = $customer->email;
						$toSupport = "support@kobzo.com";

						Mail::Send(1, $template, $subject, $data, $to, null,"noreply@kobzo.com","Congratualtions your supplier is registered with kobzo");
						Mail::Send(1, $supplier_template, $subject, $supplier_data, $toSupport, null,"noreply@kobzo.com","New Supplier is registered with kobzo");
					}
					else{
						$supplier_template = 'supplier_registered_internal';
						$subject = 'Congratualtions your supplier is registered with kobzo';
						$data = array(
							'{supplier_enterprise}' =>$supplier->company,
							'{user_email}' => $supplier->email, 
							'{name}' => $supplier->name,
							'{company}' => 'Not Available',
							'{user_email}' => $supplier->email, 
							'{user_address}' => EliteSupplierAddress::getSupplierAddress($supplier->id), 
							'{user_mobile}'=> $supplier->mobile,
							);
						
						
						$toSupport = "support@kobzo.com";
						Mail::Send(1, $supplier_template, $subject, $data, $toSupport, null,"noreply@kobzo.com","New Supplier is registered with kobzo");	
					}
				}
				else{
					$result = json_encode(array('error'=>'Something went wrong, please try again later'));
					echo $result;
					return false;
				}
			}
			else{
				$result = json_encode(array('error'=>'Sorry your email or mobile number already exists'));
				echo $result;
				return false;
			}

			$firstname = Tools::getValue('contact_name');
			$company = Tools::getValue('enterprise_name');
			$address1 = Tools::getValue('enterprise_address');
			$city = Tools::getValue('address_city');
			$state = Tools::getValue('address_state');
			$postcode = Tools::getValue('address_pincode');
			$mobile = Tools::getValue('address_mobile');
			$countryId = Tools::getValue('address_country');
			$gst = Tools::getValue('address_gst');

			$supplier_id = $supplier->id;
			$address = new Address();
			 
			$address->firstname = $firstname;
			$address->company = $company;
			$address->address1 = $address1;
			$address->city = $city;
			$address->id_state = $state;
			$address->postcode = $postcode;
			$address->phone_mobile = $mobile;
			$address->id_country = $countryId;
			$address->id_customer = $supplier_id;
			$address->vat_number = $gst;

			if($address->add())
			{
				$supplierAddress = new EliteSupplierAddress();
				$supplierAddress->id_address = $address->id;
				$supplierAddress->id_supplier = $supplier_id;
				$supplierAddress->add();
				$address_data = new Address($address->id);
        		$address_data = AddressFormat::generateAddress($address_data, $patternRules, '<br />');
        		$result = json_encode(array('address'=>$address_data));
			}
			else{
				$result = json_encode(array('error'=>'Unable to add your address'));
				echo $result;
				return false;
			}
			
			$s_cat = Tools::getValue('s_cat');
			$s_city = Tools::getValue('s_city');	
			$logger->logError($this->context->cookie->s_id);
			$result = Db::getInstance()->insert(
							'supplier_info', 
							array('id_supplier'=> $supplier_id, 'id_category' => implode(",",$s_cat), 'id_city' => implode(",",$s_city))
							);
			$result = json_encode(array(
					'success' => 'You have registered successfully, we have sent you a confirmation email',
					'id_supplier'=> $this->context->cookie->s_id,
					'name'=> $this->context->cookie->s_name,
					));
			echo $result;

		}
		if($login == 1 && $passwd != "" && $email != ""){
			$supplier = EliteSupplier::checkAuth($passwd, $email);
			$logger = new FileLogger();
		    $logger->SetFilename('test_sco.txt');
		    $logger->logError('EliteSupplier');
		    $logger->logError('Supplier  =>'.$supplier->id);
			if($supplier->id && $supplier->id > 0){
				
				$this->context = Context::getContext();
				$this->context->cookie->s_id = $supplier->id;
				$this->context->cookie->s_name = $supplier->name;
				$this->context->cookie->remote_addr = ip2long(Tools::getRemoteAddr());
				$this->context->cookie->last_activity = time();

				$result = json_encode(array(
					'id_supplier'=> $supplier->id,
					'name'=> $supplier->name,
					// 'token': generateToken($supplier),
					));
				echo $result;
			}
			else{
				// $result = {'error':'Please check your Email-id and Password'}
				$result = json_encode(array('error'=>'Please check all fields and please try again.'));
				echo $result;
			}

		}
		if($checkAuth == 1){
		    
			$this->context = Context::getContext();
			
			$result = json_encode(array(
					'id_supplier'=> $this->context->cookie->s_id,
					'name'=> $this->context->cookie->s_name,
					));
			echo $result;
		}

		if($clearAuth == 1)
		{
			$this->context = Context::getContext();
			$this->context->cookie->s_id = null;
			$this->context->cookie->s_name = null;
			$this->context->cookie->s_company = null;
			$this->context->cookie->remote_addr = null;
			$this->context->cookie->last_activity = null;
			$result = json_encode(array(
					'id_supplier'=> $this->context->cookie->supplier->s_id,
					'name'=> $this->context->cookie->supplier->s_name,
					));
			echo $result;
		}

		if($resetPassword==1){
			$supplier = EliteSupplier::checkEmail($email);
			if($supplier->id){
				$new_password = Tools::passwdGen();
				$supplier->passwd = Tools::encrypt($new_password);
				if($supplier->update()){
					$template = 'password';
					$subject = 'Password Recovery';
					$data = array(
								'{firstname}' => $supplier->name,
								'{email}' => $supplier->email, 
								'{passwd}' => $new_password, 
							);
					$to = $supplier->email;

					Mail::Send(1, $template, $subject, $data, $to, null,"noreply@kobzo.com","Password Recovery");
					$result = json_encode(array('success'=>'Please check your email for your password details.'));
					echo $result;
					return false;
				}
				else{
					$result = json_encode(array('error'=>'Something went wrong, please try again later.'));
					echo $result;
					return false;
				}
			}			
			else if($supplier->active == 0){
				$result = json_encode(array('error'=>'Email id is not matching with any of our accounts.'));
				echo $result;
				return false;
			}
			else {
				$result = json_encode(array('error'=>'Your Email-id is not available.'));
				echo $result;
				return false;
			}

		}
 	}
}