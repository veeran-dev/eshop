<?php
class ScnLoginControllerCore extends BackController
{
	public $php_self = 'scn-login';

 	public function postProcess()
	{
		parent::postProcess();

		if(self::$cookie->isLoggedBack()) {
			$employeeObj = new Employee(self::$cookie->id_employee);
			if($employeeObj->canLogin(Employee::FLAG_SUPPLY_CHAIN) && self::$cookie->logged_as == 'scn') {
				Tools::redirectAdmin('index.php?controller=scn-index');
			}
		}

		if (Tools::isSubmit('SubmitScnLogin'))
		{
  			$passwd = trim($_POST['scn_passwd']);
			$email = trim($_POST['scn_email']);
			
 			if ($email != "")
			{
				$employee = new Employee();
				$employee_detail = $employee->getByemail($email, $passwd);

				if(isset($employee->id))
				{																									
					if(!$employee->canLogin(Employee::FLAG_SUPPLY_CHAIN)) {
						self::$smarty->assign('login_error', 2);
					}
					else if(self::$cookie->logged_as == 'rm' || self::$cookie->logged_as == 'finance' || self::$cookie->logged_as == 'admin') {
						self::$smarty->assign('login_error', 3);
					}
					else {
						self::$cookie->id_employee = $employee->id;
						self::$cookie->email = $employee->email;
						self::$cookie->profile = Employee::FLAG_SUPPLY_CHAIN;
						self::$cookie->passwd = $employee->passwd;
						self::$cookie->firstname = $employee->firstname;
						self::$cookie->lastname = $employee->lastname;
						self::$cookie->logged_as = 'scn';
						self::$cookie->remote_addr = ip2long(Tools::getRemoteAddr());	
						self::$cookie->last_activity = time();
						self::$cookie->write();
						Tools::redirectAdmin('index.php?controller=scn-index');				
					}
				}
				else
				{
					self::$smarty->assign('login_error', 1);
				}
			}	
		}
 	}

	public function displayHeader($display = true) {}

	public function displayFooter($display = true) {}

	public function displayContent()
	{
		/*if (Tools::getValue('ajax') != 'true')
		{*/
			parent::displayContent();
			self::$smarty->display('scn/scn-login.tpl');	
		/*}*/
 	}
}