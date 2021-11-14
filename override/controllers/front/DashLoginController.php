<?php
class DashLoginControllerCore extends DashController
{
	 
	public $php_self = 'dash-login';
	public $dash = true;
    
 	public function postProcess()
	{ 
		parent::postProcess();

		if($this->context->cookie->isLogged() && $this->context->cookie->id_customer != "") {
			Tools::redirect('index.php?controller=dash-index');
		}
		$logger = new FileLogger();
		$logger->setFilename("test1.txt");
		$logger->logError("etad");
		$logger->logError($_POST);
		$logger->logError($_POST['SubmitDashRegister']);
		if ($_POST['SubmitDashRegister'] == 1){
			$corporate_email = $_POST['corporate_email'];
			if(Customer::getCustomersByEmail($corporate_email)){
				die(json_encode(array('error' => 'Corporate email already exists')));
			}
			$corporate_name = $_POST['corporate_name'];			
			$corporate_pwd = $_POST['corporate_pwd'];
			$corporate_address = $_POST['corporate_address'];
			$corporate_mobile = $_POST['corporate_mobile'];
			$corporate_city = $_POST['corporate_city'];
			$corporate_state = $_POST['corporate_state'];
			$corporate_country = $_POST['corporate_country'];
			$corporate_pincode = $_POST['corporate_pincode'];
			$corporate_gst = $_POST['corporate_gst'];
			$corporate_contact_name = $_POST['corporate_contact_name'];
			$corporate_contact_mobile = $_POST['corporate_contact_mobile'];
			$corporate_gst = $_POST['corporate_gst'];
			$corporate_sez = $_POST['corporate_sez'];
			$logger->logError($_POST);

			$group = new Group();
			$group->name[1] = trim($corporate_name);
			$group->price_display_method = false;
			if($group->add()){
				$logger->logError("customer");
				$customer = new Customer();
				$customer->email = $corporate_email;
				$customer->passwd = md5(_COOKIE_KEY_.$corporate_pwd);
				$customer->firstname = $corporate_contact_name;
				$customer->id_default_group = $group->id;
				$customer->mobile = $corporate_contact_mobile;
				$customer->id_buyer = 3;	
				$logger->logError($customer);		
				if($customer->add()){
					$logger->logError($customer->id);		
					$address = new Address();
					$address->id_customer = $customer->id;
					$address->id_country = 110;
					$address->id_state = $corporate_state;
					$address->alias = $corporate_name;
					$address->address1 = $corporate_address;
					$address->vat_number = $corporate_gst;
					$address->city = $corporate_city;
					$address->company = $corporate_name;
					$address->firstname = $corporate_contact_name;
					$address->postcode = $corporate_pincode;
					$address->phone_mobile = $corporate_mobile;
					if($corporate_sez){
					    $address->isez = $corporate_sez;
					}
					$logger->logError($address);		
					if($address->add())
					{
						$logger->logError("CustomerAddress");		
						$customer_address_map = new CustomerAddress(); // For customer address mapping
						$customer_address_map->id_customer = $address->id_customer;
						$customer_address_map->id_address = $address->id;
						if($customer_address_map->add()){
						    $logger->logError("CustomerAddress succ");		
							$this->context->cookie->customer_lastname = $customer->lastname;
							$this->context->cookie->customer_firstname = $customer->firstname;
							$this->context->cookie->id_buyer = $customer->id_buyer;
							$this->context->cookie->id_customer = $customer->id;
							$this->context->cookie->logged = 1;
							$this->context->cookie->is_guest = $customer->isGuest();
							$this->context->cookie->passwd = $customer->passwd;
							$this->context->cookie->email = $customer->email;
							$this->context->cookie->role = $customer->getCustomerRole();

							$credit_days = new Group((int)($customer->id_default_group));
							$this->context->cookie->credit_days = (int)$credit_days->credit_days;
							$this->context->cookie->companyName = $credit_days->name[1];
					
							$cart = new Cart();
	            			if($cart->add()) {
	            				$this->context->cart = $cart;
	            				$this->context->cookie->id_cart = $cart->id;
	            			}
							/* Update cart address */
							$this->context->cart->id_carrier = 0;
							$this->context->cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
							$this->context->cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
							// If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
							$this->context->cart->secure_key = $customer->secure_key;
							$this->context->cart->update();
				// 			Tools::redirect('index.php?controller=dash-index');
							die(json_encode(array('success' => 'Account created successfully')));
						}
					}
				}
			}
			else{
				echo "0";
			}

		}

		if (Tools::isSubmit('SubmitDashLogin'))
		{
  			$passwd = trim($_POST['login_passwd']);
			$email = trim($_POST['login_email']);
			$goToAfterLogin = $_POST['gotoPageAfterLogin'];
            $logger = new FileLogger();
            $logger->setFilename("test.txt");
            $logger->logError($_POST);
 			if ($email != "") {
 				$customer = new Customer();
				$authentication = $customer->getByEmail(trim($email), trim($passwd));
				$buyer = $customer->getBuyerId(trim($email));
				
  				if (!$authentication OR !$customer->id OR $buyer != 3 ) {
					$this->context->smarty->assign(array('login_error' => 1, 'email' => $email));
				}
				else {
					$this->context->cookie->id_compare = isset($this->context->cookie->id_compare) ? $this->context->cookie->id_compare: CompareProduct::getIdCompareByIdCustomer($customer->id);
					$this->context->cookie->id_customer = (int)($customer->id);
					$this->context->cookie->customer_lastname = $customer->lastname;
					$this->context->cookie->customer_firstname = $customer->firstname;
					$this->context->cookie->id_buyer = $customer->id_buyer;
					$this->context->cookie->logged = 1;
					$this->context->cookie->is_guest = $customer->isGuest();
					$this->context->cookie->passwd = $customer->passwd;
					$this->context->cookie->email = $customer->email;
					$this->context->cookie->role = $customer->getCustomerRole();
					
					$credit_days = new Group((int)($customer->id_default_group));
					$this->context->cookie->credit_days = (int)$credit_days->credit_days;
					$this->context->cookie->companyName = $credit_days->name[1];
					
					if (Configuration::get('PS_CART_FOLLOWING') AND (empty($this->context->cookie->id_cart) OR Cart::getNbProducts($this->context->cookie->id_cart) == 0)){
						$this->context->cookie->id_cart = (int)(Cart::lastNoneOrderedCart((int)($customer->id)));
					}
					else{
					    $cart = new Cart();
            			if($cart->add()) {
            				$this->context->cart = $cart;
            				$this->context->cookie->id_cart = $cart->id;
            			}
					}
					/* Update cart address */
					$this->context->cart->id_carrier = 0;
					$this->context->cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
					$this->context->cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
					// If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
					$this->context->cart->secure_key = $customer->secure_key;
					$this->context->cart->update();
 					
					if($customer->status != 1) {
					    $logger->logError("redirect");
						$logger = new FileLogger();
						$logger->setFilename('log-files/'.$this->context->cookie->id_customer.'-'.$this->context->cookie->customer_firstname.'.txt');
						$logger->logInfo("-------------------------------------------");
						$logger->logInfo("");
						$logger->logInfo("Customer Logged In. IP Address: ".$_SERVER['REMOTE_ADDR']);
					}
					Tools::redirect('index.php?controller=dash-index'.$goToAfterLogin);
				}
			}
		}
		else
		{
			if (Tools::getValue('ajax') == 'true')
			{
				if (!($email = Tools::getValue('email')) OR !Validate::isEmail($email))
				{
						//$this->errors[] = Tools::displayError('Invalid e-mail address');
 						$login_error = 2;
  				}
				else
				{
					$customer = new Customer();
					$customer->getByemail($email);
					if (!Validate::isLoadedObject($customer))
					{
						//$this->errors[] = Tools::displayError('There is no account registered to this e-mail address.');
 						$login_error = 3;
  					}
					else
					{
						if ((strtotime($customer->last_passwd_gen.'+'.(int)($min_time = Configuration::get('PS_PASSWD_TIME_FRONT')).' minutes') - time()) > 0)
						{
							//$this->errors[] = Tools::displayError('You can regenerate your password only every').' '.(int)($min_time).' '.Tools::displayError('minute(s)');
							$login_error = 4;
							
 						}
						else
						{	
 							$email = Db::getInstance()->getValue('SELECT `email` FROM '._DB_PREFIX_.'customer c WHERE c.`secure_key` = \''.pSQL($customer->secure_key).'\' AND c.id_customer = '.(int)$customer->id);
 							if ($email)
							{
							
								if (Mail::Send((int)$this->context->cookie->id_lang, 'password_query', Mail::l('Password Recovery', (int)$this->context->cookie->id_lang), 
									array('{email}' => $customer->email, 
										  '{lastname}' => $customer->lastname, 
										  '{firstname}' => $customer->firstname,
										  '{url}' => self::$link->getPageLink('password.php', true).'?token='.$customer->secure_key.'&id_customer='.(int)$customer->id),
									$customer->email, 
									$customer->firstname.' '.$customer->lastname))
										$login_error = 5;
										//$this->context->smarty->assign(array('confirmation' => 2, 'email' => $customer->email));
									else
										$login_error=6;
										//$this->errors[] = Tools::displayError('Error occurred when sending the e-mail.');
							}
 						}
 					}
				}
				echo $login_error;
			}
		}
 	}

	public function displayHeader($display = true) { }

	public function displayFooter($display = true) { }

	public function displayContent() {
	    if($_POST['email'] != "" && Tools::getValue('ajax') == 'true'){
	        return false;
	    }
		parent::displayContent();
		$this->context->smarty->display('dash/dash-login.tpl');	
 	}
}