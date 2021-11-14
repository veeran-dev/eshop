<?php
class PaypalControllerCore extends DashController
{
	public $php_self = 'paypal.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/paypal.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>