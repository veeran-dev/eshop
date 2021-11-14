<?php
class ChargebeeControllerCore extends DashController
{
	public $php_self = 'chargebee.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/chargebee.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>