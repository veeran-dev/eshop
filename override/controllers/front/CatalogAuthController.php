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
class CatalogAuthControllerCore extends CatalogController
{
	public $php_self = 'catalog-auth.php';
	
	//public $catalog_auth = true;

 	public function postProcess()
	{
		parent::postProcess();

		if(self::$cookie->id_employee)
			$employee_role = Vendor::getEmployeeRole((int)(self::$cookie->id_employee));

		if(self::$cookie->isLoggedBackCatalog(self::$cookie->id_poc) && (self::$cookie->id_poc != "" || !empty($employee_role))) {
			Tools::redirectAdmin('catalog.php');
		}

		if (Tools::isSubmit('SubmitCatalogLogin'))
		{
  			$passwd = trim($_POST['catalog_passwd']);
			$email = trim($_POST['catalog_email']);

 			if ($email != "")		
			{
				$vendor = new Vendor();
				$employee = new Employee();

				$vendor = $vendor->getByemail($email, $passwd);
				$employee = $employee->getByemail($email, $passwd, true);
				
    			if($vendor->id != "")
    			{
	   					self::$cookie->id_poc = $vendor->id;
						self::$cookie->email = $vendor->email;
						self::$cookie->passwd = $vendor->passwd;
						self::$cookie->firstname = $vendor->firstname;
						self::$cookie->remote_addr = ip2long(Tools::getRemoteAddr());	
	  					self::$cookie->write(); 
						Tools::redirectAdmin('catalog.php');	
				}
				else if($employee->id != ""){
						
						$employee_role = Vendor::getEmployeeRole((int)($employee->id));

						if(!empty($employee_role))
						{
		   					self::$cookie->id_employee = $employee->id;
							self::$cookie->email = $employee->email;
							self::$cookie->profile = $employee->id_profile;
							self::$cookie->passwd = $employee->passwd;
							self::$cookie->firstname = $employee->firstname;
							self::$cookie->lastname = $employee->lastname;
							self::$cookie->id_role = $employee_role[0]['id_role'];
							self::$cookie->remote_addr = ip2long(Tools::getRemoteAddr());	
		  					self::$cookie->write();
							Tools::redirectAdmin('catalog.php');
						}
						else
							self::$smarty->assign('login_error', 7);
				}
				else{
	 					self::$smarty->assign('login_error', 1);
				}
			}
		}
		else
		{
			if (Tools::getValue('ajax') == 'true')
			{
				if (!($email = Tools::getValue('email')) OR !Validate::isEmail($email))
 					$login_error = 2;
				else
				{
					$vendor = new Vendor();
					$vendor->getByemail($email);

					if (!Validate::isLoadedObject($vendor))
 						$login_error = 3;
					else
					{
						if ((strtotime($vendor->last_passwd_gen.'+'.(int)($min_time = Configuration::get('PS_PASSWD_TIME_FRONT')).' minutes') - time()) > 0)
							$login_error = 4;
						else
						{	
 							$email = Db::getInstance()->getValue('SELECT `email` FROM '._DB_PREFIX_.'vendor_poc c WHERE c.id_poc = '.(int)$vendor->id);
 							if ($email)
							{
								Db::getInstance()->ExecuteS('UPDATE `'._DB_PREFIX_.'vendor_poc` vpc SET vpc.`passwd` = "'.Tools::encrypt($password = Tools::passwdGen((int)MIN_PASSWD_LENGTH)).'"
															WHERE vpc.`email` = '.$email.'');

								if (Mail::Send((int)self::$cookie->id_lang, 'password_query_vendor', Mail::l('Password Recovery', (int)self::$cookie->id_lang), 
									array('{email}' => $vendor->email,  
										  '{firstname}' => $vendor->firstname,
										  '{url}' => self::$link->getPageLink('password.php', true)),
									$vendor->email, 
									$vendor->firstname))
										$login_error = 5;
									else
										$login_error=6;
							}
 						}
 					}
				}
				echo $login_error;
			}
		}
	}

	public function displayHeader($display = true) {}

	public function displayFooter($display = true) {}

	public function displayContent()
	{
		parent::displayContent();
		self::$smarty->display('catalog/views/catalog-login.tpl');	
 	}
}