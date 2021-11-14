<?php
class DrIndexControllerCore extends BackController
{
	public $php_self = 'dr-index.php';
 	public $scn_auth = true;
	
	/*public function Process()
	{
		$logger = new FileLogger();
		$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
		$logger->logError(self::$cookie->id_employee."scnindcex");

		if (!self::$cookie->id_employee )
		{
			$logger->logError($cookie->id_employee."---scnindcex");
			Tools::redirect('scn-login.php');
		}
	}*/
	public function displayContent()
	{	
		$employee =  new Employee(self::$cookie->id_employee);
		if($employee->id_profile !=10)
		{
			Tools::redirect('scn-login.php');
		}
		else
		{
			parent::displayContent();
			self::$smarty->display('scn/dr-index.tpl');	
		}
 	}
}
 
?>