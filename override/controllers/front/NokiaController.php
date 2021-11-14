<?php
class NokiaControllerCore extends DashController
{
	public $php_self = 'nokia.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/nokia.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>