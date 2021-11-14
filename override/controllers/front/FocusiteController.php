<?php
class FocusiteControllerCore extends DashController
{
	public $php_self = 'focusite.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/focusite.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>