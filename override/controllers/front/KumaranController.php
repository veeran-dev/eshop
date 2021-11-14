<?php
class KumaranControllerCore extends DashController
{
	public $php_self = 'kumaran.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/kumaran.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>