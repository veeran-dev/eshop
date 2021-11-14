<?php
class BgrControllerCore extends DashController
{
	public $php_self = 'bgr.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/bgr.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>