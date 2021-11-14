<?php
class AjubaControllerCore extends DashController
{
	public $php_self = 'ajuba.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/ajuba.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>