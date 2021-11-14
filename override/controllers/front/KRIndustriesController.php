<?php
class KRIndustriesControllerCore extends DashController
{
	public $php_self = 'krindustries.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/krindustries.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>