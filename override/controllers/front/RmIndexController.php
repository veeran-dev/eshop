<?php
class RmIndexControllerCore extends BackController
{
	public $php_self = 'rm-index';
 	public $RM_auth = true;
	
 	public function displayContent()
	{	
 		$employee =  new Employee(self::$cookie->id_employee);
		if(!$employee->canLogin(Employee::FLAG_RELATIONSHIP_MANAGER) || self::$cookie->logged_as != 'rm') {
			$employee->logout();
			Tools::redirect('rm-login.php');
		}
 		else {
 			parent::displayContent();
			self::$smarty->display('rm/rm-index.tpl');	
 		}
  	}
}