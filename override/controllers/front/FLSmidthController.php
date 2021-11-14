<?php
class FLSmidthControllerCore extends DashController
{
	public $php_self = 'flsmidth.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/flsmidth.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>