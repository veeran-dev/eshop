<?php
class MicrochipControllerCore extends DashController
{
	public $php_self = 'microchip.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/microchip.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>