<?php
class UrbanladderControllerCore extends DashController
{
	public $php_self = 'urbanladder.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/urbanladder.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>