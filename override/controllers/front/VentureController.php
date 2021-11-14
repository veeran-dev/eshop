<?php
class VentureControllerCore extends DashController
{
	public $php_self = 'venture.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/venture.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>