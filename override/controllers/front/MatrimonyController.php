<?php
class MatrimonyControllerCore extends DashController
{
	public $php_self = 'matrimony.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/matrimony.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>