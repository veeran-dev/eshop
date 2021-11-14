<?php
class TimesControllerCore extends DashController
{
	public $php_self = 'times.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/times.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>