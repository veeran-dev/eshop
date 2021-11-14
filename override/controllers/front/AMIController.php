<?php
class AMIControllerCore extends DashController
{
	public $php_self = 'amiindia.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/amiindia.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>