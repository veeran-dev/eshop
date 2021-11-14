<?php
class AirBusControllerCore extends DashController
{
	public $php_self = 'airBus.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/airBus.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>