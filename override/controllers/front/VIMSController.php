<?php
class VIMSControllerCore extends DashController
{
	public $php_self = 'vims.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/vims.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>