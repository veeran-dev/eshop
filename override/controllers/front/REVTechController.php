<?php
class REVTechControllerCore extends DashController
{
	public $php_self = 'revtech.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/revtech.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>