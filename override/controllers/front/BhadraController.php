<?php
class BhadraControllerCore extends DashController
{
	public $php_self = 'bhadra.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/bhadra.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>