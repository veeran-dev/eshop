<?php
class BusinessViewControllerCore extends DashController
{
	public $php_self = 'business.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/business.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>