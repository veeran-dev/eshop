<?php
class SumHRControllerCore extends DashController
{
	public $php_self = 'sumhr';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('sumhr-landing.tpl');	
 	}
	public function displayHeader($display=true)
	{
	}
	
	public function displayFooter($display=true)
	{
	}
}
?>