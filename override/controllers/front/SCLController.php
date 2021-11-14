<?php
class SCLControllerCore extends DashController
{
	public $php_self = 'scl.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/scl.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>