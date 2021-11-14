<?php
class AllsecControllerCore extends DashController
{
	public $php_self = 'allsec.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/allsec.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>