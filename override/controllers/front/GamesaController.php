<?php
class GamesaControllerCore extends DashController
{
	public $php_self = 'gamesa.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/gamesa.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>