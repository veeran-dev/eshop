<?php
class HSBCControllerCore extends DashController
{
	public $php_self = 'hsbc.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/hsbc.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>