<?php
class DashIdentityControllerCore extends DashController
{
public function ajaxReturn()
{	
		/*$address_id = $_POST['address_id'];
		$firstname = $_POST['firstname'];
		$company = $_POST['company'];
		$address1 = $_POST['address1'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$postcode = $_POST['postcode'];
		$mobile = $_POST['mobile'];
		$type = $_POST['type'];
		$occupations = $_POST['occupations'];
		$cus_id = $_POST['cus_id'];
		if($type==3)
		{
			$customer_id = $_POST['id_customer'];
		$customer = new Customer((int)($customer_id));
		$address = $customer->getAddresses(1);//id_lang=1
		echo Tools::jsonEncode($address);

		}*/
 		 $oldpassword = $_POST['old_passwd'];
		 $passwd = $_POST['passwd'];
		 $confirmPassword = $_POST['confirmPassword'];
		
		$customer = new Customer((int)(self::$cookie->id_customer));
		
 		$oldpassword = trim($oldpassword);
				$start_memory = memory_get_usage();
				if (empty($oldpassword) OR (Tools::encrypt($oldpassword) != self::$cookie->passwd))
				{
					$result=1;
					//$this->errors[] = Tools::displayError('Your password is incorrect.');
				}
				elseif ($passwd != $confirmPassword)
				{
					//$this->errors[] = Tools::displayError('Password and confirmation do not match');
					$result=2;
				}
				else
				{
					$prev_id_default_group = $customer->id_default_group;
					$this->errors = $customer->validateControler(true, true);
				}
 				if ($result=="")
				{
					$customer->id_default_group = (int)($prev_id_default_group);
					$customer->firstname = Tools::ucfirst(Tools::strtolower($customer->firstname));
					if (Tools::getValue('passwd'))
					{
						self::$cookie->passwd = $customer->passwd;
						self::$cookie->id_buyer = 3;
					}
					if ($customer->update())
					{
						self::$cookie->customer_lastname = $customer->lastname;
						self::$cookie->customer_firstname = $customer->firstname;
 						if (Mail::Send((int)self::$cookie->id_lang, 'password_elite', Mail::l('Your New Password', (int)self::$cookie->id_lang), 
						array('{email}' => $customer->email, 
							  '{lastname}' => $customer->lastname, 
							  '{firstname}' => $customer->firstname, 
							  '{passwd}' => $passwd), 
						$customer->email, 
						$customer->firstname.' '.$customer->lastname)) 
						//self::$smarty->assign('confirmation', 1);
						$result=3;
					}
					else
						//$this->errors[] = Tools::displayError('Cannot update information');
						$result=4;
				}
				echo $result;
					$logger = new FileLogger();
	$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
	$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	

	}
}