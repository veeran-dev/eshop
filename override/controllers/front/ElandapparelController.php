<?php
class ElandapparelControllerCore extends DashController
{
	public $php_self = 'elandapparel.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/elandapparel.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>