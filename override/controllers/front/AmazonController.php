<?php
class AmazonControllerCore extends DashController
{
	public $php_self = 'amazon.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/amazon.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>