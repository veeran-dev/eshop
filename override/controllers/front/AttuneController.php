<?php
class AttuneControllerCore extends DashController
{
	public $php_self = 'attune.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/attune.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>