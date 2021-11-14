<?php
class GEPControllerCore extends DashController
{
	public $php_self = 'gep.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/gep.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>