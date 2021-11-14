<?php
class LatentViewControllerCore extends DashController
{
	public $php_self = 'lva.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/lva.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>