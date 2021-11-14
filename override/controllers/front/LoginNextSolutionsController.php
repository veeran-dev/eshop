<?php
class LoginNextSolutionsControllerCore extends DashController
{
	public $php_self = 'login-next-solutions.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/login-next-solution.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>