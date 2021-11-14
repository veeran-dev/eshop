<?php
class ImpigertechControllerCore extends DashController
{
	public $php_self = 'impigertech.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/impigertech.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>