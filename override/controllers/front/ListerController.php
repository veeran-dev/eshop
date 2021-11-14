<?php
class ListerControllerCore extends DashController
{
	public $php_self = 'lister.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/lister.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>