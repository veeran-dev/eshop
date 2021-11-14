<?php
class ScnIndexControllerCore extends BackController
{
	public $php_self = 'scn-index.php';
 	public $scn_auth = true;

	public function displayContent()
	{	
 		$employee =  new Employee(self::$cookie->id_employee);
		if(!$employee->canLogin(Employee::FLAG_SUPPLY_CHAIN) || self::$cookie->logged_as != 'scn'){
			$employee->logout();
			Tools::redirect('scn-login.php');
		}
		else{
			parent::displayContent();
			self::$smarty->display('scn/scn-index.tpl');	
		}
	}
}
 
?>