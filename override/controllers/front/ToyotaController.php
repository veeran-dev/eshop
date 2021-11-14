<?php
class ToyotaControllerCore extends DashController
{
	public $php_self = 'toyota.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/toyota.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>