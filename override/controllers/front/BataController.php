<?php
class BataControllerCore extends DashController
{
	public $php_self = 'bata.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/bata.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>