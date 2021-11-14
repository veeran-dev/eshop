<?php
class SigmaelectricControllerCore extends DashController
{
	public $php_self = 'sigmaelectric.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/sigmaelectric.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>