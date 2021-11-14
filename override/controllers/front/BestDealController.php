<?php
class BestDealControllerCore extends DashController
{
	public $php_self = 'bestdeal.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/bestdeal.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>