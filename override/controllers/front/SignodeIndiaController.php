<?php
class SignodeIndiaControllerCore extends DashController
{
	public $php_self = 'signodeindia.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/signodeindia.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>