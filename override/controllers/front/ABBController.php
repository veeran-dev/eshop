<?php
class ABBControllerCore extends DashController
{
	public $php_self = 'abb.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/abb.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>