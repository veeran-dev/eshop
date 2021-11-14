<?php
class RRDControllerCore extends DashController
{
	public $php_self = 'rrd.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/rrd.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>