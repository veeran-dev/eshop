<?php
class GmpControllerCore extends DashController
{
	public $php_self = 'gmp.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/gmp.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>