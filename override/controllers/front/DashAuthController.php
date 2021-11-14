<?php
class DashAuthControllerCore extends DashController
{
	public $php_self = 'dash-login.php';
	public $dash = true;

 	public function postProcess()
	{
		parent::postProcess();
		
		if (Tools::isSubmit('SubmitDashLogin')) {
			
  			$passwd = trim($_POST['login_passwd']);
			$email = trim($_POST['login_email']);

 			if ($email != "") {
				$customer = new Customer();
				$authentication = $customer->getByEmail(trim($email), trim($passwd));
				$buyer = $customer->getBuyerId(trim($email));
				
  				if (!$authentication OR !$customer->id OR $buyer != 3 ) {
					self::$smarty->assign('login_error', 1);					
				}
				else {
					self::$cookie->id_compare = isset(self::$cookie->id_compare) ? self::$cookie->id_compare: CompareProduct::getIdCompareByIdCustomer($customer->id);
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
 					
					if($customer->status!=1)
					{
						$logger = new FileLogger();
						$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
						$logger->logInfo("-------------------------------------------");
						$logger->logInfo("");
						$logger->logInfo("Customer Logged In. IP Address: ".$_SERVER['REMOTE_ADDR']);
							Tools::redirect('dash-index.php');
					}
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
							
								if (Mail::Send((int)self::$cookie->id_lang, 'password_query', Mail::l('Password Recovery', (int)self::$cookie->id_lang), 
									array('{email}' => $customer->email, 
										  '{lastname}' => $customer->lastname, 
										  '{firstname}' => $customer->firstname,
										  '{url}' => self::$link->getPageLink('password.php', true).'?token='.$customer->secure_key.'&id_customer='.(int)$customer->id),
									$customer->email, 
									$customer->firstname.' '.$customer->lastname))
										$login_error = 5;
										//self::$smarty->assign(array('confirmation' => 2, 'email' => $customer->email));
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

	public function displayHeader($display = true)
	{	
	}

	public function displayFooter($display = true)
	{
	
	}

	public function displayContent()
	{
		if (Tools::getValue('ajax') != 'true')
		{
			parent::displayContent();
			self::$smarty->display('dash/dash-login.tpl');	
		}
 	}
}


?>