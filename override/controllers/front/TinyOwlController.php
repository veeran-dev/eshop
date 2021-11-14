<?php
class TinyOwlControllerCore extends DashController
{
	public $php_self = 'tinyowl.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/tinyowl.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>