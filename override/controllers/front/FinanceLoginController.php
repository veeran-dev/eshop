<?php
class FinanceLoginControllerCore extends BackController
{
	public $php_self = 'finance-login';
	
 	public function postProcess()
	{
  		parent::postProcess();

  		if(self::$cookie->isLoggedBack()) {
			$employeeObj = new Employee(self::$cookie->id_employee);
			if($employeeObj->canLogin(Employee::FLAG_FINANCE_TEAM) && self::$cookie->logged_as == 'finance') {
				Tools::redirectAdmin('index.php?controller=finance-index');
			}
		}

		if (Tools::isSubmit('SubmitFinanceLogin'))
		{
  			$passwd = trim($_POST['fianance_passwd']);
			$email = trim($_POST['finance_email']);

  			if ($email != "") {

				$employee = new Employee();
				$employee_detail = $employee->getByemail($email, $passwd);
				
				if(isset($employee->id))
				{
					if(!$employee->canLogin(Employee::FLAG_FINANCE_TEAM)) {
						self::$smarty->assign('login_error', 2);
					}
					else if(self::$cookie->logged_as == 'rm' || self::$cookie->logged_as == 'scn' || self::$cookie->logged_as == 'admin') {
						self::$smarty->assign('login_error', 3);
					}
					else
					{
						self::$cookie->id_employee = $employee->id;
						self::$cookie->email = $employee->email;
						self::$cookie->profile = Employee::FLAG_FINANCE_TEAM;
						self::$cookie->passwd = $employee->passwd;
						self::$cookie->firstname = $employee->firstname;
						self::$cookie->lastname = $employee->lastname;
						self::$cookie->logged_as = 'finance';
						self::$cookie->remote_addr = ip2long(Tools::getRemoteAddr());
						self::$cookie->last_activity = time();
						self::$cookie->write();
						Tools::redirectAdmin('index.php?controller=finance-index');
					}
				}
				else
				{
					self::$smarty->assign('login_error', 1);
				}
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
		/*if (Tools::getValue('ajax') != 'true')
		{*/
			parent::displayContent();
			self::$smarty->display('finance/finance-login.tpl');	
		/*}*/
 	}
}


?>