<?php
class NeotericControllerCore extends DashController
{
	public $php_self = 'neoteric.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/neoteric.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>