<?php
class GravitasControllerCore extends DashController
{
	public $php_self = 'gravitas.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/gravitas.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>