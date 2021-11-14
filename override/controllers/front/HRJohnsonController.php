<?php
class HRJohnsonControllerCore extends DashController
{
	public $php_self = 'hrjohnson.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/hrjohnson.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>