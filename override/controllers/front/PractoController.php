<?php
class PractoControllerCore extends DashController
{
	public $php_self = 'practo.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/practo.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>