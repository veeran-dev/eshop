<?php
class UTCControllerCore extends FrontController
{
	public $php_self = 'utc.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/utc.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>