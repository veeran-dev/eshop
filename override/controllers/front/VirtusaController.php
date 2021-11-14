<?php
class VirtusaControllerCore extends DashController
{
	public $php_self = 'virtusa.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/virtusa.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>