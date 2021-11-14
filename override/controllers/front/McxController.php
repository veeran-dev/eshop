<?php
class McxControllerCore extends DashController
{
	public $php_self = 'mcx.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/mcx.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>