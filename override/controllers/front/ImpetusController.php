<?php
class ImpetusControllerCore extends DashController
{
	public $php_self = 'impetus.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/impetus.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>