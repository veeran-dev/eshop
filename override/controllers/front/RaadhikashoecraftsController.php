<?php
class RaadhikashoecraftsControllerCore extends DashController
{
	public $php_self = 'raadhikashoecrafts.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/raadhikashoecrafts.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>